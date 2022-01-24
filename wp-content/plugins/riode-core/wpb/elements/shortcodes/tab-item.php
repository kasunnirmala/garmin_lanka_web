<?php
/**
 * Tab Item Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Tab Item Title', 'riode-core' ),
			'param_name'  => 'tab_title',
			'description' => esc_html__( 'Input heading title for each tab item.', 'riode-core' ),
			'value'       => 'Tab',
			'admin_label' => true,
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Tab Icon', 'riode-core' ),
			'param_name'  => 'icon',
			'description' => esc_html__( 'Choose icon for title of each tab item.', 'riode-core' ),
			'std'         => '',
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Icon Position', 'riode-core' ),
			'description' => esc_html__( 'Choose icon position of each tab nav. Choose from Left, Up, Right, Bottom.', 'riode-core' ),
			'param_name'  => 'icon_pos',
			'value'       => array(
				'left'  => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
				),
				'right' => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
				),
				'up'    => array(
					'title' => esc_html__( 'Up', 'riode-core' ),
				),
				'down'  => array(
					'title' => esc_html__( 'Down', 'riode-core' ),
				),
			),
			'std'         => 'left',
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Icon Spacing', 'riode-core' ),
			'description' => esc_html__( 'Controls spacing between icon and label in tab item header.', 'riode-core' ),
			'param_name'  => 'icon_space',
			'units'       => array(
				'px',
				'rem',
				'em',
			),
			'value'       => '{``xl``:``10``,``unit``:````,``xs``:````,``sm``:````,``md``:````,``lg``:````}',
			'selectors'   => array(
				'.nav-icon-left .nav-link[data-pane-selector="{{WRAPPER}}"] i' => "margin-{$right}: {{VALUE}}{{UNIT}};",
				'.nav-icon-right .nav-link[data-pane-selector="{{WRAPPER}}"] i' => "margin-{$left}: {{VALUE}}{{UNIT}};",
				'.nav-icon-up .nav-link[data-pane-selector="{{WRAPPER}}"] i' => 'margin-bottom: {{VALUE}}{{UNIT}};',
				'.nav-icon-down .nav-link[data-pane-selector="{{WRAPPER}}"] i' => 'margin-top: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name'  => 'icon_size',
			'description' => esc_html__( 'Controls icon size of tab item header.', 'riode-core' ),
			'value'       => '',
			'units'       => array(
				'px',
				'rem',
				'em',
			),
			'selectors'   => array(
				'.tab .nav-link[data-pane-selector="{{WRAPPER}}"] i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Tab Item', 'riode-core' ),
		'base'            => 'wpb_riode_tab_item',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_tab_item',
		'as_parent'       => array( 'except' => 'wpb_riode_tab_item' ),
		'as_child'        => array( 'only' => 'wpb_riode_tab' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Individual tab item', 'riode-core' ),
		'default_content' => '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Tab_Item extends  WPBakeryShortCodesContainer {
	}
}
