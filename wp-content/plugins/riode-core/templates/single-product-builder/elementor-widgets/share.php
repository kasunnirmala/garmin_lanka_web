<?php
/**
 * Riode Elementor Single Product Share Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

class Riode_Single_Product_Share_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_sproduct_share';
	}

	public function get_title() {
		return esc_html__( 'Product Share', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-share';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'share' );
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
			'section_product_share',
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
						'.elementor-element-{{ID}} .social-icons' => 'justify-content: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'sp_social_style',
				array(
					'label'       => 'Note:',
					'description' => sprintf( esc_html__( 'Note: You can customize product share styles in %s', 'riode-core' ), '<a href="' . wp_customize_url() . '#share" data-target="share" data-type="section" target="_blank">' . esc_html__( 'Customize Panel/Share', 'riode-core' ) . '</a>.' ),
					'type'        => 'riode_description',
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
			woocommerce_template_single_sharing();
			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
