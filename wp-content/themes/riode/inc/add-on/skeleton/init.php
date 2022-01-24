<?php
/**
 * Skeleton Screen
 *
 * @since 1.0
 * @since 1.4.0 init.php file has been created
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! $doing_ajax && ! $customize_preview && ! $is_preview && riode_get_option( 'skeleton_screen' ) ) {
	require_once RIODE_ADDON . '/skeleton/skeleton.php';
}
