<?php
/**
 * Riode WPBakery Heading Callback
 *
 * adds heading control for element option
 * follow below example of riode_heading control
 *
 * array(
 *      'type'        => 'riode_heading',
 *      'label'       => esc_html__( 'Button Heading Test', 'riode-core' ),
 *      'param_name'  => 'test_heading',
 *      'tag'         => 'h2',
 *      'class'       => 'riode-heading-control-class',
 *      'group'       => 'General',
 * ),
 *
 * @since 1.1.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function riode_heading_callback( $settings, $value ) {
	$tag   = isset( $settings['tag'] ) ? $settings['tag'] : 'h3';
	$class = isset( $settings['class'] ) ? $settings['class'] : '';
	$label = isset( $settings['label'] ) ? $settings['label'] : '';

	$html = sprintf( '<%1$s class="riode-wpb-heading-container%2$s">%3$s</%4$s>', $tag, ( $class ? ' ' . $class : '' ), $label, $tag );

	return $html;
}

vc_add_shortcode_param( 'riode_heading', 'riode_heading_callback' );
