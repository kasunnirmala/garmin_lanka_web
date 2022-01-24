<?php

/**
 * Woo Features/Hurry Up Notification
 *
 * @since 1.4.0    moved into woo features panel
 */

Riode_Customizer::add_section(
	'wf_hurryup_notification',
	array(
		'title' => esc_html__( 'Hurry Up Notification', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_hurryup_notification',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_hurryup_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_hurryup_notification',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_hurryup_description',
		'label'     => esc_html__( 'In single product page, you can show hurryup notification for some products that have low stock count. This option is widely used to motivate customers buy your products.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/hurryup-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_hurryup_notification',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_hurryup',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'        => 'number',
		'settings'    => 'product_hurryup_limit',
		'label'       => esc_html__( 'Hurry Up Stock Limit', 'riode' ),
		'default'     => riode_get_option( 'product_hurryup_limit' ),
		'tooltip'     => esc_html__( 'Control product stock count limit to show hurry up notification.', 'riode' ),
		'section'     => 'wf_hurryup_notification',
		'transport'   => 'refresh',
	)
);
