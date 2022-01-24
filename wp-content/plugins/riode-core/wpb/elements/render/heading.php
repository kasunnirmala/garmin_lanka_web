<?php
/**
 * Heading Shortcode
 *
 * @since 1.1.0
 */

// Preprocess
if ( ! empty( $atts['link_url'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link_url'] = vc_build_link( $atts['link_url'] );
}

if ( ! empty( $atts['heading_title'] ) ) {
	$atts['heading_title'] = rawurldecode( base64_decode( wp_strip_all_tags( $atts['heading_title'] ) ) );
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'content_type'    => 'custom',
			'dynamic_content' => 'title',
			'userinfo_type'   => 'display_name',
			'heading_title'   => 'Add Your Heading Text Here',
			'html_tag'        => 'h2',
			'decoration'      => '',
			'show_link'       => '',
			'link_url'        => '',
			'link_label'      => 'Link',
			'title_align'     => 'title-left',
			'link_align'      => '',
			'icon_pos'        => 'after',
			'icon'            => '',
			'show_divider'    => '',
			'class'           => '',
		),
		$atts
	)
);


$wrapper_attrs = array(
	'class' => 'title-wrapper ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$html = '';

if ( 'dynamic' == $content_type ) {
	$heading_title = '';

	if ( function_exists( 'riode_get_layout_value' ) ) {
		if ( 'title' == $dynamic_content ) {
			$heading_title = riode_get_layout_value( 'ptb', 'title' );
		} elseif ( 'subtitle' == $dynamic_content ) {
			$heading_title = riode_get_layout_value( 'ptb', 'subtitle' );
		} elseif ( 'product_cnt' == $dynamic_content ) {
			if ( function_exists( 'riode_is_shop' ) && riode_is_shop() && wc_get_loop_prop( 'total' ) ) {
				$heading_title = wc_get_loop_prop( 'total' ) . ' products';
			}
		}
	} else {
		if ( 'title' == $dynamic_content ) {
			$heading_title = 'Page Title';
		} elseif ( 'subtitle' == $dynamic_content ) {
			$heading_title = 'Page Subtitle';
		} elseif ( 'product_cnt' == $dynamic_content ) {
			$heading_title = '* Products';
		}
	}
	// Site Tag Line
	if ( 'site_tagline' == $dynamic_content ) {
		$heading_title = esc_html( get_bloginfo( 'description' ) );
	}
	// Site Title
	if ( 'site_title' == $dynamic_content ) {
		$heading_title = esc_html( get_bloginfo() );
	}
	// Current DateTime
	if ( 'date' == $dynamic_content ) {
		$format      = '';
		$date_format = get_option( 'date_format' );
		$time_format = get_option( 'time_format' );

		if ( $date_format ) {
			$format   = $date_format;
			$has_date = true;
		} else {
			$has_date = false;
		}

		if ( $time_format ) {
			if ( $has_date ) {
				$format .= ' ';
			}
			$format .= $time_format;
		}

		$heading_title = esc_html( date_i18n( $format ) );
	}
	// User Info
	if ( 'user_info' == $dynamic_content ) {
		$user = wp_get_current_user();
		if ( empty( $userinfo_type ) || 0 === $user->ID ) {
			return;
		}

		$value = '';
		switch ( $userinfo_type ) {
			case 'login':
			case 'email':
			case 'url':
			case 'nicename':
				$field = 'user_' . $userinfo_type;
				$value = isset( $user->$field ) ? $user->$field : '';
				break;
			case 'id':
				$value = $user->ID;
				break;
			case 'description':
			case 'first_name':
			case 'last_name':
			case 'display_name':
				$value = isset( $user->$userinfo_type ) ? $user->$userinfo_type : '';
				break;
			case 'meta':
				$key = $this->get_settings( 'meta_key' );
				if ( ! empty( $key ) ) {
					$value = get_user_meta( $user->ID, $key, true );
				}
				break;
		}

		$heading_title = esc_html( $value );
	}
}

if ( $heading_title || ( 'yes' == $show_link && $link_label ) ) {
	$class = $class ? $class . ' title' : 'title';

	if ( $decoration && 'simple' != $decoration ) {
		$wrapper_attrs['class'] .= ' title-' . $decoration;
	}

	if ( $title_align ) {
		$wrapper_attrs['class'] .= ' ' . $title_align;
	}

	if ( $link_align ) {
		$wrapper_attrs['class'] .= ' ' . $link_align;
	}
	$link_label = '<span>' . esc_html( $link_label ) . '</span>';

	if ( ! empty( $icon ) ) {
		if ( 'before' == $icon_pos ) {
			$wrapper_attrs['class'] .= ' icon-before';
			$link_label              = '<i class="' . $icon . '"></i>' . $link_label;
		} else {
			$wrapper_attrs['class'] .= ' icon-after';
			$link_label             .= '<i class="' . $icon . '"></i>';
		}
	}
	$wrapper_attr_html = '';
	foreach ( $wrapper_attrs as $key => $value ) {
		$wrapper_attr_html .= $key . '="' . $value . '" ';
	}

	$html .= '<div ' . riode_escaped( $wrapper_attr_html ) . '>';

	if ( $heading_title ) {
		$html .= sprintf( '<%1$s class="' . esc_attr( $class ) . '">%2$s</%1$s>', $html_tag, do_shortcode( $heading_title ) );
	}

	if ( 'yes' == $show_link ) { // If Link is allowed
		if ( 'yes' == $show_divider ) {
			$html .= '<span class="divider"></span>';
		}
		$html .= sprintf( '<a href="%1$s" class="link">%2$s</a>', ! empty( $link_url['url'] ) ? $link_url['url'] : '#', ( $link_label ) );
	}
	$html .= '</div>';
}

echo riode_escaped( $html );
