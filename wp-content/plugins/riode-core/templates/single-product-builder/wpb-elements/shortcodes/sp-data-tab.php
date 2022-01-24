<?php
/**
 * Riode Single Product Tab Data
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Type', 'riode-core' ),
			'param_name' => 'sp_type',
			'value'      => array(
				esc_html__( 'Theme Option', 'riode-core' ) => '',
				esc_html__( 'Tab', 'riode-core' )          => 'tab',
				esc_html__( 'Accordion', 'riode-core' )    => 'accordion',
			),
			'std'        => '',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Nav Typography', 'riode-core' ),
			'param_name' => 'sp_tab_link_typo',
			'selectors'  => array(
				'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a',
			),
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Nav Alignment', 'riode-core' ),
			'param_name' => 'sp_tab_link_align',
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
			'std' => 'center',
			'dependency' => array(
				'element' => 'sp_type',
				'value'   => array( '', 'tab' ),
			),
			'selectors'  => array(
				'{{WRAPPER}} .wc-tabs > .tabs' => 'justify-content: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Nav Padding', 'riode-core' ),
			'param_name' => 'sp_tab_link_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Content Padding', 'riode-core' ),
			'param_name' => 'sp_tab_link_content_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .panel.woocommerce-Tabs-panel' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Nav Colors', 'riode-core' ),
			'param_name' => 'sp_tab_link_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .wc-tabs>.tabs .nav-link, {{WRAPPER}} .card-header a',
				'hover'  => '{{WRAPPER}} .wc-tabs>.tabs .nav-link:hover, {{WRAPPER}} .card-header a:hover',
				'active' => '{{WRAPPER}} .wc-tabs>.tabs .nav-link.active, {{WRAPPER}} .card-header .collapse',
			),
			'choices'    => array( 'color', 'background-color' ),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Data Tab', 'riode-core' ),
		'base'            => 'wpb_riode_sp_data_tab',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_data_tab',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Data tab in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Data_Tab extends WPBakeryShortCode {

	}
}
