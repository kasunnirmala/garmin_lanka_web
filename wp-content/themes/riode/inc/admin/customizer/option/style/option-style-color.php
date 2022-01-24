<?php

/**
 * Color Section
 */

Riode_Customizer::add_section(
	'color',
	array(
		'title' => esc_html__( 'Color', 'riode' ),
		'panel' => 'style',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'color',
		'type'     => 'custom',
		'settings' => 'cs_colors_title',
		'label'    => '',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Colors', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'color',
		'type'      => 'color',
		'settings'  => 'primary_color',
		'label'     => esc_html__( 'Primary Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'primary_color' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'color',
		'type'      => 'color',
		'settings'  => 'secondary_color',
		'label'     => esc_html__( 'Secondary Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'secondary_color' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'color',
		'type'      => 'color',
		'settings'  => 'alert_color',
		'label'     => esc_html__( 'Alert Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'alert_color' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'color',
		'type'      => 'color',
		'settings'  => 'success_color',
		'label'     => esc_html__( 'Success Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'success_color' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'color',
		'type'      => 'color',
		'settings'  => 'dark_color',
		'label'     => esc_html__( 'Dark Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'dark_color' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'color',
		'type'      => 'color',
		'settings'  => 'light_color',
		'label'     => esc_html__( 'Light Color', 'riode' ),
		'choices'   => array(
			'alpha' => true,
		),
		'default'   => riode_get_option( 'light_color' ),
		'transport' => 'postMessage',
	)
);
