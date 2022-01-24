<?php
/**
 * Product Review Feeling
 *
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( riode_get_option( 'product_review_feeling' ) ) {
	require_once RIODE_ADDON . '/product-review-feeling/review-feeling.php';
}
