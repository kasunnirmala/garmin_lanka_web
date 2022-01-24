<?php
global $post;

if ( ! $single && ! $related && ! $widget && 'creative' == riode_get_option( 'post_grid' ) ) {
	$image_size = 'large';
}

if ( 'video' == get_post_format() && get_post_meta( $post->ID, 'featured_video' ) && ! in_array( $type, array( 'widget', 'mask', 'mask gradient' ) ) ) :

	wp_enqueue_script( 'jquery-fitvids' );

	$video_code = get_post_meta( $post->ID, 'featured_video', true );
	if ( false !== strpos( $video_code, '[video src="' ) && has_post_thumbnail() ) {
		$video_code = str_replace( '[video src="', '[video poster="' . esc_url( get_the_post_thumbnail_url( null, 'full' ) ) . '" src="', $video_code );
	}
	?>
	<figure class="post-media fit-video">
		<?php echo do_shortcode( $video_code ); ?>
	</figure>
	<?php
else :
	if ( 'attachment' == get_post_type() ) {
		$featured_id = get_the_ID();
	} else {
		$featured_id = get_post_thumbnail_id();
	}

	// get supported images of the post
	$image_ids = get_post_meta( $post->ID, 'supported_images' );
	if ( $featured_id ) {
		$image_ids = array_merge( array( $featured_id ), $image_ids );
	}

	if ( count( $image_ids ) ) :
		if ( count( $image_ids ) > 1 && 'large' == $image_size ) :
			$col_cnt = riode_get_responsive_cols( array( 'lg' => 1 ) );

			$attrs = array( 'col_sp' => 'no' );

			if ( in_array( $type, array( 'mask', 'mask gradient' ) ) ) {
				$attrs['show_dots']        = 'no';
				$attrs['show_dots_tablet'] = 'no';
				$attrs['show_dots_mobile'] = 'no';
			}
			?>
		<div class="post-media-carousel owl-dot-white 
			<?php
			echo riode_get_col_class( $col_cnt ) . ' ' . riode_get_slider_class(
				array(
					'dots_pos' => 'inner',
				)
			);
			?>
			" data-plugin="owl" data-owl-options="
			<?php
			echo esc_attr(
				json_encode(
					riode_get_slider_attrs(
						$attrs,
						$col_cnt
					)
				)
			);
			?>
		">
			<?php
		else :
			$image_ids = array( $image_ids[0] );
		endif;
		foreach ( $image_ids as $id ) :
			?>
			<figure class="post-media">
				<?php if ( ! $single || $related ) : ?>
				<a href="<?php the_permalink(); ?>">
				<?php endif; ?>
				<?php
					set_post_thumbnail( $post, $id );
				if ( 'custom' == $image_size && isset( $image_custom_size ) ) {
					the_post_thumbnail( $image_custom_size );
				} else {
					the_post_thumbnail( $image_size );
				}
				?>
				<?php if ( ! $single || $related ) : ?>
				</a> 
				<?php endif; ?>
				<?php
				if ( isset( $show_datebox ) && $show_datebox ) {
					get_template_part( RIODE_PART . '/posts/elements/post-date-in-media' );
				}
				// Caption  added (925)
				$caption = get_the_post_thumbnail_caption();
				if ( $caption ) {
					?>
				<div class="thumbnail-caption">
					<?php echo riode_strip_script_tags( $caption ); ?>
				</div>
					<?php
				}
				?>
			</figure>
			<?php
		endforeach;
		if ( count( $image_ids ) > 1 ) :
			?>
		</div>
			<?php
		endif;
		delete_post_meta( $post->ID, '_thumbnail_id' );
		set_post_thumbnail( $post, $featured_id );
	else :
		if ( 'widget' == $type ) {
			get_template_part( RIODE_PART . '/posts/elements/post-date-in-media' );
		}

		/*
		<figure class="post-media no-image text-center">
			<h4>No Featured Media</h4>
		</figure>*/
	endif;
endif;
