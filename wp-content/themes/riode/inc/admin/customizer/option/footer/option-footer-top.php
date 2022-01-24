<?php

/**
 * Footer Top
 */

Riode_Customizer::add_section(
	'footer_top',
	array(
		'title' => esc_html__( 'Footer Top', 'riode' ),
		'panel' => 'footer',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'footer_top',
		'type'     => 'custom',
		'settings' => 'cs_footer_top_desc',
		'label'    => '',
		'default'  => '<p class="warning-alert" style="margin: 0; cursor: auto;">' . sprintf( esc_html__( 'Below options will %1$snot%2$s be applied to %1$sfooter builders%2$s.', 'riode' ), '<b>', '</b>' ) . '</p>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_top',
		'type'      => 'custom',
		'settings'  => 'cs_ft_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Footer Top', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_top',
		'type'      => 'select',
		'settings'  => 'ft_wrap',
		'label'     => esc_html__( 'Wrap', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'ft_wrap' ),
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
		'section'     => 'footer_top',
		'type'        => 'text',
		'settings'    => 'ft_widgets',
		'label'       => esc_html__( 'Widget Layout', 'riode' ),
		'description' => esc_html__( 'Input "+" separated grid items ( e.g. 1/4 + 3/4 ). Empty Value will justify widgets with "space-between" property.', 'riode' ),
		'transport'   => 'postMessage',
		'default'     => riode_get_option( 'ft_widgets' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_top',
		'type'      => 'dimensions',
		'settings'  => 'ft_padding',
		'label'     => esc_html__( 'Footer Top Padding(px)', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'ft_padding' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'footer_top',
		'type'      => 'toggle',
		'settings'  => 'ft_divider',
		'label'     => esc_html__( 'Add Divider to Footer Top', 'riode' ),
		'transport' => 'postMessage',
		'default'   => riode_get_option( 'ft_divider' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'footer_top',
		'type'     => 'custom',
		'settings' => 'cs_ft_divider_link',
		'default'  => '<p style="margin: 0; cursor: auto;">' . esc_html__( 'You can change divider color in', 'riode' ) . ' <a href="#" data-target="footer_bd_color" data-type="control">' . esc_html__( 'Footer/General', 'riode' ) . '</a> section</p>',

		'active_callback' => array(
			array(
				'setting'  => 'ft_divider',
				'operator' => '!=',
				'value'    => false,
			),
		),
	)
);
