<?php
/**
 * Riode Elementor Single Product Ratings Widget
 */
defined( 'ABSPATH' ) || die;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


class Riode_Single_Product_Rating_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_sproduct_rating';
	}

	public function get_title() {
		return esc_html__( 'Product Rating', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-product-rating';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'rating', 'reviews' );
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
			'section_product_rating',
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
						'flext-start' => array(
							'title' => esc_html__( 'Left', 'riode-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'      => array(
							'title' => esc_html__( 'Center', 'riode-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'    => array(
							'title' => esc_html__( 'Right', 'riode-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .woocommerce-product-rating' => 'justify-content: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'heading_star_style',
				array(
					'label'     => esc_html__( 'Star', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_responsive_control(
				'icon_size',
				array(
					'label'     => esc_html__( 'Size', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_responsive_control(
				'icon_space',
				array(
					'label'     => esc_html__( 'Spacing', 'riode-core' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 50,
						),
					),
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating' => 'letter-spacing: {{SIZE}}{{UNIT}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_control(
				'stars_color',
				array(
					'label'     => esc_html__( 'Empty Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating:before' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_control(
				'stars_unmarked_color',
				array(
					'label'     => esc_html__( 'Full Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .star-rating span:after' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_type' => 'star',
					),
				)
			);

			$this->add_control(
				'sp_reviews',
				array(
					'label'     => esc_html__( 'Reviews', 'riode-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'riode-core' ),
					'label_on'  => esc_html__( 'Show', 'riode-core' ),
					'default'   => 'yes',
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'sp_review_typo',
					'label'     => esc_html__( 'Typography', 'riode-core' ),
					'selector'  => '.elementor-element-{{ID}} .woocommerce-review-link',
					'condition' => array(
						'sp_reviews' => 'yes',
					),
				)
			);

			$this->add_control(
				'sp_review_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .woocommerce-review-link' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_reviews' => 'yes',
					),
				)
			);

			$this->add_control(
				'sp_review_hover_color',
				array(
					'label'     => esc_html__( 'Hover Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .woocommerce-review-link:hover' => 'color: {{VALUE}}',
					),
					'condition' => array(
						'sp_reviews' => 'yes',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {

			$settings = $this->get_settings_for_display();

			if ( '' == $settings['sp_reviews'] ) {
				add_filter( 'riode_single_product_show_review', '__return_false' );
			}

			woocommerce_template_single_rating();

			if ( '' == $settings['sp_reviews'] ) {
				remove_filter( 'riode_single_product_show_review', '__return_false' );
			}

			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
