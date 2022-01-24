<?php

/**
 * Advanced Features
 */

Riode_Customizer::add_section(
	'performance',
	array(
		'title' => esc_html__( 'Performance', 'riode' ),
		'panel' => 'advanced',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'performance',
		'type'      => 'custom',
		'settings'  => 'cs_feature_lazyload_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Lazyload', 'riode' ) . '</h3>',
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'performance',
		'type'      => 'toggle',
		'settings'  => 'lazyload',
		'label'     => esc_html__( 'Image LazyLoad', 'riode' ),
		'default'   => riode_get_option( 'lazyload' ),
		'tooltip'   => esc_html__( 'All images will be lazyloaded when they come into screen.', 'riode' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'performance',
		'type'            => 'color',
		'settings'        => 'lazyload_bg',
		'label'           => esc_html__( 'Lazyload Image Initial Color', 'riode' ),
		'tooltip'         => esc_html__( 'Change background color of lazyloading images.', 'riode' ),
		'choices'         => array(
			'alpha' => true,
		),
		'default'         => riode_get_option( 'lazyload_bg' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'lazyload',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'performance',
		'type'      => 'toggle',
		'settings'  => 'lazyload_menu',
		'label'     => esc_html__( 'Menu Lazyload', 'riode' ),
		'default'   => riode_get_option( 'lazyload_menu' ),
		'tooltip'   => esc_html__( 'Menus will be lazyloaded. They will be saved in clients\' local storages for faster performance, and they will be updated when menu has been changed.', 'riode' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'     => 'performance',
		'type'        => 'toggle',
		'settings'    => 'skeleton_screen',
		'label'       => esc_html__( 'Skeleton Screen', 'riode' ),
		'tooltip'     => esc_html__( 'Beautiful skeleton screen will appear instead of preloading icon in all archive pages, single pages, quickview popup and any other ajax loading.', 'riode' ),
		'description' => esc_html__( 'NOTE: If you face into js compatibility problems with some plugins like dokan pro, please disable this feature.', 'riode' ),
		'default'     => riode_get_option( 'skeleton_screen' ),
		'transport'   => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'performance',
		'type'            => 'radio_buttonset',
		'settings'        => 'skeleton_bg',
		'label'           => esc_html__( 'Skeleton Screen Mode', 'riode' ),
		'tooltip'         => esc_html__( 'Choose skeleton screen skin from Light/Dark modes.', 'riode' ),
		'default'         => riode_get_option( 'skeleton_bg' ),
		'transport'       => 'postMessage',
		'choices'         => array(
			'light' => esc_html__( 'Light', 'riode' ),
			'dark'  => esc_html__( 'Dark', 'riode' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'skeleton_screen',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'performance',
		'type'      => 'custom',
		'settings'  => 'cs_feature_mobile_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Mobile Performance', 'riode' ) . '</h3>',
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'     => 'performance',
		'type'        => 'toggle',
		'settings'    => 'mobile_disable_animation',
		'label'       => esc_html__( 'Disable Animation on Mobile', 'riode' ),
		'tooltip'     => esc_html__( 'All entrance and floating animations will be disabled on mobile.', 'riode' ),
		'default'     => riode_get_option( 'mobile_disable_animation' ),
		'transport'   => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'     => 'performance',
		'type'        => 'toggle',
		'settings'    => 'mobile_disable_slider',
		'label'       => esc_html__( 'Disable Sliders on Mobile', 'riode' ),
		'tooltip'     => esc_html__( 'Slider feature will be disabled on mobile. Browser touch scrolling will be used instead.', 'riode' ),
		'default'     => riode_get_option( 'mobile_disable_slider' ),
		'transport'   => 'postMessage',
	)
);
