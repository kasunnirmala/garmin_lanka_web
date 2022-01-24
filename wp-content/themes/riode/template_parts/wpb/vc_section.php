<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var WPBakeryShortCode_Vc_Row $this
 */
$el_class        = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = $css_animation = '';
$disable_element = '';
$output          = $after_output = '';

$atts['tag'] = 'vc_section';
foreach ( $atts as $key => $item ) {
	$atts[ $key ] = str_replace( '"', '``', $item );
}

$sc           = WPBMap::getShortCode( 'vc_section' );
$custom_class = '';
if ( ! empty( $sc['params'] ) ) {
	$custom_class = function_exists( 'riode_get_global_hashcode' ) ? 'wpb_custom_' . riode_get_global_hashcode( $atts, 'vc_section', $sc['params'] ) : '';
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

if ( empty( $atts['section_tag'] ) || 'default' == $atts['section_tag'] ) {
	$atts['section_tag'] = 'section';
}

extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class     = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$options      = array();
$sticky_allow = false;
if ( ! empty( $atts['sticky_allow'] ) ) {

	$sticky_options = array(
		'defaults' => array(
			'minWidth' => 992,
			'maxWidth' => 20000,
		),
		'devices'  => array(
			'xl' => false,
			'lg' => false,
			'md' => false,
			'sm' => false,
			'xs' => false,
		),
	);

	if ( 'yes' == $atts['sticky_allow'] ) {
		$sticky_options['devices']['xl'] = true;
		$sticky_options['devices']['lg'] = true;
		$sticky_allow                    = true;
	} else {

		$atts['sticky_allow'] = str_replace( '``', '"', $atts['sticky_allow'] );
		$atts['sticky_allow'] = json_decode( $atts['sticky_allow'], true );

		if ( isset( $atts['sticky_allow']['xl'] ) && 'yes' == $atts['sticky_allow']['xl'] ) {
			$sticky_options['devices']['xl'] = true;
			$sticky_allow                    = true;
		}

		if ( isset( $atts['sticky_allow']['lg'] ) && 'yes' == $atts['sticky_allow']['lg'] ) {
			$sticky_options['devices']['lg'] = true;
			$sticky_allow                    = true;
		}

		if ( isset( $atts['sticky_allow']['md'] ) && 'yes' == $atts['sticky_allow']['md'] ) {
			$sticky_options['devices']['md'] = true;
			$sticky_allow                    = true;
		}

		if ( isset( $atts['sticky_allow']['sm'] ) && 'yes' == $atts['sticky_allow']['sm'] ) {
			$sticky_options['devices']['sm'] = true;
			$sticky_allow                    = true;
		}

		if ( isset( $atts['sticky_allow']['xs'] ) && 'yes' == $atts['sticky_allow']['xs'] ) {
			$sticky_options['devices']['xs'] = true;
			$sticky_allow                    = true;
		}
	}

	$sticky_options                 = json_encode( $sticky_options );
	$sticky_options                 = "'" . $sticky_options . "'";
	$options['data-sticky-options'] = $sticky_options;
}

$css_classes = array(
	'vc_section',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
	$custom_class,
);

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if ( vc_shortcode_custom_css_has_property(
	$css,
	array(
		'border',
		'background',
	)
) || $video_bg || $parallax
) {
	$css_classes[] = 'vc_section-has-fill';
}


$wrapper_attributes = array();
// build attributes for wrapper
if ( $sticky_allow ) {
	$wrapper_attributes[] = 'data-sticky-options=' . $options['data-sticky-options'];
}
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row      = true;
	$css_classes[] = 'vc_section-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_section-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
	$parallax       = $video_bg_parallax;
	$parallax_speed = $parallax_speed_video;
	$parallax_image = $video_bg_url;
	$css_classes[]  = 'vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
	$css_classes[]        = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[]        = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}

if ( ! empty( $parallax_image ) ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $parallax_image;
	} else {
		$parallax_image_id  = preg_replace( '/[^\d]/', '', $parallax_image );
		$parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
		if ( ! empty( $parallax_image_src[0] ) ) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}

$css_class            = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );

$top_shape_divider = '';
$bottom_shape_divider = '';

if( ! empty( $atts['top_divider_type'] ) ) {
	$top_shape_divider .= '<div class="wpb-shape-divider wpb-shape-top">';
	if( 'custom' == $atts['top_divider_type'] ) {
		$top_shape_divider .= rawurldecode( base64_decode( $atts['top_divider_custom'] ) );
	} elseif ( ! empty( riode_get_shape_dividers()[ $atts['top_divider_type'] ]['path'] ) ) {
		$top_shape_divider .= file_get_contents( riode_get_shape_dividers()[ $atts['top_divider_type'] ]['path'] );
	}
	$top_shape_divider .= '</div>';

	$css_class .= ' has-shape-divider';
}
if( ! empty( $atts['bottom_divider_type'] ) ) {
	$bottom_shape_divider .= '<div class="wpb-shape-divider wpb-shape-bottom">';
	if( 'custom' == $atts['bottom_divider_type'] ) {
		$bottom_shape_divider .= rawurldecode( base64_decode( $atts['bottom_divider_custom'] ) );
	} elseif ( ! empty( riode_get_shape_dividers()[ $atts['bottom_divider_type'] ]['path'] ) ) {
		$bottom_shape_divider .= file_get_contents( riode_get_shape_dividers()[ $atts['bottom_divider_type'] ]['path'] );
	}
	$bottom_shape_divider .= '</div>';

	$css_class .= ' has-shape-divider';
}

$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<' . $section_tag . ' ' . implode( ' ', $wrapper_attributes ) . '>';

$output .= $top_shape_divider;

if ( 'none' !== $wrap_container ) {
	$output .= '<div class="' . esc_attr( $wrap_container ) . '">';
}
$output .= wpb_js_remove_wpautop( $content );
if ( 'none' !== $wrap_container ) {
	$output .= '</div>';
}

$output .= $bottom_shape_divider;

$output .= '</' . $section_tag . '>';
$output .= $after_output;

return $output;
