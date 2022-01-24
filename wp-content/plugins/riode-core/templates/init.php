<?php
/**
 * Riode Template
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RIODE_CORE_TEMPLATE', RIODE_CORE_PATH . '/templates' );

class Riode_Template {
	protected $cur_page = '';

	protected $template_types;

	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->_init_template_types();
		$this->_load_builders();
		$this->_load_layout_dashboard();
		$this->_load_sidebar_dashboard();
		$this->_load_template_related();

		add_action( 'init', array( $this, 'register_template_type' ) );

		// Print Riode Template Builder Page's Header
		global $pagenow;
		if ( current_user_can( 'edit_posts' ) && 'edit.php' == $pagenow && isset( $_REQUEST['post_type'] ) && 'riode_template' == $_REQUEST['post_type'] ) {
			add_filter(
				'admin_body_class',
				function( $class ) {
					return $class . ' hidden';
				}
			);

			riode_remove_all_admin_notices();

			add_action( 'all_admin_notices', array( $this, 'print_template_dashboard_header' ), 1 );
			add_filter( 'views_edit-riode_template', array( $this, 'print_template_category_tabs' ) );
		}

		add_filter( 'manage_riode_template_posts_columns', array( $this, 'admin_column_header' ) );
		add_action( 'manage_riode_template_posts_custom_column', array( $this, 'admin_column_content' ), 10, 2 );

		// Ajax
		add_action( 'wp_ajax_riode_save_template', array( $this, 'save_riode_template' ) );
		add_action( 'wp_ajax_nopriv_riode_save_template', array( $this, 'save_riode_template' ) );

		// Delete post meta when post is delete
		add_action( 'delete_post', array( $this, 'delete_template' ) );

		// Change Admin Post Query with riode template types
		add_action( 'parse_query', array( $this, 'filter_template_type' ) );

		// Resources
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		add_filter( 'riode_core_admin_localize_vars', array( $this, 'add_localize_vars' ) );

		// Add template builder classes to body class
		add_filter( 'body_class', array( $this, 'add_body_class_for_preview' ) );
	}

	private function _init_template_types() {
		$this->template_types = array(
			'block'  => 'Block Builder',
			'header' => 'Header Builder',
			'footer' => 'Footer Builder',
			'popup'  => 'Popup Builder',
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$this->template_types['product_layout'] = 'Single Product Builder';
		}
	}

	private function _load_builders() {
		require_once RIODE_CORE_TEMPLATE . '/header-builder/init.php';

		if ( class_exists( 'WooCommerce' ) ) {
			require_once RIODE_CORE_TEMPLATE . '/single-product-builder/init.php';
		}
	}

	private function _load_layout_dashboard() {
		require_once RIODE_CORE_TEMPLATE . '/page-layouts/init.php';
	}

	private function _load_sidebar_dashboard() {
		require_once RIODE_CORE_TEMPLATE . '/sidebar-dashboard/init.php';
	}

	private function _load_template_related() {
		require_once RIODE_CORE_TEMPLATE . '/template-condition/init.php';
		require_once RIODE_CORE_TEMPLATE . '/builder-addon/init.php';
	}

	public static function load_assets() {
		if ( defined( 'RIODE_ASSETS' ) ) {
			wp_enqueue_style( 'magnific-popup', RIODE_CSS . '/3rd-plugins/magnific-popup' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), '1.0' );
			wp_register_script( 'jquery-magnific-popup', RIODE_ASSETS . '/vendor/jquery.magnific-popup/jquery.magnific-popup.min.js', array( 'jquery-core' ), '1.1.0', true );
		}
	}

	public function add_body_class_for_preview( $classes ) {
		if ( 'riode_template' == get_post_type() ) {
			$template_category = get_post_meta( get_the_ID(), 'riode_template_type', true );

			if ( ! $template_category ) {
				$template_category = 'block';
			}

			$classes[] = 'riode_' . $template_category . '_template';
		}
		return $classes;
	}

	public function add_localize_vars( $vars ) {
		if ( riode_is_elementor_preview() ) {
			$vars['texts']['elementor_addon_settings'] = esc_html__( 'Riode Settings', 'riode-core' );
		}
		return $vars;
	}

	public function register_template_type() {
		register_post_type(
			'riode_template',
			array(
				'label'               => esc_html__( 'Riode Templates', 'riode-core' ),
				'exclude_from_search' => true,
				'has_archive'         => false,
				'public'              => true,
				'supports'            => array( 'title', 'editor', 'riode', 'riode-core' ),
				'can_export'          => true,
				'show_in_rest'        => true,
				'show_in_menu'        => false,
			)
		);
	}

	public function print_template_dashboard_header() {
		if ( class_exists( 'Riode_Admin_Panel' ) ) {
			Riode_Admin_Panel::get_instance()->view_header( 'template_dashboard' );
			?>
			<div class="riode-admin-panel-header">
				<h1><?php esc_html_e( 'Templates Builder', 'riode-core' ); ?></h1>
				<p><?php esc_html_e( 'Build any part of your site with Riode Template Builder. This provides an easy but powerful way to build a full site with hundreds of pre-built templates from Riode Studio.', 'riode-core' ); ?></p>
			</div>
			<div class="riode-admin-panel-body templates-builder">
				<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=riode_template' ) ); ?>" class="page-title-action button button-dark button-large"><?php esc_html_e( 'Add New Template', 'riode-core' ); ?></a>
			</div>
			<?php
			Riode_Admin_Panel::get_instance()->view_footer();
		}
	}

	public function print_template_category_tabs( $views = array() ) {
		echo '<div class="nav-tab-wrapper" id="riode-template-nav">';

		$curslug = '';

		if ( isset( $_GET ) && isset( $_GET['post_type'] ) && 'riode_template' == $_GET['post_type'] && isset( $_GET['riode_template_type'] ) ) {
			$curslug = $_GET['riode_template_type'];
		}

		echo '<a class="nav-tab' . ( '' == $curslug ? ' nav-tab-active' : '' ) . '" href="' . esc_url( admin_url( 'edit.php?post_type=riode_template' ) ) . '">' . esc_html__( 'All', 'riode-core' ) . '</a>';

		foreach ( $this->template_types as $slug => $name ) {
			echo '<a class="nav-tab' . ( $slug == $curslug ? ' nav-tab-active' : '' ) . '" href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=' . $slug ) ) . '">' . sprintf( esc_html__( '%s', 'riode-core' ), $name ) . '</a>';
		}

		echo '</div>';

		wp_enqueue_script( 'jquery-magnific-popup' );

		?>

		<div id="riode_template_type_popup" class="riode-template-form">
			<div class="mfp-header">
				<h2><span class="riode-mini-logo"></span><?php esc_html_e( 'New Template', 'riode-core' ); ?></h2>
			</div>
			<div class="mfp-body">
				<div class="riode-new-template-description">
					<?php /* translators: $1 and $2 opening and closing strong tags respectively */ ?>
					<h4><?php printf( esc_html__( 'One Click Install %1$sTemplates%2$s', 'riode-core' ), '<b>', '</b>' ); ?></h4>

					<p><?php esc_html_e( 'A huge library of online templates are ready for your quick work, and their combination will bring a new fashionable site.', 'riode-core' ); ?></p>
					<?php if ( defined( 'RIODE_VERSION' ) ) : ?>
						<div class="editors">
							<?php if ( defined( 'ELEMENTOR_VERSION' ) ) : ?>
								<label for="riode-elementor-studio">
									<input type="radio" id="riode-elementor-studio" name="riode-studio-type" value="elementor" checked="checked">
									<img src="<?php echo esc_url( RIODE_URI . '/assets/images/studio/elementor.jpg' ); ?>" alt="Elementor" title="Elementor">
								</label>
							<?php endif; ?>
							<?php if ( defined( 'WPB_VC_VERSION' ) ) : ?>
								<label for="riode-wpbakery-studio">
									<input type="radio" id="riode-wpbakery-studio" name="riode-studio-type" value="wpbakery">
									<img src="<?php echo esc_url( RIODE_URI . '/assets/images/studio/wpbakery.jpg' ); ?>" alt="WPBakery" title="WPBakery">
								</label>
							<?php endif; ?>
							<label for="riode-gutenberg-studio">
								<input type="radio" id="riode-gutenberg-studio" name="riode-studio-type" value="gutenberg">
								<img src="<?php echo esc_url( RIODE_URI . '/assets/images/studio/gutenberg.jpg' ); ?>" alt="Gutenberg" title="Gutenberg">
							</label>
						</div>
					<?php endif; ?>
				</div>
				<div class="riode-new-template-form">
					<h4><?php esc_html_e( 'Choose Template Type', 'riode-core' ); ?></h4>
				<div class="option">
						<label><?php esc_html_e( 'Select Template Type', 'riode-core' ); ?></label>
						<select class="template-type">
						<?php
						foreach ( $this->template_types as $slug => $key ) {
							echo '<option value="' . esc_attr( $slug ) . '" ' . selected( $slug, $curslug ) . '>' . esc_html( $key ) . '</option>';
						}
						?>
						</select>
					</div>
					<div class="option">
						<label><?php esc_html_e( 'Name your template', 'riode-core' ); ?></label>
						<input type="text" name="template-name" class="template-name" placeholder="<?php esc_attr_e( 'Enter your template name (required)', 'riode-core' ); ?>" />
				</div>
				<div class="option">
						<label><?php esc_html_e( 'From Online Templates', 'riode-core' ); ?></label>
						<div class="riode-template-input">
							<input id="riode-new-template-type" type="hidden" />
							<input id="riode-new-template-id" type="hidden" />
							<input id="riode-new-template-name" type="text" class="online-template" readonly />
							<button id="riode-new-studio-trigger" title="<?php esc_attr_e( 'Riode Studio', 'riode-core' ); ?>"><i class="fas fa-layer-group"></i>
						</div>
					</div>
					<button class="button" id="riode-create-template-type"><?php esc_html_e( 'Create Template', 'riode-core' ); ?></button>
				</div>
			</div>
			</div>

		<?php
		return $views;
	}

	public function admin_column_header( $defaults ) {
		$date_post = array_search( 'date', $defaults );
		$changed   = array_merge( array_slice( $defaults, 0, $date_post - 1 ), array( 'template_type' => esc_html__( 'Template Type', 'riode-core' ) ), array_slice( $defaults, $date_post ) );
		return $changed;
	}

	public function admin_column_content( $column_name, $post_id ) {
		if ( 'template_type' === $column_name ) {
			$type = esc_attr( get_post_meta( $post_id, 'riode_template_type', true ) );
			echo '<a href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=' . $type ) ) . '">' . $type . '</a>';
		}
	}

	public function save_riode_template() {
		if ( ! check_ajax_referer( 'riode-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( ! isset( $_POST['name'] ) || ! isset( $_POST['type'] ) ) {
			wp_send_json_error( esc_html__( 'no template type or name', 'riode-core' ) );
		}

		if ( isset( $_POST['page_builder'] ) ) {
			switch ( $_POST['page_builder'] ) {
				case 'elementor':
					$cpts = get_option( 'elementor_cpt_support' );
					if ( ! in_array( 'riode_template', $cpts ) ) {
						$cpts[] = 'riode_template';
						update_option('elementor_cpt_support', $cpts);
					}
					break;
				case 'wpbakery':
					$user       = wp_get_current_user();
					$user_roles = array_intersect( array_values( (array) $user->roles ), array_keys( (array) get_editable_roles() ) );
					$roleName   = reset( $user_roles );
					$role       = get_role( $roleName );
					$caps       = $role->capabilities;
					if ( ! ( isset( $caps['vc_access_rules_post_types'] ) && 'custom' === $caps['vc_access_rules_post_types'] && isset( $caps['vc_access_rules_post_types/riode_template'] ) && true === $caps['vc_access_rules_post_types/riode_template'] ) ) {
						$role->add_cap( 'vc_access_rules_post_types', 'custom' );
						$role->add_cap( 'vc_access_rules_post_types/riode_template', true );
					}

					break;
			}
		} else {
			wp_send_json_error( esc_html__( 'no page builder is chosen', 'riode-core' ) );
		}

		$post_id = wp_insert_post(
			array(
				'post_title' => $_POST['name'],
				'post_type'  => 'riode_template',
			)
		);

		wp_save_post_revision( $post_id );
		update_post_meta( $post_id, 'riode_template_type', $_POST['type'] );
		if ( isset( $_POST['template_id'] ) && (int) $_POST['template_id'] && isset( $_POST['template_type'] ) && $_POST['template_type'] && isset( $_POST['template_category'] ) && $_POST['template_category'] ) {

			$template_type       = $_POST['template_type'];
			$template_category   = $_POST['template_category'];

			update_post_meta(
				$post_id,
				'riode_start_template',
				array(
					'id'   => (int) $_POST['template_id'],
					'type' => $template_type,
				)
			);
		}

		wp_send_json_success( $post_id );
	}

	public function delete_template( $post_id ) {
		if ( 'riode_template' == get_post_type( $post_id ) ) {
			delete_post_meta( $post_id, 'riode_template_type' );
		}
	}

	public function filter_template_type( $query ) {
		if ( is_admin() ) {
			global $pagenow;

			if ( 'edit.php' == $pagenow && isset( $_GET ) && isset( $_GET['post_type'] ) && 'riode_template' == $_GET['post_type'] ) {
				$template_type = '';
				if ( isset( $_GET['riode_template_type'] ) && $_GET['riode_template_type'] ) {
					$template_type = $_GET['riode_template_type'];
				}

				$query->query_vars['meta_key']   = 'riode_template_type';
				$query->query_vars['meta_value'] = $template_type;
			}
		}
	}
}

Riode_Template::get_instance();
