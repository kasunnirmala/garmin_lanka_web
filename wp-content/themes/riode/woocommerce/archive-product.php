<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load only posts.
 */
$only_posts = riode_doing_ajax() && isset( $_GET['only_posts'] );

if ( ! $only_posts ) {
	get_header( 'shop' );
} else {
	riode_print_title_bar();
}

do_action( 'riode_before_content', RIODE_BEFORE_CONTENT );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
?>

<?php
if ( riode_get_option( 'show_cat_description' ) ) :
	?>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h3 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h3>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<?php
endif;

if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @removed woocommerce_result_count - 20
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	$total    = wc_get_loop_prop( 'total', 0 );
	$per_page = wc_get_loop_prop( 'per_page', 0 );
	if ( ! ( 1 === $total || $total <= $per_page || -1 === $per_page || 'page' != apply_filters( 'riode_wc_archive_bottom_loadmore_type', riode_get_option( 'shop_loadmore_type' ) ) ) ) {
		?>

		<div class="toolbox toolbox-pagination">

		<?php
		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @added woocommerce_result_count - 9
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		do_action( 'woocommerce_after_shop_loop' );
		?>

		</div>

		<?php
	}
} else {
	riode_wc_shop_top_sidebar();

	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

do_action( 'riode_after_content', RIODE_AFTER_CONTENT );

if ( ! $only_posts ) {
	get_footer( 'shop' );
}
