<?php
/**
 * Product Image & Video Review
 *
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( riode_get_option( 'product_media_review' ) ) {
	global $pagenow;

	require_once RIODE_ADDON . '/product-media-review/media-review.php';

	if ( $is_admin && ( 'comment.php' == $pagenow || 'edit-comments.php' == $pagenow ) ) {
		require_once RIODE_ADDON . '/product-media-review/media-review-admin.php';
	}
}