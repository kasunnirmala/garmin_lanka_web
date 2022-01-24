<?php
/**
 * Riode Header Elementor Search
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Riode_Header_Search_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_header_search';
	}

	public function get_title() {
		return esc_html__( 'Search', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon d-icon-search-2';
	}

	public function get_categories() {
		return array( 'riode_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'riode', 'search', 'find' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( riode_is_elementor_preview() ) {
			$depends[] = 'riode-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_search_content',
			array(
				'label' => esc_html__( 'Search', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Search Type', 'riode-core' ),
					'type'    => 'riode_image_choose',
					'default' => 'hs-toggle',
					'options' => array(
						'hs-toggle'     => RIODE_CORE_URI . 'assets/images/header-search/search1.jpg',
						'hs-simple'     => RIODE_CORE_URI . 'assets/images/header-search/search2.jpg',
						'hs-expanded'   => RIODE_CORE_URI . 'assets/images/header-search/search3.jpg',
						'hs-flat'       => RIODE_CORE_URI . 'assets/images/header-search/search4.jpg',
						'hs-fullscreen' => RIODE_CORE_URI . 'assets/images/header-search/search5.jpg',
					),
				)
			);

			$this->add_control(
				'label',
				array(
					'label'     => esc_html__( 'Search Label', 'riode-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'condition' => array(
						'type' => array( 'hs-toggle', 'hs-fullscreen' ),
					),
				)
			);

			$this->add_control(
				'border_type',
				array(
					'label'      => esc_html__( 'Border Type', 'riode-core' ),
					'type'       => Controls_Manager::SELECT,
					'default'    => 'rect',
					'options'    => array(
						'rect'    => esc_html__( 'Rectangle', 'riode-core' ),
						'rounded' => esc_html__( 'Rounded', 'riode-core' ),
					),
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'type',
								'operator' => 'in',
								'value'    => array( 'hs-toggle', 'hs-expanded', 'hs-simple', 'hs-fullscreen' ),
							),
						),
					),
				)
			);

			$this->add_control(
				'category',
				array(
					'label'       => esc_html__( 'Search by Category', 'riode-core' ),
					'description' => esc_html__( 'Show category select box of search post types. If search type is all, post categories will be shown.', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'default'     => 'yes',
					'conditions'  => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'type',
								'operator' => 'in',
								'value'    => array( 'hs-toggle', 'hs-expanded', 'hs-fullscreen' ),
							),
						),
					),
				)
			);

			$this->add_control(
				'fullscreen_type',
				array(
					'label'     => esc_html__( 'Load More', 'riode-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'fs-default',
					'options'   => array(
						'fs-default'  => esc_html__( 'No', 'riode-core' ),
						'fs-loadmore' => esc_html__( 'By button', 'riode-core' ),
						'fs-infinite' => esc_html__( 'By scroll', 'riode-core' ),
					),
					'condition' => array(
						'type' => 'hs-fullscreen',
					),
				)
			);

			$this->add_control(
				'fullscreen_style',
				array(
					'label'     => esc_html__( 'Fullscreen Search Style', 'riode-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'light',
					'options'   => array(
						'light' => esc_html__( 'Light', 'riode-core' ),
						'dark'  => esc_html__( 'Dark', 'riode-core' ),
					),
					'condition' => array(
						'type' => 'hs-fullscreen',
					),
				)
			);

			$this->add_control(
				'search_type',
				array(
					'label'       => esc_html__( 'Search Types', 'riode-core' ),
					'description' => esc_html__( 'Select post types to search', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => array(
						''        => esc_html__( 'All', 'riode-core' ),
						'product' => esc_html__( 'Product', 'riode-core' ),
						'post'    => esc_html__( 'Post', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'placeholder',
				array(
					'label'   => esc_html__( 'Search Form Placeholder', 'riode-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => 'Search your keyword...',
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'   => esc_html__( 'Search Icon', 'riode-core' ),
					'type'    => Controls_Manager::ICONS,
					'default' => array(
						'value'   => 'd-icon-search',
						'library' => 'riode-icons',
					),
				)
			);

			$this->add_responsive_control(
				'search_width',
				array(
					'label'      => esc_html__( 'Search Width', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 200,
							'max'  => 600,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .hs-expanded' => 'width: {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .hs-simple' => 'width: {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .hs-toggle .input-wrapper' => 'min-width: {{SIZE}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_input_style',
			array(
				'label' => esc_html__( 'Input Field', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'input_typography',
					'selector' => '.elementor-element-{{ID}} .search-wrapper input.form-control, .elementor-element-{{ID}} select',
				)
			);

			$this->add_control(
				'search_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .search-wrapper select' => 'padding: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'search_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'color: {{VALUE}};',
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'search_bg',
				array(
					'label'     => esc_html__( 'Background', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'background-color: {{VALUE}};',
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'search_bd',
				array(
					'label'      => esc_html__( 'Border Width', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'separator'  => 'before',
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid; margin-left: -{{LEFT}}{{UNIT}}',
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'search_br',
				array(
					'label'      => esc_html__( 'Border Radius', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .search-wrapper .select-box ~ .form-control' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'search_bd_color',
				array(
					'label'     => esc_html__( 'Border Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .search-wrapper input.form-control' => 'border-color: {{VALUE}};',
						'.elementor-element-{{ID}} .search-wrapper .select-box' => 'border-color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label' => esc_html__( 'Button', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'btn_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .btn-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'btn_size',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .btn-search' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'btn_bd_width',
				array(
					'label'      => esc_html__( 'Border Width', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .btn-search' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->add_control(
				'btn_br',
				array(
					'label'      => esc_html__( 'Border Radius', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper .btn-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_btn_color' );
				$this->start_controls_tab(
					'tab_btn_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

					$this->add_control(
						'btn_color',
						array(
							'label'     => esc_html__( 'Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn-search' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bg',
						array(
							'label'     => esc_html__( 'Background', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn-search' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bd_color',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn-search' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_btn_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

					$this->add_control(
						'btn_hover_color',
						array(
							'label'     => esc_html__( 'Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn-search:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bg',
						array(
							'label'     => esc_html__( 'Background', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn-search:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bd_color',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .search-wrapper .btn-search:hover' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style',
			array(
				'label'     => esc_html__( 'Toggle Type', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'type' => array( 'hs-toggle', 'hs-fullscreen' ),
				),
			)
		);

			$this->add_control(
				'toggle_heading',
				array(
					'label' => esc_html__( 'Toggle', 'riode-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'label_typography',
					'selector' => '.elementor-element-{{ID}} .search-toggle span',
				)
			);

			$this->add_control(
				'toggle_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'toggle_icon_size',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-toggle i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'toggle_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-toggle i + span' => 'margin-left: {{SIZE}}px;',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_cart_color' );
				$this->start_controls_tab(
					'tab_toggle_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

				$this->add_control(
					'toggle_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .search-wrapper .search-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_bg',
					array(
						'label'     => esc_html__( 'Background Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .search-wrapper .search-toggle' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_toggle_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

				$this->add_control(
					'toggle_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .search-wrapper:hover .search-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'toggle_hover_bg',
					array(
						'label'     => esc_html__( 'Background Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .search-wrapper:hover .search-toggle' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'dropdown_heading',
				array(
					'label'     => esc_html__( 'Dropdown', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_responsive_control(
				'dropdown_position',
				array(
					'label'      => esc_html__( 'Position', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => -500,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => -500,
							'max'  => 500,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .hs-toggle .input-wrapper' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
					),
				)
			);

			$this->add_control(
				'dropdown_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .search-wrapper.hs-toggle .input-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'dropdown_bg',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .hs-toggle .input-wrapper' => 'background-color: {{VALUE}};',
						'.elementor-element-{{ID}} .search-wrapper.hs-toggle::after' => 'border-bottom-color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'dropdown_box_shadow',
					'selector' => '.elementor-element-{{ID}} .hs-toggle .input-wrapper',
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$args = array(
			'aria_label' => array(
				'type'             => $settings['type'],
				'fullscreen_type'  => $settings['fullscreen_type'],
				'fullscreen_style' => $settings['fullscreen_style'],
				'where'            => 'header',
				'search_post_type' => $settings['search_type'],
				'search_label'     => $settings['label'],
				'search_category'  => $settings['category'],
				'border_type'      => $settings['border_type'],
				'placeholder'      => $settings['placeholder'] ? $settings['placeholder'] : 'Search your keyword...',
				'search_right'     => false,
				'icon'             => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : 'd-icon-search',
			),
		);

		get_search_form( $args );
	}
}
