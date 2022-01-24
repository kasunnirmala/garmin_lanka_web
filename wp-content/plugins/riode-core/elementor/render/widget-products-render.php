<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Products Widget Render
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Products Selector
			'product_ids'                      => '',
			'categories'                       => '',
			'status'                           => '',
			'count'                            => array( 'size' => 10 ),
			'orderby'                          => '',
			'orderway'                         => 'ASC',
			'order_from'                       => '',
			'order_from_date'                  => '',
			'order_to'                         => '',
			'order_to_date'                    => '',
			'hide_out_date'                    => '',
			'show_progress_global'             => '',
			'show_progress'                    => '',
			'count_text'                       => '',
			'low_stock_cnt'                    => array( 'size' => 10 ),

			// Products Layout
			'col_cnt'                          => array( 'size' => 4 ),
			'col_sp'                           => '',
			'layout_type'                      => 'grid',
			'loadmore_type'                    => '',
			'loadmore_label'                   => '',
			'filter_cat_w'                     => '',
			'filter_cat'                       => '',
			'items_list'                       => '',
			'show_all_filter'                  => '',
			'creative_mode'                    => 1,
			'thumbnail_size'                   => 'woocommerce_thumbnail',
			'thumbnail_custom_dimension'       => '',
			'large_thumbnail_size'             => 'woocommerce_single',
			'large_thumbnail_custom_dimension' => '',
			'row_cnt'                          => 1,

			// Product Type
			'follow_theme_option'              => '',
			'show_labels'                      => array( 'top', 'sale', 'new', 'stock' ),
			'product_type'                     => '',
			'classic_hover'                    => '',
			'show_in_box'                      => '',
			'show_reviews_text'                => '',
			'show_media_shadow'                => '',
			'show_hover_shadow'                => '',
			'show_info'                        => array( 'category', 'label', 'price', 'rating', 'addtocart', 'quickview', 'wishlist' ),
			'hover_change'                     => '',
			'content_align'                    => '',
			'addtocart_pos'                    => '',
			'quickview_pos'                    => '',
			'wishlist_pos'                     => '',
			'page_builder'                     => '',
			'wrapper_id'                       => '',
		),
		$atts
	)
);


// Get Count ////////////////////////////////////////////////////////////////////////////////////
if ( ! is_array( $count ) ) {
	$count = json_decode( $count, true );
}
if ( ! is_array( $col_cnt ) ) {
	$col_cnt = json_decode( $col_cnt, true );
}
if ( ! is_array( $show_labels ) ) {
	$show_labels = explode( ',', $show_labels );
}
if ( ! is_array( $show_info ) ) {
	$show_info = explode( ',', $show_info );
}
if ( ! is_array( $categories ) ) {
	$categories = explode( ',', $categories );
}
$count = (int) $count['size'];

$col_cnt = riode_elementor_grid_col_cnt( $atts );

// Products Args ////////////////////////////////////////////////////////////////////////////////

$props         = array();
$args          = array(
	'columns'  => $col_cnt['lg'],
	'per_page' => $count,
);
$is_filter_cat = false;

// product status
if ( 'featured' === $status ) {
	$args['visibility'] = 'featured';
} elseif ( 'sale' === $status ) {
	$args['on_sale'] = 1;
} elseif ( 'viewed' === $status && ! $product_ids ) {
	$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array(); // @codingStandardsIgnoreLine
	$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

	if ( ! empty( $viewed_products ) ) {
		$product_ids = $viewed_products;
	}
} elseif ( 'pre_order' === $status ) {
	$args['visibility'] = 'pre_order';
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
			$args['ids']     = implode( ',', $product_ids );
			$args['orderby'] = 'post__in';
		}
	} else {
		// custom ordering
		$args['order']   = esc_attr( $orderway );
		$args['orderby'] = esc_attr( $orderby );

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
		$args['category'] = esc_attr( implode( ',', $categories ) );
	}


	// Wrapper classes & attributes ///////////////////////////////////////////////////////////

	$wrapper_class = array();
	$wrapper_attrs = '';

	// if split line is enabled, make gutter size zero
	if ( function_exists( 'riode_get_option' ) && riode_get_option( 'product_split_line' ) ) {
		$atts['col_sp'] = 'no';
	}

	$grid_space_class = riode_elementor_grid_space_class( $atts );
	if ( $grid_space_class ) {
		$wrapper_class[] = $grid_space_class;
	}

	// Slider
	if ( 'slider' === $layout_type ) {
		$wrapper_class[] = riode_get_slider_class( $atts );
		$wrapper_attrs  .= ' data-plugin="owl" data-owl-options=' . esc_attr(
			json_encode(
				riode_get_slider_attrs( $atts, $col_cnt )
			)
		);
		wc_set_loop_prop( 'row_cnt', $row_cnt );
	}

	// Creative Grid Style
	if ( 'creative' == $layout_type ) {
		$wrapper_class[] = 'product-grid row';
		if ( riode_is_preview() && ( isset( $atts['custom_creative'] ) && $atts['custom_creative'] ) ) {
			$wrapper_class[] .= ' editor-mode';
		}
		$props['creative_idx'] = 0;
		if ( ! isset( $atts['creative_cols'] ) && ( ! isset( $atts['custom_creative'] ) || ! $atts['custom_creative'] ) ) {
			$wrapper_class[]        = 'grid-layout-' . $creative_mode;
			$props['creative_mode'] = $creative_mode;
		} else {
			if ( is_array( $items_list ) ) {
				$repeater_ids   = array();
				$large_products = array();
				$product_types  = array();

				foreach ( $items_list as $item ) {
					$repeater_ids[ (int) $item['item_no'] ] = 'elementor-repeater-item-' . $item['_id'];

					if ( $item['item_col_pan'] >= 2 || $item['item_row_pan'] >= 2 ) {
						$large_products[ (int) $item['item_no'] ] = true;
					}

					$product_types[ (int) $item['item_no'] ] = $item;
				}
				wc_set_loop_prop( 'repeater_ids', $repeater_ids );
				wc_set_loop_prop( 'large_products', $large_products );
				wc_set_loop_prop( 'product_types', $product_types );
			}
		}

		$props['large_thumbnail_size'] = $large_thumbnail_size;
		if ( 'custom' == $large_thumbnail_size && $large_thumbnail_custom_dimension ) {
			$props['large_thumbnail_custom_size'] = $large_thumbnail_custom_dimension;
		}
	}

	// Filter by Category ////////////////////////////////////////////////////////////////////////

	if ( $filter_cat_w ) {
		wc_set_loop_prop( 'filter_cat_w', true );

		$is_filter_cat = true;
	}

	if ( 'yes' == $filter_cat ) {
		$term_args = array(
			'taxonomy' => 'product_cat',
		);

		if ( is_array( $categories ) ) {
			if ( 1 < count( $categories ) ) {
				$term_args['include'] = implode( ',', $categories );
				$term_args['orderby'] = 'include';
			} else {
				$term_args['parent'] = count( $categories ) ? $categories[0] : 0;
			}
		}

		$terms = get_terms( $term_args );

		if ( count( $terms ) > 1 ) {
			$slugs         = array();
			$category_html = '';
			$idx           = 0;

			foreach ( $terms as $term_cat ) {
				$id             = $term_cat->term_id;
				$name           = $term_cat->name;
				$slug           = $term_cat->slug;
				$slugs[]        = $slug;
				$category_html .= '<li><a href="' . esc_url( get_term_link( $id, 'product_cat' ) ) . '" class="nav-filter' . ( 0 == $idx && 'yes' != $show_all_filter ? ' active' : '' ) . '" data-cat="' . $id . '">' . esc_html( $name ) . '</a></li>';
				$idx ++;
			}

			if ( $category_html ) {
				$category_html = '<ul class="nav-filters product-filters">' . ( 'yes' == $show_all_filter ? '<li class="nav-filter-clean"><a href="#" class="nav-filter active">' . esc_html__( 'All', 'riode-core' ) . '</a></li>' : '' ) . $category_html . '</ul>';

				echo apply_filters( 'riode_products_filter_cat_html', $category_html );

				wc_set_loop_prop( 'filter_cat', true );
				$is_filter_cat = true;
			}

			if ( 'yes' != $show_all_filter ) {
				$args['category'] = $terms[ array_keys( $terms )[0] ]->term_taxonomy_id;
			}
		}
	}

	// Product Props ///////////////////////////////////////////////////////////////////////////////

	if ( ! $follow_theme_option ) {

		if ( $product_type ) {
			$props['product_type'] = $product_type;
		}
		if ( $show_reviews_text ) {
			$props['show_reviews_text'] = ( 'yes' == $show_reviews_text );
		} else {
			$props['show_reviews_text'] = false;
		}
		if ( $show_in_box ) {
			$props['show_in_box'] = $show_in_box;
		}
		if ( $show_media_shadow ) {
			$props['show_media_shadow'] = $show_media_shadow;
		}
		if ( $show_hover_shadow ) {
			$props['show_hover_shadow'] = $show_hover_shadow;
		}
		if ( is_array( $show_info ) ) {
			$props['show_info'] = $show_info;
		}
		if ( $hover_change ) {
			$props['hover_change'] = $hover_change;
		}
		if ( $content_align ) {
			$props['content_align'] = $content_align;
		}
		if ( $addtocart_pos ) {
			$props['addtocart_pos'] = $addtocart_pos;
		}
		if ( $quickview_pos ) {
			$props['quickview_pos'] = $quickview_pos;
		}
		if ( $wishlist_pos ) {
			$props['wishlist_pos'] = $wishlist_pos;
		}
		if ( $classic_hover ) {
			$props['classic_hover'] = $classic_hover;
		}
	} else {
		$props['follow_theme_option'] = 'yes';
	}

	$props['show_labels'] = $show_labels;

	$props['show_progress_global'] = $show_progress_global ? 'yes' : '';

	if ( $show_progress ) {
		$props['show_progress'] = $show_progress;
	}
	if ( $count_text ) {
		$props['count_text'] = $count_text;
	}
	if ( is_array( $low_stock_cnt ) ) {
		$low_stock_cnt = $low_stock_cnt['size'];
	}
	if ( $low_stock_cnt ) {
		$props['low_stock_cnt'] = $low_stock_cnt;
	}

	// Product Layout Props ////////////////////////////////////////////////////////////////////////

	$props['widget']         = 'product-group';
	$props['layout_type']    = $layout_type;
	$props['col_sp']         = $col_sp;
	$props['thumbnail_size'] = $thumbnail_size;
	if ( 'custom' == $thumbnail_size && $thumbnail_custom_dimension ) {
		$props['thumbnail_custom_size'] = $thumbnail_custom_dimension;
	}
	$props['wrapper_class'] = $wrapper_class;
	wc_set_loop_prop( 'wrapper_attrs', $wrapper_attrs );


	$props['col_cnt'] = $col_cnt;

	// Props for loadmore

	if ( $loadmore_type || $is_filter_cat ) {
		$args['paginate']        = 1;
		$props['loadmore_type']  = $loadmore_type;
		$props['loadmore_label'] = $loadmore_label;

		if ( 'button' == $loadmore_type ) {
			$settings                    = shortcode_atts(
				array(
					'button_type'                => '',
					'button_size'                => '',
					'button_skin'                => 'btn-primary',
					'shadow'                     => '',
					'button_border'              => '',
					'link_hover_type'            => '',
					'link'                       => '',
					'show_icon'                  => '',
					'show_label'                 => 'yes',
					'icon'                       => '',
					'icon_pos'                   => 'after',
					'icon_hover_effect'          => '',
					'icon_hover_effect_infinite' => '',
				),
				$atts
			);
			$props['loadmore_btn_style'] = $settings;
		}

		wc_set_loop_prop( 'loadmore_props', $props );
		wc_set_loop_prop( 'loadmore_args', $args );
	}


	// Do Shortcode /////////////////////////////////////////////////////////////////////////////////

	foreach ( $props as $key => $value ) {
		wc_set_loop_prop( $key, $value );
	}

	$args_str = '';
	foreach ( $args as $key => $value ) {
		$args_str .= ' ' . $key . '=' . json_encode( $value );
	}

	$GLOBALS['riode_current_product_id'] = 0;

	echo do_shortcode( '[products' . $args_str . ']' );

	if ( isset( $GLOBALS['riode_current_product_id'] ) ) {
		unset( $GLOBALS['riode_current_product_id'] );
	}
}
