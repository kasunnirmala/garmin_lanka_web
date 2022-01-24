<?php
/**
 * Riode 360 Degree Gallery
 *
 * @since 1.4.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'attach_images',
			'heading'     => esc_html__( 'Upload Images', 'riode-core' ),
			'param_name'  => 'images',
			'value'       => '',
			'description' => esc_html__( 'Upload bundle of images that you want to show in 360 degree gallery.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'thumbnail_size',
			'std'         => 'thumbnail',
			'heading'     => esc_html__( 'Image Size', 'riode-core' ),
			'value'       => riode_get_image_sizes(),
			'description' => esc_html__( 'Select fit image size that are suitable for rendering area.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'button_type',
			'heading'     => esc_html__( 'Nav Type', 'riode-core' ),
			'description' => esc_html__( 'Choose nav button type. Choose from Framed, Stacked, Link.', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Framed', 'riode-core' )  => 'framed',
				esc_html__( 'Stacked', 'riode-core' ) => 'stacked',
				esc_html__( 'Link', 'riode-core' )    => 'link',
			),
			'std'         => 'framed',
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'        => 'riode_number',
			'param_name'  => 'prev_icon',
			'heading'     => esc_html__( 'Prev Button Size (px)', 'riode-core' ),
			'description' => esc_html__( 'Controls size of prev frame button.', 'riode-core' ),
			'selectors'   => array(
				'{{WRAPPER}} .nav_bar .nav_bar_previous' => 'font-size: {{VALUE}}px;',
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'play_icon',
			'heading'     => esc_html__( 'Play/Pause Button Size (px)', 'riode-core' ),
			'description' => esc_html__( 'Controls size of prev frame button.', 'riode-core' ),
			'selectors'   => array(
				'{{WRAPPER}} .nav_bar .nav_bar_play' => 'font-size: {{VALUE}}px;',
				'{{WRAPPER}} .nav_bar .nav_bar_stop' => 'font-size: {{VALUE}}px;',
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'next_icon',
			'heading'     => esc_html__( 'Next Button Size (px)', 'riode-core' ),
			'description' => esc_html__( 'Controls size of next frame button.', 'riode-core' ),
			'selectors'   => array(
				'{{WRAPPER}} .nav_bar .nav_bar_next' => 'font-size: {{VALUE}}px;',
			),
		),
		array(
			'type'        => 'riode_color_group',
			'heading'     => esc_html__( 'Colors', 'riode-core' ),
			'description' => esc_html__( 'Choose text color, background color and border color for nav buttons on normal and hover events.', 'riode-core' ),
			'param_name'  => 'btn_colors',
			'selectors'   => array(
				'normal' => '{{WRAPPER}} .riode-360-gallery-wrapper .nav_bar a',
				'hover'  => '{{WRAPPER}} .riode-360-gallery-wrapper .nav_bar a:hover',
			),
			'choices'     => array( 'color', 'background-color', 'border-color' ),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( '360 Degree Gallery', 'riode-core' ),
		'base'            => 'wpb_riode_360_degree',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_360_degree',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Shows multiple images in 360 degree mode', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_360_Degree extends WPBakeryShortCode {
	}
}
