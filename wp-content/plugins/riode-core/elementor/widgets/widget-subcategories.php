<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Menu Widget
 *
 * Riode Widget to display menu.
 *
 * @since 1.0
 */


use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;

class Riode_Subcategories_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_subcategories';
	}

	public function get_title() {
		return esc_html__( 'Subcategories List', 'riode-core' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-subcategories';
	}

	public function get_keywords() {
		return array( 'menu', 'dynamic', 'list', 'riode-core' );
	}

	public function get_script_depends() {
		return array();
	}


	/**
	 * Get menu items.
	 *
	 * @access public
	 *
	 * @return array Menu Items
	 */
	public function get_menu_items() {
		$menu_items = array();
		$menus      = wp_get_nav_menus();
		foreach ( $menus as $key => $item ) {
			$menu_items[ $item->term_id ] = $item->name;
		}
		return $menu_items;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_list',
			array(
				'label' => esc_html__( 'List', 'riode-core' ),
			)
		);

			$this->add_control(
				'list_type',
				array(
					'label'       => esc_html__( 'Post Type', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'pcat',
					'description' => esc_html__( 'Choose to show category of POST or PRODUCT.', 'riode-core' ),
					'options'     => array(
						'cat'  => esc_html__( 'Post Categories', 'riode-core' ),
						'pcat' => esc_html__( 'Product Categories', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'category_ids',
				array(
					'label'       => esc_html__( 'Select Categories', 'riode-core' ),
					'type'        => 'riode_ajaxselect2',
					'object_type' => 'category',
					'description' => esc_html__( 'Choose parent categories that you want to show subcategories of.', 'riode-core' ),
					'label_block' => true,
					'multiple'    => true,
					'condition'   => array(
						'list_type' => 'cat',
					),
				)
			);

			$this->add_control(
				'product_category_ids',
				array(
					'label'       => esc_html__( 'Select Categories', 'riode-core' ),
					'type'        => 'riode_ajaxselect2',
					'description' => esc_html__( 'Choose parent categories that you want to show subcategories of.', 'riode-core' ),
					'object_type' => 'product_cat',
					'label_block' => true,
					'multiple'    => true,
					'condition'   => array(
						'list_type' => 'pcat',
					),
				)
			);

			$this->add_control(
				'count',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Subcategories Count', 'riode-core' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 24,
						),
					),
					'description' => esc_html__( 'Choose 0 value to show all subcategories.', 'riode-core' ),
				)
			);

			$this->add_control(
				'hide_empty',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Hide Empty Subcategories', 'riode-core' ),
					'description' => esc_html__( 'Choose to show/hide empty subcategories which have no products or posts.', 'riode-core' ),
				)
			);

			$this->add_control(
				'view_all',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'View All Label', 'riode-core' ),
					'description' => esc_html__( 'This label link will be appended to subcategories list.', 'riode-core' ),
				)
			);

			$this->add_control(
				'cat_delimiter',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Category Delimiter', 'riode-core' ),
					'default'     => '',
					'description' => esc_html__( 'Type the delimiter text between parent and child categories.', 'riode-core' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .subcat-title::after' => "content: '{{value}}'",
						'.elementor-element-{{ID}} .subcat-title' => 'margin-right: 0;',
					),
				)
			);

			$this->add_control(
				'subcat_delimiter',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Subcategory Delimiter', 'riode-core' ),
					'default'     => '|',
					'description' => esc_html__( 'Type the delimiter text between each child categories.', 'riode-core' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .subcat-nav a:not(:last-child):after' => "content: '{{value}}'",
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_type_style',
			array(
				'label' => esc_html__( 'Title', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'title_style_heading',
				array(
					'label' => esc_html__( 'Title', 'riode-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'        => 'title_typo',
					'scheme'      => Typography::TYPOGRAPHY_1,
					'selector'    => '.elementor-element-{{ID}} .subcat-title',
					'description' => esc_html__( 'Choose font family, size, weight, text transform, line height and letter spacing of parent category.', 'riode-core' ),
				)
			);

			$this->add_control(
				'title_color',
				array(
					'label'       => esc_html__( 'Color', 'riode-core' ),
					'description' => esc_html__( 'Choose color of parent category.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .subcat-title' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'title_space',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Space', 'riode-core' ),
					'description' => esc_html__( 'Controls space between parent category and child category list.', 'riode-core' ),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 200,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 20,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .subcat-title' => 'margin-right: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'title_space_bottom',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Row Space', 'riode-core' ),
					'description' => esc_html__( 'Controls space between each subcategory list.', 'riode-core' ),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 200,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 20,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'title_delimiter_style_heading',
				array(
					'label'     => esc_html__( 'Delimiter', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'seperator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'        => 'title_delimiter_typo',
					'description' => esc_html__( 'Controls typography of delimiter between parent and child categories.', 'riode-core' ),
					'scheme'      => Typography::TYPOGRAPHY_1,
					'selector'    => '.elementor-element-{{ID}} .subcat-title::after',
				)
			);

			$this->add_control(
				'title_delimiter_color',
				array(
					'label'       => esc_html__( 'Color', 'riode-core' ),
					'description' => esc_html__( 'Choose color of delimiter between parent and child categories.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .subcat-title::after' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'cat_delimiter_margin',
				array(
					'label'              => esc_html__( 'Delimiter Space', 'riode-core' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'description'        => esc_html__( 'Controls left and right space around delimiter between parent category and child categories.', 'riode-core' ),
					'size_units'         => array(
						'px',
					),
					'allowed_dimensions' => 'horizontal',
					'selectors'          => array(
						'.elementor-element-{{ID}} .subcat-title:after' => 'margin: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_link_style',
			array(
				'label' => esc_html__( 'Link', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'link_style_heading',
				array(
					'label' => esc_html__( 'Link', 'riode-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'        => 'link_typo',
					'description' => esc_html__( 'Choose font family, size, weight, text transform, line height and letter spacing of child categories.', 'riode-core' ),
					'scheme'      => Typography::TYPOGRAPHY_1,
					'selector'    => '.elementor-element-{{ID}} .subcat-nav a',
				)
			);

			$this->add_control(
				'link_color',
				array(
					'label'       => esc_html__( 'Color', 'riode-core' ),
					'description' => esc_html__( 'Choose color of child categories.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .subcat-nav a' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'link__hover_color',
				array(
					'label'       => esc_html__( 'Hover Color', 'riode-core' ),
					'description' => esc_html__( 'Choose color child categories on hover event.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .subcat-nav a:hover, .elementor-element-{{ID}} .subcat-nav a:focus, .elementor-element-{{ID}} .subcat-nav a:visited' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'link_space',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Space', 'riode-core' ),
					'description' => esc_html__( 'Controls space between each subcategory items.', 'riode-core' ),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 200,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 20,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .subcat-nav a' => 'margin-right: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'subcat_delimiter_style_heading',
				array(
					'label'     => esc_html__( 'Delimiter', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'seperator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'        => 'subcat_delimiter_typo',
					'scheme'      => Typography::TYPOGRAPHY_1,
					'description' => esc_html__( 'Controls typography of delimiter between subcategory items.', 'riode-core' ),
					'selector'    => '.elementor-element-{{ID}} .subcat-nav a:not(:last-child):after',
				)
			);

			$this->add_control(
				'subcat_delimiter_color',
				array(
					'label'       => esc_html__( 'Color', 'riode-core' ),
					'description' => esc_html__( 'Choose color of delimiter between subcategory items.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .subcat-nav a:not(:last-child):after' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'subcat_delimiter_margin',
				array(
					'label'              => esc_html__( 'Delimiter Space', 'riode-core' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'description'        => esc_html__( 'Controls left and right space around the delimiter between subcategory items.', 'riode-core' ),
					'size_units'         => array(
						'px',
					),
					'allowed_dimensions' => 'horizontal',
					'selectors'          => array(
						'.elementor-element-{{ID}} .subcat-nav a:not(:last-child):after' => 'right: -{{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .subcat-nav a:not(:last-child)' => 'margin-right: calc({{LEFT}}{{UNIT}} + {{RIGHT}}{{UNIT}});',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-subcategories-render.php';
	}
}
