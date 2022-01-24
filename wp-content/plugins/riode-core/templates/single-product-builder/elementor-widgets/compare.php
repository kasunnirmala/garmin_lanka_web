<?php
/**
 * Riode Single Product Elementor Compare
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Riode_Single_Product_Compare_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_sproduct_compare';
	}

	public function get_title() {
		return esc_html__( 'Product Compare', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon d-icon-compare';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'compare' );
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
			'section_compare_style',
			array(
				'label' => esc_html__( 'Compare', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'compare_typography',
					'selector' => '.elementor-element-{{ID}} .compare',
				)
			);

			$this->add_responsive_control(
				'compare_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .compare::before' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'compare_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .compare::before' => 'margin-' . $right . ': {{SIZE}}px;',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_compare_color' );
				$this->start_controls_tab(
					'tab_compare_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

				$this->add_control(
					'compare_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .compare' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_compare_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

				$this->add_control(
					'compare_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .compare:hover' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {

		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {

			$settings = $this->get_settings_for_display();

			riode_single_product_compare();

			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
