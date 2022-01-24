<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-account.php
 */

riode_add_async_script( 'jquery-magnific-popup' );

$items            = isset( $items ) ? $items : array();
$login_text       = isset( $login_text ) ? $login_text : '';
$register_text    = isset( $register_text ) ? $register_text : '';
$delimiter_text   = isset( $delimiter_text ) ? $delimiter_text : '';
$type             = isset( $type ) ? ( $type ? $type . '-type' : '' ) : ( 'block' == riode_get_option( 'account_type' ) ? ' block-type' : '' );
$icon             = isset( $icon ) ? $icon : '';
$account_dropdown = isset( $account_dropdown ) ? $account_dropdown : '';
$logout_text      = isset( $logout_text ) ? $logout_text : '';
$account_avatar   = isset( $account_avatar ) ? $account_avatar : '';

$logout_link   = '';
$login_link    = '';
$register_link = '';
$html          = '';
$extra_class   = '';

if ( is_user_logged_in() ) {
	if ( class_exists( 'WooCommerce' ) ) {
		$logout_link = wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) );
	} else {
		$logout_link = wp_logout_url( get_home_url() );
	}

	$html .= '<a class="login logout ' . $type . '" href="' . esc_url( $logout_link ) . '">';
	if ( in_array( 'icon', $items ) ) {
		if ( $account_avatar ) {
			$html .= '<span class="account-avatar">' . get_avatar( get_current_user_id() ) . '</span>';
		} else {
			$html .= '<i class="' . esc_attr( $icon ) . '"></i>';
		}
	}
	if ( in_array( 'login', $items ) ) {
		$userdata = get_userdata( get_current_user_id() );
		if ( $logout_text ) {
			$html .= '<span>' . str_replace( '%name%', $userdata->data->display_name, $logout_text ) . '</span>';
		} else {
			$html .= '<span>' . $logout_text . '</span>';
		}
	}
	$html .= '</a>';

	if ( $account_dropdown ) {
		$extra_class = ' dropdown account-dropdown';

		if ( ! has_nav_menu( 'account-menu' ) ) {
			$html .= '<div class="dropdown-box menu">';
			$html .= '<ul id="menu-account-menu" class="menu vertical-menu">';
			foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
				$html .= '<li class="' . wc_get_account_menu_item_classes( $endpoint ) . ' menu-item">';
				$html .= '<a href="' . esc_url( wc_get_account_endpoint_url( $endpoint ) ) . '">' . esc_html( $label ) . '</a>';
				$html .= '</li>';
			endforeach;
			$html .= '</ul>';
			$html .= '</div>';
		} else {
			$html .= '<div class="dropdown-box">';
			ob_start();
			wp_nav_menu(
				array(
					'theme_location' => 'account-menu',
					'container'      => 'nav',
					'items_wrap'     => '<ul id="%1$s" class="menu vertical-menu">%3$s</ul>',
					'walker'         => new Riode_Walker_Nav_Menu(),
					'depth'          => 0,
					'lazy'           => false,
				)
			);
			$html .= ob_get_clean() . '</div>';
		}
	}
} else {
	if ( class_exists( 'WooCommerce' ) ) {
		$login_link = wc_get_page_permalink( 'myaccount' );
		if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
			$register_link = wc_get_page_permalink( 'myaccount' );
		}
	} else {
		$login_link    = wp_login_url( get_home_url() );
		$active_signup = get_site_option( 'registration', 'none' );
		$active_signup = apply_filters( 'wpmu_active_signup', $active_signup );
		if ( 'none' != $active_signup ) {
			$register_link = wp_registration_url( get_home_url() );
		}
	}

	$html .= '<a class="login ' . $type . '" href="' . esc_url( $login_link ) . '">';

	if ( in_array( 'icon', $items ) ) {
		$html .= '<i class="' . esc_attr( $icon ) . '"></i>';
	}


	if ( in_array( 'login', $items ) ) {
		$html .= '<span>' . $login_text . '</span>';
	}

	$html .= '</a>';

	if ( in_array( 'register', $items ) ) {
		if ( in_array( 'login', $items ) && $delimiter_text ) {
			$html .= '<span class="delimiter">' . $delimiter_text . '</span>';
		}

		$html .= '<a class="register ' . $type . '" href="' . ( $register_link ? esc_url( $login_link ) : esc_url( $register_link ) ) . '">';
		$html .= '<span>' . $register_text . '</span>';
		$html .= '</a>';
	}
}

echo '<div class="account' . esc_attr( $extra_class ) . '">' . $html . '</div>';
