<?php
/**
 * Compatibility with 1.2.0
 *
 * @since 1.2.0
 */

if ( ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

if ( ! function_exists( 'riode_is_wpb_built_post' ) ) {
	function riode_is_wpb_built_post( $content ) {
		if ( false !== strpos( $content, '[vc_row' ) ) {
			return true;
		}
		if ( false !== strpos( $content, '[wpb_riode' ) ) {
			return true;
		}
		return false;
	}
}

if ( ! function_exists( 'riode_wpb_parse_shortcodes_custom_css' ) ) {
	function riode_wpb_parse_shortcodes_custom_css( $content ) {
		$css = '';
		if ( ! preg_match( '/\s*(\.[^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $content ) ) {
			return $css;
		}
		WPBMap::addAllMappedShortcodes();
		preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );
		foreach ( $shortcodes[2] as $index => $tag ) {
			$shortcode  = WPBMap::getShortCode( $tag );
			$attr_array = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
			if ( isset( $shortcode['params'] ) && ! empty( $shortcode['params'] ) ) {
				foreach ( $shortcode['params'] as $param ) {
					if ( isset( $param['type'] ) && 'css_editor' === $param['type'] && isset( $attr_array[ $param['param_name'] ] ) ) {
						$css .= $attr_array[ $param['param_name'] ];
					}
				}
			}
		}
		foreach ( $shortcodes[5] as $shortcode_content ) {
			$css .= riode_wpb_parse_shortcodes_custom_css( $shortcode_content );
		}

		return $css;
	}
}

if ( ! function_exists( 'riode_regenerate_wpb_custom_css' ) ) {
	function riode_regenerate_wpb_custom_css() {
		// Generate WPBakery Page CSS
		$query = new WP_Query(
			array(
				'post_type'      => array( 'page', 'riode_template' ),
				'posts_per_page' => -1,
			)
		);

		$riode_wpb = Riode_WPB_Init::get_instance();

		// The Loop
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$id      = get_the_ID();
				$post    = get_post( $id );
				$content = $post->post_content;

				if ( riode_is_wpb_built_post( $content ) ) {
					$css       = riode_wpb_parse_shortcodes_custom_css( $content );
					$css_array = $riode_wpb->parse_shortcodes_custom_css( $content );

					foreach ( $css_array as $key => $value ) {
						if ( 'responsive' == $key ) {
							if ( ! is_array( $value ) ) {
								$css .= $value;
							} else {
								$value = array_unique( $value );
								$css  .= implode( '', $value );
							}
						} else {
							if ( ! is_array( $value ) ) {
								$css .= $key . '{' . $value . '}';
							} else {
								$value = array_unique( $value );
								$css  .= $key . '{' . implode( '', $value ) . '}';
							}
						}
					}

					if ( empty( $css ) ) {
						delete_metadata( 'post', $id, '_wpb_shortcodes_custom_css' );
					} else {
						update_metadata( 'post', $id, '_wpb_shortcodes_custom_css', $css );
					}
				}
			}
		}

		wp_reset_postdata();
	}
}

if ( class_exists( 'Riode_WPB_Init' ) ) {
	add_action( 'init', 'riode_regenerate_wpb_custom_css', 99 );
}
