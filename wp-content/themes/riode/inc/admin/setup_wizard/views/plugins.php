<?php
defined( 'ABSPATH' ) || die;
?>
<h2><?php esc_html_e( 'Default Plugins', 'riode' ); ?></h2>
<form method="post">

	<?php
	$plugins = $this->_get_plugins();
	if ( count( $plugins['all'] ) ) {
		?>
		<p class="lead"><?php esc_html_e( 'This will install the default plugins which are used in Riode.', 'riode' ) . '<br>' . esc_html( 'Please check the plugins to install:', 'riode' ); ?></p>
		<ul class="riode-plugins">
			<?php
			$idx      = 0;
			$loadmore = false;
			foreach ( $plugins['all'] as $slug => $plugin ) {
				if ( isset( $plugin['visibility'] ) && 'optimize_wizard' == $plugin['visibility'] ) {
					continue;
				}
				$idx ++;
				?>
				<?php
				if ( $idx > 6 && ! $loadmore ) :
					?>
					<li class="separator">
						<a href="#" class="button-load-plugins"><b><?php esc_html_e( 'Load more', 'riode' ); ?></b> <i class="fas fa-chevron-down"></i></a>
					</li>
					<?php
					$loadmore = true;
				endif;
				?>
				<li data-slug="<?php echo esc_attr( $slug ); ?>"<?php echo 6 < $idx ? ' class="hidden"' : ''; ?>>
					<label class="checkbox checkbox-inline">
						<input type="checkbox" name="setup-plugin"<?php echo ! $plugin['required'] ? '' : ' checked="checked"'; ?>>
						<?php echo esc_html( $plugin['name'] ); ?>
						<span class="info">
						<?php
							$key = '';
						if ( isset( $plugins['install'][ $slug ] ) ) {
							$key = esc_html__( 'Installation', 'riode' );
						} elseif ( isset( $plugins['update'][ $slug ] ) ) {
							$key = esc_html__( 'Update', 'riode' );
						} elseif ( isset( $plugins['activate'][ $slug ] ) ) {
							$key = esc_html__( 'Activation', 'riode' );
						}
						if ( $key ) {
							if ( $plugin['required'] ) {
								/* translators: %s: Plugin name */
								printf( esc_html__( '%s required', 'riode' ), $key );
							} elseif ( isset( $plugin['seo'] ) && $plugin['seo'] ) {
								printf( esc_html__( '%s recommended for SEO.', 'riode' ), $key );
							} else {
								/* translators: %s: Plugin name */
								printf( esc_html__( '%s recommended for certain demos', 'riode' ), $key );
							}
						}
						?>
						</span>
					</label>
				</li>
				<?php if ( 'riode-core' === $plugin['slug'] ) : ?>
					<li class="separator"></li>
				<?php endif; ?>
			<?php } ?>
		</ul>
		<div class="use-multiple-editors notice-warning notice-alt notice-large" style="display: none;margin-bottom:0">
			<?php /* translators: $1 and $2 opening and closing bold tags respectively */ ?>
			<?php printf( esc_html__( 'Using %1$sseveral page builders%2$s togther affects your site performance.', 'riode' ), '<b>', '</b>' ); ?>
		</div>
		<?php
	} else {
		echo '<p class="lead">' . esc_html__( 'Good news! All plugins are already installed and up to date. Please continue.', 'riode' ) . '</p>';
	}
	?>

	<p class="riode-admin-panel-actions">
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_plugins"><?php esc_html_e( 'Continue', 'riode' ); ?></a>
		<?php wp_nonce_field( 'riode-setup-wizard' ); ?>
	</p>
</form>
