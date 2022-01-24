<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

$average_rate  = number_format( $product->get_average_rating(), 1 );
$display_rate  = $average_rate * 20;
$count         = $product->get_review_count();
$submit_review = get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() );

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<h2 class="woocommerce-Reviews-title">
			<?php
			if ( $count && wc_review_ratings_enabled() ) {
				/* translators: 1: reviews count 2: product name */
				$reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
				echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
			} else {
				esc_html_e( 'Reviews', 'woocommerce' );
			}
			?>
		</h2>

		<div class="row">
			<div class="col-lg-4">
				<div class="product-reviews-left">
					<h4 class="avg-rating-container">
						<mark><?php echo '' . $average_rate; ?></mark>
						<span class="avg-rating">
							<span class="avg-rating-title"><?php esc_html_e( 'Average Rating', 'riode' ); ?></span>
							<span class="star-rating">
								<span style="width: <?php echo riode_escaped( $display_rate ) . '%'; ?>;">Rated</span>
							</span>
							<span class="ratings-review"><?php echo '( ' . $count . ' ' . ( $count > 1 ? esc_html__( 'Reviews', 'riode' ) : esc_html__( 'Review', 'riode' ) ) . ' )'; ?></span>
						</span>
					</h4>
					<div class="ratings-list">
						<?php
						$ratings_count      = $product->get_rating_counts();
						$total_rating_value = 0;

						foreach ( $ratings_count as $key => $value ) {
							$total_rating_value += intval( $key ) * intval( $value );
						}

						for ( $i = 5; $i > 0; $i-- ) {
							$rating_value = isset( $ratings_count[ $i ] ) ? $ratings_count[ $i ] : 0;
							?>
							<div class="ratings-item" data-rating="<?php echo esc_attr( $i ); ?>">
								<div class="star-rating">
									<span style="width: <?php echo absint( $i ) * 20 . '%'; ?>">Rated</span>
								</div>
								<div class="rating-percent">
									<span style="width: 
									<?php
									if ( ! intval( $rating_value ) == 0 ) {
										echo round( floatval( number_format( ( $rating_value * $i ) / $total_rating_value, 3 ) * 100 ), 1 ) . '%';
									} else {
										echo '0%';
									}
									?>
									;"></span>
								</div>
								<div class="progress-value">
									<?php
									if ( ! intval( $rating_value ) == 0 ) {
										echo round( floatval( number_format( ( $rating_value * $i ) / $total_rating_value, 3 ) * 100 ), 1 ) . '%';
									} else {
										echo '0%';
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php if ( $submit_review ) : ?>
					<a class="btn btn-dark submit-review-toggle" href="#"><?php echo esc_html__( 'Submit Review', 'riode' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-lg-8">
				<?php if ( have_comments() ) : ?>
					<?php do_action( 'riode_wc_before_list_comments' ); ?>

					<ol class="commentlist product-comments-list">
						<?php
						wp_list_comments(
							apply_filters(
								'woocommerce_product_review_list_args',
								array(
									'callback' => 'woocommerce_comments',
								)
							)
						);
						?>
					</ol>

					<?php
					if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
						$page = get_query_var( 'cpage' );
						if ( ! $page ) {
							$page = 1;
						}
						$max_page = get_comment_pages_count();

						$new_args = array(
							'base'         => add_query_arg( 'cpage', '%#%' ),
							'add_fragment' => '#comments',
						);

						echo riode_get_pagination_html( $page, $max_page, '', $new_args );
					endif;
					?>
				<?php else : ?>
					<?php do_action( 'riode_wc_before_list_comments' ); ?>
					<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="review-form-section offcanvas">
		<div class="offcanvas-overlay"></div>
		<div id="review_form_wrapper" class="offcanvas-content scrollable">
			<?php if ( $submit_review ) : ?>
				<div id="review_form">
					<?php
					$commenter    = wp_get_current_commenter();
					$comment_form = array(
						/* translators: %s is product title */
						'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
						/* translators: %s is product title */
						'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
						'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
						'title_reply_after'   => '</span>',
						'comment_notes_after' => '',
						'label_submit'        => esc_html__( 'Submit Review', 'woocommerce' ),
						'logged_in_as'        => '',
						'comment_field'       => '',
					);

					$name_email_required = (bool) get_option( 'require_name_email', 1 );

					// author and email fields are replaced by riode_comment_form_args function
					$comment_form['fields'] = array(
						'author' => '',
						'email'  => '',
					);

					$account_page_url = wc_get_page_permalink( 'myaccount' );
					if ( $account_page_url ) {
						/* translators: %s opening and closing link tags respectively */
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
					}

					if ( wc_review_ratings_enabled() ) {
						$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
						</select></div>';
					}

					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

					?>

				</div>
			<?php else : ?>
				<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
			<?php endif; ?>
		</div>
		
	</div>
	<div class="clear"></div>
</div>
