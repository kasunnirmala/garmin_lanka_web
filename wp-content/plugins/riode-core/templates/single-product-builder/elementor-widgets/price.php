<?php
/**
 * Riode Elementor Single Product Price Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;

class Riode_Single_Product_Price_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_sproduct_price';
	}

	public function get_title() {
		return esc_html__( 'Product Price', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-product-price';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'price' );
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
			'section_product_price',
			array(
				'label' => esc_html__( 'Style', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'sp_title_align',
				array(
					'label'     => esc_html__( 'Align', 'riode-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
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
					'selectors' => array(
						'{{WRAPPER}} p.price' => 'text-align: {{VALUE}};',
					),
				)
			);

			$this->start_controls_tabs( 'sp_tabs' );
				$this->start_controls_tab(
					'sp_normal_tab',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

				$this->add_control(
					'sp_normal_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'{{WRAPPER}} p.price' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'sp_typo',
						'label'    => esc_html__( 'Typography', 'riode-core' ),
						'selector' => '{{WRAPPER}} p.price',
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_new_tab',
					array(
						'label' => esc_html__( 'New', 'riode-core' ),
					)
				);

				$this->add_control(
					'sp_new_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'{{WRAPPER}} ins' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'sp_typo_new',
						'label'    => esc_html__( 'Typography', 'riode-core' ),
						'selector' => '{{WRAPPER}} p.price ins',
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_old_tab',
					array(
						'label' => esc_html__( 'Old', 'riode-core' ),
					)
				);

				$this->add_control(
					'sp_old_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'{{WRAPPER}} del' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'sp_typo_old',
						'label'    => esc_html__( 'Typography', 'riode-core' ),
						'selector' => '{{WRAPPER}} p.price del',
					)
				);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
			woocommerce_template_single_price();
			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
