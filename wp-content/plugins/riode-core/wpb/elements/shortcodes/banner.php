<?php
/**
 * Banner Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )  => array(
		'riode_wpb_banner_general_controls',
	),
	esc_html__( 'Effect', 'riode-core' )   => array(
		'riode_wpb_banner_effect_controls',
	),
	esc_html__( 'Parallax', 'riode-core' ) => array(
		'riode_wpb_banner_parallax_controls',
	),
	esc_html__( 'Video', 'riode-core' )    => array(
		'riode_wpb_banner_video_controls',
	),

);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Banner', 'riode-core' ),
		'base'                    => 'wpb_riode_banner',
		'icon'                    => 'riode-logo-icon',
		'class'                   => 'riode_banner',
		'controls'                => 'full',
		'category'                => esc_html__( 'Riode', 'riode-core' ),
		'description'             => esc_html__( 'Create Riode banner with multi banner layers', 'riode-core' ),
		'as_parent'               => array( 'only' => 'wpb_riode_banner_layer' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Banner extends WPBakeryShortCodesContainer {

	}
}
