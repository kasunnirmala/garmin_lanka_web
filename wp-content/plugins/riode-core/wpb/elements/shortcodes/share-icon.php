<?php
/**
 * Share Icon Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'dropdown',
			'param_name'  => 'icon',
			'heading'     => esc_html__( 'Select Icon', 'riode-core' ),
			'description' => esc_html__( 'Select social network for each social items.', 'riode-core' ),
			'value'       => array(
				esc_html__( 'facebook', 'riode-core' )  => 'facebook',
				esc_html__( 'twitter', 'riode-core' )   => 'twitter',
				esc_html__( 'linkedin', 'riode-core' )  => 'linkedin',
				esc_html__( 'email', 'riode-core' )     => 'email',
				esc_html__( 'google', 'riode-core' )    => 'google',
				esc_html__( 'pinterest', 'riode-core' ) => 'pinterest',
				esc_html__( 'reddit', 'riode-core' )    => 'reddit',
				esc_html__( 'tumblr', 'riode-core' )    => 'tumblr',
				esc_html__( 'vk', 'riode-core' )        => 'vk',
				esc_html__( 'whatsapp', 'riode-core' )  => 'whatsapp',
				esc_html__( 'xing', 'riode-core' )      => 'xing',
				esc_html__( 'instagram', 'riode-core' ) => 'instagram',
				esc_html__( 'youtube', 'riode-core' )   => 'youtube',
				esc_html__( 'tiktok', 'riode-core' )    => 'tiktok',
				esc_html__( 'wechat', 'riode-core' )    => 'wechat',
			),
			'std'         => 'facebook',
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Link Url', 'riode-core' ),
			'description' => esc_html__( 'Please leave it blank to share this page or input URL for social login', 'riode-core' ),
			'param_name'  => 'link',
			'value'       => '',
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'social_type',
			'heading'     => esc_html__( 'Type', 'riode-core' ),
			'description' => esc_html__( 'Choose social link item type. Choose from Simple, Stacked, Framed.', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Default', 'riode-core' ) => '',
				esc_html__( 'Stacked', 'riode-core' ) => 'stacked',
				esc_html__( 'Framed', 'riode-core' )  => 'framed',
			),
			'std'         => '',
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'        => 'riode_color_group',
			'heading'     => esc_html__( 'Icon Colors', 'riode-core' ),
			'param_name'  => 'icon_color',
			'description' => esc_html__( 'Choose color scheme of social icons on normal and hover event.', 'riode-core' ),
			'selectors'   => array(
				'normal' => '{{WRAPPER}}.social-icon',
				'hover'  => '{{WRAPPER}}.social-icon:hover',
			),
			'choices'     => array( 'color', 'background-color', 'border-color' ),
			'dependency'  => array(
				'element'   => 'icon',
				'not_empty' => true,
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'        => esc_html__( 'Share Icon', 'riode-core' ),
		'base'        => 'wpb_riode_share_icon',
		'icon'        => 'riode-logo-icon',
		'class'       => 'wpb_riode_share_icon',
		'controls'    => 'full',
		'category'    => esc_html__( 'Riode', 'riode-core' ),
		'description' => esc_html__( 'Social network to share or for social login', 'riode-core' ),
		'as_child'    => array( 'only' => 'wpb_riode_share_icons' ),
		'params'      => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Share_Icon extends WPBakeryShortCode {

	}
}
