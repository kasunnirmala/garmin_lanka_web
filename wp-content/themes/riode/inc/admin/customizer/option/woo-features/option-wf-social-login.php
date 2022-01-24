<?php

/**
 * Woo Features/Social Login
 *
 * @since 1.4.0    moved into woo features panel
 */

Riode_Customizer::add_section(
	'wf_social_login',
	array(
		'title' => esc_html__( 'Social Login', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_social_login',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_social_login_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_social_login',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_social_login_description',
		'label'     => esc_html__( "With this feature, customers could be allowed to login your site with famous social site's user information.", 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/social-login-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_social_login',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_social_login',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_social_login',
		'type'      => 'toggle',
		'settings'  => 'social_login',
		'label'     => esc_html__( 'Enable Social Login', 'riode' ),
		'tooltip'   => esc_html__( 'Enable this option to use social login feature in your site.', 'riode' ),
		'default'   => riode_get_option( 'social_login' ),
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_social_login',
		'type'            => 'custom',
		'settings'        => 'cs_woo_feature_social_login_guide',
		'label'           => '<p class="options-custom-description important-note">' . sprintf( esc_html__( 'This feature needs %1$sNextend Social Login%2$s plugin to work fully.', 'riode' ), '<b>', '</b>' ) . '</p>',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'social_login',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
