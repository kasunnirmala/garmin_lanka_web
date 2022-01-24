<?php

/**
 * Woo Features/Review Ordering ( Order/Filter )
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_review_ordering',
	array(
		'title' => esc_html__( 'Review Order/Filter', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_review_ordering',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_review_ordering_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_review_ordering',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_review_ordering_description',
		'label'     => esc_html__( 'Toolbox will be shown above product reviews section and customers can filter/order product reviews freely.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/review-ordering-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_review_ordering',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_review_ordering',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'settings'  => 'product_review_ordering',
		'label'     => esc_html__( 'Enable This Feature', 'riode' ),
		'default'   => riode_get_option( 'product_review_ordering' ),
		'tooltip'   => esc_html__( 'Enable this option to use review order/filter feature.', 'riode' ),
		'section'   => 'wf_review_ordering',
		'transport' => 'refresh',
	)
);
