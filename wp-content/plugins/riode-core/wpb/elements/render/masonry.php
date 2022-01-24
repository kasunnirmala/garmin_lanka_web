<?php
/**
 * Masonry Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-masonry-container ' . $shortcode_class . $style_class,
);

$settings = array(
	'creative_mode'         => isset( $atts['creative_mode'] ) ? $atts['creative_mode'] : 1,
	'col_sp'                => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
	'creative_height'       => isset( $atts['creative_height'] ) ? $atts['creative_height'] : 600,
	'creative_height_ratio' => isset( $atts['creative_height_ratio'] ) ? $atts['creative_height_ratio'] : 75,
	'grid_float'            => isset( $atts['grid_float'] ) ? $atts['grid_float'] : '',
);

$wrapper_attrs['class'] .= ' grid creative-grid gutter-' . $settings['col_sp'] . ' grid-mode-' . $settings['creative_mode'];

if ( isset( $settings['grid_float'] ) && 'yes' == $settings['grid_float'] ) {
	$wrapper_attrs['class'] .= ' grid-float';
} else {
	wp_enqueue_script( 'isotope-pkgd' );

	$wrapper_attrs['data-plugin'] = 'isotope';
}

global $riode_wpb_creative_layout;
$riode_wpb_creative_layout = array(
	'preset' => riode_creative_layout( $settings['creative_mode'] ),
	'layout' => array(), // layout of children
	'index'  => 0, // index of children
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

$wrapper_attr_html .= "data-creative-breaks='" . json_encode(
	array(
		'sm' => 576,
		'md' => 768,
		'lg' => 992,
		'xl' => 1200,
	)
) . "' ";

if ( vc_is_inline() ) {
	$wrapper_attr_html .= 'data-creative-preset=' . json_encode( $riode_wpb_creative_layout['preset'] );
	$wrapper_attr_html .= ' data-creative-id="' . str_replace( ' ', '', $shortcode_class ) . '"';
	$wrapper_attr_html .= ' data-creative-height="' . $settings['creative_height'] . '"';
	$wrapper_attr_html .= ' data-creative-height-ratio="' . $settings['creative_height_ratio'] . '"';
}

$content_escaped = do_shortcode( $content );

riode_creative_layout_style(
	'.' . str_replace( ' ', '', $shortcode_class ),
	$riode_wpb_creative_layout['layout'],
	$settings['creative_height'],
	$settings['creative_height_ratio'],
	true
);

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
echo riode_escaped( $content_escaped );
echo '<div class="grid-space"></div>';
?>
</div>
<?php
