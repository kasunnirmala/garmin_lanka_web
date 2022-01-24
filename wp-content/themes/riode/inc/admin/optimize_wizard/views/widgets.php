<?php
defined( 'ABSPATH' ) || die;
?>
<h2><?php esc_html_e( 'Optimize Resources', 'riode' ); ?></h2>

<ul class="riode-resource-steps">
	<li class="step"><a href="#styles" class="active" data-step="1"><label><?php esc_html_e( 'Styles', 'riode' ); ?></label></a></li>
	<li class="step"><a href="#templates" data-step="2"><label><?php esc_html_e( 'Templates', 'riode' ); ?></label></a></li>
	<li class="step"><a href="#complete" data-step="3"><label><?php esc_html_e( 'Plugins', 'riode' ); ?></label></a></li>
</ul>
<form method="post" class="riode-used-elements-form">
	<div id="styles">
		<p class="lead"><?php esc_html_e( 'This will help you to optimize theme styles.', 'riode' ); ?></p>
		<p class="descripion">
			<?php esc_html_e( 'Riode comes with powerful optimization wizard for theme styles. Detailed options for used components and helper classes will optimize your site perfectly.', 'riode' ); ?>
			<br>
			<?php esc_html_e( 'All options you have been checked will be saved for next use. After you have finished development, please run this wizard.', 'riode' ); ?>
		</p>
		<p style="margin-bottom: 30px;"><?php esc_html_e( 'Please check used resources.', 'riode' ); ?></p>
		<div class="mfp-riode-page-layout"><div class="loading loading-overlay"></div></div>
		<div class="step-navs" style="margin-top: 30px;">
			<a href="#" class="button button-large button-dark prev disabled"><?php esc_html_e( 'Prev Step', 'riode' ); ?></a>
			<a href="#" class="button-primary button button-large next" data-step="2"><?php esc_html_e( 'Next Step', 'riode' ); ?></a>
		</div>
	</div>
	<div id="templates" style="display: none">
		<div class="mfp-riode-page-layout"><div class="loading loading-overlay"></div></div>
		<div class="step-navs" style="margin-top: 30px;">
			<a href="#" class="button button-large button-dark prev" data-step="1"><?php esc_html_e( 'Prev Step', 'riode' ); ?></a>
			<a href="#" class="button-primary button button-large next" data-step="3"><?php esc_html_e( 'Next Step', 'riode' ); ?></a>
		</div>
	</div>
	<div id="complete" style="display: none">

		<p style="margin-bottom: 30px"><?php esc_html_e( 'This is the last step of resource optimize. You can remove unnecessary plugin styles & scripts.', 'riode' ); ?></p>

		<label class="checkbox checkbox-inline">
			<input type="checkbox" name="resource_disable_gutenberg" <?php checked( riode_get_option( 'resource_disable_gutenberg' ) ); ?>> <strong><?php esc_html_e( 'Gutenberg', 'riode' ); ?></strong>
		</label>
		<p><?php esc_html_e( 'If any gutenberg block isn\'t used in site, check me.', 'riode' ); ?></p>

		<label class="checkbox checkbox-inline">
			<input type="checkbox" name="resource_disable_wc_blocks" <?php checked( riode_get_option( 'resource_disable_wc_blocks' ) ); ?>> <strong><?php esc_html_e( 'WooCommerce blocks for Gutenberg', 'riode' ); ?></strong>
		</label>
		<p><?php esc_html_e( 'If any WooCommerce blocks for Gutenberg isn\'t used in sites, check me.', 'riode' ); ?></p>

		<label class="checkbox checkbox-inline">
			<input type="checkbox" name="resource_disable_elementor_unused" <?php checked( riode_get_option( 'resource_disable_elementor_unused' ) ); ?>> <strong><?php esc_html_e( 'Elementor\'s Resources', 'riode' ); ?></strong>
		</label>
		<p><?php esc_html_e( 'If some elementor resources such as swiper.js are never used, check me.', 'riode' ); ?></p>

		<p class="riode-admin-panel-actions">
			<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-dark"><?php esc_html_e( 'Skip this step', 'riode' ); ?></a>
			<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="optimize_widgets"><?php esc_html_e( 'Compile & Continue', 'riode' ); ?></a>
			<?php wp_nonce_field( 'riode-setup-wizard' ); ?>
		</p>
	</div>
</form>