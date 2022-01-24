<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode_Admin_Meta_Boxes
 *
 */

class Riode_Admin_Meta_Boxes {

	/**
	 * Constructor
	 */
	public function __construct() {
		include_once RIODE_CORE_PATH . '/meta-box/custom-css-js.php';
		include_once RIODE_CORE_PATH . '/meta-box/post-meta.php';

		if ( class_exists( 'WooCommerce' ) ) {
			include_once RIODE_CORE_PATH . '/meta-box/product-meta.php';
			include_once RIODE_CORE_PATH . '/meta-box/product-cat-meta.php';
			include_once RIODE_CORE_PATH . '/meta-box/product-attr-meta.php';
		}
	}
}

if ( is_admin() ) {
	new Riode_Admin_Meta_Boxes;
}
