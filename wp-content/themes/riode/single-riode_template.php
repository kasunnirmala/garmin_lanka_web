<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Single Riode Template Page
 */

get_header();

do_action( 'riode_before_template' );

$category = get_post_meta( get_the_ID(), 'riode_template_type', true );

if ( 'header' == $category ) { // Header Layout

} elseif ( 'footer' == $category ) { // Footer Layout

} elseif ( 'popup' == $category ) { // Popup Layout
	$popup_options = get_post_meta( get_the_ID(), 'popup_options', true );
	if ( $popup_options ) {
		$popup_options = json_decode( $popup_options, true );
	} else {
		$popup_options = array(
			'width'     => '600',
			'transform' => 't-mc',
			'top'       => '50%',
			'right'     => 'auto',
			'bottom'    => 'auto',
			'left'      => '50%',
		);
	}

	echo '<div class="popup-overlay"></div>';
	echo '<div class="popup-container ' . $popup_options['transform'] . '" style="max-width: ' . (int) $popup_options['width'] . 'px; top: ' . $popup_options['top'] . '; right: ' . $popup_options['right'] . '; bottom: ' . $popup_options['bottom'] . '; left: ' . $popup_options['left'] . ';">';

	if ( have_posts() ) :

		the_post();

		the_content();

		wp_reset_postdata();

	endif;

	echo '</div>';
} elseif ( 'product_layout' == $category ) {
	global $product;

	if ( $product ) {
		wc_get_template_part( 'single-product' );
	}

	do_action( 'riode_after_template' );
} else {
	if ( have_posts() ) {

		the_post();

		the_content();

		wp_reset_postdata();
	}

	do_action( 'riode_after_template' );
}

get_footer();
