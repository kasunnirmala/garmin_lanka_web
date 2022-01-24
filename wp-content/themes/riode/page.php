<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/*
 * Default Page
 */

get_header();
do_action( 'riode_before_content', RIODE_BEFORE_CONTENT );
?>

<div class="page-content">

<?php
do_action( 'riode_print_before_page_layout' );

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		the_content();

		riode_get_page_links_html();
	}
} else {
	echo '<h2 class="entry-title">' . esc_html__( 'Nothing Found', 'riode' ) . '</h2>';
}

do_action( 'riode_print_after_page_layout' );
?>

</div>

<?php
do_action( 'riode_after_content', RIODE_AFTER_CONTENT );
get_footer();
