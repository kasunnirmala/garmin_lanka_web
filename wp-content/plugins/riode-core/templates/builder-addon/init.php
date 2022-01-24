<?php
/**
 * Riode_Single_Product_Builder class
 */
defined( 'ABSPATH' ) || die;

define( 'RIODE_BUILDER_ADDON', RIODE_CORE_TEMPLATE . '/builder-addon' );

class Riode_Builder_Addon {

	private static $instance = null;

	protected $addon;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		if ( is_admin() ) {
			if ( riode_is_elementor_preview() && isset( $_REQUEST['post'] ) && $_REQUEST['post'] ) {
				add_action( 'elementor/editor/after_enqueue_styles', array( Riode_Template::get_instance(), 'load_assets' ), 30 );
				$this->addon = true;
			} elseif ( riode_is_wpb_preview() ) {
				$this->addon = true;
			}
		}

		if ( ! $this->addon ) {
			return;
		}

		add_filter( 'riode_core_admin_localize_vars', array( $this, 'add_addon_htmls' ) );
	}

	public function add_addon_htmls( $vars ) {
		$vars['builder_addons'] = apply_filters( 'riode_builder_addon_html', array() );
		$vars['theme_url'] = esc_url( get_parent_theme_file_uri() );
		return $vars;
	}
}

Riode_Builder_Addon::get_instance();
