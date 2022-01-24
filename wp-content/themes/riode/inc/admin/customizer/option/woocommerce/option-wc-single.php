<?php

/**
 * WooCommerce/Product Catalog
 */

Riode_Customizer::add_section(
	'wc_single_product',
	array(
		'title'    => esc_html__( 'Product Detail Page', 'riode' ),
		'panel'    => 'woocommerce',
		'priority' => 3,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wc_single_product',
		'type'     => 'custom',
		'settings' => 'cs_single_product_type_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Single Product Type', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'radio_image',
		'section'   => 'wc_single_product',
		'settings'  => 'single_product_type',
		'label'     => esc_html__( 'Single Product Type', 'riode' ),
		'default'   => riode_get_option( 'single_product_type' ),
		'tooltip'   => esc_html__( 'Use supported single product preset or build your own. You can build your own product page with Riode Template Builder. Please visit products menu of Riode demos to get complete understanding of each presets.', 'riode' ),
		'choices'   => array(
			'default'     => RIODE_CUSTOMIZER_IMG . '/single-product/default.jpg',
			'horizontal'  => RIODE_CUSTOMIZER_IMG . '/single-product/horizontal.jpg',
			'grid'        => RIODE_CUSTOMIZER_IMG . '/single-product/grid.jpg',
			'masonry'     => RIODE_CUSTOMIZER_IMG . '/single-product/masonry.jpg',
			'gallery'     => RIODE_CUSTOMIZER_IMG . '/single-product/gallery.jpg',
			'sticky-info' => RIODE_CUSTOMIZER_IMG . '/single-product/sticky.jpg',
			'sticky-both' => RIODE_CUSTOMIZER_IMG . '/single-product/sticky-both.jpg',
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'     => 'custom',
		'section'  => 'wc_single_product',
		'settings' => 'cs_empty_product_template_desc',
		'default'  => sprintf( esc_html__( 'You could build your product layout with %1$sSingle Product Builder%2$s', 'riode' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=product_layout' ) ) . '" target="_blank">', '</a>' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'select',
		'section'   => 'wc_single_product',
		'settings'  => 'single_product_breadcrumb_pos',
		'default'   => riode_get_option( 'single_product_breadcrumb_pos' ),
		'label'     => esc_html__( 'Breadcrumb + Navigation Position', 'riode' ),
		'tooltip'   => esc_html__( 'This option is for breadcrumb and navigation position in single product page.', 'riode' ),
		'choices'   => array(
			''     => esc_html__( 'Default', 'riode' ),
			'top'  => esc_html__( 'On Top', 'riode' ),
			'hide' => esc_html__( 'Hide', 'riode' ),
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'select',
		'section'   => 'wc_single_product',
		'settings'  => 'single_product_tab_type',
		'label'     => esc_html__( 'Data Tab Type', 'riode' ),
		'default'   => riode_get_option( 'single_product_tab_type' ),
		'tooltip'   => esc_html__( 'You could select tab or accordion type of product data tab. Data tab includes description, additional information and reviews by default. However you could add some more.', 'riode' ),
		'choices'   => array(
			'tab'       => esc_html__( 'Tab', 'riode' ),
			'accordion' => esc_html__( 'Accordion', 'riode' ),
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'section'   => 'wc_single_product',
		'settings'  => 'single_product_cart_sticky',
		'label'     => esc_html__( 'Cart Sticky', 'riode' ),
		'default'   => riode_get_option( 'single_product_cart_sticky' ),
		'tooltip'   => esc_html__( 'Add to cart area will be sticky while scrolling to make visitors easy to buy.', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'section'   => 'wc_single_product',
		'settings'  => 'single_product_tab_inside',
		'label'     => esc_html__( 'Data Tab Inside', 'riode' ),
		'default'   => riode_get_option( 'single_product_tab_inside' ),
		'tooltip'   => esc_html__( 'Do you want place product data tab inside product information column?', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wc_single_product',
		'type'     => 'custom',
		'settings' => 'cs_product_tab_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Global Additional Data Tab', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_single_product',
		'type'      => 'text',
		'settings'  => 'single_product_tab_title',
		'label'     => esc_html__( 'Custom Tab Title', 'riode' ),
		'tooltip'   => esc_html__( 'This is global data tab and will be shown all product detail pages.', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'single_product_tab_title' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_single_product',
		'type'      => 'select',
		'settings'  => 'single_product_tab_block',
		'label'     => esc_html__( 'Custom Tab Content Block', 'riode' ),
		'tooltip'   => esc_html__( 'Please select global additional product data tab.', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'single_product_tab_block' ),
		'choices'   => array( '' => esc_html__( 'Select Block', 'riode' ) ) + Riode_Customizer::get_templates( 'block' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wc_single_product',
		'type'     => 'custom',
		'settings' => 'cs_product_related_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Related Products', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'number',
		'section'   => 'wc_single_product',
		'settings'  => 'single_product_related_count',
		'default'   => riode_get_option( 'single_product_related_count' ),
		'label'     => esc_html__( 'Count of Related Products', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'number',
		'section'   => 'wc_single_product',
		'settings'  => 'single_product_related_per_row',
		'default'   => riode_get_option( 'single_product_related_per_row' ),
		'label'     => esc_html__( 'Related Products per Row', 'riode' ),
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
		'section'   => 'wc_single_product',
		'type'      => 'select',
		'settings'  => 'single_product_related_orderby',
		'label'     => esc_html__( 'Order By', 'riode' ),
		'default'   => riode_get_option( 'single_product_related_orderby' ),
		'transport' => 'refresh',
		'choices'   => array(
			''              => esc_html__( 'Default', 'riode' ),
			'ID'            => esc_html__( 'ID', 'riode' ),
			'title'         => esc_html__( 'Name', 'riode' ),
			'date'          => esc_html__( 'Date', 'riode' ),
			'modified'      => esc_html__( 'Modified', 'riode' ),
			'price'         => esc_html__( 'Price', 'riode' ),
			'rand'          => esc_html__( 'Random', 'riode' ),
			'rating'        => esc_html__( 'Rating', 'riode' ),
			'comment_count' => esc_html__( 'Comment count', 'riode' ),
			'popularity'    => esc_html__( 'Total Sales', 'riode' ),
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_single_product',
		'type'      => 'select',
		'settings'  => 'single_product_related_orderway',
		'label'     => esc_html__( 'Order Way', 'riode' ),
		'default'   => riode_get_option( 'single_product_related_orderway' ),
		'transport' => 'refresh',
		'choices'   => array(
			''    => esc_html__( 'Descending', 'riode' ),
			'ASC' => esc_html__( 'Ascending', 'riode' ),
		),
		'transport' => 'refresh',
	)
);
