<?php

/**
 * Blog/Post Type
 */

Riode_Customizer::add_section(
	'blog_post',
	array(
		'title' => esc_html__( 'Post Type', 'riode' ),
		'panel' => 'blog',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'blog_post',
		'type'     => 'custom',
		'settings' => 'cs_blog_post_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Post Type', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'radio_image',
		'section'   => 'blog_post',
		'settings'  => 'post_type',
		'label'     => esc_html__( 'Post Type', 'riode' ),
		'default'   => riode_get_option( 'post_type' ),
		'choices'   => array(
			''              => RIODE_CUSTOMIZER_IMG . '/post/default.jpg',
			'list'          => RIODE_CUSTOMIZER_IMG . '/post/list.jpg',
			'mask'          => RIODE_CUSTOMIZER_IMG . '/post/mask.jpg',
			'mask gradient' => RIODE_CUSTOMIZER_IMG . '/post/gradient.jpg',
			'framed'        => RIODE_CUSTOMIZER_IMG . '/post/framed.jpg',
			'overlap'       => RIODE_CUSTOMIZER_IMG . '/post/overlap.jpg',
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'select',
		'section'   => 'blog_post',
		'settings'  => 'post_overlay',
		'label'     => esc_html__( 'Post Overlay', 'riode' ),
		'default'   => riode_get_option( 'post_overlay' ),
		'tooltip'   => esc_html__( 'Select image overlay effect when mouse is over.', 'riode' ),
		'choices'   => array(
			''           => esc_html__( 'No', 'riode' ),
			'light'      => esc_html__( 'Light', 'riode' ),
			'dark'       => esc_html__( 'Dark', 'riode' ),
			'zoom'       => esc_html__( 'Zoom', 'riode' ),
			'zoom_light' => esc_html__( 'Zoom and Light', 'riode' ),
			'zoom_dark'  => esc_html__( 'Zoom and Dark', 'riode' ),
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'section'   => 'blog_post',
		'settings'  => 'post_show_datebox',
		'label'     => esc_html__( 'Show Date-Box on Image', 'riode' ),
		'default'   => riode_get_option( 'post_show_datebox' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'radio_buttonset',
		'section'   => 'blog_post',
		'settings'  => 'post_excerpt_type',
		'label'     => esc_html__( 'Excerpt Limit By', 'riode' ),
		'default'   => riode_get_option( 'post_excerpt_type' ),
		'choices'   => array(
			'words'     => esc_html__( 'Word', 'riode' ),
			'character' => esc_html__( 'Letter', 'riode' ),
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'number',
		'section'   => 'blog_post',
		'settings'  => 'post_excerpt_limit',
		'label'     => esc_html__( 'Excerpt Limit', 'riode' ),
		'default'   => riode_get_option( 'post_excerpt_limit' ),
		'transport' => 'refresh',
	)
);
