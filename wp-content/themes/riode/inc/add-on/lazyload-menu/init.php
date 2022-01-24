<?php
/**
 * Lazyload Menu
 *
 * @since 1.0
 * @since 1.4.0 init.php file has been created
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( riode_get_option( 'lazyload_menu' ) ) {
	require_once RIODE_ADDON . '/lazyload-menu/lazyload.php';
}
