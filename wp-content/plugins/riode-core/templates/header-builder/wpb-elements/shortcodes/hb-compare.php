<?php
/**
 * Header Compare Button
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )       => array(
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Compare Type', 'riode-core' ),
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
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Label', 'riode-core' ),
			'param_name' => 'show_label',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Compare Label', 'riode-core' ),
			'param_name' => 'label',
			'std'        => 'Compare',
			'dependency' => array(
				'element' => 'show_label',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Icon', 'riode-core' ),
			'param_name' => 'show_icon',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Compare Icon', 'riode-core' ),
			'param_name' => 'icon',
			'dependency' => array(
				'element' => 'show_icon',
				'value'   => 'yes',
			),
			'std'        => 'd-icon-compare',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Count', 'riode-core' ),
			'param_name' => 'show_count',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency' => array(
				'element' => 'show_icon',
				'value'   => 'yes',
			),
			'std'        => 'yes',
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Mini Compare List', 'riode-core' ),
			'param_name' => 'minicompare',
			'description' => esc_html__( 'Choose where to display mini compare list', 'riode-core' ),
			'std'        => '',
			'value'      => array(
				''  => array(
					'title' => esc_html__( 'Do not show', 'riode-core' ),
					'icon'  => 'fas fa-ban',
				),
				'dropdown'  => array(
					'title' => esc_html__( 'Dropdown', 'riode-core' ),
					'icon'  => 'fas fa-arrow-down',
				),
				'offcanvas' => array(
					'title' => esc_html__( 'Off-Canvas', 'riode-core' ),
					'icon'  => 'fas fa-arrow-left',
				),
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Dropdown Position', 'riode-core' ),
			'param_name' => 'dropdown_pos',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'dependency' => array(
				'element' => 'minicompare',
				'value'   => 'dropdown',
			),
			'selectors'  => array(
				'{{WRAPPER}} .dropdown-box' => 'left: {{VALUE}}{{UNIT}}; right: auto;',
			),
		),
	),
	esc_html__( 'Compare Style', 'riode-core' ) => array(
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Compare Typography', 'riode-core' ),
			'param_name' => 'compare_typography',
			'selectors'  => array(
				'{{WRAPPER}} .compare-open',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'compare_icon',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-open i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Space', 'riode-core' ),
			'param_name' => 'compare_icon_space',
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
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Colors', 'riode-core' ),
			'param_name' => 'compare_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .compare-open',
				'hover'  => '{{WRAPPER}} .compare-dropdown:hover .compare-open',
			),
			'choices'    => array( 'color' ),
		),
	),
	esc_html__( 'Compare Badge', 'riode-core' ) => array(
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Badge Size', 'riode-core' ),
			'param_name' => 'badge_size',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Horizontal Position', 'riode-core' ),
			'param_name' => 'badge_h_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Vertical Position', 'riode-core' ),
			'param_name' => 'badge_v_position',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'top: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Count Background Color', 'riode-core' ),
			'param_name' => 'badge_count_bg_color',
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Count Color', 'riode-core' ),
			'param_name' => 'badge_count_color',
			'selectors'  => array(
				'{{WRAPPER}} .compare-count' => 'color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Header Compare', 'riode-core' ),
		'base'            => 'wpb_riode_hb_compare',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_hb_compare',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Header', 'riode-core' ),
		'description'     => esc_html__( 'Mini compare of dropdown, offcanvas type', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_HB_Compare extends WPBakeryShortCode {
	}
}
