<?php
/**
 * Filter Item Element
 *
 * @since 1.1.0
 */

$attributes  = array();
$taxonomies  = wc_get_attribute_taxonomies();
$default_att = '';

if ( count( $taxonomies ) ) {
	foreach ( $taxonomies as $key => $value ) {
		$attributes[ 'pa_' . $value->attribute_name ] = $value->attribute_label;
	}
	$attributes = array_merge( array( 'default' => esc_html__( 'Select Attribute' ) ), $attributes );
}

if ( empty( $taxonomies ) ) {
	$params = array(
		esc_html__( 'General', 'riode-core' ) => array(
			array(
				'type'       => 'riode_heading',
				'label'      => sprintf( esc_html__( 'Sorry, there are no product attributes available in this site. Click %1$shere%2$s to add attributes.', 'riode-core' ), '<a href="' . esc_url( admin_url() ) . 'edit.php?post_type=product&page=product_attributes" target="blank">', '</a>' ),
				'param_name' => 'no_attribute_description',
				'tag'        => 'p',
			),
		),
	);
} else {
	$params = array(
		esc_html__( 'General', 'riode-core' ) => array(
			array(
				'type'        => 'dropdown',
				'param_name'  => 'name',
				'heading'     => esc_html__( 'Attribute', 'riode-core' ),
				'description' => esc_html__( 'Choose specific product attribute to filter products.', 'riode-core' ),
				'value'       => array_flip( $attributes ),
				'std'         => 'default',
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'query_opt',
				'heading'     => esc_html__( 'Query Type', 'riode-core' ),
				'description' => esc_html__( 'Choose item’s query type: AND / OR.', 'riode-core' ),
				'value'       => array(
					esc_html__( 'AND', 'riode-core' ) => 'and',
					esc_html__( 'OR', 'riode-core' )  => 'or',
				),
				'std'         => 'or',
			),
		),
	);
}

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'        => esc_html__( 'Filter Item', 'riode-core' ),
		'base'        => 'wpb_riode_filter_item',
		'icon'        => 'riode-logo-icon',
		'class'       => 'wpb_riode_filter_item',
		'controls'    => 'full',
		'category'    => esc_html__( 'Riode', 'riode-core' ),
		'description' => esc_html__( 'Filterable product attribute taxonomy.', 'riode-core' ),
		'as_child'    => array( 'only' => 'wpb_riode_filter' ),
		'params'      => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Filter_Item extends WPBakeryShortCode {

	}
}
