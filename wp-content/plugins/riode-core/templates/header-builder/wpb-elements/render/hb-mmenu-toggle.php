<?php
/**
 * Header Mobile Menu Toggle Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-hb-mmenu-toggle-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

$args = array(
	'mmenu_toggle' => array(
		'icon' => isset( $atts['icon'] ) && $atts['icon'] ? $atts['icon'] : 'd-icon-bars2',
	),
);

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// HB Mobile Menu Render
if ( defined( 'RIODE_VERSION' ) ) {
	riode_get_template_part( RIODE_PART . '/header/elements/element-mmenu-toggle', null, $args );
}
?>
</div>
<?php
