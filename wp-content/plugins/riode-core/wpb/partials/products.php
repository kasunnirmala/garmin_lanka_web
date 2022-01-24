<?php

if ( ! function_exists( 'riode_wpb_products_select_controls' ) ) {
	function riode_wpb_products_select_controls() {
		return array(
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
					esc_html__( 'Price', 'riode-core' )    => 'price',
					esc_html__( 'Random', 'riode-core' )   => 'rand',
					esc_html__( 'Rating', 'riode-core' )   => 'rating',
					esc_html__( 'Total Sales', 'riode-core' ) => 'popularity',
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
		);
	}
}

if ( ! function_exists( 'riode_wpb_products_layout_controls' ) ) {
	function riode_wpb_products_layout_controls( $layout_builder = false ) {
		$creative_layout = riode_product_grid_preset();
		foreach ( $creative_layout as $key => $item ) {
			$creative_layout[ $key ] = array(
				'title' => $key,
				'image' => RIODE_CORE_URI . $item,
			);
		}

		$result = array(
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'layout_type',
				'heading'     => esc_html__( 'Layout', 'riode-core' ),
				'description' => esc_html__( 'Choose products layout type: Grid, Slider, Creative Layout (Masonry).', 'riode-core' ),
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
			),
		);

		if ( ! $layout_builder ) {
			array_push(
				$result,
				array(
					'type'        => 'dropdown',
					'param_name'  => 'bg_thumbnail_size',
					'heading'     => esc_html__( 'Image Size', 'riode-core' ),
					'description' => esc_html__( 'Product Image Size for Large grid areas', 'riode-core' ),
					'value'       => riode_get_image_sizes(),
					'dependency'  => array(
						'element' => 'layout_type',
						'value'   => 'creative',
					),
				),
				array(
					'type'         => 'riode_button_group',
					'param_name'   => 'creative_mode',
					'heading'      => esc_html__( 'Creative Layout', 'riode-core' ),
					'description'  => esc_html__( 'Choose from 9 supported presets.', 'riode-core' ),
					'std'          => 1,
					'button_width' => '150',
					'value'        => $creative_layout,
					'dependency'   => array(
						'element' => 'layout_type',
						'value'   => 'creative',
					),
				),
				array(
					'type'        => 'checkbox',
					'param_name'  => 'creative_auto_height',
					'heading'     => esc_html__( 'Auto Row Height', 'riode-core' ),
					'description' => esc_html__( 'Make base creative grid item’s height to their own.', 'riode-core' ),
					'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
					'dependency'  => array(
						'element' => 'layout_type',
						'value'   => 'creative',
					),
					'std'         => 'yes',
					'selectors'   => array(
						'{{WRAPPER}} .product-grid' => 'grid-auto-rows: auto',
					),
				),
				array(
					'type'        => 'riode_number',
					'param_name'  => 'col_cnt',
					'heading'     => esc_html__( 'Columns', 'riode-core' ),
					'description' => esc_html__( 'Controls number of products to display or load more.', 'riode-core' ),
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
					'type'        => 'riode_number',
					'param_name'  => 'row_cnt',
					'heading'     => esc_html__( 'Rows Count', 'riode-core' ),
					'description' => esc_html__( 'How many rows of products should be shown in each column?', 'riode-core' ),
					'std'         => 1,
					'dependency'  => array(
						'element' => 'layout_type',
						'value'   => 'slider',
					),
				)
			);
		} else {
			array_push(
				$result,
				array(
					'type'        => 'riode_number',
					'param_name'  => 'col_cnt',
					'heading'     => esc_html__( 'Columns', 'riode-core' ),
					'description' => esc_html__( 'Controls number of columns to display.', 'riode-core' ),
					'responsive'  => true,
					'selectors'   => array(
						'{{WRAPPER}} .product-grid' => 'grid-template-columns: repeat(auto-fill, calc(100% / {{VALUE}}))',
					),
				),
				array(
					'type'       => 'checkbox',
					'param_name' => 'creative_auto_height',
					'heading'    => esc_html__( 'Auto Row Height', 'riode-core' ),
					'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
					'dependency' => array(
						'element' => 'layout_type',
						'value'   => 'creative',
					),
					'selectors'  => array(
						'{{WRAPPER}} .product-grid' => 'grid-auto-rows: auto',
					),
				),
				array(
					'type'        => 'riode_number',
					'heading'     => esc_html__( 'Base Column Size', 'riode-core' ),
					'param_name'  => 'base_col_span',
					'std'         => '{"xl":"1","unit":"","xs":"","sm":"","md":"","lg":""}',
					'responsive'  => true,
					'description' => esc_html__( 'Control column size of normal products in this layout', 'riode-core' ),
					'dependency'  => array(
						'element' => 'layout_type',
						'value'   => 'creative',
					),
					'selectors'   => array(
						'{{WRAPPER}} .product-grid > *' => 'grid-column-end: span {{VALUE}}',
					),
				),
				array(
					'type'        => 'riode_number',
					'heading'     => esc_html__( 'Base Row Size', 'riode-core' ),
					'param_name'  => 'base_row_span',
					'std'         => '{"xl":"1","unit":"","xs":"","sm":"","md":"","lg":""}',
					'responsive'  => true,
					'description' => esc_html__( 'Control row size of normal products in this layout', 'riode-core' ),
					'dependency'  => array(
						'element' => 'layout_type',
						'value'   => 'creative',
					),
					'selectors'   => array(
						'{{WRAPPER}} .product-grid > *' => 'grid-row-end: span {{VALUE}}',
					),
				)
			);
		}

		array_push(
			$result,
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'col_sp',
				'heading'     => esc_html__( 'Columns Spacing', 'riode-core' ),
				'description' => esc_html__( 'Controls amount of spacing between columns.', 'riode-core' ),
				'std'         => 'md',
				'value'       => array(
					'no' => array(
						'title' => esc_html__( 'NO', 'riode-core' ),
					),
					'xs' => array(
						'title' => esc_html__( 'XS', 'riode-core' ),
					),
					'sm' => array(
						'title' => esc_html__( 'SM', 'riode-core' ),
					),
					'md' => array(
						'title' => esc_html__( 'MD', 'riode-core' ),
					),
					'lg' => array(
						'title' => esc_html__( 'LG', 'riode-core' ),
					),
				),
			),
			array(
				'type'       => 'riode_button_group',
				'param_name' => 'slider_vertical_align',
				'heading'    => esc_html__( 'Vertical Align', 'riode-core' ),
				'value'      => array(
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
				'dependency' => array(
					'element' => 'layout_type',
					'value'   => 'slider',
				),
			)
		);

		if ( ! $layout_builder ) {
			array_push(
				$result,
				array(
					'type'        => 'dropdown',
					'param_name'  => 'loadmore_type',
					'heading'     => esc_html__( 'Load More', 'riode-core' ),
					'description' => esc_html__( ' Allows you to load more products by ajax: By button, By scroll.', 'riode-core' ),
					'value'       => array(
						esc_html__( 'No', 'riode-core' ) => '',
						esc_html__( 'By button', 'riode-core' ) => 'button',
						esc_html__( 'By scroll', 'riode-core' ) => 'scroll',
					),
					'dependency'  => array(
						'element' => 'layout_type',
						'value'   => array( 'grid', 'creative' ),
					),
				),
				array(
					'type'        => 'textfield',
					'param_name'  => 'loadmore_label',
					'heading'     => esc_html__( 'Load More Label', 'riode-core' ),
					'value'       => '',
					'placeholder' => esc_html__( 'Load More', 'riode-core' ),
					'dependency'  => array(
						'element' => 'layout_type',
						'value'   => array( 'grid', 'creative' ),
					),
				),
				array(
					'type'        => 'checkbox',
					'param_name'  => 'filter_cat_w',
					'heading'     => esc_html__( 'Filter by Category Widget', 'riode-core' ),
					'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
					'description' => esc_html__( 'If there is a category widget enabled "Run as filter" option in the same section, You can filter by category widget using this option.', 'riode-core' ),
				),
				array(
					'type'        => 'checkbox',
					'param_name'  => 'filter_cat',
					'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
					'heading'     => esc_html__( 'Show Category Filter', 'riode-core' ),
					'description' => esc_html__( 'Defines whether to show or hide category filters above products.', 'riode-core' ),
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Show "All" Filter', 'riode-core' ),
					'param_name' => 'show_all_filter',
					'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
					'dependency' => array(
						'element' => 'filter_cat',
						'value'   => 'yes',
					),
				)
			);
		}

		return $result;
	}
}

if ( ! function_exists( 'riode_wpb_product_type_controls' ) ) {
	function riode_wpb_product_type_controls() {
		return array(
			array(
				'type'        => 'dropdown',
				'param_name'  => 'thumbnail_size',
				'heading'     => esc_html__( 'Image Size', 'riode-core' ),
				'description' => esc_html__( 'Choose size of product thumbnail.', 'riode-core' ),
				'value'       => riode_get_image_sizes(),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'follow_theme_option',
				'heading'     => esc_html__( 'Follow Theme Option', 'riode-core' ),
				'description' => esc_html__( 'Choose to follows product type from theme options.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'std'         => 'yes',
			),
			array(
				'type'         => 'riode_button_group',
				'param_name'   => 'product_type',
				'heading'      => esc_html__( 'Product Type', 'riode-core' ),
				'description'  => esc_html__( 'Choose from 4 default types: Default, Classic, List, Widget.', 'riode-core' ),
				'button_width' => '200',
				'value'        => array(
					'default' => array(
						'image' => RIODE_CORE_URI . 'assets/images/product/default.jpg',
						'title' => 'Default',
					),
					'classic' => array(
						'image' => RIODE_CORE_URI . 'assets/images/product/classic.jpg',
						'title' => 'Classic',
					),
					'list'    => array(
						'image' => RIODE_CORE_URI . 'assets/images/product/list.jpg',
						'title' => 'List',
					),
					'widget'  => array(
						'image' => RIODE_CORE_URI . 'assets/images/product/widget.jpg',
						'title' => 'Widget',
					),
				),
				'std'          => 'default',
				'dependency'   => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'classic_hover',
				'heading'     => esc_html__( 'Hover Effect', 'riode-core' ),
				'value'       => array(
					'default' => array(
						'title' => esc_html__( 'Default', 'riode-core' ),
					),
					'popup'   => array(
						'title' => esc_html__( 'Popup', 'riode-core' ),
					),
					'slideup' => array(
						'title' => esc_html__( 'Slide Up', 'riode-core' ),
					),
				),
				'description' => esc_html__( 'This option only works in product classic type.', 'riode-core' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'show_in_box',
				'heading'     => esc_html__( 'Show In Box', 'riode-core' ),
				'description' => esc_html__( 'Choose to show outline border around each product.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'show_reviews_text',
				'heading'     => esc_html__( 'Show Reviews Text', 'riode-core' ),
				'description' => esc_html__( 'Choose whether to show “reviews” text beside rating count or hide text.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'std'         => 'yes',
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'show_hover_effect',
				'heading'     => esc_html__( 'Shadow Effect on Hover', 'riode-core' ),
				'description' => esc_html__( 'This option only works in default product type', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'show_media_shadow',
				'heading'    => esc_html__( 'Media Shadow Effect on Hover', 'riode-core' ),
				'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			// Showing Info
			array(
				'type'        => 'riode_multiselect',
				'heading'     => esc_html__( 'Show Information', 'riode-core' ),
				'description' => esc_html__( 'Choose to show information of product: Category, Label, Price, Rating, Attribute, Cart, Compare, Quick view, Wishlist, Excerpt.', 'riode-core' ),
				'param_name'  => 'show_info',
				'value'       => array(
					esc_html__( 'Category', 'riode-core' ) => 'category',
					esc_html__( 'Label', 'riode-core' )    => 'label',
					esc_html__( 'Price', 'riode-core' )    => 'price',
					esc_html__( 'Rating', 'riode-core' )   => 'rating',
					esc_html__( 'Attribute', 'riode-core' ) => 'attribute',
					esc_html__( 'Add To Cart', 'riode-core' ) => 'addtocart',
					esc_html__( 'Compare', 'riode-core' )  => 'compare',
					esc_html__( 'Quickview', 'riode-core' ) => 'quickview',
					esc_html__( 'Wishlist', 'riode-core' ) => 'wishlist',
					esc_html__( 'Short Description', 'riode-core' ) => 'short_desc',
				),
				'std'         => 'category,label,price,rating,addtocart,compare,quickview,wishlist',
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),

			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Line Clamp', 'riode-core' ),
				'param_name' => 'desc_line_clamp',
				'value'      => '3',
				'selectors'  => array(
					'{{WRAPPER}} .short-desc p' => 'display: -webkit-box; -webkit-line-clamp: {{VALUE}}; -webkit-box-orient:vertical; overflow: hidden;',
				),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),

			// Showing Labels
			array(
				'type'        => 'riode_multiselect',
				'heading'     => esc_html__( 'Show Labels', 'riode-core' ),
				'description' => esc_html__( 'Select to show product labels on left part of product thumbnail: Top, Sale, New, Out of Stock, Custom labels.', 'riode-core' ),
				'param_name'  => 'show_labels',
				'value'       => array(
					esc_html__( 'Top', 'riode-core' )    => 'top',
					esc_html__( 'Sale', 'riode-core' )   => 'sale',
					esc_html__( 'new', 'riode-core' )    => 'new',
					esc_html__( 'Stock', 'riode-core' )  => 'stock',
					esc_html__( 'Custom', 'riode-core' ) => 'custom',
				),
				'std'         => 'top,sale,new,stock,custom',
			),

			array(
				'type'       => 'checkbox',
				'param_name' => 'hover_change',
				'heading'    => esc_html__( 'Change Image on Hover', 'riode-core' ),
				'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency' => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'content_align',
				'heading'     => esc_html__( 'Content Align', 'riode-core' ),
				'description' => esc_html__( 'Text alignment of product content: Left, Center, Right.', 'riode-core' ),
				'value'       => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'fas fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'fas fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'fas fa-align-right',
					),
				),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'addtocart_pos',
				'heading'     => esc_html__( 'Add to Cart Pos', 'riode-core' ),
				'description' => esc_html__( 'This option only works in default product type . ', 'riode-core' ),
				'value'       => array(
					esc_html__( 'On top of the image', 'riode-core' ) => 'default',
					esc_html__( 'On bottom of the image', 'riode-core' ) => 'bottom',
					esc_html__( '100% full width', 'riode-core' ) => 'detail_bottom',
					esc_html__( 'with QTY input', 'riode-core' ) => 'with_qty',
					esc_html__(
						'Don\'t show',
						'riode-core'
					) => 'hide',
				),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'std'         => 'default',
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'quickview_pos',
				'heading'     => esc_html__( 'Quickview Pos', 'riode-core' ),
				'description' => esc_html__( 'This option only works in default product type . ', 'riode-core' ),
				'value'       => array(
					esc_html__( 'On top of the image', 'riode-core' ) => 'default',
					esc_html__( 'On bottom of the image', 'riode-core' ) => 'bottom',
					esc_html__( 'Don\'t show', 'riode-core' ) => 'hide',
				),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'std'         => 'default',
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'wishlist_pos',
				'heading'     => esc_html__( 'Add to wishlist Pos', 'riode-core' ),
				'description' => esc_html__( 'This option only works in default product type . ', 'riode-core' ),
				'value'       => array(
					esc_html__( 'On top of the image', 'riode-core' ) => 'default',
					esc_html__( 'Under the image', 'riode-core' ) => 'bottom',
					esc_html__( 'Don\'t show', 'riode-core' ) => 'hide',
				),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'std'         => 'default',
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'show_progress_global',
				'heading'     => esc_html__( 'Use Progress Bar from Theme Option', 'riode-core' ),
				'description' => sprintf( esc_html__( 'Do you want to use progress bar setting from theme option? You can change progress bar options %1$shere.%2$s', 'riode-core' ), '<a href="' . wp_customize_url() . '#wf_sales_stock_bar" data-target="wf_sales_stock_bar" data-type="section" target="_blank">', '</a>' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			),
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'show_progress',
				'heading'     => esc_html__( 'Progress Bar for', 'riode-core' ),
				'description' => esc_html__( 'Choose what progress bar should mean: None, Sale count, Stock count.', 'riode-core' ),
				'value'       => array(
					'none'  => array(
						'title' => esc_html__( 'None', 'riode-core' ),
					),
					'sales' => array(
						'title' => esc_html__( 'Sales', 'riode-core' ),
					),
					'stock' => array(
						'title' => esc_html__( 'Stock', 'riode-core' ),
					),
				),
				'dependency'  => array(
					'element'            => 'show_progress_global',
					'value_not_equal_to' => 'yes',
				),
				'std'         => 'none',
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'count_text',
				'heading'     => esc_html__( 'Sales & Stock Text', 'riode-core' ),
				'description' => esc_html__( 'Please insert %1$s for sale count, %2$s for stock count. (e.g. %1$s sales, %2$s in stock)', 'riode-core' ),
				'dependency'  => array(
					'element'            => 'show_progress_global',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'riode_number',
				'param_name'  => 'low_stock_cnt',
				'heading'     => esc_html__( 'Default Low Stock Count', 'riode-core' ),
				'description' => esc_html__( 'Controls default low stock count that will be highlighted.', 'riode-core' ),
				'value'       => '10',
				'dependency'  => array(
					'element'            => 'show_progress_global',
					'value_not_equal_to' => 'yes',
				),
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_product_style_controls' ) ) {
	function riode_wpb_product_style_controls() {
		return array(
			// esc_html__( 'Category Filter Style', 'riode-core' ) => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Category Filter Style', 'riode-core' ),
					'param_name' => 'category-filter-style-ah',
				),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'filter_margin',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-filters' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'filter_padding',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-filters' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'filter_item_margin',
				'heading'    => esc_html__( 'Item Margin', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filters > li' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'filter_item_padding',
				'heading'    => esc_html__( 'Item Padding', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'cat_border_radius',
				'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter' => 'border-radius:{{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'cat_border_width',
				'heading'    => esc_html__( 'Border Width', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter' => 'border-style:solid;border-top-width:{{TOP}};border-right-width:{{RIGHT}};border-bottom-width:{{BOTTOM}};border-left-width:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'param_name' => 'filter_typography',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .nav-filter',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'param_name' => 'cat_align',
				'heading'    => esc_html__( 'Align', 'riode-core' ),
				'value'      => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'fas fa-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'fas fa-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'fas fa-align-right',
					),
				),
				'std'        => 'flex-start',
				'selectors'  => array(
					'{{WRAPPER}} .product-filters' => 'justify-content:{{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_color_group',
				'param_name' => 'content_colors',
				'heading'    => esc_html__( 'Colors', 'riode-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .nav-filter',
					'hover'  => '{{WRAPPER}} .nav-filter:hover',
					'active' => '{{WRAPPER}} .nav-filter.active',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			// ),
			// esc_html__( 'Product', 'riode-core' )    => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Product', 'riode-core' ),
					'param_name' => 'product-ah',
				),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'param_name' => 'product_padding',
				'selectors'  => array(
					'{{WRAPPER}} .product' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Border Width', 'riode-core' ),
				'param_name' => 'product_border',
				'selectors'  => array(
					'{{WRAPPER}} .product' => 'border-style: solid; border-top-width:{{TOP}};border-right-width:{{RIGHT}};border-bottom-width:{{BOTTOM}};border-left-width:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Border Color', 'riode-core' ),
				'param_name' => 'product_border_color',
				'selectors'  => array(
					'{{WRAPPER}} .product' => 'border-color:{{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Background Color', 'riode-core' ),
				'param_name' => 'product_bg_color',
				'selectors'  => array(
					'{{WRAPPER}} .product' => 'background-color:{{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Typorgaphy', 'riode-core' ),
				'param_name' => 'product_typography',
				'selectors'  => array(
					'{{WRAPPER}} .product',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Split Line Color', 'riode-core' ),
				'param_name' => 'product_split_color',
				'selectors'  => array(
					'{{WRAPPER}} .split-line .product-wrap' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .split-line .product-wrap::before' => 'border-color: {{VALUE}};',
				),
			),
			// ),
			// esc_html__( 'Content', 'riode-core' )    => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Content', 'riode-core' ),
					'param_name' => 'content-ah',
				),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'content_padding',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-details' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			// ),
			// esc_html__( 'Name', 'riode-core' )       => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Name', 'riode-core' ),
					'param_name' => 'name-ah',
				),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'product_name_margin',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-loop-product__title' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'param_name' => 'product_name_typo',
				'heading'    => esc_html__( 'Typorgaphy', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-loop-product__title',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'product_name_color',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-loop-product__title' => 'color: {{VALUE}};',
				),
			),
			// ),
			// esc_html__( 'Category', 'riode-core' )   => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Category', 'riode-core' ),
					'param_name' => 'category-ah',
				),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'product_cats_margin',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-cat' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'param_name' => 'product-cats_typo',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-cat',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'product_cats_color',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-cat' => 'color: {{VALUE}};',
				),
			),
			// ),
			// esc_html__( 'Price', 'riode-core' )      => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Price', 'riode-core' ),
					'param_name' => 'price-ah',
				),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'product_price_margin',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-loop .price' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'param_name' => 'product_price_typo',
				'heading'    => esc_html__( 'Typorgaphy', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-loop .price',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'product_price_color',
				'label'      => esc_html__( 'Price Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-loop .price' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'product_old_price_color',
				'label'      => esc_html__( 'Old Price Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-loop .price del' => 'color: {{VALUE}};',
				),
			),
			// ),
			// esc_html__( 'Rating', 'riode-core' )     => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Rating', 'riode-core' ),
					'param_name' => 'rating-ah',
				),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'product_rating_margin',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .woocommerce-product-rating' => 'margin-top:{{TOP}}margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'param_name' => 'product_rating_typo',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .star-rating',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'product_rating_color',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .star-rating span::after' => 'color: {{VALUE}};',
				),
			),
			// ),
			// esc_html__( 'Attributes', 'riode-core' ) => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Attributes', 'riode-core' ),
					'param_name' => 'attributes-ah',
				),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'product_attrs_margin',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-variations > *' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
					'{{WRAPPER}} .product-variations > *:last-child' => 'margin-right: 0;',
				),
			),
			array(
				'type'       => 'riode_number',
				'param_name' => 'product_attrs_width',
				'heading'    => esc_html__( 'Attribute Width', 'riode-core' ),
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .product-variations > *' => 'min-width: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'param_name' => 'product_attrs_height',
				'heading'    => esc_html__( 'Attribute Height', 'riode-core' ),
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .product-variations > *' => 'height: {{VALUE}}{{UNIT}};line-height: 0;vertical-align:middle;',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'product_attrs_border',
				'heading'    => esc_html__( 'Border Width', 'riode-core' ),
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .product-variations > *' => 'border-style: solid;border-top-width:{{TOP}};border-right-width:{{RIGHT}};border-bottom-width:{{BOTTOM}};border-left-width:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'product_attrs_border_color',
				'heading'    => esc_html__( 'Border Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-variations > *' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'product_attrs_color',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-variations > *' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'product_attrs_bg',
				'heading'    => esc_html__( 'Background Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .product-variations > *' => 'background-color: {{VALUE}};',
				),
			),
			// )
		);
	}
}
