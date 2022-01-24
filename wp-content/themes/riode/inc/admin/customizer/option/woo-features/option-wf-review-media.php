<?php

/**
 * Woo Features/Review with Media
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_review_media',
	array(
		'title' => esc_html__( 'Review with Image, Video', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_review_media',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_review_media_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_review_media',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_review_media_description',
		'label'     => esc_html__( 'Customers can upload images or videos when they leave a comment for products.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/review-media-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_review_media',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_review_media',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'settings'  => 'product_media_review',
		'label'     => esc_html__( 'Enable This Feature', 'riode' ),
		'default'   => riode_get_option( 'product_media_review' ),
		'tooltip'   => esc_html__( 'Enable this option to use media review feature.', 'riode' ),
		'section'   => 'wf_review_media',
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'            => 'number',
		'section'         => 'wf_review_media',
		'settings'        => 'product_review_image_cnt',
		'default'         => riode_get_option( 'product_review_image_cnt' ),
		'label'           => esc_html__( 'Max Count of Images', 'riode' ),
		'tooltip'         => esc_html__( 'Set max number of images which customers can upload.', 'riode' ),
		'choices'         => array(
			'min' => 0,
			'max' => 4,
		),
		'active_callback' => array(
			array(
				'setting'  => 'product_media_review',
				'operator' => '==',
				'value'    => true,
			),
		),
		'transport'       => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'            => 'text',
		'section'         => 'wf_review_media',
		'settings'        => 'product_review_image_type',
		'default'         => riode_get_option( 'product_review_image_type' ),
		'label'           => esc_html__( 'Image File Types', 'riode' ),
		'tooltip'         => esc_html__( 'Input comma seperated image file types', 'riode' ),
		'placeholder'     => '.png, .jpg, .jpeg',
		'active_callback' => array(
			array(
				'setting'  => 'product_media_review',
				'operator' => '==',
				'value'    => true,
			),
		),
		'transport'       => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'            => 'number',
		'section'         => 'wf_review_media',
		'settings'        => 'product_review_video_cnt',
		'default'         => riode_get_option( 'product_review_video_cnt' ),
		'label'           => esc_html__( 'Max Count of Videos', 'riode' ),
		'tooltip'         => esc_html__( 'Set max number of videos which customers can upload.', 'riode' ),
		'choices'         => array(
			'min' => 0,
			'max' => 4,
		),
		'active_callback' => array(
			array(
				'setting'  => 'product_media_review',
				'operator' => '==',
				'value'    => true,
			),
		),
		'transport'       => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'            => 'text',
		'section'         => 'wf_review_media',
		'settings'        => 'product_review_video_type',
		'default'         => riode_get_option( 'product_review_video_type' ),
		'label'           => esc_html__( 'Video File Types', 'riode' ),
		'tooltip'         => esc_html__( 'Input comma seperated video file types', 'riode' ),
		'placeholder'     => '.avi, .mp4',
		'active_callback' => array(
			array(
				'setting'  => 'product_media_review',
				'operator' => '==',
				'value'    => true,
			),
		),
		'transport'       => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'            => 'number',
		'section'         => 'wf_review_media',
		'settings'        => 'product_review_max_size',
		'default'         => riode_get_option( 'product_review_max_size' ),
		'label'           => esc_html__( 'Max Size of Media Files (MB)', 'riode' ),
		'tooltip'         => esc_html__( 'Set max size of medias which customers can upload.', 'riode' ),
		'choices'         => array(
			'min' => 0,
			'max' => 20,
		),
		'active_callback' => array(
			array(
				'setting'  => 'product_media_review',
				'operator' => '==',
				'value'    => true,
			),
		),
		'transport'       => 'refresh',
	)
);
