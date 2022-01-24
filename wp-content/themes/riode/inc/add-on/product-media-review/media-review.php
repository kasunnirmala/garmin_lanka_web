<?php
/**
 * Riode Media Comment Addon
 *
 * @since 1.4.0
 * @package Riode Addon
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Riode_Product_Media_Comment' ) ) {

	class Riode_Product_Media_Comment {
		/**
		 * Field name to be uploaded
		 *
		 */
		public $field_name = 'riode_comment_medias';

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
		 * Constructor
		 *
		 */
		public function __construct() {
			add_action( 'template_redirect', array( $this, 'init' ) );

			if ( count( $_FILES ) ) {
				add_action( 'comment_post', array( $this, 'save_comment_medias' ), 10, 3 );
			}
		}

		/**
		 * Init
		 *
		 */
		public function init() {
			if ( ! riode_is_product() ) {
				return;
			}

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
			add_action( 'woocommerce_product_review_comment_form_args', array( $this, 'add_file_input' ), 10 );
			add_action( 'woocommerce_review_after_comment_text', array( $this, 'display_medias' ), 30 );
			add_action( 'riode_wc_review_filter_toolbar', array( $this, 'print_filter_toolbar' ) );

			if ( isset( $_REQUEST ) && ! empty( $_REQUEST['review_filter'] ) ) {
				if ( 'with_image' == $_REQUEST['review_filter'] || 'with_video' == $_REQUEST['review_filter'] ) {
					add_filter( 'comments_clauses', array( $this, 'filter_by' ), 10, 2 );
				}
			}
		}


		/**
		 * Add Input field with file type
		 *
		 */
		public function add_file_input( $comments_form ) {
			if ( riode_is_product() ) {
				if ( is_user_logged_in() ) {
					$image_template = '<div class="file-input form-control image-input" style="background-image: url(' . wc_placeholder_img_src( array( 80, 80 ) ) . ');">
						<div class="file-input-wrapper"></div>
						<label class="btn-action btn-upload" title="Upload Media">
							<input type="file" accept="' . riode_get_option( 'product_review_image_type' ) . '" name="' . $this->field_name . '_%media_index%">
						</label>
						<label class="btn-action btn-remove" title="Remove Media">
						</label>
					</div>';

					$video_template = '<div class="file-input form-control video-input" style="background-image: url(' . wc_placeholder_img_src( array( 80, 80 ) ) . ');">
						<video class="file-input-wrapper" controls></video>
						<label class="btn-action btn-upload" title="Upload Media">
							<input type="file" accept="' . riode_get_option( 'product_review_video_type' ) . '" name="' . $this->field_name . '_%media_index%">
						</label>
						<label class="btn-action btn-remove" title="Remove Media">
						</label>
					</div>';

					$comments_form['comment_field'] .= '<div class="review-medias">';
					for ( $i = 0; $i < riode_get_option( 'product_review_image_cnt' ); $i++ ) {
						$comments_form['comment_field'] .= str_replace( '%media_index%', 'image_' . ( $i + 1 ), $image_template );
					}
					for ( $i = 0; $i < riode_get_option( 'product_review_video_cnt' ); $i++ ) {
						$comments_form['comment_field'] .= str_replace( '%media_index%', 'video_' . ( $i + 1 ), $video_template );
					}

					$comments_form['comment_field'] .= '<p>' . sprintf( esc_html__( 'Upload images and videos. Maximum count: %1$s, size: %2$sMB', 'riode' ), riode_get_option( 'product_review_image_cnt' ) + riode_get_option( 'product_review_video_cnt' ), riode_get_option( 'product_review_max_size' ) ) . '</p>';
					$comments_form['comment_field'] .= '</div>';
				} else {
					$comments_form['comment_field'] .= '<input type="text" class="form-control" value="" placeholder="' . esc_attr__( 'You have to login to add medias.', 'riode' ) . '" disabled>';
				}
			}

			return $comments_form;
		}


		/**
		 * Enqueue script
		 *
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'riode-media-review', RIODE_ADDON_URI . '/product-media-review/media-review.css', null, RIODE_VERSION, 'all' );
			wp_enqueue_script( 'riode-media-review', RIODE_ADDON_URI . '/product-media-review/media-review' . riode_get_js_extension(), array( 'riode-theme' ), RIODE_VERSION, true );
			wp_localize_script(
				'riode-media-review',
				'riode_media_review',
				array(
					'max_size' => $this->get_max_size(),
					'texts'    => array(
						'max_size_alert' => sprintf( esc_html__( 'Maximum limit of media size is %1$sMB. Please choose another one.', 'riode' ), riode_get_option( 'product_review_max_size' ) ),
					)
				)
			);
		}


		/**
		 * Get Maximun size of file to be uploaded
		 *
		 */
		public function get_max_size() {
			$max_size = (int) riode_get_option( 'product_review_max_size' ) * MB_IN_BYTES;
			return $max_size;
		}


		/**
		 * Upload medias
		 *
		 */
		public function save_comment_medias( $comment_id, $comment_approved, $comment ) {
			$post_id      = $comment['comment_post_ID'];
			$post         = get_post( $post_id );
			$image_ids    = array();
			$video_ids    = array();
			$field_images = array();
			$field_videos = array();
			$field_names  = array();

			for ( $i = 0; $i < riode_get_option( 'product_review_image_cnt' ); $i++ ) {
				$field_images[] = $this->field_name . '_image_' . ( $i + 1 );
			}
			for ( $i = 0; $i < riode_get_option( 'product_review_video_cnt' ); $i++ ) {
				$field_videos[] = $this->field_name . '_video_' . ( $i + 1 );
			}

			$field_names = array_merge( $field_images, $field_videos );

			if ( ! function_exists( 'media_handle_upload' ) ) {
				require_once ABSPATH . 'wp-admin/includes/image.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/media.php';
			}

			foreach ( $field_names as $name ) {
				if ( empty( $_FILES[ $name ] ) || ! $_FILES[ $name ]['name'] ) {
					continue;
				}

				$backup_files = $_FILES;
				$file    = array(
					'error'    => $_FILES[ $name ]['error'],
					'name'     => $_FILES[ $name ]['name'],
					'size'     => $_FILES[ $name ]['size'],
					'tmp_name' => $_FILES[ $name ]['tmp_name'],
					'type'     => $_FILES[ $name ]['type'],
				);

				$_FILES  = array( $this->field_name => $file );
				$title   = $file['name'];
				$dot_pos = strrpos( $title, '.' );
				if ( $dot_pos ) {
					$title = substr( $title, 0, $dot_pos );
				}

				// Upload media
				add_filter( 'intermediate_media_sizes', array( 'thumbnail' ), 10 );
				$attachment_id = media_handle_upload(
					$this->field_name,
					$post_id,
					array(
						'post_title' => $title,
					)
				);
				remove_filter( 'intermediate_media_sizes', array( 'thumbnail' ), 10 );

				// Check error
				if ( ! is_wp_error( $attachment_id ) ) {
					if ( in_array( $name, $field_images ) ) {
						$image_ids[] = $attachment_id;
					} else {
						$video_ids[] = $attachment_id;
					}
				}

				// Add alt text for attachement
				// translators: %1$s represents author name, %2$s represents product title.
				add_post_meta( $attachment_id, '_wp_attachment_media_alt', sprintf( esc_html__( 'Attachment media of %1$s\'s review on %2$s', 'riode' ), $comment['comment_author'], $post->post_title ), true );

				$_FILES = $backup_files;
			}

			if ( ! empty( $image_ids ) ) {
			update_comment_meta( $comment_id, $this->meta_key_image, implode( ',', $image_ids ) );
			} else {
				delete_comment_meta( $comment_id, $this->meta_key_image );
			}
			if ( ! empty( $video_ids ) ) {
			update_comment_meta( $comment_id, $this->meta_key_video, implode( ',', $video_ids ) );
			} else {
				delete_comment_meta( $comment_id, $this->meta_key_video );
			}
		}


		/**
		 * Get attached image ids as array
		 *
		 * @param integer comment_id
		 */
		public function get_attached_image_ids_arr( $comment_id = 0 ) {
			if ( ! $comment_id ) {
				$comment    = get_comment();
				$comment_id = $comment ? $comment->comment_ID : '';
			}
			$meta_data = get_comment_meta( $comment_id, $this->meta_key_image, true );
			if ( empty( $meta_data ) ) {
				return false;
			}
			return explode( ',', $meta_data );
		}


		/**
		 * Get attached video ids as array
		 *
		 * @param integer comment_id
		 */
		public function get_attached_video_ids_arr( $comment_id = 0 ) {
			if ( ! $comment_id ) {
				$comment    = get_comment();
				$comment_id = $comment ? $comment->comment_ID : '';
			}
			$meta_data = get_comment_meta( $comment_id, $this->meta_key_video, true );
			if ( empty( $meta_data ) ) {
				return false;
			}
			return explode( ',', $meta_data );
		}


		/**
		 * Get size of media to be attached to comment
		 *
		 * @return array
		 */
		public function get_media_sizes() {
			$sizes = array( 'thumbnail' );

			return $sizes;
		}


		/**
		 * Display attached medias on comment
		 *
		 */
		public function display_medias( $comment_content ) {
			$image_ids = $this->get_attached_image_ids_arr();
			$video_ids = $this->get_attached_video_ids_arr();
			if ( ! empty( $image_ids ) || ! empty( $video_ids ) ) :
				?>
			<div class="review-medias">
				<?php
				if ( $image_ids ) {
					foreach ( $image_ids as $image_id ) {
						if ( $image_id ) {
							$type = get_post_mime_type( $image_id );
	
							if ( 0 === strpos( $type, 'image' ) ) {
								$full_image = wp_get_attachment_image_src( $image_id, 'full' );
								if ( is_array( $full_image ) ) {
									echo wp_get_attachment_image(
										$image_id,
										'thumbnail',
										false,
										array(
											'data-img-src' => esc_url( $full_image[0] ),
										)
									);
								}
							}
						}
					}
				}
				if ( $video_ids ) {
					foreach ( $video_ids as $video_id ) {
						if ( $video_id ) {
							$type = get_post_mime_type( $video_id );

							if ( 0 === strpos( $type, 'video' ) ) {
								$url = wp_get_attachment_url( $video_id );

								echo '<figure class="video-attachment"><video class="" src="' . esc_url( $url ) . '" preload="metadata"></video></figure>';
							}
						}
					}
				}
				?>
			</div>
				<?php
			endif;
		}


		/**
		 * Display filter bars above product reviews
		 *
		 */
		public function print_filter_toolbar() {
			$filter = isset( $_REQUEST['review_filter'] ) ? $_REQUEST['review_filter'] : '';
			?>
			<div class="filter-medias">
				<a name="review_filter" class="btn btn-outline <?php echo esc_attr( '' == $filter ? 'active' : '' ); ?>" data-value=""><?php echo esc_html__( 'All Reviews', 'riode' ); ?></a>
				<a name="review_filter" class="btn btn-outline <?php echo esc_attr( 'with_image' == $filter ? 'active' : '' ); ?>" data-value="with_image"><?php echo esc_html__( 'With Images', 'riode' ); ?></a>
				<a name="review_filter" class="btn btn-outline <?php echo esc_attr( 'with_video' == $filter ? 'active' : '' ); ?>" data-value="with_video"><?php echo esc_html__( 'With Videos', 'riode' ); ?></a>
			</div>
			<?php
		}


		/**
		 * filter by media - with image/video
		 *
		 */
		public function filter_by( $clauses, $comment_query ) {
			global $wpdb;

			if ( empty( $clauses['where'] ) ) {
				$clauses['where'] = '';
			}

			if ( empty( $clauses['where'] ) ) {
				$clauses['where'] .= ' WHERE ';
			} else {
				$clauses['where'] .= ' AND ';
			}
			$clauses['where'] .= "EXISTS (SELECT comment_id FROM $wpdb->commentmeta WHERE comment_id = $wpdb->comments.comment_ID AND meta_key = '" . ( 'with_image' == $_REQUEST['review_filter'] ? '_riode_comment_image' : '_riode_comment_video' ) . "')";

			return $clauses;
		}
	}
}

new Riode_Product_Media_Comment;
