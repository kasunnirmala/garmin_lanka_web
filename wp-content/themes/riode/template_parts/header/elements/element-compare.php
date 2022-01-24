<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-compare.php
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$count    = 0;
$prod_ids = array();
if ( class_exists( 'Riode_Product_Compare' ) && isset( $_COOKIE[ Riode_Product_Compare::get_instance()->_compare_cookie_name() ] ) ) {
	$prod_ids = json_decode( wp_unslash( $_COOKIE[ Riode_Product_Compare::get_instance()->_compare_cookie_name() ] ), true );
	$count    = count( $prod_ids );
}

$type        = isset( $type ) ? ( $type ? $type : '' ) : '';
$show_icon   = isset( $show_icon ) ? $show_icon : true;
$show_count  = isset( $show_count ) ? $show_count : true;
$show_label  = isset( $show_label ) ? $show_label : true;
$icon        = isset( $icon ) ? $icon : 'd-icon-compare';
$label       = isset( $label ) ? $label : esc_html( 'Compare', 'riode' );
$minicompare = isset( $minicompare ) ? ( $minicompare ? $minicompare : '' ) : '';

if ( $minicompare ) {
	echo '<div class="dropdown compare-dropdown mini-basket-dropdown ' . ( 'offcanvas' == $minicompare ? 'compare-offcanvas ' : ' ' ) . $minicompare . '-type" data-minicompare-type="' . $minicompare . '">';
}
?>
	<a class="compare-open <?php echo esc_attr( $type . '-type' ); ?>" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'compare' ) ) ); ?>">
		<?php if ( $show_icon ) : ?>
		<i class="<?php echo esc_attr( $icon ); ?>">
			<?php if ( $show_count ) : ?>
				<span class="compare-count"><?php echo esc_attr( $count ); ?></span>
			<?php endif; ?>
		</i>
		<?php endif; ?>
		<?php if ( $show_label ) : ?>
		<span><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
	</a>
<?php
if ( $minicompare ) {
	if ( 'offcanvas' == $minicompare ) :
		?>
		<div class="offcanvas-overlay compare-overlay"></div>
	<?php endif; ?>

	<div class="compare-popup dropdown-box">
		<?php
		if ( 'offcanvas' == $minicompare ) {
			echo '<div class="popup-header"><h3>' . esc_html__( 'Compare', 'riode' ) . '</h3><a class="btn btn-link btn-icon-after btn-close" href="#">' . esc_html__( 'close', 'riode' ) . '<i class="d-icon-arrow-' . ( is_rtl() ? 'left' : 'right' ) . '"></i></a></div>';
		}
		?>
		<div class="widget_compare_content">
		<?php if ( empty( $prod_ids ) ) : ?>
			<p class="empty-msg"><?php esc_html_e( 'No products in compare list.', 'riode' ); ?></p>
		<?php else : ?>
			<ul class="scrollable mini-list compare-list">
			<?php
			foreach ( $prod_ids as $id ) {
				$product = wc_get_product( $id );
				if ( $product ) {
					$product_name      = $product->get_data()['name'];
					$thumbnail         = $product->get_image( 'riode-product-thumbnail', array( 'class' => 'do-not-lazyload' ) );
					$product_price     = $product->get_price_html();
					$product_permalink = $product->is_visible() ? $product->get_permalink() : '';

					if ( ! $product_price ) {
						$product_price = '';
					}

					echo '<li class="mini-item compare-item">';

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

					echo '<a href="#" class="remove remove_from_compare" data-product_id="' . $id . '"><i class="fas fa-times"></i></a>';

					echo '</li>';
				}
			}
			?>
			</ul>
			<p class="compre-buttons buttons">
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'compare' ) ) ); ?>" class="button btn btn-dark btn-md btn-block"><?php esc_html_e( 'Go To Compare List', 'riode' ); ?></a>
			</p>
		<?php endif; ?>

		<?php
			// print templates for js work
			ob_start();
		?>
			<p class="empty-msg"><?php esc_html_e( 'No products in compare list.', 'riode' ); ?></p>
			<?php
			echo '<script type="text/template" class="riode-minicompare-no-item-html">' . ob_get_clean() . '</script>';
			?>

		</div>
	</div>

</div>
	<?php
}
