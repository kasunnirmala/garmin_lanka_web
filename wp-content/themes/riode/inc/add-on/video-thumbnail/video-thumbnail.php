<?php
/**
 * Product Video Thumbnail
 *
 * Display video instead of thumbnail images
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Riode_Video_Thumbnail' ) ) :

	class Riode_Video_Thumbnail {
		public function __construct() {
			add_action( 'template_redirect', array( $this, 'init' ) );
		}

		/**
		 * Init all actions
		 */
		public function init() {
			if ( riode_is_product() && riode_get_option( 'product_video_thumbnail' ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
				add_action( 'riode_single_product_after_thumbnails', array( $this, 'printVideoThumbnails' ) );
			}
		}

		/**
		 * Load assets for video thumbnails
		 */
		public function enqueue_scripts() {
			wp_register_script( 'riode-video-thumbnail', RIODE_ADDON_URI . '/video-thumbnail/video-thumbnail.min.js', array( 'riode-theme' ), RIODE_VERSION, true );
		}

		/**
		 * Print video for product thumbnails.
		 */
		public function printVideoThumbnails() {
			$featured = get_the_post_thumbnail_url(); 

			// from library
			$ids = get_post_meta( get_the_ID(), 'riode_product_video_thumbnails' );
			if ( ! empty( $ids ) ) {
				riode_add_async_script( 'riode-video-thumbnail' );

				foreach ( $ids as $id ) {
					$url    = wp_get_attachment_url( $id );
					$poster = get_the_post_thumbnail_url( $id ) ? get_the_post_thumbnail_url( $id ) : $featured;
					?>

					<div class="product-thumb">
						<a href="#" class="riode-video-thumbnail-viewer"><img src="<?php echo esc_url( $poster ); ?>"></a>
						<script type="text/template" class="riode-video-thumbnail-data">
							<figure class="post-media fit-video">
								<?php echo do_shortcode( '[video src="' . esc_url( $url ) . '" poster="' . esc_url( $poster ) . '"]' ); ?>
							</figure>
						</script>
					</div>

					<?php
				}
			}

			// with video thumbnail shortcode
			$video_code = get_post_meta( get_the_ID(), 'riode_product_video_thumbnail_shortcode', true );
			if ( false !== strpos( $video_code, '[video src="' ) ) {
				riode_add_async_script( 'riode-video-thumbnail' );

				preg_match( '/poster="([^\"]*)"/', $video_code, $poster );
				$poster = empty( $poster ) ? $featured : $poster[1];
				$video_code = do_shortcode( preg_replace( '/poster="([^\"]*)"/', '', $video_code ) );
				?>

				<div class="product-thumb">
					<a href="#" class="riode-video-thumbnail-viewer"><img src="<?php echo esc_url( $poster ); ?>"></a>
					<script type="text/template" class="riode-video-thumbnail-data">
						<figure class="post-media fit-video">
						<?php echo riode_strip_script_tags( $video_code ); ?>
						</figure>
					</script>
				</div>

				<?php
			}
		}
	}
endif;

new Riode_Video_Thumbnail;