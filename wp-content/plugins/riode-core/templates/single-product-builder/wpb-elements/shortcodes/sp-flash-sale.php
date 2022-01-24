<?php
/**
 * Riode Single Product Flash Sale
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Content', 'riode-core' ) => array(
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'riode-core' ),
			'param_name' => 'sp_icon',
			'std'        => 'd-icon-check',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Label', 'riode-core' ),
			'param_name' => 'sp_label',
			'std'        => 'Flash Deals',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Ends Label', 'riode-core' ),
			'param_name' => 'sp_ends_label',
			'std'        => 'Ends in:',
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'Countdown Box', 'riode-core' ),
			'param_name' => 'sp_box_style_heading',
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Padding', 'riode-core' ),
			'param_name' => 'sp_box_padding',
			'selectors'  => array(
				'{{WRAPPER}} .product-countdown-container' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'riode-core' ),
			'param_name' => 'sp_bg_color',
			'selectors'  => array(
				'{{WRAPPER}} .product-countdown-container' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'Label', 'riode-core' ),
			'param_name' => 'sp_label_style_heading',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'sp_label_typo',
			'selectors'  => array(
				'{{WRAPPER}} .product-sale-info',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'riode-core' ),
			'param_name' => 'sp_label_color',
			'selectors'  => array(
				'{{WRAPPER}} .product-sale-info' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'sp_icon_size',
			'units'      => array(
				'px',
				'%',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .product-sale-info i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Spacing', 'riode-core' ),
			'param_name' => 'sp_icon_space',
			'units'      => array(
				'px',
				'%',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .product-sale-info i' => 'margin-right: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'Countdown Style', 'riode-core' ),
			'param_name' => 'sp_countdown_style_heading',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'sp_ends_typo',
			'selectors'  => array(
				'{{WRAPPER}} .countdown-wrap',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'riode-core' ),
			'param_name' => 'sp_ends_color',
			'selectors'  => array(
				'{{WRAPPER}} .countdown-wrap' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'Divider Style', 'riode-core' ),
			'param_name' => 'sp_divider_style_heading',
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'riode-core' ),
			'param_name' => 'sp_divider_color',
			'selectors'  => array(
				'{{WRAPPER}} .product-sale-info::after' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Width', 'riode-core' ),
			'param_name' => 'sp_divider_width',
			'units'      => array(
				'px',
				'%',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .product-sale-info::after' => 'width: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Height', 'riode-core' ),
			'param_name' => 'sp_divider_height',
			'units'      => array(
				'px',
				'%',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .product-sale-info::after' => 'height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Spacing', 'riode-core' ),
			'param_name' => 'sp_divider_space',
			'units'      => array(
				'px',
				'%',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .product-sale-info::after' => 'margin-left: {{VALUE}}{{UNIT}}; margin-right: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Flash Sale', 'riode-core' ),
		'base'            => 'wpb_riode_sp_flash_sale',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_flash_sale',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Flash sale countdown in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Flash_Sale extends WPBakeryShortCode {

	}
}
