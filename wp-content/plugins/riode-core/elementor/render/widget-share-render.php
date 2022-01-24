<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Button Widget Render
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'share_buttons' => array(
				array(
					'site' => 'facebook',
					'link' => '',
				),
				array(
					'site' => 'twitter',
					'link' => '',
				),
				array(
					'site' => 'linkedin',
					'link' => '',
				),
			),
			'type'          => 'stacked',
			'custom_color'  => '',
		),
		$settings
	)
);
?>

<div class="social-icons<?php echo esc_attr( $type ? ' ' . $type . '-icons' : ' inline-icons' ); ?>">
	<?php
	$custom          = 'yes' == $custom_color ? ' social-custom' : '';
	$share_no_follow = riode_get_option( 'social_no_follow' );

	$nofollow = ' ';
	if ( $share_no_follow ) {
		$nofollow = 'noopener noreferrer nofollow';
	} else {
		$nofollow = 'noopener noreferrer';
	}


	if ( $share_buttons ) {
		foreach ( $share_buttons as $share ) {
			$link  = $share['link']['url'];
			$share = $share['site'];

			if ( '' == $link ) {
				$permalink = esc_url( apply_filters( 'the_permalink', get_permalink() ) );
				$title     = esc_attr( get_the_title() );
				$excerpt   = esc_attr( get_the_excerpt() );
				$image     = wp_get_attachment_url( get_post_thumbnail_id() );

				if ( 'whatsapp' == $share ) {
					$title = rawurlencode( $title );
				} else {
					$title = urlencode( $title );
				}

				$link = strtr(
					$this->share_icons[ $share ][1],
					array(
						'$permalink' => $permalink,
						'$title'     => $title,
						'$image'     => $image,
						'$excerpt'   => $excerpt,
					)
				);
			}

			echo '<a href="' . esc_url( $link ) . '" class="social-icon ' . esc_attr( $type . $custom ) . ' social-' . $share . '" target="_blank" title="' . $share . '" rel="' . esc_attr( $nofollow ) . '">';
			echo '<i class="' . esc_attr( $this->share_icons[ $share ][0] ) . '"></i>';
			echo '</a>';
		}
	}
	?>
</div>

<?php
