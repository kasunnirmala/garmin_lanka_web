<?php

/**
 * Riode Lazyload Image Class
 *
 * @version 1.0
 */

add_action( 'init', array( 'Riode_LazyLoad_Images', 'init' ) );

if ( ! class_exists( 'Riode_LazyLoad_Images' ) ) :
	class Riode_LazyLoad_Images {

		static $lazy_image_escaped;

		static function init() {
			add_action( 'wp_head', array( __CLASS__, 'setup' ), 99 );

			add_filter( 'riode_lazy_load_images', array( __CLASS__, 'add_image_placeholders' ), 9999 );

			add_filter( 'wp_lazy_loading_enabled', array( __CLASS__, 'remove_image_lazyload_from_wp' ), 10, 2 );
		}

		static function remove_image_lazyload_from_wp( $default, $tag_name ) {
			if ( 'img' === $tag_name ) {
				return false;
			}
			return $default;
		}


		static function setup() {

			Riode_LazyLoad_Images::$lazy_image_escaped = esc_url( get_parent_theme_file_uri( 'assets/images/lazy.png' ) );

			add_filter( 'the_content', array( __CLASS__, 'add_image_placeholders' ), 9999 );
			add_filter( 'post_thumbnail_html', array( __CLASS__, 'add_image_placeholders' ), 11 );
			add_filter( 'woocommerce_product_get_image', array( __CLASS__, 'add_image_placeholders' ), 11 );
			add_filter( 'get_avatar', array( __CLASS__, 'add_image_placeholders' ), 11 );
			add_filter( 'riode_product_hover_image_html', array( __CLASS__, 'add_image_placeholders' ), 11 );
			add_filter( 'riode_wc_subcategory_thumbnail_html', array( __CLASS__, 'add_image_placeholders' ), 11 );
			add_filter( 'woocommerce_single_product_image_thumbnail_html', array( __CLASS__, 'add_image_placeholders' ), 9999 );

			add_filter( 'post_gallery', array( __CLASS__, 'start_media_gallery' ) );
			add_filter( 'wp_get_attachment_link', array( __CLASS__, 'lazyload_media_gallery' ), 12 );
			add_filter( 'dynamic_sidebar_after', array( __CLASS__, 'end_media_gallery' ) );

			wp_enqueue_script( 'jquery-lazyload' );
		}


		static function start_media_gallery( $content ) {
			$GLOBALS['riode_media_gallery_lazyload'] = true;
			return $content;
		}


		static function lazyload_media_gallery( $content ) {
			if ( isset( $GLOBALS['riode_media_gallery_lazyload'] ) ) {
				return Riode_LazyLoad_Images::add_image_placeholders( $content );
			}
		}


		static function end_media_gallery() {
			unset( $GLOBALS['riode_media_gallery_lazyload'] );
		}


		static function add_image_placeholders( $content ) {
			if ( is_feed() || is_preview() ) {
				return $content;
			}
			$matches = array();
			preg_match_all( '/<img[\s\r\n]+.*?>/is', $content, $matches );

			$search  = array();
			$replace = array();

			foreach ( $matches[0] as $img_html ) {
				if ( false !== strpos( $img_html, 'data-lazy' ) || preg_match( "/src=['\"]data:image/is", $img_html ) || preg_match( "/class=\".*do-not-lazyload\"/", $img_html ) ) {
					continue;
				}

				// replace the src and add the data-oi
				$replace_html = '';
				$style        = '';

				if ( preg_match( '/width=["\']/i', $img_html ) && preg_match( '/height=["\']/i', $img_html ) ) {
					preg_match( '/width=(["\'])(.*?)["\']/is', $img_html, $match_width );
					preg_match( '/height=(["\'])(.*?)["\']/is', $img_html, $match_height );
					if ( isset( $match_width[2] ) && $match_width[2] && is_numeric( $match_width[2] ) && isset( $match_height[2] ) && $match_height[2] && is_numeric( $match_height[2] ) ) {
						$style = 'padding-top : ' . round( $match_height[2] / $match_width[2] * 100, 2 ) . '%;';
					} else {
						continue;
					}
				} else {
					continue;
				}

				$replace_html = preg_replace( '/<img(.*?)src=/is', '<img$1src="' . Riode_LazyLoad_Images::$lazy_image_escaped . '" data-lazy=', $img_html );
				$replace_html = preg_replace( '/<img(.*?)srcset=/is', '<img$1srcset="' . Riode_LazyLoad_Images::$lazy_image_escaped . ' 100w" data-lazyset=', $replace_html );
				if ( $style ) {
					if ( preg_match( '/style=["\']/i', $replace_html ) ) {
						$replace_html = preg_replace( '/style=(["\'])(.*?)["\']/is', 'style=$1' . $style . '$2$1', $replace_html );
					} else {
						$replace_html = preg_replace( '/<img/is', '<img style="' . $style . '"', $replace_html );
					}
				}

				if ( preg_match( '/class=["\']/i', $replace_html ) ) {
					$replace_html = preg_replace( '/class=(["\'])(.*?)["\']/is', 'class=$1d-lazyload $2$1', $replace_html );
				} else {
					$replace_html = preg_replace( '/<img/is', '<img class="d-lazyload"', $replace_html );
				}

				array_push( $search, $img_html );
				array_push( $replace, $replace_html );
			}

			$search  = array_unique( $search );
			$replace = array_unique( $replace );
			$content = str_replace( $search, $replace, $content );

			// Background Image Lazyload
			$content = preg_replace_callback(
				'/style="([^"]*)background-image:\s*url\(([^)]*)\);+/is',
				function( $matches ) {
					if ( 'assets/images/lazy.png' == $matches[2] ) {
						return $matches[0];
					}
					return ' data-lazy-back="1" data-lazy="' . trim( $matches[2], '\'' ) . '" style="';
				},
				$content
			);
			$content = str_replace( ' style=""', '', $content );

			return $content;
		}
	}
endif;
