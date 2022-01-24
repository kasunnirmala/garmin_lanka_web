<?php
/**
 * Share template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $share_title string Title for share section
 * @var $share_facebook_enabled bool Whether to enable FB sharing button
 * @var $share_twitter_enabled bool Whether to enable Twitter sharing button
 * @var $share_pinterest_enabled bool Whether to enable Pintereset sharing button
 * @var $share_email_enabled bool Whether to enable Email sharing button
 * @var $share_whatsapp_enabled bool Whether to enable WhatsApp sharing button (mobile online)
 * @var $share_url_enabled bool Whether to enable share via url
 * @var $share_link_title string Title to use for post (where applicable)
 * @var $share_link_url string Url to share
 * @var $share_summary string Summary to use for sharing on social media
 * @var $share_image_url string Image to use for sharing on social media
 * @var $share_twitter_summary string Summary to use for sharing on Twitter
 * @var $share_facebook_icon string Icon for facebook sharing button
 * @var $share_twitter_icon string Icon for twitter sharing button
 * @var $share_pinterest_icon string Icon for pinterest sharing button
 * @var $share_email_icon string Icon for email sharing button
 * @var $share_whatsapp_icon string Icon for whatsapp sharing button
 * @var $share_whatsapp_url string Sharing url on whatsapp
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

$icon_type       = riode_get_option( 'share_type' );
$custom          = riode_get_option( 'share_custom_color' ) ? ' custom' : '';
$share_no_follow = riode_get_option( 'social_no_follow' );

$nofollow = ' ';
if ( $share_no_follow ) {
	$nofollow = 'noopener noreferrer nofollow';
} else {
	$nofollow = 'noopener noreferrer';
}

global $riode_social_icon;

?>

<?php do_action( 'yith_wcwl_before_wishlist_share', $wishlist ); ?>

<div class="yith-wcwl-share">
	<h4 class="yith-wcwl-share-title"><?php echo esc_html( $share_title ); ?></h4>
	<div class="social-icons">
		<?php if ( $share_facebook_enabled ) : ?>
			<a target="_blank" class="social-icon <?php echo esc_attr( $icon_type . $custom ); ?> social-facebook" href="
															<?php
																echo esc_url(
																	strtr(
																		$riode_social_icon['facebook'][1],
																		array(
																			'$permalink' => $share_link_url,
																			'$title'     => $share_link_title,
																			'$image'     => $share_image_url,
																		)
																	)
																);
															?>
		" title="<?php esc_attr_e( 'Facebook', 'yith-woocommerce-wishlist' ); ?>" rel="<?php echo esc_attr( $nofollow ); ?>">
				<?php echo riode_strip_script_tags( $share_facebook_icon ? $share_facebook_icon : esc_html__( 'Facebook', 'yith-woocommerce-wishlist' ) ); ?>
			</a>
		<?php endif; ?>

		<?php if ( $share_twitter_enabled ) : ?>
			<a target="_blank" class="social-icon <?php echo esc_attr( $icon_type . $custom ); ?> social-twitter" href="
															<?php
																echo esc_url(
																	strtr(
																		$riode_social_icon['twitter'][1],
																		array(
																			'$permalink' => $share_link_url,
																			'$title'     => $share_link_title,
																			'$image'     => $share_image_url,
																		)
																	)
																);
															?>
		" title="<?php esc_attr_e( 'Twitter', 'yith-woocommerce-wishlist' ); ?>" rel="<?php echo esc_attr( $nofollow ); ?>">
				<?php echo riode_strip_script_tags( $share_twitter_icon ? $share_twitter_icon : esc_html__( 'Twitter', 'yith-woocommerce-wishlist' ) ); ?>
			</a>
		<?php endif; ?>

		<?php if ( $share_pinterest_enabled ) : ?>
			<a target="_blank" class="social-icon <?php echo esc_attr( $icon_type . $custom ); ?> social-pinterest" href="
															<?php
																echo esc_url(
																	strtr(
																		$riode_social_icon['pinterest'][1],
																		array(
																			'$permalink' => $share_link_url,
																			'$title'     => $share_link_title,
																			'$image'     => $share_image_url,
																		)
																	)
																);
															?>
		" title="<?php esc_attr_e( 'Pinterest', 'yith-woocommerce-wishlist' ); ?>" onclick="window.open(this.href); return false;"  rel="<?php echo esc_attr( $nofollow ); ?>">
				<?php echo riode_strip_script_tags( $share_pinterest_icon ? $share_pinterest_icon : esc_html__( 'Pinterest', 'yith-woocommerce-wishlist' ) ); ?>
			</a>
		<?php endif; ?>

		<?php if ( $share_email_enabled ) : ?>
			<a class="social-icon <?php echo esc_attr( $icon_type . $custom ); ?> social-email" href="
											<?php
												echo esc_url(
													strtr(
														$riode_social_icon['email'][1],
														array(
															'$permalink' => $share_link_url,
															'$title' => $share_link_title,
															'$image' => $share_image_url,
														)
													)
												);
											?>
		" title="<?php esc_attr_e( 'Email', 'yith-woocommerce-wishlist' ); ?>"  rel="<?php echo esc_attr( $nofollow ); ?>">
				<?php echo riode_strip_script_tags( $share_email_icon ? $share_email_icon : esc_html__( 'Email', 'yith-woocommerce-wishlist' ) ); ?>
			</a>
		<?php endif; ?>

		<?php
		if ( $share_whatsapp_enabled ) :
			?>
			<a class="social-icon <?php echo esc_attr( $icon_type . $custom ); ?> social-whatsapp" href="
											<?php
												echo esc_url(
													strtr(
														$riode_social_icon['whatsapp'][1],
														array(
															'$permalink' => $share_link_url,
															'$title' => $share_link_title,
															'$image' => $share_image_url,
														)
													)
												);
											?>
		" data-action="share/whatsapp/share" target="_blank" title="<?php esc_attr_e( 'WhatsApp', 'yith-woocommerce-wishlist' ); ?>"  rel="<?php echo esc_attr( $nofollow ); ?>">
				<?php echo riode_strip_script_tags( $share_whatsapp_icon ? $share_whatsapp_icon : esc_html__( 'Whatsapp', 'yith-woocommerce-wishlist' ) ); ?>
			</a>
			<?php
		endif;
		?>
	</ul>

	<?php if ( $share_url_enabled ) : ?>
		<div class="yith-wcwl-after-share-section">
			<input class="copy-target" readonly="readonly" type="url" name="yith_wcwl_share_url" id="yith_wcwl_share_url" value="<?php echo esc_url( $share_link_url ); ?>"/>
			<?php echo ( ! empty( $share_link_url ) ) ? sprintf( '<small>%s <span class="copy-trigger">%s</span> %s</small>', esc_html__( '(Now', 'yith-woocommerce-wishlist' ), esc_html__( 'copy', 'yith-woocommerce-wishlist' ), esc_html__( 'this wishlist link and share it anywhere)', 'yith-woocommerce-wishlist' ) ) : ''; ?>
		</div>
	<?php endif; ?>

	<?php do_action( 'yith_wcwl_after_share_buttons', $share_link_url, $share_title, $share_link_title ); ?>
</div>

<?php do_action( 'yith_wcwl_after_wishlist_share', $wishlist ); ?>
