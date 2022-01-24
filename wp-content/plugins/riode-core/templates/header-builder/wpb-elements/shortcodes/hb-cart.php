<?php
/**
 * Riode Header Cart
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )     => array(
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Cart Icon and Label Direction', 'riode-core' ),
			'param_name' => 'type',
			'std'        => 'inline',
			'value'      => array(
				'block'  => array(
					'title' => esc_html__( 'Block', 'riode-core' ),
				),
				'inline' => array(
					'title' => esc_html__( 'Inline', 'riode-core' ),
				),
			),
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Cart Icon Type', 'riode-core' ),
			'param_name' => 'icon_type',
			'std'        => 'badge',
			'value'      => array(
				''      => array(
					'title' => esc_html__( 'Default', 'riode-core' ),
				),
				'badge' => array(
					'title' => esc_html__( 'Badge', 'riode-core' ),
				),
				'label' => array(
					'title' => esc_html__( 'Label', 'riode-core' ),
				),
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Cart Icon', 'riode-core' ),
			'param_name' => 'icon',
			'dependency' => array(
				'element' => 'icon_type',
				'value'   => 'badge',
			),
			'std'        => 'd-icon-bag',
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Cart Label Direction', 'riode-core' ),
			'param_name' => 'label_type',
			'std'        => 'block',
			'value'      => array(
				'block'  => array(
					'title' => esc_html__( 'Block', 'riode-core' ),
					'icon'  => 'd-icon-arrow-down',
				),
				'inline' => array(
					'title' => esc_html__( 'Inline', 'riode-core' ),
					'icon'  => 'd-icon-arrow-right',
				),
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Label', 'riode-core' ),
			'param_name' => 'show_label',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Cart Label', 'riode-core' ),
			'param_name' => 'label',
			'std'        => esc_html__( 'Shopping Cart', 'riode-core' ),
			'dependency' => array(
				'element' => 'show_label',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Delimiter', 'riode-core' ),
			'param_name' => 'delimiter',
			'std'        => '',
			'dependency' => array(
				'element' => 'show_label',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Cart Total Price', 'riode-core' ),
			'param_name' => 'show_price',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Cart Count Prefix', 'riode-core' ),
			'param_name' => 'count_pfx',
			'std'        => '(',
			'dependency' => array(
				'element' => 'icon_type',
				'value'   => 'label',
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Cart Count Suffix', 'riode-core' ),
			'param_name' => 'count_sfx',
			'std'        => ' items )',
			'dependency' => array(
				'element' => 'icon_type',
				'value'   => 'label',
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Off Canvas', 'riode-core' ),
			'param_name' => 'cart_off_canvas',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'yes',
		),
	),
	esc_html__( 'Cart Style', 'riode-core' )  => array(
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'Cart Style', 'riode-core' ),
			'param_name' => 'cart_style_title',
			'tag'        => 'h3',
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Cart Padding', 'riode-core' ),
			'param_name' => 'cart_padding',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .cart-toggle' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Cart Colors', 'riode-core' ),
			'param_name' => 'cart_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .cart-toggle',
				'hover'  => '{{WRAPPER}} .cart-dropdown:hover .cart-toggle',
			),
			'choices'    => array( 'color' ),
		),
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'Cart Label', 'riode-core' ),
			'param_name' => 'cart_label_style_title',
			'tag'        => 'h3',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Cart Typography', 'riode-core' ),
			'param_name' => 'cart_typography',
			'selectors'  => array(
				'{{WRAPPER}} .cart-toggle, {{WRAPPER}} .cart-count',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Delimiter Space', 'riode-core' ),
			'param_name' => 'cart_delimiter_space',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .cart-name-delimiter' => 'margin: 0 {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'Cart Price', 'riode-core' ),
			'param_name' => 'cart_price_style_title',
			'tag'        => 'h3',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Price Typography', 'riode-core' ),
			'param_name' => 'cart_price_typography',
			'selectors'  => array(
				'{{WRAPPER}} .cart-price',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Price Margin', 'riode-core' ),
			'param_name' => 'cart_price_margin',
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .cart-price' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'Cart Icon', 'riode-core' ),
			'param_name' => 'cart_icon_style_title',
			'tag'        => 'h3',
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'cart_icon_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .cart-dropdown .cart-toggle i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Space', 'riode-core' ),
			'param_name' => 'cart_icon_space',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .block-type .cart-label + i'  => 'margin-bottom: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .inline-type .cart-label + i' => "margin-{$left}: {{VALUE}}{{UNIT}};",
			),
		),
		array(
			'type'        => 'riode_heading',
			'label'       => esc_html__( 'Cart Count and Icon', 'riode-core' ),
			'param_name'  => 'cart_count_icon_title',
			'description' => esc_html__( 'These options are avaiable only in default cart icon type.', 'riode-core' ),
			'tag'         => 'h3',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'cart_count_typography',
			'selectors'  => array(
				'{{WRAPPER}} .cart-count',
			),
		),
		array(
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Count Color', 'riode-core' ),
			'param_name' => 'count_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .minicart-icon .cart-count',
				'hover'  => '{{WRAPPER}} .cart-dropdown:hover .minicart-icon .cart-count',
			),
			'choices'    => array( 'color' ),
		),
		array(
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Icon Color', 'riode-core' ),
			'param_name' => 'icon_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .minicart-icon',
				'hover'  => '{{WRAPPER}} .cart-dropdown:hover .minicart-icon',
			),
			'choices'    => array( 'background-color', 'border-color' ),
		),
	),
	esc_html__( 'Badge Style', 'riode-core' ) => array(
		array(
			'type'        => 'riode_heading',
			'label'       => esc_html__( 'Badge Style.', 'riode-core' ),
			'description' => esc_html__( 'These options are avaiable only in badge icon type.', 'riode-core' ),
			'param_name'  => 'cart_badge_style_description',
			'tag'         => 'h3',
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Badge Size', 'riode-core' ),
			'param_name' => 'badge_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .badge-type .cart-count' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Horizontal Position', 'riode-core' ),
			'param_name' => 'badge_h_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .badge-type .cart-count' => "{$left}: {{VALUE}}{{UNIT}};",
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Vertical Position', 'riode-core' ),
			'param_name' => 'badge_v_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .badge-type .cart-count' => 'top: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Count Background Color', 'riode-core' ),
			'param_name' => 'badge_count_bg_color',
			'selectors'  => array(
				'{{WRAPPER}} .badge-type .cart-count' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Count Color', 'riode-core' ),
			'param_name' => 'badge_count_bd_color',
			'selectors'  => array(
				'{{WRAPPER}} .badge-type .cart-count' => 'color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Header Cart Form', 'riode-core' ),
		'base'            => 'wpb_riode_hb_cart',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_hb_cart',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Header', 'riode-core' ),
		'description'     => esc_html__( 'Mini cart of dropdown, offcanvas type', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_HB_Cart extends WPBakeryShortCode {
	}
}
