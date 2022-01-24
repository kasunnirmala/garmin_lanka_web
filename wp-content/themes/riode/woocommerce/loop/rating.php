<?php
/**
 * Loop Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (
	! wc_review_ratings_enabled() ||
	(
		! isset( $is_hide_details ) &&
		'popup' === wc_get_loop_prop( 'classic_hover' ) &&
		'list' !== wc_get_loop_prop( 'product_type' )
	)
) {
	return;
}


$show_reviews_text = wc_get_loop_prop( 'show_reviews_text', true );
if ( ! riode_wc_show_info_for_role( 'rating' ) ) {
	return;
}

global $product;
?>
<div class="woocommerce-product-rating">
	<?php

	if ( apply_filters( 'riode_single_product_rating_show_number', false ) ) {
		echo esc_html( $product->get_average_rating() );
	} else {
		echo wc_get_rating_html( $product->get_average_rating() );
	}

	if ( apply_filters( 'riode_single_product_show_review', comments_open() && 'widget' != wc_get_loop_prop( 'product_type' ) ) ) {
		echo '<a href="' . esc_url( get_the_permalink() ) . '#reviews" class="woocommerce-review-link scroll-to" rel="nofollow">( ' . $product->get_review_count() . ' ' . ( $show_reviews_text ? esc_html__( 'reviews', 'riode' ) : '' ) . ' )</a>';
	}
	?>
</div>
