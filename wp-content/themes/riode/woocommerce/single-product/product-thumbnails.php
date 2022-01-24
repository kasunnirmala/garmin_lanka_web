<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

$post_attachment_id = $product->get_image_id();
$attachment_ids     = $product->get_gallery_image_ids();

echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', riode_wc_get_gallery_image_html( $post_attachment_id, false, true ), $post_attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

if ( $attachment_ids && $post_attachment_id ) {
	foreach ( $attachment_ids as $attachment_id ) {
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', riode_wc_get_gallery_image_html( $attachment_id ), $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
	}
}
