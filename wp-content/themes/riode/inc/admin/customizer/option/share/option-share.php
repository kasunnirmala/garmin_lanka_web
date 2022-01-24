<?php

/**
 * Share Panel
 */

// Selective Refresh for this panel
include_once RIODE_OPTION . '/share/option-selective.php';

global $riode_social_name;

Riode_Customizer::add_section(
	'share',
	array(
		'title'    => esc_html__( 'Share', 'riode' ),
		'priority' => 8,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'share',
		'type'      => 'custom',
		'settings'  => 'cs_share_icon_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Share Icons', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'share',
		'type'      => 'custom',
		'settings'  => 'cs_share_icon_description',
		'label'     => '',
		'default'   => '<p>' . sprintf( esc_html__( 'Please change options for %1$ssocial share buttons%2$s in single product and post page.', 'riode' ), '<span class="text-primary">', '</span>' ) . '</p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'share',
		'type'      => 'radio_image',
		'settings'  => 'share_type',
		'label'     => esc_html__( 'Share Icon Type', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'share_type' ),
		'choices'   => array(
			''                => RIODE_CUSTOMIZER_IMG . '/share1.png',
			'framed'          => RIODE_CUSTOMIZER_IMG . '/share2.png',
			'stacked'         => RIODE_CUSTOMIZER_IMG . '/share3.png',
			'stacked rounded' => RIODE_CUSTOMIZER_IMG . '/share4.png',
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'share',
		'type'      => 'toggle',
		'settings'  => 'share_custom_color',
		'label'     => esc_html__( 'Use Custom Color', 'riode' ),
		'default'   => riode_get_option( 'share_custom_color' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'share',
		'type'            => 'color',
		'settings'        => 'share_color',
		'label'           => esc_html__( 'Color', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => riode_get_option( 'share_color' ),
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'share_custom_color',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

$riode_share_names = $riode_social_name;
unset( $riode_share_names['google'], $riode_share_names['instagram'] );

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'share',
		'type'      => 'sortable',
		'settings'  => 'share_icons',
		'label'     => esc_html__( 'Share Icons', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'share_icons' ),
		'choices'   => $riode_share_names,
	)
);
