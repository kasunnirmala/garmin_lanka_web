<?php

/**
 * WooCommerce/Checkout
 */

Riode_Customizer::add_section(
	'woocommerce_checkout',
	array(
		'title'    => esc_html__( 'Checkout', 'riode' ),
		'panel'    => 'woocommerce',
		'priority' => 5,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'woocommerce_checkout',
		'type'     => 'custom',
		'settings' => 'cs_wc_checkout_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Checkout', 'riode' ) . '</h3>',
	)
);
