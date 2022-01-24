<?php
if ( ! isset( $args ) ) {
	$args = array();
}

if ( 'attachment' == get_post_type() ) {
	$related_posts = '';
} else {
	$args = wp_parse_args(
		$args,
		array(
			'post__not_in'        => array( get_the_ID() ),
			'ignore_sticky_posts' => 0,
			'category__in'        => wp_get_post_categories( get_the_ID() ),
			'posts_per_page'      => riode_get_option( 'post_related_count' ),
			'orderby'             => riode_get_option( 'post_related_orderby' ),
			'orderway'            => riode_get_option( 'post_related_orderway' ),
		)
	);

	$related_posts = new WP_Query( apply_filters( 'riode_filter_related_posts_args', $args ) );
}

if ( $related_posts && $related_posts->have_posts() ) :
	?>

<section class="related-posts">
	<h3 class="title title-simple"><?php esc_html_e( 'Related Posts', 'riode' ); ?></h3>
	<?php
		$col_cnt = riode_get_responsive_cols( array( 'lg' => riode_get_option( 'post_related_per_row' ) ), 'post' );
	?>
	<div class="<?php echo riode_get_col_class( $col_cnt ) . ' ' . riode_get_slider_class(); ?>" data-plugin="owl" data-owl-options="
	<?php
	echo esc_attr(
		json_encode(
			riode_get_slider_attrs( array( 'autoheight' => 'yes' ), $col_cnt )
		)
	);
	?>
	">
	<?php

	while ( $related_posts->have_posts() ) :
		$related_posts->the_post();
		riode_get_template_part( RIODE_PART . '/posts/post', null, array( 'related' => true ) );
		endwhile;

	wp_reset_postdata();
	?>
	</div>
</section>

	<?php
	endif;
