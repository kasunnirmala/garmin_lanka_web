<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( 'widget' === wc_get_loop_prop( 'product_type' ) || 'rotate' == riode_get_single_product_layout() ) {
	return;
}

$show_labels = wc_get_loop_prop( 'show_labels', array( 'top', 'stock', 'sale', 'new', 'custom' ) );

if ( ! is_array( $show_labels ) || 0 == count( $show_labels ) ) {
	return;
}

if ( ! riode_wc_show_info_for_role( 'label' ) ) {
	return;
}

global $post, $product;

$html = '';

// Featured Product

if ( $product->is_featured() && in_array( 'top', $show_labels ) ) {
	$top_label = riode_get_option( 'product_top_label' );
	$html     .= '<label class="product-label label-top" title="' . esc_html__( 'Featured Product', 'riode' ) . '">' . $top_label . '</label>';
}

// Sale Product
if ( $product->is_on_sale() && in_array( 'sale', $show_labels ) ) {
	$reg_p = floatval( $product->get_regular_price() );
	if ( $reg_p > 0 ) {
		$percentage = round( ( ( $reg_p - $product->get_sale_price() ) / $reg_p ) * 100 );
	} elseif ( 'variable' == $product->get_type() && $product->get_variation_regular_price() > 0 ) {
		$percentage = round( ( ( $product->get_variation_regular_price() - $product->get_variation_sale_price() ) / $product->get_variation_regular_price() ) * 100 );
	}

	$sale_label = riode_get_option( 'product_sale_label' );

	if ( ! empty( $percentage ) && ! empty( $sale_label ) && false !== strpos( $sale_label, '%percent%' ) ) {
		$percentage .= '%';
		$sale_html   = str_replace( '%percent%', $percentage, $sale_label );
		$html       .= '<label class="product-label label-sale" title="' . esc_html__( 'On-Sale Product', 'riode' ) . '">' . $sale_html . '</label>';
	}
}

// Out of Stock
if ( in_array( 'stock', $show_labels ) && 'outofstock' == $product->get_stock_status() ) {
	$stock_label = riode_get_option( 'product_stock_label' );
	$html       .= '<label class="product-label label-stock" title="' . esc_html__( 'Out-of-Stock Product', 'riode' ) . '">' . $stock_label . '</label>';
}

// New Product
if ( in_array( 'new', $show_labels ) && strtotime( $product->get_date_created() ) > strtotime( apply_filters( 'riode_product_period', '-' . (int) riode_get_option( 'product_period' ) . ' day' ) ) ) {
	$period_label = riode_get_option( 'product_new_label' );
	$html        .= '<label class="product-label label-new" title="' . esc_html__( 'New Product', 'riode' ) . '">' . $period_label . '</label>';
}

// Custom Labels
if ( in_array( 'custom', $show_labels ) && riode_get_option( 'product_custom_label' ) ) {
	$custom_labels = get_post_meta( get_the_ID(), 'riode_custom_labels', true );
	if ( is_array( $custom_labels ) && count( $custom_labels ) ) {
		foreach ( $custom_labels as $custom_label ) {
			$style_escaped = ' style="';
			if ( ! empty( $custom_label['color'] ) ) {
				$style_escaped .= 'color:' . esc_attr( $custom_label['color'] ) . ';';
			} else {
				$style_escaped .= 'color: #fff;';
			}
			if ( ! empty( $custom_label['bgColor'] ) ) {
				$style_escaped .= 'background-color:' . esc_attr( $custom_label['bgColor'] );
			} else {
				$style_escaped .= 'background-color: ' . esc_attr( riode_get_option( 'primary_color' ) );
			}
			$style_escaped .= '"';
			$html          .= '<label class="product-label"' . $style_escaped . '>';
			$html          .= $custom_label['label'];
			$html          .= '</label>';
		}
	}
}

// Video & 360 Thumbnail Label
$label_video = ( riode_get_option( 'product_video_thumbnail' ) && ! riode_is_product() ) && ( ! empty( get_post_meta( $product->get_ID(), 'riode_product_video_thumbnails' ) ) || get_post_meta( $product->get_ID(), 'riode_product_video_thumbnail_shortcode', true ) );
$label_360 = ( riode_get_option( 'product_360_thumbnail' ) && ! riode_is_product() ) && ( ! empty( get_post_meta( $product->get_ID(), 'riode_product_360_gallery' ) ) );

if ( $label_video || $label_360 ) {
	$html .= '<div class="product-thumb-type-labels">';

	if ( $label_video ) {
		$html .= '<label class="product-label label-video" title="' . esc_html__( 'Has Video Thumbnail', 'riode' ) . '"><i class="d-icon-play-solid"></i></label>';
	}
	if ( $label_360 ) {
		$html .= '<label class="product-label label-360" title="' . esc_html__( 'Has 360 Degree Thumbnail', 'riode' ) . '"><i class="fas fa-sync"></i></label>';
	}

	$html .= '</div>';
}

// Finally, print labels

if ( $html ) {
	$html = '<div class="product-label-group' . esc_attr( apply_filters( 'riode_product_label_group_class', '' ) ) . '">' . $html . '</div>';

	echo apply_filters( 'woocommerce_sale_flash', $html, $post, $product );
}

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
