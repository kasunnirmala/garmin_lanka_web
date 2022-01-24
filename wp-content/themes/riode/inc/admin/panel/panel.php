<?php
defined( 'ABSPATH' ) || die;

class Riode_Admin_Panel {

	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		$this->init_actions();
	}

	public function init_actions() {
		add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );
	}

	public function add_admin_menus() {
		if ( current_user_can( 'edit_theme_options' ) ) {
			add_menu_page( 'Riode', 'Riode', 'administrator', 'riode', array( $this, 'panel_activate' ), 'dashicons-riode-logo', '2' );
			add_submenu_page( 'riode', esc_html__( 'Welcome', 'riode' ), esc_html__( 'Welcome', 'riode' ), 'administrator', 'riode', array( $this, 'panel_activate' ) );
			add_submenu_page( 'riode', esc_html__( 'Theme Options', 'riode' ), esc_html__( 'Theme Options', 'riode' ), 'administrator', 'customize.php' );
			if ( class_exists( 'Riode_Setup_Wizard' ) ) {
				add_submenu_page(
					'riode',
					esc_html__( 'Setup Wizard', 'riode' ),
					esc_html__( 'Setup Wizard', 'riode' ),
					'manage_options',
					Riode_Setup_Wizard::get_instance()->page_slug,
					array( Riode_Setup_Wizard::get_instance(), 'view_setup_wizard' )
				);
			}
			if ( class_exists( 'Riode_Optimize_Wizard' ) ) {
				add_submenu_page(
					'riode',
					esc_html__( 'Optimize Wizard', 'riode' ),
					esc_html__( 'Optimize Wizard', 'riode' ),
					'manage_options',
					Riode_Optimize_Wizard::get_instance()->page_slug,
					array( Riode_Optimize_Wizard::get_instance(), 'view_optimize_wizard' )
				);
			}
			if ( class_exists( 'Riode_Version_Control' ) ) {
				add_submenu_page(
					'riode',
					esc_html__( 'Version Control', 'riode' ),
					esc_html__( 'Version Control', 'riode' ),
					'manage_options',
					Riode_Version_Control::get_instance()->page_slug,
					array( Riode_Version_Control::get_instance(), 'view_version_control' )
				);
			}
			if ( class_exists( 'Riode_Maintenance_Tools' ) ) {
				add_submenu_page(
					'riode',
					esc_html__( 'Maintenance Tools', 'riode' ),
					esc_html__( 'Maintenance Tools', 'riode' ),
					'manage_options',
					Riode_Maintenance_Tools::get_instance()->page_slug,
					array( Riode_Maintenance_Tools::get_instance(), 'view_maintenance_tools' )
				);
			}
			if ( class_exists( 'Riode_Layout_Dashboard' ) ) {
				add_submenu_page(
					'riode',
					esc_html__( 'Page Layouts', 'riode' ),
					esc_html__( 'Page Layouts', 'riode' ),
					'manage_options',
					Riode_Layout_Dashboard::get_instance()->page_slug,
					array( Riode_Layout_Dashboard::get_instance(), 'view_layout_dashboard' )
				);
			}
			if ( class_exists( 'Riode_Template' ) ) {
				add_submenu_page( 'riode', esc_html__( 'Templates Builder', 'riode' ), esc_html__( 'Templates Builder', 'riode' ), 'administrator', 'edit.php?post_type=riode_template' );

				if ( class_exists( 'Riode_Sidebar_Dashboard' ) ) {
					add_submenu_page( 'riode', esc_html__( 'Sidebar Manage', 'riode' ), esc_html__( 'Sidebar Manage', 'riode' ), 'administrator', 'riode_sidebar', array( Riode_Sidebar_Dashboard::get_instance(), 'sidebar_view' ) );
				}
			}
		}
	}

	public function view_header( $menu_type = 'license' ) {
		require_once RIODE_ADMIN . '/panel/views/header.php';
	}

	public function view_footer() {
		require_once RIODE_ADMIN . '/panel/views/footer.php';
	}

	public function panel_activate() {
		$this->view_header( 'license' );
		require_once RIODE_ADMIN . '/panel/views/activate.php';
		$this->view_footer();
	}
}

new Riode_Admin_Panel();
