<?php
/**
 * Product Custom TAB
 *
 * @since 1.0
 * @since 1.4.0 init.php file has been created
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( $is_admin && ( $doing_ajax || $product_edit_page ) && riode_get_option( 'product_cdt' ) ) {
	require_once( RIODE_ADDON . '/product-custom-tab/product-custom-tab-admin.php' );
}
