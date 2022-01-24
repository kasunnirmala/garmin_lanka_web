<?php

use Elementor\Group_Control_Image_Size;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'type'           => 'html',
			'html'           => '',
			'block'          => '',
			'link'           => '#',
			'product'        => '',
			'image'          => array(),
			'icon'           => array( 'value' => 'd-icon-plus' ),
			'popup_position' => 'top',
			'el_class'       => '',
			'effect'         => 'type1',
			'page_builder'   => '',
			'image_size'     => '',
		),
		$atts
	)
);

if ( $icon && ! is_array( $icon ) ) {
	$icon          = json_decode( $icon, true );
	if ( isset( $icon['icon'] ) ) {
		$icon['value'] = $icon['icon'];
	} else {
		$icon['value'] = '';
	}
}

$wrapper_class = array( 'hotspot-wrapper' );

// Type
$wrapper_class[] = 'hotspot-' . $type;

// Effect
if ( $effect ) {
	$wrapper_class[] = 'hotspot-' . $effect;
}

if ( $el_class ) {
	$wrapper_class[] = esc_attr( $el_class );
}

$url        = isset( $link['url'] ) ? esc_url( $link['url'] ) : '#';
$product_id = $product;
if ( ! is_numeric( $product_id ) && is_string( $product_id ) ) {
	$product_id = riode_get_post_id_by_name( 'product', $product_id );
}

if ( 'product' == $type ) {
	$url = get_permalink( $product_id );
}
?>
<div class="<?php echo esc_attr( implode( ' ', $wrapper_class ) ); ?> tooltip-wrapper hotspot-<?php echo esc_attr( $popup_position ); ?>-tooltip">
	<a href="<?php echo esc_url( $url ); ?>"
	<?php echo ( ( isset( $link['is_external'] ) && $link['is_external'] ) ? ' target="nofollow"' : '' ) . ( ( isset( $link['nofollow'] ) && $link['nofollow'] ) ? ' rel="_blank"' : '' ); ?>
	class="hotspot"<?php echo ( 'product' == $type && $product_id ) ? ( ' data-product-id="' . $product_id . '"' ) : ''; ?>>
		<?php if ( $icon['value'] ) : ?>
			<i class="<?php echo esc_attr( $icon['value'] ); ?>"></i>
		<?php endif; ?>
	</a>
	<?php if ( 'none' != $popup_position ) : ?>
	<div class="tooltip <?php echo esc_attr( $popup_position ); ?>-tooltip">
		<?php
		if ( 'html' == $type ) {
			echo do_shortcode( $html );
		} elseif ( 'block' == $type ) {
			riode_print_template( $block );
		} elseif ( 'image' == $type ) {
			$image_html = '';
			if ( ! empty( $image ) ) {
				if ( $page_builder ) {
					$image_html = wp_get_attachment_image( $image, $image_size );
				} else {
					$image_html = Group_Control_Image_Size::get_attachment_image_html( $atts, 'image' );
				}
			}
			echo '<figure>' . $image_html . '</figure>';
		} elseif ( $product_id && class_exists( 'WooCommerce' ) ) {
			$args = array(
				'post_type' => 'product',
				'post__in'  => array( $product_id ),
			);

			$product = new WP_Query( $args );
			while ( $product->have_posts() ) {
				$product->the_post();
				global $post;
				?>
				<div <?php wc_product_class( 'woocommerce product-widget content-center', $post ); ?>>
					<div class="product-media">
						<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
							<?php echo woocommerce_get_product_thumbnail(); ?>
						</a>
					</div>
					<div class="product-body">
						<h3 class="woocommerce-loop-product__title product-title">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
						</h3>
						<?php woocommerce_template_loop_price(); ?>
						<div class="product-action">
							<?php woocommerce_template_loop_add_to_cart(); ?>
						</div>
					</div>
				</div>
				<?php
			}
			wp_reset_postdata();
		}
		?>
	</div>
	<?php endif; ?>
</div>
