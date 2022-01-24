<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Dismiss
 *
 *
 * @since 1.4.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;

add_action( 'riode_elementor_add_common_options', 'riode_elementor_add_dismiss_controls', 25 );
add_filter( 'riode_elementor_common_wrapper_attributes', 'riode_elementor_common_wrapper_dismiss_attributes', 15, 3 );
add_action( 'riode_elementor_common_before_render_content', 'riode_elementor_common_before_render_dismiss', 25, 2 );
add_filter( 'riode_vars', 'riode_elementor_common_vars' );
add_action( 'wp_ajax_riode_set_cookie_dismiss_widget', 'riode_elementor_set_cookie_dismiss_widget' );
add_action( 'wp_ajax_nopriv_riode_set_cookie_dismiss_widget', 'riode_elementor_set_cookie_dismiss_widget' );

function riode_elementor_add_dismiss_controls( $self ) {
	global $riode_animations;

	if ( empty( $riode_animations ) ) {
		$riode_animations = array();
	}

	if ( empty( $riode_animations['sliderOut'] ) ) {
		$riode_animations['sliderOut'] = array();
	}

	$self->start_controls_section(
		'riode_cm_dismiss_section',
		array(
			'label' => esc_html__( 'Dismiss', 'riode-core' ),
			'tab'   => Riode_Elementor_Editor_Custom_Tabs::TAB_CUSTOM,
		)
	);

		$self->add_control(
			'riode_cm_dismiss',
			array(
				'label'       => esc_html__( 'Show Dismiss Button?', 'riode-core' ),
				'description' => esc_html__( 'This button removes current element with animating effect.', 'riode-core' ),
				'type'        => Elementor\Controls_Manager::SWITCHER,
				'render_type' => 'template',
			)
		);

		$self->start_controls_tabs(
			'riode_cm_dismiss_tabs',
			array(
				'condition' => array(
					'riode_cm_dismiss' => 'yes',
				),
			)
		);

			$self->start_controls_tab(
				'riode_cm_dismiss_settings_tab',
				array(
					'label' => esc_html__( 'Settings', 'riode-core' ),
				)
			);

				$self->add_control(
					'riode_cm_dismiss_animation_out',
					array(
						'label'       => esc_html__( 'Animation Out', 'riode-core' ),
						'description' => esc_html__( 'Choose animation when this element dismiss.', 'riode-core' ),
						'type'        => Controls_Manager::SELECT2,
						'options'     => $riode_animations['sliderOut'],
					)
				);

				$self->add_control(
					'riode_cm_dismiss_animation_duration',
					array(
						'label'       => esc_html__( 'Animation Duration(ms)', 'riode-core' ),
						'description' => esc_html__( 'Choose duration of out animation.', 'riode-core' ),
						'type'        => Controls_Manager::NUMBER,
						'default'     => 400,
					)
				);

				$self->add_control(
					'riode_cm_dismiss_animation_delay',
					array(
						'label'       => esc_html__( 'Animation Delay(ms)', 'riode-core' ),
						'description' => esc_html__( 'Control delay time of out animation.', 'riode-core' ),
						'type'        => Controls_Manager::NUMBER,
					)
				);

				$self->add_control(
					'riode_cm_dismiss_cookie',
					array(
						'label'       => esc_html__( 'Save In Cookie?', 'riode-core' ),
						'description' => esc_html__( 'Do not display this element again for a while using COOKIE.' ),
						'type'        => Elementor\Controls_Manager::SWITCHER,
						'label_on'    => esc_html__( 'Yes', 'riode-core' ),
						'label_off'   => esc_html__( 'No', 'riode-core' ),
						'render_type' => 'template',
						'separator'   => 'before',
					)
				);

				$self->add_control(
					'riode_cm_dismiss_cookie_expire',
					array(
						'label'       => esc_html__( 'Cookie Expires In(days)', 'riode-core' ),
						'description' => esc_html__( 'Choose existing time that cookie information will expire in.', 'riode-core' ),
						'type'        => Controls_Manager::NUMBER,
						'default'     => 7,
						'condition'   => array(
							'riode_cm_dismiss_cookie' => 'yes',
						),
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'riode_cm_dismiss_styles_tab',
				array(
					'label' => esc_html__( 'Styles', 'riode-core' ),
				)
			);

				$self->add_responsive_control(
					'riode_cm_dismiss_x_offset',
					array(
						'label'      => esc_html__( 'X-Offset', 'riode-core' ),
						'type'       => Elementor\Controls_Manager::SLIDER,
						'size_units' => array( 'px', '%', 'em' ),
						'range'      => array(
							'px' => array(
								'min' => -500,
								'max' => 500,
							),
							'%'  => array(
								'min' => -100,
								'max' => 100,
							),
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .dismiss-button.dismiss-button-{{ID}}' => 'right: {{SIZE}}{{UNIT}};',
						),
					)
				);

				$self->add_responsive_control(
					'riode_cm_dismiss_y_offset',
					array(
						'label'      => esc_html__( 'Y-Offset', 'riode-core' ),
						'type'       => Elementor\Controls_Manager::SLIDER,
						'size_units' => array( 'px', '%', 'em' ),
						'range'      => array(
							'px' => array(
								'min' => -500,
								'max' => 500,
							),
							'%'  => array(
								'min' => -100,
								'max' => 100,
							),
						),
						'selectors'  => array(
							'.elementor-element-{{ID}} .dismiss-button.dismiss-button-{{ID}}' => 'top: {{SIZE}}{{UNIT}};',
						),
					)
				);

				$self->add_responsive_control(
					'riode_cm_dismiss_z_index',
					array(
						'label'     => esc_html__( 'Z-Index', 'riode-core' ),
						'type'      => Elementor\Controls_Manager::NUMBER,
						'selectors' => array(
							'.elementor-element-{{ID}} .dismiss-button-{{ID}}' => 'z-index: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'        => 'dismiss_typography',
						'label'       => esc_html__( 'Dismiss Size', 'riode-core' ),
						'selector'    => '.elementor-element-{{ID}} .dismiss-button-{{ID}}::before',
					)
				);

				$self->add_control(
					'riode_cm_dismiss_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Elementor\Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .dismiss-button-{{ID}}' => 'color: {{VALUE}};',
						),
					)
				);

				$self->add_control(
					'riode_cm_dismiss_hover_color',
					array(
						'label'     => esc_html__( 'Hover Color', 'riode-core' ),
						'type'      => Elementor\Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .dismiss-button-{{ID}}:hover, .elementor-element-{{ID}} .dismiss-button-{{ID}}:focus' => 'color: {{VALUE}};',
						),
					)
				);

			$self->end_controls_tab();

		$self->end_controls_tabs();

	$self->end_controls_section();
}

function riode_elementor_common_wrapper_dismiss_attributes( $options, $settings, $id = '' ) {
	if ( empty( $options['class'] ) ) {
		$options['class'] = '';
	}
	if ( isset( $settings['riode_cm_dismiss'] ) && 'yes' == $settings['riode_cm_dismiss'] ) {
		$options['class'] .= ' dismiss-widget';

		if ( ! riode_is_preview() && isset( $_COOKIE[ 'riode-dismiss-' . $id ] ) ) {
			$options['class'] .= ' d-none';
		}
	}

	return $options;
}

function riode_elementor_common_before_render_dismiss( $settings, $id = '' ) {
	if ( isset( $settings['riode_cm_dismiss'] ) && 'yes' == $settings['riode_cm_dismiss'] ) {
		$settings = shortcode_atts(
			array(
				'riode_cm_dismiss_animation_out'      => '',
				'riode_cm_dismiss_animation_duration' => '',
				'riode_cm_dismiss_animation_delay'    => '',
				'riode_cm_dismiss_cookie'             => '',
				'riode_cm_dismiss_cookie_expire'      => 7,
			),
			$settings
		);

		extract( $settings ); // @codingStandardsIgnoreLine

		echo "<a href='#' class='btn btn-link dismiss-button dismiss-button-" . $id . "' data-widget-id=" . $id . " data-options='" . json_encode(
			array(
				'animation'          => $riode_cm_dismiss_animation_out,
				'animation_duration' => $riode_cm_dismiss_animation_duration,
				'animation_delay'    => $riode_cm_dismiss_animation_delay,
				'cookie_enable'      => $riode_cm_dismiss_cookie == 'yes',
				'cookie_expire'      => $riode_cm_dismiss_cookie_expire,
			)
		) . "'></a>";
	}
}

function riode_elementor_common_vars( $vars ) {
	$vars['preview']['elementor'] = riode_is_elementor_preview();

	return $vars;
}

function riode_elementor_set_cookie_dismiss_widget() {
	// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

	if ( ! empty( $_POST['widget_id'] ) ) {
		setcookie( 'riode-dismiss-' . $_POST['widget_id'], true, time() + $_POST['expire'] * 24 * 60 * 60, '/' );
	} else {
		echo 'failure';
	}

	exit;

	// phpcs:enable
}
