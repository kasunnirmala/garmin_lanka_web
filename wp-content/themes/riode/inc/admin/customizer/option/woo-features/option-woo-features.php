<?php

/**
 * WooCommerce
 */

if ( class_exists( 'WooCommerce' ) ) {
	Riode_Customizer::add_panel(
		'woo_features',
		array(
			'title'    => esc_html__( 'Woo Features', 'riode' ),
			'priority' => 10,
		)
	);

	include_once RIODE_OPTION . '/woo-features/option-wf-alert-autoremove.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-attribute-guide.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-attribute-swatch.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-buy-now.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-custom-description-tab.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-compare.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-hurryup-notification.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-live-search.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-access-role.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-product-labels.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-quickview.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-sale-countdown.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-sales-stock-bar.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-review-feeling.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-review-media.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-review-order.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-sales-popup.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-social-login.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-vendor.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-video-thumbnail.php';
	include_once RIODE_OPTION . '/woo-features/option-wf-360-thumbnail.php';
}
