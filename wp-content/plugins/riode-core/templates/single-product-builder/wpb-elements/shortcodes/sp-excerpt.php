<?php
/**
 * Riode Single Product Excerpt
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Style', 'riode-core' ) => array(
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'sp_typo',
			'selectors'  => array(
				'{{WRAPPER}} p',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'riode-core' ),
			'param_name' => 'sp_color',
			'selectors'  => array(
				'{{WRAPPER}} p' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Alignment', 'riode-core' ),
			'param_name' => 'sp_align',
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
				'{{WRAPPER}} p' => 'text-align: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Excerpt', 'riode-core' ),
		'base'            => 'wpb_riode_sp_excerpt',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_excerpt',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Short description in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Excerpt extends WPBakeryShortCode {

	}
}
