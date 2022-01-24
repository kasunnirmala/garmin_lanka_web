<?php
/**
 * Riode Multi Select
 *
 * adds multi select control for element option
 * follow below example of riode_multiselect control
 *
 * array(
 *      'type'       => 'riode_multiselect',
 *      'heading'    => esc_html__( 'Show Information', 'riode-core' ),
 *      'param_name' => 'show_info',
 *      'value'      => array(
 *          esc_html__( 'Category', 'riode-core' ) => 'category',
 *          esc_html__( 'Label', 'riode-core' )    => 'label',
 *          esc_html__( 'Price', 'riode-core' )    => 'price',
 *          esc_html__( 'Rating', 'riode-core' )   => 'rating',
 *          esc_html__( 'Attribute', 'riode-core' ) => 'attribute',
 *          esc_html__( 'Add To Cart', 'riode-core' ) => 'addtocart',
 *          esc_html__( 'Compare', 'riode-core' )  => 'compare',
 *          esc_html__( 'Quickview', 'riode-core' ) => 'quickview',
 *          esc_html__( 'Wishlist', 'riode-core' ) => 'wishlist',
 *          esc_html__( 'Short Description', 'riode-core' ) => 'short_desc',
 *      ),
 *      'dependency' => array(
 *          'element'            => 'follow_theme_option',
 *          'value_not_equal_to' => 'yes',
 *      ),
 * ),
 *
 *
 * @since 1.1.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function riode_multiselect_callback( $settings, $value ) {
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$class      = 'riode-wpb-multiselect-container';

	if ( empty( $value ) ) {
		$value = array();
	} elseif ( ! is_array( $value ) ) {
		$value = explode( ',', $value );
	}

	$html .= '<select name="' . esc_attr( $settings['param_name'] ) . '" class="riode-multiselect-container wpb_vc_param_value wpb-input wpb-select ' . esc_attr( $settings['param_name'] ) . ' ' . $type . '" value="' . esc_attr( $value ) . '"  multiple="true">';

	if ( ! empty( $settings['value'] ) ) {
		foreach ( $settings['value'] as $option_label => $option_value ) {
			$selected            = '';
			$option_value_string = (string) $option_value;
			if ( ! empty( $value ) && in_array( $option_value_string, $value ) ) {
				$selected = 'selected="selected"';
			}
			$option_class = str_replace( '#', 'hash-', $option_value );
			$html        .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '" ' . $selected . '>' . htmlspecialchars( $option_label ) . '</option>';
		}
	}
	$html .= '</select>';

	return $html;
}

vc_add_shortcode_param( 'riode_multiselect', 'riode_multiselect_callback' );
