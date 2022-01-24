<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Single Product Widget Render
 */
$settings = shortcode_atts(
	array(
		// Products Selector
		'product_ids'       => '',
		'categories'        => '',
		'status'            => '',
		'count'             => array( 'size' => 10 ),
		'orderby'           => '',
		'orderway'          => 'ASC',
		'order_from'        => '',
		'order_from_date'   => '',
		'order_to'          => '',
		'order_to_date'     => '',
		'hide_out_date'     => '',

		// Single Product
		'sp_title_tag'      => 'h2',
		'sp_gallery_type'   => '',
		'sp_sales_type'     => '',
		'sp_sales_label'    => esc_html__( 'Flash Deals', 'riode-core' ),
		'sp_show_info'      => '',
		'sp_show_in_box'    => '',
		'sp_vertical'       => '',
		'sp_col_cnt_xl'     => '',
		'sp_col_cnt'        => '',
		'sp_col_cnt_tablet' => '',
		'sp_col_cnt_mobile' => '',
		'sp_col_cnt_min'    => '',
		'sp_col_sp'         => 'md',
		'editor'            => 'elementor',

		// Slider Options
		'show_nav'          => '',
		'show_nav_tablet'   => '',
		'show_nav_mobile'   => '',
		'show_nav_xl'       => '',
		'nav_hide'          => '',
		'nav_type'          => '',
		'nav_pos'           => '',
		'show_dots'         => '',
		'show_dots_tablet'  => '',
		'show_dots_mobile'  => '',
		'show_dots_xl'      => '',
		'dots_type'         => '',
		'dots_pos'          => '',
		'fullheight'        => '',
		'autoplay'          => '',
		'autoplay_timeout'  => '',
		'loop'              => '',
		'pause_onhover'     => '',
		'autoheight'        => '',
		'center_mode'       => '',
		'prevent_drag'      => '',
		'animation_in'      => '',
		'animation_out'     => '',
	),
	$atts
);

extract( $settings ); // @codingStandardsIgnoreLine

include_once RIODE_CORE_PATH . '/elementor/partials/products.php';
wp_enqueue_style( 'riode-theme-single-product' );

if ( 'wpb' == $editor && $sp_show_info ) {
	$atts['sp_show_info'] = explode( ',', $sp_show_info );
}

// Parse product IDs or slugs
if ( ! empty( $product_ids ) && is_string( $product_ids ) ) {

	$product_ids = explode( ',', str_replace( ' ', '', esc_attr( $product_ids ) ) );

	if ( defined( 'RIODE_VERSION' ) ) {
		for ( $i = 0; isset( $product_ids[ $i ] );  ++ $i ) {
			if ( ! is_numeric( $product_ids[ $i ] ) ) {
				$product_ids[ $i ] = riode_get_post_id_by_name( 'product', $product_ids[ $i ] );
			}
		}
	}
}

// Only 1 Single Product ////////////////////////////////////////////////////////////////////////

if ( $product_ids && 1 == count( $product_ids ) ) {
	global $post, $product;
	$original_post    = $post;
	$original_product = $product;
	$post             = get_post( $product_ids[0] );
	$product          = wc_get_product( $post );

	if ( $product ) {
		riode_set_single_product_widget( $atts );
		wc_get_template_part( 'content', 'single-product' );
		riode_unset_single_product_widget( $atts );
	}

	$post    = $original_post;
	$product = $original_product;

} else {
	// Several Single Products ///////////////////////////////////////////////////////////////////

	// Get Count
	if ( ! is_array( $count ) ) {
		$count = json_decode( $count, true );
	}
	$count = (int) $count['size'];


	if ( $categories && ! is_array( $categories ) ) {
		$categories = explode( ',', $categories );
	}

	$query_args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'posts_per_page'      => $count,
		'fields'              => 'ids',
		'orderby'             => wc_clean( wp_unslash( $orderby ) ),
		'meta_query'          => WC()->query->get_meta_query(),
		'tax_query'           => array(),
	);

	// product status
	if ( 'featured' === $status ) {
		$query_args['tax_query'][] = array(
			'taxonomy'         => 'product_visibility',
			'terms'            => 'featured',
			'field'            => 'name',
			'operator'         => 'IN',
			'include_children' => false,
		);
	} elseif ( 'sale' === $status ) {
		$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
	} elseif ( 'pre_order' === $status ) {
		if ( method_exists( $this, 'set_visibility_pre_order_query_args' ) ) {
			$this->set_visibility_pre_order_query_args( $query_args );
		} else {
			$query_args['tax_query'] = array_merge( $query_args['tax_query'], WC()->query->get_tax_query() ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		}
	} elseif ( 'related' === $status || 'upsell' === $status ) {
		global $product;
		if ( ! empty( $product ) ) {
			if ( 'related' == $status ) {
				$product_ids = wc_get_related_products( $product->get_id(), $count, $product->get_upsell_ids() );
			} else {
				$product_ids = $product->get_upsell_ids();
			}
		}
	}

	// If not empty linked products for single product
	if ( ! ( ( 'related' === $status || 'upsell' === $status ) && is_array( $product_ids ) && count( $product_ids ) == 0 ) ) {
		if ( $product_ids ) {
			if ( is_string( $product_ids ) ) {
				// custom IDs
				$product_ids = explode( ',', str_replace( ' ', '', esc_attr( $product_ids ) ) );
				if ( defined( 'RIODE_VERSION' ) ) {
					for ( $i = 0; isset( $product_ids[ $i ] );  ++ $i ) {
						if ( ! is_numeric( $product_ids[ $i ] ) ) {
							$product_ids[ $i ] = riode_get_post_id_by_name( 'product', $product_ids[ $i ] );
						}
					}
				}
			}
			if ( is_array( $product_ids ) ) {
				$query_args['post__in'] = $product_ids;
				$query_args['orderby']  = 'post__in';
			}
		} else {
			// custom ordering
			$query_args['order']   = esc_attr( $orderway );
			$query_args['orderby'] = esc_attr( $orderby );

			if ( $order_from ) {
				if ( 'custom' === $order_from && $order_from_date ) {
					set_query_var( 'order_from', esc_attr( $order_from_date ) );
				} elseif ( 'custom' !== $order_from ) {
					set_query_var( 'order_from', esc_attr( $order_from ) );
				}
			}
			if ( $order_to ) {
				if ( 'custom' === $order_to && $order_to_date ) {
					set_query_var( 'order_to', esc_attr( $order_to_date ) );
				} elseif ( 'custom' !== $order_to ) {
					set_query_var( 'order_to', esc_attr( $order_to ) );
				}
			}
			set_query_var( 'hide_out_date', $hide_out_date );
		}

		if ( is_array( $categories ) && count( $categories ) ) {
			// custom categories
			$query_args['tax_query'] = array_merge(
				WC()->query->get_tax_query(),
				array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => $categories,
					),
				)
			);
		}
	}

	$query = new WP_Query( $query_args );

	if ( $query->have_posts() && defined( 'WC_ABSPATH' ) ) {
		riode_set_single_product_widget( $settings );

		// Loop products
		global $post, $product;
		$original_post    = $post;
		$original_product = $product;
		$product_ids      = $query->posts;
		update_meta_cache( 'post', $product_ids );
		update_object_term_cache( $product_ids, 'product' );

		if ( $query->post_count > 1 ) {
			?>
			<div class="products-flipbook row cols-1 <?php echo riode_get_slider_class( $settings ); ?>"
				data-plugin="owl" data-owl-options="<?php echo esc_attr( json_encode( riode_get_slider_attrs( $settings, array() ) ) ); ?>">
			<?php
		}
		foreach ( $product_ids as $product_id ) {
			$post = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $post );
			wc_get_template_part( 'content', 'single-product' );
		}
		if ( $query->post_count > 1 ) {
			?>
			</div>
			<?php
		}

		riode_unset_single_product_widget( $settings );
		$post    = $original_post;
		$product = $original_product;
		wp_reset_postdata();
	}
}
