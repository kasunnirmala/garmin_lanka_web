<?php

/**
 * Page Title Bar Style
 */

Riode_Customizer::add_section(
	'ptb_style',
	array(
		'title' => esc_html__( 'PTB Style', 'riode' ),
		'panel' => 'page_title_bar',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_style',
		'type'      => 'custom',
		'settings'  => 'cs_ptb_bar_style_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Title Bar Style', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_style',
		'type'      => 'number',
		'settings'  => 'ptb_height',
		'label'     => esc_html__( 'Title Bar Height (px)', 'riode' ),
		'default'   => riode_get_option( 'ptb_height' ),
		'transport' => 'postMessage',
		'choices'   => array(
			'step' => 5,
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_style',
		'type'      => 'background',
		'settings'  => 'ptb_bg',
		'label'     => esc_html__( 'Background', 'riode' ),
		'default'   => riode_get_option( 'ptb_bg' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_style',
		'type'      => 'custom',
		'settings'  => 'cs_ptb_breadcrumb_style_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Breadcrumb', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_style',
		'type'      => 'toggle',
		'settings'  => 'ptb_home_icon',
		'label'     => esc_html__( 'Show Home Icon', 'riode' ),
		'tooltip'   => esc_html__( 'Do you want to show home icon instead of home link?', 'riode' ),
		'default'   => riode_get_option( 'ptb_home_icon' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_style',
		'type'      => 'text',
		'settings'  => 'ptb_delimiter',
		'label'     => esc_html__( 'Breadcrumb Delimiter', 'riode' ),
		'tooltip'   => esc_html__( 'Please input delimiter text between breadcrumb links', 'riode' ),
		'default'   => riode_get_option( 'ptb_delimiter' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_style',
		'type'      => 'checkbox',
		'settings'  => 'ptb_delimiter_use_icon',
		'label'     => esc_html__( 'Use Icon for Delimiter', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'ptb_delimiter_use_icon' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'ptb_style',
		'type'            => 'text',
		'settings'        => 'ptb_delimiter_icon',
		'label'           => esc_html__( 'Delimiter Icon', 'riode' ),
		'tooltip'         => esc_html__( 'Please input icon class for delimiter symbol', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => riode_get_option( 'ptb_delimiter_icon' ),
		'active_callback' => array(
			array(
				'setting'  => 'ptb_delimiter_use_icon',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
