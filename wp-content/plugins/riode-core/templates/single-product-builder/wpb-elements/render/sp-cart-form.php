<?php
/**
 * Single Prodcut Cart Form Render
 *
 * @since 1.1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_sticky' => 'yes',
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-sp-rating-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {

	if ( 'yes' == $sp_sticky ) {
		add_filter( 'riode_single_product_sticky_cart_enabled', '__return_true' );
	}

	woocommerce_template_single_add_to_cart();

	if ( 'yes' == $sp_sticky ) {
		remove_filter( 'riode_single_product_sticky_cart_enabled', '__return_true' );
	}

	do_action( 'riode_single_product_builder_unset_product' );
}
?>
</div>
<?php
