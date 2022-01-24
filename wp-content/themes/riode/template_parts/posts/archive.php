<?php
/*
 * Post Archive
 */
?>

<div class="post-archive">

	<?php
	global $wp_query;

	if ( have_posts() ) {
		$show_filter  = apply_filters( 'riode_post_show_filter', riode_get_option( 'post_show_filter' ) );
		$post_grid    = apply_filters( 'riode_post_grid', riode_get_option( 'post_grid' ) );
		$isotope      = $show_filter || ( 'creative' === $post_grid );
		$wrap_classes = array( 'posts' );
		$wrap_attrs   = '';

		$type = apply_filters( 'riode_post_type', riode_get_option( 'post_type' ) );

		if ( 'list' == $type ) {
			$wrap_classes[] = 'list-type-posts';
		}

		if ( $isotope ) {
			wp_enqueue_script( 'isotope-pkgd' );
		}

		if ( $show_filter ) {

			$terms   = get_terms(
				array(
					'taxonomy'   => 'category',
					'hide_empty' => true,
					'count'      => true,
					'pad_counts' => true,
				)
			);
			$cur_cat = get_query_var( 'category_name' );

			$count_posts = ( wp_count_posts() );
			if ( isset( $count_posts->publish ) ) {
				$count_posts = (int) $count_posts->publish;
			}

			$blog_url = get_option( 'page_for_posts' );
			if ( $blog_url ) {
				$blog_url = esc_url( get_post_permalink( $blog_url ) );
			} else {
				$blog_url = get_home_url();
			}

			echo '<ul class="nav-filters filter-underline blog-filters" data-target=".posts">
				<li><a href="' . $blog_url . '" class="nav-filter blog-filter' . ( $cur_cat ? '' : ' active' ) . '" data-filter="*">' . esc_html__( 'All', 'riode' ) . '</a><span>' . (int) $count_posts . '</span></li>';

			foreach ( $terms as $term ) {
				echo '<li>';
				echo '<a href="' . esc_url( get_term_link( $term ) ) . '" class="nav-filter blog-filter' . ( $cur_cat == $term->slug ? ' active' : '' ) . '" data-cat="' . (int) $term->term_id . '" data-filter=".' . esc_attr( $term->slug ) . '">';
				echo esc_html( $term->name ) . '</a><span>' . intval( $term->count ) . '</span>';
				echo '</li>';
			}

			echo '</ul>';
		}

		if ( 'grid' == $post_grid && $show_filter ) {
			$wrap_attrs = " data-grid-options='" . json_encode( array( 'layoutMode' => 'fitRows' ) ) . "'";
		} elseif ( 'creative' == $post_grid ) {
			$wrap_attrs = " data-grid-options='" . json_encode( array( 'masonry' => array( 'horizontalOrder' => true ) ) ) . "'";
		}

		if ( $isotope ) {
			$wrap_classes[] = 'grid masonry';
		}
		$wrap_classes[] = riode_get_col_class(
			'list' != $type ? riode_get_responsive_cols(
				array(
					'lg'  => intval( apply_filters( 'riode_post_count_row', riode_get_option( 'post_count_row' ) ) ),
					'md'  => 2,
					'sm'  => 2,
					'min' => 1,
				)
			) : array(
				'md'  => 1,
				'sm'  => 2,
				'min' => 1,
			)
		);

		$wrap_classes = apply_filters( 'riode_post_loop_wrapper_classes', $wrap_classes );

		// Loadmore Button or Pagination
		if ( 1 < $wp_query->max_num_pages ) {
			if ( 'scroll' == riode_get_option( 'post_loadmore_type' ) ) {
				$wrap_classes[] = 'load-scroll';
			}
			$wrap_attrs .= ' ' . riode_loadmore_attributes( '', array( 'blog' => true ), 'page', $wp_query->max_num_pages );
		}

		// Print Posts
		echo '<div class="' . esc_attr( implode( ' ', $wrap_classes ) ) . '"' . $wrap_attrs . '>';

		while ( have_posts() ) :
			the_post();
			riode_get_template_part(
				RIODE_PART . '/posts/post',
				null,
				array(
					'single' => false,
				)
			);
		endwhile;

		if ( $isotope ) {
			echo '<div class="grid-space"></div>';
		}

		echo '</div>';

		// Loadmore Button or Pagination
		if ( 1 < $wp_query->max_num_pages ) {
			riode_loadmore_html( $wp_query, riode_get_option( 'post_loadmore_type' ), riode_get_option( 'loadmore_label' ) );
		}
	} else {
		echo '<h2 class="entry-title">' . esc_html__( 'Nothing Found', 'riode' ) . '</h2>';
		echo '<p class="entry-desc">' . esc_html__( 'Sorry, I am afraid you do not have any matches. Please try again with other keywords.', 'riode' ) . '</p>';
	}

	?>
</div>
