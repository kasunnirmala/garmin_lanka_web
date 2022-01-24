<?php
/**
 * Compatibility with 1.0.1
 *
 * @since 1.0.1

 */

/**
 * Generate CSS
 *
 * @since 1.0.1
 */
if ( ! function_exists( 'riode_generate_vc_style' ) ) {
	function riode_generate_vc_style( $typo ) {
		$mixin_value = ' inherit;';
		if ( ! empty( $typo['globalFontWeight'] ) && 'default' != $typo['globalFontWeight'] ) {
			$mixin_value .= 'font-weight: ' . $typo['globalFontWeight'] . ';';
		}

		if ( ! empty( $typo['customFont'] ) ) {
			$mixin_value = ' ' . $typo['fontFamily'] . ';font-weight: ' . $typo['fontStyle']['weight'] . ';';
			if ( 'regular' != $typo['fontStyle']['style'] ) {
				$mixin_value .= 'font-style: ' . $typo['fontStyle']['style'] . ';';
			}
		}

		if ( ! empty( $typo['fontSize'] ) ) {
			$mixin_value .= 'font-size: ' . $typo['fontSize'] . ';';
		}

		if ( ! empty( $typo['letterSpacing'] ) ) {
			$mixin_value .= 'letter-spacing: ' . $typo['letterSpacing'] . ';';
		}

		if ( ! empty( $typo['lineHeight'] ) ) {
			$mixin_value .= 'line-height: ' . $typo['lineHeight'] . ';';
		}

		if ( ! empty( $typo['textTransform'] ) ) {
			$mixin_value .= 'text-transform: ' . $typo['textTransform'] . ';';
		}

		return $mixin_value;
	}
}
/**
 * Update VC page contents
 *
 * @since 1.0.1
 */
if ( ! function_exists( 'riode_update_vc_contents' ) ) {
	function riode_update_vc_contents() {
		global $wpdb;
		$list = $wpdb->get_results(
			$wpdb->prepare( "SELECT meta_id, post_id, meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s", 'vcv-pageContent' ),
			ARRAY_A
		);
		foreach ( $list as $item ) {
			$data = rawurldecode( $item['meta_value'] );

			$data = json_decode( $data, true );

			if ( ! empty( $data['elements'] ) ) {
				foreach ( $data['elements'] as $key => $element ) {
					if ( 'riodeAccount' === $element['tag'] || 'riodeHeading' === $element['tag'] || 'riodeCart' === $element['tag'] || 'riodeCompare' === $element['tag'] || 'riodeWishlist' === $element['tag'] || 'riodeSPCompare' === $element['tag'] || 'riodeSpHeading' === $element['tag'] || 'riodeSpWishlist' === $element['tag'] || 'riodeDynamicHeading' === $element['tag'] ) {
						if ( isset( $element['font_size'] ) ) {
							$element['title_font']['customFont'] = $element['use_theme_fonts'];
							unset( $element['use_theme_fonts'] );
							$element['title_font']['fontSize'] = $element['font_size'];
							unset( $element['font_size'] );
							$element['title_font']['fontStyle']['weight'] = $element['font_weight'];
							$element['title_font']['globalFontWeight']    = $element['font_weight'];
							unset( $element['font_weight'] );
							$element['title_font']['letterSpacing'] = $element['letter_spacing'];
							unset( $element['letter_spacing'] );
							$element['title_font']['lineHeight'] = $element['line_height'];
							unset( $element['line_height'] );
							$element['title_font']['textTransform'] = $element['text_transform'];
							unset( $element['text_transform'] );
							$element['title_font']['status']     = '';
							$element['title_font']['mixinValue'] = riode_generate_vc_style( $element['title_font'] );
						}
					} elseif ( 'riodeSpCounter' === $element['tag'] || 'riodeCounterUp' === $element['tag'] ) {
						if ( isset( $element['countFontSize'] ) ) {
							$element['countFont']['customFont'] = true;
							$element['countFont']['fontSize']   = $element['countFontSize'];
							unset( $element['countFontSize'] );
							$element['countFont']['letterSpacing'] = $element['countLetterSpacing'];
							unset( $element['countLetterSpacing'] );
							$element['countFont']['lineHeight'] = $element['countLineHeight'];
							unset( $element['countLineHeight'] );
							$element['countFont']['textTransform'] = 'none';
							$element['countFont']['status']        = '';
							$element['countFont']['mixinValue']    = riode_generate_vc_style( $element['countFont'] );
						}
						if ( isset( $element['labelFontSize'] ) ) {
							$element['labelFont']['customFont'] = true;
							$element['labelFont']['fontSize']   = $element['labelFontSize'];
							unset( $element['labelFontSize'] );
							$element['labelFont']['letterSpacing'] = $element['labelLetterSpacing'];
							unset( $element['labelLetterSpacing'] );
							$element['labelFont']['lineHeight'] = $element['labelLineHeight'];
							unset( $element['labelLineHeight'] );
							$element['labelFont']['textTransform'] = 'none';
							$element['labelFont']['status']        = '';
							$element['labelFont']['mixinValue']    = riode_generate_vc_style( $element['labelFont'] );
						}
						if ( isset( $element['descFontSize'] ) ) {
							$element['descFont']['customFont'] = true;
							$element['descFont']['fontSize']   = $element['descFontSize'];
							unset( $element['descFontSize'] );
							$element['descFont']['letterSpacing'] = $element['descLetterSpacing'];
							unset( $element['descLetterSpacing'] );
							$element['descFont']['lineHeight'] = $element['descLineHeight'];
							unset( $element['descLineHeight'] );
							$element['descFont']['textTransform'] = 'none';
							$element['descFont']['status']        = '';
							$element['descFont']['mixinValue']    = riode_generate_vc_style( $element['descFont'] );
						}
					} elseif ( 'riodeButton' === $element['tag'] ) {
						if ( isset( $element['fontSize'] ) ) {
							$element['font']['customFont'] = $element['useCustomFont'];
							unset( $element['useCustomFont'] );
							$element['font']['fontSize'] = $element['fontSize'];
							unset( $element['fontSize'] );
							$element['font']['letterSpacing'] = $element['letterSpacing'];
							unset( $element['letterSpacing'] );
							$element['font']['lineHeight'] = $element['lineHeight'];
							unset( $element['lineHeight'] );
							$element['font']['textTransform'] = $element['textTransform'];
							unset( $element['textTransform'] );
							$element['font']['status']     = '';
							$element['font']['mixinValue'] = riode_generate_vc_style( $element['font'] );
						}
					} elseif ( 'riodeInfoBox' === $element['tag'] ) {
						if ( isset( $element['title_font_size'] ) ) {
							$element['title_google_font']['customFont'] = $element['title_use_theme_fonts'];
							unset( $element['title_use_theme_fonts'] );
							$element['title_google_font']['fontSize'] = $element['title_font_size'];
							unset( $element['title_font_size'] );
							$element['title_google_font']['fontStyle']['weight'] = $element['title_font_style'];
							$element['title_google_font']['globalFontWeight']    = $element['title_font_style'];
							unset( $element['title_font_style'] );
							$element['title_google_font']['letterSpacing'] = $element['title_font_letter_spacing'];
							unset( $element['title_font_letter_spacing'] );
							$element['title_google_font']['lineHeight'] = $element['title_font_line_height'];
							unset( $element['title_font_line_height'] );
							if ( isset( $element['title_transform'] ) ) {
								$element['title_google_font']['textTransform'] = $element['title_transform'];
								unset( $element['title_transform'] );
							}
							$element['title_google_font']['status']     = '';
							$element['title_google_font']['mixinValue'] = riode_generate_vc_style( $element['title_google_font'] );
						}
						if ( isset( $element['subtitle_font_size'] ) ) {
							$element['subtitle_google_font']               = array();
							$element['subtitle_google_font']['customFont'] = false;
							$element['subtitle_google_font']['fontSize']   = $element['subtitle_font_size'];
							unset( $element['subtitle_font_size'] );
							$element['subtitle_google_font']['fontStyle']           = array(
								'style'  => 'regular',
								'weight' => 'default',
							);
							$element['subtitle_google_font']['fontStyle']['weight'] = $element['subtitle_font_style'];
							$element['subtitle_google_font']['globalFontWeight']    = $element['subtitle_font_style'];
							unset( $element['subtitle_font_style'] );
							$element['subtitle_google_font']['letterSpacing'] = $element['subtitle_font_letter_spacing'];
							unset( $element['subtitle_font_letter_spacing'] );
							$element['subtitle_google_font']['lineHeight'] = $element['subtitle_font_line_height'];
							unset( $element['subtitle_font_line_height'] );
							if ( isset( $element['subtitle_transform'] ) ) {
								$element['subtitle_google_font']['textTransform'] = $element['subtitle_transform'];
								unset( $element['subtitle_transform'] );
							}
							$element['subtitle_google_font']['status']     = '';
							$element['subtitle_google_font']['mixinValue'] = riode_generate_vc_style( $element['subtitle_google_font'] );
						}
						if ( isset( $element['desc_font_size'] ) ) {
							$element['desc_google_font']['customFont'] = $element['desc_use_theme_fonts'];
							unset( $element['desc_use_theme_fonts'] );
							$element['desc_google_font']['fontSize'] = $element['desc_font_size'];
							unset( $element['desc_font_size'] );
							$element['desc_google_font']['fontStyle']['weight'] = $element['desc_font_style'];
							$element['desc_google_font']['globalFontWeight']    = $element['desc_font_style'];
							unset( $element['desc_font_style'] );
							if ( isset( $element['desc_font_letter_spacing'] ) ) {
								$element['desc_google_font']['letterSpacing'] = $element['desc_font_letter_spacing'];
								unset( $element['desc_font_letter_spacing'] );
							}
							$element['desc_google_font']['lineHeight'] = $element['desc_font_line_height'];
							unset( $element['desc_font_line_height'] );
							if ( isset( $element['desc_transform'] ) ) {
								$element['desc_google_font']['textTransform'] = $element['desc_transform'];
								unset( $element['desc_transform'] );
							}
							$element['desc_google_font']['status']     = '';
							$element['desc_google_font']['mixinValue'] = riode_generate_vc_style( $element['desc_google_font'] );
						}
					} elseif ( 'riodeSubCategories' === $element['tag'] ) {
						if ( isset( $element['titleFontSize'] ) ) {
							$element['titleFontFamily']['customFont'] = true;
							$element['titleFontFamily']['fontSize']   = $element['titleFontSize'];
							unset( $element['titleFontSize'] );
							$element['titleFontFamily']['fontStyle']['weight'] = $element['titleFontWeight'];
							$element['titleFontFamily']['globalFontWeight']    = $element['titleFontWeight'];
							unset( $element['titleFontWeight'] );
							$element['titleFontFamily']['letterSpacing'] = $element['titleLetterSpacing'];
							unset( $element['titleLetterSpacing'] );
							$element['titleFontFamily']['lineHeight'] = $element['titleLineHeight'];
							unset( $element['titleLineHeight'] );
							$element['titleFontFamily']['textTransform'] = 'none';
							$element['titleFontFamily']['status']        = '';
							$element['titleFontFamily']['mixinValue']    = riode_generate_vc_style( $element['titleFontFamily'] );
						}
						if ( isset( $element['subtitleFontSize'] ) ) {
							$element['subtitleFontFamily']['customFont'] = true;
							$element['subtitleFontFamily']['fontSize']   = $element['subtitleFontSize'];
							unset( $element['subtitleFontSize'] );
							$element['subtitleFontFamily']['fontStyle']['weight'] = $element['subtitleFontWeight'];
							$element['subtitleFontFamily']['globalFontWeight']    = $element['subtitleFontWeight'];
							unset( $element['subtitleFontWeight'] );
							$element['subtitleFontFamily']['letterSpacing'] = $element['subtitleLetterSpacing'];
							unset( $element['subtitleLetterSpacing'] );
							$element['subtitleFontFamily']['lineHeight'] = $element['subtitleLineHeight'];
							unset( $element['subtitleLineHeight'] );
							$element['subtitleFontFamily']['textTransform'] = 'none';
							$element['subtitleFontFamily']['status']        = '';
							$element['subtitleFontFamily']['mixinValue']    = riode_generate_vc_style( $element['subtitleFontFamily'] );
						}
					}

					$data['elements'][ $key ] = $element;
				}

				$data = json_encode( $data );

				$wpdb->update(
					$wpdb->postmeta,
					array( 'meta_value' => rawurlencode( $data ) ),
					array( 'meta_id' => $item['meta_id'] )
				);
			}
		}
	}
}

riode_update_vc_contents();
