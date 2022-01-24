<?php
/**
 * Riode Single Product Price
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Style', 'riode-core' ) => array(
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Alignment', 'riode-core' ),
			'param_name' => 'sp_price_align',
			'value'      => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} p.price' => 'text-align: {{VALUE}};',
			),
		),
		esc_html__( 'Color', 'riode-core' )      => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Normal', 'riode-core' ),
				'param_name' => 'normal_price_color',
				'selectors'  => array(
					'{{WRAPPER}} p.price' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'New', 'riode-core' ),
				'param_name' => 'new_price_color',
				'selectors'  => array(
					'{{WRAPPER}} ins' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Old', 'riode-core' ),
				'param_name' => 'old_price_color',
				'selectors'  => array(
					'{{WRAPPER}} del' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Typography', 'riode-core' ) => array(
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Normal', 'riode-core' ),
				'param_name' => 'normal_price_typography',
				'selectors'  => array(
					'{{WRAPPER}} p.price',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'New', 'riode-core' ),
				'param_name' => 'new_price_typography',
				'selectors'  => array(
					'{{WRAPPER}} p.price ins',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Old', 'riode-core' ),
				'param_name' => 'old_price_typography',
				'selectors'  => array(
					'{{WRAPPER}} p.price del',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Price', 'riode-core' ),
		'base'            => 'wpb_riode_sp_price',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_price',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Product price in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Price extends WPBakeryShortCode {

	}
}
