<?php
/**
 * Riode Block
 *
 * @since 1.1.0
 * @since 1.2.0 name option has been changed to autocomplete control from textfield control
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'        => 'autocomplete',
			'heading'     => esc_html__( 'Block ID or Slug Name', 'riode-core' ),
			'description' => esc_html__( 'Choose your favourite block from pre-built blocks.', 'riode-core' ),
			'settings'    => array(
				'multiple' => false,
				'sortable' => true,
			),
			'param_name'  => 'name',
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Block', 'riode-core' ),
		'base'            => 'wpb_riode_block',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_blcok',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Prebuilt Riode templates.', 'riode-core' ),
		'params'          => $params,
	)
);

// Block Id Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_block_name_callback', 'riode_wpb_shortcode_block_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_block_name_render', 'riode_wpb_shortcode_block_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Block extends WPBakeryShortCode {

	}
}
