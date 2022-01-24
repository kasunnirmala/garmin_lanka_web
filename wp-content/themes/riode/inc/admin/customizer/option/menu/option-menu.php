<?php

/**
 * Menu
 */

Riode_Customizer::add_panel(
	'nav_menus',
	array(
		'title'    => esc_html__( 'Menus', 'riode' ),
		'priority' => 5,
	)
);

include_once RIODE_OPTION . '/menu/option-menu-skin.php';
include_once RIODE_OPTION . '/menu/option-menu-labels.php';
include_once RIODE_OPTION . '/menu/option-menu-mobile.php';
include_once RIODE_OPTION . '/menu/option-menu-mobile-bar.php';
