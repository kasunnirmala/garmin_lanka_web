<?php

/**
 * Footer Bottom
 */

Riode_Customizer::add_section(
	'footer_bottom',
	array(
		'title' => esc_html__( 'Footer Bottom', 'riode' ),
		'panel' => 'footer',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'footer_bottom',
		'type'     => 'custom',
		'settings' => 'cs_footer_bottom_desc',
		'label'    => '',
		'default'  => '<p class="warning-alert" style="margin: 0; cursor: auto;">' . sprintf( esc_html__( 'Below options will %1$snot%2$s be applied to %1$sfooter builders%2$s.', 'riode' ), '<b>', '</b>' ) . '</p>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_bottom',
		'type'      => 'custom',
		'settings'  => 'cs_fb_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Footer Bottom', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_bottom',
		'type'      => 'select',
		'settings'  => 'fb_wrap',
		'label'     => esc_html__( 'Wrap', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'fb_wrap' ),
		'choices'   => array(
			'container'       => esc_html__( 'Container', 'riode' ),
			'container-fluid' => esc_html__( 'Container Fluid', 'riode' ),
			'full'            => esc_html__( 'Full', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'     => 'footer_bottom',
		'type'        => 'text',
		'settings'    => 'fb_widgets',
		'label'       => esc_html__( 'Widget Layout', 'riode' ),
		'description' => esc_html__( 'Input "+" separated grid items ( e.g. 1/4 + 3/4 ). Empty Value will justify widgets with "space-between" property.', 'riode' ),
		'transport'   => 'postMessage',
		'default'     => riode_get_option( 'fb_widgets' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_bottom',
		'type'      => 'dimensions',
		'settings'  => 'fb_padding',
		'label'     => esc_html__( 'Footer Bottom Padding(px)', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'fb_padding' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_bottom',
		'type'      => 'toggle',
		'settings'  => 'fb_divider',
		'label'     => esc_html__( 'Add Divider to Footer Bottom', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'fb_divider' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'footer_bottom',
		'type'     => 'custom',
		'settings' => 'cs_fb_divider_link',
		'default'  => '<p style="margin: 0; cursor: auto;">' . esc_html__( 'You can change divider color in', 'riode' ) . ' <a href="#" data-target="footer_bd_color" data-type="control">' . esc_html__( 'Footer/General', 'riode' ) . '</a> section</p>',
		'active_callback' => array(
			array(
				'setting'  => 'fb_divider',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);
