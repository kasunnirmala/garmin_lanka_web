<?php

/**
 * Page Title Bar Style
 */

Riode_Customizer::add_section(
	'ptb_config',
	array(
		'title' => esc_html__( 'PTB Config', 'riode' ),
		'panel' => 'page_title_bar',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_config',
		'type'      => 'radio_image',
		'settings'  => 'ptb_type',
		'label'     => esc_html__( 'PTB Type', 'riode' ),
		'default'   => riode_get_option( 'ptb_type' ),
		'transport' => 'refresh',
		'choices'   => array(
			'center' => RIODE_CUSTOMIZER_IMG . '/ptb1.jpg',
			'left'   => RIODE_CUSTOMIZER_IMG . '/ptb2.jpg',
			'inline' => RIODE_CUSTOMIZER_IMG . '/ptb3.jpg',
			'depart' => RIODE_CUSTOMIZER_IMG . '/ptb4.jpg',
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_config',
		'type'      => 'toggle',
		'settings'  => 'ptb_title_show',
		'label'     => esc_html__( 'Show Page Title', 'riode' ),
		'default'   => riode_get_option( 'ptb_title_show' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_config',
		'type'      => 'toggle',
		'settings'  => 'ptb_subtitle_show',
		'label'     => esc_html__( 'Show Page Subtitle', 'riode' ),
		'default'   => riode_get_option( 'ptb_subtitle_show' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_config',
		'type'      => 'toggle',
		'settings'  => 'ptb_breadcrumb_show',
		'label'     => esc_html__( 'Show Breadcrumb', 'riode' ),
		'default'   => riode_get_option( 'ptb_breadcrumb_show' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'ptb_config',
		'type'      => 'radio-buttonset',
		'settings'  => 'ptb_wrap_container',
		'label'     => esc_html__( 'Wrap PTB with', 'riode' ),
		'tooltip'   => esc_html__( 'You can wrap PTB content with container or container-fluid by using this option.', 'riode' ),
		'default'   => riode_get_option( 'ptb_wrap_container' ),
		'transport' => 'refresh',
		'choices'   => array(
			'default'         => esc_html__( 'Default', 'riode' ),
			'container'       => esc_html__( 'Boxed', 'riode' ),
			'container-fluid' => esc_html__( 'Fluid', 'riode' ),
		),
	)
);
