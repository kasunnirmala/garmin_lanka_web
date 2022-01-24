<?php
/**
 * Riode Recently Viewed Products
 *
 * @since 1.4.0
 * @package Riode Addon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Riode_Product_Recently_Viewed {
	/**
	 * Constructor
	 *
	 */
	public function __construct() {
		add_action( 'template_redirect', array( $this, 'reset_cookie_recently_viewed' ), 20 );

		if ( is_admin() ) {
			add_action( 'save_post', array( $this, 'set_recently_viewed_used' ) );
			add_action( 'delete_post', array( $this, 'unset_recently_viewed_used' ) );
		}
	}


	/**
	 * Resets cookie value with recently viewed products
	 *
	 */
	function reset_cookie_recently_viewed() {
		if ( ! is_singular( 'product' ) ) {
			return;
		}

		$recently_viewed = get_theme_mod( '_recently_viewed_used', array() );
		if ( empty( $recently_viewed ) ) {
			return;
		}

		global $post;

		if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) { // @codingStandardsIgnoreLine.
			$viewed_products = array();
		} else {
			$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
		}

		// Unset if already in viewed products list.
		$keys = array_flip( $viewed_products );

		if ( isset( $keys[ $post->ID ] ) ) {
			unset( $viewed_products[ $keys[ $post->ID ] ] );
		}

		$viewed_products[] = $post->ID;

		if ( count( $viewed_products ) > 15 ) {
			array_shift( $viewed_products );
		}

		// Store for session only.
		wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
	}


	/**
	 * Saves post id containg 'recently viewed product' widget to recently_viewed_used theme option
	 *
	 */
	public function set_recently_viewed_used( $post_id, $post = false ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! function_exists( 'get_current_screen' ) ) {
			return;
		}
		if ( 'inherit' == get_post_status( $post_id ) ) {
			return;
		}

		$is_used     = false;
		$widget_used = get_theme_mod( '_recently_viewed_used', array() );
		if ( isset( $_POST['action'] ) && 'elementor_ajax' == $_POST['action'] ) {
			$elementor_data = get_post_meta( $post_id, '_elementor_data', true );
			if ( $elementor_data && ( false !== strpos( $elementor_data, '"status":"viewed"' ) || false !== strpos( $elementor_data, '"widgetType":"wp-widget-woocommerce_recently_viewed_products"' ) ) ) {
				$is_used = true;
			}
		} else {
			$post_content = '';
			$screen       = get_current_screen();
			if ( $screen && 'post' == $screen->base && isset( $_POST['content'] ) ) {
				$post_content = wp_unslash( $_POST['content'] );
			}
			if ( ! $post_content ) {
				return;
			}
			if ( false !== stripos( $post_content, '[wpb_riode_products ' ) ) {
				$is_used = true;
			} elseif ( false !== stripos( $post_content, '[wpb_riode_products ' ) && preg_match( '/\[wpb_riode_products[^]]*status="viewed"/', $post_content ) ) {
				$is_used = true;
			}
		}

		if ( $is_used ) {
			if ( ! in_array( $post_id, $widget_used ) ) {
				$widget_used[] = (int) $post_id;
			}
		} else {
			$index = array_search( $post_id, $widget_used );
			if ( false !== $index ) {
				unset( $widget_used[ $index ] );
			}
		}
		set_theme_mod( '_recently_viewed_used', $widget_used );
	}


	/**
	 * Removes post id from recently_viewed_used theme option
	 *
	 */
	public function unset_recently_viewed_used( $post_id ) {
		$widget_used = get_theme_mod( '_recently_viewed_used', array() );
		if ( in_array( $post_id, $widget_used ) ) {
			$index = array_search( $post_id, $widget_used );
			if ( false !== $index ) {
				unset( $widget_used[ $index ] );
				set_theme_mod( '_recently_viewed_used', $widget_used );
			}
		}
	}
}

new Riode_Product_Recently_Viewed;