<?php
/**
 *
 * Single Page
 */

get_header();
do_action( 'riode_before_content', RIODE_BEFORE_CONTENT );
?>

<div class="page-content">

<?php
riode_get_template_part(
	RIODE_PART . '/posts/layout',
	null
);
?>

</div>

<?php
do_action( 'riode_after_content', RIODE_AFTER_CONTENT );
get_footer();
