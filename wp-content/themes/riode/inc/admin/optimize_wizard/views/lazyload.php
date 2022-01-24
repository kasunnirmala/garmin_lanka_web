<?php
defined( 'ABSPATH' ) || die;
?>
<h2><?php esc_html_e( 'Lazyload', 'riode' ); ?></h2>
<form method="post" class="riode_submit_form">
	<p class="lead"><?php esc_html_e( 'This will help you make your site faster by lazyloading images and contents.', 'riode' ); ?></p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="lazyload" <?php checked( riode_get_option( 'lazyload' ) ); ?>> <?php esc_html_e( 'Lazyload Images', 'riode' ); ?>
	</label>
	<p style="margin-top:5px; margin-bottom: 5px;"><?php echo sprintf( esc_html__( 'All image resources will be lazyloaded so that page loading speed gets faster. More options are available %1$shere%2$s', 'riode' ), '<a href="' . wp_customize_url() . '#performance" data-target="performance" data-type="section" target="_blank">', '</a>' ); ?></p>
	<p class="info-qt light-info" style="margin-top: 0; margin-bottom: 15px;"><?php esc_html_e( 'Use with caution! Disable this option if you have any compability problems.', 'riode' ); ?></p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="lazyload_menu" <?php checked( riode_get_option( 'lazyload_menu' ) ); ?>> <?php esc_html_e( 'Lazyload Menus', 'riode' ); ?>
	</label>
	<p style="margin-top:5px; margin-bottom: 5px;"><?php esc_html_e( 'Menus will be lazyloaded and cached in browsers for faster load.', 'riode' ); ?></p>
	<p style="margin-top:5px; margin-bottom: 15px;"><?php esc_html_e( 'Cached menus will be updated after they have been changed or customizer panel has been saved.', 'riode' ); ?></p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="skeleton" <?php checked( riode_get_option( 'skeleton_screen' ) ); ?>> <?php esc_html_e( 'Skeleton Screen', 'riode' ); ?>
	</label>
	<p style="margin-top:5px;margin-bottom:15px;"><?php echo sprintf( esc_html__( 'Instead of real content, skeleton is used to enhance speed of page loading and makes it more beautiful. More options are available %1$shere%2$s', 'riode' ), '<a href="' . wp_customize_url() . '#performance" data-target="performance" data-type="section" target="_blank">', '</a>' ); ?></p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="webfont" <?php checked( riode_get_option( 'google_webfont' ) ); ?>> <?php esc_html_e( 'Enable Web Font Loader', 'riode' ); ?>
	</label>
	<p style="margin-top: 5px; margin-bottom: 15px;">
	<?php
		printf(
			/* translators: %s values are docs urls */
			esc_html__( 'Using %1$sWeb Font Loader%2$s, you can enhance page loading speed by about 4 percent in %3$sGoogle PageSpeed Insights%4$s for both mobile and desktop.', 'riode' ),
			'<a href="https://developers.google.com/fonts/docs/webfont_loader" target="_blank">',
			'</a>',
			'<a href="https://developers.google.com/speed/pagespeed/insights/" target="_blank">',
			'</a>'
		);
		?>
	</p>

	<p class="riode-admin-panel-actions">
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-dark"><?php esc_html_e( 'Skip this step', 'riode' ); ?></a>
		<button type="submit" class="button-primary button button-large button-next" name="save_step" /><?php esc_html_e( 'Save & Continue', 'riode' ); ?></button>
		<?php wp_nonce_field( 'riode-setup-wizard' ); ?>
	</p>
</form>
