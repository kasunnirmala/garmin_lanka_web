<?php
/**
 * ShareIcon Shortcode Render
 *
 * @since 1.1.0
 */


// Preprocess
$permalink = esc_url( apply_filters( 'the_permalink', get_permalink() ) );
$title     = esc_attr( get_the_title() );
$image     = wp_get_attachment_url( get_post_thumbnail_id() );
$excerpt   = esc_attr( get_the_excerpt() );
if ( isset( $atts['icon'] ) && 'whatsapp' == $atts['icon'] ) {
	$title = rawurlencode( $title );
} else {
	$title = urlencode( $title );
}
$share_icons = array(
	esc_html__( 'facebook', 'riode-core' )  => array( 'fab fa-facebook-f', 'https://www.facebook.com/sharer.php?u=$permalink' ),
	esc_html__( 'twitter', 'riode-core' )   => array( 'fab fa-twitter', 'https://twitter.com/intent/tweet?text=$title&amp;url=$permalink' ),
	esc_html__( 'linkedin', 'riode-core' )  => array( 'fab fa-linkedin-in', 'https://www.linkedin.com/shareArticle?mini=true&amp;url=$permalink&amp;title=$title' ),
	esc_html__( 'email', 'riode-core' )     => array( 'far fa-envelope', 'mailto:?subject=$title&amp;body=$permalink' ),
	esc_html__( 'google', 'riode-core' )    => array( 'fab fa-google-plus-g', 'https://plus.google.com/share?url=$permalink' ),
	esc_html__( 'pinterest', 'riode-core' ) => array( 'fab fa-pinterest-p', 'https://pinterest.com/pin/create/button/?url=$permalink&amp;media=$image' ),
	esc_html__( 'reddit', 'riode-core' )    => array( 'fab fa-reddit-alien', 'http://www.reddit.com/submit?url=$permalink&amp;title=$title' ),
	esc_html__( 'tumblr', 'riode-core' )    => array( 'fab fa-tumblr', 'http://www.tumblr.com/share/link?url=$permalink&amp;name=$title&amp;description=$excerpt' ),
	esc_html__( 'vk', 'riode-core' )        => array( 'fab fa-vk', 'https://vk.com/share.php?url=$permalink&amp;title=$title&amp;image=$image&amp;noparse=true' ),
	esc_html__( 'whatsapp', 'riode-core' )  => array( 'fab fa-whatsapp', 'whatsapp://send?text=$title - $permalink' ),
	esc_html__( 'xing', 'riode-core' )      => array( 'fab fa-xing', 'https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=$permalink' ),
	esc_html__( 'instagram', 'riode-core' ) => array( 'fab fa-instagram', '' ),
	esc_html__( 'youtube', 'riode-core' )   => array( 'fab fa-youtube', '' ),
	esc_html__( 'tiktok', 'riode-core' )    => array( 'fab fa-tiktok', '' ),
	esc_html__( 'wechat', 'riode-core' )    => array( 'fab fa-weixin', '' ),
);

if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'icon'        => 'facebook',
			'link'        => '',
			'social_type' => '',
		),
		$atts
	)
);

$share_no_follow = riode_get_option( 'social_no_follow' );

$nofollow = ' ';
if ( $share_no_follow ) {
	$nofollow = 'noopener noreferrer nofollow';
} else {
	$nofollow = 'noopener noreferrer';
}

$wrapper_attrs = array(
	'class' => 'social-icon ' . $shortcode_class . $style_class . ' social-' . $icon . ( ! empty( $social_type ) ? ' ' . $social_type : '' ),
	'href'  => empty( $link ) ? ( isset( $share_icons[ $icon ] ) ? strtr(
		$share_icons[ $icon ][1],
		array(
			'$permalink' => $permalink,
			'$title'     => $title,
			'$image'     => $image,
			'$excerpt'   => $excerpt,
		)
	) : '#' ) : $link['url'],
	'rel'   => $nofollow,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}
?>
<a <?php echo riode_escaped( $wrapper_attr_html ); ?>>

<?php // share icon Render ?>
	<i class="<?php echo esc_attr( isset( $share_icons[ $icon ] ) ? $share_icons[ $icon ][0] : 'fab fa-facebook-f' ); ?>"></i>
</a>
<?php
