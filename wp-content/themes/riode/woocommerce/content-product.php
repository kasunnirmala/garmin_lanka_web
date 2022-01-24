<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$wrap_class      = 'product-wrap'; // classes for product wrap
$wrap_class_temp = '';
$wrap_attrs      = '';

$product_type      = wc_get_loop_prop( 'product_type' );
$classic_hover     = wc_get_loop_prop( 'classic_hover' );
$content_align     = wc_get_loop_prop( 'content_align' );
$show_in_box       = wc_get_loop_prop( 'show_in_box' );
$show_media_shadow = wc_get_loop_prop( 'show_media_shadow' );
$show_hover_shadow = wc_get_loop_prop( 'show_hover_shadow' );
$addtocart_pos     = wc_get_loop_prop( 'addtocart_pos' );
$show_info         = wc_get_loop_prop( 'show_info' );
$show_labels       = wc_get_loop_prop( 'show_labels' );
$quickview_pos     = wc_get_loop_prop( 'quickview_pos' );
$wishlist_pos      = wc_get_loop_prop( 'wishlist_pos' );
$row_cnt           = wc_get_loop_prop( 'row_cnt' );

$skip = false;

if ( riode_is_shop() ) {
	/**
	 * Product Archive
	 */

	if ( in_array( 'cat_filter', riode_get_option( 'shop_top_toolbox_items' ) ) ) {
		$cats = $product->get_category_ids();
		foreach ( $cats as $cat_id ) {
			$cat_slug = get_term( $cat_id )->slug;

			if ( 'uncategorized' == $cat_slug ) {
				continue;
			}

			$wrap_class .= ' ' . $cat_slug;
		}
	}
} elseif ( class_exists( 'WooCommerce' ) && is_product() ) {
	/**
	 * Related Products in Single Product Page
	 */
} else {
	/**
	 * Shortcode Products
	 */
	$layout_type = wc_get_loop_prop( 'layout_type' );

	// Creative Grid Image Size
	if ( 'creative' == wc_get_loop_prop( 'layout_type' ) ) {
		wc_set_loop_prop( 'creative_thumb_size', 'small' );

		$mode = wc_get_loop_prop( 'creative_mode', -1 );

		if ( -1 != $mode ) {
			$idx = (int) wc_get_loop_prop( 'creative_idx' );
			$rdx = 0;

			if ( 1 == $mode && 0 == $idx % 7 ) {
				wc_set_loop_prop( 'creative_thumb_size', 'large' );
				$rdx = ( $idx % 7 ) + 1;
			} elseif ( 2 == $mode && 1 == $idx % 5 ) {
				wc_set_loop_prop( 'creative_thumb_size', 'large' );
				$rdx = ( $idx % 5 ) + 1;
			} elseif ( 3 == $mode && 0 == $idx % 5 ) {
				wc_set_loop_prop( 'creative_thumb_size', 'large' );
				$rdx = ( $idx % 5 ) + 1;
			} elseif ( 4 == $mode && 2 == $idx % 5 ) {
				wc_set_loop_prop( 'creative_thumb_size', 'large' );
				$rdx = ( $idx % 5 ) + 1;
			} elseif ( 5 == $mode && ( 0 == $idx % 4 || 1 == $idx % 4 ) ) {
				$rdx = ( $idx % 4 ) + 1;
				wc_set_loop_prop( 'creative_thumb_size', 'large' );
			} elseif ( 6 == $mode && ( 0 == $idx % 4 || 2 == $idx % 4 ) ) {
				$rdx = ( $idx % 4 ) + 1;
				wc_set_loop_prop( 'creative_thumb_size', 'large' );
			} elseif ( 7 == $mode && ( 0 == $idx % 4 || 1 == $idx % 4 ) ) {
				$rdx = ( $idx % 4 ) + 1;
				wc_set_loop_prop( 'creative_thumb_size', 'large' );
			} elseif ( 8 == $mode && ( 0 == $idx % 4 || 1 == $idx % 4 ) ) {
				$rdx = ( $idx % 4 ) + 1;
				wc_set_loop_prop( 'creative_thumb_size', 'large' );
			} elseif ( 9 == $mode && 0 == $idx % 10 ) {
				$rdx = ( $idx % 10 ) + 1;
				wc_set_loop_prop( 'creative_thumb_size', 'large' );
			}

			if ( 'large' == wc_get_loop_prop( 'creative_thumb_size' ) ) {
				// Print large product
				$wrap_class_temp .= ' large-product-wrap grid-item-' . $rdx;
			}

			wc_set_loop_prop( 'creative_idx', $idx + 1 );
		} else {
			$large_products = wc_get_loop_prop( 'large_products', [] );
			$idx            = wc_get_loop_prop( 'creative_idx' );

			if ( isset( $large_products[ $idx + 1 ] ) && $large_products[ $idx + 1 ] ) {
				wc_set_loop_prop( 'creative_thumb_size', 'large' );
			}
			wc_set_loop_prop( 'creative_idx', $idx + 1 );
			$wrap_class_temp .= ' grid-item-' . ( $idx + 1 );
			$wrap_attrs      .= ' data-grid-idx=' . ( $idx + 1 );
		}
	}

	if ( isset( $GLOBALS['riode_current_product_id'] ) ) {
		$sp_insert     = wc_get_loop_prop( 'sp_insert' );
		$banner_insert = wc_get_loop_prop( 'banner_insert' );
		$banner_class  = wc_get_loop_prop( 'banner_class', '' );
		$sp_class      = wc_get_loop_prop( 'sp_class', '' );
		$current_id    = $GLOBALS['riode_current_product_id'];
		$repeater_ids  = wc_get_loop_prop( 'repeater_ids' );
		$product_types = wc_get_loop_prop( 'product_types' );
		$should_change = false;

		if ( isset( $repeater_ids[ $current_id + 1 ] ) ) {
			$wrap_class_temp .= ' ' . $repeater_ids[ $current_id + 1 ];
			$type_id          = $current_id;

			if ( $current_id + 1 == $banner_insert ) {
				$type_id = $current_id + 1;
			}

			if ( isset( $product_types[ $type_id + 1 ]['item_product_type'] ) ) {
				$global_product_type  = $product_type;
				$product_type         = $product_types[ $type_id + 1 ]['item_product_type'];
				$global_classic_hover = $classic_hover;
				$classic_hover        = $product_types[ $type_id + 1 ]['item_classic_hover'];
				$global_show_info     = $show_info;
				$show_info            = $product_types[ $type_id + 1 ]['item_show_info'];
				$global_show_labels   = $show_labels;
				$show_labels          = $product_types[ $type_id + 1 ]['item_show_labels'];
				$global_addtocart_pos = $addtocart_pos;
				$addtocart_pos        = $product_types[ $type_id + 1 ]['item_addtocart_pos'];
				$global_quickview_pos = $quickview_pos;
				$quickview_pos        = $product_types[ $type_id + 1 ]['item_quickview_pos'];
				$global_wishlist_pos  = $wishlist_pos;
				$wishlist_pos         = $product_types[ $type_id + 1 ]['item_wishlist_pos'];
				wc_set_loop_prop( 'product_type', $product_type );
				wc_set_loop_prop( 'classic_hover', $classic_hover );
				wc_set_loop_prop( 'show_info', $show_info );
				wc_set_loop_prop( 'show_labels', $show_labels );
				wc_set_loop_prop( 'addtocart_pos', $addtocart_pos );
				wc_set_loop_prop( 'quickview_pos', $quickview_pos );
				wc_set_loop_prop( 'wishlist_pos', $wishlist_pos );
			}
		}

		// Print single product in products
		if ( (int) $sp_insert - 1 == $current_id ) {
			$html                 = wc_get_loop_prop( 'single_in_products' );
			$products_single_atts = wc_get_loop_prop( 'products_single_atts' );

			if ( $html ) {
				$wrap_class_temp .= ' product-single-wrap ' . $sp_class;
				if ( wc_get_loop_prop( 'sp_show_in_box' ) ) {
					$count = 1;
					$html  = str_replace( 'product-single', 'product-single product-boxed', $html, $count );
				}

				echo '<li class="' . esc_attr( $wrap_class . $wrap_class_temp ) . '"' . esc_attr( $wrap_attrs ) . '>' . riode_escaped( $html ) . '</li>';

				$wrap_class_temp = '';
				wc_set_loop_prop( 'single_in_products', '' );
				$idx = wc_get_loop_prop( 'creative_idx', 1 );
				wc_set_loop_prop( 'creative_idx', $idx + 1 );
				++ $GLOBALS['riode_current_product_id'];
			} elseif ( ! empty( $products_single_atts ) ) { // if single product id is not given
				ob_start();
				riode_set_single_product_widget( $products_single_atts );
				wc_get_template_part( 'content', 'single-product' );
				riode_unset_single_product_widget( $products_single_atts );
				$html = ob_get_clean();

				$wrap_class_temp .= ' product-single-wrap ' . $sp_class;
				if ( wc_get_loop_prop( 'sp_show_in_box' ) ) {
					$count = 1;
					$html  = str_replace( 'product-single', 'product-single product-boxed', $html, $count );
				}

				echo '<li class="' . esc_attr( $wrap_class . $wrap_class_temp ) . '"' . esc_attr( $wrap_attrs ) . '>' . riode_escaped( $html ) . '</li>';

				$skip            = true;
				$wrap_class_temp = '';
			}

			global $riode_products_single_items;
			if ( isset( $riode_products_single_items ) && count( $riode_products_single_items ) ) {
				wc_set_loop_prop( 'single_in_products', $riode_products_single_items[0]['single_in_products'] );
				wc_set_loop_prop( 'sp_id', $riode_products_single_items[0]['sp_id'] );
				wc_set_loop_prop( 'sp_insert', $riode_products_single_items[0]['sp_insert'] );
				wc_set_loop_prop( 'sp_class', $riode_products_single_items[0]['sp_class'] );
				wc_set_loop_prop( 'products_single_atts', $riode_products_single_items[0]['products_single_atts'] );

				array_shift( $riode_products_single_items );
			}

			$should_change   = true;
			$wrap_class_temp = ' grid-item-' . $GLOBALS['riode_current_product_id'];
			$wrap_attrs      = ' data-grid-idx=' . $GLOBALS['riode_current_product_id'] . '';
		}

		// Print banner in products
		if ( (int) $banner_insert - 1 == $current_id ) {
			$html = wc_get_loop_prop( 'product_banner', '' );
			if ( $html ) {
				$wrap_class_temp .= ' product-banner-wrap ' . $banner_class;
				echo '<li class="' . esc_attr( $wrap_class . $wrap_class_temp ) . '"' . esc_attr( $wrap_attrs ) . '>' . riode_escaped( $html ) . '</li>';

				$wrap_class_temp = '';
				wc_set_loop_prop( 'product_banner', '' );
			}

			global $riode_products_banner_items;
			if ( isset( $riode_products_banner_items ) && count( $riode_products_banner_items ) ) {
				wc_set_loop_prop( 'product_banner', $riode_products_banner_items[0]['product_banner'] );
				wc_set_loop_prop( 'banner_insert', $riode_products_banner_items[0]['banner_insert'] );
				wc_set_loop_prop( 'banner_class', $riode_products_banner_items[0]['banner_class'] );
				array_shift( $riode_products_banner_items );
			}
			$should_change = true;
			$idx           = wc_get_loop_prop( 'creative_idx', 1 );
			wc_set_loop_prop( 'creative_idx', $idx + 1 );
			++ $GLOBALS['riode_current_product_id'];
		}

		if ( $should_change ) {
			$wrap_class_temp = ' grid-item-' . ( $GLOBALS['riode_current_product_id'] + 1 );
			if ( isset( $repeater_ids[ $current_id + 2 ] ) ) {
				$wrap_class_temp .= ' ' . $repeater_ids[ $current_id + 2 ];
			}
			$wrap_attrs = ' data-grid-idx=' . ( $GLOBALS['riode_current_product_id'] + 1 );
		}

		++ $GLOBALS['riode_current_product_id'];

		if ( isset( $repeater_ids[0] ) ) {
			$wrap_class_temp .= ' ' . $repeater_ids[0];
		}

		if ( ! empty( $row_cnt ) && $row_cnt > 1 ) {
			if ( 1 == $GLOBALS['riode_current_product_id'] % $row_cnt ) {
				echo '<li class="product-col"><ul>';
			}
		}
	}

	$wrap_class .= $wrap_class_temp;
}

if ( ! $skip ) :

	// Classes for product
	$product_classes = array( 'product-loop' );

	// - content align
	if ( in_array( $content_align, array( 'left', 'center', 'right' ) ) ) {
		$product_classes[] = 'content-' . $content_align;
	}
	// - show in box
	if ( 'yes' === $show_in_box ) {
		$product_classes[] = 'product-boxed';
	}
	// - show media shadow
	if ( 'yes' == $show_media_shadow ) {
		$product_classes[] = 'shadow-media';
	}
	// - classic
	if ( 'classic' === $product_type ) {
		$product_classes[] = 'product-classic';

		if ( 'popup' === $classic_hover ) {
			$product_classes[] = 'product-popup';
		}

		if ( 'slideup' === $classic_hover ) {
			$product_classes[] = 'product-slideup';
		}
	} elseif ( 'list' === $product_type ) {
		$product_classes[] = 'product-list product-classic';

	} elseif ( 'widget' === $product_type ) {
		$product_classes[] = 'product-list-sm';
	} else {
		$product_classes[] = 'product-default';

		// - show product shadow
		if ( 'yes' == $show_hover_shadow ) {
			$product_classes[] = 'product-shadow';
		}
		// - with QTY
		if ( 'with_qty' == $addtocart_pos ) {
			$product_classes[] = 'product-with-qty';
		}
	}
	?>
<li class="<?php echo esc_attr( apply_filters( 'riode_product_wrap_class', $wrap_class ) ); ?>"<?php echo esc_attr( $wrap_attrs ); ?>>
	<?php do_action( 'riode_product_loop_before_item', $product_type ); ?>
	<div <?php wc_product_class( $product_classes, $product ); ?>>
		<?php
		/**
		 * Hook: woocommerce_before_shop_loop_item.
		 *
		 * @hooked riode_product_loop_figure_open - 5
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item' );

		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 * @hooked riode_product_loop_hover_thumbnail - 10
		 * @hooked woocommerce_template_loop_product_link_close - 15
		 * @hooked woocommerce_show_product_loop_sale_flash - 20
		 * @hooked riode_product_loop_vertical_action - 20
		 * @hooked riode_product_loop_media_action - 20
		 * @hooked riode_product_loop_countdown_action - 30
		 * @hooked riode_product_loop_figure_close - 40
		 * @hooked riode_product_loop_details_open - 50
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_shop_loop_item_title.
		 *
		 * @hooked riode_shop_loop_item_categories - 10
		 * @hooked riode_product_loop_default_wishlist_action - 15
		 */
		do_action( 'riode_shop_loop_item_categories' );

		/**
		 * Hook: woocommerce_shop_loop_item_title.
		 *
		 * @removed woocommerce_template_loop_product_title - 10
		 * @hooked riode_wc_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_price - 10
		 * @hooked woocommerce_template_loop_rating - 15
		 * @hooked riode_product_loop_attributes - 20
		 * @hooked riode_product_loop_description - 25
		 * @hooked riode_product_loop_action - 30
		 * @hooked riode_product_loop_count - 40
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item.
		 *
		 * @removed woocommerce_template_loop_product_link_close - 5
		 * @removed woocommerce_template_loop_add_to_cart - 10
		 * @hooked riode_product_loop_details_close - 15
		 * @hooked riode_product_loop_hide_details - 20
		 */
		do_action( 'woocommerce_after_shop_loop_item' );
		?>
	</div>
	<?php
	if ( isset( $current_id ) && isset( $GLOBALS['riode_current_product_id'] ) && isset( $repeater_ids[ (int) $current_id + 1 ] ) ) {
		if ( isset( $global_product_type ) ) {
			wc_set_loop_prop( 'product_type', $global_product_type );
			wc_set_loop_prop( 'classic_hover', $global_classic_hover );
			wc_set_loop_prop( 'show_info', $global_show_info );
			wc_set_loop_prop( 'show_labels', $global_show_labels );
			wc_set_loop_prop( 'addtocart_pos', $global_addtocart_pos );
			wc_set_loop_prop( 'quickview_pos', $global_quickview_pos );
			wc_set_loop_prop( 'wishlist_pos', $global_wishlist_pos );
		}
	}
	?>
	<?php do_action( 'riode_product_loop_after_item', $product_type ); ?>
</li>
	<?php
	if ( $row_cnt && 1 != $row_cnt ) {
		if ( 0 == $GLOBALS['riode_current_product_id'] % $row_cnt ) {
			echo '</ul></li>';
		}
	}
endif;
