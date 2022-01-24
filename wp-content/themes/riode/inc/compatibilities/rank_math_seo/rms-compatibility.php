<?php
/**
 * Rank Math SEO Compatibility
 *
 * @since 1.4.0
 */
add_filter( 'riode_print_another_breadcrumb', 'riode_print_rms_breadcrumb' );

if ( ! function_exists( 'riode_print_rms_breadcrumb' ) ) {
	function riode_print_rms_breadcrumb( $func ) {
		return 'rank_math_the_breadcrumbs';
	}
}
