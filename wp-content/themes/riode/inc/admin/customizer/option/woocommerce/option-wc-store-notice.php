<?php

/**
 * WooCommerce/Store Notice
 */

Riode_Customizer::add_section(
	'woocommerce_store_notice',
	array(
		'title'    => esc_html__( 'Store Notice', 'riode' ),
		'panel'    => 'woocommerce',
		'priority' => 1,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'woocommerce_store_notice',
		'type'     => 'custom',
		'settings' => 'cs_store_notice_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Store Notice', 'riode' ) . '</h3>',
	)
);
