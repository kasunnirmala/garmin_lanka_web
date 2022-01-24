<?php
/**
 * Single Product Title Shortcode
 *
 * @since 1.1.0
 */

// Preprocess

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'content_type'    => 'custom',
			'dynamic_content' => 'title',
			'html_tag'        => 'h2',
			'heading_title'   => 'Riode Single Product Name',
			'decoration'      => '',
			'show_link'       => '',
			'link_url'        => '',
			'link_label'      => 'Link',
			'title_align'     => 'title-left',
			'link_align'      => 'link-right',
			'icon_pos'        => 'after',
			'icon'            => '',
			'show_divider'    => '',
			'class'           => '',
		),
		$atts
	)
);

global $product;

if ( $product && is_product() && $product->get_title() ) {
	$heading_title = $product->get_title();
}

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-sp-title-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}
?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
$html = '';

if ( 'dynamic' == $content_type ) {
	$heading_title = '';

	if ( function_exists( 'riode_get_layout_value' ) && riode_get_layout_value( 'slug' ) ) {
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
}


if ( $heading_title ) {

	$class         = $class ? $class . ' title' : 'title product_title entry-title';
	$wrapper_class = 'title-wrapper';

	if ( $decoration && '/' != $decoration ) {
		$wrapper_class .= ' title-' . $decoration;
	}

	if ( $title_align ) {
		$wrapper_class .= ' ' . $title_align;
	}

	if ( $link_align ) {
		$wrapper_class .= ' ' . $link_align;
	}
	$link_label = '<span>' . esc_html( $link_label ) . '</span>';

	if ( ! empty( $icon ) ) {
		if ( 'before' == $icon_pos ) {
			$wrapper_class .= ' icon-before';
			$link_label     = '<i class="' . $icon . '"></i>' . $link_label;
		} else {
			$wrapper_class .= ' icon-after';
			$link_label    .= '<i class="' . $icon . '"></i>';
		}
	}
	$html .= '<div class="' . esc_attr( $wrapper_class ) . '">';

	$html .= sprintf( '<%1$s class="' . esc_attr( $class ) . '">%2$s</%1$s>', $html_tag, $heading_title );

	if ( 'yes' == $show_link ) { // If Link is allowed
		if ( 'yes' == $show_divider ) {
			$html .= '<span class="divider"></span>';
		}
		$html .= sprintf( '<a href="%1$s" class="link">%2$s</a>', ! empty( $link_url ) ? $link_url : '#', ( $link_label ) );
	}
	$html .= '</div>';
}
echo riode_escaped( $html );
?>
</div>
<?php
