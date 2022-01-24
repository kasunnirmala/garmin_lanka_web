<?php if ( get_the_author_meta( 'description' ) ) : ?>
<div class="post-author-detail">
	<figure class="author-avatar">
		<?php echo get_avatar( get_the_ID(), 50 ); ?>
	</figure>
	<div class="author-body">
		<div class="author-header">
			<?php
				$author_name = get_the_author_meta( 'display_name' );
				$author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
			?>
			<div class="author-meta">
				<span class="author-title"><?php echo apply_filters( 'riode_filter_author_title', esc_html( 'AUTHOR', 'riode' ) ); ?></span>
				<h4 class="author-name"><?php echo esc_html( $author_name ); ?></h4>
			</div>
			<a class="author-link" href="<?php echo esc_url( $author_link ); ?>"><?php printf( esc_html__( 'View all posts by %s', 'riode' ), esc_html( $author_name ) ); ?> <i class="d-icon-arrow-right"></i></a>
		</div>
		<p class="author-content mb-0"><?php echo riode_strip_script_tags( get_the_author_meta( 'description' ) ); ?></p>
	</div>
</div>
	<?php
endif;
