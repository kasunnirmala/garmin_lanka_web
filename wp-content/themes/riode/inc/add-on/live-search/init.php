<?php
/**
 * Live Search
 *
 * @since 1.0
 * @since 1.4.0 init.php file has been created
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ( ! $is_admin || $doing_ajax ) && riode_get_option( 'live_search' ) ) {
	require_once( RIODE_ADDON . '/live-search/live-search.php' );
}
