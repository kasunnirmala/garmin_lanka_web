<?php
/**
 * Banner Layer Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Origin', 'riode-core' ),
			'description' => esc_html__( 'Set base point of banner content to determine content position.', 'riode-core' ),
			'param_name'  => 'banner_origin',
			'value'       => array(
				esc_html__( 'Default', 'riode-core' ) => 't-none',
				esc_html__( 'Vertical Center', 'riode-core' ) => 't-m',
				esc_html__( 'Horizontal Center', 'riode-core' ) => 't-c',
				esc_html__( 'Center', 'riode-core' )  => 't-mc',
			),
			'std'         => 't-mc',
		),
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Position', 'riode-core' ),
			'description' => esc_html__( 'Set Left/Top/Right/Bottom position of banner content.', 'riode-core' ),
			'param_name'  => 'layer_pos',
			'std'         => '{"top":{"xl":"50%","xs":"","sm":"","md":"","lg":""},"right":{"xs":"","sm":"","md":"","lg":"","xl":""},"bottom":{"xs":"","sm":"","md":"","lg":"","xl":""},"left":{"xs":"","sm":"","md":"","lg":"","xl":"50%"}}',
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}}' => 'top: {{TOP}};right: {{RIGHT}};bottom: {{BOTTOM}};left: {{LEFT}};',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Alignment', 'riode-core' ),
			'description' => esc_html__( 'Set global alignment of banner content items.', 'riode-core' ),
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
			'std'         => 'left',
			'selectors'   => array(
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Width', 'riode-core' ),
			'description' => esc_html__( 'Changes banner content width.', 'riode-core' ),
			'param_name'  => 'layer_width',
			'responsive'  => true,
			'value'       => '',
			'units'       => array(
				'px',
				'%',
			),
			'selectors'   => array(
				'{{WRAPPER}}.banner-content' => 'max-width: {{VALUE}}{{UNIT}}; width: 100%;',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Height', 'riode-core' ),
			'description' => esc_html__( 'Changes banner content height.', 'riode-core' ),
			'param_name'  => 'layer_height',
			'responsive'  => true,
			'value'       => '',
			'units'       => array(
				'px',
				'%',
			),
			'selectors'   => array(
				'{{WRAPPER}}'                       => 'height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .banner-content-inner' => 'height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Padding', 'riode-core' ),
			'description' => esc_html__( 'Controls padding of banner content.', 'riode-core' ),
			'param_name'  => 'layer_padding',
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}}' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Background Color', 'riode-core' ),
			'description' => esc_html__( 'Set background color of banner content.', 'riode-core' ),
			'param_name'  => 'layer_bgcolor',
			'selectors'   => array(
				'{{WRAPPER}}' => 'background-color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Banner Layer', 'riode-core' ),
		'base'                    => 'wpb_riode_banner_layer',
		'icon'                    => 'riode-logo-icon',
		'class'                   => 'wpb_riode_banner_layer',
		'controls'                => 'full',
		'category'                => esc_html__( 'Riode', 'riode-core' ),
		'description'             => esc_html__( 'Banner layer can be placed anywhere', 'riode-core' ),
		'as_child'                => array( 'only' => 'wpb_riode_banner, wpb_riode_products_banner_item' ),
		'as_parent'               => array( 'except' => 'wpb_riode_banner, wpb_riode_banner_layer' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Banner_Layer extends WPBakeryShortCodesContainer {

	}
}
