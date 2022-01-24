<?php

/**
 * Ganeral Panel
 * Change Genaral Settings
 */

Riode_Customizer::add_section(
	'general',
	array(
		'title'    => esc_html__( 'General', 'riode' ),
		'priority' => 1,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'general',
		'type'     => 'custom',
		'settings' => 'cs_layout_title',
		'label'    => '',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'General Settings', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'general',
		'type'      => 'radio-buttonset',
		'settings'  => 'site_type',
		'label'     => esc_html__( 'Site Type', 'riode' ),
		'default'   => riode_get_option( 'site_type' ),
		'transport' => 'postMessage',
		'choices'   => array(
			'full'   => esc_html__( 'Full', 'riode' ),
			'boxed'  => esc_html__( 'Boxed', 'riode' ),
			'framed' => esc_html__( 'Framed', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'general',
		'type'            => 'text',
		'settings'        => 'site_width',
		'label'           => esc_html__( 'Box/Frame Width (px)', 'riode' ),
		'default'         => riode_get_option( 'site_width' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'site_type',
				'operator' => '!=',
				'value'    => 'full',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'general',
		'type'            => 'text',
		'settings'        => 'site_gap',
		'label'           => esc_html__( 'Box/Frame Gap (px)', 'riode' ),
		'default'         => riode_get_option( 'site_gap' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'site_type',
				'operator' => '!=',
				'value'    => 'full',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'general',
		'type'            => 'background',
		'settings'        => 'screen_bg',
		'label'           => esc_html__( 'Screen Background', 'riode' ),
		'tooltip'         => esc_html__( 'Change background of outside the frame.', 'riode' ),
		'default'         => '',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'site_type',
				'operator' => '!=',
				'value'    => 'full',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'general',
		'type'      => 'background',
		'settings'  => 'content_bg',
		'label'     => esc_html__( 'Content Background', 'riode' ),
		'default'   => '',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'general',
		'type'     => 'custom',
		'settings' => 'cs_general_content_title',
		'label'    => '',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Site Content', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'general',
		'type'      => 'text',
		'settings'  => 'container',
		'label'     => esc_html__( 'Container Width (px)', 'riode' ),
		'default'   => riode_get_option( 'container' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'general',
		'type'      => 'text',
		'settings'  => 'container_fluid',
		'label'     => esc_html__( 'Container Fluid Width (px)', 'riode' ),
		'default'   => riode_get_option( 'container_fluid' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'     => 'general',
		'type'        => 'text',
		'settings'    => 'gutter',
		'label'       => esc_html__( 'Grid Gutter Size (px)', 'riode' ),
		'tooltip' => esc_html__( 'This gutter is the space between columns.', 'riode' ),
		'default'     => riode_get_option( 'gutter' ),
		'transport'   => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'general',
		'type'      => 'text',
		'settings'  => 'gutter_lg',
		'label'     => esc_html__( 'Grid Gutter Large Size (px)', 'riode' ),
		'default'   => riode_get_option( 'gutter_lg' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'general',
		'type'      => 'text',
		'settings'  => 'gutter_sm',
		'label'     => esc_html__( 'Grid Gutter Small Size (px)', 'riode' ),
		'default'   => riode_get_option( 'gutter_sm' ),
		'transport' => 'postMessage',
	)
);
