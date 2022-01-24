<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Products Banner Widget Render
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'banner_insert'        => '',
			'layout_type'          => 'grid',
			'creative_cols'        => '',
			'creative_cols_tablet' => '',
			'creative_cols_mobile' => '',
			'items_list'           => '',
		),
		$atts
	)
);

if ( 'creative' == $layout_type ) {
	$atts['custom_creative'] = true;
}


if ( is_array( $items_list ) ) {
	$repeater_ids = array();
	foreach ( $items_list as $item ) {
		$repeater_ids[ (int) $item['item_no'] ] = 'elementor-repeater-item-' . $item['_id'];
	}
	wc_set_loop_prop( 'repeater_ids', $repeater_ids );
}
$GLOBALS['riode_current_product_id'] = 0;

ob_start();
riode_products_render_banner( $this, $atts );
$banner_html = ob_get_clean();

wc_set_loop_prop( 'product_banner', $banner_html );
wc_set_loop_prop( 'banner_insert', $banner_insert );

riode_products_widget_render( $atts );

if ( isset( $GLOBALS['riode_current_product_id'] ) ) {
	unset( $GLOBALS['riode_current_product_id'] );
}
