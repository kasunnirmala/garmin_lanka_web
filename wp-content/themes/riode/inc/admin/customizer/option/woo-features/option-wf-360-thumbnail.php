<?php

/**
 * Woo Features/360 Degree Thumbnail
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_360_thumbnail',
	array(
		'title' => esc_html__( '360 Degree Thumbnail', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_360_thumbnail',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_360_thumbnail_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_360_thumbnail',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_360_thumbnail_description',
		'label'     => esc_html__( 'You could add 360 degree thumbnail which has several images taken in various angles for product thumbnails except gallery images.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/360-thumbnail-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_360_thumbnail',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_360_thumbnail',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'        => 'toggle',
		'settings'    => 'product_360_thumbnail',
		'label'       => esc_html__( 'Enable 360 Degree Thumbnail', 'riode' ),
		'default'     => riode_get_option( 'product_360_thumbnail' ),
		'tooltip'     => esc_html__( 'Enable this option to use 360 degree thumbnail feature in product detail page.', 'riode' ),
		'section'     => 'wf_360_thumbnail',
		'transport'   => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_360_thumbnail',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_360_thumbnail_guide',
		'label'   => '<p class="options-custom-description important-note">' . sprintf( esc_html__( '1. This feature needs %1$sMetabox%2$s plugin. If the required plugin is not installed yet, install it %3$shere%4$s.%5$s2. You could upload 360 degree images in Riode 360 Degree Thumbnail widget settings of product edit page.', 'riode' ), '<b>', '</b>', '<a href="' . esc_url( admin_url( 'admin.php?page=riode-setup-wizard&step=default_plugins' ) ) . '" target="__blank">', '</a>', '<br>' ) . '</p>',
		'transport' => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'product_360_thumbnail',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
