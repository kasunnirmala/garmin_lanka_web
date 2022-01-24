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
			<h1><?php esc_html_e( 'Maintenance Tools', 'riode' ); ?></h1>
			<p><?php esc_html_e( 'Keep your site always fresh and up-to-date with our tools.', 'riode' ); ?></p>
		</div>
		<table class="wp-list-table widefat riode-installing-options" id="riode_tools_table">
			<tbody id="tools-list">
				<?php foreach ( $this->tools as $action => $tool ) : ?>
					<tr class="<?php echo sanitize_html_class( $action ); ?>">
						<th>
							<h3 class="action-name"><?php echo esc_html( $tool['action_name'] ); ?></h3>
							<p class="description"><?php echo riode_escaped( $tool['description'] ); ?></p>
						</th>
						<td class="run-tool">
							<a href="#" class="button button-large button-light <?php echo esc_attr( $action ); ?>"><?php echo esc_html( $tool['button_text'] ); ?></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="message-list">
		</div>
	</div>
</div>
