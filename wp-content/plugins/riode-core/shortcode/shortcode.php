<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_shortcode(
	'riode_year',
	function() {
		return date( 'Y' );
	}
);

add_shortcode( 'riode_products', 'riode_shortcode_product' );
function riode_shortcode_product( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-products-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_products_single', 'riode_shortcode_products_single' );
function riode_shortcode_products_single( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-products-single-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_subcategories', 'riode_shortcode_subcategories' );
function riode_shortcode_subcategories( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-subcategories-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_product_category', 'riode_shortcode_product_category' );
function riode_shortcode_product_category( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-categories-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_posts', 'riode_shortcode_posts' );
function riode_shortcode_posts( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-posts-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_block', 'riode_shortcode_block' );
function riode_shortcode_block( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-block-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_single_product', 'riode_shortcode_single_product' );
function riode_shortcode_single_product( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-single-product-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_menu', 'riode_shortcode_menu' );
function riode_shortcode_menu( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-menu-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_linked_products', 'riode_shortcode_linked_product' );
function riode_shortcode_linked_product( $atts, $content = null ) {
	if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
		ob_start();
		include RIODE_CORE_PATH . 'elementor/render/widget-products-render.php';
		do_action( 'riode_single_product_builder_unset_product' );
		return ob_get_clean();
	}
}

add_shortcode( 'riode_breadcrumb', 'riode_shortcode_breadcrumb' );
function riode_shortcode_breadcrumb( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-breadcrumb-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_filter', 'riode_shortcode_filter' );
function riode_shortcode_filter( $settings, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-filter-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_hotspot', 'riode_shortcode_hotspot' );
function riode_shortcode_hotspot( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-hotspot-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_vendors', 'riode_shortcode_vendors' );
function riode_shortcode_vendors( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-vendors-render.php';
	return ob_get_clean();
}

add_shortcode( 'riode_logo', 'riode_shortcode_logo' );
function riode_shortcode_logo( $atts, $content = null ) {
	ob_start();

	$args = array(
		'logo_size' => $atts['logo_size'],
	);

	if ( defined( 'RIODE_VERSION' ) ) {
		riode_get_template_part( RIODE_PART . '/header/elements/element', 'logo', $args );
	}

	return ob_get_clean();
}

add_shortcode( 'riode_gallery', 'riode_shortcode_gallery' );
function riode_shortcode_gallery( $atts, $content = null ) {
	ob_start();
	include RIODE_CORE_PATH . 'elementor/render/widget-imageslider-render.php';
	return ob_get_clean();
}
