<?php
/**
 * Single Prodcut Counter Render
 *
 * @since 1.1.0
 */

wp_enqueue_script( 'jquery-count-to' );

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'starting_number'         => 0,
			'ending_number'           => 'sale',
			'adding_number'           => 0,
			'prefix'                  => '',
			'suffix'                  => '',
			'duration'                => 2000,
			'thousand_separator'      => 'yes',
			'thousand_separator_char' => '',
			'title'                   => 'Sale Products',
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-sp-counter-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

if ( false == is_int( $starting_number ) || false == is_int( $adding_number ) || false == is_int( $duration ) ) {
	$starting_number = intval( $starting_number );
	$adding_number   = intval( $adding_number );
	$duration        = intval( $duration );
}
?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {

	global $product;

	if ( 'sale' == $ending_number ) {
		$count_to = $product->get_total_sales();
	} else {
		$count_to = $product->get_stock_quantity();
	}

	if ( $adding_number ) {
		$count_to += $adding_number;
	}

	$counter_attrs = array(
		'class'      => 'wpb-sp-counter-number count-to',
		'data-speed' => $duration,
		'data-to'    => $count_to,
		'data-from'  => $starting_number,
	);

	if ( ! empty( $thousand_separator ) ) {
		$delimiter                       = empty( $thousand_separator_char ) ? ',' : $thousand_separator_char;
		$counter_attrs['data-delimiter'] = $thousand_separator_char;
	}

	$counter_attrs_html = '';
	foreach ( $counter_attrs as $key => $value ) {
		$counter_attrs_html .= $key . '="' . $value . '" ';
	}
	?>
	<div class = "wpb-sp-counter-number-wrapper counter">
		<span class="wpb-sp-counter-number-prefix counter-prefix"><?php echo riode_escaped( $prefix ); ?></span>
		<span <?php echo riode_escaped( $counter_attrs_html ); ?>><?php echo riode_escaped( $starting_number ); ?></span>
		<span class="wpb-sp-counter-number-suffix counter-suffix"><?php echo riode_escaped( $suffix ); ?></span>
	</div>
	<?php if ( $title ) : ?>
		<div class="wpb-sp-counter-title"><?php echo riode_escaped( $title ); ?></div>
	<?php endif; ?>
	<?php
	do_action( 'riode_single_product_builder_unset_product' );
}
?>
</div>
<?php
