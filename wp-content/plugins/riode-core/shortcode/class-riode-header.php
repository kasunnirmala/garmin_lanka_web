<?php
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

class Riode_Header extends Container implements Module {

	use EventsFilters;
	use WpFiltersActions;
	/**
	 * Riode_Header constructor.
	 */
	public function __construct() {
		
	}

	/**
	 * @param $variables
	 * @param $payload
	 *
	 * @return array
	 */
	protected function getWishlistUrl( $variables, $payload ) {
		if ( class_exists( 'YITH_WCWL' ) ) {
			$variables[] = array(
				'key'   => 'riodeWishlistUrl',
				'value' => YITH_WCWL()->get_wishlist_url(),
			);
			$variables[] = array(
				'key'   => 'riodeWishlistCount',
				'value' => yith_wcwl_count_products(),
			);
		}
		return $variables;
	}

	/**
	 * @param $variables
	 * @param $payload
	 *
	 * @return array
	 */
	protected function getCart( $variables, $payload ) {
			$variables[] = array(
				'key'   => 'riodeCartInfo',
				'value' => wc_get_page_permalink( 'cart' ),
			);
		return $variables;
	}
	/**
	 * @param $variables
	 * @param $payload
	 *
	 * @return array
	 */
	protected function getAccount( $variables, $payload ) {
		$variables[] = array(
			'key'   => 'riodeAccountInfo',
			'value' => 'account',
		);
		return $variables;
	}

	/**
	 * Add Compare List
	 *
	 * @since 1.2.0
	 * @return mixed|string
	 */
	protected function addCompare() {
		add_shortcode(
			'riode_compare',
			function ( $atts ) {

				$args = array(
					'type'        => isset( $atts['type'] ) ? $atts['type'] : 'inline',
					'show_icon'   => isset( $atts['show_icon'] ) ? $atts['show_icon'] : true,
					'show_count'  => isset( $atts['show_count'] ) ? $atts['show_count'] : true,
					'show_label'  => isset( $atts['show_label'] ) ? $atts['show_label'] : true,
					'icon'        => isset( $atts['icon']['value'] ) && $atts['icon']['value'] ? $atts['icon']['value'] : 'd-icon-compare',
					'label'       => isset( $atts['label'] ) ? $atts['label'] : 'Compare',
					'minicompare' => isset( $atts['minicompare'] ) ? $atts['minicompare'] : '',
				);

				ob_start();
				if ( defined( 'RIODE_VERSION' ) ) {
					riode_get_template_part( RIODE_PART . '/header/elements/element-compare', null, $args );
				}
				return ob_get_clean();
			}
		);
	}

	/**
	 * Add Search Form
	 *
	 *
	 * @return mixed|string
	 */
	protected function addSearchForm() {
		add_shortcode(
			'riode_search_form',
			function ( $atts ) {
				ob_start();
				$args = array(
					'aria_label' => array(
						'type'             => isset( $atts['type'] ) ? $atts['type'] : '',
						'fullscreen_type'  => isset( $atts['fullscreen_type'] ) ? $atts['fullscreen_type'] : 'fs-default',
						'fullscreen_style' => isset( $atts['fullscreen_style'] ) ? $atts['fullscreen_style'] : 'light',
						'where'            => 'header',
						'search_post_type' => isset( $atts['search_type'] ) ? $atts['search_type'] : '',
						'search_label'     => isset( $atts['label'] ) ? $atts['label'] : '',
						'search_category'  => isset( $atts['category'] ) ? $atts['category'] : '',
						'border_type'      => isset( $atts['border_type'] ) ? $atts['border_type'] : '',
						'placeholder'      => isset( $atts['placeholder'] ) ? $atts['placeholder'] : 'Search your keyword...',
						'search_right'     => false,
						'icon'             => isset( $atts['icon'] ) ? $atts['icon'] : 'd-icon-search',
					),
				);

				get_search_form( $args );
				return ob_get_clean();
			}
		);
	}
	/**
	 * Add Currency Swithcer
	 *
	 *
	 * @return mixed|string
	 */
	protected function addCurrency() {
		add_shortcode(
			'riode_currency',
			function ( $atts ) {
				ob_start();
				if ( defined( 'RIODE_VERSION' ) ) {
					riode_get_template_part( RIODE_PART . '/header/elements/element-currency-switcher' );
				}
				return ob_get_clean();
			}
		);
	}
	/**
	 * Add Language Swithcer
	 *
	 *
	 * @return mixed|string
	 */
	protected function addLanguage() {
		add_shortcode(
			'riode_language',
			function ( $atts ) {
				ob_start();
				if ( defined( 'RIODE_VERSION' ) ) {
					riode_get_template_part( RIODE_PART . '/header/elements/element-language-switcher' );
				}
				return ob_get_clean();
			}
		);
	}
	/**
	 * Add Account
	 *
	 *
	 * @return mixed|string
	 */
	protected function addAccount() {
		add_shortcode(
			'riode_account',
			function ( $atts ) {
				ob_start();
				$items = array();
				if ( isset( $atts['account_items'] ) && ! is_array( $atts['account_items'] ) ) {
					$items = explode( ',', $atts['account_items'] );
				}
				$args = array(
					'type'             => $atts['type'],
					'items'            => $items,
					'icon'             => isset( $atts['icon'] ) ? $atts['icon'] : 'd-icon-user',
					'login_text'       => isset( $atts['login_text'] ) ? $atts['login_text'] : 'Log in',
					'register_text'    => isset( $atts['register_text'] ) ? $atts['register_text'] : 'Register',
					'delimiter_text'   => isset( $atts['delimiter_text'] ) ? $atts['delimiter_text'] : '/',
					'account_dropdown' => isset( $atts['account_dropdown'] ) ? $atts['account_dropdown'] : false,
					'logout_text'      => isset( $atts['logout_text'] ) ? $atts['logout_text'] : 'Log out',
					'account_avatar'   => isset( $atts['account_avatar'] ) ? $atts['account_avatar'] : '',
				);

				if ( defined( 'RIODE_VERSION' ) ) {
					riode_get_template_part( RIODE_PART . '/header/elements/element-account', null, $args );
				}
				return ob_get_clean();
			}
		);
	}
}

new Riode_Header();
