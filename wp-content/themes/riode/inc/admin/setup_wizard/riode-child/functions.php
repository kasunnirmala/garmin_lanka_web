<?php

add_action( 'wp_enqueue_scripts', 'riode_child_css', 1001 );

// Load CSS
function riode_child_css() {
	// riode child theme styles
	wp_deregister_style( 'styles-child' );
	wp_register_style( 'styles-child', esc_url( get_theme_file_uri() ) . '/style.css' );
	wp_enqueue_style( 'styles-child' );
}
