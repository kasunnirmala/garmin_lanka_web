<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode 360 Degree Widget
 *
 * Riode Widget to display custom 360 degree.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

class Riode_360_Degree_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_360_degree';
	}

	public function get_title() {
		return esc_html__( '360 Degree View', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-360';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( '360 degree', '360', 'degree', 'gallery', 'view' );
	}

	public function get_script_depends() {
		return array( 'three-sixty' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_360_degree',
			array(
				'label' => esc_html__( '360_Degree', 'riode-core' ),
			)
		);

			$this->add_control(
				'images',
				array(
					'label'       => esc_html__( 'Upload Images', 'riode-core' ),
					'type'        => Controls_Manager::GALLERY,
					'default'     => array(),
					'show_label'  => false,
					'description' => esc_html__( 'Upload bundle of images that you want to show in 360 degree gallery.', 'riode-core' ),
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'        => 'thumbnail',
					'separator'   => 'none',
					'description' => esc_html__( 'Select fit image size that are suitable for rendering area.', 'riode-core' ),
				)
			);

			$this->add_control(
				'button_type',
				array(
					'label'       => esc_html__( 'Nav Type', 'riode-core' ),
					'description' => esc_html__( 'Choose nav button type. Choose from Framed, Stacked, Link.', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'framed',
					'options'     => array(
						'framed'  => esc_html__( 'Framed', 'riode-core' ),
						'stacked' => esc_html__( 'Staked', 'riode-core' ),
						'linked'  => esc_html__( 'Link', 'riode-core' ),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_360_degree_style',
			array(
				'label' => esc_html__( '360_Degree', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'prev_icon',
				array(
					'label'       => esc_html__( 'Prev Button Size', 'riode-core' ),
					'description' => esc_html__( 'Controls size of prev frame button.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .nav_bar .nav_bar_previous' => 'font-size: {{SIZE}}{{UNIT}};'
					)
				)
			);

			$this->add_responsive_control(
				'play_icon',
				array(
					'label'       => esc_html__( 'Play/Pause Button Size', 'riode-core' ),
					'description' => esc_html__( 'Controls size of play/pause button.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .nav_bar .nav_bar_play' => 'font-size: {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .nav_bar .nav_bar_stop' => 'font-size: {{SIZE}}{{UNIT}};'
					)
				)
			);

			$this->add_responsive_control(
				'next_icon',
				array(
					'label'       => esc_html__( 'Next Button Size', 'riode-core' ),
					'description' => esc_html__( 'Controls size of next frame button.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .nav_bar .nav_bar_next' => 'font-size: {{SIZE}}{{UNIT}};'
					)
				)
			);

			$this->start_controls_tabs( 'tabs_btn_colors' );

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
								'.elementor-element-{{ID}} .riode-360-gallery-wrapper .nav_bar a' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .riode-360-gallery-wrapper .nav_bar a' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bd_color',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .riode-360-gallery-wrapper .nav_bar a' => 'border-color: {{VALUE}};',
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
								'.elementor-element-{{ID}} .riode-360-gallery-wrapper .nav_bar a:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .riode-360-gallery-wrapper .nav_bar a:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bd_color',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .riode-360-gallery-wrapper .nav_bar a:hover' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-360-degree-render.php';
	}

	protected function content_template() {}
}
