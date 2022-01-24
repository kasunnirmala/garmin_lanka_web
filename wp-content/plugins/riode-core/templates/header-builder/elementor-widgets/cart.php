<?php
/**
 * Riode Header Elementor Cart
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Riode_Header_Cart_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_header_cart';
	}

	public function get_title() {
		return esc_html__( 'Cart', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon d-icon-shoppingbag';
	}

	public function get_categories() {
		return array( 'riode_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'riode', 'cart', 'shop', 'mini', 'bag' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( riode_is_elementor_preview() ) {
			$depends[] = 'riode-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {
		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		$this->start_controls_section(
			'section_cart_content',
			array(
				'label' => esc_html__( 'Cart', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Cart Icon and Label Direction', 'riode-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'inline',
					'options' => array(
						'block'  => array(
							'title' => esc_html__( 'Block', 'riode-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'inline' => array(
							'title' => esc_html__( 'Inline', 'riode-core' ),
							'icon'  => 'eicon-h-align-right',
						),
					),
				)
			);

			$this->add_control(
				'icon_heading',
				array(
					'label'     => esc_html__( 'Cart Icon', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'icon_type',
				array(
					'label'   => esc_html__( 'Cart Icon Type', 'riode-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => array(
						''      => esc_html__( 'Default', 'riode-core' ),
						'badge' => esc_html__( 'Badge Type', 'riode-core' ),
						'label' => esc_html__( 'Label Type', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'     => esc_html__( 'Cart Icon', 'riode-core' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => 'd-icon-bag',
						'library' => 'riode-icons',
					),
					'condition' => array(
						'icon_type' => 'badge',
					),
				)
			);

			$this->add_control(
				'label_heading',
				array(
					'label'     => esc_html__( 'Cart Label', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'label_type',
				array(
					'label'   => esc_html__( 'Cart Label Direction', 'riode-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'inline',
					'options' => array(
						'block'  => array(
							'title' => esc_html__( 'Block', 'riode-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'inline' => array(
							'title' => esc_html__( 'Inline', 'riode-core' ),
							'icon'  => 'eicon-h-align-right',
						),
					),
				)
			);

			$this->add_control(
				'show_label',
				array(
					'label'   => esc_html__( 'Show Label', 'riode-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'label',
				array(
					'label'     => esc_html__( 'Cart Label', 'riode-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => 'My Cart',
					'condition' => array(
						'show_label' => 'yes',
					),
				)
			);

			$this->add_control(
				'delimiter',
				array(
					'label'     => esc_html__( 'Delimiter', 'riode-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '/',
					'condition' => array(
						'show_label' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_price',
				array(
					'label'   => esc_html__( 'Show Cart Total Price', 'riode-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'count_pfx',
				array(
					'label'     => esc_html__( 'Cart Count Prefix', 'riode-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '(',
					'condition' => array(
						'icon_type' => 'label',
					),
				)
			);

			$this->add_control(
				'count_sfx',
				array(
					'label'     => esc_html__( 'Cart Count Suffix', 'riode-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => ' items )',
					'condition' => array(
						'icon_type' => 'label',
					),
				)
			);

			$this->add_control(
				'cart_off_canvas',
				array(
					'label'     => esc_html__( 'Off Canvas', 'riode-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'separator' => 'before',
					'default'   => 'yes',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cart_style',
			array(
				'label' => esc_html__( 'Cart Toggle', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'cart_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_cart_color' );
				$this->start_controls_tab(
					'tab_cart_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

				$this->add_control(
					'cart_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .cart-toggle' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_cart_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

				$this->add_control(
					'cart_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .cart-dropdown:hover .cart-toggle' => 'color: {{VALUE}};',
							'.elementor-element-{{ID}} .cart-dropdown:hover .minicart-icon' => 'background-color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'cart_label_heading',
				array(
					'label'     => esc_html__( 'Cart Label', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cart_typography',
					'selector' => '.elementor-element-{{ID}} .cart-toggle, .elementor-element-{{ID}} .cart-count',
				)
			);

			$this->add_responsive_control(
				'cart_delimiter_space',
				array(
					'label'      => esc_html__( 'Delimiter Space (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-name-delimiter' => 'margin: 0 {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'cart_price_heading',
				array(
					'label'     => esc_html__( 'Cart Price', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cart_price_typography',
					'selector' => '.elementor-element-{{ID}} .cart-price',
				)
			);

			$this->add_responsive_control(
				'cart_price_margin',
				array(
					'label'      => esc_html__( 'Margin', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-dropdown .cart-toggle .cart-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'cart_icon_heading',
				array(
					'label'     => esc_html__( 'Cart Icon', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_responsive_control(
				'cart_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .cart-dropdown .cart-toggle i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'cart_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .block-type .cart-label + i' => 'margin-bottom: {{SIZE}}px;',
						'.elementor-element-{{ID}} .inline-type .cart-label + i' => "margin-{$left}: {{SIZE}}px;",
					),
				)
			);

			$this->add_control(
				'cart_count_heading',
				array(
					'label'     => esc_html__( 'Cart Count and Icon', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => array(
						'icon_type' => '',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'cart_count_typography',
					'selector'  => '.elementor-element-{{ID}} .cart-count',
					'condition' => array(
						'icon_type' => '',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_count_color' );
				$this->start_controls_tab(
					'tab_count_normal',
					array(
						'label'     => esc_html__( 'Normal', 'riode-core' ),
						'condition' => array(
							'icon_type' => '',
						),
					)
				);

				$this->add_control(
					'count_color',
					array(
						'label'     => esc_html__( 'Count Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => array(
							'icon_type' => '',
						),
						'selectors' => array(
							'.elementor-element-{{ID}} .minicart-icon .cart-count' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'count_bg_color',
					array(
						'label'     => esc_html__( 'Icon Background', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => array(
							'icon_type' => '',
						),
						'selectors' => array(
							'.elementor-element-{{ID}} .minicart-icon' => 'background: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'count_bd_color',
					array(
						'label'     => esc_html__( 'Icon Border Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => array(
							'icon_type' => '',
						),
						'selectors' => array(
							'.elementor-element-{{ID}} .minicart-icon' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_count_hover',
					array(
						'label'     => esc_html__( 'Hover', 'riode-core' ),
						'condition' => array(
							'icon_type' => '',
						),
					)
				);

				$this->add_control(
					'count_hover_color',
					array(
						'label'     => esc_html__( 'Count Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => array(
							'icon_type' => '',
						),
						'selectors' => array(
							'.elementor-element-{{ID}} .cart-dropdown:hover .minicart-icon .cart-count' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'count_hover_bg_color',
					array(
						'label'     => esc_html__( 'Icon Background', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => array(
							'icon_type' => '',
						),
						'selectors' => array(
							'.elementor-element-{{ID}} .cart-dropdown:hover .minicart-icon' => 'background: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'count_hover_bd_color',
					array(
						'label'     => esc_html__( 'Icon Border Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => array(
							'icon_type' => '',
						),
						'selectors' => array(
							'.elementor-element-{{ID}} .cart-dropdown:hover .minicart-icon' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cart_badge_style',
			array(
				'label'     => esc_html__( 'Badge', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'icon_type' => 'badge',
				),
			)
		);

			$this->add_responsive_control(
				'badge_size',
				array(
					'label'      => esc_html__( 'Badge Size', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'badge_h_position',
				array(
					'label'      => esc_html__( 'Horizontal Position', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => "{$left}: {{SIZE}}{{UNIT}};",
					),
				)
			);

			$this->add_responsive_control(
				'badge_v_position',
				array(
					'label'      => esc_html__( 'Vertical Position', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'badge_count_bg_color',
				array(
					'label'     => esc_html__( 'Count Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						'icon_type' => 'badge',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'badge_count_bd_color',
				array(
					'label'     => esc_html__( 'Count Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						'icon_type' => 'badge',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .badge-type .cart-count' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$args = array(
			'cart_type'       => $settings['type'],
			'icon_type'       => $settings['icon_type'],
			'cart_off_canvas' => $settings['cart_off_canvas'],
			'label_type'      => $settings['label_type'],
			'title'           => $settings['show_label'],
			'label'           => $settings['label'],
			'price'           => $settings['show_price'],
			'delimiter'       => $settings['delimiter'],
			'pfx'             => $settings['count_pfx'],
			'sfx'             => $settings['count_sfx'],
			'icon'            => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : 'd-icon-bag',
		);

		if ( defined( 'RIODE_VERSION' ) ) {
			riode_get_template_part( RIODE_PART . '/header/elements/element-cart', null, $args );
		}
	}
}
