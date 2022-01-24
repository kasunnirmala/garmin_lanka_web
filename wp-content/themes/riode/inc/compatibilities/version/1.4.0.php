<?php
/**
 * Compatibility with 1.4.0
 *
 * @since 1.4.0
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

function do_compatibility_1_4_0() {
	global $wpdb;

	// Update attribute types to right swatch types.
	foreach ( wc_get_attribute_taxonomies() as $key => $value ) {
		if ( 'list' == $value->attribute_type ) {
			$terms = get_terms( 'pa_' . $value->attribute_name, array( 'hide_empty' => 0 ) );
			if ( count( $terms ) ) {
				if ( get_term_meta( $terms[0]->term_id, 'attr_label', true ) ) {
					$wpdb->update( 
						"{$wpdb->prefix}woocommerce_attribute_taxonomies",
						array( 'attribute_type' => 'label' ),
						array( 'attribute_id' => $value->attribute_id )
					);
				}
				if ( get_term_meta( $terms[0]->term_id, 'attr_color', true ) ) {
					$wpdb->update( 
						"{$wpdb->prefix}woocommerce_attribute_taxonomies",
						array( 'attribute_type' => 'color' ),
						array( 'attribute_id' => $value->attribute_id )
					);
				}
			}
		}
	}

	$wpdb->delete( 
		"{$wpdb->prefix}options",
		array( 'option_name' => '_transient_wc_attribute_taxonomies' )
	);

	// Update swatch options of variable products.
	$products = get_posts(
		array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'numberposts'         => -1,
			'ignore_sticky_posts' => true,
		)
	);

	if ( ! empty( $products ) ) {
		// find variable product
		foreach ( $products as $product ) {
			$product = wc_get_product( $product );

			if ( 'variable' != $product->get_type() ) {
				continue;
			}

			$swatch_options = get_post_meta( $product->get_id(), 'swatch_options', true );

			if ( $swatch_options ) {
				$swatch_options = json_decode( $swatch_options, true );

				foreach ( $swatch_options as $key => $value ) {
					if ( isset( $value['type'] ) && 'label' == $value['type'] ) {
						unset( $swatch_options[ $key ] );
					} elseif ( isset( $value['type'] ) && 'image' == $value['type'] ) {
						foreach ( $value as $id => $image_id ) {
							if ( 'type' == $id ) {
								continue;
							}

							if ( ! is_array( $image_id ) ) {
								$swatch_options[ $key ][ $id ] = array( 'image' => $image_id );
							}
						}
					}
				}

				if ( empty( $swatch_options ) ) {
					delete_post_meta( $product->get_id(), 'swatch_options' );
				} else {
					update_post_meta( $product->get_id(), 'swatch_options', json_encode( $swatch_options ) );
				}
			}
		}
	}
}

add_action( 'init', 'do_compatibility_1_4_0', 99 );
