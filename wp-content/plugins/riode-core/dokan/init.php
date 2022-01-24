<?php

add_filter( 'riode_main_content_class', 'riode_dokan_store_page_main_content_class' );

if ( ! function_exists( 'riode_dokan_store_page_main_content_class' ) ) {
	function riode_dokan_store_page_main_content_class( $class ) {
		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			$class .= ' row gutter-lg';
		}
		return $class;
	}
}

remove_filter( 'woocommerce_product_tabs', 'dokan_seller_product_tab' );
remove_action( 'woocommerce_product_tabs', 'dokan_set_more_from_seller_tab', 10 );

add_filter( 'dokan_store_widget_args', 'riode_dokan_store_widget_args' );
if ( ! function_exists( 'riode_dokan_store_widget_args' ) ) {
	function riode_dokan_store_widget_args( $args ) {
		$args['before_widget'] = '<aside id="%1$s" class="widget dokan-store-widget %2$s widget-collapsible">';
		return $args;
	}
}

add_filter( 'dokan_get_dashboard_nav', 'riode_dokan_get_dashboard_nav' );
if ( ! function_exists( 'riode_dokan_get_dashboard_nav' ) ) {
	function riode_dokan_get_dashboard_nav( $urls ) {
		$urls['dashboard']['icon']               = '<i class="d-icon-service2"></i>';
		$urls['products']['icon']                = '<i class="d-icon-officebag"></i>';
		$urls['orders']['icon']                  = '<i class="d-icon-bag"></i>';
		$urls['withdraw']['icon']                = '<i class="d-icon-rotate-left"></i>';
		$urls['settings']['icon']                = '<i class="far fa-sun"></i>';
		$urls['settings']['sub']['back']['icon'] = '<i class="d-icon-arrow-left"></i>';
		$urls['settings']['title']               = sprintf( '%s <i class="d-icon-angle-right"></i>', esc_html__( 'Settings', 'dokan-lite' ) );
		return $urls;
	}
}

add_filter( 'dokan_dashboard_nav_common_link', 'riode_dokan_dashboard_nav_common_link' );
if ( ! function_exists( 'riode_dokan_dashboard_nav_common_link' ) ) {
	function riode_dokan_dashboard_nav_common_link() {
		return '<li class="dokan-common-links dokan-clearfix">
			<a title="' . esc_attr__( 'Visit Store', 'dokan-lite' ) . '" class="tips" data-placement="top" href="' . esc_url( dokan_get_store_url( dokan_get_current_user_id() ) ) . '" target="_blank"><i class="fa fa-external-link"></i></a>
			<a title="' . esc_attr__( 'Edit Account', 'dokan-lite' ) . '" class="tips" data-placement="top" href="' . esc_url( dokan_get_navigation_url( 'edit-account' ) ) . '"><i class="d-icon-user"></i></a>
			<a title="' . esc_attr__( 'Log out', 'dokan-lite' ) . '" class="tips" data-placement="top" href="' . esc_url( wp_logout_url( home_url() ) ) . '"><i class="fa fa-power-off"></i></a>
		</li>';
	}
}

add_filter( 'dokan_price_kses', 'riode_dokan_price_kses' );
if ( ! function_exists( 'riode_dokan_price_kses' ) ) {
	function riode_dokan_price_kses( $price_kses ) {
		$price_kses['ins'] = array();
		$price_kses['del'] = array();
		return $price_kses;
	}
}

add_action( 'dokan_dashboard_wrap_before', 'riode_dokan_dashboard_before_wrap' );
add_action( 'dokan_dashboard_wrap_after', 'riode_dokan_dashboard_after_wrap' );

add_filter(
	'body_class',
	function( $classes ) {
		if ( in_array( 'dokan-dashboard', $classes ) && defined( 'RIODE_VERSION' ) && 'theme' == riode_get_option( 'dokan_dashboard_style' ) ) {
			$classes[] = 'riode-dokan-theme-style';
		}

		if ( class_exists( 'Dokan_Pro' ) ) {
			$classes[] = 'riode-dokan-pro-installed';
		}

		return $classes;
	},
	100
);

function riode_dokan_dashboard_before_wrap() {
	do_action( 'riode_before_content', RIODE_BEFORE_CONTENT );
	echo '<div class="page-content">';
	do_action( 'riode_print_before_page_layout' );
}

function riode_dokan_dashboard_after_wrap() {
	do_action( 'riode_print_after_page_layout', false );
	echo '</div>';
	do_action( 'riode_after_content', RIODE_AFTER_CONTENT );
}
