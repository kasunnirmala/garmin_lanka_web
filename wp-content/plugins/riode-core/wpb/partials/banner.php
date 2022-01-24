<?php
if ( ! function_exists( 'riode_wpb_banner_general_controls' ) ) {
	function riode_wpb_banner_general_controls() {
		return array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Wrap content with', 'riode-core' ),
				'description' => esc_html__( 'Choose to wrap banner content in Fullscreen banner.', 'riode-core' ),
				'param_name'  => 'wrap_with',
				'value'       => array(
					esc_html__( 'None', 'riode-core' ) => '',
					esc_html__( 'Container', 'riode-core' ) => 'container',
					esc_html__( 'Container Fluid', 'riode-core' ) => 'container-fluid',
				),
				'std'         => '',
			),
			array(
				'type'        => 'attach_image',
				'heading'     => esc_html__( 'Image', 'riode-core' ),
				'description' => esc_html__( 'Upload image and set it for banner image.', 'riode-core' ),
				'param_name'  => 'banner_image',
				'value'       => '',
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Background Color', 'riode-core' ),
				'description' => esc_html__( 'Set background color of banner.', 'riode-core' ),
				'param_name'  => 'banner_bg_color',
				'selectors'   => array(
					'{{WRAPPER}} .banner'     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .banner img' => 'background-color: transparent;',
				),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Image Position', 'riode-core' ),
				'param_name'  => 'image_position',
				'description' => esc_html__( 'Change image position for banner when image is larger than render area. You can input image position like this: center top or 50% 50%.', 'riode-core' ),
				'selectors'   => array(
					'{{WRAPPER}} .banner-img img' => 'object-position: {{VALUE}};',
				),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Full Screen', 'riode-core' ),
				'param_name'  => 'full_screen',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Full screen banner will have 100vh ( same as screen height ) height', 'riode-core' ),
				'std'         => 'no',
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Min Height', 'riode-core' ),
				'responsive'  => true,
				'description' => esc_html__( 'Controls min height value of banner.', 'riode-core' ),
				'param_name'  => 'min_height',
				'units'       => array(
					'px',
					'%',
					'rem',
					'vh',
				),
				'std'         => '{"xl":"300","unit":"px"}',
				'selectors'   => array(
					'{{WRAPPER}} .banner' => 'min-height: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Max Height', 'riode-core' ),
				'description' => esc_html__( 'Controls max height value of banner.', 'riode-core' ),
				'responsive'  => true,
				'param_name'  => 'max_height',
				'units'       => array(
					'px',
					'%',
					'rem',
					'vh',
				),
				'selectors'   => array(
					'{{WRAPPER}} .banner, {{WRAPPER}} img' => 'max-height: {{VALUE}}{{UNIT}};overflow: hidden;',
				),
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_banner_effect_controls' ) ) {
	function riode_wpb_banner_effect_controls() {
		return array(
			array(
				'type'        => 'riode_dropdown_group',
				'heading'     => esc_html__( 'Hover Effect', 'riode-core' ),
				'description' => esc_html__( 'Choose banner overlay and image filter effect on hover.', 'riode-core' ),
				'param_name'  => 'hover_effect',
				'value'       => array(
					''        => esc_html__( 'None', 'riode-core' ),
					'overlay' => array(
						'label'   => esc_html__( 'Overlay', 'riode-core' ),
						'options' => array(
							'overlay-light'              => esc_html__( 'Light', 'riode-core' ),
							'overlay-dark'               => esc_html__( 'Dark', 'riode-core' ),
							'overlay-zoom'               => esc_html__( 'Zoom', 'riode-core' ),
							'overlay-zoom overlay-light' => esc_html__( 'Zoom and Light', 'riode-core' ),
							'overlay-zoom overlay-dark'  => esc_html__( 'Zoom and Dark', 'riode-core' ),
						),
					),
					'effect'  => array(
						'label'   => esc_html__( 'Effect', 'riode-core' ),
						'options' => array(
							'overlay-effect-1' => esc_html__( 'Effect 1', 'riode-core' ),
							'overlay-effect-2' => esc_html__( 'Effect 2', 'riode-core' ),
							'overlay-effect-3' => esc_html__( 'Effect 3', 'riode-core' ),
							'overlay-effect-4' => esc_html__( 'Effect 4', 'riode-core' ),
						),
					),
					'filter'  => array(
						'label'   => esc_html__( 'Image Filter', 'riode-core' ),
						'options' => array(
							'overlay-image-filter overlay-blur'       => esc_html__( 'Blur', 'riode-core' ),
							'overlay-image-filter overlay-brightness' => esc_html__( 'Brightness', 'riode-core' ),
							'overlay-image-filter overlay-contrast'   => esc_html__( 'Contrast', 'riode-core' ),
							'overlay-image-filter overlay-grayscale'  => esc_html__( 'Grayscale', 'riode-core' ),
							'overlay-image-filter overlay-hue'        => esc_html__( 'Hue-Rotate', 'riode-core' ),
							'overlay-image-filter overlay-opacity'    => esc_html__( 'Opacity', 'riode-core' ),
							'overlay-image-filter overlay-saturate'   => esc_html__( 'Saturate', 'riode-core' ),
							'overlay-image-filter overlay-sepia'      => esc_html__( 'Sepia', 'riode-core' ),
						),
					),
				),
				'std'         => '',
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Hover Effect Color', 'riode-core' ),
				'description' => esc_html__( 'Set overlay color of hover effect.', 'riode-core' ),
				'param_name'  => 'hover_effect_color',
				'selectors'   => array(
					'{{WRAPPER}} .banner-img:before, {{WRAPPER}} .banner-img:after, {{WRAPPER}} .banner:before, {{WRAPPER}} .banner:after' => 'background-color: {{VALUE}};',
				),
				'dependency'  => array(
					'element'            => 'hover_effect',
					'value_not_equal_to' => array( '', 'overlay-image-filter overlay-blur', 'overlay-image-filter overlay-brightness', 'overlay-image-filter overlay-contrast', 'overlay-image-filter overlay-grayscale', 'overlay-image-filter overlay-hue', 'overlay-image-filter overlay-opacity', 'overlay-image-filter overlay-saturate', 'overlay-image-filter overlay-sepia' ),
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Background Effect', 'riode-core' ),
				'description' => esc_html__( 'Choose banner background effect. (Kenburns Effect)', 'riode-core' ),
				'param_name'  => 'background_effect',
				'value'       => array(
					esc_html__( 'None', 'riode-core' ) => 'none',
					esc_html__( 'kenBurnsToRight', 'riode-core' ) => 'kenBurnsToRight',
					esc_html__( 'kenBurnsToLeft', 'riode-core' ) => 'kenBurnsToLeft',
					esc_html__( 'kenBurnsToLeftTop', 'riode-core' ) => 'kenBurnsToLeftTop',
					esc_html__( 'kenBurnsToRightTop', 'riode-core' ) => 'kenBurnsToRightTop',
				),
				'std'         => 'none',
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Background Effect Duration', 'riode-core' ),
				'description' => esc_html__( 'Set banner background effect duration time.', 'riode-core' ),
				'param_name'  => 'effect_duration',
				'units'       => array(
					's',
				),
				'std'         => '{"xl":"30","unit":"s"}',
				'selectors'   => array(
					'{{WRAPPER}} .background-effect' => 'animation-duration: {{VALUE}}{{UNIT}};',
				),
				'dependency'  => array(
					'element'            => 'background_effect',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Particle Effect', 'riode-core' ),
				'description' => esc_html__( 'Shows animating particles over banner image. Choose from Snowfall, Sparkle.', 'riode-core' ),
				'param_name'  => 'particle_effect',
				'value'       => array(
					esc_html__( 'None', 'riode-core' )     => '',
					esc_html__( 'Snowfall', 'riode-core' ) => 'snowfall',
					esc_html__( 'Sparkle', 'riode-core' )  => 'sparkle',
				),
				'std'         => '',
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_banner_parallax_controls' ) ) {
	function riode_wpb_banner_parallax_controls() {
		return array(
			array(
				'type'        => 'checkbox',
				'param_name'  => 'parallax',
				'heading'     => esc_html__( 'Enable Parallax', 'riode-core' ),
				'description' => esc_html__( 'Set to enable parallax effect for banner.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Parallax Speed', 'riode-core' ),
				'description' => esc_html__( 'Change speed of banner parallax effect.', 'riode-core' ),
				'param_name'  => 'parallax_speed',
				'std'         => 1,
				'dependency'  => array(
					'element' => 'parallax',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Parallax Offset', 'riode-core' ),
				'description' => esc_html__( 'Determine offset value of parallax effect to show different parts on screen.', 'riode-core' ),
				'param_name'  => 'parallax_offset',
				'std'         => 0,
				'dependency'  => array(
					'element' => 'parallax',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Parallax Height (%)', 'riode-core' ),
				'description' => esc_html__( 'Change height of parallax background image.', 'riode-core' ),
				'param_name'  => 'parallax_height',
				'std'         => '200',
				'dependency'  => array(
					'element' => 'parallax',
					'value'   => 'yes',
				),
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_banner_video_controls' ) ) {
	function riode_wpb_banner_video_controls() {
		return array(
			array(
				'type'        => 'checkbox',
				'param_name'  => 'video_banner',
				'heading'     => esc_html__( 'Enable Video', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Set to make video banner.', 'riode-core' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Video URL', 'riode-core' ),
				'description' => esc_html__( 'Input video url for video banner.', 'riode-core' ),
				'param_name'  => 'video_url',
				'dependency'  => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'video_autoplay',
				'heading'     => esc_html__( 'Autoplay', 'riode-core' ),
				'description' => esc_html__( 'Set to autoplay video.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'video_mute',
				'heading'     => esc_html__( 'Mute', 'riode-core' ),
				'description' => esc_html__( 'Set to disable sound of video.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'video_loop',
				'heading'     => esc_html__( 'Loop', 'riode-core' ),
				'description' => esc_html__( 'Set to play video infinite times.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'video_controls',
				'heading'     => esc_html__( 'Player Controls', 'riode-core' ),
				'description' => esc_html__( 'Set to show control bar of video.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element' => 'video_banner',
					'value'   => 'yes',
				),
			),
		);
	}
}
