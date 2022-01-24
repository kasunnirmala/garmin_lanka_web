<?php

/**
 * Share Panel
 */

Riode_Customizer::add_section(
	'mobile_menu',
	array(
		'title'    => esc_html__( 'Mobile Menu', 'riode' ),
		'panel'    => 'nav_menus',
		'priority' => 3,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_menu',
		'type'      => 'custom',
		'settings'  => 'cs_mobile_menu_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Mobile Menu', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

$nav_menus = wp_get_nav_menus();
$menus     = array();
foreach ( $nav_menus as $menu ) {
	$menus[ $menu->term_id ] = esc_html( $menu->name );
}

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_menu',
		'type'      => 'sortable',
		'settings'  => 'mobile_menu_items',
		'label'     => esc_html__( 'Mobile Menus', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'mobile_menu_items' ),
		'tooltip'   => esc_html__( 'Select which menus you want show in mobile menu.', 'riode' ),
		'choices'   => $menus,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_menu',
		'type'      => 'radio_buttonset',
		'settings'  => 'mobile_menu_type',
		'label'     => esc_html__( 'Mobile Menus Arrange', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'mobile_menu_type' ),
		'tooltip'   => esc_html__( 'How would you like to arrange several menus?', 'riode' ),
		'choices'   => array(
			'following' => esc_html__( 'Following', 'riode' ),
			'tab' => esc_html__( 'Tab', 'riode' ),
		),
	)
);
