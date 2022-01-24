<?php
/**
 * Countdown Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
wp_enqueue_script( 'jquery.countdown' );

$container_cls = '';

if ( isset( $atts['enable_grid'] ) && 'yes' == $atts['enable_grid'] ) {
	$container_cls .= ' grid-countdown';
}


$wrapper_attrs = array(
	'class' => 'riode-countdown-container ' . $shortcode_class . $style_class . $container_cls,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

if ( ! empty( $atts['date_format'] ) ) {
	$atts['date_format'] = explode( ',', $atts['date_format'] );
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// countdown Render
include RIODE_CORE_PATH . 'elementor/render/widget-countdown-render.php';
?>
</div>
<?php
// Frontend Editor
if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
	$selector = '.' . str_replace( ' ', '', $shortcode_class );
	?>
		<script>Riode.countdown('<?php echo riode_strip_script_tags( $selector ); ?> .countdown');</script>
	<?php
}
