<?php
/**
 * Riode Testimonial
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )             => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Name', 'riode-core' ),
			'param_name'  => 'name',
			'std'         => 'John Doe',
			'description' => esc_html__( 'Type a commenter name.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Job', 'riode-core' ),
			'param_name'  => 'job',
			'std'         => 'Customer',
			'description' => esc_html__( 'Type a commenter job.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'riode-core' ),
			'param_name'  => 'title',
			'std'         => '',
			'description' => esc_html__( 'Type a title of your testimonial.', 'riode-core' ),
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Content', 'riode-core' ),
			'param_name'  => 'testimonial_content',
			'std'         => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.',
			'description' => esc_html__( 'Type a comment of your testimonial.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_number',
			'heading'     => esc_html__( 'Maximum Content Line', 'riode-core' ),
			'param_name'  => 'content_line',
			'std'         => '4',
			'selectors'   => array(
				'{{WRAPPER}} .testimonial .comment' => '-webkit-line-clamp: {{VALUE}};',
			),
			'description' => esc_html__( 'Type a number which means the line of comment.', 'riode-core' ),
		),
		esc_html__( 'Avatar', 'riode-core' ) => array(
			array(
				'type'        => 'attach_image',
				'heading'     => esc_html__( 'Choose Avatar', 'riode-core' ),
				'param_name'  => 'avatar',
				'value'       => '',
				'description' => esc_html__( 'Choose a certain image for your testimonial avatar.', 'riode-core' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Link', 'riode-core' ),
				'param_name'  => 'link',
				'description' => esc_html__( 'Type a certain URL for your testimonial.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Rating', 'riode-core' ),
				'param_name'  => 'rating',
				'std'         => '',
				'description' => esc_html__( 'Type a certain number from 1 to 5.', 'riode-core' ),
			),
		),
	),
	esc_html__( 'Layout and Position', 'riode-core' ) => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Type', 'riode-core' ),
			'param_name'  => 'testimonial_type',
			'value'       => array(
				esc_html__( 'Simple', 'riode-core' ) => 'simple',
				esc_html__( 'Boxed', 'riode-core' )  => 'boxed',
				esc_html__( 'Custom', 'riode-core' ) => 'custom',
			),
			'std'         => 'simple',
			'description' => esc_html__( 'Select a certain display type of your testimonial among Simple, Boxed and Custom types.', 'riode-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Inversed', 'riode-core' ),
			'param_name'  => 'testimonial_inverse',
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'         => 'no',
			'dependency'  => array(
				'element' => 'testimonial_type',
				'value'   => 'simple',
			),
			'description' => esc_html__( 'Enables to change the alignment of your testimonial only in the Simple type.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Avatar Position', 'riode-core' ),
			'param_name'  => 'avatar_pos',
			'value'       => array(
				esc_html__( 'Aside', 'riode-core' )       => 'aside',
				esc_html__( 'Top', 'riode-core' )         => 'top',
				esc_html__( 'Aside Commenter', 'riode-core' ) => 'aside_info',
				esc_html__( 'Top Commenter', 'riode-core' ) => 'top_info',
				esc_html__( 'After title', 'riode-core' ) => 'after_title',
			),
			'std'         => 'top',
			'dependency'  => array(
				'element' => 'testimonial_type',
				'value'   => 'custom',
			),
			'description' => esc_html__( 'Select the avatar position of your testimonial among Aside, Top, Aside Commenter, Top Commenter and After Title.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Commenter Position', 'riode-core' ),
			'param_name'  => 'commenter_pos',
			'value'       => array(
				esc_html__( 'Before Comment', 'riode-core' ) => 'before',
				esc_html__( 'After Comment', 'riode-core' )  => 'after',
			),
			'std'         => 'after',
			'dependency'  => array(
				'element' => 'testimonial_type',
				'value'   => 'custom',
			),
			'description' => esc_html__( 'Select the commenter position of your testimonial among Before Comment and After Comment.', 'riode-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Rating Position', 'riode-core' ),
			'param_name'  => 'rating_pos',
			'value'       => array(
				esc_html__( 'Before Comment', 'riode-core' ) => 'before',
				esc_html__( 'After Comment', 'riode-core' )  => 'after',
			),
			'std'         => 'before',
			'dependency'  => array(
				'element' => 'testimonial_type',
				'value'   => 'custom',
			),
			'description' => esc_html__( 'Select the rating position of your testimonial among Before Comment and After Comment.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Horizontal Alignment', 'riode-core' ),
			'param_name'  => 'v_align',
			'value'       => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'std'         => 'center',
			'selectors'   => array(
				'{{WRAPPER}} .testimonial-custom' => 'text-align: {{VALUE}};',
			),
			'dependency'  => array(
				'element' => 'testimonial_type',
				'value'   => 'custom',
			),
			'description' => esc_html__( 'Choose the certain horizontal alignment of your testimonial.', 'riode-core' ),
		),
		array(
			'type'        => 'riode_button_group',
			'heading'     => esc_html__( 'Vertial Alignment', 'riode-core' ),
			'param_name'  => 'h_align',
			'value'       => array(
				'flex-start' => array(
					'title' => esc_html__( 'Top', 'riode-core' ),
				),
				'center'     => array(
					'title' => esc_html__( 'Middle', 'riode-core' ),
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Bottom', 'riode-core' ),
				),
			),
			'std'         => 'center',
			'selectors'   => array(
				'{{WRAPPER}} .testimonial-custom, {{WRAPPER}} .testimonial-custom .commenter' => 'align-items: {{VALUE}};',
			),
			'dependency'  => array(
				'element' => 'testimonial_type',
				'value'   => 'custom',
			),
			'description' => esc_html__( 'Choose the certain vertical alignment of your testimonial.', 'riode-core' ),
		),
	),
	esc_html__( 'Style', 'riode-core' )               => array(
		esc_html__( 'Avatar', 'riode-core' )  => array(
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Size', 'riode-core' ),
				'param_name'  => 'avatar_size',
				'value'       => '',
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .testimonial .avatar img' => 'width: {{VALUE}}{{UNIT}}; height: {{VALUE}}{{UNIT}};',
					'{{WRAPPER}} .testimonial-simple .content::after' => "{$left}: calc(2rem + {{VALUE}}{{UNIT}} / 2 - 1rem);",
					'{{WRAPPER}} .avatar::before'          => 'font-size: {{VALUE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Avatar size.', 'riode-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'param_name'  => 'avatar_color',
				'selectors'   => array(
					'{{WRAPPER}} .avatar:before' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Avatar color.', 'riode-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Background Color', 'riode-core' ),
				'param_name'  => 'avatar_bg_color',
				'selectors'   => array(
					'{{WRAPPER}} .avatar' => 'background-color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Avatar backgrund color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Padding', 'riode-core' ),
				'param_name'  => 'avatar_padding',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .testimonial .avatar' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the Avatar padding.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Margin', 'riode-core' ),
				'param_name'  => 'avatar_margin',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .testimonial .avatar' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the Avatar margin.', 'riode-core' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Border Type', 'riode-core' ),
				'param_name'  => 'avatar_border',
				'value'       => array(
					esc_html__( 'None', 'riode-core' )   => 'none',
					esc_html__( 'Solid', 'riode-core' )  => 'solid',
					esc_html__( 'Double', 'riode-core' ) => 'double',
					esc_html__( 'Dotted', 'riode-core' ) => 'dotted',
					esc_html__( 'Dashed', 'riode-core' ) => 'dashed',
					esc_html__( 'Groove', 'riode-core' ) => 'groove',
				),
				'selectors'   => array(
					'{{WRAPPER}} .avatar' => 'border-style: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Avatar border style.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Border Width', 'riode-core' ),
				'param_name'  => 'sp_share_border_width',
				'responsive'  => true,
				'selectors'   => array(
					'{{WRAPPER}} .avatar' => 'border-top-width: {{TOP}};border-right-width: {{RIGHT}};border-bottom-width: {{BOTTOM}};border-left-width: {{LEFT}};',
				),
				'dependency'  => array(
					'element'            => 'avatar_border',
					'value_not_equal_to' => 'none',
				),
				'description' => esc_html__( 'Controls the Avatar border width.', 'riode-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Border Color', 'riode-core' ),
				'param_name'  => 'avatar_border_color',
				'selectors'   => array(
					'{{WRAPPER}} .avatar' => 'border-color: {{VALUE}};',
				),
				'dependency'  => array(
					'element'            => 'avatar_border',
					'value_not_equal_to' => 'none',
				),
				'description' => esc_html__( 'Controls the Avatar border color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Border Radius', 'riode-core' ),
				'param_name'  => 'avatar_border_radius',
				'responsive'  => true,
				'selectors'   => array(
					'{{WRAPPER}} .avatar > .social-icon' => 'border-top-left-radius: {{TOP}};border-top-right-radius: {{RIGHT}}; border-bottom-left-radius: {{BOTTOM}};border-top-right-radius: {{LEFT}};',
				),
				'dependency'  => array(
					'element'            => 'avatar_border',
					'value_not_equal_to' => 'none',
				),
				'description' => esc_html__( 'Controls the Avatar border radius.', 'riode-core' ),
			),
		),
		esc_html__( 'Content', 'riode-core' ) => array(
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Background Color', 'riode-core' ),
				'param_name'  => 'content_bg_color',
				'selectors'   => array(
					'{{WRAPPER}} .content, {{WRAPPER}} .content:after' => 'background-color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Content color only in the Simple type.', 'riode-core' ),
				'dependency'  => array(
					'element' => 'testimonial_type',
					'value'   => 'simple',
				),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Padding', 'riode-core' ),
				'param_name'  => 'content_padding',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .content' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the Content padding only in the Simple type.', 'riode-core' ),
				'dependency'  => array(
					'element' => 'testimonial_type',
					'value'   => 'simple',
				),
			),
			array(
				'type'       => 'riode_heading',
				'label'      => esc_html__( 'Only available in the Simple type.', 'riode-core' ),
				'param_name' => 'content_heading',
				'tag'        => 'h4',
				'class'      => 'riode-heading-control-class',
				'dependency' => array(
					'element'            => 'testimonial_type',
					'value_not_equal_to' => 'simple',
				),
			),
		),
		esc_html__( 'Title', 'riode-core' )   => array(
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'param_name'  => 'title_color',
				'selectors'   => array(
					'{{WRAPPER}} .comment-title' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Title color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Typography', 'riode-core' ),
				'param_name'  => 'title_typography',
				'selectors'   => array(
					'{{WRAPPER}} .comment-title',
				),
				'description' => esc_html__( 'Controls the Title typography.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Margin', 'riode-core' ),
				'param_name'  => 'title_margin',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .comment-title' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the Title margin.', 'riode-core' ),
			),
		),
		esc_html__( 'Comment', 'riode-core' ) => array(
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'param_name'  => 'comment_color',
				'selectors'   => array(
					'{{WRAPPER}} .comment' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Comment color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Typography', 'riode-core' ),
				'param_name'  => 'comment_typography',
				'selectors'   => array(
					'{{WRAPPER}} .testimonial .comment',
				),
				'description' => esc_html__( 'Controls the Comment typography.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Padding', 'riode-core' ),
				'param_name'  => 'comment_padding',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .comment' => 'padding-top: {{TOP}};padding-right: {{RIGHT}};padding-bottom: {{BOTTOM}};padding-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the Comment padding.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Margin', 'riode-core' ),
				'param_name'  => 'comment_margin',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .comment' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the Comment margin.', 'riode-core' ),
			),
		),
		esc_html__( 'Name', 'riode-core' )    => array(
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'param_name'  => 'name_color',
				'selectors'   => array(
					'{{WRAPPER}} .name' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Name color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Typography', 'riode-core' ),
				'param_name'  => 'name_typography',
				'selectors'   => array(
					'{{WRAPPER}} .name',
				),
				'description' => esc_html__( 'Controls the Name typography.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Margin', 'riode-core' ),
				'param_name'  => 'name_margin',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .name' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the Name margin.', 'riode-core' ),
			),
		),
		esc_html__( 'Job', 'riode-core' )     => array(
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'param_name'  => 'job_color',
				'selectors'   => array(
					'{{WRAPPER}} .job' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Job color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_typography',
				'heading'     => esc_html__( 'Typography', 'riode-core' ),
				'param_name'  => 'job_typography',
				'selectors'   => array(
					'{{WRAPPER}} .job',
				),
				'description' => esc_html__( 'Controls the Job typography.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Margin', 'riode-core' ),
				'param_name'  => 'job_margin',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .job' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the Job margin.', 'riode-core' ),
			),
		),
		esc_html__( 'Rating', 'riode-core' )  => array(
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Size', 'riode-core' ),
				'param_name'  => 'rating_size',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'value'       => '',
				'selectors'   => array(
					'{{WRAPPER}} .ratings-full' => 'font-size: {{VALUE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Rating size.', 'riode-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Color', 'riode-core' ),
				'param_name'  => 'rating_color',
				'selectors'   => array(
					'{{WRAPPER}} .ratings-full span::after' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Rating color.', 'riode-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Blank Color', 'riode-core' ),
				'param_name'  => 'rating_blank_color',
				'selectors'   => array(
					'{{WRAPPER}} .ratings-full::before' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Rating blank color.', 'riode-core' ),
			),
			array(
				'type'        => 'riode_dimension',
				'heading'     => esc_html__( 'Margin', 'riode-core' ),
				'param_name'  => 'rating_margin',
				'responsive'  => true,
				'units'       => array(
					'px',
					'rem',
					'em',
				),
				'selectors'   => array(
					'{{WRAPPER}} .ratings-container' => 'margin-top: {{TOP}};margin-right: {{RIGHT}};margin-bottom: {{BOTTOM}};margin-left: {{LEFT}};',
				),
				'description' => esc_html__( 'Controls the Rating margin.', 'riode-core' ),
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Testimonial', 'riode-core' ),
		'base'            => 'wpb_riode_testimonial',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_testimonial',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display testimonial with avatar', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Testimonial extends WPBakeryShortCode {

	}
}
