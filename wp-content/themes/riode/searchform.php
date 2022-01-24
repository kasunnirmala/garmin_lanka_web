<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-search-form.php
 */
$where            = isset( $args['aria_label'] ) && isset( $args['aria_label']['where'] ) ? $args['aria_label']['where'] : '';
$live_search      = (bool) riode_get_option( 'live_search' );
$search_type      = isset( $args['aria_label']['type'] ) ? $args['aria_label']['type'] : 'hs-simple';
$fullscreen_type  = isset( $args['aria_label']['fullscreen_type'] ) ? $args['aria_label']['fullscreen_type'] : 'fs-default';
$fullscreen_style = isset( $args['aria_label']['fullscreen_style'] ) ? $args['aria_label']['fullscreen_style'] : 'light';

$class            = $search_type;
$search_post_type = isset( $args['aria_label']['search_post_type'] ) ? $args['aria_label']['search_post_type'] : ( 'product' == get_post_type() ? 'product' : 'post' );
$search_category  = isset( $args['aria_label']['search_category'] ) ? $args['aria_label']['search_category'] : false;
$search_label     = isset( $args['aria_label']['search_label'] ) ? $args['aria_label']['search_label'] : '';
$border_type      = isset( $args['aria_label']['border_type'] ) ? $args['aria_label']['border_type'] : 'rounded';
$placeholder      = isset( $args['aria_label']['placeholder'] ) ? $args['aria_label']['placeholder'] : esc_html__( 'Search your keyword...', 'riode' );
$search_right     = isset( $args['aria_label']['search_right'] ) ? $args['aria_label']['search_right'] : false;
$icon             = isset( $args['aria_label']['icon'] ) ? $args['aria_label']['icon'] : 'd-icon-search';

if ( 'hs-flat' == $class ) {
	$class = 'hs-simple hs-flat';
} else {
	$class .= ' ' . esc_attr( $border_type );
}

if ( 'hs-fullscreen' == $search_type ) {
	$class .= ' ' . esc_attr( $fullscreen_type );
	if ( 'dark' == $fullscreen_style ) {
		$class .= ' dark-style';
	}
}

if ( '' == $where && ! isset( $args['aria_label']['type'] ) ) {
	$search_type = 'hs-simple';
	$class       = 'hs-simple';
} elseif ( 'header' == $where && isset( $args['aria_label']['device_class'] ) ) {
	$class .= $args['aria_label']['device_class'];
}
?>

<div class="search-wrapper <?php echo esc_attr( $class ); ?>">
	<?php if ( 'hs-toggle' == $search_type || 'hs-fullscreen' == $search_type ) : ?>
	<a href="#" class="search-toggle<?php echo esc_attr( $search_right ? ' search-right' : '' ); ?>">
		<i class="<?php echo esc_attr( $icon ); ?>"></i>
		<?php
		if ( $search_label ) :
			echo '<span>' . esc_attr( $search_label ) . '</span>';
		endif;
		?>
	</a>
	<?php endif; ?>
	<?php if ( 'hs-fullscreen' == $search_type ) : ?>
	<div class="search-form-overlay">
		<div class="close-overlay"></div>
		<a class="search-form-close"><i class="d-icon-times"></i></a>
		<div class="search-form-wrapper">
	<?php endif; ?>
	<form action="<?php echo esc_url( home_url() ); ?>/" method="get" class="input-wrapper">
		<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_post_type ); ?>"/>

		<?php if ( 'header' == $where && ( 'hs-toggle' == $search_type || 'hs-expanded' == $search_type || 'hs-fullscreen' == $search_type ) && $search_category ) : ?>
		<div class="select-box">
			<?php
			$args = array(
				'show_option_all' => esc_html__( 'All Categories', 'riode' ),
				'hierarchical'    => 1,
				'class'           => 'cat',
				'echo'            => 1,
				'value_field'     => 'slug',
				'selected'        => 1,
				'depth'           => 1,
			);
			if ( 'product' == $search_post_type && class_exists( 'WooCommerce' ) ) {
				$args['taxonomy'] = 'product_cat';
				$args['name']     = 'product_cat';
			}
			wp_dropdown_categories( $args );
			?>
		</div>
		<?php endif; ?>

		<input type="search" class="form-control" name="s" placeholder="<?php echo esc_attr( $placeholder ); ?>" required="" autocomplete="off">

		<?php if ( $live_search ) : ?>
			<div class="live-search-list"></div>
		<?php endif; ?>

		<button class="btn btn-search" type="submit">
			<i class="<?php echo esc_attr( $icon ); ?>"></i>
		</button> 
	</form>
	<?php if ( 'hs-fullscreen' == $search_type ) : ?>
		<div class="search-container mt-8 mb-6">
			<div class="scrollable">
				<div class="search-results row cols-xl-7 cols-lg-5 cols-md-4 cols-sm-3 cols-2">
				</div>
				<?php
				if ( 'fs-default' == $fullscreen_type ) {
					?>
					<div class="search-action d-flex align-items-center justify-content-center">
						<a href="#" class="btn btn-dark btn-rounded btn-icon-after text-white show-all" style="display: none;"><?php esc_html_e( 'View All', 'riode' ); ?><i class="d-icon-arrow-right"></i></a>
					</div>
					<?php
				}
				if ( 'fs-loadmore' == $fullscreen_type ) {
					?>
					<div class="search-action d-flex align-items-center justify-content-center">
						<a href="#" class="btn btn-dark btn-rounded btn-icon-after text-white loadmore" style="display: none;"><?php esc_html_e( 'Load more', 'riode' ); ?></a>
					</div>
					<?php
				}
				?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
