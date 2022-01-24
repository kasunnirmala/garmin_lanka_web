<?php

if ( ! function_exists( 'riode_wpb_single_product_type_controls' ) ) {
	function riode_wpb_single_product_type_controls() {
		return array(
			array(
				'type'        => 'dropdown',
				'param_name'  => 'sp_title_tag',
				'heading'     => esc_html__( 'Title Tag', 'riode-core' ),
				'description' => esc_html__( 'Choose product name’s tag: H1, H2, H3, H4, H5, H6.', 'riode-core' ),
				'value'       => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				'std'         => 'h2',
			),
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'sp_gallery_type',
				'heading'     => esc_html__( 'Gallery Type', 'riode-core' ),
				'description' => esc_html__( 'Choose single product gallery type from 7 presets.', 'riode-core' ),
				'width'       => '250',
				'value'       => array(
					'normal'     => array(
						'image' => riode_get_customize_dir() . '/single-product/default.jpg',
						'title' => 'Default',
					),
					'default'    => array(
						'image' => riode_get_customize_dir() . '/single-product/vertical.jpg',
						'title' => 'Vertical',
					),
					'horizontal' => array(
						'image' => riode_get_customize_dir() . '/single-product/horizontal.jpg',
						'title' => 'Horizontal',
					),
					'grid'       => array(
						'image' => riode_get_customize_dir() . '/single-product/grid.jpg',
						'title' => 'Grid',
					),
					'masonry'    => array(
						'image' => riode_get_customize_dir() . '/single-product/masonry.jpg',
						'title' => 'Masonry',
					),
					'gallery'    => array(
						'image' => riode_get_customize_dir() . '/single-product/gallery.jpg',
						'title' => 'Gallery',
					),
					'rotate'     => array(
						'image' => riode_get_customize_dir() . '/single-product/rotate.jpg',
						'title' => 'Rotate',
					),
				),
				'std'         => 'normal',
			),
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'sp_sales_type',
				'heading'     => esc_html__( 'Sales Type', 'riode-core' ),
				'description' => esc_html__( 'Choose position of sale countdown: In Summary, In Gallery.', 'riode-core' ),
				'value'       => array(
					'default' => array(
						'title' => esc_html__( 'In Summary', 'riode-core' ),
					),
					'gallery' => array(
						'title' => esc_html__( 'In Gallery', 'riode-core' ),
					),
				),
				'std'         => 'default',
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'sp_sales_label',
				'description' => esc_html__( 'Controls sale countdown label.', 'riode-core' ),
				'heading'     => esc_html__( 'Sales Label', 'riode-core' ),
				'value'       => esc_html__( 'Flash Deals', 'riode-core' ),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'sp_vertical',
				'heading'     => esc_html__( 'Show Vertical', 'riode-core' ),
				'description' => esc_html__( 'Choose to show single product vertically.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element'            => 'sp_gallery_type',
					'value_not_equal_to' => 'gallery',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'sp_show_in_box',
				'heading'     => esc_html__( 'Show In Box', 'riode-core' ),
				'description' => esc_html__( 'Choose to show outline border around single product.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			),
			array(
				'type'        => 'riode_multiselect',
				'param_name'  => 'sp_show_info',
				'heading'     => esc_html__( 'Show Information', 'riode-core' ),
				'description' => esc_html__( 'Choose to show information of product: Category, Label, Price, Rating, Attribute, Cart, Compare, Quick view, Wishlist, Excerpt.', 'riode-core' ),
				'value'       => array(
					esc_html__( 'Gallery', 'riode-core' )  => 'gallery',
					esc_html__( 'Title', 'riode-core' )    => 'title',
					esc_html__( 'Meta', 'riode-core' )     => 'meta',
					esc_html__( 'Price', 'riode-core' )    => 'price',
					esc_html__( 'Rating', 'riode-core' )   => 'rating',
					esc_html__( 'Description', 'riode-core' ) => 'excerpt',
					esc_html__( 'Add To Cart Form', 'riode-core' ) => 'addtocart_form',
					esc_html__( 'Divider In Cart Form', 'riode-core' ) => 'divider',
					esc_html__( 'Share', 'riode-core' )    => 'share',
					esc_html__( 'Wishlist', 'riode-core' ) => 'wishlist',
					esc_html__( 'Compare', 'riode-core' )  => 'compare',
				),
				'std'         => 'gallery,title,meta,price,rating,excerpt,addtocart_form,divider,share,wishlist,compare',
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Columns', 'riode-core' ),
				'description' => esc_html__( 'Controls number of columns to display.', 'riode-core' ),
				'param_name'  => 'sp_col_cnt',
				'responsive'  => true,
				'dependency'  => array(
					'element' => 'sp_gallery_type',
					'value'   => array( 'grid', 'masonry', 'gallery' ),
				),
			),
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'sp_col_sp',
				'heading'     => esc_html__( 'Columns Spacing', 'riode-core' ),
				'description' => esc_html__( 'Controls amount of spacing between columns.', 'riode-core' ),
				'std'         => 'md',
				'value'       => array(
					'no' => array(
						'title' => esc_html__( 'No space', 'riode-core' ),
					),
					'xs' => array(
						'title' => esc_html__( 'Extra Small', 'riode-core' ),
					),
					'sm' => array(
						'title' => esc_html__( 'Small', 'riode-core' ),
					),
					'md' => array(
						'title' => esc_html__( 'Medium', 'riode-core' ),
					),
					'lg' => array(
						'title' => esc_html__( 'Large', 'riode-core' ),
					),
				),
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_single_product_style_controls' ) ) {
	function riode_wpb_single_product_style_controls() {
		return array(
			// esc_html__( 'Title', 'riode-core' )     => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Title', 'riode-core' ),
					'param_name' => 'title-ah',
				),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'sp_title_color',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the color of product title', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .product_title a' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'riode_typography',
				'param_name'  => 'sp_title_typo',
				'heading'     => esc_html__( 'Typography', 'riode-core' ),
				'description' => esc_html__( 'Controls the typography of product title.', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .product_title',
				),
			),
			// ),
			// esc_html__( 'Price', 'riode-core' )     => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Price', 'riode-core' ),
					'param_name' => 'price-ah',
				),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'sp_price_color',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the color of product price', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} p.price' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'riode_typography',
				'param_name'  => 'sp_price_typo',
				'heading'     => esc_html__( 'Typography', 'riode-core' ),
				'description' => esc_html__( 'Controls the typography of product price', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} p.price',
				),
			),
			// ),
			// esc_html__( 'Old Price', 'riode-core' ) => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Old Price', 'riode-core' ),
					'param_name' => 'old-price-ah',
				),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'sp_old_price_color',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the color of product old price', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} p.price del' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'riode_typography',
				'param_name'  => 'sp_old_price_typo',
				'heading'     => esc_html__( 'Typography', 'riode-core' ),
				'description' => esc_html__( 'Controls the typography of product old price', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} p.price del',
				),
			),
			// ),
			// esc_html__( 'Countdown', 'riode-core' ) => array(
				array(
					'type'       => 'riode_accordion_header',
					'heading'    => esc_html__( 'Countdown', 'riode-core' ),
					'param_name' => 'countdown-ah',
				),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'sp_countdown_color',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the color of product sale countdown.', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .product-countdown-container' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'        => 'riode_typography',
				'param_name'  => 'sp_countdown_typo',
				'heading'     => esc_html__( 'Typography', 'riode-core' ),
				'description' => esc_html__( 'Controls the typography of product sale countdown.', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .product-countdown-container',
				),
			),
		// ),
		);
	}
}

