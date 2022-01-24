<?php
add_action( 'riode_demo_imported', 'riode_update_elementor_settings', 99 );
add_action( 'riode_demo_imported', 'riode_update_elementor_preferences', 99 );
add_action( 'customize_save_after', 'riode_update_elementor_settings', 99 );
add_action( 'customize_save_after', 'riode_update_elementor_preferences', 99 );
add_action( 'register_new_user', 'riode_update_elementor_preferences', 99 );

if ( (int) get_transient( 'riode_after_setup_e' ) ) {
	add_action( 'wp', 'riode_update_elementor_settings' );
}

/**
 * riode_update_elementor_settings
 *
 * update default elementor active kit options
 *
 * @since 1.0
 */
function riode_update_elementor_settings() {
	$default_kit = get_option( 'elementor_active_kit', 0 );

	if ( $default_kit ) {
		$general_settings = get_post_meta( $default_kit, '_elementor_page_settings', true );
		$changed          = false;

		if ( empty( $general_settings ) ) {
			$general_settings = array();
		}

		// container width
		if ( empty( $general_settings['container_width'] ) || ! isset( $general_settings['container_width']['size'] ) || $general_settings['container_width']['size'] != riode_get_option( 'container' ) ) {
			$general_settings['container_width'] = array(
				'size'  => riode_get_option( 'container' ),
				'unit'  => 'px',
				'sizes' => array(),
			);
			$changed                             = true;
		}

		// space between widgets
		if ( empty( $general_settings['space_between_widgets'] ) || ! isset( $general_settings['space_between_widgets']['size'] ) || $general_settings['space_between_widgets']['size'] != 0 ) {
			$general_settings['space_between_widgets'] = array(
				'size'  => 0,
				'unit'  => 'px',
				'sizes' => array(),
			);
			$changed                                   = true;
		}

		// responsive breadkpoint
		if ( empty( $general_settings['viewport_tablet'] ) || 992 != $general_settings['viewport_tablet'] ) {
			$general_settings['viewport_tablet'] = 992;
			$changed                         = true;
		}
		if ( empty( $general_settings['viewport_mobile'] ) || 768 != $general_settings['viewport_mobile'] ) {
			$general_settings['viewport_mobile'] = 768;
			$changed                         = true;
		}

		// system colors
		if ( empty( $general_settings['system_colors'] ) ) {
			$general_settings['system_colors'] = array(
				array(
					'_id'   => 'primary',
					'title' => esc_html( 'Primary', 'elementor' ),
					'color' => riode_get_option( 'primary_color' ),
				),
				array(
					'_id'   => 'secondary',
					'title' => esc_html( 'Secondary', 'elementor' ),
					'color' => riode_get_option( 'secondary_color' ),
				),
				array(
					'_id'   => 'text',
					'title' => esc_html( 'Text', 'elementor' ),
					'color' => riode_get_option( 'typo_default' )['color'],
				),
				array(
					'_id'   => 'accent',
					'title' => esc_html( 'Accent', 'elementor' ),
					'color' => riode_get_option( 'success_color' ),
				),
			);

			$changed = true;
		}

		// system fonts
		if ( empty( $general_settings['system_typography'] ) ) {
			$general_settings['system_typography'] = array(
				array(
					'_id'                    => 'primary',
					'title'                  => esc_html( 'Primary', 'elementor' ),
					'typography_typography'  => 'custom',
					'typography_font_family' => riode_get_option( 'typo_default' )['font-family'],
					'typography_font_weight' => 'default',
				),
				array(
					'_id'                    => 'secondary',
					'title'                  => esc_html( 'Secondary', 'elementor' ),
					'typography_typography'  => 'custom',
					'typography_font_family' => 'default',
					'typography_font_weight' => 'default',
				),
				array(
					'_id'                    => 'text',
					'title'                  => esc_html( 'Text', 'elementor' ),
					'typography_typography'  => 'custom',
					'typography_font_family' => 'default',
					'typography_font_weight' => 'default',
				),
				array(
					'_id'                    => 'accent',
					'title'                  => esc_html( 'Accent', 'elementor' ),
					'typography_typography'  => 'custom',
					'typography_font_family' => 'default',
					'typography_font_weight' => 'default',
				),
			);

			$changed = true;
		}

		// disable elementor image lightbox by default
		if ( empty( $general_settings['global_image_lightbox'] ) ) {
			$general_settings['global_image_lightbox'] = '';
		}

		if ( $changed ) {
			update_post_meta( $default_kit, '_elementor_page_settings', $general_settings );
			update_option( '_elementor_settings_update_time', time() );

			try {
				if ( ! empty(\Elementor\Plugin::$instance->files_manager) ) {
					\Elementor\Plugin::$instance->files_manager->clear_cache();
				}
			} catch ( Exception $e ) {
			}
		}
	}

	if ( false === get_option( 'elementor_disable_color_schemes', false ) ) {
		update_option( 'elementor_disable_color_schemes', 'yes' );
	}
	if ( false === get_option( 'elementor_disable_typography_schemes', false ) ) {
		update_option( 'elementor_disable_typography_schemes', 'yes' );
	}
	if ( false === get_option( 'elementor_experiment-e_dom_optimization', false ) ) {
		update_option( 'elementor_experiment-e_dom_optimization', 'active' );
	}

	$count = get_transient( 'riode_after_setup_e' );
	if ( $count ) {

		// Create elementor default kit
		$kit = Elementor\Plugin::$instance->kits_manager->get_active_kit();
		if ( ! $kit->get_id() ) {
			$created_default_kit = Elementor\Plugin::$instance->kits_manager->create_default();
			if ( $created_default_kit ) {
				update_option( Elementor\Core\Kits\Manager::OPTION_ACTIVE, $created_default_kit );
			}
		}

		set_transient( 'riode_after_setup_e', (int) $count - 1 );
	} else {
		delete_transient( 'riode_after_setup_e' );
	}
}

/**
 * riode_update_elementor_preferences
 *
 * update default elementor preference values
 *  - panel width to 340
 *
 * @since 1.0.1
 */
function riode_update_elementor_preferences( $user_id = -1 ) {
	if ( -1 == $user_id ) {
		$user_id = get_current_user_id();
	}

	$preference = get_user_meta( $user_id, 'elementor_preferences' );
	if ( empty( $preference[0] ) || empty( $preference[0]['panel_width'] ) ) {
		$preference[0]['panel_width'] = array(
			'unit'  => 'px',
			'size'  => 340,
			'sizes' => array(),
		);
	}

	update_user_meta( $user_id, 'elementor_preferences', $preference[0] );
}
