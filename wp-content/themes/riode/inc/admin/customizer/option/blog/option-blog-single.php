<?php

/**
 * Blog/Blog Single
 */

Riode_Customizer::add_section(
	'blog_single',
	array(
		'title' => esc_html__( 'Post Detail Page', 'riode' ),
		'panel' => 'blog',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'blog_single',
		'type'     => 'custom',
		'settings' => 'cs_blog_single_showing_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Showing Information', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'multicheck',
		'section'   => 'blog_single',
		'settings'  => 'post_show_info',
		'default'   => riode_get_option( 'post_show_info' ),
		'label'     => esc_html__( 'Items to show', 'riode' ),
		'tooltip'   => esc_html__( 'Check items to show in single post page', 'riode' ),
		'transport' => 'refresh',
		'choices'   => array(
			'image'         => esc_html__( 'Media', 'riode' ),
			'meta'          => esc_html__( 'Meta Information', 'riode' ),
			'content'       => esc_html__( 'Post Content', 'riode' ),
			'author_box'    => esc_html__( 'Author Box', 'riode' ),
			'tag'           => esc_html__( 'Tag List', 'riode' ),
			'share'         => esc_html__( 'Share Options', 'riode' ),
			'navigation'    => esc_html__( 'Prev and Next Navigation', 'riode' ),
			'related'       => esc_html__( 'Related Posts', 'riode' ),
			'comments_list' => esc_html__( 'Comments', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'blog_single',
		'type'     => 'custom',
		'settings' => 'cs_post_related_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Related Posts', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'number',
		'section'   => 'blog_single',
		'settings'  => 'post_related_count',
		'default'   => riode_get_option( 'post_related_count' ),
		'label'     => esc_html__( 'Count of Related Posts', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'number',
		'section'   => 'blog_single',
		'settings'  => 'post_related_per_row',
		'default'   => riode_get_option( 'post_related_per_row' ),
		'label'     => esc_html__( 'Related Posts per Row', 'riode' ),
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
		'section'   => 'blog_single',
		'type'      => 'select',
		'settings'  => 'post_related_orderby',
		'label'     => esc_html__( 'Order By', 'riode' ),
		'default'   => riode_get_option( 'post_related_orderby' ),
		'transport' => 'refresh',
		'choices'   => array(
			''              => esc_html__( 'Default', 'riode' ),
			'ID'            => esc_html__( 'ID', 'riode' ),
			'title'         => esc_html__( 'Title', 'riode' ),
			'date'          => esc_html__( 'Date', 'riode' ),
			'modified'      => esc_html__( 'Modified', 'riode' ),
			'author'        => esc_html__( 'Author', 'riode' ),
			'comment_count' => esc_html__( 'Comment count', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'blog_single',
		'type'      => 'select',
		'settings'  => 'post_related_orderway',
		'label'     => esc_html__( 'Order Way', 'riode' ),
		'default'   => riode_get_option( 'post_related_orderway' ),
		'transport' => 'refresh',
		'choices'   => array(
			''    => esc_html__( 'Descending', 'riode' ),
			'ASC' => esc_html__( 'Ascending', 'riode' ),
		),
	)
);
