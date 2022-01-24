<?php
defined( 'ABSPATH' ) || die;

/**
 * riode Elementor Vendors Widget Render
 *
 * @since 1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Select Vendors
			'vendor_select_type'  => 'group',
			'vendor_ids'          => '',
			'vendor_type'         => '',
			'vendor_count'        => '',
			'vendor_period'       => '',

			// Select Vendors Layout
			'col_cnt'             => array( 'size' => 4 ),
			'col_sp'              => 'md',
			'layout_type'         => 'grid',

			// Select Vendor Display Type
			'vendor_display_type' => '1',
			'show_vendor_rating'  => '',
			'show_total_sale'     => '',
			'page_builder'        => 'Elementor',
		),
		$atts
	)
);
if ( 'wpb' == $page_builder ) {
	$vendor_ids = explode( ',', $vendor_ids );
}

$vendors          = [];
$wrapper_class    = array();
$wrapper_attrs    = '';
$grid_space_class = riode_elementor_grid_space_class( $atts );
$col_cnt          = riode_elementor_grid_col_cnt( $atts );

if ( 'group' == $vendor_select_type ) {
	if ( 'sale' == $vendor_type ) {
		$vendors = riode_get_best_sellers( $vendor_count, $vendor_period );
	}

	if ( 'rating' == $vendor_type ) {
		$vendors = riode_get_top_rating_sellers( $vendor_count );
	}

	if ( 'recent' == $vendor_type ) {
		$vendors = riode_get_sellers( $vendor_count, 'registered' );
	}

	if ( '' == $vendor_type ) {
		$vendors = riode_get_sellers( $vendor_count );
	}
} else {
	if ( ! empty( $vendor_ids ) ) {
		foreach ( $vendor_ids as $id ) {
			$vendor['id'] = $id;
			$vendors[]    = $vendor;
		}
	}
}

if ( $grid_space_class ) {
	$wrapper_class[] = $grid_space_class;
}

if ( 'slider' == $layout_type ) {
	do_action( 'riode_save_used_widget', 'slider' );

	$wrapper_class = riode_get_slider_class( $atts );

	$wrapper_attrs = ' data-plugin="owl" data-owl-options=' . esc_attr(
		json_encode(
			riode_get_slider_attrs( $atts, $col_cnt )
		)
	);

	echo '<div ' . $wrapper_attrs . ' class="riode-vendor-group ' . $wrapper_class . '">';
} else {
	$extra_class = riode_get_col_class( $col_cnt );
	echo '<div class="riode-vendor-group ' . $extra_class . '">';
}
if ( 0 == count( $vendors ) ) {
	echo esc_html__( 'There are no vendors matched', 'riode-core' );
}

foreach ( $vendors as $vendor ) {
	if ( class_exists( 'WeDevs_Dokan' ) ) {
		$vendor_info = riode_get_dokan_vendor_info( $vendor );
	} elseif ( class_exists( 'WCFM' ) ) {
		$vendor_info = riode_get_wcfm_vendor_info( $vendor );
	} elseif ( class_exists( 'WCMp' ) ) {
		$vendor_info = riode_get_wcmp_vendor_info( $vendor );
	}

	if ( empty( $vendor_info ) ) {
		continue;
	}

	$query = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'showposts'           => 3,
		'meta_key'            => 'total_sales',
		'orderby'             => 'meta_value_num',
		'author'              => $vendor_info['id'],
	);
	$list  = new WP_Query( $query );


	echo '<div class="vendor-widget-wrap">';

	if ( '1' == $vendor_display_type ) { ?>
		<div class="vendor-widget vendor-widget-1">
			<div class="vendor-details">
				<figure class="vendor-logo">
					<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>">
						<?php
						if ( class_exists( 'WCMp' ) || class_exists( 'WCFM' ) ) {
							?>
							<img src="<?php echo esc_url( $vendor_info['avatar_url'] ); ?>" alt="<?php echo esc_html( $vendor_info['store_name'] ); ?>">
							<?php
						} else {
							echo get_avatar( $vendor_info['id'], 60 );
						}
						?>
					</a>
				</figure>
				<div class="vendor-personal">
					<h4 class="vendor-name"><a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>"><?php echo esc_html( $vendor_info['store_name'] ); ?></a> <span class="vendor-products-count">( <?php echo esc_html( $vendor_info['products_count'] ) . esc_html__( ' Products', 'riode-core' ); ?>)</span></h4>
					<?php
					if ( 'yes' == $show_vendor_rating ) {
						?>
					<div class="ratings-container">
						<?php
						echo wc_get_rating_html( $vendor_info['rating'] );
						?>
					</div>
						<?php
					}
					?>
					<?php
					if ( 'yes' == $show_total_sale ) :
						?>
					<span class="vendor-sale">
						<?php echo get_woocommerce_currency_symbol() . $vendor_info['total_sale'] . esc_html__( ' earned', 'riode-core' ); ?>
					</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="vendor-products grid-type gutter-xs ">
				<?php

				if ( $list->have_posts() ) {
					$index = 0;
					while ( $list->have_posts() && $index < 3 ) {
						global $post;
						$class = 'large-item';
						$list->the_post();
						?>
					<div class="vendor-product">
						<figure class="product-media">
							<a href="<?php esc_url( the_permalink() ); ?>">
								<?php
								echo get_the_post_thumbnail( $post->ID, ( 'large-item' == $class ) ? 'shop_catalog' : 'shop_thumbnail' );
								?>
							</a>
						</figure>
					</div>
						<?php
						$index++;
					}
					wp_reset_postdata();
				}
				?>
			</div>
		</div>
		<?php
	} elseif ( '2' == $vendor_display_type ) {
		?>
		<div class="vendor-widget vendor-widget-2">
			<div class="vendor-details">

				<figure class="vendor-logo">
					<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>">
						<?php
						if ( class_exists( 'WCMp' ) || class_exists( 'WCFM' ) ) {
							?>
							<img src="<?php echo esc_url( $vendor_info['avatar_url'] ); ?>" alt="<?php echo esc_html( $vendor_info['store_name'] ); ?>">
							<?php
						} else {
							echo get_avatar( $vendor_info['id'], 60 );
						}
						?>
					</a>
				</figure>

				<div class="vendor-personal">
					<h4 class="vendor-name">
						<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>" title="<?php echo esc_attr( $vendor_info['store_name'] ); ?>"><?php echo esc_html( $vendor_info['store_name'] ); ?></a>
					</h4>

					<span class="vendor-products-count">(<?php echo esc_attr( $vendor_info['products_count'] ) . esc_html__( ' Products', 'wolmart-core' ); ?>)</span>

					<div class="ratings-container">
						<?php echo wc_get_rating_html( $vendor_info['rating'] ); ?>
					</div>

					<?php if ( 'yes' == $show_total_sale ) : ?>
					<p class="vendor-sale">
						<?php echo get_woocommerce_currency_symbol() . round( $vendor_info['total_sale'], 2 ) . esc_html__( ' earned', 'wolmart-core' ); ?>
					</p>
					<?php endif; ?>
				</div>
			</div>
			<?php if ( $list->have_posts() ) : ?>
			<div class="vendor-products row cols-3 gutter-sm">
				<?php
				$index = 0;
				while ( $list->have_posts() && $index < 3 ) {
					global $post;
					$list->the_post();
					?>
					<div class="vendor-product">
						<figure class="product-media">
							<a href="<?php esc_url( the_permalink() ); ?>">
							<?php
							echo get_the_post_thumbnail( $post->ID, 'shop_catalog' );
							?>
							</a>
						</figure>
					</div>
					<?php
					$index++;
				}
				wp_reset_postdata();
				?>
			</div>
			<?php endif; ?>
		</div>
		<?php
	} else {
		?>
		<div class="vendor-widget vendor-widget-3 vendor-widget-banner">
			<figure class="vendor-banner">
			<?php echo wp_get_attachment_image( $vendor_info['banner'], 'full' ); ?> 
			</figure>

			<div class="vendor-details">
				<figure class="vendor-logo">
					<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>">
				<?php
				if ( class_exists( 'WCMp' ) || class_exists( 'WCFM' ) ) {
					?>
							<img src="<?php echo esc_url( $vendor_info['avatar_url'] ); ?>" width="90" height="90" alt="<?php echo esc_html( $vendor_info['store_name'] ); ?>">
						<?php
				} else {
					echo get_avatar( $vendor_info['id'], 90 );
				}
				?>
					</a>
				</figure>

				<h4 class="vendor-name">
					<a href="<?php echo esc_url( $vendor_info['store_url'] ); ?>" title="<?php echo esc_attr( $vendor_info['store_name'] ); ?>"><?php echo esc_html( $vendor_info['store_name'] ); ?></a>
				</h4>

				<?php if ( 'yes' == $show_vendor_rating ) : ?>
				<div class="ratings-container">
					<?php
					echo wc_get_rating_html( $vendor_info['rating'] );
					?>
				</div>
				<?php endif; ?>

				<p class="vendor-products-count"><?php echo $vendor_info['products_count'] . esc_html__( ' Products', 'riode-core' ); ?> </p>

					<?php if ( $list->have_posts() ) : ?>
				<div class="vendor-products row cols-3 gutter-sm">
						<?php
						$index = 0;
						while ( $list->have_posts() && $index < 3 ) {
							global $post;
							$list->the_post();
							?>
						<div class="vendor-product">
							<figure class="product-media">
								<a href="<?php esc_url( the_permalink() ); ?>">
								<?php
								echo get_the_post_thumbnail( $post->ID, 'shop_catalog' );
								?>
								</a>
							</figure>
						</div>
							<?php
							$index++;
						}
						wp_reset_postdata();
						?>
				</div>
				<?php endif; ?>
			</div>

		</div>
			<?php
	}

		echo '</div>';
}
		echo '</div>';
