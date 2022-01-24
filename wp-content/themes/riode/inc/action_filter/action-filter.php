<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Theme Action, Filters
 */

add_action( 'wp', 'riode_set_layout' );
add_filter( 'body_class', 'riode_add_body_class' );
add_filter( 'riode_main_class', 'riode_add_main_class' );

// Breadcrumb and blocks
add_action( 'riode_before_content', 'riode_func_add_block' );
add_action( 'riode_before_inner_content', 'riode_func_add_block' );
add_action( 'riode_after_inner_content', 'riode_func_add_block' );
add_action( 'riode_after_content', 'riode_func_add_block' );

// Page layout
add_action( 'riode_print_before_page_layout', 'riode_print_layout_before' );
add_action( 'riode_print_after_page_layout', 'riode_print_layout_after' );

// Comment
add_filter( 'riode_filter_comment_form_args', 'riode_comment_form_args' );
add_action( 'comment_form_before_fields', 'riode_comment_form_before_fields' );
add_action( 'comment_form_after_fields', 'riode_comment_form_after_fields' );
add_filter( 'pre_get_avatar_data', 'riode_set_avatar_size' );

// Cookie
add_action( 'init', 'riode_set_cookies' );

// Contact Form
add_action( 'wpcf7_init', 'riode_wpcf7_add_form_tag_submit', 20, 0 );
add_filter( 'wpcf7_form_novalidate', 'riode_wpcf7_form_novalidate' );


// Widget Compatabilities
add_filter( 'widget_nav_menu_args', 'riode_widget_nav_menu_args', 10, 4 );

/**
 * Riode Ajax Actions
 */
add_action( 'wp_ajax_riode_loadmore', 'riode_loadmore' );
add_action( 'wp_ajax_nopriv_riode_loadmore', 'riode_loadmore' );
add_action( 'wp_ajax_riode_account_form', 'riode_ajax_account_form' );
add_action( 'wp_ajax_nopriv_riode_account_form', 'riode_ajax_account_form' );
add_action( 'wp_ajax_riode_account_signin_validate', 'riode_account_signin_validate' );
add_action( 'wp_ajax_nopriv_riode_account_signin_validate', 'riode_account_signin_validate' );
add_action( 'wp_ajax_riode_account_signup_validate', 'riode_account_signup_validate' );
add_action( 'wp_ajax_nopriv_riode_account_signup_validate', 'riode_account_signup_validate' );
add_action( 'wp_ajax_riode_load_mobile_menu', 'riode_load_mobile_menu' );
add_action( 'wp_ajax_nopriv_riode_load_mobile_menu', 'riode_load_mobile_menu' );
add_action( 'wp_ajax_riode_print_popup', 'riode_ajax_print_popup' );
add_action( 'wp_ajax_nopriv_riode_print_popup', 'riode_ajax_print_popup' );
