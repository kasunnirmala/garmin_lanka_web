<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php
	if ( $order ) :
		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		wp_enqueue_script( 'riode-sticky-lib' )
		?>
		
		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed alert alert-simple order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button btn btn-dark btn-md pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
						<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button btn btn-dark btn-md btn-outline pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<div class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
				<div class="order-success">
					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							viewBox="0 0 50 50" enable-background="new 0 0 50 50" xml:space="preserve">
						<g>
							<path fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="bevel" stroke-miterlimit="10" d="
								M33.3,3.9c-2.7-1.1-5.6-1.8-8.7-1.8c-12.3,0-22.4,10-22.4,22.4c0,12.3,10,22.4,22.4,22.4c12.3,0,22.4-10,22.4-22.4
								c0-0.7,0-1.4-0.1-2.1"/>
								<polyline fill="none" stroke-width="4" stroke-linecap="round" stroke-linejoin="bevel" stroke-miterlimit="10" points="
								48,6.9 24.4,29.8 17.2,22.3 	"/>
						</g>
					</svg>
					<p>
						<strong><?php echo apply_filters( 'woocommerce_thankyou_order_received_text_before', esc_html__( 'Thank you!', 'riode' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
						<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Your order has been received', 'riode' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</p>
				</div>
			</div>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="overview-item">
					<span><?php esc_html_e( 'Order number:', 'riode' ); ?></span>
					<strong><?php echo riode_strip_script_tags( $order->get_order_number() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="overview-item">
					<span><?php esc_html_e( 'Status:', 'riode' ); ?></span>
					<strong><?php echo wc_get_order_status_name( $order->get_status() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="overview-item">
					<span><?php esc_html_e( 'Date:', 'riode' ); ?></span>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="overview-item">
					<span><?php esc_html_e( 'Email:', 'riode' ); ?></span>
					<strong><?php echo riode_strip_script_tags( $order->get_billing_email() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="overview-item">
					<span><?php esc_html_e( 'Total:', 'riode' ); ?></span>
					<strong><?php echo riode_strip_script_tags( $order->get_formatted_order_total() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="overview-item">
						<span><?php esc_html_e( 'Payment method:', 'riode' ); ?></span>
						<strong><?php echo riode_strip_script_tags( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

		<?php else : ?>

			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received alert alert-simple alert-success alert-icon"><i class="fas fa-check"></i><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

		<?php endif; ?>
	</div>
</div>
