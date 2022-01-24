<?php
/**
 * Sales Popup
 *
 * @since 1.0
 * @since 1.4.0 init.php file has been created
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( riode_get_option( 'sales_popup' ) &&
	( ! wp_is_mobile() || riode_get_option( 'sales_popup_mobile' ) ) &&
	! $is_preview ) {
	require_once RIODE_ADDON . '/sales-popup/sales-popup.php';
}
