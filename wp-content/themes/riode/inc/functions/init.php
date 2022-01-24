<?php
/**
 * Riode Functions
 */

defined( 'ABSPATH' ) || die;

define( 'RIODE_FUNCTIONS_DIR', RIODE_INC . '/functions' );

/**
 * Riode WooCommerce Functions
 */

function riode_init_woocommerce_actions() {
	require_once RIODE_FUNCTIONS_DIR . '/woocommerce/woocommerce.php';
	require_once RIODE_FUNCTIONS_DIR . '/woocommerce/product-loop.php';
	require_once RIODE_FUNCTIONS_DIR . '/woocommerce/product-category.php';
	require_once RIODE_FUNCTIONS_DIR . '/woocommerce/product-archive.php';
	require_once RIODE_FUNCTIONS_DIR . '/woocommerce/product-single.php';
}

if ( class_exists( 'WooCommerce' ) ) {
	if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
		add_action( 'init', 'riode_init_woocommerce_actions', 8 );
	} else {
		riode_init_woocommerce_actions();
	}
}
