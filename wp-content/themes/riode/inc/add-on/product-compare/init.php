<?php
/**
 * Product Compare
 *
 * @since 1.2.0
 * @since 1.4.0 init.php file has been created
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( riode_get_option( 'product_compare' ) ) {
	require_once RIODE_ADDON . '/product-compare/compare.php';
}
