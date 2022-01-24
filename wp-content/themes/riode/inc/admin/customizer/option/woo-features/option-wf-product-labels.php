<?php

/**
 * Woo Features/Product Labels
 *
 * @since 1.4.0    moved into woo features panel
 */

Riode_Customizer::add_section(
	'wf_product_labels',
	array(
		'title' => esc_html__( 'Product Labels', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_product_labels',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_product_labels_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_product_labels',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_product_labels_description',
		'label'     => esc_html__( "Product labels are shown at the top left corner of product image to notice product's current status.", 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/product-labels-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'custom',
		'settings' => 'cs_product_top_label',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Featured Product Label', 'riode' ) . '</h3>',
		'tooltip'  => esc_html__( 'Here, you can change label settings of featured products.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'text',
		'settings' => 'product_top_label',
		'label'    => esc_html__( 'Label Text', 'riode' ),
		'default'  => riode_get_option( 'product_top_label' ),
		'tooltip'  => esc_html__( 'Please insert custom label for your featured products.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_product_labels',
		'type'      => 'color',
		'settings'  => 'product_top_label_bg_color',
		'label'     => esc_html__( 'Label Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'product_top_label_bg_color' ),
		'transport' => 'postMessage',
		'tooltip'   => esc_html__( 'Please choose background color for your featured label.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'custom',
		'settings' => 'cs_product_sale_label',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Sale Product Label', 'riode' ) . '</h3>',
		'tooltip'  => esc_html__( 'Here, you can change label settings of on-sale products.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'text',
		'settings' => 'product_sale_label',
		'label'    => esc_html__( 'Label Text', 'riode' ),
		'default'  => riode_get_option( 'product_sale_label' ),
		'tooltip'  => esc_html__( 'Please insert custom label for your sale products. Your custom label should be kept some format(ex: %percent% Off).', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_product_labels',
		'type'      => 'color',
		'settings'  => 'product_sale_label_bg_color',
		'label'     => esc_html__( 'Label Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'product_sale_label_bg_color' ),
		'transport' => 'postMessage',
		'tooltip'   => esc_html__( 'Please choose background color for your sale label.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'custom',
		'settings' => 'cs_product_out_of_stock_label',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Out Of Stock Product Label', 'riode' ) . '</h3>',
		'tooltip'  => esc_html__( 'Here, you can change label settings of out-of-stock products.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'text',
		'settings' => 'product_stock_label',
		'label'    => esc_html__( 'Label Text', 'riode' ),
		'default'  => riode_get_option( 'product_stock_label' ),
		'tooltip'  => esc_html__( 'Please insert custom label for your out of stock products.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_product_labels',
		'type'      => 'color',
		'settings'  => 'product_stock_label_bg_color',
		'label'     => esc_html__( 'Label Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'product_stock_label_bg_color' ),
		'transport' => 'postMessage',
		'tooltip'   => esc_html__( 'Please choose custom background color for your stock label.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'custom',
		'settings' => 'cs_product_new_label',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'New Product Label', 'riode' ) . '</h3>',
		'tooltip'  => esc_html__( 'Here, you can change label settings of new products.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'number',
		'settings' => 'product_period',
		'label'    => esc_html__( 'New Product Period ( days )', 'riode' ),
		'default'  => riode_get_option( 'product_period' ),
		'tooltip'  => esc_html__( 'After this period, product is not new anymore and new label will be removed. Insert value should be number( ex: 1, 30, 160... )', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'text',
		'settings' => 'product_new_label',
		'label'    => esc_html__( 'Label Text', 'riode' ),
		'default'  => riode_get_option( 'product_new_label' ),
		'tooltip'  => esc_html__( 'Please insert custom label for your new products.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_product_labels',
		'type'      => 'color',
		'settings'  => 'product_new_label_bg_color',
		'label'     => esc_html__( 'Label Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'product_new_label_bg_color' ),
		'transport' => 'postMessage',
		'tooltip'   => esc_html__( 'Please choose background color for new product label.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'custom',
		'settings' => 'cs_product_thumbnail_label',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Thumbnail Type Label', 'riode' ) . '</h3>',
		'tooltip'  => esc_html__( 'Thumbnail type labels show if certain product has special type of thumbnail like video and 360 degree.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_product_labels',
		'type'      => 'color',
		'settings'  => 'product_thumbnail_label_bg_color',
		'label'     => esc_html__( 'Label Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'product_thumbnail_label_bg_color' ),
		'transport' => 'postMessage',
		'tooltip'   => esc_html__( 'Please choose custom background color for product thumbnail type label.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_product_labels',
		'type'     => 'custom',
		'settings' => 'cs_product_custom_label',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Custom Labels', 'riode' ) . '</h3>',
		'tooltip'  => esc_html__( 'You can use not only ordinary product labels but also custom product labels. It will make your products unique than others.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_product_labels',
		'type'      => 'toggle',
		'settings'  => 'product_custom_label',
		'label'     => esc_html__( 'Enable Custom Labels', 'riode' ),
		'default'   => riode_get_option( 'product_custom_label' ),
		'tooltip'   => esc_html__( 'Enable this option to use custom product labels for products.', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_product_labels',
		'type'            => 'custom',
		'settings'        => 'cs_woo_feature_custom_labels_guide',
		'label'           => '<p class="options-custom-description important-note">' . esc_html__( 'You could add custom labels and change label colors for each products in product data settings of product edit page.', 'riode' ) . '</p>',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'product_custom_label',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
