<?php
/**
 * Riode Vendor Render
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )          => array(
		array(
			'type'        => 'dropdown',
			'param_name'  => 'vendor_select_type',
			'heading'     => esc_html__( 'Select', 'riode-core' ),
			'description' => esc_html__( 'Allows you to choose certain method to select vendors.', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Individually', 'riode-core' ) => 'individual',
				esc_html__( 'Group', 'riode-core' )        => 'group',
			),
			'std'         => 'group',
		),
		array(
			'type'        => 'autocomplete',
			'param_name'  => 'vendor_ids',
			'heading'     => esc_html__( 'Select Vendors', 'riode-core' ),
			'description' => esc_html__( 'Allows you to select certain vendors by typing their names.', 'riode-core' ),
			'settings'    => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency'  => array(
				'element' => 'vendor_select_type',
				'value'   => 'individual',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'vendor_type',
			'heading'     => esc_html__( 'Vendor Type', 'riode-core' ),
			'description' => esc_html__( 'Select certain group of vendors(ex: top selling, top rating and etc).', 'riode-core' ),
			'value'       => array(
				esc_html__( 'General', 'riode-core' ) => '',
				esc_html__( 'Top Selling Vendors', 'riode-core' ) => 'sale',
				esc_html__( 'Top Rating Vendors', 'riode-core' ) => 'rating',
				esc_html__( 'Newly Added Vendors', 'riode-core' ) => 'recent',
			),
			'std'         => '',
			'dependency'  => array(
				'element' => 'vendor_select_type',
				'value'   => 'group',
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'vendor_count',
			'heading'     => esc_html__( 'Vendor Count', 'riode-core' ),
			'description' => esc_html__( 'Type a number of vendors which are shown.', 'riode-core' ),
			'std'         => '{"xl":"4"}',
			'dependency'  => array(
				'element' => 'vendor_select_type',
				'value'   => 'group',
			),
		),
	),
	esc_html__( 'Layout', 'riode-core' )           => array(
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'layout_type',
			'heading'     => esc_html__( 'Vendors Layout', 'riode-core' ),
			'description' => esc_html__( 'Select a certain layout for displaying your vendors.', 'riode-core' ),
			'value'       => array(
				'grid'   => array(
					'title' => esc_html__( 'Grid', 'riode-core' ),
				),
				'slider' => array(
					'title' => esc_html__( 'Slider', 'riode-core' ),
				),
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'thumbnail',
			'heading'     => esc_html__( 'Image Size', 'riode-core' ),
			'description' => esc_html__( 'Select a certain image size which is fit with your image.', 'riode-core' ),
			'value'       => array_flip( riode_get_image_sizes() ),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'col_cnt',
			'heading'     => esc_html__( 'Columns', 'riode-core' ),
			'description' => esc_html__( 'Select number of columns to display.', 'riode-core' ),
			'responsive'  => true,
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
			'description' => esc_html__( 'Select the amount of spacing between items.', 'riode-core' ),
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
		),
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'slider_vertical_align',
			'heading'     => esc_html__( 'Vertical Align', 'riode-core' ),
			'description' => esc_html__( 'Choose vertical alignment of items. Choose from Top, Middle, Bottom, Stretch.', 'riode-core' ),
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
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'slider',
			),
		),
	),
	esc_html__( 'Vendor Type' )                    => array(
		array(
			'type'        => 'dropdown',
			'param_name'  => 'vendor_display_type',
			'heading'     => esc_html__( 'Display Type', 'riode-core' ),
			'description' => esc_html__( 'Select a certain display type for your vendors.', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Type 1', 'riode-core' ) => '1',
				esc_html__( 'Type 2', 'riode-core' ) => '2',
				esc_html__( 'Type 3', 'riode-core' ) => '3',
			),
			'std'         => '1',
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'show_vendor_rating',
			'heading'     => esc_html__( 'Show Vendor Rating', 'riode-core' ),
			'description' => esc_html__( 'Toggle for making your vendors have ratings or not.', 'riode-core' ),
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element'            => 'vendor_display_type',
				'value_not_equal_to' => '2',
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'show_total_sale',
			'heading'     => esc_html__( 'Show Total Sale', 'riode-core' ),
			'description' => esc_html__( 'Toggle for making your vendors have total sales or not.', 'riode-core' ),
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'vendor_display_type',
				'value'   => array( '1', '2' ),
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
		'name'            => esc_html__( 'Vendors', 'riode-core' ),
		'base'            => 'wpb_riode_vendor',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_vendor',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display vendors in marketplace', 'riode-core' ),
		'params'          => $params,
	)
);

// Vendor Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_vendor_vendor_ids_callback', 'riode_wpb_shortcode_vendor_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_vendor_vendor_ids_render', 'riode_wpb_shortcode_vendor_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Vendor extends WPBakeryShortCode {
	}
}
