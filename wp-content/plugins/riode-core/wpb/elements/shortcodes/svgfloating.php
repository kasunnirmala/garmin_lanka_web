<?php
/**
 * Riode SVG Floating
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'textarea_raw_html',
			'heading'     => esc_html__( 'SVG HTML', 'riode-core' ),
			'param_name'  => 'float_svg',
			'placeholder' => esc_html__( 'Input SVG Html code here', 'riode-core' ),
			'description' => esc_html__( 'Only SVG with path elements will work. Please make sure SVG html has "viewBox" attribute.' ),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Offset', 'riode-core' ),
			'description' => esc_html__( 'Controls how much different SVG shape should be transformed.', 'riode-core' ),
			'param_name'  => 'delta',
			'std'         => '15',
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Speed', 'riode-core' ),
			'description' => esc_html__( 'Controls how fast SVG shape should be transformed.', 'riode-core' ),
			'param_name'  => 'speed',
			'std'         => '10',
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Size', 'riode-core' ),
			'description' => esc_html__( 'Controls size of SVG shape.', 'riode-core' ),
			'param_name'  => 'size',
			'std'         => '1',
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Rotate', 'riode-core' ),
			'description' => esc_html__( 'Controls how much SVG shape should be rotated.', 'riode-core' ),
			'param_name'  => 'rotate',
			'selectors'   => array(
				'{{WRAPPER}} svg' => 'transform: rotate({{VALUE}}deg);',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Opacity', 'riode-core' ),
			'description' => esc_html__( 'Controls transparency of SVG shape.', 'riode-core' ),
			'param_name'  => 'opacity',
			'selectors'   => array(
				'{{WRAPPER}} svg' => 'opacity: {{VALUE}};',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Fill Color', 'riode-core' ),
			'description' => esc_html__( 'Choose background color of SVG shape.', 'riode-core' ),
			'param_name'  => 'fill_color',
			'selectors'   => array(
				'{{WRAPPER}} svg' => 'fill: {{VALUE}};',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Stroke Color', 'riode-core' ),
			'description' => esc_html__( 'Choose border color of SVG shape.', 'riode-core' ),
			'param_name'  => 'stroke_color',
			'selectors'   => array(
				'{{WRAPPER}} svg' => 'stroke: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'SVG Floating', 'riode-core' ),
		'base'            => 'wpb_riode_svgfloating',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_svgfloating',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display SVG changing its shape', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_SVGFloating extends WPBakeryShortCode {
	}
}
