<?php
/**
 * Initialize TGM plugins
 */
class Riode_TGM_Plugins {

	/**
	 * Array of plugins. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array $plugins
	 */
	protected $plugins = array(
		'riode-core'                       => array(
			'name'      => 'Riode Core',
			'slug'      => 'riode-core',
			'source'    => RIODE_PLUGINS_URI . '/riode-core.zip',
			'required'  => true,
			'version'   => '1.4.3',
			'url'       => 'riode-core/riode-core.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/riode-core.png',
			'usein'     => 'setup',
		),
		'kirki'                            => array(
			'name'      => 'Kirki',
			'slug'      => 'kirki',
			'required'  => true,
			'url'       => 'kirki/kirki.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/kirki.png',
			'usein'     => 'setup',
		),
		'customizer-search'                => array(
			'name'      => 'Customizer Search',
			'slug'      => 'customizer-search',
			'required'  => true,
			'url'       => 'customizer-search/customizer-search.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/plugins.png',
			'usein'     => 'setup',
		),
		'woocommerce'                      => array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => true,
			'url'       => 'woocommerce/woocommerce.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/woocommerce.png',
			'usein'     => 'setup',
		),
		'wpb'                              => array(
			'name'      => 'WPBakery Page Builder',
			'slug'      => 'js_composer',
			'required'  => false,
			'url'       => 'js_composer/js_composer.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/wpb.png',
			'usein'     => 'setup',
		),
		'elementor'                        => array(
			'name'      => 'Elementor',
			'slug'      => 'elementor',
			'required'  => false,
			'url'       => 'elementor/elementor.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/elementor.png',
			'usein'     => 'setup',
		),
		'yith-woocommerce-wishlist'        => array(
			'name'      => 'YITH Woocommerce Wishlist',
			'slug'      => 'yith-woocommerce-wishlist',
			'required'  => false,
			'url'       => 'yith-woocommerce-wishlist/init.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/yith_wishlist.png',
			'usein'     => 'setup',
		),
		'dokan-lite'                       => array(
			'name'      => 'Dokan Lite',
			'slug'      => 'dokan-lite',
			'required'  => false,
			'url'       => 'dokan-lite/dokan.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/dokan_lite.png',
			'usein'     => 'setup',
		),
		'wc-multivendor-marketplace'       => array(
			'name'      => 'WCFM - WooCommerce Multivendor Marketplace',
			'slug'      => 'wc-multivendor-marketplace',
			'required'  => false,
			'url'       => 'wc-multivendor-marketplace/wc-multivendor-marketplace.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/wcfmmp.png',
			'usein'     => 'setup',
		),
		'wc-frontend-manager'              => array(
			'name'      => 'WCFM - WooCommerce Frontend Manager',
			'slug'      => 'wc-frontend-manager',
			'required'  => false,
			'url'       => 'wc-frontend-manager/wc_frontend_manager.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/wcfmmp.png',
			'usein'     => 'setup',
		),
		'contact-form-7'                   => array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
			'url'       => 'contact-form-7/wp-contact-form-7.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/contact_form_7.png',
			'usein'     => 'setup',
		),
		'yith-woocommerce-ajax-navigation' => array(
			'name'      => 'YITH WooCommerce Ajax Product Filter',
			'slug'      => 'yith-woocommerce-ajax-navigation',
			'required'  => false,
			'url'       => 'yith-woocommerce-ajax-navigation/init.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/yith_ajax_filter.png',
			'usein'     => 'setup',
		),
		'meta-box'                         => array(
			'name'      => 'Meta-Box',
			'slug'      => 'meta-box',
			'required'  => false,
			'url'       => 'meta-box/meta-box.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/meta_box.png',
			'usein'     => 'setup',
		),
		'regenerate-thumbnails'            => array(
			'name'      => 'Regenerate Thumbnails',
			'slug'      => 'regenerate-thumbnails',
			'required'  => false,
			'url'       => 'regenerate-thumbnails/regenerate-thumbnails.php',
			'image_url' => RIODE_PLUGINS_URI . '/images/regenerate_thumbnails.png',
			'usein'     => 'setup',
		),
		'seo-by-rank-math'                   => array(
			'name'       => 'Rank Math SEO',
			'slug'       => 'seo-by-rank-math',
			'required'   => false,
			'seo'        => true,
			'url'        => 'seo-by-rank-math/rank-math.php',
			'image_url'  => RIODE_PLUGINS_URI . '/images/rank_math_seo.png',
			'usein'      => 'setup',
		),
		'wordpress-seo'                       => array(
			'name'       => 'Yoast SEO',
			'slug'       => 'wordpress-seo',
			'required'   => false,
			'seo'        => true,
			'url'        => 'wordpress-seo/wp-seo.php',
			'image_url'  => RIODE_PLUGINS_URI . '/images/yoast_seo.png',
			'usein'      => 'setup',
		),
		'wp-optimize'                      => array(
			'name'       => 'Wp Optimize',
			'slug'       => 'wp-optimize',
			'required'   => false,
			'url'        => 'wp-optimize/wp-optimize.php',
			'visibility' => 'optimize_wizard',
			'desc'       => 'plugin cleans your database by removing unnecessary data, tables and data fragmentation, compresses your images and caches your site for your super fast load times',
			'usein'      => 'optimize',
		),
		'advanced-database-cleaner'        => array(
			'name'       => 'Advanced Database Cleaner',
			'slug'       => 'advanced-database-cleaner',
			'required'   => false,
			'url'        => 'advanced-database-cleaner/advanced-db-cleaner.php',
			'visibility' => 'optimize_wizard',
			'desc'       => 'plugin cleans up database by deleting orphaned items such as old revisions, spam comments, optimize database and more...',
			'usein'      => 'optimize',
		),
		'wp-super-cache'                   => array(
			'name'       => 'WP Super Cache',
			'slug'       => 'wp-super-cache',
			'required'   => false,
			'url'        => 'wp-super-cache/wp-cache.php',
			'visibility' => 'optimize_wizard',
			'desc'       => 'plugin generates static html files from your dynamic WordPress blog.',
			'usein'      => 'optimize',
		),
		'fast-velocity-minify'             => array(
			'name'       => 'Fast Velocity Minify',
			'slug'       => 'fast-velocity-minify',
			'required'   => false,
			'url'        => 'fast-velocity-minify/fvm.php',
			'visibility' => 'optimize_wizard',
			'desc'       => 'plugin reduces HTTP requests by merging CSS & Javascript files into groups of files, while attempting to use the least amount of files as possible.',
			'usein'      => 'optimize',
		),
	);

	/**
	 * Demo Plugin Dependencies
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @var array $demo_plugin_dependencies
	 */
	public $demo_plugin_dependencies = array(
		'demo-1'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-2'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-3'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-4'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-5'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-6'        => array(
			'yith-woocommerce-wishlist' => true,
		),
		'demo-7'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-8'        => array(
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-9'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-10'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-11'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-12'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-13'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-14'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-15'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-16'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-17'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-18'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-19'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-20'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-21'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-22'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-23'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-24'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-25'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-26'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-27'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-28'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-29'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-30'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-31'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-32'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-33'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-34'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-35'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'demo-36'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'kid'           => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'food'          => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'beauty'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'diamart'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'sport'         => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'medical'       => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'market-1'      => array(
			'dokan-lite'                       => true,
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'market-2'      => array(
			'dokan-lite'                       => true,
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'market-wcfm-1' => array(
			'wc-multivendor-marketplace'       => true,
			'wc-frontend-manager'              => true,
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'market-wcfm-2' => array(
			'wc-multivendor-marketplace'       => true,
			'wc-frontend-manager'              => true,
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'tea'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'cake'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'yoga'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'landing-1'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
		'food-2'        => array(
			'contact-form-7'                   => true,
			'yith-woocommerce-ajax-navigation' => true,
			'yith-woocommerce-wishlist'        => true,
		),
	);

	public function __construct() {
		$plugin = RIODE_PLUGINS . '/tgm-plugin-activation/class-tgm-plugin-activation.php';
		if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
			require_once $plugin;
		}

		add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );

		add_filter( 'tgmpa_notice_action_links', array( $this, 'update_action_links' ), 10, 1 );

		$this->plugins = $this->get_plugins_list();
	}

	public function get_plugins_list() {
		return $this->plugins;
		// get transient
		$plugins = get_site_transient( 'riode_plugins' );
		if ( ! $plugins ) {
			$plugins = $this->update_plugins_list();
		}
		if ( ! $plugins ) {
			return $this->plugins;
		}
		return array_merge( $plugins, $this->plugins );
	}

	private function update_plugins_list() {

		require_once RIODE_PLUGINS . '/importer/importer-api.php';
		$importer_api = new Riode_Importer_API();
		$plugins      = $importer_api->get_response( 'plugins_version' );

		if ( is_wp_error( $plugins ) || ! $plugins ) {
			return false;
		}

		$args = $importer_api->generate_args( false );

		foreach ( $plugins as $key => $plugin ) {
			$args['plugin']               = $plugin['slug'];
			$plugins[ $key ]['source']    = add_query_arg( $args, $importer_api->get_url( 'plugins' ) );
			$plugins[ $key ]['image_url'] = RIODE_PLUGINS_URI . '/images/' . $args['plugin'] . '.png';
			$plugins[ $key ]['usein']     = 'setup';
		}
		// set transient
		set_site_transient( 'riode_plugins', $plugins, 4 * 24 * HOUR_IN_SECONDS );

		return $plugins;
	}

	public function register_required_plugins() {
		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       => 'riode',                    // Text domain - likely want to be the same as your theme.
			'default_path' => '',                          // Default absolute path to pre-packaged plugins
			'menu'         => 'install-required-plugins',  // Menu slug
			'has_notices'  => true,                        // Show admin notices or not
			'is_automatic' => true,                        // Automatically activate plugins after installation or not
			'message'      => '',                          // Message to output right before the plugins table
		);

		tgmpa( $this->plugins, $config );
	}

	public function update_action_links( $action_links ) {
		$url = add_query_arg(
			array(
				'page' => 'riode-setup-wizard',
				'step' => 'default_plugins',
			),
			self_admin_url( 'admin.php' )
		);
		foreach ( $action_links as $key => $link ) {
			if ( $link ) {
				$link                 = preg_replace( '/<a([^>]*)href="([^"]*)"/i', '<a$1href="' . esc_url( $url ) . '"', $link );
				$action_links[ $key ] = $link;
			}
		}
		return $action_links;
	}
}

new Riode_TGM_Plugins();
