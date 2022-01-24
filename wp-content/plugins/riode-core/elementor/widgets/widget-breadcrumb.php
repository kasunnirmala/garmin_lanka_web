<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Breadcrumb Widget
 *
 * Riode Widget to display breadcrumb.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Riode_Breadcrumb_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_breadcrumb';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumb', 'riode-core' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-breadcrumb';
	}

	public function get_keywords() {
		return array( 'breadcrumb', 'riode-core' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_breadcrumb',
			array(
				'label' => esc_html__( 'Breadcrumb', 'riode-core' ),
			)
		);

			$this->add_control(
				'breadcrumb_description',
				array(
					'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s In most case breadcrumb is placed on page header, so its default color is %2$swhite%3$s. Please choose different color in %2$sstyle options section%3$s for other purposes.%4$s', 'riode-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
					'type'        => 'riode_description',
				)
			);

			$this->add_control(
				'delimiter',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Breadcrumb Delimiter', 'riode-core' ),
					'description' => esc_html__( 'Changes breadcrumb delimiter text between each links.', 'riode-core' ),
					'placeholder' => esc_html__( '/', 'riode-core' ),
				)
			);

			$this->add_control(
				'delimiter_icon',
				array(
					'label'       => esc_html__( 'Delimiter Icon', 'riode-core' ),
					'type'        => Controls_Manager::ICONS,
					'description' => esc_html__( 'Choose delimiter icon that will be placed between each links.', 'riode-core' ),
				)
			);

			$this->add_control(
				'home_icon',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Show Home Icon', 'riode-core' ),
					'description' => esc_html__( "Set to show home icon instead of 'home' link.", 'riode-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_breadcrumb_style',
			array(
				'label' => esc_html__( 'Breadcrumb Style', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'        => 'breadcrumb_typography',
					'label'       => esc_html__( 'Breadcrumb Typography', 'riode-core' ),
					'scheme'      => Typography::TYPOGRAPHY_1,
					'selector'    => '.elementor-element-{{ID}} .breadcrumb',
					'description' => esc_html__( 'Controls font family, size, weight, line height and letter spacing value of breadcrumb links.', 'riode-core' ),
				)
			);

			$this->add_responsive_control(
				'align',
				array(
					'label'       => esc_html__( 'Align', 'riode-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'description' => esc_html__( 'Changes alignment of breadcrumb. Choose from left, center, right.', 'riode-core' ),
					'options'     => array(
						'flex-start' => array(
							'title' => esc_html__( 'Left', 'riode-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => esc_html__( 'Center', 'riode-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => esc_html__( 'Right', 'riode-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .breadcrumb' => 'justify-content: {{VALUE}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_link_col' );
				$this->start_controls_tab(
					'tab_link_col',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

					$this->add_control(
						'link_color',
						array(
							'label'       => esc_html__( 'Color', 'riode-core' ),
							'type'        => Controls_Manager::COLOR,
							'description' => esc_html__( 'Choose normal text color of breadcrumb links. Default color is white with 0.5 opacity.', 'riode-core' ),
							'selectors'   => array(
								'.elementor-element-{{ID}} .breadcrumb' => 'color: {{VALUE}};',
								'.elementor-element-{{ID}} .breadcrumb a' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_link_col_active',
					array(
						'label' => esc_html__( 'Active', 'riode-core' ),
					)
				);

					$this->add_control(
						'link_color_active',
						array(
							'label'       => esc_html__( 'Color', 'riode-core' ),
							'type'        => Controls_Manager::COLOR,
							'description' => esc_html__( 'Choose active or hover color of breadcrumb links. Default color is white.', 'riode-core' ),
							'selectors'   => array(
								'.elementor-element-{{ID}} .breadcrumb' => 'color: {{VALUE}};',
								'.elementor-element-{{ID}} .breadcrumb a' => 'opacity: 1;',
								'.elementor-element-{{ID}} .breadcrumb a:hover' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'delimiter_size',
				array(
					'label'       => esc_html__( 'Delimiter Size', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'description' => esc_html__( 'Controls size of breadcrumb delimiter text or icon.', 'riode-core' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units'  => array(
						'px',
						'%',
						'rem',
					),
					'separator'   => 'before',
					'selectors'   => array(
						'.elementor-element-{{ID}} .delimiter' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'delimiter_space',
				array(
					'label'       => esc_html__( 'Delimiter Space', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'description' => esc_html__( 'Controls space between breadcrumb links.', 'riode-core' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units'  => array(
						'px',
						'rem',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .delimiter' => 'margin: 0 {{SIZE}}{{UNIT}}',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-breadcrumb-render.php';
	}

	protected function content_template() {}
}
