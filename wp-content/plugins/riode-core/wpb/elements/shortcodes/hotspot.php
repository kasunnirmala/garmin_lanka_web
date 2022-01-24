<?php
/**
 * Riode Hotspot
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )       => array(
		array(
			'type'        => 'iconpicker',
			'param_name'  => 'icon',
			'heading'     => esc_html__( 'Icon', 'riode-core' ),
			'description' => esc_html__( 'Choose icon from icon library for hotspot on image.', 'riode-core' ),
			'std'         => 'd-icon-plus',
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'horizontal',
			'heading'     => esc_html__( 'Horizontal Position', 'riode-core' ),
			'description' => esc_html__( 'Controls horizontal position of hotspot on image.', 'riode-core' ),
			'units'       => array(
				'px',
				'vw',
				'%',
				'rem',
			),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}}' => 'left: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'vertical',
			'heading'     => esc_html__( 'Vertical Position', 'riode-core' ),
			'description' => esc_html__( 'Controls vertical position of hotspot on image.', 'riode-core' ),
			'units'       => array(
				'px',
				'vw',
				'%',
				'rem',
			),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}}' => 'top: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'effect',
			'heading'     => esc_html__( 'Hotspot Effect', 'riode-core' ),
			'description' => esc_html__( 'Choose effect of hotspot item.', 'riode-core' ),
			'value'       => array(
				esc_html__( 'None', 'riode-core' )    => '',
				esc_html__( 'Spread', 'riode-core' )  => 'type1',
				esc_html__( 'Twinkle', 'riode-core' ) => 'type2',
			),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Popup Content', 'riode-core' ),
			'description' => esc_html__( 'Choose popup information type that will be displayed when mouse is over hotspot.', 'riode-core' ),
			'param_name'  => 'type',
			'value'       => array(
				'html'    => array(
					'title' => esc_html__( 'HTML', 'riode-core' ),
				),
				'block'   => array(
					'title' => esc_html__( 'Block', 'riode-core' ),
				),
				'product' => array(
					'title' => esc_html__( 'Product', 'riode-core' ),
				),
				'image'   => array(
					'title' => esc_html__( 'Image', 'riode-core' ),
				),
			),
			'std'         => 'html',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea',
			'param_name'  => 'html',
			'heading'     => esc_html__( 'Custom Html', 'riode-core' ),
			'description' => esc_html__( 'Input Html Code that will be shown in hotspot popup.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'html',
			),
		),
		array(
			'type'        => 'autocomplete',
			'param_name'  => 'block',
			'heading'     => esc_html__( 'Block', 'riode-core' ),
			'description' => esc_html__( 'Choose block that will be shown in hotspot popupt.', 'riode-core' ),
			'settings'    => array(
				'multiple' => false,
				'sortable' => true,
			),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'block',
			),
		),
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Choose Image', 'riode-core' ),
			'description' => esc_html__( 'Choose image that will be shown in hotspot popupt.', 'riode-core' ),
			'param_name'  => 'image',
			'value'       => '',
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'image',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'image_size',
			'std'         => 'full',
			'heading'     => esc_html__( 'Image Size', 'riode-core' ),
			'description' => esc_html__( 'Choose image size of hotspot popup image. Choose from registered image sizes of WordPress and other plugins.', 'riode-core' ),
			'value'       => riode_get_image_sizes(),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'image',
			),
		),
		array(
			'type'        => 'autocomplete',
			'heading'     => __( 'Product', 'riode-core' ),
			'description' => esc_html__( 'Choose product that will be shown in hotspot popupt.', 'riode-core' ),
			'param_name'  => 'product',
			'settings'    => array(
				'multiple' => true,
				'sortable' => true,
			),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'product',
			),
		),
		array(
			'type'        => 'vc_link',
			'param_name'  => 'link',
			'heading'     => esc_html__( 'Link URL', 'riode-core' ),
			'description' => esc_html__( 'Input link url of hotspot where you will move to.', 'riode-core' ),
			'dependency'  => array(
				'element' => 'type',
				'value'   => array( 'html', 'block', 'image' ),
			),
		),
		array(
			'type'        => 'riode_button_group',
			'param_name'  => 'popup_position',
			'heading'     => esc_html__( 'Popup Position', 'riode-core' ),
			'description' => esc_html__( 'Determine where popup will be shown when mouse is over hotspot.', 'riode-core' ),
			'value'       => array(
				'none'   => array(
					'title' => esc_html__( 'Hide', 'riode-core' ),
				),
				'top'    => array(
					'title' => esc_html__( 'Top', 'riode-core' ),
				),
				'left'   => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'riode-core' ),
				),
			),
			'std'         => 'top',
		),
	),
	esc_html__( 'Hotspot Style', 'riode-core' ) => array(
		array(
			'type'        => 'riode_number',
			'param_name'  => 'size',
			'heading'     => esc_html__( 'Hotspot Size', 'riode-core' ),
			'description' => esc_html__( 'Controls hotspot size.', 'riode-core' ),
			'units'       => array(
				'px',
				'%',
				'rem',
			),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .hotspot' => 'width:{{VALUE}}{{UNIT}};height:{{VALUE}}{{UNIT}};line-height:{{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'icon_size',
			'heading'     => esc_html__( 'Icon Size', 'riode-core' ),
			'description' => esc_html__( 'Controls icon size in hotspot.', 'riode-core' ),
			'units'       => array(
				'px',
				'em',
			),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .hotspot i' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_dimension',
			'param_name'  => 'border_radius',
			'heading'     => esc_html__( 'Border Radius', 'riode-core' ),
			'description' => esc_html__( 'Controls border radius value of hotspot.', 'riode-core' ),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .hotspot, {{WRAPPER}} .hotspot-wrapper::before' => 'border-radius:{{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
			),
		),
		array(
			'type'        => 'riode_color_group',
			'heading'     => esc_html__( 'Colors', 'riode-core' ),
			'description' => esc_html__( 'Choose icon color and background color of hotspot on normal and hover event.', 'riode-core' ),
			'param_name'  => 'hotspot_colors',
			'selectors'   => array(
				'normal' => '{{WRAPPER}} .hotspot',
				'hover'  => '{{WRAPPER}}:hover .hotspot',
			),
			'choices'     => array( 'color', 'background-color' ),
		),
	),
	esc_html__( 'Popup Style', 'riode-core' )   => array(
		array(
			'type'        => 'riode_number',
			'param_name'  => 'popup_width',
			'description' => esc_html__( 'Controls width hotspot content popup.', 'riode-core' ),
			'heading'     => esc_html__( 'Popup Width', 'riode-core' ),
			'units'       => array(
				'px',
				'%',
				'rem',
			),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .tooltip' => 'width:{{VALUE}}{{UNIT}}; min-width:{{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'popup_h_pos',
			'description' => esc_html__( 'Controls horizontal position of hotspot popup.', 'riode-core' ),
			'heading'     => esc_html__( 'Horizontal Position', 'riode-core' ),
			'units'       => array(
				'px',
				'%',
				'rem',
			),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .tooltip' => 'left: {{VALUE}}{{UNIT}}; right: auto;',
			),
		),
		array(
			'type'        => 'riode_number',
			'param_name'  => 'popup_v_pos',
			'description' => esc_html__( 'Controls vertical position of hotspot popup.', 'riode-core' ),
			'heading'     => esc_html__( 'Vertical Position', 'riode-core' ),
			'units'       => array(
				'px',
				'%',
				'rem',
			),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .tooltip' => 'top: {{VALUE}}{{UNIT}}; bottom: auto;',
				'{{WRAPPER}} .hotspot-top-tooltip .hotspot::after, {{WRAPPER}} .hotspot-bottom-tooltip .hotspot::after' => 'height: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'        => 'riode_dimension',
			'param_name'  => 'popup_padding',
			'description' => esc_html__( 'Controls padding value of hotspot popup.', 'riode-core' ),
			'heading'     => esc_html__( 'Padding', 'riode-core' ),
			'responsive'  => true,
			'selectors'   => array(
				'{{WRAPPER}} .tooltip' => 'padding:{{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
			),
		),
		array(
			'type'        => 'colorpicker',
			'description' => esc_html__( 'Choose background color of hotspot popup.', 'riode-core' ),
			'heading'     => esc_html__( 'Background Color', 'riode-core' ),
			'param_name'  => 'popup_bg',
			'selectors'   => array(
				'{{WRAPPER}} .tooltip' => 'background-color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Hotspot', 'riode-core' ),
		'base'            => 'wpb_riode_hotspot',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_hotspot',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Shows information of specific targets', 'riode-core' ),
		'params'          => $params,
	)
);

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_hotspot_product_callback', 'riode_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_hotspot_product_render', 'riode_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_riode_hotspot_product_param_value', 'riode_wpb_shortcode_product_id_param_value', 10, 4 );

// Block Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_hotspot_block_callback', 'riode_wpb_shortcode_block_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_hotspot_block_render', 'riode_wpb_shortcode_block_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Hotspot extends WPBakeryShortCode {
	}
}
