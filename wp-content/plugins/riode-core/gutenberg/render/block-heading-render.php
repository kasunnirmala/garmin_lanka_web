<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'className'             => '',
			'id'                    => '',
			'content_align'         => 'left',
			'text'                  => 'This is Riode Heading',
			'tag'                   => 'h2',
			'family'                => '',
			'size'                  => 20,
			'weight'                => 700,
			'ls'                    => '-0.01em',
			'lh'                    => '1',
			'mt'                    => 0,
			'mr'                    => 0,
			'mb'                    => 0,
			'ml'                    => 0,
			'transform'             => 'none',
			'col'                   => '#333',
			'decoration'            => '',
			'decor_space'           => 30,
			'hide_active_underline' => false,
			'div_ht'                => 2,
			'div_active_ht'         => 2,
			'div_col'               => '#f4f4f4',
			'div_active_col'        => '#2b579a',
		),
		$atts
	)
);

$aclass       = array( 'title-wrapper' );
$custom_style = array();
$aclass[]     = $decoration;
$aclass[]     = $content_align;

$heading_css = array();

$heading_css['text-align'] = $content_align;
if ( $family ) {
	$heading_css['font-family'] = $family . ', ' . ( function_exists( 'riode_get_option' ) ? riode_get_option( 'typo_default' )['font-family'] . ', ' : '' ) . 'sans-serif';
}
if ( '' == $size ) {
	$size = 20;
}
$heading_css['font-size'] = $size;
if ( ! preg_replace( '/[0-9.]/', '', $heading_css['font-size'] ) ) {
	$heading_css['font-size'] .= 'px';
}
$heading_css['font-weight']    = $weight;
$heading_css['line-height']    = $lh;
$heading_css['text-transform'] = $transform;
$heading_css['color']          = $col;
$heading_css['letter-spacing'] = $ls . ( false !== strpos( $ls, 'em' ) || false !== strpos( $ls, 'rem' ) || false !== strpos( $ls, 'px' ) ? '' : 'px' );

if ( 'left' == $content_align ) {
	$heading_css['justify-content'] = 'flex-start';
} elseif ( 'right' == $content_align ) {
	$heading_css['justify-content'] = 'flex-end';
} else {
	$heading_css['justify-content'] = 'center';
}
echo '<div id="riode_gtnbg_heading_' . $id . '" class="' . implode( ' ', $aclass ) . ' ' . esc_attr( $className ) . '">';
echo '<style>';

echo '#riode_gtnbg_heading_' . $id . '{
		margin: ' . $mt . 'px ' . $mr . 'px ' . $mb . 'px ' . $ml . 'px;
	}';

echo '#riode_gtnbg_heading_' . $id . ' .title {';
foreach ( $heading_css as $key => $value ) {
	echo esc_attr( $key . ':' . $value . ';' );
}
echo '}';

if ( 'title-cross' === $decoration ) {
	$custom_style[] = '#riode_gtnbg_heading_' . $id . ' .title::before { margin-right:' . $decor_space . 'px; height: ' . $div_ht . 'px; background: ' . ( $div_col ? $div_col : '#f4f4f4' ) . '; }';
	$custom_style[] = '#riode_gtnbg_heading_' . $id . ' .title::after { margin-left:' . $decor_space . 'px; height: ' . $div_ht . 'px; background: ' . ( $div_col ? $div_col : '#f4f4f4' ) . '; }';
} elseif ( 'title-underline' === $decoration ) {
	$custom_style[] = '#riode_gtnbg_heading_' . $id . ' .title-underline::after { height: ' . $div_ht . 'px; background: ' . ( $div_col ? $div_col : '#f4f4f4' ) . '; }';
	if ( $hide_active_underline ) {
		$custom_style[] = '#riode_gtnbg_heading_' . $id . ' .title::after { content: none; }';
	} else {
		$custom_style[] = '#riode_gtnbg_heading_' . $id . ' .title::after { height: ' . $div_active_ht . 'px; background: ' . ( $div_active_col ? $div_active_col : '#2b579a' ) . '; }';
	}
}
echo implode( ' ', $custom_style );

echo '</style>';


echo '<' . $tag . ' class="title">';
echo riode_strip_script_tags( $text );
echo '</' . $tag . ' >';
echo '</div>';
