<?php
/*
Plugin Name: Riode Core
Plugin URI: https://d-themes.com/wordpress/riode
Description: Add more powerful features to Riode Theme
Version: 1.4.3
Author: D-Themes
Author URI: https://d-themes.com/
License: GPL2
Text Domain: riode-core
*/

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'RIODE_CORE_URI', plugin_dir_url( __FILE__ ) );                // plugin dir uri
define( 'RIODE_CORE_PATH', plugin_dir_path( __FILE__ ) );              // plugin dir path
define( 'RIODE_CORE_FUNCTIONS', RIODE_CORE_PATH . '/functions' );      // plugin functions path
define( 'RIODE_CORE_FILE', __FILE__ );
define( 'RIODE_CORE_VERSION', '1.4.3' );

class RIODE_CORE {
	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0
	*/
	public function __construct() {

		// Load text domain
		add_action( 'plugins_loaded', array( $this, 'load' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	// load required files
	public function load() {
		load_plugin_textdomain( 'riode-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		// add riode core plugin functions
		require_once RIODE_CORE_FUNCTIONS . '/core-functions.php';
		require_once RIODE_CORE_FUNCTIONS . '/hooks.php';

		// add Shortcode
		require_once RIODE_CORE_PATH . '/shortcode/shortcode.php';

		// add page builder inits
		require_once RIODE_CORE_PATH . '/elementor/init.php';
		require_once RIODE_CORE_PATH . '/gutenberg/init.php';
		require_once RIODE_CORE_PATH . '/wpb/init.php';

		// add metabox
		require_once RIODE_CORE_PATH . '/meta-box/init.php';

		// add custom sidebar widgets
		require_once RIODE_CORE_PATH . '/sidebar-widgets/init.php';

		// add riode templates
		require_once RIODE_CORE_PATH . '/templates/init.php';

		// add dokan compatibilities
		require_once RIODE_CORE_PATH . '/dokan/init.php';
	}

	/**
	 * load_scripts
	 *
	 * loads admin styles and scripts
	 *
	 * @since 1.0.0
	 * @since 1.1.0 localize script part is moved to print_footer_scripts function
	 */
	public static function load_scripts() {
		wp_enqueue_style( 'riode-core-admin', RIODE_CORE_URI . 'assets/css/admin' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), RIODE_CORE_VERSION );
		wp_enqueue_script( 'riode-core-admin', RIODE_CORE_URI . 'assets/js/admin' . riode_get_js_extension(), array(), RIODE_CORE_VERSION, true );
		wp_enqueue_script( 'wp-color-picker' );

		add_action( 'admin_print_footer_scripts', array( isset( $this ) ? $this : self::get_instance(), 'print_footer_scripts' ), 30 );
	}

	/**
	 * print_footer_scripts
	 *
	 * prints inline scripts including riode_core_vars
	 *
	 * @since 1.1.0
	 */
	public static function print_footer_scripts() {
		echo '<script id="riode-core-admin-js-extra">';
		echo 'var riode_core_vars = ' . json_encode(
			apply_filters(
				'riode_core_admin_localize_vars',
				array(
					'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'    => wp_create_nonce( 'riode-core-nonce' ),
				)
			)
		) . ';';
		echo '</script>';
	}
}

RIODE_CORE::get_instance();
