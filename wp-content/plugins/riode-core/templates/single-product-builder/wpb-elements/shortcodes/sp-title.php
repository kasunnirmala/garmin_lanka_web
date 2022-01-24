<?php
/**
 * Riode Single Product Title
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Content', 'riode-core' ) => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'HTML Tag', 'riode-core' ),
			'param_name' => 'html_tag',
			'value'      => array(
				'H1' => 'h1',
				'H2' => 'h2',
				'H3' => 'h3',
				'H4' => 'h4',
				'H5' => 'h5',
				'H6' => 'h6',
				'p'  => 'p',
			),
			'std'        => 'h2',
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Decoration Type', 'riode-core' ),
			'param_name' => 'decoration',
			'std'        => '',
			'value'      => array(
				''          => array(
					'title' => esc_html__( 'Simple', 'riode-core' ),
				),
				'cross'     => array(
					'title' => esc_html__( 'Cross', 'riode-core' ),
				),
				'underline' => array(
					'title' => esc_html__( 'Underline', 'riode-core' ),
				),
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Hide Active Underline?', 'riode-core' ),
			'param_name' => 'hide_underline',
			'value'      => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'decoration',
				'value'   => 'underline',
			),
			'selectors'  => array(
				'{{WRAPPER}} .title::after' => 'content: none',
			),
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Title Align', 'riode-core' ),
			'param_name' => 'title_align',
			'std'        => 'title-left',
			'value'      => array(
				'title-left'   => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'title-center' => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'title-right'  => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => 'title-left',
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Decoration Spacing', 'riode-core' ),
			'param_name' => 'decoration_spacing',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'em',
				'%',
			),
			'value'      => '',
			'selectors'  => array(
				'{{WRAPPER}} .title::before' => "margin-{$right}: {{VALUE}}{{UNIT}};",
				'{{WRAPPER}} .title::after'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
			),
			'dependency' => array(
				'element' => 'decoration',
				'value'   => 'cross',
			),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		esc_html__( 'Title', 'riode-core' )  => array(
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Title Spacing', 'riode-core' ),
				'param_name' => 'title_spacing',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .title' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Title Color', 'riode-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Title Typography', 'riode-core' ),
				'param_name' => 'title_typography',
				'selectors'  => array(
					'{{WRAPPER}} .title',
				),
			),
		),
		esc_html__( 'Border', 'riode-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Color', 'riode-core' ),
				'param_name' => 'border_color',
				'selectors'  => array(
					'{{WRAPPER}} .title-cross .title::before, {{WRAPPER}} .title-cross .title::after, {{WRAPPER}} .title-underline::after' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Active Color', 'riode-core' ),
				'param_name' => 'border_active_color',
				'selectors'  => array(
					'{{WRAPPER}} .title-underline .title::after' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Border Height', 'riode-core' ),
				'param_name' => 'border_height',
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .title-cross .title::before, {{WRAPPER}} .title-cross .title::after, {{WRAPPER}} .title-wrapper::after' => 'height: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Active Border Height', 'riode-core' ),
				'param_name' => 'active_border_height',
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .title-underline .title::after' => 'height: {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element' => 'decoration',
					'value'   => 'underline',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Title', 'riode-core' ),
		'base'            => 'wpb_riode_sp_title',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_title',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Product name in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Tilte extends WPBakeryShortCode {

	}
}
