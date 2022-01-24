<?php

/**
 * WooCommerce
 */

if ( class_exists( 'WooCommerce' ) ) {
	Riode_Customizer::add_panel(
		'woocommerce',
		array(
			'title'    => esc_html__( 'WooCommerce', 'riode' ),
			'priority' => 10,
		)
	);

	include_once RIODE_OPTION . '/woocommerce/option-wc-store-notice.php';
	include_once RIODE_OPTION . '/woocommerce/option-wc-shop.php';
	include_once RIODE_OPTION . '/woocommerce/option-wc-single.php';
	include_once RIODE_OPTION . '/woocommerce/option-wc-product-images.php';
	include_once RIODE_OPTION . '/woocommerce/option-wc-checkout.php';

	include_once RIODE_OPTION . '/woocommerce/option-wc-product.php';
	include_once RIODE_OPTION . '/woocommerce/option-wc-category.php';
}
