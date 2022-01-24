<?php
/**
 * Riode Single Product Meta
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Style', 'riode-core' ) => array(
		esc_html__( 'General', 'riode-core' ) => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Meta Direction', 'riode-core' ),
				'param_name' => 'sp_type',
				'value'      => array(
					esc_html__( 'Horizontal', 'riode-core' ) => 'inline-block',
					esc_html__( 'Vertical', 'riode-core' ) => 'block',
				),
				'std'        => '',
				'selectors'  => array(
					'{{WRAPPER}} .product_meta > *' => 'display: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Alignment', 'riode-core' ),
				'param_name' => 'sp_align',
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
					'{{WRAPPER}} .product_meta' => 'text-align: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Divider', 'riode-core' ) => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Divider', 'riode-core' ),
				'param_name' => 'divider',
				'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'selectors'  => array(
					'{{WRAPPER}} .product_meta>:not(:last-child):after' => 'content: "";',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'riode-core' ),
				'param_name' => 'divider_style',
				'value'      => array(
					esc_html__( 'Solid', 'riode-core' )  => 'solid',
					esc_html__( 'Double', 'riode-core' ) => 'double',
					esc_html__( 'Dotted', 'riode-core' ) => 'dotted',
					esc_html__( 'Dashed', 'riode-core' ) => 'dashed',
				),
				'std'        => '',
				'selectors'  => array(
					'{{WRAPPER}} .product_meta>:not(:last-child):after' => 'border-style: {{VALUE}}; border-width: 0;',
				),
				'dependency' => array(
					'element' => 'divider',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Width', 'riode-core' ),
				'param_name' => 'divider_weight_v',
				'units'      => array(
					'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .product_meta>:not(:last-child):after' => 'display: block; border-top-width: {{VALUE}}{{UNIT}}; margin-bottom: calc(-{{VALUE}}{{UNIT}}/2);',
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'block',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Width', 'riode-core' ),
				'param_name' => 'divider_weight',
				'units'      => array(
					'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .product_meta>:not(:last-child):after' => "border-{$left}-width: {{VALUE}}{{UNIT}}; margin-{$left}: 2rem;",
				),
				'dependency' => array(
					'element' => 'sp_type',
					'value'   => 'inline-block',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'param_name' => 'divider_color',
				'selectors'  => array(
					'{{WRAPPER}} .product_meta>:not(:last-child):after' => 'border-color: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'divider',
					'value'   => 'yes',
				),
			),
		),
		esc_html__( 'Text', 'riode-core' )    => array(
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'param_name' => 'sp_typo',
				'selectors'  => array(
					'{{WRAPPER}} .product_meta',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'param_name' => 'text_color',
				'selectors'  => array(
					'{{WRAPPER}} .product_meta' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Meta', 'riode-core' ),
		'base'            => 'wpb_riode_sp_meta',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_meta',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Meta information in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Meta extends WPBakeryShortCode {

	}
}
