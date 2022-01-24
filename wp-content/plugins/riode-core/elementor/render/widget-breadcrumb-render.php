<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Breadcrumb Widget Render
 */


$atts['widget'] = 'breadcrumb';
do_action( 'riode_print_breadcrumb', $atts );
