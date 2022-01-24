<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Posts Widget Render
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Posts Selector
			'post_ids'                   => '',
			'categories'                 => '',
			'count'                      => array( 'size' => 6 ),
			'orderby'                    => 'ID',
			'orderway'                   => 'DESC',

			// Posts Layout
			'layout_type'                => 'grid',
			'col_cnt'                    => 3,
			'thumbnail_size'             => 'medium',
			'thumbnail_custom_dimension' => '',
			'creative_mode'              => 1,
			'creative_height'            => array( 'size' => 600 ),
			'creative_height_ratio'      => array( 'size' => 75 ),
			'grid_float'                 => '',
			'loadmore_type'              => '',
			'row_cnt'                    => 1,

			// Post Type
			'follow_theme_option'        => '',
			'post_type'                  => '',
			'overlay'                    => '',
			'show_info'                  => array(),
			'show_datebox'               => '',
			'read_more_label'            => 'Read More',
			'read_more_custom'           => '',
			'excerpt_custom'             => '',
			'excerpt_limit'              => array( 'size' => 20 ),
			'excerpt_type'               => 'words',

			// Style
			'content_align'              => '',
			'page_builder'               => '',
			'wrapper_id'                 => '',
		),
		$atts
	)
);

do_action( 'riode_save_used_widget', 'posts' );

if ( ! is_array( $count ) ) {
	$count = json_decode( $count, true );
}
if ( '' == $col_cnt ) {
	$col_cnt         = 3;
	$atts['col_cnt'] = 3;
}
if ( ! is_array( $creative_height ) ) {
	$creative_height = json_decode( $creative_height, true );
}
if ( ! is_array( $creative_height_ratio ) ) {
	$creative_height_ratio = json_decode( $creative_height_ratio, true );
}
if ( ! is_array( $col_cnt ) && $col_cnt ) {
	$col_cnt = json_decode( $col_cnt, true );
}
if ( ! is_array( $show_info ) ) {
	$show_info = explode( ',', $show_info );
}
if ( ! is_array( $excerpt_limit ) ) {
	$excerpt_limit = json_decode( $excerpt_limit, true );
}
// Generate a Query ////////////////////////////////////////////////////////////

$posts_per_page = $count['size'];

$args = array(
	'post_type'      => 'post',
	'posts_per_page' => $posts_per_page,
);

if ( ! empty( $post_ids ) ) {
	$args['post__in']       = explode( ',', $post_ids );
	$args['posts_per_page'] = count( $args['post__in'] );
	$orderby                = 'post__in';
}


if ( '' != $categories && ! empty( $categories ) ) {
	$cat_arr = explode( ',', $categories );
	if ( isset( $cat_arr[0] ) && is_numeric( trim( $cat_arr[0] ) ) ) {
		$args['cat'] = $categories;
	} else {
		$args['category_name'] = $categories;
	}
}

if ( $orderby ) {
	$args['orderby'] = $orderby;
}
if ( $orderway ) {
	$args['order'] = $orderway;
}

if ( 'creative' == $layout_type ) {
	$creative_layout = riode_post_creative_layout( $creative_mode );

	$args['posts_per_page'] = count( $creative_layout );
}

$posts = new WP_Query( $args );

// Process Posts /////////////////////////////////////////////////////////////////

if ( $posts->have_posts() ) {

	$extra_class = array( 'posts' );
	$extra_attrs = '';

	// Props

	$props = array(
		'widget'    => true,
		'post_grid' => $layout_type,
	);

	if ( ! $follow_theme_option ) {
		$props['type']            = $post_type;
		$props['overlay']         = $overlay;
		$props['show_info']       = $show_info;
		$props['show_datebox']    = $show_datebox;
		$props['excerpt_limit']   = 'yes' === $excerpt_custom ? $excerpt_limit['size'] : '';
		$props['excerpt_type']    = 'yes' === $excerpt_custom ? $excerpt_type : '';
		$props['read_more_label'] = riode_widget_button_get_label( $atts, '', $read_more_label ? $read_more_label : 'Read More' );
		$props['read_more_class'] = $read_more_custom ? implode( ' ', riode_widget_button_get_class( $atts ) ) : '';

	} else {
		$props['follow_theme_option'] = 'yes';
	}
	$props['thumbnail_size']             = $thumbnail_size;
	$props['thumbnail_custom_dimension'] = $thumbnail_custom_dimension;

	// Layout

	$col_cnt          = riode_elementor_grid_col_cnt( $atts );
	$grid_space_class = riode_elementor_grid_space_class( $atts );

	if ( $grid_space_class ) {
		$extra_class[] = $grid_space_class;
	}

	if ( 'grid' === $layout_type || 'slider' === $layout_type ) {
		$extra_class[] = riode_get_col_class( $col_cnt );

	} elseif ( 'creative' == $layout_type ) {
		wp_enqueue_script( 'isotope-pkgd' );

		$extra_class[] = 'grid';
		$extra_class[] = 'creative-grid';
		$extra_class[] = 'grid-mode-' . $creative_mode;
		if ( $grid_float ) {
			$extra_class[] = 'grid-float';
		}

		$extra_attrs .= ' data-plugin="isotope"';

		if ( 'wpb' == $page_builder ) {
			riode_creative_layout_style(
				'.' . str_replace( ' ', '', $shortcode_class ),
				$creative_layout,
				$creative_height['size'] ? $creative_height['size'] : 600,
				$creative_height_ratio['size'] ? $creative_height_ratio['size'] : 75
			);
		} else {
			riode_creative_layout_style(
				'.elementor-element-' . $this->get_data( 'id' ),
				$creative_layout,
				$creative_height['size'] ? $creative_height['size'] : 600,
				$creative_height_ratio['size'] ? $creative_height_ratio['size'] : 75
			);
		}
		$props['creative_idx']  = 0;
		$props['creative_mode'] = $creative_mode;
	}

	if ( 'slider' === $layout_type ) {
		do_action( 'riode_save_used_widget', 'slider' );

		$extra_class[] = riode_get_slider_class( $atts );

		if ( 'framed' == $post_type ) {
			$extra_class[] = 'owl-shadow-carousel';
		}
		$extra_attrs .= ' data-plugin="owl" data-owl-options=' . esc_attr(
			json_encode(
				riode_get_slider_attrs( $atts, $col_cnt )
			)
		);
	}

	if ( in_array( $content_align, array( 'left', 'center', 'right' ) ) ) {
		$extra_class[] = 'text-' . $content_align;
	}

	// Load More Properties

	if ( function_exists( 'riode_loadmore_attributes' ) ) {
		if ( 'scroll' == $loadmore_type ) {
			$extra_class[] = 'load-scroll';
		}
		$extra_attrs .= ' ' . riode_loadmore_attributes( $props, $args, $loadmore_type, $posts->max_num_pages );
	}

	echo '<div class="' . esc_attr( implode( ' ', apply_filters( 'riode_post_loop_wrapper_classes', $extra_class ) ) ) . '"' . riode_escaped( $extra_attrs ) . '>';

	$posts_cnt = 0;

	while ( $posts->have_posts() ) {
		$posts->the_post();

		if ( 'slider' == $layout_type && $row_cnt > 1 && 0 == $posts_cnt % $row_cnt ) {
			echo '<div class="posts-row">';
		}

		if ( defined( 'RIODE_PART' ) ) {
			riode_get_template_part(
				RIODE_PART . '/posts/post',
				null,
				$props
			);
		}

		if ( 'creative' == $layout_type && isset( $props['creative_idx'] ) ) {
			$props['creative_idx'] ++;
		}

		$posts_cnt ++;

		if ( 'slider' == $layout_type && $row_cnt > 1 && 0 == $posts_cnt % $row_cnt ) {
			echo '</div>';
		}
	}

	if ( 'slider' == $layout_type && $row_cnt > 1 && $posts_cnt % $row_cnt ) {
		echo '</div>';
	}

	if ( 'creative' == $layout_type ) {
		echo '<div class="grid-space"></div>';
	}

	echo '</div>';
}

if ( function_exists( 'riode_loadmore_html' ) && 'grid' == $layout_type ) {
	$settings = array();

	if ( 'button' == $loadmore_type ) {
		$settings = shortcode_atts(
			array(
				'loadmore_button_type'                => '',
				'loadmore_button_size'                => '',
				'loadmore_button_skin'                => 'btn-primary',
				'loadmore_shadow'                     => '',
				'loadmore_button_border'              => '',
				'loadmore_link_hover_type'            => '',
				'loadmore_link'                       => '',
				'loadmore_show_icon'                  => '',
				'loadmore_show_label'                 => 'yes',
				'loadmore_icon'                       => '',
				'loadmore_icon_pos'                   => 'after',
				'loadmore_icon_hover_effect'          => '',
				'loadmore_icon_hover_effect_infinite' => '',
			),
			$atts
		);
	}

	if ( 1 < $posts->max_num_pages ) {
		riode_loadmore_html( $posts, $loadmore_type, isset( $atts['loadmore_label'] ) ? $atts['loadmore_label'] : __( 'Load More', 'riode-core' ), $settings, 'loadmore_' );
	}
}

wp_reset_postdata();
