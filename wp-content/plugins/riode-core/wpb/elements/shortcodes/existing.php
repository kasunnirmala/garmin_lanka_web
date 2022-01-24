<?php
add_action( 'vc_after_init', 'riode_wpb_enhance_section' );
add_action( 'vc_after_init', 'riode_wpb_enhance_row' );

if ( ! function_exists( 'riode_wpb_enhance_section' ) ) {
	function riode_wpb_enhance_section() {
		// Animation
		global $riode_animations;

		$animations = array( 'none' => esc_html__( 'None', 'riode-core' ) );

		if ( isset( $riode_animations['sliderIn'] ) && isset( $riode_animations['sliderOut'] ) && isset( $riode_animations['appear'] ) ) {
			$animations = array_merge( $animations, $riode_animations['sliderIn'], $riode_animations['sliderOut'], $riode_animations['appear']['Riode Fading'], $riode_animations['appear']['Blur'] );
		}

		$options = array(
				array(
					'type'        => 'riode_button_group',
					'heading'     => esc_html__( 'Content Width', 'riode-core' ),
					'param_name'  => 'wrap_container',
					'value'       => array(
						'container'       => array(
							'title' => esc_html__( 'Boxed', 'riode-core' ),
						),
						'container-fluid' => array(
							'title' => esc_html__( 'Fluid', 'riode-core' ),
						),
						'none'            => array(
							'title' => esc_html__( 'Full Width', 'riode-core' ),
						),
					),
					'std'         => 'none',
				'group'       => esc_html__( 'Riode Options', 'riode-core' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'HTML Tag', 'riode-core' ),
					'param_name'  => 'section_tag',
					'value'       => array(
						esc_html__( 'Default', 'riode-core' ) => 'default',
						esc_html__( 'div', 'riode-core' )  => 'div',
						esc_html__( 'header', 'riode-core' ) => 'header',
						esc_html__( 'footer', 'riode-core' ) => 'footer',
						esc_html__( 'main', 'riode-core' ) => 'main',
						esc_html__( 'article', 'riode-core' ) => 'article',
						esc_html__( 'section', 'riode-core' ) => 'section',
						esc_html__( 'aside', 'riode-core' ) => 'aside',
						esc_html__( 'nav', 'riode-core' )  => 'nav',
					),
				'group'       => esc_html__( 'Riode Options', 'riode-core' ),
					'std'         => 'default',
					'admin_label' => true,
				),
				array(
					'type'       => 'riode_button_group',
					'heading'    => esc_html__( 'Enable Sticky', 'riode-core' ),
					'param_name' => 'sticky_allow',
					'responsive' => true,
					'value'      => array(
						''    => array(
							'title' => esc_html__( 'Hide', 'riode-core' ),
						),
						'yes' => array(
							'title' => esc_html__( 'Show', 'riode-core' ),
						),
					),
					'std'        => '',
				'group'      => esc_html__( 'Sticky Options', 'riode-core' ),
				),
				array(
					'type'       => 'riode_number',
					'heading'    => esc_html__( 'Sticky padding on sticky', 'riode-core' ),
					'param_name' => 'sticky_padding',
					'units'      => array(
						'px',
						'rem',
						'em',
					),
				'group'      => esc_html__( 'Sticky Options', 'riode-core' ),
					'selectors'  => array(
						'{{WRAPPER}}.sticky-content.fixed' => 'padding-top: {{VALUE}}{{UNIT}} !important;padding-bottom: {{VALUE}}{{UNIT}} !important;',
					),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Sticky Background Color', 'riode-core' ),
					'param_name' => 'sticky_bg',
				'group'      => esc_html__( 'Sticky Options', 'riode-core' ),
					'selectors'  => array(
						'{{WRAPPER}}.sticky-content.fixed' => 'background-color: {{VALUE}} !important;',
					),
				),
		);

		$shapes        = riode_get_shape_dividers();
		$shape_options = array( esc_html( 'None', 'riode-core' ) => 'none' );
		foreach ( $shapes as $key => $value ) {
			$shape_options[ $value['title'] ] = $key;
		}

		foreach ( array( 'top', 'bottom' ) as $side ) {
			$options = array_merge(
				$options,
			array(
				array(
					'type'       => 'dropdown',
						'heading'     => esc_html__( 'Divider Type', 'riode-core' ),
						'description' => esc_html__( 'Select the type of the shape divider', 'riode-core' ),
						'param_name'  => $side . '_divider_type',
						'value'       => $shape_options,
					'std'        => 'none',
						'admin_label' => true,
						'group'       => sprintf( esc_html__( '%1$s Shape Divider', 'riode-core' ), ucfirst( $side ) ),
				),
				array(
						'type'        => 'textarea_raw_html',
						'heading'     => esc_html__( 'Custom Shape Divider', 'riode-core' ),
						'param_name'  => $side . '_divider_custom',
						// @codingStandardsIgnoreLine
						'value'       => base64_encode( '' ),
						'description' => esc_html__( 'Please writer your svg code.', 'riode-core' ),
						'dependency'  => array(
							'element' => $side . '_divider_type',
							'value'   => 'custom',
						),
						'group'       => sprintf( esc_html__( '%1$s Shape Divider', 'riode-core' ), ucfirst( $side ) ),
				),
				array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Color', 'riode-core' ),
						'param_name'  => $side . '_divider_color',
						'description' => esc_html__( 'Select fill color of svg.', 'riode-core' ),
						'std'         => '#fff',
						'dependency'  => array(
							'element'            => $side . '_divider_type',
							'value_not_equal_to' => 'none',
						),
						'selectors'  => array(
							'{{WRAPPER}} > .wpb-shape-' . $side . ' svg' => 'fill: {{VALUE}};',
						),
						'group'       => sprintf( esc_html__( '%1$s Shape Divider', 'riode-core' ), ucfirst( $side ) ),
					),
					array(
						'type'        => 'riode_number',
						'heading'     => esc_html__( 'Width (%)', 'riode-core' ),
						'description' => esc_html__( 'Please input width of shape divider.', 'riode-core' ),
						'param_name'  => $side . '_divider_width',
						'responsive'  => true,
						'dependency'  => array(
							'element'            => $side . '_divider_type',
							'value_not_equal_to' => 'none',
						),
						'selectors'  => array(
							'{{WRAPPER}} > .wpb-shape-' . $side . ' svg' => 'width: calc({{VALUE}}% + 1.3px);',
						),
						'group'       => sprintf( esc_html__( '%1$s Shape Divider', 'riode-core' ), ucfirst( $side ) ),
					),
					array(
						'type'        => 'riode_number',
						'heading'     => esc_html__( 'Height (px)', 'riode-core' ),
						'description' => esc_html__( 'Please input height of shape divider.', 'riode-core' ),
						'param_name'  => $side . '_divider_height',
						'responsive'  => true,
						'dependency'  => array(
							'element'            => $side . '_divider_type',
							'value_not_equal_to' => 'none',
						),
						'selectors'  => array(
							'{{WRAPPER}} > .wpb-shape-' . $side . ' svg' => 'height: {{VALUE}}px;',
						),
						'group'       => sprintf( esc_html__( '%1$s Shape Divider', 'riode-core' ), ucfirst( $side ) ),
				),
			array(
						'type'        => 'riode_number',
						'heading'     => esc_html__( 'Shape Divider Position (%)', 'riode-core' ),
						'description' => esc_html__( 'Please input left position of shape divider.', 'riode-core' ),
						'param_name'  => $side . '_divider_position',
						'responsive'  => true,
						'dependency'  => array(
							'element'            => $side . '_divider_type',
							'value_not_equal_to' => 'none',
						),
						'selectors'  => array(
							'{{WRAPPER}} > .wpb-shape-' . $side . ' svg' => 'left: {{VALUE}}%;',
						),
						'group'       => sprintf( esc_html__( '%1$s Shape Divider', 'riode-core' ), ucfirst( $side ) ),
					),
				array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Flip', 'riode-core' ),
						'param_name'  => $side . '_divider_flip',
						'description' => esc_html__( 'Enable this option to flip Shape by X axis.', 'riode-core' ),
						'dependency'  => array(
							'element'            => $side . '_divider_type',
							'value_not_equal_to' => 'none',
						),
						'selectors'  => array(
							'{{WRAPPER}} > .wpb-shape-' . $side . ' svg' => 'transform: translateX(-50%) rotateY(180deg);',
						),
						'group'       => sprintf( esc_html__( '%1$s Shape Divider', 'riode-core' ), ucfirst( $side ) ),
				),
				array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Invert', 'riode-core' ),
						'param_name'  => $side . '_divider_invert',
						'description' => esc_html__( 'Enable this option to rotate shape divider inversly', 'riode-core' ),
						'dependency'  => array(
							'element'            => $side . '_divider_type',
							'value_not_equal_to' => 'none',
						),
						'selectors'  => array(
							'{{WRAPPER}} > .wpb-shape-' . $side => 'transform: rotate(180deg);',
						),
						'group'       => sprintf( esc_html__( '%1$s Shape Divider', 'riode-core' ), ucfirst( $side ) ),
				),
				array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Bring To Front', 'riode-core' ),
						'param_name'  => $side . '_divider_front',
						'description' => esc_html__( 'Show shape divider above of all others.', 'riode-core' ),
						'dependency'  => array(
							'element'            => $side . '_divider_type',
							'value_not_equal_to' => 'none',
						),
						'selectors'  => array(
							'{{WRAPPER}} > .wpb-shape-divider' => 'z-index: 2',
						),
						'group'       => sprintf( esc_html__( '%1$s Shape Divider', 'riode-core' ), ucfirst( $side ) ),
				),
			)
		);
		}

		// Customize Section
		vc_add_params( 'vc_section', $options );

		vc_map_update( 'vc_section', 'description', esc_html__( 'Group multiple rows in section with theme effects like container, sticky and shape dividers.', 'riode-core' ) );
	}
}

if ( ! function_exists( 'riode_wpb_enhance_row' ) ) {
	function riode_wpb_enhance_row() {
		vc_update_shortcode_param(
			'vc_row',
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Columns gap', 'js_composer' ),
				'param_name'  => 'gap',
				'value'       => array(
					esc_html__( 'Default', 'riode-core' ) => 'default',
					'0px'                                 => '0',
					'1px'                                 => '1',
					'2px'                                 => '2',
					'3px'                                 => '3',
					'4px'                                 => '4',
					'5px'                                 => '5',
					'10px'                                => '10',
					'15px'                                => '15',
					'20px'                                => '20',
					'25px'                                => '25',
					'30px'                                => '30',
					'35px'                                => '35',
				),
				'std'         => 'default',
				'description' => esc_html__( 'Select gap between columns in row.', 'js_composer' ),
			)
		);
		vc_update_shortcode_param(
			'vc_row_inner',
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Columns gap', 'js_composer' ),
				'param_name'  => 'gap',
				'value'       => array(
					esc_html__( 'Default', 'riode-core' ) => 'default',
					'0px'                                 => '0',
					'1px'                                 => '1',
					'2px'                                 => '2',
					'3px'                                 => '3',
					'4px'                                 => '4',
					'5px'                                 => '5',
					'10px'                                => '10',
					'15px'                                => '15',
					'20px'                                => '20',
					'25px'                                => '25',
					'30px'                                => '30',
					'35px'                                => '35',
				),
				'std'         => 'default',
				'description' => esc_html__( 'Select gap between columns in row.', 'js_composer' ),
			)
		);
	}
}
