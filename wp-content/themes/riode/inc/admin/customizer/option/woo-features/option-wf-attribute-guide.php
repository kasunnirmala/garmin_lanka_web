<?php

/**
 * Woo Features/Attribute Guide
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_attribute_guide',
	array(
		'title' => esc_html__( 'Attribute Guide', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_attribute_guide',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_attribute_guide_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_attribute_guide',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_attribute_guide_description',
		'label'     => esc_html__( 'You could add any guide blocks to product attributes such as size guide, color guide, dimension guide and so on.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/attribute-guide-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_attribute_guide',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_attribute_guide',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'toggle',
		'settings'  => 'attribute_guide',
		'label'     => esc_html__( 'Enable Attribute Guide', 'riode' ),
		'default'   => riode_get_option( 'product_attribute_guide' ),
		'tooltip'   => esc_html__( 'Enable this option to use attribute guide in product detail page.', 'riode' ),
		'section'   => 'wf_attribute_guide',
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_attribute_guide',
		'type'            => 'custom',
		'settings'        => 'cs_woo_feature_attribute_guide_guide',
		'label'           => '<p class="options-custom-description important-note">' . sprintf( esc_html__( 'Build your guide block with %1$sRiode Template Builder/Block Builder%2$s and select it in %3$sattribute edit page%2$s.', 'riode' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=block' ) ) . '" target="__blank">', '</a>', '<a href="' . esc_url( admin_url( 'edit.php?post_type=product&page=product_attributes' ) ) . '" target="__blank">' ) . '</p>',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'attribute_guide',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
