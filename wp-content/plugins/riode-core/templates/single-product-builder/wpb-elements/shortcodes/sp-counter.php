<?php
/**
 * Riode Single Product Counter
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Content', 'riode-core' ) => array(
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Starting Number', 'riode-core' ),
			'param_name' => 'starting_number',
			'std'        => 0,
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Ending Number', 'riode-core' ),
			'param_name' => 'ending_number',
			'value'      => array(
				esc_html__( 'Sale Count', 'riode-core' ) => 'sale',
				esc_html__( 'Stock', 'riode-core' )      => 'stock',
			),
			'std'        => 'sale',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Fake Addition Number', 'riode-core' ),
			'param_name' => 'adding_number',
			'std'        => 0,
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Counter Prefix', 'riode-core' ),
			'param_name' => 'prefix',
			'std'        => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Counter Suffix', 'riode-core' ),
			'param_name' => 'suffix',
			'std'        => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Animation Duration (ms)', 'riode-core' ),
			'param_name' => 'duration',
			'std'        => 2000,
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Thousand Separator', 'riode-core' ),
			'param_name' => 'thousand_separator',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Separator', 'riode-core' ),
			'param_name' => 'thousand_separator_char',
			'value'      => array(
				esc_html__( 'Default', 'riode-core' ) => '',
				esc_html__( 'Dot', 'riode-core' )     => '.',
				esc_html__( 'Space', 'riode-core' )   => ' ',
			),
			'std'        => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'riode-core' ),
			'param_name' => 'title',
			'std'        => 'Sale Products',
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Alignment', 'riode-core' ),
			'param_name' => 'counter_align',
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
			'selectors'  => array(
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		esc_html__( 'Number', 'riode-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'param_name' => 'number_color',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-number-wrapper' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'param_name' => 'number_typo',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-number-wrapper',
				),
			),
		),
		esc_html__( 'Title', 'riode-core' )  => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'param_name' => 'title_typo',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-sp-counter-title',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Counter', 'riode-core' ),
		'base'            => 'wpb_riode_sp_counter',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_counter',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Counter of sale count and stock in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Counter extends WPBakeryShortCode {

	}
}
