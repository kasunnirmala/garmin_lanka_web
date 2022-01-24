<?php

/**
 * Woo Features/Attriute Swatch
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_attribute_swatch',
	array(
		'title' => esc_html__( 'Attribute Swatches (Label/Color/Image)', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_attribute_swatch',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_attr_swatch_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_attribute_swatch',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_attr_swatch_description',
		'label'     => esc_html__( 'Riode offers label, color and image swatches for attribute items in product single/archive page.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/attribute-swatch-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_attribute_swatch',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_attr_swatch',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'        => 'toggle',
		'settings'    => 'attribute_swatch',
		'label'       => esc_html__( 'Enable Attribute Swatch', 'riode' ),
		'default'     => riode_get_option( 'image_swatch' ),
		'tooltip'     => esc_html__( 'Enable this option to use attribute swatches in product single/archive page.', 'riode' ),
		'section'     => 'wf_attribute_swatch',
		'transport'   => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_attribute_swatch',
		'type'            => 'custom',
		'settings'        => 'cs_woo_feature_attr_swatch_guide',
		'label'           => '<p class="options-custom-description important-note">' . sprintf( esc_html__( '1. You could change attribute type to Label, Color and Image while you are %1$sadding/editing attribute terms%2$s.%3$s2. You can use default or custom %4$sdisplay types%5$s of attribute terms for each variable product in product edit page.', 'riode' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=product&page=product_attributes' ) ) . '" target="__blank">', '</a>', '<br>', '<b>', '</b>' ) . '</p>',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'attribute_swatch',
				'operator' => '!=',
				'value'    => '',
			),
		),
	)
);
