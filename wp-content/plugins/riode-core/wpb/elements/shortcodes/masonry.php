<?php
/**
 * Masonry Element
 *
 * @since 1.1.0
 */


$creative_layout = riode_creative_preset();

foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => $item,
	);
}

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'         => 'riode_button_group',
			'param_name'   => 'creative_mode',
			'heading'      => esc_html__( 'Creative Layout', 'riode-core' ),
			'std'          => 1,
			'button_width' => '100',
			'value'        => $creative_layout,
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Change Grid Height', 'riode-core' ),
			'param_name' => 'creative_height',
			'value'      => '600',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Grid Mobile Height (%)', 'riode-core' ),
			'param_name' => 'creative_height_ratio',
			'value'      => '75',
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'grid_float',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'heading'     => esc_html__( 'Use Float Grid', 'riode-core' ),
			'description' => esc_html__( 'The Layout will be built with only float style not using isotope plugin. This is very useful for some simple creative layouts.', 'riode-core' ),
		),
		array(
			'type'       => 'riode_button_group',
			'param_name' => 'col_sp',
			'heading'    => esc_html__( 'Columns Spacing', 'riode-core' ),
			'std'        => 'md',
			'value'      => array(
				'no' => array(
					'title' => esc_html__( 'NO', 'riode-core' ),
				),
				'xs' => array(
					'title' => esc_html__( 'XS', 'riode-core' ),
				),
				'sm' => array(
					'title' => esc_html__( 'S', 'riode-core' ),
				),
				'md' => array(
					'title' => esc_html__( 'M', 'riode-core' ),
				),
				'lg' => array(
					'title' => esc_html__( 'L', 'riode-core' ),
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Masonry', 'riode-core' ),
		'base'            => 'wpb_riode_masonry',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_masonry',
		'as_parent'       => array( 'only' => 'wpb_riode_masonry_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display elements in creative layout', 'riode-core' ),
		'default_content' => vc_is_inline() ? '[wpb_riode_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_riode_masonry_item][wpb_riode_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_riode_masonry_item][wpb_riode_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_riode_masonry_item][wpb_riode_masonry_item css=".vc_custom_1615975173573{border-top-width: 1px !important;border-right-width: 1px !important;border-bottom-width: 1px !important;border-left-width: 1px !important;border-left-color: #e1e1e1 !important;border-left-style: dashed !important;border-right-color: #e1e1e1 !important;border-right-style: dashed !important;border-top-color: #e1e1e1 !important;border-top-style: dashed !important;border-bottom-color: #e1e1e1 !important;border-bottom-style: dashed !important;}"][/wpb_riode_masonry_item]' : '',
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Masonry extends WPBakeryShortCodesContainer {
	}
}
