<?php
/**
 * Single Prodcut Flash Sale Render
 *
 * @since 1.1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_icon'       => 'd-icon-check',
			'sp_label'      => 'Flash Deals',
			'sp_ends_label' => 'Ends in:',
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-sp-flash-sale-container ' . $shortcode_class . $style_class,
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

	if ( function_exists( 'riode_single_product_sale_countdown' ) ) {
		$icon_html = '<i class="' . $sp_icon . '"></i>';
		riode_single_product_sale_countdown( $sp_label, $sp_ends_label, $icon_html );
	}
	do_action( 'riode_single_product_builder_unset_product' );
}
?>
</div>
<?php
