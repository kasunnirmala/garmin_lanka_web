<?php

/**
 * Footer Panel
 */

// Selective Refresh for this panel
include_once RIODE_OPTION . '/page_title_bar/option-selective.php';

Riode_Customizer::add_panel(
	'page_title_bar',
	array(
		'title'    => esc_html__( 'Page Title Bar', 'riode' ),
		'priority' => 6,
	)
);

include_once RIODE_OPTION . '/page_title_bar/option-ptb-config.php';
include_once RIODE_OPTION . '/page_title_bar/option-ptb-style.php';
include_once RIODE_OPTION . '/page_title_bar/option-ptb-typography.php';
