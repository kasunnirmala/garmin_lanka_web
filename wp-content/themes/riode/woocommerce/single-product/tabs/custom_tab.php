<?php
/**
 * Single Product Custom Tab
 */
defined( 'ABSPATH' ) || die;

if ( isset( $tab_name ) ) {
	if ( 'riode_custom_tab' == $tab_name && riode_get_option( 'product_cdt' ) ) {
		$tab_title   = get_post_meta( get_the_ID(), 'riode_custom_tab_title', true );
		$tab_content = get_post_meta( get_the_ID(), 'riode_custom_tab_content', true );
		echo apply_filters( 'riode_product_tab_title', ( $tab_title ? ( '<h2>' . esc_html( $tab_title ) . '</h2>' ) : '' ), $tab_name );
		echo '<div class="riode-custom-tab-content">';
		echo do_shortcode( riode_strip_script_tags( $tab_content ) );
		echo '</div>';
	} elseif ( 'riode_custom_tab2' == $tab_name && riode_get_option( 'product_cdt' ) ) {
		$tab_title   = get_post_meta( get_the_ID(), 'riode_custom_tab_title2', true );
		$tab_content = get_post_meta( get_the_ID(), 'riode_custom_tab_content2', true );
		echo apply_filters( 'riode_product_tab_title2', ( $tab_title ? ( '<h2>' . esc_html( $tab_title ) . '</h2>' ) : '' ), $tab_name );
		echo '<div class="riode-custom-tab-content">';
		echo do_shortcode( riode_strip_script_tags( $tab_content ) );
		echo '</div>';
	} elseif ( 'riode_pa_block_' == substr( $tab_name, 0, 15 ) && ! empty( $tab_data['block_id'] ) ) {
		riode_print_template( absint( $tab_data['block_id'] ) );
	} elseif ( 'riode_product_tab' == $tab_name ) {
		riode_print_template( absint( riode_get_option( 'single_product_tab_block' ) ) );
	}
}
