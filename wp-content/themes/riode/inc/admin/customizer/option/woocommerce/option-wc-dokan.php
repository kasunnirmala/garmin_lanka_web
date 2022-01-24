<?php

/**
 * WooCommerce/Dokan
 *
 * @since 1.0.3
 */

Riode_Customizer::add_section(
	'wc_dokan',
	array(
		'title'    => esc_html__( 'Dokan', 'riode' ),
		'panel'    => 'woocommerce',
		'priority' => 10,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wc_dokan',
		'type'     => 'custom',
		'settings' => 'cs_wc_dokan_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Vendor Dashboard', 'riode' ) . '</h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_dokan',
		'type'      => 'radio_buttonset',
		'settings'  => 'dokan_dashboard_style',
		'label'     => esc_html__( 'Vendor Dashboard Style', 'riode' ),
		'default'   => riode_get_option( 'dokan_dashboard_style' ),
		'transport' => 'refresh',
		'choices'   => array(
			'dokan' => esc_html__( 'Dokan', 'riode' ),
			'theme' => esc_html__( 'Theme', 'riode' ),
		),
	)
);
