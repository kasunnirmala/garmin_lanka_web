<?php
/**
 * Dokan Widget Content Product Template
 *
 * @since 2.4
 *
 * @package dokan
 */

$img_kses = apply_filters(
	'dokan_product_image_attributes',
	array(
		'img' => array(
			'alt'       => array(),
			'class'     => array(),
			'height'    => array(),
			'src'       => array(),
			'width'     => array(),
			'data-lazy' => array(),
		),
	)
);

?>

<?php if ( $r->have_posts() ) : ?>
	<ul class="dokan-bestselling-product-widget product_list_widget products-col">
	<?php
	wc_set_loop_prop( 'product_type', 'widget' );
	wc_set_loop_prop( 'show_info', array( 'price', 'rating' ) );
	while ( $r->have_posts() ) :
		$r->the_post();

		global $product;
		wc_get_template_part( 'content', 'product' );

	endwhile;
	?>
	</ul>
<?php else : ?>
	<p><?php esc_html_e( 'No products found', 'dokan-lite' ); ?></p>
<?php endif; ?>
