<?php
/**
 * Riode WooCommerce Product Loop Functions
 *
 * Functions used to display product loop.
 */

defined( 'ABSPATH' ) || die;

// Product Loop Media
add_action( 'woocommerce_before_shop_loop_item', 'riode_product_loop_figure_open', 5 );

// Compatiblilty with elementor editor
if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
	add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
}

// Product Loop Media - Anchor Tag
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'riode_product_loop_hover_thumbnail' );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );
add_filter( 'single_product_archive_thumbnail_size', 'riode_single_product_archive_thumbnail_size' );

// Product Loop Media - Labels and Actions
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 20 ); // Label
add_action( 'woocommerce_before_shop_loop_item_title', 'riode_product_loop_vertical_action', 20 ); // Vertical action
add_action( 'woocommerce_before_shop_loop_item_title', 'riode_product_loop_media_action', 20 ); // Media Action
add_action( 'woocommerce_before_shop_loop_item_title', 'riode_product_loop_countdown_action', 20 ); // Countdown Action
add_action( 'woocommerce_before_shop_loop_item_title', 'riode_product_loop_figure_close', 40 );

// Product Loop Details
add_action( 'woocommerce_before_shop_loop_item_title', 'riode_product_loop_details_open', 50 );
add_action( 'riode_shop_loop_item_categories', 'riode_shop_loop_item_categories' );
add_action( 'riode_shop_loop_item_categories', 'riode_product_loop_default_wishlist_action', 15 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
add_action( 'woocommerce_shop_loop_item_title', 'riode_wc_template_loop_product_title' );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15 );
add_action( 'woocommerce_after_shop_loop_item_title', 'riode_product_loop_attributes', 20 );
add_action( 'woocommerce_after_shop_loop_item_title', 'riode_product_loop_description', 25 );
add_action( 'woocommerce_after_shop_loop_item_title', 'riode_product_loop_action', 30 );
add_action( 'woocommerce_after_shop_loop_item_title', 'riode_product_loop_stock_sale_info', 40 );
add_action( 'woocommerce_after_shop_loop_item', 'riode_product_loop_details_close', 15 );
add_filter( 'woocommerce_product_get_rating_html', 'riode_get_rating_html', 10, 3 );

// Product Loop Hide Details (for classic type)
add_action( 'woocommerce_after_shop_loop_item', 'riode_product_loop_hide_details', 20 );
add_action( 'riode_product_loop_hide_details', 'riode_wc_template_loop_rating_hide_details' );
add_action( 'riode_product_loop_hide_details', 'riode_product_loop_action' );

// Remove default AddToCart
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
add_filter( 'woocommerce_product_add_to_cart_text', 'riode_wc_product_add_to_cart_text', 10, 2 );
add_filter( 'woocommerce_loop_add_to_cart_args', 'riode_loop_add_to_cart_args', 99, 2 );

// Change order of del and ins tag
add_filter( 'woocommerce_format_sale_price', 'riode_wc_format_sale_price', 10, 3 );

// Remove default YITH loop positions
if ( defined( 'YITH_WCWL' ) ) {
	add_filter( 'yith_wcwl_loop_positions', 'riode_yith_wcwl_loop_positions' );
	add_filter( 'yith_wcwl_add_to_wishlist_params', 'riode_yith_wcwl_add_btn_product_icon_class' );
}
if ( defined( 'YITH_WOOCOMPARE' ) ) {
	global $yith_woocompare;
	if ( $yith_woocompare->obj instanceof YITH_Woocompare_Frontend ) {
		remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
	}
}

/**
 * Riode Loop Add To Cart Args Function
 *
 * @since 1.4.2
 * @param $args {array} arguments
 * @param $product {object}
 */
if ( ! function_exists( 'riode_loop_add_to_cart_args' ) ) {
	function riode_loop_add_to_cart_args( $args, $product ) {
		$args['attributes']['data-simple-label']   = esc_html__( 'Add to Cart', 'riode' );
		$args['attributes']['data-variable-label'] = esc_html__( 'Select Options', 'riode' );

		return $args;
	}
}


/**
 * Riode Product Loop Media Functions
 */
if ( ! function_exists( 'riode_product_loop_figure_open' ) ) {
	function riode_product_loop_figure_open() {
		echo '<figure class="product-media">';
	}
}

/**
 * riode_product_loop_countdown_action
 *
 * prints countdown box for on-sale product in archive page
 *
 * @since 1.4.0
 */
if ( ! function_exists( 'riode_product_loop_countdown_action' ) ) {
	function riode_product_loop_countdown_action() {
		if ( riode_get_option( 'product_sale_countdown_type' ) ) {
			riode_single_product_sale_countdown();
		}
	}
}

if ( ! function_exists( 'riode_product_loop_figure_close' ) ) {
	function riode_product_loop_figure_close() {
		echo '</figure>';
	}
}

if ( ! function_exists( 'riode_product_loop_hover_thumbnail' ) ) {
	function riode_product_loop_hover_thumbnail() {
		$hover_change = get_post_meta( get_the_ID(), 'riode_image_change_hover', true );
		if ( ! $hover_change ) {
			$hover_change = wc_get_loop_prop( 'hover_change' ) ? 'show' : 'hide';
		}

		if ( 'show' == $hover_change ) {
			$gallery = get_post_meta( get_the_ID(), '_product_image_gallery', true );
			if ( ! empty( $gallery ) ) {
				$gallery          = explode( ',', $gallery );
				$first_image_id   = $gallery[0];
				$attachment_image = wp_get_attachment_image(
					$first_image_id,
					apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' ),
					false
				);
				echo apply_filters( 'riode_product_hover_image_html', $attachment_image );
			}
		}
	}
}

if ( ! function_exists( 'riode_single_product_archive_thumbnail_size' ) ) {
	function riode_single_product_archive_thumbnail_size( $size ) {
		if ( 'creative' == wc_get_loop_prop( 'layout_type' ) && 'large' == wc_get_loop_prop( 'creative_thumb_size' ) ) {
			$size = wc_get_loop_prop( 'large_thumbnail_size', $size );
			if ( 'custom' == $size ) {
				$size = wc_get_loop_prop( 'large_thumbnail_custom_size', 'woocommerce_single' );
			}
		} else {
			$size = wc_get_loop_prop( 'thumbnail_size', $size );
			if ( 'custom' == $size ) {
				$size = wc_get_loop_prop( 'thumbnail_custom_size', 'woocommerce_thumbnail' );
			}
		}
		return $size;
	}
}

if ( ! function_exists( 'riode_product_loop_vertical_action' ) ) {
	function riode_product_loop_vertical_action() {
		// if product type is not default, do not print vertical action buttons.
		if ( wc_get_loop_prop( 'product_type' ) ) {
			if ( 'classic' == wc_get_loop_prop( 'product_type' ) && riode_wc_show_info_for_role( 'compare' ) ) {
				echo '<div class="product-action-vertical">';
				riode_product_compare( ' btn-product-icon' );
				echo '</div>';
			}

			return;
		}

		global $product;

		$html = '';

		if ( '' == wc_get_loop_prop( 'addtocart_pos' ) ) {
			ob_start();

			woocommerce_template_loop_add_to_cart(
				array(
					'class' => implode(
						' ',
						array_filter(
							array(
								'btn-product-icon',
								'product_type_' . $product->get_type(),
								$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
								$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
							)
						)
					),
				)
			);

			$html .= ob_get_clean();
		}

		if ( riode_wc_show_info_for_role( 'wishlist' ) &&
			'' == wc_get_loop_prop( 'wishlist_pos' ) && defined( 'YITH_WCWL' ) ) {
			$html .= do_shortcode( '[yith_wcwl_add_to_wishlist container_classes="btn-product-icon"]' );
		}

		if ( riode_wc_show_info_for_role( 'quickview' ) &&
			'' == wc_get_loop_prop( 'quickview_pos' ) ) {
			$html .= '<button class="btn-product-icon btn-quickview" data-product="' . $product->get_id() . '" title="' . esc_attr__( 'Quick View', 'riode' ) . '">' . esc_html__( 'Quick View', 'riode' ) . '</button>';
		}

		if ( riode_wc_show_info_for_role( 'compare' ) ) {
			ob_start();
			riode_product_compare( ' btn-product-icon' );
			$html .= ob_get_clean();
		}

		if ( $html ) {
			echo '<div class="product-action-vertical">' . riode_escaped( $html ) . '</div>';
		}
	}
}

if ( ! function_exists( 'riode_product_loop_media_action' ) ) {
	function riode_product_loop_media_action() {
		// if product type is not default, do not print action buttons in figure tag.
		if ( wc_get_loop_prop( 'product_type' ) ) {
			return;
		}

		global $product;

		if ( 'bottom' == wc_get_loop_prop( 'addtocart_pos' ) ) {
			echo '<div class="product-action">';
			woocommerce_template_loop_add_to_cart(
				array(
					'class' => implode(
						' ',
						array_filter(
							array(
								'btn-product',
								'product_type_' . $product->get_type(),
								$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
								$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
							)
						)
					),
				)
			);
			echo '</div>';
		} elseif ( 'bottom' == wc_get_loop_prop( 'quickview_pos' ) ) {
			if ( riode_wc_show_info_for_role( 'quickview' ) ) {
				echo '<div class="product-action"><button class="btn-product btn-quickview" data-product="' . $product->get_id() . '" title="' . esc_attr__( 'Quick View', 'riode' ) . '">' . esc_html__( 'Quick View', 'riode' ) . '</button></div>';
			}
		}
	}
}

/**
 * Riode Product Loop Details Functions
 */
if ( ! function_exists( 'riode_product_loop_details_open' ) ) {
	function riode_product_loop_details_open() {
		echo '<div class="product-details">';
	}
}

if ( ! function_exists( 'riode_product_loop_details_close' ) ) {
	function riode_product_loop_details_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'riode_wc_template_loop_product_title' ) ) {
	function riode_wc_template_loop_product_title() {
		echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title', 'product-title' ) ) . '">';
		echo '<a href="' . esc_url( get_the_permalink() ) . '">' . riode_strip_script_tags( get_the_title() ) . '</a>';
		echo '</h3>';
	}
}

if ( ! function_exists( 'riode_shop_loop_item_categories' ) ) {
	function riode_shop_loop_item_categories() {
		if ( riode_wc_show_info_for_role( 'category' ) ) {
			global $product;
			echo '<div class="product-cat">' . wc_get_product_category_list( $product->get_id(), ', ', '' ) . '</div>';
		}
	}
}

if ( ! function_exists( 'riode_product_loop_attributes' ) ) {
	function riode_product_loop_attributes() {
		if ( riode_wc_show_info_for_role( 'attribute' ) ) {
			global $product;

			if ( 'variable' != $product->get_type() || ! $product->is_purchasable() ) {
				return;
			}

			$variations_json = wp_json_encode( $product->get_available_variations() );
			$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
			echo '<div class="product-variation-wrapper" data-product_variations="' . esc_attr( $variations_attr ) . '">';

			$attributes = $product->get_variation_attributes();

			foreach ( $attributes as $name => $options ) {
				$type = apply_filters( 'riode_wc_attribute_display_type', 'select', $product->get_id(), $name );
				riode_wc_product_listed_attributes_html( $name, $options, $product, $type, true );
			}

			echo '</div>';
		}
	}
}

if ( ! function_exists( 'riode_product_loop_description' ) ) {
	function riode_product_loop_description() {
		$show_info = wc_get_loop_prop( 'show_info', false );
		if ( 'list' === wc_get_loop_prop( 'product_type' ) && ( ! is_array( $show_info ) || in_array( 'short_desc', $show_info ) ) ) {
			global $product;
			echo '<div class="short-desc">' . riode_trim_description( $product->get_short_description(), 30, 'words', 'product-short-desc' ) . '</div>';
		}
	}
}

if ( ! function_exists( 'riode_product_loop_default_wishlist_action' ) ) {
	function riode_product_loop_default_wishlist_action() {
		if ( '' === wc_get_loop_prop( 'product_type' ) ) {
			if ( defined( 'YITH_WCWL' ) &&
				'bottom' === wc_get_loop_prop( 'wishlist_pos' ) &&
				riode_wc_show_info_for_role( 'wishlist' ) ) {

				echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
			}
		}
	}
}

if ( ! function_exists( 'riode_product_loop_action' ) ) {
	function riode_product_loop_action( $details = '' ) {
		global $product;

		$product_type = wc_get_loop_prop( 'product_type' );

		if ( 'classic' == $product_type || 'list' == $product_type ) {

			if ( 'hide-details' !== $details && 'popup' === wc_get_loop_prop( 'classic_hover' ) && 'list' != $product_type ) {
				return;
			}

			$content_align = wc_get_loop_prop( 'content_align' );

			if ( defined( 'YITH_WCWL' ) && riode_wc_show_info_for_role( 'wishlist' ) ) {
				$wishlist = do_shortcode( '[yith_wcwl_add_to_wishlist container_classes="btn-product-icon"]' );
			} else {
				$wishlist = '';
			}

			if ( riode_wc_show_info_for_role( 'quickview' ) ) {
				$quickview = '<button class="btn-product-icon btn-quickview" data-product="' . $product->get_id() . '">' . esc_html__( 'Quick View', 'riode' ) . '</button>';
			} else {
				$quickview = '';
			}

			if ( riode_wc_show_info_for_role( 'compare' ) ) {
				ob_start();
				riode_product_compare( ' btn-product-icon' );
				$compare = ob_get_clean();
			} else {
				$compare = '';
			}

			echo '<div class="product-action">';

			if ( 'center' === $content_align || ( ( ! is_rtl() && 'right' === $content_align ) || ( is_rtl() && 'left' === $content_align ) ) ) {
				echo riode_escaped( $wishlist );
			}
			if ( ( ! is_rtl() && 'right' === $content_align ) || ( is_rtl() && 'left' === $content_align ) ) {
				echo riode_escaped( $quickview );
			}

			if ( is_rtl() && 'list' == $product_type ) {
				echo riode_escaped( $compare );
			}

			woocommerce_template_loop_add_to_cart(
				array(
					'class' => implode(
						' ',
						array_filter(
							array(
								'btn-product',
								'product_type_' . $product->get_type(),
								$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
								$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
							)
						)
					),
				)
			);

			if ( ( ! is_rtl() && 'left' === $content_align ) || ( is_rtl() && 'right' === $content_align ) ) {
				echo riode_escaped( $wishlist );
			}
			if ( ( ! is_rtl() && 'right' !== $content_align ) || ( is_rtl() && 'left' !== $content_align ) ) {
				echo riode_escaped( $quickview );
			}

			if ( ! is_rtl() && 'list' == $product_type ) {
				echo riode_escaped( $compare );
			}

			echo '</div>';

		} elseif ( 'widget' == $product_type ) {

			woocommerce_template_loop_add_to_cart(
				array(
					'class' => implode(
						' ',
						array_filter(
							array(
								'btn-product',
								'product_type_' . $product->get_type(),
								$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
								$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
							)
						)
					),
				)
			);
		} elseif ( '' == $product_type ) {
			if ( 'detail_bottom' == wc_get_loop_prop( 'addtocart_pos' ) ) {
				echo '<div class="product-action">';
				woocommerce_template_loop_add_to_cart(
					array(
						'class' => implode(
							' ',
							array_filter(
								array(
									'btn-product',
									'product_type_' . $product->get_type(),
									$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
									$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
								)
							)
						),
					)
				);
				echo '</div>';
			} elseif ( 'with_qty' == wc_get_loop_prop( 'addtocart_pos' ) ) {
				echo '<div class="product-action">';

				if ( $product->is_purchasable() && $product->is_in_stock() && ( 'simple' == $product->get_type() || riode_wc_show_info_for_role( 'attribute' ) ) ) {
					woocommerce_quantity_input(
						array(
							'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
							'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
							'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( sanitize_text_field( wp_unslash( $_POST['quantity'] ) ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
						)
					);
				}

				woocommerce_template_loop_add_to_cart(
					array(
						'class' => implode(
							' ',
							array_filter(
								array(
									'btn-product',
									'product_type_' . $product->get_type(),
									$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
									$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
								)
							)
						),
					)
				);
				echo '</div>';
			}
		}
	}
}

if ( ! function_exists( 'riode_product_loop_stock_sale_info' ) ) {
	/**
	 * Riode Product Loop Stock Sale Info
	 *
	 * @since 1.0.0
	 * @version 1.4.3 Fixed a issue in out of stock product case.
	 *
	 * @author @ndy
	 */
	function riode_product_loop_stock_sale_info() {
		global $product;

		$show_progress = wc_get_loop_prop( 'show_progress', '' );
		$count_text    = wc_get_loop_prop( 'count_text', '' );
		$stock_status  = $product->get_stock_status();

		if ( 'outofstock' === $stock_status || ! $show_progress && ! $count_text ) {
			return;
		}

		$sales            = $product->get_total_sales();
		$stock            = $product->get_stock_quantity();
		$low_stock        = $product->get_low_stock_amount();

		if ( null == $stock ) {
			$stock = 999999;
		}

		if ( 'sales' == $show_progress ) {
			echo '<div class="count-progress sales-progress">';
			echo '<div class="count-now" data-sales="' . $sales . '" style="width: 0%;"></div>';
			echo '</div>';
			wc_set_loop_prop( 'products_max_sales', max( (int)wc_get_loop_prop( 'products_max_sales', 0 ), $sales ) );
		} elseif ( 'stock' == $show_progress ) {
			if ( ! $low_stock ) {
				$low_stock = (int) wc_get_loop_prop( 'low_stock_cnt' );
			}

			if ( ! $low_stock ) {
				$low_stock = 20;
			}

			$amount_cls = '';
			if ( $stock >= $low_stock * 3 ) {
				$amount_cls = 'progress-many';
			}
			if ( $stock < $low_stock ) {
				$amount_cls = 'progress-few';
			}

			echo '<div class="count-progress stock-progress">';
			echo '<div style="width: calc( 100% * ' . ( $stock / $low_stock / 4 ) . ' );" class="count-now ' . $amount_cls . '"></div>';
			echo '</div>';
		}

		if ( $count_text ) {
			if ( 999999 == $stock ) {
				$stock = 'Ꝏ';
			}
			?>
			<div class="count-text">
				<?php
				echo riode_strip_script_tags(
					apply_filters(
						'riode_product_loop_quantity_text',
						$stock ? sprintf( $count_text, $sales, $stock ) : '',
						$product,
						$sales,
						$stock
					)
				);
				?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'riode_get_rating_html' ) ) {
	function riode_get_rating_html( $html, $rating, $count ) {
		if ( 0 == $rating ) {
			/* translators: %s: rating */
			$label = sprintf( esc_html__( 'Rated %s out of 5', 'riode' ), $rating );
			$html  = '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $rating, $count ) . '</div>';
		}
		return $html;
	}
}

if ( ! function_exists( 'riode_get_rating_link_html' ) ) {
	function riode_get_rating_link_html( $product ) {
		return '<a href="' . esc_url( get_the_permalink( $product->get_id() ) ) . '#reviews" class="woocommerce-review-link scroll-to" rel="nofollow">(' . $product->get_review_count() . ' ' . esc_html__( 'reviews', 'riode' ) . ')</a>';
	}
}

/**
 * Riode Product Loop Hide Details (for classic type) Functions
 */
if ( ! function_exists( 'riode_product_loop_hide_details' ) ) {
	function riode_product_loop_hide_details() {
		if ( 'popup' === wc_get_loop_prop( 'classic_hover' ) && 'list' != wc_get_loop_prop( 'product_type' ) ) {
			echo '<div class="product-hide-details">';
			do_action( 'riode_product_loop_hide_details', 'hide-details' );
			echo '</div>';
		}
	}
}
if ( ! function_exists( 'riode_wc_template_loop_rating_hide_details' ) ) {
	function riode_wc_template_loop_rating_hide_details() {
		wc_get_template(
			'loop/rating.php',
			array(
				'is_hide_details' => true,
			)
		);
	}
}

/**
 * change 'add to cart' to 'Add to Cart'
 */
if ( ! function_exists( 'riode_wc_product_add_to_cart_text' ) ) {
	function riode_wc_product_add_to_cart_text( $text, $self ) {
		$text = $self->is_purchasable() && $self->is_in_stock() ? ( $self->is_type( 'simple' ) ? esc_html__( 'Add to Cart', 'riode' ) : esc_html__( 'Select Options', 'riode' ) ) : esc_html__( 'Read more', 'woocommerce' );
		return $text;
	}
}

/**
 * Change order of del and ins tag.
 */
if ( ! function_exists( 'riode_wc_format_sale_price' ) ) {
	function riode_wc_format_sale_price( $price, $regular_price, $sale_price ) {
		return '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
	}
}

/**
 * Remove default YITH loop positions
 */
if ( ! function_exists( 'riode_yith_wcwl_loop_positions' ) ) {
	function riode_yith_wcwl_loop_positions( $positions ) {
		$positions['before_image']['hook']     = '';
		$positions['before_image']['priority'] = 10;
		return $positions;
	}
}

if ( ! function_exists( 'riode_yith_wcwl_add_btn_product_icon_class' ) ) {
	function riode_yith_wcwl_add_btn_product_icon_class( $args ) {
		if ( isset( $args['container_classes'] ) ) {
			$args['container_classes'] .= ' btn-product-icon';
		} else {
			$args['container_classes'] = ' btn-product-icon';
		}

		return $args;
	}
}

/**
 * Riode product compare function
 */
if ( ! function_exists( 'riode_product_compare' ) ) {
	function riode_product_compare( $extra_class = '' ) {
		if ( ! riode_get_option( 'product_compare' ) && ! class_exists( 'YITH_Woocompare' ) ) {
			return;
		}

		global $product;

		$css_class  = 'compare' . $extra_class;
		$product_id = $product->get_id();
		$url_args   = array( 'id' => $product_id );
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			$url_args['lang'] = ICL_LANGUAGE_CODE;
		}

		$the_list = array();
		if ( class_exists( 'Riode_Product_Compare' ) && isset( $_COOKIE[ Riode_Product_Compare::get_instance()->_compare_cookie_name() ] ) ) {
			$the_list = json_decode( wp_unslash( $_COOKIE[ Riode_Product_Compare::get_instance()->_compare_cookie_name() ] ), true );
		}

		if ( in_array( $product_id, $the_list ) ) {
			$css_class  .= ' remove_from_compare';
			$button_text = esc_html__( 'Remove', 'riode' );
		} else {
			$button_text = esc_html__( 'Compare', 'riode' );
		}

		$url = esc_url_raw( add_query_arg( $url_args, site_url() ) );
		printf( '<a href="%s" class="%s" title="%s" data-product_id="%d">%s</a>', esc_url( $url ), esc_attr( $css_class ), esc_html( $button_text ), $product_id, $button_text );
	}
}

/**
 * Product Attributes (in archive loop and single)
 * shows attrbitue select/swatches in archive loop and single
 *
 * @since 1.0
 * @since 1.4.0 ajax add to cart in archive page
 */
if ( ! function_exists( 'riode_wc_product_listed_attributes_html' ) ) {
	function riode_wc_product_listed_attributes_html( $name, $options, $product, $type, $archive = false ) {
		$custom = false;
		if ( 'pa_' != substr( $name, 0, 3 ) ) {
			$custom = true;
		}

		ob_start();
		do_action( 'riode_wc_print_listed_type_attributes', $name, $options, $product, $type, $custom );
		$html = ob_get_clean();

		$select_html = '';
		if ( ! $archive || ! $html ) {
			ob_start();
			wc_dropdown_variation_attribute_options(
				array(
					'options'   => $options,
					'attribute' => $name,
					'product'   => $product,
					'type'      => $type,
				)
			);
			$select_html = ob_get_clean();

			if ( ! $archive && ! $html ) {
				echo riode_escaped( $select_html );
				return;
			}
		}

		if ( $archive ) {
			echo '<div class="product-variations ' . ( 'select' == $type ? 'dropdown' : 'list' ) . '-type ' . esc_attr( $custom ? 'pa_custom_' . $name : $name ) . '" data-attr="' . esc_attr( $custom ? 'pa_custom_' . $name : $name ) . '">' . $html . $select_html . '</div>';
		} else {
			echo '<div class="product-variations ' . ( 'select' == $type ? 'dropdown' : 'list' ) . '-type ' . esc_attr( $custom ? 'pa_custom_' . $name : $name ) . '" data-attr="' . esc_attr( $custom ? 'pa_custom_' . $name : $name ) . '">' . $html . '</div>' . $select_html;
		}
	}
}