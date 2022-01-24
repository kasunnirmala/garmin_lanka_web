<?php
defined( 'ABSPATH' ) || die;
update_option( 'riode_setup_complete', time() );
?>
<h2 style="padding-left: 110px;"><?php esc_html_e( 'Your Website is now optimized much better than before!', 'riode' ); ?></h2>

<p class="lead success" style="margin: 0 0 30px; padding-left: 110px; max-width: 900px;"><?php esc_html_e( 'Congratulations! The Site is now much faster, better and fully optimized. Please visit your new site to notice how its performance changed.', 'riode' ); ?><a target="_blank" style="margin-left: 10px;" href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'View your new website!', 'riode' ); ?></a></p>

<i class="speed-optimize-icon fas fa-rocket"></i>

<div class="riode-setup-next-steps">
	<div class="riode-setup-next-steps-first">
		<h3 style="margin: 5px 0 0;"><?php esc_html_e( 'Leave a Comment', 'riode' ); ?></h3>
		<p style="margin: 5px 0 10px; color: #999">
		<?php
			printf(
				esc_html__(
					'Are you satisfied by Riode Optimize Wizard? If you find any bugs or any new suggestions, please %1$sleave a comment %2$s. Thank you.',
					'riode'
				),
				'<a href="#">',
				'</a>'
			);
			?>
		</p>
		<?php /* translators: opening and closing a tag */ ?>
		<p class="info-qt light-info" style="margin-top: 20px;"><?php printf( esc_html__( 'Please leave a %1$s5-star rating%2$s if you are satisfied with this theme. Thanks!', 'riode' ), '<a href="http://themeforest.net/downloads" target="_blank">', '</a>' ); ?></p>
	</div>
</div>
