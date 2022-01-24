<?php
/**
 * Riode Menu Render
 *
 * @since 1.1.0
 */

function get_menu_items() {
	$menu_items = array();
	$menus      = wp_get_nav_menus();
	foreach ( $menus as $key => $item ) {
		$menu_items[ $item->name ] = $item->term_id;
	}
	return $menu_items;
}

$wpb_menu_items = array_merge( array( esc_html__( 'Select Menu', 'riode-core' ) => '' ), get_menu_items() );

$params = array(
	esc_html__( 'Menu', 'riode-core' )  => array(
		array(
			'type'        => 'dropdown',
			'param_name'  => 'menu_id',
			'heading'     => esc_html__( 'Select Menu', 'riode-core' ),
			'value'       => $wpb_menu_items,
			'admin_label' => true,
			'description' => esc_html__( 'Select certain menu you want to place among menus have been created.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'skin',
			'heading'     => esc_html__( 'Select Skin', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Skin 1', 'riode-core' ) => 'skin1',
				esc_html__( 'Skin 2', 'riode-core' ) => 'skin2',
				esc_html__( 'Skin 3', 'riode-core' ) => 'skin3',
				esc_html__( 'Custom', 'riode-core' ) => 'custom',
			),
			'std'         => 'skin1',
			'admin_label' => true,
			'description' => esc_html__( 'Select certain skin you have already prepared in the theme option panel.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'type',
			'heading'     => esc_html__( 'Select Type', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Horizontal', 'riode-core' ) => 'horizontal',
				esc_html__( 'Vertical', 'riode-core' )   => 'vertical',
				esc_html__( 'Vertical Collapsible', 'riode-core' ) => 'collapsible',
				esc_html__( 'Toggle Dropdown', 'riode-core' ) => 'dropdown',
			),
			'std'         => 'horizontal',
			'admin_label' => true,
			'description' => esc_html__( 'Select certain type you want to display among 4 fashionable types.', 'riode-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show as dropdown links in mobile', 'riode-core' ),
			'param_name'  => 'mobile',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'description' => esc_html__( 'Enables your menu be dropdown links on mobile.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'horizontal',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Mobile Links Label', 'riode-core' ),
			'description' => esc_html__( 'When mobile options is true, It only works.', 'riode-core' ),
			'param_name'  => 'mobile_label',
			'value'       => esc_html__( 'LINKS', 'riode-core' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'horizontal',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Mobile Dropdown Position', 'riode-core' ),
			'description' => esc_html__( 'When mobile options is true, It only works.', 'riode-core' ),
			'param_name'  => 'mobile_dropdown_pos',
			'value'       => array(
				'dp-left'  => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'dp-right' => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'horizontal',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Width', 'riode-core' ),
			'description' => esc_html__( 'If menu type is vertical or collapsible, you can control this option. And when menu type is dropdown if this \'Fit width to sidebar\' property is false, you can also control.', 'riode-core' ),
			'param_name'  => 'width',
			'units'       => array(
				'px',
				'rem',
				'em',
			),
			'value'       => '{"xl":"300","unit":"px"}',
			'selectors'   => array(
				'{{WRAPPER}} .menu' => 'width: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Underline on hover', 'riode-core' ),
			'param_name'  => 'underline',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'description' => esc_html__( 'Gives underline style to your menu items on hover.', 'riode-core' ),
			'dependency'  => array(
				'element'            => 'type',
				'value_not_equal_to' => 'dropdown',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Toggle Label', 'riode-core' ),
			'param_name'  => 'label',
			'description' => esc_html__( 'Type a toggle label.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Toggle Icon', 'riode-core' ),
			'param_name'  => 'icon',
			'std'         => 'd-icon-bars',
			'description' => esc_html__( 'Choose a toggle icon.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Toggle Hover Icon', 'riode-core' ),
			'param_name'  => 'hover_icon',
			'description' => esc_html__( 'Choose a toggle hover icon.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'No Border', 'riode-core' ),
			'param_name'  => 'no_bd',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'description' => esc_html__( 'Toggle Menu Dropdown will have no border.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show After Homepage Loading', 'riode-core' ),
			'description' => esc_html__( 'Menu Dropdown will be shown after loading in homepage.', 'riode-core' ),
			'param_name'  => 'show_home',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show After Page Loading', 'riode-core' ),
			'description' => esc_html__( 'Menu Dropdown will be shown after loading in all pages.', 'riode-core' ),
			'param_name'  => 'show_page',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Fit width to sidebar', 'riode-core' ),
			'description' => esc_html__( 'Menu Dropdown will be laid on top of homepage sidebar and resized equally with sidebar width.', 'riode-core' ),
			'param_name'  => 'tog_equal',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'dropdown',
			),
		),

	),
	esc_html__( 'Style', 'riode-core' ) => array(
		esc_html__( 'Menu Ancestor', 'riode-core' ) => array(
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'param_name' => 'ancestor_typography',
				'selectors'  => array(
					'{{WRAPPER}} .menu > li > a',
				),
				'description' => esc_html__( 'Controls ancestor typographys.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Border Width', 'riode-core' ),
				'param_name' => 'ancestor_border',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .menu > li > a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
				),
				'description' => esc_html__( 'Controls ancestor border width.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
				'param_name' => 'ancestor_border_radius',
				'selectors'  => array(
					'{{WRAPPER}} .menu > li > a' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
				'description' => esc_html__( 'Controls ancestor border radius.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_color_group',
				'heading'    => esc_html__( 'Colors', 'riode-core' ),
				'param_name' => 'ancestor_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .menu > li > a',
					'hover'  => '{{WRAPPER}} .menu > li:hover > a, {{WRAPPER}} .menu > .current-menu-item > a',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
				'description' => esc_html__( 'Controls ancestor colors.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'param_name' => 'ancestor_padding',
				'selectors'  => array(
					'{{WRAPPER}} .menu > li > a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls ancestor padding.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'param_name' => 'ancestor_margin',
				'selectors'  => array(
					'{{WRAPPER}} .menu > li'            => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
					'{{WRAPPER}} .menu > li:last-child' => 'margin: 0;',
				),
				'description' => esc_html__( 'Controls ancestor margin.', 'riode-core' ),
			),
		),
		esc_html__( 'Submenu Item', 'riode-core' )  => array(
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'param_name' => 'submenu_typography',
				'selectors'  => array(
					'{{WRAPPER}} .menu li ul',
				),
				'description' => esc_html__( 'Controls submenu typography.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Border Width', 'riode-core' ),
				'param_name' => 'submenu_border',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} li li > a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
				),
				'description' => esc_html__( 'Controls submenu border width.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
				'param_name' => 'submenu_border_radius',
				'selectors'  => array(
					'{{WRAPPER}} li li > a' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
				'description' => esc_html__( 'Controls submenu border radius.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_color_group',
				'heading'    => esc_html__( 'Colors', 'riode-core' ),
				'param_name' => 'submenu_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .menu .menu-item li > a',
					'hover'  => '{{WRAPPER}} .menu .menu-item li:hover > a:not(.nolink)',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
				'description' => esc_html__( 'Controls submenu colors.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'param_name' => 'submenu_padding',
				'selectors'  => array(
					'{{WRAPPER}} li li > a' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls submenu padding.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'param_name' => 'submenu_margin',
				'selectors'  => array(
					'{{WRAPPER}} li li'            => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
					'{{WRAPPER}} li li:last-child' => 'margin: 0;',
				),
				'description' => esc_html__( 'Controls submenu margin.', 'riode-core' ),
			),
		),
		esc_html__( 'Menu Toggle', 'riode-core' )   => array(
			array(
				'type'       => 'riode_heading',
				'label'      => esc_html__( 'In this section, you can control menu toggle if only set as mobile toggle.', 'riode-core' ),
				'param_name' => 'toggle_heading',
				'tag'        => 'p',
				'class'      => 'riode-heading-control-class',
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'param_name' => 'toggle_typography',
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu > a',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
				'description' => esc_html__( 'Controls toggle icon typography.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => __( 'Icon Size', 'riode-core' ),
				'param_name' => 'toggle_icon',
				'responsive' => true,
				'units'      => array(
					'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu > a i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
				'description' => esc_html__( 'Controls toggle icon size.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => __( 'Icon Space', 'riode-core' ),
				'param_name' => 'toggle_icon_space',
				'responsive' => true,
				'units'      => array(
					'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu > a i + span' => 'margin-left: {{VALUE}}{{UNIT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
				'description' => esc_html__( 'Controls toggle icon space.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Border Width', 'riode-core' ),
				'param_name' => 'toggle_border',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu > a' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
				'description' => esc_html__( 'Controls toggle icon border width.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
				'param_name' => 'toggle_border_radius',
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu > a' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
				'description' => esc_html__( 'Controls toggle icon border radius.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_color_group',
				'heading'    => esc_html__( 'Colors', 'riode-core' ),
				'param_name' => 'toggle_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .toggle-menu .dropdown-menu-toggle',
					'hover'  => '{{WRAPPER}} .toggle-menu.show .dropdown-menu-toggle',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'dropdown',
				),
				'description' => esc_html__( 'Controls toggle icon colors.', 'riode-core' ),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'param_name' => 'toggle_padding',
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu > .dropdown-menu-toggle' => 'padding-top: {{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
				'description' => esc_html__( 'Controls toggle icon padding.', 'riode-core' ),
			),
		),
		esc_html__( 'Menu Dropdown', 'riode-core' ) => array(
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'param_name' => 'dropdown_padding',
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu .menu'     => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
					'{{WRAPPER}} .menu > li > ul'        => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
					'{{WRAPPER}} .mobile-links nav > ul' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls toggle dropdown padding.', 'riode-core' ),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'riode-core' ),
				'param_name' => 'dropdown_bg',
				'selectors'  => array(
					'{{WRAPPER}} .toggle-menu .menu'   => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .menu li > ul'        => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .collapsible-menu'    => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .toggle-menu::after'  => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .menu > .menu-item-has-children::after' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .vertical-menu > .menu-item-has-children::after' => 'border-right-color: {{VALUE}};border-bottom-color: transparent;',
					'{{WRAPPER}} .mobile-links nav'    => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mobile-links::after' => 'border-bottom-color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls toggle dropdown background.', 'riode-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Border Color', 'riode-core' ),
				'param_name'  => 'dropdown_bd_color',
				'description' => esc_html__( 'This option only works in toggle dropdown type.', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .has-border .menu'   => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .has-border::before' => 'border-bottom-color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls toggle dropdown border color.', 'riode-core' ),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Menu', 'riode-core' ),
		'base'            => 'wpb_riode_menu',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_menu',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display specific menu with skins', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Menu extends WPBakeryShortCode {
	}
}
