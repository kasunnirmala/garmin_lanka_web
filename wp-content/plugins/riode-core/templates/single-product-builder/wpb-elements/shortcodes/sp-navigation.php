<?php
/**
 * Riode Single Product Navigation
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Style', 'riode-core' ) => array(
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Alignment', 'riode-core' ),
			'param_name' => 'sp_align',
			'value'      => array(
				''         => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'   => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end' => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-navigation' => 'justify-content: {{VALUE}}',
			),
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'sp_typo',
			'selectors'  => array(
				'{{WRAPPER}} .product-nav',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'sp_nav_icon_size',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}} .product-nav a > i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Previous Icon', 'riode-core' ),
			'param_name' => 'sp_prev_icon',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Next Icon', 'riode-core' ),
			'param_name' => 'sp_next_icon',
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Normal Color', 'riode-core' ),
			'param_name' => 'sp_link_color',
			'selectors'  => array(
				'{{WRAPPER}} .product-nav li>a' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Hover Color', 'riode-core' ),
			'param_name' => 'sp_link_hover_color',
			'selectors'  => array(
				'{{WRAPPER}} .product-nav li>a:hover' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Disabled Color', 'riode-core' ),
			'param_name' => 'sp_link_disabled_color',
			'selectors'  => array(
				'{{WRAPPER}} .product-nav li.disabled>a' => 'color: {{VALUE}};',
				'{{WRAPPER}} .product-nav li.disabled'   => 'opacity: 1;',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Navigation', 'riode-core' ),
		'base'            => 'wpb_riode_sp_navigation',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_navigation',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Next/prev product in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Navigation extends WPBakeryShortCode {
	}
}
