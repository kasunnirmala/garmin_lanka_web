<?php
/**
 * Product Buy Now
 *
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( riode_get_option( 'product_buy_now' ) ) {
	require_once RIODE_ADDON . '/product-buy-now/buy-now.php';
}
