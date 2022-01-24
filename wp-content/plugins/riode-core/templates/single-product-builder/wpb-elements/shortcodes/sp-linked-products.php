<?php
/**
 * Riode Single Product Linked Products
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )          => array(
		array(
			'type'       => 'riode_number',
			'param_name' => 'count',
			'heading'    => esc_html__( 'Product Count', 'riode-core' ),
			'value'      => '10',
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'status',
			'heading'    => esc_html__( 'Product Status', 'riode-core' ),
			'value'      => array(
				esc_html__( 'Related Products', 'riode-core' )      => 'related',
				esc_html__( 'Upsell Products', 'riode-core' ) => 'upsell',
			),
			'std'        => 'related',
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'orderby',
			'heading'    => esc_html__( 'Order By', 'riode-core' ),
			'std'        => 'name',
			'value'      => array(
				esc_html__( 'Default', 'riode-core' )     => '',
				esc_html__( 'ID', 'riode-core' )          => 'ID',
				esc_html__( 'Name', 'riode-core' )        => 'title',
				esc_html__( 'Date', 'riode-core' )        => 'date',
				esc_html__( 'Modified', 'riode-core' )    => 'modified',
				esc_html__( 'Price', 'riode-core' )       => 'price',
				esc_html__( 'Random', 'riode-core' )      => 'rand',
				esc_html__( 'Rating', 'riode-core' )      => 'rating',
				esc_html__( 'Comment count', 'riode-core' ) => 'comment_count',
				esc_html__( 'Total Sales', 'riode-core' ) => 'popularity',
			),
		),
		array(
			'type'       => 'riode_button_group',
			'param_name' => 'orderway',
			'value'      => array(
				'DESC' => array(
					'title' => esc_html__( 'Descending', 'riode-core' ),
				),
				'ASC'  => array(
					'title' => esc_html__( 'Ascending', 'riode-core' ),
				),
			),
			'std'        => 'ASC',
		),
	),
	esc_html__( 'Layout', 'riode-core' )           => array(
		'riode_wpb_products_layout_controls',
	),
	esc_html__( 'Type', 'riode-core' )             => array(
		'riode_wpb_product_type_controls',
	),
	esc_html__( 'Style', 'riode-core' )            => array(
		'riode_wpb_product_style_controls',
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

$params = array_merge( riode_wpb_filter_element_params( $params, 'wpb_riode_products' ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Linked Products', 'riode-core' ),
		'base'            => 'wpb_riode_sp_linked_products',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_linked_products',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Related or upsell products in single product', 'riode-core' ),
		'params'          => $params,
	)
);

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_sp_linked_products_product_ids_callback', 'riode_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_sp_linked_products_product_ids_render', 'riode_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_riode_sp_linked_products_product_ids_param_value', 'riode_wpb_shortcode_product_id_param_value', 10, 4 );


if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Linked_Products extends WPBakeryShortCode {

	}
}
