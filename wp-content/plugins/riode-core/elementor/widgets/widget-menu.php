<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Menu Widget
 *
 * Riode Widget to display menu.
 *
 * @since 1.0
 */


use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Riode_Menu_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_menu';
	}

	public function get_title() {
		return esc_html__( 'Menu', 'riode-core' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-menu';
	}

	public function get_keywords() {
		return array( 'menu', 'riode-core' );
	}

	public function get_script_depends() {
		return array();
	}


	/**
	 * Get menu items.
	 *
	 * @access public
	 *
	 * @return array Menu Items
	 */
	public function get_menu_items() {
		$menu_items = array();
		$menus      = wp_get_nav_menus();
		foreach ( $menus as $key => $item ) {
			$menu_items[ $item->term_id ] = $item->name;
		}
		return $menu_items;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_menu',
			array(
				'label' => esc_html__( 'Menu', 'riode-core' ),
			)
		);

			$this->add_control(
				'menu_id',
				array(
					'label'       => esc_html__( 'Select Menu', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'options'     => $this->get_menu_items(),
					'description' => esc_html__( 'Select certain menu you want to place among menus have been created.', 'riode-core' ),
				)
			);

			$this->add_control(
				'skin',
				array(
					'label'       => esc_html__( 'Select Skin', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'skin1',
					'description' => sprintf( esc_html__( 'You can customize menu skins in %1$sCustomize Panel/Menus/Menu Skins%2$s', 'riode-core' ), '<a href="' . wp_customize_url() . '#menu_skins" data-target="menu_skins" data-type="section" target="_blank">', '</a>.' ),
					'options'     => array(
						'skin1'  => esc_html__( 'Skin 1', 'riode-core' ),
						'skin2'  => esc_html__( 'Skin 2', 'riode-core' ),
						'skin3'  => esc_html__( 'Skin 3', 'riode-core' ),
						'custom' => esc_html__( 'Custom', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'type',
				array(
					'label'       => esc_html__( 'Select Type', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'vertical',
					'options'     => array(
						'horizontal'  => esc_html__( 'Horizontal', 'riode-core' ),
						'vertical'    => esc_html__( 'Vertical', 'riode-core' ),
						'collapsible' => esc_html__( 'Vertical Collapsible', 'riode-core' ),
						'dropdown'    => esc_html__( 'Toggle Dropdown', 'riode-core' ),
					),
					'description' => esc_html__( 'Select certain type you want to display among 4 fashionable types.', 'riode-core' ),
				)
			);

			$this->add_control(
				'mobile',
				array(
					'label'       => esc_html__( 'Show as dropdown links in mobile', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'type' => 'horizontal',
					),
					'description' => esc_html__( 'Enables your menu be dropdown links on mobile.', 'riode-core' ),
				)
			);

			$this->add_control(
				'mobile_label',
				array(
					'label'       => esc_html__( 'Mobile Links Label', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'description' => esc_html__( 'If this input is empty, menu links label is set as "Links" by default.', 'riode-core' ),
					'condition'   => array(
						'type'   => 'horizontal',
						'mobile' => 'yes',
					),
				)
			);

			$this->add_control(
				'mobile_dropdown_pos',
				array(
					'label'       => esc_html__( 'Mobile Dropdown Position', 'riode-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => array(
						'dp-left'  => array(
							'title' => esc_html__( 'Left', 'riode-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'dp-right' => array(
							'title' => esc_html__( 'Right', 'riode-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'condition'   => array(
						'type'   => 'horizontal',
						'mobile' => 'yes',
					),
					'description' => esc_html__( 'Select mobile dropdown position among left and right postions.', 'riode-core' ),
				)
			);

			$this->add_responsive_control(
				'width',
				array(
					'label'       => esc_html__( 'Width (px)', 'riode-core' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 300,
					'conditions'  => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'type',
								'operator' => 'in',
								'value'    => array( 'vertical', 'collapsible' ),
							),
							array(
								'relation' => 'and',
								'terms'    => array(
									array(
										'name'     => 'type',
										'operator' => '==',
										'value'    => 'dropdown',
									),
									array(
										'name'     => 'tog_equal',
										'operator' => '!=',
										'value'    => 'yes',
									),
								),
							),
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .menu' => 'width: {{VALUE}}px;',
					),
					'description' => esc_html__( 'Type a number of your menu’s width.', 'riode-core' ),
				)
			);

			$this->add_control(
				'underline',
				array(
					'label'       => esc_html__( 'Underline on hover', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'type!' => 'dropdown',
					),
					'description' => esc_html__( 'Gives underline style to your menu items on hover.', 'riode-core' ),
				)
			);

			$this->add_control(
				'label',
				array(
					'label'       => esc_html__( 'Toggle Label', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'condition'   => array(
						'type' => 'dropdown',
					),
					'description' => esc_html__( 'Type a toggle label.', 'riode-core' ),
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'       => esc_html__( 'Toggle Icon', 'riode-core' ),
					'type'        => Controls_Manager::ICONS,
					'default'     => array(
						'value'   => 'd-icon-bars',
						'library' => 'riode-icons',
					),
					'condition'   => array(
						'type' => 'dropdown',
					),
					'description' => esc_html__( 'Choose a toggle icon.', 'riode-core' ),
				)
			);

			$this->add_control(
				'hover_icon',
				array(
					'label'       => esc_html__( 'Toggle Hover Icon', 'riode-core' ),
					'type'        => Controls_Manager::ICONS,
					'condition'   => array(
						'type' => 'dropdown',
					),
					'description' => esc_html__( 'Choose a toggle hover icon.', 'riode-core' ),
				)
			);

			$this->add_control(
				'no_bd',
				array(
					'label'       => esc_html__( 'No Border', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'type' => 'dropdown',
					),
					'description' => esc_html__( 'Toggle Menu Dropdown will have no border.', 'riode-core' ),
				)
			);

			$this->add_control(
				'show_home',
				array(
					'label'       => esc_html__( 'Show After Homepage Loading', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'Shows your menu dropdown only in home page.', 'riode-core' ),
					'condition'   => array(
						'type' => 'dropdown',
					),
				)
			);

			$this->add_control(
				'show_page',
				array(
					'label'       => esc_html__( 'Show After Page Loading', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'Shows your menu dropdown in all pages.', 'riode-core' ),
					'condition'   => array(
						'type' => 'dropdown',
					),
				)
			);

			$this->add_control(
				'tog_equal',
				array(
					'label'       => esc_html__( 'Fit width to sidebar', 'riode-core' ),
					'description' => esc_html__( 'Menu Dropdown will be laid on top of homepage sidebar and resized equally with sidebar width.', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'type' => 'dropdown',
					),
				)
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_ancestor_style',
			array(
				'label' => esc_html__( 'Menu Ancestor', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'ancestor_typography',
					'selector' => '.elementor-element-{{ID}} .menu > li > a',
				)
			);

			$this->add_responsive_control(
				'ancestor_border',
				array(
					'label'       => esc_html__( 'Border Width', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array( 'px', 'rem' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .menu > li > a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
					'description' => esc_html__( 'Controls ancestor border width.', 'riode-core' ),
				)
			);

			$this->add_control(
				'ancestor_border_radius',
				array(
					'label'       => esc_html__( 'Border Radius', 'elementor' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array( 'px', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .menu > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'description' => esc_html__( 'Controls ancestor border radius.', 'riode-core' ),
				)
			);

			$this->start_controls_tabs( 'ancestor_color_tab' );
				$this->start_controls_tab(
					'ancestor_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

				$this->add_control(
					'ancestor_color',
					array(
						'label'       => esc_html__( 'Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu > li > a' => 'color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls ancestor color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'ancestor_back_color',
					array(
						'label'       => esc_html__( 'Background Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu > li > a' => 'background-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls ancestor background color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'ancestor_border_color',
					array(
						'label'       => esc_html__( 'Border Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu > li > a' => 'border-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls ancestor border color.', 'riode-core' ),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'ancestor_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

				$this->add_control(
					'ancestor_hover_color',
					array(
						'label'       => esc_html__( 'Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-item > a, .elementor-element-{{ID}} .menu > .current-menu-ancestor > a' => 'color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls ancestor hover color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'ancestor_hover_back_color',
					array(
						'label'       => esc_html__( 'Background Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'background-color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-item > a, .elementor-element-{{ID}} .menu > .current-menu-ancestor > a' => 'background-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls ancestor background hover color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'ancestor_hover_border_color',
					array(
						'label'       => esc_html__( 'Border Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu > li:hover > a' => 'border-color: {{VALUE}};',
							'.elementor-element-{{ID}} .menu > .current-menu-item > a, .elementor-element-{{ID}} .menu > .current-menu-ancestor > a' => 'border-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls ancestor border hover color.', 'riode-core' ),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'ancestor_padding',
				array(
					'label'       => esc_html__( 'Padding', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'seperator'   => 'before',
					'size_units'  => array( 'px', 'rem', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'description' => esc_html__( 'Controls ancestor padding.', 'riode-core' ),
				)
			);

			$this->add_responsive_control(
				'ancestor_margin',
				array(
					'label'       => esc_html__( 'Margin', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array( 'px', 'rem', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .menu > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .menu > li:last-child' => 'margin: 0;',
					),
					'description' => esc_html__( 'Controls ancestor margin.', 'riode-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_submenu_style',
			array(
				'label' => esc_html__( 'Submenu Item', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'submenu_typography',
					'selector' => '.elementor-element-{{ID}} .menu li ul',
				)
			);

			$this->add_responsive_control(
				'submenu_border',
				array(
					'label'       => esc_html__( 'Border Width', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array( 'px', 'rem' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} li li > a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
					'description' => esc_html__( 'Controls submenu border width.', 'riode-core' ),
				)
			);

			$this->add_control(
				'submenu_border_radius',
				array(
					'label'       => esc_html__( 'Border Radius', 'elementor' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array( 'px', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} li li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'description' => esc_html__( 'Controls submenu border radius.', 'riode-core' ),
				)
			);

			$this->start_controls_tabs( 'submenu_color_tab' );
				$this->start_controls_tab(
					'submenu_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

				$this->add_control(
					'submenu_color',
					array(
						'label'       => esc_html__( 'Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu-item li > a' => 'color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls submenu color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'submenu_back_color',
					array(
						'label'       => esc_html__( 'Background Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu .menu-item li > a' => 'background-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls submenu background color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'submenu_border_color',
					array(
						'label'       => esc_html__( 'Border Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu-item li > a' => 'border-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls submenu border color.', 'riode-core' ),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'submenu_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

				$this->add_control(
					'submenu_hover_color',
					array(
						'label'       => esc_html__( 'Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu-item li:hover > a:not(.nolink)' => 'color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls submenu hover color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'submenu_hover_back_color',
					array(
						'label'       => esc_html__( 'Background Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu .menu-item li:hover > a:not(.nolink)' => 'background-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls submenu background hover color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'submenu_hover_border_color',
					array(
						'label'       => esc_html__( 'Border Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .menu-item li:hover > a' => 'border-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls submenu border hover color.', 'riode-core' ),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'submenu_padding',
				array(
					'label'       => esc_html__( 'Padding', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'seperator'   => 'before',
					'size_units'  => array( 'px', 'rem', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} li li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'description' => esc_html__( 'Controls submenu padding.', 'riode-core' ),
				)
			);

			$this->add_responsive_control(
				'submenu_margin',
				array(
					'label'       => esc_html__( 'Margin', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array( 'px', 'rem', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} li li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} li li:last-child' => 'margin: 0;',
					),
					'description' => esc_html__( 'Controls submenu margin.', 'riode-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style',
			array(
				'label'     => esc_html__( 'Menu Toggle', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'type' => 'dropdown',
				),
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'toggle_typography',
					'selector' => '.elementor-element-{{ID}} .toggle-menu > a',
				)
			);

			$this->add_responsive_control(
				'toggle_icon',
				array(
					'label'       => esc_html__( 'Icon Size (px)', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array( 'px' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .toggle-menu > a i' => 'font-size: {{SIZE}}px;',
					),
					'description' => esc_html__( 'Controls toggle icon size.', 'riode-core' ),
				)
			);

			$this->add_responsive_control(
				'toggle_icon_space',
				array(
					'label'       => esc_html__( 'Icon Space (px)', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array( 'px' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .toggle-menu > a i + span' => 'margin-left: {{SIZE}}px;',
					),
					'description' => esc_html__( 'Controls toggle icon space.', 'riode-core' ),
				)
			);

			$this->add_responsive_control(
				'toggle_border',
				array(
					'label'       => esc_html__( 'Border Width', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array( 'px', 'rem' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .toggle-menu > a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
					'description' => esc_html__( 'Controls toggle icon border width.', 'riode-core' ),
				)
			);

			$this->add_control(
				'toggle_border_radius',
				array(
					'label'       => esc_html__( 'Border Radius', 'elementor' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array( 'px', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .toggle-menu > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'description' => esc_html__( 'Controls toggle icon border radius.', 'riode-core' ),
				)
			);

			$this->start_controls_tabs( 'toggle_color_tab' );
				$this->start_controls_tab(
					'toggle_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

				$this->add_control(
					'toggle_color',
					array(
						'label'       => esc_html__( 'Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .toggle-menu .dropdown-menu-toggle' => 'color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls toggle icon color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'toggle_back_color',
					array(
						'label'       => esc_html__( 'Background Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .toggle-menu .dropdown-menu-toggle' => 'background-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls toggle icon background color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'toggle_border_color',
					array(
						'label'       => esc_html__( 'Border Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .toggle-menu .dropdown-menu-toggle' => 'border-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls toggle icon border color.', 'riode-core' ),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'toggle_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

				$this->add_control(
					'toggle_hover_color',
					array(
						'label'       => esc_html__( 'Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .toggle-menu.show .dropdown-menu-toggle' => 'color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls toggle icon hover color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'toggle_hover_back_color',
					array(
						'label'       => esc_html__( 'Background Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .toggle-menu.show .dropdown-menu-toggle' => 'background-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls toggle icon hover backgroud color.', 'riode-core' ),
					)
				);

				$this->add_control(
					'toggle_hover_border_color',
					array(
						'label'       => esc_html__( 'Border Color', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .toggle-menu.show .dropdown-menu-toggle' => 'border-color: {{VALUE}};',
						),
						'description' => esc_html__( 'Controls toggle icon border color.', 'riode-core' ),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'toggle_padding',
				array(
					'label'       => esc_html__( 'Padding', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'seperator'   => 'before',
					'size_units'  => array( 'px', 'rem', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .toggle-menu > .dropdown-menu-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'description' => esc_html__( 'Controls toggle icon padding.', 'riode-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dropdown_style',
			array(
				'label' => esc_html__( 'Menu Dropdown', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'dropdown_padding',
				array(
					'label'       => esc_html__( 'Padding', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'seperator'   => 'before',
					'size_units'  => array( 'px', 'rem', '%' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .toggle-menu .menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .menu > li > ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .mobile-links nav > ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'description' => esc_html__( 'Controls toggle dropdown padding.', 'riode-core' ),
				)
			);

			$this->add_responsive_control(
				'dropdown_bg',
				array(
					'label'       => esc_html__( 'Background', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .toggle-menu .menu' => 'background-color: {{VALUE}}',
						'.elementor-element-{{ID}} .menu li > ul' => 'background-color: {{VALUE}}',
						'.elementor-element-{{ID}} .collapsible-menu' => 'background-color: {{VALUE}}',
						'.elementor-element-{{ID}} .toggle-menu::after' => 'border-bottom-color: {{VALUE}}',
						'.elementor-element-{{ID}} .menu > .menu-item-has-children::after' => 'border-bottom-color: {{VALUE}}',
						'.elementor-element-{{ID}} .vertical-menu > .menu-item-has-children::after' => 'border-bottom-color: transparent; border-right-color: {{VALUE}}',
						'.elementor-element-{{ID}} .mobile-links nav' => 'background-color: {{VALUE}}',
						'.elementor-element-{{ID}} .mobile-links::after' => 'border-bottom-color: {{VALUE}}',
					),
					'description' => esc_html__( 'Controls toggle dropdown background.', 'riode-core' ),
				)
			);

			$this->add_responsive_control(
				'dropdown_bd_color',
				array(
					'label'       => esc_html__( 'Border Color', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .has-border .menu' => 'border-color: {{VALUE}}',
						'.elementor-element-{{ID}} .has-border::before' => 'border-bottom-color: {{VALUE}}',
					),
					'condition'   => array(
						'type'   => 'dropdown',
						'no_bd!' => 'no',
					),
					'description' => esc_html__( 'Controls toggle dropdown border color.', 'riode-core' ),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'        => 'dropdown_box_shadow',
					'selector'    => '.elementor-element-{{ID}} .show .dropdown-box, .elementor-element-{{ID}} li ul',
					'description' => esc_html__( 'Controls toggle dropdown box shadow.', 'riode-core' ),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-menu-render.php';
	}
}
