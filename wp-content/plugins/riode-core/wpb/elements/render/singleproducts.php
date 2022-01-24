<?php
/**
 * Single Products Shortcode Render
 *
 * @since 1.1.0
 */

$wrapper_attrs = array(
	'class' => 'riode-wpb-singleproducts-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

// Preprocess
$keys = array(
	'count',
);

foreach ( $keys as $key ) {
	if ( ! empty( $atts[ $key ] ) ) {
		$atts[ $key ] = array(
			'size' => (int) $atts[ $key ],
		);
	}
}

$atts['page_builder'] = 'wpb';

// Columns
if ( ! empty( $atts['sp_col_cnt'] ) ) {

	$columns                   = json_decode( str_replace( '``', '"', $atts['sp_col_cnt'] ), true );
	$atts['sp_col_cnt_xl']     = $columns['xl'];
	$atts['sp_col_cnt']        = empty( $columns['lg'] ) ? $columns['xl'] : $columns['lg'];
	$atts['sp_col_cnt_tablet'] = $columns['md'];
	$atts['sp_col_cnt_mobile'] = $columns['sm'];
	$atts['sp_col_cnt_min']    = $columns['xs'];
}

if ( 'singleproducts' == $shortcode ) {
	echo '<div ' . $wrapper_attr_html . '>';
} else {
	global $riode_products_single_items;
	if ( ! empty( $riode_products_single_items ) ) {
		$riode_products_single_items[ count( $riode_products_single_items ) - 1 ]['sp_class'] = $wrapper_attrs['class'];
	}
}

// Categories Render
include RIODE_CORE_PATH . 'elementor/render/widget-single-product-render.php';

if ( 'singleproducts' == $shortcode ) {
	echo '</div>';
}

// Frontend Editor
if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
	$selector = '.' . str_replace( ' ', '', $shortcode_class );
	if ( isset( $atts['count']['size'] ) && 1 < $atts['count']['size'] ) {
		?>
			<script>Riode.slider('<?php echo riode_strip_script_tags( $selector ); ?> .owl-carousel');</script>
		<?php
	}
}
