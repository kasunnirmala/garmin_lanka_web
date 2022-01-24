<?php
/**
 * Tab Item Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class'          => 'riode-tab-item-container tab-pane ' . $shortcode_class . $style_class,
	'data-tab-title' => empty( $atts['tab_title'] ) ? 'Tab' : riode_strip_script_tags( $atts['tab_title'] ),
);

global $riode_wpb_tab;
if ( empty( $riode_wpb_tab ) ) {
	$wrapper_attrs['class'] .= ' active';
	$riode_wpb_tab           = array();
}
$riode_wpb_tab[] = array(
	'title'    => empty( $atts['tab_title'] ) ? ( empty( $atts['icon'] ) ? 'Tab' : '' ) : $atts['tab_title'],
	'icon'     => empty( $atts['icon'] ) ? '' : $atts['icon'],
	'icon_pos' => empty( $atts['icon_pos'] ) ? 'left' : $atts['icon_pos'],
	'selector' => '.' . str_replace( ' ', '', $shortcode_class ),
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
echo do_shortcode( $content );
?>
</div>
<?php
