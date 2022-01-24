<?php
/**
 * Riode_Single_Product_Builder class
 */
defined( 'ABSPATH' ) || die;

define( 'RIODE_HEADER_BUILDER', RIODE_CORE_TEMPLATE . '/header-builder' );

class Riode_Template_Header_Builder {

	public $widgets = array(
		'account',
		'cart',
		'compare',
		'wishlist',
		'currency_switcher',
		'language_switcher',
		'mmenu_toggle',
		'search',
		'v_divider',
	);

	protected static $instance;

	public function __construct() {
		if ( isset( $_POST['action'] ) && 'riode_quickview' == $_POST['action'] ) {
			return;
		}

		// Use elementor widgets for header builder
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

	public function register_elementor_category( $self ) {
		global $post;

		$register = false;

		if ( is_admin() ) {
			if ( ! riode_is_elementor_preview() || ( $post && 'riode_template' == $post->post_type && 'header' == get_post_meta( $post->ID, 'riode_template_type', true ) ) ) {
				$register = true;
			}
		} elseif ( function_exists( 'riode_get_layout_value' ) ) {
			if ( riode_get_layout_value( 'header', 'id' ) && -1 != riode_get_layout_value( 'header', 'id' ) ) {
				$register = true;
			}
		}

		if ( $register ) {
			$self->add_category(
				'riode_header_widget',
				array(
					'title'  => esc_html__( 'Riode Header', 'riode-core' ),
					'active' => true,
				)
			);
		}
	}

	public function register_elementor_widgets( $self ) {
		global $post;

		$register = false;

		if ( is_admin() ) {
			if ( ! riode_is_elementor_preview() || ( $post && 'riode_template' == $post->post_type && 'header' == get_post_meta( $post->ID, 'riode_template_type', true ) ) ) {
				$register = true;
			}
		} elseif ( function_exists( 'riode_get_layout_value' ) ) {
			if ( riode_get_layout_value( 'header', 'id' ) && -1 != riode_get_layout_value( 'header', 'id' ) ) {
				$register = true;
			}
		}

		if ( $register ) {
			sort( $this->widgets );

			foreach ( $this->widgets as $widget ) {
				include_once RIODE_HEADER_BUILDER . '/elementor-widgets/' . str_replace( '_', '-', $widget ) . '.php';
				$class_name = 'Riode_Header_' . ucwords( $widget, '_' ) . '_Elementor_Widget';
				$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
			}
		}
	}

	public function register_wpb_elements() {
		global $post;

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
		if ( $post_id && 'riode_template' == $post_type && 'header' == get_post_meta( $post_id, 'riode_template_type', true ) || ( wp_doing_ajax() && isset( $_REQUEST['action'] ) && 'vc_edit_form' == $_REQUEST['action'] ) ) {
		}

		$elements = array();

		foreach ( $this->widgets as $widget ) {
			$elements[] = 'hb_' . $widget;
		}

		Riode_WPB_Init::get_instance()->add_shortcodes( $elements, RIODE_HEADER_BUILDER . '/wpb-elements' );
	}
}

Riode_Template_Header_Builder::get_instance();
