<?php
/**
 * Product Data Addons
 *
 * @since 1.0
 * @since 1.4.0 init.php file has been created
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( $is_admin && ( $doing_ajax || $product_edit_page ) ) {
	require_once( RIODE_ADDON . '/product-data-addons/product-data-addons-admin.php' );
}
