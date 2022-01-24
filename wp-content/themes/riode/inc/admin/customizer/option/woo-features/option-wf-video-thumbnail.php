<?php

/**
 * Woo Features/Video Thumbnail
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_video_thumbnail',
	array(
		'title' => esc_html__( 'Video Thumbnail', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_video_thumbnail',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_video_thumbnail_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_video_thumbnail',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_video_thumbnail_description',
		'label'     => esc_html__( 'You could add video for product thumbnails except gallery images. Video might be helpful to give better details.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/video-thumbnail-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_video_thumbnail',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_video_thumbnail',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'settings'  => 'product_video_thumbnail',
		'label'     => esc_html__( 'Enable Video Thumbnail', 'riode' ),
		'default'   => riode_get_option( 'product_video_thumbnail' ),
		'tooltip'   => esc_html__( 'Enable this option to use video thumbnail feature in product detail page.', 'riode' ),
		'section'   => 'wf_video_thumbnail',
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_video_thumbnail',
		'type'            => 'custom',
		'settings'        => 'cs_woo_feature_video_thumbnail_guide',
		'label'           => '<p class="options-custom-description important-note">' . sprintf( esc_html__( '1. This feature needs %1$sMetabox%2$s plugin. If the required plugin is not installed yet, install it %3$shere%4$s.%5$s2. You could upload video or input video link in Riode Video Thumbnail widget settings of product edit page.', 'riode' ), '<b>', '</b>', '<a href="' . esc_url( admin_url( 'admin.php?page=riode-setup-wizard&step=default_plugins' ) ) . '" target="__blank">', '</a>', '<br>' ) . '</p>',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'product_video_thumbnail',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
