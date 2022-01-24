<?php
/**
 * Riode Counter Render
 *
 * @since 1.1.0
 */

wp_enqueue_script( 'jquery-count-to' );

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'starting_number'         => 0,
			'res_number'              => 50,
			'prefix'                  => '',
			'suffix'                  => '',
			'duration'                => 0,
			'thousand_separator'      => 'yes',
			'thousand_separator_char' => '',
			'title'                   => esc_html__( 'Add Your Text Here', 'riode-core' ),
			'subtitle'                => esc_html__( 'Add Your Description Text Here', 'riode-core' ),
		),
		$atts
	)
);

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-counter-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

if ( false == is_int( $starting_number ) || false == is_int( $res_number ) || false == is_int( $duration ) ) {
	$starting_number = intval( $starting_number );
	$res_number      = intval( $res_number );
	$duration        = intval( $duration );
}
?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php


	$counter_attrs = array(
		'class'      => 'wpb-riode-counter-number count-to',
		'data-speed' => $duration,
		'data-to'    => $res_number,
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
		<div class = "wpb-riode-counter-number-wrapper counter">
			<span <?php echo riode_escaped( $counter_attrs_html ); ?>><?php echo riode_escaped( $starting_number ); ?></span>
		</div>
		<?php if ( $title ) : ?>
			<h4 class="wpb-riode-counter-title"><?php echo riode_escaped( $title ); ?></h4>
		<?php endif; ?>
		<?php if ( $subtitle ) : ?>
			<p class="wpb-riode-counter-subtitle"><?php echo riode_escaped( $subtitle ); ?></p>
		<?php endif; ?>
	<?php
	do_action( 'riode_single_product_builder_unset_product' );

	?>
</div>
<?php
