<?php
/**
 * Lazyload Images
 *
 * @since 1.0
 * @since 1.4.0 init.php file has been created
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! $is_admin && ! $customize_preview && ! $doing_ajax && riode_get_option( 'lazyload' ) ) {
	require_once RIODE_ADDON . '/lazyload-images/lazyload.php';
}
