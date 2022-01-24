<?php if (  dokan_get_option( 'enable_theme_store_sidebar', 'dokan_appearance', 'off' ) === 'off' ) : ?>
	<?php wp_enqueue_script( 'riode-sticky-lib' ); ?>
	<div id="dokan-secondary" class="dokan-clearfix dokan-w3 dokan-store-sidebar sidebar sidebar-fixed left-sidebar col-lg-3" role="complementary">
		<div class="sidebar-overlay"></div>
		<a class="sidebar-close" href="#"><i class="close-icon"></i></a>
		<a href="#" class="sidebar-toggle"><i class="fas fa-chevron-right"></i></a>
		<div class="dokan-widget-area widget-collapse sidebar-content">
			<div class="sticky-sidebar">
			<?php do_action( 'dokan_sidebar_store_before', $store_user->data, $store_info ); ?>
			<?php
			if ( ! is_active_sidebar( 'sidebar-store' ) || ! dynamic_sidebar( 'sidebar-store' ) ) {
				$args = array(
					'before_widget' => '<aside class="widget dokan-store-widget %s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				);

				if ( dokan()->widgets->is_exists( 'store_category_menu' ) ) {
					the_widget( dokan()->widgets->store_category_menu, array( 'title' => esc_html__( 'Store Product Category', 'dokan-lite' ) ), $args );
				}

				if ( dokan()->widgets->is_exists( 'store_location' ) && dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on' && ! empty( $map_location ) ) {
					the_widget( dokan()->widgets->store_location, array( 'title' => esc_html__( 'Store Location', 'dokan-lite' ) ), $args );
				}

				if ( dokan()->widgets->is_exists( 'store_open_close' ) && dokan_get_option( 'store_open_close', 'dokan_general', 'on' ) == 'on' ) {
					the_widget( dokan()->widgets->store_open_close, array( 'title' => esc_html__( 'Store Time', 'dokan-lite' ) ), $args );
				}

				if ( dokan()->widgets->is_exists( 'store_contact_form' ) && dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
					the_widget( dokan()->widgets->store_contact_form, array( 'title' => esc_html__( 'Contact Vendor', 'dokan-lite' ) ), $args );
				}
			}
			?>

			<?php do_action( 'dokan_sidebar_store_after', $store_user->data, $store_info ); ?>
		</div>
		</div>
	</div><!-- #secondary .widget-area -->
<?php else : ?>
	<?php get_sidebar( 'store' ); ?>
<?php endif; ?>
