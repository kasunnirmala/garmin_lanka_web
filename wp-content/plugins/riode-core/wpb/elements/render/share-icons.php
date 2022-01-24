<?php
/**
 * Share Icons Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess


$wrapper_attrs = array(
	'class' => 'riode-shareicon-container social-icons ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// share icon Render

// content
if ( $content ) {
	echo do_shortcode( $content );
}

?>
</div>
<?php
