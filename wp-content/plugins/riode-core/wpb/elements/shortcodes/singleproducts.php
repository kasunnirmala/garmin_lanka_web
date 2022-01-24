<?php
/**
 * Riode Single Product
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )          => array(
		array(
			'type'        => 'autocomplete',
			'param_name'  => 'product_ids',
			'heading'     => esc_html__( 'Product IDs', 'riode-core' ),
			'description' => esc_html__( 'Choose product ids of specific products to display.', 'riode-core' ),
			'settings'    => array(
				'multiple' => true,
				'sortable' => true,
			),
		),
		array(
			'type'        => 'autocomplete',
			'param_name'  => 'categories',
			'heading'     => esc_html__( 'Categories', 'riode-core' ),
			'description' => esc_html__( 'Choose categories which include products to display.', 'riode-core' ),
			'settings'    => array(
				'multiple' => true,
				'sortable' => true,
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'count',
			'heading'     => esc_html__( 'Product Count', 'riode-core' ),
			'description' => esc_html__( 'Controls number of products to display or load more.', 'riode-core' ),
			'value'       => '10',
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'status',
			'heading'     => esc_html__( 'Product Status', 'riode-core' ),
			'description' => esc_html__( 'Choose product status: All, Featured, On Sale, Recently Viewed.', 'riode-core' ),
			'value'       => array(
				esc_html__( 'All', 'riode-core' )      => 'all',
				esc_html__( 'Featured', 'riode-core' ) => 'featured',
				esc_html__( 'On Sale', 'riode-core' )  => 'sale',
				esc_html__( 'Recently Viewed', 'riode-core' ) => 'viewed',
			),
			'std'         => 'all',
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'orderby',
			'heading'     => esc_html__( 'Order By', 'riode-core' ),
			'description' => esc_html__( 'Defines how products should be ordered: Default, ID, Name, Date, Modified, Price, Random, Rating, Total Sales.', 'riode-core' ),
			'std'         => 'name',
			'value'       => array(
				esc_html__( 'Default', 'riode-core' )  => '',
				esc_html__( 'ID', 'riode-core' )       => 'ID',
				esc_html__( 'Name', 'riode-core' )     => 'title',
				esc_html__( 'Date', 'riode-core' )     => 'date',
				esc_html__( 'Modified', 'riode-core' ) => 'modified',
				esc_html__( 'Random', 'riode-core' )   => 'rand',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'orderway',
			'description' => esc_html__( 'Defines products ordering type: Ascending or Descending.', 'riode-core' ),
			'value'       => array(
				'DESC' => array(
					'title' => esc_html__( 'Descending', 'riode-core' ),
				),
				'ASC'  => array(
					'title' => esc_html__( 'Ascending', 'riode-core' ),
				),
			),
			'std'         => 'ASC',
			'dependency'  => array(
				'element'            => 'orderby',
				'value_not_equal_to' => array( 'rating', 'popularity', 'rand' ),
			),
		),
	),
	esc_html__( 'Type', 'riode-core' )             => array(
		'riode_wpb_single_product_type_controls',
	),
	esc_html__( 'Style', 'riode-core' )            => array(
		'riode_wpb_single_product_style_controls',
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
		'name'            => esc_html__( 'Single Products', 'riode-core' ),
		'base'            => 'wpb_riode_singleproducts',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_singleproducts',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display products in single product mode', 'riode-core' ),
		'params'          => $params,
	)
);

// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_singleproducts_categories_callback', 'riode_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_singleproducts_categories_render', 'riode_wpb_shortcode_product_category_id_render', 10, 1 );

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_singleproducts_product_ids_callback', 'riode_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_singleproducts_product_ids_render', 'riode_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_riode_singleproducts_product_ids_param_value', 'riode_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_SingleProducts extends WPBakeryShortCode {
	}
}
