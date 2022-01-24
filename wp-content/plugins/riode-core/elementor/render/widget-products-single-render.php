<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}


extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Single Product
			'sp_id'                => '',
			'sp_insert'            => '',
			'sp_show_in_box'       => '',
			'layout_type'          => 'creative',
			'creative_cols'        => '',
			'creative_cols_tablet' => '',
			'creative_cols_mobile' => '',
			'items_list'           => '',
			'page_builder'         => 'elementor',
			'sp_show_info'         => '',
		),
		$atts
	)
);

// Enqueue Theme Single Product CSS
wp_enqueue_style( 'riode-theme-single-product' );

$atts['layout_type']     = 'creative';
$atts['custom_creative'] = true;

if ( is_array( $items_list ) ) {
	$repeater_ids   = array();
	$large_products = array();
	foreach ( $items_list as $item ) {
		$repeater_ids[ (int) $item['item_no'] ] = 'elementor-repeater-item-' . $item['_id'];

		if ( $item['item_col_pan'] >= 2 || $item['item_row_pan'] >= 2 ) {
			$large_products[ (int) $item['item_no'] ] = true;
		}
	}
	wc_set_loop_prop( 'repeater_ids', $repeater_ids );
	wc_set_loop_prop( 'large_products', $large_products );
}

wc_set_loop_prop( 'creative_idx', 0 );

if ( $sp_show_in_box ) {
	wc_set_loop_prop( 'sp_show_in_box', 1 );
}

include_once RIODE_CORE_PATH . '/elementor/partials/products.php';

if ( $sp_id ) {
	$selected_post = false;

	if ( ! is_numeric( $sp_id ) && is_string( $sp_id ) ) {
		$sp_id = riode_get_post_id_by_name( 'product', $sp_id );
	}

	if ( $sp_id ) {
		$selected_post = get_post( $sp_id );
	}

	if ( $selected_post ) {
		riode_set_single_product_widget( $atts );

		global $post, $product;
		$original_post    = $post;
		$original_product = $product;
		$post             = get_post( $selected_post );
		$product          = wc_get_product( $post );
		setup_postdata( $selected_post );

		ob_start();
		wc_get_template_part( 'content', 'single-product' );
		$single_product_html = ob_get_clean();

		riode_unset_single_product_widget( $atts );
		$post    = $original_post;
		$product = $original_product;
		wp_reset_postdata();

		wc_set_loop_prop( 'single_in_products', $single_product_html );
		wc_set_loop_prop( 'sp_id', $sp_id );
		wc_set_loop_prop( 'sp_insert', $sp_insert );
	}
} else {
	wc_set_loop_prop( 'products_single_atts', $atts );
	wc_set_loop_prop( 'sp_insert', $sp_insert );
}

$GLOBALS['riode_current_product_id'] = 0;

riode_products_widget_render( $atts );

if ( isset( $GLOBALS['riode_current_product_id'] ) ) {
	unset( $GLOBALS['riode_current_product_id'] );
}
