<?php
/**
 * Riode Blockquote Widget Render
 *
 * @since 1.4.0
 *
 */
extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'type'       => 'type1',
			'blockquote' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'riode-core' ),
			'cite'       => esc_html__( 'John Doe', 'riode-core' ),
			'image'      => '',
			'dark_skin'  => '',
		),
		$atts
	)
);

// Classes
$class = array( 'blockquote-' . $type );
if ( 'yes' == $dark_skin ) {
	$class[] = 'dark-skin';
}

// Element Parts
$content_html = '<p>' . esc_html( $blockquote ) . '</p>';
$cite_html    = '<cite>' . esc_html( $cite ) . '</cite>';
$comment_icon = '<i class="blockquote-icon fa fa-quote-left"></i>';

// Render Wrapper
$html = '<div class="blockquote-wrapper ' . esc_attr( implode( ' ', $class ) ) . '">';

// Type 1 OR Type 2
if ( 'type1' == $type || 'type2' == $type ) {
	$html .= $comment_icon;
}

// Type 4 OR Type 5
if ( 'type4' == $type || 'type5' == $type ) {
	$html .= '<figure class="blockquote-media">';
	if ( ! empty( $image['id'] ) ) {
		$html .= wp_get_attachment_image(
			$image['id'],
			'full',
			false
		);
	} elseif ( class_exists( 'WooCommerce' ) ) {
		$html .= wc_placeholder_img( 'full' );
	}

	$html .= '</figure>';
}

$html .= '<blockquote>';

// Type 4
if ( 'type4' == $type ) {
	$html .= $comment_icon;
}

$html .= ( $content_html . $cite_html );

$html .= '</blockquote>';

$html .= '</div>';

echo riode_escaped( $html );
