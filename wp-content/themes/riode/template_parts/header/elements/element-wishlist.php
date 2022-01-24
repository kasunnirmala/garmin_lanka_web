<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-wishlist.php
 */

if ( class_exists( 'YITH_WCWL' ) ) {
	$wc_link  = YITH_WCWL()->get_wishlist_url();
	$wc_count = yith_wcwl_count_products();

	$wishlist       = YITH_WCWL_Wishlist_Factory::get_current_wishlist( array() );
	$wishlist_items = array();
	if ( $wishlist && $wishlist->has_items() ) {
		$wishlist_items = $wishlist->get_items();
	}

	$type         = isset( $type ) ? ( $type ? $type : '' ) : riode_get_option( 'wish_type' );
	$show_icon    = isset( $show_icon ) ? $show_icon : (bool) riode_get_option( 'wish_icon_show' );
	$show_count   = isset( $show_count ) ? $show_count : (bool) riode_get_option( 'wish_count' );
	$show_label   = isset( $show_label ) ? $show_label : (bool) riode_get_option( 'wish_title' );
	$icon         = isset( $icon ) ? $icon : ( riode_get_option( 'wish_icon' ) ? riode_get_option( 'wish_icon' ) : 'd-icon-heart' );
	$label        = isset( $label ) ? $label : ( riode_get_option( 'wish_title_text' ) ? riode_get_option( 'wish_title_text' ) : esc_html__( 'Wishlist', 'riode' ) );
	$miniwishlist = isset( $miniwishlist ) ? $miniwishlist : '';

	if ( $miniwishlist ) {
		echo '<div class="dropdown wishlist-dropdown mini-basket-dropdown ' . ( 'offcanvas' == $miniwishlist ? 'wishlist-offcanvas ' : ' ' ) . $miniwishlist . '-type" data-miniwishlist-type="' . $miniwishlist . '">';
	}
	?>
		<a class="wishlist <?php echo esc_attr( $type . '-type' ); ?>" href="<?php echo esc_url( $wc_link ); ?>">
			<?php if ( $show_icon ) : ?>
			<i class="<?php echo esc_attr( $icon ); ?>">
				<?php if ( $show_count ) : ?>
					<span class="wish-count"><?php echo esc_attr( $wc_count ); ?></span>
				<?php endif; ?>
			</i>
			<?php endif; ?>
			<?php if ( $show_label ) : ?>
			<span><?php echo esc_html( $label ); ?></span>
			<?php endif; ?>
		</a>
	<?php
	if ( $miniwishlist ) {
		if ( 'offcanvas' == $miniwishlist ) {
			echo '<div class="offcanvas-overlay wishlist-overlay"></div>';
		}
		?>

		<div class="wishlist-popup dropdown-box">
			<?php
			if ( 'offcanvas' == $miniwishlist ) {
				echo '<div class="popup-header"><h3>' . esc_html__( 'Wishlist', 'riode' ) . '</h3><a class="btn btn-link btn-icon-after btn-close" href="#">' . esc_html__( 'close', 'riode' ) . '<i class="d-icon-arrow-' . ( is_rtl() ? 'left' : 'right' ) . '"></i></a></div>';
			}
			?>
			<div class="widget_wishlist_content">
			<?php if ( empty( $wishlist_items ) ) : ?>
				<p class="empty-msg"><?php esc_html_e( 'No products in wishlist.', 'riode' ); ?></p>
			<?php else : ?>
				<ul class="scrollable mini-list wish-list">
				<?php
				foreach ( $wishlist_items as $item ) {
					$product = $item->get_product();
					if ( $product ) {
						$id                = $product->get_ID();
						$product_name      = $product->get_data()['name'];
						$thumbnail         = $product->get_image( 'riode-product-thumbnail', array( 'class' => 'do-not-lazyload' ) );
						$product_price     = $product->get_price_html();
						$product_permalink = $product->is_visible() ? $product->get_permalink() : '';

						if ( ! $product_price ) {
							$product_price = '';
						}

						echo '<li class="mini-item wishlist-item">';

						if ( empty( $product_permalink ) ) {
							echo riode_escaped( $thumbnail );
						} else {
							echo '<a href="' . esc_url( $product_permalink ) . '">' . $thumbnail . '</a>';
						}

						echo '<div class="mini-item-meta">';

						if ( empty( $product_permalink ) ) {
							echo riode_escaped( $product_name );
						} else {
							echo '<a href="' . esc_url( $product_permalink ) . '">' . $product_name . '</a>';
						}
						echo '<span class="quantity">' . $product_price . '</span>';

						echo '</div>';

						echo '<a href="#" class="remove remove_from_wishlist" data-product_id="' . $id . '"><i class="fas fa-times"></i></a>';

						echo '</li>';
					}
				}
				?>
				</ul>
				<p class="compre-buttons buttons">
					<a href="<?php echo esc_url( get_permalink( get_option( 'yith-wcwl-page-id' ) ) ); ?>" class="button btn btn-dark btn-md btn-block"><?php esc_html_e( 'Go To Wishlist', 'riode' ); ?></a>
				</p>
			<?php endif; ?>

			<?php
				// print templates for js work
				ob_start();
			?>
				<p class="empty-msg"><?php esc_html_e( 'No products in wishlist.', 'riode' ); ?></p>
				<?php
				echo '<script type="text/template" class="riode-miniwishlist-no-item-html">' . ob_get_clean() . '</script>';
				?>

			</div>
		</div>

		</div>
		<?php
	}
} else {
	?>
	<span class="no-plugin d-flex align-items-center"><i class="d-icon-alert mr-1" style="font-size: 22px;"></i><?php echo sprintf( esc_html__( '%1$sYith Wishlist Plugin%2$s is not installed.', 'riode' ), '<b class="mr-1">', '</b>' ); ?></span>
	<?php
}
