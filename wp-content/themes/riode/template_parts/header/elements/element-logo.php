<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-logo.php
 */

$logo_id    = riode_get_option( 'custom_logo' );
$site_title = get_bloginfo( 'name', 'display' );

?>

<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" title="<?php echo esc_attr( $site_title ); ?> - <?php bloginfo( 'description' ); ?>">
	<?php echo wp_get_attachment_image( $logo_id, isset( $logo_size ) ? $logo_size : 'full', false, array( 'alt' => esc_attr( $site_title ) ) ); ?>
</a>
