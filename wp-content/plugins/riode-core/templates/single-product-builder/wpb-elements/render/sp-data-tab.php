<?php
/**
 * Single Prodcut Data Tab Render
 *
 * @since 1.1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_type' => '',
		),
		$atts
	)
);
$GLOBALS['riode_sp_data_tab_settings'] = $atts;
// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-sp-data-tab-container ' . $shortcode_class . $style_class,
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
	if ( ! function_exists( 'riode_get_tab_type' ) ) {
		function riode_get_tab_type( $type ) {
			global $riode_sp_data_tab_settings;
			$sp_type = '';
			if ( isset( $riode_sp_data_tab_settings['sp_type'] ) ) {
				$sp_type = $riode_sp_data_tab_settings['sp_type'];
			}
			if ( 'accordion' == $sp_type ) {
				$type = $sp_type;
			}

			return $type;
		}
	}

	add_filter( 'riode_single_product_data_tab_type', 'riode_get_tab_type' );

	woocommerce_output_product_data_tabs();

	remove_filter( 'riode_single_product_data_tab_type', 'riode_get_tab_type' );

	do_action( 'riode_single_product_builder_unset_product' );
}
?>
</div>
<?php
