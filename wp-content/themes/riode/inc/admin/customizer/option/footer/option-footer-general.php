<?php

/**
 * Footer General
 */

Riode_Customizer::add_section(
	'footer_general',
	array(
		'title' => esc_html__( 'General', 'riode' ),
		'panel' => 'footer',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_general',
		'type'      => 'custom',
		'settings'  => 'cs_footer_skin_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Footer Skin', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_general',
		'type'      => 'radio-buttonset',
		'settings'  => 'footer_skin',
		'label'     => esc_html__( 'Footer Skin', 'riode' ),
		'default'   => riode_get_option( 'footer_skin' ),
		'transport' => 'postMessage',
		'choices'   => array(
			'dark'  => esc_html__( 'Dark', 'riode' ),
			'light' => esc_html__( 'Light', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_general',
		'type'      => 'background',
		'settings'  => 'footer_bg',
		'label'     => esc_html__( 'Background', 'riode' ),
		'default'   => '',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_general',
		'type'      => 'color',
		'settings'  => 'footer_link_color',
		'label'     => esc_html__( 'Link color', 'riode' ),
		'default'   => '',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_general',
		'type'      => 'color',
		'settings'  => 'footer_active_color',
		'label'     => esc_html__( 'Link Hover color', 'riode' ),
		'default'   => '',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_general',
		'type'      => 'color',
		'settings'  => 'footer_bd_color',
		'label'     => esc_html__( 'Divider color', 'riode' ),
		'default'   => '',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_general',
		'type'      => 'custom',
		'settings'  => 'cs_back_to_top_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Scroll To Top Button', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_general',
		'type'      => 'slider',
		'settings'  => 'top_button_size',
		'label'     => esc_html__( 'Button Size', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'top_button_size' ),
		'choices'   => array(
			'min'    => 0,
			'max'    => 200,
			'step'   => 1,
			'suffix' => '%',
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_general',
		'type'      => 'radio_buttonset',
		'settings'  => 'top_button_pos',
		'label'     => esc_html__( 'Button Position', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'top_button_pos' ),
		'choices'   => array(
			'left'  => esc_html__( 'Left', 'riode' ),
			'right' => esc_html__( 'Right', 'riode' ),
		),
	)
);
