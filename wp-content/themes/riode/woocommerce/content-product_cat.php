<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout_type        = wc_get_loop_prop( 'layout_type' );
$category_type      = wc_get_loop_prop( 'category_type' );
$default_width_auto = wc_get_loop_prop( 'default_width_auto' );
$hover_effect       = wc_get_loop_prop( 'hover_effect' );
$overlay            = wc_get_loop_prop( 'overlay' );
$content_align      = wc_get_loop_prop( 'content_align' );
$content_origin     = wc_get_loop_prop( 'content_origin' );
$show_icon          = wc_get_loop_prop( 'show_icon' );
$category_class     = array();

$category_wrapper_class = '';
if ( 'creative' == $layout_type ) {
	$mode = wc_get_loop_prop( 'creative_mode' );

	$category_wrapper_class .= 'grid-item';

	if ( class_exists( 'RIODE_CORE' ) ) {
		$idx       = wc_get_loop_prop( 'creative_idx' );
		$grid_item = riode_creative_layout( $mode )[ $idx ];

		foreach ( $grid_item as $key => $value ) {
			$category_wrapper_class .= ' ' . $key . '-' . $value;
		}

		wc_set_loop_prop( 'creative_idx', $idx + 1 );
	}
}


if ( ( 'group' == $category_type || 'group-2' == $category_type ) && 'yes' == $show_icon || 'icon' == $category_type ) {
	wc_set_loop_prop( 'show_icon', true );
}

if ( 'creative' == $layout_type ) {
	echo '<li class="' . esc_attr( $category_wrapper_class ) . '">';
} else {
	echo '<li class="category-wrap">';
}


$category_class[] = 'category-' . $category->slug;

if ( 'badge' === $category_type ) {
	$category_class[] = 'cat-type-badge cat-type-absolute';

} elseif ( 'banner' === $category_type ) {

		$category_class[] = 'cat-type-banner cat-type-absolute';

} elseif ( 'simple' === $category_type ) {

	$category_class[] = 'cat-type-simple';

} elseif ( 'label' === $category_type ) {

	$category_class[] = 'cat-type-block';

} elseif ( 'icon' === $category_type ) {

	$category_class[] = 'cat-type-icon';

} elseif ( 'classic' === $category_type ) {

	$category_class[] = 'cat-type-classic cat-type-absolute';

} elseif ( 'ellipse' === $category_type ) {

	$category_class[] = 'cat-type-ellipse';

} elseif ( 'ellipse-2' === $category_type ) {

	$category_class[] = 'cat-type-ellipse2  cat-type-absolute';

} elseif ( 'group' === $category_type ) {

	$category_class[] = 'cat-type-group';

} elseif ( 'group-2' === $category_type ) {

	$category_class[] = 'cat-type-group-2';

} elseif ( 'center' === $category_type ) {

	$category_class[] = 'cat-type-overlay cat-type-absolute';

} elseif ( 'icon-overlay' === $category_type ) {

	$category_class[] = 'cat-type-icon-overlay cat-type-absolute';

} else {

	$category_class[] = 'cat-type-default cat-type-absolute';

	if ( $default_width_auto ) {
		$category_class[] = 'default-content-auto';
	}
}

// Content Align
if ( $content_align ) {
	$category_class[] = $content_align;
}

// Overlay
$overlay = wc_get_loop_prop( 'overlay' );

if ( $overlay ) {
	$category_class[] = riode_get_overlay_class( $overlay );
}

do_action( 'riode_product_loop_before_cat' );
?>

<div <?php wc_product_cat_class( $category_class, $category ); ?>>
	<?php
	/**
	 * woocommerce_before_subcategory hook.
	 *
	 * @removed woocommerce_template_loop_category_link_open - 10
	 */
	do_action( 'woocommerce_before_subcategory', $category );

	/**
	 * woocommerce_before_subcategory_title hook.
	 *
	 * @removed woocommerce_subcategory_thumbnail - 10
	 *
	 * @hooked riode_before_subcategory_thumbnail - 5
	 * @hooked riode_wc_subcategory_thumbnail - 10
	 * @hooked riode_after_subcategory_thumbnail - 15
	 */
	do_action( 'woocommerce_before_subcategory_title', $category );

	/**
	 * woocommerce_shop_loop_subcategory_title hook.
	 *
	 * @removed woocommerce_template_loop_category_title - 10
	 *
	 * @hooked riode_wc_template_loop_category_title - 10
	 */

	do_action( 'woocommerce_shop_loop_subcategory_title', $category );

	/**
	 * woocommerce_after_subcategory_title hook.
	 *
	 * @hooked riode_wc_after_subcategory_title - 10
	 */
	do_action( 'woocommerce_after_subcategory_title', $category );

	/**
	 * woocommerce_after_subcategory hook.
	 *
	 * @removed woocommerce_template_loop_category_link_close - 10
	 * @hooked riode_wc_template_loop_category_link_close - 10
	 */
	do_action( 'woocommerce_after_subcategory', $category );
	?>
</div>

<?php
do_action( 'riode_product_loop_after_cat' );

echo '</li>';
