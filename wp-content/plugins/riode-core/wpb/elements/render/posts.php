<?php
/**
 * Post Shortcode Render
 *
 * @since 1.1.0
 */
$wrapper_attrs = array(
	'class' => 'riode-wpb-post-container ' . $shortcode_class . $style_class . ( ! empty( $atts['el_class'] ) ? ( ' ' . $atts['el_class'] ) : '' ),
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

if ( ! isset( $atts['loadmore_button_size'] ) || '/' == $atts['loadmore_button_size'] ) {
	$atts['loadmore_button_size'] = '';
}
if ( ! isset( $atts['loadmore_button_border'] ) || '/' == $atts['loadmore_button_border'] ) {
	$atts['loadmore_button_border'] = '';
}
if ( ! isset( $atts['loadmore_button_skin'] ) || '/' == $atts['loadmore_button_skin'] ) {
	$atts['loadmore_button_skin'] = '';
}

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

// Preprocess
$keys = array(
	'creative_height',
	'creative_height_ratio',
);

$settings = shortcode_atts(
	array(
		'creative_height'       => '{``xl``:``900``,``unit``:``px``}',
		'creative_height_ratio' => '{``xl``:``75``,``unit``:``%``}',
	),
	$atts
);
foreach ( $keys as $key ) {
	if ( ! empty( $settings[ $key ] ) ) {
		$value = str_replace( '``', '"', $settings[ $key ] );

		$value = json_decode( $value, true );
		if ( ! empty( $value['xl'] ) ) {
			$atts[ $key ] = array(
				'size' => (int) $value['xl'],
			);
		}
	}
}

if ( isset( $atts['excerpt_limit'] ) ) {
	$atts['excerpt_limit'] = array(
		'size' => (int) $atts['excerpt_limit'],
	);
}

if ( isset( $atts['count'] ) ) {
	$atts['count'] = array(
		'size' => (int) $atts['count'],
	);
}

if ( isset( $atts['icon'] ) ) {
	$atts['icon'] = array(
		'value' => $atts['icon'],
	);
}

if ( isset( $atts['loadmore_icon'] ) ) {
	$atts['loadmore_icon'] = array(
		'value' => $atts['loadmore_icon'],
	);
}

if ( ! isset( $atts['show_label'] ) ) {
	$atts['show_label'] = 'yes';
}

if ( ! isset( $atts['icon_hover_effect'] ) ) {
	$atts['icon_hover_effect'] = '';
}

$atts['page_builder'] = 'wpb';

// slider
$atts = array_merge(
	$atts,
	array(
		'col_sp'                => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
		'slider_vertical_align' => isset( $atts['slider_vertical_align'] ) ? $atts['slider_vertical_align'] : '',
		'row_cnt'               => isset( $atts['row_cnt'] ) ? $atts['row_cnt'] : 1,
		'fullheight'            => isset( $atts['fullheight'] ) ? $atts['fullheight'] : '',
		'autoplay'              => isset( $atts['autoplay'] ) ? $atts['autoplay'] : '',
		'autoplay_timeout'      => isset( $atts['autoplay_timeout'] ) ?
		$atts['autoplay_timeout'] : 5000,
		'loop'                  => isset( $atts['loop'] ) ? $atts['loop'] : '',
		'pause_onhover'         => isset( $atts['pause_onhover'] ) ? $atts['pause_onhover'] : '',
		'autoheight'            => isset( $atts['autoheight'] ) ? $atts['autoheight'] : '',
		'center_mode'           => isset( $atts['center_mode'] ) ? $atts['center_mode'] : '',
		'prevent_drag'          => isset( $atts['prevent_drag'] ) ? $atts['prevent_drag'] : '',
		'animation_in'          => isset( $atts['animation_in'] ) ? $atts['animation_in'] : '',
		'animation_out'         => isset( $atts['animation_out'] ) ? $atts['animation_out'] : '',
		'nav_hide'              => isset( $atts['nav_hide'] ) ? $atts['nav_hide'] : '',
		'nav_type'              => isset( $atts['nav_type'] ) ? $atts['nav_type'] : '',
		'vertical_dots'         => isset( $atts['vertical_dots'] ) ? $atts['vertical_dots'] : '',
		'dots_type'             => isset( $atts['dots_type'] ) ? $atts['dots_type'] : '',
		'dots_pos'              => isset( $atts['dots_pos'] ) ? $atts['dots_pos'] : '',
	)
);
// Responsive columns
$atts = array_merge( $atts, riode_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $atts['col_cnt'] ) {
	$atts['col_cnt'] = $atts['col_cnt_xl'];
}
// Responsive nav visibility
$atts = array_merge( $atts, riode_wpb_convert_responsive_values( 'show_nav', $atts ) );
if ( isset( $atts['show_nav_xl'] ) && ! isset( $atts['show_nav'] ) ) {
	$atts['show_nav'] = $atts['show_nav_xl'];
}
// Responsive dots visibility
$atts = array_merge( $atts, riode_wpb_convert_responsive_values( 'show_dots', $atts ) );
if ( isset( $atts['show_dots_xl'] ) && ! isset( $atts['show_dots'] ) ) {
	$atts['show_dots'] = $atts['show_dots_xl'];
}

if ( ! isset( $atts['follow_theme_option'] ) ) {
	$atts['follow_theme_option'] = 'yes';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// Post Render
include RIODE_CORE_PATH . 'elementor/render/widget-posts-render.php';
?>
</div>
<?php
// Frontend Editor
if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
	$selector = '.' . str_replace( ' ', '', $shortcode_class );
	if ( isset( $atts['layout_type'] ) && 'creative' == $atts['layout_type'] ) {
		?>
			<script>Riode.isotopes('<?php echo riode_strip_script_tags( $selector ); ?> .grid');</script>
		<?php
	}
	if ( isset( $atts['layout_type'] ) && 'slider' == $atts['layout_type'] ) {
		?>
			<script>Riode.slider('<?php echo riode_strip_script_tags( $selector ); ?> .owl-carousel');</script>
		<?php
	}
}
