<?php
/**
 * Riode WPBakery Dropdown Group Callback
 *
 * adds dropdown control with optgroup for element option
 * follow below example of dropdown_group control
 *
 * array(
 *      'type'       => 'riode_dropdown_opt',
 *      'heading'    => esc_html__( 'Cart Type Options', 'riode-core' ),
 *      'param_name' => 'test_accordion_header',
 *      'group'      => 'General',
 * ),
 *
 * @since 1.2.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */

function riode_dropdown_group_callback( $settings, $value ) {
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';

	$html .= '<select name="' . $settings['param_name'] . '" class="riode-dropdown-group-container wpb_vc_param_value wpb-input wpb-select ' . esc_attr( $settings['param_name'] ) . ' ' . $type . '" value="' . esc_attr( $value ) . '">';

	if ( ! empty( $settings['value'] ) ) {
		foreach ( $settings['value'] as $v => $label ) {
			if ( is_array( $label ) ) {
				if ( ! empty( $label ) ) {
					$html .= '<optgroup label="' . esc_attr( $label['label'] ) . '">';
					foreach ( $label['options'] as $iv => $l ) {
						$html .= '<option value="' . esc_attr( $iv ) . '" ' . selected( $value, $iv, false ) . '>' . htmlspecialchars( $l ) . '</option>';
					}
					$html .= '</optgroup>';
				}
			} else {
				$html .= '<option value="' . esc_attr( $v ) . '">' . htmlspecialchars( $label ) . '</option>';
			}
		}
	}
	$html .= '</select>';

	return $html;
}

vc_add_shortcode_param( 'riode_dropdown_group', 'riode_dropdown_group_callback' );
