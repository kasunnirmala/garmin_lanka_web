<?php
/**
 * Products + Banner Layout Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-products-layout-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php

// for various banner items
global $riode_products_banner_items, $riode_products_single_items;
$riode_products_banner_items = array();
$riode_products_single_items = array();

do_shortcode( $content );

if ( ! empty( $riode_products_banner_items ) ) {
	$idxs = array();
	foreach ( $riode_products_banner_items as $item ) {
		$idxs[] = $item['banner_insert'];
	}

	array_multisort( $idxs, SORT_ASC, $riode_products_banner_items );

	wc_set_loop_prop( 'product_banner', $riode_products_banner_items[0]['product_banner'] );
	wc_set_loop_prop( 'banner_insert', $riode_products_banner_items[0]['banner_insert'] );
	wc_set_loop_prop( 'banner_class', $riode_products_banner_items[0]['banner_class'] );

	array_shift( $riode_products_banner_items );
}
if ( ! empty( $riode_products_single_items ) ) {
	$idxs = array();
	foreach ( $riode_products_single_items as $item ) {
		$idxs[] = $item['sp_insert'];
	}

	array_multisort( $idxs, SORT_ASC, $riode_products_single_items );

	wc_set_loop_prop( 'single_in_products', $riode_products_single_items[0]['single_in_products'] );
	wc_set_loop_prop( 'sp_id', $riode_products_single_items[0]['sp_id'] );
	wc_set_loop_prop( 'sp_insert', $riode_products_single_items[0]['sp_insert'] );
	wc_set_loop_prop( 'sp_class', $riode_products_single_items[0]['sp_class'] );
	wc_set_loop_prop( 'products_single_atts', $riode_products_single_items[0]['products_single_atts'] );

	array_shift( $riode_products_single_items );
}

// Responsive columns
$atts = array_merge( $atts, riode_wpb_convert_responsive_values( 'creative_cols', $atts, 0 ) );
if ( ! $atts['creative_cols'] ) {
	$atts['creative_cols'] = $atts['creative_cols_xl'];
}
include RIODE_CORE_WPB . '/elements/render/products.php';

if ( isset( $GLOBALS['riode_current_product_id'] ) ) {
	unset( $GLOBALS['riode_current_product_id'] );
}
?>
</div>
<?php
