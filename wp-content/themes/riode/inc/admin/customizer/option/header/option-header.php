<?php

/**
 * Header Panel
 */

Riode_Customizer::add_panel(
	'header',
	array(
		'title'    => esc_html__( 'Header', 'riode' ),
		'priority' => 4,
	)
);

include_once RIODE_OPTION . '/header/option-header-builder.php';
include_once RIODE_OPTION . '/header/option-header-typography.php';
