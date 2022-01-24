<?php

add_action( 'customize_register', 'riode_refresh_footer' );

function riode_refresh_footer( $customize ) {
	$customize->selective_refresh->add_partial(
		'selective-footer',
		array(
			'selector'            => '.footer',
			'settings'            => array( 'ft_widgets', 'fm_widgets', 'fb_widgets' ),
			'container_inclusive' => true,
			'render_callback'     => function() {
				get_footer();
			},
		)
	);
}
