<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Block Widget
 *
 * Riode Widget to display custom block.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;

class Riode_Block_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_block';
	}

	public function get_title() {
		return esc_html__( 'Block', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-block';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'block' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_block',
			array(
				'label' => esc_html__( 'Block', 'riode-core' ),
			)
		);

			$this->add_control(
				'name',
				array(
					'type'        => 'riode_ajaxselect2',
					'label'       => esc_html__( 'Block Slug or ID', 'riode-core' ),
					'description' => esc_html__( 'Choose your favourite block from pre-built blocks.', 'riode-core' ),
					'object_type' => 'riode_template',
					'label_block' => true,
				)
			);
		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-block-render.php';
	}

	protected function content_template() {}
}
