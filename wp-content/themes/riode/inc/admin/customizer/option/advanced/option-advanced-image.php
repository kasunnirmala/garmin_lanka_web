<?php

/**
 * Error 404 Page Options
 */

Riode_Customizer::add_section(
	'images',
	array(
		'title' => esc_html__( 'New Image Size', 'riode' ),
		'panel' => 'advanced',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'images',
		'type'      => 'custom',
		'settings'  => 'cs_image_size_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Image Size', 'riode' ) . '</h3>',
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'images',
		'type'      => 'dimensions',
		'settings'  => 'custom_image_size',
		'label'     => 'Register Custom Image Size (px)',
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'custom_image_size' ),
		'tooltip'   => esc_html__( 'Do you need a custom image size? Please input width and height to register new size. Do not forget to regenerate previously uploaded images.', 'riode' ),
	)
);
