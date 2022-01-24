<?php
defined( 'ABSPATH' ) || die;

$output_steps = $this->steps;
?>
<div class="riode-admin-panel-row riode-optimize-panel">
	<div class="riode-admin-panel-side">
		<img class="logo" src="<?php echo RIODE_URI; ?>/assets/images/admin/setup-wizard.png" alt="Riode Optimize Wizard" width="214" height="202" />
		<h3><b><?php esc_html_e( 'Riode eCommerce', 'riode' ); ?></b><br> <?php echo esc_html__( 'version', 'riode' ) . ' ' . RIODE_VERSION; ?></h3>
	</div>
	<div class="riode-admin-panel-content">
		<div class="riode-admin-panel-header">
			<h1><?php esc_html_e( 'Optimize Wizard', 'riode' ); ?></h1>
			<p><?php esc_html_e( 'Riode optimize wizard will help you configure proper website with optimum resources and peak efficiency.', 'riode' ); ?></p>
			<p style="margin-top: 20px; padding: 10px; display: inline-block; color: #fff; background-color: #d26e4b; border-radius: 3px;"><?php esc_html_e( 'Note! Make sure that you have finished developing. Changes after running this wizard will not be affected. If you have such a problem, please rerun this wizard.', 'riode' ); ?></p>
		</div>
		<ul class="riode-optimize-panel-steps">
			<?php
				$index = 1;
				foreach ( $output_steps as $step_key => $step ) : ?>
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
				<li class="step <?php echo esc_attr( $li_class_escaped ); ?>">
				<?php
				if ( $show_link ) {
					?>
						<a href="<?php echo esc_url( $this->get_step_link( $step_key ) ); ?>">
							<span><?php echo esc_html( $index ); ?></span>
							<label><?php echo esc_html( $step['name'] ); ?></label>
						</a>
						<?php
				} else {
					?>
					<a href="#" class="active">
						<span><?php echo esc_html( $index ); ?></span>
						<label><?php echo esc_html( $step['name'] ); ?></label>
					</a>
					<?php
				}
				?>
				</li>
			<?php 
				$index ++;
				endforeach;
			?>
		</ul>
		<div class="riode-admin-panel-body">
			<?php $this->view_step(); ?>
		</div>
	</div>
</div>
