<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Riode_Common_Elementor_Widget
 *
 * Enhanced elementor base common widget that gives you all the advanced options of the basic.
 * Added Riode custom CSS and JS control
 *
 * @since 1.0.1
 * @since 1.2.0 added floating effects
 * @since 1.4.0 added duplex, ribbon functions
 */

class Riode_Common_Elementor_Widget extends \Elementor\Widget_Common {
	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data, $args );
		add_action( 'elementor/frontend/widget/before_render', array( $this, 'widget_before_render' ) );
		add_action( 'elementor/widget/before_render_content', array( $this, 'widget_before_render_content' ) );
	}

	protected function register_controls() {
		parent::register_controls();

		do_action( 'riode_elementor_add_common_options', $this );
	}

	public function widget_before_render( $widget ) {
		$settings = $widget->get_settings_for_display();

		$widget->add_render_attribute(
			'_wrapper',
			apply_filters( 'riode_elementor_common_wrapper_attributes', array(), $settings, $widget->get_ID() )
		);
	}

	/**
	 * prints other widget html before render
	 *
	 * @since 1.4.0
	 */
	public function widget_before_render_content( $widget ) {
		$data     = $widget->get_data();
		$settings = $data['settings'];

		do_action( 'riode_elementor_common_before_render_content', $settings, $widget->get_ID() );
	}
}
