<?php

/**
 * WooCommerce/Product Catalog
 */

Riode_Customizer::add_section(
	'woocommerce_product_catalog',
	array(
		'title'    => esc_html__( 'Shop Pages', 'riode' ),
		'panel'    => 'woocommerce',
		'priority' => 2,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'woocommerce_product_catalog',
		'type'     => 'custom',
		'settings' => 'cs_catalog_config_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Shop Configuration', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'woocommerce_product_catalog',
		'type'     => 'custom',
		'settings' => 'cs_catalog_grid_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Shop Grid', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'number',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'shop_listcount',
		'default'   => riode_get_option( 'shop_listcount' ),
		'label'     => esc_html__( 'List Type Products per row', 'riode' ),
		'tooltip'   => esc_html__( 'How many products should be shown per row when it is list view mode.', 'riode' ),
		'choices'   => array(
			'min' => 1,
			'max' => 2,
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'number',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'product_count_row',
		'default'   => riode_get_option( 'product_count_row' ),
		'label'     => esc_html__( 'Products per row', 'woocommerce' ),
		'tooltip'   => esc_html__( 'How many products should be shown per row?', 'woocommerce' ),
		'choices'   => array(
			'min' => 1,
			'max' => 8,
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'radio_buttonset',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'product_gap',
		'default'   => riode_get_option( 'product_gap' ),
		'label'     => esc_html__( 'Products Gap', 'riode' ),
		'tooltip'   => esc_html__( 'Change gap size between products', 'riode' ),
		'choices'   => array(
			'gutter-no' => esc_html__( 'No', 'riode' ),
			'gutter-xs' => esc_html__( 'XS', 'riode' ),
			'gutter-sm' => esc_html__( 'S', 'riode' ),
			'gutter-md' => esc_html__( 'M', 'riode' ),
			'gutter-lg' => esc_html__( 'L', 'riode' ),
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'show_cat_description',
		'default'   => riode_get_option( 'show_cat_description' ),
		'label'     => esc_html__( 'Show Category Description', 'riode' ),
		'tooltip'   => esc_html__( 'Show product category description on its category page.', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'simple_shop',
		'default'   => riode_get_option( 'simple_shop' ),
		'label'     => esc_html__( 'Simple Shop', 'riode' ),
		'tooltip'   => esc_html__( 'Show only basic information including image, name and price. The else will be hidden.', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'show_as_list_type',
		'default'   => riode_get_option( 'show_as_list_type' ),
		'label'     => esc_html__( 'Show as List Type.', 'riode' ),
		'tooltip'   => esc_html__( 'Show product as list type by default in shop page.', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'shop_toolbox_sticky',
		'default'   => riode_get_option( 'shop_toolbox_sticky' ),
		'label'     => esc_html__( 'Enable Sticky Toolbox on Mobile.', 'riode' ),
		'tooltip'   => esc_html__( 'Show sticky toolbox on mobile.', 'riode' ),
		'transport' => 'refresh',
	)
);


Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'radio_image',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'shop_loadmore_type',
		'default'   => riode_get_option( 'shop_loadmore_type' ),
		'label'     => esc_html__( 'Load More Type', 'riode' ),
		'tooltip'   => esc_html__( 'Select method to load more products.', 'riode' ),
		'choices'   => array(
			'button' => RIODE_CUSTOMIZER_IMG . '/loadmore_button.png',
			'page'   => RIODE_CUSTOMIZER_IMG . '/loadmore_page.png',
			'scroll' => RIODE_CUSTOMIZER_IMG . '/loadmore_scroll.png',
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'            => 'text',
		'section'         => 'woocommerce_product_catalog',
		'settings'        => 'shop_loadmore_label',
		'default'         => riode_get_option( 'shop_loadmore_label' ),
		'label'           => esc_html__( 'Loadmore Button Text', 'riode' ),
		'tooltip'         => esc_html__( 'Input loadmore button label.', 'riode' ),
		'transport'       => 'refresh',
		'active_callback' => array(
			array(
				'setting'  => 'shop_loadmore_type',
				'operator' => '==',
				'value'    => 'button',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'woocommerce_product_catalog',
		'type'     => 'custom',
		'settings' => 'cs_catalog_top_toolbox_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Shop Top Toolbox', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'multicheck',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'shop_top_toolbox_items',
		'default'   => riode_get_option( 'shop_top_toolbox_items' ),
		'label'     => esc_html__( 'Top Toolbox Items', 'riode' ),
		'tooltip'   => esc_html__( "Check items to show in shop page's top toolbox bar", 'riode' ),
		'transport' => 'refresh',
		'choices'   => array(
			'title'      => esc_html__( 'Page Title', 'riode' ),
			'res_count'  => esc_html__( 'Result Count of Products', 'riode' ),
			'sort_by'    => esc_html__( 'Sort By Selectbox', 'riode' ),
			'view_type'  => esc_html__( 'View Type Select', 'riode' ),
			'count_box'  => esc_html__( 'Per Page Select Box', 'riode' ),
			'cat_filter' => esc_html__( 'Category Filter', 'riode' ),
			'search'     => esc_html__( 'Toggle Type Search', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'text',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'shop_shownums',
		'default'   => riode_get_option( 'shop_shownums' ),
		'label'     => esc_html__( 'Per Page Select Options', 'riode' ),
		'tooltip'   => esc_html__( 'Please input comma separated integers. Every integers will be shown as option of select box in product archive page. Integer with prefix "_" will be default count. e.g: 9, _12, 24, 36', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'woocommerce_product_catalog',
		'type'     => 'custom',
		'settings' => 'cs_catalog_bottom_toolbox_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Shop Bottom Toolbox', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'multicheck',
		'section'   => 'woocommerce_product_catalog',
		'settings'  => 'shop_bottom_toolbox_items',
		'default'   => riode_get_option( 'shop_bottom_toolbox_items' ),
		'label'     => esc_html__( 'Bottom Toolbox Items', 'riode' ),
		'tooltip'   => esc_html__( "Check items to show in shop page's bottom toolbox bar", 'riode' ),
		'transport' => 'refresh',
		'choices'   => array(
			'res_count' => esc_html__( 'Result Count of Products', 'riode' ),
		),
	)
);
