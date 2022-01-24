<?php
/**
 * Banner Shortcode Render
 *
 * @since 1.1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'wrap_with'         => '',
			'banner_image'      => '',
			'full_screen'       => 'no',
			'min_height'        => '300',
			'max_height'        => '',
			'hover_effect'      => '',
			'background_effect' => '',
			'particle_effect'   => '',
			'parallax'          => 'no',
			'parallax_speed'    => 1,
			'parallax_offset'   => 0,
			'parallax_height'   => '200',
			'video_banner'      => 'no',
			'video_url'         => '',
			'video_autoplay'    => 'no',
			'video_mute'        => 'no',
			'video_loop'        => 'no',
			'video_controls'    => 'no',
		),
		$atts
	)
);
// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-wpb-banner-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}


if ( 'banner' == $shortcode ) {
	echo '<div ' . $wrapper_attr_html . '>';
} else {
	global $riode_products_banner_items;
	$riode_products_banner_items[ count( $riode_products_banner_items ) - 1 ]['banner_class'] = $wrapper_attrs['class'];
}

$html             = '';
$wrapper_cls      = 'banner banner-fixed';
$background_cls   = 'background-effect';
$particle_cls     = '';
$parallax_img     = '';
$parallax_options = array();
$video_options    = '';

if ( 'yes' == $full_screen ) {
	$wrapper_cls .= ' banner-full';
}
// image
$img            = '';
$banner_img_cls = '';
if ( isset( $background_effect ) && ! empty( $background_effect ) ) {
	$banner_img_cls = 'banner-img-hidden';
}
if ( $banner_image ) {
	$img_attr['class'] = '';
	if ( is_numeric( $banner_image ) ) {
		$img_data = wp_get_attachment_image_src( $banner_image, 'full' );
		if ( is_array( $img_data ) ) {
			// Generate 'srcset' and 'sizes'
			$image_meta = wp_get_attachment_metadata( $banner_image );
			$srcset     = wp_get_attachment_image_srcset( $banner_image, 'full', $image_meta );
			$sizes      = wp_get_attachment_image_sizes( $banner_image, 'full', $image_meta );
			if ( $srcset && $sizes ) {
				$img_attr['srcset'] = $srcset;
				$img_attr['sizes']  = $sizes;
			}

			$attr_str_escaped = '';
			foreach ( $img_attr as $key => $val ) {
				$attr_str_escaped .= ' ' . esc_html( $key ) . '="' . esc_attr( $val ) . '"';
			}
			$img = '<figure class="banner-img ' . esc_attr( $banner_img_cls ) . '"><img src="' . esc_url( $img_data[0] ) . '" alt="' . esc_attr( trim( get_post_meta( $banner_image, '_wp_attachment_image_alt', true ) ) ) . '" width="' . esc_attr( $img_data[1] ) . '" height="' . esc_attr( $img_data[2] ) . '"' . $attr_str_escaped . '></figure>';
		}
	} else {
		$img_attr['src'] = esc_url( $banner_image );
		$img_attr_html   = '';
		foreach ( $img_attr as $name => $value ) {
			$img_attr_html .= " $name=" . '"' . $value . '"';
		}
		$img = '<figure class="banner-img"><img alt=""' . $img_attr_html . ' /></figure>';
	}
}

// effect
if ( $hover_effect ) {
	$wrapper_cls .= ' ' . $hover_effect;
}
if ( $background_effect || $particle_effect ) {
	$background_cls .= ' ' . $background_effect;
	$particle_cls   .= ' ' . $particle_effect;

	if ( $banner_image ) {
		if ( is_numeric( $banner_image ) ) {
			$img_data       = wp_get_attachment_image_src( $banner_image, 'full' );
			$background_img = esc_url( $img_data[0] );
		} else {
			$background_img = esc_url( $banner_image );
		}
	}
}
// parallax
if ( 'yes' == $parallax ) {
	wp_enqueue_script( 'jquery-parallax' );
	$wrapper_cls .= ' parallax';

	if ( $banner_image ) {
		if ( is_numeric( $banner_image ) ) {
			$img_data     = wp_get_attachment_image_src( $banner_image, 'full' );
			$parallax_img = esc_url( $img_data[0] );
		} else {
			$parallax_img = esc_url( $banner_image );
		}
	}

	if ( is_numeric( $parallax_speed ) || is_numeric( $parallax_speed ) ) {
		$parallax_speed  = intval( $parallax_speed );
		$parallax_offset = intval( $parallax_offset );
	}
	$parallax_options = array(
		'speed'          => $parallax_speed ? 10 / $parallax_speed : 1.5,
		'parallaxHeight' => $parallax_height ? $parallax_height . '%' : '200%',
		'offset'         => $parallax_offset ? $parallax_offset : 0,
	);
	$parallax_options = 'data-parallax-options=' . json_encode( $parallax_options );
}
// video
if ( 'yes' == $video_banner ) {
	$wrapper_cls .= ' video-banner';
	if ( 'yes' == $video_autoplay ) {
		$video_options .= ' autoplay';
	}
	if ( 'yes' == $video_mute ) {
		$video_options .= ' muted="muted"';
	}
	if ( 'yes' == $video_loop ) {
		$video_options .= ' loop';
	}
	if ( 'yes' == $video_controls ) {
		$video_options .= ' controls';
	}
}
if ( 'yes' == $parallax ) {
	$html .= '<div class="' . $wrapper_cls . '" data-plugin="parallax" data-image-src="' . $parallax_img . '" ' . esc_attr( $parallax_options ) . '>';
} elseif ( 'yes' == $video_banner ) {
	$html .= '<div class="' . $wrapper_cls . '">';
	$html .= '<video ' . $video_options . '><source src="' . esc_url( $video_url ) . '" type="video/mp4"></video>';
} else {
	$html .= '<div class="' . $wrapper_cls . '">';
}

// background & particle effect
if ( $background_effect || $particle_effect ) {
	$html .= '<div class="background-effect-wrapper">';
	if ( ! empty( $banner_image ) ) {
		$html .= '<div class="background-effect ' . $background_cls . '" style="background-image: url(' . $background_img . '); background-size: cover;">';
		if ( $particle_effect ) {
			$html .= '<div class="particle-effect ' . $particle_cls . '"></div>';
		}
		$html .= '</div>';
	}
	$html .= '</div>';
}
// image
if ( $img ) {
	$html .= $img;
}
// content
if ( $content ) {
	if ( $wrap_with ) {
		$html .= '<div class="' . $wrap_with . '">';
	}
	$html .= do_shortcode( $content );
	if ( $wrap_with ) {
		$html .= '</div>';
	}
}

$html .= '</div>';

echo riode_escaped( $html );

if ( 'banner' == $shortcode ) {
	echo '</div>';
}
