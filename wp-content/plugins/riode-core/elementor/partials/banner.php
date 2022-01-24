<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

/**
 * Register banner controls.
 */
function riode_elementor_banner_controls( $self, $mode = '' ) {

	$self->start_controls_section(
		'section_banner',
		array(
			'label' => esc_html__( 'Banner', 'riode-core' ),
		)
	);

	if ( 'insert_number' == $mode ) {
		$self->add_control(
			'banner_insert',
			array(
				'label'   => esc_html__( 'Insert number', 'riode-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '1',
			)
		);
	}

	$self->add_control(
		'banner_presets_heading',
		array(
			'label' => esc_html__( 'Presets', 'riode-core' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$self->add_control(
		'banner_preset',
		[
			'label'       => esc_html__( 'Preset', 'riode-core' ),
			'type'        => 'riode_image_choose',
			'description' => esc_html__( 'Choose one from prebuilt banner presets.', 'riode-core' ),
			'default'     => 'simple-center',
			'options'     => [
				'simple-left'   => RIODE_CORE_URI . '/assets/images/banner/banner-1.jpg',
				'simple-center' => RIODE_CORE_URI . '/assets/images/banner/banner-2.jpg',
				'simple-right'  => RIODE_CORE_URI . '/assets/images/banner/banner-3.jpg',
				'badge-simple'  => RIODE_CORE_URI . '/assets/images/banner/banner-4.jpg',
				'boxed-left'    => RIODE_CORE_URI . '/assets/images/banner/banner-5.jpg',
				'boxed-center'  => RIODE_CORE_URI . '/assets/images/banner/banner-6.jpg',
				'boxed-right'   => RIODE_CORE_URI . '/assets/images/banner/banner-7.jpg',
				'boxed-round'   => RIODE_CORE_URI . '/assets/images/banner/banner-8.jpg',
			],
		]
	);

	$self->add_control(
		'banner_background_heading',
		array(
			'label'       => esc_html__( 'Background', 'riode-core' ),
			'description' => esc_html__( 'Set background color and image with excluisve options like position, size, repeat and etc.', 'riode-core' ),
			'type'        => Controls_Manager::HEADING,
			'separator'   => 'before',
		)
	);

	$self->add_group_control(
		Group_Control_Background::get_type(),
		array(
			'name'           => 'banner_background',
			'types'          => array( 'classic', 'gradient' ),
			'selector'       => 'riode_widget_banner' == $self->get_name() ? '{{WRAPPER}}' : '.elementor-element-{{ID}} .banner',
			'fields_options' => array(
				'background' => array(
					'frontend_available' => true,
					'default'            => 'classic',
				),
				'color'      => array(
					'default' => '#27c',
					'dynamic' => array(),
				),
				'color_b'    => array(
					'dynamic'   => array(),
					'condition' => array(
						'fixed_banner' => 'yes',
					),
				),
			),
		)
	);

	$self->add_control(
		'banner_content_heading',
		array(
			'label'     => esc_html__( 'Content Items', 'riode-core' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		)
	);

	$repeater = new Repeater();

		$repeater->start_controls_tabs(
			'banner_item_tabs'
		);

		$repeater->start_controls_tab(
			'banner_item_content',
			array(
				'label' => esc_html__( 'Content', 'riode-core' ),
			)
		);
			/* Global */
			$repeater->add_control(
				'banner_item_type',
				array(
					'label'       => esc_html__( 'Type', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'description' => esc_html__( 'Choose the content item type.', 'riode-core' ),
					'default'     => 'text',
					'options'     => array(
						'text'   => esc_html__( 'Text', 'riode-core' ),
						'button' => esc_html__( 'Button', 'riode-core' ),
						'image'  => esc_html__( 'Image', 'riode-core' ),
					),
				)
			);

			$repeater->add_control(
				'banner_item_display',
				array(
					'label'       => esc_html__( 'Display', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'description' => esc_html__( 'Choose the display type of content item.', 'riode-core' ),
					'default'     => 'block',
					'options'     => array(
						'inline' => esc_html__( 'Inline', 'riode-core' ),
						'block'  => esc_html__( 'Block', 'riode-core' ),
					),
				)
			);

			$repeater->add_control(
				'banner_item_aclass',
				array(
					'label' => esc_html__( 'Custom Class', 'riode-core' ),
					'type'  => Controls_Manager::TEXT,
				)
			);

			/* Text Item */
			$repeater->add_control(
				'banner_text_content',
				array(
					'label'     => esc_html__( 'Content', 'riode-core' ),
					'type'      => Controls_Manager::TEXTAREA,
					'condition' => array(
						'banner_item_type' => 'text',
					),
				)
			);

			$repeater->add_control(
				'banner_text_tag',
				array(
					'label'     => esc_html__( 'Tag', 'riode-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'h2',
					'options'   => array(
						'h1'   => esc_html__( 'H1', 'riode-core' ),
						'h2'   => esc_html__( 'H2', 'riode-core' ),
						'h3'   => esc_html__( 'H3', 'riode-core' ),
						'h4'   => esc_html__( 'H4', 'riode-core' ),
						'h5'   => esc_html__( 'H5', 'riode-core' ),
						'h6'   => esc_html__( 'H6', 'riode-core' ),
						'p'    => esc_html__( 'p', 'riode-core' ),
						'div'  => esc_html__( 'div', 'riode-core' ),
						'span' => esc_html__( 'span', 'riode-core' ),
					),
					'condition' => array(
						'banner_item_type' => 'text',
					),
				)
			);

			/* Button */
			$repeater->add_control(
				'banner_btn_text',
				array(
					'label'       => esc_html__( 'Text', 'riode-core' ),
					'description' => esc_html__( 'Type text that will be shown on button.', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'condition'   => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_link',
				array(
					'label'       => esc_html__( 'Link Url', 'riode-core' ),
					'description' => esc_html__( 'Input URL where you will move when button is clicked.', 'riode-core' ),
					'type'        => Controls_Manager::URL,
					'default'     => array(
						'url' => '',
					),
					'condition'   => array(
						'banner_item_type' => 'button',
					),
				)
			);

			riode_elementor_button_layout_controls( $repeater, 'banner_item_type', 'button' );

			/* Image */
			$repeater->add_control(
				'banner_image',
				array(
					'label'     => esc_html__( 'Choose Image', 'riode-core' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'condition' => array(
						'banner_item_type' => 'image',
					),
				)
			);

			$repeater->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'      => 'banner_image',
					'default'   => 'full',
					'separator' => 'none',
					'condition' => array(
						'banner_item_type' => 'image',
					),
				)
			);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'banner_item_style',
			array(
				'label' => esc_html__( 'Style', 'riode-core' ),
			)
		);

			// Global
			$repeater->add_responsive_control(
				'banner_item_margin',
				array(
					'label'      => esc_html__( 'Margin', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_item_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default'    => array(
						'unit' => 'px',
					),
					'size_units' => array( 'px', 'em', 'rem', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			// Text
			$repeater->add_control(
				'banner_text_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'separator' => 'before',
					'condition' => array(
						'banner_item_type' => 'text',
					),
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.text, .elementor-element-{{ID}} {{CURRENT_ITEM}} .text' => 'color: {{VALUE}};',
					),
				)
			);
			$repeater->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'banner_text_typo',
					'scheme'    => Typography::TYPOGRAPHY_4,
					'condition' => array(
						'banner_item_type' => 'text',
					),
					'selector'  => '.elementor-element-{{ID}} {{CURRENT_ITEM}}.text, .elementor-element-{{ID}} {{CURRENT_ITEM}} .text',
				)
			);

			// Button
			$repeater->add_responsive_control(
				'banner_btn_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition'  => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_responsive_control(
				'banner_btn_border_width',
				array(
					'label'      => esc_html__( 'Border Width', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
						'em',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
					'condition'  => array(
						'banner_item_type' => 'button',
					),
				)
			);

			$repeater->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'banner_btn_typo',
					'scheme'    => Typography::TYPOGRAPHY_4,
					'separator' => 'before',
					'condition' => array(
						'banner_item_type' => 'button',
					),
					'selector'  => '.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn',
					'condition' => array(
						'banner_item_type' => 'button',
					),
				)
			);

			// Animation
			$repeater->add_responsive_control(
				'_animation',
				array(
					'label'              => esc_html__( 'Entrance Animation', 'riode-core' ),
					'type'               => Controls_Manager::ANIMATION,
					'frontend_available' => true,
					'separator'          => 'before',
				)
			);

			$repeater->add_control(
				'animation_duration',
				array(
					'label'        => esc_html__( 'Animation Duration', 'riode-core' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => '',
					'options'      => array(
						'slow' => esc_html__( 'Slow', 'riode-core' ),
						''     => esc_html__( 'Normal', 'riode-core' ),
						'fast' => esc_html__( 'Fast', 'riode-core' ),
					),
					'prefix_class' => 'animated-',
					'condition'    => array(
						'_animation!' => '',
					),
				)
			);

			$repeater->add_control(
				'_animation_delay',
				array(
					'label'              => esc_html__( 'Animation Delay', 'riode-core' ) . ' (ms)',
					'type'               => Controls_Manager::NUMBER,
					'default'            => '',
					'min'                => 0,
					'step'               => 100,
					'condition'          => array(
						'_animation!' => '',
					),
					'render_type'        => 'none',
					'frontend_available' => true,
				)
			);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'banner_item_floating',
			array(
				'label' => esc_html__( 'Floating', 'riode-core' ),
			)
		);

			riode_elementor_add_floating_controls( $repeater, true );

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$repeater->add_control(
			'banner_btn_heading',
			array(
				'label'     => esc_html__( 'Button Custom Style', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'banner_item_type' => 'button',
				),
			)
		);

		$repeater->start_controls_tabs(
			'tabs_banner_btn_cat',
			array(
				'condition' => array(
					'banner_item_type' => 'button',
				),
			)
		);

			$repeater->start_controls_tab(
				'tab_banner_btn_normal',
				array(
					'label' => esc_html__( 'Normal', 'riode-core' ),
				)
			);

			$repeater->add_control(
				'banner_btn_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn' => 'color: {{VALUE}};',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn' => 'background-color: {{VALUE}};',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn' => 'border-color: {{VALUE}};',
					),
				)
			);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'tab_banner_btn_hover',
				array(
					'label' => esc_html__( 'Hover', 'riode-core' ),
				)
			);

			$repeater->add_control(
				'banner_btn_color_hover',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn:hover, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn:hover' => 'color: {{VALUE}};',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_back_color_hover',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn:hover, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn:hover' => 'background-color: {{VALUE}};',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_border_color_hover',
				array(
					'label'     => esc_html__( 'Border Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn:hover, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn:hover' => 'border-color: {{VALUE}};',
					),
				)
			);
			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'tab_banner_btn_active',
				array(
					'label' => esc_html__( 'Active', 'riode-core' ),
				)
			);

			$repeater->add_control(
				'banner_btn_color_active',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn:not(:focus):active, .elementor-element-{{ID}} {{CURRENT_ITEM}}.btn:focus, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn:not(:focus):active, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn:focus' => 'color: {{VALUE}};',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_back_color_active',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn:not(:focus):active, .elementor-element-{{ID}} {{CURRENT_ITEM}}.btn:focus, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn:not(:focus):active, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn:focus' => 'background-color: {{VALUE}};',
					),
				)
			);

			$repeater->add_control(
				'banner_btn_border_color_active',
				array(
					'label'     => esc_html__( 'Border Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} {{CURRENT_ITEM}}.btn:not(:focus):active, .elementor-element-{{ID}} {{CURRENT_ITEM}}.btn:focus, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn:not(:focus):active, .elementor-element-{{ID}} {{CURRENT_ITEM}} .btn:focus' => 'border-color: {{VALUE}};',
					),
				)
			);
			$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

		$presets = array(
			array(
				'_id'                 => 'heading',
				'banner_item_type'    => 'text',
				'banner_item_display' => 'block',
				'banner_text_content' => esc_html__( 'This is a simple banner', 'riode-core' ),
				'banner_text_tag'     => 'h3',
				'banner_text_color'   => '#fff',
			),
			array(
				'_id'                 => 'text',
				'banner_item_type'    => 'text',
				'banner_item_display' => 'block',
				'banner_text_content' => sprintf( esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh %1$s euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'riode-core' ), '<br/>' ),
				'banner_text_tag'     => 'p',
				'banner_text_color'   => '#fff',
			),
			array(
				'_id'                 => 'button',
				'banner_item_type'    => 'button',
				'banner_item_display' => 'inline',
				'banner_btn_text'     => esc_html__( 'Click Here', 'riode-core' ),
				'button_type'         => 'btn-outline',
				'button_skin'         => 'btn-white',
			),
		);

	$self->add_control(
		'banner_item_list',
		array(
			'label'       => esc_html__( 'Banner Items', 'riode-core' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => $presets,
			'title_field' => sprintf( '{{{ banner_item_type == "text" ? \'%1$s\' : ( banner_item_type == "image" ? \'%2$s\' : \'%3$s\' ) }}}  {{{ banner_item_type == "text" ? banner_text_content : ( banner_item_type == "image" ? banner_image[\'url\'] : banner_btn_text ) }}}', '<i class="eicon-t-letter"></i>', '<i class="eicon-image"></i>', '<i class="eicon-button"></i>' ),
		)
	);

	$self->end_controls_section();

	/* Banner Style */
	$self->start_controls_section(
		'section_banner_style',
		array(
			'label' => esc_html__( 'Banner Wrapper', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_responsive_control(
			'banner_max_height',
			array(
				'label'       => esc_html__( 'Max Height', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Controls max height value of banner.', 'riode-core' ),
				'default'     => array(
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 700,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner, .elementor-element-{{ID}} img' => 'max-height:{{SIZE}}{{UNIT}};overflow:hidden;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_min_height',
			array(
				'label'       => esc_html__( 'Min Height', 'riode-core' ),
				'description' => esc_html__( 'Controls min height value of banner.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'unit' => 'px',
					'size' => 450,
				),
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'range'       => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 700,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vh'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner' => 'min-height:{{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'absolute_banner',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Absolute Content', 'riode-core' ),
				'description' => esc_html__( 'Content will be placed absolutely above image with l/t/r/b position.', 'riode-core' ),
				'default'     => 'yes',
			)
		);

		$self->add_control(
			'fixed_banner',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Background Banner / Image Banner', 'riode-core' ),
				'description' => esc_html__( 'Choose whether image is shown with background style or <img> tag.', 'riode-core' ),
				'default'     => 'yes',
			)
		);

		$self->add_responsive_control(
			'banner_img_pos',
			array(
				'label'       => esc_html__( 'Image Position (%)', 'riode-core' ),
				'description' => esc_html__( 'Changes image position when image is larger than render area.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'%' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner-img img' => 'object-position: {{SIZE}}%;',
				),
				'condition'   => array(
					'absolute_banner' => 'yes',
					'fixed_banner'    => 'yes',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'banner_layer_layout',
		array(
			'label' => esc_html__( 'Banner Content', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);
		$self->add_control(
			'banner_wrap',
			array(
				'label'       => esc_html__( 'Wrap content with', 'riode-core' ),
				'description' => esc_html__( 'Choose to wrap banner content in Fullscreen banner.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''                => esc_html__( 'None', 'riode-core' ),
					'container'       => esc_html__( 'Container', 'riode-core' ),
					'container-fluid' => esc_html__( 'Container fluid', 'riode-core' ),
				),
			)
		);
		$self->add_responsive_control(
			'banner_content_padding',
			array(
				'label'       => esc_html__( 'Content Padding', 'riode-core' ),
				'description' => esc_html__( 'Controls padding of banner content.', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'default'     => array(
					'unit' => 'px',
				),
				'size_units'  => array( 'px', '%' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$self->add_control(
			'banner_content_bg',
			array(
				'label'       => esc_html__( 'Background Color', 'riode-core' ),
				'description' => esc_html__( 'Set background color of banner content.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'background: {{VALUE}};',
				),
			)
		);
		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'        => 'banner_content_shadow',
				'description' => esc_html__( 'Set box shadow of boxed banner content.', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .banner .banner-content',
			)
		);
		$self->add_control(
			'banner_text_align',
			array(
				'label'       => esc_html__( 'Text Align', 'riode-core' ),
				'description' => esc_html__( 'Set global alignment of banner content items.', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justify', 'riode-core' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'text-align: {{VALUE}}',
				),
			)
		);

		$self->add_control(
			'banner_origin',
			array(
				'label'       => esc_html__( 'Origin', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'description' => esc_html__( 'Set base point of banner content to determine content position.', 'riode-core' ),
				'options'     => array(
					't-none' => array(
						'title' => esc_html__( 'Default', 'riode-core' ),
						'icon'  => 'eicon-ban',
					),
					't-m'    => array(
						'title' => esc_html__( 'Vertical Center', 'riode-core' ),
						'icon'  => 'eicon-v-align-middle',
					),
					't-c'    => array(
						'title' => esc_html__( 'Horizontal Center', 'riode-core' ),
						'icon'  => 'eicon-h-align-center',
					),
					't-mc'   => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'eicon-frame-minimize',
					),
				),
				'default'     => '',
				'condition'   => array(
					'absolute_banner' => 'yes',
				),
			)
		);

		$self->start_controls_tabs(
			'banner_position_tabs',
			array(
				'condition' => array(
					'absolute_banner' => 'yes',
				),
			)
		);

		$self->start_controls_tab(
			'banner_pos_left_tab',
			array(
				'label' => esc_html__( 'Left', 'riode-core' ),
			)
		);

		$self->add_control(
			'banner_left_auto',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Remove Left Offset', 'riode-core' ),
				'description' => esc_html__( 'Set to give auto value for left position of banner content.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'left:auto;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_left',
			array(
				'label'       => esc_html__( 'Left Offset', 'riode-core' ),
				'description' => esc_html__( 'Set Left position of banner content.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'       => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'left:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'banner_left_auto' => '',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_top_tab',
			array(
				'label' => esc_html__( 'Top', 'riode-core' ),
			)
		);

		$self->add_control(
			'banner_top_auto',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Remove Top Offset', 'riode-core' ),
				'description' => esc_html__( 'Set to give auto value for top position of banner content.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'top:auto;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_top',
			array(
				'label'       => esc_html__( 'Top Offset', 'riode-core' ),
				'description' => esc_html__( 'Set top position of banner content.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'       => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'top:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'banner_top_auto' => '',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_right_tab',
			array(
				'label' => esc_html__( 'Right', 'riode-core' ),
			)
		);

		$self->add_control(
			'banner_right_auto',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Remove Right Offset', 'riode-core' ),
				'description' => esc_html__( 'Set to give auto value for right position of banner content.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'right:auto;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_right',
			array(
				'label'       => esc_html__( 'Right Offset', 'riode-core' ),
				'description' => esc_html__( 'Set right position of banner content.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'       => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'right:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'banner_right_auto' => '',
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_bottom_tab',
			array(
				'label' => esc_html__( 'Bottom', 'riode-core' ),
			)
		);

		$self->add_control(
			'banner_bottom_auto',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Remove Bottom Offset', 'riode-core' ),
				'description' => esc_html__( 'Set to give auto value for bottom position of banner content.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'bottom:auto;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_bottom',
			array(
				'label'       => esc_html__( 'Bottom Offset', 'riode-core' ),
				'description' => esc_html__( 'Set bottom position of banner content.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'       => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'bottom:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'banner_bottom_auto' => '',
				),
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_responsive_control(
			'banner_width',
			array(
				'label'       => esc_html__( 'Width', 'riode-core' ),
				'description' => esc_html__( 'Changes banner content width.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 1000,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'     => array(
					'unit' => '%',
				),
				'separator'   => 'before',
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'max-width:{{SIZE}}{{UNIT}}; width: 100%',
				),
				'condition'   => array(
					'absolute_banner' => 'yes',
				),
			)
		);

		$self->add_responsive_control(
			'banner_height',
			array(
				'label'       => esc_html__( 'Height', 'riode-core' ),
				'description' => esc_html__( 'Changes banner content height.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 1000,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'     => array(
					'unit' => '%',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner .banner-content' => 'height:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'absolute_banner' => 'yes',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'banner_effect',
		array(
			'label' => esc_html__( 'Banner Effect', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'banner_image_effect',
			array(
				'label' => esc_html__( 'Image Effect', 'riode-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$self->add_control(
			'overlay',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Hover Effect', 'riode-core' ),
				'description' => esc_html__( 'Choose banner overlay and image filter effect on hover.', 'riode-core' ),
				'groups'      => array(
					''        => esc_html__( 'None', 'riode-core' ),
					'overlay' => array(
						'label'   => esc_html__( 'Overlay', 'riode-core' ),
						'options' => array(
							'light'      => esc_html__( 'Light', 'riode-core' ),
							'dark'       => esc_html__( 'Dark', 'riode-core' ),
							'zoom'       => esc_html__( 'Zoom', 'riode-core' ),
							'zoom_light' => esc_html__( 'Zoom and Light', 'riode-core' ),
							'zoom_dark'  => esc_html__( 'Zoom and Dark', 'riode-core' ),
						),
					),
					'effect'  => array(
						'label'   => esc_html__( 'Effect', 'riode-core' ),
						'options' => array(
							'effect-1' => esc_html__( 'Effect 1', 'riode-core' ),
							'effect-2' => esc_html__( 'Effect 2', 'riode-core' ),
							'effect-3' => esc_html__( 'Effect 3', 'riode-core' ),
							'effect-4' => esc_html__( 'Effect 4', 'riode-core' ),
						),
					),
					'filter'  => array(
						'label'   => esc_html__( 'Image Filter', 'riode-core' ),
						'options' => array(
							'blur'       => esc_html__( 'Blur', 'riode-core' ),
							'brightness' => esc_html__( 'Brightness', 'riode-core' ),
							'contrast'   => esc_html__( 'Contrast', 'riode-core' ),
							'grayscale'  => esc_html__( 'Grayscale', 'riode-core' ),
							'hue'        => esc_html__( 'Hue-Rotate', 'riode-core' ),
							'opacity'    => esc_html__( 'Opacity', 'riode-core' ),
							'saturate'   => esc_html__( 'Saturate', 'riode-core' ),
							'sepia'      => esc_html__( 'Sepia', 'riode-core' ),
						),
					),
				),
			)
		);

		$self->add_control(
			'banner_overlay_color',
			array(
				'label'       => esc_html__( 'Hover Effect Color', 'riode-core' ),
				'description' => esc_html__( 'Set overlay color of hover effect.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .banner:before, .elementor-element-{{ID}} .banner:after, .elementor-element-{{ID}} .banner figure:before, .elementor-element-{{ID}} .banner figure:after' => 'background: {{VALUE}};',
					'.elementor-element-{{ID}} .overlay-dark:hover figure:after' => 'opacity: .5;',
				),
				'condition'   => array(
					'overlay!' => array( '', 'blur', 'brightness', 'contrast', 'grayscale', 'hue', 'opacity', 'saturate', 'sepia' ),
				),
			)
		);

		$self->add_control(
			'background_effect',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Backgrund Effect', 'riode-core' ),
				'description' => esc_html__( 'Choose banner background effect. (Kenburns Effect)', 'riode-core' ),
				'options'     => array(
					''                   => esc_html__( 'No', 'riode-core' ),
					'kenBurnsToRight'    => esc_html__( 'kenBurnsRight', 'riode-core' ),
					'kenBurnsToLeft'     => esc_html__( 'kenBurnsLeft', 'riode-core' ),
					'kenBurnsToLeftTop'  => esc_html__( 'kenBurnsLeftToTop', 'riode-core' ),
					'kenBurnsToRightTop' => esc_html__( 'kenBurnsRightTop', 'riode-core' ),
				),
			)
		);

		$self->add_control(
			'background_effect_duration',
			array(
				'label'       => esc_html__( 'Background Effect Duration (s)', 'riode-core' ),
				'description' => esc_html__( 'Set banner background effect duration time.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					's',
				),
				'default'     => array(
					'size' => 30,
					'unit' => 's',
				),
				'range'       => array(
					's' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 60,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .background-effect' => 'animation-duration:{{SIZE}}s;',
				),
				'condition'   => array(
					'background_effect!' => '',
				),
			)
		);

		$self->add_control(
			'particle_effect',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Particle Effects', 'riode-core' ),
				'description' => esc_html__( 'Shows animating particles over banner image. Choose from Snowfall, Sparkle.', 'riode-core' ),
				'options'     => array(
					''         => esc_html__( 'No', 'riode-core' ),
					'snowfall' => esc_html__( 'Snowfall', 'riode-core' ),
					'sparkle'  => esc_html__( 'Sparkle', 'riode-core' ),
				),
			)
		);

		$self->add_control(
			'parallax',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Enable Parallax', 'riode-core' ),
				'description' => esc_html__( 'Set to enable parallax effect for banner.', 'riode-core' ),
			)
		);

		$self->add_control(
			'banner_content_effect',
			array(
				'label'     => esc_html__( 'Content Effect', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$self->add_responsive_control(
			'_content_animation',
			array(
				'label'              => esc_html__( 'Content Entrance Animation', 'riode-core' ),
				'type'               => Controls_Manager::ANIMATION,
				'description'        => esc_html__( 'Set entrance animation for entire banner content.', 'riode-core' ),
				'frontend_available' => true,
			)
		);

		$self->add_control(
			'content_animation_duration',
			array(
				'label'        => esc_html__( 'Animation Duration', 'riode-core' ),
				'description'  => esc_html__( 'Determine how long entrance animation should shown.' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					'slow' => esc_html__( 'Slow', 'riode-core' ),
					''     => esc_html__( 'Normal', 'riode-core' ),
					'fast' => esc_html__( 'Fast', 'riode-core' ),
				),
				'prefix_class' => 'animated-',
				'condition'    => array(
					'_content_animation!' => '',
				),
			)
		);

		$self->add_control(
			'_content_animation_delay',
			array(
				'label'              => esc_html__( 'Animation Delay', 'riode-core' ) . ' (ms)',
				'description'        => esc_html__( 'Set delay time for content entrance animation.', 'riode-core' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => '',
				'min'                => 0,
				'step'               => 100,
				'condition'          => array(
					'_content_animation!' => '',
				),
				'render_type'        => 'none',
				'frontend_available' => true,
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'parallax_options',
		array(
			'label'     => esc_html__( 'Parallax', 'riode-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'parallax' => 'yes',
			),
		)
	);

		$self->add_control(
			'parallax_speed',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Parallax Speed', 'riode-core' ),
				'description' => esc_html__( 'Change speed of banner parallax effect.', 'riode-core' ),
				'condition'   => array(
					'parallax' => 'yes',
				),
				'default'     => array(
					'size' => 1,
					'unit' => 'px',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 10,
					),
				),
			)
		);

		$self->add_control(
			'parallax_offset',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Parallax Offset', 'riode-core' ),
				'description' => esc_html__( 'Determine offset value of parallax effect to show different parts on screen.', 'riode-core' ),
				'condition'   => array(
					'parallax' => 'yes',
				),
				'default'     => array(
					'size' => 0,
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => -300,
						'max'  => 300,
					),
				),
			)
		);

		$self->add_control(
			'parallax_height',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Parallax Height (%)', 'riode-core' ),
				'description' => esc_html__( 'Change height of parallax background image.', 'riode-core' ),
				'condition'   => array(
					'parallax' => 'yes',
				),
				'separator'   => 'after',
				'default'     => array(
					'size' => 200,
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 100,
						'max'  => 300,
					),
				),
			)
		);

	$self->end_controls_section();
}

/**
 * Render banner.
 */
function riode_products_render_banner( $self, $atts ) {
	include RIODE_CORE_PATH . 'elementor/render/widget-banner-render.php';
}

/**
 * Register elementor layout controls for section & column banner.
 */
function riode_elementor_banner_layout_controls( $self, $condition_key ) {

	$is_section = 'section' == $self->get_type();
	$is_column  = 'column' == $self->get_type();

	if ( ! $is_section ) {
		$self->add_control(
			'banner_wrap_with',
			array(
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose to wrap banner content in Fullscreen banner.', 'riode-core' ),
				'label'       => esc_html__( 'Content Width', 'riode-core' ),
				'options'     => array(
					''                => esc_html__( 'Default', 'riode-core' ),
					'container'       => esc_html__( 'Container', 'riode-core' ),
					'container-fluid' => esc_html__( 'Container Fluid', 'riode-core' ),
				),
				'condition'   => array(
					$condition_key => 'banner',
				),
			)
		);
	}

	$self->add_responsive_control(
		'banner_min_height',
		array(
			'label'       => esc_html__( 'Min Height', 'riode-core' ),
			'description' => esc_html__( 'Controls min height value of banner.', 'riode-core' ),
			'type'        => Controls_Manager::SLIDER,
			'default'     => array(
				'unit' => 'px',
			),
			'size_units'  => array(
				'px',
				'rem',
				'%',
				'vh',
			),
			'range'       => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 700,
				),
			),
			'condition'   => array(
				$condition_key => 'banner',
			),
			'selectors'   => array(
				'.elementor .elementor-element-{{ID}}' => 'min-height:{{SIZE}}{{UNIT}};',
				'.elementor-element-{{ID}} > .elementor-container' => 'min-height:{{SIZE}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'banner_max_height',
		array(
			'label'       => esc_html__( 'Max Height', 'riode-core' ),
			'description' => esc_html__( 'Controls max height value of banner.', 'riode-core' ),
			'type'        => Controls_Manager::SLIDER,
			'default'     => array(
				'unit' => 'px',
			),
			'size_units'  => array(
				'px',
				'rem',
				'%',
				'vh',
			),
			'range'       => array(
				'px' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 700,
				),
			),
			'condition'   => array(
				$condition_key => 'banner',
			),
			'selectors'   => array(
				'.elementor .elementor-element-{{ID}}' => 'max-height:{{SIZE}}{{UNIT}};',
				'.elementor-element-{{ID}} > .elementor-container' => 'max-height:{{SIZE}}{{UNIT}};',
			),
		)
	);

	if ( ! $is_column ) {
		$self->add_control(
			'fixed_banner',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Background Banner / Image Banner', 'riode-core' ),
				'description' => esc_html__( 'Choose whether image is shown with background style or <img> tag.', 'riode-core' ),
				'condition'   => array(
					$condition_key => 'banner',
				),
				'default'     => $is_section ? 'yes' : '',
			)
		);
	}

	$self->add_responsive_control(
		'banner_img_pos',
		array(
			'label'       => esc_html__( 'Image Position (%)', 'riode-core' ),
			'description' => esc_html__( 'Changes image position when image is larger than render area.', 'riode-core' ),
			'type'        => Controls_Manager::SLIDER,
			'range'       => array(
				'%' => array(
					'step' => 1,
					'min'  => 0,
					'max'  => 100,
				),
			),
			'condition'   => $is_section ? array(
				$condition_key => 'banner',
				'fixed_banner' => 'yes',
			) : array( $condition_key => 'banner' ),
			'selectors'   => array(
				'{{WRAPPER}} .banner-img img' => 'object-position: {{SIZE}}%;',
			),
		)
	);

	$self->add_control(
		'overlay',
		array(
			'type'        => Controls_Manager::SELECT,
			'label'       => esc_html__( 'Hover Effect', 'riode-core' ),
			'description' => esc_html__( 'Choose banner overlay and image filter effect on hover.', 'riode-core' ),
			'groups'      => array(
				''        => esc_html__( 'None', 'riode-core' ),
				'overlay' => array(
					'label'   => esc_html__( 'Overlay', 'riode-core' ),
					'options' => array(
						'light'      => esc_html__( 'Light', 'riode-core' ),
						'dark'       => esc_html__( 'Dark', 'riode-core' ),
						'zoom'       => esc_html__( 'Zoom', 'riode-core' ),
						'zoom_light' => esc_html__( 'Zoom and Light', 'riode-core' ),
						'zoom_dark'  => esc_html__( 'Zoom and Dark', 'riode-core' ),
					),
				),
				'effect'  => array(
					'label'   => esc_html__( 'Effect', 'riode-core' ),
					'options' => array(
						'effect-1' => esc_html__( 'Effect 1', 'riode-core' ),
						'effect-2' => esc_html__( 'Effect 2', 'riode-core' ),
						'effect-3' => esc_html__( 'Effect 3', 'riode-core' ),
						'effect-4' => esc_html__( 'Effect 4', 'riode-core' ),
					),
				),
				'filter'  => array(
					'label'   => esc_html__( 'Image Filter', 'riode-core' ),
					'options' => array(
						'blur'       => esc_html__( 'Blur', 'riode-core' ),
						'brightness' => esc_html__( 'Brightness', 'riode-core' ),
						'contrast'   => esc_html__( 'Contrast', 'riode-core' ),
						'grayscale'  => esc_html__( 'Grayscale', 'riode-core' ),
						'hue'        => esc_html__( 'Hue-Rotate', 'riode-core' ),
						'opacity'    => esc_html__( 'Opacity', 'riode-core' ),
						'saturate'   => esc_html__( 'Saturate', 'riode-core' ),
						'sepia'      => esc_html__( 'Sepia', 'riode-core' ),
					),
				),
			),
			'condition'   => array(
				$condition_key => 'banner',
			),
			'separator'   => 'before',
		)
	);

	$self->add_control(
		'banner_overlay_color',
		array(
			'label'       => esc_html__( 'Hover Effect Color', 'riode-core' ),
			'type'        => Controls_Manager::COLOR,
			'description' => esc_html__( 'Set overlay color of hover effect.', 'riode-core' ),
			'selectors'   => array(
				'.elementor-element-{{ID}} .banner:before, .elementor-element-{{ID}} .banner:after, .elementor-element-{{ID}} .banner figure:before, .elementor-element-{{ID}} .banner figure:after' => 'background: {{VALUE}};',
				'.elementor-element-{{ID}} .overlay-dark:hover figure:after' => 'opacity: .5;',
				'.elementor-element-{{ID}}.banner:before, .elementor-element-{{ID}}.banner:after, .elementor-element-{{ID}}.banner figure:before, .elementor-element-{{ID}}.banner figure:after' => 'background: {{VALUE}};',
				'.elementor-element-{{ID}}.overlay-dark:hover figure:after' => 'opacity: .5;',
			),
			'condition'   => array(
				'overlay!' => array( '', 'blur', 'brightness', 'contrast', 'grayscale', 'hue', 'opacity', 'saturate', 'sepia' ),
			),
		)
	);

	if ( ! $is_column ) {
		$self->add_control(
			'background_effect',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Backgrund Effect', 'riode-core' ),
				'description' => esc_html__( 'Choose banner background effect. (Kenburns Effect)', 'riode-core' ),
				'options'     => array(
					''                   => esc_html__( 'No', 'riode-core' ),
					'kenBurnsToRight'    => esc_html__( 'kenBurnsRight', 'riode-core' ),
					'kenBurnsToLeft'     => esc_html__( 'kenBurnsLeft', 'riode-core' ),
					'kenBurnsToLeftTop'  => esc_html__( 'kenBurnsLeftToTop', 'riode-core' ),
					'kenBurnsToRightTop' => esc_html__( 'kenBurnsRightToTop', 'riode-core' ),
				),
				'condition'   => array(
					$condition_key => 'banner',
				),
			)
		);

		$self->add_responsive_control(
			'background_effect_duration',
			array(
				'label'       => esc_html__( 'Background Effect Duration (s)', 'riode-core' ),
				'description' => esc_html__( 'Set banner background effect duration time.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					's',
				),
				'default'     => array(
					'size' => 30,
					'unit' => 's',
				),
				'range'       => array(
					's' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 60,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .background-effect' => 'animation-duration:{{SIZE}}s;',
				),
				'condition'   => array(
					$condition_key       => 'banner',
					'background_effect!' => '',
				),
			)
		);

		$self->add_control(
			'particle_effect',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Particle Effects', 'riode-core' ),
				'description' => esc_html__( 'Shows animating particles over banner image. Choose from Snowfall, Sparkle.', 'riode-core' ),
				'options'     => array(
					''         => esc_html__( 'No', 'riode-core' ),
					'snowfall' => esc_html__( 'Snowfall', 'riode-core' ),
					'sparkle'  => esc_html__( 'Sparkle', 'riode-core' ),
				),
				'separator'   => 'after',
				'condition'   => array(
					$condition_key => 'banner',
				),
			)
		);
	}
}

/**
 * Register elementor layout controls for column banner layer.
 */
function riode_elementor_banner_layer_layout_controls( $self, $condition_key ) {

	$self->start_controls_section(
		'banner_layer_layout',
		array(
			'label'     => esc_html__( 'Banner Layer', 'riode-core' ),
			'tab'       => Controls_Manager::TAB_LAYOUT,
			'condition' => array(
				$condition_key => array( 'banner', 'banner_layer' ),
			),
		)
	);
		$self->add_control(
			'banner_text_align',
			array(
				'label'       => esc_html__( 'Text Align', 'riode-core' ),
				'description' => esc_html__( 'Set global alignment of banner content items.', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justify', 'riode-core' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'selectors'   => array(
					'{{WRAPPER}}' => 'text-align: {{VALUE}}',
				),
				'condition'   => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->add_control(
			'banner_origin',
			array(
				'label'       => esc_html__( 'Origin', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'description' => esc_html__( 'Set base point of banner content to determine content position.', 'riode-core' ),
				'options'     => array(
					't-m'  => array(
						'title' => esc_html__( 'Vertical Center', 'riode-core' ),
						'icon'  => 'eicon-v-align-middle',
					),
					't-c'  => array(
						'title' => esc_html__( 'Horizontal Center', 'riode-core' ),
						'icon'  => 'eicon-h-align-center',
					),
					't-mc' => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'eicon-frame-minimize',
					),
				),
				'default'     => 't-mc',
				'condition'   => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->start_controls_tabs( 'banner_position_tabs' );

		$self->start_controls_tab(
			'banner_pos_left_tab',
			array(
				'label'     => esc_html__( 'Left', 'riode-core' ),
				'condition' => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->add_control(
			'banner_left_auto',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Remove Left Offset', 'riode-core' ),
				'description' => esc_html__( 'Set to give auto value for left position of banner content.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'left:auto;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_left',
			array(
				'label'       => esc_html__( 'Left Offset', 'riode-core' ),
				'description' => esc_html__( 'Set Left position of banner content.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'       => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'     => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'left:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_top_tab',
			array(
				'label'     => esc_html__( 'Top', 'riode-core' ),
				'condition' => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->add_control(
			'banner_top_auto',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Remove Top Offset', 'riode-core' ),
				'description' => esc_html__( 'Set to give auto value for top position of banner content.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'top:auto;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_top',
			array(
				'label'       => esc_html__( 'Top Offset', 'riode-core' ),
				'description' => esc_html__( 'Set top position of banner content.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'       => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'     => array(
					'size' => 50,
					'unit' => '%',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'top:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_right_tab',
			array(
				'label'     => esc_html__( 'Right', 'riode-core' ),
				'condition' => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->add_control(
			'banner_right_auto',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Remove Right Offset', 'riode-core' ),
				'description' => esc_html__( 'Set to give auto value for right position of banner content.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'right:auto;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_right',
			array(
				'label'       => esc_html__( 'Right Offset', 'riode-core' ),
				'description' => esc_html__( 'Set right position of banner content.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'       => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'right:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			'banner_pos_bottom_tab',
			array(
				'label'     => esc_html__( 'Bottom', 'riode-core' ),
				'condition' => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->add_control(
			'banner_bottom_auto',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Remove Bottom Offset', 'riode-core' ),
				'description' => esc_html__( 'Set to give auto value for bottom position of banner content.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'right:auto;',
				),
			)
		);

		$self->add_responsive_control(
			'banner_bottom',
			array(
				'label'       => esc_html__( 'Bottom Offset', 'riode-core' ),
				'description' => esc_html__( 'Set bottom position of banner content.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
					'%',
					'vw',
				),
				'range'       => array(
					'px'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 500,
					),
					'rem' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'%'   => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
					'vw'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'bottom:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_responsive_control(
			'banner_width',
			array(
				'label'       => esc_html__( 'Width', 'riode-core' ),
				'description' => esc_html__( 'Changes banner content width.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 1000,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'     => array(
					'unit' => '%',
				),
				'separator'   => 'before',
				'selectors'   => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'width:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

		$self->add_responsive_control(
			'banner_height',
			array(
				'label'       => esc_html__( 'Height', 'riode-core' ),
				'description' => esc_html__( 'Changes banner content height.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', '%' ),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 1000,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default'     => array(
					'unit' => '%',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}}.banner-content,.elementor-element-{{ID}}>.banner-content,.elementor-element-{{ID}}>div>.banner-content' => 'height:{{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					$condition_key => array( 'banner', 'banner_layer' ),
				),
			)
		);

	$self->end_controls_section();
}
