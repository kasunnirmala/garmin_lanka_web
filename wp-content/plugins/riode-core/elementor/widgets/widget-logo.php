<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Logo Widget
 *
 * Riode Widget to display site logo.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

class Riode_Logo_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_logo';
	}

	public function get_title() {
		return esc_html__( 'Logo', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-logo';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'image', 'site', 'riode', 'dynamic', 'logo' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_logo_content',
			array(
				'label' => esc_html__( 'Image', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'        => 'logo', // Usage: `{name}_size` and `{name}_custom_dimension`
					'default'     => 'full',
					'description' => esc_html__( 'Choose image size for logo image. Choose from registered image sizes of WordPress and other plugins.', 'riode-core' ),
				)
			);

			$this->start_controls_tabs( 'tabs_logo' );

				$this->start_controls_tab(
					'tab_logo_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

					$this->add_responsive_control(
						'logo_width',
						array(
							'label'       => esc_html__( 'Width', 'riode-core' ),
							'type'        => Controls_Manager::SLIDER,
							'size_units'  => array( 'px', 'rem', '%' ),
							'description' => esc_html__( 'Controls width of logo image.', 'riode-core' ),
							'selectors'   => array(
								'.elementor-element-{{ID}} .logo' => 'width: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$this->add_responsive_control(
						'logo_max_width',
						array(
							'label'       => esc_html__( 'Max Width', 'riode-core' ),
							'type'        => Controls_Manager::SLIDER,
							'size_units'  => array( 'px', 'rem', '%' ),
							'description' => esc_html__( 'Controls max width of logo image.', 'riode-core' ),
							'selectors'   => array(
								'.elementor-element-{{ID}} .logo' => 'max-width: {{SIZE}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_logo_sticky',
					array(
						'label' => esc_html__( 'Sticky', 'riode-core' ),
					)
				);

					$this->add_responsive_control(
						'logo_width_sticky',
						array(
							'label'       => esc_html__( 'Width', 'riode-core' ),
							'type'        => Controls_Manager::SLIDER,
							'size_units'  => array( 'px', 'rem', '%' ),
							'description' => esc_html__( 'Controls width of logo image when it is sticked.', 'riode-core' ),
							'selectors'   => array(
								'.fixed .elementor-element-{{ID}} .logo' => 'width: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$this->add_responsive_control(
						'logo_max_width_sticky',
						array(
							'label'       => esc_html__( 'Max Width', 'riode-core' ),
							'type'        => Controls_Manager::SLIDER,
							'size_units'  => array( 'px', 'rem', '%' ),
							'description' => esc_html__( 'Controls max width of logo image when it is sticked.', 'riode-core' ),
							'selectors'   => array(
								'.fixed .elementor-element-{{ID}} .logo' => 'max-width: {{SIZE}}{{UNIT}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$args     = array(
			'logo_size' => $settings['logo_size'],
		);

		if ( defined( 'RIODE_VERSION' ) ) {
			riode_get_template_part( RIODE_PART . '/header/elements/element', 'logo', $args );
		}
	}
}
