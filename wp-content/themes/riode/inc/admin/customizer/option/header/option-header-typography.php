<?php

/**
 * Header Typography
 */

Riode_Customizer::add_section(
	'header_style',
	array(
		'title' => esc_html__( 'Header Style', 'riode' ),
		'panel' => 'header',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'header_style',
		'type'      => 'custom',
		'settings'  => 'cs_header_typography_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Header Typography', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'header_style',
		'type'      => 'typography',
		'settings'  => 'typo_header',
		'label'     => esc_html__( 'Header Typography', 'riode' ),
		'default'   => riode_get_option( 'typo_header' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'header_style',
		'type'      => 'color',
		'settings'  => 'header_active_color',
		'label'     => esc_html__( 'Hover Color', 'riode' ),
		'default'   => '',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'header_style',
		'type'      => 'custom',
		'settings'  => 'cs_header_background_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Header Background', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'header_style',
		'type'      => 'background',
		'settings'  => 'header_bg',
		'label'     => esc_html__( 'Header Background', 'riode' ),
		'default'   => riode_get_option( 'header_bg' ),
		'transport' => 'postMessage',
	)
);
