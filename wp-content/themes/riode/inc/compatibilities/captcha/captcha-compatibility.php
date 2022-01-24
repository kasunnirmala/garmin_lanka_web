<?php
/**
 * Captcha Plugin Compatibility
 *
 * @since 1.4.3
 * @package riode
 * @author Andy
 */

// Localize child theme variables.
add_filter( 'riode_vars', 'add_theme_captcha_vars' );

if ( ! function_exists( 'add_theme_captcha_vars' ) ) {

	/**
	 * Add theme captcha variables.
	 *
	 * @since 1.4.3
	 * @param array $vars theme variables.
	 * @return array
	 */
	function add_theme_captcha_vars( $vars ) {
		if ( class_exists( 'anr_captcha_class' ) ) {
			$vars = array_merge_recursive(
				$vars,
				array(
					'recaptcha'     => true,
					'recaptcha_msg' => __( 'Please verify that you are not a robot.', 'riode' ),
				)
			);
		}

		return $vars;
	}
}
