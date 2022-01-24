<?php
/**
 * Riode Image Gallery
 *
 * @since 1.1.0
 */

$creative_layout = riode_product_grid_preset();
foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => $item,
	);
}

$params = array(
	esc_html__( 'General', 'riode-core' )          => array(
		array(
			'type'        => 'attach_images',
			'heading'     => esc_html__( 'Add Images', 'riode-core' ),
			'param_name'  => 'images',
			'value'       => '',
			'description' => esc_html__( 'Select images from media library.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'thumbnail_size',
			'std'         => 'thumbnail',
			'heading'     => esc_html__( 'Image Size', 'riode-core' ),
			'value'       => riode_get_image_sizes(),
			'description' => esc_html__( 'Select fit image size with your certain image.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'caption_type',
			'heading'     => esc_html__( 'Caption', 'riode-core' ),
			'value'       => array(
				esc_html__( 'None', 'riode-core' )        => 'none',
				esc_html__( 'Title', 'riode-core' )       => 'title',
				esc_html__( 'Caption', 'riode-core' )     => 'caption',
				esc_html__( 'Description', 'riode-core' ) => 'description',
			),
			'std'         => 'none',
			'description' => esc_html__( 'Select caption type which will be shown under image.', 'riode-core' ),
		),
	),
	esc_html__( 'Layout', 'riode-core' )           => array(
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'layout_type',
			'heading'     => esc_html__( 'Layout', 'riode-core' ),
			'std'         => 'slider',
			'value'       => array(
				'grid'     => array(
					'title' => esc_html__( 'Grid', 'riode-core' ),
				),
				'slider'   => array(
					'title' => esc_html__( 'Slider', 'riode-core' ),
				),
				'creative' => array(
					'title' => esc_html__( 'Creative Grid', 'riode-core' ),
				),
			),
			'description' => esc_html__( 'Select certain layout of your gallery: Grid, Slider, Creative.', 'riode-core' ),
		),
		array(
			'type'         => 'riode_button_group',
			'param_name'   => 'creative_mode',
			'heading'      => esc_html__( 'Creative Layout', 'riode-core' ),
			'std'          => 1,
			'button_width' => '150',
			'value'        => $creative_layout,
			'description'  => esc_html__( 'Choose from 9 supported presets.', 'riode-core' ),
			'dependency'   => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'creative_equal_height',
			'heading'     => esc_html__( 'Equal Row Height', 'riode-core' ),
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'selectors'   => array(
				'{{WRAPPER}} .creative-grid' => 'grid-auto-rows: auto',
			),
			'description' => esc_html__( 'Make base creative grid item’s height to their own.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'col_cnt',
			'heading'     => esc_html__( 'Columns', 'riode-core' ),
			'responsive'  => true,
			'value'       => '{"xl":"4"}',
			'description' => esc_html__( 'Select number of columns to display.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => array(
					'grid',
					'slider',
				),
			),
		),
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'col_sp',
			'heading'     => esc_html__( 'Columns Spacing', 'riode-core' ),
			'std'         => 'md',
			'value'       => array(
				'no' => array(
					'title' => esc_html__( 'No space', 'riode-core' ),
				),
				'xs' => array(
					'title' => esc_html__( 'Extra Small', 'riode-core' ),
				),
				'sm' => array(
					'title' => esc_html__( 'Small', 'riode-core' ),
				),
				'md' => array(
					'title' => esc_html__( 'Medium', 'riode-core' ),
				),
				'lg' => array(
					'title' => esc_html__( 'Large', 'riode-core' ),
				),
			),
			'description' => esc_html__( 'Select the amount of spacing between items.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'slider_vertical_align',
			'heading'     => esc_html__( 'Vertical Align', 'riode-core' ),
			'value'       => array(
				'top'         => array(
					'title' => esc_html__( 'Top', 'riode-core' ),
				),
				'middle'      => array(
					'title' => esc_html__( 'Middle', 'riode-core' ),
				),
				'bottom'      => array(
					'title' => esc_html__( 'Bottom', 'riode-core' ),
				),
				'same-height' => array(
					'title' => esc_html__( 'Stretch', 'riode-core' ),
				),
			),
			'description' => esc_html__( 'Choose from top, middle, bottom and stretch in slider layout.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Image Full Width', 'riode-core' ),
			'param_name'  => 'slider_image_expand',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'description' => esc_html__( 'Expand image size to fit slider layout.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'slider_horizontal_align',
			'heading'     => esc_html__( 'Horizontal Align', 'riode-core' ),
			'value'       => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
				),
			),
			'description' => esc_html__( 'Choose from left, center and right in slider layout.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
			'selectors'   => array(
				'{{WRAPPER}} .owl-item figure' => 'justify-content: {{VALUE}};',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'grid_vertical_align',
			'heading'     => esc_html__( 'Vertical Align', 'riode-core' ),
			'value'       => array(
				'flex-start' => array(
					'title' => esc_html__( 'Top', 'riode-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Middle', 'riode-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Bottom', 'riode-core' ),
				),
				'stretch'    => array(
					'title' => esc_html__( 'Stretch', 'riode-core' ),
				),
			),
			'description' => esc_html__( 'Choose from top, middle, bottom and stretch in grid layout.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'grid',
			),
			'selectors'   => array(
				'{{WRAPPER}} .image-wrap' => 'display: flex;align-items: {{VALUE}};',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Image Full Width', 'riode-core' ),
			'param_name'  => 'grid_image_expand',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'description' => esc_html__( 'Expand image size to fit grid layout.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'grid',
			),
			'selectors'   => array(
				'{{WRAPPER}} .image-wrap img' => 'width: 100%;',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'grid_horizontal_align',
			'heading'     => esc_html__( 'Horizontal Align', 'riode-core' ),
			'value'       => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
				),
			),
			'description' => esc_html__( 'Choose from left, center and right in grid layout.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'grid',
			),
			'selectors'   => array(
				'{{WRAPPER}} .image-wrap' => 'display: flex; justify-content: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Carousel Options', 'riode-core' ) => array(
		esc_html__( 'Options', 'riode-core' ) => array(
			'riode_wpb_slider_general_controls',
		),
		esc_html__( 'Nav', 'riode-core' )     => array(
			'riode_wpb_slider_nav_controls',
		),
		esc_html__( 'Dots', 'riode-core' )    => array(
			'riode_wpb_slider_dots_controls',
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Image Gallery', 'riode-core' ),
		'base'            => 'wpb_riode_image_gallery',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_image_gallery',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Shows multiple images in grid/slider/creative layout', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Image_Gallery extends WPBakeryShortCode {
	}
}
