<?php
/**
 * Riode Categories
 *
 * @since 1.1.0
 */

$creative_layout = riode_creative_preset();

foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => $item,
	);
}


$params = array(
	esc_html__( 'General', 'riode-core' )          => array(
		array(
			'type'        => 'autocomplete',
			'param_name'  => 'category_ids',
			'heading'     => esc_html__( 'Category IDs', 'riode-core' ),
			'description' => esc_html__( 'comma separated list of category ids', 'riode-core' ),
			'settings'    => array(
				'multiple' => true,
				'sortable' => true,
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'run_as_filter',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'heading'     => esc_html__( 'Run As Filter', 'riode-core' ),
			'description' => esc_html__( 'If this option selected, this widget works as category filter for other product widgets in its section.', 'riode-core' ),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'show_subcategories',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'heading'     => esc_html__( 'Show Subcategories', 'riode-core' ),
			'description' => esc_html__( 'If this option selected, this widget displays only child categories of selected categories.', 'riode-core' ),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'hide_empty',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'heading'     => esc_html__( 'Hide Empty', 'riode-core' ),
			'description' => esc_html__( 'Hide categories that have no products.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'count',
			'heading'     => esc_html__( 'Category Count', 'riode-core' ),
			'description' => esc_html__( 'Select number of products to display. 0 value will show all categories.', 'riode-core' ),
			'std'         => '4',
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'orderby',
			'heading'     => esc_html__( 'Order By', 'riode-core' ),
			'std'         => 'name',
			'value'       => array(
				esc_html__( 'Name', 'riode-core' )        => 'name',
				esc_html__( 'ID', 'riode-core' )          => 'id',
				esc_html__( 'Slug', 'riode-core' )        => 'slug',
				esc_html__( 'Modified', 'riode-core' )    => 'modified',
				esc_html__( 'Product Count', 'riode-core' ) => 'count',
				esc_html__( 'Parent', 'riode-core' )      => 'parent',
				esc_html__( 'Description', 'riode-core' ) => 'description',
				esc_html__( 'Term Group', 'riode-core' )  => 'term_group',
			),
			'description' => esc_html__( 'Defines how categories should be ordered.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'orderway',
			'value'       => array(
				'DESC' => array(
					'title' => esc_html__( 'Descending', 'riode-core' ),
				),
				'ASC'  => array(
					'title' => esc_html__( 'Ascending', 'riode-core' ),
				),
			),
			'std'         => 'DESC',
			'description' => esc_html__( 'Provides advanced configuration: Ascending, Descending.', 'riode-core' ),
		),
	),
	esc_html__( 'Layout', 'riode-core' )           => array(
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'layout_type',
			'heading'     => esc_html__( 'Categories Layout', 'riode-core' ),
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
			'std'         => 'grid',
			'description' => esc_html__( 'Choose the specific layout to suit your need to display categories. We advise you to use Inner Content type of category in creative layout', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'thumbnail_size',
			'heading'     => esc_html__( 'Image Size', 'riode-core' ),
			'value'       => riode_get_image_sizes(),
			'description' => esc_html__( 'Choose the correct image size to fit your category.', 'riode-core' ),
		),
		array(
			'type'         => 'riode_button_group',
			'param_name'   => 'creative_mode',
			'heading'      => esc_html__( 'Creative Layout', 'riode-core' ),
			'std'          => 1,
			'button_width' => '150',
			'value'        => $creative_layout,
			'dependency'   => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Change Grid Height', 'riode-core' ),
			'param_name' => 'creative_height',
			'value'      => '600',
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Grid Mobile Height (%)', 'riode-core' ),
			'param_name' => 'creative_height_ratio',
			'value'      => '75',
			'dependency' => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'grid_float',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'heading'     => esc_html__( 'Use Float Grid', 'riode-core' ),
			'description' => esc_html__( 'The Layout will be built with only float style not using isotope plugin. This is very useful for some simple creative layouts.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'layout_type',
				'value'   => 'creative',
			),
		),
		'riode_wpb_grid_layout_controls',
		'riode_wpb_slider_layout_controls',
	),
	esc_html__( 'Type', 'riode-core' )             => array(
		array(
			'type'        => 'checkbox',
			'param_name'  => 'follow_theme_option',
			'heading'     => esc_html__( 'Follow Theme Option', 'riode-core' ),
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'         => 'yes',
			'description' => esc_html__( 'Set the category type globally.', 'riode-core' ),
		),
		array(
			'type'         => 'riode_button_group',
			'param_name'   => 'category_type',
			'heading'      => esc_html__( 'Category Type', 'riode-core' ),
			'button_width' => '200',
			'description'  => esc_html__( 'Select your specific category type to suit your need.', 'riode-core' ),
			'value'        => array(
				'default'      => array(
					'image' => riode_get_customize_dir() . '/category/default.jpg',
					'title' => esc_html__( 'Default', 'riode-core' ),
				),
				'simple'       => array(
					'image' => riode_get_customize_dir() . '/category/simple.jpg',
					'title' => esc_html__( 'Simple', 'riode-core' ),
				),
				'badge'        => array(
					'image' => riode_get_customize_dir() . '/category/badge.jpg',
					'title' => esc_html__( 'Badge', 'riode-core' ),
				),
				'banner'       => array(
					'image' => riode_get_customize_dir() . '/category/banner.jpg',
					'title' => esc_html__( 'Banner', 'riode-core' ),
				),
				'icon'         => array(
					'image' => riode_get_customize_dir() . '/category/icon.jpg',
					'title' => esc_html__( 'Icon', 'riode-core' ),
				),
				'classic'      => array(
					'image' => riode_get_customize_dir() . '/category/classic.jpg',
					'title' => esc_html__( 'Classic', 'riode-core' ),
				),
				'ellipse'      => array(
					'image' => riode_get_customize_dir() . '/category/ellipse.jpg',
					'title' => esc_html__( 'Ellipse', 'riode-core' ),
				),
				'ellipse-2'    => array(
					'image' => riode_get_customize_dir() . '/category/ellipse-2.jpg',
					'title' => esc_html__( 'Ellipse-2', 'riode-core' ),
				),
				'group'        => array(
					'image' => riode_get_customize_dir() . '/category/subcategory-1.jpg',
					'title' => esc_html__( 'Group', 'riode-core' ),
				),
				'group-2'      => array(
					'image' => riode_get_customize_dir() . '/category/subcategory-2.jpg',
					'title' => esc_html__( 'Group-2', 'riode-core' ),
				),
				'icon-overlay' => array(
					'image' => riode_get_customize_dir() . '/category/icon-overlay.jpg',
					'title' => esc_html__( 'Icon Overlay', 'riode-core' ),
				),
				'center'       => array(
					'image' => riode_get_customize_dir() . '/category/centered.jpg',
					'title' => esc_html__( 'Center', 'riode-core' ),
				),
				'label'        => array(
					'image' => riode_get_customize_dir() . '/category/label.jpg',
					'title' => esc_html__( 'Label', 'riode-core' ),
				),
			),
			'std'          => 'default',
			'dependency'   => array(
				'element'            => 'follow_theme_option',
				'value_not_equal_to' => 'yes',
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'default_width_auto',
			'heading'     => esc_html__( 'Content Width Auto', 'riode-core' ),
			'description' => esc_html__( "Make content width not fixed. Their widths will be different each other depending on children's width.", 'riode-core' ),
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element'            => 'follow_theme_option',
				'value_not_equal_to' => 'yes',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_icon',
			'heading'    => esc_html__( 'Show Icon', 'riode-core' ),
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency' => array(
				'element'            => 'follow_theme_option',
				'value_not_equal_to' => 'yes',
			),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'subcat_cnt',
			'heading'     => esc_html__( 'Subcategory Count', 'riode-core' ),
			'description' => esc_html__( 'This option only works in group type categories', 'riode-core' ),
			'dependency'  => array(
				'element'            => 'follow_theme_option',
				'value_not_equal_to' => 'yes',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'overlay',
			'heading'     => esc_html__( 'Overlay Effect', 'riode-core' ),
			'description' => esc_html__( 'Choose category overlay effect as your need. This effect does not work properly in Icon Overlay, Icon, Group, Group2, Label types.', 'riode-core' ),
			'value'       => array(
				esc_html__( 'No', 'riode-core' )    => '',
				esc_html__( 'Light', 'riode-core' ) => 'light',
				esc_html__( 'Dark', 'riode-core' )  => 'dark',
				esc_html__( 'Zoom', 'riode-core' )  => 'zoom',
				esc_html__( 'Zoom and Light', 'riode-core' ) => 'zoom_light',
				esc_html__( 'Zoom and Dark', 'riode-core' ) => 'zoom_dark',
			),
			'dependency'  => array(
				'element'            => 'follow_theme_option',
				'value_not_equal_to' => 'yes',
			),
		),
	),
	esc_html__( 'Style', 'riode-core' )            => array(
		esc_html__( 'Category', 'riode-core' )         => array(
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'cat_padding',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'param_name' => 'category_min_height',
				'heading'    => esc_html__( 'Min Height', 'riode-core' ),
				'units'      => array(
					'px',
					'rem',
					'%',
					'vh',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category img' => 'min-height:{{VALUE}}{{UNIT}}; object-fit: cover;',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'cat_bg',
				'heading'    => esc_html__( 'Background Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'cat_color',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Category Icon', 'riode-core' )    => array(
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'icon_margin',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} figure i' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'icon_padding',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} figure' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'param_name' => 'icon_size',
				'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
				'with_units' => true,
				'selectors'  => array(
					'{{WRAPPER}} figure i' => 'font-size: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'icon_color',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} figure i' => 'color: {{VALUE}};',
				),
			),
		),
		esc_html__( 'Category Content', 'riode-core' ) => array(
			array(
				'type'       => 'riode_button_group',
				'param_name' => 'content_origin',
				'heading'    => esc_html__( 'Origin', 'riode-core' ),
				'value'      => array(
					'default' => array(
						'title' => esc_html__( 'Default', 'riode-core' ),
					),
					't-m'     => array(
						'title' => esc_html__( 'Vertical Center', 'riode-core' ),
					),
					't-c'     => array(
						'title' => esc_html__( 'Horizontal Center', 'riode-core' ),
					),
					't-mc'    => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
					),
				),
				'std'        => 'default',
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'content_pos',
				'heading'    => esc_html__( 'Content Position', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'top: {{TOP}};right: {{RIGHT}};bottom: {{BOTTOM}};left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'param_name' => 'content_height',
				'heading'    => esc_html__( 'Content Height', 'riode-core' ),
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'height: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'param_name' => 'content_width',
				'heading'    => esc_html__( 'Content Width', 'riode-core' ),
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'width: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'content_width_auto',
				'heading'    => esc_html__( 'Fit Width Automatically', 'riode-core' ),
				'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'selectors'  => array(
					'{{WRAPPER}} .category-content' => 'width: auto !important;',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'content_padding',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'units'      => array(
					'px',
					'em',
					'%',
				),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'param_name' => 'content_align',
				'heading'    => esc_html__( 'Content Align', 'riode-core' ),
				'value'      => array(
					'default'        => array(
						'title' => esc_html__( 'Default', 'riode-core' ),
						'icon'  => 'fas fa-ban',
					),
					'content-left'   => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'fas fa-align-left',
					),
					'content-center' => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'fas fa-align-center',
					),
					'content-right'  => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'fas fa-align-right',
					),
				),
				'std'        => 'default',
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'content_radius',
				'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .category-content' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_color_group',
				'param_name' => 'content_colors',
				'heading'    => esc_html__( 'Colors', 'riode-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .product-category .category-content',
					'hover'  => '{{WRAPPER}} .product-category:hover .category-content',
				),
				'choices'    => array( 'color', 'background-color' ),
			),
		),
		esc_html__( 'Category Name', 'riode-core' )    => array(
			array(
				'type'       => 'colorpicker',
				'param_name' => 'title_color',
				'heading'    => esc_html__( 'Text Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .woocommerce-loop-category__title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'param_name' => 'title_typography',
				'heading'    => esc_html__( 'Text Typography', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .woocommerce-loop-category__title',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'title_margin',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .woocommerce-loop-category__title' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
		),
		esc_html__( 'Products Count', 'riode-core' )   => array(
			array(
				'type'       => 'colorpicker',
				'param_name' => 'count_color',
				'heading'    => esc_html__( 'Count Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category mark' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'param_name' => 'count_typography',
				'heading'    => esc_html__( 'Count Typography', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category mark',
				),
			),
		),
		esc_html__( 'Button', 'riode-core' )           => array(
			array(
				'type'       => 'riode_typography',
				'param_name' => 'button_typography',
				'heading'    => esc_html__( 'Button Typography', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-category .btn',
				),
			),
			array(
				'type'       => 'riode_color_group',
				'param_name' => 'button_colors',
				'heading'    => esc_html__( 'Colors', 'riode-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .product-category .btn',
					'hover'  => '{{WRAPPER}} .product-category .btn:hover, {{WRAPPER}} .product-category .btn:focus',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'button_border_type',
				'heading'    => esc_html__( 'Border Type', 'riode-core' ),
				'value'      => array(
					esc_html__( 'None', 'riode-core' )   => 'none',
					esc_html__( 'Solid', 'riode-core' )  => 'solid',
					esc_html__( 'Double', 'riode-core' ) => 'double',
					esc_html__( 'Dotted', 'riode-core' ) => 'dotted',
					esc_html__( 'Dashed', 'riode-core' ) => 'dashed',
					esc_html__( 'Groove', 'riode-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-style:{{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'button_border_width',
				'heading'    => esc_html__( 'Border Width', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-top:{{TOP}};border-right:{{RIGHT}};border-bottom:{{BOTTOM}};border-left:{{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'button_border_type',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'button_border_radius',
				'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .btn' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'button_margin',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .btn' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'button_padding',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .product-category .btn' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
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
		'name'            => esc_html__( 'Product Categories', 'riode-core' ),
		'base'            => 'wpb_riode_categories',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_categories',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Product categories shown in grid/slider/creative layouts', 'riode-core' ),
		'params'          => $params,
	)
);

add_filter( 'vc_autocomplete_wpb_riode_categories_category_ids_callback', 'riode_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_categories_category_ids_render', 'riode_wpb_shortcode_product_category_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Categories extends WPBakeryShortCode {
	}
}
