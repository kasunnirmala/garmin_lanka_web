<?php
/**
 * Riode_Single_Product_Builder class
 */
defined( 'ABSPATH' ) || die;

define( 'RIODE_SINGLE_PRODUCT_BUILDER', RIODE_CORE_TEMPLATE . '/single-product-builder' );

class Riode_Template_Single_Product_Builder {

	public $widgets = array(
		'counter',
		'cart_form',
		'compare',
		'data_tab',
		'excerpt',
		'flash_sale',
		'image',
		'linked_products',
		'meta',
		'navigation',
		'price',
		'rating',
		'share',
		'title',
		'wishlist',
	);

	protected $post;
	protected $product           = false;
	protected $is_product_layout = false;

	protected static $instance;

	public function __construct() {
		if ( isset( $_POST['action'] ) && 'riode_quickview' == $_POST['action'] ) {
			return;
		}

		// setup builder
		add_action( 'init', array( $this, 'find_variable_product_for_preview' ) );
		add_action( 'wp', array( $this, 'setup_product_layout' ), 99 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 30 );

		// add woocommerce class to body
		add_filter( 'body_class', array( $this, 'add_body_class' ), 5 );

		// setup global $product
		add_action( 'riode_before_template', array( $this, 'set_post_product' ) );
		add_filter( 'riode_single_product_builder_set_product', array( $this, 'set_post_product' ) );
		add_action( 'riode_single_product_builder_unset_product', array( $this, 'unset_post_product' ) );

		// Use elementor widgets for single product
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_category' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widgets' ) );

		if ( defined( 'WPB_VC_VERSION' ) ) {
			$this->register_wpb_elements();
		}
	}

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function find_variable_product_for_preview() {
		$elementor_preview = function_exists( 'riode_is_elementor_preview' ) && riode_is_elementor_preview();
		$wpb_preview       = function_exists( 'riode_is_wpb_preview' ) && riode_is_wpb_preview();
		$is_preview        = $elementor_preview || $wpb_preview;

		if ( ! $is_preview ) {
			return;
		}

		$posts = get_posts(
			array(
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'numberposts'         => 10,
				'ignore_sticky_posts' => true,
			)
		);

		if ( ! empty( $posts ) ) {

			// find variable product
			foreach ( $posts as $post ) {
				$this->post    = $post;
				$this->product = wc_get_product( $post );

				if ( 'variable' == $this->product->get_type() ) {
					break;
				}
			}

			// if no variable product exists, get any product
			if ( ! $this->product ) {
				$this->post    = $posts[0];
				$this->product = wc_get_product( $posts[0] );
			}
		}
	}

	public function setup_product_layout() {
		global $post;

		if ( ! empty( $post ) ) {
			if ( 'riode_template' != get_post_type() || 'product_layout' != get_post_meta( get_the_ID(), 'riode_template_type', true ) ) {
				$this->is_product_layout = false;
				$this->post              = null;
				$this->product           = null;
			}

			if (
				( 'riode_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, 'riode_template_type', true ) ) ||
				( defined( 'RIODE_VERSION' ) && is_product() )
			) {
				$this->is_product_layout = true;
			}
		}
	}

	public function get_template() {
		if ( ! $this->is_product_layout ) {
			return false;
		}

		global $post;
		if ( 'riode_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, 'riode_template_type', true ) ) {
			return $post->ID;
		} else {
			global $riode_layout;
			if ( isset( $riode_layout['content'] ) && isset( $riode_layout['content']['single_product_template'] ) ) {
				return $riode_layout['content']['single_product_template'];
			} else {
				return 'default';
			}
		}

		return false;
	}

	public function set_post_product() {
		if ( ! is_product() && $this->product ) {
			global $post, $product;
			$post    = $this->post;
			$product = $this->product;
			setup_postdata( $this->post );
			add_filter( 'riode_is_product', '__return_true', 23 );
			return true;
		}
		return $this->is_product_layout;
	}

	public function unset_post_product() {
		if ( ! is_product() && $this->product ) {
			remove_filter( 'riode_is_product', '__return_true', 23 );
			wp_reset_postdata();
		}
	}

	public function enqueue_scripts() {
		if ( $this->product ) {
			wp_enqueue_style( 'riode-theme-single-product' );
			wp_enqueue_script( 'wc-single-product' );
		}
	}

	public function add_body_class( $classes ) {
		global $post;
		if ( ! empty( $post ) && $this->is_product_layout ) {
			$classes[] = 'woocommerce';
		}
		return $classes;
	}

	public function register_elementor_category( $self ) {
		global $post;

		if ( $post && 'riode_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, 'riode_template_type', true ) ) {
			$self->add_category(
				'riode_single_product_widget',
				array(
					'title'  => esc_html__( 'Riode Single Product', 'riode-core' ),
					'active' => true,
				)
			);
		}
	}

	public function register_elementor_widgets( $self ) {
		global $post, $product;

		if ( ( $post && 'riode_template' == $post->post_type && 'product_layout' == get_post_meta( $post->ID, 'riode_template_type', true ) ) || (
			isset( $product ) ) ) {
			foreach ( $this->widgets as $widget ) {
				include_once RIODE_SINGLE_PRODUCT_BUILDER . '/elementor-widgets/' . str_replace( '_', '-', $widget ) . '.php';
				$class_name = 'Riode_Single_Product_' . ucwords( $widget, '_' ) . '_Elementor_Widget';
				$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
			}
		}
	}

	public function register_wpb_elements() {
		global $post, $product;

		$post_id   = 0;
		$post_type = '';

		if ( $post ) {
			$post_id   = $post->ID;
			$post_type = $post->post_type;
		} elseif ( riode_is_wpb_preview() ) {
			if ( vc_is_inline() ) {
				$post_id   = isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : $_REQUEST['vc_post_id'];
				$post_type = get_post_type( $post_id );
			} elseif ( isset( $_REQUEST['post'] ) ) {
				$post_id   = $_REQUEST['post'];
				$post_type = get_post_type( $post_id );
			}
		}
		if ( ( ( $post_id && ( 'riode_template' == $post_type && 'product_layout' == get_post_meta( $post_id, 'riode_template_type', true ) ) ) || isset( $product ) ) || ( wp_doing_ajax() && isset( $_REQUEST['action'] ) && 'vc_edit_form' == $_REQUEST['action'] ) ) {
		}

		$elements = array();

		foreach ( $this->widgets as $widget ) {
			$elements[] = 'sp_' . $widget;
		}

		Riode_WPB_Init::get_instance()->add_shortcodes( $elements, RIODE_SINGLE_PRODUCT_BUILDER . '/wpb-elements' );
	}
}

Riode_Template_Single_Product_Builder::get_instance();
