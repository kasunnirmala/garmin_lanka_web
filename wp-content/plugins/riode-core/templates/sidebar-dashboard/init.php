<?php
/**
 * Riode_Single_Product_Builder class
 */
defined( 'ABSPATH' ) || die;

define( 'RIODE_SIDEBAR_DASHBOARD', RIODE_CORE_TEMPLATE . '/sidebar-dashboard' );

class Riode_Sidebar_Dashboard {

	private static $instance = null;

	protected $sidebars;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		if ( isset( $_GET['page'] ) && 'riode_sidebar' == $_GET['page'] ) {
			riode_remove_all_admin_notices();

			$this->_init_sidebars();

			add_filter( 'riode_core_admin_localize_vars', array( $this, 'add_localize_vars' ) );
		}

		/* Ajax */
		add_action( 'wp_ajax_riode_add_widget_area', array( $this, 'add_sidebar' ) );
		add_action( 'wp_ajax_nopriv_riode_add_widget_area', array( $this, 'add_sidebar' ) );
		add_action( 'wp_ajax_riode_remove_widget_area', array( $this, 'remove_sidebar' ) );
		add_action( 'wp_ajax_nopriv_riode_remove_widget_area', array( $this, 'remove_sidebar' ) );
	}

	private function _init_sidebars() {
		$sidebars = get_option( 'riode_sidebars' );
		if ( $sidebars ) {
			$sidebars       = json_decode( $sidebars, true );
			$this->sidebars = $sidebars;
		} else {
			$this->sidebars = array();
		}
	}

	public function add_localize_vars( $vars ) {
		$vars['sidebars']  = $this->sidebars;
		$vars['admin_url'] = esc_url( admin_url() );
		return $vars;
	}

	public function sidebar_view() {
		if ( class_exists( 'Riode_Admin_Panel' ) ) {
			Riode_Admin_Panel::get_instance()->view_header( 'template_dashboard' );
			include RIODE_SIDEBAR_DASHBOARD . '/view.php';
			Riode_Admin_Panel::get_instance()->view_footer();
		}
	}

	public function add_sidebar() {
		if ( ! check_ajax_referer( 'riode-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		$this->_init_sidebars();

		if ( isset( $_POST['slug'] ) && isset( $_POST['name'] ) ) {
			$this->sidebars[ $_POST['slug'] ] = $_POST['name'];

			update_option( 'riode_sidebars', json_encode( $this->sidebars ) );

			wp_send_json_success( esc_html__( 'succesfully registered', 'riode-core' ) );
		} else {
			wp_send_json_error( 'no sidebar name or slug' );
		}
	}

	public function remove_sidebar() {
		if ( ! check_ajax_referer( 'riode-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		$this->_init_sidebars();

		if ( isset( $_POST['slug'] ) ) {
			unset( $this->sidebars[ $_POST['slug'] ] );

			update_option( 'riode_sidebars', json_encode( $this->sidebars ) );

			wp_send_json_success( esc_html__( 'succesfully removed', 'riode-core' ) );
		} else {
			wp_send_json_error( 'no sidebar name or slug' );
		}
	}
}

Riode_Sidebar_Dashboard::get_instance();
