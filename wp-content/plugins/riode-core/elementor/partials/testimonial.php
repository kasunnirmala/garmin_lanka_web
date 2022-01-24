<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use ELementor\Group_Control_Background;
use ELementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

/**
 * Register elementor style controls for testimonials.
 */
function riode_elementor_testimonial_style_controls( $self ) {
	$self->start_controls_section(
		'avatar_style',
		array(
			'label' => esc_html__( 'Avatar', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'avatar_sz',
			array(
				'label'       => esc_html__( 'Size', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
					'em',
				),
				'range'       => array(
					'px' => array(
						'min'  => 1,
						'max'  => 300,
						'step' => 1,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .testimonial .avatar img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .testimonial-simple .content::after' => 'left: calc(2rem + {{SIZE}}{{UNIT}} / 2 - 1rem)',
					'.elementor-element-{{ID}} .avatar::before' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Avatar size.', 'riode-core' ),
			)
		);

		$self->add_control(
			'avatar_color',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .avatar::before' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Avatar color.', 'riode-core' ),
			)
		);

		$self->add_control(
			'avatar_bg_color',
			array(
				'label'       => esc_html__( 'Background Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .avatar' => 'background-color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Avatar backgrund color.', 'riode-core' ),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'        => 'avatar_shadow',
				'selector'    => '.elementor-element-{{ID}} .avatar',
				'description' => esc_html__( 'Controls the Avatar box shadow.', 'riode-core' ),
			)
		);

		$self->add_control(
			'avatar_divider',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$self->add_control(
			'avatar_pd',
			array(
				'label'       => esc_html__( 'Padding', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .testimonial .avatar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Avatar padding.', 'riode-core' ),
			)
		);

		$self->add_control(
			'avatar_mg',
			array(
				'label'       => esc_html__( 'Margin', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .testimonial .avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Avatar margin.', 'riode-core' ),
			)
		);

		$self->add_control(
			'avatar_border_heading',
			array(
				'label'       => esc_html__( 'Border Style', 'riode-core' ),
				'separator'   => 'before',
				'type'        => Controls_Manager::HEADING,
				'description' => esc_html__( 'Controls the Avatar border style.', 'riode-core' ),
			)
		);

		$self->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'avatar_border',
				'selector'    => '.elementor-element-{{ID}} .avatar',
				'description' => esc_html__( 'Controls the Avatar border width and color.', 'riode-core' ),
			)
		);

		$self->add_control(
			'avatar_br',
			array(
				'label'       => esc_html__( 'Border Radius', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'separator'   => 'before',
				'size_units'  => array( 'px', '%' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Avatar border radius.', 'riode-core' ),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'content_style',
		array(
			'label'     => esc_html__( 'Content', 'riode-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'testimonial_type' => 'simple',
			),
		)
	);

		$self->add_control(
			'content_bg_color',
			array(
				'label'       => esc_html__( 'Background Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .content, .elementor-element-{{ID}} .content:after' => 'background-color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Content background color only in the Simple type.', 'riode-core' ),
				'condition'   => array(
					'testimonial_type' => 'simple',
				),
			)
		);

		$self->add_control(
			'content_pd',
			array(
				'label'       => esc_html__( 'Padding', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Content padding only in the Simple type.', 'riode-core' ),
				'condition'   => array(
					'testimonial_type' => 'simple',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'title_style',
		array(
			'label' => esc_html__( 'Title', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'title_color',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .comment-title' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Title color.', 'riode-core' ),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Typography', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .comment-title',
				'description' => esc_html__( 'Controls the Title typography.', 'riode-core' ),
			)
		);

		$self->add_control(
			'title_mg',
			array(
				'label'       => esc_html__( 'Margin', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .comment-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Title margin.', 'riode-core' ),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'comment_style',
		array(
			'label' => esc_html__( 'Comment', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'comment_color',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .comment' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Comment color.', 'riode-core' ),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'        => 'comment_typography',
				'label'       => esc_html__( 'Comment', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .comment',
				'description' => esc_html__( 'Controls the Comment typography.', 'riode-core' ),
			)
		);

		$self->add_control(
			'comment_pd',
			array(
				'label'       => esc_html__( 'Padding', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .comment' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Comment padding.', 'riode-core' ),
			)
		);

		$self->add_control(
			'comment_mg',
			array(
				'label'       => esc_html__( 'Margin', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Comment margin.', 'riode-core' ),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'name_style',
		array(
			'label' => esc_html__( 'Name', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'name_color',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .name' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Name color.', 'riode-core' ),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'        => 'name_typography',
				'label'       => esc_html__( 'Name', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .name',
				'description' => esc_html__( 'Controls the Name typography.', 'riode-core' ),
			)
		);

		$self->add_control(
			'name_mg',
			array(
				'label'       => esc_html__( 'Margin', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Name margin.', 'riode-core' ),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'job_style',
		array(
			'label' => esc_html__( 'Job', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'job_color',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .job' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Job color.', 'riode-core' ),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'        => 'job_typography',
				'label'       => esc_html__( 'Job', 'riode-core' ),
				'selector'    => '.elementor-element-{{ID}} .job',
				'description' => esc_html__( 'Controls the Job typography.', 'riode-core' ),
			)
		);

		$self->add_control(
			'job_mg',
			array(
				'label'       => esc_html__( 'Margin', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Job margin.', 'riode-core' ),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'rating_style',
		array(
			'label' => esc_html__( 'Rating', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'rating_sz',
			array(
				'label'       => esc_html__( 'Size', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .ratings-full' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Rating size.', 'riode-core' ),
			)
		);

		$self->add_control(
			'rating_color',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .ratings-full span::after' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Rating color.', 'riode-core' ),
			)
		);

		$self->add_control(
			'rating_blank_color',
			array(
				'label'       => esc_html__( 'Blank Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .ratings-full::before' => 'color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the Rating blank color.', 'riode-core' ),
			)
		);

		$self->add_control(
			'rating_mg',
			array(
				'label'       => esc_html__( 'Margin', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .ratings-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the Rating margin.', 'riode-core' ),
			)
		);

	$self->end_controls_section();
}

/**
 * Register elementor content controls for testimonials
 */
function riode_elementor_testimonial_content_controls( $self ) {
	$self->add_control(
		'name',
		array(
			'label'       => esc_html__( 'Name', 'riode-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'John Doe',
			'description' => esc_html__( 'Type a commenter name.', 'riode-core' ),
		)
	);

	$self->add_control(
		'job',
		array(
			'label'       => esc_html__( 'Job', 'riode-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Customer',
			'description' => esc_html__( 'Type a commenter job.', 'riode-core' ),
		)
	);

	$self->add_control(
		'title',
		array(
			'label'       => esc_html__( 'Title', 'riode-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => '',
			'description' => esc_html__( 'Type a title of your testimonial.', 'riode-core' ),
		)
	);

	$self->add_control(
		'content',
		array(
			'label'       => esc_html__( 'Content', 'riode-core' ),
			'type'        => Controls_Manager::TEXTAREA,
			'rows'        => '10',
			'default'     => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.',
			'description' => esc_html__( 'Type a comment of your testimonial.', 'riode-core' ),
		)
	);

	$self->add_control(
		'avatar',
		array(
			'label'       => esc_html__( 'Choose Avatar', 'riode-core' ),
			'type'        => Controls_Manager::MEDIA,
			'description' => esc_html__( 'Choose a certain image for your testimonial avatar.', 'riode-core' ),
		)
	);

	$self->add_control(
		'link',
		array(
			'label'       => esc_html__( 'Link', 'riode-core' ),
			'type'        => Controls_Manager::URL,
			'placeholder' => esc_html__( 'https://your-link.com', 'riode-core' ),
			'description' => esc_html__( 'Type a certain URL for your testimonial.', 'riode-core' ),
		)
	);

	$self->add_group_control(
		Group_Control_Image_Size::get_type(),
		array(
			'name'        => 'avatar',
			'default'     => 'full',
			'separator'   => 'none',
			'description' => esc_html__( 'Select a certain image size fits your image.', 'riode-core' ),
		)
	);

	$self->add_control(
		'rating',
		array(
			'label'       => esc_html__( 'Rating', 'riode-core' ),
			'type'        => Controls_Manager::NUMBER,
			'min'         => 0,
			'max'         => 5,
			'step'        => 0.1,
			'default'     => '',
			'description' => esc_html__( 'Type a certain number from 1 to 5.', 'riode-core' ),
		)
	);
}

/**
 * Register elementor type controls for testimonials.
 */
function riode_elementor_testimonial_type_controls( $self ) {
	$self->add_control(
		'testimonial_type',
		array(
			'label'       => esc_html__( 'Testimonial Type', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'simple',
			'options'     => array(
				'simple' => esc_html__( 'Simple', 'riode-core' ),
				'boxed'  => esc_html__( 'Boxed', 'riode-core' ),
				'custom' => esc_html__( 'Custom', 'riode-core' ),
			),
			'description' => esc_html__( 'Select a certain display type of your testimonial among Simple, Boxed and Custom types.', 'riode-core' ),
		)
	);

	$self->add_control(
		'testimonial_inverse',
		array(
			'label'       => esc_html__( 'Inversed', 'riode-core' ),
			'type'        => Controls_Manager::SWITCHER,
			'condition'   => array(
				'testimonial_type' => 'simple',
			),
			'description' => esc_html__( 'Enables to change the alignment of your testimonial only in the Simple type.', 'riode-core' ),
		)
	);

	$self->add_control(
		'avatar_pos',
		[
			'label'       => esc_html__( 'Avatar Position', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'top',
			'options'     => [
				'aside'       => esc_html__( 'Aside', 'riode-core' ),
				'top'         => esc_html__( 'Top', 'riode-core' ),
				'aside_info'  => esc_html__( 'Aside Commenter', 'riode-core' ),
				'top_info'    => esc_html__( 'Top Commenter', 'riode-core' ),
				'after_title' => esc_html__( 'After Title', 'riode-core' ),
			],
			'condition'   => array(
				'testimonial_type' => 'custom',
			),
			'description' => esc_html__( 'Select the avatar position of your testimonial among Aside, Top, Aside Commenter, Top Commenter and After Title.', 'riode-core' ),
		]
	);

	$self->add_control(
		'commenter_pos',
		[
			'label'       => esc_html__( 'Commenter Position', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'after',
			'options'     => [
				'before' => esc_html__( 'Before Comment', 'riode-core' ),
				'after'  => esc_html__( 'After Comment', 'riode-core' ),
			],
			'condition'   => array(
				'testimonial_type' => 'custom',
			),
			'description' => esc_html__( 'Select the commenter position of your testimonial among Before Comment and After Comment.', 'riode-core' ),
		]
	);

	$self->add_control(
		'rating_pos',
		[
			'label'       => esc_html__( 'Rating Position', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'before',
			'options'     => [
				'before' => esc_html__( 'Before Comment', 'riode-core' ),
				'after'  => esc_html__( 'After Comment', 'riode-core' ),
			],
			'condition'   => array(
				'testimonial_type' => 'custom',
			),
			'description' => esc_html__( 'Select the rating position of your testimonial among Before Comment and After Comment.', 'riode-core' ),
		]
	);

	$self->add_control(
		'v_align',
		[
			'label'       => esc_html__( 'Horizontal Alignment', 'riode-core' ),
			'type'        => Controls_Manager::CHOOSE,
			'default'     => 'center',
			'options'     => [
				'left'   => [
					'title' => esc_html__( 'Left', 'riode-core' ),
					'icon'  => 'eicon-text-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'riode-core' ),
					'icon'  => 'eicon-text-align-center',
				],
				'right'  => [
					'title' => esc_html__( 'Right', 'riode-core' ),
					'icon'  => 'eicon-text-align-right',
				],
			],
			'selectors'   => array(
				'.elementor-element-{{ID}} .testimonial' => 'text-align: {{VALUE}};',
			),
			'condition'   => array(
				'testimonial_type' => 'custom',
			),
			'description' => esc_html__( 'Choose the certain horizontal alignment of your testimonial.', 'riode-core' ),
		]
	);

	$self->add_control(
		'h_align',
		[
			'label'       => esc_html__( 'Vertical Alignment', 'riode-core' ),
			'type'        => Controls_Manager::CHOOSE,
			'default'     => 'center',
			'options'     => [
				'flex-start' => [
					'title' => esc_html__( 'Top', 'riode-core' ),
					'icon'  => 'eicon-v-align-top',
				],
				'center'     => [
					'title' => esc_html__( 'Middle', 'riode-core' ),
					'icon'  => 'eicon-v-align-middle',
				],
				'flex-end'   => [
					'title' => esc_html__( 'Bottom', 'riode-core' ),
					'icon'  => 'eicon-v-align-bottom',
				],
			],
			'description' => esc_html__( 'Choose the certain vertical alignment of your testimonial.', 'riode-core' ),
			'selectors'   => array(
				'.elementor-element-{{ID}} .testimonial' => 'align-items: {{VALUE}};',
				'.elementor-element-{{ID}} .commenter'   => 'align-items: {{VALUE}};',
			),
			'condition'   => array(
				'testimonial_type' => 'custom',
			),
		]
	);
}
