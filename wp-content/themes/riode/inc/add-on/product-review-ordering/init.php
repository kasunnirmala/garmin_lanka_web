<?php
/**
 * Product Review Feeling
 *
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( riode_get_option( 'product_review_ordering' ) ) {
	require_once RIODE_ADDON . '/product-review-ordering/review-ordering.php';
}
