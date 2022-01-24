<?php
/**
 * Tab Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )           => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Tab Type', 'riode-core' ),
			'description' => esc_html__( 'Choose from 6 tab types. Choose from Default, Stacked, Border, Simple, Outline, Inverse.', 'riode-core' ),
			'param_name'  => 'tab_h_type',
			'value'       => array(
				esc_html__( 'Default', 'riode-core' ) => '',
				esc_html__( 'Stacked', 'riode-core' ) => 'stacked',
				esc_html__( 'Border', 'riode-core' )  => 'border',
				esc_html__( 'Simple', 'riode-core' )  => 'simple',
				esc_html__( 'Outline', 'riode-core' ) => 'outline',
				esc_html__( 'Inverse', 'riode-core' ) => 'inverse',
			),
			'std'         => '',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Tab Layout', 'riode-core' ),
			'param_name'  => 'tab_type',
			'description' => esc_html__( 'Determine whether to arrange tab navs horizontally or vertically.', 'riode-core' ),
			'std'         => '',
			'value'       => array(
				''         => array(
					'title' => esc_html__( 'Horizontal', 'riode-core' ),
				),
				'vertical' => array(
					'title' => esc_html__( 'Vertical', 'riode-core' ),
				),
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Vertical Nav Width', 'riode-core' ),
			'description' => esc_html__( 'Controls nav width of vertical tab.', 'riode-core' ),
			'param_name'  => 'tab_nav_width',
			'units'       => array(
				'px',
				'rem',
				'vw',
				'%',
			),
			'dependency'  => array(
				'element' => 'tab_type',
				'value'   => 'vertical',
			),
			'selectors'   => array(
				'{{WRAPPER}} .tab-vertical .nav'         => 'width: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .tab-vertical .tab-content' => 'width: calc( 100% - {{VALUE}}{{UNIT}} );',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Justify Tabs', 'riode-core' ),
			'description' => esc_html__( 'Set to make tab navs have 100% full width.', 'riode-core' ),
			'param_name'  => 'tab_justify',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element'            => 'tab_type',
				'value_not_equal_to' => 'vertical',
			),
			'selectors'   => array(
				'{{WRAPPER}} .tab .nav-item' => 'flex: 1;',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Active Border Width', 'riode-core' ),
			'description' => esc_html__( 'Controls underline width of active nav in Default type tab.', 'riode-core' ),
			'param_name'  => 'tab_default_bd_width',
			'units'       => array(
				'px',
				'%',
			),
			'dependency'  => array(
				'element'            => 'tab_type',
				'value_not_equal_to' => 'vertical',
			),
			'selectors'   => array(
				'{{WRAPPER}} .nav-link::after' => 'width: {{VALUE}}{{UNIT}}; max-width: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Active Border Height', 'riode-core' ),
			'description' => esc_html__( 'Controls underline height of active nav in Default type tab.', 'riode-core' ),
			'param_name'  => 'tab_default_bd_height',
			'units'       => array(
				'px',
				'%',
			),
			'dependency'  => array(
				'element'            => 'tab_type',
				'value_not_equal_to' => 'vertical',
			),
			'selectors'   => array(
				'{{WRAPPER}} .nav-link::after' => 'height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Tab Navs Position', 'riode-core' ),
			'param_name'  => 'tab_navs_pos',
			'description' => esc_html__( 'Controls alignment of tab navs. Choose from Start, Middle, End.', 'riode-core' ),
			'value'       => array(
				'left'   => array(
					'title' => esc_html__( 'Start', 'riode-core' ),
				),
				'center' => array(
					'title' => esc_html__( 'Middle', 'riode-core' ),
				),
				'right'  => array(
					'title' => esc_html__( 'End', 'riode-core' ),
				),
			),
			'std'         => 'left',
		),
	),
	esc_html__( 'Tab Nav Style', 'riode-core' )     => array(
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Tab Nav Padding', 'riode-core' ),
			'param_name'  => 'nav_padding',
			'description' => esc_html__( 'Controls padding of tab navs.', 'riode-core' ),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .nav .nav-link' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Nav Item Spacing', 'riode-core' ),
			'description' => esc_html__( 'Controls space between tab navs.', 'riode-core' ),
			'param_name'  => 'nav_space',
			'responsive'  => true,
			'units'       => array(
				'px',
				'rem',
				'vw',
				'%',
			),
			'selectors'   => array(
				'{{WRAPPER}} .tab-nav-left > ul > li:not(.last-child)' => 'margin-right: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .tab>ul>li:not(:last-child)' => 'margin-right: {{VALUE}}{{UNIT}};',
				'.wpb-wrapper {{WRAPPER}} .tab-nav-center>ul>li' => 'margin-left: calc( {{VALUE}}{{UNIT}} / 2 ); margin-right: calc( {{VALUE}}{{UNIT}} / 2 );',
				'{{WRAPPER}} .tab-nav-right>ul>li:not(:first-child)' => 'margin-left: {{VALUE}}{{UNIT}}; margin-right: 0;',
				'{{WRAPPER}} .tab-nav-right>ul>li:first-child' => 'margin-right: 0;',
				'{{WRAPPER}} .tab-vertical>ul>li:not(:last-child)' => 'margin-bottom: {{VALUE}}{{UNIT}}; margin-right: 0;',
			),
		),
		array(
			'type'        => 'riode_typography',
			'heading'     => esc_html__( 'Nav Item Typography', 'riode-core' ),
			'param_name'  => 'tab_nav_typography',
			'description' => esc_html__( 'Choose font family, weight, size, text transform, line height and letter spacing of tab navs.', 'riode-core' ),
			'selectors'   => array(
				'{{WRAPPER}} .nav .nav-link',
			),
		),
		array(
			'type'        => 'riode_color_group',
			'heading'     => esc_html__( 'Nav Item Colors', 'riode-core' ),
			'param_name'  => 'tab_nav_colors',
			'description' => esc_html__( 'Choose text color, background color and border color of tab navs on normal and active status.', 'riode-core' ),
			'selectors'   => array(
				'normal' => '{{WRAPPER}} .nav .nav-link',
				'active' => '{{WRAPPER}} .nav .nav-link.active, {{WRAPPER}} .nav .nav-link:hover',
			),
			'choices'     => array( 'color', 'background-color', 'border-color' ),
		),
	),
	esc_html__( 'Tab Content Style', 'riode-core' ) => array(
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Tab Content Padding', 'riode-core' ),
			'description' => esc_html__( 'Control global padding of tab content.', 'riode-core' ),
			'param_name'  => 'tab_padding',
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .tab-content .tab-pane' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => __( 'Tab Background Color', 'riode-core' ),
			'param_name'  => 'tab_bg_color',
			'description' => esc_html__( 'Choose background color of tab content.', 'riode-core' ),
			'selectors'   => array(
				'{{WRAPPER}} .tab-content .tab-pane' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => __( 'Tab Border Color', 'riode-core' ),
			'param_name'  => 'tab_bd_color',
			'description' => esc_html__( 'Choose border color of tab content.', 'riode-core' ),
			'selectors'   => array(
				'{{WRAPPER}} .tab-content .tab-pane' => 'border-color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Tab', 'riode-core' ),
		'base'            => 'wpb_riode_tab',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_tab',
		'as_parent'       => array( 'only' => 'wpb_riode_tab_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Riode tabbed content', 'riode-core' ),
		'default_content' => vc_is_inline() ? '[wpb_riode_tab_item tab_title="Tab 1"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_riode_tab_item][wpb_riode_tab_item tab_title="Tab 2"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_riode_tab_item][wpb_riode_tab_item tab_title="Tab 3"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_riode_tab_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Tab extends WPBakeryShortCodesContainer {
	}
}
