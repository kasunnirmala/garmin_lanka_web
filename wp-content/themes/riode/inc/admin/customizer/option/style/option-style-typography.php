<?php

/**
 * Typography Section
 */

Riode_Customizer::add_section(
	'typography',
	array(
		'title' => esc_html__( 'Typography', 'riode' ),
		'panel' => 'style',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'typography',
		'type'     => 'custom',
		'settings' => 'cs_header_footer_typo',
		'default'  => '<p style="margin-bottom: 0; cursor: auto;">' . sprintf( esc_html__( 'You can set header and footer typography in %1$sHeader/Header General%2$sFooter/Typography%3$s Section', 'riode' ), '<a href="#" data-target="header_style">', '</a>, <a href="#" data-target="footer_typography">', '</a>' ) . '</p>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'typography',
		'type'     => 'custom',
		'settings' => 'cs_typo_default_font',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Default Typography', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'typography',
		'type'      => 'typography',
		'settings'  => 'typo_default',
		'label'     => '',
		'default'   => riode_get_option( 'typo_default' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'typography',
		'type'     => 'custom',
		'settings' => 'cs_typo_heading',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Heading Typography', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'typography',
		'type'      => 'typography',
		'settings'  => 'typo_heading',
		'label'     => '',
		'default'   => riode_get_option( 'typo_heading' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'typography',
		'type'     => 'custom',
		'settings' => 'cs_typo_custom_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Custom Google Fonts', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'typography',
		'type'     => 'custom',
		'settings' => 'cs_typo_custom_desc',
		'default'  => '<p style="margin: 0;">' . esc_html__( 'Select other google fonts to download', 'riode' ) . '</p>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'typography',
		'type'      => 'radio-buttonset',
		'settings'  => 'typo_custom_part',
		'default'   => '1',
		'transport' => 'postMessage',
		'choices'   => array(
			'1' => esc_html__( 'Custom 1', 'riode' ),
			'2' => esc_html__( 'Custom 2', 'riode' ),
			'3' => esc_html__( 'Custom 3', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'typography',
		'type'            => 'typography',
		'settings'        => 'typo_custom1',
		'label'           => esc_html__( 'Custom Font 1', 'riode' ),
		'default'         => riode_get_option( 'typo_custom1' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'typo_custom_part',
				'operator' => '==',
				'value'    => '1',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'typography',
		'type'            => 'typography',
		'settings'        => 'typo_custom2',
		'label'           => esc_html__( 'Custom Font 2', 'riode' ),
		'default'         => riode_get_option( 'typo_custom2' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'typo_custom_part',
				'operator' => '==',
				'value'    => '2',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'typography',
		'type'            => 'typography',
		'settings'        => 'typo_custom3',
		'label'           => esc_html__( 'Custom Font 3', 'riode' ),
		'default'         => riode_get_option( 'typo_custom3' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'typo_custom_part',
				'operator' => '==',
				'value'    => '3',
			),
		),
	)
);
