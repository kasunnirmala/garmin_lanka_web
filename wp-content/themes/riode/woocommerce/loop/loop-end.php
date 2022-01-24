<?php
/**
 * Product Loop End
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout_type = wc_get_loop_prop( 'layout_type' );

if ( isset( $GLOBALS['riode_current_product_id'] ) ) {

	$sp_insert     = wc_get_loop_prop( 'sp_insert' );
	$banner_insert = wc_get_loop_prop( 'banner_insert' );
	$current_id    = $GLOBALS['riode_current_product_id'];
	$repeater_ids  = wc_get_loop_prop( 'repeater_ids' );

	// Print single product in products
	if ( (int) $sp_insert >= $current_id ) { // at last or after max
		$html = wc_get_loop_prop( 'single_in_products', '' );
		if ( $html ) {
			$wrap_class = 'product-wrap product-single-wrap';
			if ( isset( $repeater_ids[ $current_id + 1 ] ) ) {
				$wrap_class .= ' ' . $repeater_ids[ $current_id + 1 ];
			}
			if ( wc_get_loop_prop( 'sp_show_in_box' ) ) {
				$count = 1;
				$html  = str_replace( 'product-single', 'product-single product-boxed', $html, $count );
			}

			echo '<li class="' . esc_attr( $wrap_class ) . '">' . riode_escaped( $html ) . '</li>';

			wc_set_loop_prop( 'single_in_products', '' );
		}
	}

	// Print banner in products
	if ( (int) $banner_insert >= $current_id ) { // at last or after max
		$html = wc_get_loop_prop( 'product_banner', '' );
		if ( $html ) {
			$wrap_class_temp  = 'product-wrap grid-item-' . ( $current_id + 1 );
			if ( isset( $repeater_ids[ $current_id + 1 ] ) ) {
				$wrap_class_temp .= ' ' . $repeater_ids[ $current_id + 1 ];
			}
			$wrap_attrs       = ' data-grid-idx=' . ( $current_id + 1 ) . '';
			$wrap_class_temp .= ' product-banner-wrap ' . wc_get_loop_prop( 'banner_class', '' );
			wc_set_loop_prop( 'product_banner', '' );
			echo '<li class="' . esc_attr( $wrap_class_temp ) . '"' . esc_attr( $wrap_attrs ) . '>' . riode_escaped( $html ) . '</li>';
		}
	}
}

if ( 'creative' == $layout_type && 'product-category-group' == wc_get_loop_prop( 'widget' ) ) {
	echo '<li class="grid-space"></li>';
}

if ( 'sales' == wc_get_loop_prop( 'show_progress', '' ) ) {
	$max_sales = (int) wc_get_loop_prop( 'products_max_sales' );
	$max_sales = pow( 10, ceil( log( $max_sales, 10 ) ) );
	echo '<li class="products-max-sales d-none" data-value="' . $max_sales . '"></li>';
}

echo '</ul>';

if ( riode_is_shop() && ! wc_get_loop_prop( 'widget' ) ) {
	echo '</div>'; // end of shop-products-wrapper
}


// Load More
$loadmore_type      = wc_get_loop_prop( 'loadmore_type' );
$loadmore_btn_style = wc_get_loop_prop( 'loadmore_btn_style' );

if ( $loadmore_type ) {
	$page        = absint( empty( $_GET['product-page'] ) ? wc_get_loop_prop( 'current_page', 1 ) : $_GET['product-page'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$total_pages = wc_get_loop_prop( 'total_pages' );

	if ( $total_pages > 1 ) {
		if ( 'page' === $loadmore_type ) {
			if ( wc_get_loop_prop( 'widget', false ) ) {
				echo riode_get_pagination_html( $page, $total_pages, 'pagination-load' );
			}
		} else {
			riode_loadmore_html( '', $loadmore_type, wc_get_loop_prop( 'loadmore_label' ), $loadmore_btn_style );
		}
	}
}
