<?php
/**
 * Riode Elementor Single Product Linked Products Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;

class Riode_Single_Product_Linked_Products_Elementor_Widget extends Riode_Products_Elementor_Widget {

	public function get_name() {
		return 'riode_sproduct_linked_products';
	}

	public function get_title() {
		return esc_html__( 'Linked Products', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-product-related';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'linked_products' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( riode_is_elementor_preview() ) {
			$depends[] = 'riode-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {
		parent::register_controls();

		$this->remove_control( 'product_ids' );
		$this->remove_control( 'categories' );

		$this->update_control(
			'status',
			array(
				'label'   => esc_html__( 'Product Status', 'riode-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'related',
				'options' => array(
					'related' => esc_html__( 'Related Products', 'riode-core' ),
					'upsell'  => esc_html__( 'Upsell Products', 'riode-core' ),
				),
			)
		);
	}

	protected function render() {
		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
			parent::render();
			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
