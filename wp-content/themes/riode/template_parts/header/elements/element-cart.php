<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-cart.php
 */

if ( class_exists( 'WooCommerce' ) ) :
	$cart_type       = isset( $cart_type ) ? ( $cart_type ? $cart_type : 'inline' ) : riode_get_option( 'cart_type' );
	$icon_type       = isset( $icon_type ) ? $icon_type : riode_get_option( 'cart_icon_type' );
	$label_type      = isset( $label_type ) ? $label_type : riode_get_option( 'cart_label_type' );
	$title           = isset( $title ) ? $title : (bool) riode_get_option( 'cart_title' );
	$price           = isset( $price ) ? $price : (bool) riode_get_option( 'cart_price' );
	$delimiter       = isset( $delimiter ) ? $delimiter : riode_get_option( 'cart_delimiter' );
	$icon            = isset( $icon ) ? $icon : ( riode_get_option( 'cart_icon' ) ? riode_get_option( 'cart_icon' ) : 'd-icon-bag' );
	$label           = isset( $label ) ? $label : riode_get_option( 'cart_title_text' );
	$pfx             = isset( $pfx ) ? $pfx : riode_get_option( 'cart_count_pfx' );
	$sfx             = isset( $sfx ) ? $sfx : riode_get_option( 'cart_count_sfx' );
	$cart_off_canvas = isset( $cart_off_canvas ) ? $cart_off_canvas : riode_get_option( 'cart_off_canvas' );

	$extra_class = '';

	if ( $cart_off_canvas ) {
		$extra_class .= ' cart-offcanvas offcanvas-type';
	}
	?>
	<div class="dropdown  mini-basket-dropdown cart-dropdown<?php echo esc_attr( ( $icon_type ? ' ' . $icon_type . '-type ' : ' ' ) . $cart_type . '-type' . esc_attr( $extra_class ) ); ?>">
		<a class="cart-toggle" href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>">
			<?php if ( $title || $price ) { ?>
			<span class="cart-label <?php echo esc_attr( $label_type ) . '-type'; ?>">
			<?php } ?>
				<?php if ( $title ) : ?>
				<span class="cart-name"><?php echo esc_html( $label ); ?></span>
					<?php if ( $delimiter ) : ?>
				<span class="cart-name-delimiter"><?php echo esc_html( $delimiter ); ?></span>
				<?php endif; ?>
				<?php endif; ?>

				<?php if ( $price ) : ?>
				<span class="cart-price">$0.00</span>
				<?php endif; ?>
			<?php if ( $title || $price ) { ?>
			</span>
			<?php } ?>
			<?php if ( ! $icon_type ) : ?>
			<i class="minicart-icon">
				<span class="cart-count">0</span>
			</i>
			<?php elseif ( 'badge' == $icon_type ) : ?>
				<i class="<?php echo esc_attr( $icon ); ?>">
					<span class="cart-count">0</span>
				</i>
			<?php elseif ( 'label' == $icon_type ) : ?>
				<span class="cart-count-wrap">
				<?php
				$html = '';
				if ( $pfx ) {
					$html .= esc_html( $pfx );
				}
					$html .= '<span class="cart-count">0</span>';
				if ( $sfx ) {
					$html .= esc_html( $sfx );
				}
				echo riode_escaped( $html );
				?>
				</span>
			<?php endif ?>
		</a>
		<?php if ( $cart_off_canvas ) : ?>
			<div class="offcanvas-overlay cart-overlay"></div>
		<?php endif; ?>
		<div class="cart-popup widget_shopping_cart dropdown-box">
			<?php
			if ( $cart_off_canvas ) {
				echo '<div class="popup-header"><h3>' . esc_html__( 'Shopping Cart', 'riode' ) . '</h3><a class="btn btn-link btn-icon-after btn-close" href="#">' . esc_html__( 'close', 'riode' ) . '<i class="d-icon-arrow-' . ( is_rtl() ? 'left' : 'right' ) . '"></i></a></div>';
			}
			?>
			<div class="widget_shopping_cart_content">
				<div class="cart-loading"></div>
			</div>
		</div>
	</div>
	<?php
endif;
