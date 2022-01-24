<?php
defined( 'ABSPATH' ) || die;

?>
<div class="riode-admin-panel-row riode-maintenance-tools">
	<div class="riode-admin-panel-side">
		<img class="logo" src="<?php echo RIODE_URI; ?>/assets/images/admin/setup-wizard.png" alt="Riode Maintenance Tools" width="214" height="202" />
		<h3><b><?php esc_html_e( 'Riode eCommerce', 'riode' ); ?></b><br> <?php echo esc_html__( 'version', 'riode' ) . ' ' . RIODE_VERSION; ?></h3>
	</div>
	<div class="riode-admin-panel-content">
		<div class="riode-admin-panel-header">
			<h1><?php esc_html_e( 'Version Control', 'riode' ); ?><span class="label-new">New</span></h1>
			<p><?php esc_html_e( 'Experiencing an issue with New version? Rollback to a previous version before the issue appeared.', 'riode' ); ?></p>
		</div>
		<table class="wp-list-table widefat riode-installing-options" id="riode_versions_table">
			<tbody id="versions-list">
				<tr class="theme-version" id="riode-theme-version">
					<th>
						<h3 class="version-type"><?php echo esc_html__( 'Riode Theme', 'riode' ); ?></h3>
						<p class="description warning"><?php echo esc_html__( 'Warning: Please backup your database before making the rollback.', 'riode' ); ?></p>
					</th>
					<td class="run-tool">
						<select class="version-select theme-versions" id="theme-versions">
							<?php
							foreach ( $this->theme_versions as $version ) {
								?>
									<option value="<?php echo esc_attr( $version ); ?>"><?php echo esc_html( $version ); ?></option>
									<?php
							}
							?>
						</select>
						<a href="#" class="button button-large button-light theme-rollback"><?php echo esc_html__( 'Downgrade', 'riode' ); ?></a>
					</td>
				</tr>
				<tr class="plugin-version" id="riode-plugin-version">
					<th>
						<h3 class="version-type"><?php echo esc_html__( 'Riode Core Plugin', 'riode' ); ?></h3>
						<p class="description warning"><?php echo esc_html__( 'Warning: Please backup your database before making the rollback.', 'riode' ); ?></p>
					</th>
					<td class="run-tool">
						<select class="version-select plugin-versions" id="plugin-versions">
						<?php
						foreach ( $this->plugin_versions as $version ) {
							?>
								<option value="<?php echo esc_attr( $version ); ?>"><?php echo esc_html( $version ); ?></option>
							<?php
						}
						?>
						</select>
						<a href="#" class="button button-large button-light plugin-rollback"><?php echo esc_html__( 'Downgrade', 'riode' ); ?></a>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="message-list">
		</div>
	</div>
</div>
