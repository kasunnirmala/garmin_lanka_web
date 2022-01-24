<?php
/**
 * Masonry Item Element
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Grid Item Width', 'riode-core' ),
			'param_name'  => 'creative_width',
			'responsive'  => true,
			'units'       => array(
				'%',
			),
			'description' => esc_html( 'Leave it blank to follow creative grid preset.', 'riode-core' ),
		),
		array(
			'type'       => 'riode_dropdown',
			'heading'    => esc_html__( 'Grid Item Height', 'riode-core' ),
			'param_name' => 'creative_height',
			'responsive' => true,
			'value'      => array(
				esc_html__( 'Preset', 'riode-core' )   => 'preset',
				'1'                                    => '1',
				'1/2'                                  => '1-2',
				'1/3'                                  => '1-3',
				'2/3'                                  => '2-3',
				'1/4'                                  => '1-4',
				'3/4'                                  => '3-4',
				'1/5'                                  => '1-5',
				'2/5'                                  => '2-5',
				'3/5'                                  => '3-5',
				'4/5'                                  => '4-5',
				esc_html__( 'Children', 'riode-core' ) => 'child',
			),
		),
		array(
			'type'        => 'riode_dropdown',
			'heading'     => esc_html__( 'Grid Item Order', 'riode-core' ),
			'param_name'  => 'creative_order',
			'responsive'  => true,
			'value'       => array(
				esc_html__( 'Default', 'riode-core' ) => '',
				'1'                                   => '1',
				'2'                                   => '2',
				'3'                                   => '3',
				'4'                                   => '4',
				'5'                                   => '5',
				'6'                                   => '6',
				'7'                                   => '7',
				'8'                                   => '8',
				'9'                                   => '9',
				'10'                                  => '10',
			),
			'description' => esc_html( 'Item order option does not work for float grid layout.', 'riode-core' ),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Masonry Item', 'riode-core' ),
		'base'            => 'wpb_riode_masonry_item',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_masonry_item',
		'as_parent'       => array( 'except' => 'wpb_riode_masonry_item' ),
		'as_child'        => array( 'only' => 'wpb_riode_masonry' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Individual masonry item', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Masonry_Item extends WPBakeryShortCodesContainer {
	}
}
