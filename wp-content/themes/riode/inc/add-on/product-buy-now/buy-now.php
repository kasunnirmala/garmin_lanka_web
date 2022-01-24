<?php

/**
 * Riode Product Buy Now class
 *
 * @version 1.4.0
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Riode_Product_Buy_Now' ) ) {

	/**
	 * Riode Product Buy Now Feature Class
	 */
	class Riode_Product_Buy_Now {
		/**
		 * Main Class construct
		 */
		public function __construct() {
			add_action( 'template_redirect', array( $this, 'init' ) );
			add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'redirect_checkout' ), 99 );
		}

		/**
		 * Init all actions
		 */
		public function init() {
			if ( ! riode_is_product() ) {
				return;
			}

			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'add_buy_now_btn' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
		}

		/**
		 * add_buy_now_btn
		 * adds buy now button after cart button
		 */
		public function add_buy_now_btn() {
			global $product;

			if ( 'external' == $product->get_type() || riode_doing_quickview() ) {
				return;
			}

			echo '<button class="product-buy-now alt button btn">' . esc_html__( 'Buy Now', 'riode' ) . '</button>';
		}

		/**
		 * enqueue_script
		 * loads script file related to this feature
		 */
		public function enqueue_script() {
			wp_enqueue_script( 'riode-product-buy-now', RIODE_ADDON_URI . '/product-buy-now/buy-now' . riode_get_js_extension(), array( 'riode-theme' ), RIODE_VERSION, true );
		}


		/**
		 * redirect_checkout
		 * redirects to checkout after click buy now button
		 */
		public function redirect_checkout( $url ) {

			if ( ! isset( $_REQUEST['buy_now'] ) || $_REQUEST['buy_now'] == false ) {
				return $url;
			}

			return wc_get_checkout_url();
		}
	}
}

new Riode_Product_Buy_Now;
