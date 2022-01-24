<?php

/**
 * WooCommerce/Product Images
 */

Riode_Customizer::add_section(
	'woocommerce_product_images',
	array(
		'title'    => esc_html__( 'Product Images', 'riode' ),
		'panel'    => 'woocommerce',
		'priority' => 4,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'woocommerce_product_images',
		'type'     => 'custom',
		'settings' => 'cs_product_images_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Product Images', 'riode' ) . '</h3>',
	)
);
