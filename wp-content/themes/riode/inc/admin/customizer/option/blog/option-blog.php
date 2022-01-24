<?php

/**
 * Blog
 */

Riode_Customizer::add_panel(
	'blog',
	array(
		'title'    => esc_html__( 'Blog', 'riode' ),
		'priority' => 8,
	)
);

include_once RIODE_OPTION . '/blog/option-blog-archive.php';
include_once RIODE_OPTION . '/blog/option-blog-single.php';
include_once RIODE_OPTION . '/blog/option-blog-post.php';
