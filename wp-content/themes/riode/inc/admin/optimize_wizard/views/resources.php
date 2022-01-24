<?php
defined( 'ABSPATH' ) || die;
?>
<h2 style="margin-bottom: 20px"><?php esc_html_e( 'Performance', 'riode' ); ?></h2>

<form method="post" class="riode_submit_form">

	<h3><?php esc_html_e( 'Mobile Performance', 'riode' ); ?></h3>
	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="mobile_disable_animation" <?php checked( riode_get_option( 'mobile_disable_animation' ) ); ?>> <?php esc_html_e( 'Disable animations on mobile', 'riode' ); ?>
	</label>
	<p><?php esc_html_e( 'All entrance and floating animations will be disabled on mobile.', 'riode' ); ?></p>
	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="mobile_disable_slider" <?php checked( riode_get_option( 'mobile_disable_slider' ) ); ?>> <?php esc_html_e( 'Disable sliders on mobile', 'riode' ); ?>
	</label>
	<p><?php esc_html_e( 'Slider feature will be disabled on mobile. Browser touch scrolling will be used instead.', 'riode' ); ?></p>

	<h3><?php esc_html_e( 'Preload Fonts', 'riode' ); ?></h3>
	<p style="margin-bottom: .5rem">
		<?php /* translators: Google Page Speed url */ ?>
		<?php printf( esc_html__( 'This improves page load time as the browser caches preloaded resources so they are available immediately when needed. By using this option, you can increase page speed about 1 ~ 4 percent in %1$sGoogle PageSpeed Insights%2$s for both of mobile and desktop.', 'riode' ), '<a href="https://developers.google.com/speed/pagespeed/insights/" target="_blank">', '</a>' ); ?>
	</p>
	<p>
		<label class="checkbox checkbox-inline">
		<?php
			$preload_fonts = riode_get_option( 'preload_fonts' );
		if ( empty( $preload_fonts ) ) {
			$preload_fonts = array();
		}
		?>
			<input type="checkbox" value="riode" name="preload_fonts[]" <?php checked( in_array( 'riode', $preload_fonts ) ); ?>> <?php esc_html_e( 'Riode Icons', 'riode' ); ?>
		</label>&nbsp;
		<label class="checkbox checkbox-inline">
			<input type="checkbox" value="fas" name="preload_fonts[]" <?php checked( in_array( 'fas', $preload_fonts ) ); ?>> <?php esc_html_e( 'Font Awesome 5 Solid', 'riode' ); ?>
		</label>&nbsp;
		<label class="checkbox checkbox-inline">
			<input type="checkbox" value="far" name="preload_fonts[]" <?php checked( in_array( 'far', $preload_fonts ) ); ?>> <?php esc_html_e( 'Font Awesome 5 Regular', 'riode' ); ?>
		</label>&nbsp;
		<label class="checkbox checkbox-inline">
			<input type="checkbox" value="fab" name="preload_fonts[]" <?php checked( in_array( 'fab', $preload_fonts ) ); ?>> <?php esc_html_e( 'Font Awesome 5 Brands', 'riode' ); ?>
		</label>&nbsp;
		<br>
		<br>
		<label><?php esc_html_e( 'Please input other resources that will be pre loaded. Ex. https://d-themes.com/wordpress/riode/wp-content/themes/riode-child/fonts/custom.woff2.', 'riode' ); ?></label>
		<textarea class="form-control input-text" name="preload_fonts_custom" style="width: 100%; margin-top: .4rem" rows="4" value="<?php echo isset( $preload_fonts['custom'] ) ? esc_attr( $preload_fonts['custom'] ) : ''; ?>"><?php echo isset( $preload_fonts['custom'] ) ? esc_html( $preload_fonts['custom'] ) : ''; ?></textarea>
	</p>

	<h3><?php esc_html_e( 'Asynchronous Scripts', 'riode' ); ?></h3>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="resource_async_js" <?php checked( riode_get_option( 'resource_async_js' ) ); ?>> <?php esc_html_e( 'Asynchronous load', 'riode' ); ?>
	</label>
	<p><?php esc_html_e( 'Some javascript libraries does not affect first paint. And you can increase page loading speed by loading them asynchronously.', 'riode' ); ?></p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="resource_split_tasks" <?php checked( riode_get_option( 'resource_split_tasks' ) ); ?>> <?php esc_html_e( 'Split tasks', 'riode' ); ?>
	</label>
	<p><?php esc_html_e( 'Long time tasks may cause unintentional rendering suspension or affect to its performance. To make pages faster, please check split task option.', 'riode' ); ?></p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="resource_idle_run" <?php checked( riode_get_option( 'resource_idle_run' ) ); ?>> <?php esc_html_e( 'Only necessary JS at loading', 'riode' ); ?>
	</label>
	<p><?php esc_html_e( 'While page is loaded, there exists a lot of unnecessary javascripts running during initialization. If they works in idle time and only necessary ones runs while loading time, page speed will be faster.', 'riode' ); ?></p>

	<label class="checkbox checkbox-inline">
		<input type="checkbox" name="resource_after_load" <?php checked( riode_get_option( 'resource_after_load' ) ); ?>> <?php esc_html_e( 'Process after load event', 'riode' ); ?>
	</label>
	<p><?php esc_html_e( 'This will accelerate page\'s load time. But this may cause compatibility issue since page still not be ready. It will be in ready state after document or window load event is ready. To fix this problem, Please add event handlers to window\'s "riode_complete" event.', 'riode' ); ?></p>

	<p class="riode-admin-panel-actions">
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-dark"><?php esc_html_e( 'Skip this step', 'riode' ); ?></a>
		<button type="submit" class="button-primary button button-large button-next" name="save_step"><?php esc_html_e( 'Save & Continue', 'riode' ); ?></button>
		<input type="hidden" name="css_js" id="css_js" value="<?php echo checked( riode_get_option( 'minify_css_js' ), true, false ) ? 'true' : 'false'; ?>">
		<input type="hidden" name="font_icons" id="font_icons" value="<?php echo checked( riode_get_option( 'minify_font_icons' ), true, false ) ? 'true' : 'false'; ?>">
		<?php wp_nonce_field( 'riode-setup-wizard' ); ?>
	</p>
</form>
