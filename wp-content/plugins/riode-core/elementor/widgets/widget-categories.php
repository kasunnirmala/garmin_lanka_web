<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Categories Widget
 *
 * Riode Widget to display product categories.
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

class Riode_Categories_Elementor_Widget extends \Elementor\Widget_Base {

	// Showing Link Conditions
	private $show_link_conditions = array( 'icon', 'badge' );

	// Showing Count Conditions
	private $show_cnt_conditions = array( '', 'badge', 'banner', 'icon', 'ellipse', 'group-2', 'center' );

	public function get_name() {
		return 'riode_widget_categories';
	}

	public function get_title() {
		return esc_html__( 'Product Categories', 'riode-core' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'product categories', 'shop', 'woocommerce', 'filter' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-categories';
	}

	public function get_script_depends() {
		$depends = array( 'owl-carousel', 'isotope-pkgd' );
		if ( riode_is_elementor_preview() ) {
			$depends[] = 'riode-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_categories_selector',
			array(
				'label' => esc_html__( 'Categories Selector', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'category_ids',
				array(
					'type'        => 'riode_ajaxselect2',
					'label'       => esc_html__( 'Category IDs', 'riode-core' ),
					'description' => esc_html__( 'comma separated list of category ids', 'riode-core' ),
					'object_type' => 'product_cat',
					'label_block' => true,
					'multiple'    => true,
				)
			);

			$this->add_control(
				'run_as_filter',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Run As Filter', 'riode-core' ),
					'description' => esc_html__( 'If this option selected, this widget works as category filter for other product widgets in its section.', 'riode-core' ),
				)
			);

			$this->add_control(
				'show_subcategories',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Show Subcategories', 'riode-core' ),
					'description' => esc_html__( 'If this option selected, this widget displays only child categories of selected categories.', 'riode-core' ),
					'condition'   => array(
						'category_ids!' => '',
					),
				)
			);

			$this->add_control(
				'hide_empty',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Hide Empty Categories', 'riode-core' ),
					'description' => esc_html__( 'Hide categories that have no products.', 'riode-core' ),
				)
			);

			$this->add_control(
				'count',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Category Count', 'riode-core' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 24,
						),
					),
					'description' => esc_html__( 'Select number of products to display. 0 value will show all categories.', 'riode-core' ),
				)
			);

			$this->add_control(
				'orderby',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Order By', 'riode-core' ),
					'default'     => 'name',
					'options'     => array(
						'name'        => esc_html__( 'Name', 'riode-core' ),
						'id'          => esc_html__( 'ID', 'riode-core' ),
						'slug'        => esc_html__( 'Slug', 'riode-core' ),
						'modified'    => esc_html__( 'Modified', 'riode-core' ),
						'count'       => esc_html__( 'Product Count', 'riode-core' ),
						'parent'      => esc_html__( 'Parent', 'riode-core' ),
						'description' => esc_html__( 'Description', 'riode-core' ),
						'term_group'  => esc_html__( 'Term Group', 'riode-core' ),
					),
					'description' => esc_html__( 'Defines how categories should be ordered.', 'riode-core' ),
				)
			);

			$this->add_control(
				'orderway',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Order Way', 'riode-core' ),
					'options'     => array(
						''    => esc_html__( 'Descending', 'riode-core' ),
						'ASC' => esc_html__( 'Ascending', 'riode-core' ),
					),
					'description' => esc_html__( 'Provides advanced configuration: Ascending, Descending.', 'riode-core' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_categories_layout',
			array(
				'label' => esc_html__( 'Categories Layout', 'riode-core' ),
			)
		);

			$this->add_control(
				'layout_type',
				array(
					'label'       => esc_html__( 'Categories Layout', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'grid',
					'description' => esc_html__( 'Choose the specific layout to suit your need to display categories. We advise you to use Inner Content type of category in creative layout', 'riode-core' ),
					'options'     => array(
						'grid'     => esc_html__( 'Grid', 'riode-core' ),
						'slider'   => esc_html__( 'Slider', 'riode-core' ),
						'creative' => esc_html__( 'Creative Grid', 'riode-core' ),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'        => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
					'default'     => 'woocommerce_thumbnail',
					'description' => esc_html__( 'Choose the correct image size to fit your category.', 'riode-core' ),
				)
			);

			riode_el_creative_isotope_layout_controls( $this, 'layout_type', 'categories' );

			riode_elementor_grid_layout_controls( $this, 'layout_type' );

			riode_elementor_slider_layout_controls( $this, 'layout_type' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_category_type',
			array(
				'label' => esc_html__( 'Category Type', 'riode-core' ),
			)
		);
			$this->add_control(
				'follow_theme_option',
				array(
					'label'       => esc_html__( 'Follow Theme Option', 'riode-core' ),
					'description' => esc_html__( 'Set the category type globally.', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'default'     => 'yes',
				)
			);

			$this->add_control(
				'category_type',
				array(
					'label'       => esc_html__( 'Category Type', 'riode-core' ),
					'type'        => 'riode_image_choose',
					'width'       => 'full',
					'default'     => '',
					'options'     => array(
						''             => riode_get_customize_dir() . '/category/default.jpg',
						'badge'        => riode_get_customize_dir() . '/category/badge.jpg',
						'banner'       => riode_get_customize_dir() . '/category/banner.jpg',
						'simple'       => riode_get_customize_dir() . '/category/simple.jpg',
						'icon'         => riode_get_customize_dir() . '/category/icon.jpg',
						'classic'      => riode_get_customize_dir() . '/category/classic.jpg',
						'ellipse'      => riode_get_customize_dir() . '/category/ellipse.jpg',
						'ellipse-2'    => riode_get_customize_dir() . '/category/ellipse-2.jpg',
						'icon-overlay' => riode_get_customize_dir() . '/category/icon-overlay.jpg',
						'group'        => riode_get_customize_dir() . '/category/subcategory-1.jpg',
						'group-2'      => riode_get_customize_dir() . '/category/subcategory-2.jpg',
						'center'       => riode_get_customize_dir() . '/category/centered.jpg',
						'label'        => riode_get_customize_dir() . '/category/label.jpg',
					),
					'description' => esc_html__( 'Select your specific category type to suit your need.', 'riode-core' ),
					'condition'   => array(
						'follow_theme_option' => '',
					),
				)
			);

			$this->add_control(
				'default_width_auto',
				array(
					'label'       => esc_html__( 'Content Width Auto', 'riode-core' ),
					'description' => esc_html__( "Make content width not fixed. Their widths will be different each other depending on children's width.", 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'default'     => '',
					'condition'   => array(
						'category_type'       => array( '' ),
						'follow_theme_option' => '',
					),
				)
			);

			$this->add_control(
				'show_icon',
				array(
					'label'       => esc_html__( 'Show Icon', 'riode-core' ),
					'description' => esc_html__( 'Choose whether to show icons.', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'default'     => '',
					'condition'   => array(
						'category_type'       => array( 'group', 'group-2' ),
						'follow_theme_option' => '',
					),
				)
			);

			$this->add_control(
				'subcat_cnt',
				array(
					'label'       => esc_html__( 'Subcategory Count', 'riode-core' ),
					'description' => esc_html__( 'Controls number of subcategories in group category types.', 'riode-core' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 5,
					'condition'   => array(
						'category_type'       => array( 'group', 'group-2' ),
						'follow_theme_option' => '',
					),
				)
			);

			$this->add_control(
				'overlay',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Overlay Effect', 'riode-core' ),
					'options'     => array(
						''           => esc_html__( 'No', 'riode-core' ),
						'light'      => esc_html__( 'Light', 'riode-core' ),
						'dark'       => esc_html__( 'Dark', 'riode-core' ),
						'zoom'       => esc_html__( 'Zoom', 'riode-core' ),
						'zoom_light' => esc_html__( 'Zoom and Light', 'riode-core' ),
						'zoom_dark'  => esc_html__( 'Zoom and Dark', 'riode-core' ),
					),
					'description' => esc_html__( 'Choose category overlay effect as your need.', 'riode-core' ),
					'conditions'  => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'follow_theme_option',
								'operator' => '==',
								'value'    => '',
							),
							array(
								'name'     => 'category_type',
								'operator' => '!in',
								'value'    => array( 'icon-overlay', 'icon', 'group', 'group-2', 'label' ),
							),
						),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_cat',
			array(
				'label' => esc_html__( 'Category ', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
			$this->add_responsive_control(
				'cat_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'category_min_height',
				array(
					'label'      => esc_html__( 'Min Height', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => array(
						'unit' => 'px',
					),
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vh',
					),
					'range'      => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 700,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category img' => 'min-height:{{SIZE}}{{UNIT}}; object-fit: cover;',
					),
				)
			);

			$this->add_control(
				'cat_bg',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-category' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'cat_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-category' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			array(
				'label'     => esc_html__( 'Category Icon', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'icon_margin',
				array(
					'label'      => esc_html__( 'Margin', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} figure i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'icon_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} figure' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'icon_typography',
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '.elementor-element-{{ID}} figure i',
				)
			);

			$this->add_control(
				'icon_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} figure i' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Category Content', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'content_origin',
				array(
					'label'   => esc_html__( 'Origin', 'riode-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => array(
						't-m'  => array(
							'title' => esc_html__( 'Vertical Center', 'riode-core' ),
							'icon'  => 'eicon-v-align-middle',
						),
						't-c'  => array(
							'title' => esc_html__( 'Horizontal Center', 'riode-core' ),
							'icon'  => 'eicon-h-align-center',
						),
						't-mc' => array(
							'title' => esc_html__( 'Center', 'riode-core' ),
							'icon'  => 'eicon-frame-minimize',
						),
					),
					'default' => '',
				)
			);

			$this->start_controls_tabs( 'content_position_tabs' );

			$this->start_controls_tab(
				'content_pos_left_tab',
				array(
					'label' => esc_html__( 'Left', 'riode-core' ),
				)
			);

			$this->add_control(
				'content_left_auto',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Remove Left Offset', 'riode-core' ),
					'selectors' => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'left: auto;',
					),
				)
			);

			$this->add_responsive_control(
				'content_left',
				array(
					'label'      => esc_html__( 'Left Offset', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'condition'  => array(
						'content_left_auto' => '',
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'left:{{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'content_pos_top_tab',
				array(
					'label' => esc_html__( 'Top', 'riode-core' ),
				)
			);

			$this->add_control(
				'content_top_auto',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Remove Top Offset', 'riode-core' ),
					'selectors' => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'top: auto;',
					),
				)
			);

			$this->add_responsive_control(
				'content_top',
				array(
					'label'      => esc_html__( 'Top Offset', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'top:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'content_top_auto' => '',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'content_pos_right_tab',
				array(
					'label' => esc_html__( 'Right', 'riode-core' ),
				)
			);

			$this->add_control(
				'content_right_auto',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Remove Right Offset', 'riode-core' ),
					'selectors' => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'right: auto;',
					),
				)
			);

			$this->add_responsive_control(
				'content_right',
				array(
					'label'      => esc_html__( 'Right Offset', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'right:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'content_right_auto' => '',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'content_pos_bottom_tab',
				array(
					'label' => esc_html__( 'Bottom', 'riode-core' ),
				)
			);

			$this->add_control(
				'content_bottom_auto',
				array(
					'type'      => Controls_Manager::SWITCHER,
					'label'     => esc_html__( 'Remove Bottom Offset', 'riode-core' ),
					'selectors' => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'bottom: auto;',
					),
				)
			);

			$this->add_responsive_control(
				'content_bottom',
				array(
					'label'      => esc_html__( 'Bottom Offset', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array(
						'px',
						'rem',
						'%',
						'vw',
					),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'bottom:{{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'content_bottom_auto' => '',
					),
				)
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'content_height',
				array(
					'type'       => Controls_Manager::SLIDER,
					'label'      => esc_html__( 'Content Height', 'riode-core' ),
					'size_units' => array( 'px', 'rem', '%' ),
					'separator'  => 'before',
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 60,
							'max'  => 1000,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 6,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'height:  {{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'category_type!' => array( 'group', 'group-2' ),
					),
				)
			);

			$this->add_responsive_control(
				'content_width',
				array(
					'type'       => Controls_Manager::SLIDER,
					'label'      => esc_html__( 'Content Width', 'riode-core' ),
					'size_units' => array( 'px', 'rem', '%' ),
					'range'      => array(
						'px'  => array(
							'step' => 1,
							'min'  => 60,
							'max'  => 1000,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 6,
							'max'  => 100,
						),
						'%'   => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'width:  {{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'category_type!'     => array( 'group', 'group-2' ),
						'content_width_auto' => '',
					),
				)
			);

			$this->add_responsive_control(
				'content_width_auto',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Width Auto', 'riode-core' ),
					'description' => esc_html__( "Make content width not fixed. Their widths will be different each other depending on children's width.", 'riode-core' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .category-content' => 'width:  auto !important;',
					),
					'condition'   => array(
						'category_type!' => array( 'group', 'group-2' ),
					),
				)
			);

			$this->add_responsive_control(
				'content_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'content_align',
				array(
					'label'   => esc_html__( 'Content Align', 'riode-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => array(
						'content-left'   => array(
							'title' => esc_html__( 'Left', 'riode-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'content-center' => array(
							'title' => esc_html__( 'Center', 'riode-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'content-right'  => array(
							'title' => esc_html__( 'Right', 'riode-core' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
				)
			);

			$this->add_responsive_control(
				'content_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .category-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_content_style' );

				$this->start_controls_tab(
					'tab_content_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

					$this->add_control(
						'content_bg',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .category-content' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'content_color',
						array(
							'label'     => esc_html__( 'Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .category-content' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_content_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

					$this->add_control(
						'content_hover_bg',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category:hover .category-content' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'content_hover_color',
						array(
							'label'     => esc_html__( 'Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category:hover .category-content' => 'color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Category Name', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'title_color',
				array(
					'label'     => esc_html__( 'Text Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'.elementor-element-{{ID}} .product-category .woocommerce-loop-category__title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'title_typography',
					'selector' => '.elementor-element-{{ID}} .product-category .woocommerce-loop-category__title',
				)
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				array(
					'name'     => 'title_text_shadow',
					'selector' => '.elementor-element-{{ID}} .product-category .woocommerce-loop-category__title',
				)
			);

			$this->add_responsive_control(
				'title_margin',
				array(
					'label'      => esc_html__( 'Margin', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .woocommerce-loop-category__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'separator'  => 'before',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_count',
			array(
				'label' => esc_html__( 'Products Count', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'count_color',
				array(
					'label'     => esc_html__( 'Text Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .product-category mark' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'count_typography',
					'selector' => '.elementor-element-{{ID}} .product-category mark',
				)
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				array(
					'name'     => 'count_text_shadow',
					'selector' => '.elementor-element-{{ID}} .product-category mark',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			array(
				'label' => esc_html__( 'Shop Now Button', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'typography',
					'scheme'   => Typography::TYPOGRAPHY_4,
					'selector' => '.elementor-element-{{ID}} .product-category .btn',
				)
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				array(
					'name'     => 'text_shadow',
					'selector' => '.elementor-element-{{ID}} .product-category .btn',
				)
			);

			$this->start_controls_tabs( 'tabs_button_style' );

				$this->start_controls_tab(
					'tab_button_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

					$this->add_control(
						'btn_color',
						array(
							'label'     => esc_html__( 'Text Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_border_color',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_button_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

					$this->add_control(
						'btn_hover_color',
						array(
							'label'     => esc_html__( 'Text Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn:hover, .elementor-element-{{ID}} .product-category .btn:focus' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn:hover, .elementor-element-{{ID}} .product-category .btn:focus' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_border_color',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'.elementor-element-{{ID}} .product-category .btn:hover, , .elementor-element-{{ID}} .product-category .btn:focus' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'      => 'border',
					'selector'  => '.elementor-element-{{ID}} .btn',
					'separator' => 'before',
				)
			);

			$this->add_control(
				'border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'button_box_shadow',
					'selector' => '.elementor-element-{{ID}} .product-category .btn',
				)
			);

			$this->add_responsive_control(
				'button_margin',
				array(
					'label'      => esc_html__( 'Margin', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'separator'  => 'before',
				)
			);

			$this->add_responsive_control(
				'button_padding',
				array(
					'label'      => esc_html__( 'Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .product-category .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		riode_elementor_slider_style_controls( $this, 'layout_type' );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		if ( ! empty( $atts['category_ids'] ) && is_array( $atts['category_ids'] ) ) {
			$atts['category_ids'] = sanitize_text_field( implode( ',', $atts['category_ids'] ) );
		}
		include RIODE_CORE_PATH . 'elementor/render/widget-categories-render.php';
	}

	protected function content_template() {}
}
