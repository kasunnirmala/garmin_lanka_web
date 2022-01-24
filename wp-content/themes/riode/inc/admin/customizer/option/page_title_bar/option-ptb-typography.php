<?php

/**
 * Page Title Bar Dimension
 */

Riode_Customizer::add_section(
	'ptb_typography',
	array(
		'title' => esc_html__( 'PTB Typography', 'riode' ),
		'panel' => 'page_title_bar',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_typography',
		'type'      => 'custom',
		'settings'  => 'cs_ptb_typo_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Title', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_typography',
		'type'      => 'typography',
		'settings'  => 'typo_ptb_title',
		'label'     => esc_html__( 'Page Title', 'riode' ),
		'default'   => riode_get_option( 'typo_ptb_title' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_typography',
		'type'      => 'typography',
		'settings'  => 'typo_ptb_subtitle',
		'label'     => esc_html__( 'Page Subtitle', 'riode' ),
		'default'   => riode_get_option( 'typo_ptb_subtitle' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_typography',
		'type'      => 'custom',
		'settings'  => 'cs_ptb_breadcrumb_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Breadcrumb', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_typography',
		'type'      => 'typography',
		'settings'  => 'typo_ptb_breadcrumb',
		'label'     => esc_html__( 'Breadcrumb', 'riode' ),
		'default'   => riode_get_option( 'typo_ptb_breadcrumb' ),
		'transport' => 'postMessage',
	)
);
