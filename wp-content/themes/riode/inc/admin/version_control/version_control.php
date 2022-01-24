<?php
defined( 'ABSPATH' ) || die;

define( 'RIODE_VERSION_CONTROL', RIODE_ADMIN . '/version_control' );

if ( ! class_exists( 'Riode_Version_Control' ) ) :
	/**
	 * Riode Version Control Panel
	 *
	 * @version 1.4.3
	 */
	class Riode_Version_Control {

		protected $theme_name = '';

		public $theme_slug = 'riode';

		protected $riode_url = 'https://d-themes.com/wordpress/riode/';

		public $theme_versions = array();

		public $plugin_versions = array();

		protected $page_url;

		private static $instance = null;

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			$this->current_theme_meta();
			$this->init_version_control();
		}

		/**
		 * Initialize current theme meta.
		 *
		 * @since 1.4.3
		 */
		public function current_theme_meta() {
			$current_theme    = wp_get_theme();
			$this->theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
			$this->page_slug  = 'riode-version-control';
			$this->page_url   = 'admin.php?page=' . $this->page_slug;
		}

		/**
		 * Initialize all variables, actions and filters.
		 *
		 * @since 1.4.3
		 */
		public function init_version_control() {
			if ( ! current_user_can( 'administrator' ) || ! isset( $_GET['page'] ) || 'riode-version-control' != $_GET['page'] ) {
				return;
			}
			// Get previous versions.
			$this->theme_versions  = $this->get_theme_versions();
			$this->plugin_versions = $this->get_plugin_versions();

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ), 30 );

			add_action( 'wp_ajax_riode_modify_theme_auto_updates', array( $this, 'riode_modify_theme_auto_updates' ) );
			add_action( 'wp_ajax_riode_modify_plugin_auto_updates', array( $this, 'riode_modify_plugin_auto_updates' ) );

			add_filter( 'site_transient_update_themes', array( $this, 'riode_check_for_update_theme' ), 1 );
			add_filter( 'site_transient_update_plugins', array( $this, 'riode_check_for_update_plugin' ), 1 );
		}

		/**
		 * Modify theme auto updates
		 *
		 * @since 1.4.3
		 */
		public function riode_modify_theme_auto_updates() {
			if ( ! isset( $_REQUEST['wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['wpnonce'], 'riode_version_control_nonce' ) ) {
				wp_send_json( false );
				die();
			}

			delete_transient( 'riode_modify_theme_auto_update' );

			require_once RIODE_PLUGINS . '/importer/importer-api.php';
			$importer_api = new Riode_Importer_API();

			$args            = $importer_api->generate_args( false );
			$version         = isset( $_REQUEST['version'] ) ? wp_unslash( $_REQUEST['version'] ) : '';
			$args['version'] = $version;
			$package_url     = add_query_arg( $args, $importer_api->get_url( 'theme_rollback' ) );

			$transient_data = array(
				'theme'           => get_template(),
				'new_version'     => $version,
				'release_version' => $version,
				'url'             => $this->riode_url,
				'package'         => $package_url,
			);

			set_site_transient( 'riode_modify_theme_auto_update', $transient_data, WEEK_IN_SECONDS );

			add_filter( 'site_transient_update_themes', array( $this, 'riode_check_for_update_theme' ), 1 );

			wp_send_json( true );
			die();
		}

		/**
		 * Modify plugin auto updates
		 *
		 * @since 1.4.3
		 */
		public function riode_modify_plugin_auto_updates() {
			if ( ! isset( $_REQUEST['wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['wpnonce'], 'riode_version_control_nonce' ) ) {
				wp_send_json( false );
				die();
			}

			delete_transient( 'riode_modify_plugin_auto_update' );

			require_once RIODE_PLUGINS . '/importer/importer-api.php';
			$importer_api = new Riode_Importer_API();

			$args            = $importer_api->generate_args( false );
			$version         = isset( $_REQUEST['version'] ) ? wp_unslash( $_REQUEST['version'] ) : '';
			$args['version'] = $version;
			$package_url     = add_query_arg( $args, $importer_api->get_url( 'plugin_rollback' ) );

			$transient_data = array(
				'slug'            => 'riode-core',
				'plugin'          => 'riode-core/riode-core.php',
				'new_version'     => $version,
				'release_version' => $version,
				'url'             => $this->riode_url,
				'package'         => $package_url,
			);

			set_site_transient( 'riode_modify_plugin_auto_update', $transient_data, WEEK_IN_SECONDS );

			add_filter( 'site_transient_update_plugins', array( $this, 'riode_check_for_update_plugin' ), 1 );

			wp_send_json( true );
			die();
		}

		/**
		 * Check for update theme.
		 *
		 * @since 1.4.3
		 *
		 * @param array $data themes info
		 * @return array $data
		 */
		public function riode_check_for_update_theme( $data ) {
			$transient_data = get_site_transient( 'riode_modify_theme_auto_update' );

			if ( $transient_data ) {
				$data->response[ get_template() ] = $transient_data;
			}

			return $data;
		}

		/**
		 * Check for update plugin
		 *
		 * @since 1.4.3
		 */
		public function riode_check_for_update_plugin( $data ) {
			$transient_data = get_site_transient( 'riode_modify_plugin_auto_update' );

			if ( ! empty( $transient_data ) ) {
				$data->response['riode-core/riode-core.php'] = json_decode( json_encode( $transient_data ), false );
			}

			return $data;
		}

		/**
		 * Get Theme Versions.
		 *
		 * @since 1.4.3
		 * @return array versions
		 */
		public function get_theme_versions() {
			$rollback_versions = get_site_transient( 'riode_theme_rollback_versions' );

			if ( false === $rollback_versions ) {
				$max_version   = 20;
				$current_index = 0;

				require_once RIODE_PLUGINS . '/importer/importer-api.php';
				$importer_api = new Riode_Importer_API();

				$versions = $importer_api->get_response( 'theme_rollback_versions' );

				if ( is_wp_error( $versions ) || empty( $versions ) ) {
					return array();
				}

				$rollback_versions = array();

				foreach ( $versions as $version ) {
					if ( $max_version <= $current_index ) {
						break;
					}

					if ( version_compare( $version, RIODE_VERSION, '>=' ) ) {
						continue;
					}

					$current_index ++;
					$rollback_versions[] = $version;
				}

				if ( ! empty( $rollback_versions ) ) {
					set_site_transient( 'riode_theme_rollback_versions', $rollback_versions, WEEK_IN_SECONDS );
				}
			}

			return $rollback_versions;
		}

		/**
		 * Get Plugin Versions.
		 *
		 * @since 1.4.3
		 * @return array versions
		 */
		public function get_plugin_versions() {
			$rollback_versions = get_site_transient( 'riode_plugin_rollback_versions' );

			if ( false === $rollback_versions ) {
				$max_version   = 20;
				$current_index = 0;

				require_once RIODE_PLUGINS . '/importer/importer-api.php';
				$importer_api = new Riode_Importer_API();

				$versions = $importer_api->get_response( 'plugin_rollback_versions' );

				if ( is_wp_error( $versions ) || empty( $versions ) ) {
					return array();
				}

				$rollback_versions = array();

				foreach ( $versions as $version ) {
					if ( $max_version <= $current_index ) {
						break;
					}

					if ( version_compare( $version, RIODE_VERSION, '>=' ) ) {
						continue;
					}

					$current_index ++;
					$rollback_versions[] = $version;
				}

				set_site_transient( 'riode_plugin_rollback_versions', $rollback_versions, WEEK_IN_SECONDS );
			}

			return $rollback_versions;
		}


		/**
		 * Prints tools page.
		 */
		public function view_version_control() {
			if ( ! Riode_Admin::get_instance()->is_registered() ) {
				wp_redirect( admin_url( 'admin.php?page=riode' ) );
			}
			Riode_Admin_Panel::get_instance()->view_header( 'license' );
			include RIODE_VERSION_CONTROL . '/views/index.php';
			Riode_Admin_Panel::get_instance()->view_footer();
		}

		/**
		 * enqueues styles and scripts
		 */
		public function enqueue() {
			wp_enqueue_style( 'riode-admin-wizard', RIODE_CSS . '/admin/wizard' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );
			wp_enqueue_script( 'riode-admin-wizard', RIODE_JS . '/admin/wizard' . riode_get_js_extension(), array( 'jquery-core' ), true, 50 );

			wp_localize_script(
				'riode-admin-wizard',
				'riode_version_control_params',
				array(
					'wpnonce' => wp_create_nonce( 'riode_version_control_nonce' ),
				)
			);
		}
	}
endif;

add_action( 'after_setup_theme', 'riode_theme_version_control', 10 );

if ( ! function_exists( 'riode_theme_version_control' ) ) :
	function riode_theme_version_control() {
		$instance = Riode_Version_Control::get_instance();
	}
endif;
