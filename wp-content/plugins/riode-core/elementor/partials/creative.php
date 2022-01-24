<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Creative Grid Functions
 * Creative Grid Functions
 */

use Elementor\Controls_Manager;

/**
 * Register elementor layout controls for creative grid.
 */

function riode_el_creative_isotope_layout_controls( $self, $condition_key, $widget = '' ) {

	$self->add_control(
		'creative_mode',
		array(
			'label'       => esc_html__( 'Creative Layout', 'riode-core' ),
			'type'        => 'riode_image_choose',
			'default'     => 1,
			'options'     => 'posts' == $widget ? riode_post_grid_presets() : riode_creative_preset(),
			'condition'   => array(
				$condition_key => 'creative',
			),
			'description' => esc_html__( 'Select any preset to suit your need  under creative grid option.​', 'riode-core' ),
		)
	);

	$self->add_control(
		'creative_height',
		array(
			'label'       => esc_html__( 'Change Grid Height', 'riode-core' ),
			'type'        => Controls_Manager::SLIDER,
			'default'     => 'posts' == $widget ? array(
				'size' => 900,
			) : array(
				'size' => 600,
			),
			'range'       => array(
				'px' => array(
					'step' => 5,
					'min'  => 100,
					'max'  => 1000,
				),
			),
			'condition'   => array(
				$condition_key => 'creative',
			),
			'description' => esc_html__( 'Determine the height of the grid layout.', 'riode-core' ),
		)
	);

	$self->add_control(
		'creative_height_ratio',
		array(
			'label'       => esc_html__( 'Grid Mobile Height (%)', 'riode-core' ),
			'type'        => Controls_Manager::SLIDER,
			'default'     => array(
				'size' => 75,
			),
			'range'       => array(
				'%' => array(
					'step' => 1,
					'min'  => 30,
					'max'  => 100,
				),
			),
			'condition'   => array(
				$condition_key => 'creative',
			),
			'description' => esc_html__( 'Determine the height of the grid layout on mobile.', 'riode-core' ),
		)
	);

	$self->add_control(
		'grid_float',
		array(
			'label'       => esc_html__( 'Use Float Grid', 'riode-core' ),
			'description' => esc_html__( 'The Layout will be built with only float style not using isotope plugin. This is very useful for some simple creative layouts.', 'riode-core' ),
			'type'        => Controls_Manager::SWITCHER,
			'default'     => '',
			'condition'   => array(
				$condition_key => 'creative',
			),
		)
	);
}
