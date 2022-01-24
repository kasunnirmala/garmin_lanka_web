<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_action( 'widgets_init', 'riode_add_widgets' );

function riode_add_widgets() {
	$widgets = array( 'block', 'social_link', 'posts', 'contact_info' );

	if ( defined( 'DOKAN_PLUGIN_VERSION' ) ) {
		$widgets[] = 'vendor_info';
		$widgets[] = 'more_products';
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$widgets[] = 'price_filter';
		$widgets[] = 'products';
		$widgets[] = 'clean_toggle';
	}

	foreach ( $widgets as $widget ) {
		include_once RIODE_CORE_PATH . '/sidebar-widgets/' . $widget . '.php';
		register_widget( 'Riode_' . ucfirst( $widget ) . '_Sidebar_Widget' );
	}
}

/* Compatabilities */
add_filter(
	'widget_nav_menu_args',
	function( $nav_menu_args, $menu, $args, $instance ) {
		$nav_menu_args['items_wrap'] = '<ul id="%1$s" class="menu collapsible-menu">%3$s</ul>';
		return $nav_menu_args;
	},
	10,
	4
);
