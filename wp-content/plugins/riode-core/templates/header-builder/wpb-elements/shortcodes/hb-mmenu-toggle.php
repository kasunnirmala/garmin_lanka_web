<?php
/**
 * Header Mobile Menu Toggle Button
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Toggle Icon', 'riode-core' ),
			'param_name' => 'icon',
			'std'        => 'd-icon-bars2',
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'icon_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Padding', 'riode-core' ),
			'param_name' => 'toggle_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Width', 'riode-core' ),
			'param_name' => 'toggle_border',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle' => 'border-top: {{TOP}} solid;border-right: {{RIGHT}} solid;border-bottom: {{BOTTOM}} solid;border-left: {{LEFT}} solid;',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
			'param_name' => 'toggle_border_radius',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .mobile-menu-toggle' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Colors', 'riode-core' ),
			'param_name' => 'toggle_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .mobile-menu-toggle',
				'hover'  => '{{WRAPPER}} .mobile-menu-toggle:hover',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Header Mobile Menu Toggle', 'riode-core' ),
		'base'            => 'wpb_riode_hb_mmenu_toggle',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_hb_mmenu_toggle',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Header', 'riode-core' ),
		'description'     => esc_html__( 'Toggle to open/close mobile menu', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_HB_Mmenu_Toggle extends WPBakeryShortCode {
	}
}
