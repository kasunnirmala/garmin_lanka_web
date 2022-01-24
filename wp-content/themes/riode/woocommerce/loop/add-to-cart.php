<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! riode_wc_show_info_for_role( 'addtocart' ) ) {
	return;
}

global $product;

// Wishlist Page
if ( isset( $args['page'] ) && 'wishlist' == $args['page'] ) {
	$args['class'] .= ' button';
	if ( riode_wc_show_info_for_role( 'quickview' ) ) {
		echo '<a class="button btn-quickview btn-outline btn-primary" data-product="' . $product->get_id() . '" title="' . esc_attr__( 'Quick View', 'riode' ) . '">' . esc_html__( 'Quick View', 'riode' ) . '</a>';
	}
}

if ( 'variable' == $product->get_type() && false === strpos( $args['class'], 'product_type_variable' ) ) {
	$args['class'] .= ' product_type_variable';
}

if ( doing_action( 'woocommerce_grouped_add_to_cart' ) ) {
	$args['class'] .= ' btn btn-dark btn-sm';
}

echo apply_filters(
	'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf(
		'<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		doing_action( 'woocommerce_grouped_add_to_cart' ) ? esc_html__( 'read more', 'riode' ) : esc_html( $product->add_to_cart_text() )
	),
	$product,
	$args
);
