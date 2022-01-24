<?php
defined( 'ABSPATH' ) || die;
?>
<div class="riode-admin-panel-header">
	<h1><?php esc_html_e( 'Welcome to Riode', 'riode' ); ?></h1>
	<?php if ( Riode_Admin::get_instance()->is_registered() ) : ?>
		<p><?php esc_html_e( 'Congratulations! Your product is registered now.', 'riode' ); ?></p>
	<?php else : ?>
		<p><?php esc_html_e( 'Thank you for choosing Riode theme from ThemeForest. Please register your purchase and make sure that you have fulfilled all of the requirements.', 'riode' ); ?></p>
	<?php endif; ?>
</div>
<div class="riode-admin-panel-body welcome">
	<div class="riode-important-notice registration-form-container">
		<div class="riode-registration-form">
			<?php if ( ! Riode_Admin::get_instance()->is_registered() ) : ?>
				<p class="about-description"><?php esc_html_e( 'Please enter your Purchase Code to complete registration.', 'riode' ); ?></p>
			<?php endif; ?>

			<p class="info-qt"><?php esc_html_e( 'Where can I find my purchase code?', 'riode' ); ?></p>
			<ul>
				<?php /* translators: $1: opening A tag which has link to the Themeforest downloads page $2: closing A tag */ ?>
				<li><i class="circle fa fa-check"></i><?php printf( esc_html__( 'Please go to %1$sThemeForest.net/downloads%2$s', 'riode' ), '<a target="_blank" href="https://themeforest.net/downloads">', '</a>' ); ?></li>
				<li><i class="circle fa fa-check"></i><?php printf( esc_html__( 'Click the Download button in Riode row', 'riode' ), '<strong>', '</strong>' ); ?></li>
				<li><i class="circle fa fa-check"></i><?php printf( esc_html__( 'Select License Certificate & Purchase code', 'riode' ), '<strong>', '</strong>' ); ?></li>
				<li><i class="circle fa fa-check"></i><?php printf( esc_html__( 'Copy Item Purchase Code', 'riode' ), '<strong>', '</strong>' ); ?></li>
			</ul>

			<?php
				$disable_field = '';
				$errors        = get_option( 'riode_register_error_msg' );
				update_option( 'riode_register_error_msg', '' );
				$purchase_code = Riode_Admin::get_instance()->get_purchase_code_asterisk();
			if ( ! empty( $errors ) ) {
				echo '<div class="notice-error notice-alt notice-large">' . riode_escaped( $errors ) . '</div>';
			}

			if ( ! empty( $purchase_code ) ) {
				if ( ! empty( $errors ) ) {
					echo '<div class="notice-warning notice-alt notice-large">' . esc_html__( 'Purchase code not updated. We will keep the existing one.', 'riode' ) . '</div>';
				} else {
					/* translators: $1 and $2 opening and closing strong tags respectively */
					echo '<div class="notice-success notice-alt notice-large">' . sprintf( esc_html__( 'Your %1$spurchase code is valid%2$s. Thank you! Enjoy Riode Theme and automatic updates.', 'riode' ), '<strong>', '</strong>' ) . '</div>';
				}
			}
			?>
			<form id="riode_registration" method="post">
				<?php
				if ( $purchase_code && ! empty( $purchase_code ) && Riode_Admin::get_instance()->is_registered() ) {
					$disable_field = ' disabled=true';
				}
				?>
				<span class="dashicons dashicons-admin-network riode-code-icon"></span>
				<input type="hidden" name="riode_registration" />
				<?php if ( Riode_Admin::get_instance()->is_envato_hosted() ) : ?>
					<p class="confirm unregister">
						<?php esc_html_e( 'You are using Envato Hosted, this subscription code can not be deregistered.', 'riode' ); ?>
					</p>
				<?php else : ?>
					<input type="text" id="riode_purchase_code" name="code" class="regular-text" value="<?php echo esc_attr( $purchase_code ); ?>" placeholder="<?php esc_attr_e( 'Purchase Code', 'riode' ); ?>" <?php echo riode_escaped( $disable_field ); ?> />
					<?php if ( Riode_Admin::get_instance()->is_registered() ) : ?>
						<input type="hidden" name="action" value="unregister" />
						<?php submit_button( esc_html__( 'Deactivate', 'riode' ), array( 'button-dark', 'large', 'riode-large-button' ), '', true ); ?>
					<?php else : ?>
						<input type="hidden" name="action" value="register" />
						<?php submit_button( esc_html__( 'Activate', 'riode' ), array( 'primary', 'large', 'riode-large-button' ), '', true ); ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php wp_nonce_field( 'riode-setup-wizard' ); ?>
			</form>
		</div>
	</div>
	<p class="about-description">
		<?php /* translators: $1: opening A tag which has link to the Riode documentation $2: closing A tag */ ?>
		<?php printf( esc_html__( 'Before you get started, please be sure to always check out %1$sthis documentation%2$s. We outline all kinds of good information, and provide you with all the details you need to use Riode.', 'riode' ), '<a href="https://d-themes.com/wordpress/riode/documentation" target="_blank">', '</a>' ); ?>
	</p>
	<p class="about-description">
		<?php /* translators: $1: opening A tag which has link to the Riode support $2: closing A tag */ ?>
		<?php printf( esc_html__( 'If you are unable to find your answer in our documentation, we encourage you to contact us through %1$ssupport page%2$s with your site CPanel (or FTP) and WordPress admin details. We are very happy to help you and you will get reply from us more faster than you expected.', 'riode' ), '<a href="https://d-themes.com/wordpress/riode/support" target="_blank">', '</a>' ); ?>
	</p>
</div>
