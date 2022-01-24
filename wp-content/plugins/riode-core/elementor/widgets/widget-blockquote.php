<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Blockquote Widget
 *
 * Riode Widget to display custom block.
 *
 * @since 1.4.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Riode_Blockquote_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_blockquote';
	}

	public function get_title() {
		return esc_html__( 'Blockquote', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-blockquote';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'blockquote', 'testimonial', 'review' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_blockquote',
			array(
				'label' => esc_html__( 'Blockquote', 'riode-core' ),
			)
		);

			$this->add_control(
				'type',
				array(
					'label'       => esc_html__( 'Type', 'riode-core' ),
					'description' => esc_html__( 'Choose your favourite blockquote type from pre-built types.', 'riode-core' ),
					'type'        => 'riode_image_choose',
					'default'     => 'type1',
					'width'       => '50',
					'options'     => array(
						'type1' => RIODE_CORE_URI . 'assets/images/blockquote/type1.jpg',
						'type2' => RIODE_CORE_URI . 'assets/images/blockquote/type2.jpg',
						'type3' => RIODE_CORE_URI . 'assets/images/blockquote/type3.jpg',
						'type4' => RIODE_CORE_URI . 'assets/images/blockquote/type4.jpg',
						'type5' => RIODE_CORE_URI . 'assets/images/blockquote/type5.jpg',
					),
					'label_block' => true,
				)
			);

			$this->add_control(
				'dark_skin',
				array(
					'label'       => esc_html__( 'Dark Skin', 'riode-core' ),
					'description' => esc_html__( 'Choose whether if use dark skin', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'type' => array( 'type5' ),
					),
				)
			);

			$this->add_control(
				'image',
				array(
					'label'       => esc_html__( 'Image', 'riode-core' ),
					'description' => esc_html__( 'Choose a blockquote image', 'riode-core' ),
					'type'        => Controls_Manager::MEDIA,
					'condition'   => array(
						'type' => array(
							'type4',
							'type5',
						),
					),
				)
			);

			$this->add_control(
				'blockquote',
				array(
					'label'       => esc_html__( 'Content', 'riode-core' ),
					'description' => esc_html__( 'Type a blockquote content', 'riode-core' ),
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'riode-core' ),
				)
			);

			$this->add_control(
				'cite',
				array(
					'label'       => esc_html__( 'Author', 'riode-core' ),
					'description' => esc_html__( 'Type a author name', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'John Doe', 'riode-core' ),
				)
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'blockquote_icon_style',
			array(
				'label' => esc_html__( 'Icon', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'icon_size',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .blockquote-wrapper .blockquote-icon' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_control(
				'icon_color',
				array(
					'label'     => esc_html__( 'Icon Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .blockquote-wrapper .blockquote-icon' => 'color: {{VALUE}}',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'blockquote_content_style',
			array(
				'label' => esc_html__( 'Content', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'content_typo',
					'label'    => esc_html__( 'Content Typography', 'riode-core' ),
					'selector' => '.elementor-element-{{ID}} .blockquote-wrapper blockquote p',
				)
			);

			$this->add_control(
				'content_color',
				array(
					'label'     => esc_html__( 'Content Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .blockquote-wrapper blockquote p' => 'color: {{VALUE}}',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'blockquote_author_style',
			array(
				'label' => esc_html__( 'Author', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'author_typo',
					'label'    => esc_html__( 'Author Typography', 'riode-core' ),
					'selector' => '.elementor-element-{{ID}} .blockquote-wrapper blockquote cite',
				)
			);

			$this->add_control(
				'author_color',
				array(
					'label'     => esc_html__( 'Author Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .blockquote-wrapper blockquote cite' => 'color: {{VALUE}}',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-blockquote-render.php';
	}

	protected function content_template() {}
}
