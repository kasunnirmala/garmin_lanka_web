<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Posts Widget
 *
 * Riode Widget to display posts.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

class Riode_Posts_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_posts';
	}

	public function get_title() {
		return esc_html__( 'Posts', 'riode-core' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'blog', 'article', 'posts', 'post', 'recent' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-posts';
	}

	public function get_script_depends() {
		$depends = array( 'owl-carousel', 'isotope-pkgd' );
		if ( riode_is_elementor_preview() ) {
			$depends[] = 'riode-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		global $riode_animations;

		$this->start_controls_section(
			'section_posts_selector',
			array(
				'label' => esc_html__( 'Posts Selector', 'riode-core' ),
			)
		);

			$this->add_control(
				'post_ids',
				array(
					'type'        => 'riode_ajaxselect2',
					'label'       => esc_html__( 'Post IDs', 'riode-core' ),
					'description' => esc_html__(
						'Choose post ids of specific posts to display.
					*Comma separated list of post ids only.',
						'riode-core'
					),
					'object_type' => 'post',
					'label_block' => true,
					'multiple'    => true,
				)
			);

			$this->add_control(
				'categories',
				array(
					'type'        => 'riode_ajaxselect2',
					'label'       => esc_html__( 'Category IDs or slugs', 'riode-core' ),
					'description' => esc_html__(
						'Choose post category ids of specific posts to display or choose slugs of them.
					*Comma separated list of category ids or slugs only.',
						'riode-core'
					),
					'object_type' => 'category',
					'label_block' => true,
					'multiple'    => true,
				)
			);

			$this->add_control(
				'count',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Posts Count', 'riode-core' ),
					'default'     => array(
						'size' => 6,
						'unit' => 'px',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'description' => esc_html__(
						'Select the number of posts to display.​',
						'riode-core'
					),
				)
			);

			$this->add_control(
				'orderby',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Order By', 'riode-core' ),
					'default'     => 'ID',
					'options'     => array(
						''              => esc_html__( 'Default', 'riode-core' ),
						'ID'            => esc_html__( 'ID', 'riode-core' ),
						'title'         => esc_html__( 'Title', 'riode-core' ),
						'date'          => esc_html__( 'Date', 'riode-core' ),
						'modified'      => esc_html__( 'Modified', 'riode-core' ),
						'author'        => esc_html__( 'Author', 'riode-core' ),
						'comment_count' => esc_html__( 'Comment count', 'riode-core' ),
					),
					'description' => esc_html__(
						'Select the specific approach to sort your posts.',
						'riode-core'
					),
				)
			);

			$this->add_control(
				'orderway',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Order Way', 'riode-core' ),
					'default'     => '',
					'options'     => array(
						''    => esc_html__( 'Descending', 'riode-core' ),
						'ASC' => esc_html__( 'Ascending', 'riode-core' ),
					),
					'description' => esc_html__(
						'Choose the specific approach to sort your posts.',
						'riode-core'
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_posts_layout',
			array(
				'label' => esc_html__( 'Posts Layout', 'riode-core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'       => esc_html__( 'Posts Layout', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'grid',
					'options'     => array(
						'grid'     => esc_html__( 'Grid', 'riode-core' ),
						'slider'   => esc_html__( 'Slider', 'riode-core' ),
						'creative' => esc_html__( 'Creative Grid', 'riode-core' ),
					),
					'description' => esc_html__(
						'Choose the specific layout to suit your need to display posts.',
						'riode-core'
					),
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'    => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
					'default' => 'medium',
				)
			);

			riode_elementor_grid_layout_controls( $this, 'layout_type' );

			riode_elementor_slider_layout_controls( $this, 'layout_type' );

			riode_el_creative_isotope_layout_controls( $this, 'layout_type', 'posts' );

			riode_elementor_loadmore_layout_controls( $this, 'layout_type' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_type',
			array(
				'label' => esc_html__( 'Post Type', 'riode-core' ),
			)
		);

			$this->add_control(
				'follow_theme_option',
				array(
					'label'       => esc_html__( 'Follow Theme Option', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'default'     => 'yes',
					'description' => esc_html__(
						'Determine the post type globally.​',
						'riode-core'
					),
				)
			);

			$this->add_control(
				'post_type',
				array(
					'label'       => esc_html__( 'Post Type', 'riode-core' ),
					'description' => esc_html__(
						'Select your specific post type to suit your need.​​',
						'riode-core'
					),
					'type'        => 'riode_image_choose',
					'width'       => 'full',
					'default'     => '',
					'options'     => array(
						''              => riode_get_customize_dir() . '/post/default.jpg',
						'list'          => riode_get_customize_dir() . '/post/list.jpg',
						'mask'          => riode_get_customize_dir() . '/post/mask.jpg',
						'mask gradient' => riode_get_customize_dir() . '/post/gradient.jpg',
						'widget'        => riode_get_customize_dir() . '/post/widget.jpg',
						'list-xs'       => riode_get_customize_dir() . '/post/calendar.jpg',
						'framed'        => riode_get_customize_dir() . '/post/framed.jpg',
						'overlap'       => riode_get_customize_dir() . '/post/overlap.jpg',
					),
					'condition'   => array(
						'follow_theme_option' => '',
					),
				)
			);

			$this->add_control(
				'show_info',
				array(
					'type'        => Controls_Manager::SELECT2,
					'label'       => esc_html__( 'Show Information', 'riode-core' ),
					'multiple'    => true,
					'default'     => array(
						'image',
						'date',
						'author',
						'category',
						'comment',
						'readmore',
					),
					'options'     => array(
						'image'    => esc_html__( 'Featured Image', 'riode-core' ),
						'author'   => esc_html__( 'Author', 'riode-core' ),
						'date'     => esc_html__( 'Date', 'riode-core' ),
						'comment'  => esc_html__( 'Comments Count', 'riode-core' ),
						'category' => esc_html__( 'Category', 'riode-core' ),
						'content'  => esc_html__( 'Content', 'riode-core' ),
						'readmore' => esc_html__( 'Read More', 'riode-core' ),
					),
					'condition'   => array(
						'follow_theme_option' => '',
						'post_type'           => array( '', 'framed', 'widget', 'list-xs' ),
					),
					'description' => esc_html__(
						'Includes the specific post information which you want to show in your site.​​​',
						'riode-core'
					),
				)
			);

			$this->add_control(
				'overlay',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Image Hover Effect', 'riode-core' ),
					'options'     => array(
						''           => esc_html__( 'No', 'riode-core' ),
						'light'      => esc_html__( 'Light', 'riode-core' ),
						'dark'       => esc_html__( 'Dark', 'riode-core' ),
						'zoom'       => esc_html__( 'Zoom', 'riode-core' ),
						'zoom_light' => esc_html__( 'Zoom and Light', 'riode-core' ),
						'zoom_dark'  => esc_html__( 'Zoom and Dark', 'riode-core' ),
					),
					'condition'   => array(
						'follow_theme_option' => '',
					),
					'description' => esc_html__(
						'Allows your post media have overlay effect on hover.​',
						'riode-core'
					),
				)
			);

			$this->add_control(
				'show_datebox',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Show Date On Featured Image', 'riode-core' ),
					'condition'   => array(
						'follow_theme_option' => '',
					),
					'description' => esc_html__(
						'Allows you to show date on the post media with prebuilt design.​​',
						'riode-core'
					),
				)
			);

			$this->add_control(
				'excerpt_custom',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Custom Excerpt Length', 'riode-core' ),
					'separator'   => 'before',
					'condition'   => array(
						'follow_theme_option' => '',
						'post_type!'          => 'mask',
					),
					'description' => esc_html__(
						'Allows you to change the post excerpt line.​​​',
						'riode-core'
					),
				)
			);

			$this->add_control(
				'excerpt_type',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Excerpt By', 'riode-core' ),
					'default'     => 'words',
					'options'     => array(
						'words'     => esc_html__( 'Words', 'riode-core' ),
						'character' => esc_html__( 'Characters', 'riode-core' ),
					),
					'condition'   => array(
						'follow_theme_option' => '',
						'excerpt_custom'      => 'yes',
						'post_type!'          => 'mask',
					),
					'description' => esc_html__(
						'Determine how to change the post excerpt line.​​​​',
						'riode-core'
					),
				)
			);

			$this->add_control(
				'excerpt_limit',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Excerpt Length', 'riode-core' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 500,
						),
					),
					'condition'   => array(
						'follow_theme_option' => '',
						'excerpt_custom'      => 'yes',
						'post_type!'          => 'mask',
					),
					'description' => esc_html__(
						'Determine the number of words or characters to change the post excerpt line.​',
						'riode-core'
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_read_more',
			array(
				'label'     => esc_html__( 'Read More Button', 'riode-core' ),
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

			$this->add_control(
				'read_more_label',
				array(
					'label'       => esc_html__( 'Read More Label', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Read More', 'riode-core' ),
					'condition'   => array(
						'follow_theme_option' => '',
					),
					'description' => esc_html__(
						'Type the specific label for read more button.​',
						'riode-core'
					),
				)
			);

			$this->add_control(
				'read_more_custom',
				array(
					'label'       => esc_html__( 'Use Custom', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'follow_theme_option' => '',
					),
					'description' => esc_html__(
						'Allows you to customize the read more button.​',
						'riode-core'
					),
				)
			);

			riode_elementor_button_layout_controls( $this, 'read_more_custom' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'style_heading_post',
				array(
					'label'     => esc_html__( 'Post', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_responsive_control(
				'post_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'post_bg',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .post' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'post_box_shadow',
					'selector' => '.elementor-element-{{ID}} .post',
				)
			);

			$this->add_control(
				'style_heading_content',
				array(
					'label'     => esc_html__( 'Content Wrap', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_responsive_control(
				'content_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .post-wrap .post-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'content_align',
				array(
					'label'   => esc_html__( 'Alignment', 'riode-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'riode-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'riode-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'riode-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
				)
			);

			$this->add_control(
				'style_heading_meta',
				array(
					'label'     => esc_html__( 'Meta', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_responsive_control(
				'meta_margin',
				array(
					'label'      => esc_html__( 'Margin', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'meta_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .post-meta' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'meta_typography',
					'selector' => '.elementor-element-{{ID}} .post-meta',
				)
			);

			$this->add_control(
				'style_divider_title',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$this->add_control(
				'style_heading_title',
				array(
					'label' => esc_html__( 'Title', 'riode-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_responsive_control(
				'title_margin',
				array(
					'label'      => esc_html__( 'Margin', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'title_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .post-title' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'title_typography',
					'selector' => '{{WRAPPER}} .post-title',
				)
			);

			$this->add_control(
				'style_divider_cats',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$this->add_control(
				'style_heading_cats',
				array(
					'label' => esc_html__( 'Category', 'riode-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_responsive_control(
				'cats_margin',
				array(
					'label'      => esc_html__( 'Margin', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .post-cats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'cats_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .post-cats' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'cats_typography',
					'selector' => '.elementor-element-{{ID}} .post-cats',
				)
			);

			$this->add_control(
				'style_divider_content',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$this->add_control(
				'style_heading_excerpt',
				array(
					'label' => esc_html__( 'Excerpt', 'riode-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_responsive_control(
				'content_margin',
				array(
					'label'      => esc_html__( 'Margin', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .post-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'content_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .post-content' => 'color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'content_typography',
					'selector' => '.elementor-element-{{ID}} .post-content p',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_cal_style',
			array(
				'label' => esc_html__( 'Calendar Type', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->add_responsive_control(
				'cal_width',
				array(
					'type'       => Controls_Manager::SLIDER,
					'label'      => esc_html__( 'Calendar Width', 'riode-core' ),
					'size_units' => array( 'px', 'rem', '%' ),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 1000,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .post-calendar' => 'width:  {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'cal_height',
				array(
					'type'       => Controls_Manager::SLIDER,
					'label'      => esc_html__( 'Calendar Height', 'riode-core' ),
					'size_units' => array( 'px', 'rem', '%' ),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 1000,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .post-calendar' => 'height:  {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'cal_border',
				array(
					'label'      => esc_html__( 'Border Width', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'rem' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .post-calendar' => 'border-style: solid; border-top-width: {{TOP}}{{UNIT}}; border-right-width: {{RIGHT}}{{UNIT}}; border-bottom-width: {{BOTTOM}}{{UNIT}}; border-left-width: {{LEFT}}{{UNIT}};',
					),
				)
			);
			$this->add_control(
				'cal_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .post-calendar' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'label'    => esc_html__( 'Day Typograhy', 'riode-core' ),
					'name'     => 'cal_day_type',
					'selector' => '.elementor-element-{{ID}} .post-calendar .post-day',
				)
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'label'    => esc_html__( 'Month Typograhy', 'riode-core' ),
					'name'     => 'cal_month_type',
					'selector' => '.elementor-element-{{ID}} .post-calendar .post-month',
				)
			);
			$this->add_control(
				'cal_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .post-calendar' => 'border-color: {{VALUE}}',
					),
				)
			);
			$this->add_control(
				'cal_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .post-calendar' => 'color: {{VALUE}}',
					),
				)
			);
			$this->add_control(
				'cal_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .post-calendar' => 'background-color: {{VALUE}}',
					),
				)
			);
		$this->end_controls_section();

		riode_elementor_button_style_controls( $this );

		riode_elementor_slider_style_controls( $this, 'layout_type' );

		riode_elementor_loadmore_button_controls( $this, 'layout_type', 'loadmore_' );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		if ( ! empty( $atts['post_ids'] ) && is_array( $atts['post_ids'] ) ) {
			$atts['post_ids'] = sanitize_text_field( implode( ',', $atts['post_ids'] ) );
		}
		if ( ! empty( $atts['categories'] ) && is_array( $atts['categories'] ) ) {
			$atts['categories'] = sanitize_text_field( implode( ',', $atts['categories'] ) );
		}
		include RIODE_CORE_PATH . 'elementor/render/widget-posts-render.php';
	}

	protected function content_template() {

	}
}
