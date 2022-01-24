<?php
/**
 * The template for displaying comments.
 */

if ( post_password_required() ) {
	return;
}

if ( ! comments_open() && get_comments_number() < 1 ) {
	return;
}

?>

<div id="comments" class="comments">
	<?php
	$comments_count = number_format_i18n( get_comments_number() );
	$title          = ( $comments_count ? $comments_count : esc_html__( 'No', 'riode' ) ) . ' ' . ( 1 == $comments_count ? esc_html__( 'Comment', 'riode' ) : esc_html__( 'Comments', 'riode' ) );
	$title          = apply_filters( 'riode_comments_title', $title );

	?>
	<h3 class="title title-simple"><?php echo riode_strip_script_tags( $title ); ?></h3>
	<?php

	if ( have_comments() ) :
		?>
		<ol class="commentlist">
			<?php
			// List comments
			wp_list_comments(
				apply_filters(
					'riode_filter_comment_args',
					array(
						'callback'   => 'riode_post_comment',
						'style'      => 'ol',
						'format'     => 'html5',
						'short_ping' => true,
					)
				)
			);
			?>
		</ol>

		<?php
		// Are there comments to navigate through?
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
			$page = get_query_var( 'cpage' );
			if ( ! $page ) {
				$page = 1;
			}
			$max_page = get_comment_pages_count();

			$new_args = array(
				'base'         => add_query_arg( 'cpage', '%#%' ),
				'add_fragment' => '#comments',
			);

			echo riode_get_pagination_html( $page, $max_page, '', $new_args );
		}

		if ( ! comments_open() && get_comments_number() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'riode' ); ?></p>
			<?php
		endif;
	endif;
	?>
</div>

<?php
if ( comments_open() ) {
	comment_form( apply_filters( 'riode_filter_comment_form_args', array() ) );
}
