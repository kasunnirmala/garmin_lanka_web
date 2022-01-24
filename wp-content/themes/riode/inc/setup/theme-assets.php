<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Load core css and js
 */

/**
 * Manage Theme and Plugin Assets
 */
// Remove WooCommerce Style
if ( ! is_admin() ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
}
add_action( 'wp_enqueue_scripts', 'riode_yith_styles', 20 );
add_action( 'wp_enqueue_scripts', 'riode_register_scripts' );
add_action( 'wp_enqueue_scripts', 'riode_enqueue_scripts' );
add_action( 'wp_enqueue_scripts', 'riode_enqueue_styles', 20 );
add_action( 'wp_enqueue_scripts', 'riode_enqueue_custom_css', 999 );
add_action( 'wp_enqueue_scripts', 'riode_dequeue_scripts_styles', 99 );
add_action( 'wp_enqueue_scripts', 'riode_enqueue_lazy_scripts', 999 );
add_action( 'admin_enqueue_scripts', 'riode_load_admin_scripts' );
add_action( 'wp_print_footer_scripts', 'riode_print_async_scripts', 20 );

function riode_yith_styles() {
	// Dequeue Yith Font Icon
	if ( ! defined( 'YITH_WCWL_PREMIUM' ) ) {
	wp_dequeue_style( 'yith-wcwl-font-awesome' );
	wp_deregister_style( 'yith-wcwl-font-awesome' );
}
}

function riode_load_admin_scripts() {
	wp_enqueue_style( 'riode-admin', RIODE_CSS . '/admin/admin' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', null, RIODE_VERSION, 'all' );
	wp_enqueue_script( 'riode-admin', RIODE_JS . '/admin/admin' . riode_get_js_extension(), array( 'jquery-core' ), RIODE_VERSION, true );

	// font awesome for admin
	wp_enqueue_style( 'font-awesome-free', RIODE_ASSETS . '/vendor/fontawesome-free/css/all.min.css', array(), '5.14.0' );

	riode_load_google_font();

	wp_localize_script(
		'riode-admin',
		'riode_admin_vars',
		apply_filters(
			'riode_admin_vars',
			array(
				'ajax_url'  => esc_url( admin_url( 'admin-ajax.php' ) ),
				'nonce'     => wp_create_nonce( 'riode-admin' ),
				'theme_url' => RIODE_URI,
			)
		)
	);
}

function riode_enqueue_styles() {
	wp_enqueue_style( 'fontawesome-free', RIODE_ASSETS . '/vendor/fontawesome-free/css/all.min.css', array(), '5.14.0' );
	wp_enqueue_style( 'riode-icons', RIODE_ASSETS . '/vendor/riode-icons/css/icons.min.css', array(), RIODE_VERSION );
	wp_enqueue_style( 'owl-carousel', RIODE_CSS . '/3rd-plugins/owl.carousel' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );

	wp_enqueue_style( 'magnific-popup', RIODE_CSS . '/3rd-plugins/magnific-popup' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), '1.0' );

	$css_files  = array( 'theme', 'blog', 'single-post', 'shop', 'shop-other', 'single-product' );
	$upload_dir = wp_upload_dir()['basedir'];
	$upload_url = wp_upload_dir()['baseurl'];
	foreach ( $css_files as $file ) {
		$filename = 'theme' . ( 'theme' == $file ? '' : '-' . $file );
		if ( file_exists( wp_normalize_path( $upload_dir . '/riode_styles/' . $filename . '.min.css' ) ) ) {
			wp_register_style( 'riode-' . $filename, $upload_url . '/riode_styles/' . $filename . '.min.css', array(), RIODE_VERSION );
		} else {
			wp_register_style( 'riode-' . $filename, RIODE_CSS . '/theme/' . ( 'theme' == $file ? '' : 'pages/' ) . $file . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array(), RIODE_VERSION );
		}
	}

	if ( current_user_can( 'edit_pages' ) ) {
		wp_enqueue_style( 'bootstrap-tooltip', RIODE_ASSETS . '/vendor/bootstrap/bootstrap.tooltip.css', array(), '4.1.3' );
	}

	do_action( 'riode_before_enqueue_theme_style' );
	wp_enqueue_style( 'riode-theme' );

	// theme page style
	$custom_css_handle = 'riode-theme';

	if ( 'product_archive_layout' == riode_get_layout_value( 'slug' ) ) { // Product Archive Page
		$custom_css_handle = 'riode-theme-shop';
		wp_enqueue_style( 'riode-theme-shop' );
		riode_add_async_script( 'jquery-cookie' );
	} elseif ( 'post_archive_layout' == riode_get_layout_value( 'slug' ) ) { // Blog Page
		$custom_css_handle = 'riode-theme-blog';
		wp_enqueue_style( 'riode-theme-blog' );
	} elseif ( 'page_layout' == riode_get_layout_value( 'slug' ) ) { // Page
		if ( defined( 'YITH_WCWL_PREMIUM' ) && function_exists( 'yith_wcwl_is_wishlist_page' ) && yith_wcwl_is_wishlist_page() ) {
			wp_dequeue_style( 'yith-wcwl-main' );
		}
		if ( ( defined( 'YITH_WCWL' ) && function_exists( 'yith_wcwl_is_wishlist_page' ) && yith_wcwl_is_wishlist_page() ) || (
			class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) ) ) {
			$custom_css_handle = 'riode-theme-shop-other';
			wp_enqueue_style( 'riode-theme-shop-other' );
		}
	} elseif ( 'product_single_layout' == riode_get_layout_value( 'slug' ) ) { // Single Product Page
		$custom_css_handle = 'riode-theme-single-product';
		wp_enqueue_style( 'riode-theme-single-product' );
	} elseif ( 'post_single_layout' == riode_get_layout_value( 'slug' ) ) { // Single Post Page
		$custom_css_handle = 'riode-theme-single-post';
		wp_enqueue_style( 'riode-theme-single-post' );
	}

	if ( file_exists( wp_normalize_path( $upload_dir . '/riode_styles/dynamic_css_vars.css' ) ) ) {
		$dynamic_url = $upload_url . '/riode_styles/dynamic_css_vars.css';
	} else {
		$dynamic_url = RIODE_CSS . '/theme/dynamic_css_vars.css';
	}

	// global css
	if ( ! is_customize_preview() ) {
		wp_enqueue_style( 'riode-dynamic-vars', $dynamic_url, array( $custom_css_handle ), RIODE_VERSION );

		$custom_css = riode_get_option( 'custom_css' );
		if ( $custom_css ) {
			wp_add_inline_style( $custom_css_handle, '/* Global CSS */' . PHP_EOL . wp_strip_all_tags( wp_specialchars_decode( $custom_css ) ) );
		}
	} else {
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$upload_dir = wp_upload_dir()['basedir'];

		if ( file_exists( wp_normalize_path( $upload_dir . '/riode_styles/dynamic_css_vars.css' ) ) ) {
			$dynamic_dir = wp_normalize_path( $upload_dir . '/riode_styles/dynamic_css_vars.css' );
			$data        = $wp_filesystem->get_contents( $dynamic_dir );
		} else {
		        $dynamic_url = str_replace( 'https:', 'http:', $dynamic_url );
		        $data        = $wp_filesystem->get_contents( $dynamic_url );
		}

		wp_add_inline_style( $custom_css_handle, $data );
	}

	do_action( 'riode_after_enqueue_theme_style' );

	riode_load_google_font();
}

if ( defined( 'YITH_WCWL' ) ) {
	add_filter( 'yith_wcwl_main_script_deps', 'riode_yith_wcwl_main_deps_remove_selectbox' );
	function riode_yith_wcwl_main_deps_remove_selectbox( $deps ) {
		foreach ( $deps as $i => $dep ) {
			if ( 'jquery-selectBox' == $dep ) {
				array_splice( $deps, $i, 1 );
			}
		}
		return $deps;
	}
}

/**
 * block gutenberg editor
 */

function riode_dequeue_scripts_styles() {

	// YITH WCWL styles & scripts
	if ( defined( 'YITH_WCWL' ) && ! defined( 'YITH_WCWL_PREMIUM' ) ) {
		// YITH : main style was dequeued because of font-awesome
		wp_dequeue_style( 'yith-wcwl-main' );
		wp_dequeue_style( 'yith-wcwl-font-awesome' );

		wp_dequeue_style( 'jquery-selectBox' );
		wp_dequeue_script( 'jquery-selectBox' );

		// checkout
		if ( function_exists( 'is_checkout' ) && is_checkout() ) {
			wp_dequeue_style( 'selectWoo' );
			wp_deregister_style( 'selectWoo' );
		}
	}

	// WooCommerce PrettyPhoto(deprecated), but YITH Wishlist use
	if ( class_exists( 'WooCommerce' ) && ! defined( 'YITH_WCWL_PREMIUM' ) ) {
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		wp_deregister_style( 'woocommerce_prettyPhoto_css' );
		wp_dequeue_script( 'prettyPhoto-init' );
		wp_dequeue_script( 'prettyPhoto' );
	}

	// Optimize disable
	if ( riode_get_option( 'resource_disable_gutenberg' ) ) {
		wp_dequeue_style( 'wp-block-library' );
	}
	if ( riode_get_option( 'resource_disable_wc_blocks' ) ) {
		wp_dequeue_style( 'wc-block-style' );
		wp_deregister_style( 'wc-block-style' );
		wp_dequeue_style( 'wc-block-vendors-style' );
		wp_deregister_style( 'wc-block-vendors-style' );
	}
}

function riode_enqueue_custom_css() {

	do_action( 'riode_before_enqueue_custom_css' );

	// Theme Style
	wp_enqueue_style( 'riode-style', RIODE_URI . '/style.css', array(), RIODE_VERSION );

	// Enqueue Page CSS
	if ( function_exists( 'riode_is_elementor_preview' ) && riode_is_elementor_preview() ) {
		$page_css = '';

		wp_enqueue_script( 'isotope-pkgd' );
		wp_enqueue_script( 'jquery-parallax' );
		wp_enqueue_script( 'isotope-plugin' );
		wp_enqueue_script( 'jquery-countdown' );
	} else {
		$page_css = get_post_meta( intval( get_the_ID() ), 'page_css', true );
	}

	if ( $page_css ) {
		wp_add_inline_style( 'riode-style', '/* Page CSS */' . PHP_EOL . riode_strip_script_tags( $page_css ) );
	}

	do_action( 'riode_after_enqueue_custom_style' );
}

function riode_register_scripts() {
	wp_register_script( 'jquery-lazyload', RIODE_ASSETS . '/vendor/jquery.lazyload/jquery.lazyload.min.js', array( 'jquery-core' ), false, true );
	wp_register_script( 'owl-carousel', RIODE_ASSETS . '/vendor/owl-carousel/owl.carousel.min.js', array( 'jquery-core', 'imagesloaded' ), '2.3.4', true );
	wp_register_script( 'jquery-magnific-popup', RIODE_ASSETS . '/vendor/jquery.magnific-popup/jquery.magnific-popup.min.js', array( 'jquery-core', 'imagesloaded' ), '1.1.0', true );
	wp_register_script( 'isotope-pkgd', RIODE_ASSETS . '/vendor/isotope/isotope.pkgd.min.js', array( 'jquery-core', 'imagesloaded' ), '3.0.6', true );
	wp_register_script( 'jquery-fitvids', RIODE_ASSETS . '/vendor/jquery.fitvids/jquery.fitvids.min.js', array( 'jquery-core' ), false, true );
	wp_register_script( 'jquery-countdown', RIODE_ASSETS . '/vendor/jquery.countdown/jquery.countdown.min.js', array( 'jquery-core' ), false, true );
	wp_register_script( 'jquery-count-to', RIODE_ASSETS . '/vendor/jquery.count-to/jquery.count-to.min.js', array( 'jquery-core' ), false, true );
	wp_register_script( 'jquery-parallax', RIODE_ASSETS . '/vendor/parallax/parallax.min.js', array( 'jquery-core' ), false, true );
	wp_register_script( 'jquery-floating', RIODE_ASSETS . '/vendor/jquery.floating/jquery.floating.min.js', array( 'jquery-core' ), false, true );
	wp_register_script( 'jquery-skrollr', RIODE_ASSETS . '/vendor/skrollr/skrollr.min.js', array(), '0.6.30', true );
	wp_register_script( 'jquery-cookie', RIODE_ASSETS . '/vendor/jquery.cookie/jquery.cookie.min.js', array(), '1.4.1', true );
	wp_register_script( 'three-sixty', RIODE_ASSETS . '/vendor/threesixty/threesixty.min.js', array(), '2.0.5', true );

	wp_register_script( 'riode-sticky-lib', RIODE_JS . '/libs/sticky' . riode_get_js_extension(), array( 'jquery-core' ), RIODE_VERSION, true );
	wp_register_script( 'riode-theme-async', RIODE_JS . '/theme-async' . riode_get_js_extension(), array( 'riode-theme' ), RIODE_VERSION, true );
}

function riode_enqueue_scripts() {
	do_action( 'riode_before_enqueue_theme_script' );

	if ( current_user_can( 'edit_pages' ) ) {
		wp_enqueue_script( 'popper', RIODE_ASSETS . '/vendor/bootstrap/popper.min.js', array( 'jquery-core' ), '4.1.3', true );
		wp_enqueue_script( 'bootstrap-tooltip', RIODE_ASSETS . '/vendor/bootstrap/bootstrap.tooltip.min.js', array( 'popper' ), '4.1.3', true );
	}

	wp_enqueue_script( 'riode-theme', RIODE_JS . '/theme' . riode_get_js_extension(), array( 'jquery-core' ), RIODE_VERSION, true );
	do_action( 'riode_after_enqueue_theme_script' );

	$my_account_page_link = '';

	if ( class_exists( 'WooCommerce' ) ) {
		$my_account_page_link = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
	}

	$localize_vars = array(
		'ajax_url'             => esc_url( admin_url( 'admin-ajax.php' ) ),
		'nonce'                => wp_create_nonce( 'riode-nonce' ),
		'lazyload'             => riode_get_option( 'lazyload' ),
		'skeleton_screen'      => riode_get_option( 'skeleton_screen' ),
		'container'            => riode_get_option( 'container' ),
		'gutters'              => array(
			'lg' => riode_get_option( 'gutter_lg' ),
			'md' => riode_get_option( 'gutter' ),
			'sm' => riode_get_option( 'gutter_sm' ),
		),
		'assets_url'           => RIODE_ASSETS,
		'texts'                => array(
			'loading'        => esc_html__( 'Loading...', 'riode' ),
			'loadmore_error' => esc_html__( 'Loading failed', 'riode' ),
			'popup_error'    => esc_html__( 'The content could not be loaded.', 'riode' ),
			'show_info_all'  => esc_html__( 'all %d', 'riode' ),
		),
		'resource_async_js'    => riode_get_option( 'resource_async_js' ),
		'resource_split_tasks' => riode_get_option( 'resource_split_tasks' ),
		'resource_idle_run'    => riode_get_option( 'resource_idle_run' ),
		'resource_after_load'  => riode_get_option( 'resource_after_load' ),
		'riode_cache_key'      => 'riode_cache_' . MD5( home_url() ),
		'lazyload_menu'        => boolval( riode_get_option( 'lazyload_menu' ) ),
		'shop_toolbox_sticky'  => riode_get_option( 'shop_toolbox_sticky' ),
		'preview'              => array(),
		'my_account_page_link' => $my_account_page_link,
	);

	if ( 'post_archive' == riode_get_page_layout() ) {
		$localize_vars['posts_per_page'] = get_option( 'posts_per_page' );
	}

	if ( riode_get_option( 'lazyload_menu' ) ) {
		$localize_vars['menu_last_time'] = riode_get_option( 'menu_last_time' );
	}
	if ( riode_get_option( 'blog_ajax' ) ) {
		$localize_vars['blog_ajax'] = 1;
	}
	if ( riode_get_option( 'shop_ajax' ) ) {
		$localize_vars['shop_ajax'] = 1;
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$localize_vars = array_merge_recursive(
			$localize_vars,
			array(
				'quickview_type'                      => riode_get_option( 'product_quickview_type' ),
				'product_quickview_popup_loading'     => riode_get_option( 'product_quickview_popup_loading' ),
				'product_quickview_offcanvas_loading' => riode_get_option( 'product_quickview_offcanvas_loading' ),
				'pre_order'                           => riode_is_product() && riode_get_option( 'woo_pre_order' ),
				'wc_alert_remove'                     => riode_get_option( 'wc_alert_remove' ) * 1000,
				'texts'                               => array(
					'added_to_cart'   => esc_html__( 'Successfully Added To Cart', 'riode' ),
					'add_to_wishlist' => esc_html__( 'Add to wishlist', 'riode' ),
					'view_cart'       => esc_html__( 'View Cart', 'riode' ),
					'view_checkout'   => esc_html__( 'Check Out', 'riode' ),
				),
				'pages'                               => array(
					'shop'     => esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ),
					'cart'     => wc_get_page_permalink( 'cart' ),
					'checkout' => wc_get_page_permalink( 'checkout' ),
				),
				'single_product'                      => array(
					'zoom_enabled' => true,
					'zoom_options' => array(),
				),
				'placeholder_img'                     => wc_placeholder_img_src(),
			)
		);

		if ( function_exists( 'riode_sales_popup_data' ) ) {
			$localize_vars['sales_popup'] = riode_sales_popup_data();
		}
	}

	wp_localize_script(
		'riode-theme',
		'riode_vars',
		apply_filters( 'riode_vars', $localize_vars )
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

function riode_enqueue_lazy_scripts() {
	riode_add_async_script( 'riode-theme-async' );
}

function riode_add_async_style( $handle ) {
	global $riode_async_styles;

	if ( ! isset( $riode_async_styles ) ) {
		$riode_async_styles = array();
	}

	if ( ! in_array( $handle, $riode_async_styles ) ) {
		$riode_async_styles[] = $handle;
	}
}

function riode_add_async_script( $handle ) {
	global $riode_async_scripts;

	if ( ! isset( $riode_async_scripts ) ) {
		$riode_async_scripts = array();
	}

	if ( ! in_array( $handle, $riode_async_scripts ) ) {
		$riode_async_scripts[] = $handle;
	}
}

function riode_print_async_scripts() {
	global $riode_async_styles;
	global $riode_async_scripts;

	if ( isset( $riode_async_styles ) ) {
		wp_print_styles( $riode_async_scripts );
	}
	if ( isset( $riode_async_scripts ) ) {
		wp_print_scripts( $riode_async_scripts );
	}

	$global_js = riode_get_option( 'custom_js' );

	if ( $global_js ) {
		?>
		<script id="riode_custom_global_script">
			(function($) {
				$(window).on('riode_complete', function() {
					<?php echo riode_strip_script_tags( $global_js ); ?>
				});
			})(jQuery);
		</script>
		<?php
	}

	$page_js = get_post_meta( intval( get_the_ID() ), 'page_js', true );
	if ( $page_js ) {
		?>
		<script id="riode_custom_page_script">
			(function($) {
				$(window).on('riode_complete', function() {
					<?php echo riode_strip_script_tags( $page_js ); ?>
				});
			})(jQuery);
		</script>
		<?php
	}

	$used_blocks = riode_get_layout_value( 'used_blocks' );
	if ( ! empty( $used_blocks ) ) {
		foreach ( $used_blocks as $block_id => $value ) {
			$script = get_post_meta( $block_id, 'page_js', true );
			if ( $script ) {
				?>
			<script id="riode_block_<?php echo esc_attr( $block_id ); ?>_script">
				(function($) {
					$(window).on('riode_complete', function() {
						<?php echo riode_strip_script_tags( $script ); ?>
					});
				})(jQuery);
			</script>
				<?php
			}

			$riode_layout['used_blocks'][ $block_id ]['js'] = true;
		}
	}
}
