<?php
/**
 * YITH Compatibility
 *
 * - YITH Wishlist Premium
 *
 * @since 1.4.0
 */

// YITH Wishlist Premium
if ( defined( 'YITH_WCWL_PREMIUM' ) ) {
	add_action(
		'wp_enqueue_scripts',
		function() {
			wp_enqueue_style( 'riode-yith-pro', RIODE_ASSETS . '/css/theme/pages/yith-wcwl-pro' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), RIODE_VERSION );
		},
		999
	);
}

if ( ! function_exists( 'riode_yith_wcwl_popup_heading_icon_class' ) ) {
	function riode_yith_wcwl_popup_heading_icon_class( $heading_icon ) {
		$icon = get_option( 'yith_wcwl_add_to_wishlist_icon' );

		if ( ! empty( $icon ) && 'custom' !== $icon && 'fa-heart-o' === $icon ) {
			$heading_icon = '<i class="far fa-heart"></i>';
		}

		return $heading_icon;
	}
}

add_filter( 'yith_wcwl_popup_heading_icon_class', 'riode_yith_wcwl_popup_heading_icon_class', 99 );

/**
 * YITH Ajax Filter URL
 *
 * @since 1.4.2
 * @param $link {string}
 */
if ( ! function_exists( 'riode_wc_layered_nav_link' ) ) {
	function riode_wc_layered_nav_link( $link ) {
		$is_list_type = isset( $_REQUEST['showtype'] ) && 'list' === $_REQUEST['showtype'];

		// If default show type is list type.
		if ( true === riode_get_option( 'show_as_list_type' ) && empty( $_REQUEST['showtype'] ) ) {
			$is_list_type = true;
		}

		if ( $is_list_type ) {
			return riode_add_url_parameters( $link, 'showtype', 'list' );
		} else {
			return riode_add_url_parameters( $link, 'showtype', 'grid' );
		}
	}
}

add_filter( 'woocommerce_layered_nav_link', 'riode_wc_layered_nav_link' );
