<?php
defined( 'ABSPATH' ) || die;

$output_steps = $this->steps;
?>
<div class="riode-admin-panel-row">
	<div class="riode-admin-panel-side">
		<img class="logo" src="<?php echo RIODE_URI; ?>/assets/images/admin/setup-wizard.png" alt="Riode Setup Wizard" width="214" height="202" />
		<h3><b><?php esc_html_e( 'Riode eCommerce', 'riode' ); ?></b><br> <?php echo esc_html__( 'version', 'riode' ) . ' ' . RIODE_VERSION; ?></h3>
	</div>
	<div class="riode-admin-panel-content">
		<div class="riode-admin-panel-header">
			<h1><?php esc_html_e( 'Setup Wizard', 'riode' ); ?></h1>
			<p><?php esc_html_e( 'This quick setup wizard will help you configure your new website. This wizard will install the required WordPress plugins, import demo.', 'riode' ); ?></p>
		</div>
		<ul class="riode-admin-panel-steps">
			<?php foreach ( $output_steps as $step_key => $step ) : ?>
				<?php
				if ( 'ready' == $step_key ) {
					continue;
				}

				$show_link        = true;
				$li_class_escaped = '';
				if ( $step_key === $this->step ) {
					$li_class_escaped = 'active';
				} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
					$li_class_escaped = 'done';
				}
				if ( $step_key === $this->step ) {
					$show_link = false;
				}
				?>
				<li class="<?php echo esc_attr( $li_class_escaped ); ?>">
				<?php
				if ( $show_link ) {
					?>
						<a href="<?php echo esc_url( $this->get_step_link( $step_key ) ); ?>"><?php echo esc_html( $step['name'] ); ?></a>
						<?php
				} else {
					echo esc_html( $step['name'] );
				}
				?>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="riode-admin-panel-body riode-setup-<?php echo esc_attr( str_replace( '_', '-', $this->step ) ); ?>">
			<?php $this->view_step(); ?>
		</div>
	</div>
</div>
