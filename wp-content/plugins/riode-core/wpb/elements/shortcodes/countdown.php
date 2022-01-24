<?php
/**
 * Riode Countdown
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Content', 'riode-core' ) => array(
		array(
			'type'        => 'riode_datetimepicker',
			'param_name'  => 'date',
			'heading'     => esc_html__( 'Target Date', 'riode-core' ),
			'value'       => '',
			'description' => esc_html__( 'Set the certain date the countdown element will count down to.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'timezone',
			'heading'     => esc_html__( 'Timezone', 'riode-core' ),
			'value'       => array(
				esc_html__( 'WordPress Defined Timezone', 'riode-core' )    => '',
				esc_html__( 'User System Timezone', 'riode-core' )   => 'user_timezone',
			),
			'std'         => '',
			'description' => esc_html__( 'Allows you to specify which timezone is used, the sites or the viewer timezone.', 'riode-core' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Label', 'riode-core' ),
			'param_name' => 'label',
			'value'      => 'Offer Ends In',
			'dependency' => array(
				'element' => 'type',
				'value'   => 'inline',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'label_type',
			'heading'     => esc_html__( 'Unit Type', 'riode-core' ),
			'description' => esc_html__(
				'Select time unit type from full and short. The default type is the full type.',
				'riode-core'
			),
			'value'       => array(
				esc_html__( 'Full', 'riode-core' )  => '',
				esc_html__( 'Short', 'riode-core' ) => 'short',
			),
			'std'         => '',
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'block',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'label_pos',
			'heading'     => esc_html__( 'Unit Position', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Inner', 'riode-core' )  => '',
				esc_html__( 'Outer', 'riode-core' )  => 'outer',
				esc_html__( 'Custom', 'riode-core' ) => 'custom',
			),
			'std'         => '',
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'block',
			),
			'description' => esc_html__( 'Select unit position from inner, outer and custom. The default position is inner.', 'riode-core' ),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Label Position', 'riode-core' ),
			'param_name' => 'label_dimension',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}} .countdown .countdown-period' => 'bottom: {{VALUE}}{{UNIT}};',
			),
			'dependency' => array(
				'element' => 'label_pos',
				'value'   => 'custom',
			),
		),
		array(
			'type'        => 'riode_multiselect',
			'param_name'  => 'date_format',
			'heading'     => esc_html__( 'Units', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Year', 'riode-core' )   => 'Y',
				esc_html__( 'Month', 'riode-core' )  => 'O',
				esc_html__( 'Week', 'riode-core' )   => 'W',
				esc_html__( 'Day', 'riode-core' )    => 'D',
				esc_html__( 'Hour', 'riode-core' )   => 'H',
				esc_html__( 'Minute', 'riode-core' ) => 'M',
				esc_html__( 'Second', 'riode-core' ) => 'S',
			),
			'std'         => 'D,H,M,S',
			'description' => esc_html__( 'Allows to show or hide the amount of time aspects used in the countdown element.', 'riode-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Hide Spliter?', 'riode-core' ),
			'param_name'  => 'hide_split',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'block',
			),
			'description' => esc_html__( 'Allows you to show or hide the splitters between time amounts.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'type',
			'heading'     => esc_html__( 'Type', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Block', 'riode-core' )  => 'block',
				esc_html__( 'Inline', 'riode-core' ) => 'inline',
			),
			'std'         => 'block',
			'description' => esc_html__( 'Select countdown type from block and inline types.', 'riode-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Enable Grid?', 'riode-core' ),
			'param_name'  => 'enable_grid',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'block',
			),
			'description' => esc_html__( 'Enables to configure your countdown with the grid mode.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Columns', 'riode-core' ),
			'description' => esc_html__( 'Type a certain number for the grid columns.', 'riode-core' ),
			'param_name'  => 'grid_cols',
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .countdown-row' => 'display: grid; grid-template-columns: repeat({{VALUE}}, calc(100% / {{VALUE}})); grid-template-rows: auto;',
			),
			'dependency'  => array(
				'element' => 'enable_grid',
				'value'   => 'yes',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Alignment', 'riode-core' ),
			'param_name'  => 'align',
			'value'       => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'selectors'   => array(
				'{{WRAPPER}} .countdown-container' => 'justify-content: {{VALUE}};',
			),
			'description' => esc_html__( 'Determine where the countdown is located, left, center or right.', 'riode-core' ),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		esc_html__( 'Dimension', 'riode-core' )  => array(
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Item Width', 'riode-core' ),
				'description' => esc_html__(
					'Controls the width of each countdown section.',
					'riode-core'
				),
				'param_name'  => 'item_width',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
				),
				'selectors'   => array(
					'{{WRAPPER}} .countdown-section' => 'min-width: {{VALUE}}{{UNIT}}; width: {{VALUE}}{{UNIT}}; max-width: 100%;',
				),
				'dependency'  => array(
					'element' => 'type',
					'value'   => 'block',
				),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Item Padding', 'riode-core' ),
				'description' => esc_html__(
					'Controls the padding of each countdown section.',
					'riode-core'
				),
				'param_name'  => 'item_padding',
				'responsive'  => true,
				'selectors'   => array(
					'{{WRAPPER}} .countdown-section' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Item Margin', 'riode-core' ),
				'description' => esc_html__(
					'Controls the margin of each countdown section.',
					'riode-core'
				),
				'param_name'  => 'item_margin',
				'responsive'  => true,
				'selectors'   => array(
					'{{WRAPPER}} .countdown-section' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Label Margin', 'riode-core' ),
				'description' => esc_html__(
					'Controls the margin of each countdown section in the inline type.',
					'riode-core'
				),
				'param_name'  => 'label_margin',
				'selectors'   => array(
					'{{WRAPPER}} .countdown-label' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'dependency'  => array(
					'element' => 'type',
					'value'   => 'inline',
				),
			),
		),
		esc_html__( 'Typography', 'riode-core' ) => array(
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Amount', 'riode-core' ),
				'description' => esc_html__(
					'Controls the typography of the countdown amount.',
					'riode-core'
				),
				'param_name'  => 'countdown_amount',
				'selectors'   => array(
					'{{WRAPPER}} .countdown-container .countdown-amount',
				),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Unit, Label', 'riode-core' ),
				'description' => esc_html__(
					'Controls the typography of the countdown label.',
					'riode-core'
				),
				'param_name'  => 'countdown_label',
				'selectors'   => array(
					'{{WRAPPER}} .countdown-period',
					'{{WRAPPER}} .countdown-label',
				),
			),
		),
		esc_html__( 'Color', 'riode-core' )      => array(
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Section Background', 'riode-core' ),
				'description' => esc_html__(
					'Controls the backgorund color of the countdown section.',
					'riode-core'
				),
				'param_name'  => 'countdown_section_color',
				'selectors'   => array(
					'{{WRAPPER}} .countdown-section' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Amount', 'riode-core' ),
				'description' => esc_html__(
					'Controls the color of the countdown amount.',
					'riode-core'
				),
				'param_name'  => 'countdown_amount_color',
				'selectors'   => array(
					'{{WRAPPER}} .countdown-amount' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Unit, Label', 'riode-core' ),
				'description' => esc_html__(
					'Controls the color of the countdown label.',
					'riode-core'
				),
				'param_name'  => 'countdown_label_color',
				'selectors'   => array(
					'{{WRAPPER}} .countdown-period' => 'color: {{VALUE}};',
					'{{WRAPPER}} .countdown-label'  => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Separator Color', 'riode-core' ),
				'description' => esc_html__(
					'Controls the color of the countdown separator.',
					'riode-core'
				),
				'param_name'  => 'countdown_separator_color',
				'selectors'   => array(
					'{{WRAPPER}} .countdown-section:after' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Border', 'riode-core' )     => array(
			array(
				'type'        => 'dropdown',
				'param_name'  => 'border-type',
				'heading'     => esc_html__( 'Border Type', 'riode-core' ),
				'description' => esc_html__(
					'Controls the border of the countdown section.',
					'riode-core'
				),
				'value'       => array(
					esc_html__( 'None', 'riode-core' )   => '',
					esc_html__( 'Solid', 'riode-core' )  => 'solid',
					esc_html__( 'Double', 'riode-core' ) => 'double',
					esc_html__( 'Dotted', 'riode-core' ) => 'dotted',
					esc_html__( 'Dashed', 'riode-core' ) => 'dashed',
					esc_html__( 'Groove', 'riode-core' ) => 'groove',
				),
				'std'         => '',
				'selectors'   => array(
					'{{WRAPPER}} .countdown-section' => 'border-style: {{VALUE}};',
				),
				'dependency'  => array(
					'element' => 'type',
					'value'   => 'block',
				),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Border Width', 'riode-core' ),
				'description' => esc_html__( 'Controls the border width of the countdown section.', 'riode-core' ),
				'param_name'  => 'border_width',
				'responsive'  => true,
				'selectors'   => array(
					'{{WRAPPER}} .countdown-section' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Border Color', 'riode-core' ),
				'description' => esc_html__(
					'Controls the border color of the countdown section.',
					'riode-core'
				),
				'param_name'  => 'border_color',
				'selectors'   => array(
					'{{WRAPPER}} .countdown-section' => 'border-color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Border Radius', 'riode-core' ),
				'description' => esc_html__(
					'Controls the border radius of the countdown section.',
					'riode-core'
				),
				'param_name'  => 'border-radius',
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .countdown-section' => 'border-radius: {{VALUE}}{{UNIT}};',
				),
				'dependency'  => array(
					'element' => 'type',
					'value'   => 'block',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Countdown', 'riode-core' ),
		'base'            => 'wpb_riode_countdown',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_countdown',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Countdown timer for deals', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Countdown extends WPBakeryShortCode {

	}
}
