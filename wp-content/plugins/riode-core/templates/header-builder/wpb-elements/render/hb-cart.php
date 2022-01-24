<?php
/**
 * Header Cart Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-hb-cart-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

$args = array(
	'cart_type'       => isset( $atts['type'] ) ? $atts['type'] : 'inline',
	'icon_type'       => isset( $atts['icon_type'] ) ? $atts['icon_type'] : 'badge',
	'cart_off_canvas' => isset( $atts['cart_off_canvas'] ) ? $atts['cart_off_canvas'] : 'yes',
	'label_type'      => isset( $atts['label_type'] ) ? $atts['label_type'] : 'block',
	'title'           => isset( $atts['show_label'] ) ? $atts['show_label'] : 'yes',
	'label'           => isset( $atts['label'] ) ? $atts['label'] : esc_html__( 'Shopping Cart', 'riode-core' ),
	'price'           => isset( $atts['show_price'] ) ? $atts['show_price'] : 'yes',
	'delimiter'       => isset( $atts['delimiter'] ) ? $atts['delimiter'] : '',
	'pfx'             => isset( $atts['count_pfx'] ) ? $atts['count_pfx'] : '(',
	'sfx'             => isset( $atts['count_sfx'] ) ? $atts['count_sfx'] : 'items )',
	'icon'            => isset( $atts['icon'] ) && $atts['icon'] ? $atts['icon'] : 'd-icon-bag',
);

if ( '/' == $args['icon_type'] ) {
	$args['icon_type'] = '';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// HB Cart Render
if ( defined( 'RIODE_VERSION' ) ) {
	riode_get_template_part( RIODE_PART . '/header/elements/element-cart', null, $args );
}
?>
</div>
<?php
