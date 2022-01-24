<?php

/**
 * Error 404 Block
 */

Riode_Customizer::add_section(
	'error_404',
	array(
		'title'    => esc_html__( 'Error 404', 'riode' ),
		'priority' => 12,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'error_404',
		'type'      => 'custom',
		'settings'  => 'cs_error_404_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Eror 404 Page', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

$block_templates = Riode_Customizer::get_templates( 'block' );
$block_templates[''] = esc_html__( 'Select Block', 'riode' );

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'error_404',
		'type'      => 'select',
		'settings'  => '404_block',
		'default'   => riode_get_option( '404_block' ),
		'label'     => esc_html__( '404 Block', 'riode' ),
		'choices'   => $block_templates,
		'transport' => 'postMessage',
	)
);
