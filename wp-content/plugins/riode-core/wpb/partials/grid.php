<?php
if ( ! function_exists( 'riode_wpb_grid_layout_controls' ) ) {
	function riode_wpb_grid_layout_controls() {
		return array(
			array(
				'type'        => 'riode_number',
				'param_name'  => 'col_cnt',
				'heading'     => esc_html__( 'Columns', 'riode-core' ),
				'description' => esc_html__( 'Select number of columns to show.', 'riode-core' ),
				'responsive'  => true,
				'dependency'  => array(
					'element' => 'layout_type',
					'value'   => array(
						'grid',
						'slider',
					),
				),
			),
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'col_sp',
				'heading'     => esc_html__( 'Columns Spacing', 'riode-core' ),
				'description' => esc_html__( 'Choose amount of spacing between items. Choose from No Space, Extra Small, Small, Medium, Large.', 'riode-core' ),
				'std'         => 'md',
				'value'       => array(
					'no' => array(
						'title' => esc_html__( 'NO', 'riode-core' ),
					),
					'xs' => array(
						'title' => esc_html__( 'XS', 'riode-core' ),
					),
					'sm' => array(
						'title' => esc_html__( 'SM', 'riode-core' ),
					),
					'md' => array(
						'title' => esc_html__( 'MD', 'riode-core' ),
					),
					'lg' => array(
						'title' => esc_html__( 'LG', 'riode-core' ),
					),
				),
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_loadmore_layout_controls' ) ) {
	function riode_wpb_loadmore_layout_controls() {
		return array(
			array(
				'type'       => 'dropdown',
				'param_name' => 'loadmore_type',
				'heading'    => esc_html__( 'Load More', 'riode-core' ),
				'value'      => array(
					esc_html__( 'No', 'riode-core' ) => '',
					esc_html__( 'By button', 'riode-core' ) => 'button',
					esc_html__( 'By pagination', 'riode-core' ) => 'page',
					esc_html__( 'By scroll', 'riode-core' ) => 'scroll',
				),
				'dependency' => array(
					'element' => 'layout_type',
					'value'   => array( 'grid', 'creative' ),
				),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'loadmore_label',
				'heading'     => esc_html__( 'Load More Label', 'riode-core' ),
				'value'       => '',
				'placeholder' => esc_html__( 'Load More', 'riode-core' ),
				'dependency'  => array(
					'element' => 'layout_type',
					'value'   => array( 'grid', 'creative' ),
				),
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_loadmore_button_controls' ) ) {
	function riode_wpb_loadmore_button_controls() {
		return array(
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Label Typography', 'riode-core' ),
				'param_name' => 'loadmore_button_typography',
				'selectors'  => array(
					'{{WRAPPER}} .btn-load',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Min Width', 'riode-core' ),
				'param_name' => 'loadmore_btn_min_width',
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .btn-load' => 'min-width: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Padding', 'riode-core' ),
				'param_name' => 'loadmore_btn_padding',
				'selectors'  => array(
					'{{WRAPPER}} .btn-load' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => __( 'Border Radius', 'riode-core' ),
				'param_name' => 'loadmore_btn_border_radius',
				'selectors'  => array(
					'{{WRAPPER}} .btn-load' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'heading'    => esc_html__( 'Border Width', 'riode-core' ),
				'param_name' => 'loadmore_btn_border_width',
				'selectors'  => array(
					'{{WRAPPER}} .btn-load' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
				),
			),
			array(
				'type'       => 'riode_color_group',
				'heading'    => esc_html__( 'Colors', 'riode-core' ),
				'param_name' => 'loadmore_colors',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .btn-load',
					'hover'  => '{{WRAPPER}} .btn-load:hover',
					'active' => '{{WRAPPER}} .btn-load:not(:focus):active, {{WRAPPER}} .btn-load:focus',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_slider_layout_controls' ) ) {
	function riode_wpb_slider_layout_controls() {
		return array(
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'slider_vertical_align',
				'heading'     => esc_html__( 'Vertical Align', 'riode-core' ),
				'description' => esc_html__( 'Choose vertical alignment of items. Choose from Top, Middle, Bottom, Stretch.', 'riode-core' ),
				'value'       => array(
					'top'         => array(
						'title' => esc_html__( 'Top', 'riode-core' ),
					),
					'middle'      => array(
						'title' => esc_html__( 'Middle', 'riode-core' ),
					),
					'bottom'      => array(
						'title' => esc_html__( 'Bottom', 'riode-core' ),
					),
					'same-height' => array(
						'title' => esc_html__( 'Stretch', 'riode-core' ),
					),
				),
				'dependency'  => array(
					'element' => 'layout_type',
					'value'   => 'slider',
				),
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_slider_general_controls' ) ) {
	function riode_wpb_slider_general_controls() {
		global $riode_animations;

		if ( empty( $riode_animations ) ) {
			$riode_animations = array();
		}

		return array(
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Full Height', 'riode-core' ),
				'param_name'  => 'fullheight',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Set to use 100vh slider.', 'riode-core' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Autoplay', 'riode-core' ),
				'param_name'  => 'autoplay',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Enable autoslide of carousel items.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Autoplay Timeout', 'riode-core' ),
				'param_name'  => 'autoplay_timeout',
				'std'         => 5000,
				'description' => esc_html__( "Change carousel item's autoplay duration.", 'riode-core' ),
				'dependency'  => array(
					'element' => 'autoplay',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Infinite Loop', 'riode-core' ),
				'param_name'  => 'loop',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Enable carousel items to slide infinitely.', 'riode-core' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Pause on Hover', 'riode-core' ),
				'param_name'  => 'pause_onhover',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Pause autoslide of carousel items when mouse is over.', 'riode-core' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Auto Height', 'riode-core' ),
				'param_name'  => 'autoheight',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Makes each slides have their own height. Slides could have different height.', 'riode-core' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Center Mode', 'riode-core' ),
				'param_name'  => 'center_mode',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Center item will be aligned center for both even and odd index. It works well in slider where loop option is enabled.', 'riode-core' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Disable Drag', 'riode-core' ),
				'param_name'  => 'prevent_drag',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Disable mouse drag effect of carousel items.', 'riode-core' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Animation In', 'riode-core' ),
				'param_name'  => 'animation_in',
				'description' => esc_html__( 'Choose sliding animation when next slides become visible.', 'riode-core' ),
				'value'       => empty( $riode_animations['sliderIn'] ) ? array() : array_flip( $riode_animations['sliderIn'] ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Animation Out', 'riode-core' ),
				'param_name'  => 'animation_out',
				'description' => esc_html__( 'Choose sliding animation when previous slides become invisible.', 'riode-core' ),
				'value'       => empty( $riode_animations ) ? array() : array_flip( $riode_animations['sliderOut'] ),
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_slider_nav_controls' ) ) {
	function riode_wpb_slider_nav_controls() {
		$left  = is_rtl() ? 'right' : 'left';
		$right = is_rtl() ? 'left' : 'right';

		return array(
			array(
				'type'        => 'riode_button_group',
				'heading'     => esc_html__( 'Show Nav', 'riode-core' ),
				'param_name'  => 'show_nav',
				'description' => esc_html__( 'Determine whether to show/hide slider navigations.', 'riode-core' ),
				'responsive'  => true,
				'value'       => array(
					''    => array(
						'title' => esc_html__( 'Hide', 'riode-core' ),
					),
					'yes' => array(
						'title' => esc_html__( 'Show', 'riode-core' ),
					),
				),
				'std'         => '',
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Nav Auto Hide', 'riode-core' ),
				'param_name'  => 'nav_hide',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Hides slider navs automatically and show them only if mouse is over.', 'riode-core' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Nav Type', 'riode-core' ),
				'param_name'  => 'nav_type',
				'description' => esc_html__( 'Choose from icon presets of slider nav. Choose from Default, Simple, Simple 2, Circle, Full.', 'riode-core' ),
				'std'         => 'default',
				'value'       => array(
					esc_html__( 'Default', 'riode-core' ) => 'default',
					esc_html__( 'Simple', 'riode-core' )  => 'simple',
					esc_html__( 'Simple2', 'riode-core' ) => 'simple2',
					esc_html__( 'Circle', 'riode-core' )  => 'circle',
					esc_html__( 'Full', 'riode-core' )    => 'full',
				),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Nav Position', 'riode-core' ),
				'param_name'  => 'nav_pos',
				'description' => esc_html__( 'Choose position of slider navs. Choose from Inner, Outer, Top, Custom.', 'riode-core' ),
				'std'         => 'outer',
				'value'       => array(
					esc_html__( 'Inner', 'riode-core' )  => 'inner',
					esc_html__( 'Outer', 'riode-core' )  => 'outer',
					esc_html__( 'Top', 'riode-core' )    => 'top',
					esc_html__( 'Custom', 'riode-core' ) => 'custom',
				),
				'dependency'  => array(
					'element'            => 'nav_type',
					'value_not_equal_to' => 'full',
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Nav Horizontal Position', 'riode-core' ),
				'description' => esc_html__( 'Controls horizontal position of slider navs when nav type is Custom.', 'riode-core' ),
				'param_name'  => 'nav_h_position',
				'responsive'  => true,
				'units'       => array(
					'px',
					'%',
				),
				'dependency'  => array(
					'element' => 'nav_pos',
					'value'   => array( 'top', 'custom' ),
				),
				'selectors'   => array(
					'{{WRAPPER}} .owl-nav .owl-prev'    => "{$left}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .owl-nav .owl-next'    => "{$right}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .owl-nav-top .owl-nav' => "{$right}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Nav Vertical Position', 'riode-core' ),
				'param_name'  => 'nav_v_position',
				'description' => esc_html__( 'Controls vertical position of slider navs when nav type is Custom.', 'riode-core' ),
				'responsive'  => true,
				'units'       => array(
					'px',
					'%',
				),
				'dependency'  => array(
					'element' => 'nav_pos',
					'value'   => array( 'top', 'custom' ),
				),
				'selectors'   => array(
					'{{WRAPPER}} .owl-carousel .owl-nav > *, {{WRAPPER}} .owl-nav-top .owl-nav' => 'top: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Nav Size', 'riode-core' ),
				'param_name'  => 'slider_nav_size',
				'description' => esc_html__( 'Controls size of slider navs.', 'riode-core' ),
				'responsive'  => true,
				'units'       => array(
					'px',
					'%',
					'rem',
				),
				'selectors'   => array(
					'{{WRAPPER}} .owl-carousel .owl-nav button' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'        => 'riode_color_group',
				'heading'     => esc_html__( 'Colors', 'riode-core' ),
				'description' => esc_html__( 'Choose color, background color, border color of slider navs for normal, hover, disabled status.', 'riode-core' ),
				'param_name'  => 'nav_colors',
				'selectors'   => array(
					'normal'   => '{{WRAPPER}} .owl-carousel .owl-nav button',
					'hover'    => '{{WRAPPER}} .owl-carousel .owl-nav button:not(.disabled):hover',
					'disabled' => '{{WRAPPER}} .owl-carousel .owl-nav button.disabled',
				),
				'choices'     => array( 'color', 'background-color', 'border-color' ),
			),
		);
	}
}

if ( ! function_exists( 'riode_wpb_slider_dots_controls' ) ) {
	function riode_wpb_slider_dots_controls( $imagedot = false ) {
		$options = array();

		$options[] = array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Show Dots', 'riode-core' ),
			'param_name'  => 'show_dots',
			'description' => esc_html__( 'Determine whether to show/hide slider dots.', 'riode-core' ),
			'responsive'  => true,
			'value'       => array(
				''    => array(
					'title' => esc_html__( 'Hide', 'riode-core' ),
				),
				'yes' => array(
					'title' => esc_html__( 'Show', 'riode-core' ),
				),
			),
			'std'         => '',
		);

		if ( $imagedot ) {
			$options[] = array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Choose your dots type', 'riode-core' ),
				'param_name'  => 'dots_kind',
				'description' => esc_html__( 'Choose what you are going to use for slider dots. Choose from Dots, Images.', 'riode-core' ),
				'value'       => array(
					esc_html__( 'Default', 'riode-core' ) => 'default',
					esc_html__( 'Image dots', 'riode-core' ) => 'thumb',
				),
				'std'         => 'default',
			);
			$options[] = array(
				'type'        => 'attach_images',
				'heading'     => esc_html__( 'Add Thumbnails', 'js_composer' ),
				'param_name'  => 'thumbs',
				'description' => esc_html__( 'Choose thumbnail images which represent each slides.', 'riode-core' ),
				'dependency'  => array(
					'element' => 'dots_kind',
					'value'   => 'thumb',
				),
			);
			$options[] = array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Enable Vertical Dots', 'riode-core' ),
				'param_name'  => 'vertical_dots',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__( 'Shows dots vertically not horizontally.', 'riode-core' ),
				'dependency'  => array(
					'element' => 'dots_kind',
					'value'   => 'thumb',
				),
			);
		}

		$options[] = array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Dots Skin', 'riode-core' ),
			'param_name'  => 'dots_type',
			'description' => esc_html__( 'Choose slider dots color skin. Choose from Default, White, Grey, Dark.', 'riode-core' ),
			'std'         => 'primary',
			'value'       => array(
				'primary' => array(
					'title' => esc_html__( 'Primary', 'riode-core' ),
					'color' => 'var(--rio-primary-color, #27c)',
				),
				'white'   => array(
					'title' => esc_html__( 'White', 'riode-core' ),
					'color' => '#fff',
				),
				'grey'    => array(
					'title' => esc_html__( 'Grey', 'riode-core' ),
					'color' => 'var(--rio-light-color, #ccc)',
				),
				'dark'    => array(
					'title' => esc_html__( 'Dark', 'riode-core' ),
					'color' => 'var(--rio-dark-color, #222)',
				),
			),
			'dependency'  => array(
				'element'            => 'dots_kind',
				'value_not_equal_to' => 'thumb',
			),
		);
		$options[] = array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Dots Position', 'riode-core' ),
			'param_name'  => 'dots_pos',
			'std'         => 'outer',
			'description' => esc_html__( 'Choose position of slider dots and image dots. Choose from Inner, Outer, Close Outer, Custom.', 'riode-core' ),
			'value'       => array(
				esc_html__( 'Inner', 'riode-core' )       => 'inner',
				esc_html__( 'Outer', 'riode-core' )       => 'outer',
				esc_html__( 'Close Outer', 'riode-core' ) => 'close',
				esc_html__( 'Custom', 'riode-core' )      => 'custom',
			),
		);
		$options[] = array(
			'type'        => 'riode_number',
			'heading'     => __( 'Dots Vertical Position', 'riode-core' ),
			'param_name'  => 'dots_v_position',
			'responsive'  => true,
			'description' => esc_html__( 'Controls vertical position of slider dots and image dots.', 'riode-core' ),
			'units'       => array(
				'px',
				'%',
			),
			'dependency'  => array(
				'element' => 'dots_pos',
				'value'   => 'custom',
			),
			'selectors'   => array(
				'{{WRAPPER}} .owl-dots, {{WRAPPER}} .slider-thumb-dots' => 'position: absolute; bottom: {{VALUE}}{{UNIT}};',
			),
		);
		$options[] = array(
			'type'        => 'riode_number',
			'heading'     => __( 'Dots Horizontal Position', 'riode-core' ),
			'description' => esc_html__( 'Controls horizontal position of slider dots and image dots.', 'riode-core' ),
			'param_name'  => 'dots_h_position',
			'responsive'  => true,
			'units'       => array(
				'px',
				'%',
			),
			'dependency'  => array(
				'element' => 'dots_pos',
				'value'   => 'custom',
			),
			'selectors'   => array(
				'{{WRAPPER}} .owl-dots, {{WRAPPER}} .slider-thumb-dots' => 'position: absolute; left: {{VALUE}}{{UNIT}}; transform: translateX(-50%);',
			),
		);
		$options[] = array(
			'type'        => 'riode_number',
			'heading'     => __( 'Dots Size', 'riode-core' ),
			'param_name'  => 'slider_dots_size',
			'description' => esc_html__( 'Controls size of slider dots.', 'riode-core' ),
			'responsive'  => true,
			'units'       => array(
				'px',
				'%',
				'rem',
			),
			'selectors'   => array(
				'{{WRAPPER}} .owl-dots .owl-dot span'     => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .owl-dots .owl-dot.active span' => 'width: calc({{VALUE}}{{UNIT}} * 2.25); height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .slider-thumb-dots .owl-dot' => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .owl-dot-close ~ .slider-thumb-dots' => 'margin-top: calc(-{{VALUE}}{{UNIT}} / 2);',
			),
		);

		if ( $imagedot ) {
			$options[] = array(
				'type'        => 'riode_number',
				'heading'     => __( 'Dots Spacing', 'riode-core' ),
				'param_name'  => 'dots_thumb_spacing',
				'responsive'  => true,
				'description' => esc_html__( 'Controls gap space between image thumbnail dots.', 'riode-core' ),
				'units'       => array(
					'px',
					'%',
					'rem',
				),
				'selectors'   => array(
					'{{WRAPPER}} .slider-thumb-dots .owl-dot' => 'margin-right: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .vertical-dots + .slider-thumb-dots .owl-dot' => 'margin-bottom: {{VALUE}}{{UNIT}}; margin-right: 0;',
				),
				'dependency'  => array(
					'element' => 'dots_kind',
					'value'   => 'thumb',
				),
			);
			$options[] = array(
				'type'        => 'riode_color_group',
				'heading'     => esc_html__( 'Colors', 'riode-core' ),
				'description' => esc_html__( 'Choose color, background color, border color of image dots for normal, hover, disabled status.', 'riode-core' ),
				'param_name'  => 'thumb_colors',
				'selectors'   => array(
					'normal' => '{{WRAPPER}} .slider-thumb-dots .owl-dot',
					'hover'  => '{{WRAPPER}} .slider-thumb-dots .owl-dot:hover',
					'active' => '{{WRAPPER}} .slider-thumb-dots .owl-dot.active',
				),
				'choices'     => array( 'background-color' ),
				'dependency'  => array(
					'element' => 'dots_kind',
					'value'   => 'thumb',
				),
			);

			$options[] = array(
				'type'        => 'riode_number',
				'param_name'  => 'thumb_border_radius',
				'heading'     => esc_html__( 'Image Thumb Border Radius', 'riode-core' ),
				'description' => esc_html__( 'Controls border radius of image thumbnail dots.', 'riode-core' ),
				'dependency'  => array(
					'element' => 'dots_kind',
					'value'   => 'thumb',
				),
				'units'       => array(
					'px',
					'%',
				),
				'selectors'   => array(
					'{{WRAPPER}} .slider-thumb-dots .owl-dot, {{WRAPPER}} .slider-thumb-dots .owl-dot img' => 'border-radius: {{VALUE}}{{UNIT}};',
				),
			);

			$options[] = array(
				'type'        => 'riode_number',
				'param_name'  => 'thumb_border_width',
				'heading'     => esc_html__( 'Image Thumb Border Width', 'riode-core' ),
				'description' => esc_html__( 'Controls border width of image thumbnail dots.', 'riode-core' ),
				'dependency'  => array(
					'element' => 'dots_kind',
					'value'   => 'thumb',
				),
				'selectors'   => array(
					'{{WRAPPER}} .slider-thumb-dots .owl-dot' => 'padding: {{VALUE}}px;',
				),
			);
		}

		$options[] = array(
			'type'        => 'riode_color_group',
			'heading'     => esc_html__( 'Colors', 'riode-core' ),
			'param_name'  => 'dot_colors',
			'description' => esc_html__( 'Choose color, background color, border color of slider dots for normal, hover, disabled status.', 'riode-core' ),
			'selectors'   => array(
				'normal' => '{{WRAPPER}} .owl-dots .owl-dot span',
				'hover'  => '{{WRAPPER}} .owl-dots .owl-dot:hover span',
				'active' => '{{WRAPPER}} .owl-dots .owl-dot.active span',
			),
			'choices'     => array( 'background-color', 'border-color' ),
			'dependency'  => array(
				'element'            => 'dots_kind',
				'value_not_equal_to' => 'thumb',
			),
		);

		return $options;
	}
}
