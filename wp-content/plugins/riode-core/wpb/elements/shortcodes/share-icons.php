<?php
/**
 * Share Icons Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'dropdown',
			'param_name'  => 'share_direction',
			'description' => esc_html__( 'Determine whether to arrange social link items horizontally or vertically.', 'riode-core' ),
			'heading'     => esc_html__( 'Share Direction', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Row', 'riode-core' )    => 'flex',
				esc_html__( 'Column', 'riode-core' ) => 'block',
			),
			'std'         => 'flex',
			'selectors'   => array(
				'{{WRAPPER}}.social-icons' => 'display:{{VALUE}};',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'border_type',
			'description' => esc_html__( 'Choose border style of social link item. Choose from Square, Rounded, Ellipse.', 'riode-core' ),
			'heading'     => esc_html__( 'Border Style', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Rectangle', 'riode-core' ) => '0',
				esc_html__( 'Rounded', 'riode-core' )   => '10px',
				esc_html__( 'Circle', 'riode-core' )    => '50%',
			),
			'std'         => '50%',
			'selectors'   => array(
				'{{WRAPPER}} .social-icon' => 'border-radius:{{VALUE}};',
			),
		),
		array(
			'type'        => 'riode_dimension',
			'param_name'  => 'icon_border',
			'description' => esc_html__( 'Controls border width of framed social icons.', 'riode-core' ),
			'heading'    => esc_html__( 'Border', 'riode-core' ),
			'responsive'  => false,
			'selectors'   => array(
				'{{WRAPPER}} .social-icon' => 'border-top:{{TOP}} solid;border-right:{{RIGHT}} solid;border-bottom:{{BOTTOM}} solid;border-left:{{LEFT}} solid;',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => __( 'Border Radius', 'riode-core' ),
			'description' => esc_html__( 'Controls border radius of social icons.', 'riode-core' ),
			'param_name' => 'br_radius',
			'responsive'  => false,
			'units'       => array(
				'px',
				'%',
			),
			'selectors'   => array(
				'{{WRAPPER}} .social-icon' => 'border-radius: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => __( 'Background Size', 'riode-core' ),
			'description' => esc_html__( 'Controls entire size of social items.', 'riode-core' ),
			'param_name'  => 'bg_size',
			'responsive'  => false,
			'units'       => array(
				'px',
			),
			'selectors'   => array(
				'{{WRAPPER}} .social-icon' => 'width: {{VALUE}}{{UNIT}};height: {{VALUE}}{{UNIT}};display:flex;align-items:center;justify-content:center;',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => __( 'Icon Size', 'riode-core' ),
			'description' => esc_html__( 'Controls only icon size of social items.', 'riode-core' ),
			'param_name'  => 'icon_size',
			'responsive'  => true,
			'units'       => array(
				'px',
			),
			'selectors'   => array(
				'{{WRAPPER}} .social-icon i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_color_group',
			'heading'     => esc_html__( 'Icon Colors', 'riode-core' ),
			'description' => esc_html__( 'Choose color scheme of social icons on normal and hover event.', 'riode-core' ),
			'param_name'  => 'icon_color',
			'selectors'   => array(
				'normal' => '{{WRAPPER}} .social-icon',
				'hover'  => '{{WRAPPER}} .social-icon:hover',
			),
			'choices'     => array( 'color', 'background-color', 'border-color' ),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => __( 'Icon Column Spacing', 'riode-core' ),
			'description' => esc_html__( 'Controls horizontal space (Left and Right) of social items.', 'riode-core' ),
			'param_name'  => 'icon_spacing',
			'responsive'  => true,
			'units'       => array(
				'px',
				'%',
				'rem',
			),
			'selectors'   => array(
				'{{WRAPPER}} .social-icon'            => 'margin-right: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .social-icon:last-child' => 'margin-right: 0;',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => __( 'Icon Row Spacing', 'riode-core' ),
			'description' => esc_html__( 'Controls vertical space (Top and Bottom) of social items.', 'riode-core' ),
			'param_name'  => 'row_space',
			'responsive'  => true,
			'units'       => array(
				'px',
				'%',
				'rem',
			),
			'selectors'   => array(
				'{{WRAPPER}} .social-icon + .social-icon, {{WRAPPER}} .vc_wpb_riode_share_icon + .vc_wpb_riode_share_icon' => 'margin-top: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Share Icons', 'riode-core' ),
		'base'                    => 'wpb_riode_share_icons',
		'icon'                    => 'riode-logo-icon',
		'class'                   => 'wpb_riode_share_icons',
		'controls'                => 'full',
		'category'                => esc_html__( 'Riode', 'riode-core' ),
		'description'             => esc_html__( 'Group of social network to share or for social login', 'riode-core' ),
		'as_parent'               => array( 'only' => 'wpb_riode_share_icon' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'default_content'         => '[wpb_riode_share_icon icon="facebook"][wpb_riode_share_icon icon="twitter"][wpb_riode_share_icon icon="linkedin"]',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Share_Icons extends WPBakeryShortCodesContainer {

	}
}
