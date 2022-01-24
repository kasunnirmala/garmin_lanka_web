<?php
/**
 * Hotspot Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

$atts['icon'] = array(
	'value' => ! empty( $atts['icon'] ) ? $atts['icon'] : 'd-icon-plus',
);

$atts['page_builder'] = 'wpb';

$wrapper_attrs = array(
	'class' => 'riode-wpb-hotspot-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// Button Render
include RIODE_CORE_PATH . 'elementor/render/widget-hotspot-render.php';
?>
</div>
<?php
