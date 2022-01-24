<?php
/**
 * SVG Floating Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-svg-floating-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

global $riode_wpb_svgfloating;
$riode_wpb_svgfloating = array(
	'delta' => ! empty( $atts['delta'] ) ? $atts['delta'] : 15,
	'speed' => ! empty( $atts['speed'] ) ? $atts['speed'] : 10,
	'size'  => ! empty( $atts['size'] ) ? $atts['size'] : 1,
);

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php

if ( ! empty( $atts['float_svg'] ) ) {
	$html = rawurldecode( base64_decode( wp_strip_all_tags( $atts['float_svg'] ) ) );

	$html = preg_replace_callback(
		'|viewBox="([^"]*)"|',
		function( $matches ) {
			global $riode_wpb_svgfloating;
			$box     = array_map( 'floatval', explode( ' ', $matches[1] ) );
			$box[1] -= $riode_wpb_svgfloating['delta'];
			$box[3] += $riode_wpb_svgfloating['delta'] * 2;
			return 'viewBox="' . implode( ' ', $box ) . '" class="float-svg" data-float-options="{&quot;delta&quot;:' . $riode_wpb_svgfloating['delta'] . ',&quot;speed&quot;:' . $riode_wpb_svgfloating['speed'] . ',&quot;size&quot;:' . $riode_wpb_svgfloating['size'] . '}"';
		},
		$html
	);

	$html = preg_replace_callback(
		'|width="([\d\|\.]+)px"|',
		function( $matches ) {
			global $riode_wpb_svgfloating;
			return 'width="' . round( floatval( $matches[1] ) * $riode_wpb_svgfloating['size'], 3 ) . 'px"';
		},
		$html
	);

	$html = preg_replace_callback(
		'|height="([\d\|\.]+)px"|',
		function( $matches ) {
			global $riode_wpb_svgfloating;
			return 'height="' . round( floatval( $matches[1] ) * $riode_wpb_svgfloating['size'], 3 ) . 'px"';
		},
		$html
	);

	echo riode_escaped( $html );
}

unset( $riode_wpb_svgfloating );

?>
</div>
<?php
