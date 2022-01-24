<?php
/**
 * Riode Single Product Compare
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Compare', 'riode-core' ) => array(
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'compare_typo',
			'selectors'  => array(
				'{{WRAPPER}} .compare',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'compare_icon_size',
			'units'      => array(
				'px',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .compare::before' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Space', 'riode-core' ),
			'param_name' => 'compare_icon_space',
			'units'      => array(
				'px',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .compare::before' => "margin-{$right}: {{VALUE}}{{UNIT}};",
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Normal Color', 'riode-core' ),
			'param_name' => 'compare_color',
			'selectors'  => array(
				'{{WRAPPER}} .compare' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Hover Color', 'riode-core' ),
			'param_name' => 'compare_hover_color',
			'selectors'  => array(
				'{{WRAPPER}} .compare:hover' => 'color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Compare', 'riode-core' ),
		'base'            => 'wpb_riode_sp_compare',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_compare',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Compare item in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Compare extends WPBakeryShortCode {

	}
}
