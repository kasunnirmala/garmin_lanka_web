<?php

/**
 * Blog/Blog Archive
 */

Riode_Customizer::add_section(
	'blog_archive',
	array(
		'title' => esc_html__( 'Blog Page', 'riode' ),
		'panel' => 'blog',
		'priority' => 9,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'blog_archive',
		'type'     => 'custom',
		'settings' => 'cs_blog_archive_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Blog Archive', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'radio_buttonset',
		'section'   => 'blog_archive',
		'settings'  => 'post_grid',
		'label'     => esc_html__( 'Posts Grid', 'riode' ),
		'default'   => riode_get_option( 'post_grid' ),
		'choices'   => array(
			'grid'     => esc_html__( 'Grid', 'riode' ),
			'creative' => esc_html__( 'Masonry', 'riode' ),
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'number',
		'section'   => 'blog_archive',
		'settings'  => 'post_count_row',
		'default'   => riode_get_option( 'post_count_row' ),
		'label'     => esc_html__( 'Posts per row', 'riode' ),
		'tooltip'   => esc_html__( 'How many posts should be shown per row?', 'riode' ),
		'choices'   => array(
			'min' => 1,
			'max' => 8,
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'section'   => 'blog_archive',
		'settings'  => 'post_show_filter',
		'default'   => riode_get_option( 'post_show_filter' ),
		'label'     => esc_html__( 'Show Category Filter', 'riode' ),
		'tooltip'   => esc_html__( 'Show post category filter on top of post archive page.', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'radio_image',
		'section'   => 'blog_archive',
		'settings'  => 'post_loadmore_type',
		'default'   => riode_get_option( 'post_loadmore_type' ),
		'label'     => esc_html__( 'Load More Type', 'riode' ),
		'tooltip'   => esc_html__( 'Select method to load more posts.', 'riode' ),
		'choices'   => array(
			'button' => RIODE_CUSTOMIZER_IMG . '/loadmore_button.png',
			'page'   => RIODE_CUSTOMIZER_IMG . '/loadmore_page.png',
			'scroll' => RIODE_CUSTOMIZER_IMG . '/loadmore_scroll.png',
		),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'            => 'text',
		'section'         => 'blog_archive',
		'settings'        => 'post_loadmore_label',
		'default'         => riode_get_option( 'post_loadmore_label' ),
		'label'           => esc_html__( 'Loadmore Button Text', 'riode' ),
		'tooltip'         => esc_html__( 'Input loadmore button label.', 'riode' ),
		'transport'       => 'refresh',
		'active_callback' => array(
			array(
				'setting'  => 'post_loadmore_type',
				'operator' => '==',
				'value'    => 'button',
			),
		),
	)
);
