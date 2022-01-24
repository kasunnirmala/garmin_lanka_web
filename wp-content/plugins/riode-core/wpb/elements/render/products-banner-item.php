<?php
/**
 * Product + Banner Item Shortcode Render
 *
 * @since 1.1.0
 */

global $riode_products_banner_items;

if ( ! isset( $riode_products_banner_items ) ) {
	$riode_products_banner_items = array();
}

$riode_products_banner_items[] = array(
	'banner_insert' => isset( $atts['item_no'] ) ? $atts['item_no'] : 1,
);

ob_start();
include RIODE_CORE_WPB . '/elements/render/banner.php';
$riode_products_banner_items[ count( $riode_products_banner_items ) - 1 ]['product_banner'] = ob_get_clean();
