<?php
/**
 * Riode WooCommerce Functions
 *
 * Functions related to WooCommerce Plugin
 *
 * @package riode/woocommerce
 * @author d-themes
 *
 * @since 1.0.0
 *
 * @version 1.4.3 Modify woocommerce store notification hooks.
 */

defined( 'ABSPATH' ) || die;

// Woocommerce Mini Cart
add_filter( 'woocommerce_add_to_cart_fragments', 'riode_wc_add_to_cart_fragment' );
add_action( 'wp_ajax_riode_cart_item_remove', 'riode_wc_cart_item_remove' );
add_action( 'wp_ajax_nopriv_riode_cart_item_remove', 'riode_wc_cart_item_remove' );
add_action( 'wp_ajax_riode_add_to_cart', 'riode_wc_add_to_cart' );
add_action( 'wp_ajax_nopriv_riode_add_to_cart', 'riode_wc_add_to_cart' );

// Woocommerce Cart
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
add_action( 'woocommerce_widget_shopping_cart_buttons', 'riode_wc_widget_shopping_cart_button_view_cart', 10 );
add_action( 'woocommerce_widget_shopping_cart_buttons', 'riode_wc_widget_shopping_cart_proceed_to_checkout', 20 );

// Woocommerce Breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'riode_action_print_breadcrumb', 'woocommerce_breadcrumb' );
add_filter( 'woocommerce_breadcrumb_defaults', 'riode_wc_breadcrumb_args' );

// Woocommerce Notice Skin
add_filter( 'wc_add_to_cart_message_html', 'riode_wc_add_to_cart_message_html' );
add_filter( 'riode_wc_notice_class', 'riode_wc_notice_class', 10, 3 );
add_action( 'riode_wc_before_notice', 'riode_wc_notice_action', 10, 2 );
add_action( 'riode_wc_after_notice', 'riode_wc_notice_close', 10, 2 );

// Woocommerce Checkout Page
add_filter( 'woocommerce_default_address_fields', 'riode_wc_address_fields_change_form_row' );
add_filter( 'woocommerce_billing_fields', 'riode_wc_billing_fields_change_form_row' );
add_filter( 'woocommerce_form_field_args', 'riode_wc_form_field_args' );

// Woocommerce Cart Page
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'riode_wc_after_cart_form', 'woocommerce_cross_sell_display' );

// YITH Wishlist Page
add_filter( 'yith_wcwl_edit_title_icon', 'riode_yith_wcwl_edit_title_icon' );
add_filter( 'yith_wcwl_wishlist_params', 'riode_yith_wcwl_wishlist_params', 10, 5 );

// YITH Wishlist Remove Notice
if ( class_exists( 'WooCommerce' ) && defined( 'YITH_WCWL' ) ) {
	add_action( 'wp_ajax_remove_from_wishlist', 'riode_yith_wcwl_before_remove_notice', 3 );
	add_action( 'wp_ajax_nopriv_remove_from_wishlist', 'riode_yith_wcwl_before_remove_notice', 3 );
	add_action( 'wp', 'riode_yith_wcwl_remove_notice' );
	add_action( 'wp_ajax_riode_account_form', 'riode_yith_wcwl_remove_notice', 5 );
	add_action( 'wp_ajax_nopriv_riode_account_form', 'riode_yith_wcwl_remove_notice', 5 );
}

// YITH ajax filter
add_filter( 'yith_wcan_list_type_empty_filter_class', 'riode_yith_empty_filter_class' );
add_filter( 'yith_wcwl_localize_script', 'riode_yith_wcwl_localize_script' );

// YITH Mini Wishlist
add_action( 'wp_ajax_riode_update_mini_wishlist', 'riode_yith_update_mini_wishlist' );
add_action( 'wp_ajax_nopriv_riode_update_mini_wishlist', 'riode_yith_update_mini_wishlist' );

/**
 * Modify WooCommerce Store Notification Hooks.
 *
 * @since 1.4.3
 */
remove_action( 'wp_footer', 'woocommerce_demo_store' );
add_action( 'wp_body_open', 'woocommerce_demo_store', 1 );

if ( ! function_exists( 'riode_wc_add_to_cart_fragment' ) ) {
	/**
 * Riode Woocommerce Mini Cart Functions
	 *
	 * @since 1.0.0
	 * @param array $fragments
	 * @return array
 */
	function riode_wc_add_to_cart_fragment( $fragments ) {
		$_cart_total                           = WC()->cart->get_cart_subtotal();
		$fragments['.cart-toggle .cart-price'] = '<span class="cart-price">' . $_cart_total . '</span>';
		$_cart_qty                             = WC()->cart->cart_contents_count;
		$_cart_qty                             = ( $_cart_qty > 0 ? $_cart_qty : '0' );
		$fragments['.cart-toggle .cart-count'] = '<span class="cart-count">' . ( (int) $_cart_qty ) . '</span>';
		return $fragments;
	}
}

if ( ! function_exists( 'riode_wc_add_to_cart' ) ) {
	/**
	 * AJAX add to cart.
	 */
	function riode_wc_add_to_cart() {
		ob_start();

		// phpcs:disable WordPress.Security.NonceVerification.Missing
		if ( ! isset( $_POST['product_id'] ) ) {
			return;
		}

		$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$product           = wc_get_product( $product_id );
		$quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( wp_unslash( $_POST['quantity'] ) );
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
		$product_status    = get_post_status( $product_id );
		$variation_id      = 0;
		$variation         = array();

		if ( $product && 'variation' === $product->get_type() ) {
			$variation_id = $product_id;
			$product_id   = $product->get_parent_id();
			$variation    = $product->get_variation_attributes();
			if ( ! empty( $variation ) ) {
				foreach ( $variation as $k => $v ) {
					if ( empty( $v ) && ! empty( $_REQUEST[ $k ] ) ) {
						$variation[ $k ] = wp_unslash( $_REQUEST[ $k ] );
					}
				}
			}
		}

		if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) && 'publish' === $product_status ) {

			do_action( 'woocommerce_ajax_added_to_cart', $product_id );

			if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
				wc_add_to_cart_message( array( $product_id => $quantity ), true );
			}

			WC_AJAX::get_refreshed_fragments();

		} else {

			// If there was an error adding to the cart, redirect to the product page to show any errors.
			$data = array(
				'error'       => true,
				'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
			);

			wp_send_json( $data );
		}
		// phpcs:enable
	}
}

if ( ! function_exists( 'riode_wc_cart_item_remove' ) ) {
	function riode_wc_cart_item_remove() {
		//check_ajax_referer( 'riode-nonce', 'nonce' );
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification
		$cart         = WC()->instance()->cart;
		$cart_id      = sanitize_text_field( $_POST['cart_id'] );
		$cart_item_id = $cart->find_product_in_cart( $cart_id );
		if ( $cart_item_id ) {
			$cart->set_quantity( $cart_item_id, 0 );
		}
		$cart_ajax = new WC_AJAX();
		$cart_ajax->get_refreshed_fragments();
		// phpcs:enable
		exit();
	}
}

if ( ! function_exists( 'riode_wc_widget_shopping_cart_button_view_cart' ) ) {
	function riode_wc_widget_shopping_cart_button_view_cart() {
		echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward btn btn-link">' . esc_html__( 'View Cart', 'riode' ) . '</a>';
	}
}

if ( ! function_exists( 'riode_wc_widget_shopping_cart_proceed_to_checkout' ) ) {
	function riode_wc_widget_shopping_cart_proceed_to_checkout() {
		echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button checkout wc-forward btn btn-dark btn-md btn-block">' . esc_html__( 'Go To Checkout', 'riode' ) . '</a>';
	}
}

/**
 * Riode Woocommerce Breadcrumb Functions
 */
if ( ! function_exists( 'riode_wc_breadcrumb_args' ) ) {
	function riode_wc_breadcrumb_args( $args ) {
		$delimiter          = riode_strip_script_tags( riode_get_option( 'ptb_delimiter' ) );
		$delimiter_use_icon = boolval( riode_get_option( 'ptb_delimiter_use_icon' ) );
		$delimiter_icon     = esc_attr( riode_get_option( 'ptb_delimiter_icon' ) );
		$home_icon          = riode_get_option( 'ptb_home_icon' );
		$extra_class        = '';

		if ( $delimiter_use_icon ) {
			$delimiter = '<i class="' . $delimiter_icon . '"></i>';
		}

		if ( ! $delimiter ) {
			$delimiter = '/';
		}

		if ( $home_icon ) {
			$args['home'] = '<i class="d-icon-home"></i>';
			$extra_class .= ' home-icon';
		}

		$args['delimiter']   = '<li class="delimiter">' . $delimiter . '</li>';
		$args['wrap_before'] = '<ul class="breadcrumb' . $extra_class . '">';
		$args['wrap_after']  = '</ul>';
		$args['before']      = '<li>';
		$args['after']       = '</li>';

		return apply_filters( 'riode_breadcrumb_args', $args );
	}
}

/**
 * Woocommerce Notice Skin
 */
if ( ! function_exists( 'riode_wc_add_to_cart_message_html' ) ) {
	function riode_wc_add_to_cart_message_html( $message ) {
		return str_replace( 'button wc-forward', 'btn btn-success btn-md', $message );
	}
}
if ( ! function_exists( 'riode_wc_notice_class' ) ) {
	function riode_wc_notice_class( $class, $notice, $type ) {

		if ( strpos( $notice['notice'], 'btn' ) ) {
			$class .= ' alert alert-simple alert-btn alert-' . ( 'info' == $type ? 'primary' : esc_attr( $type ) );
		} else {
			$class .= ' alert alert-simple alert-icon alert-' . ( 'info' == $type ? 'primary' : esc_attr( $type ) );
		}

		return $class;
	}
}
if ( ! function_exists( 'riode_wc_notice_action' ) ) {
	function riode_wc_notice_action( $notice, $type ) {
		if ( ! strpos( $notice['notice'], 'btn' ) ) {
			if ( 'success' == $type ) {
				echo '<i class="fas fa-check"></i>';
			} elseif ( 'notice' == $type ) {
				echo '<i class="fas fa-exclamation-circle"></i>';
			} elseif ( 'error' == $type ) {
				echo '<i class="fas fa-exclamation-triangle"></i>';
			}
		}
	}
}
if ( ! function_exists( 'riode_wc_notice_close' ) ) {
	function riode_wc_notice_close() {
		echo '<button type="button" class="btn btn-link btn-close"><i class="close-icon"></i></button>';
	}
}

/**
 * Riode Woocommerce Checkout Page Functions
 */
if ( ! function_exists( 'riode_wc_address_fields_change_form_row' ) ) {
	function riode_wc_address_fields_change_form_row( $fields ) {
		if ( ! is_cart() ) {
			$fields['city']['class']     = array( 'form-row-first', 'address-field' );
			$fields['state']['class']    = array( 'form-row-last', 'address-field' );
			$fields['postcode']['class'] = array( 'form-row-first', 'address-field' );
		}
		return $fields;
	}
}

if ( ! function_exists( 'riode_wc_billing_fields_change_form_row' ) ) {
	function riode_wc_billing_fields_change_form_row( $fields ) {
		if ( ! is_cart() ) {
			$fields['billing_phone']['class'] = array( 'form-row-last' );
		}
		return $fields;
	}
}

if ( ! function_exists( 'riode_wc_form_field_args' ) ) {
	function riode_wc_form_field_args( $args ) {
		$args['custom_attributes']['rows'] = 5;
		return $args;
	}
}


/**
 * Riode Woocommerce Cart Page Functions
 */

/**
 * Riode YITH Wishlist Page Functions
 */
if ( ! function_exists( 'riode_yith_wcwl_edit_title_icon' ) ) {
	function riode_yith_wcwl_edit_title_icon( $icon ) {
		return '<i class="fas fa-pencil-alt"></i>';
	}
}

if ( ! function_exists( 'riode_yith_wcwl_wishlist_params' ) ) {
	function riode_yith_wcwl_wishlist_params( $additional_params, $action, $action_params, $pagination, $per_page ) {
		global $riode_social_icon;

		$additional_params['share_atts']['share_facebook_icon']  = '<i class="' . $riode_social_icon['facebook'][0] . '"></i>';
		$additional_params['share_atts']['share_twitter_icon']   = '<i class="' . $riode_social_icon['twitter'][0] . '"></i>';
		$additional_params['share_atts']['share_pinterest_icon'] = '<i class="' . $riode_social_icon['pinterest'][0] . '"></i>';
		$additional_params['share_atts']['share_email_icon']     = '<i class="' . $riode_social_icon['email'][0] . '"></i>';
		$additional_params['share_atts']['share_whatsapp_icon']  = '<i class="' . $riode_social_icon['whatsapp'][0] . '"></i>';

		return $additional_params;
	}
}

if ( ! function_exists( 'riode_yith_wcwl_localize_script' ) ) {
	function riode_yith_wcwl_localize_script( $variables ) {
		$variables['labels']['added_to_cart_message'] = sprintf( '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message alert alert-simple alert-icon alert-success" role="alert"><i class="fas fa-check"></i>%s<button type="button" class="btn btn-link btn-close"><i class="close-icon"></i></button></div></div>', apply_filters( 'yith_wcwl_added_to_cart_message', esc_html__( 'Product added to cart successfully', 'yith-woocommerce-wishlist' ) ) );
		return $variables;
	}
}

/**
 * YITH Wishlist Remove Notice
 */
if ( ! function_exists( 'riode_yith_wcwl_before_remove_notice' ) ) {
	function riode_yith_wcwl_before_remove_notice() {
		if ( ! isset( $_REQUEST['context'] ) || 'frontend' != $_REQUEST['context'] ) {
			wc_add_notice( 'riode_yith_wcwl_before_remove_notice' );
		}
	}
}

if ( ! function_exists( 'riode_yith_wcwl_remove_notice' ) ) {
	function riode_yith_wcwl_remove_notice() {
		if ( WC()->session ) {
			$notices = WC()->session->get( 'wc_notices', array() );
			if ( ! empty( $notices['success'] ) ) {
				$cnt = count( $notices['success'] );

				for ( $i = 0; $i < $cnt; ++$i ) {
					if ( isset( $notices['success'][ $i ]['notice'] ) && 'riode_yith_wcwl_before_remove_notice' == $notices['success'][ $i ]['notice'] ) {
						if ( $i < $cnt-- ) {
							array_splice( $notices['success'], $i, 1 );
							if ( $i < $cnt-- ) {
								array_splice( $notices['success'], $i, 1 );
							}
							-- $i;
						}
					}
				}

				WC()->session->set( 'wc_notices', $notices );
			}
		}
	}
}

/**
 * Riode YITH Ajax Filter Functions
 */
if ( ! function_exists( 'riode_yith_empty_filter_class' ) ) {
	function riode_yith_empty_filter_class( $class ) {
		if ( empty( $class ) ) {
			return 'class="empty"';
		} else {
			return substr( $class, 0, -1 ) . ' empty' . "'";
		}
	}
}

/**
 * WooCommerce Top Sidebar
 * prints top sidebar including order by, show count and view mode in search result page.
 */
if ( ! function_exists( 'riode_wc_shop_top_sidebar' ) ) {
	function riode_wc_shop_top_sidebar() {
		$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
		$catalog_orderby_options = apply_filters(
			'woocommerce_catalog_orderby',
			array(
				'menu_order' => esc_html__( 'Default sorting', 'woocommerce' ),
				'popularity' => esc_html__( 'Sort by popularity', 'woocommerce' ),
				'rating'     => esc_html__( 'Sort by average rating', 'woocommerce' ),
				'date'       => esc_html__( 'Sort by latest', 'woocommerce' ),
				'price'      => esc_html__( 'Sort by price: low to high', 'woocommerce' ),
				'price-desc' => esc_html__( 'Sort by price: high to low', 'woocommerce' ),
			)
		);

		$default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		$orderby = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby;
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		if ( wc_get_loop_prop( 'is_search' ) ) {
			$catalog_orderby_options = array_merge( array( 'relevance' => esc_html__( 'Relevance', 'woocommerce' ) ), $catalog_orderby_options );

			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( ! $show_default_orderby ) {
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( ! wc_review_ratings_enabled() ) {
			unset( $catalog_orderby_options['rating'] );
		}

		if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
			$orderby = current( array_keys( $catalog_orderby_options ) );
		}

		wc_get_template(
			'loop/orderby.php',
			array(
				'catalog_orderby_options' => $catalog_orderby_options,
				'orderby'                 => $orderby,
				'show_default_orderby'    => $show_default_orderby,
			)
		);
	}
}

if ( ! function_exists( 'riode_yith_update_mini_wishlist' ) ) {
	/**
	 * riode_yith_update_mini_wishlist
	 *
	 * update mini wishlit when product is added or removed
	 *
	 * @since 1.4.0
	 */
	function riode_yith_update_mini_wishlist() {
		ob_start();

		riode_get_template_part(
			RIODE_PART . '/header/elements/element-wishlist',
			null,
			array(
			'miniwishlist' => true,
			'show_count'   => true,
			'show_icon'    => true,
			)
		);

		wp_send_json( ob_get_clean() );
	}
}