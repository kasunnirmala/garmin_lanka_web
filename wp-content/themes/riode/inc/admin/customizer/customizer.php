<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Add theme-customizer options
 */

if ( ! class_exists( 'Riode_Customizer' ) ) :

	/**
	 * Riode_Customizer Class
	 * This class is a Kirki class wapper.
	 */
	class Riode_Customizer {

		protected $wp_customize;

		public $blocks;
		public $popups;
		public $product_layouts;

		protected static $instance;

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			add_action( 'customize_controls_print_styles', array( $this, 'load_styles' ) );
			add_action( 'customize_controls_print_scripts', array( $this, 'load_scripts' ), 30 );
			add_action( 'riode_before_enqueue_theme_style', array( $this, 'load_selective_assets' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'load_global_custom_css' ), 21 );
			add_action( 'customize_save_after', array( $this, 'save_theme_options' ) );
			add_action( 'customize_register', array( $this, 'customize_register' ) );

			// Theme Option Import/Export
			add_action( 'wp_ajax_riode_import_theme_options', array( $this, 'import_options' ) );
			add_action( 'wp_ajax_nopriv_riode_import_theme_options', array( $this, 'import_options' ) );
			add_action( 'wp_ajax_riode_export_theme_options', array( $this, 'export_options' ) );
			add_action( 'wp_ajax_nopriv_riode_export_theme_options', array( $this, 'export_options' ) );

			// Theme Option Reset
			add_action( 'wp_ajax_riode_reset_theme_options', array( $this, 'reset_options' ) );
			add_action( 'wp_ajax_nopriv_riode_reset_theme_options', array( $this, 'reset_options' ) );

			// Get Page Links ( Load other page for previewer )
			add_action( 'wp_ajax_riode_customize_page_links', array( $this, 'get_links' ) );
			add_action( 'wp_ajax_nopriv_riode_customize_page_links', array( $this, 'get_links' ) );

			// Customize Navigator
			add_action( 'customize_controls_print_scripts', array( $this, 'customizer_navigator' ) );

			add_action( 'wp_ajax_riode_save_customize_nav', array( $this, 'customizer_nav_save' ) );
			add_action( 'wp_ajax_nopriv_riode_save_customize_nav', array( $this, 'customizer_nav_save' ) );

			require_once RIODE_ADMIN . '/customizer/option/option.php';
			require_once RIODE_ADMIN . '/customizer/dynamic/riode-color-lib.php';
		}

		/**
		 * Change theme css to theme preview css
		 * load selective refresh JS
		 */
		public function load_selective_assets() {
			wp_enqueue_script( 'riode-selective', RIODE_JS . '/admin/selective-refresh' . riode_get_js_extension(), array( 'jquery-core' ), RIODE_VERSION, true );

			wp_localize_script(
				'riode-selective',
				'riode_selective_vars',
				array(
					'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'    => wp_create_nonce( 'riode-selective' ),
				)
			);
		}

		/**
		 * load custom css
		 */
		public function load_global_custom_css() {
			wp_enqueue_style( 'riode-preview-custom', RIODE_CSS . '/admin/preview-custom.min.css' );
			wp_add_inline_style( 'riode-preview-custom', wp_strip_all_tags( wp_specialchars_decode( riode_get_option( 'header_css' ) . riode_get_option( 'custom_css' ) ) ) );
		}

		/**
		 * Add CSS for Customizer Options
		 */
		public function load_styles() {
			wp_enqueue_style( 'riode-customizer', RIODE_CSS . '/admin/customizer' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', null, RIODE_VERSION, 'all' );
			wp_enqueue_style( 'magnific-popup', RIODE_CSS . '/3rd-plugins/magnific-popup' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), '1.0' );
		}

		/**
		 * Add JS for Customizer Options
		 */
		public function load_scripts() {
			wp_enqueue_script( 'jquery-ui-sortable', RIODE_JS . '/admin/jquery-ui.sortable' . riode_get_js_extension(), array( 'jquery-core' ), '1.11.4', true );
			wp_enqueue_script( 'riode-customizer', RIODE_JS . '/admin/customizer.js', array( 'jquery-ui-sortable' ), RIODE_VERSION, true );

			wp_localize_script(
				'riode-customizer',
				'customizer_admin_vars',
				array(
					'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'    => wp_create_nonce( 'riode-customizer' ),
				)
			);
		}

		/**
		 * Save theme options
		 */
		public function save_theme_options() {
			ob_start();
			include RIODE_INC . '/admin/customizer/dynamic/dynamic_vars.php';

			global $wp_filesystem;
			// Initialize the WordPress filesystem, no more using file_put_contents function
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			try {
				$target      = wp_upload_dir()['basedir'] . '/riode_styles/dynamic_css_vars.css';
				$target_path = dirname( $target );
				if ( ! file_exists( $target_path ) ) {
					wp_mkdir_p( $target_path );
				}

				// check file mode and make it writable.
				if ( is_writable( $target_path ) == false ) {
					@chmod( get_theme_file_path( $target ), 0755 );
				}
				if ( file_exists( $target ) ) {
					if ( is_writable( $target ) == false ) {
						@chmod( $target, 0755 );
					}
					@unlink( $target );
				}

				$wp_filesystem->put_contents( $target, ob_get_clean(), FS_CHMOD_FILE );
			} catch ( Exception $e ) {
				var_dump( $e );
				var_dump( 'error occured while saving dynamic css vars.' );
			}
		}

		/**
		 * public function add_setting()
		 * WordPress Standard function
		 */
		public function add_setting( $id, $args = array() ) {
			WP_Customize_Manager::add_setting( $id, $args );
		}

		/**
		 * public function add_setting()
		 * WordPress Standard function
		 */
		public function add_control( $id, $args = array() ) {
			WP_Customize_Manager::add_control( $id, $args );
		}

		/**
		 * Add new panels
		 *
		 * @param    $id      string    the panel ID
		 * @param    $args    array     the panel's arguments
		 */
		public static function add_panel( $id = '', $args = array() ) {
			if ( class_exists( 'Kirki' ) ) {
				Kirki::add_panel( $id, $args );
			}
		}

		/**
		 * Add new sections
		 *
		 * @param    $id      string    the section ID
		 * @param    $args    array     the section's arguments
		 */
		public static function add_section( $id, $args ) {
			if ( class_exists( 'Kirki' ) ) {
				Kirki::add_section( $id, $args );
			}
		}

		/**
		 * Add new configuration options.
		 *
		 * @param    $id      string    the configuration ID
		 * @param    $args    array     the configuration's arguments
		 */
		public static function add_config( $id, $args = array() ) {
			if ( class_exists( 'Kirki' ) ) {
				Kirki::add_config( $id, $args );
				return;
			}
		}

		/**
		 * Add new field
		 *
		 * @param    $id      string    the field ID
		 * @param    $args    array     the field's arguments
		 */
		public static function add_field( $id, $args ) {
			if ( class_exists( 'Kirki' ) ) {
				Kirki::add_field( $id, $args );
				return;
			}
		}

		public function customize_register( $wp_customize ) {
			$this->wp_customize = $wp_customize;
		}

		/**
		 * Get avaiable templates
		 */
		public function get_templates( $type ) {
			if ( 'block' == $type && $this->blocks && ! empty( $this->blocks ) ) {
				return $this->blocks;
			} elseif ( 'popup' == $type && $this->popups && ! empty( $this->popups ) ) {
				return $this->popups;
			} elseif ( 'product_layout' == $type && $this->product_layouts && ! empty( $this->product_layouts ) ) {
				return $this->product_layouts;
			}

			$posts = get_posts(
				array(
					'post_status' => 'publish',
					'post_type'   => 'riode_template',
					'meta_key'    => 'riode_template_type',
					'meta_value'  => $type,
					'numberposts' => -1,
				)
			);

			if ( empty( $posts ) ) {
				return array();
			}

			sort( $posts );

			if ( 'block' == $type ) {
				foreach ( $posts as $post ) {
					$this->blocks[ $post->ID ] = $post->post_title;
				}

				return $this->blocks;
			} elseif ( 'popup' == $type ) {
				foreach ( $posts as $post ) {
					$this->popups[ $post->ID ] = $post->post_title;
				}

				return $this->popups;
			} elseif ( 'product_layout' == $type ) {
				foreach ( $posts as $post ) {
					$this->product_layouts[ $post->ID ] = $post->post_title;
				}

				return $this->product_layouts;
			}
		}

		/**
		 * Import theme options
		 *
		 */
		public function import_options() {
			if ( ! $this->wp_customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
			}

			if ( ! check_ajax_referer( 'riode-customizer', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			if ( empty( $_FILES['file'] ) || empty( $_FILES['file']['name'] ) ) {
				wp_send_json_error( 'Empty file pathname' );
			}

			$filename = $_FILES['file']['name'];

			if ( empty( $_FILES['file']['tmp_name'] ) || '.json' !== substr( $filename, -5 ) ) {
				wp_send_json_error( 'invalid_type' );
			}

			$options = file_get_contents( $_FILES['file']['tmp_name'] );
			if ( $options ) {
				$options = json_decode( $options, true );
			}

			if ( $options ) {
			update_option( 'theme_mods_' . get_option( 'stylesheet' ), $options );
			wp_send_json_success();
			} else {
				wp_send_json_error( 'invalid_type' );
			}
		}

		/**
		 * Export theme options
		 *
		 */
		public function export_options() {
			if ( ! $this->wp_customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
			}

			if ( ! check_ajax_referer( 'riode-customizer', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			header( 'Content-Description: File Transfer' );
			header( 'Content-type: application/txt' );
			header( 'Content-Disposition: attachment; filename="riode_theme_options_backup_' . date( 'Y-m-d' ) . '.json"' );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate' );
			header( 'Pragma: public' );
			echo json_encode( get_theme_mods() );
			exit;
		}

		/**
		 * Reset theme options
		 *
		 */
		public function reset_options() {
			if ( ! $this->wp_customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
			}

			if ( ! check_ajax_referer( 'riode-customizer', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			remove_theme_mods();

			// Delete compiled css in uploads/riode_style directory.
			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			try {
				$wp_filesystem->delete( wp_upload_dir()['basedir'] . '/riode_styles', true );
			} catch ( Exception $e ) {
				wp_send_json_error( 'error occured while deleting compiled css.' );
			}

			wp_send_json_success();
		}

		/**
		 * Get Page Links
		 *
		 */
		public function get_links() {
			if ( ! $this->wp_customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
			}

			if ( ! check_ajax_referer( 'riode-customizer', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			$link = array();

			// Shop Url
			$p = get_posts(
				array(
					'posts_per_page' => 1,
				)
			)[0];

			// Blog Url
			$link['blog_archive'] = esc_url( get_author_posts_url( get_post_field( 'post_author', $p ) ) );

			// Single Post Url
			$link['blog_single'] = esc_url( get_permalink( $p ) );

			$pr = get_posts(
				array(
					'posts_per_page' => 1,
					'post_type'      => 'product',
				)
			)[0];

			// Single Product Url
			$link['wc_single_product'] = esc_url( get_permalink( $pr ) );

			wp_send_json_success( $link );
		}

		/**
		 * Get Navigator Template
		 *
		 */
		public function customizer_navigator() {
			$nav_items = riode_get_option( 'navigator_items' );

			ob_start();
			?>
			<div class="customizer-nav">
				<h3><?php esc_html_e( 'Navigator', 'riode' ); ?><a href="#" class="navigator-toggle"><i class="fas fa-chevron-left"></i></a></h3>
				<div class="customizer-nav-content">
					<ul class="customizer-nav-items">
				<?php foreach ( $nav_items as $section => $label ) : ?>
						<li>
							<a href="#" data-target="<?php echo esc_attr( $section ); ?>" data-type="<?php echo esc_attr( $label[1] ); ?>" class="customizer-nav-item"><?php echo esc_html( $label[0] ); ?></a>
							<a href="#" class="customizer-nav-remove"><i class="fas fa-trash"></i></a>
						</li>
				<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<?php
			echo ob_get_clean();
		}

		/**
		 * Save Navigator Items
		 *
		 */
		public function customizer_nav_save() {
			if ( ! check_ajax_referer( 'riode-customizer', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			if ( isset( $_POST['navs'] ) ) {
				set_theme_mod( 'navigator_items', $_POST['navs'] );
				wp_send_json_success();
			}
		}
	}

	Riode_Customizer::get_instance();
endif;
