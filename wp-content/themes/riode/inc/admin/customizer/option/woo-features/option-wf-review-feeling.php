<?php

/**
 * Woo Features/Review Feeling ( Like/Unlike )
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_review_feeling',
	array(
		'title' => esc_html__( 'Review Like/Unlike', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_review_feeling',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_review_feeling_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_review_feeling',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_review_feeling_description',
		'label'     => esc_html__( 'Customers can show their feeling about each product reviews with like & unlike buttons.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/review-feeling-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_review_feeling',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_review_feeling',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'settings'  => 'product_review_feeling',
		'label'     => esc_html__( 'Enable This Feature', 'riode' ),
		'default'   => riode_get_option( 'product_review_feeling' ),
		'tooltip'   => esc_html__( 'Enable this option to use review feeling feature.', 'riode' ),
		'section'   => 'wf_review_feeling',
		'transport' => 'refresh',
	)
);
