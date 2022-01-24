<?php

/**
 * Woo Features/Quickview
 *
 * @since 1.4.0    moved into woo features panel
 */

Riode_Customizer::add_section(
	'wf_quickview',
	array(
		'title' => esc_html__( 'Product Quickview', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_quickview',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_quickivew_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_quickview',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_quickivew_description',
		'label'     => esc_html__( 'Each client has the opportunity to view product details without entering and being redirected to the product page.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/quickview-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_quickview',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_quickview',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_quickview',
		'type'      => 'radio_image',
		'settings'  => 'product_quickview_type',
		'label'     => esc_html__( 'Quickview Type', 'riode' ),
		'default'   => riode_get_option( 'product_quickview_type' ),
		'transport' => 'refresh',
		'tooltip'   => esc_html__( 'Select quickview type while your site is loading product details.', 'riode' ),
		'choices'   => array(
			'popup'     => RIODE_CUSTOMIZER_IMG . '/quickview-popup.png',
			'offcanvas' => RIODE_CUSTOMIZER_IMG . '/quickview-offcanvas.png',
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_quickview',
		'type'            => 'radio_buttonset',
		'settings'        => 'product_quickview_popup_loading',
		'label'           => esc_html__( 'Popup Loading Type', 'riode' ),
		'default'         => riode_get_option( 'product_quickview_popup_loading' ),
		'transport'       => 'refresh',
		'tooltip'         => esc_html__( 'Select appearance of quickview while your site is loading product details.', 'riode' ),
		'choices'         => array(
			'skeleton' => esc_html__( 'Skeleton', 'riode' ),
			'zoom'     => esc_html__( 'Zoom', 'riode' ),
			'loading'  => esc_html__( 'Loading', 'riode' ),
		),
		'description'     => sprintf( esc_html__( 'Skeleton type is available only if skeleton screen is enabled. You could enable skeleton screen in %1$sTheme Option > Advanced > Theme Features%2$s', 'riode' ), '<a href="#" data-target="feature">', '</a>' ),
		'active_callback' => array(
			array(
				'setting'  => 'product_quickview_type',
				'operator' => '==',
				'value'    => 'popup',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_quickview',
		'type'            => 'radio_buttonset',
		'settings'        => 'product_quickview_offcanvas_loading',
		'label'           => esc_html__( 'Offcanvas Loading Type', 'riode' ),
		'default'         => riode_get_option( 'product_quickview_offcanvas_loading' ),
		'transport'       => 'refresh',
		'tooltip'         => esc_html__( 'Select appearance of quickview while your site is loading product details.', 'riode' ),
		'choices'         => array(
			'skeleton' => esc_html__( 'Skeleton', 'riode' ),
			'loading'  => esc_html__( 'Loading', 'riode' ),
		),
		'description'     => sprintf( esc_html__( 'Skeleton type is available only if skeleton screen is enabled. You could enable skeleton screen in %1$sTheme Option > Advanced > Theme Features%2$s', 'riode' ), '<a href="#" data-target="feature">', '</a>' ),
		'active_callback' => array(
			array(
				'setting'  => 'product_quickview_type',
				'operator' => '==',
				'value'    => 'offcanvas',
			),
		),
	)
);
