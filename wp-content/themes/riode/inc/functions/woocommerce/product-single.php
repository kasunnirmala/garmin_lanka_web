<?php
/**
 * Riode WooCommerce Single Product Functions
 *
 * Functions used to display single product.
 */

defined( 'ABSPATH' ) || die;

// Compatiblilty with elementor editor
if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
	if ( class_exists( 'WC_Template_Loader' ) ) {
		add_filter( 'woocommerce_product_tabs', array( 'WC_Template_Loader', 'unsupported_theme_remove_review_tab' ) );
		add_filter( 'woocommerce_product_tabs', 'woocommerce_default_product_tabs' );
		add_filter( 'woocommerce_product_tabs', 'woocommerce_sort_product_tabs', 99 );
		add_action( 'woocommerce_single_product_summary', 'riode_product_compare', 57 );
	}
}

// Single Product Class
add_filter( 'riode_single_product_classes', 'riode_single_product_extend_class' );

// Single Product - Breadcrumb
add_action( 'riode_before_main_content', 'riode_single_product_top_breadcrumb' );
add_action( 'woocommerce_single_product_summary', 'riode_single_product_summary_breadcrumb', 3 );

// Single Product - Flash Sale
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'riode_before_wc_gallery_figure', 'woocommerce_show_product_sale_flash' );

// Single Product - gallery type and sticky-both type
add_action( 'woocommerce_single_product_summary', 'riode_single_product_wrap_special_start', 2 );
add_action( 'woocommerce_single_product_summary', 'riode_single_product_wrap_special_end', 22 );
add_action( 'woocommerce_single_product_summary', 'riode_single_product_wrap_special_start', 22 );
add_action( 'woocommerce_single_product_summary', 'riode_single_product_wrap_special_end', 70 );

// Single Product - the other types except gallery and sticky-both types
add_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_start', 5 );
add_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_end', 30 );
add_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_start', 30 );
add_action( 'riode_after_product_summary_wrap', 'riode_single_product_wrap_general_end', 20 );

// Single Product - sticky-both type
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_before_single_product_summary', 'riode_wc_show_product_images_not_sticky_both', 20 );
add_action( 'riode_before_product_summary', 'riode_wc_show_product_images_sticky_both', 5 );

// Single Product - sticky-info type
add_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_sticky_info_start', 40 );
add_action( 'riode_after_product_summary_wrap', 'riode_single_product_wrap_sticky_info_end', 15 );


// Single Product Media
add_filter( 'riode_wc_thumbnail_image_size', 'riode_single_product_thumbnail_image_size' );
add_filter( 'riode_product_label_group_class', 'riode_single_product_vertical_label_group_class' );
add_action( 'riode_woocommerce_product_images', 'riode_single_product_images' );
add_filter( 'woocommerce_single_product_image_gallery_classes', 'riode_single_product_wc_gallery_classes' );
add_filter( 'riode_single_product_gallery_main_classes', 'riode_single_product_gallery_classes' );
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
add_action( 'woocommerce_product_thumbnails', 'riode_wc_show_product_thumbnails', 20 );
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'riode_wc_gallery_thumbnail_image_size' );

// Single Product Summary
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
add_action( 'woocommerce_single_product_summary', 'riode_single_product_divider', 31 );
add_filter( 'riode_single_product_summary_class', 'riode_single_product_summary_extend_class' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
add_action( 'woocommerce_single_product_summary', 'riode_wc_template_single_price', 9 );
add_action( 'woocommerce_single_product_summary', 'riode_single_product_sale_countdown', 9 );
add_action( 'woocommerce_single_product_summary', 'riode_wc_template_gallery_single_price', 24 );

// Single Product Form
add_action( 'woocommerce_before_add_to_cart_button', 'riode_single_product_divider' );
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'riode_wc_dropdown_variation_attribute_options_arg' );
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'riode_wc_dropdown_variation_attribute_options_html', 10, 2 );
add_action( 'woocommerce_before_add_to_cart_quantity', 'riode_single_product_sticky_cart_wrap_start' );
add_action( 'woocommerce_after_add_to_cart_button', 'riode_single_product_sticky_cart_wrap_end', 20 );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'riode_wc_product_single_add_to_cart_text', 10, 2 );

// Single Product Data Tab
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
add_action( 'woocommerce_after_single_product_summary', 'riode_wc_output_product_data_tabs_outer' );
add_action( 'riode_after_product_summary_wrap', 'riode_wc_output_product_data_tabs_inner' );
add_filter( 'riode_single_product_data_tab_type', 'riode_single_product_get_data_tab_type' );
add_filter( 'woocommerce_product_tabs', 'riode_wc_product_custom_tabs' );

// Quantity
add_action( 'woocommerce_before_quantity_input_field', 'riode_wc_before_quantity_input_field' );
add_action( 'woocommerce_after_quantity_input_field', 'riode_wc_after_quantity_input_field' );

// Product Listed Attributes
add_action( 'riode_wc_product_listed_attributes', 'riode_wc_product_listed_attributes_html', 10, 4 );

// Change default YITH positions
if ( class_exists( 'YITH_WCWL_Frontend' ) ) {
	add_filter( 'yith_wcwl_positions', 'riode_yith_wcwl_positions' );
}

if ( class_exists( 'YITH_Woocompare' ) ) {
	global $yith_woocompare;
	if ( ! empty( $yith_woocompare->obj ) ) {
		remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
	}
}
if ( riode_get_option( 'product_compare' ) || class_exists( 'YITH_Woocompare' ) ) {
	add_action( 'woocommerce_single_product_summary', 'riode_product_compare', 57 );
}

// Single Product Reviews Tab
add_action( 'woocommerce_review_before', 'riode_wc_review_before_avatar', 5 );
add_action( 'woocommerce_review_before', 'riode_wc_review_after_avatar', 15 );

// Single Product - Related Products
add_action( 'woocommerce_output_related_products_args', 'riode_related_products_args' );

// Woocommerce Comment Form
add_filter( 'woocommerce_product_review_comment_form_args', 'riode_comment_form_args' );

// Single Product - Grouped Product
add_action( 'woocommerce_grouped_product_list_before_label', 'riode_print_grouped_product_thumbnail' );
add_filter( 'woocommerce_grouped_product_columns', 'riode_grouped_product_columns', 10, 2 );
add_filter( 'woocommerce_grouped_product_list_column_quantity', 'riode_print_grouped_product_list_column_quantity', 10, 2 );

// Single Product - Variable Product Sale Countdown
add_action( 'woocommerce_available_variation', 'riode_variation_add_sale_ends', 100, 3 );

// Quickview ajax actions & enqueue scripts for quickview
if ( ! function_exists( 'riode_doing_quickview' ) ) {
	function riode_doing_quickview() {
		return apply_filters( 'riode_doing_quickview', riode_doing_ajax() && isset( $_REQUEST['action'] ) && 'riode_quickview' == $_REQUEST['action'] && isset( $_POST['product_id'] ) );
	}
}

if ( riode_doing_quickview() ) {
	add_action( 'wp_ajax_riode_quickview', 'riode_wc_quickview' );
	add_action( 'wp_ajax_nopriv_riode_quickview', 'riode_wc_quickview' );
} else {
	add_action( 'wp_enqueue_scripts', 'riode_quickview_add_scripts' );
}


/**
 * Riode Single Product Class & Layout
 */
if ( ! function_exists( 'riode_single_product_extend_class' ) ) {
	function riode_single_product_extend_class( $classes ) {
		$single_product_layout = riode_get_single_product_layout();

		if ( 'gallery' != $single_product_layout ) {
			if ( 'sticky-both' == $single_product_layout ) {
				$classes[] = 'sticky-both';
			} else {
				if ( 'sticky-info' == $single_product_layout ) {
					$classes[] = 'sticky-info';
				}
				$classes[] = 'row';
			}
		}
		return $classes;
	}
}

if ( ! function_exists( 'riode_get_single_product_layout' ) ) {
	function riode_get_single_product_layout() {
		if ( riode_doing_ajax() ) {
			$layout = 'horizontal';
		} else {
			$layout = riode_get_option( 'single_product_type' );
		}

		return apply_filters( 'riode_single_product_layout', $layout );
	}
}

/**
 * Riode Single Product - Breadcrumb Functions
 */
if ( ! function_exists( 'riode_single_product_top_breadcrumb' ) ) {
	function riode_single_product_top_breadcrumb() {
		if ( 'product_single_layout' != riode_get_layout_value( 'slug' ) ) {
			return;
		}

		$pos = apply_filters( 'riode_single_product_breadcrumb_pos', riode_get_option( 'single_product_breadcrumb_pos' ) );

		if ( 'top' == $pos ) {
			woocommerce_breadcrumb();
		}
	}
}

if ( ! function_exists( 'riode_single_product_summary_breadcrumb' ) ) {
	function riode_single_product_summary_breadcrumb() {
		if ( ! riode_doing_quickview() ) {
			global $riode_layout;

			$pos = apply_filters( 'riode_single_product_breadcrumb_pos', riode_get_option( 'single_product_breadcrumb_pos' ) );

			if ( '' == $pos ) {
				$single_product_layout = riode_get_single_product_layout();
				if ( 'gallery' != $single_product_layout && 'sticky-both' != $single_product_layout ) {
					woocommerce_breadcrumb();
				}
			}
		}
	}
}

/**
 * Get single product layout
 */

if ( ! function_exists( 'riode_wc_show_product_images_not_sticky_both' ) ) {
	function riode_wc_show_product_images_not_sticky_both() {
		if ( 'sticky-both' != riode_get_single_product_layout() ) {
			woocommerce_show_product_images();
		}
	}
}

if ( ! function_exists( 'riode_wc_show_product_images_sticky_both' ) ) {
	function riode_wc_show_product_images_sticky_both() {
		if ( 'sticky-both' == riode_get_single_product_layout() ) {
			woocommerce_show_product_images();
		}
	}
}


/**
 * Riode Single Product - Gallery Image Functions
 */
if ( ! function_exists( 'riode_wc_get_gallery_image_html' ) ) {
	function riode_wc_get_gallery_image_html( $attachment_id, $main_image = false, $featured_image = false, $only_image = false ) {

		if ( $main_image ) {
			// Get large image

			$image_size    = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
			$full_size     = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
			$thumbnail_src = wp_get_attachment_image_src( $attachment_id, 'woocommerce_single' );
			$full_src      = wp_get_attachment_image_src( $attachment_id, $full_size );
			$alt_text      = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );

			if ( $thumbnail_src && $full_src ) {
				$image = wp_get_attachment_image(
					$attachment_id,
					$image_size,
					false,
					apply_filters(
						'woocommerce_gallery_image_html_attachment_image_params',
						array(
							'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
							'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
							'data-src'                => esc_url( $full_src[0] ),
							'data-large_image'        => esc_url( $full_src[0] ),
							'data-large_image_width'  => $full_src[1],
							'data-large_image_height' => $full_src[2],
							'class'                   => $featured_image ? 'wp-post-image' : '',
						),
						$attachment_id,
						$image_size,
						$main_image
					)
				);
			} else {
				$image = '';
			}

			if ( ! $only_image && is_array( $full_src ) && ( is_array( $thumbnail_src ) ) ) {
				$image = '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . ( $alt_text ? '" data-thumb-alt="' . esc_attr( $alt_text ) : '' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';
			}
		} else {
			// Get small image

			$single_product_layout = riode_get_single_product_layout();
			$thumbnail_size        = apply_filters( 'riode_wc_thumbnail_image_size', 'woocommerce_thumbnail' );

			if ( 'default' == $single_product_layout || 'horizontal' == $single_product_layout ) {
				// If default or horizontal layout, print simple image tag
				$gallery_thumbnail = false;
				if ( 'riode-product-thumbnail' == $thumbnail_size ) {
					$image_sizes = wp_get_additional_image_sizes();
					if ( isset( $image_sizes[ $thumbnail_size ] ) ) {
						$gallery_thumbnail = $image_sizes[ $thumbnail_size ];
					}
				}
				if ( ! $gallery_thumbnail ) {
					$gallery_thumbnail = wc_get_image_size( $thumbnail_size );
				}

				if ( 0 == $gallery_thumbnail['height'] ) {
					$full_image_size = wp_get_attachment_image_src( $attachment_id, 'full' );
					if ( isset( $full_image_size[1] ) && $full_image_size[1] ) {
						$gallery_thumbnail['height'] = intval( $gallery_thumbnail['width'] / absint( $full_image_size[1] ) * absint( $full_image_size[2] ) );
					}
				}
				$thumbnail_size = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
				$image_src      = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
				if ( $image_src ) {
					$image = '<img alt="' . esc_attr( _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ) ) . '" src="' . esc_url( $image_src[0] ) . '" width="' . (int) $thumbnail_size[0] . '" height="' . $thumbnail_size[1] . '">';
				} else {
					$image = sprintf( '<img src="%s" alt="%s" class="wp-post-image">', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
				}
			} else {
				$image = '';
			}

			if ( ! $only_image && $image ) {
				$image = '<div class="product-thumb' . ( $featured_image ? ' active' : '' ) . '">' . $image . '</div>';
			}
		}
		return apply_filters( 'riode_wc_get_gallery_image_html', $image );
	}
}

if ( ! function_exists( 'riode_single_product_thumbnail_image_size' ) ) {
	function riode_single_product_thumbnail_image_size( $image ) {
		if ( riode_is_product() ) {
			return 'riode-product-thumbnail';
		}
	}
}


/**
 * Riode Single Product Navigation
 */
if ( ! function_exists( 'riode_single_product_navigation' ) ) {
	function riode_single_product_navigation() {
		global $post;
		$prev_post = get_previous_post( true, '', 'product_cat' );
		$next_post = get_next_post( true, '', 'product_cat' );
		$html      = '';

		if ( is_a( $prev_post, 'WP_Post' ) || is_a( $next_post, 'WP_Post' ) ) {
			$html .= '<ul class="product-nav">';

			if ( is_a( $prev_post, 'WP_Post' ) ) {
				$html             .= '<li class="product-nav-prev">';
					$html         .= '<a href="' . esc_url( get_the_permalink( $prev_post->ID ) ) . '" rel="prev">';
						$html     .= '<i class="' . esc_attr( apply_filters( 'riode_single_product_nav_prev_icon', 'd-icon-arrow-left' ) ) . '"></i>';
						$html     .= ' ' . esc_html__( 'Prev', 'riode' );
						$html     .= '<span class="product-nav-popup">';
							$html .= riode_strip_script_tags( get_the_post_thumbnail( $prev_post->ID, apply_filters( 'woocommerce_gallery_thumbnail_size', 'woocommerce_gallery_thumbnail' ) ) );
							$html .= '<span>' . esc_attr( get_the_title( $prev_post->ID ) ) . '</span>';
				$html             .= '</span></a></li>';
			} else {
				$html .= '<li class="product-nav-prev disabled">';
				$html .= '<a href="#" rel="prev">';
				$html .= '<i class="' . esc_attr( apply_filters( 'riode_single_product_nav_prev_icon', 'd-icon-arrow-left' ) ) . '"></i>';
				$html .= ' ' . esc_html__( 'Prev', 'riode' );
				$html .= '</a></li>';
			}
			if ( is_a( $next_post, 'WP_Post' ) ) {
				$html             .= '<li class="product-nav-next">';
					$html         .= '<a href="' . esc_url( get_the_permalink( $next_post->ID ) ) . '" rel="next">';
						$html     .= esc_html__( 'Next', 'riode' ) . ' ';
						$html     .= '<i class="' . esc_attr( apply_filters( 'riode_single_product_nav_next_icon', 'd-icon-arrow-right' ) ) . '"></i>';
						$html     .= ' <span class="product-nav-popup">';
							$html .= riode_strip_script_tags( get_the_post_thumbnail( $next_post->ID, apply_filters( 'woocommerce_gallery_thumbnail_size', 'woocommerce_gallery_thumbnail' ) ) );
							$html .= '<span>' . esc_attr( get_the_title( $next_post->ID ) ) . '</span>';
				$html             .= '</span></a></li>';
			} else {
				$html .= '<li class="product-nav-next disabled">';
				$html .= '<a href="#" rel="next">';
				$html .= esc_html__( 'Next', 'riode' ) . ' ';
				$html .= '<i class="' . esc_attr( apply_filters( 'riode_single_product_nav_next_icon', 'd-icon-arrow-right' ) ) . '"></i>';
				$html .= '</a></li>';
			}

			$html .= '</ul>';
		}
		return apply_filters( 'riode_single_product_navigation', $html );
	}
}

if ( ! function_exists( 'riode_single_prev_next_product' ) ) {
	function riode_single_prev_next_product( $args ) {
		$html = riode_single_product_navigation();
		if ( ! isset( $args['wrap_before'] ) ) {
			$args['wrap_before'] = '';
		}
		$args['wrap_before'] = '<div class="product-navigation">' . $args['wrap_before'];
		if ( ! isset( $args['wrap_after'] ) ) {
			$args['wrap_after'] = '';
		}
		$args['wrap_after'] .= $html . '</div>';

		return apply_filters( 'riode_filter_single_prev_next_product', $args );
	}
}

/**
 * Riode Single Product Layout Functions
 */
if ( ! function_exists( 'riode_single_product_wrap_special_start' ) ) {
	function riode_single_product_wrap_special_start() {

		$single_product_layout = riode_get_single_product_layout();

		if ( 'gallery' == $single_product_layout || 'sticky-both' == $single_product_layout ) {
			$wrap_class = 'col-md-6';

			if ( 'sticky-both' == $single_product_layout ) {
				$wrap_class .= ' col-lg-3';
			}

			echo '<div class="' . esc_attr( apply_filters( 'riode_single_product_wrap_class', $wrap_class ) ) . '">';

			if ( 'sticky-both' == $single_product_layout ) {
				wp_enqueue_script( 'riode-sticky-lib' );
				echo '<div class="sticky-sidebar">';
			}
		}
	}
}
if ( ! function_exists( 'riode_single_product_wrap_special_end' ) ) {
	function riode_single_product_wrap_special_end() {

		$single_product_layout = riode_get_single_product_layout();

		if ( 'gallery' == $single_product_layout || 'sticky-both' == $single_product_layout ) {
			if ( 'sticky-both' == $single_product_layout ) {
				echo '</div>';
			}
			echo '</div>';
		}
	}
}
if ( ! function_exists( 'riode_single_product_wrap_general_start' ) ) {
	function riode_single_product_wrap_general_start() {

		$single_product_layout = riode_get_single_product_layout();

		if ( ( ( riode_doing_ajax() && 'offcanvas' != riode_get_option( 'product_quickview_type' ) ) || ( ! riode_doing_ajax() || riode_is_elementor_preview() ) ) && 'gallery' != $single_product_layout && 'sticky-both' != $single_product_layout ) {
			echo '<div class="' . esc_attr( apply_filters( 'riode_single_product_wrap_class', 'col-md-6' ) ) . '">';
		}
	}
}
if ( ! function_exists( 'riode_single_product_wrap_general_end' ) ) {
	function riode_single_product_wrap_general_end() {

		$single_product_layout = riode_get_single_product_layout();

		if ( ( ( riode_doing_ajax() && 'offcanvas' != riode_get_option( 'product_quickview_type' ) ) || ( ! riode_doing_ajax() || riode_is_elementor_preview() ) ) && 'gallery' != $single_product_layout && 'sticky-both' != $single_product_layout ) {
			echo '</div>';
		}
	}
}
if ( ! function_exists( 'riode_single_product_wrap_sticky_info_start' ) ) {
	function riode_single_product_wrap_sticky_info_start() {
		if ( 'sticky-info' == riode_get_single_product_layout() ) {
			wp_enqueue_script( 'riode-sticky-lib' );
			echo '<div class="sticky-sidebar">';
		}
	}
}
if ( ! function_exists( 'riode_single_product_wrap_sticky_info_end' ) ) {
	function riode_single_product_wrap_sticky_info_end() {
		if ( 'sticky-info' == riode_get_single_product_layout() ) {
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'riode_single_product_sticky_cart_wrap_start' ) ) {
	function riode_single_product_sticky_cart_wrap_start() {
		if ( riode_is_product() && ! riode_doing_quickview() && apply_filters( 'riode_single_product_sticky_cart_enabled', riode_get_option( 'single_product_cart_sticky' ) ) ) {
			echo '<div class="sticky-content fix-top product-sticky-content"><div class="container">';
		}
	}
}

if ( ! function_exists( 'riode_single_product_sticky_cart_wrap_end' ) ) {
	function riode_single_product_sticky_cart_wrap_end() {
		if ( riode_is_product() && ! riode_doing_quickview() && apply_filters( 'riode_single_product_sticky_cart_enabled', riode_get_option( 'single_product_cart_sticky' ) ) ) {
			echo '</div></div>';
		}
	}
}

if ( ! function_exists( 'riode_single_product_sticky_both_class' ) ) {
	function riode_single_product_sticky_both_class( $classes ) {
		$classes[] = 'sticky-both';
		return $classes;
	}
}

/**
 * Riode Single Product Media Functions
 */
if ( ! function_exists( 'riode_single_product_vertical_label_group_class' ) ) {
	function riode_single_product_vertical_label_group_class( $class ) {
		if ( 'default' == riode_get_single_product_layout() && ( riode_doing_quickview() || ( riode_is_product() && 'related' != wc_get_loop_prop( 'name' ) ) ) ) {
			$class .= ' pg-vertical-label';
		}
		return $class;
	}
}
if ( ! function_exists( 'riode_single_product_images' ) ) {
	function riode_single_product_images() {
		global $product;

		$single_product_layout = riode_get_single_product_layout();
		$post_thumbnail_id     = $product->get_image_id();
		$attachment_ids        = $product->get_gallery_image_ids();

		if ( $post_thumbnail_id ) {
			$html = apply_filters( 'woocommerce_single_product_image_thumbnail_html', riode_wc_get_gallery_image_html( $post_thumbnail_id, true, true ), $post_thumbnail_id );
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image">', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}

		if ( $single_product_layout ) {
			if ( $attachment_ids && $post_thumbnail_id ) {
				foreach ( $attachment_ids as $attachment_id ) {
					$html .= apply_filters( 'woocommerce_single_product_image_thumbnail_html', riode_wc_get_gallery_image_html( $attachment_id, true ), $attachment_id );
				}
			}
		}

		if ( 'default' == $single_product_layout || 'horizontal' == $single_product_layout ) {
			$html = '<div class="product-single-carousel owl-carousel owl-theme owl-nav-inner owl-nav-fade row cols-1 gutter-no">' . $html . '</div>';
		} elseif ( 'masonry' == $single_product_layout ) {
			$html .= '<div class="grid-space col-sm-1"></div>';
		} elseif ( 'gallery' == $single_product_layout ) {
			$html = '<div class="product-gallery-carousel owl-carousel owl-same-height owl-theme owl-nav-full' .
				apply_filters( 'riode_single_product_gallery_type_class', ' row cols-1 cols-md-2 cols-lg-3' )
				. '"' . apply_filters( 'riode_single_product_gallery_type_attr', '' ) . '>' . $html . '</div>';
		} elseif ( 'rotate' == $single_product_layout ) {
			$html = '<div class="rotate-slider owl-carousel owl-theme owl-nav-simple2 row cols-1 gutter-no">' . $html . '</div>';
		}

		echo riode_escaped( $html );
	}
}

if ( ! function_exists( 'riode_single_product_wc_gallery_classes' ) ) {
	function riode_single_product_wc_gallery_classes( $classes ) {
		$single_product_layout = riode_get_single_product_layout();
		if ( 'sticky-both' == $single_product_layout ) {
			$classes[] = 'col-lg-6';
		}
		return $classes;
	}
}

if ( ! function_exists( 'riode_single_product_gallery_classes' ) ) {
	function riode_single_product_gallery_classes( $classes ) {
		$single_product_layout = riode_get_single_product_layout();
		$classes[]             = 'product-gallery';

		if ( 'default' == $single_product_layout ) {
			riode_add_async_script( 'owl-carousel' );
			$classes[] = 'pg-vertical';
		} elseif ( 'horizontal' == $single_product_layout ) {
			riode_add_async_script( 'owl-carousel' );
		} elseif ( 'gallery' == $single_product_layout ) {
			$classes[] = 'pg-gallery';
			riode_add_async_script( 'owl-carousel' );
		} elseif ( 'rotate' == $single_product_layout ) {
			riode_add_async_script( 'owl-carousel' );
			$classes[] = 'pg-rotate';
		} elseif ( 'grid' == $single_product_layout ) {
			$classes[] = 'row';
			$classes[] = 'cols-sm-2';
		} elseif ( 'sticky-both' == $single_product_layout ) {
			$classes[] = 'row';
			$classes[] = 'cols-sm-2 cols-lg-1';
		} elseif ( 'masonry' == $single_product_layout ) {
			$classes[] = 'row';
			$classes[] = 'cols-sm-2';
			$classes[] = 'product-masonry-type';
		} elseif ( 'sticky-info' == $single_product_layout ) {
			$classes[] = 'row';
			$classes[] = 'gutter-no';
		}
		return $classes;
	}
}

if ( ! function_exists( 'riode_wc_show_product_thumbnails' ) ) {
	function riode_wc_show_product_thumbnails() {

		if ( riode_doing_quickview() ) {
			return;
		}

		$single_product_layout = riode_get_single_product_layout();

		if ( 'default' == $single_product_layout || 'horizontal' == $single_product_layout ) {
			?>
			<div class="product-thumbs-wrap">
				<div class="product-thumbs row gutter-no">
				<?php
					woocommerce_show_product_thumbnails();
					do_action( 'riode_single_product_after_thumbnails' );
				?>
				</div>
				<button class="thumb-up fas fa-chevron-left disabled"></button>
				<button class="thumb-down fas fa-chevron-right disabled"></button>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'riode_wc_gallery_thumbnail_image_size' ) ) {
	function riode_wc_gallery_thumbnail_image_size( $size ) {

		$single_product_layout = riode_get_single_product_layout();

		if ( 'default' == $single_product_layout || 'horizontal' == $single_product_layout ) {
			$size['width']  = 150;
			$size['height'] = 150;
		}
		return $size;
	}
}

/**
 * Riode Single Product Summary Functions
 */
if ( ! function_exists( 'riode_single_product_sale_countdown' ) ) {
	function riode_single_product_sale_countdown( $label = '', $ends_label = '', $icon_html = '' ) {
		global $product;

		$sale_to_date = '';
		$extra_class  = '';

		if ( $product->is_on_sale() ) {
			if ( $product->is_type( 'variable' ) ) {
				$variations = $product->get_available_variations( 'object' );
				$sale_date  = '';
				foreach ( $variations as $variation ) {
					if ( $variation->is_on_sale() ) {
						$new_date = get_post_meta( $variation->get_id(), '_sale_price_dates_to', true );
						if ( ! $new_date || ( $sale_to_date && $sale_to_date != $new_date ) ) {
							$sale_to_date = false;
						} elseif ( $new_date ) {
							if ( false !== $sale_to_date ) {
								$sale_to_date = $new_date;
							}
							$sale_date = $new_date;
						}
						if ( false === $sale_to_date && $sale_date ) {
							break;
						}
					}
				}
				if ( $sale_to_date ) {
					$sale_to_date = date( 'Y/m/d H:i:s', (int) $sale_to_date );
				} elseif ( $sale_date ) {
					$extra_class  = ' countdown-variations';
					$sale_to_date = date( 'Y/m/d H:i:s', (int) $sale_date );
				}
			} else {
				$sale_end = $product->get_date_on_sale_to();
				if ( $sale_end ) {
					$sale_to_date = $sale_end->date( 'Y/m/d H:i:s' );
				}
			}
		}

		if ( $sale_to_date ) {
		} elseif ( ( function_exists( 'riode_is_elementor_preview' ) && riode_is_elementor_preview() ) ||
					( function_exists( 'riode_is_wpb_preview' ) && riode_is_wpb_preview() ) ) {
			$sale_to_date = date( 'today' );
		} else {
			return;
		}

		$type = '';
		if ( 'woocommerce_single_product_summary' == current_action() ) {
			$ends_label = $ends_label ? $ends_label : esc_html__( 'Off Ends In:', 'riode' );
			$type = ' data-compact="true"';
		} else {
			if ( 'inline' == riode_get_option( 'product_sale_countdown_type' ) ) {
				$type = ' data-compact="true"';
			}

			$extra_class .= ' ' . riode_get_option( 'product_sale_countdown_type' ) . '-type';
		}

		riode_add_async_script( 'jquery-countdown' );
		?>
		<div class="product-countdown-container<?php echo esc_attr( $extra_class ? $extra_class : '' ); ?>">
			<?php if ( $icon_html || $label ) : ?>
				<div class="product-sale-info">
					<?php echo riode_escaped( $icon_html ) . esc_html( $label ); ?>
				</div>
			<?php endif; ?>
			<div class="countdown-wrap">
				<?php echo esc_html( $ends_label ); ?>
				<div class="product-countdown countdown-compact" data-until="<?php echo esc_attr( $sale_to_date ); ?>"<?php echo esc_attr( $type ); ?>></div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'riode_single_product_summary_extend_class' ) ) {
	function riode_single_product_summary_extend_class( $class ) {
		$single_product_layout = riode_get_single_product_layout();
		if ( 'gallery' == $single_product_layout || 'sticky-both' == $single_product_layout ) {
			$class .= ' row';
		} elseif ( riode_doing_ajax() ) {
			$class .= ' scrollable';
		}
		return $class;
	}
}

if ( ! function_exists( 'riode_single_product_divider' ) ) {
	function riode_single_product_divider() {
		echo apply_filters( 'riode_single_product_divider', '<hr class="product-divider">' );
	}
}

if ( ! function_exists( 'riode_wc_template_single_price' ) ) {
	function riode_wc_template_single_price() {
		if ( 'gallery' != riode_get_single_product_layout() ) {
			woocommerce_template_single_price();
		}
	}
}

if ( ! function_exists( 'riode_wc_template_gallery_single_price' ) ) {
	function riode_wc_template_gallery_single_price() {
		if ( 'gallery' == riode_get_single_product_layout() ) {
			woocommerce_template_single_price();
		}
	}
}

/**
 * Riode Single Product Form Functions
 */
if ( ! function_exists( 'riode_wc_dropdown_variation_attribute_options_arg' ) ) {
	function riode_wc_dropdown_variation_attribute_options_arg( $args ) {
		// Select Box
		if ( 'select' == $args['type'] ) {
			$args['class'] = isset( $args['class'] ) ? $args['class'] . ' form-control' : 'form-control';
		}
		return $args;
	}
}

if ( ! function_exists( 'riode_wc_dropdown_variation_attribute_options_html' ) ) {
	function riode_wc_dropdown_variation_attribute_options_html( $html, $args ) {
		// Select Box
		if ( 'select' == $args['type'] ) {
			$html = '<div class="select-box">' . $html . '</div>';
		}

		// Guide Link
		if ( riode_get_option( 'attribute_guide' ) ) {
			$name            = substr( $args['attribute'], 3 );
			$riode_pa_blocks = get_option( 'riode_pa_blocks' );

			if ( isset( $riode_pa_blocks[ $name ] ) &&
				isset( $riode_pa_blocks[ $name ]['text'] ) ) {

				$html .= '<a href="' . ( riode_doing_quickview() || apply_filters( 'riode_is_single_product_widget', false ) ? esc_url( get_the_permalink() ) : '' ) . '#tab-title-riode_pa_block_' . esc_attr( $name ) . '" class="guide-link ' . esc_attr( $name ) . '-guide">';
				if ( ! empty( $riode_pa_blocks[ $name ]['icon'] ) ) {
					$html .= '<i class="' . esc_attr( $riode_pa_blocks[ $name ]['icon'] ) . '"></i>';
				}
				$html .= $riode_pa_blocks[ $name ]['text'] . '</a>';
			}
		}

		return $html;
	}
}

if ( ! function_exists( 'riode_wc_before_quantity_input_field' ) ) {
	function riode_wc_before_quantity_input_field() {
		echo '<button class="quantity-minus d-icon-minus"></button>';
	}
}

if ( ! function_exists( 'riode_wc_after_quantity_input_field' ) ) {
	function riode_wc_after_quantity_input_field() {
		echo '<button class="quantity-plus d-icon-plus"></button>';
	}
}

if ( ! function_exists( 'riode_wc_product_single_add_to_cart_text' ) ) {
	function riode_wc_product_single_add_to_cart_text( $text, $self ) {
		global $product;

		if ( 'simple' == $product->get_type() ) {
			return esc_html__( 'Add to Cart', 'riode' );
		}

		return $text;
	}
}

/**
 * Riode Single Product Data Tab Functions
 */
if ( ! function_exists( 'riode_wc_output_product_data_tabs_outer' ) ) {
	function riode_wc_output_product_data_tabs_outer( $tabs ) {
		if ( ! riode_doing_quickview() && ! apply_filters( 'riode_single_product_tab_inside', riode_get_option( 'single_product_tab_inside' ) ) ) {
			woocommerce_output_product_data_tabs();
		}
	}
}
if ( ! function_exists( 'riode_wc_output_product_data_tabs_inner' ) ) {
	function riode_wc_output_product_data_tabs_inner( $tabs ) {
		if ( ! riode_doing_quickview() && ! apply_filters( 'riode_is_single_product_widget', false ) && apply_filters( 'riode_single_product_tab_inside', riode_get_option( 'single_product_tab_inside' ) ) ) {
			woocommerce_output_product_data_tabs();
		}
	}
}
if ( ! function_exists( 'riode_single_product_get_data_tab_type' ) ) {
	function riode_single_product_get_data_tab_type( $tabs ) {
		return riode_get_option( 'single_product_tab_type' );
	}
}

if ( ! function_exists( 'riode_wc_product_custom_tabs' ) ) {
	function riode_wc_product_custom_tabs( $tabs ) {
		// global custom tab
		$title = riode_get_option( 'single_product_tab_title' );
		if ( $title ) {
			$tabs['riode_product_tab'] = array(
				'title'    => sanitize_text_field( $title ),
				'priority' => 24,
				'callback' => 'riode_wc_product_custom_tab',
			);
		}

		if ( riode_get_option( 'product_cdt' ) ) {
			// individual custom tab 1
			$title = get_post_meta( get_the_ID(), 'riode_custom_tab_title', true );
			if ( $title ) {
				$tabs['riode_custom_tab'] = array(
					'title'    => sanitize_text_field( $title ),
					'priority' => 26,
					'callback' => 'riode_wc_product_custom_tab',
				);
			}

			// individual custom tab 2
			$title = get_post_meta( get_the_ID(), 'riode_custom_tab_title2', true );
			if ( $title ) {
				$tabs['riode_custom_tab2'] = array(
					'title'    => sanitize_text_field( $title ),
					'priority' => 26,
					'callback' => 'riode_wc_product_custom_tab',
				);
			}
		}

		// Guide block
		if ( riode_get_option( 'attribute_guide' ) ) {
			global $product;
			if ( 'variable' == $product->get_type() ) {
				$attributes      = $product->get_attributes();
				$riode_pa_blocks = get_option( 'riode_pa_blocks' );

				foreach ( $attributes as $key => $attribute ) {
					$name = substr( $key, 3 );
					if ( isset( $riode_pa_blocks[ $name ] ) &&
						isset( $riode_pa_blocks[ $name ]['block'] ) && $riode_pa_blocks[ $name ]['block'] &&
						isset( $riode_pa_blocks[ $name ]['text'] ) && $riode_pa_blocks[ $name ]['text'] ) {

						$tabs[ 'riode_pa_block_' . $name ] = apply_filters(
							"riode_product_attribute_{$name}_guide",
							array(
								'title'    => sanitize_text_field( $riode_pa_blocks[ $name ]['text'] ),
								'priority' => 28,
								'callback' => 'riode_wc_product_custom_tab',
								'block_id' => absint( $riode_pa_blocks[ $name ]['block'] ),
							)
						);
					}
				}
			}
		}

		return $tabs;
	}
}
if ( ! function_exists( 'riode_wc_product_custom_tab' ) ) {
	function riode_wc_product_custom_tab( $key, $product_tab ) {
		wc_get_template(
			'single-product/tabs/custom_tab.php',
			array(
				'tab_name' => $key,
				'tab_data' => $product_tab,
			)
		);
	}
}
/**
 * Change default YITH positions
 */
if ( ! function_exists( 'riode_yith_wcwl_positions' ) ) {
	function riode_yith_wcwl_positions( $position ) {
		$position['after_add_to_cart']['priority'] = 55;
		$position['add-to-cart']['priority']       = 55;
		return $position;
	}
}

/**
 * Riode product compare function
 */
if ( ! function_exists( 'riode_single_product_compare' ) ) {
	function riode_single_product_compare( $extra_class = '' ) {
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
			$css_class  .= ' added';
			$button_text = esc_html__( 'Added', 'riode' );
		} else {
			$button_text = esc_html__( 'Add To Compare', 'riode' );
		}

		$url = esc_url_raw( add_query_arg( $url_args, site_url() ) );
		printf( '<a href="%s" class="%s" title="%s" data-product_id="%d">%s</a>', esc_url( $url ), esc_attr( $css_class ), esc_html( $button_text ), $product_id, $button_text );
	}
}

/**
 * Single Product Reviews Tab
 */
if ( ! function_exists( 'riode_wc_review_before_avatar' ) ) {
	function riode_wc_review_before_avatar() {
		echo '<figure class="comment-avatar">';
	}
}
if ( ! function_exists( 'riode_wc_review_after_avatar' ) ) {
	function riode_wc_review_after_avatar() {
		echo '</figure>';
	}
}

/**
 * Riode Single Product - Related Products Functions
 */
if ( ! function_exists( 'riode_related_products_args' ) ) {
	function riode_related_products_args( $args = array() ) {
		$count    = riode_get_option( 'single_product_related_count' );
		$orderby  = riode_get_option( 'single_product_related_orderby' );
		$orderway = riode_get_option( 'single_product_related_orderway' );
		if ( $count ) {
			$args['posts_per_page'] = $count;
		}
		if ( $orderby ) {
			$args['orderby'] = $orderby;
		}
		if ( $orderway ) {
			$args['orderway'] = $orderway;
		}
		return $args;
	}
}


/**
 * Riode Single Product - Lazyload Images Functions
 */
if ( ! function_exists( 'riode_wc_gallery_image_params' ) ) {
	function riode_wc_gallery_image_params( $args, $id, $image_size, $main_image ) {
		if ( empty( $args ) ) {
			$args = array();
		}
		if ( riode_get_option( 'lazyload' ) ) {
			$args['class'] .= ' d-lazyload';
		}
	}
}

/**
 * Riode Quickview Ajax Actions
 */
if ( ! function_exists( 'riode_wc_quickview' ) ) {
	function riode_wc_quickview() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification
		if ( ! has_action( 'woocommerce_single_product_summary', 'riode_product_compare', 57 ) ) {
			add_action( 'woocommerce_single_product_summary', 'riode_product_compare', 57 );
		}

		global $product, $post;
		$product_id = intval( $_POST['product_id'] );
		$post       = get_post( $product_id );
		$product    = wc_get_product( $product_id );

		if ( $product->is_type( 'variation' ) ) {
			$attrs = wc_get_product_variation_attributes( $post->ID );
			if ( ! empty( $attrs ) ) {
				foreach ( $attrs as $key => $val ) {
					$_REQUEST[ $key ] = $val;
				}
			}
			$parent_id = wp_get_post_parent_id( $post );
			if ( $parent_id ) {
				$post    = get_post( (int) $parent_id );
				$product = wc_get_product( $post->ID );
			}
		}
		wc_get_template_part( 'content', 'single-product' );
		// phpcs:enable
		die;
	}
}

if ( ! function_exists( 'riode_quickview_add_scripts' ) ) {
	function riode_quickview_add_scripts() {
		wp_enqueue_script( 'imagesloaded' );
		riode_add_async_script( 'owl-carousel' );
		riode_add_async_script( 'jquery-magnific-popup' );
		riode_add_async_script( 'jquery-countdown' );

		wp_enqueue_script( 'wc-single-product' );
		wp_enqueue_script( 'wc-add-to-cart-variation' );
		wp_enqueue_script( 'zoom' );
	}
}

if ( ! function_exists( 'riode_print_grouped_product_thumbnail' ) ) {
	function riode_print_grouped_product_thumbnail( $child ) {
		echo '<td class="product-thumbnail">';
		echo '<figure>';
		the_post_thumbnail( 'riode-product-thumbnail' );
		echo '</figure>';
		echo '</td>';
	}
}

if ( ! function_exists( 'riode_grouped_product_columns' ) ) {
	/**
	 * riode_grouped_product_columns
	 *
	 * rearranges grouped product columns
	 *
	 * @since 1.4.0
	 */
	function riode_grouped_product_columns( $columns, $product ) {
		return array(
			'label',
			'price',
			'quantity',
		);
	}
}

if ( ! function_exists( 'riode_print_grouped_product_list_column' ) ) {
	/**
	 * riode_print_grouped_product_list_column_quantity
	 *
	 * changes the way to display checkbox option for product which can be sold individually
	 *
	 * @since 1.4.0
	 */
	function riode_print_grouped_product_list_column_quantity( $value, $child ) {
		if ( $child->is_sold_individually() ) {
			return '<label class="sell-individually"><input type="checkbox" name="' . esc_attr( 'quantity[' . $child->get_id() . ']' ) . '" value="1" class="wc-grouped-product-add-to-cart-checkbox" /><span>' . esc_html__( 'Buy This', 'riode' ) . '</span></label>';
		}

		return $value;
	}
}

if ( ! function_exists( 'riode_variation_add_sale_ends' ) ) {
	/**
	 * riode_variation_add_sale_ends
	 *
	 * add sale countdown data when product variation has sale end date.
	 *
	 * @since 1.4.0
	 */
	function riode_variation_add_sale_ends( $vars, $product, $variation ) {
		if ( $variation->is_on_sale() ) {
			$date_diff = $variation->get_date_on_sale_to();
			if ( $date_diff ) {
				$vars['riode_date_on_sale_to'] = $date_diff->date( 'Y/m/d H:i:s' );
			}
		}
		return $vars;
	}
}
