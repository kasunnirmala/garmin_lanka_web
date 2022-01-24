<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-search-form.php
 * Please refer to searchform.php file, thank you.
 */

$device_class = '';
if ( isset( $search_form->device ) && $search_form->device ) {
	$device_class = ' d-show-' . $search_form->device;
}

get_search_form(
	array(
		'aria_label' => array(
			'where'            => 'header',
			'device_class'     => $device_class,
			'search_post_type' => riode_get_option( 'search_post_type' ),
		),
	)
);
