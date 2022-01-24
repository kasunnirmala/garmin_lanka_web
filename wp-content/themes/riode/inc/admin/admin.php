<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Riode_Admin {

	private $checked_purchase_code;

	private $activation_url = 'https://dythemes.com/wordpress/dummy/api/includes/verify_purchase.php';

	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		if ( is_admin_bar_showing() ) {
			add_action( 'wp_before_admin_bar_render', array( $this, 'add_wp_toolbar_menu' ), 40 );
		}

		add_action( 'after_switch_theme', array( $this, 'after_switch_theme' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_theme_update_url' ), 1001 );

		add_action( 'admin_init', array( $this, 'check_activation' ) );
		add_action( 'admin_init', array( $this, 'show_activation_notice' ) );

		if ( is_admin() ) {
			add_filter( 'pre_set_site_transient_update_themes', array( $this, 'pre_set_site_transient_update_themes' ) );
			add_filter( 'upgrader_pre_download', array( $this, 'upgrader_pre_download' ), 10, 3 );
		}
	}

	public function add_wp_toolbar_menu() {
		if ( current_user_can( 'edit_theme_options' ) ) {
			$riode_toolbar_title = '<span class="ab-icon dashicons dashicons-riode-logo"></span><span class="ab-label">Riode</span>';

			$this->add_wp_toolbar_menu_item( $riode_toolbar_title, false, esc_url( admin_url( 'admin.php?page=riode' ) ), array( 'class' => 'riode-menu' ), 'riode' );

			$this->add_wp_toolbar_menu_item( esc_html__( 'License', 'riode' ), 'riode', esc_url( admin_url( 'admin.php?page=riode' ) ), array( 'target' => '_self' ), 'riode_welcome_license' );
			$this->add_wp_toolbar_menu_item( esc_html__( 'Theme Options', 'riode' ), 'riode', esc_url( admin_url( 'customize.php' ) ), array( 'target' => '_blank' ), 'riode_theme_options' );

			$this->add_wp_toolbar_menu_item( esc_html__( 'Management', 'riode' ), 'riode', esc_url( admin_url( 'admin.php?page=riode-setup-wizard' ) ), array( 'target' => '_self' ), 'riode_management' );

			if ( class_exists( 'Riode_Setup_Wizard' ) ) {
				$this->add_wp_toolbar_menu_item( esc_html__( 'Setup Wizard', 'riode' ), 'riode_management', esc_url( admin_url( 'admin.php?page=riode-setup-wizard' ) ), array( 'target' => '_self' ), 'riode_setup' );
			}

			if ( class_exists( 'Riode_Optimize_Wizard' ) ) {
				$this->add_wp_toolbar_menu_item( esc_html__( 'Optimize Wizard', 'riode' ), 'riode_management', esc_url( admin_url( 'admin.php?page=riode-optimize-wizard' ) ), array( 'target' => '_self' ), 'riode_optimize' );
			}

			if ( class_exists( 'Riode_Version_Control' ) ) {
				$this->add_wp_toolbar_menu_item( esc_html__( 'Version Control', 'riode' ), 'riode_management', esc_url( admin_url( 'admin.php?page=riode-version-control' ) ), array( 'target' => '_self' ), 'riode_version_control' );
			}

			if ( class_exists( 'Riode_Maintenance_Tools' ) ) {
				$this->add_wp_toolbar_menu_item( esc_html__( 'Maintenance Tools', 'riode' ), 'riode_management', esc_url( admin_url( 'admin.php?page=riode-maintenance-tools' ) ), array( 'target' => '_self' ), 'riode_maintenance_tools' );
			}

			$this->add_wp_toolbar_menu_item( esc_html__( 'Builder', 'riode' ), 'riode', esc_url( admin_url( 'admin.php?page=riode_layout_dashboard' ) ), array( 'target' => '_self' ), 'riode_builder' );

			$this->add_wp_toolbar_menu_item( esc_html__( 'Page Layouts', 'riode' ), 'riode_builder', esc_url( admin_url( 'admin.php?page=riode_layout_dashboard' ) ), array( 'target' => '_self' ), 'riode_page_layout' );

			if ( class_exists( 'Riode_Template' ) ) {
				$this->add_wp_toolbar_menu_item( esc_html__( 'Templates Builder', 'riode' ), 'riode_builder', esc_url( admin_url( 'edit.php?post_type=riode_template' ) ), array( 'target' => '_self' ), 'riode_template_builder' );
				$this->add_wp_toolbar_menu_item( esc_html__( 'Sidebar Manage', 'riode' ), 'riode_builder', esc_url( admin_url( 'admin.php?page=riode_sidebar' ) ), array( 'target' => '_self' ), 'riode_sidebar_manage' );
			}

			if ( ! $this->is_registered() ) {
				$this->add_wp_toolbar_menu_item( '<span class="ab-icon dashicons dashicons-admin-network"></span><span class="ab-label">' . esc_html__( 'Activate Theme', 'riode' ) . '</span>', false, esc_url( admin_url( 'admin.php?page=riode' ) ), array( 'class' => 'riode-menu' ), 'riode-activate' );
			}

			do_action( 'riode_add_wp_toolbar_menu', $this );
		}
	}

	public function add_wp_toolbar_menu_item( $title, $parent = false, $href = '', $custom_meta = array(), $custom_id = '' ) {
		global $wp_admin_bar;
		if ( current_user_can( 'edit_theme_options' ) ) {
			if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
				return;
			}
			// Set custom ID
			if ( $custom_id ) {
				$id = $custom_id;
			} else { // Generate ID based on $title
				$id = strtolower( str_replace( ' ', '-', $title ) );
			}
			// links from the current host will open in the current window
			$meta = strpos( $href, home_url() ) !== false ? array() : array( 'target' => '_blank' ); // external links open in new tab/window

			$meta = array_merge( $meta, $custom_meta );
			$wp_admin_bar->add_node(
				array(
					'parent' => $parent,
					'id'     => $id,
					'title'  => $title,
					'href'   => $href,
					'meta'   => $meta,
				)
			);
		}
	}

	public function check_purchase_code() {

		if ( ! $this->checked_purchase_code ) {
			$code         = isset( $_POST['code'] ) ? sanitize_text_field( $_POST['code'] ) : '';
			$code_confirm = $this->get_purchase_code();

			if ( isset( $_POST['action'] ) && ! empty( $_POST['action'] ) ) {
				preg_match( '/[a-z0-9\-]{1,63}\.[a-z\.]{2,6}$/', parse_url( home_url(), PHP_URL_HOST ), $_domain_tld );
				if ( isset( $_domain_tld[0] ) ) {
					$domain = $_domain_tld[0];
				} else {
					$domain = parse_url( home_url(), PHP_URL_HOST );
				}
				if ( ! $code || $code != $code_confirm ) {
					if ( $code_confirm ) {
						$result = $this->curl_purchase_code( $code_confirm, '', 'remove' );
					}
					if ( 'unregister' === $_POST['action'] && isset( $result ) && $result && isset( $result['result'] ) && 3 === (int) $result['result'] ) {
						$this->checked_purchase_code = 'unregister';
						$this->set_purchase_code( '' );
						return $this->checked_purchase_code;
					}
				}
				if ( $code ) {
					$result = $this->curl_purchase_code( $code, $domain, 'add' );
					if ( ! $result ) {
						$this->checked_purchase_code = 'invalid';
						$code_confirm                = '';
					} elseif ( isset( $result['result'] ) && 1 === (int) $result['result'] ) {
						$code_confirm                = $code;
						$this->checked_purchase_code = 'verified';
					} else {
						$this->checked_purchase_code = $this->get_api_message( $result['message'], $result );
						$code_confirm                = '';
					}
				} else {
					$code_confirm                = '';
					$this->checked_purchase_code = '';
				}
				$this->set_purchase_code( $code_confirm );
			} else {
				if ( $code && $code_confirm && $code == $code_confirm ) {
					$this->checked_purchase_code = 'verified';
				}
			}
		}
		return $this->checked_purchase_code;
	}

	public function get_api_message( $msg_code, $data = false ) {
		if ( 'blocked_spam' == $msg_code ) {
			return esc_html__( 'Your ip address is blocked as spam!!!', 'riode' );
		} elseif ( 'code_invalid' == $msg_code ) {
			return esc_html__( 'Purchase Code is not valid!!!', 'riode' );
		} elseif ( 'already_used' == $msg_code && ! empty( $data['domain'] ) ) {
			return vsprintf( esc_html__( 'This code was already used in %s', 'riode' ), $data['domain'] );
		} elseif ( 'reactivate' == $msg_code ) {
			return esc_html__( 'Please re-activate the theme.', 'riode' );
		} elseif ( 'unregistered' == $msg_code ) {
			return esc_html__( 'Riode Theme is unregistered!', 'riode' );
		} elseif ( 'activated' == $msg_code ) {
			return esc_html__( 'Riode Theme is activated!', 'riode' );
		} elseif ( ! empty( $msg_code ) ) {
			return $msg_code;
		}
		return '';
	}

	public function curl_purchase_code( $code, $domain, $act ) {

		require_once RIODE_PLUGINS . '/importer/importer-api.php';
		$importer_api = new Riode_Importer_API();

		$result = $importer_api->get_response(
			$this->activation_url,
			array(
				'body' => array(
					'item'     => 30616619,
					'code'     => $code,
					'domain'   => $domain,
					'siteurl'  => urlencode( home_url() ),
					'act'      => $act,
					'local'    => ( $importer_api->is_localhost() ? true : '' ),
					'template' => get_template(),
				),
			)
		);

		if ( ! $result || is_wp_error( $result ) ) {
			return false;
		}
		return $result;
	}

	public function get_purchase_code() {
		if ( $this->is_envato_hosted() ) {
			return SUBSCRIPTION_CODE;
		}
		return get_option( 'envato_purchase_code_30616619' );
	}

	public function is_registered() {
		if ( $this->is_envato_hosted() ) {
			return true;
		}
		return get_option( 'riode_registered' );
	}

	public function set_purchase_code( $code ) {
		update_option( 'envato_purchase_code_30616619', $code );
	}

	public function is_envato_hosted() {
		return defined( 'ENVATO_HOSTED_KEY' ) ? true : false;
	}

	public function get_ish() {
		if ( ! defined( 'ENVATO_HOSTED_KEY' ) ) {
			return false;
		}
		return substr( ENVATO_HOSTED_KEY, 0, 16 );
	}

	function get_purchase_code_asterisk() {
		$code = $this->get_purchase_code();
		if ( $code ) {
			$code = substr( $code, 0, 13 );
			$code = $code . '-****-****-************';
		}
		return $code;
	}

	public function pre_set_site_transient_update_themes( $transient ) {
		if ( ! $this->is_registered() ) {
			return $transient;
		}

		require_once RIODE_PLUGINS . '/importer/importer-api.php';
		$importer_api   = new Riode_Importer_API();
		$new_version    = $importer_api->get_latest_theme_version();
		$theme_template = get_template();
		if ( version_compare( wp_get_theme( $theme_template )->get( 'Version' ), $new_version, '<' ) ) {

			$args = $importer_api->generate_args( false );
			if ( $this->is_envato_hosted() ) {
				$args['ish'] = $this->get_ish();
			}

			$transient->response[ $theme_template ] = array(
				'theme'       => $theme_template,
				'new_version' => $new_version,
				'url'         => $importer_api->get_url( 'changelog' ),
				'package'     => add_query_arg( $args, $importer_api->get_url( 'theme' ) ),
			);

		}
		return $transient;
	}

	public function upgrader_pre_download( $reply, $package, $obj ) {
		return $reply;

		require_once RIODE_PLUGINS . '/importer/importer-api.php';
		$importer_api = new Riode_Importer_API();
		if ( strpos( $package, $importer_api->get_url( 'theme' ) ) !== false || strpos( $package, $importer_api->get_url( 'plugins' ) ) !== false ) {
			if ( ! $this->is_registered() ) {
				return new WP_Error( 'not_registerd', sprintf( esc_html__( 'Please %s Riode theme to get access to pre-built demo websites and auto updates.', 'riode' ), '<a href="admin.php?page=riode">' . esc_html__( 'register', 'riode' ) . '</a>' ) );
			}
			$code   = $this->get_purchase_code();
			$domain = $importer_api->generate_args();
			$domain = $domain['domain'];
			$result = $this->curl_purchase_code( $code, $domain, 'add' );
			if ( ! isset( $result['result'] ) || 1 !== (int) $result['result'] ) {
				$message = isset( $result['message'] ) ? $result['message'] : esc_html__( 'Purchase Code is not valid or could not connect to the API server!', 'riode' );
				return new WP_Error( 'purchase_code_invalid', esc_html( $message ) );
			}
		}
		return $reply;
	}

	public function add_theme_update_url() {
		global $pagenow;
		if ( 'update-core.php' == $pagenow ) {

			require_once RIODE_PLUGINS . '/importer/importer-api.php';
			$importer_api   = new Riode_Importer_API();
			$new_version    = $importer_api->get_latest_theme_version();
			$theme_template = get_template();
			if ( version_compare( RIODE_VERSION, $new_version, '<' ) ) {
				$url         = $importer_api->get_url( 'changelog' );
				$checkbox_id = md5( wp_get_theme( $theme_template )->get( 'Name' ) );
				wp_add_inline_script( 'riode-admin', 'if (jQuery(\'#checkbox_' . $checkbox_id . '\').length) {jQuery(\'#checkbox_' . $checkbox_id . '\').closest(\'tr\').children().last().append(\'<a href="' . esc_url( $url ) . '" target="_blank">' . esc_html__( 'View Details', 'riode' ) . '</a>\');}' );
			}
		}
	}

	public function after_switch_theme() {
		if ( $this->is_registered() ) {
			$this->refresh_transients();
		}
	}

	public function refresh_transients() {
		delete_site_transient( 'riode_plugins' );
		delete_site_transient( 'update_themes' );
		unset( $_COOKIE['riode_dismiss_activate_msg'] );
		setcookie( 'riode_dismiss_activate_msg', null, -1, '/' );
	}

	public function activation_notices() {
		?>
		<div class="notice error notice-error is-dismissible">
			<?php /* translators: $1 and $2 opening and closing strong tags respectively */ ?>
			<p><?php printf( esc_html__( 'Please %1$sregister%2$s riode theme to get access to pre-built demo websites and auto updates.', 'riode' ), '<a href="admin.php?page=riode">', '</a>' ); ?></p>
			<?php /* translators: $1 and $2 opening and closing strong tags respectively, and $3 and $4 are opening and closing anchor tags respectively */ ?>
			<p><?php printf( esc_html__( '%1$s Important! %2$s One %3$s standard license %4$s is valid for only %1$s1 website%2$s. Running multiple websites on a single license is a copyright violation.', 'riode' ), '<strong>', '</strong>', '<a target="_blank" href="https://themeforest.net/licenses/standard">', '</a>' ); ?></p>
			<button type="button" class="notice-dismiss riode-notice-dismiss"><span class="screen-reader-text"><?php esc_html__( 'Dismiss this notice.', 'riode' ); ?></span></button>
		</div>
		<script>
			(function($) {
				var setCookie = function (name, value, exdays) {
					var exdate = new Date();
					exdate.setDate(exdate.getDate() + exdays);
					var val = encodeURIComponent(value) + ((null === exdays) ? "" : "; expires=" + exdate.toUTCString());
					document.cookie = name + "=" + val;
				};
				$(document).on('click.riode-notice-dismiss', '.riode-notice-dismiss', function(e) {
					e.preventDefault();
					var $el = $(this).closest('.notice');
					$el.fadeTo( 100, 0, function() {
						$el.slideUp( 100, function() {
							$el.remove();
						});
					});
					setCookie('riode_dismiss_activate_msg', '<?php echo RIODE_VERSION; ?>', 30);
				});
			})(window.jQuery);
		</script>
		<?php
	}

	public function activation_message() {
		?>
		<script>
			(function($){
				$(window).on('load', function() {
					<?php /* translators: $1 and $2 are opening and closing anchor tags respectively */ ?>
					$('.themes .theme.active .theme-screenshot').after('<div class="notice update-message notice-error notice-alt"><p><?php printf( esc_html__( 'Please %1$sverify purchase%2$s to get updates!', 'riode' ), '<a href="admin.php?page=riode" class="button-link">', '</a>' ); ?></p></div>');
				});
			})(window.jQuery);
		</script>
		<?php
	}

	public function check_activation() {
		if ( isset( $_POST['riode_registration'] ) && check_admin_referer( 'riode-setup-wizard' ) ) {
			update_option( 'riode_register_error_msg', '' );
			$result = $this->check_purchase_code();
			if ( 'verified' === $result ) {
				update_option( 'riode_registered', true );
				$this->refresh_transients();
			} elseif ( 'unregister' === $result ) {
				update_option( 'riode_registered', false );
				$this->refresh_transients();
			} elseif ( 'invalid' === $result ) {
				update_option( 'riode_registered', false );
				update_option( 'riode_register_error_msg', esc_html__( 'There is a problem contacting to the Riode API server. Please try again later.', 'riode' ) );
			} else {
				update_option( 'riode_registered', false );
				update_option( 'riode_register_error_msg', $result );
			}
		}
	}

	public function show_activation_notice() {
		if ( ! $this->is_registered() ) {
			if ( ( 'themes.php' == $GLOBALS['pagenow'] && isset( $_GET['page'] ) ) ||
				empty( $_COOKIE['riode_dismiss_activate_msg'] ) ||
				version_compare( $_COOKIE['riode_dismiss_activate_msg'], RIODE_VERSION, '<' )
			) {
				add_action( 'admin_notices', array( $this, 'activation_notices' ) );
			} elseif ( 'themes.php' == $GLOBALS['pagenow'] ) {
				add_action( 'admin_footer', array( $this, 'activation_message' ) );
			}
		}
	}
}

Riode_Admin::get_instance();
