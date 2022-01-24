<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Riode Testimonial Widget
 *
 * Riode Widget to display testimonial.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use ELementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Riode_Testimonial_Group_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_testimonial_group';
	}

	public function get_title() {
		return esc_html__( 'Testimonial Group', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-testimonial-group';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'testimonial', 'rating', 'comment', 'review', 'customer', 'slider', 'grid', 'group' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_testimonial_group',
			array(
				'label' => esc_html__( 'Testimonials', 'riode-core' ),
			)
		);

			$repeater = new Repeater();

			riode_elementor_testimonial_content_controls( $repeater );

			$presets = [
				[
					'name'    => 'John Doe',
					'job'     => 'Programmer',
					'title'   => '',
					'content' => 'There are many good electronics in Riode Shop.',
				],
				[
					'name'    => 'Henry Harry',
					'job'     => 'Banker',
					'title'   => '',
					'content' => 'Here, shopping is very convenient and trustful.',
				],
				[
					'name'    => 'Tom Jakson',
					'job'     => 'Vendor',
					'title'   => '',
					'content' => 'I love customers and I will be loyal to them.',
				],
				[
					'name'    => 'Jane Doe',
					'job'     => 'CEO',
					'title'   => '',
					'content' => 'I love customers and I will be loyal to them.',
				],
			];

			$this->add_control(
				'testimonial_group_list',
				[
					'label'   => esc_html__( 'Testimonial Group', 'riode-core' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => $presets,
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_testimonials_layout',
			array(
				'label' => esc_html__( 'Testimonials Layout', 'riode core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'   => esc_html__( 'Testimonials Layout', 'riode-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'grid',
					'options' => array(
						'grid'   => esc_html__( 'Grid', 'riode-core' ),
						'slider' => esc_html__( 'Slider', 'riode-core' ),
					),
				)
			);

			riode_elementor_grid_layout_controls( $this, 'layout_type' );

		$this->end_controls_section();

		$this->start_controls_section(
			'testimonial_general',
			array(
				'label' => esc_html__( 'Testimonial Type', 'riode-core' ),
			)
		);

			riode_elementor_testimonial_type_controls( $this );

			$this->add_control(
				'content_line',
				[
					'label'     => esc_html__( 'Maximum Content Line', 'riode-core' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '4',
					'selectors' => array(
						'.elementor-element-{{ID}} .testimonial .comment' => '-webkit-line-clamp: {{VALUE}};',
					),
				]
			);

		$this->end_controls_section();

		riode_elementor_testimonial_style_controls( $this );

		riode_elementor_slider_style_controls( $this, 'layout_type' );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		include RIODE_CORE_PATH . 'elementor/render/widget-testimonial-group-render.php';
	}
}
