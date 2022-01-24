<?php
/**
 * Logo Element
 *
 * @since 1.1.0
 */

$params = array(
	array(
		'type'        => 'dropdown',
		'param_name'  => 'logo_imaze_size',
		'heading'     => esc_html__( 'Image Size', 'riode-core' ),
		'value'       => riode_get_image_sizes(),
		'description' => esc_html__( 'Choose image size for logo image. Choose from registered image sizes of WordPress and other plugins.', 'riode-core' ),
	),
	array(
		'type'        => 'riode_number',
		'heading'     => esc_html__( 'Width', 'riode-core' ),
		'param_name'  => 'logo_width',
		'description' => esc_html__( 'Controls width of logo image.', 'riode-core' ),
		'responsive'  => true,
		'units'       => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'       => '',
		'selectors'   => array(
			'{{WRAPPER}} .logo' => 'width: {{VALUE}}{{UNIT}};',
		),
	),
	array(
		'type'        => 'riode_number',
		'heading'     => esc_html__( 'Max Width', 'riode-core' ),
		'param_name'  => 'logo_max_width',
		'description' => esc_html__( 'Controls max width of logo image.', 'riode-core' ),
		'responsive'  => true,
		'units'       => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'       => '',
		'selectors'   => array(
			'{{WRAPPER}} .logo' => 'max-width: {{VALUE}}{{UNIT}};',
		),
	),
	array(
		'type'        => 'riode_number',
		'heading'     => esc_html__( 'Width on Sticky', 'riode-core' ),
		'param_name'  => 'logo_width_sticky',
		'description' => esc_html__( 'Controls width of logo image when it is sticked.', 'riode-core' ),
		'responsive'  => true,
		'units'       => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'       => '',
		'selectors'   => array(
			'.fixed {{WRAPPER}} .logo' => 'width: {{VALUE}}{{UNIT}};',
		),
	),
	array(
		'type'        => 'riode_number',
		'heading'     => esc_html__( 'Max Width on Sticky', 'riode-core' ),
		'param_name'  => 'logo_max_width_sticky',
		'description' => esc_html__( 'Controls max width of logo image when it is sticked.', 'riode-core' ),
		'responsive'  => true,
		'units'       => array(
			'px',
			'rem',
			'em',
			'%',
		),
		'value'       => '',
		'selectors'   => array(
			'.fixed {{WRAPPER}} .logo' => 'max-width: {{VALUE}}{{UNIT}};',
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Logo', 'riode-core' ),
		'base'            => 'wpb_riode_logo',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_logo',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display site logo', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Logo extends WPBakeryShortCode {
	}
}
