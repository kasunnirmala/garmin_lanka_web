<?php
/**
 * Tab Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-tab-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php

$extra_class = ' tab element-tab';
$settings    = array(
	'tab_type'     => isset( $atts['tab_type'] ) ? $atts['tab_type'] : '',
	'tab_navs_pos' => isset( $atts['tab_navs_pos'] ) ? $atts['tab_navs_pos'] : 'left',
	'tab_h_type'   => isset( $atts['tab_h_type'] ) ? $atts['tab_h_type'] : '',
);

if ( 'vertical' == $settings['tab_type'] ) {
	$extra_class .= ' tab-vertical';
}

if ( $settings['tab_h_type'] ) {
	$extra_class .= ' tab-' . $settings['tab_h_type'];
}

switch ( $settings['tab_navs_pos'] ) { // nav position
	case 'center':
		$extra_class .= ' tab-nav-center';
		break;
	case 'right':
		$extra_class .= ' tab-nav-right';
}

global $riode_wpb_tab;
$riode_wpb_tab = array();

$content = do_shortcode( $content );

echo '<div class="' . $extra_class . '">';
echo '<ul class="nav nav-tabs">';

if ( ! vc_is_inline() ) {
	if ( ! empty( $riode_wpb_tab ) ) {
		for ( $i = 0; $i < count( $riode_wpb_tab ); $i ++ ) {
			echo '<li class="nav-item ' . ( $riode_wpb_tab[ $i ]['icon'] ? 'nav-icon-' . $riode_wpb_tab[ $i ]['icon_pos'] : '' ) . '">';

			$html = '';
			if ( $riode_wpb_tab[ $i ]['icon'] && ( 'left' == $riode_wpb_tab[ $i ]['icon_pos'] || 'up' == $riode_wpb_tab[ $i ]['icon_pos'] ) ) {
				$html .= '<i class="' . $riode_wpb_tab[ $i ]['icon'] . '"></i>';
			}
			$html .= riode_strip_script_tags( $riode_wpb_tab[ $i ]['title'] );
			if ( $riode_wpb_tab[ $i ]['icon'] && ( 'right' == $riode_wpb_tab[ $i ]['icon_pos'] || 'down' == $riode_wpb_tab[ $i ]['icon_pos'] ) ) {
				$html .= '<i class="' . $riode_wpb_tab[ $i ]['icon'] . '"></i>';
			}

			echo '<a class="nav-link' . ( 0 == $i ? ' active' : '' ) . '" href="#" data-pane-selector="' . $riode_wpb_tab[ $i ]['selector'] . '">' . $html . '</a>';
			echo '</li>';
		}
	}
}

echo '</ul>';
echo '<div class="tab-content">';
echo riode_strip_script_tags( $content );
echo '</div>';
echo '</div>';
?>
</div>
<?php
