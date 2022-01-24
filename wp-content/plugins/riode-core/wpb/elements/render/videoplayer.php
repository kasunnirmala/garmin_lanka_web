<?php
/**
 * Video Player Shortcode Render
 *
 * @since 1.1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'button_icon'   => '',
			'alignment'     => 'left',
			'button_border' => 'btn-ellipse',
			'button_skin'   => 'btn-primary',
		),
		$atts
	)
);

// Preprocess

$wrapper_attrs = array(
	'class' => 'riode-videopopup-container video-player text-' . $alignment . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
$class    = 'btn btn-video-player';
$icon_cls = $button_icon ? $button_icon : 'd-icon-play-solid';
if ( $button_border ) {
	$class .= ' ' . $button_border;
}
if ( $button_skin ) {
	$class .= ' ' . $button_skin;
}
printf( '<a class="' . esc_attr( $class ) . '"><i class="' . esc_attr( $icon_cls ) . '"></i></a>' );
?>
</div>
<?php
