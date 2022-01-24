<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * walker-nav-menu-edit.php
 * Class Riode_Walker_Nav_Menu_Edit
 */

class Riode_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {

	/**
	 * Start the element output.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$default = '';
		$substr  = '<p class="field-link-target description">';

		ob_start();
		do_action( 'riode_add_custom_fields', $item->ID, $item, $depth, $args );
		$custom = ob_get_clean();

		parent::start_el( $default, $item, $depth, $args, $id );

		$output .= str_replace( $substr, $custom . $substr, $default );
	}
}
