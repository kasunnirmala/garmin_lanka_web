<?php

/**
 * Skin Section
 */

Riode_Customizer::add_section(
	'skin',
	array(
		'title' => esc_html__( 'Skin', 'riode' ),
		'panel' => 'style',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'     => 'skin',
		'type'        => 'toggle',
		'settings'    => 'rounded_skin',
		'label'       => esc_html__( 'Enable Rounded Border', 'riode' ),
		'default'     => riode_get_option( 'rounded_skin' ),
		'tooltip'     => esc_html__( 'All buttons, images and borders will have border-radius value by default. Product image is an exception.', 'riode' ),
		'transport'   => 'refresh',
	)
);
