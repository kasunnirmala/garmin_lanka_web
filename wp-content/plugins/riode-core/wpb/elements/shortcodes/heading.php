<?php
/**
 * Riode Heading
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Content', 'riode-core' ),
			'description' => esc_html__( 'Select a certain content type among Custom and Dynamic.', 'riode-core' ),
			'param_name'  => 'content_type',
			'value'       => array(
				'custom'  => array(
					'title' => esc_html__( 'Custom', 'riode-core' ),
				),
				'dynamic' => array(
					'title' => esc_html__( 'Dynamic', 'riode-core' ),
				),
			),
			'std'         => 'custom',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea_raw_html',
			'heading'     => esc_html__( 'Title', 'riode-core' ),
			'description' => esc_html__( 'Type a certain heading you want to display.', 'riode-core' ),
			'param_name'  => 'heading_title',
			'value'       => base64_encode( esc_html__( 'Add Your Heading Text Here', 'riode-core' ) ),
			'dependency'  => array(
				'element' => 'content_type',
				'value'   => 'custom',
			),
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Dynamic Content', 'riode-core' ),
			'param_name'  => 'dynamic_content',
			'value'       => array(
				esc_html__( 'Page Title', 'riode-core' ) => 'title',
				esc_html__( 'Page Subtitle', 'riode-core' ) => 'subtitle',
				esc_html__( 'Products Count', 'riode-core' ) => 'product_cnt',
				esc_html__( 'Site Tag Line', 'riode-core' ) => 'site_tagline',
				esc_html__( 'Site Title', 'riode-core' ) => 'site_title',
				esc_html__( 'Current Date Time', 'riode-core' ) => 'date',
				esc_html__( 'User Info', 'riode-core' )  => 'user_info',
			),
			'dependency'  => array(
				'element' => 'content_type',
				'value'   => 'dynamic',
			),
			'description' => esc_html__( 'Select the certain dynamic content you want to show in your page. ( ex. page title, subtitle, user info and so on )', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'User Info Field', 'riode-core' ),
			'param_name'  => 'userinfo_type',
			'value'       => array(
				esc_html__( 'ID', 'riode-core' )           => 'id',
				esc_html__( 'Display Name', 'riode-core' ) => 'display_name',
				esc_html__( 'Username', 'riode-core' )     => 'login',
				esc_html__( 'First Name', 'riode-core' )   => 'first_name',
				esc_html__( 'Last Name', 'riode-core' )    => 'last_name',
				esc_html__( 'Bio', 'riode-core' )          => 'description',
				esc_html__( 'Email', 'riode-core' )        => 'email',
				esc_html__( 'Website', 'riode-core' )      => 'url',
				esc_html__( 'User Meta', 'riode-core' )    => 'meta',
			),
			'std'         => 'display_name',
			'dependency'  => array(
				'element' => 'dynamic_content',
				'value'   => 'user_info',
			),
			'description' => esc_html__( 'Select the certain user information you want to show in your page. ( ex. username, email and so on )', 'riode-core' ),
		),
		array(
			'type'        => 'riode_dropdown',
			'heading'     => esc_html__( 'HTML Tag', 'riode-core' ),
			'param_name'  => 'html_tag',
			'value'       => array(
				'H1'   => 'h1',
				'H2'   => 'h2',
				'H3'   => 'h3',
				'H4'   => 'h4',
				'H5'   => 'h5',
				'H6'   => 'h6',
				'P'    => 'p',
				'Div'  => 'div',
				'Span' => 'span',
			),
			'std'         => 'h2',
			'admin_label' => true,
			'description' => esc_html__( 'Select the HTML Heading tag from H1 to H6 and P tag,too.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Decoration Type', 'riode-core' ),
			'param_name'  => 'decoration',
			'value'       => array(
				'simple'    => array(
					'title' => esc_html__( 'Simple', 'riode-core' ),
				),
				'cross'     => array(
					'title' => esc_html__( 'Cross', 'riode-core' ),
				),
				'underline' => array(
					'title' => esc_html__( 'Underline', 'riode-core' ),
				),
			),
			'description' => esc_html__( 'Select the decoration type among Simple, Cross and Underline options. The Default type is the Simple type.', 'riode-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Hide Active Underline?', 'riode-core' ),
			'description' => esc_html__( 'Toggle for making your heading has an active underline or not.', 'riode-core' ),
			'param_name'  => 'hide_underline',
			'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'decoration',
				'value'   => 'underline',
			),
			'selectors'   => array(
				'{{WRAPPER}} .title::after' => 'content: none',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Title Align', 'riode-core' ),
			'param_name'  => 'title_align',
			'value'       => array(
				'title-left'   => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'title-center' => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'title-right'  => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'         => 'title-left',
			'description' => esc_html__( 'Controls the alignment of title. Options are left, center and right.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Decoration Spacing', 'riode-core' ),
			'description' => esc_html__( 'Controls the space between the heading and the decoration.', 'riode-core' ),
			'param_name'  => 'decoration_spacing',
			'responsive'  => true,
			'units'       => array(
				'px',
				'rem',
				'em',
				'%',
			),
			'value'       => '',
			'selectors'   => array(
				'{{WRAPPER}} .title::before' => 'margin-right: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .title::after'  => 'margin-left: {{VALUE}}{{UNIT}};',
			),
			'dependency'  => array(
				'element' => 'decoration',
				'value'   => 'cross',
			),
		),
	),
	esc_html__( 'Link', 'riode-core' )    => array(
		array(
			'type'        => 'checkbox',
			'param_name'  => 'show_link',
			'heading'     => esc_html__( 'Show Link?', 'riode-core' ),
			'description' => esc_html__( 'Toggle for making your heading has link or not.', 'riode-core' ),
			'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Link Url', 'riode-core' ),
			'description' => esc_html__( 'Type a certain URL to link through other pages.', 'riode-core' ),
			'param_name'  => 'link_url',
			'value'       => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Link Label', 'riode-core' ),
			'description' => esc_html__( 'Type a certain label of your heading link.', 'riode-core' ),
			'param_name'  => 'link_label',
			'value'       => 'Link',
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'riode-core' ),
			'description' => esc_html__( 'Upload a certain icon of your heading link.', 'riode-core' ),
			'param_name'  => 'icon',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Icon Position', 'riode-core' ),
			'description' => esc_html__( 'Select a certain position of your icon.', 'riode-core' ),
			'param_name'  => 'icon_pos',
			'value'       => array(
				'before' => array(
					'title' => esc_html__( 'Before', 'riode-core' ),
				),
				'after'  => array(
					'title' => esc_html__( 'After', 'riode-core' ),
				),
			),
			'std'         => 'after',
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Icon Spacing', 'riode-core' ),
			'description' => esc_html__( 'Type a certain number for the space between label and icon.', 'riode-core' ),
			'param_name'  => 'icon_space',
			'responsive'  => true,
			'units'       => array(
				'px',
				'rem',
				'em',
			),
			'selectors'   => array(
				'{{WRAPPER}}.icon-before i' => 'margin-right: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}}.icon-after i'  => 'margin-left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Icon Size', 'riode-core' ),
			'description' => esc_html__( 'Type a certain number for your icon size.', 'riode-core' ),
			'param_name'  => 'icon_size',
			'responsive'  => true,
			'units'       => array(
				'px',
				'rem',
				'em',
			),
			'selectors'   => array(
				'{{WRAPPER}} i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Link Align', 'riode-core' ),
			'description' => esc_html__( 'Choose a certain alignment of your heading link.', 'riode-core' ),
			'param_name'  => 'link_align',
			'value'       => array(
				'link-left'  => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'link-right' => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Link Space', 'riode-core' ),
			'description' => esc_html__( 'Type a certain number for the space between heading and link.', 'riode-core' ),
			'param_name'  => 'link_gap',
			'responsive'  => true,
			'units'       => array(
				'px',
				'%',
			),
			'selectors'   => array(
				'{{WRAPPER}} .link' => 'margin-left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show Divider', 'riode-core' ),
			'description' => esc_html__( 'Toggle for making your heading has a divider or not. It is only available in left alignment.', 'riode-core' ),
			'param_name'  => 'show_divider',
			'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'        => 'riode_dimension',
			'heading'     => esc_html__( 'Title Spacing', 'riode-core' ),
			'description' => esc_html__( 'Controls the padding of your heading.', 'riode-core' ),
			'param_name'  => 'title_spacing',
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .title' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Title Color', 'riode-core' ),
			'description' => esc_html__( 'Controls the heading color.', 'riode-core' ),
			'param_name'  => 'title_color',
			'selectors'   => array(
				'{{WRAPPER}} .title' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'        => 'riode_typography',
			'heading'     => esc_html__( 'Title Typography', 'riode-core' ),
			'description' => esc_html__( 'Controls the heading typography.', 'riode-core' ),
			'param_name'  => 'title_typography',
			'selectors'   => array(
				'{{WRAPPER}} .title',
			),
		),
		array(
			'type'        => 'riode_typography',
			'heading'     => esc_html__( 'Link Typography', 'riode-core' ),
			'description' => esc_html__( 'Controls the link typography.', 'riode-core' ),
			'param_name'  => 'link_typography',
			'selectors'   => array(
				'{{WRAPPER}} .link',
			),
		),
		array(
			'type'        => 'riode_color_group',
			'heading'     => esc_html__( 'Link Colors', 'riode-core' ),
			'description' => esc_html__( 'Controls the link colors.', 'riode-core' ),
			'param_name'  => 'link_colors',
			'group'       => esc_html__( 'General', 'riode-core' ),
			'selectors'   => array(
				'normal' => '{{WRAPPER}} .link',
				'hover'  => '{{WRAPPER}} .link:hover',
			),
			'choices'     => array( 'color' ),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Border Color', 'riode-core' ),
			'description' => esc_html__( 'Controls the border color.', 'riode-core' ),
			'param_name'  => 'border_color',
			'selectors'   => array(
				'{{WRAPPER}}.title-cross .title::before, {{WRAPPER}}.title-cross .title::after, {{WRAPPER}}.title-underline::after' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Border Active Color', 'riode-core' ),
			'description' => esc_html__( 'Controls the active border color.', 'riode-core' ),
			'param_name'  => 'border_active_color',
			'selectors'   => array(
				'{{WRAPPER}}.title-underline .title::after' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Border Height', 'riode-core' ),
			'description' => esc_html__( 'Controls the border width.', 'riode-core' ),
			'param_name'  => 'border_height',
			'units'       => array(
				'px',
				'rem',
			),
			'selectors'   => array(
				'{{WRAPPER}} .title::before, {{WRAPPER}} .title::after, {{WRAPPER}}.title-wrapper::after' => 'height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Active Border Height', 'riode-core' ),
			'description' => esc_html__( 'Controls the active border width.', 'riode-core' ),
			'param_name'  => 'active_border_height',
			'units'       => array(
				'px',
				'rem',
			),
			'selectors'   => array(
				'{{WRAPPER}}.title-underline .title::after' => 'height: {{VALUE}}{{UNIT}};',
			),
			'dependency'  => array(
				'element' => 'decoration',
				'value'   => 'underline',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Heading', 'riode-core' ),
		'base'            => 'wpb_riode_heading',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_heading',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Simple headings or title decoration with links', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Heading extends WPBakeryShortCode {
	}
}
