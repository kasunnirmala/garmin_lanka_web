<?php

/**
 * Default Wp Sections
 */

Riode_Customizer::add_section(
	'title_tagline',
	array(
		'title'    => esc_html__( 'Site Identity', 'riode' ),
		'priority' => 14,
	)
);

Riode_Customizer::add_panel(
	'widgets',
	array(
		'title'    => esc_html__( 'Widgets', 'riode' ),
		'priority' => 14,
	)
);

Riode_Customizer::add_section(
	'static_front_page',
	array(
		'title'    => esc_html__( 'Homepage Settings', 'riode' ),
		'priority' => 15,
	)
);
