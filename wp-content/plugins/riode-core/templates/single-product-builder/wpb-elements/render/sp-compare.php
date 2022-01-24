<?php
/**
 * Single Prodcut Compare Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-sp-compare-container ' . $shortcode_class . $style_class,
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

	riode_single_product_compare();

	do_action( 'riode_single_product_builder_unset_product' );
}
?>
</div>
<?php
