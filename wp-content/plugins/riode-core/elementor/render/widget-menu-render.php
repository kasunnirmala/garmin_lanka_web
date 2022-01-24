<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Menu Widget Render
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'menu_id'             => '',
			'skin'                => 'skin1',
			'type'                => 'horizontal',
			'mobile'              => '',
			'underline'           => '',
			'label'               => '',
			'icon'                => array( 'value' => 'd-icon-bars' ),
			'hover_icon'          => array( 'value' => '' ),
			'no_bd'               => '',
			'show_home'           => '',
			'show_page'           => '',
			'tog_equal'           => '',
			'mobile_label'        => 'Links',
			'mobile_dropdown_pos' => '',
			'builder'             => 'elementor',
		),
		$atts
	)
);

if ( defined( 'RIODE_PART' ) ) {
	$args = array(
		'menu' => array(
			'menu_id'             => $menu_id,
			'skin'                => $skin,
			'type'                => $type,
			'mobile'              => $mobile == 'yes',
			'mobile_text'         => $mobile_label ? $mobile_label : 'Links',
			'underline'           => $underline,
			'label'               => $label,
			'icon'                => isset( $icon['value'] ) ? $icon['value'] : '',
			'hover_icon'          => isset( $hover_icon['value'] ) ? $hover_icon['value'] : '',
			'no_bd'               => $no_bd,
			'show_home'           => $show_home,
			'show_page'           => $show_page,
			'tog_equal'           => $tog_equal,
			'mobile_dropdown_pos' => $mobile_dropdown_pos,
		),
	);

	riode_get_template_part( RIODE_PART . '/header/elements/element-menu', null, $args );
}
