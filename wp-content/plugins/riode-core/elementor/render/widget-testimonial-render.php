<?php

use Elementor\Group_Control_Image_Size;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'testimonial_type' => 'simple',
			'name'             => 'John Doe',
			'job'              => 'Customer',
			'link'             => '',
			'title'            => '',
			'content'          => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.',
			'avatar'           => array( 'url' => '' ),
			'rating'           => '',
			'avatar_pos'       => 'top',
			'commenter_pos'    => 'after',
			'rating_pos'       => 'before',
			'rating_sp'        => 0,
		),
		$settings
	)
);

$html = '';

if ( defined( 'ELEMENTOR_VERSION' ) ) {
	$image = Group_Control_Image_Size::get_attachment_image_html( $settings, 'avatar' );
} else {
	$image = '';
	if ( is_numeric( $settings['avatar'] ) ) {
		$img_data = wp_get_attachment_image_src( $settings['avatar'], 'full' );
		$img_alt  = get_post_meta( $settings['avatar'], '_wp_attachment_image_alt', true ) ? get_post_meta( $settings['avatar'], '_wp_attachment_image_alt', true ) : esc_html__( 'Testimonial Image', 'riode-core' );
		$img_alt  = esc_attr( trim( $img_alt ) );
		if ( is_array( $img_data ) ) {
			$image = '<img src="' . esc_url( $img_data[0] ) . '" alt="' . $img_alt . '" width="' . esc_attr( $img_data[1] ) . '" height="' . esc_attr( $img_data[2] ) . '">';
		}
	}
}

if ( isset( $link['url'] ) && $link['url'] ) {
	$image = '<a href="' . esc_url( $link['url'] ) . '">' . $image . '</a>';
}

if ( defined( 'ELEMENTOR_VERSION' ) ) {
	if ( $avatar['url'] ) {
		$image = '<div class="avatar">' . $image . '</div>';
	} else {
		$image = '<div class="avatar icon"></div>';
	}
} else {
	if ( is_numeric( $avatar ) ) {
		$image = '<div class="avatar">' . $image . '</div>';
	} else {
		$image = '<div class="avatar icon"></div>';
	}
}

if ( 'custom' == $testimonial_type && ( 'top' == $avatar_pos || 'aside' == $avatar_pos ) ) {
	$image_info = '';
} else {
	$image_info = $image;
	$image      = '';
}

$title_escaped = trim( esc_html( $title ) );
$content       = '<p class="comment">' . esc_textarea( $content ) . '</p>';
if ( ! empty( $title_escaped ) && 'boxed' != $testimonial_type ) {
	$content = '<h5 class="comment-title">' . $title_escaped . '</h5>' . $content;
}
if ( $rating ) {
	$rating_cls = '';
	$rating_w   = 20 * $rating . '%'; // get rating width
	if ( 'before' == $rating_pos && 'custom' == $testimonial_type ) {
		$content = '<div class="ratings-container"><div class="ratings-full' . $rating_cls . '" aria-label="Rated ' . $rating . ' out of 5"><span class="ratings" style="width: ' . $rating_w . ';"></span></div></div>' . $content;
	} else {
		$content .= '<div class="ratings-container"><div class="ratings-full' . $rating_cls . '" aria-label="Rated ' . $rating . ' out of 5"><span class="ratings" style="width: ' . $rating_w . ';"></span></div></div>';
	}
}
$commenter = '<cite><span class="name">' . esc_html( $name ) . '</span><span class="job">' . esc_html( $job ) . '</span></cite>';

if ( 'simple' == $testimonial_type ) {
	$html .= '<blockquote class="testimonial testimonial-simple' . ( 'yes' == $settings['testimonial_inverse'] ? ' inversed' : '' ) . '">';
	$html .= '<div class="content">' . $content . '</div>';
	$html .= '<div class="commenter">' . $image_info . $commenter . '</div>';
	$html .= '</blockquote>';
} elseif ( 'boxed' == $testimonial_type ) {
	$html .= '<blockquote class="testimonial testimonial-boxed">';
	if ( ! empty( $title_escaped ) ) {
		$html .= ' <h5 class="comment-title">' . $title_escaped . '</h5>';
	}
	$html .= $image_info;
	$html .= '<div class="content">' . $content . '</div>';
	$html .= $commenter;
	$html .= '</blockquote>';
} elseif ( 'custom' == $testimonial_type ) {
	$html .= '<blockquote class="testimonial testimonial-custom ' . esc_attr( $avatar_pos ) . '">';

	$html .= $image;

	if ( 'aside' == $avatar_pos ) {
		$html .= '<div class="content">';
	}

	if ( 'before' == $commenter_pos ) {
		$html .= '<div class="commenter">' . $image_info . $commenter . '</div>';
	}

	$html .= $content;

	if ( 'after' == $commenter_pos ) {
		$html .= '<div class="commenter">' . $image_info . $commenter . '</div>';
	}

	if ( 'aside' == $avatar_pos ) {
		$html .= '</div>';
	}
	$html .= '</blockquote>';
}

echo $html;
