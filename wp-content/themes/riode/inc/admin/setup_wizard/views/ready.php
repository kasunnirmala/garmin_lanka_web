<?php
defined( 'ABSPATH' ) || die;
update_option( 'riode_setup_complete', time() );
?>
<h2><?php esc_html_e( 'Your Website is Ready!', 'riode' ); ?></h2>

<p class="lead"><?php esc_html_e( 'Congratulations! The theme has been activated and your website is ready. Please go to your WordPress dashboard to make changes and modify the content for your needs.', 'riode' ); ?></p>

<p><?php esc_html_e( 'This theme comes with 6 months item support from purchase date (with the option to extend this period). This license allows you to use this theme on a single website. Please purchase an additional license to use this theme on another website.', 'riode' ); ?></p>
<div class="riode-admin-panel-row">
	<div class="riode-support">
		<?php /* translators: $1 and $2 opening and closing strong tags respectively */ ?>
		<h4 class="success system-status"><i class="circle fa fa-check"></i> <?php printf( esc_html__( 'Item Support %1$sDOES%2$s Include:', 'riode' ), '<strong class="success">', '</strong>' ); ?></h4>

		<ul class="list">
			<li><?php esc_html_e( 'Availability of the author to answer questions', 'riode' ); ?></li>
			<li><?php esc_html_e( 'Answering technical questions about item features', 'riode' ); ?></li>
			<li><?php esc_html_e( 'Assistance with reported bugs and issues', 'riode' ); ?></li>
			<li><?php esc_html_e( 'Help with bundled 3rd party plugins', 'riode' ); ?></li>
		</ul>
	</div>
	<div class="riode-support">
		<?php /* translators: $1 and $2 opening and closing strong tags respectively */ ?>
		<h4 class="error system-status"><i class="circle fas fa-ban"></i> <?php printf( esc_html__( 'Item Support %1$sDOES NOT%2$s Include:', 'riode' ), '<strong class="error">', '</strong>' ); ?></h4>
		<ul class="list">
			<li><?php printf( esc_html__( 'Customization services (this is available through %1$sptheme.customize@gmail.com%2$s)', 'riode' ), '<a href="mailto:ptheme.customize@gmail.com">', '</a>' ); ?></li>
			<li><?php printf( esc_html__( 'Installation services (this is available through %1$sptheme.customize@gmail.com%2$s)', 'riode' ), '<a href="mailto:ptheme.customize@gmail.com">', '</a>' ); ?></li>
			<li><?php esc_html_e( 'Help and Support for non-bundled 3rd party plugins (i.e. plugins you install yourself later on)', 'riode' ); ?></li>
		</ul>
	</div>
</div>
<?php /* translators: $1 and $2 opening and closing anchor tags respectively */ ?>
<p class="info-qt light-info"><?php printf( esc_html__( 'More details about item support can be found in the ThemeForest %1$sItem Support Policy%2$s.', 'riode' ), '<a href="http://themeforest.net/page/item_support_policy" target="_blank">', '</a>' ); ?></p>
<br>
<div class="riode-setup-next-steps">
	<div class="riode-setup-next-steps-first">
		<h4><?php esc_html_e( 'More Resources', 'riode' ); ?></h4>
		<ul style="margin-bottom:40px;">
			<li class="documentation"><a href="https://d-themes.com/wordpress/riode/documentation"><?php esc_html_e( 'Riode Documentation', 'riode' ); ?></a></li>
			<li class="woocommerce documentation"><a href="https://docs.woocommerce.com/document/woocommerce-101-video-series/"><?php esc_html_e( 'Learn how to use WooCommerce', 'riode' ); ?></a></li>
			<li class="howto" style="font-style: normal;"><a href="https://wordpress.org/support/"><?php esc_html_e( 'Learn how to use WordPress', 'riode' ); ?></a></li>
			<li class="rating"><a href="http://themeforest.net/downloads"><?php esc_html_e( 'Leave an Item Rating', 'riode' ); ?></a></li>
		</ul>
		<?php /* translators: $1 and $2 opening and closing anchor tags respectively */ ?>
		<p class="info-qt light-info"><?php printf( esc_html__( 'Please come back and leave a %1$s5-star rating%2$s if you are happy with this theme. Thanks!', 'riode' ), '<a href="http://themeforest.net/downloads" target="_blank">', '</a>' ); ?></p>
	</div>
	<div class="riode-admin-panel-actions">
		<a class="button button-large button-primary button-next" href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'View your new website!', 'riode' ); ?></a>
	</div>
</div>
