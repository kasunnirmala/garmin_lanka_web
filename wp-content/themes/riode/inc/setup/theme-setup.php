<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}


add_action( 'after_setup_theme', 'riode_theme_setup' );

/**
 * Add defualt theme-editor options
 */
if ( ! function_exists( 'riode_theme_setup' ) ) :
	/**
	 * Set up and register options for riode theme.
	 *
	 */

	if ( class_exists( 'WooCommerce' ) ) {
		add_filter(
			'riode_nav_menu',
			function( $menu ) {
				$menu['account-menu'] = esc_html__( 'Account Menu', 'riode' );
				return $menu;
			}
		);
	}

	function riode_theme_setup() {

		// translation
		load_theme_textdomain( 'riode', RIODE_PATH . '/languages' );
		load_child_theme_textdomain( 'riode', get_theme_file_path() . '/languages' );

		register_nav_menus(
			apply_filters(
				'riode_nav_menu',
				array(
					'cur-switcher'  => esc_html__( 'Currency Switcher', 'riode' ),
					'lang-switcher' => esc_html__( 'Language Switcher', 'riode' ),
					'main-menu'     => esc_html__( 'Main Menu', 'riode' ),
				)
			)
		);

		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-header', array() );
		add_theme_support( 'custom-background', array() );
		add_theme_support( 'woocommerce' );

		// default rss feed links
		add_theme_support( 'automatic-feed-links' );
		// add support for post thumbnails
		add_theme_support( 'post-thumbnails' );
		// add support for post formats
		add_theme_support( 'post-formats', array( 'video' ) );

		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		// Add custom editor font sizes.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Small', 'riode' ),
					'shortName' => esc_html__( 'S', 'riode' ),
					'size'      => 15,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html__( 'Normal', 'riode' ),
					'shortName' => esc_html__( 'N', 'riode' ),
					'size'      => 18,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Medium', 'riode' ),
					'shortName' => esc_html__( 'M', 'riode' ),
					'size'      => 24,
					'slug'      => 'medium',
				),
				array(
					'name'      => esc_html__( 'Large', 'riode' ),
					'shortName' => esc_html__( 'L', 'riode' ),
					'size'      => 30,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Huge', 'riode' ),
					'shortName' => esc_html__( 'huge', 'riode' ),
					'size'      => 34,
					'slug'      => 'huge',
				),
			)
		);

		// Editor color palette.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Primary', 'riode' ),
					'slug'  => 'primary',
					'color' => riode_get_option( 'primary_color' ),
				),
				array(
					'name'  => esc_html__( 'Secondary', 'riode' ),
					'slug'  => 'secondary',
					'color' => riode_get_option( 'secondary_color' ),
				),
				array(
					'name'  => esc_html__( 'Alert', 'riode' ),
					'slug'  => 'alert',
					'color' => riode_get_option( 'alert_color' ),
				),
				array(
					'name'  => esc_html__( 'Dark', 'riode' ),
					'slug'  => 'dark',
					'color' => '#333',
				),
				array(
					'name'  => esc_html__( 'White', 'riode' ),
					'slug'  => 'white',
					'color' => '#fff',
				),
				array(
					'name'  => esc_html__( 'Default Font Color', 'riode' ),
					'slug'  => 'font',
					'color' => riode_get_option( 'typo_default' )['color'],
				),
				array(
					'name'  => esc_html__( 'Transparent', 'riode' ),
					'slug'  => 'transparent',
					'color' => 'transparent',
				),
			)
		);

		/**
		 * Add support for custom logo.
		 *
		 */
		add_theme_support(
			'custom-logo',
			array(
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

		add_theme_support( 'wc-product-gallery-lightbox' );

		add_editor_style();

		// add image sizes
		add_image_size( 'riode-product-thumbnail', 150, 0, true );
		$size = riode_get_option( 'custom_image_size' );

		if ( isset( $size['Width'] ) && $size['Width'] && isset( $size['Height'] ) && $size['Height'] ) {
			add_image_size( 'riode-custom', (int) $size['Width'], (int) $size['Height'], true );
		}
	}
endif;
