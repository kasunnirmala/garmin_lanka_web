<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 *  Error 404 Page
 */
get_header();
do_action( 'riode_before_content', RIODE_BEFORE_CONTENT );
?>

<div class="page-content">

<?php
do_action( 'riode_print_before_page_layout' );

if ( riode_get_option( '404_block' ) ) {
	riode_print_template( riode_get_option( '404_block' ) );
} else {
	?>
	<div class="area_404">
		<h2 class="title mb-3 ls-m"><?php esc_html_e( 'Error 404', 'riode' ); ?></h2>
		<div class="img-area ml-auto mr-auto"></div>
		<h4 class="mt-8 mb-0 ls-m"><?php esc_html_e( 'OOOPPS.! THAT PAGE CAN’T BE FOUND.', 'riode' ); ?></h4>
		<p class="font-primary ls-m"><?php esc_html_e( 'It looks like nothing was found at this location.', 'riode' ); ?></p>
		<a href="<?php echo esc_url( home_url() ); ?>" class="btn btn-primary mb-3"><?php esc_html_e( 'Go Home', 'riode' ); ?></a>
	</div>
	<?php
}

do_action( 'riode_print_after_page_layout' );
?>

</div>

<?php
do_action( 'riode_after_content', RIODE_AFTER_CONTENT );
get_footer();
