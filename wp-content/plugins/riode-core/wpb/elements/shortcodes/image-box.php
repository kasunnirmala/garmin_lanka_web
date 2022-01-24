<?php
/**
 * ImageBox Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Choose Images', 'riode-core' ),
			'param_name'  => 'image',
			'value'       => '',
			'description' => esc_html__( 'Select images from media library.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'thumbnail',
			'std'         => 'full',
			'heading'     => esc_html__( 'Image Size', 'riode-core' ),
			'value'       => riode_get_image_sizes(),
			'description' => esc_html__( 'Select fit image size with your certain image.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'riode-core' ),
			'param_name'  => 'title',
			'value'       => 'Input Title Here',
			'admin_label' => true,
			'description' => esc_html__( 'Type a title for your image box.', 'riode-core' ),
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Subtitle', 'riode-core' ),
			'param_name'  => 'subtitle',
			'value'       => 'Input SubTitle Here',
			'admin_label' => true,
			'description' => esc_html__( 'Type a subtitle for your image box.', 'riode-core' ),
		),
		array(
			'type'        => 'textarea_raw_html',
			'heading'     => esc_html__( 'Content', 'riode-core' ),
			'param_name'  => 'content',
			// @codingStandardsIgnoreLine
			'value'       => base64_encode( '<div class="social-icons">
									<a href="#" class="social-icon framed social-facebook"><i class="fab fa-facebook-f"></i></a>
									<a href="#" class="social-icon framed social-twitter"><i class="fab fa-twitter"></i></a>
									<a href="#" class="social-icon framed social-linkedin"><i class="fab fa-linkedin-in"></i></a>
								</div>'
			),
			'admin_label' => true,
			'description' => esc_html__( 'Type a description or any raw html you want to display in your image box content.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'type',
			'heading'     => esc_html__( 'Imagebox Type', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Default', 'riode-core' )     => 'default',
				esc_html__( 'Outer Title', 'riode-core' ) => 'outer',
				esc_html__( 'Inner Title', 'riode-core' ) => 'inner',
			),
			'std'         => 'default',
			'description' => esc_html__( 'Select any type which suits your need.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'visible_bottom',
			'heading'     => esc_html__( 'Title Bottom Offset', 'riode-core' ),
			'description' => esc_html__( 'Change bottom offset of title and subtitle on hover event.', 'riode-core' ),
			'units'       => array(
				'rem',
			),
			'responsive'  => true,
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'inner',
			),
			'selectors'   => array(
				'{{WRAPPER}} figure:hover .overlay-visible' => 'padding-bottom: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'invisible_top',
			'heading'     => esc_html__( 'Description Top Offset', 'riode-core' ),
			'description' => esc_html__( 'Change top offset of description on hover event.', 'riode-core' ),
			'units'       => array(
				'rem',
			),
			'responsive'  => true,
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'inner',
			),
			'selectors'   => array(
				'{{WRAPPER}} figure:hover .overlay-transparent' => 'padding-top: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Alignment', 'riode-core' ),
			'param_name'  => 'imagebox_align',
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
			'std'         => 'center',
			'selectors'   => array(
				'{{WRAPPER}} .image-box' => 'text-align: {{VALUE}}',
			),
			'description' => esc_html__( 'Choose an alignment for your image box.', 'riode-core' ),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		esc_html__( 'Title', 'riode-core' )       => array(
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'param_name'  => 'title_color',
				'selectors'   => array(
					'{{WRAPPER}} .image-box .title' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Pick the image box title color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Title Typography', 'riode-core' ),
				'param_name'  => 'title_typography',
				'selectors'   => array(
					'{{WRAPPER}} .image-box .title',
				),
				'description' => esc_html__( 'Controls the image box title typography.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Title Margin', 'riode-core' ),
				'param_name'  => 'title_mg',
				'responsive'  => false,
				'selectors'   => array(
					'{{WRAPPER}} .image-box .title' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the image box title margin.', 'riode-core' ),
			),
		),
		esc_html__( 'Sub title', 'riode-core' )   => array(
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'param_name'  => 'subtitle_color',
				'selectors'   => array(
					'{{WRAPPER}} .image-box .subtitle' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Pick the image box subtitle color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'SubTitle Typography', 'riode-core' ),
				'param_name'  => 'subtitle_typography',
				'selectors'   => array(
					'{{WRAPPER}} .image-box .subtitle',
				),
				'description' => esc_html__( 'Controls the image box subtitle typography.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'SubTitle Margin', 'riode-core' ),
				'param_name'  => 'subtitle_mg',
				'responsive'  => false,
				'selectors'   => array(
					'{{WRAPPER}} .image-box .subtitle' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the image box subtitle margin.', 'riode-core' ),
			),
		),
		esc_html__( 'Description', 'riode-core' ) => array(
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'param_name'  => 'description_color',
				'selectors'   => array(
					'{{WRAPPER}} .image-box .content' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Pick the image box description color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Typography', 'riode-core' ),
				'param_name'  => 'description_typography',
				'selectors'   => array(
					'{{WRAPPER}} .image-box .content',
				),
				'description' => esc_html__( 'Controls the image box description typography.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Margin', 'riode-core' ),
				'param_name'  => 'description_mg',
				'responsive'  => false,
				'selectors'   => array(
					'{{WRAPPER}} .image-box .content' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the image box description margin.', 'riode-core' ),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'ImageBox', 'riode-core' ),
		'base'            => 'wpb_riode_image_box',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_image_box',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Shows information with image and description', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Image_Box extends WPBakeryShortCode {
	}
}
