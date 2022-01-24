<?php

add_action( 'customize_register', 'riode_refresh_ptb' );

function riode_refresh_ptb( $customize ) {
	$customize->selective_refresh->add_partial(
		'selective-breadcrumb',
		array(
			'selector'            => '.breadcrumb',
			'settings'            => array( 'ptb_home_icon', 'ptb_delimiter', 'ptb_delimiter_use_icon', 'ptb_delimiter_icon' ),
			'container_inclusive' => true,
			'render_callback'     => function() {
				do_action( 'riode_print_breadcrumb' );
			},
		)
	);
}
