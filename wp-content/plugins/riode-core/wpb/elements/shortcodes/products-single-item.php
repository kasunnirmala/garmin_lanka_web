<?php
/**
 * Products Layout Single Product Item Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Layout', 'riode-core' ) => array(
		array(
			'type'       => 'riode_heading',
			'tag'        => 'p',
			'label'      => esc_html__( 'This element works only for creative products layout.', 'riode-core' ),
			'param_name' => 'creative_item_heading',
		),
		array(
			'type'        => 'autocomplete',
			'param_name'  => 'product_ids',
			'heading'     => esc_html__( 'Product IDs', 'riode-core' ),
			'description' => esc_html__( 'If this field is empty, it displays below index of user-selected products as single product.', 'riode-core' ),
			'settings'    => array(
				'sortable' => true,
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'item_no',
			'heading'     => esc_html__( 'Insert Before', 'riode-core' ),
			'description' => esc_html__( 'Input item index where this single product should be inserted before.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Single Product Column Size', 'riode-core' ),
			'param_name'  => 'item_col_span',
			'std'         => '{"xl":"2","unit":"","xs":"","sm":"","md":"","lg":""}',
			'responsive'  => true,
			'description' => esc_html__( 'Control column size of single product in this layout. This option works only for creative layout.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
			'selectors'   => array(
				'.product-grid > {{WRAPPER}}' => 'grid-column-end: span {{VALUE}}',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Single Product Row Size', 'riode-core' ),
			'param_name'  => 'item_row_span',
			'std'         => '{"xl":"1","unit":"","xs":"","sm":"","md":"","lg":""}',
			'responsive'  => true,
			'description' => esc_html__( 'Control row size of single product in this layout. This option works only for creative layout.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
			'selectors'   => array(
				'.product-grid > {{WRAPPER}}' => 'grid-row-end: span {{VALUE}}',
			),
		),
	),
	esc_html__( 'Type', 'riode-core' )   => array(
		'riode_wpb_single_product_type_controls',
	),
	esc_html__( 'Style', 'riode-core' )  => array(
		'riode_wpb_single_product_style_controls',
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Products Layout Single Product Item', 'riode-core' ),
		'base'            => 'wpb_riode_products_single_item',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_products_single_item',
		'controls'        => 'full',
		'content_element' => true,
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Single product item inside products layout', 'riode-core' ),
		'as_child'        => array( 'only' => 'wpb_riode_products_layout' ),
		'params'          => $params,
	)
);

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_products_single_item_product_ids_callback', 'riode_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_products_single_item_product_ids_render', 'riode_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_riode_products_single_item_product_ids_param_value', 'riode_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Products_Single_Item extends WPBakeryShortCode {
	}
}
