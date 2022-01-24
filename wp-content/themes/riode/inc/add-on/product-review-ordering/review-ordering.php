<?php
/**
 * Riode Review Ordering Addon
 *
 * @since 1.4.0
 * @package Riode Addon
 */

defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Riode_Product_Review_Ordering' ) ) {

	class Riode_Product_Review_Ordering {
		/**
		 * Constructor
		 *
		 */
		public function __construct() {
			add_action( 'template_redirect', array( $this, 'init' ) );
		}

		/**
		 * Init
		 *
		 */
		public function init() {
			if( ! riode_is_product() ) {
				return;
			}

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
			add_filter( 'comments_template_query_args', array( $this, 'remove_hierarchical' ) );
			add_action( 'riode_wc_before_list_comments', array( $this, 'print_review_order_toolbox' ) );

			if ( isset( $_REQUEST ) ) {
				if ( ! empty( $_REQUEST['review_order'] ) ) {
					add_filter( 'woocommerce_product_review_list_args', array( $this, 'order_by_date' ) );

					if ( 'high_rate' == $_REQUEST['review_order'] || 'low_rate' == $_REQUEST['review_order'] ) {
						add_filter( 'comments_clauses', array( $this, 'order_by' ), 10, 2 );
					}
				}
			}
		}


		/**
		 * Enqueue script
		 *
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'riode-review-ordering', RIODE_ADDON_URI . '/product-review-ordering/review-ordering' . riode_get_js_extension(), array( 'riode-theme' ), RIODE_VERSION, true );
		}


		/**
		 * Remove hierarchical from comment query args
		 *
		 */
		public function remove_hierarchical( $args ) {
			$args['hierarchical'] = '';

			return $args;
		}


		/**
		 * Prints order/filter toolbox above comments list
		 *
		 */
		public function print_review_order_toolbox() {
			?>

			<div class="toolbox">
				<div class="toolbox-left">
					<?php do_action( 'riode_wc_review_filter_toolbar' ); ?>
				</div>
				<div class="toolbox-right">
					<div class="order-select select-box">
						<?php
						$orderby_options = apply_filters(
							'riode_wc_review_orderby_options',
							array(
								''          => esc_html__( 'Default Order', 'riode' ),
								'newest'    => esc_html__( 'Newest Reviews', 'riode' ),
								'oldest'    => esc_html__( 'Oldest Reviews', 'riode' ),
								'high_rate' => esc_html__( 'Highest Rating', 'riode' ),
								'low_rate'  => esc_html__( 'Lowest Rating', 'riode' ),
							)
						);
						$orderby         = isset( $_REQUEST ) && ! empty( $_REQUEST['review_order'] ) ? $_REQUEST['review_order'] : '';
						?>
						<label><?php esc_html_e( 'Sort By', 'riode' ); ?> :</label>
						<select name="review_order" class="orderby form-control" aria-label="<?php esc_attr_e( 'Comment Order', 'riode' ); ?>">
							<?php foreach ( $orderby_options as $arg => $name ) : ?>
								<option value="<?php echo esc_attr( $arg ); ?>" <?php selected( $orderby, $arg ); ?>><?php echo esc_html( $name ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>

			<?php
		}


		/**
		 * Order by date - Newest/Oldest
		 *
		 */
		public function order_by_date( $args ) {
			switch ( $_REQUEST['review_order'] ) {
				case 'newest':
					$args['reverse_top_level'] = true;
					break;
				case 'oldest':
					$args['reverse_top_level'] = false;
					break;
				default:
					$args['reverse_top_level'] = false;
					break;
			}

			return $args;
		}


		/**
		 * Order by rating - Highest/Lowest
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
			$clauses['where'] .= "$wpdb->commentmeta.meta_key = 'rating'";

			$order = "$wpdb->commentmeta" . ".meta_value " . ( 'high_rate' == $_REQUEST['review_order'] ? 'DESC' : 'ASC' );
			if ( empty( $clauses['orderby'] ) ) {
				$clauses['orderby'] .= $order;
			} else {
				$clauses['orderby'] = $order . ', ' . $clauses['orderby'];
			}

			return $clauses;
		}
	}
}

new Riode_Product_Review_Ordering;
