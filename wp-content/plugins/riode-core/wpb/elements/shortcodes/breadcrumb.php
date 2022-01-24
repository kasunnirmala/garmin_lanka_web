<?php
/**
 * Riode Breadcrumb
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'riode_heading',
			'heading'     => esc_html__( 'Note:', 'riode-core' ),
			'param_name'  => 'breadcrumb_description',
			'description' => sprintf( esc_html__( '%1$s In most case breadcrumb is placed on page header, so its default color is %2$swhite%3$s. Please choose different color in %2$sstyle options section%3$s for other purposes.%4$s', 'riode-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Delimiter', 'riode-core' ),
			'param_name'  => 'delimiter',
			'description' => esc_html__( 'Changes breadcrumb delimiter text between each links.', 'riode-core' ),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Delimiter Icon', 'riode-core' ),
			'param_name'  => 'delimiter_icon',
			'description' => esc_html__( 'Choose delimiter icon that will be placed between each links.', 'riode-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Home Icon', 'riode-core' ),
			'param_name'  => 'home_icon',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'description' => esc_html__( "Set to show home icon instead of 'home' link.", 'riode-core' ),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'        => 'riode_typography',
			'heading'     => esc_html__( 'Typography', 'riode-core' ),
			'param_name'  => 'breadcrumb_typography',
			'description' => esc_html__( 'Controls font family, size, weight, line height and letter spacing value of breadcrumb links.', 'riode-core' ),
			'selectors'   => array(
				'{{WRAPPER}} .breadcrumb',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Alignment', 'riode-core' ),
			'param_name'  => 'align',
			'description' => esc_html__( 'Changes alignment of breadcrumb. Choose from left, center, right.', 'riode-core' ),
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
			'selectors'   => array(
				'{{WRAPPER}} .breadcrumb' => 'justify-content: {{VALUE}};',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Color', 'riode-core' ),
			'param_name'  => 'normal_color',
			'description' => esc_html__( 'Choose normal text color of breadcrumb links. Default color is white with 0.5 opacity.', 'riode-core' ),
			'selectors'   => array(
				'{{WRAPPER}} .breadcrumb'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .breadcrumb a' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Active Color', 'riode-core' ),
			'param_name'  => 'active_color',
			'description' => esc_html__( 'Choose active or hover color of breadcrumb links. Default color is white.', 'riode-core' ),
			'selectors'   => array(
				'{{WRAPPER}} .breadcrumb'         => 'color: {{VALUE}};',
				'{{WRAPPER}} .breadcrumb a'       => 'opacity: 1;',
				'{{WRAPPER}} .breadcrumb a:hover' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Delimiter Size', 'riode-core' ),
			'param_name'  => 'delimiter_size',
			'description' => esc_html__( 'Controls size of breadcrumb delimiter text or icon.', 'riode-core' ),
			'units'       => array(
				'px',
				'rem',
			),
			'value'       => '',
			'selectors'   => array(
				'{{WRAPPER}} .delimiter' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Delimiter Space', 'riode-core' ),
			'param_name'  => 'delimiter_space',
			'description' => esc_html__( 'Controls space between breadcrumb links.', 'riode-core' ),
			'units'       => array(
				'px',
				'rem',
			),
			'value'       => '',
			'selectors'   => array(
				'{{WRAPPER}} .delimiter' => 'margin: 0 {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Padding', 'riode-core' ),
			'param_name' => 'button_padding',
			'selectors'  => array(
				'{{WRAPPER}} .breadcrumb' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Breadcrumb', 'riode-core' ),
		'base'            => 'wpb_riode_breadcrumb',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_breadcrumb',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Page/post hierarchical navigation', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Breadcrumb extends WPBakeryShortCode {

	}
}
