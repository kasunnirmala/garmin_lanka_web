<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Riode Image Box Widget
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use ELementor\Group_Control_Background;
use ELementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

class Riode_Imagebox_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_imagebox';
	}

	public function get_title() {
		return esc_html__( 'Image Box', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-image-box';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'image box', 'imagebox', 'feature', 'member', 'riode-core' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		$this->start_controls_section(
			'imagebox_content',
			array(
				'label' => esc_html__( 'Image Box', 'riode-core' ),
			)
		);

			$this->add_control(
				'image',
				[
					'label'       => esc_html__( 'Choose Image', 'riode-core' ),
					'type'        => Controls_Manager::MEDIA,
					'default'     => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'description' => esc_html__( 'Uploads certain images you want to show in your image box.', 'riode-core' ),
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'        => 'image',
					'default'     => 'full',
					'separator'   => 'none',
					'description' => esc_html__( 'Select fit image size with your certain image.', 'riode-core' ),
				]
			);

			$this->add_control(
				'title',
				[
					'label'       => esc_html__( 'Title', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'Input Title Here',
					'description' => esc_html__( 'Type a title for your image box.', 'riode-core' ),
				]
			);

			$this->add_control(
				'subtitle',
				[
					'label'       => esc_html__( 'Subtitle', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'Input SubTitle Here',
					'description' => esc_html__( 'Type a subtitle for your image box.', 'riode-core' ),
				]
			);

			$this->add_control(
				'content',
				[
					'label'       => esc_html__( 'Content', 'riode-core' ),
					'type'        => Controls_Manager::TEXTAREA,
					'rows'        => '10',
					'default'     => '<div class="social-icons">
									<a href="#" class="social-icon framed social-facebook"><i class="fab fa-facebook-f"></i></a>
									<a href="#" class="social-icon framed social-twitter"><i class="fab fa-twitter"></i></a>
									<a href="#" class="social-icon framed social-linkedin"><i class="fab fa-linkedin-in"></i></a>
								</div>',
					'description' => esc_html__( 'Type a description or any raw html you want to display in your image box content.', 'riode-core' ),
				]
			);

			$this->add_control(
				'type',
				array(
					'label'       => esc_html__( 'Imagebox Type', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => array(
						''      => esc_html__( 'Default', 'riode-core' ),
						'outer' => esc_html__( 'Outer Title', 'riode-core' ),
						'inner' => esc_html__( 'Inner Title', 'riode-core' ),
					),
					'description' => esc_html__( 'Select any type which suits your need.', 'riode-core' ),
				)
			);

			$this->add_responsive_control(
				'visible_bottom',
				array(
					'label'       => esc_html__( 'Title Bottom Offset', 'riode-core' ),
					'description' => esc_html__( 'Change bottom offset of title and subtitle on hover event.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 10,
						'unit' => 'rem',
					),
					'size_units'  => array(
						'rem',
						'px',
					),
					'range'       => array(
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 30,
						),
					),
					'condition'   => array( 'type' => 'inner' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} figure:hover .overlay-visible' => 'padding-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'invisible_top',
				array(
					'label'       => esc_html__( 'Description Top Offset', 'riode-core' ),
					'description' => esc_html__( 'Change top offset of description on hover event.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 0,
						'unit' => 'rem',
					),
					'size_units'  => array(
						'rem',
						'px',
					),
					'range'       => array(
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 30,
						),
					),
					'condition'   => array( 'type' => 'inner' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} figure:hover .overlay-transparent' => 'padding-top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'imagebox_align',
				array(
					'label'       => esc_html__( 'Alignment', 'riode-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'riode-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'riode-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'riode-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'default'     => 'center',
					'selectors'   => array(
						'.elementor-element-{{ID}} .image-box' => 'text-align: {{VALUE}};',
					),
					'description' => esc_html__( 'Choose an alignment for your image box.', 'riode-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			array(
				'label' => esc_html__( 'Title', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'title_color',
				array(
					'label'       => esc_html__( 'Color', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .title' => 'color: {{VALUE}};',
					),
					'description' => esc_html__( 'Pick the image box title color.', 'riode-core' ),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'        => 'title_typography',
					'description' => esc_html__( 'Controls the image box title typography.', 'riode-core' ),
					'label'       => esc_html__( 'Typography', 'riode-core' ),
					'selector'    => '.elementor-element-{{ID}} .title',
				)
			);

			$this->add_control(
				'title_mg',
				array(
					'label'       => esc_html__( 'Margin', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array(
						'px',
						'em',
						'rem',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'description' => esc_html__( 'Controls the image box title margin.', 'riode-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_style',
			array(
				'label' => esc_html__( 'Subtitle', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'subtitle_color',
				array(
					'label'       => esc_html__( 'Color', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .subtitle' => 'color: {{VALUE}};',
					),
					'description' => esc_html__( 'Pick the image box subtitle color.', 'riode-core' ),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'        => 'subtitle_typography',
					'label'       => esc_html__( 'Typography', 'riode-core' ),
					'selector'    => '.elementor-element-{{ID}} .subtitle',
					'description' => esc_html__( 'Controls the image box subtitle typography.', 'riode-core' ),
				)
			);

			$this->add_control(
				'subtitle_mg',
				array(
					'label'       => esc_html__( 'Margin', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array(
						'px',
						'em',
						'rem',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'description' => esc_html__( 'Controls the image box subtitle margin.', 'riode-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'description_style',
			array(
				'label' => esc_html__( 'Description', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'description_color',
				array(
					'label'       => esc_html__( 'Color', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .content' => 'color: {{VALUE}};',
					),
					'description' => esc_html__( 'Pick the image box description color.', 'riode-core' ),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'        => 'description_typography',
					'label'       => esc_html__( 'Typography', 'riode-core' ),
					'selector'    => '.elementor-element-{{ID}} .content',
					'description' => esc_html__( 'Controls the image box description typography.', 'riode-core' ),
				)
			);

			$this->add_control(
				'description_mg',
				array(
					'label'       => esc_html__( 'Margin', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array(
						'px',
						'em',
						'rem',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'description' => esc_html__( 'Controls the image box description margin.', 'riode-core' ),
				)
			);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'title' );
		$this->add_inline_editing_attributes( 'subtitle' );
		$this->add_inline_editing_attributes( 'content' );

		include RIODE_CORE_PATH . 'elementor/render/widget-imagebox-render.php';
	}
}
