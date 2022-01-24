<?php
/**
 * Logo Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-logo-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// Logo Render
$args = array(
	'logo_size' => isset( $atts['logo_imaze_size'] ) ? $atts['logo_imaze_size'] : '',
);

if ( defined( 'RIODE_VERSION' ) ) {
	riode_get_template_part( RIODE_PART . '/header/elements/element', 'logo', $args );
}
?>
</div>
<?php
