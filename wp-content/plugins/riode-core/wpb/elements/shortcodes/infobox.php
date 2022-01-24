<?php
/**
 * InfoBox Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'riode-core' ),
			'param_name'  => 'icon',
			'std'         => 'd-icon-truck',
			'description' => esc_html__( 'Allows you choose any icon in the library for your icon box.', 'riode-core' ),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'enable_svg',
			'heading'     => esc_html__( 'Enable SVG', 'riode-core' ),
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'description' => esc_html__( 'Enable to display SVG.​', 'riode-core' ),
		),
		array(
			'type'        => 'textarea_raw_html',
			'heading'     => esc_html__( 'SVG HTML', 'riode-core' ),
			'param_name'  => 'svg_html',
			'placeholder' => esc_html__( 'Your SVG Html...', 'riode-core' ),
			'description' => esc_html__( 'Enter your SVG Html here.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'enable_svg',
				'value'   => array(
					'yes',
				),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'View Type', 'riode-core' ),
			'param_name'  => 'view_type',
			'value'       => array(
				'Default' => '',
				'Stacked' => 'stacked',
				'Framed'  => 'framed',
			),
			'std'         => '',
			'description' => esc_html__( 'Select any view type you want to implement in your icon box.​', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Shape', 'riode-core' ),
			'param_name'  => 'shape',
			'value'       => array(
				'Circle' => 'circle',
				'Square' => '',
			),
			'std'         => 'circle',
			'description' => esc_html__( 'Select any shape you want to implement in your icon box.​', 'riode-core' ),
			'dependency'  => array(
				'element' => 'view_type',
				'value'   => array(
					'stacked',
					'framed',
				),
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'enable_hover_effect',
			'heading'     => esc_html__( 'Enable Hover Effect', 'riode-core' ),
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'description' => esc_html__( 'Determine whether your icon has hover effect or not.​', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Hover Effect', 'riode-core' ),
			'param_name'  => 'icon_hover_effect',
			'value'       => array(
				'Push Up'    => 'pushup',
				'Push Down'  => 'pushdown',
				'Push Left'  => 'pushleft',
				'Push Right' => 'pushright',
			),
			'std'         => 'pushup',
			'description' => esc_html__( 'Select any hover effect you want to implement in your icon box.​', 'riode-core' ),
			'dependency'  => array(
				'element' => 'enable_hover_effect',
				'value'   => 'yes',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'riode-core' ),
			'param_name'  => 'title',
			'value'       => 'Free Shipping & Return',
			'admin_label' => true,
			'description' => esc_html__( 'Type a title for your icon box.', 'riode-core' ),
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Description', 'riode-core' ),
			'param_name'  => 'description',
			'value'       => 'Free shipping on orders over $99',
			'admin_label' => true,
			'description' => esc_html__( 'Type a description for your icon box.', 'riode-core' ),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Link Url', 'riode-core' ),
			'param_name'  => 'link',
			'value'       => '',
			'description' => esc_html__( 'Type a certain URL to link through.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Title HTML Tag', 'riode-core' ),
			'param_name'  => 'html_tag',
			'value'       => array(
				'H1' => 'h1',
				'H2' => 'h2',
				'H3' => 'h3',
				'H4' => 'h4',
				'H5' => 'h5',
				'H6' => 'h6',
				'p'  => 'p',
			),
			'std'         => 'h3',
			'description' => esc_html__( 'Select the HTML Heading tag for icon box title from H1 to H6 and P tag, too.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Icon Position', 'riode-core' ),
			'param_name'  => 'icon_pos',
			'value'       => array(
				'left'  => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
				),
				'top'   => array(
					'title' => esc_html__( 'Top', 'riode-core' ),
				),
				'right' => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
				),
			),
			'std'         => 'left',
			'selectors'   => array(
				'{{WRAPPER}}.icon-box-right' => 'flex-direction: row-reverse;',
			),
			'description' => esc_html__( 'Select the icon position of your icon box among left, top and right.', 'riode-core' ),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		esc_html__( 'Icon', 'riode-core' )    => array(
			array(
				'type'        => 'riode_dimension',
				'param_name'  => 'icon_border',
				'heading'     => esc_html__( 'Border', 'riode-core' ),
				'responsive'  => false,
				'selectors'   => array(
					'{{WRAPPER}} .icon-box-icon' => 'border-top:{{TOP}} solid;border-right:{{RIGHT}} solid;border-bottom:{{BOTTOM}} solid;border-left:{{LEFT}} solid;',
				),
				'description' => esc_html__( 'Controls the border width of the icon wrap.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Border Radius', 'riode-core' ),
				'param_name'  => 'br_radius',
				'responsive'  => false,
				'units'       => array(
					'px',
					'%',
				),
				'selectors'   => array(
					'{{WRAPPER}}.infobox-anim .icon-box-icon-wrapper, {{WRAPPER}} .icon-box-icon' => 'border-radius: {{VALUE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the border radius of the icon wrap.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Background Size', 'riode-core' ),
				'param_name'  => 'bg_size',
				'responsive'  => false,
				'units'       => array(
					'px',
				),
				'selectors'   => array(
					'{{WRAPPER}} .icon-box-icon' => 'width: {{VALUE}}{{UNIT}};height: {{VALUE}}{{UNIT}};flex: 0 0 {{VALUE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the icon background size.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_color_group',
				'heading'     => esc_html__( 'Icon Colors', 'riode-core' ),
				'param_name'  => 'icon_color',
				'selectors'   => array(
					'normal' => '{{WRAPPER}} .icon-box-icon, {{WRAPPER}} .icon-box-icon a',
					'hover'  => '{{WRAPPER}} .icon-box-icon:hover, .icon-box-icon a:hover',
				),
				'choices'     => array( 'color', 'background-color', 'border-color' ),
				'description' => esc_html__( 'Controls the icon colors like normal color and hover color.', 'riode-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'icon_wrapper_bg',
				'heading'     => esc_html__( 'Icon Wrapper Background', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}}.infobox-anim .icon-box-icon-wrapper' => 'background-color: {{VALUE}};',
				),
				'description' => esc_html__( 'Pick your icon wrapper background. *Only available for animated icons', 'riode-core' ),
				'dependency'  => array(
					'element' => 'enable_hover_effect',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Icon Spacing', 'riode-core' ),
				'param_name'  => 'icon_space',
				'responsive'  => true,
				'units'       => array(
					'px',
				),
				'selectors'   => array(
					'{{WRAPPER}}.icon-box-left .icon-box-icon-wrapper'  => "margin-{$right}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}}.icon-box-right .icon-box-icon-wrapper' => "margin-{$left}: {{VALUE}}{{UNIT}};margin-{$right}: 0;",
					'{{WRAPPER}}.icon-box-top .icon-box-icon-wrapper'   => 'margin-bottom: {{VALUE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the gap between the icon and the title.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Icon Size', 'riode-core' ),
				'param_name'  => 'icon_size',
				'responsive'  => true,
				'units'       => array(
					'px',
				),
				'selectors'   => array(
					'{{WRAPPER}} .icon-box-icon' => 'font-size: {{VALUE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the icon size.', 'riode-core' ),
			),
		),
		esc_html__( 'Content', 'riode-core' ) => array(
			array(
				'type'        => 'riode_button_group',
				'heading'     => esc_html__( 'Alignment', 'riode-core' ),
				'param_name'  => 'content_alignment',
				'value'       => array(
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
				'std'         => 'left',
				'responsive'  => true,
				'selectors'   => array(
					'{{WRAPPER}}.icon-box'          => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .icon-box-content' => 'text-align: {{VALUE}}',
				),
				'description' => esc_html__( 'Controls the alignment of your icon box.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_button_group',
				'heading'     => esc_html__( 'Vertical Alignment', 'riode-core' ),
				'param_name'  => 'vertical_alignment',
				'value'       => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'riode-core' ),
					),
					'center'     => array(
						'title' => esc_html__( 'Middle', 'riode-core' ),
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Bottom', 'riode-core' ),
					),
				),
				'std'         => 'center',
				'selectors'   => array(
					'{{WRAPPER}}.icon-box-side' => 'align-items: {{VALUE}}',
				),
				'dependency'  => array(
					'element'            => 'icon_pos',
					'value_not_equal_to' => 'top',
				),
				'description' => esc_html__( 'Controls the vertical alignment of your icon box.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Title Spacing', 'riode-core' ),
				'param_name'  => 'title_space',
				'responsive'  => true,
				'units'       => array(
					'px',
				),
				'selectors'   => array(
					'{{WRAPPER}} .icon-box-title' => 'margin-bottom: {{VALUE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the gap between the title and the description.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Title Typography', 'riode-core' ),
				'param_name'  => 'title_font',
				'selectors'   => array(
					'{{WRAPPER}} .icon-box-title',
				),
				'description' => esc_html__( 'Controls the title typography.', 'riode-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Title Color', 'riode-core' ),
				'param_name'  => 'title_color',
				'selectors'   => array(
					'{{WRAPPER}} .icon-box-title' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the title color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Description Spacing', 'riode-core' ),
				'param_name'  => 'description_space',
				'responsive'  => true,
				'units'       => array(
					'px',
				),
				'selectors'   => array(
					'{{WRAPPER}} .icon-box-content p' => 'margin-bottom: {{VALUE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the description bottom space.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Description Typography', 'riode-core' ),
				'param_name'  => 'description_font',
				'selectors'   => array(
					'{{WRAPPER}} .icon-box-content p',
				),
				'description' => esc_html__( 'Controls the description typography.', 'riode-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Description Color', 'riode-core' ),
				'param_name'  => 'description_color',
				'selectors'   => array(
					'{{WRAPPER}} .icon-box-content p' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the description color.', 'riode-core' ),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'InfoBox', 'riode-core' ),
		'base'            => 'wpb_riode_infobox',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_infobox',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Icon boxes with different types', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Riode_Infobox extends WPBakeryShortCode {
	}
}
