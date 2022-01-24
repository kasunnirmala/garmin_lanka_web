<?php
/**
 * Block Shortcode Render
 *
 * @since 1.1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'name' => '',
		),
		$atts
	)
);

// Preprocess

$wrapper_attrs = array(
	'class' => 'riode-block-container ' . $shortcode_class . ' ' . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
include RIODE_CORE_PATH . 'elementor/render/widget-block-render.php';
?>
</div>
<?php
