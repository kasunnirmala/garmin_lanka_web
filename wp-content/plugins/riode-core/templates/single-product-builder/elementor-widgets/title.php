<?php
/**
 * Riode Elementor Single Product Title Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use ELementor\Group_Control_Box_Shadow;

class Riode_Single_Product_Title_Elementor_Widget extends Riode_Heading_Elementor_Widget {

	public function get_name() {
		return 'riode_sproduct_title';
	}

	public function get_title() {
		return esc_html__( 'Product Title', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-product-title';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'name', 'title' );
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
			'section_heading_title',
			array(
				'label' => esc_html__( 'Title', 'riode-core' ),
			)
		);

		$this->add_control(
			'tag',
			array(
				'label'   => esc_html__( 'HTML Tag', 'riode-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'p',
				),
				'default' => 'h2',
			)
		);

		$this->add_control(
			'decoration',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Decoration Type', 'riode-core' ),
				'default' => '',
				'options' => array(
					''          => esc_html__( 'Simple', 'riode-core' ),
					'cross'     => esc_html__( 'Cross', 'riode-core' ),
					'underline' => esc_html__( 'Underline', 'riode-core' ),
				),
			)
		);

		$this->add_control(
			'hide_underline',
			array(
				'label'     => esc_html__( 'Hide Active Underline?', 'riode-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => array(
					'.elementor-element-{{ID}} .title::after' => 'content: none',
				),
				'condition' => array(
					'decoration' => 'underline',
				),
			)
		);

		$this->add_control(
			'title_align',
			array(
				'label'   => esc_html__( 'Title Align', 'riode-core' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'title-left',
				'options' => array(
					'title-left'   => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'title-center' => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'title-right'  => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
			)
		);

		$this->add_responsive_control(
			'decoration_spacing',
			array(
				'label'      => esc_html__( 'Decoration Spacing', 'riode-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .title::before' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .title::after'  => 'margin-left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'decoration' => 'cross',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_title_style',
			array(
				'label' => esc_html__( 'Title', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'title_spacing',
			array(
				'label'      => esc_html__( 'Title Spacing', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'em',
					'%',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '.elementor-element-{{ID}} .title',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_border_style',
			array(
				'label' => esc_html__( 'Border', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'border_color',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .title-cross .title::before, .elementor-element-{{ID}} .title-cross .title::after, .elementor-element-{{ID}} .title-underline::after' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'border_active_color',
			array(
				'label'     => esc_html__( 'Active Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .title-underline .title::after' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'border_height',
			array(
				'label'     => esc_html__( 'Height', 'riode-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .title::before, .elementor-element-{{ID}} .title::after, .elementor-element-{{ID}} .title-wrapper::after' => 'height: {{SIZE}}px;',
				),
			)
		);

		$this->add_control(
			'active_border_height',
			array(
				'label'     => esc_html__( 'Active Border Height', 'riode-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .title-underline .title::after' => 'height: {{SIZE}}px;',
				),
				'condition' => array(
					'decoration' => 'underline',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
			global $product;

			$settings          = $this->get_settings_for_display();
			$settings['title'] = $product->get_name();
			$settings['class'] = 'product_title entry-title';

			$this->add_inline_editing_attributes( 'link_label' );

			include RIODE_CORE_PATH . 'elementor/render/widget-heading-render.php';

			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
