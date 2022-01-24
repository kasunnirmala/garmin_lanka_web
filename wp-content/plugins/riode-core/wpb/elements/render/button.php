<?php
/**
 * Button Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}
$atts['builder'] = 'wpb';

$settings = $atts;

if ( ! empty( $atts['icon'] ) ) {
	$settings['icon'] = array(
		'value' => $atts['icon'],
	);
}

$wrapper_attrs = array(
	'class' => 'riode-button-container ' . $shortcode_class . $style_class,
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
include RIODE_CORE_PATH . 'elementor/render/widget-button-render.php';
?>
</div>
<?php
