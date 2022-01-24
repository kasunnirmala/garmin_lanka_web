<?php
/**
 * Uni CPO Compatibility
 *
 * @since 1.4.0
 */

remove_filter( 'woocommerce_loop_add_to_cart_link', 'uni_cpo_add_to_cart_button', 10 );
add_filter( 'woocommerce_loop_add_to_cart_link', 'riode_uni_cpo_add_to_cart_button', 10, 3 );

if ( ! function_exists( 'riode_uni_cpo_add_to_cart_button' ) ) {
	function riode_uni_cpo_add_to_cart_button( $link, $product, $args ) {
		$product_id   = intval( $product->get_id() );
		$product_data = Uni_Cpo_Product::get_product_data_by_id( $product_id );

		if ( $product->is_in_stock() ) {
			$button_text = __( 'Select options', 'uni-cpo' );
		} else {
			$button_text = __( 'Out of stock / See details', 'uni-cpo' );
		}

		$class = $args['class'];
		if ( $product->is_type( 'simple' ) ) {
			$class  = str_replace( 'product_type_simple', '', $class );
			$class  = str_replace( 'add_to_cart_button', '', $class );
			$class .= ' product_type_variable product-unicpo';
		}

		if ( 'on' === $product_data['settings_data']['cpo_enable'] ) {
			$link = sprintf(
				'<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s" %s>%s</a>',
				esc_url( get_permalink( $product_id ) ),
				esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $class ) ? $class : 'button' ),
				isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
				esc_html( $button_text )
			);
		}
		return $link;
	}
}
