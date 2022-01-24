<?php
/**
 * Menu Shortcode Render
 *
 * @since 1.1.0
 */

if ( isset( $atts['icon'] ) ) {
	$atts['icon'] = array(
		'value' => $atts['icon'],
	);
}

if ( isset( $atts['hover_icon'] ) ) {
	$atts['hover_icon'] = array(
		'value' => $atts['hover_icon'],
	);
}

$atts['builder'] = 'wpb';

$wrapper_attrs = array(
	'class' => 'riode-menu-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// Menu Render
include RIODE_CORE_PATH . 'elementor/render/widget-menu-render.php';
?>
</div>
<?php
