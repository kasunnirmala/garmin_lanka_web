<?php
/**
 * Products Layout Banner Item Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Layout', 'riode-core' )   => array(
		array(
			'type'        => 'riode_number',
			'param_name'  => 'item_no',
			'std'         => 1,
			'heading'     => esc_html__( 'Insert Before', 'riode-core' ),
			'description' => esc_html__( 'Input item index where this banner should be inserted before.', 'riode-core' ),
		),
		array(
			'type'       => 'riode_heading',
			'tag'        => 'h3',
			'label'      => esc_html__( 'Creative Layout Options', 'riode-core' ),
			'param_name' => 'creative_item_heading',
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Banner Column Size', 'riode-core' ),
			'param_name'  => 'item_col_span',
			'std'         => '{"xl":"2","unit":"","xs":"","sm":"","md":"","lg":""}',
			'responsive'  => true,
			'description' => esc_html__( 'Control column size of banner in this layout. This option works only for creative layout.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
			'selectors'   => array(
				'.products.product-grid > {{WRAPPER}}' => 'grid-column-end: span {{VALUE}}',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Banner Row Size', 'riode-core' ),
			'param_name'  => 'item_row_span',
			'std'         => '{"xl":"1","unit":"","xs":"","sm":"","md":"","lg":""}',
			'responsive'  => true,
			'description' => esc_html__( 'Control row size of banner in this layout. This option works only for creative layout.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
			'selectors'   => array(
				'.products.product-grid > {{WRAPPER}}' => 'grid-row-end: span {{VALUE}}',
			),
		),
	),
	esc_html__( 'General', 'riode-core' )  => array(
		'riode_wpb_banner_general_controls',
	),
	esc_html__( 'Effect', 'riode-core' )   => array(
		'riode_wpb_banner_effect_controls',
	),
	esc_html__( 'Parallax', 'riode-core' ) => array(
		'riode_wpb_banner_parallax_controls',
	),
	esc_html__( 'Video', 'riode-core' )    => array(
		'riode_wpb_banner_video_controls',
	),

);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'                    => esc_html__( 'Products Layout Banner Item', 'riode-core' ),
		'base'                    => 'wpb_riode_products_banner_item',
		'icon'                    => 'riode-logo-icon',
		'class'                   => 'riode_products_banner_item',
		'controls'                => 'full',
		'category'                => esc_html__( 'Riode', 'riode-core' ),
		'description'             => esc_html__( 'Banner item inside products layout', 'riode-core' ),
		'as_parent'               => array( 'only' => 'wpb_riode_banner_layer' ),
		'as_child'                => array( 'only' => 'wpb_riode_products_layout' ),
		'show_settings_on_create' => true,
		'js_view'                 => 'VcColumnView',
		'params'                  => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_wpb_riode_products_banner_item extends WPBakeryShortCodesContainer {

	}
}
