<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-html.php
 */

foreach ( $args as $key => $value ) {
	$str = '';
	if ( is_string( $value ) ) {
		$str = $value;
	} elseif ( is_object( $value ) && isset( $value->html ) ) {
		$str = $value->html;
	}
	echo '<div class="custom-html' . ( is_object( $value ) && isset( $value->el_class ) && $value->el_class ? ' ' . esc_attr( $value->el_class ) : '' ) . '">';
		echo do_shortcode( $str );
	echo '</div>';
}
