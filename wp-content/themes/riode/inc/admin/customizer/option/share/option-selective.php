<?php

add_action( 'customize_register', 'riode_refresh_share' );

function riode_refresh_share( $customize ) {
	$customize->selective_refresh->add_partial(
		'selective-post-share',
		array(
			'selector'            => '.post-details .social-icons, .product-single .summary .social-icons',
			'settings'            => array( 'share_type', 'share_icons', 'share_custom_color' ),
			'container_inclusive' => true,
			'render_callback'     => function() {
				if ( function_exists( 'riode_print_share' ) ) {
					riode_print_share();
				}
			},
		)
	);
}
