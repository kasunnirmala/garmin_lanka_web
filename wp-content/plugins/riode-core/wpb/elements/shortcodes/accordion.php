<?php
/**
 * Accordion Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )     => array(
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Accordion Type', 'riode-core' ),
			'param_name'  => 'accordion_type',
			'description' => esc_html__( 'Choose the design style for accordion.', 'riode-core' ),
			'std'         => '',
			'value'       => array(
				''        => array(
					'title' => esc_html__( 'Default', 'riode-core' ),
				),
				'shadow'  => array(
					'title' => esc_html__( 'Shadow', 'riode-core' ),
				),
				'stacked' => array(
					'title' => esc_html__( 'Stacked', 'riode-core' ),
				),
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Card Space', 'riode-core' ),
			'param_name'  => 'accordion_card_space',
			'description' => esc_html__( 'Set the space between each card items.', 'riode-core' ),
			'units'       => array(
				'px',
				'rem',
				'em',
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .card:not(:last-child)' => 'margin-bottom: {{VALUE}}{{UNIT}}',
				'.elementor-element-{{ID}} .accordion-shadow .card' => 'margin-bottom: 0; border-bottom-width: {{VALUE}}{{UNIT}}',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => __( 'Card Background Color', 'riode-core' ),
			'description' => esc_html__( 'Set background color of card including card header and card body.', 'riode-core' ),
			'param_name'  => 'accordion_card_bg',
			'selectors'   => array(
				'{{WRAPPER}} .card' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Card Body Padding', 'riode-core' ),
			'param_name'  => 'accordion_content_pad',
			'description' => esc_html__( 'Set padding of card body content.', 'riode-core' ),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .card .card-body' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
	),
	esc_html__( 'Card Header', 'riode-core' ) => array(
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Toggle Icon', 'riode-core' ),
			'description' => esc_html__( 'Choose inactive(closed) toggle icon of card header.', 'riode-core' ),
			'param_name'  => 'accordion_icon',
			'std'         => 'd-icon-plus',
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Active Toggle Icon', 'riode-core' ),
			'description' => esc_html__( 'Choose active(opened) toggle icon of card header.', 'riode-core' ),
			'param_name'  => 'accordion_active_icon',
			'std'         => 'd-icon-minus',
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Toggle Icon Size', 'riode-core' ),
			'description' => esc_html__( 'Set size of card header toggle icon.', 'riode-core' ),
			'param_name'  => 'toggle_icon_size',
			'units'       => array(
				'px',
				'rem',
			),
			'selectors'   => array(
				'{{WRAPPER}} .toggle-icon' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_typography',
			'heading'     => esc_html__( 'Header Typography', 'riode-core' ),
			'description' => esc_html__( 'Set typography of card headers.', 'riode-core' ),
			'param_name'  => 'panel_header_typography',
			'selectors'   => array(
				'{{WRAPPER}} .card-header > a',
			),
		),
		array(
			'type'        => 'riode_color_group',
			'heading'     => esc_html__( 'Header Colors', 'riode-core' ),
			'description' => esc_html__( 'Set text color, background color and border color of normal and active card headers.', 'riode-core' ),
			'param_name'  => 'accordion_colors',
			'selectors'   => array(
				'normal' => '{{WRAPPER}} .card-header a',
				'active' => '{{WRAPPER}} .card-header a.collapse, {{WRAPPER}} .card-header a:hover',
			),
			'choices'     => array( 'color', 'background-color', 'border-color' ),
		),
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Header Padding', 'riode-core' ),
			'description' => esc_html__( 'Set padding of card headers.', 'riode-core' ),
			'param_name'  => 'accordion_header_pad',
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .card-header > a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				'{{WRAPPER}} .card-header .opened, {{WRAPPER}} .card-header .closed' => 'right: {{RIGHT}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Accordion', 'riode-core' ),
		'base'            => 'wpb_riode_accordion',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_accordion',
		'as_parent'       => array( 'only' => 'wpb_riode_accordion_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Collapsible content panels', 'riode-core' ),
		'default_content' => vc_is_inline() ? '[wpb_riode_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_riode_accordion_item][wpb_riode_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_riode_accordion_item][wpb_riode_accordion_item][vc_column_text]Add anything to this accordion card item[/vc_column_text][/wpb_riode_accordion_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Accordion extends WPBakeryShortCodesContainer {
	}
}
