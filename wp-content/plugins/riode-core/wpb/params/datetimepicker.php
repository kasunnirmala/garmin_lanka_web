<?php
/**
 * Riode WPBakery datetimepicker Callback
 *
 * adds datepicker control for element option
 * follow below example of riode_heading control
 *
 * array(
 *      'type'        => 'riode_datetimepicker',
 *      'label'       => esc_html__( 'Date', 'riode-core' ),
 *      'param_name'  => 'test_date',
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
function riode_datetimepicker_callback( $settings, $value ) {
	$dependency = '';
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$class      = isset( $settings['class'] ) ? $settings['class'] : '';
	$uni        = uniqid( 'datetimepicker-' . rand() );
	$output     = '<div id="riode-date-time' . esc_attr( $uni ) . '" class="riode-datetime"><input data-format="yyyy/MM/dd hh:mm:ss" readonly class="wpb_vc_param_value ' . esc_attr( $param_name ) . ' ' . esc_attr( $type ) . ' ' . esc_attr( $class ) . '" name="' . esc_attr( $param_name ) . '" style="width:258px;" value="' . esc_attr( $value ) . '" ' . $dependency . '/><div class="add-on" > <i data-time-icon="far fa-calendar" data-date-icon="far fa-calendar"></i></div></div>';
	$output    .= '<script type="text/javascript"></script>';
	return $output;
}

vc_add_shortcode_param( 'riode_datetimepicker', 'riode_datetimepicker_callback', plugins_url( '../js/riode-datetimepicker.min.js', __FILE__ ) );
