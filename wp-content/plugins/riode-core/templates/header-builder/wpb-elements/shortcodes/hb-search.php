<?php
/**
 * Header Search Button
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )           => array(
		array(
			'type'         => 'riode_button_group',
			'heading'      => esc_html__( 'Search Type', 'riode-core' ),
			'param_name'   => 'type',
			'std'          => 'hs-toggle',
			'button_width' => 200,
			'value'        => array(
				'hs-toggle'     => array(
					'title' => esc_html__( 'Toggle Type', 'riode-core' ),
					'image' => RIODE_CORE_URI . '/assets/images/header-search/search1.jpg',
				),
				'hs-simple'     => array(
					'title' => esc_html__( 'Simple Type', 'riode-core' ),
					'image' => RIODE_CORE_URI . '/assets/images/header-search/search2.jpg',
				),
				'hs-expanded'   => array(
					'title' => esc_html__( 'Expanded Type', 'riode-core' ),
					'image' => RIODE_CORE_URI . '/assets/images/header-search/search3.jpg',
				),
				'hs-flat'       => array(
					'title' => esc_html__( 'Flat Type', 'riode-core' ),
					'image' => RIODE_CORE_URI . '/assets/images/header-search/search4.jpg',
				),
				'hs-fullscreen' => array(
					'title' => esc_html__( 'Fullscreen Type', 'riode-core' ),
					'image' => RIODE_CORE_URI . '/assets/images/header-search/search5.jpg',
				),
			),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Search Label', 'riode-core' ),
			'param_name' => 'label',
			'std'        => '',
			'dependency' => array(
				'element' => 'type',
				'value'   => array( 'hs-toggle', 'hs-fullscreen' ),
			),
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Border Type', 'riode-core' ),
			'param_name' => 'border_type',
			'std'        => 'rect',
			'dependency' => array(
				'element'            => 'type',
				'value_not_equal_to' => 'hs-flat',
			),
			'value'      => array(
				'rect'    => array(
					'title' => esc_html__( 'Rectangle', 'riode-core' ),
				),
				'rounded' => array(
					'title' => esc_html__( 'Rounded', 'riode-core' ),
				),
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Search By Category', 'riode-core' ),
			'description' => esc_html__( 'Show category select box of search post types. If search type is all, post categories will be shown.', 'riode-core' ),
			'param_name'  => 'category',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => array( 'hs-toggle', 'hs-expanded', 'hs-fullscreen' ),
			),
			'std'         => 'yes',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Load More', 'riode-core' ),
			'param_name' => 'fullscreen_type',
			'value'      => array(
				esc_html__( 'No', 'riode-core' )        => 'fs-default',
				esc_html__( 'By button', 'riode-core' ) => 'fs-loadmore',
				esc_html__( 'By scroll', 'riode-core' ) => 'fs-infinite',
			),
			'std'        => 'fs-default',
			'dependency' => array(
				'element' => 'type',
				'value'   => array( 'hs-fullscreen' ),
			),
		),
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Fullscreen Search Style', 'riode-core' ),
			'param_name' => 'fullscreen_style',
			'value'      => array(
				'light' => array(
					'title' => esc_html__( 'Light', 'riode-core' ),
				),
				'dark'  => array(
					'title' => esc_html__( 'Dark', 'riode-core' ),
				),
			),
			'std'        => 'light',
			'dependency' => array(
				'element' => 'type',
				'value'   => array( 'hs-fullscreen' ),
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Search Types', 'riode-core' ),
			'description' => esc_html__( 'Select post types to search', 'riode-core' ),
			'param_name'  => 'search_type',
			'value'       => array(
				''        => array(
					'title' => esc_html__( 'All', 'riode-core' ),
				),
				'product' => array(
					'title' => esc_html__( 'Product', 'riode-core' ),
				),
				'post'    => array(
					'title' => esc_html__( 'Post', 'riode-core' ),
				),
			),
			'std'         => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Search Form Placeholder', 'riode-core' ),
			'param_name' => 'placeholder',
			'std'        => 'Search your keyword...',
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Search Icon', 'riode-core' ),
			'param_name' => 'icon',
			'std'        => 'd-icon-search',
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Search Width', 'riode-core' ),
			'param_name' => 'search_width',
			'responsive' => true,
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .hs-expanded'              => 'width: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .hs-simple'                => 'width: {{VALUE}}{{UNIT}};',
				'{{WRAPPER}} .hs-toggle .input-wrapper' => 'min-width: {{VALUE}}{{UNIT}};',
			),
		),
	),
	esc_html__( 'Input Field Style', 'riode-core' ) => array(
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'input_typography',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper input.form-control, {{WRAPPER}} select',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Padding', 'riode-core' ),
			'param_name' => 'search_padding',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper input.form-control' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				'{{WRAPPER}} .search-wrapper select' => 'padding-right: {{RIGHT}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'riode-core' ),
			'param_name' => 'search_color',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper input.form-control' => 'color: {{VALUE}};',
				'{{WRAPPER}} .search-wrapper .select-box' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'riode-core' ),
			'param_name' => 'search_bg',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper input.form-control' => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .search-wrapper .select-box' => 'background-color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Width', 'riode-core' ),
			'param_name' => 'search_bd',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper input.form-control' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;margin-left:-{{LEFT}};',
				'{{WRAPPER}} .search-wrapper .select-box' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
			'param_name' => 'search_br',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper .select-box' => 'border-top-left-radius: {{TOP}};border-top-right-radius: 0;border-bottom-right-radius: 0;border-bottom-left-radius: {{LEFT}};',
				'{{WRAPPER}} .search-wrapper .select-box ~ .form-control' => 'border-top-left-radius: 0;border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: 0;',
				'{{WRAPPER}} .search-wrapper input.form-control' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color', 'riode-core' ),
			'param_name' => 'search_bd_color',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper input.form-control' => 'border-color: {{VALUE}};',
				'{{WRAPPER}} .search-wrapper .select-box' => 'border-color: {{VALUE}};',
			),
		),
	),
	esc_html__( 'Button Style', 'riode-core' )      => array(
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Padding', 'riode-core' ),
			'param_name' => 'btn_padding',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper .btn-search' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'btn_size',
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper .btn-search' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Width', 'riode-core' ),
			'param_name' => 'btn_bd_width',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper .btn-search' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};border-style: solid;',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
			'param_name' => 'btn_br',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper .btn-search' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}};border-bottom-right-radius: {{BOTTOM}};border-bottom-left-radius: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Colors', 'riode-core' ),
			'param_name' => 'btn_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .search-wrapper .btn-search',
				'hover'  => '{{WRAPPER}} .search-wrapper .btn-search:hover',
			),
			'choices'    => array( 'color', 'background-color', 'border-color' ),
		),
	),
	esc_html__( 'Toggle Type', 'riode-core' )       => array(
		array(
			'type'        => 'riode_heading',
			'label'       => esc_html__( 'Search Toggle', 'riode-core' ),
			'description' => esc_html__( 'Below options are working only if search type is toggle type', 'riode-core' ),
			'param_name'  => 'search_toggle_style_heading',
			'tag'         => 'h3',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'label_typography',
			'selectors'  => array(
				'{{WRAPPER}} .search-toggle span',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Padding', 'riode-core' ),
			'param_name' => 'toggle_padding',
			'selectors'  => array(
				'{{WRAPPER}} .search-toggle' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'toggle_icon_size',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}} .search-toggle i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Space', 'riode-core' ),
			'param_name' => 'toggle_icon_space',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'selectors'  => array(
				'{{WRAPPER}} .search-toggle i + span' => 'margin-left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_color_group',
			'heading'    => esc_html__( 'Icon Colors', 'riode-core' ),
			'param_name' => 'toggle_color',
			'selectors'  => array(
				'normal' => '{{WRAPPER}} .search-wrapper .search-toggle',
				'hover'  => '{{WRAPPER}} .search-wrapper:hover .search-toggle',
			),
			'choices'    => array( 'color', 'background-color' ),
		),
		array(
			'type'        => 'riode_heading',
			'label'       => esc_html__( 'Search Dropdown', 'riode-core' ),
			'description' => esc_html__( 'Below options are working only if search type is toggle type', 'riode-core' ),
			'tag'         => 'h3',
			'param_name'  => 'search_dropdown_style_heading',
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Position', 'riode-core' ),
			'param_name' => 'dropdown_position',
			'units'      => array(
				'px',
				'rem',
				'%',
			),
			'selectors'  => array(
				'{{WRAPPER}} .hs-toggle .input-wrapper' => 'left: {{VALUE}}{{UNIT}};right: auto;',
			),
		),
		array(
			'type'       => 'riode_dimension',
			'heading'    => esc_html__( 'Padding', 'riode-core' ),
			'param_name' => 'dropdown_padding',
			'selectors'  => array(
				'{{WRAPPER}} .search-wrapper.hs-toggle .input-wrapper' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'riode-core' ),
			'param_name' => 'dropdown_bg',
			'selectors'  => array(
				'{{WRAPPER}} .hs-toggle .input-wrapper' => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .search-wrapper.hs-toggle::after' => 'border-bottom-color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Header Search', 'riode-core' ),
		'base'            => 'wpb_riode_hb_search',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_hb_search',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Header', 'riode-core' ),
		'description'     => esc_html__( 'Search form in various types', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_HB_Search extends WPBakeryShortCode {
	}
}
