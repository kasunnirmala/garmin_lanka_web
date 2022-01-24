<?php
/**
 * Riode WooCommerce Product Category Functions
 *
 * Functions used to display product category.
 */

defined( 'ABSPATH' ) || die;

remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open' );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close' );

// Category Thumbnail
add_action( 'woocommerce_before_subcategory_title', 'riode_before_subcategory_thumbnail', 5 );
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail' );
add_action( 'woocommerce_before_subcategory_title', 'riode_wc_subcategory_thumbnail' );
add_action( 'woocommerce_before_subcategory_title', 'riode_after_subcategory_thumbnail', 15 );
add_filter( 'subcategory_archive_thumbnail_size', 'riode_wc_category_thumbnail_size' );

// Category Content
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title' );
add_action( 'woocommerce_shop_loop_subcategory_title', 'riode_wc_template_loop_category_title' );
add_action( 'woocommerce_after_subcategory_title', 'riode_wc_after_subcategory_title' );

/**
 * Riode Category Thumbnail Functions
 */
if ( ! function_exists( 'riode_before_subcategory_thumbnail' ) ) {
	function riode_before_subcategory_thumbnail( $category ) {
		$category_type = wc_get_loop_prop( 'category_type' );
		echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '"' .
			( wc_get_loop_prop( 'run_as_filter' ) ? ' data-cat="' . $category->term_id . '"' : '' ) . '>';

		if ( 'label' != $category_type ) {
			echo '<figure>';
		}
	}
}

if ( ! function_exists( 'riode_wc_subcategory_thumbnail' ) ) {
	function riode_wc_subcategory_thumbnail( $category ) {
		$category_type = wc_get_loop_prop( 'category_type' );
		if ( 'label' != $category_type ) {
			if ( wc_get_loop_prop( 'show_icon', false ) ) {
				$icon_class = get_term_meta( $category->term_id, 'product_cat_icon', true );
				$icon_class = $icon_class ? $icon_class : 'far fa-heart';
				echo '<i class="' . $icon_class . '"></i>';
			} else {
				$html           = '';
				$thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'woocommerce_thumbnail' );
				$thumbnail_id   = get_term_meta( $category->term_id, 'thumbnail_id', true );
				$dimensions     = false;

				if ( ! in_array( str_replace( 'woocommerce_', '', $thumbnail_size ), array( 'shop_single', 'single', 'shop_catalog', 'thumbnail', 'shop_thumbnail', 'gallery_thumbnail' ) ) ) {
					if ( 'full' == $thumbnail_size ) {
						$dimensions = wp_get_attachment_metadata( $thumbnail_id );
					} else {
						$dimensions = image_get_intermediate_size( $thumbnail_id, $thumbnail_size );
					}
				}
				if ( ! $dimensions ) {
					$dimensions = wc_get_image_size( $thumbnail_size );
				}

				if ( $thumbnail_id ) {
					if ( isset( $dimensions['url'] ) && $dimensions['url'] ) {
						$image = $dimensions['url'];
					} else {
						$image = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size );

						if ( ! empty( $image ) ) {
							$image = $image[0];
						} else {
							$image = wc_placeholder_img_src();
						}
					}
					if ( empty( $image ) ) {
						$image = wc_placeholder_img_src();
					}
					$image_srcset = wp_get_attachment_image_srcset( $thumbnail_id, $thumbnail_size );
					$image_sizes  = wp_get_attachment_image_sizes( $thumbnail_id, $thumbnail_size );

					if ( 0 == $dimensions['height'] ) {
						$full_image_size = wp_get_attachment_image_src( $thumbnail_id, 'full' );
						if ( isset( $full_image_size[1] ) && $full_image_size[1] ) {
							$dimensions['height'] = intval( $dimensions['width'] / absint( $full_image_size[1] ) * absint( $full_image_size[2] ) );
						}
					}
				} else {
					$image        = wc_placeholder_img_src();
					$image_srcset = false;
					$image_sizes  = false;
				}

				if ( $image ) {
					// Prevent esc_url from breaking spaces in urls for image embeds.
					// Ref: https://core.trac.wordpress.org/ticket/23605.
					$image = str_replace( ' ', '%20', $image );

					// Add responsive image markup if available.
					if ( $image_srcset && $image_sizes ) {
						$html = '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" />';
					} else {
						$html = '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
					}
				}

				echo apply_filters( 'riode_wc_subcategory_thumbnail_html', $html );
			}

			if ( 'icon-overlay' == $category_type ) {
				$icon_class = get_term_meta( $category->term_id, 'product_cat_icon', true );
				$icon_class = $icon_class ? $icon_class : 'far fa-heart';
				echo '<i class="' . $icon_class . '"></i>';
			}
		}
	}
}

if ( ! function_exists( 'riode_after_subcategory_thumbnail' ) ) {
	function riode_after_subcategory_thumbnail( $category ) {
		$category_type  = wc_get_loop_prop( 'category_type' );
		$content_origin = wc_get_loop_prop( 'content_origin' );
		if ( 'label' != $category_type ) {

			echo '</figure>';

			if ( 'group-2' === $category_type ) { // Group 2
				// Title
				echo '<h3 class="woocommerce-loop-category__title">';
				echo esc_html( $category->name );

				// Count
				if ( wc_get_loop_prop( 'show_count', true ) ) {
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark>(' . esc_html( $category->count ) . ')</mark>', $category );
				}

				echo '</h3>';
			}
			if ( 'boxed' !== $category_type ) {
				echo '</a>';
			}
			if ( $content_origin ) {
				echo '<div class="category-content ' . $content_origin . '">';
			} else {
				echo '<div class="category-content">';
			}
		}
	}
}

if ( ! function_exists( 'riode_wc_category_thumbnail_size' ) ) {
	function riode_wc_category_thumbnail_size( $size ) {
		$size = wc_get_loop_prop( 'thumbnail_size', $size );
		if ( 'custom' == $size ) {
			return wc_get_loop_prop( 'thumbnail_custom_size', 'woocommerce_thumbnail' );
		}
		return $size;
	}
}

/**
 * Riode Category Content Functions
 */
if ( ! function_exists( 'riode_wc_template_loop_category_title' ) ) {
	function riode_wc_template_loop_category_title( $category ) {

		$category_type = wc_get_loop_prop( 'category_type' );

		// Title
		if ( 'group-2' !== $category_type ) {
			echo '<h3 class="woocommerce-loop-category__title">';

			if ( 'boxed' !== $category_type && 'boxed' !== $category_type && 'badge' !== $category_type && 'banner' !== $category_type && 'classic' !== $category_type && 'label' !== $category_type ) {
				echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '"' .
					( wc_get_loop_prop( 'run_as_filter' ) ? ' data-cat="' . $category->term_id . '"' : '' ) . '>';
				echo esc_html( $category->name );
				echo '</a>';
			} else {
				echo esc_html( $category->name );
			}

			// Count
			if ( ( 'badge' === $category_type || 'boxed' === $category_type ) && wc_get_loop_prop( 'show_count', true ) ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark>(' . esc_html( $category->count ) . ')</mark>', $category );
			}

			echo '</h3>';

			// Count
			if ( 'badge' !== $category_type && 'boxed' !== $category_type && wc_get_loop_prop( 'show_count', true ) ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', '<mark>' . esc_html( $category->count ) . ' ' . esc_html__( 'Products', 'riode' ) . '</mark>', $category );
			}
		}
		// Link
		if ( wc_get_loop_prop( 'show_link', true ) ) {
			$link_text  = wc_get_loop_prop( 'link_text' );
			$link_class = 'btn btn-underline btn-link';
			if ( 'badge' === $category_type ) {
				$link_class = 'btn btn-primary btn-block';
			}
			echo '<a class="' . esc_attr( $link_class ) . '"' .
				( wc_get_loop_prop( 'run_as_filter' ) ? ' data-cat="' . $category->term_id . '"' : '' ) .
				' href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '">' .
				( $link_text ? esc_html( $link_text ) : esc_html__( 'Shop Now', 'riode' ) ) .
				'</a>';
		}
		if ( 'group' === $category_type || 'group-2' === $category_type ) {
			$terms = get_terms(
				array(
					'taxonomy'   => 'product_cat',
					'parent'     => $category->term_id, // $parent ),
					'hide_empty' => false,
					'number'     => wc_get_loop_prop( 'subcat_cnt', 5 ),
				)
			);
			if ( is_array( $terms ) ) {
				echo '<ul class="category-list">';

				if ( 0 === count( $terms ) && (
					( function_exists( 'riode_is_elementor_preview' ) && riode_is_elementor_preview() ) ||
					( function_exists( 'vc_is_inline' ) && vc_is_inline() ) ) ) {
					for ( $i = 1; $i <= wc_get_loop_prop( 'subcat_cnt', 5 ); ++ $i ) {
						echo '<li><a href="#">';
						/* translators: %d represents a virtual number from 1 to 5. */
						printf( esc_html__( 'Subcategory %d', 'riode' ), $i );
						echo '</a></li>';
					}
				} else {
					foreach ( $terms as $term ) {
						echo '<li><a href="' . get_term_link( $term ) . '"' .
						( wc_get_loop_prop( 'run_as_filter' ) ? ' data-cat="' . $term->term_id . '"' : '' ) . '>' . $term->name . '</a></li>';
					}
				}

				echo '</ul>';
			}
		}
	}
}

if ( ! function_exists( 'riode_wc_after_subcategory_title' ) ) {
	function riode_wc_after_subcategory_title() {
		$category_type = wc_get_loop_prop( 'category_type' );
		if ( 'label' == $category_type ) {
			echo '</a>';
		} else {
			echo '</div>';
			if ( 'boxed' === $category_type ) {
				echo '</a>';
			}
		}
	}
}
