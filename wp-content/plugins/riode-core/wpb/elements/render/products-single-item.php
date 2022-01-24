<?php
/**
 * Product + Single Product Item Shortcode Render
 *
 * @since 1.1.0
 */

global $riode_products_single_items;

if ( ! isset( $riode_products_single_items ) ) {
	$riode_products_single_items = array();
}

$atts['editor'] = 'wpb';

$riode_products_single_items[] = array(
	'sp_insert'            => isset( $atts['item_no'] ) ? $atts['item_no'] : 1,
	'single_in_products'   => '',
	'sp_id'                => '',
	'products_single_atts' => $atts,
	'sp_class' => '',
);

if ( isset( $atts['product_ids'] ) ) {
	ob_start();
	include RIODE_CORE_WPB . '/elements/render/singleproducts.php';
	$riode_products_single_items[ count( $riode_products_single_items ) - 1 ]['single_in_products'] = ob_get_clean();
	$riode_products_single_items[ count( $riode_products_single_items ) - 1 ]['sp_id'] = $atts['product_ids'];
}
