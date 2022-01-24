<?php
/**
 * 360 Degree Gallery Shortcode Render
 *
 * @since 1.4.0
 */
$wrapper_attrs = array(
	'class' => 'riode-wpb-360-degree-container ' . $shortcode_class . $style_class . ( ! empty( $atts['el_class'] ) ? ( ' ' . $atts['el_class'] ) : '' ),
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

// Preprocess
if ( ! empty( $atts['images'] ) ) {
	$atts['images'] = explode( ',', $atts['images'] );
	foreach ( $atts['images'] as &$value ) {
		$value = array(
			'id'    => $value,
		);
	}
}

$atts['page_builder'] = 'wpb';

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// 360 Degree Galery Render
include RIODE_CORE_PATH . 'elementor/render/widget-360-degree-render.php';
?>
</div>
