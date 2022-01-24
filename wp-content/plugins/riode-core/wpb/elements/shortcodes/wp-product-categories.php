<?php
/**
 * Riode WP Product Categories
 *
 * @since 1.1.0
 */
$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'riode-core' ),
			'param_name' => 'title',
			'std'        => 'Product categories',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show product counts', 'riode-core' ),
			'param_name' => 'count',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'no',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show hierarchy', 'riode-core' ),
			'param_name' => 'hierarchical',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Hide empty categories', 'riode-core' ),
			'param_name' => 'hide_empty',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Maximum depth', 'riode-core' ),
			'param_name' => 'max_depth',
			'std'        => 1,
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ) );

vc_map(
	array(
		'name'            => esc_html__( 'WP Product Categories', 'riode-core' ),
		'base'            => 'wpb_riode_wp_product_categories',
		'icon'            => 'riode-logo-icon',
		'class'           => 'wpb_riode_wp_product_categories',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display product categories in sidebar', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_WP_Product_Categories extends WPBakeryShortCode {

	}
}
