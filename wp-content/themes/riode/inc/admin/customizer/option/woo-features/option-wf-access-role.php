<?php

/**
 * Woo Features/Access Roles
 *
 * @since 1.4.0    moved into woo features panel
 */

Riode_Customizer::add_section(
	'wf_access_role',
	array(
		'title' => esc_html__( 'Product Access Roles', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_access_role',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_access_roles_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_access_role',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_access_roles_description',
		'label'     => esc_html__( 'Do you want to hide some product information for visitors who are not registered? This feature enables you to give access roles for different users.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/access-roles-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_access_role',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_access_roles',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_access_role',
		'type'      => 'toggle',
		'settings'  => 'change_product_info_role',
		'label'     => esc_html__( 'Change access roles', 'riode' ),
		'tooltip'   => esc_html__( 'Enable this option to change access roles for product information.', 'riode' ),
		'default'   => riode_get_option( 'change_product_info_role' ),
		'transport' => 'refresh',
	)
);

$all_roles = array();
$roles     = wp_roles()->roles;
$roles     = apply_filters( 'editable_roles', $roles );
foreach ( $roles as $role_name => $role_info ) {
	$all_roles[ $role_name ] = $role_info['name'];
}
$all_roles['visitor'] = esc_html__( 'Visitor', 'riode' );
array_multisort( $all_roles );
$showitems = array(
	'category'  => esc_html__( 'Category', 'riode' ),
	'label'     => esc_html__( 'Label', 'riode' ),
	'price'     => esc_html__( 'Price', 'riode' ),
	'rating'    => esc_html__( 'Rating', 'riode' ),
	'attribute' => esc_html__( 'Attributes', 'riode' ),
	'addtocart' => esc_html__( 'Add To Cart', 'riode' ),
	'compare'   => esc_html__( 'Compare', 'riode' ),
	'quickview' => esc_html__( 'Quickview', 'riode' ),
	'wishlist'  => esc_html__( 'Wishlist', 'riode' ),
);
foreach ( $showitems as $key => $value ) {
	Riode_Customizer::add_field(
		'option',
		array(
			'section'         => 'wf_access_role',
			'type'            => 'select',
			'settings'        => 'product_role_info_' . $key,
			'label'           => $value,
			'choices'         => $all_roles,
			'default'         => riode_get_option( 'product_role_info_' . $key ),
			'multiple'        => 999,
			'transport'       => 'refresh',
			'active_callback' => array(
				array(
					'setting'  => 'change_product_info_role',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}
