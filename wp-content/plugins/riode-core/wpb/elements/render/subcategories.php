<?php
/**
 * Subcategories Shortcode Render
 *
 * @since 1.1.0
 */

$wrapper_attrs = array(
	'class' => 'riode-wpb-subcategories-container ' . $shortcode_class . $style_class,
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
include RIODE_CORE_PATH . 'elementor/render/widget-subcategories-render.php';
?>
</div>
<?php
