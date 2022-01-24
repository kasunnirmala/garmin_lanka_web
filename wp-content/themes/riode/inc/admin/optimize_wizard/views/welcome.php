<?php
defined( 'ABSPATH' ) || die;
?>
<?php /* translators: %s: Theme name */ ?>
<h2><?php printf( esc_html__( 'Welcome to the optimize wizard for %s.', 'riode' ), wp_get_theme() ); ?></h2>

<?php
if ( get_option( 'riode_optimize_complete', false ) ) {
	?>
	<p class="lead success"><?php esc_html_e( 'It looks like you have already optimized your site.', 'riode' ); ?></p>

	<p class="riode-admin-panel-actions">
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-next button-large"><?php esc_html_e( 'Run Optimize Wizard Again', 'riode' ); ?></a>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=riode' ) ); ?>" class="button button-large"><?php esc_html_e( 'Exit to Riode Panel', 'riode' ); ?></a>
	</p>
	<?php
} else {
	?>
	<?php /* translators: %s: Theme name */ ?>
	<p class="lead"><?php printf( esc_html__( 'This Optimize Wizard is introduced to optimize all resources that are unnecessary for your site. Every step has enough description about how it works. Some options may produce some conflicts if your site is still in development progress, so we advise you to enable all options once site development is completed.', 'riode' ), wp_get_theme() ); ?></p>
	<p><span class="info-qt"><?php esc_html_e( 'No time right now? ', 'riode' ); ?></span><?php esc_html_e( 'If you don\'t want to go through the wizard, you can skip and return to the WordPress dashboard. Come back anytime you want!', 'riode' ); ?></p>
	<p class="riode-admin-panel-actions">
		<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>" class="button button-large button-dark"><?php esc_html_e( 'Not right now', 'riode' ); ?></a>
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next"><?php esc_html_e( "Let's Go", 'riode' ); ?></a>
	</p>
	<?php
}
