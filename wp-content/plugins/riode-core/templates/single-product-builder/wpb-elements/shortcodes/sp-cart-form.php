<?php
/**
 * Riode Single Product Cart Form
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )      => array(
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Sticky', 'riode-core' ),
			'param_name' => 'sp_sticky',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'yes',
		),
	),
	esc_html__( 'Variations', 'riode-core' )   => array(
		array(
			'type'       => 'riode_heading',
			'label'    => esc_html__( 'Label', 'riode-core' ),
			'param_name' => 'sp_variations_label_style_heading',
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'riode-core' ),
			'param_name' => 'sp_variations_label_color',
			'selectors'  => array(
				'{{WRAPPER}} .cart label' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'sp_variations_label_typo',
			'selectors'  => array(
				'{{WRAPPER}} .cart label',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Width', 'riode-core' ),
			'param_name' => 'sp_variations_label_width',
			'units'      => array(
				'px',
				'%',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .cart .label' => 'min-width: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'    => esc_html__( 'Variation Swatches', 'riode-core' ),
			'param_name' => 'sp_variations_list_style_heading',
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Swatch Size', 'riode-core' ),
			'param_name' => 'sp_variations_list_size',
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-variations button' => 'min-width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .list-type' => 'line-height: {{VALUE}}{{UNIT}};'
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
			'param_name' => 'sp_variations_list_br',
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-variations button' => 'border-radius: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'    => esc_html__( 'Variation Dropdowns', 'riode-core' ),
			'param_name' => 'sp_variations_dropdown_style_heading',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'sp_variations_select_typo',
			'selectors'  => array(
				'{{WRAPPER}} .cart select',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
			'param_name' => 'sp_variations_dropdown_br',
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .cart select' => 'border-radius: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Width', 'riode-core' ),
			'param_name' => 'sp_variations_dropdown_width',
			'units'      => array(
				'px',
				'%',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .cart select' => 'width: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Height', 'riode-core' ),
			'param_name' => 'sp_variations_dropdown_height',
			'units'      => array(
				'px',
				'%',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .cart select' => 'height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .select-type' => 'line-height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'    => esc_html__( 'Divider Style', 'riode-core' ),
			'param_name' => 'sp_variations_divider_style_heading',
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Divider Color', 'riode-core' ),
			'param_name' => 'sp_varitions_divider_color',
			'selectors'  => array(
				'{{WRAPPER}} .product-divider' => 'border-top-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Divider Spacing', 'riode-core' ),
			'param_name' => 'sp_varitions_divider_spacing',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .product-divider' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
			),
		),
	),
	esc_html__( 'Quantity Form', 'riode-core' ) => array(
		array(
			'type'       => 'riode_heading',
			'label'    => esc_html__( 'QTY Form Style', 'riode-core' ),
			'param_name' => 'sp_qty_form_style_heading',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'sp_qty_typo',
			'selectors'  => array(
				'{{WRAPPER}} .quantity .qty,{{WRAPPER}} .quantity button',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Width', 'riode-core' ),
			'param_name' => 'sq_qty_width',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'responsive' => true,
			'selectors' => array(
				'{{WRAPPER}} .quantity .qty' => 'width: calc(48px * {{VALUE}} / 100);',
				'{{WRAPPER}} .quantity button' => 'padding: 8px calc(8px * {{VALUE}} / 100);',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Height', 'riode-core' ),
			'param_name' => 'sq_qty_height',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'responsive' => true,
			'selectors' => array(
				'{{WRAPPER}} .quantity' => 'height: {{VALUE}}{{UNIT}}',
				'{{WRAPPER}} .button' => 'height: {{VALUE}}{{UNIT}}',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
			'param_name' => 'sq_qty_br',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'responsive' => true,
			'selectors' => array(
				'{{WRAPPER}} .quantity .quantity-minus' => 'border-radius: {{VALUE}}{{UNIT}} 0 0 {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .quantity .quantity-plus' => 'border-radius: 0 {{VALUE}}{{UNIT}} {{VALUE}}{{UNIT}} 0;',
				'{{WRAPPER}} .button' => 'border-radius: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Spacing', 'riode-core' ),
			'param_name' => 'sp_qty_space',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'responsive' => true,
			'selectors'  => array(
				'body:not(.rtl) {{WRAPPER}} .quantity' => "margin-right: {{VALUE}}{{UNIT}};",
				'body.rtl {{WRAPPER}} .quantity' => "margin-left: {{VALUE}}{{UNIT}};",
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'    => esc_html__( 'Add to Cart Style', 'riode-core' ),
			'param_name' => 'sp_cart_style_heading',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'sp_btn_typo',
			'selectors'  => array(
				'{{WRAPPER}} .cart .button',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Width', 'riode-core' ),
			'param_name' => 'sq_btn_width',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'responsive' => true,
			'selectors' => array(
				'{{WRAPPER}} .button' => 'padding: 0; width: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Colors', 'riode-core' ),
			'param_name' => 'sp_btn_colors',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .cart .button',
				'hover'  => '{{WRAPPER}} .cart .button:hover',
				'active' => '{{WRAPPER}} .cart .button:active',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Cart Form', 'riode-core' ),
		'base'            => 'wpb_riode_sp_cart_form',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_cart_form',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Cart form in single product.', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Cart_Form extends WPBakeryShortCode {

	}
}
