<?php
/**
 * Riode Single Product Wishlist
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Content', 'riode-core' ) => array(
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Alignment', 'riode-core' ),
			'param_name' => 'wishlist_align',
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => 'flex-start',
			'selectors'  => array(
				'{{WRAPPER}} .yith-wcwl-add-to-wishlist a' => 'justify-content: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'wishlist_typo',
			'selectors'  => array(
				'{{WRAPPER}} .yith-wcwl-add-to-wishlist',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'wishlist_icon_size',
			'units'      => array(
				'px',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .yith-wcwl-add-to-wishlist a::before' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Space', 'riode-core' ),
			'param_name' => 'wishlist_icon_space',
			'units'      => array(
				'px',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .yith-wcwl-add-to-wishlist a::before' => "margin-{$right}: {{VALUE}}{{UNIT}};",
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Normal Color', 'riode-core' ),
			'param_name' => 'wishlist_color',
			'selectors'  => array(
				'{{WRAPPER}} .yith-wcwl-add-to-wishlist a' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Hover Color', 'riode-core' ),
			'param_name' => 'wishlist_hover_color',
			'selectors'  => array(
				'{{WRAPPER}} .yith-wcwl-add-to-wishlist a:hover' => 'color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Wishlist', 'riode-core' ),
		'base'            => 'wpb_riode_sp_wishlist',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_wishlist',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Wishlist item in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Wishlist extends WPBakeryShortCode {

	}
}
