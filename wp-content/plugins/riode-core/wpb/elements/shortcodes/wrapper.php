<?php
/**
 * Riode Element Wrapper shortcode
 *
 * @since 1.1.0
 */

global $riode_animations;

if ( empty( $riode_animations ) ) {
	$riode_animations = array();
}

if ( empty( $riode_animations['sliderOut'] ) ) {
	$riode_animations['sliderOut'] = array();
}

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Tag', 'riode-core' ),
			'param_name' => 'html_tag',
			'value'      => array(
				esc_html( 'Div', 'riode-core' )     => 'div',
				esc_html( 'Section', 'riode-core' ) => 'section',
				esc_html( 'H1', 'riode-core' )      => 'h1',
				esc_html( 'H2', 'riode-core' )      => 'h2',
				esc_html( 'H3', 'riode-core' )      => 'h3',
				esc_html( 'H4', 'riode-core' )      => 'h4',
				esc_html( 'H5', 'riode-core' )      => 'h5',
				esc_html( 'H6', 'riode-core' )      => 'h6',
				esc_html( 'P', 'riode-core' )       => 'p',
				esc_html( 'Span', 'riode-core' )    => 'span',
			),
			'std'        => 'div',
		),
		array(
			'type'        => 'riode_dropdown_group',
			'heading'     => esc_html__( 'Floating Effects', 'riode-core' ),
			'param_name'  => 'floating_effect',
			'description' => esc_html__( 'Select the certain floating effect you want to implement in your page.', 'riode-core' ),
			'value'       => array(
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
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Inverse Mouse Move', 'riode-core' ),
			'param_name'  => 'floating_m_track_dir',
			'description' => esc_html__( 'Move object in opposite direction of mouse move.', 'riode-core' ),
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'floating_effect',
				'value'   => array( 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Track Speed', 'riode-core' ),
			'description' => esc_html__( 'Controls speed of floating object while mouse is moving.', 'riode-core' ),
			'param_name'  => 'floating_m_track_speed',
			'std'         => '0.5',
			'dependency'  => array(
				'element' => 'floating_effect',
				'value'   => array( 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
			),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Floating Size', 'riode-core' ),
			'description' => esc_html__( 'Controls offset of floating object position while scrolling.', 'riode-core' ),
			'param_name'  => 'floating_scroll_speed',
			'std'         => '50',
			'dependency'  => array(
				'element'            => 'floating_effect',
				'value_not_equal_to' => array( '', 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Floating Stop', 'riode-core' ),
			'description' => esc_html__( 'When scrolling effect should be stopped', 'riode-core' ),
			'param_name'  => 'floating_scroll_stop',
			'std'         => 'center',
			'value'       => array(
				esc_html__( 'After Top of Object reaches Top of Screen', 'riode-core' ) => 'top',
				esc_html__( 'After Top of Object reaches Center of Screen', 'riode-core' ) => 'center-top',
				esc_html__( 'After Center of Object reaches Center of Screen', 'riode-core' ) => 'center',
			),
			'dependency'  => array(
				'element'            => 'floating_effect',
				'value_not_equal_to' => array( '', 'mouse_tracking_x', 'mouse_tracking_y', 'mouse_tracking' ),
			),
		),
	),
	esc_html__( 'Dismiss', 'riode-core' ) => array(
		esc_html__( 'General', 'riode-core' ) => array(
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Dismiss?', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'param_name'  => 'riode_cm_dismiss',
				'description' => esc_html__( 'This button removes current element with animating effect.', 'riode-core' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Animation Out', 'riode-core' ),
				'description' => esc_html__( 'Choose animation when this element dismiss.', 'riode-core' ),
				'param_name'  => 'riode_cm_dismiss_animation_out',
				'value'       => array_flip( $riode_animations['sliderOut'] ),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Animation Duration(ms)', 'riode-core' ),
				'description' => esc_html__( 'Choose duration of out animation.', 'riode-core' ),
				'param_name'  => 'riode_cm_dismiss_animation_duration',
				'std'         => 400,
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Animation Delay(ms)', 'riode-core' ),
				'description' => esc_html__( 'Control delay time of out animation.', 'riode-core' ),
				'param_name'  => 'riode_cm_dismiss_animation_delay',
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Save In Cookie?', 'riode-core' ),
				'param_name'  => 'riode_cm_dismiss_cookie',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Do not display this element again for a while using COOKIE.' ),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Cookie Expires In(days)', 'riode-core' ),
				'description' => esc_html__( 'Choose existing time that cookie information will expire in.', 'riode-core' ),
				'param_name'  => 'riode_cm_dismiss_cookie_expire',
				'std'         => 7,
			),
		),
		esc_html__( 'Style', 'riode-core' )   => array(
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Button Position', 'riode-core' ),
				'param_name' => 'riode_cm_dismiss_position',
				'selectors'  => array(
					'{{WRAPPER}} > .dismiss-button' => 'top: {{TOP}}; right: {{RIGHT}}; left: {{LEFT}}; bottom: {{BOTTOM}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Z-Index', 'riode-core' ),
				'param_name' => 'riode_cm_dismiss_z_index',
				'selectors'  => array(
					'{{WRAPPER}} > .dismiss-button' => 'z-index:{{VALUE}};',
				),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Button Typography', 'riode-core' ),
				'param_name'  => '_dismiss_typography',
				'selectors'   => array(
					'{{WRAPPER}} > .dismiss-button::before',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Color', 'riode-core' ),
				'param_name' => 'riode_cm_dismiss_color',
				'selectors'  => array(
					'{{WRAPPER}} > .dismiss-button' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Hover Color', 'riode-core' ),
				'param_name' => 'riode_cm_dismiss_hover_color',
				'selectors'  => array(
					'{{WRAPPER}} > .dismiss-button:hover' => 'color: {{VALUE}};',
				),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Element Wrapper', 'riode-core' ),
		'base'            => 'wpb_riode_wrapper',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_wrapper',
		'as_parent'       => array( 'except' => 'wpb_riode_wrapper' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Wrap any elements with this. This provides floating effects and dismiss feature.', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Wrapper extends WPBakeryShortCodesContainer {
	}
}
