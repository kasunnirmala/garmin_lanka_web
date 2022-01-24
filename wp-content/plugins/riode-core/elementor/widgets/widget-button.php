<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Button Widget
 *
 * Riode Widget to display button.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;


class Riode_Button_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'riode_widget_button';
	}

	public function get_title() {
		return esc_html__( 'Button', 'riode-core' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'Button', 'link', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-button';
	}

	public function get_script_depends() {
		return array();
	}

	public function register_controls() {

		$this->start_controls_section(
			'section_button',
			array(
				'label' => esc_html__( 'Button Options', 'riode-core' ),
			)
		);

		$this->add_control(
			'label',
			array(
				'label'       => esc_html__( 'Label', 'riode-core' ),
				'description' => esc_html__( 'Type text that will be shown on button.', 'riode-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'Click Here', 'riode-core' ),
			)
		);

		$this->add_control(
			'button_expand',
			array(
				'label'       => esc_html__( 'Expand', 'riode-core' ),
				'description' => esc_html__( "Makes button's width 100% full.", 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
			)
		);

		$this->add_responsive_control(
			'button_align',
			array(
				'label'       => esc_html__( 'Alignment', 'riode-core' ),
				'description' => esc_html__( "Controls button's alignment. Choose from Left, Center, Right.", 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'     => 'left',
				'selectors'   => array(
					'.elementor-element-{{ID}} .elementor-widget-container' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link Url', 'riode-core' ),
				'description' => esc_html__( 'Input URL where you will move when button is clicked.', 'riode-core' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'url' => '',
				),
			)
		);

		riode_elementor_button_layout_controls( $this );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_video_button',
			array(
				'label' => esc_html__( 'Video Options', 'riode-core' ),
			)
		);

		$this->add_control(
			'play_btn',
			array(
				'label'       => esc_html__( 'Use as a play button in section', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Off', 'riode-core' ),
				'label_on'    => esc_html__( 'On', 'riode-core' ),
				'description' => esc_html__( 'You can play video whenever you set video in parent section' ),
				'condition'   => array(
					'video_btn' => '',
				),
			)
		);

		$this->add_control(
			'video_btn',
			array(
				'label'       => esc_html__( 'Use as video button', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Off', 'riode-core' ),
				'label_on'    => esc_html__( 'On', 'riode-core' ),
				'default'     => '',
				'description' => esc_html__( 'You can play video on lightbox.' ),
				'condition'   => array(
					'play_btn' => '',
				),
			)
		);

		$this->add_control(
			'vtype',
			array(
				'label'       => esc_html__( 'Source', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'youtube',
				'options'     => array(
					'youtube' => esc_html__( 'YouTube', 'riode-core' ),
					'vimeo'   => esc_html__( 'Vimeo', 'riode-core' ),
					'hosted'  => esc_html__( 'Self Hosted', 'riode-core' ),
				),
				'condition'   => array(
					'video_btn' => 'yes',
				),
				'description' => esc_html__( 'Select a certain video upload mode among Youtube, Vimeo, Dailymotion and Self Hosted modes.', 'riode-core' ),
			)
		);

		$this->add_control(
			'video_url',
			array(
				'label'       => esc_html__( 'Video url', 'riode-core' ),
				'type'        => Controls_Manager::URL,
				'separator'   => 'after',
				'condition'   => array(
					'video_btn' => 'yes',
				),
				'description' => esc_html__( 'Type a certain URL of a video you want to upload.', 'riode-core' ),
			)
		);

		$this->end_controls_section();

		riode_elementor_button_style_controls( $this );
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'label' );
		include RIODE_CORE_PATH . 'elementor/render/widget-button-render.php';
	}
}
