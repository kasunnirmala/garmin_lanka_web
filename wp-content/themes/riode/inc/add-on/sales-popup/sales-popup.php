<?php
/**
 * Riode_WC_Product_Ordering class
 *
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'WC_Shortcode_Products' ) && ! class_exists( 'Riode_Sales_Popup_Products' ) ) {

	class Riode_Sales_Popup_Products extends WC_Shortcode_Products {

		private static $instance = null;

		public static function get_instance( $attributes = array(), $type = 'products' ) {
			if ( ! self::$instance ) {
				self::$instance = new self( $attributes, $type );
			}
			return self::$instance;
		}

		public function __construct( $attributes = array(), $type = 'products' ) {
			parent::__construct( $attributes, $type );
		}

		public function get_products() {
			$products = $this->get_query_results();
			$result   = array();
			if ( $products && $products->ids ) {
				global $wpdb;
				foreach ( $products->ids as $product_id ) {
					$post    = get_post( $product_id );
					$product = wc_get_product( $post );

					if ( get_post_meta( $product_id, 'riode_virtual_buy_time_text', true ) ) {
						$date = esc_html( get_post_meta( $product_id, 'riode_virtual_buy_time_text', true ) );
					} else {
						// get the last bought time
						$date = $wpdb->get_var( $wpdb->prepare( 'select date_created from ' . $wpdb->prefix . 'wc_order_product_lookup where product_id=%d order by date_created DESC', $product_id ) );
						if ( $date ) {
							$date = riode_get_period_from( strtotime( $date ) );
						} elseif ( get_post_meta( $product_id, 'riode_virtual_buy_time', true ) ) {
							$date = riode_get_period_from( strtotime( get_post_meta( $product_id, 'riode_virtual_buy_time', true ) ) );
						} else {
							$date = apply_filters( 'riode_sales_popup_nobuy_time', esc_html__( 'A While Ago', 'riode' ) );
						}
					}

					$image_src = wp_get_attachment_image_src( $product->get_image_id(), 'riode-product-thumbnail' );
					if ( $image_src ) {
						$image_src = $image_src[0];
					} else {
						$image_src = wc_placeholder_img_src();
					}

					$result[] = array(
						'title'  => esc_html( $product->get_title() ),
						'link'   => esc_url( $product->get_permalink() ),
						'image'  => esc_js( $image_src ),
						'price'  => $product->get_price_html(),
						'rating' => (float) $product->get_average_rating(),
						'date'   => $date,
					);
				}
			}
			return $result;
		}
	}
}

if ( wp_doing_ajax() ) {
	add_action( 'wp_ajax_riode_sales_popup_products', 'riode_sales_popup_products' );
	add_action( 'wp_ajax_nopriv_riode_sales_popup_products', 'riode_sales_popup_products' );

	if ( ! function_exists( 'riode_sales_popup_products' ) ) {
		function riode_sales_popup_products() {
			check_ajax_referer( 'riode-nonce', 'nonce' );

			$atts = array(
				'limit' => (int) riode_get_option( 'sales_popup_count' ),
			);

			$type = 'products';

			switch ( riode_get_option( 'sales_popup' ) ) {
				case 'popular':
					$type = 'best_selling_products';
					break;
				case 'rating':
					$type = 'top_rated_products';
					break;
				case 'sale':
					$type = 'sale_products';
					break;
				case 'featured':
					$type = 'featured_products';
					break;
				case 'recent':
					$type            = 'recent_products';
					$atts['orderby'] = 'date';
					$atts['order']   = 'DESC';
					break;
				case 'category':
					$type                 = 'products';
					$atts['orderby']      = 'menu_order title';
					$atts['order']        = 'ASC';
					$atts['category']     = riode_get_option( 'sales_popup_category' );
					$atts['cat_operator'] = 'IN';
					break;
				case 'products':
					$type        = 'products';
					$atts['ids'] = riode_get_option( 'sales_popup_products' );
					break;
			}

			$products = Riode_Sales_Popup_Products::get_instance( $atts, $type );

			wp_send_json( $products->get_products() );
		}
	}
}


if ( ! function_exists( 'riode_sales_popup_data' ) ) {

	function riode_sales_popup_data() {

		return array(
			'title'    => esc_js( riode_get_option( 'sales_popup_title' ) ),
			'start'    => (int) riode_get_option( 'sales_popup_start_delay' ),
			'interval' => (int) riode_get_option( 'sales_popup_interval' ),
			'themeuri' => esc_url( get_parent_theme_file_uri() ),
		);
	}
}
