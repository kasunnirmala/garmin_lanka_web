<?php

/**
 * Woo Features/Alert Auto Remove
 *
 * @since 1.4.0    moved into woo features panel
 */

Riode_Customizer::add_section(
	'wf_alert_autoremove',
	array(
		'title' => esc_html__( 'Auto-Remove Notices', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_alert_autoremove',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_notice_about',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_alert_autoremove',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_notice_description',
		'label'     => esc_html( 'Notifications from wishlist, checkout and other Woo pages will be removed automatically after certain time.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/notice-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_alert_autoremove',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_notice',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'        => 'text',
		'settings'    => 'wc_alert_remove',
		'label'       => esc_html__( 'Auto remove notices after (seconds)', 'riode' ),
		'default'     => riode_get_option( 'wc_alert_remove' ),
		'tooltip'     => esc_html__( 'Notices will be removed automatically after below time.', 'riode' ),
		'section'     => 'wf_alert_autoremove',
		'transport'   => 'refresh',
	)
);
