<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Post Layout
 */

do_action( 'riode_print_before_page_layout' );

if ( is_single() ) :
	get_template_part( RIODE_PART . '/posts/single' );
else :
	riode_get_template_part(
		RIODE_PART . '/posts/archive',
		null
	);
endif;

do_action( 'riode_print_after_page_layout' );
