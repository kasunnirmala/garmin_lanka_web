<?php
/**
 * Product Attribute Swatch
 *
 * @since 1.0.0
 * @since 1.4.0 manages all attribute swatches
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( riode_get_option( 'attribute_swatch' ) ) {
	if ( $is_admin && ( wp_doing_ajax() || $product_edit_page ) ) {
		require_once( RIODE_ADDON . '/attribute-swatch/attribute-swatch-admin.php' );
	}

	require_once( RIODE_ADDON . '/attribute-swatch/attribute-swatch.php' );
}
