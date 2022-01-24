<?php

/**
 * Style Panel
 */

Riode_Customizer::add_panel(
	'style',
	array(
		'title'    => esc_html__( 'Style', 'riode' ),
		'priority' => 2,
	)
);

include_once RIODE_OPTION . '/style/option-style-color.php';
include_once RIODE_OPTION . '/style/option-style-typography.php';
include_once RIODE_OPTION . '/style/option-style-skin.php';
