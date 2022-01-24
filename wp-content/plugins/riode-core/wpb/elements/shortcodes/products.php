<?php
/**
 * Riode Products
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )          => array(
		'riode_wpb_products_select_controls',
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
		'name'            => esc_html__( 'Products', 'riode-core' ),
		'base'            => 'wpb_riode_products',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_products',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display products in grid/slider/creative layout', 'riode-core' ),
		'params'          => $params,
	)
);

// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_products_categories_callback', 'riode_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_products_categories_render', 'riode_wpb_shortcode_product_category_id_render', 10, 1 );

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_products_product_ids_callback', 'riode_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_products_product_ids_render', 'riode_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_riode_products_product_ids_param_value', 'riode_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Products extends WPBakeryShortCode {
	}
}
