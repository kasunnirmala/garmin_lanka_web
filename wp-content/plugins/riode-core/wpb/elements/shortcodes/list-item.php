<?php
/**
 * Banner Layer Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'riode-core' ),
			'description' => esc_html__( 'Choose the icon for your list item.', 'riode-core' ),
			'param_name'  => 'icon',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'riode-core' ),
			'description' => esc_html__( 'Type the list text for your list item.', 'riode-core' ),
			'param_name'  => 'title',
			'value'       => 'Free Shipping & Return',
			'admin_label' => true,
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Link Url', 'riode-core' ),
			'description' => esc_html__( 'Type a certain URL for your list item.', 'riode-core' ),
			'param_name'  => 'link',
			'value'       => '',
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		esc_html__( 'Icon', 'riode-core' )    => array(
			array(
				'type'       => 'riode_heading',
				'label'      => esc_html__( 'In this section, you can control icon but now iconpicker is empty.', 'riode-core' ),
				'param_name' => 'icon_heading',
				'tag'        => 'p',
				'class'      => 'riode-heading-control-class',
			),
			array(
				'type'        => 'riode_dimension',
				'param_name'  => 'icon_border',
				'heading'     => esc_html__( 'Border', 'riode-core' ),
				'description' => esc_html__( 'Controls the icon border width.', 'riode-core' ),
				'responsive'  => false,
				'selectors'   => array(
					'{{WRAPPER}} .list-item-icon' => 'border-top:{{TOP}} solid;border-right:{{RIGHT}} solid;border-bottom:{{BOTTOM}} solid;border-left:{{LEFT}} solid;',
				),
				'dependency'  => array(
					'element'   => 'icon',
					'not_empty' => true,
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Border Radius', 'riode-core' ),
				'description' => esc_html__( 'Controls the icon border radius.', 'riode-core' ),
				'param_name'  => 'br_radius',
				'responsive'  => false,
				'units'       => array(
					'px',
					'%',
				),
				'selectors'   => array(
					'{{WRAPPER}} .list-item-icon' => 'border-radius: {{VALUE}}{{UNIT}};',
				),
				'dependency'  => array(
					'element'   => 'icon',
					'not_empty' => true,
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Background Size', 'riode-core' ),
				'description' => esc_html__( 'Controls the icon background size.', 'riode-core' ),
				'param_name'  => 'bg_size',
				'responsive'  => false,
				'units'       => array(
					'px',
				),
				'selectors'   => array(
					'{{WRAPPER}} .list-item-icon' => 'width: {{VALUE}}{{UNIT}};height: {{VALUE}}{{UNIT}};display:inline-flex;align-items:center;justify-content:center;',
				),
				'dependency'  => array(
					'element'   => 'icon',
					'not_empty' => true,
				),
			),
			array(
				'type'        => 'riode_color_group',
				'heading'     => esc_html__( 'Icon Colors', 'riode-core' ),
				'description' => esc_html__( 'Controls the icon colors.', 'riode-core' ),
				'param_name'  => 'icon_color',
				'selectors'   => array(
					'normal' => '{{WRAPPER}} .list-item-icon, {{WRAPPER}} .list-item-icon a',
					'hover'  => '{{WRAPPER}} .list-item-icon:hover, .list-item-icon a:hover',
				),
				'choices'     => array( 'color', 'background-color', 'border-color' ),
				'dependency'  => array(
					'element'   => 'icon',
					'not_empty' => true,
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Icon Size', 'riode-core' ),
				'param_name'  => 'icon_size',
				'description' => esc_html__( 'Controls the icon size.', 'riode-core' ),
				'responsive'  => true,
				'units'       => array(
					'px',
				),
				'selectors'   => array(
					'{{WRAPPER}} .list-item-icon i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
				'dependency'  => array(
					'element'   => 'icon',
					'not_empty' => true,
				),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Margin', 'riode-core' ),
				'description' => esc_html__( 'Controls the margin of your list icon.', 'riode-core' ),
				'param_name'  => 'icon_margin',
				'selectors'   => array(
					'{{WRAPPER}} .list-item-icon' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Content', 'riode-core' ) => array(
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Title Typography', 'riode-core' ),
				'description' => esc_html__( 'Controls the list text typography.', 'riode-core' ),
				'param_name'  => 'title_font',
				'selectors'   => array(
					'{{WRAPPER}} .list-item-content',
				),
			),
			array(
				'type'        => 'riode_color_group',
				'heading'     => esc_html__( 'Colors', 'riode-core' ),
				'description' => esc_html__( 'Controls the list text colors.', 'riode-core' ),
				'param_name'  => 'title_color',
				'selectors'   => array(
					'normal' => '{{WRAPPER}} .list-item-content, {{WRAPPER}} .list-item-content a',
					'hover'  => '{{WRAPPER}} .list-item-content:hover, .list-item-content a:hover',
				),
				'choices'     => array( 'color', 'background-color' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Margin', 'riode-core' ),
				'description' => esc_html__( 'Controls the margin of your list text.', 'riode-core' ),
				'param_name'  => 'title_margin',
				'selectors'   => array(
					'{{WRAPPER}} .list-item-content' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'        => esc_html__( 'List Item', 'riode-core' ),
		'base'        => 'wpb_riode_list_item',
		'icon'        => 'riode-logo-icon',
		'class'       => 'wpb_riode_list_item',
		'controls'    => 'full',
		'category'    => esc_html__( 'Riode', 'riode-core' ),
		'description' => esc_html__( 'Individual item with icon and description', 'riode-core' ),
		'as_child'    => array( 'only' => 'wpb_riode_list' ),
		'params'      => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_List_Item extends WPBakeryShortCode {

	}
}
