<?php
/**
 * Sidebar.php
 */

wp_enqueue_script( 'riode-sticky-lib' );

$sidebar_cls = array( 'sidebar' );
if ( 'top' == $pos && 'product_archive_layout' == $layout_slug ) {
	$sidebar_cls[] = 'top-sidebar';
	$sidebar_cls[] = 'sidebar-fixed';

	if ( 'product_archive_layout' == $layout_slug ) {
		$sidebar_cls[] = 'shop-sidebar';
	}
	if ( 'navigation' == $sidebar['type'] ) {
		$sidebar_cls[] = 'navigation-sidebar closed';
	} elseif ( 'horizontal' == $sidebar['type'] ) {
		$sidebar_cls[] = 'horizontal-sidebar';
	}
} else {
	$in_content = ! ( isset( $sidebar['type'] ) && 'control' == $sidebar['type'] ) || ( isset( $sidebar['place'] ) && 'in' == $sidebar['place'] );
	$control_in = ( isset( $sidebar['type'] ) && 'control' == $sidebar['type'] ) && ( isset( $sidebar['place'] ) && 'in' == $sidebar['place'] );

	if ( ! ( isset( $sidebar['type'] ) && 'control' == $sidebar['type'] ) ) {
		$sidebar_cls[] = 'classic-sidebar';
	} else {
		$sidebar_cls[] = 'controllable-sidebar';
	}

	if ( $in_content ) {
		$sidebar_cls[] = 'col-lg-3';

		if ( 'container' != $container ) {
			$sidebar_cls[] = 'col-xxl-2';
		}
	}

	if ( is_rtl() ) {
		$pos = 'left' == $pos ? 'right' : 'left';
	}
	$sidebar_cls[] = $pos . '-sidebar';

	if ( 'product_archive_layout' == $layout_slug ) {
		$sidebar_cls[] = 'shop-sidebar';
	}
	if ( $control_in && 'product_archive_layout' == $layout_slug ) {
		$sidebar_cls[] = 'sidebar-toggle-remain';
	}
	if ( ! isset( $sidebar['type'] ) || '' == $sidebar['type'] || $control_in ) {
		$sidebar_cls[] = 'sidebar-fixed';
	} else {
		$sidebar_cls[] = 'sidebar-offcanvas';
	}

	if ( isset( $sidebar['type'] ) && 'control' == $sidebar['type'] && ! $sidebar['first_show'] ) {
		$sidebar_cls[] = 'closed';
	}
}

?>

<aside class="<?php echo esc_attr( implode( ' ', apply_filters( 'riode_sidebar_classes', $sidebar_cls ) ) ); ?>" id="<?php echo esc_attr( $sidebar['id'] ); ?>">

<?php if ( 'top' == $pos && 'product_archive_layout' == $layout_slug ) { ?>

	<div class="sidebar-overlay">
	</div>
	<a class="sidebar-close" href="#"><i class="close-icon"></i></a>
	<div class="sidebar-content<?php echo esc_attr( 'horizontal' == $sidebar['type'] ? ' toolbox-left' : '' ); ?>">
		<?php if ( isset( $sidebar['type'] ) && 'navigation' == $sidebar['type'] ) : ?>
		<div class="filter-actions">
			<a href="#" class="sidebar-toggle-btn toggle-remain btn btn-sm btn-rounded btn-outline btn-primary"><?php echo esc_html__( 'Filter', 'riode' ); ?><i class="d-icon-arrow-left"></i></a>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="filter-clean"><?php echo esc_html__( 'Clean All', 'riode' ); ?></a>
		</div>
		<div class="top-filter-widgets row">
		<?php endif; ?>
		<?php
		// sidebar check again
		if ( is_active_sidebar( $sidebar['id'] ) ) :
			dynamic_sidebar( $sidebar['id'] );
		endif;
		?>
		<?php if ( isset( $sidebar['type'] ) && 'navigation' == $sidebar['type'] ) : ?>
		</div>
		<?php endif; ?>
	</div>

	<?php
} else {
	if ( $in_content || ( isset( $sidebar['overlay'] ) && 'true' == $sidebar['overlay'] ) ) :
		?>
	<div class="sidebar-overlay">
	</div>
	<a class="sidebar-close" href="#"><i class="close-icon"></i></a>
	<?php endif; ?>

	<?php
	if ( ! ( isset( $sidebar['type'] ) && 'control' == $sidebar['type'] ) ) :
		?>
		<a href="#" class="sidebar-toggle"><i class="fas fa-chevron-<?php echo esc_attr( 'left' == $pos ? 'right' : 'left' ); ?>"></i></a>
	<?php endif; ?>

	<div class="sidebar-content">
		<?php do_action( 'riode_sidebar_content_start' ); ?>

		<?php if ( $in_content ) : ?>
			<?php
			$sticky                        = array();
			$sticky['paddingOffsetTop']    = ! empty( $sidebar['sticky_top'] ) ? $sidebar['sticky_top'] : 0;
			$sticky['paddingOffsetBottom'] = ! empty( $sidebar['sticky_bottom'] ) ? $sidebar['sticky_bottom'] : 0;
			?>
		<div class="sticky-sidebar" data-sticky-options='<?php echo json_encode( $sticky ); ?>'>

		<?php endif; ?>

			<?php
			// sidebar check again
			if ( is_active_sidebar( $sidebar['id'] ) ) :
				dynamic_sidebar( $sidebar['id'] );
			endif;
			?>

		<?php if ( $in_content ) : ?>
		</div>
		<?php endif; ?>
		<?php do_action( 'riode_sidebar_content_end' ); ?>

	</div>

	<?php
}
?>
</aside>
