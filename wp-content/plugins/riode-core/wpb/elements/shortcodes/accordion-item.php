<?php
/**
 * Accordion Item Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Card Title', 'riode-core' ),
			'description' => esc_html__( 'Set header title of each card items.', 'riode-core' ),
			'param_name'  => 'card_title',
			'value'       => 'Card Item',
			'admin_label' => true,
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Prefix Icon', 'riode-core' ),
			'description' => esc_html__( 'Choose different prefix icon of each card headers.', 'riode-core' ),
			'param_name'  => 'card_icon',
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Prefix Icon Size', 'riode-core' ),
			'description' => esc_html__( 'Set font size of prefix icons of card headers.', 'riode-core' ),
			'param_name'  => 'card_icon_size',
			'units'       => array(
				'px',
				'rem',
			),
			'selectors'   => array(
				'{{WRAPPER}} .card-header a > i:first-child' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Prefix Icon Space', 'riode-core' ),
			'description' => esc_html__( 'Set spacing between prefix icon and card header title.', 'riode-core' ),
			'param_name'  => 'card_icon_space',
			'units'       => array(
				'px',
				'rem',
			),
			'selectors'   => array(
				'{{WRAPPER}} .card-header a > i:first-child' => 'margin-right: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Accordion Item', 'riode-core' ),
		'base'            => 'wpb_riode_accordion_item',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_accordion_item',
		'as_parent'       => array( 'except' => 'wpb_riode_accordion_item' ),
		'as_child'        => array( 'only' => 'wpb_riode_accordion' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Individual accordion items', 'riode-core' ),
		// 'default_content' => vc_is_inline() ? '[wpb_riode_tab_item tab_title="Tab 1"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_riode_tab_item][wpb_riode_tab_item tab_title="Tab 2"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_riode_tab_item][wpb_riode_tab_item tab_title="Tab 3"][vc_custom_heading text="Add anything to this tab pane" use_theme_fonts="yes"][/wpb_riode_tab_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Accordion_Item extends WPBakeryShortCodesContainer {
	}
}
