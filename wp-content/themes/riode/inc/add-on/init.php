<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'RIODE_ADDON', RIODE_INC . '/add-on' );
define( 'RIODE_ADDON_URI', RIODE_URI . '/inc/add-on' );

$addons = array();

if ( ! isset( $_GET['action'] ) || 'yith-woocompare-view-table' != $_GET['action'] ) {
	$doing_ajax         = riode_doing_ajax();
	$customize_preview  = is_customize_preview();
	$is_admin           = is_admin();
	$elementor_preview  = function_exists( 'riode_is_elementor_preview' ) && riode_is_elementor_preview();
	$wpb_preview        = function_exists( 'riode_is_wpb_preview' ) && riode_is_wpb_preview();
	$is_preview         = $elementor_preview || $wpb_preview;
	$template_edit_page = 'edit.php' == $GLOBALS['pagenow'] && isset( $_REQUEST['post_type'] ) && 'riode_template' == $_REQUEST['post_type'];
	$product_edit_page  = ( 'post-new.php' == $GLOBALS['pagenow'] && isset( $_GET['post_type'] ) && 'product' == $_GET['post_type'] ) ||
							( 'post.php' == $GLOBALS['pagenow'] && isset( $_GET['post'] ) && 'product' == get_post_type( $_GET['post'] ) );

	$addons = array_merge(
		$addons,
		array(
		'skeleton',
		'lazyload-images',
		'lazyload-menu',
		'live-search',
		'studio',
		'starter-guide',
		'breadcrumb',
		)
	);

	// WooCommerce Add-ons
	if ( class_exists( 'WooCommerce' ) ) {
		$addons = array_merge(
			$addons,
			array(
			'product-data-addons',
			'attribute-swatch',
			'product-custom-tab',
			'sales-popup',
			'video-thumbnail',
			'360-gallery',
			'product-compare',
			'product-buy-now',
			'product-media-review',
			'product-review-feeling',
			'product-review-ordering',
				'product-recently-viewed',
			)
		);
	}

	foreach ( $addons as $addon ) {
		include_once RIODE_ADDON . '/' . $addon . '/init.php';
	}
}
