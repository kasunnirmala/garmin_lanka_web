<?php
/**
 * Product 360 Degree Gallery
 *
 * Display 360 degree images instead of product thumbnail
 *
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Riode_360_Gallery' ) ) :

	class Riode_360_Gallery {
		public function __construct() {
			add_action( 'template_redirect', array( $this, 'init' ) );
		}

		/**
		 * Init all actions
		 */
		public function init() {
			if ( riode_is_product() && riode_get_option( 'product_360_thumbnail' ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
				add_action( 'riode_single_product_after_thumbnails', array( $this, 'print360Gallery' ) );
			}
		}

		/**
		 * Load assets for 360 degree images
		 */
		public function enqueue_scripts() {
			wp_register_script( 'riode-360-gallery', RIODE_ADDON_URI . '/360-gallery/360-gallery.min.js', array( 'riode-theme' ), RIODE_VERSION, true );
		}

		/**
		 * Print 360 degree image for product thumbnails.
		 */
		public function print360Gallery() {
			// from library
			$ids = get_post_meta( get_the_ID(), 'riode_product_360_gallery' );
			if ( ! empty( $ids ) ) {
				riode_add_async_script( 'three-sixty' );
				riode_add_async_script( 'riode-360-gallery' );

				?>
				<div class="product-thumb">
					<a href="#" class="riode-360-gallery-viewer"><?php echo wp_get_attachment_image( $ids[0], 'shop_catalog' ); ?></a>

					<?php
					$srcs = array();

					for ( $i = 0; $i < count( $ids ); $i++ ) {
						$srcs[] = esc_url( wp_get_attachment_image_url( $ids[ $i ], 'full' ) );
					}
					?>

					<script type="text/template" class="riode-360-gallery-data">
						<ul class="riode-360-gallery-wrap list-type-none" data-srcs="<?php echo implode( ',', $srcs ); ?>">
						</ul>
						<div class="riode-degree-progress-bar"></div>
					</script>
				</div>
				<?php
			}
		}
	}
endif;

new Riode_360_Gallery;
