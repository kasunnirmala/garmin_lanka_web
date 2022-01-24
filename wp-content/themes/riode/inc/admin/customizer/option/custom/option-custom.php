<?php

/**
 * Additional CSS Panel
 */

Riode_Customizer::add_section(
	'custom_css_js',
	array(
		'title'    => esc_html__( 'Custom CSS & JS', 'riode' ),
		'priority' => 13,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'custom_css_js',
		'type'      => 'code',
		'settings'  => 'custom_css',
		'label'     => esc_html__( 'CSS code', 'riode' ),
		'default'   => riode_get_option( 'custom_css' ),
		'transport' => 'postMessage',
		'choices'   => array(
			'language' => 'css',
			'theme'    => 'monokai',
		),
	)
);


if ( current_user_can( 'unfiltered_html' ) ) {
	Riode_Customizer::add_field(
		'option',
		array(
			'section'   => 'custom_css_js',
			'type'      => 'custom',
			'settings'  => 'custom_js_prefix',
			'default'   => "<h4>" . esc_html__( 'JS Code', 'riode' ) . "</h4><p style='" . 'margin-top: -5px; margin-bottom: -5px;' . "'><b>Riode." . '$' . "window.on('riode_complete', function() {</b></p>",
			'transport' => 'postMessage',
		)
	);

	Riode_Customizer::add_field(
		'option',
		array(
			'section'   => 'custom_css_js',
			'type'      => 'code',
			'settings'  => 'custom_js',
			'label'     => '',
			'default'   => riode_get_option( 'custom_js' ),
			'transport' => 'postMessage',
			'choices'   => array(
				'language' => 'js',
				'theme'    => 'monokai',
			),
		)
	);

	Riode_Customizer::add_field(
		'option',
		array(
			'section'   => 'custom_css_js',
			'type'      => 'custom',
			'settings'  => 'custom_js_suffix',
			'label'     => '',
			'default'   => "<p style='margin-top: -5px;'><b>})</b></p>",
			'transport' => 'postMessage',
		)
	);
}
