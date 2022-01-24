<?php
/**
 * Riode Single Product Elementor Cart Form
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class Riode_Single_Product_Cart_Form_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_sproduct_cart_form';
	}

	public function get_title() {
		return esc_html__( 'Product Cart Form', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-product-add-to-cart';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'cart_form', 'variation' );
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
			'section_cf_content',
			array(
				'label' => esc_html__( 'Content', 'riode-core' ),
			)
		);

			$this->add_control(
				'sp_sticky',
				array(
					'label' => esc_html__( 'Add To Cart Sticky', 'riode-core' ),
					'type'  => Controls_Manager::SWITCHER,
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cf_variations_style',
			array(
				'label' => esc_html__( 'Variations', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'heading_variations_label_style',
				array(
					'label'     => esc_html__( 'Label', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'sp_variations_label_color_focus',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .cart .label' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_variations_label_typo',
					'selector' => '.elementor-element-{{ID}} .cart .label',
				)
			);

			$this->add_responsive_control(
				'sp_variations_label_width',
				array(
					'label'     => esc_html__( 'Width', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 50,
							'max'  => 500,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .cart .label' => 'min-width: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$this->add_control(
				'heading_variations_swatch_style',
				array(
					'label'     => esc_html__( 'Variation Swatches', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_responsive_control(
				'sp_variations_list_size',
				array(
					'label'     => esc_html__( 'Swatch Size', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-variations button' => 'min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
						'.elementor-element-{{ID}} .list-type' => 'line-height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'sp_variations_list_border_radius',
				array(
					'label'     => esc_html__( 'Border Radius', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => array(
						'.elementor-element-{{ID}} .variations button' => 'border-radius: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$this->add_control(
				'heading_variations_select_style',
				array(
					'label'     => esc_html__( 'Variation Dropdowns', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_variations_select_typo',
					'selector' => '.elementor-element-{{ID}} .cart select',
				)
			);

			$this->add_control(
				'sp_variations_select_border_radius',
				array(
					'label'     => esc_html__( 'Border Radius', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => array(
						'.elementor-element-{{ID}} .cart select' => 'border-radius: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$this->add_responsive_control(
				'sp_variations_select_width',
				array(
					'label'     => esc_html__( 'Width', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 50,
							'max'  => 500,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .cart select' => 'width: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$this->add_responsive_control(
				'sp_variations_select_height',
				array(
					'label'     => esc_html__( 'Height', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => array(
						'.elementor-element-{{ID}} .cart select' => 'height: {{SIZE}}{{UNIT}}',
						'.elementor-element-{{ID}} .select-type' => 'line-height: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$this->add_control(
				'heading_variations_divider_style',
				array(
					'label'     => esc_html__( 'Divider Style', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'sp_qty_divider_color',
				array(
					'label'     => esc_html__( 'Divider Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-divider' => 'border-top-color: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'sp_qty_divider_space',
				array(
					'label'      => esc_html__( 'Divider Spacing', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-divider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cf_qty_form_style',
			array(
				'label' => esc_html__( 'Quantity Form', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'heading_qty_form_style',
				array(
					'label'     => esc_html__( 'QTY Form Style', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_qty_typo',
					'selector' => '.elementor-element-{{ID}} .quantity .qty,.elementor-element-{{ID}} .quantity button',
				)
			);

			$this->add_responsive_control(
				'sp_qty_form_width',
				array(
					'label'     => esc_html__( 'Width', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 200,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .quantity .qty' => 'width: calc(48px * {{SIZE}} / 100);',
						'.elementor-element-{{ID}} .quantity button' => 'padding: 8px calc(8px * {{SIZE}} / 100);',
					),
				)
			);

			$this->add_responsive_control(
				'sp_qty_form_height',
				array(
					'label'     => esc_html__( 'Height', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => array(
						'.elementor-element-{{ID}} .quantity' => 'height: {{SIZE}}{{UNIT}}',
						'.elementor-element-{{ID}} .button' => 'height: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$this->add_responsive_control(
				'sp_qty_form_br',
				array(
					'label'     => esc_html__( 'Border Radius', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => array(
						'.elementor-element-{{ID}} .quantity .quantity-minus' => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .quantity .quantity-plus' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;',
						'.elementor-element-{{ID}} .button' => 'border-radius: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'sp_qty_form_space',
				array(
					'label'     => esc_html__( 'Space', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => array(
						'.elementor-element-{{ID}} .quantity' => 'margin-right: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'heading_button_style',
				array(
					'label'     => esc_html__( 'Add to Cart Button', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_btn_typo',
					'selector' => '.elementor-element-{{ID}} .cart .button',
				)
			);

			$this->add_responsive_control(
				'sp_btn_width',
				array(
					'label'      => esc_html__( 'Width', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'em', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .button' => 'padding: 0; width: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'sp_btn_style_tabs' );

				$this->start_controls_tab(
					'sp_btn_style_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

					$this->add_control(
						'sp_btn_text_color',
						array(
							'label'     => esc_html__( 'Text Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .cart .button' => 'color: {{VALUE}}',
							),
						)
					);

					$this->add_control(
						'sp_btn_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .cart .button' => 'background-color: {{VALUE}}',
							),
						)
					);

					$this->add_control(
						'sp_btn_border_color',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .cart .button' => 'border-color: {{VALUE}}',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_btn_style_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

					$this->add_control(
						'sp_btn_text_color_hover',
						array(
							'label'     => esc_html__( 'Text Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .cart .button:hover' => 'color: {{VALUE}}',
							),
						)
					);

					$this->add_control(
						'sp_btn_bg_color_hover',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .cart .button:hover' => 'background-color: {{VALUE}}',
							),
						)
					);

					$this->add_control(
						'sp_btn_border_color_hover',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .cart .button:hover' => 'border-color: {{VALUE}}',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sp_btn_style_disabled',
					array(
						'label' => esc_html__( 'Disabled', 'riode-core' ),
					)
				);

					$this->add_control(
						'sp_btn_text_color_disabled',
						array(
							'label'     => esc_html__( 'Text Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .cart .button.disabled' => 'color: {{VALUE}}',
							),
						)
					);

					$this->add_control(
						'sp_btn_bg_color_disabled',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .cart .button.disabled' => 'background-color: {{VALUE}}',
							),
						)
					);

					$this->add_control(
						'sp_btn_border_color_disabled',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .cart .button.disabled' => 'border-color: {{VALUE}}',
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

			if ( 'yes' == $settings['sp_sticky'] ) {
				add_filter( 'riode_single_product_sticky_cart_enabled', '__return_true' );
			}

			woocommerce_template_single_add_to_cart();

			if ( 'yes' == $settings['sp_sticky'] ) {
				remove_filter( 'riode_single_product_sticky_cart_enabled', '__return_true' );
			}

			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
