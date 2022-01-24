<?php

/**
 * Advanced Features
 */

Riode_Customizer::add_section(
	'guide',
	array(
		'title' => esc_html__( 'Starter Guide', 'riode' ),
		'panel' => 'advanced',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'guide',
		'type'      => 'custom',
		'settings'  => 'cs_feature_guide_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Riode Starter Guides', 'riode' ) . '</h3>',
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'guide',
		'type'      => 'toggle',
		'settings'  => 'elementor_starter_guide',
		'label'     => esc_html__( 'Show Elementor Guide', 'riode' ),
		'default'   => riode_get_option( 'elementor_starter_guide' ),
		'transport' => 'postMessage',
	)
);
