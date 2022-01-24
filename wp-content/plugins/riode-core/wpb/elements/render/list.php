<?php
/**
 * List Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess


$wrapper_attrs = array(
	'class' => 'riode-list-container list ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<ul <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// List Render

// content
if ( $content ) {
	echo do_shortcode( $content );
}

?>
</ul>
<?php
