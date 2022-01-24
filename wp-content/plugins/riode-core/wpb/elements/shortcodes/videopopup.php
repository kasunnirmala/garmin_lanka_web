<?php
/**
 * Riode Video Popup
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Video Source', 'riode-core' ),
			'param_name'  => 'vtype',
			'value'       => array(
				esc_html__( 'Youtube', 'riode-core' )     => 'youtube',
				esc_html__( 'Vimeo', 'riode-core' )       => 'vimeo',
				esc_html__( 'Self Hosted', 'riode-core' ) => 'hosted',
			),
			'std'         => 'youtube',
			'description' => esc_html__( 'Select a certain video upload mode among Youtube, Vimeo, Dailymotion and Self Hosted modes.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Video URL', 'riode-core' ),
			'param_name'  => 'video_url',
			'value'       => '',
			'description' => esc_html__( 'Type a certain URL of a video you want to upload.', 'riode-core' ),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__(
				'Player Icon',
				'riode-core'
			),
			'description' => esc_html__(
				'Choose icon from icon library that will be video player.',
				'riode-core'
			),
			'param_name'  => 'button_icon',
			'std'         => 'd-icon-play-solid',
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Player Icon Size', 'riode-core' ),
			'description' => esc_html__( 'Control button icon size.', 'riode-core' ),
			'param_name'  => 'icon_size',
			'units'       => array(
				'px',
			),
			'selectors'   => array(
				'{{WRAPPER}} i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
			'std'         => '{"xl":"35","unit":"","xs":"","sm":"","md":"","lg":""}',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Alignment', 'riode-core' ),
			'description' => esc_html__( "Controls button's alignment. Choose from Left, Center, Right.", 'riode-core' ),
			'param_name'  => 'alignment',
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
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Button Size', 'riode-core' ),
			'description' => esc_html__( 'Control button size.', 'riode-core' ),
			'param_name'  => 'button_size',
			'units'       => array(
				'px',
			),
			'selectors'   => array(
				'{{WRAPPER}} .btn' => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
			),
			'std'         => '{"xl":"60","unit":"","xs":"","sm":"","md":"","lg":""}',
		),
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Padding', 'riode-core' ),
			'description' => esc_html__( 'Controls padding value of button.', 'riode-core' ),
			'param_name'  => 'button_padding',
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .btn' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
			'std'         => '{"top":{"xl":"10","xs":"","sm":"","md":"","lg":""},"right":{"xs":"","sm":"","md":"","lg":"","xl":"12"},"bottom":{"xs":"","sm":"","md":"","lg":"","xl":"10"},"left":{"xs":"","sm":"","md":"","lg":"","xl":"12"}}',
		),
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Border Width', 'riode-core' ),
			'description' => esc_html__( 'Controls border width of buttons.', 'riode-core' ),
			'param_name'  => 'button_bd_width',
			'selectors'   => array(
				'{{WRAPPER}} .btn' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
			),
			'std'         => '{"top":{"xl":"1","xs":"","sm":"","md":"","lg":""},"right":{"xs":"","sm":"","md":"","lg":"","xl":"1"},"bottom":{"xs":"","sm":"","md":"","lg":"","xl":"1"},"left":{"xs":"","sm":"","md":"","lg":"","xl":"1"}}',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Shape', 'riode-core' ),
			'description' => esc_html__( 'Choose border style of Square, Rounded and Ellipse buttons.', 'riode-core' ),
			'param_name'  => 'button_border',
			'label_type'  => 'icon',
			'value'       => array(
				''            => array(
					'title' => esc_html__( 'Square', 'riode-core' ),
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
			'std'         => 'btn-ellipse',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Skin', 'riode-core' ),
			'description' => esc_html__( 'Choose color skin of buttons. Choose from Default, Primary, Secondary, Alert, Success, Dark, White.', 'riode-core' ),
			'param_name'  => 'button_skin',
			'value'       => array(
				''              => array(
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
			'std'         => 'btn-primary',
		),
		array(
			'type'        => 'riode_color_group',
			'heading'     => esc_html__( 'Colors', 'riode-core' ),
			'description' => esc_html__( 'Choose text color, background color and border color for button on normal, hover and active events.', 'riode-core' ),
			'param_name'  => 'btn_colors',
			'selectors'   => array(
				'normal' => '{{WRAPPER}} .btn',
				'hover'  => '{{WRAPPER}} .btn:hover',
				'active' => '{{WRAPPER}} .btn:active',
			),
			'choices'     => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Video Popup', 'riode-core' ),
		'base'            => 'wpb_riode_videopopup',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_videopopup',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Shows video popup', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Videopopup extends WPBakeryShortCode {

	}
}
