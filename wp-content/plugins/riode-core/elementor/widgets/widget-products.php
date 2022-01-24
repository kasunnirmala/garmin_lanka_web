<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Products Widget
 *
 * Riode Widget to display products.
 *
 * @since 1.0
 */

class Riode_Products_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_products';
	}

	public function get_title() {
		return esc_html__( 'Products', 'riode-core' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-products';
	}

	public function get_script_depends() {
		$depends = array( 'owl-carousel' );
		if ( riode_is_elementor_preview() ) {
			$depends[] = 'riode-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		riode_elementor_products_select_controls( $this );

		riode_elementor_products_layout_controls( $this );

		riode_elementor_product_type_controls( $this );

		riode_elementor_slider_style_controls( $this, 'layout_type' );

		riode_elementor_product_style_controls( $this );

		riode_elementor_loadmore_button_controls( $this, 'layout_type' );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-products-render.php';
	}

	protected function content_template() {}
}
