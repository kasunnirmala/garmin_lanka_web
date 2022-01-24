<?php
/**
 * Filter Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Filter Item Width', 'riode-core' ),
			'description' => esc_html__( 'Controls width of filter items', 'riode-core' ),
			'param_name'  => 'filter_width',
			'with_units'  => true,
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .riode-filter' => 'width: {{VALUE}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Filter Height', 'riode-core' ),
			'description' => esc_html__( 'Controls height of filter items', 'riode-core' ),
			'param_name'  => 'filter_height',
			'with_units'  => true,
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .btn-filter' => 'height: {{VALUE}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Filter Gap', 'riode-core' ),
			'description' => esc_html__( 'Controls space between filter items', 'riode-core' ),
			'param_name'  => 'filter_gap',
			'with_units'  => true,
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .align-left > *'   => 'margin-right: {{VALUE}};',
				'{{WRAPPER}} .align-center > *' => 'margin-left: calc( {{VALUE}} / 2 );',
				'{{WRAPPER}} .align-right > *'  => 'margin-left: {{VALUE}};',
			),
			'std'         => '{"xl":"10", "unit":"", "lg":"", "md":"", "sm":"", "xs":""}',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Alignment', 'riode-core' ),
			'description' => esc_html__( 'Controls alignment of the attribute filter items.', 'riode-core' ),
			'param_name'  => 'align',
			'value'       => array(
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
			'std'         => 'center',
		),
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Border Width', 'riode-core' ),
			'description' => esc_html__( 'Controls border width of filter items', 'riode-core' ),
			'param_name'  => 'filter_bd_width',
			'selectors'   => array(
				'{{WRAPPER}} .select-ul-toggle' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
			'dependency'  => array(
				'element'            => 'filter_bd_style',
				'value_not_equal_to' => 'none',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Border Color', 'riode-core' ),
			'description' => esc_html__( 'Controls border color of filter items', 'riode-core' ),
			'param_name'  => 'filter_bd_color',
			'selectors'   => array(
				'{{WRAPPER}} .select-ul-toggle' => 'border-color: {{VALUE}};',
			),
			'dependency'  => array(
				'element'            => 'filter_bd_style',
				'value_not_equal_to' => 'none',
			),
		),
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Border Radius', 'riode-core' ),
			'description' => esc_html__( 'Controls border radius of filter items', 'riode-core' ),
			'param_name'  => 'filter_bd_radius',
			'selectors'   => array(
				'{{WRAPPER}} .select-ul-toggle, {{WRAPPER}} .btn-filter' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Filter Button Label', 'riode-core' ),
			'description' => esc_html__( 'Input filter button’s label.', 'riode-core' ),
			'param_name'  => 'btn_label',
			'value'       => 'Filter',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Filter Button Skin', 'riode-core' ),
			'description' => esc_html__( 'Choose submit button’s skin.', 'riode-core' ),
			'param_name'  => 'btn_skin',
			'std'         => 'btn-primary',
			'value'       => array(
				'btn-primary'   => array(
					'title' => esc_html__( 'Primary', 'riode-core' ),
					'color' => 'var(--rio-primary-color,#27c)',
				),
				'btn-secondary' => array(
					'title' => esc_html__( 'Secondary', 'riode-core' ),
					'color' => 'var(--rio-secondary-color,#d26e4b)',
				),
				'btn-alert'     => array(
					'title' => esc_html__( 'Alert', 'riode-core' ),
					'color' => 'var(--rio-alert-color,#b10001)',
				),
				'btn-success'   => array(
					'title' => esc_html__( 'Success', 'riode-core' ),
					'color' => 'var(--rio-success-color,#a8c26e)',
				),
				'btn-dark'      => array(
					'title' => esc_html__( 'Dark', 'riode-core' ),
					'color' => 'var(--rio-dark-color,#222)',
				),
				'btn-white'     => array(
					'title' => esc_html__( 'white', 'riode-core' ),
					'color' => '#fff',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Product Attribute Filter', 'riode-core' ),
		'base'            => 'wpb_riode_filter',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_filter',
		'as_parent'       => array( 'only' => 'wpb_riode_filter_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Product Attribute Filter Group', 'riode-core' ),
		// 'default_content' => vc_is_inline() ? '[wpb_riode_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_riode_accordion_item][wpb_riode_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_riode_accordion_item][wpb_riode_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_riode_accordion_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Filter extends WPBakeryShortCodesContainer {
	}
}
