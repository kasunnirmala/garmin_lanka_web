<?php

/**
 * Import/Export/Reset Options
 */

Riode_Customizer::add_section(
	'reset_options',
	array(
		'title' => esc_html__( 'Import/Export/Reset', 'riode' ),
		'panel' => 'advanced',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'reset_options',
		'type'      => 'custom',
		'settings'  => 'cs_reset_import_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Import/Export Options', 'riode' ) . '</h3>',
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'reset_options',
		'type'      => 'custom',
		'settings'  => 'import_src',
		'label'     => esc_html__( 'Please select source option file to import', 'riode' ),
		'transport' => 'postMessage',
		'default'   => '<input type="file">',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'reset_options',
		'type'     => 'custom',
		'settings' => 'cs_import_option',
		'label'    => '',
		'default'  => '<button name="import" id="riode-import-options" class="button button-primary">' . esc_html__( 'Import', 'riode' ) . '</button>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'reset_options',
		'type'     => 'custom',
		'settings' => 'cs_export_option',
		'label'    => '',
		'default'  => '<p>' . esc_html__( 'Export theme options', 'riode' ) . '</p><a href="' . esc_url( admin_url( 'admin-ajax.php?action=riode_export_theme_options&wp_customize=on&nonce=' . wp_create_nonce( 'riode-customizer' ) ) ) . '" name="export" id="riode-export-options" class="button button-primary">' . esc_html__( 'Download Theme Options', 'riode' ) . '</a>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'reset_options',
		'type'      => 'custom',
		'settings'  => 'cs_reset_options_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Reset Options', 'riode' ) . '</h3>',
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'reset_options',
		'type'     => 'custom',
		'settings' => 'cs_reset_option',
		'label'    => '',
		'default'  => '<p>' . esc_html__( 'Please click below button to reset options.', 'riode' ) . '</p><button name="reset" id="riode-reset-options" class="button button-primary">' . esc_html__( 'Reset Theme Options', 'riode' ) . '</button>',
	)
);
