<?php
/**
 * Riode Studio - Templates Library
 *
 * @since 1.0.0
 * @since 1.4.0 init.php file has been created
 * @package Riode Addon
 */

defined( 'ABSPATH' ) || die;

if ( defined( 'RIODE_CORE_VERSION' ) && ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) &&
	( $doing_ajax || $is_preview || $template_edit_page ) ) {
	require_once RIODE_ADDON . '/studio/studio.php';
}
