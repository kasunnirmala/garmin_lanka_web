<?php
/**
 * Single Prodcut Rating Render
 *
 * @since 1.1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_type'    => 'star',
			'sp_reviews' => 'yes',
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

	if ( '' == $sp_reviews ) {
		add_filter( 'riode_single_product_show_review', '__return_false' );
	}

	woocommerce_template_single_rating();

	if ( '' == $sp_reviews ) {
		remove_filter( 'riode_single_product_show_review', '__return_false' );
	}

	do_action( 'riode_single_product_builder_unset_product' );
}
?>
</div>
<?php
