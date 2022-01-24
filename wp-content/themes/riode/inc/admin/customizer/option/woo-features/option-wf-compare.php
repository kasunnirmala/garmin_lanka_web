<?php

/**
 * Woo Features/Compare
 *
 * @since 1.4.0    moved into woo features panel
 */

Riode_Customizer::add_section(
	'wf_compare',
	array(
		'title' => esc_html__( 'Compare', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_compare',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_compare_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_compare',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_compare_description',
		'label'     => esc_html__( 'Riode uses its own compare feature not YITH Compare Plugin. We offer compare popup, compare page, compare mini list and other niche features.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/compare-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_compare',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_compare',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'        => 'toggle',
		'settings'    => 'product_compare',
		'label'       => esc_html__( 'Enable Product Compare', 'riode' ),
		'default'     => riode_get_option( 'product_compare' ),
		'tooltip'     => esc_html__( 'Enable this option to use compare feature in your site.', 'riode' ),
		'section'     => 'wf_compare',
		'transport'   => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_compare',
		'type'            => 'custom',
		'settings'        => 'cs_woo_feature_compare_guide',
		'label'           => '<p class="options-custom-description important-note">' . esc_html__( 'Please make sure that you deactivate YITH compare plugin for full working.', 'riode' ) . '</p>',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'product_compare',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
