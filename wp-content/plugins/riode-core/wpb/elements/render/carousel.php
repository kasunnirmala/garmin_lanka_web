<?php
/**
 * Carousel Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-carousel-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
$settings = array(
	'col_sp'                => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
	'slider_vertical_align' => isset( $atts['slider_vertical_align'] ) ? $atts['slider_vertical_align'] : '',
	'fullheight'            => isset( $atts['fullheight'] ) ? $atts['fullheight'] : '',
	'autoplay'              => isset( $atts['autoplay'] ) ? $atts['autoplay'] : '',
	'autoplay_timeout'      => isset( $atts['autoplay_timeout'] ) ?
	$atts['autoplay_timeout'] : 5000,
	'loop'                  => isset( $atts['loop'] ) ? $atts['loop'] : '',
	'pause_onhover'         => isset( $atts['pause_onhover'] ) ? $atts['pause_onhover'] : '',
	'autoheight'            => isset( $atts['autoheight'] ) ? $atts['autoheight'] : '',
	'center_mode'           => isset( $atts['center_mode'] ) ? $atts['center_mode'] : '',
	'prevent_drag'          => isset( $atts['prevent_drag'] ) ? $atts['prevent_drag'] : '',
	'animation_in'          => isset( $atts['animation_in'] ) ? $atts['animation_in'] : '',
	'animation_out'         => isset( $atts['animation_out'] ) ? $atts['animation_out'] : '',
	'nav_hide'              => isset( $atts['nav_hide'] ) ? $atts['nav_hide'] : '',
	'nav_pos'               => isset( $atts['nav_pos'] ) ? $atts['nav_pos'] : 'outer',
	'nav_type'              => isset( $atts['nav_type'] ) ? $atts['nav_type'] : '',
	'dots_kind'             => isset( $atts['dots_kind'] ) ? $atts['dots_kind'] : '',
	'thumbs'                => isset( $atts['thumbs'] ) ? $atts['thumbs'] : '',
	'vertical_dots'         => isset( $atts['vertical_dots'] ) ? $atts['vertical_dots'] : '',
	'dots_type'             => isset( $atts['dots_type'] ) ? $atts['dots_type'] : '',
	'dots_pos'              => isset( $atts['dots_pos'] ) ? $atts['dots_pos'] : '',
);

// Responsive columns
$settings = array_merge( $settings, riode_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $settings['col_cnt'] ) {
	$settings['col_cnt'] = $settings['col_cnt_xl'];
}
// Responsive nav visibility
$settings = array_merge( $settings, riode_wpb_convert_responsive_values( 'show_nav', $atts ) );
if ( isset( $settings['show_nav_xl'] ) && ! isset( $settings['show_nav'] ) ) {
	$settings['show_nav'] = $settings['show_nav_xl'];
}
// Responsive dots visibility
$settings = array_merge( $settings, riode_wpb_convert_responsive_values( 'show_dots', $atts ) );
if ( isset( $settings['show_dots_xl'] ) && ! isset( $settings['show_dots'] ) ) {
	$settings['show_dots'] = $settings['show_dots_xl'];
}

$col_cnt      = riode_elementor_grid_col_cnt( $settings );
$extra_class  = riode_get_col_class( $col_cnt );
$extra_class .= ' ' . riode_elementor_grid_space_class( $settings );
$extra_class .= ' ' . riode_get_slider_class( $settings );
$extra_attrs  = 'data-plugin="owl" data-owl-options=' . esc_attr(
	json_encode(
		riode_get_slider_attrs( $settings, $col_cnt, str_replace( ' ', '', $shortcode_class ) )
	)
);

echo '<div class="' . $extra_class . '" ' . riode_strip_script_tags( $extra_attrs ) . '>';
echo do_shortcode( $content );
echo '</div>';

if ( 'thumb' == $settings['dots_kind'] ) {
	echo '<div class="slider-thumb-dots slider-thumb-dots-' . str_replace( ' ', '', $shortcode_class ) . '">';

	$settings['thumbs'] = explode( ',', $settings['thumbs'] );

	if ( count( $settings['thumbs'] ) ) {
		foreach ( $settings['thumbs'] as $thumb ) {
			echo '<button role="presentation" class="owl-dot">';
			echo wp_get_attachment_image( $thumb );
			echo '</button>';
		}
	}
	echo '</div>';
}
?>
</div>
<?php
