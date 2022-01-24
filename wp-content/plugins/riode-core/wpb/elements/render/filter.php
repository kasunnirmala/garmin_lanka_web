<?php
/**
 * Filter Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-filter-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

global $riode_wpb_filter;
do_shortcode( $content );

$settings = array(
	'align'      => isset( $atts['align'] ) ? $atts['align'] : 'center',
	'btn_label'  => isset( $atts['btn_label'] ) ? $atts['btn_label'] : 'Filter',
	'btn_skin'   => isset( $atts['btn_skin'] ) ? $atts['btn_skin'] : 'btn-primary',
	'attributes' => $riode_wpb_filter,
);

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// Filter Render
include RIODE_CORE_PATH . 'elementor/render/widget-filter-render.php';
?>
</div>
<?php
