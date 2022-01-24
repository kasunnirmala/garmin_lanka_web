<?php
/**
 * Accordion Item Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-accordion-item-container card ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

$settings = array(
	'card_title' => isset( $atts['card_title'] ) ? $atts['card_title'] : 'Card Item',
	'card_icon'  => isset( $atts['card_icon'] ) ? $atts['card_icon'] : '',
);

global $riode_wpb_accordion;
?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<div class="card-header">
	<a href="#" class="<?php echo isset( $riode_wpb_accordion ) && 0 == $riode_wpb_accordion['index'] ? 'collapse' : 'expand'; ?>">
	<?php
		if ( $settings['card_icon'] ) {
			echo '<i class="' . esc_attr( $settings['card_icon'] ) . '"></i>';
		}
		echo '<span class="title">' . esc_html( $settings['card_title'] ) . '</span>';
		if ( isset( $riode_wpb_accordion ) ) {
			if ( $riode_wpb_accordion['accordion_icon'] ) {
				echo '<span class="toggle-icon opened"><i class="' . esc_attr( $riode_wpb_accordion['accordion_active_icon'] ) . '"></i></span>';
			}
			if ( $riode_wpb_accordion['accordion_active_icon'] ) {
				echo '<span class="toggle-icon closed"><i class="' . esc_attr( $riode_wpb_accordion['accordion_icon'] ) . '"></i></span>';
			}
		}
	?>
	</a>
</div>
<div class="card-body <?php echo isset( $riode_wpb_accordion ) && 0 == $riode_wpb_accordion['index'] ? 'expanded' : 'collapsed'; ?>">
<?php
echo do_shortcode( $content );
?>
</div>
</div>
<?php
if ( isset( $riode_wpb_accordion ) ) {
	$riode_wpb_accordion['index'] ++;
}
