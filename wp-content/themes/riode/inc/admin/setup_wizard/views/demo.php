<?php
defined( 'ABSPATH' ) || die;
?>
<div class="riode-admin-panel-row">
	<div class="riode-setup-demo-header">
		<h2><?php esc_html_e( 'Demo Content Installation', 'riode' ); ?></h2>
		<p class="lead"><?php esc_html_e( 'In this step you can upload your logo and select a demo from the list.', 'riode' ); ?></p>
	</div>
	<table class="logo-select">
		<tr>
			<td>
				<label><?php esc_html_e( 'Your Logo:', 'riode' ); ?></label>
			</td>
			<td>
				<button id="current-logo" class="button button-upload">
				<?php
					$image_url  = riode_get_option( 'site_logo' );
					$logo_width = riode_get_option( 'logo_width' );

					$image_url  = $image_url ? $image_url : RIODE_URI . '/assets/images/logo.png';
					$logo_width = $logo_width ? $logo_width : 163;

				if ( $image_url ) {
					$image = '<img class="site-logo" src="%s" alt="%s" style="max-width:%spx; height:auto" />';
					printf( $image, esc_url( $image_url ), get_bloginfo( 'name' ), intval( $logo_width ) );
				}
				?>
				</button>
			</td>
		</tr>
	</table>
</div>

<div class="riode-remove-demo-title<?php echo empty( get_option( 'riode_demo_history', array() ) ) ? ' mfp-hide' : ''; ?>">
	<h3 style="margin-top: 0"><?php esc_html_e( 'Remove all installed demo contents', 'riode' ); ?></h3>
	<p style="margin-bottom: 30px;"><a href="#" class="button button-large button-dark btn-remove-demo-contents"><?php esc_html_e( 'Remove Content', 'riode' ); ?><i class="far fa-trash-alt" style="margin-<?php echo is_rtl() ? 'right' : 'left'; ?>: .5rem"></i></a></p>
</div>

<div class="riode-remove-demo mfp-hide">
	<div class="riode-install-demo-header">
		<h2><span class="riode-mini-logo"></span><?php esc_html_e( 'Demo Contents Remove', 'riode' ); ?></h2>
	</div>
	<div class="riode-install-section riode-wrap" style="margin: 30px 20px; border: none;">
		<div style="flex: 0 0 40%; max-width: 40%; box-sizing: border-box;">
			<label><input type="checkbox" value="" checked="checked"/> <?php esc_html_e( 'All', 'riode' ); ?></label>
			<label><input type="checkbox" value="page" checked="checked"/> <?php esc_html_e( 'Pages', 'riode' ); ?></label>
			<label><input type="checkbox" value="post" checked="checked"/> <?php esc_html_e( 'Posts', 'riode' ); ?></label>
			<label><input type="checkbox" value="attachment" checked="checked"/> <?php esc_html_e( 'Attachments', 'riode' ); ?></label>
			<label><input type="checkbox" value="product" checked="checked"/> <?php esc_html_e( 'Products', 'riode' ); ?></label>
			<label><input type="checkbox" value="riode_template" checked="checked"/> <?php esc_html_e( 'Builders', 'riode' ); ?></label>
			<label><input type="checkbox" value="widgets" checked="checked"/> <?php esc_html_e( 'Widgets', 'riode' ); ?></label>
			<label><input type="checkbox" value="options" checked="checked"/> <?php esc_html_e( 'Theme Options', 'riode' ); ?></label>
		</div>
		<div style="flex: 0 0 60%; max-width: 60%;  box-sizing: border-box;">
			<div class="notice-warning notice-alt" style="padding: 1rem; margin-bottom: 1.5rem; border-radius: 3px;"><?php esc_html_e( 'Please backup your site before uninstalling. All imported and overriden contents from Riode demos would be removed.', 'riode' ); ?></div>
			<div class="remove-status" style="width: 100%"></div>
			<button class="button button-primary button-large" <?php disabled( empty( get_option( 'riode_demo_history', array() ) ) ); ?> style="width: 100%"><i class="far fa-trash-alt" style="margin-right: .5rem"></i><?php esc_html_e( 'Uninstall', 'riode' ); ?></button>
		</div>
	</div>
</div>

<h3 style="margin-bottom: 0;"><?php esc_html_e( 'Select Demo', 'riode' ); ?></h3>
<form method="post" class="riode-install-demos">
	<input type="hidden" id="current_site_link" value="<?php echo esc_url( home_url() ); ?>">
	<?php
	$demos               = $this->riode_demo_types();
	$memory_limit        = wp_convert_hr_to_bytes( @ini_get( 'memory_limit' ) );
	$riode_plugins_obj   = new Riode_TGM_Plugins();
	$required_plugins    = $riode_plugins_obj->get_plugins_list();
	$uninstalled_plugins = array();
	$all_plugins         = array();

	foreach ( $required_plugins as $plugin ) {
		if ( is_plugin_inactive( $plugin['url'] ) ) {
			$uninstalled_plugins[ $plugin['slug'] ] = $plugin;
		}
		$all_plugins[ $plugin['slug'] ] = $plugin;
	}
	$time_limit    = ini_get( 'max_execution_time' );
	$server_status = $memory_limit >= 268435456 && ( $time_limit >= 600 || 0 == $time_limit );
	?>

	<div class="riode-install-demo mfp-hide">
		<div class="riode-install-demo-header">
			<h2><span class="riode-mini-logo"></span><?php esc_html_e( 'Demo Import', 'riode' ); ?></h2>
		</div>
		<div class="riode-install-demo-row">
			<div class="theme" style="width: 100%;">
				<div class="theme-wrapper">
					<a class="theme-link" href="#" target="_blank">
						<img class="theme-screenshot" src="#">
					</a>
				</div>
			</div>
			<div class="theme-import-panel">
				<div id="import-status">
					<div class="riode-installing-options">
						<div class="riode-import-options"><span class="riode-loading"></span><?php esc_html_e( 'Import theme options', 'riode' ); ?></div>
						<div class="riode-reset-menus"><span class="riode-loading"></span><?php esc_html_e( 'Reset menus', 'riode' ); ?></div>
						<div class="riode-reset-widgets"><span class="riode-loading"></span><?php esc_html_e( 'Reset widgets', 'riode' ); ?></div>
						<div class="riode-import-dummy"><span class="riode-loading"></span><?php esc_html_e( 'Import dummy content', 'riode' ); ?> <span></span></div>
						<div class="riode-import-widgets"><span class="riode-loading"></span><?php esc_html_e( 'Import widgets', 'riode' ); ?></div>
						<div class="riode-import-subpages"><span class="riode-loading"></span><?php esc_html_e( 'Import subpages', 'riode' ); ?></div>
					</div>
					<p class="import-result"></p>
				</div>
				<div id="riode-install-options" class="riode-install-options">
					<?php if ( Riode_Admin::get_instance()->is_registered() ) : ?>
						<div class="riode-install-editors">
							<label for="riode-elementor-demo" class="d-none">
								<input type="radio" id="riode-elementor-demo" name="riode-import-editor" value="elementor" checked="checked">
								<img src="<?php echo esc_url( RIODE_URI . '/assets/images/studio/elementor.jpg' ); ?>" alt="Elementor" title="Elementor">
							</label>
							<label for="riode-js_composer-demo" class="d-none">
								<input type="radio" id="riode-js_composer-demo" name="riode-import-editor" value="js_composer">
								<img src="<?php echo esc_url( RIODE_URI . '/assets/images/studio/wpbakery.jpg' ); ?>" alt="WPBakery Page Builder" title="WPBakery Page Builder">
							</label>
						</div>
					<div class="riode-install-section">
						<div class="riode-install-options-section">
							<h3><?php esc_html_e( 'Select Content to Import', 'riode' ); ?></h3>
							<label for="riode-import-options"><input type="checkbox" id="riode-import-options" value="1" checked="checked"/> <?php esc_html_e( 'Import theme options', 'riode' ); ?></label>
							<input type="hidden" id="riode-install-demo-type" value="landing"/>
							<label for="riode-reset-menus"><input type="checkbox" id="riode-reset-menus" value="1" checked="checked"/> <?php esc_html_e( 'Reset menus', 'riode' ); ?></label>
							<label for="riode-reset-widgets"><input type="checkbox" id="riode-reset-widgets" value="1" checked="checked"/> <?php esc_html_e( 'Reset widgets', 'riode' ); ?></label>
							<label for="riode-import-dummy"><input type="checkbox" id="riode-import-dummy" value="1" checked="checked"/> <?php esc_html_e( 'Import dummy content', 'riode' ); ?></label>
							<label for="riode-import-widgets"><input type="checkbox" id="riode-import-widgets" value="1" checked="checked"/> <?php esc_html_e( 'Import widgets', 'riode' ); ?></label>
							<label for="riode-override-contents"><input type="checkbox" id="riode-override-contents" value="1" checked="checked" /> <?php esc_html_e( 'Override existing contents', 'riode' ); ?></label>
							<label for="riode-import-subpages"><input type="checkbox" id="riode-import-subpages" value="1" checked="checked" /> <?php esc_html_e( 'Import subpages', 'riode' ); ?></label>
						</div>
						<div>
						<p style="margin-top: 0;"><?php esc_html_e( 'Do you want to install demo? It can also take a minute to complete.', 'riode' ); ?></p>
						<button class="btn <?php echo ! $server_status ? 'btn-quaternary' : 'btn-primary'; ?> riode-import-yes"<?php echo ! $server_status ? ' disabled="disabled"' : ''; ?>><?php esc_html_e( 'Standard Import', 'riode' ); ?></button>
						<?php if ( ! $server_status ) : ?>
							<p><?php esc_html_e( 'Your server performance does not satisfy Riode demo importer engine\'s requirement. We recommend you to use alternative method to perform demo import without any issues but it may take much time than standard import.', 'riode' ); ?></p>
						<?php else : ?>
							<p><?php esc_html_e( 'If you have any issues with standard import, please use Alternative mode. But it may take much time than standard import.', 'riode' ); ?></p>
						<?php endif; ?>
						<button class="btn btn-secondary riode-import-yes alternative"><?php esc_html_e( 'Alternative Mode', 'riode' ); ?></button>
					</div>
					</div>
					<?php else : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=riode' ) ); ?>" class="btn btn-dark btn-activate" style="display: inline-block; box-sizing: border-box; text-decoration: none; text-align: center; margin-bottom: 20px;"><?php esc_html_e( 'Activate Theme', 'riode' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div id="theme-install-demos">
		<?php foreach ( $demos as $demo => $demo_details ) : ?>
			<?php
			$uninstalled_demo_plugins = $uninstalled_plugins;
			if ( ! empty( $demo_details['plugins'] ) ) {
				foreach ( $demo_details['plugins'] as $plugin ) {
					if ( is_plugin_inactive( $all_plugins[ $plugin ]['url'] ) ) {
						$uninstalled_demo_plugins[ $plugin ] = $all_plugins[ $plugin ];
					}
				}
			}

			if ( 'landing' == $demo ) {
			} else {
				$demo_sites = $this->riode_url . $demo;
			}
			?>
			<div class="theme <?php echo esc_attr( $demo_details['filter'] ); ?>">
				<div class="theme-wrapper">
					<img class="theme-screenshot" src="<?php echo esc_url( $demo_details['img'] ); ?>" />
					<h3 class="theme-name" id="<?php echo esc_attr( $demo ); ?>" data-live-url="<?php echo esc_attr( $demo_sites ); ?>"><?php echo riode_escaped( $demo_details['alt'] ); ?></h3>
					<ul class="plugins-used" data-editor="<?php echo esc_attr( json_encode( $demo_details['editors'] ) ); ?>">
					<?php if ( ! empty( $uninstalled_demo_plugins ) ) : ?>
						<?php foreach ( $uninstalled_demo_plugins as $plugin ) : ?>
							<?php if ( $plugin['required'] || isset( $riode_plugins_obj->demo_plugin_dependencies[ $demo ][ $plugin['slug'] ] ) ) : ?>
							<li data-plugin="<?php echo esc_attr( $plugin['slug'] ); ?>">
								<div class="thumb">
									<img src="<?php echo esc_url( $plugin['image_url'] ); ?>" />
								</div>
								<div>
									<h5><?php echo esc_html( $plugin['name'] ); ?></h5>
										<a href="#" data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>" data-callback="install_plugin" class="demo-plugin"><?php esc_html_e( 'Install', 'riode' ); ?></a>
								</div>
							</li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if ( ! empty( $demo_details['editors'] ) ) : ?>
						<?php foreach ( $demo_details['editors'] as $editor ) : ?>
							<?php if ( is_plugin_inactive( $all_plugins[ $editor ]['url'] ) ) : ?>
							<li data-plugin="<?php echo esc_attr( $all_plugins[ $editor ]['slug'] ); ?>" class="plugin-editor">
								<div class="thumb">
									<img src="<?php echo esc_url( $all_plugins[ $editor ]['image_url'] ); ?>" />
								</div>
								<div>
									<h5><?php echo esc_html( $all_plugins[ $editor ]['name'] ); ?></h5>
									<a href="#" data-slug="<?php echo esc_attr( $all_plugins[ $editor ]['slug'] ); ?>" data-callback="install_plugin" class="demo-plugin"><?php esc_html_e( 'Install', 'riode' ); ?></a>
								</div>
							</li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
					</ul>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<p class="info-qt light-info icon-fixed" style="padding-left: 20px;"><?php esc_html_e( 'Installing a demo provides pages, posts, menus, images, theme options, widgets and more.', 'riode' ); ?>
	<br /><strong><?php esc_html_e( 'IMPORTANT: ', 'riode' ); ?> </strong><span><?php esc_html_e( 'The included plugins need to be installed and activated before you install a demo.', 'riode' ); ?></span>
	<?php /* translators: $1: opening A tag which has link to the plugins step $2: closing A tag */ ?>
	<br /><?php printf( esc_html__( 'Please check the %1$sStatus%2$s step to ensure your server meets all requirements for a successful import. Settings that need attention will be listed in red.', 'riode' ), '<a href="' . esc_url( $this->get_step_link( 'status' ) ) . '">', '</a>' ); ?></p>

	<input type="hidden" name="new_logo_id" id="new_logo_id" value="">

	<p class="riode-admin-panel-actions">
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-dark button-next button-icon-hide"><?php esc_html_e( 'Skip this step', 'riode' ); ?></a>
		<button type="submit" class="button-primary button button-large button-next" name="save_step"><?php esc_html_e( 'Continue', 'riode' ); ?></button>
		<?php wp_nonce_field( 'riode-setup-wizard' ); ?>
	</p>
</form>
