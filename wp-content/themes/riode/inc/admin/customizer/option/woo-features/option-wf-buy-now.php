<?php

/**
 * Woo Features/Buy Now
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_buy_now',
	array(
		'title' => esc_html__( 'Buy Now', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_buy_now',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_buy_now_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_buy_now',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_buy_now_description',
		'label'     => esc_html__( 'Buy Now feature allows you to checkout products directly without passing through cart page.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/buy-now-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_buy_now',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_buy_now',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'        => 'toggle',
		'settings'    => 'product_buy_now',
		'label'       => esc_html__( 'Enable Buy Now', 'riode' ),
		'default'     => riode_get_option( 'product_buy_now' ),
		'tooltip'     => esc_html__( 'Enable this option to use buy now feature.', 'riode' ),
		'section'     => 'wf_buy_now',
		'transport'   => 'refresh',
	)
);
