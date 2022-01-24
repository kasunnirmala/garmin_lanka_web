<?php
if ( ! function_exists( 'riode_get_wpb_design_controls' ) ) {
	function riode_get_wpb_design_controls() {
		return array(
			array(
				'type'       => 'css_editor',
				'heading'    => esc_html__( 'CSS box', 'riode-core' ),
				'param_name' => 'css',
				'group'      => esc_html__( 'Design Options', 'riode-core' ),
			),
		);
	}
}
