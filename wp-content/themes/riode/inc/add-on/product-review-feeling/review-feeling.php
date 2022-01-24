<?php
/**
 * Riode Review Feeling Addon
 *
 * @since 1.4.0
 * @package Riode Addon
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Riode_Product_Review_Feeling' ) ) {

	class Riode_Product_Review_Feeling {
		/**
		 * Meta key for comment media
		 *
		 */
		public $meta_key = '_riode_review_';


		/**
		 * Constructor
		 *
		 */
		public function __construct() {
			add_action( 'template_redirect', array( $this, 'init' ) );

			add_action( 'wp_ajax_riode_comment_feeling', array( $this, 'change_review_feeling' ) );
			add_action( 'wp_ajax_nopriv_riode_comment_feeling', array( $this, 'change_review_feeling' ) );
		}

		/**
		 * Init
		 *
		 */
		public function init() {
			if ( riode_is_product() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
				add_action( 'woocommerce_review_after_comment_text', array( $this, 'display_feelings' ), 40 );
				add_filter( 'riode_wc_review_orderby_options', array( $this, 'add_orderby_options' ) );

				if ( isset( $_REQUEST ) && ! empty( $_REQUEST['review_order'] ) ) {
					if ( 'most_likely' == $_REQUEST['review_order'] || 'most_unlikely' == $_REQUEST['review_order'] ) {
						add_filter( 'comments_clauses', array( $this, 'order_by' ), 10, 2 );
					}
				}
			}
		}

		/**
		 *
		 *
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'riode-review-feeling', RIODE_ADDON_URI . '/product-review-feeling/review-feeling.css', null, RIODE_VERSION, 'all' );
			wp_enqueue_script( 'riode-review-feeling', RIODE_ADDON_URI . '/product-review-feeling/review-feeling' . riode_get_js_extension(), array( 'riode-theme' ), RIODE_VERSION, true );

			wp_localize_script(
				'riode-review-feeling',
				'riode_review_feeling_vars',
				array(
					'ajax_url'     => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'        => wp_create_nonce( 'riode-review-feeling' ),
				)
			);
		}


		/** 
		 * Manages like/unlike ajax action
		 *
		 */
		public function change_review_feeling() {
			if ( ! check_ajax_referer( 'riode-review-feeling', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}
			$comment_id = isset( $_POST['comment_id'] ) ? $_POST['comment_id'] : 0;
			if ( $comment_id ) {
				$modes        = $_POST['modes'];
				$userid       = get_current_user_id();

				$like         = get_comment_meta( $comment_id, $this->meta_key . 'like_cnt', true );
				$unlike       = get_comment_meta( $comment_id, $this->meta_key . 'unlike_cnt', true );
				$like_users   = get_comment_meta( $comment_id, $this->meta_key . 'like_users', true );
				$unlike_users = get_comment_meta( $comment_id, $this->meta_key . 'unlike_users', true );
				$like         = $like ? $like : 0;
				$unlike       = $unlike ? $unlike : 0;
				$like_users   = $like_users ? json_decode( $like_users, true ) : array();
				$unlike_users = $unlike_users ? json_decode( $unlike_users, true ) : array();

				$cookie = isset( $_COOKIE['riode_feeling_comments'] ) ? $_COOKIE['riode_feeling_comments'] : '';
				if ( empty( $cookie ) ) {
					$cookie = array(
						'like_comments' => array(),
						'unlike_comments' => array()
					);
				} else {
					$cookie = str_replace( '\\', '', $cookie );
					$cookie = json_decode( $cookie, true );
				}

				if ( is_array( $modes ) && count( $modes ) ) {
					foreach ( $modes as $mode ) {
						switch ( $mode ) {
							case 'add_like':
								++ $like;
								if ( $userid && ! in_array( $userid, $like_users ) ) {
									$like_users[] = $userid;
								}
								if ( ! in_array( $comment_id, $cookie['like_comments'] ) ) {
									$cookie['like_comments'][] = $comment_id;
								}
								break;
							case 'remove_like':
								$like = max( 0, -- $like );
								if ( $userid && in_array( $userid, $like_users ) ) {
									$idx        = array_search( $userid, $like_users );
									$like_users = array_merge( array_splice( $like_users, 0, $idx ), array_splice( $like_users, 1 ) );
								}
								if ( in_array( $comment_id, $cookie['like_comments'] ) ) {
									$idx                     = array_search( $comment_id, $cookie['like_comments'] );
									$cookie['like_comments'] = array_merge( array_splice( $cookie['like_comments'], 0, $idx ), array_splice( $cookie['like_comments'], 1 ) );
								}
								break;
							case 'add_unlike':
								++ $unlike;
								if ( $userid && ! in_array( $userid, $unlike_users ) ) {
									$unlike_users[] = $userid;
								}
								if ( ! in_array( $comment_id, $cookie['unlike_comments'] ) ) {
									$cookie['unlike_comments'][] = $comment_id;
								}
								break;
							case 'remove_unlike':
								$unlike = max( 0, -- $unlike );
								if ( $userid && in_array( $userid, $unlike_users ) ) {
									$idx        = array_search( $userid, $unlike_users );
									$unlike_users = array_merge( array_splice( $unlike_users, 0, $idx ), array_splice( $unlike_users, 1 ) );
								}
								if ( in_array( $comment_id, $cookie['unlike_comments'] ) ) {
									$idx                     = array_search( $comment_id, $cookie['unlike_comments'] );
									$cookie['unlike_comments'] = array_merge( array_splice( $cookie['unlike_comments'], 0, $idx ), array_splice( $cookie['unlike_comments'], 1 ) );
								}
								break;
						}
					}
				}

				setcookie( 'riode_feeling_comments', '', time() - 3600);
				if ( ! empty( $cookie['like_comments'] ) || ! empty( $cookie['unlike_comments'] ) ) {
					setcookie( 'riode_feeling_comments', json_encode( array( 
						'like_comments'   => $cookie['like_comments'],
						'unlike_comments' => $cookie['unlike_comments']
					 ) ), time() + 360 * 24 * 60 * 60, '/' );
				}

				update_comment_meta( $comment_id, $this->meta_key . 'like_cnt', $like );
				update_comment_meta( $comment_id, $this->meta_key . 'like_users', json_encode( $like_users ) );
				update_comment_meta( $comment_id, $this->meta_key . 'unlike_cnt', $unlike );
				update_comment_meta( $comment_id, $this->meta_key . 'unlike_users', json_encode( $unlike_users ) );
			}

			wp_send_json_success(
				array(
					'like'   => $like,
					'unlike' => $unlike,
				)
			);
			exit();
		}


		/**
		 * Display attached medias on comment
		 *
		 */
		public function display_feelings( $comment_content ) {
			$comment = get_comment();
			?>
			<div class="feeling">
			<?php
				$like         = get_comment_meta( $comment->comment_ID, $this->meta_key . 'like_cnt', true );
				$unlike       = get_comment_meta( $comment->comment_ID, $this->meta_key . 'unlike_cnt', true );
				$like_users   = get_comment_meta( $comment->comment_ID, $this->meta_key . 'like_users', true );
				$unlike_users = get_comment_meta( $comment->comment_ID, $this->meta_key . 'unlike_users', true );
				$like         = $like ? $like : 0;
				$unlike       = $unlike ? $unlike : 0;
				$like_users   = $like_users ? json_decode( $like_users, true ) : array();
				$unlike_users = $unlike_users ? json_decode( $unlike_users, true ) : array();
				$status       = '';

				$cookie = isset( $_COOKIE['riode_feeling_comments'] ) ? $_COOKIE['riode_feeling_comments'] : '';
				if ( ! empty( $cookie ) ) {
					$cookie = str_replace( '\\', '', $cookie );
					$cookie = json_decode( $cookie, true );

					if ( in_array( $comment->comment_ID, $cookie['like_comments'] ) ) {
						$status = 'like';
					} elseif ( in_array( $comment->comment_ID, $cookie['unlike_comments'] ) ) {
						$status = 'unlike';
					}
				}

				if ( ! $status && $userid = get_current_user_id() ) {
					if ( in_array( $userid, $like_users ) ) {
						$status = 'like';
					} elseif ( in_array( get_current_user_id(), $unlike_users ) ) {
						$status = 'unlike';
					}
				}
			?>
				<button class="btn btn-link btn-icon-left btn-slide-up btn-infinite like<?php echo esc_attr( 'like' == $status ? ' active' : '' ); ?>">
					<i class="fa fa-thumbs-up"></i>
					<?php echo esc_html__( 'Like', 'riode' ); ?>
					<span class="count"><?php echo esc_html( $like ? $like : 0 ); ?></span>
				</button>
				<button class="btn btn-link btn-icon-left btn-slide-down btn-infinite unlike<?php echo esc_attr( 'unlike' == $status ? ' active' : '' ); ?>">
					<i class="fa fa-thumbs-down"></i>
					<?php echo esc_html__( 'Unlike', 'riode' ); ?>
					<span class="count"><?php echo esc_html( $unlike ? $unlike : 0 ); ?></span>
				</button>
			</div>
			<?php
		}


		/**
		 * adds orderby options related to feeling
		 *
		 */
		public function add_orderby_options( $options ) {
			$options['most_likely'] = esc_html__( 'Most Likely', 'riode' );
			$options['most_unlikely'] = esc_html__( 'Most Unlikely', 'riode' );

			return $options;
		}


		/**
		 * Order by Feeling - Most Likely/Unlikely
		 *
		 */
		public function order_by( $clauses, $comment_query ) {
			global $wpdb;

			if ( empty( $clauses['where'] ) ) {
				$clauses['where'] = '';
			}
			if ( empty( $clauses['join'] ) ) {
				$clauses['join'] = '';
			}
			if ( empty( $clauses['order'] ) ) {
				$clauses['order'] = '';
			}

			if ( false === strpos( $clauses['join'], "$wpdb->commentmeta" ) ) {
				$clauses['join'] .= " JOIN $wpdb->commentmeta on $wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id";
			}

			if ( empty( $clauses['where'] ) ) {
				$clauses['where'] .= ' WHERE ';
			} else {
				$clauses['where'] .= ' AND ';
			}
			$clauses['where'] .= "$wpdb->commentmeta.meta_key = '" . ( 'most_likely' == $_REQUEST['review_order'] ? '_riode_review_like_cnt' : '_riode_review_unlike_cnt' ) . "'";

			$order = "$wpdb->commentmeta" . ".meta_value DESC";
			if ( empty( $clauses['orderby'] ) ) {
				$clauses['orderby'] .= $order;
			} else {
				$clauses['orderby'] = $order . ', ' . $clauses['orderby'];
			}

			return $clauses;
		}
	}
}

new Riode_Product_Review_Feeling;
