<?php

/**
 * Woo Features/Dokan, WCFM
 *
 * @since 1.0.3
 */

Riode_Customizer::add_section(
	'wf_vendor',
	array(
		'title'    => esc_html__( 'Vendor Plugins', 'riode' ),
		'panel'    => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_vendor',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_vendors_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_vendor',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_vendors_description',
		'label'     => esc_html__( "You can change settings about dashboard, shop, and other pages of Dokan and WCFM.", 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/vendors-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_vendor',
		'type'     => 'custom',
		'settings' => 'cs_wc_vendor_general_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'General', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'number',
		'section'   => 'wf_vendor',
		'settings'  => 'vendor_products_count_row',
		'default'   => riode_get_option( 'vendor_products_count_row' ),
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
		'section'  => 'wf_vendor',
		'type'     => 'custom',
		'settings' => 'cs_wc_dokan_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Dokan', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_vendor',
		'type'      => 'radio_buttonset',
		'settings'  => 'dokan_dashboard_style',
		'label'     => esc_html__( 'Vendor Dashboard Style', 'riode' ),
		'default'   => riode_get_option( 'dokan_dashboard_style' ),
		'tooltip'   => esc_html__( 'What would you like to style vendor dashboard page with? Choose from plugin or theme skin.', 'riode' ),
		'transport' => 'refresh',
		'choices'   => array(
			'dokan' => esc_html__( 'Dokan', 'riode' ),
			'theme' => esc_html__( 'Theme', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wf_vendor',
		'type'     => 'custom',
		'settings' => 'cs_wc_wcfm_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'WCFM', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'section'   => 'wf_vendor',
		'settings'  => 'single_product_hide_vendor_tab',
		'default'   => riode_get_option( 'single_product_hide_vendor_tab' ),
		'label'     => esc_html__( 'Hide Vendor Info Tab', 'riode' ),
		'tooltip'   => esc_html__( 'You can show or hide vendor info panel in product data tab.', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'            => 'text',
		'section'         => 'wf_vendor',
		'settings'        => 'single_product_vendor_info_title',
		'default'         => riode_get_option( 'single_product_vendor_info_title' ),
		'label'           => esc_html__( 'Vendor Info Title', 'riode' ),
		'tooltip'         => esc_html__( 'This option is for vendor info title in product data tab', 'riode' ),
		'active_callback' => array(
			array(
				'setting'  => 'single_product_hide_vendor_tab',
				'operator' => '!=',
				'value'    => true,
			),
		),
		'transport'       => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'section'   => 'wf_vendor',
		'settings'  => 'wcfm_show_sold_by_label',
		'default'   => riode_get_option( 'wcfm_show_sold_by_label' ),
		'label'     => esc_html__( 'Show Sold by Label', 'riode' ),
		'tooltip'   => esc_html__( 'You can show or hide sold by label in products.', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'text',
		'section'   => 'wf_vendor',
		'settings'  => 'wcfm_sold_by_label',
		'default'   => riode_get_option( 'wcfm_sold_by_label' ),
		'label'     => esc_html__( 'Sold by Label', 'riode' ),
		'tooltip'   => esc_html__( 'This option is for sold by label text in products.', 'riode' ),
		'transport' => 'refresh',
	)
);
