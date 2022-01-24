<?php

/**
 * Woo Features/Live Search
 *
 * @since 1.4.0    moved into woo features panel
 */

Riode_Customizer::add_section(
	'wf_live_search',
	array(
		'title' => esc_html__( 'Live Search', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_live_search',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_live_search_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_live_search',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_live_search_description',
		'label'     => esc_html__( 'Without redirecting or entering search results page, you can get the results instantly and quickly.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/live-search-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_live_search',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_live_search',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_live_search',
		'type'      => 'toggle',
		'settings'  => 'live_search',
		'label'     => esc_html__( 'Enable Live Search', 'riode' ),
		'tooltip'   => esc_html__( 'Enable this option to use live search feature in your site.', 'riode' ),
		'default'   => riode_get_option( 'live_search' ),
		'transport' => 'postMessage',
	)
);
