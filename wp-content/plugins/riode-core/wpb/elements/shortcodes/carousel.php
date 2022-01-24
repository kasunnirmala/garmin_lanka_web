<?php
/**
 * Carousel Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )          => array(
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Columns', 'riode-core' ),
			'responsive'  => true,
			'param_name'  => 'col_cnt',
			'description' => esc_html__( 'Leave it blank to give default value', 'riode-core' ),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Column Spacing', 'riode-core' ),
			'param_name'  => 'col_sp',
			'value'       => array(
				'no' => array(
					'title' => esc_html__( 'NO', 'riode-core' ),
				),
				'xs' => array(
					'title' => esc_html__( 'XS', 'riode-core' ),
				),
				'sm' => array(
					'title' => esc_html__( 'S', 'riode-core' ),
				),
				'md' => array(
					'title' => esc_html__( 'M', 'riode-core' ),
				),
				'lg' => array(
					'title' => esc_html__( 'L', 'riode-core' ),
				),
			),
			'description' => esc_html__( 'Change gap size of carousel items.', 'riode-core' ),
			'std'         => 'md',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Vertical Align', 'riode-core' ),
			'param_name'  => 'slider_vertical_align',
			'value'       => array(
				'top'         => array(
					'title' => esc_html__( 'Top', 'riode-core' ),
				),
				'middle'      => array(
					'title' => esc_html__( 'Middle', 'riode-core' ),
				),
				'bottom'      => array(
					'title' => esc_html__( 'Bottom', 'riode-core' ),
				),
				'same-height' => array(
					'title' => esc_html__( 'Stretch', 'riode-core' ),
				),
			),
			'description' => esc_html__( 'Change vertical alignment of carousel items.', 'riode-core' ),
		),
	),
	esc_html__( 'Carousel Options', 'riode-core' ) => array(
		esc_html__( 'Options', 'riode-core' ) => array(
			'riode_wpb_slider_general_controls',
		),
		esc_html__( 'Nav', 'riode-core' )     => array(
			'riode_wpb_slider_nav_controls',
		),
		esc_html__( 'Dots', 'riode-core' )    => array(
			'riode_wpb_slider_dots_controls',
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params, 'wpb_riode_carousel' ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Carousel', 'riode-core' ),
		'base'            => 'wpb_riode_carousel',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_carousel',
		'as_parent'       => array( 'except' => 'wpb_riode_carousel' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Owl carousel box', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Carousel extends WPBakeryShortCodesContainer {
	}
}
