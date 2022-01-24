<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Custom Css & Js
 *
 *
 * @since 1.2.0
 * @since 1.4.0 added in independent widget file
 */

use Elementor\Controls_Manager;

add_action( 'riode_elementor_add_common_options', 'riode_elementor_add_css_js_controls', 90 );

function riode_elementor_add_css_js_controls( $self ) {
	$self->start_controls_section(
		'_riode_section_custom_css',
		array(
			'label' => __( 'Custom Page CSS', 'riode-core' ),
			'tab'   => Riode_Elementor_Editor_Custom_Tabs::TAB_CUSTOM,
		)
	);

		$self->add_control(
			'_riode_custom_css',
			array(
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 40,
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'_riode_section_custom_js',
		array(
			'label' => __( 'Custom Page JS', 'riode-core' ),
			'tab'   => Riode_Elementor_Editor_Custom_Tabs::TAB_CUSTOM,
		)
	);

		$self->add_control(
			'_riode_custom_js',
			array(
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 40,
			)
		);

	$self->end_controls_section();
}
