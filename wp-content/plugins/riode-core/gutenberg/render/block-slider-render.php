<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'id'                      => '',
			'col_cnt_xl'              => '',
			'col_cnt'                 => '1',
			'col_cnt_min'             => '1',
			'col_sp'                  => 'no',
			'slider_vertical_align'   => '',
			'slider_horizontal_align' => '',
			'show_nav'                => false,
			'nav_hide'                => false,
			'nav_type'                => '',
			'nav_pos'                 => '',
			'show_dots'               => false,
			'dots_type'               => '',
			'dots_pos'                => '',
			'autoplay'                => false,
			'autoplay_timeout'        => 5000,
			'loop'                    => false,
			'pause_onhover'           => false,
			'autoheight'              => false,
			'center_mode'             => false,
			'animation_in'            => '',
			'animation_out'           => '',
			'nav_size'                => 20,
		),
		$atts
	)
);

wp_enqueue_script( 'owl-carousel' );

// Slider Settings
$extra_class = '';
$extra_attr  = '';

$extra_class .= 'owl-carousel owl-theme';

// Layout
if ( 'lg' === $col_sp || 'sm' === $col_sp || 'xs' === $col_sp || 'no' === $col_sp ) {
	$extra_class .= ' gutter-' . $col_sp;
}

$col_cnt = array(
	'xl'  => (int) $col_cnt_xl,
	'lg'  => (int) $col_cnt,
	'md'  => (int) $col_cnt,
	'sm'  => (int) $col_cnt,
	'min' => (int) $col_cnt_min,
);


if ( function_exists( 'riode_get_responsive_cols' ) ) {
	$col_cnt = riode_get_responsive_cols( $col_cnt );
}

if ( function_exists( 'riode_get_col_class' ) ) {
	$extra_class .= riode_get_col_class( $col_cnt );
}


// Nav & Dots

if ( 'full' === $nav_type ) {
	$extra_class .= ' owl-nav-full';
} else {
	if ( 'simple' === $nav_type ) {
		$extra_class .= ' owl-nav-simple';
	}
	if ( 'inner' === $nav_pos ) {
		$extra_class .= ' owl-nav-inner';
	} elseif ( 'top' === $nav_pos ) {
		$extra_class .= ' owl-nav-top';
	}
}
if ( true === $nav_hide ) {
	$extra_class .= ' owl-nav-fade';
}

if ( $dots_type ) {
	$extra_class .= ' owl-dot-' . $dots_type;
}

if ( 'inner' === $dots_pos ) {
	$extra_class .= ' owl-dot-inner';
}
if ( 'close' === $dots_pos ) {
	$extra_class .= ' owl-dot-close';
}

if ( 'top' === $slider_vertical_align ||
	'middle' === $slider_vertical_align ||
	'bottom' === $slider_vertical_align ||
	'same-height' === $slider_vertical_align ) {
	$extra_class .= ' owl-' . $slider_vertical_align;
}

// Options - ( Change Value ) true/false to yes/no
if ( isset( $atts['show_nav'] ) ) {
	$atts['show_nav'] = 'yes';
} else {
	$atts['show_nav'] = 'no';
}
if ( isset( $atts['show_dots'] ) ) {
	$atts['show_dots'] = 'yes';
} else {
	$atts['show_dots'] = 'no';
}
if ( isset( $atts['autoplay'] ) ) {
	$atts['autoplay'] = 'yes';
} else {
	$atts['autoplay'] = 'no';
}
if ( isset( $atts['loop'] ) ) {
	$atts['loop'] = 'yes';
} else {
	$atts['loop'] = 'no';
}
if ( isset( $atts['pause_onhover'] ) ) {
	$atts['pause_onhover'] = 'yes';
} else {
	$atts['pause_onhover'] = 'no';
}
if ( isset( $atts['pause_onhover'] ) ) {
	$atts['pause_onhover'] = 'yes';
} else {
	$atts['pause_onhover'] = 'no';
}
if ( isset( $atts['center_mode'] ) ) {
	$atts['center_mode'] = 'yes';
} else {
	$atts['center_mode'] = 'no';
}

$extra_attrs = ' data-plugin="owl" data-owl-options=' . esc_attr(
	json_encode(
		riode_get_slider_attrs( $atts, $col_cnt )
	)
);

// render HTML
echo '<style>';
echo '#riode_gtnbg_slider_' . $id . ' .owl-nav button { font-size: ' . $nav_size . 'px; }';
echo '</style>';
echo '<div class="' . esc_attr( $extra_class ) . '" ' . $extra_attrs . '>';
echo do_shortcode( $content );
echo '</div>';
