<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="login-popup" id="customer_login">
	<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

	<div class="tab form-tab tab-simple">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a href="signin" class="nav-link active" data-toggle="tab"><?php esc_html_e( 'Login', 'riode' ); ?></a>
			</li>
		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
			<li class="delimiter"><?php esc_html_e( 'or', 'riode' ); ?></li>
			<li class="nav-item">
				<a href="signup" class="nav-link" data-toggle="tab"><?php esc_html_e( 'Register', 'riode' ); ?></a>
			</li>
		<?php endif; ?>
		</ul>
		<div class="tab-content">

			<div class="tab-pane active" id="signin">
				<form class="woocommerce-form woocommerce-form-login login" method="post">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" required placeholder="<?php echo esc_attr__( 'Username or Email Address', 'riode' ) . ' *'; ?>" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required placeholder="<?php echo esc_attr__( 'Password', 'woocommerce' ) . ' *'; ?>" />
					</p>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<div class="form-row form-footer">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme form-checkbox">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
						</label>
						<p class="woocommerce-LostPassword lost_password">
							<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
						</p>
					</div>

					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<button type="submit" class="woocommerce-button button woocommerce-form-login__submit btn btn-md btn-dark" name="login" value="<?php esc_attr_e( 'LogIn', 'riode' ); ?>"><?php esc_html_e( 'LogIn', 'riode' ); ?></button>

					<p class="submit-status"></p>

					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>
			</div>

		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
			<div class="tab-pane" id="signup">
				<form method="post" class="woocommerce-form woocommerce-form-login register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" required placeholder="<?php echo esc_attr__( 'Username', 'woocommerce' ) . ' *'; ?>" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						</p>

					<?php endif; ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" required placeholder="<?php echo esc_attr__( 'Your Email address', 'riode' ) . ' *'; ?>" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</p>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required placeholder="<?php echo esc_attr__( 'Password', 'woocommerce' ) . ' *'; ?>" />
						</p>

					<?php else : ?>

						<p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

					<?php
					/* translators: opening and ending p tag */
					$text = sprintf( esc_html__( '%1$sI agree to the %2$s', 'riode' ), '<p class="custom-checkbox"><input type="checkbox" id="register-policy" required=""><label for="register-policy">', '[privacy_policy]</label></p>' );
					echo wpautop( wc_replace_policy_page_link_placeholders( $text ) );
					?>

					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
					<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit btn btn-md btn-dark" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>

					<p class="submit-status"></p>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

				</form>
			</div>
		<?php endif; ?>
		</div>
	</div>
			<script type="text/javascript">
				var riode_anr_onloadCallback = function() {
					for ( var i = 0; i < document.forms.length; i++ ) {
						var form = document.forms[i];
						var captcha_div = form.querySelector( '.anr_captcha_field_div' );
	
						if ( null === captcha_div )
							continue;
						captcha_div.innerHTML = '';
						( function( form ) {
							var anr_captcha = grecaptcha.render( captcha_div,{
								'sitekey' : '<?php echo esc_js( trim( anr_get_option( 'site_key' ) ) ); ?>',
								'size'  : '<?php echo esc_js( anr_get_option( 'size', 'normal' ) ); ?>',
								'theme' : '<?php echo esc_js( anr_get_option( 'theme', 'light' ) ); ?>'
							});
							if ( typeof jQuery !== 'undefined' ) {
								jQuery( document.body ).on( 'checkout_error', function(){
									grecaptcha.reset(anr_captcha);
								});
							}
							if ( typeof wpcf7 !== 'undefined' ) {
								document.addEventListener( 'wpcf7submit', function() {
									grecaptcha.reset(anr_captcha);
								}, false );
							}
						})(form);
					}
				};
			</script>
			<?php
			if ( class_exists( 'anr_captcha_class' ) && wp_doing_ajax() ) {
				$language = trim( anr_get_option( 'language' ) );

				$lang = '';
				if ( $language ) {
					$lang = '&hl=' . $language;
				}
				$google_url = apply_filters( 'anr_v2_checkbox_script_api_src', sprintf( 'https://www.%s/recaptcha/api.js?onload=riode_anr_onloadCallback&render=explicit' . $lang, anr_recaptcha_domain() ), $lang );
				?>
				<script src="<?php echo esc_url( $google_url ); ?>"
					async defer>
				</script>
			<?php } ?>

	<?php do_action( 'riode_after_customer_login_form' ); ?>
</div>
