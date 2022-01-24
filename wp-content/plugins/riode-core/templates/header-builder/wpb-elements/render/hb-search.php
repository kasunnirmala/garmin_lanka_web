<?php
/**
 * Header Search Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-hb-search-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

$args = array(
	'aria_label' => array(
		'type'             => isset( $atts['type'] ) ? $atts['type'] : 'hs-toggle',
		'fullscreen_type'  => isset( $atts['fullscreen_type'] ) ? $atts['fullscreen_type'] : 'fs-default',
		'fullscreen_style' => isset( $atts['fullscreen_style'] ) ? $atts['fullscreen_style'] : 'light',
		'where'            => 'header',
		'search_post_type' => isset( $atts['search_type'] ) ? $atts['search_type'] : '',
		'search_label'     => isset( $atts['label'] ) ? $atts['label'] : '',
		'search_category'  => isset( $atts['category'] ) ? 'yes' == $atts['category'] : true,
		'border_type'      => isset( $atts['border_type'] ) ? $atts['border_type'] : 'rect',
		'placeholder'      => isset( $atts['placeholder'] ) && $atts['placeholder'] ? $atts['placeholder'] : 'Search your keyword...',
		'search_right'     => false,
		'icon'             => isset( $atts['icon'] ) && $atts['icon'] ? $atts['icon'] : 'd-icon-search',
	),
);

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// HB Search Render
get_search_form( $args );
?>
</div>
<?php
