<?php
/**
 * Riode Single Product Image
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Content', 'riode-core' ) => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Gallery Type', 'riode-core' ),
			'param_name' => 'sp_type',
			'std'        => 'default',
			'value'      => array(
				esc_html__( 'Default', 'riode-core' )    => 'default',
				esc_html__( 'Horizontal', 'riode-core' ) => 'horizontal',
				esc_html__( 'Grid', 'riode-core' )       => 'grid',
				esc_html__( 'Masonry', 'riode-core' )    => 'masonry',
				esc_html__( 'Gallery', 'riode-core' )    => 'gallery',
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Columns', 'riode-core' ),
			'param_name'  => 'col_cnt',
			'responsive'  => true,
			'value'       => '',
			'description' => 'Type numbers from 1 to 8.',
			'dependency'  => array(
				'element'            => 'sp_type',
				'value_not_equal_to' => array( 'default', 'horizontal', 'masonry' ),
			),
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
					'title' => esc_html__( 'SM', 'riode-core' ),
				),
				'md' => array(
					'title' => esc_html__( 'MD', 'riode-core' ),
				),
				'lg' => array(
					'title' => esc_html__( 'LG', 'riode-core' ),
				),
			),
			'dependency' => array(
				'element'            => 'sp_type',
				'value_not_equal_to' => array( 'default', 'horizontal' ),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Image', 'riode-core' ),
		'base'            => 'wpb_riode_sp_image',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_image',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Thumbnail gallery in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Image extends WPBakeryShortCode {

	}
}
