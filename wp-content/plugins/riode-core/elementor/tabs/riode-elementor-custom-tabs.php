<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Riode_Elementor_Editor_Custom_Tabs
 *
 * register new custom tabs to elementor editor
 *
 * @since 1.0.1
 */

use Elementor\Controls_Manager;

class Riode_Elementor_Editor_Custom_Tabs {
	const TAB_CUSTOM = 'riode_custom_tab';

	private $custom_tabs;

	public function __construct() {
		$this->init_custom_tabs();

		$this->register_custom_tabs();
	}

	private function init_custom_tabs() {
		$this->custom_tabs = array();

		$this->custom_tabs[ $this::TAB_CUSTOM ] = esc_html__( 'Riode Options', 'riode-core' );
	}

	public function register_custom_tabs() {
		foreach ( $this->custom_tabs as $key => $value ) {
			Elementor\Controls_Manager::add_tab( $key, $value );
		}
	}
}

new Riode_Elementor_Editor_Custom_Tabs;
