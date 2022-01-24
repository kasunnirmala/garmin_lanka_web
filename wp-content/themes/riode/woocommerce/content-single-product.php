<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

$classes = array( 'product', 'product-single' );

if ( riode_doing_quickview() ) {
	$view_type = 'quickview';
	$classes[] = 'product-quickview';
	if ( 'offcanvas' == riode_get_option( 'product_quickview_type' ) ) {
		$classes[] = 'scrollable';
	}
} elseif ( apply_filters( 'riode_is_single_product_widget', false ) ) {
	$view_type = 'widget';
	$classes[] = 'product-widget';
} else {
	$view_type = '';
}

if ( ! $view_type ) {
	/**
	 * Hook: woocommerce_before_single_product.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked riode_single_product_inner_breadcrumb - 15
	 */
	do_action( 'woocommerce_before_single_product' );
}

$single_product_template = ! $view_type && defined( 'RIODE_SINGLE_PRODUCT_BUILDER' ) ? Riode_Template_Single_Product_Builder::get_instance()->get_template() : false;
if ( ! is_numeric( $single_product_template ) ) {
	$single_product_template = riode_get_single_product_layout();
}
$classes[] = 'single-product-type-' . $single_product_template;

$classes = apply_filters( 'riode_single_product_classes', $classes );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( $classes, $product ); ?>>

	<?php
	if ( 'riode_template' == get_post_type() && 'product_layout' == get_post_meta( get_the_ID(), 'riode_template_type', true ) ) {
		the_content();
	} elseif ( is_numeric( $single_product_template ) ) {
		do_action( 'riode_before_single_product_template' );

		riode_print_template( $single_product_template );

		do_action( 'riode_after_single_product_template' );
	} else {
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @removed woocommerce_show_product_sale_flash - 10
		 * @removed woocommerce_show_product_images - 20
		 *
		 * @hooked riode_single_product_wrap_general_start - 5
		 * @hooked riode_wc_show_product_images_not_sticky_both - 20
		 * @hooked riode_single_product_wrap_general_end - 30
		 * @hooked riode_single_product_wrap_general_start - 30
		 * @hooked riode_single_product_wrap_sticky_info_start - 40
		 */
		do_action( 'woocommerce_before_single_product_summary' );
		?>

		<div class="<?php echo esc_attr( apply_filters( 'riode_single_product_summary_class', 'summary entry-summary' ) ); ?>">
			<?php
			/**
			 * Hook: riode_before_product_summary
			 *
			 * @hooked riode_wc_show_product_images_sticky_both - 5
			 * @hooked Riode_Skeleton::get_instance()->before_product_summary - 20
			 */
			do_action( 'riode_before_product_summary' );

			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked riode_single_product_wrap_special_start - 2
			 * @hooked riode_single_product_summary_breadcrumb - 3
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_meta - 7
			 * @hooked riode_wc_template_single_price - 9
			 * @hooked riode_single_product_sale_countdown - 9
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked riode_single_product_wrap_special_end - 22
			 * @hooked riode_single_product_wrap_special_start - 22
			 * @hooked riode_wc_template_gallery_single_price - 24
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked riode_single_product_divider - 31
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 * @hooked riode_single_product_wrap_special_end - 70
			 *
			 * @removed woocommerce_template_single_price - 10
			 * @removed woocommerce_template_single_meta - 40
			 */
			do_action( 'woocommerce_single_product_summary' );

			/**
			 * Hook: riode_before_product_summary
			 *
			 * @hooked Riode_Skeleton::get_instance()->after_product_summary - 20
			 */
			do_action( 'riode_after_product_summary' );
			?>
		</div>

		<?php

		/**
		 * Hook: riode_after_product_summary_wrap.
		 *
		 * @hooked riode_wc_output_product_data_tabs_inner - 10
		 * @hooked riode_single_product_wrap_sticky_info_end - 15
		 * @hooked riode_single_product_wrap_general_end - 20
		 */
		do_action( 'riode_after_product_summary_wrap' );

		if ( ! $view_type ) {
			/**
			 * Hook: woocommerce_after_single_product_summary.
			 *
			 * @removed woocommerce_output_product_data_tabs - 10
			 * @hooked riode_wc_output_product_data_tabs_outer - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		}
		?>
	<?php } ?>
</div>

<?php
if ( ! $view_type ) {
	do_action( 'woocommerce_after_single_product' );
}
?>
