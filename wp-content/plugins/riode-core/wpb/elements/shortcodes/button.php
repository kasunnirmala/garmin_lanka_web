<?php
/**
 * Button Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Button Title', 'riode-core' ),
			'description' => esc_html__( 'Type text that will be shown on button.', 'riode-core' ),
			'param_name'  => 'label',
			'value'       => 'Click here',
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Expand Button', 'riode-core' ),
			'description' => esc_html__( "Makes button's width 100% full.", 'riode-core' ),
			'param_name'  => 'button_expand',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Alignment', 'riode-core' ),
			'description' => esc_html__( "Controls button's alignment. Choose from Left, Center, Right.", 'riode-core' ),
			'param_name'  => 'button_align',
			'value'       => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'         => 'left',
			'selectors'   => array(
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Link Url', 'riode-core' ),
			'description' => esc_html__( 'Input URL where you will move when button is clicked.', 'riode-core' ),
			'param_name'  => 'link',
			'value'       => '',
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Type', 'riode-core' ),
			'description' => esc_html__( 'Choose button type. Choose from Default, Solid, Outline, Link.', 'riode-core' ),
			'param_name'  => 'button_type',
			'value'       => array(
				esc_html__( 'Default', 'riode-core' )  => 'default',
				esc_html__( 'Solid', 'riode-core' )    => 'btn-solid',
				esc_html__( 'Gradient', 'riode-core' ) => 'btn-gradient',
				esc_html__( 'Outline', 'riode-core' )  => 'btn-outline',
				esc_html__( 'Inline', 'riode-core' )   => 'btn-link',
			),
			'std'         => 'default',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Size', 'riode-core' ),
			'description' => esc_html__( 'Choose button size. Choose from Small, Medium, Normal, Large.', 'riode-core' ),
			'param_name'  => 'button_size',
			'value'       => array(
				'btn-sm'  => array(
					'title' => esc_html__( 'Small', 'riode-core' ),
				),
				'btn-md'  => array(
					'title' => esc_html__( 'Medium', 'riode-core' ),
				),
				'default' => array(
					'title' => esc_html__( 'Normal', 'riode-core' ),
				),
				'btn-lg'  => array(
					'title' => esc_html__( 'Large', 'riode-core' ),
				),
			),
			'std'         => 'default',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Hover Underline', 'riode-core' ),
			'description' => esc_html__( 'Choose hover underline effect of Link type buttons. Choose from 3 underline effects.', 'riode-core' ),
			'param_name'  => 'link_hover_type',
			'value'       => array(
				'default'          => array(
					'title' => esc_html__( 'None', 'riode-core' ),
				),
				'btn-underline sm' => array(
					'title' => esc_html__( 'Underline1', 'riode-core' ),
				),
				'btn-underline'    => array(
					'title' => esc_html__( 'Underline2', 'riode-core' ),
				),
				'btn-underline lg' => array(
					'title' => esc_html__( 'Underline3', 'riode-core' ),
				),
			),
			'std'         => 'default',
			'dependency'  => array(
				'element' => 'button_type',
				'value'   => 'btn-link',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Box Shadow', 'riode-core' ),
			'description' => esc_html__( 'Choose box shadow effect for button. Choose from 3 shadow effects.', 'riode-core' ),
			'param_name'  => 'shadow',
			'value'       => array(
				esc_html__( 'None', 'riode-core' )     => 'default',
				esc_html__( 'Shadow 1', 'riode-core' ) => 'btn-shadow-sm',
				esc_html__( 'Shadow 2', 'riode-core' ) => 'btn-shadow',
				esc_html__( 'Shadow 3', 'riode-core' ) => 'btn-shadow-lg',
			),
			'std'         => 'default',
			'dependency'  => array(
				'element'            => 'button_type',
				'value_not_equal_to' => 'btn-link',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Border Style', 'riode-core' ),
			'description' => esc_html__( 'Choose border style of Default, Solid and Outline buttons. Choose from Default, Square, Rounded, Ellipse.', 'riode-core' ),
			'param_name'  => 'button_border',
			'label_type'  => 'icon',
			'value'       => array(
				''            => array(
					'title' => esc_html__( 'Default', 'riode-core' ),
					'icon'  => 'attr-icon',
				),
				'default'     => array(
					'title' => esc_html__( 'Rectangle', 'riode-core' ),
					'icon'  => 'attr-icon-square',
				),
				'btn-rounded' => array(
					'title' => esc_html__( 'Rounded', 'riode-core' ),
					'icon'  => 'attr-icon-rounded',
				),
				'btn-ellipse' => array(
					'title' => esc_html__( 'Ellipse', 'riode-core' ),
					'icon'  => 'attr-icon-ellipse',
				),
			),
			'std'         => '',
			'dependency'  => array(
				'element'            => 'button_type',
				'value_not_equal_to' => 'btn-link',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Skin', 'riode-core' ),
			'description' => esc_html__( 'Choose color skin of buttons. Choose from Default, Primary, Secondary, Alert, Success, Dark, White.', 'riode-core' ),
			'param_name'  => 'button_skin',
			'value'       => array(
				'default'       => array(
					'title' => esc_html__( 'Default', 'riode-core' ),
					'color' => '#e4eaec',
				),
				'btn-primary'   => array(
					'title' => esc_html__( 'Primary', 'riode-core' ),
					'color' => 'var(--rio-primary-color,#27c)',
				),
				'btn-secondary' => array(
					'title' => esc_html__( 'Secondary', 'riode-core' ),
					'color' => 'var(--rio-secondary-color,#d26e4b)',
				),
				'btn-alert'     => array(
					'title' => esc_html__( 'Alert', 'riode-core' ),
					'color' => 'var(--rio-alert-color,#b10001)',
				),
				'btn-success'   => array(
					'title' => esc_html__( 'Success', 'riode-core' ),
					'color' => 'var(--rio-success-color,#a8c26e)',
				),
				'btn-dark'      => array(
					'title' => esc_html__( 'Dark', 'riode-core' ),
					'color' => 'var(--rio-dark-color,#222)',
				),
				'btn-white'     => array(
					'title' => esc_html__( 'white', 'riode-core' ),
					'color' => '#fff',
				),
			),
			'dependency'  => array(
				'element'            => 'button_type',
				'value_not_equal_to' => 'btn-gradient',
			),
			'std'         => 'default',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Gradient Skin', 'riode-core' ),
			'description' => esc_html__( 'Choose gradient color skin of gradient buttons.', 'riode-core' ),
			'param_name'  => 'button_gradient_skin',
			'value'       => array(
				'btn-gra-default' => array(
					'title' => esc_html__( 'Default', 'riode-core' ),
					'color' => '#e4eaec',
				),
				'btn-gra-blue'    => array(
					'title' => esc_html__( 'Blue', 'riode-core' ),
					'color' => '#27c',
				),
				'btn-gra-orange'  => array(
					'title' => esc_html__( 'Orange', 'riode-core' ),
					'color' => '#d26e4b',
				),
				'btn-gra-pink'    => array(
					'title' => esc_html__( 'Pink', 'riode-core' ),
					'color' => '#ea4d89',
				),
				'btn-gra-green'   => array(
					'title' => esc_html__( 'Green', 'riode-core' ),
					'color' => '#99e35f',
				),
				'btn-gra-dark'    => array(
					'title' => esc_html__( 'Dark', 'riode-core' ),
					'color' => '#222',
				),
			),
			'std'         => 'btn-gra-default',
			'dependency'  => array(
				'element' => 'button_type',
				'value'   => 'btn-gradient',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Line-break', 'riode-core' ),
			'description' => esc_html__( 'Prevents the button text from placing in several rows.', 'riode-core' ),
			'param_name'  => 'line_break',
			'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
			'selectors'   => array(
				'{{WRAPPER}} .btn' => 'white-space: normal;',
			),
		),
	),
	esc_html__( 'Icon', 'riode-core' )    => array(
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show Icon?', 'riode-core' ),
			'description' => esc_html__( 'Allows to show icon before or after button text.', 'riode-core' ),
			'param_name'  => 'show_icon',
			'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show Label', 'riode-core' ),
			'description' => esc_html__( 'Determines whether to show/hide button text.', 'riode-core' ),
			'param_name'  => 'show_label',
			'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
			'std'         => 'yes',
			'dependency'  => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'riode-core' ),
			'description' => esc_html__( 'Choose icon from icon library that will be shown with button text.', 'riode-core' ),
			'param_name'  => 'icon',
			'std'         => '',
			'dependency'  => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Icon Position', 'riode-core' ),
			'description' => esc_html__( 'Choose where to show icon with button text. Choose from Before/After.', 'riode-core' ),
			'param_name'  => 'icon_pos',
			'value'       => array(
				'after'  => array(
					'title' => esc_html__( 'After', 'riode-core' ),
				),
				'before' => array(
					'title' => esc_html__( 'Before', 'riode-core' ),
				),
			),
			'dependency'  => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Icon Spacing', 'riode-core' ),
			'description' => esc_html__( 'Control spacing between icon and text.', 'riode-core' ),
			'param_name'  => 'icon_space',
			'units'       => array(
				'px',
				'rem',
				'em',
			),
			'value'       => '',
			'dependency'  => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
			'selectors'   => array(
				'{{WRAPPER}} .btn-icon-left:not(.btn-reveal-left) i' => "margin-{$right}: {{VALUE}}{{UNIT}};",
				'{{WRAPPER}} .btn-icon-right:not(.btn-reveal-right) i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
				'{{WRAPPER}} .btn-reveal-left:hover i, {{WRAPPER}} .btn-reveal-left:active i, {{WRAPPER}} .btn-reveal-left:focus i'  => "margin-{$right}: {{VALUE}}{{UNIT}};",
				'{{WRAPPER}} .btn-reveal-right:hover i, {{WRAPPER}} .btn-reveal-right:active i, {{WRAPPER}} .btn-reveal-right:focus i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Icon Size', 'riode-core' ),
			'description' => esc_html__( 'Control button icon size.', 'riode-core' ),
			'param_name'  => 'icon_size',
			'value'       => '',
			'units'       => array(
				'px',
				'rem',
				'em',
			),
			'dependency'  => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
			'selectors'   => array(
				'{{WRAPPER}} .btn i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Icon Hover Effect', 'riode-core' ),
			'description' => esc_html__( 'Choose hover effect of buttons with icon. Choose from 3 hover effects.', 'riode-core' ),
			'param_name'  => 'icon_hover_effect',
			'value'       => array(
				esc_html__( 'None', 'riode-core' )         => 'default',
				esc_html__( 'Slide Left', 'riode-core' )   => 'btn-slide-left',
				esc_html__( 'Slide Right', 'riode-core' )  => 'btn-slide-right',
				esc_html__( 'Slide Up', 'riode-core' )     => 'btn-slide-up',
				esc_html__( 'Slide Down', 'riode-core' )   => 'btn-slide-down',
				esc_html__( 'Reveal Left', 'riode-core' )  => 'btn-reveal-left',
				esc_html__( 'Reveal Right', 'riode-core' ) => 'btn-reveal-right',
			),
			'std'         => 'default',
			'dependency'  => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Animation Infinite', 'riode-core' ),
			'description' => esc_html__( 'Determines whether icons should be animated once or several times for buttons with icon.', 'riode-core' ),
			'param_name'  => 'icon_hover_effect_infinite',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element'   => 'show_icon',
				'not_empty' => true,
			),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Button Padding', 'riode-core' ),
			'description' => esc_html__( 'Controls padding value of button.', 'riode-core' ),
			'param_name'  => 'button_padding',
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .btn' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
			),
		),
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Button Border Width', 'riode-core' ),
			'description' => esc_html__( 'Controls border width of buttons.', 'riode-core' ),
			'param_name'  => 'button_border_width',
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .btn' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
		),
		array(
			'type'        => 'riode_typography',
			'heading'     => esc_html__( 'Button Typography', 'riode-core' ),
			'description' => esc_html__( 'Change font family, size, weight, text transform, letter spacing and line height of button text.', 'riode-core' ),
			'param_name'  => 'btn_font',
			'selectors'   => array(
				'{{WRAPPER}} .btn',
			),
		),
		array(
			'type'        => 'riode_color_group',
			'heading'     => esc_html__( 'Colors', 'riode-core' ),
			'description' => esc_html__( 'Choose text color, background color and border color for button on normal, hover and active events.', 'riode-core' ),
			'param_name'  => 'btn_colors',
			'selectors'   => array(
				'normal' => '{{WRAPPER}} .btn',
				'hover'  => '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus',
				'active' => '{{WRAPPER}} .btn:active',
			),
			'choices'     => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Button', 'riode-core' ),
		'base'            => 'wpb_riode_button',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_button',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Button with various types and shapes', 'riode-core' ),
		'params'          => $params,
	)
);


if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Button extends WPBakeryShortCode {
	}
}
