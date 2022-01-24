<?php

/**
 * Typography Panel
 */

Riode_Customizer::add_section(
	'menu_skins',
	array(
		'title'    => esc_html__( 'Menu Skins', 'riode' ),
		'priority' => 2,
		'panel'    => 'nav_menus',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'menu_skins',
		'type'     => 'custom',
		'settings' => 'cs_menu_skins_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Menu Skins', 'riode' ) . '</h3>',
		'tooltip'  => esc_html__( 'Change styles of below 3 supported menu skins and assign to different menus.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'menu_skins',
		'type'      => 'select',
		'settings'  => 'menu_skins_select',
		'default'   => 'skin1',
		'transport' => 'postMessage',
		'choices'   => array(
			'skin1' => esc_html__( 'Skin 1', 'riode' ),
			'skin2' => esc_html__( 'Skin 2', 'riode' ),
			'skin3' => esc_html__( 'Skin 3', 'riode' ),
		),
	)
);

// Skin 1
Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'custom',
		'settings'        => 'cs_menu_skin1_typo_title',
		'default'         => '<h3 class="options-custom" style="margin: 0; padding: 10px; border: 1px solid #666;">' . esc_html__( 'Skin 1', 'riode' ) . '</h3>',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'radio-buttonset',
		'settings'        => 'menu_skin1_part',
		'default'         => 'ancestor',
		'transport'       => 'postMessage',
		'choices'         => array(
			'ancestor' => esc_html__( 'Ancestor', 'riode' ),
			'content'  => esc_html__( 'Content', 'riode' ),
			'toggle'   => esc_html__( 'Toggle', 'riode' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'typography',
		'settings'        => 'typo_menu_skin1_ancestor',
		'label'           => esc_html__( 'Ancestor Typography', 'riode' ),
		'default'         => riode_get_option( 'typo_menu_skin1_ancestor' ),
		'tooltip'         => esc_html__( 'Menu ancestors are top-level menu items, which can have submenus and megamenus.', 'riode' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'text',
		'settings'        => 'skin1_ancestor_gap',
		'label'           => esc_html__( 'Ancestor Gap Space (px)', 'riode' ),
		'default'         => riode_get_option( 'skin1_ancestor_gap' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'dimensions',
		'settings'        => 'skin1_ancestor_padding',
		'label'           => esc_html__( 'Ancestor Padding(px)', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => riode_get_option( 'skin1_ancestor_padding' ),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin1_anc_bg',
		'label'           => esc_html__( 'Ancestor Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin1_anc_active_bg',
		'label'           => esc_html__( 'Ancestor Hover Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin1_anc_active_color',
		'label'           => esc_html__( 'Ancestor Hover Color', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'typography',
		'settings'        => 'typo_menu_skin1_content',
		'label'           => esc_html__( 'Content Typography', 'riode' ),
		'default'         => riode_get_option( 'typo_menu_skin1_content' ),
		'tooltip'         => esc_html__( 'Please change style of submenus or megamenus', 'riode' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin1_con_bg',
		'label'           => esc_html__( 'Menu Content Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin1_con_active_bg',
		'label'           => esc_html__( 'Menu Item Hover Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin1_con_active_color',
		'label'           => esc_html__( 'Menu Item Hover Color', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'typography',
		'settings'        => 'typo_menu_skin1_toggle',
		'label'           => esc_html__( 'Toggle Typography', 'riode' ),
		'tooltip'         => esc_html__( "Please change menu toggle's style in toggle-type menus.", 'riode' ),
		'default'         => riode_get_option( 'typo_menu_skin1_toggle' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'dimensions',
		'settings'        => 'skin1_toggle_padding',
		'label'           => esc_html__( 'Toggle Padding(px)', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => riode_get_option( 'skin1_toggle_padding' ),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin1_tog_bg',
		'label'           => esc_html__( 'Toggle Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin1_tog_active_bg',
		'label'           => esc_html__( 'Toggle Hover Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin1_tog_active_color',
		'label'           => esc_html__( 'Toggle Hover Color', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin1',
			),
			array(
				'setting'  => 'menu_skin1_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

// Skin 2
Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'custom',
		'settings'        => 'cs_menu_skin2_typo_title',
		'default'         => '<h3 class="options-custom" style="margin: 0; padding: 10px; border: 1px solid #666;">' . esc_html__( 'Skin 2', 'riode' ) . '</h3>',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'radio-buttonset',
		'settings'        => 'menu_skin2_part',
		'default'         => 'ancestor',
		'transport'       => 'postMessage',
		'choices'         => array(
			'ancestor' => esc_html__( 'Ancestor', 'riode' ),
			'content'  => esc_html__( 'Content', 'riode' ),
			'toggle'   => esc_html__( 'Toggle', 'riode' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'typography',
		'settings'        => 'typo_menu_skin2_ancestor',
		'label'           => esc_html__( 'Ancestor Typography', 'riode' ),
		'default'         => riode_get_option( 'typo_menu_skin2_ancestor' ),
		'tooltip'         => esc_html__( 'Menu ancestors are top-level menu items, which can have submenus and megamenus.', 'riode' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'text',
		'settings'        => 'skin2_ancestor_gap',
		'label'           => esc_html__( 'Ancestor Gap Space (px)', 'riode' ),
		'default'         => riode_get_option( 'skin2_ancestor_gap' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'dimensions',
		'settings'        => 'skin2_ancestor_padding',
		'label'           => esc_html__( 'Ancestor Padding(px)', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => riode_get_option( 'skin2_ancestor_padding' ),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin2_anc_bg',
		'label'           => esc_html__( 'Ancestor Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin2_anc_active_bg',
		'label'           => esc_html__( 'Ancestor Hover Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin2_anc_active_color',
		'label'           => esc_html__( 'Ancestor Hover Color', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'typography',
		'settings'        => 'typo_menu_skin2_content',
		'label'           => esc_html__( 'Content Typography', 'riode' ),
		'default'         => riode_get_option( 'typo_menu_skin2_content' ),
		'tooltip'         => esc_html__( 'Please change style of submenus or megamenus', 'riode' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin2_con_bg',
		'label'           => esc_html__( 'Menu Content Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin2_con_active_bg',
		'label'           => esc_html__( 'Menu Item Hover Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin2_con_active_color',
		'label'           => esc_html__( 'Menu Item Hover Color', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'typography',
		'settings'        => 'typo_menu_skin2_toggle',
		'label'           => esc_html__( 'Toggle Typography', 'riode' ),
		'tooltip'         => esc_html__( "Please change menu toggle's style in toggle-type menus.", 'riode' ),
		'default'         => riode_get_option( 'typo_menu_skin2_toggle' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'dimensions',
		'settings'        => 'skin2_toggle_padding',
		'label'           => esc_html__( 'Toggle Padding(px)', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => riode_get_option( 'skin2_toggle_padding' ),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin2_tog_bg',
		'label'           => esc_html__( 'Toggle Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin2_tog_active_bg',
		'label'           => esc_html__( 'Toggle Hover Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin2_tog_active_color',
		'label'           => esc_html__( 'Toggle Hover Color', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin2',
			),
			array(
				'setting'  => 'menu_skin2_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

// Skin 3
Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'custom',
		'settings'        => 'cs_menu_skin3_typo_title',
		'default'         => '<h3 class="options-custom" style="margin: 0; padding: 10px; border: 1px solid #666;">' . esc_html__( 'Skin 3', 'riode' ) . '</h3>',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'radio-buttonset',
		'settings'        => 'menu_skin3_part',
		'default'         => 'ancestor',
		'transport'       => 'postMessage',
		'choices'         => array(
			'ancestor' => esc_html__( 'Ancestor', 'riode' ),
			'content'  => esc_html__( 'Content', 'riode' ),
			'toggle'   => esc_html__( 'Toggle', 'riode' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'typography',
		'settings'        => 'typo_menu_skin3_ancestor',
		'label'           => esc_html__( 'Ancestor Typography', 'riode' ),
		'default'         => riode_get_option( 'typo_menu_skin3_ancestor' ),
		'tooltip'         => esc_html__( 'Menu ancestors are top-level menu items, which can have submenus and megamenus.', 'riode' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'text',
		'settings'        => 'skin3_ancestor_gap',
		'label'           => esc_html__( 'Ancestor Gap Space (px)', 'riode' ),
		'default'         => riode_get_option( 'skin3_ancestor_gap' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'dimensions',
		'settings'        => 'skin3_ancestor_padding',
		'label'           => esc_html__( 'Ancestor Padding(px)', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => riode_get_option( 'skin3_ancestor_padding' ),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin3_anc_bg',
		'label'           => esc_html__( 'Ancestor Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin3_anc_active_bg',
		'label'           => esc_html__( 'Ancestor Hover Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin3_anc_active_color',
		'label'           => esc_html__( 'Ancestor Hover Color', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'ancestor',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'typography',
		'settings'        => 'typo_menu_skin3_content',
		'label'           => esc_html__( 'Content Typography', 'riode' ),
		'default'         => riode_get_option( 'typo_menu_skin3_content' ),
		'tooltip'         => esc_html__( 'Please change style of submenus or megamenus', 'riode' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin3_con_bg',
		'label'           => esc_html__( 'Menu Content Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin3_con_active_bg',
		'label'           => esc_html__( 'Menu Item Hover Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin3_con_active_color',
		'label'           => esc_html__( 'Menu Item Hover Color', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'typography',
		'settings'        => 'typo_menu_skin3_toggle',
		'label'           => esc_html__( 'Toggle Typography', 'riode' ),
		'tooltip'         => esc_html__( "Please change menu toggle's style in toggle-type menus.", 'riode' ),
		'default'         => riode_get_option( 'typo_menu_skin3_toggle' ),
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'dimensions',
		'settings'        => 'skin3_toggle_padding',
		'label'           => esc_html__( 'Toggle Padding(px)', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => riode_get_option( 'skin3_toggle_padding' ),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin3_tog_bg',
		'label'           => esc_html__( 'Toggle Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin3_tog_active_bg',
		'label'           => esc_html__( 'Toggle Hover Background', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'menu_skins',
		'type'            => 'color',
		'settings'        => 'skin3_tog_active_color',
		'label'           => esc_html__( 'Toggle Hover Color', 'riode' ),
		'transport'       => 'postMessage',
		'default'         => '',
		'choices'         => array(
			'alpha' => true,
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_skins_select',
				'operator' => '==',
				'value'    => 'skin3',
			),
			array(
				'setting'  => 'menu_skin3_part',
				'operator' => '==',
				'value'    => 'toggle',
			),
		),
	)
);
