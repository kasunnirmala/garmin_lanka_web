<?php
/**
 * Riode Header Elementor Wishlist
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Riode_Header_Wishlist_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_header_wishlist';
	}

	public function get_title() {
		return esc_html__( 'Wishlist', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon d-icon-heart';
	}

	public function get_categories() {
		return array( 'riode_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'riode', 'wish', 'love', 'like', 'list' );
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
			'section_wishlist_content',
			array(
				'label' => esc_html__( 'Wishlist', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Wishlist Type', 'riode-core' ),
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
				'show_icon',
				array(
					'label'   => esc_html__( 'Show Icon', 'riode-core' ),
					'default' => 'yes',
					'type'    => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'     => esc_html__( 'Icon', 'riode-core' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => 'd-icon-heart',
						'library' => 'riode-icons',
					),
					'condition' => array(
						'show_icon' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_count',
				array(
					'label'     => esc_html__( 'Show Count', 'riode-core' ),
					'default'   => 'yes',
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'show_icon' => 'yes',
					),
				)
			);

			$this->add_control(
				'label',
				array(
					'label'       => esc_html__( 'Label', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Wishlist', 'riode-core' ),
					'condition'   => array(
						'show_label' => 'yes',
					),
				)
			);

			$this->add_control(
				'miniwishlist',
				array(
					'label'   => esc_html__( 'Mini Wish List', 'riode-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => '',
					'options' => array(
						''          => array(
							'title' => esc_html__( 'Do not show', 'riode-core' ),
							'icon'  => 'eicon-ban',
						),
						'dropdown'  => array(
							'title' => esc_html__( 'Dropdown', 'riode-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'offcanvas' => array(
							'title' => esc_html__( 'Off-Canvas', 'riode-core' ),
							'icon'  => 'eicon-h-align-left',
						),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wishlist_style',
			array(
				'label' => esc_html__( 'Wishlist', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'wishlist_typography',
					'selector' => '.elementor-element-{{ID}} .wishlist',
				)
			);

			$this->add_responsive_control(
				'wishlist_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .wishlist i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'wishlist_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .block-type i + span' => 'margin-top: {{SIZE}}px;',
						'.elementor-element-{{ID}} .inline-type i + span' => 'margin-left: {{SIZE}}px;',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_wishlist_color' );
				$this->start_controls_tab(
					'tab_wishlist_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

				$this->add_control(
					'wishlist_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .wishlist' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_wishlist_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

				$this->add_control(
					'wishlist_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .wishlist:hover' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'wishlist_dropdown_heading',
				array(
					'label'     => esc_html__( 'Dropdown Mini Wishlist', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => array(
						'miniwishlist' => 'dropdown',
					),
				)
			);

			$this->add_responsive_control(
				'dropdown_position',
				array(
					'label'      => esc_html__( 'Dropdown Position', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .dropdown-box' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
					),
					'condition'  => array(
						'miniwishlist' => 'dropdown',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_wishlist_badge',
			array(
				'label' => esc_html__( 'Badge', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'badge_size',
				array(
					'label'      => esc_html__( 'Badge Size', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .wish-count' => 'font-size: {{SIZE}}px;',
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
						'.elementor-element-{{ID}} .wish-count' => 'left: {{SIZE}}{{UNIT}};',
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
						'.elementor-element-{{ID}} .wish-count' => 'top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'badge_count_bg_color',
				array(
					'label'     => esc_html__( 'Count Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .wish-count' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'badge_count_color',
				array(
					'label'     => esc_html__( 'Count Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .wish-count' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$args = array(
			'type'         => $settings['type'],
			'show_label'   => 'yes' == $settings['show_label'],
			'show_count'   => 'yes' == $settings['show_count'],
			'show_icon'    => 'yes' == $settings['show_icon'],
			'label'        => isset( $settings['label'] ) && $settings['label'] ? $settings['label'] : 'Wishlist',
			'icon'         => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : 'd-icon-heart',
			'miniwishlist' => $settings['miniwishlist'],
		);

		if ( defined( 'RIODE_VERSION' ) ) {
			riode_get_template_part( RIODE_PART . '/header/elements/element-wishlist', null, $args );
		}
	}
}
