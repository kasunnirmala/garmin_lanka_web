<?php
/**
 * Header Currency Switcher Button
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Switcher Toggle', 'riode-core' ) => array(
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'toggle_typography',
			'selectors'  => array(
				'{{WRAPPER}} .switcher > li > a',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Padding', 'riode-core' ),
			'param_name' => 'toggle_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher > li > a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Width', 'riode-core' ),
			'param_name' => 'toggle_border',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher > li > a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}}; border-style: solid;',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
			'param_name' => 'toggle_border_radius',
			'selectors'  => array(
				'{{WRAPPER}} .switcher > li > a' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Colors', 'riode-core' ),
			'param_name' => 'toggle_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .switcher > li > a',
				'hover'  => '{{WRAPPER}} .menu > li:hover > a',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
	esc_html__( 'Dropdown Box', 'riode-core' )    => array(
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Padding', 'riode-core' ),
			'param_name' => 'dropdown_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Position', 'riode-core' ),
			'param_name' => 'dropdown_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'left: {{VALUE}}{{UNIT}}; right: auto;',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Border', 'riode-core' ),
			'param_name' => 'dropdown_border_style',
			'std'        => 'none',
			'value'      => array(
				esc_html__( 'None', 'riode-core' )   => 'none',
				esc_html__( 'Solid', 'riode-core' )  => 'solid',
				esc_html__( 'Double', 'riode-core' ) => 'double',
				esc_html__( 'Dotted', 'riode-core' ) => 'dotted',
				esc_html__( 'Dashed', 'riode-core' ) => 'dashed',
				esc_html__( 'Groove', 'riode-core' ) => 'groove',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'border-style: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Width', 'riode-core' ),
			'param_name' => 'dropdown_border_width',
			'dependency' => array(
				'element'            => 'dropdown_border_style',
				'value_not_equal_to' => 'none',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'riode-core' ),
			'param_name' => 'dropdown_border_color',
			'dependency' => array(
				'element'            => 'dropdown_border_style',
				'value_not_equal_to' => 'none',
			),
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'border-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'riode-core' ),
			'param_name' => 'dropdown_bg',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul' => 'background-color: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Currency Item', 'riode-core' )   => array(
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'item_typography',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Padding', 'riode-core' ),
			'param_name' => 'item_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Margin', 'riode-core' ),
			'param_name' => 'item_margin',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Width', 'riode-core' ),
			'param_name' => 'item_border',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}}; border-style: solid',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
			'param_name' => 'item_border_radius',
			'selectors'  => array(
				'{{WRAPPER}} .switcher ul a' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Colors', 'riode-core' ),
			'param_name' => 'item_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .switcher ul a',
				'hover'  => '{{WRAPPER}} .switcher ul > li:hover a',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Header Currency Switcher', 'riode-core' ),
		'base'            => 'wpb_riode_hb_currency_switcher',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_hb_currency_switcher',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Header', 'riode-core' ),
		'description'     => esc_html__( 'Currency switcher plugin item or menu', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_HB_Currency_Switcher extends WPBakeryShortCode {
	}
}
