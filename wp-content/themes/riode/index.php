<?php
/**
 *
 * This file is called when nothing more specific matches a query.
 */

$only_posts = riode_doing_ajax() && isset( $_GET['only_posts'] );

if ( ! $only_posts ) {
	get_header();
	do_action( 'riode_before_content', RIODE_BEFORE_CONTENT );
	echo '<div class="page-content">';
} else {
	riode_print_title_bar();
}

riode_get_template_part(
	RIODE_PART . '/posts/layout',
	null
);

if ( ! $only_posts ) {
	echo '</div>';
	do_action( 'riode_after_content', RIODE_AFTER_CONTENT );
	get_footer();
}
