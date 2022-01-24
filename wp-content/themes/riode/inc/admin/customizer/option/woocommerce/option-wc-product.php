<?php

/**
 * WooCommerce/Product Type
 */

Riode_Customizer::add_section(
	'wc_product',
	array(
		'title'    => esc_html__( 'Product Type', 'riode' ),
		'panel'    => 'woocommerce',
		'priority' => 6,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wc_product',
		'type'     => 'custom',
		'settings' => 'cs_product_type_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Product Type', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_product',
		'type'      => 'radio_image',
		'settings'  => 'product_type',
		'label'     => esc_html__( 'Product Type', 'riode' ),
		'default'   => riode_get_option( 'product_type' ),
		'transport' => 'refresh',
		'choices'   => array(
			''        => RIODE_CUSTOMIZER_IMG . '/product1.png',
			'classic' => RIODE_CUSTOMIZER_IMG . '/product2.png',
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wc_product',
		'type'            => 'select',
		'settings'        => 'product_classic_hover',
		'label'           => esc_html__( 'Hover Effect', 'riode' ),
		'default'         => riode_get_option( 'product_classic_hover' ),
		'transport'       => 'refresh',
		'choices'         => array(
			''        => esc_html__( 'Default', 'riode' ),
			'popup'   => esc_html__( 'Popup', 'riode' ),
			'slideup' => esc_html__( 'Slide Up', 'riode' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'product_type',
				'operator' => '==',
				'value'    => 'classic',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wc_product',
		'type'            => 'radio_image',
		'settings'        => 'product_addtocart_pos',
		'label'           => esc_html__( 'Add To Cart Position', 'riode' ),
		'default'         => riode_get_option( 'product_addtocart_pos' ),
		'transport'       => 'refresh',
		'tooltip'         => esc_html__( "Change add to cart button's position. Cart button will be placed in blue filled area.", 'riode' ),
		'choices'         => array(
			''              => RIODE_CUSTOMIZER_IMG . '/product_pos1.png',
			'bottom'        => RIODE_CUSTOMIZER_IMG . '/product_pos2.png',
			'detail_bottom' => RIODE_CUSTOMIZER_IMG . '/product_pos4.png',
			'with_qty'      => RIODE_CUSTOMIZER_IMG . '/product_pos5.png',
		),
		'active_callback' => array(
			array(
				'setting'  => 'product_type',
				'operator' => '==',
				'value'    => '',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wc_product',
		'type'            => 'radio_image',
		'settings'        => 'product_quickview_pos',
		'label'           => esc_html__( 'Quickview Position', 'riode' ),
		'default'         => riode_get_option( 'product_quickview_pos' ),
		'transport'       => 'refresh',
		'tooltip'         => esc_html__( "Change quickview button's position. Quickview button will be placed in blue filled area.", 'riode' ),
		'choices'         => array(
			''       => RIODE_CUSTOMIZER_IMG . '/product_pos1.png',
			'bottom' => RIODE_CUSTOMIZER_IMG . '/product_pos2.png',
		),
		'active_callback' => array(
			array(
				'setting'  => 'product_type',
				'operator' => '==',
				'value'    => '',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wc_product',
		'type'            => 'radio_image',
		'settings'        => 'product_wishlist_pos',
		'label'           => esc_html__( 'Add To Wishlist Position', 'riode' ),
		'default'         => riode_get_option( 'product_wishlist_pos' ),
		'transport'       => 'refresh',
		'tooltip'         => esc_html__( "Change wishlist button's position. Wishlist button will be placed in blue filled area.", 'riode' ),
		'choices'         => array(
			''       => RIODE_CUSTOMIZER_IMG . '/product_pos1.png',
			'bottom' => RIODE_CUSTOMIZER_IMG . '/product_pos3.png',
		),
		'active_callback' => array(
			array(
				'setting'  => 'product_type',
				'operator' => '==',
				'value'    => '',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_product',
		'type'      => 'radio_buttonset',
		'settings'  => 'product_content_align',
		'label'     => esc_html__( 'Content Align', 'riode' ),
		'default'   => riode_get_option( 'product_content_align' ),
		'transport' => 'refresh',
		'choices'   => array(
			'left'   => esc_html__( 'Left', 'riode' ),
			'center' => esc_html__( 'Center', 'riode' ),
			'right'  => esc_html__( 'Right', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_product',
		'type'      => 'toggle',
		'settings'  => 'product_show_in_box',
		'label'     => esc_html__( 'Show In Box', 'riode' ),
		'tooltip'   => esc_html__( 'Products will be shown inside boxes. You can see each products have border around them.', 'riode' ),
		'default'   => riode_get_option( 'product_show_in_box' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_product',
		'type'      => 'toggle',
		'settings'  => 'product_show_reviews_text',
		'label'     => esc_html__( 'Show Review Text', 'riode' ),
		'default'   => riode_get_option( 'product_show_reviews_text' ),
		'tooltip'   => esc_html__( 'Review link will be shown like ( * reviews ).', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_product',
		'type'      => 'toggle',
		'settings'  => 'product_split_line',
		'label'     => esc_html__( 'Show Split Line', 'riode' ),
		'tooltip'   => esc_html__( 'Vertical and Horizontal dividers will be shown between products. If you set this option, gap option does not work in product layout.', 'riode' ),
		'default'   => riode_get_option( 'product_split_line' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wc_product',
		'type'     => 'custom',
		'settings' => 'cs_product_info_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Showing Information', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_product',
		'type'      => 'multicheck',
		'settings'  => 'product_show_info',
		'label'     => esc_html__( 'Items to show', 'riode' ),
		'default'   => riode_get_option( 'product_show_info' ),
		'choices'   => array(
			'category'  => esc_html__( 'Category', 'riode' ),
			'label'     => esc_html__( 'Label', 'riode' ),
			'price'     => esc_html__( 'Price', 'riode' ),
			'rating'    => esc_html__( 'Rating', 'riode' ),
			'attribute' => esc_html__( 'Attributes', 'riode' ),
			'addtocart' => esc_html__( 'Add To Cart', 'riode' ),
			'compare'   => esc_html__( 'Compare', 'riode' ),
			'quickview' => esc_html__( 'Quickview', 'riode' ),
			'wishlist'  => esc_html__( 'Wishlist', 'riode' ),
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wc_product',
		'type'     => 'custom',
		'settings' => 'cs_product_hover_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Hover Effects', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wc_product',
		'type'            => 'toggle',
		'settings'        => 'product_show_hover_shadow',
		'label'           => esc_html__( 'Box shadow on Hover', 'riode' ),
		'default'         => riode_get_option( 'product_show_hover_shadow' ),
		'transport'       => 'refresh',
		'tooltip'         => esc_html__( 'Show shadow of product when mouse is over.', 'riode' ),
		'active_callback' => array(
			array(
				'setting'  => 'product_type',
				'operator' => '==',
				'value'    => '',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_product',
		'type'      => 'toggle',
		'settings'  => 'product_show_media_shadow',
		'label'     => esc_html__( 'Media Shadow Effect on Hover', 'riode' ),
		'tooltip'   => esc_html__( 'Show shadow of Product Image when mouse is over.', 'riode' ),
		'default'   => riode_get_option( 'product_show_media_shadow' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_product',
		'type'      => 'toggle',
		'settings'  => 'product_hover_change',
		'label'     => esc_html__( 'Change Image on Hover', 'riode' ),
		'default'   => riode_get_option( 'product_hover_change' ),
		'tooltip'   => esc_html__( 'Show second product image when mouse is over. You could change this option for individual products', 'riode' ),
		'transport' => 'refresh',
	)
);
