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

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Riode_Products_Banner_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_products_banner';
	}

	public function get_title() {
		return esc_html__( 'Banner + Products', 'riode-core' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce', 'banner' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-products-banner';
	}

	protected function register_controls() {

		riode_elementor_products_layout_controls( $this, 'custom_layouts' );

		riode_elementor_banner_controls( $this, 'insert_number' );

		riode_elementor_products_select_controls( $this );

		riode_elementor_product_type_controls( $this );

		riode_elementor_slider_style_controls( $this, 'layout_type' );

		riode_elementor_product_style_controls( $this );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-products-banner-render.php';
	}

	protected function content_template() {}
}
