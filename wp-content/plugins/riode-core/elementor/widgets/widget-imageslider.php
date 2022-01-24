<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Image Gallery Widget
 *
 * Riode Widget to display image.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use ELementor\Group_Control_Background;
use ELementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use ELementor\Group_Control_Box_Shadow;

class Riode_ImageSlider_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_imageslider';
	}

	public function get_title() {
		return esc_html__( 'Image Gallery', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-image-gallery';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'image', 'slider', 'carousel', 'gallery', 'grid', 'creative' );
	}

	public function get_script_depends() {
		return array( 'owl-carousel' );
	}

	protected function register_controls() {

		global $riode_animations;

		$this->start_controls_section(
			'section_image_carousel',
			array(
				'label' => esc_html__( 'Images', 'riode-core' ),
			)
		);

		$this->add_control(
			'images',
			array(
				'label'       => esc_html__( 'Add Images', 'riode-core' ),
				'type'        => Controls_Manager::GALLERY,
				'default'     => array(),
				'show_label'  => false,
				'description' => esc_html__( 'Uploads certain images you want to show in your gallery.', 'riode-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'        => 'thumbnail',
				'separator'   => 'none',
				'description' => esc_html__( 'Select fit image size with your certain image.', 'riode-core' ),
			)
		);

		$this->add_control(
			'caption_type',
			array(
				'label'       => esc_html__( 'Caption', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''            => esc_html__( 'None', 'riode-core' ),
					'title'       => esc_html__( 'Title', 'riode-core' ),
					'caption'     => esc_html__( 'Caption', 'riode-core' ),
					'description' => esc_html__( 'Description', 'riode-core' ),
				),
				'description' => esc_html__( 'Select caption type which will be shown under image.', 'riode-core' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_options',
			array(
				'label' => esc_html__( 'Layout Options', 'riode-core' ),
			)
		);

		$this->add_control(
			'layout_type',
			array(
				'label'       => esc_html__( 'Layout', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''         => esc_html__( 'Slider', 'riode-core' ),
					'grid'     => esc_html__( 'Grid', 'riode-core' ),
					'creative' => esc_html__( 'Creative', 'riode-core' ),
				),
				'description' => esc_html__( 'Select certain layout of your gallery: Grid, Slider, Creative.', 'riode-core' ),
			)
		);

		riode_elementor_gallery_creative_controls( $this, 'layout_type' );

		$this->add_responsive_control(
			'col_cnt',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Columns Count', 'riode-core' ),
				'options'     => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
					'7' => 7,
					'8' => 8,
					''  => esc_html__( 'Default', 'riode-core' ),
				),
				'description' => esc_html__( 'Select number of columns to display.', 'riode-core' ),
				'condition'   => array(
					'layout_type!' => 'creative',
				),

			)
		);

		$this->add_control(
			'col_cnt_xl',
			array(
				'label'       => esc_html__( 'Columns Count ( >= 1200px )', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
					'7' => 7,
					'8' => 8,
					''  => esc_html__( 'Default', 'riode-core' ),
				),
				'description' => esc_html__( 'Select number of columns to display on large display( >= 1200px ). ', 'riode-core' ),
				'condition'   => array(
					'layout_type!' => 'creative',
				),
			)
		);

		$this->add_control(
			'col_cnt_min',
			array(
				'label'       => esc_html__( 'Columns Count ( < 576px )', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
					'7' => 7,
					'8' => 8,
					''  => esc_html__( 'Default', 'riode-core' ),
				),
				'description' => esc_html__( 'Select number of columns to display on mobile( >= 576px ). ', 'riode-core' ),
				'condition'   => array(
					'layout_type!' => 'creative',
				),
			)
		);

		$this->add_control(
			'col_sp',
			array(
				'label'       => esc_html__( 'Columns Spacing', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'md',
				'options'     => array(
					'no' => esc_html__( 'No space', 'riode-core' ),
					'xs' => esc_html__( 'Extra Small', 'riode-core' ),
					'sm' => esc_html__( 'Small', 'riode-core' ),
					'md' => esc_html__( 'Medium', 'riode-core' ),
					'lg' => esc_html__( 'Large', 'riode-core' ),
				),
				'description' => esc_html__( 'Select the amount of spacing between items.', 'riode-core' ),
			)
		);

		$this->add_control(
			'slider_vertical_align',
			array(
				'label'       => esc_html__( 'Vertical Align', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'top'         => array(
						'title' => esc_html__( 'Top', 'riode-core' ),
						'icon'  => 'eicon-v-align-top',
					),
					'middle'      => array(
						'title' => esc_html__( 'Middle', 'riode-core' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom'      => array(
						'title' => esc_html__( 'Bottom', 'riode-core' ),
						'icon'  => 'eicon-v-align-bottom',
					),
					'same-height' => array(
						'title' => esc_html__( 'Stretch', 'riode-core' ),
						'icon'  => 'eicon-v-align-stretch',
					),
				),
				'description' => esc_html__( 'Choose vertical alignment of items. Choose from Top, Middle, Bottom, Stretch.', 'riode-core' ),
				'condition'   => array(
					'layout_type' => '',
				),
			)
		);

		$this->add_control(
			'slider_image_expand',
			array(
				'label'       => esc_html__( 'Image Full Width', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Expand image size to fit slider layout.', 'riode-core' ),
				'condition'   => array(
					'layout_type' => '',
				),
			)
		);

		$this->add_control(
			'slider_horizontal_align',
			array(
				'label'       => esc_html__( 'Horizontal Align', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
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
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-item figure' => 'justify-content:{{VALUE}}',
				),
				'description' => esc_html__( 'Choose from left, center and right in slider layout.', 'riode-core' ),
				'condition'   => array(
					'slider_image_expand' => '',
					'layout_type'         => '',
				),
			)
		);

		$this->add_control(
			'grid_vertical_align',
			array(
				'label'       => esc_html__( 'Vertical Align', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'riode-core' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center'     => array(
						'title' => esc_html__( 'Middle', 'riode-core' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Bottom', 'riode-core' ),
						'icon'  => 'eicon-v-align-bottom',
					),
					'stretch'    => array(
						'title' => esc_html__( 'Stretch', 'riode-core' ),
						'icon'  => 'eicon-v-align-stretch',
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .image-wrap' => 'display: flex; align-items:{{VALUE}};',
				),
				'description' => esc_html__( 'Choose from top, middle, bottom and stretch in grid layout.', 'riode-core' ),
				'condition'   => array(
					'layout_type' => 'grid',
				),
			)
		);

		$this->add_control(
			'grid_image_expand',
			array(
				'label'       => esc_html__( 'Image Full Width', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'selectors'   => array(
					'.elementor-element-{{ID}} .image-wrap img' => 'width: 100%;',
				),
				'description' => esc_html__( 'Expand image size to fit grid layout.', 'riode-core' ),
				'condition'   => array(
					'layout_type' => 'grid',
				),
			)
		);

		$this->add_control(
			'grid_horizontal_align',
			array(
				'label'       => esc_html__( 'Horizontal Align', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
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
				'selectors'   => array(
					'.elementor-element-{{ID}} .image-wrap' => 'display:flex; justify-content:{{VALUE}}',
				),
				'description' => esc_html__( 'Choose from left, center and right in grid layout.', 'riode-core' ),
				'condition'   => array(
					'grid_image_expand' => '',
					'layout_type'       => 'grid',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_style',
			array(
				'label'     => esc_html__( 'Slider', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'layout_type' => '',
				),
			)
		);

		$this->add_control(
			'style_heading_nav',
			array(
				'label' => esc_html__( 'Navigation', 'riode-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'show_nav',
			array(
				'label'   => esc_html__( 'Nav', 'riode-core' ),
				'description' => esc_html__( 'Determine whether to show/hide slider navigations.', 'riode-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'nav_hide',
			array(
				'label'   => esc_html__( 'Nav Auto Hide', 'riode-core' ),
				'description' => esc_html__( 'Hides slider navs automatically and show them only if mouse is over.', 'riode-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'nav_type',
			array(
				'label'   => esc_html__( 'Nav Type', 'riode-core' ),
				'type'    => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose from icon presets of slider nav. Choose from Default, Simple, Simple 2, Circle, Full.', 'riode-core' ),
				'default' => '',
				'options' => array(
					''       => esc_html__( 'Default', 'riode-core' ),
					'simple' => esc_html__( 'Simple', 'riode-core' ),
					'circle' => esc_html__( 'Circle', 'riode-core' ),
					'full'   => esc_html__( 'Full', 'riode-core' ),
				),
			)
		);

		$this->add_control(
			'nav_pos',
			array(
				'label'     => esc_html__( 'Nav Position', 'riode-core' ),
				'type'      => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose position of slider navs. Choose from Inner, Outer, Top, Custom.', 'riode-core' ),
				'default'   => '',
				'options'   => array(
					'inner'  => esc_html__( 'Inner', 'riode-core' ),
					'custom' => esc_html__( 'Custom', 'riode-core' ),
					''       => esc_html__( 'Outer', 'riode-core' ),
					'top'    => esc_html__( 'Top', 'riode-core' ),
				),
				'condition' => array(
					'nav_type!' => 'full',
				),
			)
		);

		$this->add_responsive_control(
			'nav_h_position',
			array(
				'label'      => esc_html__( 'Nav Horizontal Position', 'riode-core' ),
				'type'       => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Controls horizontal position of slider navs when nav type is Custom.', 'riode-core' ),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .owl-nav .owl-prev' => 'left: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .owl-nav .owl-next' => 'right: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'nav_pos' => 'custom',
				),
			)
		);

		$this->add_responsive_control(
			'nav_v_position',
			array(
				'label'      => esc_html__( 'Nav Vertical Position', 'riode-core' ),
				'description' => esc_html__( 'Controls vertical position of slider navs when nav type is Custom.', 'riode-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -500,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav > *' => 'top: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'nav_pos' => 'custom',
				),
			)
		);

		$this->add_responsive_control(
			'show_dots',
			array(
				'label'   => esc_html__( 'Dots', 'riode-core' ),
				'description' => esc_html__( 'Determine whether to show/hide slider dots.', 'riode-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'dots_type',
			array(
				'label'   => esc_html__( 'Dots Type', 'riode-core' ),
				'type'    => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose slider dots color skin. Choose from Default, White, Grey, Dark.', 'riode-core' ),
				'default' => '',
				'options' => array(
					''      => esc_html__( 'default', 'riode-core' ),
					'white' => esc_html__( 'white', 'riode-core' ),
					'grey'  => esc_html__( 'grey', 'riode-core' ),
					'dark'  => esc_html__( 'dark', 'riode-core' ),
				),
			)
		);

		$this->add_control(
			'dots_pos',
			array(
				'label'   => esc_html__( 'Dots Position', 'riode-core' ),
				'type'    => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose position of slider dots and image dots. Choose from Inner, Outer, Close Outer, Custom.', 'riode-core' ),
				'default' => '',
				'options' => array(
					'inner'  => esc_html__( 'Inner', 'riode-core' ),
					''       => esc_html__( 'Outer', 'riode-core' ),
					'custom' => esc_html__( 'Custom', 'riode-core' ),
				),
			)
		);

		$this->add_responsive_control(
			'dots_h_position',
			array(
				'label'      => esc_html__( 'Dot Vertical Position', 'riode-core' ),
				'description' => esc_html__( 'Controls vertical position of slider dots and image dots.', 'riode-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => '25',
				),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -200,
						'max'  => 200,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .owl-dots' => 'position: absolute; bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'dots_pos' => 'custom',
				),
			)
		);

		$this->add_responsive_control(
			'dots_v_position',
			array(
				'label'      => esc_html__( 'Dot Horizontal Position', 'riode-core' ),
				'description' => esc_html__( 'Controls horizontal position of slider dots and image dots.', 'riode-core' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => '%',
					'size' => '50',
				),
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => -200,
						'max'  => 200,
					),
					'%'  => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .owl-dots' => 'position: absolute; left: {{SIZE}}{{UNIT}}; transform: translateX(-50%);',
				),
				'condition'  => array(
					'dots_pos' => 'custom',
				),
			)
		);

		$this->add_control(
			'style_divider_slider_options',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'style_heading_slider_options',
			array(
				'label' => esc_html__( 'Options', 'riode-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Autoplay', 'riode-core' ),
				'description' => esc_html__( 'Enables each slides play sliding automatically.', 'riode-core' ),
			)
		);

		$this->add_control(
			'autoplay_timeout',
			array(
				'type'      => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Controls how long each slides should be shown.', 'riode-core' ),
				'label'     => esc_html__( 'Autoplay Timeout', 'riode-core' ),
				'default'   => 5000,
				'condition' => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'loop',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Makes slides of slider play sliding infinitely.', 'riode-core' ),
				'label' => esc_html__( 'Infinite Loop', 'riode-core' ),
			)
		);

		$this->add_control(
			'pause_onhover',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Makes slider stop sliding when mouse is over.', 'riode-core' ),
				'label' => esc_html__( 'Pause on Hover', 'riode-core' ),
			)
		);

		$this->add_control(
			'autoheight',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Auto Height', 'riode-core' ),
				'description' => esc_html__( 'Makes each slides have their own height. Slides could have different height.', 'riode-core' ),
			)
		);

		$this->add_control(
			'center_mode',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Center Mode', 'riode-core' ),
				'description' => esc_html__( 'Center item will be aligned center for both even and odd index. It works well in slider where loop option is enabled.', 'riode-core' ),
			)
		);

		$this->add_control(
			'prevent_drag',
			array(
				'type'  => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Prevents sliding effect even if customers drag slides.', 'riode-core' ),
				'label' => esc_html__( 'Disable Drag', 'riode-core' ),
			)
		);

		$this->add_control(
			'animation_in',
			array(
				'label'   => esc_html__( 'Animation In', 'riode-core' ),
				'type'    => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Choose sliding animation when next slides become visible.', 'riode-core' ),
				'options' => $riode_animations['sliderIn'],
			)
		);

		$this->add_control(
			'animation_out',
			array(
				'label'   => esc_html__( 'Animation Out', 'riode-core' ),
				'type'    => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Choose sliding animation when previous slides become invisible.', 'riode-core' ),
				'options' => $riode_animations['sliderOut'],
			)
		);

		$this->add_control(
			'style_divider_slider_styles',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'style_heading_slider_styles',
			array(
				'label' => esc_html__( 'Styles', 'riode-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'slider_nav_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Nav Size', 'riode-core' ),
				'description' => esc_html__( 'Controls size of slider navs.', 'riode-core' ),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 20,
						'max'  => 100,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button' => 'font-size: {{SIZE}}px',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_nav_style' );

		$this->start_controls_tab(
			'tab_nav_normal',
			array(
				'label' => esc_html__( 'Normal', 'riode-core' ),
			)
		);

		$this->add_control(
			'nav_color',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'nav_box_shadow',
				'selector' => '.elementor-element-{{ID}} .owl-carousel .owl-nav button',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_nav_hover',
			array(
				'label' => esc_html__( 'Hover', 'riode-core' ),
			)
		);

		$this->add_control(
			'nav_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button:not(.disabled):hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_back_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button:not(.disabled):hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button:not(.disabled):hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'nav_box_shadow_hover',
				'selector' => '.elementor-element-{{ID}} .owl-carousel .owl-nav button:not(.disabled):hover',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_nav_disabled',
			array(
				'label' => esc_html__( 'Disabled', 'riode-core' ),
			)
		);

		$this->add_control(
			'nav_color_disabled',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button.disabled' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_back_color_disabled',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button.disabled' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'nav_border_color_disabled',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button.disabled' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'nav_box_shadow_disabled',
				'selector' => '.elementor-element-{{ID}} .owl-carousel .owl-nav button.disabled',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'style_heading_dots_options',
			array(
				'label'     => esc_html__( 'Dots Style', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'slider_dots_size',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Dots Size', 'riode-core' ),
				'description' => esc_html__( 'Controls size of slider dots.', 'riode-core' ),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 5,
						'max'  => 100,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .owl-dots .owl-dot.active span' => 'width: calc({{SIZE}}{{UNIT}} * 2.25); height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_dot_style' );

		$this->start_controls_tab(
			'tab_dot_normal',
			array(
				'label' => esc_html__( 'Normal', 'riode-core' ),
			)
		);

		$this->add_control(
			'dot_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dot_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot span' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'dot_box_shadow',
				'selector' => '.elementor-element-{{ID}} .owl-dots .owl-dot span',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dot_hover',
			array(
				'label' => esc_html__( 'Hover', 'riode-core' ),
			)
		);

		$this->add_control(
			'dot_back_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dot_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot:hover span' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'dot_box_shadow_hover',
				'selector' => '.elementor-element-{{ID}} .owl-dots .owl-dot:hover span',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dot_active',
			array(
				'label' => esc_html__( 'Active', 'riode-core' ),
			)
		);

		$this->add_control(
			'dot_back_color_active',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dot_border_color_active',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot.active span' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'dot_box_shadow_active',
				'selector' => '.elementor-element-{{ID}} .owl-dots .owl-dot.active span',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-imageslider-render.php';
	}

}

function riode_elementor_gallery_creative_controls( $self, $condition_key ) {

	$self->add_control(
		'custom_creative',
		array(
			'label'       => esc_html__( 'Use Custom Layout', 'riode-core' ),
			'type'        => Controls_Manager::SWITCHER,
			'default'     => '',
			'description' => esc_html__( 'Use creative layout preset or build your own.', 'riode-core' ),
			'condition'   => array(
				$condition_key => 'creative',
			),
		)
	);

	$self->add_control(
		'creative_mode',
		array(
			'label'       => esc_html__( 'Creative Layout', 'riode-core' ),
			'type'        => 'riode_image_choose',
			'default'     => 1,
			'options'     => riode_product_grid_preset(),
			'description' => esc_html__( 'Choose from 9 supported presets.', 'riode-core' ),
			'condition'   => array(
				$condition_key    => 'creative',
				'custom_creative' => '',
			),
		)
	);

	$repeater = new Repeater();

	$repeater->add_control(
		'item_no',
		[
			'label'       => esc_html__( 'Item Index', 'riode-core' ),
			'type'        => Controls_Manager::TEXT,
			'placeholder' => esc_html__( 'Blank for all items.', 'riode-core' ),
			'description' => esc_html__( 'Choose item number to control creative items.', 'riode-core' ),
		]
	);

	$repeater->add_responsive_control(
		'item_col_span',
		array(
			'type'        => Controls_Manager::SLIDER,
			'label'       => esc_html__( 'Column Size', 'riode-core' ),
			'default'     => array(
				'size' => 1,
				'unit' => 'px',
			),
			'size_units'  => array(
				'px',
			),
			'range'       => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 12,
				),
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-column-end: span {{SIZE}}',
			),
			'description' => esc_html__( 'Controls selected item\'s column size.', 'riode-core' ),
		)
	);

	$repeater->add_responsive_control(
		'item_row_span',
		array(
			'type'        => Controls_Manager::SLIDER,
			'label'       => esc_html__( 'Row Size', 'riode-core' ),
			'default'     => array(
				'size' => 1,
				'unit' => 'px',
			),
			'size_units'  => array(
				'px',
			),
			'range'       => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 8,
				),
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-row-end: span {{SIZE}}',
			),
			'description' => esc_html__( 'Controls selected item\'s row size.', 'riode-core' ),
		)
	);

	$repeater->add_group_control(
		Group_Control_Image_Size::get_type(),
		array(
			'name'        => 'item_thumb', // Usage: `{name}_size` and `{name}_custom_dimension`
			'label'       => esc_html__( 'Image Size', 'riode-core' ),
			'default'     => 'thumbnail',
			'description' => esc_html__( 'Select fit image size with your certain image', 'riode-core' ),
			'condition'   => array(
				'item_no!' => '',
			),
		)
	);

	$self->add_responsive_control(
		'creative_cols',
		array(
			'type'           => Controls_Manager::SLIDER,
			'label'          => esc_html__( 'Columns', 'riode-core' ),
			'default'        => array(
				'size' => 4,
				'unit' => 'px',
			),
			'tablet_default' => array(
				'size' => 3,
				'unit' => 'px',
			),
			'mobile_default' => array(
				'size' => 2,
				'unit' => 'px',
			),
			'size_units'     => array(
				'px',
			),
			'range'          => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 60,
				),
			),
			'description'    => esc_html__( 'Controls number of creative columns to display.', 'riode-core' ),
			'condition'      => array(
				$condition_key     => 'creative',
				'custom_creative!' => '',
			),
			'selectors'      => array(
				'.elementor-element-{{ID}} .creative-grid' => 'grid-template-columns: repeat(auto-fill, calc(100% / {{SIZE}}))',
			),
		)
	);

	$self->add_control(
		'creative_layout_heading',
		array(
			'label'     => __( "Customize each grid item's layout", 'riode-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => array(
				$condition_key     => 'creative',
				'custom_creative!' => '',
			),
		)
	);

	$self->add_control(
		'items_list',
		[
			'label'       => esc_html__( 'Grid Item Layouts', 'riode-core' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'condition'   => array(
				$condition_key     => 'creative',
				'custom_creative!' => '',
			),
			'default'     => array(
				array(
					'item_no'       => '',
					'item_col_span' => array(
						'size' => 1,
						'unit' => 'px',
					),
					'item_row_span' => array(
						'size' => 1,
						'unit' => 'px',
					),
				),
				array(
					'item_no'       => 2,
					'item_col_span' => array(
						'size' => 2,
						'unit' => 'px',
					),
					'item_row_span' => array(
						'size' => 2,
						'unit' => 'px',
					),
				),
			),
			'title_field' => sprintf( '{{{ item_no ? \'%1$s\' : \'%2$s\' }}}' . ' <strong>{{{ item_no }}}</strong>', esc_html__( 'Index', 'riode-core' ), esc_html__( 'Base', 'riode-core' ) ),
		]
	);

	$self->add_responsive_control(
		'creative_equal_height',
		array(
			'type'        => Controls_Manager::SWITCHER,
			'label'       => esc_html__( 'Disable Equal Row Height', 'riode-core' ),
			'default'     => 'yes',
			'description' => esc_html__( 'Make base creative grid item’s height to their own.', 'riode-core' ),
			'condition'   => array(
				$condition_key => 'creative',
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .creative-grid' => 'grid-auto-rows: auto',
			),
		)
	);
}
