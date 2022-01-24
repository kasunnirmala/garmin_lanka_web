<?php

/**
 * Woo Features/Custom Description Tabs
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_custom_description_tab',
	array(
		'title' => esc_html__( 'Custom Description Tab', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_custom_description_tab',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_cdt_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_custom_description_tab',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_cdt_description',
		'label'     => esc_html__( 'Riode offers 2 more description tabs except global description tab for each product.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/description-tab-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_custom_description_tab',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_cdt',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'settings'  => 'product_cdt',
		'label'     => esc_html__( 'Enable Custom Description Tabs', 'riode' ),
		'default'   => riode_get_option( 'product_cdt' ),
		'tooltip'   => esc_html__( 'Enable this option to use custom description tabs feature in single product page.', 'riode' ),
		'section'   => 'wf_custom_description_tab',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_custom_description_tab',
		'type'            => 'custom',
		'settings'        => 'cs_woo_feature_cdt_guide',
		'label'           => '<p class="options-custom-description important-note">' . esc_html__( 'You could input tab title and content in product data settings of product edit page.', 'riode' ) . '</p>',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'product_cdt',
				'operator' => '!=',
				'value'    => '',
			),
		),
	)
);
