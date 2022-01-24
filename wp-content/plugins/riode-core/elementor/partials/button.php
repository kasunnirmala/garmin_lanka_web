<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use ELementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

/**
 * Register elementor layout controls for button.
 */
function riode_elementor_button_layout_controls( $self, $condition_key = '', $condition_value = 'yes', $name_prefix = '' ) {

	$left  = is_rtl() ? 'right' : 'left';
	$right = 'left' == $left ? 'right' : 'left';

	$self->add_control(
		$name_prefix . 'button_type',
		array(
			'label'       => esc_html__( 'Type', 'riode-core' ),
			'description' => esc_html__( 'Choose button type. Choose from Default, Solid, Outline, Link.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''             => esc_html__( 'Default', 'riode-core' ),
				'btn-gradient' => esc_html__( 'Gradient', 'riode-core' ),
				'btn-solid'    => esc_html__( 'Solid', 'riode-core' ),
				'btn-outline'  => esc_html__( 'Outline', 'riode-core' ),
				'btn-link'     => esc_html__( 'Link', 'riode-core' ),
			),
			'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
		)
	);

	$self->add_control(
		$name_prefix . 'button_size',
		array(
			'label'       => esc_html__( 'Size', 'riode-core' ),
			'description' => esc_html__( 'Choose button size. Choose from Small, Medium, Normal, Large.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				'btn-sm' => esc_html__( 'Small', 'riode-core' ),
				'btn-md' => esc_html__( 'Medium', 'riode-core' ),
				''       => esc_html__( 'Normal', 'riode-core' ),
				'btn-lg' => esc_html__( 'Large', 'riode-core' ),
			),
			'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
		)
	);

	$self->add_control(
		$name_prefix . 'link_hover_type',
		array(
			'label'       => esc_html__( 'Hover Underline', 'riode-core' ),
			'description' => esc_html__( 'Choose hover underline effect of Link type buttons. Choose from 3 underline effects.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''                 => esc_html__( 'None', 'riode-core' ),
				'btn-underline sm' => esc_html__( 'Underline1', 'riode-core' ),
				'btn-underline '   => esc_html__( 'Underline2', 'riode-core' ),
				'btn-underline lg' => esc_html__( 'Underline3', 'riode-core' ),
			),
			'condition'   => $condition_key ? array(
				$condition_key               => $condition_value,
				$name_prefix . 'button_type' => 'btn-link',
			) : array(
				$name_prefix . 'button_type' => 'btn-link',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'shadow',
		array(
			'type'        => Controls_Manager::SELECT,
			'label'       => esc_html__( 'Box Shadow', 'riode-core' ),
			'description' => esc_html__( 'Choose box shadow effect for button. Choose from 3 shadow effects.', 'riode-core' ),
			'default'     => '',
			'options'     => array(
				''              => esc_html__( 'None', 'riode-core' ),
				'btn-shadow-sm' => esc_html__( 'Shadow 1', 'riode-core' ),
				'btn-shadow'    => esc_html__( 'Shadow 2', 'riode-core' ),
				'btn-shadow-lg' => esc_html__( 'Shadow 3', 'riode-core' ),
			),
			'condition'   => $condition_key ? array(
				$condition_key                => $condition_value,
				$name_prefix . 'button_type!' => array( 'btn-link', 'btn-outline' ),
			) : array(
				$name_prefix . 'button_type!' => array( 'btn-link', 'btn-outline' ),
			),
		)
	);

	$self->add_control(
		$name_prefix . 'button_border',
		array(
			'label'       => esc_html__( 'Border Style', 'riode-core' ),
			'description' => esc_html__( 'Choose border style of Default, Solid and Outline buttons. Choose from Default, Square, Rounded, Ellipse.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''            => esc_html__( 'Default', 'riode-core' ),
				'btn-square'  => esc_html__( 'Square', 'riode-core' ),
				'btn-rounded' => esc_html__( 'Rounded', 'riode-core' ),
				'btn-ellipse' => esc_html__( 'Ellipse', 'riode-core' ),
			),
			'condition'   => $condition_key ? array(
				$condition_key                => $condition_value,
				$name_prefix . 'button_type!' => 'btn-link',
			) : array(
				$name_prefix . 'button_type!' => 'btn-link',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'button_skin',
		array(
			'label'       => esc_html__( 'Skin', 'riode-core' ),
			'description' => esc_html__( 'Choose color skin of buttons. Choose from Default, Primary, Secondary, Alert, Success, Dark, White.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'btn-primary',
			'options'     => array(
				''              => esc_html__( 'Default', 'riode-core' ),
				'btn-primary'   => esc_html__( 'Primary', 'riode-core' ),
				'btn-secondary' => esc_html__( 'Secondary', 'riode-core' ),
				'btn-alert'     => esc_html__( 'Alert', 'riode-core' ),
				'btn-success'   => esc_html__( 'Success', 'riode-core' ),
				'btn-dark'      => esc_html__( 'Dark', 'riode-core' ),
				'btn-white'     => esc_html__( 'White', 'riode-core' ),
			),
			'condition'   => $condition_key ? array(
				$condition_key                => $condition_value,
				$name_prefix . 'button_type!' => 'btn-gradient',
			) : array(
				$name_prefix . 'button_type!' => 'btn-gradient',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'button_gradient_skin',
		array(
			'label'       => esc_html__( 'Skin', 'riode-core' ),
			'description' => esc_html__( 'Choose gradient color skin of gradient buttons.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				'btn-gra-default' => esc_html__( 'Default', 'riode-core' ),
				'btn-gra-blue'    => esc_html__( 'Blue', 'riode-core' ),
				'btn-gra-orange'  => esc_html__( 'Orange', 'riode-core' ),
				'btn-gra-pink'    => esc_html__( 'Pink', 'riode-core' ),
				'btn-gra-green'   => esc_html__( 'Green', 'riode-core' ),
				'btn-gra-dark'    => esc_html__( 'Dark', 'riode-core' ),
			),
			'condition'   => $condition_key ? array(
				$condition_key               => $condition_value,
				$name_prefix . 'button_type' => 'btn-gradient',
			) : array(
				$name_prefix . 'button_type' => 'btn-gradient',
			),
		)
	);

	if ( 'riode_widget_button' == $self->get_name() ) {
		$self->add_control(
			$name_prefix . 'line_break',
			array(
				'label'       => esc_html__( 'Disable Line-break', 'riode-core' ),
				'description' => esc_html__( 'Prevents the button text from placing in several rows.', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'nowrap',
				'options'     => array(
					'nowrap' => array(
						'title' => esc_html__( 'On', 'riode-core' ),
						'icon'  => 'eicon-h-align-right',
					),
					'normal' => array(
						'title' => esc_html__( 'Off', 'riode-core' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .btn span' => 'white-space: {{VALUE}};',
				),
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);

		$self->add_control(
			$name_prefix . 'btn_class',
			array(
				'label'       => esc_html__( 'Custom Class', 'riode-core' ),
				'description' => esc_html__( 'Input custom classes without dot to give specific styles.', 'riode-core' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
			)
		);
	}

	$self->add_control(
		$name_prefix . 'show_icon',
		array(
			'label'       => esc_html__( 'Show Icon?', 'riode-core' ),
			'description' => esc_html__( 'Allows to show icon before or after button text.', 'riode-core' ),
			'type'        => Controls_Manager::SWITCHER,
			'condition'   => $condition_key ? array( $condition_key => $condition_value ) : '',
		)
	);

		$self->add_control(
			$name_prefix . 'show_label',
			array(
				'label'       => esc_html__( 'Show Label?', 'riode-core' ),
				'description' => esc_html__( 'Determines whether to show/hide button text.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'condition'   => $condition_key ? array(
					$condition_key             => $condition_value,
					$name_prefix . 'show_icon' => 'yes',
				) : array( 'show_icon' => 'yes' ),
			)
		);

	$self->add_control(
		$name_prefix . 'icon',
		array(
			'label'       => esc_html__( 'Icon', 'riode-core' ),
			'description' => esc_html__( 'Choose icon from icon library that will be shown with button text.', 'riode-core' ),
			'type'        => Controls_Manager::ICONS,
			'default'     => [
				'value'   => 'd-icon-arrow-right',
				'library' => 'riode-icons',
			],
			'condition'   => $condition_key ? array(
				$condition_key             => $condition_value,
				$name_prefix . 'show_icon' => 'yes',
			) : array(
				'show_icon' => 'yes',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'icon_pos',
		array(
			'label'       => esc_html__( 'Icon Position', 'riode-core' ),
			'description' => esc_html__( 'Choose where to show icon with button text. Choose from Before/After.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'after',
			'options'     => array(
				'after'  => esc_html__( 'After', 'riode-core' ),
				'before' => esc_html__( 'Before', 'riode-core' ),
			),
			'condition'   => $condition_key ? array(
				$condition_key             => $condition_value,
				$name_prefix . 'show_icon' => 'yes',
			) : array(
				$name_prefix . 'show_icon' => 'yes',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'icon_space',
		array(
			'label'       => esc_html__( 'Icon Spacing (px)', 'riode-core' ),
			'description' => esc_html__( 'Control spacing between icon and text.', 'riode-core' ),
			'type'        => Controls_Manager::SLIDER,
			'range'       => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 30,
				),
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .btn-icon-left:not(.btn-reveal-left) i' => "margin-{$right}: {{SIZE}}px;",
				'.elementor-element-{{ID}} .btn-icon-right:not(.btn-reveal-right) i'  => "margin-{$left}: {{SIZE}}px;",
				'.elementor-element-{{ID}} .btn-reveal-left:hover i, .elementor-element-{{ID}} .btn-reveal-left:active i, .elementor-element-{{ID}} .btn-reveal-left:focus i'  => "margin-{$right}: {{SIZE}}px;",
				'.elementor-element-{{ID}} .btn-reveal-right:hover i, .elementor-element-{{ID}} .btn-reveal-right:active i, .elementor-element-{{ID}} .btn-reveal-right:focus i'  => "margin-{$left}: {{SIZE}}px;",
			),
			'condition'   => $condition_key ? array(
				$condition_key             => $condition_value,
				$name_prefix . 'show_icon' => 'yes',
			) : array(
				$name_prefix . 'show_icon' => 'yes',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'icon_size',
		array(
			'label'       => esc_html__( 'Icon Size (px)', 'riode-core' ),
			'description' => esc_html__( 'Control button icon size.', 'riode-core' ),
			'type'        => Controls_Manager::SLIDER,
			'range'       => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 50,
				),
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .btn i' => 'font-size: {{SIZE}}px;',
			),
			'condition'   => $condition_key ? array(
				$condition_key             => $condition_value,
				$name_prefix . 'show_icon' => 'yes',
			) : array(
				$name_prefix . 'show_icon' => 'yes',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'icon_hover_effect',
		array(
			'label'       => esc_html__( 'Icon Hover Effect', 'riode-core' ),
			'description' => esc_html__( 'Choose hover effect of buttons with icon. Choose from 3 hover effects.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''                 => esc_html__( 'None', 'riode-core' ),
				'btn-slide-left'   => esc_html__( 'Slide Left', 'riode-core' ),
				'btn-slide-right'  => esc_html__( 'Slide Right', 'riode-core' ),
				'btn-slide-up'     => esc_html__( 'Slide Up', 'riode-core' ),
				'btn-slide-down'   => esc_html__( 'Slide Down', 'riode-core' ),
				'btn-reveal-left'  => esc_html__( 'Reveal Left', 'riode-core' ),
				'btn-reveal-right' => esc_html__( 'Reveal Right', 'riode-core' ),
			),
			'condition'   => $condition_key ? array(
				$condition_key             => $condition_value,
				$name_prefix . 'show_icon' => 'yes',
			) : array(
				$name_prefix . 'show_icon' => 'yes',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'icon_hover_effect_infinite',
		array(
			'label'       => esc_html__( 'Animation Infinite', 'riode-core' ),
			'description' => esc_html__( 'Determines whether icons should be animated once or several times for buttons with icon.', 'riode-core' ),
			'type'        => Controls_Manager::SWITCHER,
			'condition'   => $condition_key ? array(
				$condition_key                      => $condition_value,
				$name_prefix . 'show_icon'          => 'yes',
				$name_prefix . 'icon_hover_effect!' => array( '', 'btn-reveal-left', 'btn-reveal-right' ),
			) : array(
				'show_icon'                         => 'yes',
				$name_prefix . 'icon_hover_effect!' => array( '', 'btn-reveal-left', 'btn-reveal-right' ),
			),
		)
	);
}

/**
 * Register elementor style controls for button.
 */
function riode_elementor_button_style_controls( $self, $name_prefix = '' ) {
	$self->start_controls_section(
		$name_prefix . 'section_button_style',
		array(
			'label' => esc_html__( 'Button Style', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'        => $name_prefix . 'button_typography',
			'label'       => esc_html__( 'Label Typography', 'riode-core' ),
			'description' => esc_html__( 'Change font family, size, weight, text transform, letter spacing and line height of button text.', 'riode-core' ),
			'scheme'      => Typography::TYPOGRAPHY_1,
			'selector'    => '.elementor-element-{{ID}} .btn',
		)
	);

	$self->add_responsive_control(
		$name_prefix . 'btn_min_width',
		array(
			'label'       => esc_html__( 'Min Width', 'riode-core' ),
			'description' => esc_html__( 'Changes min width of button.', 'riode-core' ),
			'type'        => Controls_Manager::SLIDER,
			'range'       => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 50,
				),
			),
			'size_units'  => array(
				'px',
				'%',
				'rem',
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .btn' => 'min-width: {{SIZE}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		$name_prefix . 'btn_padding',
		array(
			'label'       => esc_html__( 'Padding', 'riode-core' ),
			'description' => esc_html__( 'Controls padding value of button.', 'riode-core' ),
			'type'        => Controls_Manager::DIMENSIONS,
			'size_units'  => array(
				'px',
				'%',
				'em',
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		$name_prefix . 'btn_border_radius',
		array(
			'label'       => esc_html__( 'Border Radius', 'riode-core' ),
			'description' => esc_html__( 'Controls border radius value of buttons.', 'riode-core' ),
			'type'        => Controls_Manager::DIMENSIONS,
			'size_units'  => array(
				'px',
				'%',
				'em',
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		$name_prefix . 'btn_border_width',
		array(
			'label'       => esc_html__( 'Border Width', 'riode-core' ),
			'description' => esc_html__( 'Controls border width of buttons.', 'riode-core' ),
			'type'        => Controls_Manager::DIMENSIONS,
			'size_units'  => array(
				'px',
				'%',
				'em',
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
			),
		)
	);

	$self->start_controls_tabs( $name_prefix . 'tabs_btn_cat' );

	$self->start_controls_tab(
		$name_prefix . 'tab_btn_normal',
		array(
			'label' => esc_html__( 'Normal', 'riode-core' ),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_color',
		array(
			'label'     => esc_html__( 'Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_back_color',
		array(
			'label'     => esc_html__( 'Background Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_border_color',
		array(
			'label'     => esc_html__( 'Border Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => $name_prefix . 'btn_box_shadow',
			'selector' => '.elementor-element-{{ID}} .btn',
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		$name_prefix . 'tab_btn_hover',
		array(
			'label' => esc_html__( 'Hover', 'riode-core' ),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_color_hover',
		array(
			'label'     => esc_html__( 'Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_back_color_hover',
		array(
			'label'     => esc_html__( 'Background Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:hover' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_border_color_hover',
		array(
			'label'     => esc_html__( 'Border Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:hover' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => $name_prefix . 'btn_box_shadow_hover',
			'selector' => '.elementor-element-{{ID}} .btn:hover',
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		$name_prefix . 'tab_btn_active',
		array(
			'label' => esc_html__( 'Active', 'riode-core' ),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_color_active',
		array(
			'label'     => esc_html__( 'Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:not(:focus):active, .elementor-element-{{ID}} .btn:focus' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_back_color_active',
		array(
			'label'     => esc_html__( 'Background Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:not(:focus):active, .elementor-element-{{ID}} .btn:focus' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		$name_prefix . 'btn_border_color_active',
		array(
			'label'     => esc_html__( 'Border Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .btn:not(:focus):active, .elementor-element-{{ID}} .btn:focus' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'     => $name_prefix . 'btn_box_shadow_active',
			'selector' => '.elementor-element-{{ID}} .btn:active, .elementor-element-{{ID}} .btn:focus',
		)
	);

	$self->end_controls_tab();

	$self->end_controls_tabs();

	$self->end_controls_section();

}
