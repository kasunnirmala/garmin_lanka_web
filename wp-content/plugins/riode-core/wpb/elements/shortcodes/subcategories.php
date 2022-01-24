<?php
/**
 * Riode Subcategories
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Post Type', 'riode-core' ),
			'param_name'  => 'list_type',
			'description' => esc_html__( 'Choose to show category of POST or PRODUCT.', 'riode-core' ),
			'value'       => array(
				'cat'  => array(
					'title' => esc_html__( 'Post', 'riode-core' ),
				),
				'pcat' => array(
					'title' => esc_html__( 'Product', 'riode-core' ),
				),
			),
			'std'         => 'pcat',
			'admin_label' => true,
		),
		array(
			'type'        => 'autocomplete',
			'param_name'  => 'category_ids',
			'description' => esc_html__( 'Choose parent categories that you want to show subcategories of.', 'riode-core' ),
			'heading'     => esc_html__( 'Select Categories', 'riode-core' ),
			'settings'    => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'cat',
			),
		),
		array(
			'type'        => 'autocomplete',
			'param_name'  => 'product_category_ids',
			'description' => esc_html__( 'Choose parent categories that you want to show subcategories of.', 'riode-core' ),
			'heading'     => esc_html__( 'Select Categories', 'riode-core' ),
			'settings'    => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'pcat',
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'count',
			'heading'     => esc_html__( 'Subcategories Count', 'riode-core' ),
			'description' => esc_html__( '0 value will show all categories.', 'riode-core' ),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'hide_empty',
			'description' => esc_html__( 'Choose to show/hide empty subcategories which have no products or posts', 'riode-core' ),
			'heading'     => esc_html__( 'Hide Empty Subcategories', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'view_all',
			'description' => esc_html__( 'This label link will be appended to subcategories list', 'riode-core' ),
			'heading'     => esc_html__( 'View All Label', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'cat_delimtier',
			'description' => esc_html__( 'Type the delimiter text between parent and child categories.', 'riode-core' ),
			'heading'     => esc_html__( 'Category Delimiter', 'riode-core' ),
			'selectors'   => array(
				'{{WRPAPER}} .subcat-title::after' => "content: '{{VALUE}}';",
				'{{WRPAPER}} .subcat-title'        => 'margin-right: 0;',
			),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'subcat_delimtier',
			'std'         => '|',
			'description' => esc_html__( 'Type the delimiter text between each child categories.', 'riode-core' ),
			'heading'     => esc_html__( 'Subcategory Delimiter', 'riode-core' ),
			'selectors'   => array(
				'{{WRAPPER}} .subcat-nav a:not(:last-child):after' => "content: '{{VALUE}}';",
			),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		esc_html__( 'Title Style', 'riode-core' )       => array(
			array(
				'type'        => 'riode_typography',
				'param_name'  => 'title_typo',
				'description' => esc_html__( 'Choose font family, size, weight, text transform, line height and letter spacing of parent category.', 'riode-core' ),
				'heading'     => esc_html__( 'Title Typography', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-title',
				),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'title_color',
				'description' => esc_html__( 'Choose color of parent category.', 'riode-core' ),
				'heading'     => esc_html__( 'Title Color', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'riode_number',
				'param_name'  => 'title_space',
				'description' => esc_html__( 'Controls space between parent category and child category list.', 'riode-core' ),
				'heading'     => esc_html__( 'Title Space', 'riode-core' ),
				'units'       => array(
					'px',
					'rem',
				),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-title' => 'margin-right:{{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'        => 'riode_number',
				'param_name'  => 'title_space_bottom',
				'description' => esc_html__( 'Controls space between each subcategory list.', 'riode-core' ),
				'heading'     => esc_html__( 'Title Row Space', 'riode-core' ),
				'units'       => array(
					'px',
					'rem',
				),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-title' => 'margin-bottom:{{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'        => 'riode_typography',
				'param_name'  => 'cat_delimiter_typo',
				'description' => esc_html__( 'Controls typography of delimiter between parent and child categories.', 'riode-core' ),
				'heading'     => esc_html__( 'Delimiter Typography', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-title::after',
				),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'cat_delimiter_color',
				'description' => esc_html__( 'Choose color of delimiter between parent and child categories.', 'riode-core' ),
				'heading'     => esc_html__( 'Delimiter Color', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-title::after' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Delimiter Spacing', 'riode-core' ),
				'param_name'  => 'cat_delimiter_spacing',
				'description' => esc_html__( 'Controls left and right space around delimiter between parent category and child categories.', 'riode-core' ),
				'disallowed'  => array( 'top', 'bottom' ),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-title::after' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
		),
		esc_html__( 'Subcategory Style', 'riode-core' ) => array(
			array(
				'type'        => 'riode_typography',
				'param_name'  => 'link_typo',
				'description' => esc_html__( 'Choose font family, size, weight, text transform, line height and letter spacing of child categories.', 'riode-core' ),
				'heading'     => esc_html__( 'Link Typography', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-nav a',
				),
			),
			array(
				'type'        => 'riode_color_group',
				'description' => esc_html__( 'Choose color of child categories.', 'riode-core' ),
				'heading'     => esc_html__( 'Link Colors', 'riode-core' ),
				'param_name'  => 'link_color',
				'selectors'   => array(
					'normal' => '{{WRAPPER}} .subcat-nav a',
					'hover'  => '{{WRAPPER}} .subcat-nav a:hover, {{WRAPPER}} .subcat-nav a:focus, {{WRAPPER}} .subcat-nav a:visited',
				),
				'choices'     => array( 'color' ),
			),
			array(
				'type'        => 'riode_number',
				'param_name'  => 'link_space',
				'description' => esc_html__( 'Controls space between each subcategory items.', 'riode-core' ),
				'heading'     => esc_html__( 'Link Space', 'riode-core' ),
				'units'       => array(
					'px',
					'rem',
				),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-nav a' => 'margin-right:{{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .subcat-nav a:not(:last-child):after' => 'margin-left: calc( {{VALUE}}{{UNIT}} / 2 );',
				),
			),
			array(
				'type'        => 'riode_typography',
				'param_name'  => 'subcat_delimiter_typo',
				'description' => esc_html__( 'Controls typography of delimiter between subcategory items.', 'riode-core' ),
				'heading'     => esc_html__( 'Delimiter Typography', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-nav a:not(:last-child):after',
				),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'subcat_delimiter_color',
				'description' => esc_html__( 'Choose color of delimiter between subcategory items.', 'riode-core' ),
				'heading'     => esc_html__( 'Delimiter Color', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-nav a:not(:last-child):after' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Delimiter Spacing', 'riode-core' ),
				'param_name'  => 'subcat_delimiter_spacing',
				'description' => esc_html__( 'Controls left and right space around the delimiter between subcategory items.', 'riode-core' ),
				'disallowed'  => array( 'top', 'bottom' ),
				'selectors'   => array(
					'{{WRAPPER}} .subcat-nav a:not(:last-child):after' => 'right:-{{LEFT}};',
					'{{WRAPPER}} .subcat-nav a:not(:last-child)' => 'margin-right:calc({{LEFT}} + {{RIGHT}});',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Subcategories', 'riode-core' ),
		'base'            => 'wpb_riode_subcategories',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_subcategories',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display subcategories of specific category', 'riode-core' ),
		'params'          => $params,
	)
);

// Category Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_subcategories_category_ids_callback', 'riode_wpb_shortcode_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_subcategories_category_ids_render', 'riode_wpb_shortcode_category_id_render', 10, 1 );

// Product Category Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_subcategories_product_category_ids_callback', 'riode_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_subcategories_product_category_ids_render', 'riode_wpb_shortcode_product_category_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Subcategories extends WPBakeryShortCode {
	}
}
