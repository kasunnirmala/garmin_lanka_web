<?php

/**
 * Footer Panel
 */

// Selective Refresh for this panel
include_once RIODE_OPTION . '/footer/option-selective.php';

Riode_Customizer::add_panel(
	'footer',
	array(
		'title'    => esc_html__( 'Footer', 'riode' ),
		'priority' => 7,
	)
);

include_once RIODE_OPTION . '/footer/option-footer-builder.php';
include_once RIODE_OPTION . '/footer/option-footer-general.php';
include_once RIODE_OPTION . '/footer/option-footer-typography.php';
include_once RIODE_OPTION . '/footer/option-footer-top.php';
include_once RIODE_OPTION . '/footer/option-footer-main.php';
include_once RIODE_OPTION . '/footer/option-footer-bottom.php';
