<?php

/**
 * Riode Lazyload Menus Class
 *
 * @version 1.0
 */
class Riode_LazyLoad_Menus {

	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Init function
	 *
	 */
	public function init() {
		if ( is_admin() ) {
			global $pagenow;

			add_action( 'customize_save_after', array( $this, 'set_last_menu_update_time' ) );

			if ( 'post.php' == $pagenow ) {
				add_action( 'save_post', array( $this, 'set_last_menu_update_time' ) );
			}

			add_action( 'wp_update_nav_menu_item', array( $this, 'set_last_menu_update_time' ), 10, 3 );
		}

		add_action( 'wp_ajax_riode_load_menu', array( $this, 'load_menu' ) );
		add_action( 'wp_ajax_nopriv_riode_load_menu', array( $this, 'load_menu' ) );
	}


	/**
	 * set last menu update time
	 *
	 */
	public function set_last_menu_update_time() {
		set_theme_mod( 'menu_last_time', time() + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
	}


	/**
	 * Lazy-Loads Menu
	 *
	 */
	public function load_menu() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

		if ( ! shortcode_exists( 'vc_row' ) && class_exists( 'WPBMap' ) && method_exists( 'WPBMap', 'addAllMappedShortcodes' ) ) {
			WPBMap::addAllMappedShortcodes();
		}

		if ( isset( $_POST['menus'] ) && is_array( $_POST['menus'] ) ) {
			$menus = $_POST['menus'];
			if ( ! empty( $menus ) ) {
				$result = array();
				foreach ( $menus as $menu ) {
					$result[ $menu ] = wp_nav_menu(
						array(
							'menu'       => $menu,
							'container'  => '',
							'items_wrap' => '%3$s',
							'walker'     => new Riode_Walker_Nav_Menu(),
							'echo'       => false,
						)
					);
				}
				echo json_encode( $result );
			}
		}

		exit;

		// phpcs:enable
	}
}

new Riode_LazyLoad_Menus;
