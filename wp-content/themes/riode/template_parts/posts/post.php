<?php
/**
 * post.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

wp_enqueue_script( 'imagesloaded' );

$classes    = get_post_class();
$wrap_class = array();
$wrap_attrs = '';

if ( ! in_array( 'post', $classes ) ) {
	$classes[] = 'post';
}

$widget     = isset( $widget );
$single     = isset( $single ) ? $single : false;
$related    = isset( $related ) ? $related : false;
$image_size = 'large';

// For Widget
if ( $widget ) {
	if ( 'creative' == $post_grid ) {
		$wrap_class[] = 'grid-item';

		if ( class_exists( 'RIODE_CORE' ) ) {
			$grid_item = riode_post_creative_layout( $creative_mode )[ $creative_idx ];

			foreach ( $grid_item as $key => $value ) {
				$wrap_class[] = ' ' . $key . '-' . $value;
			}
		}
	}
}

if ( $widget && ! isset( $follow_theme_option ) ) { // For "custom options" Widget
	if ( ! $excerpt_type ) {
		$excerpt_type = riode_get_option( 'post_excerpt_type' );
	}
	if ( ! $excerpt_limit ) {
		$excerpt_limit = riode_get_option( 'post_excerpt_limit' );
	}
	if ( isset( $overlay ) && $overlay ) {
		$classes[] = riode_get_overlay_class( $overlay );
	}
} else { // Archive, Single Or "follow theme option" Widget
	if ( ! $single || $related || isset( $follow_theme_option ) ) { // Archive page or Related posts
		// Type and Count Row
		$type      = apply_filters( 'riode_post_type', riode_get_option( 'post_type' ) );
		$cnt_row   = apply_filters( 'riode_post_count_row', riode_get_option( 'post_count_row' ) );
		$show_info = apply_filters( 'riode_archive_post_show_items', array( 'image', 'date', 'comment', 'content', 'readmore' ) );

		if ( $related ) {
			$type       = '';
			$image_size = 'medium';
			$show_info  = apply_filters( 'riode_related_post_show_items', array( 'image', 'content', 'readmore' ) );
		} elseif ( 3 < $cnt_row ) {
			$image_size = 'medium';
		} elseif ( 1 == $cnt_row ) {
			$classes[] = 'post-lg';
			$classes[] = 'post-full';
			$show_info = apply_filters( 'riode_classic_post_show_items', array( 'image', 'author', 'date', 'comment', 'content', 'readmore' ) );
		}

		// Excerpt
		$excerpt_limit = riode_get_option( 'post_excerpt_limit' );
		$excerpt_type  = riode_get_option( 'post_excerpt_type' );

		if ( $related ) {
			if ( 'words' == $excerpt_type ) {
				$excerpt_limit = 10;
			} else {
				$excerpt_limit = 80;
			}
		}

		// Overlay
		$classes[] = riode_get_overlay_class( riode_get_option( 'post_overlay' ) );

		// Show Date Box
		$show_datebox = riode_get_option( 'post_show_datebox' );

		// Read More
		$read_more_label = '';

		// Except Widget
		if ( ! isset( $follow_theme_option ) ) {
			// Show Filter
			$post_grid   = riode_get_option( 'post_grid' );
			$show_filter = riode_get_option( 'post_show_filter' );
			if ( $show_filter || 'creative' == $post_grid ) {
				$wrap_class[] = 'grid-item';
			}
			if ( $show_filter ) {
				$cs = get_the_category( get_the_ID() ); // categories of each post.

				foreach ( $cs as $cat ) {
					$wrap_class[] = $cat->slug;
				}
			}
		}
	} else { // Single Post Page
		$show_info = riode_get_option( 'post_show_info' );
		if ( in_array( 'meta', $show_info ) ) {
			$show_info[] = 'author';
			$show_info[] = 'date';
			$show_info[] = 'comment';
		}

		$type            = '';
		$cnt_row         = '';
		$excerpt_limit   = '';
		$excerpt_type    = '';
		$read_more_label = '';
		$show_datebox    = '';
		$classes[]       = 'post-full';
	}
}

if ( $type ) { // List or Mask
	if ( 'list' != $type || 'creative' != $post_grid ) {
		$classes[] = 'post-' . $type;
	}
	if ( 'list' == $type ) {
		$show_info = apply_filters( 'riode_list_type_post_show_items', array( 'image', 'date', 'comment', 'content', 'readmore' ), $type );
	} elseif ( false !== strpos( $type, 'mask' ) ) {
		$show_info = apply_filters( 'riode_mask_type_post_show_items', array( 'image', 'date', 'comment', 'content', 'readmore' ), $type );
	} elseif ( 'overlap' == $type ) {
		$show_info = apply_filters( 'riode_overlap_type_post_show_items', array( 'image', 'date', 'comment', 'readmore' ), $type );
	}
}

if ( empty( $read_more_label ) ) {
	$read_more_label = esc_html__( 'Read More', 'riode' );
}
if ( empty( $read_more_class ) ) {
	$read_more_class = '';
}

$classes = apply_filters( 'riode_post_loop_classes', $classes );

// Render
?>
<div class="post-wrap <?php echo esc_attr( implode( ' ', $wrap_class ) ); ?>">
	<?php do_action( 'riode_post_loop_before_item', $type ); ?>
	<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php
		if ( 'list-xs' !== $type ) {
			if ( in_array( 'image', $show_info ) ) {

				$props = array(
					'type'         => $type,
					'image_size'   => $image_size,
					'related'      => $related,
					'single'       => $single,
					'type'         => $type,
					'show_datebox' => $show_datebox,
					'widget'       => $widget,
				);

				if ( isset( $thumbnail_size ) ) {
					$props['image_size'] = $thumbnail_size;
					if ( 'custom' == $thumbnail_size && isset( $thumbnail_custom_dimension ) ) {
						$props['image_custom_size'] = $thumbnail_custom_dimension;
					}
				}

				riode_get_template_part(
					RIODE_PART . '/posts/elements/post',
					'media',
					$props
				);
			}
		} else {
			riode_get_template_part(
				RIODE_PART . '/posts/elements/post',
				'date-in-media'
			);
		}
		?>
		<div class="post-details">
			<?php
			riode_get_template_part(
				RIODE_PART . '/posts/elements/post',
				'meta',
				array(
					'related'   => $related,
					'show_info' => $show_info,
				)
			);
			riode_get_template_part(
				RIODE_PART . '/posts/elements/post',
				'title',
				array(
					'single'  => $single,
					'related' => $related,
				)
			);
			riode_get_template_part(
				RIODE_PART . '/posts/elements/post',
				'category',
				array(
					'related'   => $related,
					'show_info' => $show_info,
				)
			);
			if ( 'mask' != $type && 'mask gradient' != $type && in_array( 'content', $show_info ) ) {
				riode_get_template_part(
					RIODE_PART . '/posts/elements/post',
					'content',
					array(
						'single'        => $single,
						'related'       => $related,
						'show_info'     => $show_info,
						'excerpt_limit' => $excerpt_limit,
						'excerpt_type'  => $excerpt_type,
					)
				);
			}
			riode_get_template_part(
				RIODE_PART . '/posts/elements/post',
				'readmore',
				array(
					'single'          => $single,
					'related'         => $related,
					'show_info'       => $show_info,
					'read_more_label' => $read_more_label,
					'read_more_class' => $read_more_class,
				)
			);
			if ( $single && ! $related ) {
				if ( in_array( 'author_box', $show_info ) ) {
					get_template_part( RIODE_PART . '/posts/elements/post-author' );
				}

				if ( ( in_array( 'tag', $show_info ) && get_the_tag_list() ) || ( in_array( 'share', $show_info ) && function_exists( 'riode_print_share' ) ) ) {
					echo '<div class="post-footer">';
					if ( in_array( 'tag', $show_info ) && get_the_tag_list() ) {
						get_template_part( RIODE_PART . '/posts/elements/post-tag' );
					}
					if ( in_array( 'share', $show_info ) && function_exists( 'riode_print_share' ) ) {
						riode_print_share();
					}
					echo '</div>';
				}
			}

			?>
		</div>
	</article>
	<?php do_action( 'riode_post_loop_after_item', $type ); ?>
</div>
