<?php

/**
 * Footer Typography
 */

Riode_Customizer::add_section(
	'footer_typography',
	array(
		'title' => esc_html__( 'Typography', 'riode' ),
		'panel' => 'footer',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_typography',
		'type'      => 'custom',
		'settings'  => 'cs_footer_typo_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Footer Typography', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_typography',
		'type'      => 'typography',
		'settings'  => 'typo_footer',
		'label'     => esc_html__( 'Footer Base', 'riode' ),
		'default'   => riode_get_option( 'typo_footer' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_typography',
		'type'      => 'typography',
		'settings'  => 'typo_footer_title',
		'label'     => esc_html__( 'Widget Title', 'riode' ),
		'default'   => riode_get_option( 'typo_footer_title' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_typography',
		'type'      => 'typography',
		'settings'  => 'typo_footer_widget',
		'label'     => esc_html__( 'Widget', 'riode' ),
		'default'   => riode_get_option( 'typo_footer_widget' ),
		'transport' => 'postMessage',
	)
);
