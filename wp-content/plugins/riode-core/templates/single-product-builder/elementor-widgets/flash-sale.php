<?php
/**
 * Riode Elementor Single Product Flash Sale Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

class Riode_Single_Product_Flash_Sale_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_sproduct_flash_sale';
	}

	public function get_title() {
		return esc_html__( 'Product Flash Sale', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-countdown';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'flash', 'sale', 'countdown' );
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
			'section_product_flash_content',
			array(
				'label' => esc_html__( 'Content', 'riode-core' ),
			)
		);

			$this->add_control(
				'sp_flash_sale_heading',
				array(
					'description'            => sprintf( esc_html__( '%1$sThis element shows countdown box for on-sale product. This element will not be shown for product without sale end date. Fake countdown box is only for preview page.%2$s', 'riode-core' ), '<span class="important-note">', '</span>' ),
					'type'             => 'riode_description',
				)
			);

			$this->add_control(
				'sp_icon',
				array(
					'label'            => esc_html__( 'Icon', 'riode-core' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => array(
						'value'   => 'd-icon-check',
						'library' => '',
					),
					'skin'             => 'inline',
					'label_block'      => false,
				)
			);

			$this->add_control(
				'sp_label',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Label', 'riode-core' ),
					'placeholder' => esc_html__( 'Flash Deals', 'riode-core' ),
				)
			);

			$this->add_control(
				'sp_ends_label',
				array(
					'label'       => esc_html__( 'End Label', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Ends in:', 'riode-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_flash_style',
			array(
				'label' => esc_html__( 'Style', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'sp_back_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-countdown-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'sp_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-countdown-container' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'heading_labels_style',
				array(
					'label'     => esc_html__( 'Label', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_label_typo',
					'selector' => '.elementor-element-{{ID}} .product-sale-info',
				)
			);

			$this->add_control(
				'label_icon_size',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-sale-info i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'label_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-sale-info i' => 'margin-right: {{SIZE}}px;',
					)
				)
			);

			$this->add_control(
				'sp_label_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-sale-info' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'heading_countdown_style',
				array(
					'label'     => esc_html__( 'Countdown', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_ends_typo',
					'selector' => '.elementor-element-{{ID}} .countdown-wrap',
				)
			);

			$this->add_control(
				'sp_ends_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .countdown-wrap' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'heading_divider_style',
				array(
					'label'     => esc_html__( 'Divider', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'sp_divider_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-sale-info::after' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'sp_divider_width',
				array(
					'label'      => esc_html__( 'Width (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-sale-info::after' => 'width: {{SIZE}}px;',
					)
				)
			);

			$this->add_control(
				'sp_divider_height',
				array(
					'label'      => esc_html__( 'Height (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-sale-info::after' => 'height: {{SIZE}}px;',
					)
				)
			);

			$this->add_control(
				'sp_divider_space',
				array(
					'label'      => esc_html__( 'Space (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-sale-info::after' => 'margin-left: {{SIZE}}px; marign-right: {{SIZE}}px;',
					)
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
			global $product;

			if ( function_exists( 'riode_single_product_sale_countdown' ) ) {
				$settings = $this->get_settings_for_display();

				ob_start();
				Icons_Manager::render_icon( $settings['sp_icon'] );
				$icon_html = ob_get_clean();

				riode_single_product_sale_countdown( $settings['sp_label'], $settings['sp_ends_label'], $icon_html );
			}
			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
