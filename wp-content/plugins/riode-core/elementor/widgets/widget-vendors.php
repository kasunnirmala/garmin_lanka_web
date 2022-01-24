<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Riode Vendors Widget
 *
 * Widget to display vendors
 *
 * @since 1.0
 * @package riode-core
 */

if ( ! class_exists( 'WeDevs_Dokan' ) ) {
	return;
}

use Elementor\Controls_Manager;
use Elementor\Riode_Controls_Manager;

class Riode_Vendors_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'riode_widget_vendors';
	}

	public function get_title() {
		return esc_html__( 'Vendors', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-vendors';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'vendors', 'dokan', 'wcfm', 'wcvendor', 'customer' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {

		// Select Vendors
		$this->start_controls_section(
			'section_vendors_selector',
			array(
				'label' => esc_html__( 'Vendors Selector', 'riode-core' ),
			)
		);

		if ( class_exists( 'WeDevs_Dokan' ) || class_exists( 'WCFM' ) ) {
			$this->add_control(
				'vendor_select_type',
				array(
					'label'       => esc_html__( 'Select', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'individual',
					'options'     => array(
						'individual' => esc_html__( 'Individually', 'riode-core' ),
						'group'      => esc_html__( 'Group', 'riode-core' ),
					),
					'description' => esc_html__( 'Allows you to choose certain method to select vendors.', 'riode-core' ),
				)
			);

			$this->add_control(
				'vendor_ids',
				array(
					'label'       => esc_html__( 'Select Vendors', 'riode-core' ),
					'type'        => 'riode_ajaxselect2',
					'object_type' => 'vendors',
					'label_block' => true,
					'multiple'    => true,
					'default'     => '',
					'condition'   => array(
						'vendor_select_type' => array( 'individual' ),
					),
					'description' => esc_html__( 'Allows you to select certain vendors by typing their names.', 'riode-core' ),
				)
			);

			$this->add_control(
				'vendor_type',
				array(
					'label'       => esc_html__( 'Vendor Type', 'riode-core' ),
					'description' => esc_html__( 'Select certain group of vendors(ex: top selling, top rating and etc).', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => array(
						''       => esc_html__( 'General', 'riode-core' ),
						'sale'   => esc_html__( 'Top Selling Vendors', 'riode-core' ),
						'rating' => esc_html__( 'Top Rating Vendors', 'riode-core' ),
						// 'featured' => esc_html__( 'Featured Vendors', 'riode-core' ),
						'recent' => esc_html__( 'Newly Added Vendors', 'riode-core' ),
					),
					'condition'   => array(
						'vendor_select_type' => array( 'group' ),
					),
				)
			);

			$this->add_control(
				'vendor_count',
				array(
					'label'       => esc_html( 'Vendor Count', 'riode-core' ),
					'description' => esc_html__( 'Type a number of vendors which are shown.', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '4',
					'condition'   => array(
						'vendor_select_type' => array( 'group' ),
					),
				)
			);
		}

		$this->end_controls_section();

		// Select Vendor Layouts
		$this->start_controls_section(
			'section_vendors_layout',
			array(
				'label' => esc_html__( 'Layout', 'riode-core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'       => esc_html__( 'Vendors Layout', 'riode-core' ),
					'description' => esc_html__( 'Select a certain layout for displaying your vendors.', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'grid',
					'options'     => array(
						'grid'   => esc_html__( 'Grid', 'riode-core' ),
						'slider' => esc_html__( 'Slider', 'riode-core' ),
					),
				)
			);

			riode_elementor_grid_layout_controls( $this, 'layout_type' );

		$this->end_controls_section();

		// Select Vendor Display Type
		$this->start_controls_section(
			'section_display_type',
			array(
				'label' => esc_html__( 'Vendor Type', 'riode-core' ),
			)
		);

			$this->add_control(
				'vendor_display_type',
				array(
					'label'       => esc_html__( 'Display Type', 'riode-core' ),
					'description' => esc_html__( 'Select a certain display type for your vendors.', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '1',
					'options'     => array(
						'1' => esc_html__( 'Type 1', 'riode-core' ),
						'2' => esc_html__( 'Type 2', 'riode-core' ),
						'3' => esc_html__( 'Type 3', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'show_vendor_rating',
				array(
					'label'       => esc_html__( 'Show Vendor Rating', 'riode-core' ),
					'description' => esc_html__( 'Toggle for making your vendors have ratings or not.', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'vendor_display_type!' => '2',
					),
				)
			);

			$this->add_control(
				'show_total_sale',
				array(
					'label'       => esc_html__( 'Show Total Sale', 'riode-core' ),
					'description' => esc_html__( 'Toggle for making your vendors have total sales or not.', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'vendor_display_type' => array( '1', '2' ),
					),
				)
			);

		$this->end_controls_section();

		riode_elementor_slider_style_controls(
			$this,
			'',
			array(
				'show_dots' => true,
				'show_nav'  => false,
			)
		);
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-vendors-render.php';
	}
}
