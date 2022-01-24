<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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

$col_cnt     = array();
$layout_type = 'grid';
$columns     = 4;

if ( class_exists( 'WooCommerce' ) && ( ! wc_get_loop_prop( 'widget' ) || wc_get_loop_prop( 'follow_theme_option' ) ) ) {
	// Set product type as theme option
	riode_wc_set_loop_prop();
}

if ( class_exists( 'WooCommerce' ) && 'yes' == wc_get_loop_prop( 'show_progress_global', 'yes' ) ) {
	wc_set_loop_prop( 'show_progress', riode_get_option( 'product_show_progress' ) );
	wc_set_loop_prop( 'count_text', riode_get_option( 'product_progress_text' ) );
	wc_set_loop_prop( 'low_stock_cnt', riode_get_option( 'product_low_stock_cnt' ) );
}

$wrapper_class   = wc_get_loop_prop( 'wrapper_class', array() );
$wrapper_attrs   = wc_get_loop_prop( 'wrapper_attrs', '' );
$wrapper_class[] = 'products';

if ( apply_filters( 'riode_is_vendor_store', false ) && ! wc_get_loop_prop( 'widget' ) ) {
	$is_list_type = isset( $_REQUEST['showtype'] ) && 'list' == $_REQUEST['showtype'];

	if ( $is_list_type ) { // if list view mode
		$col_cnt = array(
			'sm'  => 1,
			'min' => 2,
		);
		wc_set_loop_prop( 'product_type', 'list' );
		wc_set_loop_prop( 'content_align', is_rtl() ? 'right' : 'left' );

		if ( ! riode_get_option( 'simple_shop' ) ) {
			$show_info   = wc_get_loop_prop( 'show_info' );
			$show_info[] = 'short_desc';
			wc_set_loop_prop( 'show_info', $show_info );
		}
	} else {
		$columns        = apply_filters( 'riode_vendor_products_count_row', riode_get_option( 'vendor_products_count_row' ) );
		$col_cnt        = riode_get_responsive_cols( array( 'lg' => $columns ) );
		$wrapper_attrs .= ' data-col-grid="' . esc_attr( riode_get_col_class( $col_cnt ) ) . '"';
	}
} elseif ( riode_is_shop() && ! wc_get_loop_prop( 'widget' ) ) {
	/**
	 * Product Archive
	 */
	do_action( 'riode_wc_loop_start_shop' );

	$layout_type = 'grid';

	$col_cnt = array(
		'xl'  => riode_get_option( 'shop_listcount' ) ? riode_get_option( 'shop_listcount' ) : 1,
		'sm'  => 1,
		'min' => 2,
	);

	$wrapper_attrs .= ' data-col-list="' . esc_attr( riode_get_col_class( $col_cnt ) ) . '"';

	$is_list_type = isset( $_REQUEST['showtype'] ) && 'list' == $_REQUEST['showtype'];

	// If default show type is list type.
	if ( true == riode_get_option( 'show_as_list_type' ) && empty( $_REQUEST['showtype'] ) ) {
		$is_list_type = true;
	}

	if ( $is_list_type ) { // if list view mode
		wc_set_loop_prop( 'product_type', 'list' );
		wc_set_loop_prop( 'content_align', is_rtl() ? 'right' : 'left' );

		if ( ! riode_get_option( 'simple_shop' ) ) {
			$show_info   = wc_get_loop_prop( 'show_info' );
			$show_info[] = 'short_desc';
			wc_set_loop_prop( 'show_info', $show_info );
		}
		$wrapper_attrs .= ' data-col-grid="' . esc_attr(
			riode_get_col_class(
				riode_get_responsive_cols(
					array(
						'lg' => riode_get_option( 'product_count_row' ) ? riode_get_option( 'product_count_row' ) : 3,
					)
				)
			)
		) . '"';
	} else {
		$columns        = apply_filters( 'riode_wc_product_count_row', riode_get_option( 'product_count_row' ) );
		$col_cnt        = riode_get_responsive_cols( array( 'lg' => $columns ) );
		$wrapper_attrs .= ' data-col-grid="' . esc_attr( riode_get_col_class( $col_cnt ) ) . '"';
	}

	wc_set_loop_prop( 'loadmore_type', riode_get_option( 'shop_loadmore_type' ) );
	wc_set_loop_prop( 'loadmore_label', riode_get_option( 'shop_loadmore_label' ) );
	wc_set_loop_prop( 'loadmore_args', array( 'shop' => true ) );

	$wrapper_class[] = riode_get_option( 'product_split_line' ) ? 'gutter-no' : riode_get_option( 'product_gap' );

	echo '<div class="product-archive">';
} elseif ( class_exists( 'WooCommerce' ) && riode_is_product() && ! wc_get_loop_prop( 'widget' ) ) {
	/**
	 * Related Products in Single Product Page
	 */

	$layout_type = 'slider';

	$columns = riode_get_option( 'single_product_related_per_row' );
	$col_cnt = riode_get_responsive_cols( array( 'lg' => $columns ) );

	$wrapper_class[] = riode_get_slider_class();
	$wrapper_attrs  .= ' data-plugin="owl" data-owl-options=' . esc_attr(
		json_encode(
			riode_get_slider_attrs(
				array(
					'show_dots'        => false,
					'show_dots_tablet' => false,
					'show_dots_mobile' => false,
					'col_sp'           => riode_get_option( 'product_split_line' ) ? 'no' : substr( riode_get_option( 'product_gap' ), 7, 2 ),
				),
				$col_cnt
			)
		)
	);
} else {
	/**
	 * Shortcode Products
	 */
	$col_cnt = wc_get_loop_prop(
		'col_cnt',
		array(
			'md'  => 3,
			'min' => 2,
		)
	);
}

if ( 'product-category-group' != wc_get_loop_prop( 'widget' ) && wc_get_loop_prop( 'split-line' ) ) {
	$wrapper_class[] = 'split-line';
}

if ( 'classic' == wc_get_loop_prop( 'product_type' ) && 'slideup' == wc_get_loop_prop( 'classic_hover' ) ) {
	$wrapper_class[] = 'slideup';
}

// For Category widget
if ( wc_get_loop_prop( 'run_as_filter' ) ) {
	$wrapper_class[] = 'filter-categories';
}

// If loadmore or ajax category filter, add only pages count.
if ( wc_get_loop_prop( 'riode_ajax_load' ) ) {

	$wrapper_attrs .= ' data-load-max="' . wc_get_loop_prop( 'total_pages' ) . '"';

} else {

	// Load more
	$loadmore_type = apply_filters( 'riode_wc_loadmore_type', wc_get_loop_prop( 'loadmore_type' ) );

	if ( $loadmore_type || wc_get_loop_prop( 'filter_cat' ) || wc_get_loop_prop( 'filter_cat_w' ) ) {
		$wrapper_attrs .= ' ' . riode_loadmore_attributes(
			wc_get_loop_prop( 'loadmore_props' ),   // Props
			wc_get_loop_prop( 'loadmore_args' ),    // Args
			$loadmore_type,                         // Type
			wc_get_loop_prop( 'total_pages' ),      // Total Pages
			wc_get_loop_prop( 'filter_cat' )        // Filter Category
		);

		if ( wc_get_loop_prop( 'filter_cat_w' ) ) {
			$wrapper_class[] = 'filter-products';
		}

		if ( 'scroll' == $loadmore_type ) {
			$wrapper_class[] = 'load-scroll';

			if ( riode_is_shop() ) {
				$wrapper_attrs .= ' data-load-to=".main-content .products"';
			}
		}
	}
}

if ( 'list' == wc_get_loop_prop( 'product_type' ) ) {
	$wrapper_class[] = 'list-type-products';
}

if ( 'creative' != wc_get_loop_prop( 'layout_type' ) ) {
	$wrapper_class[] = riode_get_col_class( $col_cnt );
}

$wrapper_class = apply_filters( 'riode_product_loop_wrapper_classes', $wrapper_class );

echo '<ul class="' . esc_attr( implode( ' ', $wrapper_class ) ) . '"' . riode_escaped( $wrapper_attrs ) . '>';
