<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

/**
 * Register elementor layout controls for slider.
 */

function riode_elementor_slider_layout_controls( $self, $condition_key ) {
	if ( is_object( $self ) && is_callable( array( $self, 'get_name' ) ) && ( 'riode_widget_posts' == $self->get_name() || 'riode_widget_products' == $self->get_name() ) ) {
		$self->add_control(
			'row_cnt',
			array(
				'label'       => esc_html__( 'Rows Count', 'riode-core' ),
				'description' => esc_html__( 'How many rows of products should be shown in each column?', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 1,
				'options'     => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
					'7' => 7,
					'8' => 8,
				),
				'condition'   => array(
					$condition_key => 'slider',
				),
			)
		);
	}

	$self->add_control(
		'slider_vertical_align',
		array(
			'label'       => esc_html__( 'Vertical Align', 'riode-core' ),
			'description' => esc_html__( 'Choose vertical alignment of items. Choose from Top, Middle, Bottom, Stretch.', 'riode-core' ),
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
			'condition'   => array(
				$condition_key => 'slider',
			),
		)
	);
}

/**
 * Register elementor style controls for slider.
 */

function riode_elementor_slider_style_controls( $self, $condition_key = '', $defaults = array() ) {

	global $riode_animations;

	if ( empty( $condition_key ) ) {
		$self->start_controls_section(
			'slider_style',
			array(
				'label' => esc_html__( 'Slider', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
	} else {
		$self->start_controls_section(
			'slider_style',
			array(
				'label'     => esc_html__( 'Slider', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					$condition_key => 'slider',
				),
			)
		);
	}

		$self->add_control(
			'style_heading_nav',
			array(
				'label' => esc_html__( 'Navigation', 'riode-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$self->add_responsive_control(
			'show_nav',
			array(
				'label'       => esc_html__( 'Nav', 'riode-core' ),
				'description' => esc_html__( 'Determine whether to show/hide slider navigations.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => empty( $defaults['show_nav'] ) ? '' : 'yes',
			)
		);

		$self->add_control(
			'nav_hide',
			array(
				'label'       => esc_html__( 'Nav Auto Hide', 'riode-core' ),
				'description' => esc_html__( 'Hides slider navs automatically and show them only if mouse is over.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
			)
		);

		$self->add_control(
			'nav_type',
			array(
				'label'       => esc_html__( 'Nav Type', 'riode-core' ),
				'description' => esc_html__( 'Choose from icon presets of slider nav. Choose from Default, Simple, Simple 2, Circle, Full.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''        => esc_html__( 'Default', 'riode-core' ),
					'simple'  => esc_html__( 'Simple', 'riode-core' ),
					'simple2' => esc_html__( 'Simple2', 'riode-core' ),
					'circle'  => esc_html__( 'Circle', 'riode-core' ),
					'full'    => esc_html__( 'Full', 'riode-core' ),
				),
			)
		);

		$self->add_control(
			'nav_pos',
			array(
				'label'       => esc_html__( 'Nav Position', 'riode-core' ),
				'description' => esc_html__( 'Choose position of slider navs. Choose from Inner, Outer, Top, Custom.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					'inner'  => esc_html__( 'Inner', 'riode-core' ),
					'custom' => esc_html__( 'Custom', 'riode-core' ),
					''       => esc_html__( 'Outer', 'riode-core' ),
					'top'    => esc_html__( 'Top', 'riode-core' ),
				),
				'condition'   => array(
					'nav_type!' => 'full',
				),
			)
		);

		$self->add_responsive_control(
			'nav_h_position',
			array(
				'label'       => esc_html__( 'Nav Horizontal Position', 'riode-core' ),
				'description' => esc_html__( 'Controls horizontal position of slider navs when nav type is Custom.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
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
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-nav .owl-prev' => ( is_rtl() ? 'right' : 'left' ) . ': {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .owl-nav .owl-next' => ( is_rtl() ? 'left' : 'right' ) . ': {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .owl-nav-top .owl-nav' => ( is_rtl() ? 'left' : 'right' ) . ': {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'nav_pos' => array( 'top', 'custom' ),
				),
			)
		);

		$self->add_responsive_control(
			'nav_v_position',
			array(
				'label'       => esc_html__( 'Nav Vertical Position', 'riode-core' ),
				'description' => esc_html__( 'Controls vertical position of slider navs when nav type is Custom.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
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
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav > *, .elementor-element-{{ID}} .owl-nav-top .owl-nav' => 'top: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'nav_pos' => array( 'top', 'custom' ),
				),
			)
		);

		$self->add_responsive_control(
			'show_dots',
			array(
				'label'       => esc_html__( 'Dots', 'riode-core' ),
				'description' => esc_html__( 'Determine whether to show/hide slider dots.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => empty( $defaults['show_dots'] ) ? '' : 'yes',
			)
		);

		$dot_default = '';
	if ( 'use_as' == $condition_key ) {
		$self->add_control(
			'dots_kind',
			array(
				'label'       => esc_html__( 'Choose Your Dots Style', 'riode-core' ),
				'description' => esc_html__( 'Choose what you are going to use for slider dots. Choose from Dots, Images.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''      => esc_html__( 'Default', 'riode-core' ),
					'thumb' => esc_html__( 'Thumbnail', 'riode-core' ),
				),
			)
		);

		$self->add_control(
			'thumbs',
			array(
				'label'       => esc_html__( 'Add Thumbnails', 'riode-core' ),
				'description' => esc_html__( 'Choose thumbnail images which represent each slides.', 'riode-core' ),
				'type'        => Controls_Manager::GALLERY,
				'default'     => array(),
				'show_label'  => false,
				'condition'   => array(
					'dots_kind' => 'thumb',
				),
			)
		);

		$self->add_control(
			'vertical_dots',
			array(
				'label'       => esc_html__( 'Enable Vertical Dots', 'riode-core' ),
				'description' => esc_html__( 'Shows dots vertically not horizontally.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => empty( $defaults['vertical_dots'] ) ? '' : 'yes',
				'condition'   => array(
					'dots_kind' => 'thumb',
				),
			)
		);

		$dot_default = array( 'dots_kind' => '' );
	}

		$self->add_control(
			'dots_type',
			array(
				'label'       => esc_html__( 'Dots Type', 'riode-core' ),
				'description' => esc_html__( 'Choose slider dots color skin. Choose from Default, White, Grey, Dark.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''      => esc_html__( 'default', 'riode-core' ),
					'white' => esc_html__( 'white', 'riode-core' ),
					'grey'  => esc_html__( 'grey', 'riode-core' ),
					'dark'  => esc_html__( 'dark', 'riode-core' ),
				),
				'condition'   => array(
					'dots_kind' => '',
				),
			)
		);

		$self->add_control(
			'dots_pos',
			array(
				'label'       => esc_html__( 'Dots Position', 'riode-core' ),
				'description' => esc_html__( 'Choose position of slider dots and image dots. Choose from Inner, Outer, Close Outer, Custom.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					'inner'  => esc_html__( 'Inner', 'riode-core' ),
					''       => esc_html__( 'Outer', 'riode-core' ),
					'close'  => esc_html__( 'Close Outer', 'riode-core' ),
					'custom' => esc_html__( 'Custom', 'riode-core' ),
				),
			)
		);

		$self->add_responsive_control(
			'dots_h_position',
			array(
				'label'       => esc_html__( 'Dot Vertical Position', 'riode-core' ),
				'description' => esc_html__( 'Controls vertical position of slider dots and image dots.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'unit' => 'px',
					'size' => '25',
				),
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
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
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-dots, .elementor-element-{{ID}} .slider-thumb-dots' => 'position: absolute; bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'dots_pos' => 'custom',
				),
			)
		);

		$self->add_responsive_control(
			'dots_v_position',
			array(
				'label'       => esc_html__( 'Dot Horizontal Position', 'riode-core' ),
				'description' => esc_html__( 'Controls horizontal position of slider dots and image dots.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'unit' => '%',
					'size' => '50',
				),
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
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
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-dots, .elementor-element-{{ID}} .slider-thumb-dots' => 'position: absolute; left: {{SIZE}}{{UNIT}}; transform: translateX(-50%);',
				),
				'condition'   => array(
					'dots_pos' => 'custom',
				),
			)
		);

		$self->add_control(
			'style_heading_slider_options',
			array(
				'label'     => esc_html__( 'Options', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_control(
			'fullheight',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Set to use 100vh slider.', 'riode-core' ),
				'label'       => esc_html__( 'Full Height', 'riode-core' ),
			)
		);

		$self->add_control(
			'autoplay',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Enables each slides play sliding automatically.', 'riode-core' ),
				'label'       => esc_html__( 'Autoplay', 'riode-core' ),
			)
		);

		$self->add_control(
			'autoplay_timeout',
			array(
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Controls how long each slides should be shown.', 'riode-core' ),
				'label'       => esc_html__( 'Autoplay Timeout', 'riode-core' ),
				'default'     => 5000,
				'condition'   => array(
					'autoplay' => 'yes',
				),
			)
		);

		$self->add_control(
			'loop',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Makes slides of slider play sliding infinitely.', 'riode-core' ),
				'label'       => esc_html__( 'Infinite Loop', 'riode-core' ),
			)
		);

		$self->add_control(
			'pause_onhover',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Makes slider stop sliding when mouse is over.', 'riode-core' ),
				'label'       => esc_html__( 'Pause on Hover', 'riode-core' ),
			)
		);

		$self->add_control(
			'autoheight',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Auto Height', 'riode-core' ),
				'description' => esc_html__( 'Makes each slides have their own height. Slides could have different height.', 'riode-core' ),
			)
		);

		$self->add_control(
			'center_mode',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Center Mode', 'riode-core' ),
				'description' => esc_html__( 'Center item will be aligned center for both even and odd index. It works well in slider where loop option is enabled.', 'riode-core' ),
			)
		);

		$self->add_control(
			'prevent_drag',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Prevents sliding effect even if customers drag slides.', 'riode-core' ),
				'label'       => esc_html__( 'Disable Drag', 'riode-core' ),
			)
		);

		$self->add_control(
			'animation_in',
			array(
				'label'       => esc_html__( 'Animation In', 'riode-core' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $riode_animations['sliderIn'],
				'description' => esc_html__( 'Choose sliding animation when next slides become visible.', 'riode-core' ),
			)
		);

		$self->add_control(
			'animation_out',
			array(
				'label'       => esc_html__( 'Animation Out', 'riode-core' ),
				'description' => esc_html__( 'Choose sliding animation when previous slides become invisible.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $riode_animations['sliderOut'],
			)
		);

		$self->add_control(
			'style_heading_slider_styles',
			array(
				'label'     => esc_html__( 'Styles', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_responsive_control(
			'slider_nav_size',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Nav Size', 'riode-core' ),
				'description' => esc_html__( 'Controls size of slider navs.', 'riode-core' ),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 20,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .owl-nav button' => 'font-size: {{SIZE}}px',
				),
			)
		);

		$self->start_controls_tabs( 'tabs_nav_style' );

		$self->start_controls_tab(
			'tab_nav_normal',
			array(
				'label' => esc_html__( 'Normal', 'riode-core' ),
			)
		);

		$self->add_control(
			'nav_color',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the nav color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_back_color',
			array(
				'label'       => esc_html__( 'Background Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the nav background color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_border_color',
			array(
				'label'       => esc_html__( 'Border Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the nav border color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'        => 'nav_box_shadow',
				'description' => esc_html__( 'Controls the nav box shadow.', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .owl-carousel .owl-nav button',
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_nav_hover',
			array(
				'label' => esc_html__( 'Hover', 'riode-core' ),
			)
		);

		$self->add_control(
			'nav_color_hover',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the nav hover color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button:not(.disabled):hover' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_back_color_hover',
			array(
				'label'       => esc_html__( 'Background Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the nav hover background color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button:not(.disabled):hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_border_color_hover',
			array(
				'label'       => esc_html__( 'Border Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the nav hover border color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button:not(.disabled):hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'        => 'nav_box_shadow_hover',
				'description' => esc_html__( 'Controls the nav hover box shadow.', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .owl-carousel .owl-nav button:not(.disabled):hover',
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_nav_disabled',
			array(
				'label' => esc_html__( 'Disabled', 'riode-core' ),
			)
		);

		$self->add_control(
			'nav_color_disabled',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the nav disabled color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button.disabled' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_back_color_disabled',
			array(
				'label'       => esc_html__( 'Background Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the nav disabled background color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button.disabled' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'nav_border_color_disabled',
			array(
				'label'       => esc_html__( 'Border Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the nav disabled border color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-carousel .owl-nav button.disabled' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'        => 'nav_box_shadow_disabled',
				'description' => esc_html__( 'Controls the nav disabled box shadow.', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .owl-carousel .owl-nav button.disabled',
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_control(
			'style_heading_dots_options',
			array(
				'label'     => esc_html__( 'Dots Style', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_responsive_control(
			'slider_dots_size',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Dots Size (px)', 'riode-core' ),
				'description' => esc_html__( 'Controls size of slider dots.', 'riode-core' ),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 5,
						'max'  => 200,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .owl-dots .owl-dot.active span' => 'width: calc({{SIZE}}{{UNIT}} * 2.25); height: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .slider-thumb-dots .owl-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .owl-dot-close ~ .slider-thumb-dots' => 'margin-top: calc(-{{SIZE}}{{UNIT}} / 2)',
				),
			)
		);

		$self->add_responsive_control(
			'dots_thumb_spacing',
			array(
				'label'       => esc_html__( 'Dots Spacing', 'riode-core' ),
				'description' => esc_html__( 'Controls gap space between image thumbnail dots.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'unit' => 'px',
					'size' => '25',
				),
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
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
				'selectors'   => array(
					'.elementor-element-{{ID}} .slider-thumb-dots .owl-dot' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .vertical-dots + .slider-thumb-dots .owl-dot' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0;',
				),
				'condition'   => array(
					'dots_kind' => 'thumb',
				),
			)
		);

		$self->start_controls_tabs( 'tabs_dot_style' );

		$self->start_controls_tab(
			'tab_dot_normal',
			array(
				'label' => esc_html__( 'Normal', 'riode-core' ),
			)
		);

		$self->add_control(
			'dot_back_color',
			array(
				'label'       => esc_html__( 'Background Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the dots background  color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
				),
				'condition'   => $dot_default,
			)
		);

		$self->add_control(
			'dot_border_color',
			array(
				'label'       => esc_html__( 'Border Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the dots border color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot span' => 'border-color: {{VALUE}};',
					'.elementor-element-{{ID}} .slider-thumb-dots .owl-dot' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'        => 'dot_box_shadow',
				'description' => esc_html__( 'Controls the dots box shadow.', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .owl-dots .owl-dot span',
				'condition'   => $dot_default,
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_dot_hover',
			array(
				'label' => esc_html__( 'Hover', 'riode-core' ),
			)
		);

		$self->add_control(
			'dot_back_color_hover',
			array(
				'label'       => esc_html__( 'Background Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the dots hover background color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}};',
				),
				'condition'   => $dot_default,
			)
		);

		$self->add_control(
			'dot_border_color_hover',
			array(
				'label'       => esc_html__( 'Border Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the dots hover border color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot:hover span' => 'border-color: {{VALUE}};',
					'.elementor-element-{{ID}} .slider-thumb-dots .owl-dot:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'        => 'dot_box_shadow_hover',
				'description' => esc_html__( 'Controls the dots hover box shadow.', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .owl-dots .owl-dot:hover span',
				'condition'   => $dot_default,
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'tab_dot_active',
			array(
				'label' => esc_html__( 'Active', 'riode-core' ),
			)
		);

		$self->add_control(
			'dot_back_color_active',
			array(
				'label'       => esc_html__( 'Background Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the dots active backgorund color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}};',
				),
				'condition'   => $dot_default,
			)
		);

		$self->add_control(
			'dot_border_color_active',
			array(
				'label'       => esc_html__( 'Border Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the dots active border color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .owl-dots .owl-dot.active span' => 'border-color: {{VALUE}};',
					'.elementor-element-{{ID}} .slider-thumb-dots .owl-dot.active' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'        => 'dot_box_shadow_active',
				'description' => esc_html__( 'Controls the dots active box shadow.', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .owl-dots .owl-dot.active span',
				'condition'   => $dot_default,
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_control(
			'dots_thumb_border_radius',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Thumb Dots Border Radius', 'riode-core' ),
				'description' => esc_html__( 'Controls border radius of image thumbnail dots.', 'riode-core' ),
				'default'     => array(
					'unit' => 'px',
					'size' => '3',
				),
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 200,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .slider-thumb-dots .owl-dot' => 'border-radius: {{SIZE}}{{UNIT}}',
					'.elementor-element-{{ID}} .slider-thumb-dots .owl-dot img' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'dots_kind' => 'thumb',
				),
			)
		);

		$self->add_control(
			'dots_thumb_border_width',
			array(
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Controls border width of image thumbnail dots.', 'riode-core' ),
				'label'       => esc_html__( 'Thumb Dots Border Width (px)', 'riode-core' ),
				'default'     => array(
					'unit' => 'px',
					'size' => '3',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 20,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .slider-thumb-dots .owl-dot' => 'padding: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'dots_kind' => 'thumb',
				),
			)
		);

	$self->end_controls_section();
}

/**
 * Elementor content-template for slider.
 */
function riode_elementor_slider_template() {

	wp_enqueue_script( 'owl-carousel' );
	global $riode_breakpoints;
	?>
	var breakpoints = <?php echo json_encode( $riode_breakpoints ); ?>;
	var extra_options = {};

	extra_class += ' owl-carousel owl-theme';

	// Layout
	if ( 'lg' === settings.col_sp || 'xs' === settings.col_sp || 'sm' === settings.col_sp || 'no' === settings.col_sp ) {
		extra_class += ' gutter-' + settings.col_sp;
	}

	var col_cnt = riode_get_responsive_cols({
		xl: settings.col_cnt_xl,
		lg: settings.col_cnt,
		md: settings.col_cnt_tablet,
		sm: settings.col_cnt_mobile,
		min: settings.col_cnt_min,
	});
	extra_class += ' ' + riode_get_col_class( col_cnt );

	// Nav & Dot

	if ( 'full' === settings.nav_type ) {
		extra_class += ' owl-nav-full';
	} else {
		if ( 'simple' === settings.nav_type ) {
			extra_class += ' owl-nav-simple';
		}
		if ( 'simple2' === settings.nav_type ) {
			extra_class += ' owl-nav-simple2';
		}
		if ( 'inner' === settings.nav_pos ) {
			extra_class += ' owl-nav-inner';
		} else if ( 'top' === settings.nav_pos ) {
			extra_class += ' owl-nav-top';
		}
	}
	if ( 'yes' === settings.nav_hide ) {
		extra_class += ' owl-nav-fade';
	}

	if ( 'yes' === settings.vertical_dots ) {
		extra_class += ' vertical-dots';
	}

	if ( settings.dots_type ) {
		extra_class += ' owl-dot-' + settings.dots_type;
	}

	if ( 'inner' === settings.dots_pos ) {
		extra_class += ' owl-dot-inner';
	}
	if ( 'close' === settings.dots_pos ) {
		extra_class += ' owl-dot-close';
	}

	if ( 'yes' === settings.fullheight ) {
		extra_class += ' owl-full-height';
	}

	if ( 'top' === settings.slider_vertical_align ||
		'middle' === settings.slider_vertical_align ||
		'bottom' === settings.slider_vertical_align ||
		'same-height' === settings.slider_vertical_align ) {
		extra_class += ' owl-' + settings.slider_vertical_align;
	}

	// Options

	if ( settings.show_nav_mobile ) {
		extra_options["nav"] = true;
	}
	if ( ! settings.show_dots_mobile ) {
		extra_options["dots"] = false;
	}
	if ( 'no' !== settings.col_sp ) {
		if ( 'sm' === settings.col_sp ) {
			extra_options['margin'] = 10;
		}
		else if ( 'lg' === settings.col_sp ) {
			extra_options['margin'] = 30;
		}
		else if ( 'xs' === settings.col_sp ) {
			extra_options['margin'] = 2;
		}
		else {
			extra_options['margin'] = 20;
		}
	}
	if ( 'yes' == settings.autoplay ) {
		extra_options["autoplay"] = true;
	}
	if ( 5000 != settings.autoplay_timeout ) {
		extra_options["autoplayTimeout"] = settings.autoplay_timeout;
	}
	if ( 'yes' === settings.pause_onhover ) {
		extra_options["autoplayHoverPause"] = true;
	}
	if ( 'yes' === settings.loop ) {
		extra_options["loop"] = true;
	}
	if ( 'yes' === settings.autoheight) {
		extra_options["autoHeight"] = true;
	}
	if ( 'yes' === settings.prevent_drag ) {
		extra_options["mouseDrag"] = false;
		extra_options["touchDrag"] = false;
		extra_options["pullDrag"]  = false;
	}
	if ( settings.animation_in ) {
		extra_options["animateIn"] = settings.animation_in;
	}
	if ( settings.animation_out ) {
		extra_options["animateOut"] = settings.animation_out;
	}
	if ( settings.dots_kind ) {
		extra_options["dotsContainer"] = '.slider-thumb-dots-' + view.getID();
	}
	var responsive = {};
	for ( var w in col_cnt ) {
		responsive[ breakpoints[ w ] ] = {
			items: col_cnt[w]
		};
	}
	if ( ! responsive[ breakpoints.md ] ) {
		responsive[ breakpoints.md ] = {};
	}
	responsive[ breakpoints.md ].nav = 'yes' === settings.show_nav_tablet;
	responsive[ breakpoints.md ].dots = 'yes' === settings.show_dots_tablet;
	if ( ! responsive[ breakpoints.lg ] ) {
		responsive[ breakpoints.lg ] = {};
	}
	responsive[ breakpoints.lg ].nav  = 'yes' === settings.show_nav;
	responsive[ breakpoints.lg ].dots = 'yes' === settings.show_dots;
	if ( responsive[ breakpoints.xl ] ) {
		responsive[ breakpoints.xl ].nav  = 'yes' === settings.show_nav;
		responsive[ breakpoints.xl ].dots = 'yes' === settings.show_dots;
	}

	extra_options.responsive = responsive;

	extra_attrs += ' data-plugin="owl" data-owl-options=' + JSON.stringify( extra_options );
	<?php
}
