<?php
/**
 * Riode WPBakery Accordion Header Callback
 *
 * adds heading control for element option
 * follow below example of accordion_header control
 *
 * array(
 *      'type'       => 'riode_accordion_header',
 *      'heading'    => esc_html__( 'Cart Type Options', 'riode-core' ),
 *      'param_name' => 'test_accordion_header',
 *      'group'      => 'General',
 * ),
 *
 * @since 1.1.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function riode_accordion_header_callback( $settings, $value ) {
	$heading = isset( $settings['heading'] ) ? $settings['heading'] : '';

	$html = sprintf( '<h3 class="riode-wpb-accordion-header">%1$s</h3>', $heading );

	return $html;
}

vc_add_shortcode_param( 'riode_accordion_header', 'riode_accordion_header_callback' );
