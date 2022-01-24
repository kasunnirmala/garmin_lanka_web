<?php
/**
 * Header Account Button
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )          => array(
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Account Type', 'riode-core' ),
			'param_name' => 'type',
			'std'        => 'inline',
			'value'      => array(
				'block'  => array(
					'title' => esc_html__( 'Block', 'riode-core' ),
				),
				'inline' => array(
					'title' => esc_html__( 'Inline', 'riode-core' ),
				),
			),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'riode-core' ),
			'param_name' => 'icon',
			'std'        => 'd-icon-user',
		),
		array(
			'type'       => 'riode_multiselect',
			'heading'    => esc_html__( 'Show Items', 'riode-core' ),
			'param_name' => 'account_items',
			'value'      => array(
				esc_html__( 'User Icon/Avatar', 'riode-core' )   => 'icon',
				esc_html__( 'Login/Logout Label', 'riode-core' ) => 'login',
				esc_html__( 'Register Label', 'riode-core' )     => 'register',
			),
			'std'        => 'icon,login,register',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Login Text', 'riode-core' ),
			'param_name' => 'account_login',
			'std'        => 'Log in',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Register Text', 'riode-core' ),
			'param_name' => 'account_register',
			'std'        => 'Register',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Delimiter Text', 'riode-core' ),
			'param_name'  => 'account_delimiter',
			'description' => esc_html__( 'Account Delimiter will be shown between Login and Register links', 'riode-core' ),
			'std'         => '/',
		),
	),
	esc_html__( 'Loggined Options', 'riode-core' ) => array(
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'When user is logged in', 'riode-core' ),
			'tag'        => 'h4',
			'param_name' => 'account_loggined_heading',
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Menu Dropdown', 'riode-core' ),
			'param_name'  => 'account_dropdown',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'description' => esc_html__( 'Menu that is located in Account Menu will be shown.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Logout Text', 'riode-core' ),
			'param_name'  => 'account_logout',
			'std'         => 'Log out',
			'description' => esc_html__( 'Please input %name% where you want to show current user name. ( ex: Hi, %name%! )', 'riode-core' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Avatar', 'riode-core' ),
			'param_name' => 'account_avatar',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
		),
	),
	esc_html__( 'Styles', 'riode-core' )           => array(
		esc_html__( 'Account Styles', 'riode-core' )   => array(
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Account Typography', 'riode-core' ),
				'param_name' => 'account_typography',
				'selectors'  => array(
					'{{WRAPPER}} .account > a',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
				'param_name' => 'account_icon',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .account i'      => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Icon Space', 'riode-core' ),
				'param_name' => 'account_icon_space',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .block-type i + span'  => 'margin-top: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .inline-type i + span' => 'margin-left: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Avatar Size', 'riode-core' ),
				'param_name' => 'account_avatar_size',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .account-avatar' => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Avatar Space', 'riode-core' ),
				'param_name' => 'account_avatar_space',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .block-type .account-avatar' => 'margin-bottom: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .inline-type .account-avatar' => 'margin-right: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'riode_color_group',
				'heading'    => esc_html__( 'Colors', 'riode-core' ),
				'param_name' => 'account_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .account > a',
					'hover'  => '{{WRAPPER}} .account > a:hover, {{WRAPPER}} .account-dropdown:hover > .logout',
				),
				'choices'    => array( 'color' ),
			),
		),
		esc_html__( 'Delimiter Styles', 'riode-core' ) => array(
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Delimiter Typography', 'riode-core' ),
				'param_name' => 'deimiter_typography',
				'selectors'  => array(
					'{{WRAPPER}} .account .delimiter',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Delimiter Color', 'riode-core' ),
				'param_name' => 'delimiter_color',
				'selectors'  => array(
					'{{WRAPPER}} .account .delimiter' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Delimiter Space', 'riode-core' ),
				'param_name' => 'account_delimiter_space',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
				),
				'selectors'  => array(
					'{{WRAPPER}} .account .delimiter' => 'margin-left: {{VALUE}}{{UNIT}}; margin-right: {{VALUE}}{{UNIT}}; ',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Header Account', 'riode-core' ),
		'base'            => 'wpb_riode_hb_account',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_hb_account',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Header', 'riode-core' ),
		'description'     => esc_html__( 'Account form for login/register/logout', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_HB_Account extends WPBakeryShortCode {
	}
}
