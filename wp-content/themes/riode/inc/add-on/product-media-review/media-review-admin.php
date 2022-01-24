<?php
/**
 * Riode Image Comment Admin addon
 *
 * @since 1.4.0
 * @package Riode Addon
 */

// Direct access is denied
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Riode_Product_Media_Comment_Admin' ) ) {
	class Riode_Product_Media_Comment_Admin {

		/**
		 * Meta key for comment image
		 *
		 */
		public $meta_key_image = '_riode_comment_image';


		/**
		 * Meta key for comment video
		 *
		 */
		public $meta_key_video = '_riode_comment_video';


		/**
		 * Meta keys for comment medias
		 *
		 */
		public $meta_keys = array();


		/**
		 * Meta keys for comment medias
		 *
		 */
		public $limit_count = 2;


		/**
		 * Constructor
		 *
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'add_meta_boxes_comment', array( $this, 'add_metaboxes' ) );
			add_action( 'edit_comment', array( $this, 'save_comment_meta' ), 10, 2 );
			add_action( 'delete_comment', array( $this, 'delete_medias' ), 10 );

			add_filter( 'manage_edit-comments_columns', array( $this, 'add_comment_list_columns' ) );
			add_action( 'manage_comments_custom_column', array( $this, 'add_comment_list_column' ), 10, 2 );
		}


		/**
		 * Enqueue scripts
		 *
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'riode-media-review', RIODE_ADDON_URI . '/product-media-review/media-review.css', null, RIODE_VERSION, 'all' );
			wp_enqueue_script( 'riode-media-review-admin', RIODE_ADDON_URI . '/product-media-review/media-review-admin.js', array(), RIODE_VERSION, true );
		}


		/**
		 * Add comment metaboxes
		 *
		 */
		public function add_metaboxes() {
			add_meta_box( 'riode-comment-medias-metabox', esc_html__( 'Riode Comment Medias', 'riode' ), array( $this, 'render' ), null, 'normal', 'low' );
		}


		/**
		 * Render meta field layout to add metaboxes
		 *
		 */
		public function render() {
			$comment_id  = $this->get_the_comment_id();
			$image_ids   = get_comment_meta( $comment_id, $this->meta_key_image, true );
			if ( $image_ids ) {
				$image_ids = explode( ',', $image_ids );
			} else {
				$image_ids = array();
			}
			$video_ids   = get_comment_meta( $comment_id, $this->meta_key_video, true );
			if ( $video_ids ) {
				$video_ids = explode( ',', $video_ids );
			} else {
				$video_ids = array();
			}
			?>
			<div class="review-form-section">
				<?php if ( empty( $image_ids ) && empty( $video_ids ) ) : ?>
					<p><?php echo esc_html__( 'No media files were uploaded for this comment.', 'riode' ); ?></p>
				<?php else: ?>
					<p><?php echo esc_html__( 'Below are media attachments uploaded for this comment.', 'riode' ); ?></p>
				<?php endif; ?>
				<div class="review-medias" style="margin-top: 20px;">
					<?php
					if ( count( $image_ids ) ) {
						foreach ( $image_ids as $image_id ) {
							if ( $image_id ) {
								$type = get_post_mime_type( $image_id );

								if ( 0 === strpos( $type, 'image' ) ) {
									$url           = wp_get_attachment_image_src( $image_id, 'full' )[0];
									$thumbnail_url = wp_get_attachment_image_src( $image_id, 'thumbnail' )[0];
									?>
									<div class="file-input form-control image-input" data-id="<?php echo esc_attr( $image_id ); ?>">
										<a class="file-input-wrapper" href="<?php echo esc_url( $url ); ?>" style="background-image: url(<?php echo esc_url( $thumbnail_url ); ?>)" target="__blank"></a>
										<label class="btn-action btn-remove" title="Remove Image">
										</label>
									</div>
									<?php
								}
							}
						}
					}
					if ( count( $video_ids ) ) {
						foreach ( $video_ids as $video_id ) {
							if ( $video_id ) {
								$type = get_post_mime_type( $video_id );

								if ( 0 === strpos( $type, 'video' ) ) {
									$url = wp_get_attachment_url( $video_id );
									?>
									<div class="file-input form-control video-input" data-id="<?php echo esc_attr( $video_id ); ?>">
										<a class="file-input-wrapper" href="<?php echo esc_url( $url ); ?>" target="__blank"><figure><video src="<?php echo esc_url( $url ) ?>" preload="metadata"></video></figure></a>
										<label class="btn-action btn-remove" title="Remove Video">
										</label>
									</div>
									<?php
								}
							}
						}
					}
					?>

					<input type="hidden" class="image-ids" name="<?php echo esc_attr( $this->meta_key_image ); ?>" value="<?php echo esc_attr( implode( ',', $image_ids ) ); ?>">
					<input type="hidden" class="video-ids" name="<?php echo esc_attr( $this->meta_key_video ); ?>" value="<?php echo esc_attr( implode( ',', $video_ids ) ); ?>">
				</div>
			</div>
			<?php
		}


		/**
		 * Get the comment ID
		 *
		 */
		public function get_the_comment_id() {
			$comment = get_comment();

			if ( ! $comment ) {
				return '';
			}

			return $comment->comment_ID;
		}


		/**
		 * Save comment meta
		 *
		 */
		public function save_comment_meta( $comment_id, $data ) {
			if ( isset( $_POST[ $this->meta_key_image ] ) ) {
				if ( $_POST[ $this->meta_key_image ] ) {
					update_comment_meta( $comment_id, $this->meta_key_image, esc_attr( $_POST[ $this->meta_key_image ] ) );
				} else {
					delete_comment_meta( $comment_id, $this->meta_key_image );
				}
			}
			if ( isset( $_POST[ $this->meta_key_video ] ) ) {
				if ( $_POST[ $this->meta_key_video ] ) {
					update_comment_meta( $comment_id, $this->meta_key_video, esc_attr( $_POST[ $this->meta_key_video ] ) );
				} else {
					delete_comment_meta( $comment_id, $this->meta_key_video );
				}
			}
		}


		/**
		 * Delete medias from comment
		 *
		 */
		public function delete_medias( $comment_id ) {
			$image_ids   = get_comment_meta( $id, $this->meta_key_image, true );
			if ( $image_ids ) {
				$image_ids = explode( ',', $image_ids );
			} else {
				$image_ids = array();
			}
			$video_ids   = get_comment_meta( $id, $this->meta_key_video, true );
			if ( $video_ids ) {
				$video_ids = explode( ',', $video_ids );
			} else {
				$video_ids = array();
			}

			$media_ids = array_merge( $image_ids, $video_ids );

			if ( count( $media_ids ) ) {
				foreach ( $media_ids as $id ) {
					wp_delete_attachment( $id, true );
				}
			}

			delete_comment_meta( $comment_id, $this->meta_key_image );
			delete_comment_meta( $comment_id, $this->meta_key_video );
		}


		/**
		 * Add attachments column header to list table
		 *
		 */
		public function add_comment_list_columns( $columns ) {
			return array_merge(
				array_splice( $columns, 0, 3 ),
				array(
					'attachments' => esc_html__( 'Attachments', 'riode' ),
				),
				array_splice( $columns, 0, 5 )
			);
		}


		/**
		 * Add attachments column data to list table
		 *
		 */
		public function add_comment_list_column( $name, $id ) {
			$image_ids   = get_comment_meta( $id, $this->meta_key_image, true );
			if ( $image_ids ) {
				$image_ids = explode( ',', $image_ids );
			} else {
				$image_ids = array();
			}
			$video_ids   = get_comment_meta( $id, $this->meta_key_video, true );
			if ( $video_ids ) {
				$video_ids = explode( ',', $video_ids );
			} else {
				$video_ids = array();
			}

			if ( empty( $image_ids ) && empty( $video_ids ) ) {
				echo '<p>' . esc_html__( 'No Attachments', 'riode' ) . '</p>';
			} else {
				$cnt = $this->limit_count;

				foreach ( $image_ids as $image_id ) {
					if ( $image_id ) {
						$type = get_post_mime_type( $image_id );

						if ( 0 === strpos( $type, 'image' ) ) {
							echo wp_get_attachment_image(
								$image_id,
								'thumbnail',
								false
							);
						}

						-- $cnt;
					}

					if ( $cnt == 0 ) {
						break;
					}
				}

				if ( $cnt > 0 ) {
					foreach ( $video_ids as $video_id ) {
						if ( $video_id ) {
							$type = get_post_mime_type( $video_id );

							if ( 0 === strpos( $type, 'video' ) ) {
								$url = wp_get_attachment_url( $video_id );
								echo '<figure class="video-attachment"><video class="" src="' . esc_url( $url ) . '" preload="metadata"></video></figure>';
							}

							-- $cnt;
						}

						if ( $cnt == 0 ) {
							break;
						}
					}
				}

				if ( count( $image_ids ) + count( $video_ids ) > $this->limit_count ) {
					echo '<span class="count-badge">' . ( count( $image_ids ) + count( $video_ids ) - $this->limit_count ) . '+</span>';
				}
			}
		}
	}
}

new Riode_Product_Media_Comment_Admin;
