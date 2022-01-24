<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! function_exists( 'riode_set_layout' ) ) {
	function riode_set_layout() {
		global $riode_layout;

		$riode_layout                = riode_get_layout();
		$riode_layout['used_blocks'] = riode_get_page_blocks();
	}
}


if ( ! function_exists( 'riode_add_body_class' ) ) {
	function riode_add_body_class( $classes ) {
		// Page Type
		$classes[] = str_replace( '_', '-', riode_get_layout_value( 'slug' ) );

		// Center Content Mode
		if ( 'true' == riode_get_layout_value( 'general', 'center_content' ) ) {
			$classes[] = 'center-with-sidebar';
		}

		// Left Sidebar Active?
		if ( riode_get_layout_value( 'left_sidebar', 'id' ) && -1 != riode_get_layout_value( 'left_sidebar', 'id' ) ) {
			if ( 'control' == riode_get_layout_value( 'left_sidebar', 'type' ) && 'out' == riode_get_layout_value( 'left_sidebar', 'place' ) && 'true' == riode_get_layout_value( 'left_sidebar', 'first_show' ) ) {
				$classes[] = ( is_rtl() ? 'right' : 'left' ) . '-sidebar-active';
			}
		}

		// Right Sidebar Active?
		if ( riode_get_layout_value( 'right_sidebar', 'id' ) && -1 != riode_get_layout_value( 'right_sidebar', 'id' ) ) {
			if ( 'control' == riode_get_layout_value( 'right_sidebar', 'type' ) && 'out' == riode_get_layout_value( 'right_sidebar', 'place' ) && 'true' == riode_get_layout_value( 'right_sidebar', 'first_show' ) ) {
				$classes[] = ( is_rtl() ? 'left' : 'right' ) . '-sidebar-active';
			}
		}

		// Skeleton Skin
		if ( 'dark' == riode_get_option( 'skeleton_bg' ) ) {
			$classes[] = 'riode-skeleton-dark';
		}

		// Disable Mobile Animation
		if ( riode_get_option( 'mobile_disable_animation' ) ) {
			$classes[] = 'riode-disable-mobile-animation';
		}

		// Disable Slider on Mobile
		if ( riode_get_option( 'mobile_disable_slider' ) ) {
			$classes[] = 'riode-disable-mobile-slider';
		}

		// Rounded Border Skin
		if ( riode_get_option( 'rounded_skin' ) ) {
			$classes[] = 'riode-rounded-skin';
		}

		return $classes;
	}
}

if ( ! function_exists( 'riode_add_main_class' ) ) {
	function riode_add_main_class( $classes ) {
		if ( ( defined( 'YITH_WCWL' ) && function_exists( 'yith_wcwl_is_wishlist_page' ) && yith_wcwl_is_wishlist_page() ) ||
			( class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) ) ) {
			$classes .= ' pt-lg';
		}
		return $classes;
	}
}


/*******************************
	*                          *
	*  Riode Theme Functions  *
	*                          *
	*/

if ( ! function_exists( 'riode_print_title_bar' ) ) {
	function riode_print_title_bar() {
		if ( is_front_page() || 'product_single_layout' == riode_get_layout_value( 'slug' ) ) {
			return;
		}

		if ( class_exists( 'Woocommerce' ) && ( is_cart() || is_checkout() ) ) {
			?>
			<div class="woo-page-header">
				<div class="<?php echo esc_attr( 'full' == riode_get_layout_value( 'general', 'wrap' ) ? 'container' : riode_get_layout_value( 'general', 'wrap' ) ); ?>">
					<ul class="breadcrumb">
						<li class="<?php echo is_cart() ? esc_attr( 'current' ) : ''; ?>">
							<a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php echo apply_filters( 'riode_wc_checkout_ptb_title', esc_html__( '1. Shopping Cart', 'riode' ), 'cart' ); ?></a>
							<i class="delimiter"></i>
						</li>
						<li class="<?php echo is_checkout() && ! is_order_received_page() ? esc_attr( 'current' ) : ''; ?>">
							<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><?php echo apply_filters( 'riode_wc_checkout_ptb_title', esc_html__( '2. Checkout', 'riode' ), 'checkout' ); ?></a>
							<i class="delimiter"></i>
						</li>
						<li class="<?php echo is_order_received_page() ? esc_attr( 'current' ) : esc_attr( 'disable' ); ?>">
							<a href="#"><?php echo apply_filters( 'riode_wc_checkout_ptb_title', esc_html__( '3. Order Complete', 'riode' ), 'order' ); ?></a>
						</li>
					</ul>
				</div>
			</div>

			<?php
			return;
		}

		if ( ! riode_get_layout_value( 'ptb', 'title' ) && ! riode_get_layout_value( 'ptb', 'subtitle' ) ) {
			return;
		}

		if ( 'classic' != riode_get_layout_value( 'ptb', 'id' ) && '' != riode_get_layout_value( 'ptb', 'id' ) ) {
			if ( riode_get_layout_value( 'ptb', 'id' ) > 0 ) {
				echo '<div class="ptb-block">';
				riode_print_template( riode_get_layout_value( 'ptb', 'id' ) );
				echo '</div>';
			}
		} else {
			$ptb = array();
			if ( 'false' == riode_get_layout_value( 'ptb', 'ptb_follow_theme_option' ) ) {
				riode_print_template( $riode_layout['ptb']['id'] );
			}
			$ptb_type            = ! empty( $ptb['ptb_type'] ) ? $ptb['ptb_type'] : riode_get_option( 'ptb_type' );
			$ptb_title_show      = ! empty( $ptb['ptb_title_show'] ) ? ( 'true' === $ptb['ptb_title_show'] ? 'show' : '' ) : riode_get_option( 'ptb_title_show' );
			$ptb_subtitle_show   = ! empty( $ptb['ptb_subtitle_show'] ) ? ( 'true' === $ptb['ptb_subtitle_show'] ? 'show' : '' ) : riode_get_option( 'ptb_subtitle_show' );
			$ptb_breadcrumb_show = ! empty( $ptb['ptb_breadcrumb_show'] ) ? ( 'true' === $ptb['ptb_breadcrumb_show'] ? 'show' : '' ) : riode_get_option( 'ptb_breadcrumb_show' );
			$ptb_wrap_container  = ! empty( $ptb['ptb_wrap_container'] ) ? $ptb['ptb_wrap_container'] : riode_get_option( 'ptb_wrap_container' );

			if ( $ptb_title_show || $ptb_subtitle_show || ( 'depart' != $ptb_type && $ptb_breadcrumb_show ) ) {
				echo '<div class="page-header">';

				if ( 'default' != $ptb_wrap_container ) {
					echo '<div class="' . $ptb_wrap_container . '">';
				}

				echo '<div class="page-title-bar type-' . $ptb_type . '">';

				echo '<div class="page-title-wrap">';

				if ( 'show' == $ptb_subtitle_show && riode_get_layout_value( 'ptb', 'subtitle' ) ) {
					echo '<h3 class="page-subtitle">' . riode_get_layout_value( 'ptb', 'subtitle' ) . '</h3>';
				}
				if ( 'show' == $ptb_title_show && riode_get_layout_value( 'ptb', 'title' ) ) {
					echo '<h2 class="page-title">' . riode_get_layout_value( 'ptb', 'title' ) . '</h2>';
				}

				echo '</div>';

				if ( 'depart' != $ptb_type && $ptb_breadcrumb_show ) {
					do_action( 'riode_print_breadcrumb' );
				}

				echo '</div>';

				if ( 'default' != $ptb_wrap_container ) {
					echo '</div>';
				}

				echo '</div>';
			}

			if ( 'depart' == $ptb_type && $ptb_breadcrumb_show ) {

				echo '<div class="breadcrumb_wrapper">';

				if ( 'default' != $ptb_wrap_container ) {
					echo '<div class="' . $ptb_wrap_container . '">';
				} else {
					if ( 'full' != riode_get_layout_value( 'general', 'wrap' ) ) {
						echo '<div class="' . riode_get_layout_value( 'general', 'wrap' ) . '">';
					} else {
						echo '<div class="container">';
					}
				}

				do_action( 'riode_print_breadcrumb' );

				echo '</div>';
				echo '</div>';
			}
		}
	}
}

if ( ! function_exists( 'riode_func_add_block' ) ) {
	function riode_func_add_block( $arg = RIODE_BEFORE_CONTENT ) {
		$block_name = '';

		if ( RIODE_BEFORE_CONTENT == $arg ) {
			$single_type = riode_get_option( 'single_product_type' );

			if ( class_exists( 'WooCommerce' ) && is_product() ) {
				add_filter( 'riode_breadcrumb_args', 'riode_single_prev_next_product' );

				if ( 'gallery' != $single_type ) {
					remove_action( 'riode_before_content', 'riode_print_title_bar' );
				}
			}
		}

		if ( RIODE_BEFORE_CONTENT == $arg && 0 < riode_get_layout_value( 'top_block', 'id' ) ) {
			$block_name = sanitize_text_field( riode_get_layout_value( 'top_block', 'id' ) );
			echo '<div class="top-block">';
		} elseif ( RIODE_BEFORE_INNER_CONTENT == $arg && 0 < riode_get_layout_value( 'inner_top_block', 'id' ) ) {
			$block_name = sanitize_text_field( riode_get_layout_value( 'inner_top_block', 'id' ) );
			echo '<div class="inner-top-block">';
		} elseif ( RIODE_AFTER_INNER_CONTENT == $arg && 0 < riode_get_layout_value( 'inner_bottom_block', 'id' ) ) {
			$block_name = sanitize_text_field( riode_get_layout_value( 'inner_bottom_block', 'id' ) );
			echo '<div class="inner-bottom-block">';
		} elseif ( RIODE_AFTER_CONTENT == $arg && 0 < riode_get_layout_value( 'bottom_block', 'id' ) ) {
			$block_name = sanitize_text_field( riode_get_layout_value( 'bottom_block', 'id' ) );
			echo '<div class="bottom-block">';
		}

		riode_print_template( $block_name );

		if ( $block_name ) {
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'riode_print_layout_before' ) ) {
	function riode_print_layout_before() {
		if ( 'full' != riode_get_layout_value( 'general', 'wrap' ) ) {
			echo '<div class="' . esc_attr( 'container' == riode_get_layout_value( 'general', 'wrap' ) ? 'container' : 'container-fluid' ) . '">';
		}

		do_action( 'riode_before_main_content' );

		$ls        = false; // state of left sidebar
		$rs        = false; // state of right sidebar
		$ls_canvas = false; // on_canvas/off_canvas
		$rs_canvas = false; // on_canvas/off_canvas

		if ( is_active_sidebar( riode_get_layout_value( 'left_sidebar', 'id' ) ) ) {
			$ls = true;
			if ( 'control' != riode_get_layout_value( 'left_sidebar', 'type' ) || 'in' == riode_get_layout_value( 'left_sidebar', 'place' ) ) {
				$ls_canvas = true;
			}
		}

		if ( is_active_sidebar( riode_get_layout_value( 'right_sidebar', 'id' ) ) ) {
			$rs = true;
			if ( 'control' != riode_get_layout_value( 'right_sidebar', 'type' ) || 'in' == riode_get_layout_value( 'right_sidebar', 'place' ) ) {
				$rs_canvas = true;
			}
		}

		if ( $ls ) {
			ob_start();

			riode_get_template_part(
				RIODE_PART . '/sidebar',
				null,
				array(
					'layout_slug' => riode_get_layout_value( 'slug' ),
					'sidebar'     => riode_get_layout_value( 'left_sidebar' ),
					'container'   => riode_get_layout_value( 'general', 'wrap' ),
					'pos'         => 'left',
				)
			);

			$ls = ob_get_clean();
		}

		$col_class = '';

		if ( $ls && ! $ls_canvas ) {
			echo riode_escaped( $ls );
		}

		if ( $ls_canvas || $rs_canvas ) {
			if ( $ls_canvas && $rs_canvas ) {
				$col_class = ' col-lg-6';
			} else {
				$col_class = ' col-lg-9';
			}
			echo '<div class="row gutter-lg main-content-wrap">';
		}

		if ( $ls && $ls_canvas ) {
			echo riode_escaped( $ls );
		}

		echo '<div class="' . esc_attr( apply_filters( 'riode_main_content_class', 'main-content' . $col_class ) ) . '">';

		$ts = ( 'product_archive_layout' == riode_get_layout_value( 'slug' ) ) && is_active_sidebar( riode_get_layout_value( 'top_sidebar', 'id' ) );

		if ( ! $ts ) {
			do_action( 'riode_before_inner_content', RIODE_BEFORE_INNER_CONTENT );
		}
	}
}

if ( ! function_exists( 'riode_print_layout_after' ) ) {
	function riode_print_layout_after( $comment_template = true ) {
		$ts = ( 'product_archive_layout' == riode_get_layout_value( 'slug' ) ) && is_active_sidebar( riode_get_layout_value( 'top_sidebar', 'id' ) );

		do_action( 'riode_after_inner_content', RIODE_AFTER_INNER_CONTENT );

		echo '</div>'; // End of main content wrap

		$ls        = false; // state of left sidebar
		$rs        = false; // state of right sidebar
		$ls_canvas = false; // on_canvas/off_canvas
		$rs_canvas = false; // on_canvas/off_canvas

		if ( is_active_sidebar( riode_get_layout_value( 'left_sidebar', 'id' ) ) ) {
			$ls = true;

			if ( 'control' != riode_get_layout_value( 'left_sidebar', 'type' ) || 'in' == riode_get_layout_value( 'left_sidebar', 'place' ) ) {
				$ls_canvas = true;
			}
		}
		if ( is_active_sidebar( riode_get_layout_value( 'right_sidebar', 'id' ) ) ) {
			$rs = true;

			if ( 'control' != riode_get_layout_value( 'right_sidebar', 'type' ) || 'in' == riode_get_layout_value( 'right_sidebar', 'place' ) ) {
				$rs_canvas = true;
			}
		}

		if ( $rs ) {
			ob_start();

			riode_get_template_part(
				RIODE_PART . '/sidebar',
				null,
				array(
					'layout_slug' => riode_get_layout_value( 'slug' ),
					'sidebar'     => riode_get_layout_value( 'right_sidebar' ),
					'container'   => riode_get_layout_value( 'general', 'wrap' ),
					'pos'         => 'right',
				)
			);

			$rs = ob_get_clean();
		}

		if ( $rs && $rs_canvas ) {
			echo riode_escaped( $rs );
		}
		if ( $ls_canvas || $rs_canvas ) {
			echo '</div>';
		}
		if ( $rs && ! $rs_canvas ) {
			echo riode_escaped( $rs );
		}

		do_action( 'riode_after_main_content' );

		if ( $comment_template && is_page() && ! riode_is_shop() ) {
			comments_template();
		}

		if ( 'full' != riode_get_layout_value( 'general', 'wrap' ) ) { // end of container or container-fluid
			echo '</div>';
		}
	}
}


if ( ! function_exists( 'riode_comment_form_before_fields' ) ) {
	function riode_comment_form_before_fields() {
		echo '<div class="row">';
	}
}

if ( ! function_exists( 'riode_comment_form_after_fields' ) ) {
	function riode_comment_form_after_fields() {
		echo '</div>';
	}
}

if ( ! function_exists( 'riode_set_avatar_size' ) ) {
	function riode_set_avatar_size( $args ) {
		$args['size']   = 80;
		$args['width']  = 80;
		$args['height'] = 80;
		return $args;
	}
}

if ( ! function_exists( 'riode_author_date_pattern' ) ) {
	function riode_author_date_pattern( $date ) {
		return date( 'F j, Y \a\t g:s a', strtotime( $date ) );
	}
}

if ( ! function_exists( 'riode_set_cookies' ) ) {
	function riode_set_cookies() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

		if ( ! empty( $_GET['top_filter'] ) ) {
			setcookie( 'top_filter', sanitize_title( $_GET['top_filter'] ), time() + ( 86400 ), '/' );
			$_COOKIE['riode_top_filter'] = esc_html( $_GET['top_filter'] );
		}

		// phpcs:enable
	}
}


/*******************************
	*                          *
	*   Riode Ajax Actions  *
	*                          *
	*/

if ( ! function_exists( 'riode_loadmore' ) ) {
	function riode_loadmore() {

		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

		if ( isset( $_POST['args'] ) && isset( $_POST['props'] ) ) {
			$args  = $_POST['args'];
			$props = $_POST['props'];

			if ( 'post' === $args['post_type'] ) {
				/**
				 * Load more posts
				 */
				$posts = new WP_Query( $args );
				if ( $posts ) {

					ob_start();
					while ( $posts->have_posts() ) {
						$posts->the_post();
						if ( function_exists( 'riode_get_template_part' ) ) {
							riode_get_template_part(
								RIODE_PART . '/posts/post',
								null,
								$props
							);
						}
					}
					$html = ob_get_clean();

					if ( $_POST['pagination'] ) {
						echo json_encode(
							array(
								'html'       => $html,
								'pagination' => riode_get_pagination( $posts, 'pagination-load' ),
							)
						);
					} else {
						echo riode_escaped( $html );
					}
					wp_reset_postdata();
				}
			} else {
				/**
				 * Load more products
				 */
				$args  = $_POST['args'];
				$props = $_POST['props'];

				if ( isset( $args['paged'] ) && $args['paged'] ) {
					$args['page'] = $args['paged'];
					unset( $args['paged'] );
				}

				if ( isset( $args['total'] ) && $args['total'] ) {
					unset( $args['total'] );
				}

				wc_set_loop_prop( 'riode_ajax_load', true );

				foreach ( $props as $key => $prop ) {
					wc_set_loop_prop( $key, $prop );
				}

				$args_str = '';
				foreach ( $args as $key => $value ) {
					$args_str .= ' ' . $key . '=' . json_encode( $value );
				}

				$html = do_shortcode( '[products' . $args_str . ']' );

				echo riode_escaped( $html );
			}
		}

		exit;

		// phpcs:enable
	}
}


// ajax sign in / sign up form
if ( ! function_exists( 'riode_ajax_account_form' ) ) {
	function riode_ajax_account_form() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

		echo wc_get_template_part( 'myaccount/form-login' );

		exit();

		// phpcs:enable
	}
}

// sign in ajax validate
function riode_account_signin_validate() {
	$nonce_value = wc_get_var( $_REQUEST['woocommerce-login-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.
	$result      = false;
	if ( wp_verify_nonce( $nonce_value, 'woocommerce-login' ) ) {
		try {
			$creds = array(
				'user_login'    => trim( $_POST['username'] ),
				'user_password' => $_POST['password'],
				'remember'      => isset( $_POST['rememberme'] ),
			);

			$validation_error = new WP_Error();
			$validation_error = apply_filters( 'woocommerce_process_login_errors', $validation_error, $_POST['username'], $_POST['password'] );

			if ( $validation_error->get_error_code() ) {
				echo json_encode(
					array(
						'loggedin' => false,
						'message'  => '<strong>' . esc_html__(
							'Error:',
							'riode'
						) . '</strong> ' . $validation_error->get_error_message(),
					)
				);
				die();
			}

			if ( empty( $creds['user_login'] ) ) {
				echo json_encode(
					array(
						'loggedin' => false,
						'message'  => '<strong>' . esc_html__(
							'Error:',
							'riode'
						) . '</strong> ' . esc_html__(
							'Username is required.',
							'riode'
						),
					)
				);
				die();
			}

			// On multisite, ensure user exists on current site, if not add them before allowing login.
			if ( is_multisite() ) {
				$user_data = get_user_by( is_email( $creds['user_login'] ) ? 'email' : 'login', $creds['user_login'] );

				if ( $user_data && ! is_user_member_of_blog( $user_data->ID, get_current_blog_id() ) ) {
					add_user_to_blog( get_current_blog_id(), $user_data->ID, 'customer' );
				}
			}

			// Perform the login
			$user = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), is_ssl() );
			if ( ! is_wp_error( $user ) ) {
				$result = true;
			}
		} catch ( Exception $e ) {
		}
	}
	if ( $result ) {
		echo json_encode(
			array(
				'loggedin' => true,
				'message'  => esc_html__(
					'Login successful, redirecting...',
					'riode'
				),
			)
		);
	} else {
		echo json_encode(
			array(
				'loggedin' => false,
				'message'  => esc_html__(
					'Wrong username or password.',
					'riode'
				),
			)
		);
	}
	die();
}

// sign up ajax validate
function riode_account_signup_validate() {

	$nonce_value = isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '';
	$nonce_value = isset( $_POST['woocommerce-register-nonce'] ) ? $_POST['woocommerce-register-nonce'] : $nonce_value;
	$result      = true;

	if ( wp_verify_nonce( $nonce_value, 'woocommerce-register' ) ) {
		$username = 'no' === get_option( 'woocommerce_registration_generate_username' ) ? $_POST['username'] : '';
		$password = 'no' === get_option( 'woocommerce_registration_generate_password' ) ? $_POST['password'] : '';
		$email    = $_POST['email'];

		try {
			$validation_error = new WP_Error();
			$validation_error = apply_filters( 'woocommerce_process_registration_errors', $validation_error, $username, $password, $email );

			if ( $validation_error->get_error_code() ) {
				echo json_encode(
					array(
						'loggedin' => false,
						'message'  => $validation_error->get_error_message(),
					)
				);
				die();
			}

			$new_customer = wc_create_new_customer( sanitize_email( $email ), wc_clean( $username ), $password );

			if ( is_wp_error( $new_customer ) ) {
				echo json_encode(
					array(
						'loggedin' => false,
						'message'  => $new_customer->get_error_message(),
					)
				);
				die();
			}

			if ( apply_filters( 'woocommerce_registration_auth_new_customer', true, $new_customer ) ) {
				wc_set_customer_auth_cookie( $new_customer );
			}
		} catch ( Exception $e ) {
			$result = false;
		}
	}
	if ( $result ) {
		echo json_encode(
			array(
				'loggedin' => true,
				'message'  => esc_html__(
					'Register successful, redirecting...',
					'riode'
				),
			)
		);
	} else {
		echo json_encode(
			array(
				'loggedin' => false,
				'message'  => esc_html__(
					'Register failed.',
					'riode'
				),
			)
		);
	}
	die();
}

if ( ! function_exists( 'riode_load_mobile_menu' ) ) {
	function riode_load_mobile_menu() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification
		?>

		<!-- Search Form -->
		<div class="mobile-menu">
			<div class="search-wrapper hs-simple">
				<form action="<?php echo esc_url( home_url() ); ?>/" method="get" class="input-wrapper">
					<input type="hidden" name="post_type" value="<?php echo esc_attr( class_exists( 'WooCommerce' ) ? 'product' : 'post' ); ?>"/>
					<input type="search" class="form-control" name="s" placeholder="<?php esc_attr_e( 'Search your keywords...', 'riode' ); ?>" required="" autocomplete="off">

					<?php if ( riode_get_option( 'live_search' ) ) : ?>
						<div class="live-search-list"></div>
					<?php endif; ?>

					<button class="btn btn-search" type="submit">
						<i class="d-icon-search"></i>
					</button> 
				</form>
			</div>

		<?php

		$mobile_menus = riode_get_option( 'mobile_menu_items' );

		if ( ! empty( $mobile_menus ) ) {
			echo '<div class="nav-wrapper" data-menu-arrange="' . riode_get_option( 'mobile_menu_type' ) . '">';

			ob_start();
			foreach ( $mobile_menus as $menu ) {
				if ( empty( $menu ) ) {
					continue;
				}
				$menu_name = $menu;

				if ( is_numeric( $menu ) ) {
					$menu_obj = get_term( $menu, 'nav_menu' );
					if ( ! $menu_obj || is_wp_error( $menu_obj ) ) {
						continue;
					}
					$menu_name = $menu_obj->name;
				}

				wp_nav_menu(
					array(
						'menu'            => $menu,
						'container'       => 'nav',
						'container_class' => $menu_name,
						'items_wrap'      => '<ul id="%1$s" class="mobile-menu">%3$s</ul>',
						'walker'          => new Riode_Walker_Nav_Menu(),
						'theme_location'  => '',
						'fallback_cb'     => '__return_false',
						'mobile'          => true,
					)
				);
			}
			$mobile_menu_html_escaped = ob_get_clean();

			if ( $mobile_menu_html_escaped ) {
				echo riode_strip_script_tags( $mobile_menu_html_escaped );
			} else {
				echo '<nav><ul class="mobile-menu"></ul></nav>';
			}

			echo '</div>';
		}

		echo '</div>';

		if ( riode_doing_ajax() && $_REQUEST['action'] && 'riode_load_mobile_menu' == $_REQUEST['action'] ) {
			die;
		}

		// phpcs:enable
	}
}

// Riode Contact Form Functions
if ( ! function_exists( 'riode_wpcf7_add_form_tag_submit' ) ) {
	function riode_wpcf7_add_form_tag_submit() {
		wpcf7_remove_form_tag( 'submit' );
		wpcf7_add_form_tag( 'submit', 'riode_wpcf7_submit_form_tag_handler' );
	}
}
if ( ! function_exists( 'riode_wpcf7_submit_form_tag_handler' ) ) {
	function riode_wpcf7_submit_form_tag_handler( $tag ) {
		$class = wpcf7_form_controls_class( $tag->type );

		$atts = array();

		$atts['class']    = $tag->get_class_option( $class );
		$atts['id']       = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

		$value = isset( $tag->values[0] ) ? $tag->values[0] : '';

		if ( empty( $value ) ) {
			$value = esc_html__( 'Send', 'riode' );
		}

		$atts['type']  = 'submit';
		$atts['value'] = $value;

		$atts = wpcf7_format_atts( $atts );

		$html = sprintf( '<button %1$s>%2$s</button>', $atts, esc_html( $value ) );

		return $html;
	}
}
function riode_wpcf7_form_novalidate() {
	return '';
}

// Riode Widget Compatability Functions
if ( ! function_exists( 'riode_widget_nav_menu_args' ) ) {
	function riode_widget_nav_menu_args( $nav_menu_args, $menu, $args, $instance ) {
		$nav_menu_args['items_wrap'] = '<ul id="%1$s" class="menu collapsible-menu">%3$s</ul>';
		return $nav_menu_args;
	}
}

/**
 * Riode Comment Form Functions
 */
if ( ! function_exists( 'riode_comment_form_args' ) ) {
	function riode_comment_form_args( $args ) {
		$page_type = riode_get_layout_value( 'slug' );

		$args['title_reply_before'] = '<h3 id="reply-title" class="comment-reply-title">';
		$args['title_reply_after']  = '</h3>';
		$args['fields']['author']   = '<div class="col-md-6"><input name="author" type="text" class="form-control" value="" placeholder="' . esc_attr__( 'Name', 'riode' ) . '*"> </div>';
		$args['fields']['email']    = '<div class="col-md-6"><input name="email" type="text" class="form-control" value="" placeholder="' . esc_attr__( 'Email', 'riode' ) . '*"> </div>';

		$args['comment_field']  = isset( $args['comment_field'] ) ? $args['comment_field'] : '';
		$args['comment_field']  = substr( $args['comment_field'], 0, strpos( $args['comment_field'], '<p class="comment-form-comment">' ) );
		$args['comment_field'] .= '<textarea name="comment" id="comment" class="form-control" rows="6" maxlength="65525" required="required" placeholder="' . esc_attr__( 'Comment', 'riode' ) . '*"></textarea>';
		$args['submit_button']  = '<button type="submit" class="btn btn-dark btn-submit">' .
			( 'product_single_layout' == $page_type ? esc_html__( 'Submit', 'riode' ) : esc_html__( 'Post Comment', 'riode' ) ) .
			'<i class="d-icon-arrow-' . ( is_rtl() ? 'left' : 'right' ) . '"></i>' . '</button>';

		return $args;
	}
}

// print popup template when specific selector is clicked
if ( ! function_exists( 'riode_ajax_print_popup' ) ) {
	function riode_ajax_print_popup() {
		// check_ajax_referer( 'riode-nonce', 'nonce' );
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

		$id = isset( $_POST['popup_id'] ) ? $_POST['popup_id'] : 0;

		if ( $id ) {
			riode_print_popup_template( $id, '', '' );
		}

		// phpcs:enable
		exit();
	}
}
