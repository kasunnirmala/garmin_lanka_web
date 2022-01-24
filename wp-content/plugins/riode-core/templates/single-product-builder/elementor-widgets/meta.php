<?php
/**
 * Riode Elementor Single Product Meta Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;

class Riode_Single_Product_Meta_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_sproduct_meta';
	}

	public function get_title() {
		return esc_html__( 'Product Meta', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-product-meta';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'meta' );
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
			'section_product_meta',
			array(
				'label' => esc_html__( 'Style', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'sp_type',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Meta Direction', 'riode-core' ),
					'options'   => array(
						'block' => esc_html__( 'Vertical', 'riode-core' ),
						''      => esc_html__( 'Horizontal', 'riode-core' ),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .product_meta > *' => 'display: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'sp_align',
				array(
					'label'     => esc_html__( 'Align', 'riode-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'    => array(
							'title' => esc_html__( 'Left', 'riode-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => esc_html__( 'Center', 'riode-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'   => array(
							'title' => esc_html__( 'Right', 'riode-core' ),
							'icon'  => 'eicon-text-align-right',
						),
						'justify' => array(
							'title' => esc_html__( 'Justified', 'riode-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .product_meta' => 'text-align: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'divider',
				array(
					'label'        => esc_html__( 'Divider', 'riode-core' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'Off', 'riode-core' ),
					'label_on'     => esc_html__( 'On', 'riode-core' ),
					'selectors'    => array(
						'.elementor-element-{{ID}} .product_meta>:not(:last-child):after' => 'content: ""',
					),
					'return_value' => 'yes',
					'separator'    => 'before',
				)
			);

			$this->add_control(
				'divider_style',
				array(
					'label'     => esc_html__( 'Style', 'riode-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'solid'  => esc_html__( 'Solid', 'riode-core' ),
						'double' => esc_html__( 'Double', 'riode-core' ),
						'dotted' => esc_html__( 'Dotted', 'riode-core' ),
						'dashed' => esc_html__( 'Dashed', 'riode-core' ),
					),
					'default'   => 'solid',
					'condition' => array(
						'divider' => 'yes',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .product_meta>:not(:last-child):after' => 'border-style: {{VALUE}}; border-width: 0;',
					),
				)
			);

			$this->add_control(
				'divider_weight_v',
				array(
					'label'     => esc_html__( 'Width', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 1,
					),
					'range'     => array(
						'px' => array(
							'min' => 1,
							'max' => 20,
						),
					),
					'condition' => array(
						'divider' => 'yes',
						'sp_type' => 'block',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .product_meta>:not(:last-child):after' => 'display: block; border-top-width: {{SIZE}}{{UNIT}}; margin-bottom: calc(-{{SIZE}}{{UNIT}}/2)',
					),
				)
			);

			$this->add_control(
				'divider_weight',
				array(
					'label'     => esc_html__( 'Width', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 1,
					),
					'range'     => array(
						'px' => array(
							'min' => 1,
							'max' => 20,
						),
					),
					'condition' => array(
						'divider' => 'yes',
						'sp_type' => '',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .product_meta>:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}; margin-left: 2rem',
					),
				)
			);

			$this->add_control(
				'divider_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ddd',
					'condition' => array(
						'divider' => 'yes',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .product_meta>:not(:last-child):after' => 'border-color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'heading_text_style',
				array(
					'label'     => esc_html__( 'Text', 'riode-core' ),
					'separator' => 'before',
					'type'      => Controls_Manager::HEADING,
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_typo',
					'label'    => esc_html__( 'Typography', 'riode-core' ),
					'selector' => '.elementor-element-{{ID}} .product_meta',
				)
			);

			$this->add_control(
				'text_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product_meta' => 'color: {{VALUE}}',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
			woocommerce_template_single_meta();
			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
