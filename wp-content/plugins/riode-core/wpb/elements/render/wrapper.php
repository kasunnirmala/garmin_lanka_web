<?php
/**
 * Wrapper Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess

$wrapper_attrs = array(
	'class' => 'element-wrapper ' . $shortcode_class . $style_class,
);

$id = str_replace( array( ' ', 'wpb_custom_' ), '', $shortcode_class );

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$floating_options = array(
	'riode_floating'      => isset( $atts['floating_effect'] ) ? $atts['floating_effect'] : '',
	'riode_m_track_dir'   => isset( $atts['floating_m_track_dir'] ) ? $atts['floating_m_track_dir'] : '',
	'riode_m_track_speed' => array( 'size' => isset( $atts['floating_m_track_speed'] ) ? $atts['floating_m_track_speed'] : '0.5' ),
	'riode_scroll_size'   => array( 'size' => isset( $atts['floating_scroll_speed'] ) ? $atts['floating_scroll_speed'] : '50' ),
	'riode_scroll_stop'   => isset( $atts['floating_scroll_stop'] ) ? $atts['floating_scroll_stop'] : 'center',
);

$dismiss_options = array(
	'riode_cm_dismiss'                    => isset( $atts['riode_cm_dismiss'] ) ? $atts['riode_cm_dismiss'] : '',
	'riode_cm_dismiss_animation_out'      => isset( $atts['riode_cm_dismiss_animation_out'] ) ? $atts['riode_cm_dismiss_animation_out'] : '',
	'riode_cm_dismiss_animation_duration' => isset( $atts['riode_cm_dismiss_animation_duration'] ) ? $atts['riode_cm_dismiss_animation_duration'] : 400,
	'riode_cm_dismiss_animation_delay'    => isset( $atts['riode_cm_dismiss_animation_delay'] ) ? $atts['riode_cm_dismiss_animation_delay'] : '',
	'riode_cm_dismiss_cookie'             => isset( $atts['riode_cm_dismiss_cookie'] ) ? $atts['riode_cm_dismiss_cookie'] : '',
	'riode_cm_dismiss_cookie_expire'      => isset( $atts['riode_cm_dismiss_cookie_expire'] ) ? $atts['riode_cm_dismiss_cookie_expire'] : 7,
);

if ( 'yes' == $dismiss_options['riode_cm_dismiss'] &&
	'yes' == $dismiss_options['riode_cm_dismiss_cookie'] &&
	! riode_is_wpb_preview() &&
	isset( $_COOKIE[ 'riode-dismiss-' . $id ] ) ) {
	return;
}

include_once RIODE_CORE_PATH . '/elementor/additionals/additional-floating-effect.php';
include_once RIODE_CORE_PATH . '/elementor/additionals/additional-dismiss.php';

$wrapper_attrs = riode_elementor_common_wrapper_floating_attributes( $wrapper_attrs, $floating_options, $id );
$wrapper_attrs = riode_elementor_common_wrapper_dismiss_attributes( $wrapper_attrs, $dismiss_options, $id );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	if ( 'data-options' == $key ) {
		$value = "'" . $value . "'";
	} else {
		$value = '"' . $value . '"';
	}
	$wrapper_attr_html .= $key . '=' . $value . ' ';
}

$html_tag = isset( $atts['html_tag'] ) ? $atts['html_tag'] : 'div';

echo '<' . $html_tag . ' ' . $wrapper_attr_html . '>';

// Dimsiss
riode_elementor_common_before_render_dismiss( $dismiss_options, $id );

if ( $floating_options['riode_floating'] && 0 === strpos( 'mouse_tracking', $floating_options['riode_floating'] ) ) {
	echo '<div class="layer">';
}
echo do_shortcode( $content );
if ( $floating_options['riode_floating'] && 0 === strpos( 'mouse_tracking', $floating_options['riode_floating'] ) ) {
	echo '</div>';
}
echo '</' . $html_tag . '>';
