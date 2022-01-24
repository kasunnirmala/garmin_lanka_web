<?php
defined( 'ABSPATH' ) || die;

define( 'RIODE_SETUP_WIZARD', RIODE_ADMIN . '/setup_wizard' );

if ( ! class_exists( 'Riode_Setup_Wizard' ) ) :
	/**
	* Riode Theme Setup Wizard
	*/
	class Riode_Setup_Wizard {

		protected $version = '1.0';

		protected $theme_name = '';

		protected $step = '';

		protected $steps = array();

		public $page_slug;

		protected $tgmpa_instance;

		protected $tgmpa_menu_slug = 'tgmpa-install-plugins';

		protected $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';

		protected $page_url;

		protected $riode_url = 'https://d-themes.com/wordpress/riode/';

		protected $demo;

		public $demo_import_post_types         = array( 'page', 'riode_template', 'post', 'product', 'nav_menu_item' );
		public $demo_import_taxonomies         = array( 'category', 'product_cat' );
		public $demo_import_product_attributes = array( 'Color', 'Size', 'Brand' );
		public $woopages                       = array(
			'woocommerce_shop_page_id'      => 'Riode Shop',
			'woocommerce_cart_page_id'      => 'Shopping Cart',
			'woocommerce_checkout_page_id'  => 'Checkout',
			'woocommerce_myaccount_page_id' => 'My Account',
		);

		private static $instance = null;

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			$this->current_theme_meta();
			$this->init_setup_wizard();
		}

		public function current_theme_meta() {
			$current_theme    = wp_get_theme();
			$this->theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
			$this->page_slug  = 'riode-setup-wizard';
			$this->page_url   = 'admin.php?page=' . $this->page_slug;
		}

		public function init_setup_wizard() {
			add_action( 'upgrader_post_install', array( $this, 'upgrader_post_install' ), 10, 2 );

			if ( apply_filters( $this->theme_name . '_enable_setup_wizard', false ) ) {
				return;
			}

			if ( ! is_child_theme() ) {
				add_action( 'after_switch_theme', array( $this, 'switch_theme' ) );
			}

			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				add_action( 'init', array( $this, 'get_tgmpa_instanse' ), 30 );
				add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );
			}

			add_action( 'admin_init', array( $this, 'admin_redirects' ), 30 );
			add_action( 'admin_init', array( $this, 'init_wizard_steps' ), 30 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ), 30 );
			// Plugin Install
			add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
			add_action( 'wp_ajax_riode_setup_wizard_plugins', array( $this, 'ajax_plugins' ) );
			//Demo Import
			add_action( 'wp_ajax_riode_reset_menus', array( $this, 'reset_menus' ) );
			add_action( 'wp_ajax_riode_reset_widgets', array( $this, 'reset_widgets' ) );
			add_action( 'wp_ajax_riode_import_dummy', array( $this, 'import_dummy' ) );
			add_action( 'wp_ajax_riode_import_dummy_step_by_step', array( $this, 'import_dummy_step_by_step' ) );
			add_action( 'wp_ajax_riode_import_widgets', array( $this, 'import_widgets' ) );
			add_action( 'wp_ajax_riode_import_icons', array( $this, 'import_icons' ) );
			add_action( 'wp_ajax_riode_import_options', array( $this, 'import_options' ) );
			add_action( 'wp_ajax_riode_import_subpages', array( $this, 'import_subpages' ) );
			add_action( 'wp_ajax_riode_update_menu_links', array( $this, 'update_menu_links' ) );
			add_action( 'wp_ajax_riode_delete_tmp_dir', array( $this, 'delete_tmp_dir' ) );
			add_action( 'wp_ajax_riode_download_demo_file', array( $this, 'download_demo_file' ) );

			add_filter( 'wp_import_existing_post', array( $this, 'import_override_contents' ), 10, 2 );
			add_action( 'import_start', array( $this, 'import_dummy_start' ) );
			add_action( 'import_end', array( $this, 'import_dummy_end' ) );

			// add_action( 'riode_importer_update_post', array( $this, 'save_old_id' ), 10, 2 );
			// add_action( 'wp_import_insert_post', array( $this, 'save_old_id' ), 10, 2 );

			if ( ( ! empty( $_GET['page'] ) && $this->page_slug === $_GET['page'] ) || ( wp_doing_ajax() && isset( $_REQUEST['action'] ) && 0 === strpos( $_REQUEST['action'], 'riode_' ) ) ) {
				require_once 'class-riode-demo-history.php';
				new Riode_Demo_History();
			}
		}

		public function upgrader_post_install( $return, $theme ) {
			if ( is_wp_error( $return ) ) {
				return $return;
			}
			if ( get_stylesheet() != $theme ) {
				return $return;
			}
			update_option( 'riode_setup_complete', false );

			return $return;
		}

		public function switch_theme() {
			set_transient( '_' . $this->theme_name . '_activation_redirect', 1 );
		}

		public function admin_redirects() {
			ob_start();

			if ( ! get_transient( '_' . $this->theme_name . '_activation_redirect' ) || get_option( 'riode_setup_complete', false ) ) {
				return;
			}
			delete_transient( '_' . $this->theme_name . '_activation_redirect' );
			wp_safe_redirect( admin_url( $this->page_url ) );
			exit;
		}

		public function get_tgmpa_instanse() {
			$this->tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		}

		public function set_tgmpa_url() {

			$this->tgmpa_menu_slug = ( property_exists( $this->tgmpa_instance, 'menu' ) ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
			$this->tgmpa_menu_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_tgmpa_menu_slug', $this->tgmpa_menu_slug );

			$tgmpa_parent_slug = ( property_exists( $this->tgmpa_instance, 'parent_slug' ) && 'themes.php' !== $this->tgmpa_instance->parent_slug ) ? 'admin.php' : 'themes.php';

			$this->tgmpa_url = apply_filters( $this->theme_name . '_theme_setup_wizard_tgmpa_url', $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug );

		}

		public function init_wizard_steps() {

			$this->steps['status'] = array(
				'step_id' => 1,
				'name'    => esc_html__( 'Status', 'riode' ),
				'view'    => array( $this, 'view_status' ),
				'handler' => '',
			);

			$this->steps['customize'] = array(
				'step_id' => 2,
				'name'    => esc_html__( 'Child Theme', 'riode' ),
				'view'    => array( $this, 'view_customize' ),
				'handler' => '',
			);

			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				$this->steps['default_plugins'] = array(
					'step_id' => 3,
					'name'    => esc_html__( 'Plugins', 'riode' ),
					'view'    => array( $this, 'view_default_plugins' ),
					'handler' => '',
				);
			}

			$this->steps['demo_content'] = array(
				'step_id' => 4,
				'name'    => esc_html__( 'Demo Import', 'riode' ),
				'view'    => array( $this, 'view_demo_content' ),
				'handler' => array( $this, 'riode_setup_wizard_demo_content_save' ),
			);

			$this->steps['ready'] = array(
				'step_id' => 5,
				'name'    => esc_html__( 'Ready!', 'riode' ),
				'view'    => array( $this, 'view_ready' ),
				'handler' => '',
			);

			$this->steps = apply_filters( $this->theme_name . '_theme_setup_wizard_steps', $this->steps );
		}

		// enqueue style & script
		public function enqueue() {

			if ( empty( $_GET['page'] ) || $this->page_slug !== $_GET['page'] ) {
				return;
			}

			$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

			// Style

			wp_enqueue_style( 'riode-setup_wiard', RIODE_CSS . '/admin/wizard' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );
			wp_enqueue_style( 'magnific-popup', RIODE_CSS . '/3rd-plugins/magnific-popup' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), '1.0' );
			wp_enqueue_style( 'wp-admin' );
			wp_enqueue_media();

			// Script
			wp_enqueue_script( 'isotope-pkgd', RIODE_ASSETS . '/vendor/isotope/isotope.pkgd.min.js', array( 'jquery-core', 'imagesloaded' ), '3.0.6', true );
			wp_enqueue_script( 'jquery-magnific-popup', RIODE_ASSETS . '/vendor/jquery.magnific-popup/jquery.magnific-popup.min.js', array( 'jquery-core' ), '1.1.0', true );
			wp_enqueue_script( 'riode-admin-wizard', RIODE_JS . '/admin/wizard' . riode_get_js_extension(), array( 'jquery-core' ), true, 50 );
			wp_enqueue_script( 'media' );

			wp_localize_script(
				'riode-admin-wizard',
				'riode_setup_wizard_params',
				array(
					'tgm_plugin_nonce' => array(
						'update'  => wp_create_nonce( 'tgmpa-update' ),
						'install' => wp_create_nonce( 'tgmpa-install' ),
					),
					'tgm_bulk_url'     => esc_url( admin_url( $this->tgmpa_url ) ),
					'wpnonce'          => wp_create_nonce( 'riode_setup_wizard_nonce' ),
					'texts'            => array(
						'confirm_leave'    => esc_html__( 'Are you sure you want to leave?', 'riode' ),
						'confirm_override' => esc_html__( 'Are you sure to import demo contents and override old one?', 'riode' ),
						/* translators: $1 and $2 opening and closing strong tags respectively */
						'import_failed'    => vsprintf( esc_html__( 'Failed importing! Please check the %1$s"System Status"%2$s tab to ensure your server meets all requirements for a successful import. Settings that need attention will be listed in red. If your server provider does not allow to update settings, please try using alternative import mode.', 'riode' ), array( '<a href="' . esc_url( $this->page_url . '&step=status' ) . '" target="_blank">', '</a>' ) ),
						'install_failed'   => esc_html__( ' installation is failed!', 'riode' ),
						'install_finished' => esc_html__( ' installation is finished!', 'riode' ),
						'installing'       => esc_html__( 'Installing', 'riode' ),
						'visit_your_site'  => esc_html__( 'Visit your site.', 'riode' ),
						'failed'           => esc_html__( 'Failed', 'riode' ),
						'ajax_error'       => esc_html__( 'Ajax error', 'riode' ),
					),
				)
			);
		}

		/**
		 * Display setup wizard
		 */
		public function view_setup_wizard() {
			if ( ! Riode_Admin::get_instance()->is_registered() ) {
				wp_redirect( admin_url( 'admin.php?page=riode' ) );
			}
			Riode_Admin_Panel::get_instance()->view_header( 'license' );
			include RIODE_SETUP_WIZARD . '/views/index.php';
			Riode_Admin_Panel::get_instance()->view_footer();
		}

		public function view_step() {
			$show_content = true;
			if ( ! empty( $_REQUEST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) {
				$show_content = call_user_func( $this->steps[ $this->step ]['handler'] );
			}
			if ( $show_content && isset( $this->steps[ $this->step ] ) ) {
				call_user_func( $this->steps[ $this->step ]['view'] );
			}
		}

		/**
		 * Output the step contents
		 */
		public function view_status() {
			include RIODE_SETUP_WIZARD . '/views/status.php';
		}
		public function view_customize() {
			include RIODE_SETUP_WIZARD . '/views/customize.php';
		}
		public function view_default_plugins() {

			tgmpa_load_bulk_installer();
			if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
				die( esc_html__( 'Failed to find TGM', 'riode' ) );
			}
			$url     = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'riode-setup-wizard' );
			$plugins = $this->_get_plugins();

			$method = '';
			$fields = array_keys( $_POST );

			if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
				return true;
			}

			if ( ! WP_Filesystem( $creds ) ) {
				request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );
				return true;
			}

			include RIODE_SETUP_WIZARD . '/views/plugins.php';
		}
		public function view_demo_content() {
			$url    = wp_nonce_url( add_query_arg( array( 'demo_content' => 'go' ) ), 'riode-setup-wizard' );
			$method = '';
			$fields = array_keys( $_POST );
			if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
				return true;
			}

			if ( ! WP_Filesystem( $creds ) ) {
				request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );
				return true;
			}
			include RIODE_SETUP_WIZARD . '/views/demo.php';
		}
		public function view_support() {
			include RIODE_SETUP_WIZARD . '/views/support.php';
		}
		public function view_ready() {
			include RIODE_SETUP_WIZARD . '/views/ready.php';
		}

		/**
		 * Save actions
		 */
		public function riode_setup_wizard_welcome_save() {
			check_admin_referer( 'riode-setup-wizard' );
			return false;
		}

		public function riode_setup_wizard_demo_content_save() {
			check_admin_referer( 'riode-setup-wizard' );
			if ( ! empty( $_POST['new_logo_id'] ) ) {
				$new_logo_id = (int) $_POST['new_logo_id'];
				if ( $new_logo_id ) {
					set_theme_mod( 'custom_logo', $new_logo_id );
				}
			}
			wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
			die();
		}

		/**
		 * Create child theme
		 */
		private function _make_child_theme( $new_theme_title ) {

			$parent_theme_title    = 'Riode';
			$parent_theme_template = 'riode';
			$parent_theme_name     = get_stylesheet();
			$parent_theme_dir      = get_stylesheet_directory();

			$new_theme_name = sanitize_title( $new_theme_title );
			$theme_root     = get_theme_root();

			$new_theme_path = $theme_root . '/' . $new_theme_name;
			if ( ! file_exists( $new_theme_path ) ) {
				wp_mkdir_p( $new_theme_path );

				$plugin_folder = get_parent_theme_file_path( 'inc/admin/setup_wizard/riode-child/' );

				ob_start();
				require $plugin_folder . 'style.css.php';
				$css = ob_get_clean();

				// filesystem
				global $wp_filesystem;
				// Initialize the WordPress filesystem, no more using file_put_contents function
				if ( empty( $wp_filesystem ) ) {
					require_once ABSPATH . '/wp-admin/includes/file.php';
					WP_Filesystem();
				}

				if ( ! $wp_filesystem->put_contents( $new_theme_path . '/style.css', $css, FS_CHMOD_FILE ) ) {
					echo '<p class="lead success">';
					/* translators: %s: path */
					printf( esc_html__( 'Directory permission required for %s', 'riode' ), '/wp-content/themes.' );
					echo '</p>';
					return;
				}

				// Copy functions.php
				copy( $plugin_folder . 'functions.php', $new_theme_path . '/functions.php' );

				// Copy screenshot
				copy( $plugin_folder . 'screenshot.jpg', $new_theme_path . '/screenshot.jpg' );

				// Make child theme an allowed theme (network enable theme)
				$allowed_themes[ $new_theme_name ] = true;
			}

			// Switch to theme
			if ( $parent_theme_template !== $new_theme_name ) {

				echo '<p class="lead success">';
				/* translators: %1$s: Theme name, %1$s: br tag, %3$s: path */
				printf( esc_html__( 'Child Theme %1$s has been created and activated!%2$s Folder is located in %3$s', 'riode' ), '<strong>' . esc_html( $new_theme_title ) . '</strong>', '<br />', 'wp-content/themes/<strong>' . esc_html( $new_theme_name ) . '</strong>' );
				echo '</p>';
				switch_theme( $new_theme_name, $new_theme_name );
			}
		}

		/**
		 * Install plugins
		 */
		public function tgmpa_load( $status ) {
			return is_admin() || current_user_can( 'install_themes' );
		}

		private function _get_plugins() {
			$instance         = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
			$plugin_func_name = 'is_plugin_active';
			$plugins          = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);

			foreach ( $instance->plugins as $slug => $plugin ) {
				if ( 'setup' != $plugin['usein'] || ( $instance->$plugin_func_name( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) ) {
					continue;
				} else {
					$plugins['all'][ $slug ] = $plugin;

					if ( ! $instance->is_plugin_installed( $slug ) ) {
						$plugins['install'][ $slug ] = $plugin;
					} else {
						if ( false !== $instance->does_plugin_have_update( $slug ) ) {
							$plugins['update'][ $slug ] = $plugin;
						}

						if ( $instance->can_plugin_activate( $slug ) ) {
							$plugins['activate'][ $slug ] = $plugin;
						}
					}
				}
			}
			return $plugins;
		}
		public function ajax_plugins() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
				wp_send_json_error(
					array(
						'error'   => 1,
						'message' => esc_html__(
							'No Slug Found',
							'riode'
						),
					)
				);
			}
			$json = array();
			// send back some json we use to hit up TGM
			$plugins = $this->_get_plugins();
			// what are we doing with this plugin?
			foreach ( $plugins['activate'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => esc_url( admin_url( $this->tgmpa_url ) ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-activate',
						'action2'       => -1,
						'message'       => esc_html__( 'Activating Plugin', 'riode' ),
					);
					break;
				}
			}
			foreach ( $plugins['update'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => esc_url( admin_url( $this->tgmpa_url ) ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-update',
						'action2'       => -1,
						'message'       => esc_html__( 'Updating Plugin', 'riode' ),
					);
					break;
				}
			}
			foreach ( $plugins['install'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => esc_url( admin_url( $this->tgmpa_url ) ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-install',
						'action2'       => -1,
						'message'       => esc_html__( 'Installing Plugin', 'riode' ),
					);
					break;
				}
			}

			if ( $json ) {
				$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
				wp_send_json( $json );
			} else {
				wp_send_json(
					array(
						'done'    => 1,
						'message' => esc_html__(
							'Success',
							'riode'
						),
					)
				);
			}
			exit;
		}


		/**
		 * Step links
		 */
		public function get_step_link( $step ) {
			return add_query_arg( 'step', $step, admin_url( 'admin.php?page=' . $this->page_slug ) );
		}
		public function get_next_step_link() {
			$keys = array_keys( $this->steps );
			return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) + 1 ], remove_query_arg( 'translation_updated' ) );
		}

		/**
		 * Demo Import
		 */
		private function get_demo_file( $demo = false ) {
			if ( ! $demo ) {
				$demo = ( isset( $_POST['demo'] ) && $_POST['demo'] ) ? sanitize_text_field( $_POST['demo'] ) : 'landing';
			}

			$this->demo = $demo;

			// Return demo file path
			require_once RIODE_PLUGINS . '/importer/importer-api.php';

			$importer_api = new Riode_Importer_API( $demo );

			$demo_file_path = $importer_api->get_remote_demo();

			if ( ! $demo_file_path ) {
				echo json_encode(
					array(
						'process' => 'error',
						'message' => esc_html__( 'Remote API error.', 'riode' ),
					)
				);
				die();
			} elseif ( is_wp_error( $demo_file_path ) ) {
				echo json_encode(
					array(
						'process' => 'error',
						'message' => $demo_file_path->get_error_message(),
					)
				);
				die();
			}
			return $demo_file_path;
		}

		private function get_file_data( $path ) {
			$data = false;
			$path = wp_normalize_path( $path );
			// filesystem
			global $wp_filesystem;
			// Initialize the WordPress filesystem, no more using file_put_contents function
			if ( empty( $wp_filesystem ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}
			if ( $wp_filesystem->exists( $path ) ) {
				$data = $wp_filesystem->get_contents( $path );
			}
			return $data;
		}

		public function download_demo_file() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce', false ) ) {
				die();
			}
			$this->get_demo_file();
			echo json_encode( array( 'process' => 'success' ) );
			die();
		}

		/**
		 * Delete temporary directory
		 */
		function delete_tmp_dir() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce', false ) ) {
				die();
			}
			$demo = ( isset( $_POST['demo'] ) && $_POST['demo'] ) ? sanitize_text_field( $_POST['demo'] ) : 'landing';

			// Importer remote API
			require_once RIODE_PLUGINS . '/importer/importer-api.php';
			$importer_api = new Riode_Importer_API( $demo );

			$importer_api->delete_temp_dir();
			die();
		}

		function reset_menus() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce' ) ) {
				die();
			}
			if ( current_user_can( 'manage_options' ) ) {
				do_action( 'riode_importer_before_reset_menus' );

				$import_shortcodes = ( isset( $_POST['import_shortcodes'] ) && 'true' == $_POST['import_shortcodes'] ) ? true : false;
				if ( $import_shortcodes ) {
					$menus = array( 'Main Menu', 'Category Menu', 'Top Navigation', 'Currency Switcher', 'Language Switcher', 'Footer Nav 1', 'Footer Nav 2', 'Footer Nav 3', 'Deal Menu', 'Category Menu 1', 'Category Menu 2', 'Header Nav' );
				} else {
					$menus = array( 'Main Menu', 'Category Menu', 'Top Navigation', 'Currency Switcher', 'Language Switcher', 'Footer Nav 1', 'Footer Nav 2', 'Footer Nav 3', 'Deal Menu', 'Category Menu 1', 'Category Menu 2', 'Header Nav' );
				}

				foreach ( $menus as $menu ) {
					wp_delete_nav_menu( $menu );
				}
				esc_html_e( 'Successfully reset menus!', 'riode' );
			}
			die;
		}

		function reset_widgets() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce' ) ) {
				die();
			}
			if ( current_user_can( 'manage_options' ) ) {
				do_action( 'riode_importer_before_import_widgets' );

				ob_start();
				$sidebars_widgets = retrieve_widgets();
				foreach ( $sidebars_widgets as $area => $widgets ) {
					foreach ( $widgets as $key => $widget_id ) {
						$pieces       = explode( '-', $widget_id );
						$multi_number = array_pop( $pieces );
						$id_base      = implode( '-', $pieces );
						$widget       = get_option( 'widget_' . $id_base );
						unset( $widget[ $multi_number ] );
						update_option( 'widget_' . $id_base, $widget );
						unset( $sidebars_widgets[ $area ][ $key ] );
					}
				}

				update_option( 'sidebars_widgets', $sidebars_widgets );
				ob_clean();
				ob_end_clean();
				esc_html_e( 'Successfully reset widgets!', 'riode' );
			}
			die;
		}

		function import_dummy() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce', false ) ) {
				die();
			}
			global $import_logo;
			if ( empty( $import_logo ) ) {
				$import_logo = get_theme_mod( 'custom_logo' );
			}
			if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
				define( 'WP_LOAD_IMPORTERS', true ); // we are loading importers
			}
			if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
				require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			}
			if ( ! class_exists( 'WP_Import' ) ) { // if WP importer doesn't exist
				require_once RIODE_PLUGINS . '/importer/wordpress-importer.php';
			}
			if ( current_user_can( 'manage_options' ) && class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) { // check for main import class and wp import class

				$demo                        = ( isset( $_POST['demo'] ) && $_POST['demo'] ) ? sanitize_text_field( $_POST['demo'] ) : 'landing';
				$process                     = ( isset( $_POST['process'] ) && $_POST['process'] ) ? sanitize_text_field( $_POST['process'] ) : 'import_start';
				$demo_path                   = $this->get_demo_file();
				$importer                    = new WP_Import();
				$theme_xml                   = $demo_path . '/content.xml';
				$importer->fetch_attachments = true;

				$this->import_before_functions( $demo );

				// ob_start();
				$response = $importer->import( $theme_xml, $process );
				// ob_end_clean();

				if ( 'import_start' == $process && $response ) {
					echo json_encode(
						array(
							'process' => 'importing',
							'count'   => 0,
							'index'   => 0,
							'message' => 'success',
						)
					);
				} else {
					$this->import_after_functions( $demo );
				}
			}
			die();
		}

		function import_override_contents( $post_exists, $post ) {
			$override_contents = ( isset( $_POST['override_contents'] ) && 'true' == $_POST['override_contents'] ) ? true : false;
			if ( ! $override_contents || ( $post_exists && get_post_type( $post_exists ) != 'revision' ) ) {
				return $post_exists;
			}

			// remove posts which have same ID
			$processed_duplicates = get_option( 'riode_import_processed_duplicates', array() );
			if ( in_array( $post['post_id'], $processed_duplicates ) ) {
				return false;
			}
			$old_post = get_post( $post['post_id'] );
			if ( $old_post ) {
				if ( $old_post->post_type == $post['post_type'] && in_array( $post['post_type'], $this->demo_import_post_types ) ) {
					return $post['post_id'];
				}
				if ( defined( 'ELEMENTOR_VERSION' ) && 'kit' == get_post_meta( $post['post_id'], '_elementor_template_type', true ) ) {
					$_GET['force_delete_kit'] = true;
				}
				wp_delete_post( $post['post_id'], true );
				unset( $_GET['force_delete_kit'] );
			}

			// remove posts which have same title and slug
			global $wpdb;

			$post_title = wp_unslash( sanitize_post_field( 'post_title', $post['post_title'], 0, 'db' ) );
			$post_name  = wp_unslash( sanitize_post_field( 'post_name', $post['post_name'], 0, 'db' ) );

			$query  = "SELECT ID FROM $wpdb->posts WHERE 1=1";
			$args   = array();
			$query .= ' AND post_title = %s';
			$args[] = $post_title;
			$query .= ' AND post_name = %s';
			$args[] = $post_name;

			$old_post = (int) $wpdb->get_var( $wpdb->prepare( $query, $args ) );

			if ( $old_post && get_post_type( $old_post ) == $post['post_type'] ) {
				if ( in_array( $post['post_type'], $this->demo_import_post_types ) ) {
					$processed_duplicates[] = $old_post;
					update_option( 'riode_import_processed_duplicates', $processed_duplicates );
					return $old_post;
				}
				if ( defined( 'ELEMENTOR_VERSION' ) && 'kit' == get_post_meta( $old_post, '_elementor_template_type', true ) ) {
					$_GET['force_delete_kit'] = true;
				}
				wp_delete_post( $old_post, true );
				unset( $_GET['force_delete_kit'] );
			}

			return false;
		}

		function import_dummy_start() {
			$process = ( isset( $_POST['process'] ) && $_POST['process'] ) ? sanitize_text_field( $_POST['process'] ) : 'import_start';
			if ( current_user_can( 'manage_options' ) && 'import_start' == $process ) {
				delete_option( 'riode_import_processed_duplicates' );
			}

			if ( class_exists( 'WC_Comments' ) ) {
				remove_action( 'wp_update_comment_count', array( 'WC_Comments', 'clear_transients' ) );
			}
		}

		function import_dummy_end() {
			if ( current_user_can( 'manage_options' ) && isset( $_POST['action'] ) && 'riode_import_dummy' === $_POST['action'] ) {
				ob_end_clean();
				ob_start();
				echo json_encode(
					array(
						'process' => 'complete',
						'message' => 'success',
					)
				);
				ob_end_flush();
				ob_start();
			}

			if ( class_exists( 'WC_Comments' ) ) {
				add_action( 'wp_update_comment_count', array( 'WC_Comments', 'clear_transients' ) );
			}
		}

		function import_dummy_step_by_step() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce' ) ) {
				die();
			}

			global $import_logo;
			if ( empty( $import_logo ) ) {
				$import_logo = get_theme_mod( 'custom_logo' );
			}

			if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
				define( 'WP_LOAD_IMPORTERS', true ); // we are loading importers
			}

			if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
				$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
				include $wp_importer;
			}

			if ( ! class_exists( 'Riode_WP_Import' ) ) { // if WP importer doesn't exist
				$wp_import = RIODE_PLUGINS . '/importer/riode-wordpress-importer.php';
				include $wp_import;
			}

			if ( current_user_can( 'manage_options' ) && class_exists( 'WP_Importer' ) && class_exists( 'Riode_WP_Import' ) ) { // check for main import class and wp import class

				$process   = ( isset( $_POST['process'] ) && $_POST['process'] ) ? sanitize_text_field( $_POST['process'] ) : 'import_start';
				$demo      = ( isset( $_POST['demo'] ) && $_POST['demo'] ) ? sanitize_text_field( $_POST['demo'] ) : 'landing';
				$index     = ( isset( $_POST['index'] ) && $_POST['index'] ) ? (int) $_POST['index'] : 0;
				$demo_path = $this->get_demo_file();

				$importer                    = new Riode_WP_Import();
				$theme_xml                   = $demo_path . '/content.xml';
				$importer->fetch_attachments = true;

				if ( 'import_start' == $process ) {
					$this->import_before_functions( $demo );
				}

				$loop = (int) ( ini_get( 'max_execution_time' ) / 60 );
				if ( $loop < 1 ) {
					$loop = 1;
				}
				if ( $loop > 10 ) {
					$loop = 10;
				}
				$i = 0;
				while ( $i < $loop ) {
					$response = $importer->import( $theme_xml, $process, $index );
					if ( isset( $response['count'] ) && isset( $response['index'] ) && $response['count'] && $response['index'] && $response['index'] < $response['count'] ) {
						$i++;
						$index = $response['index'];
					} else {
						break;
					}
				}

				echo json_encode( $response );
				ob_start();
				if ( 'complete' == $response['process'] ) {
					$this->import_after_functions( $demo );
				}
				ob_end_clean();
			}
			die();
		}

		function import_widgets() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce' ) ) {
				die();
			}
			if ( current_user_can( 'manage_options' ) ) {
				do_action( 'riode_importer_before_import_widgets' );

				// Import widgets
				$demo_path   = $this->get_demo_file();
				$widget_data = $this->get_file_data( $demo_path . '/widget_data.json' );
				$this->before_replacement();
				$widget_data = preg_replace_callback( '|(\"nav_menu\":)(\d+)|', array( $this, 'replace_term_ids' ), $widget_data );
				$this->import_widget_data( $widget_data );
				esc_html_e( 'Successfully imported widgets!', 'riode' );
				flush_rewrite_rules();
			}
			die();
		}
		function import_override_subpages( $post_exists, $post ) {
			// remove posts which have same title and slug
			global $wpdb;

			$post_title = wp_unslash( sanitize_post_field( 'post_title', $post['post_title'], 0, 'db' ) );
			$post_name  = wp_unslash( sanitize_post_field( 'post_name', $post['post_name'], 0, 'db' ) );

			$query  = "SELECT ID FROM $wpdb->posts WHERE 1=1";
			$args   = array();
			$query .= ' AND post_title = %s';
			$args[] = $post_title;
			$query .= ' AND post_name = %s';
			$args[] = $post_name;

			$old_post = (int) $wpdb->get_var( $wpdb->prepare( $query, $args ) );

			if ( $old_post && get_post_type( $old_post ) == $post['post_type'] ) {
				wp_delete_post( $old_post, true );
			}

			return false;
		}
		function import_subpages() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce', false ) ) {
				die();
			}
			if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
				define( 'WP_LOAD_IMPORTERS', true ); // we are loading importers
			}
			if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
				require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			}
			if ( ! class_exists( 'WP_Import' ) ) { // if WP importer doesn't exist
				require_once RIODE_PLUGINS . '/importer/wordpress-importer.php';
			}

			if ( current_user_can( 'manage_options' ) && class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) { // check for main import class and wp import class
				$process   = ( isset( $_POST['process'] ) && $_POST['process'] ) ? sanitize_text_field( $_POST['process'] ) : 'import_start';
				$builder   = isset( $_REQUEST['builder'] ) ? $_REQUEST['builder'] : '';
				$demo_path = $this->get_demo_file( 'subpages' );

				$importer  = new WP_Import();
				$theme_xml = $demo_path . '/subpages.xml';
				if ( 'wpb' == $builder ) {
					$theme_xml = $demo_path . '/wpb-subpages.xml';
				}
				$importer->fetch_attachments = true;

				add_filter( 'wp_import_existing_post', array( $this, 'import_override_subpages' ), 11, 2 );
				// ob_start();
				$response = $importer->import( $theme_xml, $process );
				// ob_end_clean();
				if ( 'import_start' == $process && $response ) {
					echo json_encode(
						array(
							'process' => 'importing',
							'count'   => 0,
							'index'   => 0,
							'message' => 'success',
						)
					);
				}
				remove_filter( 'wp_import_existing_post', array( $this, 'import_override_subpages' ), 11 );
				flush_rewrite_rules();
				die();
			}
		}

		function update_menu_links() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce', false ) ) {
				die();
			}
			// Add PageLayout Options
			$page_layouts      = riode_get_option( 'page_layouts' );
			$layout_counter    = riode_get_option( 'layout_counter' );
			$layout_conditions = riode_get_option( 'layout_conditions' );

			foreach ( $page_layouts as $key => $item ) {
				if ( ! empty( $item['imported'] ) && 'true' == $item['imported'] && ( 'Subpages' == $item['name'] || 'Coming Soon' == $item['name'] ) ) {
					unset( $page_layouts[ $key ] );
				}
			}

			$page_layouts[ 'layout-' . $layout_counter ] = array(
				'name'      => 'Subpages',
				'imported'  => 'true',
				'content'   => array(
					'general' => array(
						'wrap'           => 'full',
						'center_content' => 'true',
					),
				),
				'condition' => array(),
			);

			$page_layouts[ 'layout-' . ( $layout_counter + 1 ) ] = array(
				'name'      => 'Coming Soon',
				'imported'  => 'true',
				'content'   => array(
					'general' => array(
						'wrap'           => 'full',
						'center_content' => 'true',
					),
					'header'  => array(
						'id' => -1,
					),
					'ptb'     => array(
						'id' => -1,
					),
					'footer'  => array(
						'id' => -1,
					),
				),
				'condition' => array(),
			);

			$about_us    = $this->importer_get_page_by_title( 'About Us' );
			$contact_us  = $this->importer_get_page_by_title( 'Contact Us' );
			$faqs        = $this->importer_get_page_by_title( 'FAQs' );
			$coming_soon = $this->importer_get_page_by_title( 'Coming Soon' );

			if ( ! isset( $layout_conditions['page'] ) ) {
				$layout_conditions['page'] = array( 'individual' => array() );
			} elseif ( ! isset( $layout_conditions['page']['individual'] ) ) {
				$layout_conditions['page']['individual'] = array();
			}

			if ( $about_us && $about_us->ID ) {
				$layout_conditions['page']['individual'][ $about_us->ID ]   = 'layout-' . $layout_counter;
				$page_layouts[ 'layout-' . $layout_counter ]['condition'][] = array(
					'category'    => 'page',
					'subcategory' => 'individual',
					'id'          => array(
						'id'    => $about_us->ID,
						'title' => 'About Us',
					),
				);
			}
			if ( $contact_us && $contact_us->ID ) {
				$layout_conditions['page']['individual'][ $contact_us->ID ] = 'layout-' . $layout_counter;
				$page_layouts[ 'layout-' . $layout_counter ]['condition'][] = array(
					'category'    => 'page',
					'subcategory' => 'individual',
					'id'          => array(
						'id'    => $contact_us->ID,
						'title' => 'Contact Us',
					),
				);
			}
			if ( $faqs && $faqs->ID ) {
				$layout_conditions['page']['individual'][ $faqs->ID ]       = 'layout-' . $layout_counter;
				$page_layouts[ 'layout-' . $layout_counter ]['condition'][] = array(
					'category'    => 'page',
					'subcategory' => 'individual',
					'id'          => array(
						'id'    => $faqs->ID,
						'title' => 'FAQs',
					),
				);
			}
			if ( $coming_soon && $coming_soon->ID ) {
				$layout_conditions['page']['individual'][ $coming_soon->ID ]        = 'layout-' . ( $layout_counter + 1 );
				$page_layouts[ 'layout-' . ( $layout_counter + 1 ) ]['condition'][] = array(
					'category'    => 'page',
					'subcategory' => 'individual',
					'id'          => array(
						'id'    => $coming_soon->ID,
						'title' => 'Coming Soon',
					),
				);
			}

			set_theme_mod( 'page_layouts', $page_layouts );
			set_theme_mod( 'layout_counter', $layout_counter + 2 );
			set_theme_mod( 'layout_conditions', $layout_conditions );

			// Update custom links in menu items.
			global $wpdb;
			$menu_items = $wpdb->get_results( $wpdb->prepare( "SELECT posts.ID FROM $wpdb->posts AS posts JOIN $wpdb->postmeta AS meta ON ( posts.ID = meta.post_id and meta.meta_key = %s and meta.meta_value = %s )", '_menu_item_type', 'custom' ) );

			if ( ! empty( $menu_items ) ) {
				foreach ( $menu_items as $item ) {
					$custom_menu = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE post_id=%s AND meta_key=%s", $item->ID, '_menu_item_url' ) );
					$custom_menu = $custom_menu[0];
					$post_id     = -1;
					if ( preg_match( '/(contact-us)/', $custom_menu->meta_value ) ) {
						$post_id = $contact_us->ID;
					}
					if ( preg_match( '/(faqs)/', $custom_menu->meta_value ) ) {
						$post_id = $faqs->ID;
					}
					if ( preg_match( '/(about-us)/', $custom_menu->meta_value ) ) {
						$post_id = $about_us->ID;
					}
					if ( preg_match( '/(coming-soon)/', $custom_menu->meta_value ) ) {
						$post_id = $coming_soon->ID;
					}

					if ( $post_id > 0 ) {
						update_post_meta( $item->ID, '_menu_item_url', get_permalink( $post_id ) );
					}
				}
			}
			echo 'success';
			die();
		}
		function import_options() {
			if ( ! check_ajax_referer( 'riode_setup_wizard_nonce', 'wpnonce' ) ) {
				die();
			}
			if ( current_user_can( 'manage_options' ) ) {
				do_action( 'riode_importer_before_import_options' );

				$demo_path = $this->get_demo_file();
				ob_start();
				include $demo_path . '/theme_options.php';
				$options = ob_get_clean();

				ob_start();
				$options = str_replace( 'IMPORT_SITE_URL', get_home_url(), $options );
				$options = json_decode( $options, true );
				if ( ! isset( $options['theme'] ) || ! isset( $options['sidebars'] ) ) {
					die();
				}

				ob_clean();
				ob_end_clean();
				echo 'success';
				try {
					update_option( 'riode_sidebars', $options['sidebars'] );
					riode_import_theme_options( false, $options['theme'] );
				} catch ( Exception $e ) {
					esc_html_e( 'Please compile default css files by publishing options in customize panel.', 'riode' );
				}
			}
			die();
		}

		private function get_post_id_from_imported_id( $import_id, $demo ) {
			global $wpdb;
			$result = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_riode_demo' AND meta_value = %s LIMIT 1", sanitize_title( $demo ) . '#' . sanitize_title( $import_id ) ) );
			if ( $result ) {
				return array(
					'id'    => (int) $result,
					'title' => '',
				);
			}
			return false;
		}

		// Parsing Widgets Function
		// Reference: http://wordpress.org/plugins/widget-settings-importexport/
		private function import_widget_data( $widget_data ) {
			$json_data = $widget_data;
			$json_data = json_decode( $json_data, true );

			$sidebar_data = $json_data[0];
			$widget_data  = $json_data[1];

			foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
				$widgets[ $widget_data_title ] = array();
				foreach ( $widget_data_value as $widget_data_key => $widget_data_array ) {
					if ( is_int( $widget_data_key ) ) {
						$widgets[ $widget_data_title ][ $widget_data_key ] = 'on';
					}
				}
			}
			unset( $widgets[''] );

			foreach ( $sidebar_data as $title => $sidebar ) {
				$count = count( $sidebar );
				for ( $i = 0; $i < $count; $i++ ) {
					$widget               = array();
					$widget['type']       = trim( substr( $sidebar[ $i ], 0, strrpos( $sidebar[ $i ], '-' ) ) );
					$widget['type-index'] = trim( substr( $sidebar[ $i ], strrpos( $sidebar[ $i ], '-' ) + 1 ) );
					if ( ! isset( $widgets[ $widget['type'] ][ $widget['type-index'] ] ) ) {
						unset( $sidebar_data[ $title ][ $i ] );
					}
				}
				$sidebar_data[ $title ] = array_values( $sidebar_data[ $title ] );
			}

			foreach ( $widgets as $widget_title => $widget_value ) {
				foreach ( $widget_value as $widget_key => $widget_value ) {
					$widgets[ $widget_title ][ $widget_key ] = $widget_data[ $widget_title ][ $widget_key ];
				}
			}

			$sidebar_data = array( array_filter( $sidebar_data ), $widgets );
			$this->parse_import_data( $sidebar_data );
		}
		private function parse_import_data( $import_array ) {
			global $wp_registered_sidebars;
			$sidebars_data    = $import_array[0];
			$widget_data      = $import_array[1];
			$current_sidebars = get_option( 'sidebars_widgets' );
			$new_widgets      = array();

			foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

				foreach ( $import_widgets as $import_widget ) :
					// if the sidebar exists
					if ( isset( $wp_registered_sidebars[ $import_sidebar ] ) ) :
						$title               = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
						$index               = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
						$current_widget_data = get_option( 'widget_' . $title );
						$new_widget_name     = $this->get_new_widget_name( $title, $index );
						$new_index           = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

						if ( ! empty( $new_widgets[ $title ] ) && is_array( $new_widgets[ $title ] ) ) {
							while ( array_key_exists( $new_index, $new_widgets[ $title ] ) ) {
								$new_index++;
							}
						}
						$current_sidebars[ $import_sidebar ][] = $title . '-' . $new_index;
						if ( array_key_exists( $title, $new_widgets ) ) {
							$new_widgets[ $title ][ $new_index ] = $widget_data[ $title ][ $index ];
							$multiwidget                         = $new_widgets[ $title ]['_multiwidget'];
							unset( $new_widgets[ $title ]['_multiwidget'] );
							$new_widgets[ $title ]['_multiwidget'] = $multiwidget;
						} else {
							$current_widget_data[ $new_index ] = $widget_data[ $title ][ $index ];
							$current_multiwidget               = ( isset( $current_widget_data['_multiwidget'] ) ) ? $current_widget_data['_multiwidget'] : '';
							$new_multiwidget                   = isset( $widget_data[ $title ]['_multiwidget'] ) ? $widget_data[ $title ]['_multiwidget'] : false;
							$multiwidget                       = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
							unset( $current_widget_data['_multiwidget'] );
							$current_widget_data['_multiwidget'] = $multiwidget;
							$new_widgets[ $title ]               = $current_widget_data;
						}

					endif;
				endforeach;
			endforeach;

			if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
				update_option( 'sidebars_widgets', $current_sidebars );

				foreach ( $new_widgets as $title => $content ) {
					update_option( 'widget_' . $title, $content );
				}

				return true;
			}

			return false;
		}
		private function get_new_widget_name( $widget_name, $widget_index ) {
			$current_sidebars = get_option( 'sidebars_widgets' );
			$all_widget_array = array();
			foreach ( $current_sidebars as $sidebar => $widgets ) {
				if ( ! empty( $widgets ) && is_array( $widgets ) && 'wp_inactive_widgets' != $sidebar ) {
					foreach ( $widgets as $widget ) {
						$all_widget_array[] = $widget;
					}
				}
			}
			while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
				$widget_index++;
			}
			$new_widget_name = $widget_name . '-' . $widget_index;
			return $new_widget_name;
		}
		private function importer_get_page_by_title( $page_title, $output = OBJECT ) {
			global $wpdb;
			$page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id and $wpdb->postmeta.meta_key = %s ) WHERE $wpdb->posts.post_title = %s AND $wpdb->posts.post_type = %s order by $wpdb->postmeta.meta_value desc limit 1", 'riode_imported_date', $page_title, 'page' ) );

			if ( $page ) {
				return get_post( $page, $output );
			}
		}
		private function import_before_functions( $demo ) {
		}

		// public function add_import_id( $type, $new_id, $old_id ) {
		// 	if ( 'term' == $type ) {
		// 		add_term_meta( $new_id, '_riode_import_id', $this->demo . '#' . $old_id );
		// 	}
		// }

		private function import_after_functions( $demo ) {
			delete_option( 'riode_import_processed_duplicates' );
			foreach ( $this->woopages as $woo_page_name => $woo_page_title ) {
				$woopage = get_page_by_title( $woo_page_title );
				if ( isset( $woopage ) && $woopage->ID ) {
					update_option( $woo_page_name, $woopage->ID ); // Front Page
				}
			}

			// We no longer need to install pages
			$notices = array_diff( get_option( 'woocommerce_admin_notices', array() ), array( 'install', 'update' ) );
			update_option( 'woocommerce_admin_notices', $notices );
			delete_option( '_wc_needs_pages' );
			delete_transient( '_wc_activation_redirect' );

			// Set reading options
			$homepage   = $this->importer_get_page_by_title( 'Home' );
			$shop_page  = $this->importer_get_page_by_title( 'Riode Shop' );
			$posts_page = $this->importer_get_page_by_title( 'Blog' );

			if ( ( $homepage && $homepage->ID ) || ( $shop_page && $shop_page->ID ) || ( $posts_page && $posts_page->ID ) ) {
				update_option( 'show_on_front', 'page' );
				if ( $homepage && $homepage->ID ) {
					update_option( 'page_on_front', $homepage->ID ); // Front Page
				} elseif ( $shop_page && $shop_page->ID ) {
					update_option( 'page_on_front', $shop_page->ID ); // Shop Page
				}
				if ( $posts_page && $posts_page->ID ) {
					update_option( 'page_for_posts', $posts_page->ID ); // Blog Page
				}
			}

			if ( ( 'demo-6' == str_replace( array( 'wpb-' ), '', $demo ) || 'demo-18' == str_replace( array( 'wpb-' ), '', $demo ) ) && $shop_page && $shop_page->ID ) {
				update_option( 'page_on_front', $shop_page->ID );
			}

			update_option( 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/' );
			/**
			 * Update imported IDs
			 */
			$this->before_replacement();

			//Logo
			global $import_logo, $riode_import_posts_map;
			if ( ! empty( $import_logo ) ) {
				$new_id = $import_logo;
				if ( isset( $riode_import_posts_map[ $import_logo ] ) ) {
					$new_id = $riode_import_posts_map[ $import_logo ];
				}
				set_theme_mod( 'custom_logo', $new_id );
			}

			// Theme Options / Update blocks_menu imported id
			$data = riode_get_option( '_riode_blocks_menu' );
			if ( $data ) {
				$data = preg_replace_callback( '|(\\\")(\d+)(\\\":)|', array( $this, 'replace_term_ids' ), json_encode( $data ) );
				set_theme_mod( '_riode_blocks_menu', json_decode( $data, true ) );
			}

			// update post ids in pages
			$args = array(
				'posts_per_page' => -1,
				'post_type'      => array( 'page', 'riode_template' ),
				'post_status'    => 'publish',
				'meta_query'     => array(
					'relation' => 'AND',
					array(
						'meta_key' => '_riode_demo',
						'compare'  => 'EXISTS',
					),
				),
			);

			// Update id for wpb posts
			if ( 0 === strpos( $demo, 'wpb-' ) ) {
				$post_query = new WP_Query( $args );
				if ( $post_query->have_posts() ) {
					foreach ( $post_query->posts as $post ) {
						$new_content = $post->post_content;
						$new_content = preg_replace_callback( '|(\sid=")(\d+)(")|', array( $this, 'replace_post_ids' ), $new_content );
						$new_content = preg_replace_callback( '|(\scategory_ids=")([^"]*)(")|', array( $this, 'replace_term_ids' ), $new_content );
						$new_content = preg_replace_callback( '|(\sproduct_ids=")([^"]*)(")|', array( $this, 'replace_post_ids' ), $new_content );
						$new_content = preg_replace_callback( '|(\simage=")(\d+)(")|', array( $this, 'replace_post_ids' ), $new_content );
						$new_content = preg_replace_callback( '|(\simages=")([^"]*)(")|', array( $this, 'replace_post_ids' ), $new_content );
						$new_content = preg_replace_callback( '|(\sproduct_category_ids=")([^"]*)(")|', array( $this, 'replace_term_ids' ), $new_content );
						$new_content = preg_replace_callback( '|(\scategories=")([^"]*)(")|', array( $this, 'replace_term_ids' ), $new_content );
						$new_content = preg_replace_callback( '|(\smenu_id=")(\d+)(")|', array( $this, 'replace_term_ids' ), $new_content );
						$new_content = preg_replace_callback( '|(\snav_menu=")(\d+)(")|', array( $this, 'replace_term_ids' ), $new_content );
						if ( $post->post_content != $new_content ) {
							$post->post_content = $new_content;
							wp_update_post( $post );
						}
					}
				}
			} else {
				// Update id for Elementor posts
				$args['meta_query'][] = array(
					'meta_key' => '_elementor_data',
					'compare'  => 'EXISTS',
				);
				$post_query           = new WP_Query( $args );
				if ( $post_query->have_posts() ) {
					foreach ( $post_query->posts as $post ) {
						$data = get_post_meta( $post->ID, '_elementor_data', true );
						$data = preg_replace_callback( '|(id=\")(\d+)(\")|', array( $this, 'replace_post_ids' ), $data );
						$data = preg_replace_callback( '|(\"id\":\")(\d+)(\")|', array( $this, 'replace_post_ids' ), $data );
						$data = preg_replace_callback( '|(\"menu_id\":\")(\d+)(\")|', array( $this, 'replace_term_ids' ), $data );
						$data = preg_replace_callback( '|(\"category_ids\":\")([^\"]*)(\")|', array( $this, 'replace_term_ids' ), $data );
						$data = preg_replace_callback( '|(\"category_ids\":\[)([^\]]*)(\])|', array( $this, 'replace_term_ids' ), $data );
						$data = preg_replace_callback( '|(\"product_ids\":\")([^\"]*)(\")|', array( $this, 'replace_post_ids' ), $data );
						$data = preg_replace_callback( '|(\"product_ids\":\[)([^\]]*)(\])|', array( $this, 'replace_post_ids' ), $data );
						$data = preg_replace_callback( '|(\"categories\":\[)([^\]]*)(\])|', array( $this, 'replace_term_ids' ), $data );
						$data = preg_replace_callback( '|(\"product_category_ids\":\[)([^\]]*)(\])|', array( $this, 'replace_term_ids' ), $data );
						$data = preg_replace_callback( '|(\"nav_menu\":\")(\d+)(\")|', array( $this, 'replace_term_ids' ), $data );

						update_post_meta( $post->ID, '_elementor_data', wp_slash( $data ) );
					}
				}
			}

			/* Menu Item*/
			$menu_query = new WP_Query(
				array(
					'posts_per_page' => -1,
					'post_type'      => array( 'nav_menu_item' ),
					'post_status'    => 'publish',
					'meta_query'     => array(
						'relation' => 'AND',
						array(
							'meta_key' => '_menu_item_block',
							'compare'  => 'EXISTS',
						),
					),
				)
			);
			if ( $menu_query->have_posts() ) {
				foreach ( $menu_query->posts as $menu_item ) {
					$menu_item_block = get_post_meta( $menu_item->ID, '_menu_item_block', true );
					if ( isset( $riode_import_posts_map[ $menu_item_block ] ) ) {
						update_post_meta( $menu_item->ID, '_menu_item_block', $riode_import_posts_map[ $menu_item_block ] );
					}
				}
			}

			if ( defined( 'ELEMENTOR_VERSION' ) ) {
				$elementor_cpt_support = get_option( 'elementor_cpt_support' );
				if ( empty( $elementor_cpt_support ) ) {
					$elementor_cpt_support = array( 'post', 'page' );
				}
				$elementor_cpt_support[] = 'riode_template';
				update_option( 'elementor_cpt_support', $elementor_cpt_support );
				if ( version_compare( ELEMENTOR_VERSION, '3.0' ) < 0 ) {
					update_option( 'elementor_disable_color_schemes', 'yes' );
					update_option( 'elementor_disable_typography_schemes', 'yes' );
				} else {
					update_option( 'elementor_disable_color_schemes', true );
					update_option( 'elementor_disable_typography_schemes', true );
				}

				// after setup, set elementor options
				set_transient( 'riode_after_setup_e', 3 );
			}

			// update page layout ids
			$page_layouts = riode_get_option( 'page_layouts' );
			if ( ! empty( $page_layouts ) ) {
				$update_keys = array( 'header', 'footer', 'top_block', 'inner_top_block', 'inner_bottom_block', 'bottom_block', 'ptb' );
				foreach ( $page_layouts as $layout_name => $layout ) {
					if ( ! empty( $layout['content'] ) ) {
						foreach ( $layout['content'] as $block_name => $block_layout ) {
							if ( in_array( $block_name, $update_keys ) && ! empty( $block_layout['id'] ) && intval( $block_layout['id'] ) > 0 ) {
								$new_post = $this->get_post_id_from_imported_id( $block_layout['id'], $demo );
								if ( $new_post ) {
									$page_layouts[ $layout_name ]['content'][ $block_name ]['id'] = $new_post['id'];
								}
							}
						}
					}
					if ( ! empty( $layout['condition'] ) ) {
						foreach ( $layout['condition'] as $cond_index => $cond ) {
							if ( ! empty( $cond ) && isset( $cond['subcategory'] ) && 'individual' == $cond['subcategory'] && ! empty( $cond['id'] ) && ! empty( $cond['id']['id'] ) ) {
								$new_post = $this->get_post_id_from_imported_id( $cond['id']['id'], $demo );
								if ( $new_post ) {
									$page_layouts[ $layout_name ]['condition'][ $cond_index ]['id']['id'] = $new_post['id'];
								}
							}
						}
					}
				}
				set_theme_mod( 'page_layouts', $page_layouts );
			}

			$layout_conditions = riode_get_option( 'layout_conditions' );
			if ( ! empty( $layout_conditions ) && ! empty( $layout_conditions['page'] ) && ! empty( $layout_conditions['page']['individual'] ) ) {
				foreach ( $layout_conditions['page']['individual'] as $page_id => $layout_name ) {
					$new_post = $this->get_post_id_from_imported_id( $page_id, $demo );
					if ( $new_post && (int) $page_id !== (int) $new_post['id'] ) {
						unset( $layout_conditions['page']['individual'][ $page_id ] );
						$layout_conditions['page']['individual'][ (int) $new_post['id'] ] = $layout_name;
					}
				}
				set_theme_mod( 'layout_conditions', $layout_conditions );
			}

			$popup_conditions = riode_get_option( 'popup_conditions' );
			if ( ! empty( $popup_conditions ) && ! empty( $popup_conditions['page'] ) && ! empty( $popup_conditions['page']['individual'] ) ) {
				foreach ( $popup_conditions['page']['individual'] as $page_id => $layout_name ) {
					$new_post = $this->get_post_id_from_imported_id( $page_id, $demo );
					if ( $new_post && (int) $page_id !== (int) $new_post['id'] ) {
						unset( $popup_conditions['page']['individual'][ $page_id ] );
						$popup_conditions['page']['individual'][ (int) $new_post['id'] ] = $layout_name;
					}
				}
				set_theme_mod( 'popup_conditions', $popup_conditions );
			}

			// Clear all woocommerce caches
			if ( class_exists( 'WooCommerce' ) ) {
				wc_update_product_lookup_tables();

				wc_delete_product_transients();
				wc_delete_shop_order_transients();
				delete_transient( 'wc_count_comments' );
				delete_transient( 'as_comment_count' );

				$attribute_taxonomies = wc_get_attribute_taxonomies();

				if ( $attribute_taxonomies ) {
					foreach ( $attribute_taxonomies as $attribute ) {
						delete_transient( 'wc_layered_nav_counts_pa_' . $attribute->attribute_name );
					}
				}

				WC_Cache_Helper::get_transient_version( 'shipping', true );

				wc_delete_expired_transients();

				wc_clear_template_cache();
			}

			if ( class_exists( 'YITH_WCWL' ) ) {
				$wishlist = $this->importer_get_page_by_title( 'Wishlist' );
				if ( $wishlist && $wishlist->ID ) {
					update_option( 'yith-wcwl-page-id', $wishlist->ID );
				}
				update_option( 'yith_wcwl_variation_show', 'no' );
				update_option( 'yith_wcwl_price_show', 'yes' );
				update_option( 'yith_wcwl_stock_show', 'yes' );
				update_option( 'yith_wcwl_show_dateadded', 'no' );
				update_option( 'yith_wcwl_add_to_cart_show', 'yes' );
				update_option( 'yith_wcwl_show_remove', 'yes' );
				update_option( 'yith_wcwl_repeat_remove_button', 'no' );
			}

			// Compile Theme Style
			require_once RIODE_ADMIN . '/customizer/customizer.php';
			require_once RIODE_ADMIN . '/customizer/dynamic/riode-color-lib.php';
			require_once RIODE_ADMIN . '/customizer/customizer-function.php';

			Riode_Customizer::get_instance()->save_theme_options();

			set_theme_mod( 'lazyload_menu', false );

			// Demo imported!
			do_action( 'riode_demo_imported' );
			flush_rewrite_rules();
		}

		private function before_replacement() {
			global $wpdb, $riode_import_terms_map, $riode_import_posts_map;

			$riode_import_posts_map = array();

			$posts_result = $wpdb->get_results( "SELECT post_id, meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_riode_demo'" );
			foreach ( $posts_result as $result ) {
				$data = explode( '#', $result->meta_value );
				if ( 2 == count( $data ) ) {
					if ( $this->demo == $data[0] ) {
						$riode_import_posts_map[ (int) $data[1] ] = (int) $result->post_id;
					}
				}
			}

			$riode_import_terms_map = array();

			$terms_result = $wpdb->get_results( "SELECT term_id, meta_value FROM {$wpdb->termmeta} WHERE meta_key = '_riode_demo'" );
			foreach ( $terms_result as $result ) {
				$data = explode( '#', $result->meta_value );
				if ( 2 == count( $data ) ) {
					if ( $this->demo == $data[0] ) {
						$riode_import_terms_map[ (int) $data[1] ] = (int) $result->term_id;
					}
				}
			}
		}

		public function replace_post_ids( $matches ) {
			global $riode_import_posts_map;
			$ids     = array_map( 'intval', explode( ',', str_replace( '"', '', $matches[2] ) ) );
			$new_ids = array();
			foreach ( $ids as $id ) {
				if ( isset( $riode_import_posts_map[ $id ] ) ) {
					$new_ids[] = $riode_import_posts_map[ $id ];
				} else {
					$new_ids[] = $id;
				}
			}
			return $matches[1] . implode( ',', $new_ids ) . $matches[3];
		}

		public function replace_term_ids( $matches ) {
			global $riode_import_terms_map;
			$ids     = array_map( 'intval', explode( ',', str_replace( '"', '', $matches[2] ) ) );
			$new_ids = array();
			foreach ( $ids as $id ) {
				if ( isset( $riode_import_terms_map[ $id ] ) ) {
					$new_ids[] = $riode_import_terms_map[ $id ];
				} else {
					$new_ids[] = $id;
				}
			}
			return $matches[1] . implode( ',', $new_ids ) . $matches[3];
		}

		// public function save_old_id( $post_id, $original_post ) {
		// 	if ( empty( $original_post ) ) {
		// 		return;
		// 	}
		// 	$demo = ( isset( $_POST['demo'] ) && $_POST['demo'] ) ? sanitize_text_field( $_POST['demo'] ) : 'landing';
		// 	update_post_meta( $post_id, '_riode_import_id', $demo . '#' . intval( $original_post ) );
		// }

		public function riode_demo_types() {
			return array(
				'demo-1'        => array(
					'alt'     => 'Demo 1',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo1.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-2'        => array(
					'alt'     => 'Demo 2',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo2.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-3'        => array(
					'alt'     => 'Demo 3',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo3.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-4'        => array(
					'alt'     => 'Demo 4',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo4.jpg',
					'filter'  => 'sport',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-5'        => array(
					'alt'     => 'Demo 5',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo5.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-6'        => array(
					'alt'     => 'Demo 6',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo6.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-7'        => array(
					'alt'     => 'Demo 7',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo7.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-8'        => array(
					'alt'     => 'Demo 8',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo8.jpg',
					'filter'  => 'furniture',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-9'        => array(
					'alt'     => 'Demo 9',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo9.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-10'       => array(
					'alt'     => 'Demo 10',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo10.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-11'       => array(
					'alt'     => 'Demo 11',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo11.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-12'       => array(
					'alt'     => 'Demo 12',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo12.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-13'       => array(
					'alt'     => 'Demo 13',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo13.jpg',
					'filter'  => 'sport',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-14'       => array(
					'alt'     => 'Demo 14',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo14.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-15'       => array(
					'alt'     => 'Demo 15',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo15.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-16'       => array(
					'alt'     => 'Demo 16',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo16.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-17'       => array(
					'alt'     => 'Demo 17',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo17.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-18'       => array(
					'alt'     => 'Demo 18',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo18.jpg',
					'filter'  => 'electronics',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-19'       => array(
					'alt'     => 'Demo 19',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo19.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-20'       => array(
					'alt'     => 'Demo 20',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo20.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-21'       => array(
					'alt'     => 'Demo 21',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo21.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-22'       => array(
					'alt'     => 'Demo 22',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo22.jpg',
					'filter'  => 'market',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-23'       => array(
					'alt'     => 'Demo 23',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo23.jpg',
					'filter'  => 'electronics',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-24'       => array(
					'alt'     => 'Demo 24',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo24.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-25'       => array(
					'alt'     => 'Demo 25',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo25.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-26'       => array(
					'alt'     => 'Demo 26',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo26.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-27'       => array(
					'alt'     => 'Demo 27',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo27.jpg',
					'filter'  => 'electronics',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-28'       => array(
					'alt'     => 'Demo 28',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo28.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-29'       => array(
					'alt'     => 'Demo 29',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo29.jpg',
					'filter'  => 'electronics',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-30'       => array(
					'alt'     => 'Demo 30',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo30.jpg',
					'filter'  => 'electronics',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-31'       => array(
					'alt'     => 'Demo 31',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo31.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-32'       => array(
					'alt'     => 'Demo 32',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo32.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-33'       => array(
					'alt'     => 'Demo 33',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo33.jpg',
					'filter'  => 'sport',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-34'       => array(
					'alt'     => 'Demo 34',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo34.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-35'       => array(
					'alt'     => 'Demo 35',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo35.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-36'       => array(
					'alt'     => 'Demo 36',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo36.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'beauty'        => array(
					'alt'     => 'Beauty',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/beauty.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'diamart'       => array(
					'alt'     => 'Diamart',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/diamart.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'food'          => array(
					'alt'     => 'Food',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/food.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'market-1'      => array(
					'alt'     => 'Market 1 (Dokan)',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/market1.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'market-2'      => array(
					'alt'     => 'Market 2 (Dokan)',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/market2.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'market-wcfm-1' => array(
					'alt'     => 'Market 1 (WCFM)',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/market1-wcfm.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'market-wcfm-2' => array(
					'alt'     => 'Market 2 (WCFM)',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/market2-wcfm.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'medical'       => array(
					'alt'     => 'Medical',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/medical.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'sport'         => array(
					'alt'     => 'Sport',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/sports.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'kid'           => array(
					'alt'     => 'Kid',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/baby.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'demo-rtl'      => array(
					'alt'     => 'RTL Demo',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/demo-rtl.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'tea'        => array(
					'alt'     => 'Tea',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/tea.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'cake'        => array(
					'alt'     => 'Cake',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/cake.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'food-2'        => array(
					'alt'     => 'Food 2',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/food2.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'yoga'        => array(
					'alt'     => 'Yoga',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/yoga.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
				'landing-1'        => array(
					'alt'     => 'Product Landing',
					'img'     => 'https://d-themes.com/wordpress/riode/landing/landing/images/pages/landing.jpg',
					'filter'  => 'fashion',
					'plugins' => array( 'woocommerce' ),
					'editors' => array( 'elementor', 'js_composer' ),
				),
			);
		}
	}
endif;

add_action( 'after_setup_theme', 'riode_theme_setup_wizard', 10 );

if ( ! function_exists( 'riode_theme_setup_wizard' ) ) :
	function riode_theme_setup_wizard() {
		$instance = Riode_Setup_Wizard::get_instance();
	}
endif;

if ( ! function_exists( 'riode_import_theme_options' ) ) {
	function riode_import_theme_options( $plugin_options, $imported_options ) {
		update_option( 'theme_mods_' . get_option( 'stylesheet' ), $imported_options );
	}
}
