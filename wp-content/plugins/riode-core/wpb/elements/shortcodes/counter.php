<?php
/**
 * Riode Counter
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Content', 'riode-core' ) => array(
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Starting Number', 'riode-core' ),
			'param_name'  => 'starting_number',
			'std'         => 0,
			'description' => esc_html__( 'Type the number which will be the start number of your counter.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Ending Number', 'riode-core' ),
			'param_name'  => 'res_number',
			'std'         => 50,
			'description' => esc_html__( 'Type the number which will be the end number of your counter.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Number Prefix', 'riode-core' ),
			'param_name'  => 'prefix',
			'std'         => '',
			'selectors'   => array(
				'{{WRAPPER}} .count-to:before' => 'content: "{{VALUE}}"',
			),
			'description' => esc_html__( 'Type the number prefix which will be before the number.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Number Suffix', 'riode-core' ),
			'param_name'  => 'suffix',
			'std'         => '',
			'selectors'   => array(
				'{{WRAPPER}} .count-to:after' => 'content: "{{VALUE}}"',
			),
			'description' => esc_html__( 'Type the number suffix which will be after the number.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Animation Duration (ms)', 'riode-core' ),
			'param_name'  => 'duration',
			'std'         => 2000,
			'description' => esc_html__( 'Type the number for the animation duration of the counter. The unit is ms.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'riode-core' ),
			'param_name'  => 'title',
			'std'         => esc_html__( 'Add Your Text Here', 'riode-core' ),
			'description' => esc_html__( 'Type the title of the counter.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Subtitle', 'riode-core' ),
			'param_name'  => 'subtitle',
			'std'         => esc_html__( 'Add Your Description Text Here', 'riode-core' ),
			'description' => esc_html__( 'Type the subtitle of the counter.', 'riode-core' ),
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Alignment', 'riode-core' ),
			'param_name' => 'counter_align',
			'value'      => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'selectors'  => array(
				'{{WRAPPER}}' => 'text-align: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		esc_html__( 'Number', 'riode-core' )   => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'param_name' => 'number_color',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-riode-counter-number-wrapper' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'param_name' => 'number_typo',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-riode-counter-number-wrapper .count-to',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'param_name' => 'counter_margin',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-riode-counter-number-wrapper' => 'margin-top: {{TOP}}; margin-right: {{RIGHT}}; margin-bottom: {{BOTTOM}}; margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Title', 'riode-core' )    => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'param_name' => 'title_color',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-riode-counter-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'param_name' => 'title_typo',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-riode-counter-title',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'param_name' => 'title_margin',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-riode-counter-title' => 'margin-top: {{TOP}}; margin-right: {{RIGHT}}; margin-bottom: {{BOTTOM}}; margin-left: {{LEFT}};',
				),
			),
		),
		esc_html__( 'Subtitle', 'riode-core' ) => array(
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'param_name' => 'subtitle_color',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-riode-counter-subtitle' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Typography', 'riode-core' ),
				'param_name' => 'subtitle_typo',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-riode-counter-subtitle',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Margin', 'riode-core' ),
				'param_name' => 'subtitle_margin',
				'selectors'  => array(
					'{{WRAPPER}} .wpb-riode-counter-subtitle' => 'margin-top: {{TOP}}; margin-right: {{RIGHT}}; margin-bottom: {{BOTTOM}}; margin-left: {{LEFT}};',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Counter', 'riode-core' ),
		'base'            => 'wpb_riode_counter',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_counter',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Counterup timer from zero value', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Riode_Counter extends WPBakeryShortCode {

	}
}
