<?php
/**
 * Breadcrumb Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess

$wrapper_attrs = array(
	'class' => 'riode-breadcrumb-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
$atts['widget'] = 'breadcrumb';
if ( isset( $atts['delimiter_icon'] ) ) {
	$atts['delimiter_icon'] = array( 'value' => $atts['delimiter_icon'] );
}
if ( ! isset( $atts['home_icon'] ) ) {
	$atts['home_icon'] = '';
}
do_action( 'riode_print_breadcrumb', $atts );
?>
</div>
<?php
