<?php
/**
 * Guide Tool tip
 * Ver 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! class_exists( 'Riode_Guide' ) ) :
	class Riode_Guide {

		protected static $instance;

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {

			// React and React-dom

			if ( ! wp_doing_ajax() ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'react_packages' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'load_guide_assets' ), 20 );
			}

			if ( function_exists( 'riode_is_elementor_preview' ) && riode_is_elementor_preview() ) {

				add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'load_guide_assets' ), 99 );
			}
			// Customizer Panel
			add_action( 'wp_ajax_riode_disable_theme_option_guide', array( $this, 'disable_theme_option_guide' ) );
			add_action( 'wp_ajax_nopriv_riode_disable_theme_option_guide', array( $this, 'disable_theme_option_guide' ) );
			add_action( 'wp_ajax_riode_get_theme_option_guide', array( $this, 'get_theme_option_guide' ) );
			add_action( 'wp_ajax_nopriv_riode_get_theme_option_guide', array( $this, 'get_theme_option_guide' ) );

			// Elementor
			add_action( 'wp_ajax_riode_disable_elementor_guide', array( $this, 'disable_elementor_guide' ) );
			add_action( 'wp_ajax_nopriv_riode_disable_elementor_guide', array( $this, 'disable_elementor_guide' ) );
			add_action( 'wp_ajax_riode_get_elementor_guide', array( $this, 'get_elementor_guide' ) );
			add_action( 'wp_ajax_nopriv_riode_get_elementor_guide', array( $this, 'get_elementor_guide' ) );
		}

		/**
		 * Add React Package js
		 */
		public function react_packages() {
			wp_enqueue_script( 'wp-element' );
		}

		/**
		 * Set Elementor Guide info
		 */
		public function disable_elementor_guide() {
			check_ajax_referer( 'riode-core-nonce', 'nonce' );
			set_theme_mod( 'elementor_starter_guide', false );
			die();
		}
		/**
		 * Get Elementor Guide info
		 */
		public function get_elementor_guide() {
			check_ajax_referer( 'riode-core-nonce', 'nonce' );
			echo riode_get_option( 'elementor_starter_guide' ) ? 'enabled' : 'disabled';
			die();
		}
		/**
		 * Add Tooltip Guide
		 */
		public function load_guide_assets() {
			if ( function_exists( 'riode_is_elementor_preview' ) && riode_is_elementor_preview() ) {
				wp_enqueue_script( 'riode-tooltip-builder', RIODE_ADDON_URI . '/starter-guide/builder-guide.min.js', null, RIODE_VERSION, true );
				wp_enqueue_style( 'riode-guide-builder', RIODE_ADDON_URI . '/starter-guide/builder-guide.css', 50 );
			}

		}
	}
endif;

Riode_Guide::get_instance();
