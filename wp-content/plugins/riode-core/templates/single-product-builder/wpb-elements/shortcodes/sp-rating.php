<?php
/**
 * Riode Single Product Rating
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'Style', 'riode-core' ) => array(
		array(
			'type'       => 'riode_button_group',
			'heading'    => esc_html__( 'Alignment', 'riode-core' ),
			'param_name' => 'sp_align',
			'value'      => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'        => 'flex-start',
			'selectors'  => array(
				'{{WRAPPER}} .woocommerce-product-rating' => 'justify-content: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'Star', 'riode-core' ),
			'param_name' => 'sp_rating',
			'tag'        => 'h3',
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'icon_size',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .star-rating' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Space', 'riode-core' ),
			'param_name' => 'icon_space',
			'units'      => array(
				'px',
				'rem',
				'em',
			),
			'responsive' => true,
			'selectors'  => array(
				'{{WRAPPER}} .star-rating' => 'letter-spacing: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Empty Color', 'riode-core' ),
			'param_name' => 'stars_color',
			'selectors'  => array(
				'{{WRAPPER}} .star-rating:before' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Full Color', 'riode-core' ),
			'param_name' => 'stars_unmarked_color',
			'selectors'  => array(
				'{{WRAPPER}} .star-rating span:after' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_heading',
			'label'      => esc_html__( 'Reviews', 'riode-core' ),
			'param_name' => 'sp_reviews_heading',
			'tag'        => 'h3',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Reviews Show', 'riode-core' ),
			'param_name' => 'sp_reviews',
			'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Typography', 'riode-core' ),
			'param_name' => 'sp_review_typo',
			'selectors'  => array(
				'{{WRAPPER}} .woocommerce-review-link',
			),
			'dependency' => array(
				'element' => 'sp_reviews',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'riode-core' ),
			'param_name' => 'stars_review_color',
			'selectors'  => array(
				'{{WRAPPER}} .woocommerce-review-link' => 'color: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'sp_reviews',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Hover Color', 'riode-core' ),
			'param_name' => 'stars_review_hover_color',
			'selectors'  => array(
				'{{WRAPPER}} .woocommerce-review-link:hover' => 'color: {{VALUE}};',
			),
			'dependency' => array(
				'element' => 'sp_reviews',
				'value'   => 'yes',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Single Product Rating', 'riode-core' ),
		'base'            => 'wpb_riode_sp_rating',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_sp_rating',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode Single Product', 'riode-core' ),
		'description'     => esc_html__( 'Product rating in single product', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Sp_Rating extends WPBakeryShortCode {

	}
}
