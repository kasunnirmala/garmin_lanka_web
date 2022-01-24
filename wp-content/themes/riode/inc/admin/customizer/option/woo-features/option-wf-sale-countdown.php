<?php

/**
 * Woo Features/Sale Countdown over Product Image
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_sale_countdown',
	array(
		'title' => esc_html__( 'Product Sale Countdown', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sale_countdown',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_sale_countdown_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sale_countdown',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_sale_countdown_description',
		'label'     => esc_html__( 'Sale countdown box will be shown above thumbnail images of on-sale products', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/sale-countdown-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sale_countdown',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_sale_countdown',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sale_countdown',
		'type'      => 'radio_image',
		'settings'  => 'product_sale_countdown_type',
		'label'     => esc_html__( 'Sale Countdown Type', 'riode' ),
		'default'   => riode_get_option( 'product_sale_countdown_type' ),
		'tooltip'   => esc_html__( 'Select countdown box type. Choose from None, Box Type, Inline Type', 'riode' ),
		'transport' => 'refresh',
		'choices'   => array(
			''       => RIODE_CUSTOMIZER_IMG . '/description-images/sale-countdown-2.png',
			'box'    => RIODE_CUSTOMIZER_IMG . '/description-images/sale-countdown-3.png',
			'inline' => RIODE_CUSTOMIZER_IMG . '/description-images/sale-countdown-4.png',
		),
	)
);
