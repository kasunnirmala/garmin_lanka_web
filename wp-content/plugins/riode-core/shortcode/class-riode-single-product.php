<?php
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

class Riode_Single_Product extends Container implements Module {

	use EventsFilters;
	use WpFiltersActions;
	/**
	 * attr
	 *
	 * @since 1.0.0
	 * @var int
	 */
	public $settings;

	protected static $instance;
	/**
	 * Riode_Single_Product constructor.
	 */
	public function __construct() {

	}

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * @param $variables
	 * @param $payload
	 *
	 * @return array
	 */
	protected function getEndNumber( $variables, $payload ) {

		global $product;
		$end_number = array(
			'sale'  => 0,
			'stock' => 0,
		);
		if ( isset( $product ) ) {
			$end_number['sale']  = $product->get_total_sales();
			$end_number['stock'] = $product->get_stock_quantity();
		}
		$variables[] = array(
			'key'   => 'riodeEndNumber',
			'value' => $end_number,
		);
		return $variables;
	}

	/**
	 * Add Product Title
	 *
	 *
	 * @return mixed|string
	 */
	protected function addTitle() {
		add_shortcode(
			'riode_single_product_title',
			function () {
				global $product;
				ob_start();
				if ( $product && is_product() && $product->get_title() ) {
					echo esc_html( $product->get_title() );
				} else {
					esc_html_e( 'Riode Single Product Name', 'riode-core' );
				}
				return ob_get_clean();
			}
		);
	}
	/**
	 * Add Product Content
	 *
	 *
	 * @return mixed|string
	 */
	protected function addContent() {
		add_shortcode(
			'riode_single_product_content',
			function () {
				global $product;
				ob_start();
				if ( $product && is_product() && $product->get_short_description() ) {
					echo esc_html( $product->get_short_description() );
				}
				return ob_get_clean();
			}
		);
	}
	/**
	 * Add Product Nav
	 *
	 *
	 * @return mixed|string
	 */
	protected function addNav() {
		add_shortcode(
			'riode_single_product_nav',
			function ( $atts, $content = null ) {
				ob_start();
				extract( // @codingStandardsIgnoreLine
					shortcode_atts(
						array(
							'sp_align'     => '',
							'sp_prev_icon' => '',
							'sp_next_icon' => '',
						),
						$atts
					)
				);
				$this->settings = $atts;
				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {

					add_filter( 'riode_check_single_next_prev_nav', '__return_true' );
					add_filter( 'riode_single_product_nav_prev_icon', array( $this, 'get_prev_icon' ) );
					add_filter( 'riode_single_product_nav_next_icon', array( $this, 'get_next_icon' ) );

					echo '<div class="product-navigation">' . riode_single_product_navigation() . '</div>';

					remove_filter( 'riode_check_single_next_prev_nav', '__return_true' );
					remove_filter( 'riode_single_product_nav_prev_icon', array( $this, 'get_prev_icon' ) );
					remove_filter( 'riode_single_product_nav_next_icon', array( $this, 'get_next_icon' ) );

					do_action( 'riode_single_product_builder_unset_product' );
				}
				return ob_get_clean();
			}
		);
	}
	/**
	 * Add Product Image
	 *
	 *
	 * @return mixed|string
	 */
	protected function addImage() {
		add_shortcode(
			'riode_single_product_image',
			function ( $atts, $content = null ) {
				ob_start();

				extract( // @codingStandardsIgnoreLine
					shortcode_atts(
						array(
							'sp_type' => '',
						),
						$atts
					)
				);
				$this->settings = $atts;

				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
					add_filter( 'riode_single_product_layout', array( $this, 'get_gallery_type' ), 99 );
					add_filter( 'riode_single_product_gallery_main_classes', array( $this, 'extend_gallery_class' ), 20 );
					if ( 'gallery' == $sp_type ) {
						add_filter( 'riode_single_product_gallery_type_class', array( $this, 'extend_gallery_type_class' ) );
						add_filter( 'riode_single_product_gallery_type_attr', array( $this, 'extend_gallery_type_attr' ) );
					}
					woocommerce_show_product_images();

					remove_filter( 'riode_single_product_layout', array( $this, 'get_gallery_type' ), 99 );
					remove_filter( 'riode_single_product_gallery_main_classes', array( $this, 'extend_gallery_class' ), 20 );
					if ( 'gallery' == $sp_type ) {
						remove_filter( 'riode_single_product_gallery_type_class', array( $this, 'extend_gallery_type_class' ) );
						remove_filter( 'riode_single_product_gallery_type_attr', array( $this, 'extend_gallery_type_attr' ) );
					}

					do_action( 'riode_single_product_builder_unset_product' );
				}

				return ob_get_clean();
			}
		);
	}

	/**
	 * Add Product Meta
	 *
	 *
	 * @return mixed|string
	 */
	protected function addMeta() {
		add_shortcode(
			'riode_single_product_meta',
			function () {
				ob_start();
				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
					woocommerce_template_single_meta();
					do_action( 'riode_single_product_builder_unset_product' );
				}
				return ob_get_clean();
			}
		);
	}

	/**
	 * Add Product Share
	 *
	 *
	 * @return mixed|string
	 */
	protected function addShare() {
		add_shortcode(
			'riode_single_product_share',
			function () {
				ob_start();
				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
					riode_print_share();
					do_action( 'riode_single_product_builder_unset_product' );
				}
				return ob_get_clean();
			}
		);
	}

	/**
	 * Add Product Cart
	 *
	 *
	 * @return mixed|string
	 */
	protected function addCart() {
		add_shortcode(
			'riode_single_product_cart',
			function ( $atts ) {
				extract( // @codingStandardsIgnoreLine
					shortcode_atts(
						array(
							'sp_sticky' => '',
						),
						$atts
					)
				);
				ob_start();
				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
					if ( 'yes' == $sp_sticky ) {
						add_filter( 'riode_single_product_sticky_cart_enabled', '__return_true' );
					}
					woocommerce_template_single_add_to_cart();
					if ( 'yes' == $sp_sticky ) {
						remove_filter( 'riode_single_product_sticky_cart_enabled', '__return_true' );
					}
					do_action( 'riode_single_product_builder_unset_product' );
				}
				return ob_get_clean();
			}
		);
	}

	/**
	 * Add Product Compare
	 *
	 * @return mixed|string
	 */
	protected function addCompare() {
		add_shortcode(
			'riode_single_product_compare',
			function() {
				ob_start();

				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
					riode_single_product_compare();
					do_action( 'riode_single_product_builder_unset_product' );
				}

				return ob_get_clean();
			}
		);
	}

	/**
	 * Add Product Wishlist
	 *
	 * @return mixed|string
	 */
	protected function addWishlist() {
		add_shortcode(
			'riode_single_product_wishlist',
			function() {
				ob_start();

				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
					echo do_shortcode( '[yith_wcwl_add_to_wishlist container_classes="btn-product-icon"]' );
					do_action( 'riode_single_product_builder_unset_product' );
				}

				return ob_get_clean();
			}
		);
	}

	/**
	 * Add Product Price
	 *
	 *
	 * @return mixed|string
	 */
	protected function addPrice() {
		add_shortcode(
			'riode_single_product_price',
			function () {
				ob_start();
				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
					woocommerce_template_single_price();
					do_action( 'riode_single_product_builder_unset_product' );
				}
				return ob_get_clean();
			}
		);
	}

	/**
	 * Add Product Rating
	 *
	 *
	 * @return mixed|string
	 */
	protected function addRating() {
		add_shortcode(
			'riode_single_product_rating',
			function ( $atts, $content = null ) {
				ob_start();

				extract( // @codingStandardsIgnoreLine
					shortcode_atts(
						array(
							'sp_type'    => '',
							'sp_reviews' => '',
						),
						$atts
					)
				);
				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
					if ( '' == $sp_reviews ) {
						add_filter( 'riode_single_product_show_review', '__return_false' );
					}

					woocommerce_template_single_rating();

					if ( '' == $sp_reviews ) {
						remove_filter( 'riode_single_product_show_review', '__return_false' );
					}

					do_action( 'riode_single_product_builder_unset_product' );
				}

				return ob_get_clean();
			}
		);
	}

	/**
	 * Add Product Flash Sale
	 *
	 *
	 * @return mixed|string
	 */
	protected function addSale() {
		add_shortcode(
			'riode_single_product_sale',
			function ( $atts, $content = null ) {
				ob_start();

				extract( // @codingStandardsIgnoreLine
					shortcode_atts(
						array(
							'sp_label'      => '',
							'sp_ends_label' => '',
							'icon_html'     => '',
						),
						$atts
					)
				);
				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
					global $product;

					if ( function_exists( 'riode_single_product_sale_countdown' ) ) {
						riode_single_product_sale_countdown( $sp_label, $sp_ends_label, $icon_html );
					}
					do_action( 'riode_single_product_builder_unset_product' );
				}

				return ob_get_clean();
			}
		);
	}

	/**
	 * Add Product DataTab
	 *
	 *
	 * @return mixed|string
	 */
	protected function addDataTab() {
		add_shortcode(
			'riode_single_product_tab',
			function ( $atts, $content = null ) {
				extract( // @codingStandardsIgnoreLine
					shortcode_atts(
						array(
							'sp_type' => '',
						),
						$atts
					)
				);
				$this->settings = $atts;
				ob_start();
				if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {

					add_filter( 'riode_single_product_data_tab_type', array( $this, 'get_tab_type' ) );

					woocommerce_output_product_data_tabs();

					remove_filter( 'riode_single_product_data_tab_type', array( $this, 'get_tab_type' ) );

					do_action( 'riode_single_product_builder_unset_product' );
				}
				return ob_get_clean();
			}
		);
	}

	public function get_tab_type( $type ) {
		$sp_type = '';
		if ( isset( $this->settings['sp_type'] ) ) {
			$sp_type = $this->settings['sp_type'];
		}
		if ( 'accordion' == $sp_type ) {
			$type = $sp_type;
		}

		return $type;
	}

	public function extend_gallery_class( $classes ) {
		$settings              = $this->settings;
		$single_product_layout = isset( $settings['sp_type'] ) ? $settings['sp_type'] : '';
		$classes[]             = 'pg-custom';

		if ( 'grid' == $single_product_layout || 'masonry' == $single_product_layout ) {
			$classes[] = 'grid-gallery';

			foreach ( $classes as $i => $class ) {
				if ( 'cols-sm-2' == $class ) {
					array_splice( $classes, $i, 1 );
				}
			}
			$classes[]        = riode_get_col_class( riode_elementor_grid_col_cnt( $settings ) );
			$grid_space_class = riode_elementor_grid_space_class( $settings );
			if ( $grid_space_class ) {
				$classes[] = $grid_space_class;
			}
		}

		return $classes;
	}

	public function extend_gallery_type_class( $class ) {
		$settings         = $this->settings;
		$class            = ' ' . riode_get_col_class( riode_elementor_grid_col_cnt( $settings ) );
		$grid_space_class = riode_elementor_grid_space_class( $settings );
		if ( $grid_space_class ) {
			$class .= ' ' . $grid_space_class;
		}
		return $class;
	}

	public function extend_gallery_type_attr( $attr ) {
		$settings                     = $this->settings;
		$settings['show_nav']         = 'yes';
		$settings['show_dots_tablet'] = '';
		$attr                        .= ' data-owl-options=' . esc_attr(
			json_encode(
				riode_get_slider_attrs( $settings, riode_elementor_grid_col_cnt( $settings ) )
			)
		);
		return $attr;
	}

	public function get_gallery_type() {
		return isset( $this->settings['sp_type'] ) ? $this->settings['sp_type'] : '';
	}

	public function get_prev_icon() {
		return isset( $this->settings['sp_prev_icon'] ) ? $this->settings['sp_prev_icon'] : 'd-icon-arrow-left';
	}

	public function get_next_icon() {
		return isset( $this->settings['sp_next_icon'] ) ? $this->settings['sp_next_icon'] : 'd-icon-arrow-right';
	}

}

Riode_Single_Product::get_instance();
