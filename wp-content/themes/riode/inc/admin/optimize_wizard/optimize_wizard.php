<?php

defined( 'ABSPATH' ) || die;

define( 'RIODE_OPTIMIZE_WIZARD', RIODE_ADMIN . '/optimize_wizard' );

if ( ! class_exists( 'Riode_Optimize_Wizard' ) ) :
	/**
	* Riode Theme Optimize Wizard
	*/
	class Riode_Optimize_Wizard {

		protected $version = '1.0';

		protected $theme_name = '';

		protected $step = '';

		protected $steps = array();

		public $page_slug;

		protected $tgmpa_instance;

		protected $tgmpa_menu_slug = 'tgmpa-install-plugins';

		protected $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';

		protected $page_url;

		protected $files;

		private static $instance = null;

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			$this->current_theme_meta();
			$this->init_actions();
		}

		public function current_theme_meta() {
			$current_theme    = wp_get_theme();
			$this->theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
			$this->page_slug  = 'riode-optimize-wizard';
			$this->page_url   = 'admin.php?page=' . $this->page_slug;
		}

		public function init_actions() {
			add_action( 'upgrader_post_install', array( $this, 'upgrader_post_install' ), 10, 2 );

			if ( apply_filters( $this->theme_name . '_enable_optimize_wizard', false ) ) {
				return;
			}

			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				add_action( 'init', array( $this, 'get_tgmpa_instanse' ), 30 );
				add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );
			}

			add_action( 'wp_ajax_riode_optimize_wizard_widgets_load', array( $this, 'ajax_load_widgets' ) );
			add_action( 'wp_ajax_riode_optimize_wizard_templates_load', array( $this, 'ajax_load_templates' ) );
			add_action( 'wp_ajax_riode_optimize_wizard_widgets_optimize', array( $this, 'ajax_optimize_widgets' ) );
			add_action( 'wp_ajax_riode_optimize_wizard_plugins', array( $this, 'ajax_plugins' ) );
			add_action( 'wp_ajax_riode_optimize_wizard_plugins_deactivate', array( $this, 'ajax_deactivate_plugins' ) );

			if ( isset( $_GET['page'] ) && $this->page_slug === $_GET['page'] ) {
				add_action( 'admin_init', array( $this, 'admin_redirects' ), 30 );
				add_action( 'admin_init', array( $this, 'init_wizard_steps' ), 30 );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ), 30 );
			}
		}

		public function upgrader_post_install( $return, $theme ) {
			if ( is_wp_error( $return ) ) {
				return $return;
			}
			if ( get_stylesheet() != $theme ) {
				return $return;
			}
			update_option( 'riode_optimize_complete', false );

			return $return;
		}

		public function admin_redirects() {
			ob_start();

			if ( ! get_transient( '_' . $this->theme_name . '_activation_redirect' ) || get_option( 'riode_optimize_complete', false ) ) {
				return;
			}

			delete_transient( '_' . $this->theme_name . '_activation_redirect' );
			wp_safe_redirect( admin_url( $this->page_url ) );
			exit;
		}

		/**
		 * Display optimize wizard
		 */
		public function enqueue() {

			if ( empty( $_GET['page'] ) || $this->page_slug !== $_GET['page'] ) {
				return;
			}

			$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

			// Style
			if ( is_rtl() ) {
				wp_enqueue_style( 'riode-setup_wiard', RIODE_CSS . '/admin/wizard-rtl.min.css' );
			} else {
				wp_enqueue_style( 'riode-setup_wiard', RIODE_CSS . '/admin/wizard.min.css' );
			}
			wp_enqueue_style( 'wp-admin' );
			wp_enqueue_media();

			wp_enqueue_style( 'fontawesome-free', RIODE_ASSETS . '/vendor/fontawesome-free/css/all.min.css', array(), '5.14.0' );

			// Script
			wp_register_script( 'jquery.blockUI', RIODE_JS . '/plugins/jquery.blockUI.min.js', false, true );
			wp_enqueue_script( 'riode-admin-wizard', RIODE_JS . '/admin/wizard' . riode_get_js_extension(), array( 'jquery-core', 'jquery.blockUI' ), true, 50 );
			wp_enqueue_script( 'media' );

			wp_localize_script(
				'riode-admin-wizard',
				'riode_optimize_wizard_params',
				array(
					'tgm_plugin_nonce' => array(
						'update'  => wp_create_nonce( 'tgmpa-update' ),
						'install' => wp_create_nonce( 'tgmpa-install' ),
					),
					'tgm_bulk_url'     => esc_url( admin_url( $this->tgmpa_url ) ),
					'wpnonce'          => wp_create_nonce( 'riode_optimize_wizard_nonce' ),
					'texts'            => array(
						'loading_failed' => esc_html__( 'Loading Failed', 'riode' ),
						'failed'         => esc_html__( 'Failed', 'riode' ),
						'ajax_error'     => esc_html__( 'Ajax error', 'riode' ),
					),
				)
			);

			ob_start();

		}

		/**
		 * Display optimize wizard
		 */
		public function view_optimize_wizard() {
			if ( ! Riode_Admin::get_instance()->is_registered() ) {
				wp_redirect( admin_url( 'admin.php?page=riode' ) );
			}

			Riode_Admin_Panel::get_instance()->view_header( 'license' );
			include RIODE_OPTIMIZE_WIZARD . '/views/index.php';
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

		public function get_tgmpa_instanse() {
			$this->tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		}

		public function set_tgmpa_url() {

			$this->tgmpa_menu_slug = ( property_exists( $this->tgmpa_instance, 'menu' ) ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
			$this->tgmpa_menu_slug = apply_filters( $this->theme_name . '_theme_optimize_wizard_tgmpa_menu_slug', $this->tgmpa_menu_slug );

			$tgmpa_parent_slug = ( property_exists( $this->tgmpa_instance, 'parent_slug' ) && 'themes.php' !== $this->tgmpa_instance->parent_slug ) ? 'admin.php' : 'themes.php';

			$this->tgmpa_url = apply_filters( $this->theme_name . '_theme_optimize_wizard_tgmpa_url', $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug );
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
				'all'               => array(), // Meaning: all plugins which still have open actions.
				'install'           => array(),
				'update'            => array(),
				'activate'          => array(),
				'installed'         => array(), // all plugins that installed.
				'network_activated' => array(),
			);

			foreach ( $instance->plugins as $slug => $plugin ) {
				if ( 'optimize' != $plugin['usein'] || ! isset( $plugin['visibility'] ) || 'optimize_wizard' != $plugin['visibility'] || $instance->$plugin_func_name( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
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

			$current = get_option( 'active_plugins', array() );
			if ( is_multisite() ) {
				$network_current = get_site_option( 'active_sitewide_plugins', array() );
			}
			foreach ( $current as $plugin ) {
				$plugins['installed'][ $plugin ] = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			}

			if ( isset( $network_current ) ) {
				$plugins['network_activated'] = $network_current;

				foreach ( $network_current as $slug => $plugin ) {
					$plugins['network_activated'][ $slug ] = get_plugin_data( WP_PLUGIN_DIR . '/' . $slug );
				}
			}

			return $plugins;
		}

		/**
		 * Get All Shortcodes
		 */
		private function get_all_shortcodes() {
			$shortcodes = array();
			if ( class_exists( 'WPBMap' ) ) {
				$all_wpb_shortcodes = WPBMap::getAllShortCodes();
				if ( ! empty( $all_wpb_shortcodes ) ) {
					foreach ( $all_wpb_shortcodes as $key => $value ) {
						if ( 0 === strpos( $key, 'wpb_riode' ) || 'vc_section' == $key || 'vc_row' == $key || 'vc_row_inner' == $key || 'vc_column' == $key || 'vc_column_inner' == $key ) {
							continue;
						}
						$shortcodes[] = $key;
					}
				}
			}

			return apply_filters( 'riode_all_shortcodes', $shortcodes );
		}

		/**
		 * Get used shortcodes
		 */
		private function get_used_shortcodes( $shortcodes = array() ) {
			if ( empty( $shortcodes ) ) {
				$shortcodes = $this->get_all_shortcodes();
			}
			global $wpdb, $riode_settings;
			$post_contents = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_content, post_excerpt FROM $wpdb->posts WHERE post_type not in (%s, %s) AND post_status = 'publish' AND ( post_content != '' or post_excerpt != '')", 'revision', 'attachment' ) );

			$sidebars_array = get_option( 'sidebars_widgets' );
			if ( empty( $post_contents ) || ! is_array( $post_contents ) ) {
				$post_contents = array();
			}
			foreach ( $sidebars_array as $sidebar => $widgets ) {
				if ( ! empty( $widgets ) && is_array( $widgets ) ) {
					foreach ( $widgets as $sidebar_widget ) {
						$widget_type = trim( substr( $sidebar_widget, 0, strrpos( $sidebar_widget, '-' ) ) );
						if ( ! array_key_exists( $widget_type, $post_contents ) ) {
							$post_contents[ $widget_type ] = get_option( 'widget_' . $widget_type );
						}
					}
				}
			}

			$used = array();

			$excerpt_arr = array(
				'post_content',
				'post_excerpt',
			);
			foreach ( $post_contents as $post_content ) {
				foreach ( $excerpt_arr as $excerpt_key ) {
					if ( is_string( $post_content ) && 'post_excerpt' == $excerpt_key ) {
						break;
					}
					if ( ! is_string( $post_content ) && 'post_excerpt' == $excerpt_key && ! isset( $post_content->post_excerpt ) ) {
						break;
					}
					$content = is_string( $post_content ) ? $post_content : ( isset( $post_content->{$excerpt_key} ) ? $post_content->{$excerpt_key} : '' );

					foreach ( $shortcodes as $shortcode ) {
						if ( false === strpos( $content, '[' ) ) {
							continue;
						}
						if ( ! in_array( $shortcode, $used ) && ( stripos( $content, '[' . $shortcode ) !== false ) ) {
							$used[] = $shortcode;
						}
					}
				}
			}
			return apply_filters( 'riode_wpb_get_used_shortcodes', $used );
		}

		public function ajax_plugins() {
			if ( ! check_ajax_referer( 'riode_optimize_wizard_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
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
		public function ajax_deactivate_plugins() {
			if ( ! check_ajax_referer( 'riode_optimize_wizard_nonce', 'wpnonce' ) || empty( $_POST['url'] ) ) {
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

			if ( ! current_user_can( 'deactivate_plugin', $plugin ) ) {
				wp_die( esc_html__( 'Sorry, you are not allowed to deactivate this plugin.', 'riode' ) );
			}

			deactivate_plugins( array( $_POST['url'] ), true, false );
			die();
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

		public function init_wizard_steps() {
			$this->steps = array(
				'widgets'   => array(
					'step_id' => 1,
					'name'    => esc_html__( 'Resources', 'riode' ),
					'view'    => array( $this, 'view_resources' ),
					'handler' => '',
				),
				'lazyload'  => array(
					'step_id' => 2,
					'name'    => esc_html__( 'Lazyload', 'riode' ),
					'view'    => array( $this, 'view_lazyload' ),
					'handler' => array( $this, 'view_lazyload_save' ),
				),
				'resources' => array(
					'step_id' => 3,
					'name'    => esc_html__( 'Peformance', 'riode' ),
					'view'    => array( $this, 'view_performance' ),
					'handler' => array( $this, 'view_performance_save' ),
				),
			);

			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				$this->steps['plugins'] = array(
					'step_id' => 4,
					'name'    => esc_html__( 'Plugins', 'riode' ),
					'view'    => array( $this, 'view_plugins' ),
					'handler' => '',
				);
			};

			$this->steps['ready'] = array(
				'step_id' => 5,
				'name'    => esc_html__( 'Ready!', 'riode' ),
				'view'    => array( $this, 'view_ready' ),
				'handler' => '',
			);

			$this->steps = apply_filters( $this->theme_name . '_theme_optimize_wizard_steps', $this->steps );
		}

		// View for each step content
		public function view_welcome() {
			include RIODE_OPTIMIZE_WIZARD . '/views/welcome.php';
		}

		public function view_resources() {
			// riode_compile_dynamic_css( 'optimize', get_theme_mod( 'used_elements' ) );
			include RIODE_OPTIMIZE_WIZARD . '/views/widgets.php';
		}

		public function ajax_load_templates() {
			if ( ! check_ajax_referer( 'riode_optimize_wizard_nonce', 'wpnonce' ) ) {
				wp_send_json_error(
					array(
						'error'   => 1,
						'message' => esc_html__(
							'Nonce Error',
							'riode'
						),
					)
				);
			}

			include RIODE_OPTIMIZE_WIZARD . '/views/templates_load.php';
			die;
		}

		public function ajax_load_widgets() {
			if ( ! check_ajax_referer( 'riode_optimize_wizard_nonce', 'wpnonce' ) ) {
				wp_send_json_error(
					array(
						'error'   => 1,
						'message' => esc_html__(
							'Nonce Error',
							'riode'
						),
					)
				);
			}

			$checked_elements = get_theme_mod( 'used_elements', false );

			include RIODE_ADMIN . '/customizer/dynamic/dynamic_conditions.php';
			foreach ( $checked_elements as $element => $used ) {
				if ( ! ( isset( $riode_used_elements[ $element ] ) && $riode_used_elements[ $element ] ) ) {
					$riode_used_elements[ $element ] = $used;
				}
			}

			// get used shortcodes
			$used_shortcodes    = array();
			$checked_shortcodes = array();
			if ( defined( 'WPB_VC_VERSION' ) ) {
				$checked_shortcodes = get_theme_mod( 'used_wpb_shortcodes', false );
				$used_shortcodes    = $this->get_used_shortcodes();
				if ( $checked_shortcodes ) {
					$checked_shortcodes = array_merge( $used_shortcodes, $checked_shortcodes );
				} else {
					$checked_shortcodes = $used_shortcodes;
				}
			}

			include RIODE_OPTIMIZE_WIZARD . '/views/widgets_load.php';
			die;
		}

		public function ajax_optimize_widgets() {
			if ( ! check_ajax_referer( 'riode_optimize_wizard_nonce', 'wpnonce' ) ) {
				wp_send_json_error(
					array(
						'error'   => 1,
						'message' => esc_html__(
							'Nonce Error',
							'riode'
						),
					)
				);
			}

			$elements = array();
			if ( ! empty( $_POST['used'] ) ) {
				foreach ( $_POST['used'] as $used_element ) {
					$elements[ $used_element ] = 1;
				}
			}
			if ( ! empty( $_POST['unused'] ) ) {
				foreach ( $_POST['unused'] as $unused_element ) {
					$elements[ $unused_element ] = 0;
				}
			}

			set_theme_mod( 'used_elements', $elements );

			if ( defined( 'WPB_VC_VERSION' ) ) {
				$wpb_shortcodes = array();
				if ( ! empty( $_POST['used_shortcode'] ) ) {
					foreach ( $_POST['used_shortcode'] as $used_shortcode ) {
						$wpb_shortcodes[] = $used_shortcode;
					}
				}

				set_theme_mod( 'used_wpb_shortcodes', $wpb_shortcodes );

				// Compile WPBakery Shortcodes
				$wpb_shortcodes_to_remove = array();
				if ( isset( $_POST['unused_shortcode'] ) && ! empty( $_POST['unused_shortcode'] ) ) {
					$wpb_shortcodes_to_remove = array_map( 'sanitize_text_field', $_POST['unused_shortcode'] );
				}

				riode_wpb_shortcode_compile_css( $wpb_shortcodes_to_remove );
			}

			set_theme_mod( 'resource_disable_gutenberg', isset( $_POST['resource_disable_gutenberg'] ) && 'true' == $_POST['resource_disable_gutenberg'] );
			set_theme_mod( 'resource_disable_wc_blocks', isset( $_POST['resource_disable_wc_blocks'] ) && 'true' == $_POST['resource_disable_wc_blocks'] );
			set_theme_mod( 'resource_disable_elementor_unused', isset( $_POST['resource_disable_elementor_unused'] ) && 'true' == $_POST['resource_disable_elementor_unused'] );

			// Optimize templates
			if ( ! empty( $_POST['layouts'] ) ) {
				$layouts           = riode_get_option( 'page_layouts' );
				$optimized_layouts = array();
				foreach ( $layouts as $key => $layout ) {
					if ( ! in_array( $key, $_POST['layouts'] ) ) {
						$optimized_layouts[ $key ] = $layout;
					}
				}
				set_theme_mod( 'page_layouts', $optimized_layouts );
			}

			if ( ! empty( $_POST['sidebars'] ) ) {
				$sidebars = get_option( 'riode_sidebars' );
				if ( $sidebars ) {
					$sidebars = json_decode( $sidebars, true );
				}

				foreach ( $_POST['sidebars'] as $key ) {
					unset( $sidebars[ $key ] );
				}
				update_option( 'riode_sidebars', json_encode( $sidebars ) );
			}

			riode_compile_dynamic_css( 'optimize', $elements );
		}

		public function view_lazyload() {
			include RIODE_OPTIMIZE_WIZARD . '/views/lazyload.php';
		}

		public function view_lazyload_save() {
			check_admin_referer( 'riode-setup-wizard' );

			set_theme_mod( 'lazyload', isset( $_POST['lazyload'] ) );
			set_theme_mod( 'lazyload_menu', isset( $_POST['lazyload_menu'] ) );
			set_theme_mod( 'skeleton_screen', isset( $_POST['skeleton'] ) );
			set_theme_mod( 'google_webfont', isset( $_POST['webfont'] ) );
			wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
			die;
		}

		public function view_performance() {
			include RIODE_OPTIMIZE_WIZARD . '/views/resources.php';
		}

		public function view_performance_save() {
			check_admin_referer( 'riode-setup-wizard' );

			set_theme_mod( 'mobile_disable_animation', isset( $_POST['mobile_disable_animation'] ) );
			set_theme_mod( 'mobile_disable_slider', isset( $_POST['mobile_disable_slider'] ) );

			$preload_fonts = riode_get_option( 'preload_fonts' );
			if ( empty( $preload_fonts ) ) {
				$preload_fonts = array();
			}
			if ( isset( $_POST['preload_fonts'] ) ) {
				$preload_fonts = array_map( 'sanitize_text_field', $_POST['preload_fonts'] );
			} else {
				$preload_fonts = array();
			}
			if ( isset( $_POST['preload_fonts_custom'] ) ) {
				$preload_fonts['custom'] = sanitize_textarea_field( $_POST['preload_fonts_custom'] );
			}
			set_theme_mod( 'preload_fonts', $preload_fonts );

			set_theme_mod( 'resource_async_js', isset( $_POST['resource_async_js'] ) );
			set_theme_mod( 'resource_split_tasks', isset( $_POST['resource_split_tasks'] ) );
			set_theme_mod( 'resource_idle_run', isset( $_POST['resource_idle_run'] ) );
			set_theme_mod( 'resource_after_load', isset( $_POST['resource_after_load'] ) );
			wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
			die();
		}

		public function view_plugins() {
			include RIODE_OPTIMIZE_WIZARD . '/views/plugins.php';
		}

		public function view_ready() {
			include RIODE_OPTIMIZE_WIZARD . '/views/ready.php';
		}
	}
endif;

add_action( 'after_setup_theme', 'riode_theme_optimize_wizard', 10 );

if ( ! function_exists( 'riode_theme_optimize_wizard' ) ) :
	function riode_theme_optimize_wizard() {
		Riode_Optimize_Wizard::get_instance();
	}
endif;
