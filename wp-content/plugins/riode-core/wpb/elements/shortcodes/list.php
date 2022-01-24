<?php
/**
 * List Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'checkbox',
			'param_name'  => 'enable_ordered',
			'heading'     => esc_html__( 'Enable Ordered List', 'riode-core' ),
			'description' => esc_html__( 'Toggle for making your list ordered or not. *Please remove icons before setting this option.', 'riode-core' ),
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'selectors'   => array(
				'{{WRAPPER}} .riode-list-item' => 'display: list-item;',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'List Style', 'riode-core' ),
			'description' => esc_html__( 'Select a certain list style for your ordered list.', 'riode-core' ),
			'param_name'  => 'list_style',
			'value'       => array(
				esc_html__( 'None', 'riode-core' )        => 'none',
				esc_html__( 'Circle', 'riode-core' )      => 'circle',
				esc_html__( 'Decimal', 'riode-core' )     => 'decimal',
				esc_html__( 'Decimal Leading Zero', 'riode-core' ) => 'decimal-leading-zero',
				esc_html__( 'Lower Alpha', 'riode-core' ) => 'lower-alpha',
				esc_html__( 'Upper Alpha', 'riode-core' ) => 'upper-alpha',
				esc_html__( 'Disc', 'riode-core' )        => 'disc',
				esc_html__( 'Square', 'riode-core' )      => 'square',
			),
			'std'         => 'none',
			'selectors'   => array(
				'{{WRAPPER}}' => 'list-style: {{VALUE}};',
			),
			'dependency'  => array(
				'element' => 'enable_ordered',
				'value'   => 'yes',
			),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		esc_html__( 'Marker', 'riode-core' ) => array(
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'marker_color',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the marker color.', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .riode-list-item::marker' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'marker_hover_color',
				'heading'     => esc_html__( 'Hover Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the marker hover color.', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .riode-list-item:hover::marker' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Typography', 'riode-core' ),
				'description' => esc_html__( 'Controls the marker typography.', 'riode-core' ),
				'param_name'  => 'marker_typo',
				'selectors'   => array(
					'{{WRAPPER}} .riode-list-item::marker',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'List', 'riode-core' ),
		'base'                    => 'wpb_riode_list',
		'icon'                    => 'riode-logo-icon',
		'class'                   => 'wpb_riode_list',
		'controls'                => 'full',
		'category'                => esc_html__( 'Riode', 'riode-core' ),
		'description'             => esc_html__( 'Lists several items', 'riode-core' ),
		'as_parent'               => array( 'only' => 'wpb_riode_list_item' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_List extends WPBakeryShortCodesContainer {

	}
}
