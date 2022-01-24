<?php
/**
 * Header V-Divider Button
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'riode-core' ),
			'param_name' => 'divider_color',
			'selectors'  => array(
				'{{WRAPPER}} .divider' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Height', 'riode-core' ),
			'param_name' => 'divider_height',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
				'vh',
			),
			'selectors'  => array(
				'{{WRAPPER}} .divider' => 'height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Width', 'riode-core' ),
			'param_name' => 'divider_width',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
				'vw',
			),
			'selectors'  => array(
				'{{WRAPPER}} .divider' => 'width: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Header V-Divider', 'riode-core' ),
		'base'            => 'wpb_riode_hb_v_divider',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_hb_v_divider',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Header', 'riode-core' ),
		'description'     => esc_html__( 'Vertical divider to distinguish items', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_HB_V_Divider extends WPBakeryShortCode {
	}
}
