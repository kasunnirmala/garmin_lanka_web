<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Floating Effect
 *
 * Mouse Tracking Effect
 * Scroll Floating Effect
 *
 * @since 1.2.0
 * @since 1.4.0 added in independent widget file
 */

use Elementor\Controls_Manager;

add_action( 'riode_elementor_add_common_options', 'riode_elementor_add_floating_controls', 10 );
add_filter( 'riode_elementor_common_wrapper_attributes', 'riode_elementor_common_wrapper_floating_attributes', 10, 3 );

function riode_elementor_add_floating_controls( $self, $is_banner = false ) {
	if ( ! $is_banner ) {
		$self->start_controls_section(
			'_riode_section_floating_effect',
			array(
				'label' => __( 'Floating Effects', 'riode-core' ),
				'tab'   => Riode_Elementor_Editor_Custom_Tabs::TAB_CUSTOM,
			)
		);
	}

		$self->add_control(
			'riode_floating',
			array(
				'label'       => esc_html__( 'Floating Effects', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'description' => esc_html__( 'Select the certain floating effect you want to implement in your page.', 'riode-core' ),
				'groups'      => array(
					''                  => esc_html__( 'None', 'riode-core' ),
					'transform_group'   => array(
						'label'   => esc_html__( 'Transform Scroll Effect', 'riode-core' ),
						'options' => array(
							'skr_transform_up'    => esc_html__( 'Move To Up', 'riode-core' ),
							'skr_transform_down'  => esc_html__( 'Move To Down', 'riode-core' ),
							'skr_transform_left'  => esc_html__( 'Move To Left', 'riode-core' ),
							'skr_transform_right' => esc_html__( 'Move To Right', 'riode-core' ),
						),
					),
					'fade_in_group'     => array(
						'label'   => esc_html__( 'Fade In Scroll Effect', 'riode-core' ),
						'options' => array(
							'skr_fade_in'       => esc_html__( 'Fade In', 'riode-core' ),
							'skr_fade_in_up'    => esc_html__( 'Fade In Up', 'riode-core' ),
							'skr_fade_in_down'  => esc_html__( 'Fade In Down', 'riode-core' ),
							'skr_fade_in_left'  => esc_html__( 'Fade In Left', 'riode-core' ),
							'skr_fade_in_right' => esc_html__( 'Fade In Right', 'riode-core' ),
						),
					),
					'fade_out_group'    => array(
						'label'   => esc_html__( 'Fade Out Scroll Effect', 'riode-core' ),
						'options' => array(
							'skr_fade_out'       => esc_html__( 'Fade Out', 'riode-core' ),
							'skr_fade_out_up'    => esc_html__( 'Fade Out Up', 'riode-core' ),
							'skr_fade_out_down'  => esc_html__( 'Fade Out Down', 'riode-core' ),
							'skr_fade_out_left'  => esc_html__( 'Fade Out Left', 'riode-core' ),
							'skr_fade_out_right' => esc_html__( 'Fade Out Right', 'riode-core' ),
						),
					),
					'flip_group'        => array(
						'label'   => esc_html__( 'Flip Scroll Effect', 'riode-core' ),
						'options' => array(
							'skr_flip_x' => esc_html__( 'Flip Horizontally', 'riode-core' ),
							'skr_flip_y' => esc_html__( 'Flip Vertically', 'riode-core' ),
						),
					),
					'rotate_group'      => array(
						'label'   => esc_html__( 'Rotate Scroll Effect', 'riode-core' ),
						'options' => array(
							'skr_rotate'       => esc_html__( 'Rotate', 'riode-core' ),
							'skr_rotate_left'  => esc_html__( 'Rotate To Left', 'riode-core' ),
							'skr_rotate_right' => esc_html__( 'Rotate To Right', 'riode-core' ),
						),
					),
					'zoom_in_group'     => array(
						'label'   => esc_html__( 'Zoom In Scroll Effect', 'riode-core' ),
						'options' => array(
							'skr_zoom_in'       => esc_html__( 'Zoom In', 'riode-core' ),
							'skr_zoom_in_up'    => esc_html__( 'Zoom In Up', 'riode-core' ),
							'skr_zoom_in_down'  => esc_html__( 'Zoom In Down', 'riode-core' ),
							'skr_zoom_in_left'  => esc_html__( 'Zoom In Left', 'riode-core' ),
							'skr_zoom_in_right' => esc_html__( 'Zoom In Right', 'riode-core' ),
						),
					),
					'zoom_out_group'    => array(
						'label'   => esc_html__( 'Zoom Out Scroll Effect', 'riode-core' ),
						'options' => array(
							'skr_zoom_out'       => esc_html__( 'Zoom Out', 'riode-core' ),
							'skr_zoom_out_up'    => esc_html__( 'Zoom Out Up', 'riode-core' ),
							'skr_zoom_out_down'  => esc_html__( 'Zoom Out Down', 'riode-core' ),
							'skr_zoom_out_left'  => esc_html__( 'Zoom Out Left', 'riode-core' ),
							'skr_zoom_out_right' => esc_html__( 'Zoom Out Right', 'riode-core' ),
						),
					),
					'mouse_track_group' => array(
						'label'   => esc_html__( 'Mouse Tracking', 'riode-core' ),
						'options' => array(
							'mouse_tracking_x' => esc_html__( 'Track Horizontally', 'riode-core' ),
							'mouse_tracking_y' => esc_html__( 'Track Vertically', 'riode-core' ),
							'mouse_tracking'   => esc_html__( 'Track Any Direction', 'riode-core' ),
						),
					),
				),
			)
		);

		$self->add_control(
			'riode_m_track_dir',
			array(
				'label'       => esc_html__( 'Inverse Mouse Move', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Move object in opposite direction of mouse move.', 'riode-core' ),
				'condition'   => array(
					'riode_floating' => array( 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
				),
			)
		);

		$self->add_control(
			'riode_m_track_speed',
			array(
				'label'       => esc_html__( 'Track Speed', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Controls speed of floating object while mouse is moving.', 'riode-core' ),
				'default'     => array(
					'size' => 0.5,
				),
				'range'       => array(
					'' => array(
						'step' => 0.1,
						'min'  => 0,
						'max'  => 5,
					),
				),
				'condition'   => array(
					'riode_floating' => array( 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
				),
			)
		);

		$self->add_control(
			'riode_scroll_size',
			array(
				'label'       => esc_html__( 'Floating Size', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Controls offset of floating object position while scrolling.', 'riode-core' ),
				'default'     => array(
					'size' => '50',
					'unit' => '%',
				),
				'range'       => array(
					'%' => array(
						'step' => 1,
						'min'  => 20,
						'max'  => 500,
					),
				),
				'condition'   => array(
					'riode_floating!' => array( '', 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
				),
			)
		);

		$self->add_control(
			'riode_scroll_stop',
			array(
				'label'       => esc_html__( 'When scrolling effect should be stopped', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'center',
				'options'     => array(
					'top'        => esc_html__( 'After Top of Object reaches Top of Screen', 'riode-core' ),
					'center-top' => esc_html__( 'After Top of Object reaches Center of Screen', 'riode-core' ),
					'center'     => esc_html__( 'After Center of Object reaches Center of Screen', 'riode-core' ),
				),
				'condition'   => array(
					'riode_floating!' => array( '', 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
				),
				'description' => esc_html__( 'Determine how to stop scrolling effect.', 'riode-core' ),
			)
		);

	if ( ! $is_banner ) {
		$self->end_controls_section();
	}
}

function riode_elementor_common_wrapper_floating_attributes( $options, $settings, $id = '' ) {
	if ( 0 === strpos( $settings['riode_floating'], 'mouse_tracking' ) ) { // mouse tracking
		$floating_settings = array();
		if ( 'yes' == $settings['riode_m_track_dir'] ) {
			$floating_settings['invertX'] = true;
			$floating_settings['invertY'] = true;
		} else {
			$floating_settings['invertX'] = false;
			$floating_settings['invertY'] = false;
		}

		if ( 'mouse_tracking_x' == $settings['riode_floating'] ) {
			$floating_settings['limitY'] = '0';
		} elseif ( 'mouse_tracking_y' == $settings['riode_floating'] ) {
			$floating_settings['limitX'] = '0';
		}

		wp_enqueue_script( 'jquery-floating' );
		$options = $options +
			array(
				'data-plugin'         => 'floating',
				'data-options'        => json_encode( $floating_settings ),
				'data-floating-depth' => empty( $settings['riode_m_track_speed']['size'] ) ? 0.5 : floatval( $settings['riode_m_track_speed']['size'] ),
			);
	} elseif ( 0 === strpos( $settings['riode_floating'], 'skr_' ) ) { // scrolling effect
		$scroll_settings = array();
		$size            = empty( $settings['riode_scroll_size']['size'] ) ? 50 : floatval( $settings['riode_scroll_size']['size'] );
		$pos             = isset( $settings['riode_scroll_stop'] ) ? $settings['riode_scroll_stop'] : 'center';

		if ( 0 === strpos( $settings['riode_floating'], 'skr_transform_' ) ) {
			switch ( $settings['riode_floating'] ) {
				case 'skr_transform_up':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, ' . $size . '%);';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: translate(0, -' . $size . '%);';
					break;
				case 'skr_transform_down':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, -' . $size . '%);';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: translate(0, ' . $size . '%);';
					break;
				case 'skr_transform_left':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(' . $size . '%, 0);';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: translate(-' . $size . '%, 0);';
					break;
				case 'skr_transform_right':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(-' . $size . '%, 0);';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: translate(' . $size . '%, 0);';
					break;
			}
		} elseif ( 0 === strpos( $settings['riode_floating'], 'skr_fade_in' ) ) {
			switch ( $settings['riode_floating'] ) {
				case 'skr_fade_in':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, 0); opacity: 0;';
					break;
				case 'skr_fade_in_up':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, ' . $size . '%); opacity: 0;';
					break;
				case 'skr_fade_in_down':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, -' . $size . '%); opacity: 0;';
					break;
				case 'skr_fade_in_left':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(' . $size . '%, 0); opacity: 0;';
					break;
				case 'skr_fade_in_right':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(-' . $size . '%, 0); opacity: 0;';
					break;
			}

			$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0%, 0%); opacity: 1;';
		} elseif ( 0 === strpos( $settings['riode_floating'], 'skr_fade_out' ) ) {
			$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0%, 0%); opacity: 1;';

			switch ( $settings['riode_floating'] ) {
				case 'skr_fade_out':
					$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, 0); opacity: 0;';
					break;
				case 'skr_fade_out_up':
					$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, -' . $size . '%); opacity: 0;';
					break;
				case 'skr_fade_out_down':
					$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, ' . $size . '%); opacity: 0;';
					break;
				case 'skr_fade_out_left':
					$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(-' . $size . '%, 0); opacity: 0;';
					break;
				case 'skr_fade_out_right':
					$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(' . $size . '%, 0); opacity: 0;';
					break;
			}
		} elseif ( 0 === strpos( $settings['riode_floating'], 'skr_flip' ) ) {
			switch ( $settings['riode_floating'] ) {
				case 'skr_flip_x':
					$scroll_settings['options']['data-bottom-top'] = 'transform: perspective(20cm) rotateY(' . $size . 'deg)';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: perspective(20cm), rotateY(-' . $size . 'deg)';
					break;
				case 'skr_flip_y':
					$scroll_settings['options']['data-bottom-top'] = 'transform: perspective(20cm) rotateX(-' . $size . 'deg)';
					$scroll_settings['options'][ 'data-' . $pos ]  = 'transform: perspective(20cm), rotateX(' . $size . 'deg)';
					break;
			}
		} elseif ( 0 === strpos( $settings['riode_floating'], 'skr_rotate' ) ) {
			switch ( $settings['riode_floating'] ) {
				case 'skr_rotate':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, 0) rotate(-' . ( 360 * $size / 50 ) . 'deg);';
					break;
				case 'skr_rotate_left':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(' . ( 100 * $size / 50 ) . '%, 0) rotate(-' . ( 360 * $size / 50 ) . 'deg);';
					break;
				case 'skr_rotate_right':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(-' . ( 100 * $size / 50 ) . '%, 0) rotate(-' . ( 360 * $size / 50 ) . 'deg);';
					break;
			}

			$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, 0) rotate(0deg);';
		} elseif ( 0 === strpos( $settings['riode_floating'], 'skr_zoom_in' ) ) {
			switch ( $settings['riode_floating'] ) {
				case 'skr_zoom_in':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, 0) scale(' . ( 1 - $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_in_up':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, ' . ( 40 + $size ) . '%) scale(' . ( 1 - $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_in_down':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, -' . ( 40 + $size ) . '%) scale(' . ( 1 - $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_in_left':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(' . $size . '%, 0) scale(' . ( 1 - $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_in_right':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(-' . $size . '%, 0) scale(' . ( 1 - $size / 100 ) . '); transform-origin: center;';
					break;
			}

			$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, 0) scale(1);';
		} elseif ( 0 === strpos( $settings['riode_floating'], 'skr_zoom_out' ) ) {
			switch ( $settings['riode_floating'] ) {
				case 'skr_zoom_out':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, 0) scale(' . ( 1 + $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_out_up':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, ' . ( 40 + $size ) . '%) scale(' . ( 1 + $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_out_down':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(0, -' . ( 40 + $size ) . '%) scale(' . ( 1 + $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_out_left':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(' . $size . '%, 0) scale(' . ( 1 + $size / 100 ) . '); transform-origin: center;';
					break;
				case 'skr_zoom_out_right':
					$scroll_settings['options']['data-bottom-top'] = 'transform: translate(-' . $size . '%, 0) scale(' . ( 1 + $size / 100 ) . '); transform-origin: center;';
					break;
			}

			$scroll_settings['options'][ 'data-' . $pos ] = 'transform: translate(0, 0) scale(1);';
		}

		wp_enqueue_script( 'jquery-skrollr' );
		$options = $options +
			array(
				'data-plugin'  => 'skrollr',
				'data-options' => json_encode( $scroll_settings['options'] ),
			);
	}

	return $options;
}
