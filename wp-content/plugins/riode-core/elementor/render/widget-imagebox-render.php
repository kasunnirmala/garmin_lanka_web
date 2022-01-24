<?php

use Elementor\Group_Control_Image_Size;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'title'    => 'Input Title Here',
			'subtitle' => 'Input SubTitle Here',
			'content'  => '<div class="social-icons">
								<a href="#" class="social-icon framed social-facebook"><i class="fab fa-facebook-f"></i></a>
								<a href="#" class="social-icon framed social-twitter"><i class="fab fa-twitter"></i></a>
								<a href="#" class="social-icon framed social-linkedin"><i class="fab fa-linkedin-in"></i></a>
							</div>',
			'image'        => array( 'url' => '' ),
			'type'         => '',
			'thumbnail'    => 'full',
			'page_builder' => '',
		),
		$settings
	)
);

$html = '';
$image = '';
if ( 'wpb' == $page_builder ) {
	if ( ! empty( $settings['image'] ) ) {
		$image = wp_get_attachment_image( $settings['image'], $thumbnail );
	}
} else {
	$image = Group_Control_Image_Size::get_attachment_image_html( $settings, 'image' );
}


$title_html    = $title ? '<h3 class="title">' . $title . '</h3>' : '';
$subtitle_html = $subtitle ? '<h4 class="subtitle">' . $subtitle . '</h4>' : '';
$content_html  = $content ? '<div class="content">' . $content . '</div>' : '';

$html = '<div class="image-box ' . esc_attr( $type ) . '">';

if ( ! $type ) {
	$html .= '<figure>' . $image . '</figure>' . $title_html . $subtitle_html . $content_html;
} elseif ( 'inner' == $type ) {
	$html .= '<figure>' . $image . '<div class="overlay-visible">' . $title_html . $subtitle_html . '</div>' . '<div class="overlay overlay-transparent">' . $content_html . '</div>' . '</figure>';
} elseif ( 'outer' == $type ) {
	$html .= '<figure>' . $image . '<div class="overlay">' . $content_html . '</div>' . '</figure>' . $title_html . $subtitle_html;
}

$html .= '</div>';

echo riode_escaped( $html );
