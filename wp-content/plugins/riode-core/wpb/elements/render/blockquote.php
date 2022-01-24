<?php
/**
 * Blockquote Shortcode Render
 *
 * @since 1.4.0
 */

// Preprocess
if ( ! empty( $atts['image'] ) ) {
	$atts['image'] = array(
		'id' => $atts['image'],
	);
}

$wrapper_attrs = array(
	'class' => 'riode-blockquote-container ' . $shortcode_class . ' ' . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
include RIODE_CORE_PATH . 'elementor/render/widget-blockquote-render.php';
?>
</div>
<?php
