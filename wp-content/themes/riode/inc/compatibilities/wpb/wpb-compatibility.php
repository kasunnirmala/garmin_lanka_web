<?php
/**
 * WPBakery Compatibility
 *
 * @since 1.1.0
 */

// WPBakery Templates
if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
	$dir = RIODE_PATH . '/template_parts/wpb';
	vc_set_shortcodes_templates_dir( $dir );
}

if ( is_admin() ) {
	if ( riode_is_wpb_preview() ) {
		add_action( 'admin_enqueue_scripts', 'riode_enqueue_wpb_editor_assets', 999 );
	}
}

if ( vc_is_inline() ) {
	add_action(
		'wp_enqueue_scripts',
		function() {
			wp_enqueue_style( 'riode-js-composer-editor-preview', RIODE_ASSETS . '/css/admin/wpb-preview.min.css', array(), RIODE_VERSION );
		},
		999
	);
}

function riode_enqueue_wpb_editor_assets() {
	wp_enqueue_style( 'riode-js-composer-editor', RIODE_ASSETS . '/css/admin/wpb-editor.min.css', array(), RIODE_VERSION );
	wp_enqueue_style( 'bootstrap-datepicker', RIODE_ASSETS . '/vendor/bootstrap/bootstrap-datepicker.min.css', array(), RIODE_VERSION );
	// Color Variables
	$custom_css  = 'html {';
	$custom_css .= '--rio-primary-color:' . riode_get_option( 'primary_color' ) . ';';
	$custom_css .= '--rio-secondary-color:' . riode_get_option( 'secondary_color' ) . ';';
	$custom_css .= '--rio-alert-color:' . riode_get_option( 'alert_color' ) . ';';
	$custom_css .= '--rio-success-color:' . riode_get_option( 'success_color' ) . ';';
	$custom_css .= '--rio-dark-color:' . riode_get_option( 'dark_color' ) . ';';
	$custom_css .= '--rio-light-color:' . riode_get_option( 'light_color' ) . ';';
	$custom_css .= '}';

	wp_add_inline_style( 'riode-js-composer-editor', wp_strip_all_tags( wp_specialchars_decode( $custom_css ) ) );
}

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
add_action( 'vc_before_init', 'riode_vc_set_as_theme' );
function riode_vc_set_as_theme() {
	if ( function_exists( 'vc_set_as_theme' ) ) {
		vc_set_as_theme();
	}
}
