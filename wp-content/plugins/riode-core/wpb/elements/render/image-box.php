<?php
/**
 * Image Box Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess

$settings = $atts;
$settings['page_builder'] = 'wpb';
$settings['content'] = rawurldecode( base64_decode( wp_strip_all_tags( $content ) ) );
$wrapper_attrs = array(
	'class' => 'riode-imagebox-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// Image Box Render
include RIODE_CORE_PATH . 'elementor/render/widget-imagebox-render.php';
?>
</div>
<?php
