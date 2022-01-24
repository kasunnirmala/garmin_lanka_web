<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * admin-init.php
 */

define( 'RIODE_CUSTOMIZER_IMG', RIODE_URI . '/inc/admin/customizer/images' );

/**
 * Plugins
	 */
if ( is_customize_preview() || wp_doing_ajax() ) {
	// require_once RIODE_PLUGINS . '/kirki/kirki.php';
}
require_once RIODE_PLUGINS . '/plugins.php'; // issue : when

/**
 * Admin Functions
 */
// Admin - Customizer
if ( is_customize_preview() ) {
	require_once RIODE_ADMIN . '/customizer/customizer.php';
	require_once RIODE_ADMIN . '/customizer/customizer-function.php';
}

// Admin Panel
require_once RIODE_ADMIN . '/panel/panel.php';
require_once RIODE_ADMIN . '/admin.php';
require_once RIODE_ADMIN . '/setup_wizard/setup_wizard.php';
require_once RIODE_ADMIN . '/optimize_wizard/optimize_wizard.php';
require_once RIODE_ADMIN . '/maintenance_tools/maintenance_tools.php';
require_once RIODE_ADMIN . '/version_control/version_control.php';
