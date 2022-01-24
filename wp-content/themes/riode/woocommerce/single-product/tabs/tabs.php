<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) :

	$product_tabs_type = apply_filters( 'riode_single_product_data_tab_type', 'tab' );
	$wrapper_class     = 'woocommerce-tabs wc-tabs-wrapper';

	if ( 'accordion' == $product_tabs_type ) {
		$wrapper_class .= ' accordion accordion-simple';
	} else {
		$wrapper_class .= ' tab tab-nav-simple tab-nav-center';
	}
	?>

	<?php do_action( 'riode_wc_product_before_tabs' ); ?>

	<div class="<?php echo esc_attr( apply_filters( 'riode_single_product_data_tab_class', $wrapper_class ) ); ?>">

		<?php if ( 'tab' == $product_tabs_type ) : ?>
			<ul class="nav nav-tabs tabs wc-tabs" role="tablist">
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<li class="nav-item <?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<a href="#tab-<?php echo esc_attr( $key ); ?>" class="nav-link">
							<?php echo riode_strip_script_tags( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<?php
			$panel_class = '';
			if ( 'accordion' == $product_tabs_type ) {
				$panel_class .= 'card-body collapsed';
				?>
				<div class="card">
					<div class="card-header <?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<a href="#tab-<?php echo esc_attr( $key ); ?>" class="expand">
							<?php echo riode_strip_script_tags( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
							<span class="toggle-icon opened"><i class="d-icon-angle-down"></i></span>
							<span class="toggle-icon closed"><i class="d-icon-angle-up"></i></span>
						</a>
					</div>
				<?php
			} else {
				$panel_class .= 'tab-pane';
			}
			?>
				<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab <?php echo esc_attr( $panel_class ); ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
					<?php
					if ( isset( $product_tab['callback'] ) ) {
						call_user_func( $product_tab['callback'], $key, $product_tab );
					}
					?>
				</div>
			<?php if ( 'accordion' == $product_tabs_type ) { ?>
				</div>
			<?php } ?>

		<?php endforeach; ?>

	</div>

	<?php do_action( 'woocommerce_product_after_tabs' ); ?>

<?php endif; ?>
