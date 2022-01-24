<?php
/*
 * Single Post
 */
?>

<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'riode_post_single_class', array( 'post-single' ) ) ) ); ?> <?php echo esc_attr(is_sticky() ? 'sticky-post' : ''); ?>">

<?php

$single_info_items = riode_get_option( 'post_show_info' );
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		riode_get_template_part( RIODE_PART . '/posts/post', null, array( 'single' => true ) );

		if ( in_array( 'navigation', $single_info_items ) ) {
			get_template_part( RIODE_PART . '/posts/elements/post-navigation' );
		}

		if ( in_array( 'related', $single_info_items ) ) {
			get_template_part( RIODE_PART . '/posts/elements/post-related' );
		}
	}
}

if ( in_array( 'comments_list', $single_info_items ) ) {
	comments_template();
}
?>

</div>
