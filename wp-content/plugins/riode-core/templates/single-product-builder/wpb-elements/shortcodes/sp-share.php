<?php
/**
 * Riode Single Product Share
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
			'selectors'  => array(
				'{{WRAPPER}} .social-icons' => 'justify-content: {{VALUE}}; width: 100%;',
			),
		),
		array(
			'type'       => 'riode_heading',
			'heading'    => sprintf( esc_html__( 'Note: You can customize product share styles in %s', 'riode-core' ), '<a href="' . wp_customize_url() . '#share" data-target="share" data-type="section" target="_blank">' . esc_html__( 'Customize Panel/Share', 'riode-core' ) . '</a>.' ),
			'param_name' => 'share_description',
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Share', 'riode-core' ),
		'base'            => 'wpb_riode_sp_share',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_share',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Share networks in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Share extends WPBakeryShortCode {

	}
}
