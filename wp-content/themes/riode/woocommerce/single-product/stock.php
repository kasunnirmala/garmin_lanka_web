<?php
/**
 * Single Product stock.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/stock.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * shows hurry up notification bar
 *
 * @since 1.3.0
 */

if ( $product->managing_stock() && $product->get_stock_quantity() < riode_get_option( 'product_hurryup_limit' ) ) {
	echo '<div class="stock hurryup-bar">';
	echo '<p>' . sprintf( esc_html__( 'Hurry Up! Only %1$s left in stock.', 'riode' ), '<b>' . $product->get_stock_quantity() . '</b>' ) . '</p>';
	echo '<span class="bar"><span class="stock-bar" style="width: ' . ( $product->get_stock_quantity() / riode_get_option( 'product_hurryup_limit' ) * 100 ) . '%;"></span></span>';
	echo '</div>';
} else {
	echo '<p class="stock ' . esc_attr( $class ) . '">' . wp_kses_post( $availability ) . '</p>';
}
