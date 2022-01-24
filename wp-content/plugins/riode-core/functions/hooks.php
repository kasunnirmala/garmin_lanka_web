<?php

// Social Login
add_action( 'woocommerce_login_form_end', 'riode_print_social_login_content' );
add_action( 'woocommerce_register_form_end', 'riode_print_social_login_content' );

// Woocommerce actions
add_action(
	'init',
	function() {
		/**
		 * Woocommerce share
		 */
		add_action( 'woocommerce_share', 'riode_print_share' );
	},
	8
);

// Riode async script
if ( function_exists( 'riode_get_option' ) ) {
	if ( riode_get_option( 'resource_async_js' ) ) {
		add_filter( 'script_loader_tag', 'riode_script_make_async', 10, 2 );
	}
	if ( riode_get_option( 'resource_disable_elementor_unused' ) ) {
		add_action( 'wp_enqueue_scripts', 'riode_dequeue_elementor_scripts', 5 );
	}
}


function riode_nextend_social_login( $social ) {
	$res = '';
	if ( class_exists( 'NextendSocialLogin', false ) ) {
		$res = NextendSocialLogin::isProviderEnabled( $social );
	} else {
		if ( 'facebook' == $social ) {
			$res = defined( 'NEW_FB_LOGIN' );
		} elseif ( 'google' == $social ) {
			$res = defined( 'NEW_GOOGLE_LOGIN' );
		} elseif ( 'twitter' == $social ) {
			$res = defined( 'NEW_TWITTER_LOGIN' );
		}
	}
	return apply_filters( 'riode_nextend_social_login', $res, $social );
}

if ( ! function_exists( 'riode_print_social_login_content' ) ) {
	function riode_print_social_login_content() {
		$is_facebook_login = riode_nextend_social_login( 'facebook' );
		$is_google_login   = riode_nextend_social_login( 'google' );
		$is_twitter_login  = riode_nextend_social_login( 'twitter' );

		if ( ( $is_facebook_login || $is_google_login || $is_twitter_login ) && riode_get_option( 'social_login' ) ) {
			?>

			<div class="social-login title-center title-cross text-center">
				<h4 class="title">
					<?php
					if ( 'woocommerce_login_form_end' == current_action() ) {
						esc_html_e( 'or Login With', 'riode-core' );
					} else {
						esc_html_e( 'or Register With', 'riode-core' );
					}
					?>
				</h4>
				<div class="social-icons">
				<?php do_action( 'riode_before_login_social' ); ?>
				<?php if ( $is_google_login ) { ?>
					<a class="social-icon stacked rounded social-google" href="<?php echo wp_login_url(); ?>?loginGoogle=1&redirect=<?php echo the_permalink(); ?>" onclick="window.location.href = '<?php echo wp_login_url(); ?>?loginGoogle=1&redirect='+window.location.href; return false">
						<i class="fab fa-google"></i></a>
				<?php } ?>
				<?php if ( $is_facebook_login ) { ?>
					<a class="social-icon stacked rounded social-facebook" href="<?php echo wp_login_url(); ?>?loginFacebook=1&redirect=<?php echo the_permalink(); ?>" onclick="window.location.href = '<?php echo wp_login_url(); ?>?loginFacebook=1&redirect='+window.location.href; return false"><i class="fab fa-facebook-f"></i></a>
				<?php } ?>
				<?php if ( $is_twitter_login ) { ?>
					<a class="social-icon stacked rounded social-twitter" href="<?php echo wp_login_url(); ?>?loginSocial=twitter&redirect=<?php echo the_permalink(); ?>" onclick="window.location.href = '<?php echo wp_login_url(); ?>?loginSocial=twitter&redirect='+window.location.href; return false">
						<i class="fab fa-twitter"></i></a>
				<?php } ?>
				<?php do_action( 'riode_after_login_social' ); ?>
				</div>
			</div>

			<?php
		}
	}
}

/**
 * Sharing Post
 */
if ( ! function_exists( 'riode_print_share' ) ) {
	function riode_print_share() {
		if ( ! function_exists( 'riode_get_option' ) ) {
			return;
		}
		ob_start();
		?>
		<div class="social-icons">
			<?php
			global $riode_social_name, $riode_social_icon;

			$icon_type       = riode_get_option( 'share_type' );
			$custom          = riode_get_option( 'share_custom_color' ) ? ' social-custom' : '';
			$share_no_follow = riode_get_option( 'social_no_follow' );

			$nofollow = ' ';
			if ( $share_no_follow ) {
				$nofollow = 'noopener noreferrer nofollow';
			} else {
				$nofollow = 'noopener noreferrer';
			}

			foreach ( riode_get_option( 'share_icons' ) as $share ) {
				$permalink = apply_filters( 'the_permalink', get_permalink() );
				$title     = esc_attr( get_the_title() );
				$image     = wp_get_attachment_url( get_post_thumbnail_id() );

				// if ( class_exists( 'YITH_WCWL' ) && is_user_logged_in() ) {
				// if ( get_option( 'yith_wcwl_wishlist_page_id' ) == get_the_ID() ) {
				// $wishlist_id = ( YITH_WCWL()->last_operation_token ) ? YITH_WCWL()->last_operation_token : YITH_WCWL()->details['wishlist_id'];
				// $permalink  .= '/view/' . $wishlist_id;
				// $permalink   = urlencode( $permalink );
				// }
				// }

				$permalink = esc_url( $permalink );

				$link_escaped = strtr(
					$riode_social_icon[ $share ][1],
					array(
						'$permalink' => $permalink,
						'$title'     => $title,
						'$image'     => $image,
					)
				);
				if ( empty( $link_escaped ) ) {
					continue;
				}

				if ( 'whatsapp' == $share ) {
					$title        = rawurlencode( $title );
					$link_escaped = esc_attr( $link_escaped );
				} else {
					$title        = urlencode( $title );
					$link_escaped = esc_url( $link_escaped );
				}

				echo '<a href="' . $link_escaped . '" class="social-icon ' . esc_attr( $icon_type . $custom ) . ' social-' . $share . '" target="_blank" title="' . $riode_social_name[ $share ] . '" rel="' . esc_attr( $nofollow ) . '">';
				echo '<i class="' . esc_attr( $riode_social_icon[ $share ][0] ) . '"></i>';
				echo '</a>';
			}
			?>
		</div>
		<?php
		echo ob_get_clean();
	}
}

function riode_script_make_async( $tag, $handle ) {
	global $riode_async_scripts;

	if ( is_array( $riode_async_scripts ) && in_array( $handle, $riode_async_scripts ) ) {
		return str_replace( ' src', ' async="async" src', $tag );
	}
	return $tag;
}

function riode_dequeue_elementor_scripts() {
	if ( defined( 'ELEMENTOR_URL' ) ) {
		wp_deregister_script( 'swiper' );
		wp_dequeue_script( 'swiper' );

		// ELEMENTOR_URL
		wp_deregister_script( 'elementor-frontend' );
		wp_register_script(
			'elementor-frontend',
			ELEMENTOR_URL . 'assets/js/frontend' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || defined( 'ELEMENTOR_TESTS' ) && ELEMENTOR_TESTS ? '' : '.min' ) . '.js',
			array(
				'elementor-frontend-modules',
				'elementor-dialog',
				'elementor-waypoints',
				// 'swiper',
				'share-link',
			),
			ELEMENTOR_VERSION,
			true
		);
	}
}
