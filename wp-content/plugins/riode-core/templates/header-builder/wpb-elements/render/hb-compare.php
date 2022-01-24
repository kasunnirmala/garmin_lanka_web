<?php
/**
 * Header Compare Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-hb-compare-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

$args = array(
	'type'        => isset( $atts['type'] ) ? $atts['type'] : 'inline',
	'show_label'  => isset( $atts['show_label'] ) ? 'yes' == $atts['show_label'] : 'yes',
	'show_count'  => isset( $atts['show_count'] ) ? 'yes' == $atts['show_count'] : 'yes',
	'show_icon'   => isset( $atts['show_icon'] ) ? 'yes' == $atts['show_icon'] : 'yes',
	'icon'        => isset( $atts['icon'] ) && $atts['icon'] ? $atts['icon'] : 'd-icon-compare',
	'label'       => isset( $atts['label'] ) ? $atts['label'] : 'Compare',
	'minicompare' => isset( $atts['minicompare'] ) ? $atts['minicompare'] : '',
);

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// HB Compare Render
if ( defined( 'RIODE_VERSION' ) ) {
	riode_get_template_part( RIODE_PART . '/header/elements/element-compare', null, $args );
}
?>
</div>
<?php
