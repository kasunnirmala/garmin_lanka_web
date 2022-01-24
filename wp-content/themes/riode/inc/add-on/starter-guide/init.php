<?php
/**
 * Starter Guide
 *
 * @since 1.0
 * @since 1.4.0 init.php file has been created
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( $is_admin ) {
	if ( $customize_preview || $elementor_preview || ( $doing_ajax && isset( $_REQUEST['action'] ) ) ) {
		require_once( RIODE_ADDON . '/starter-guide/guide.php' );
	}
}
