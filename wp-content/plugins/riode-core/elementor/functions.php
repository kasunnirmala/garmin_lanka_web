<?php

/**
 * Is optimize mode ?
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'riode_elementor_if_dom_optimization' ) ) :
	function riode_elementor_if_dom_optimization() {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return false;
		}
		if ( version_compare( ELEMENTOR_VERSION, '3.1.0', '>=' ) ) {
			return \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' );
		} elseif ( version_compare( ELEMENTOR_VERSION, '3.0', '>=' ) ) {
			return ( ! \Elementor\Plugin::instance()->get_legacy_mode( 'elementWrappers' ) );
		}
		return false;
	}
endif;

/*
 * unused function
function riode_elementor_loadmore_render_html( $query, $atts ) {

	if ( $query->max_num_pages > 1 ) {

		if ( 'button' === $atts['loadmore_type'] ) {

			echo '<button class="btn btn-load btn-primary">';
			echo empty( $atts['loadmore_label'] ) ? esc_html__( 'Load More', 'riode-core' ) : esc_html( $atts['loadmore_label'] );
			echo '</button>';

		} elseif ( 'page' === $atts['loadmore_type'] ) {
			echo riode_get_pagination( $query, 'pagination-load' );
		}
	}
} */

function riode_is_elementor_block( $id ) {
	$elements_data = get_post_meta( $id, '_elementor_data', true );
	if ( get_post_meta( $id, '_elementor_edit_mode', true ) && $elements_data ) {
		return true;
	}
	return false;
}