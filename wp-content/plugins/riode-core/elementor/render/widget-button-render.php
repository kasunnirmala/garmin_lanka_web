<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Button Widget Render
 *
 */

$settings = shortcode_atts(
	array(
		'label'                      => '',
		'button_expand'              => '',
		'button_type'                => '',
		'button_size'                => '',
		'button_skin'                => '',
		'button_gradient_skin'       => '',
		'shadow'                     => '',
		'button_border'              => '',
		'link_hover_type'            => '',
		'link'                       => '',
		'show_icon'                  => '',
		'show_label'                 => 'yes',
		'icon'                       => '',
		'icon_pos'                   => 'after',
		'icon_hover_effect'          => '',
		'icon_hover_effect_infinite' => '',
		'btn_class'                  => '',
		'show_icon'                  => '',
		'play_btn'                   => '',
		'video_btn'                  => '',
		'video_url'                  => array( 'url' => '#' ),
		'vtype'                      => 'youtube',
		'rel'                        => '',
		'builder'                    => 'elementor',
	),
	$settings
);

extract( $settings ); // @codingStandardsIgnoreLine

$class = 'btn';

if ( 'yes' == $settings['button_expand'] ) {
	$class .= ' btn-block';
}

if ( empty( $settings['label'] ) ) {
	$settings['label'] = esc_html__( 'Click here', 'riode-core' );
}

$label  = riode_widget_button_get_label( $settings, $this, $settings['label'] );
$class .= ' ' . implode( ' ', riode_widget_button_get_class( $settings ) );

global $riode_section;
if ( isset( $riode_section['video'] ) && isset( $settings['play_btn'] ) && 'yes' == $settings['play_btn'] ) {
	$riode_section['video_btn'] = true;
	$class                     .= ' btn-video elementor-custom-embed-image-overlay';
	$options                    = array();
	if ( isset( $riode_section['lightbox'] ) ) {
		$options = $riode_section['lightbox'];
	}
	echo '<div class="' . $class . '" role="button"' . ( $options ? ( ' data-elementor-open-lightbox="yes" data-elementor-lightbox="' . esc_attr( json_encode( $options ) ) . '"' ) : '' ) . '>' . riode_strip_script_tags( $label ) . '</div>';
} elseif ( 'yes' == $settings['video_btn'] ) {
	$class .= ' btn-video-iframe';
	printf( '<a class="' . esc_attr( $class ) . '" href="' . esc_attr( ! empty( $settings['video_url']['url'] ) ? $settings['video_url']['url'] : '#' ) . '" data-video-source="' . esc_attr( $settings['vtype'] ) . '">%1$s</a>', riode_strip_script_tags( $label ) );
} else {
	$link_attrs = '';
	$attrs = array();
	if ( 'wpb' == $builder ) {
		$attrs['href']    = ( isset( $link['url'] ) && $link['url'] ) ? $link['url'] : '#';
		$attrs['target'] = ( isset( $link['target'] ) && $link['target'] ) ? esc_attr( trim( $link['target'] ) ) : '';
		$attrs['title']  = ( isset( $link['title'] ) && $link['title'] ) ? esc_attr( $link['title'] ) : '';
		$attrs['rel']    = ( isset( $link['rel'] ) && $link['rel'] ) ? esc_attr( $rel ) . ' ' . esc_attr( $link['rel'] ) : esc_attr( $rel );
	} else {
		$attrs['href']    = ( isset( $link['url'] ) && $link['url'] ) ? $link['url'] : '#';
		$attrs['target'] = ( isset( $link['is_external'] ) && 'on' == $link['is_external'] ) ? '__blank' : '';
		$attrs['rel']    = ( isset( $link['nofollow'] ) && 'on' == $link['nofollow'] ) ? 'nofollow' : '';
		if ( ! empty( $link['custom_attributes'] ) ) {
			$temp = explode( ',', $link['custom_attributes'] );
			foreach ( $temp as $item ) {
				$key   = explode( '|', $item )[0];
				$value = explode( '|', $item )[1];
				if ( ! isset( $attrs[ $key ] ) ) {
					$attrs[ $key ] = $value;
				} else {
					$attrs[ $key ] .= ( ' ' . $value );
				}
			}
		}
	}
	$link_attrs = '';
	foreach ( $attrs as $key => $value ) {
		if ( ! empty( $value ) ) {
			$link_attrs .= ( $key . '="' . esc_attr( $value ) . '" ' );
		}
	}
	printf( '<a class="' . esc_attr( $class ) . '" ' . $link_attrs . '>%1$s</a>', riode_strip_script_tags( $label ) );
}
