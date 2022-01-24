<?php

/**
 * Share Panel
 */

Riode_Customizer::add_panel(
	'advanced',
	array(
		'title'    => esc_html__( 'Advanced', 'riode' ),
		'priority' => 13,
	)
);

include_once RIODE_OPTION . '/advanced/option-advanced-performance.php';
include_once RIODE_OPTION . '/advanced/option-advanced-seo.php';
include_once RIODE_OPTION . '/advanced/option-advanced-guide.php';
include_once RIODE_OPTION . '/advanced/option-advanced-image.php';
include_once RIODE_OPTION . '/advanced/option-advanced-options.php';
