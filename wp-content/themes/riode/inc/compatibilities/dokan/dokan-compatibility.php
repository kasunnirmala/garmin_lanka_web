<?php

add_filter( 'dokan_product_image_attributes', 'riode_dokan_product_image_attributes', 999 );
add_filter( 'riode_is_vendor_store', 'riode_is_dokan_store_page' );

function riode_dokan_product_image_attributes() {
	return array(
		'img' => array(
			'alt'       => array(),
			'class'     => array(),
			'height'    => array(),
			'src'       => array(),
			'width'     => array(),
			'data-lazy' => array(),
		),
	);
}

/**
 * Store Page
 *
 * Check if is dokan store page.
 *
 * @since 1.2.0
 *
 * @param bool $arg
 *
 * @return bool
 */
if ( ! function_exists( 'riode_is_dokan_store_page' ) ) {
	function riode_is_dokan_store_page( $arg = false ) {
		return dokan_is_store_page();
	}
}

/**
 * Compatibility with dokan plugin
 * WordPress color picker doesn't work because of dokan chart.
 */
add_action( 'admin_enqueue_scripts', function() {
	if ( empty( $_GET['page'] ) || 'dokan' != $_GET['page'] ) { // register dokan chart js only in dokan dashboard page
		wp_deregister_script( 'dokan-chart' );
	}
}, 30 );
