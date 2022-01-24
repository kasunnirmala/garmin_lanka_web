<?php
/**
 * Testimonial Shortcode Render
 *
 * @since 1.1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'testimonial_type'    => 'simple',
			'name'                => 'John Doe',
			'job'                 => 'Customer',
			'link'                => '',
			'title'               => '',
			'testimonial_content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.',
			'avatar'              => array( 'url' => '' ),
			'rating'              => '',
			'avatar_pos'          => '',
			'commenter_pos'       => 'after',
			'rating_pos'          => 'before',
			'rating_sp'           => 0,
		),
		$atts
	)
);

// Preprocess

$wrapper_attrs = array(
	'class' => 'riode-testimonial-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . esc_attr( $value ) . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php

if ( defined( 'ELEMENTOR_VERSION' ) ) {
	if ( empty( $atts['avatar'] ) ) {
		$atts['avatar']        = $avatar;
		$atts['avatar']['url'] = '';
		$atts['avatar']['id']  = '';
	}

	if ( ! empty( $atts['avatar'] ) && is_numeric( $atts['avatar'] ) ) {
		$avatar_id             = $atts['avatar'];
		$avatar_url            = wp_get_attachment_image_url( $avatar, 'full' );
		$atts['avatar']        = array();
		$atts['avatar']['url'] = $avatar_url;
		$atts['avatar']['id']  = intVal( $avatar_id );
	}
} else {
	$atts['avatar'] = $avatar;
}

if ( empty( $atts['testimonial_inverse'] ) ) {
	$atts['testimonial_inverse'] = 'no';
}
$atts['link']        = array();
$atts['link']['url'] = $link;
$atts['content']     = $testimonial_content;
$settings            = $atts;
include RIODE_CORE_PATH . 'elementor/render/widget-testimonial-render.php';
?>
</div>
<?php
