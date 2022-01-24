<?php
/**
 * Riode Elementor Single Product Prev-Next Navigation Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;

class Riode_Single_Product_Navigation_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_sproduct_navigation';
	}

	public function get_title() {
		return esc_html__( 'Product Navigation', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-post-navigation';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'navigation', 'prev', 'next' );
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
			'section_product_navigation',
			array(
				'label' => esc_html__( 'Style', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'sp_align',
				array(
					'label'     => esc_html__( 'Align', 'riode-core' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
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
					'selectors' => array(
						'.elementor-element-{{ID}} .product-navigation' => 'justify-content: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'sp_typo',
					'label'    => esc_html__( 'Typography', 'riode-core' ),
					'selector' => '{{WRAPPER}} .product-nav',
				)
			);

			$this->add_control(
				'sp_size',
				array(
					'type'      => Controls_Manager::SLIDER,
					'label'     => esc_html__( 'Icon Size', 'riode-core' ),
					'range'     => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .product-nav i' => 'font-size: {{SIZE}}px',
					),
					'separator' => 'before',
				)
			);

			$this->add_control(
				'sp_prev_icon',
				array(
					'label'       => esc_html__( 'Prev Icon', 'elementor' ),
					'type'        => Controls_Manager::ICONS,
					'default'     => array(
						'value'   => 'd-icon-arrow-left',
						'library' => 'riode',
					),
					'recommended' => array(
						'fa-solid'   => array(
							'chevron-left',
							'angle-left',
							'angle-double-left',
							'caret-left',
							'caret-square-left',
						),
						'fa-regular' => array(
							'caret-square-left',
						),
					),
					'skin'        => 'inline',
					'label_block' => false,
				)
			);

			$this->add_control(
				'sp_next_icon',
				array(
					'label'       => esc_html__( 'Next Icon', 'elementor' ),
					'type'        => Controls_Manager::ICONS,
					'default'     => array(
						'value'   => 'd-icon-arrow-right',
						'library' => 'riode',
					),
					'recommended' => array(
						'fa-solid'   => array(
							'chevron-right',
							'angle-right',
							'angle-double-right',
							'caret-right',
							'caret-square-right',
						),
						'fa-regular' => array(
							'caret-square-right',
						),
					),
					'skin'        => 'inline',
					'label_block' => false,
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
						'sp_a_color',
						array(
							'label'     => esc_html__( 'Link Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .product-nav li>a' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'sp_hover_tab',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

					$this->add_control(
						'sp_a_color_hover',
						array(
							'label'     => esc_html__( 'Link Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .product-nav li>a:hover' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'sp_disable_tab',
					array(
						'label' => esc_html__( 'Disabled', 'riode-core' ),
					)
				);

					$this->add_control(
						'sp_a_color_disable',
						array(
							'label'     => esc_html__( 'Link Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .product-nav li.disabled>a' => 'color: {{VALUE}};',
								'{{WRAPPER}} .product-nav li.disabled'   => 'opacity: 1;',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function get_prev_icon() {
		return $this->prev_icon;
	}

	public function get_next_icon() {
		return $this->next_icon;
	}

	protected function render() {
		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {

			$settings = $this->get_settings_for_display();

			$this->prev_icon = $settings['sp_prev_icon']['value'];
			$this->next_icon = $settings['sp_next_icon']['value'];

			add_filter( 'riode_check_single_next_prev_nav', '__return_true' );
			add_filter( 'riode_single_product_nav_prev_icon', array( $this, 'get_prev_icon' ) );
			add_filter( 'riode_single_product_nav_next_icon', array( $this, 'get_next_icon' ) );

			echo '<div class="product-navigation">' . riode_single_product_navigation() . '</div>';

			remove_filter( 'riode_check_single_next_prev_nav', '__return_true' );
			remove_filter( 'riode_single_product_nav_prev_icon', array( $this, 'get_prev_icon' ) );
			remove_filter( 'riode_single_product_nav_next_icon', array( $this, 'get_next_icon' ) );

			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
