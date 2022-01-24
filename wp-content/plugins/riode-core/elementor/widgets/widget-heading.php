<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Heading Widget
 *
 * Riode Widget to display heading.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use ELementor\Group_Control_Box_Shadow;


class Riode_Heading_Elementor_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'riode_widget_heading';
	}

	public function get_title() {
		return esc_html__( 'Heading', 'riode-core' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'heading', 'title', 'subtitle', 'text', 'riode', 'dynamic' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-heading';
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_heading_title',
			array(
				'label' => esc_html__( 'Title', 'riode-core' ),
			)
		);

		$this->add_control(
			'content_type',
			array(
				'label'       => esc_html__( 'Content', 'riode-core' ),
				'description' => esc_html__( 'Select a certain content type among Custom and Dynamic.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'custom'  => esc_html__( 'Custom Text', 'riode-core' ),
					'dynamic' => esc_html__( 'Dynamic Content', 'riode-core' ),
				),
				'default'     => 'custom',
			)
		);

		$this->add_control(
			'dynamic_content',
			array(
				'label'       => esc_html__( 'Dynamic Content', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'title'        => esc_html__( 'Page Title', 'riode-core' ),
					'subtitle'     => esc_html__( 'Page Subtitle', 'riode-core' ),
					'product_cnt'  => esc_html__( 'Products Count', 'riode-core' ),
					'site_tagline' => esc_html__( 'Site Tag Line', 'riode-core' ),
					'site_title'   => esc_html__( 'Site Title', 'riode-core' ),
					'date'         => esc_html__( 'Current Date Time', 'riode-core' ),
					'user_info'    => esc_html__( 'User Info', 'riode-core' ),
				),
				'default'     => 'title',
				'condition'   => array(
					'content_type' => 'dynamic',
				),
				'description' => esc_html__( 'Select the certain dynamic content you want to show in your page. ( ex. page title, subtitle, user info and so on )', 'riode-core' ),
			)
		);

		$this->add_control(
			'userinfo_type',
			array(
				'label'       => esc_html__( 'User Info Field', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'id'           => esc_html__( 'ID', 'riode-core' ),
					'display_name' => esc_html__( 'Display Name', 'riode-core' ),
					'login'        => esc_html__( 'Username', 'riode-core' ),
					'first_name'   => esc_html__( 'First Name', 'riode-core' ),
					'last_name'    => esc_html__( 'Last Name', 'riode-core' ),
					'description'  => esc_html__( 'Bio', 'riode-core' ),
					'email'        => esc_html__( 'Email', 'riode-core' ),
					'url'          => esc_html__( 'Website', 'riode-core' ),
					'meta'         => esc_html__( 'User Meta', 'riode-core' ),
				),
				'default'     => 'display_name',
				'condition'   => array(
					'content_type'    => 'dynamic',
					'dynamic_content' => 'user_info',
				),
				'description' => esc_html__( 'Select the certain user information you want to show in your page. ( ex. username, email and so on )', 'riode-core' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'riode-core' ),
				'description' => esc_html__( 'Type a certain heading you want to display.', 'riode-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'Add Your Heading Text Here', 'riode-core' ),
				'placeholder' => esc_html__( 'Enter your title', 'riode-core' ),
				'condition'   => array(
					'content_type' => 'custom',
				),
			)
		);

		$this->add_control(
			'tag',
			array(
				'label'       => esc_html__( 'HTML Tag', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'p',
				),
				'default'     => 'h2',
				'description' => esc_html__( 'Select the HTML Heading tag from H1 to H6 and P tag,too.', 'riode-core' ),
			)
		);

		$this->add_control(
			'decoration',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Decoration Type', 'riode-core' ),
				'default'     => '',
				'options'     => array(
					''          => esc_html__( 'Simple', 'riode-core' ),
					'cross'     => esc_html__( 'Cross', 'riode-core' ),
					'underline' => esc_html__( 'Underline', 'riode-core' ),
				),
				'description' => esc_html__( 'Select the decoration type among Simple, Cross and Underline options. The Default type is the Simple type.', 'riode-core' ),
			)
		);

		$this->add_control(
			'hide_underline',
			array(
				'label'       => esc_html__( 'Hide Active Underline?', 'riode-core' ),
				'description' => esc_html__( 'Toggle for making your heading has an active underline or not.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'selectors'   => array(
					'.elementor-element-{{ID}} .title::after' => 'content: none',
				),
				'condition'   => array(
					'decoration' => 'underline',
				),
			)
		);

		$this->add_control(
			'title_align',
			array(
				'label'       => esc_html__( 'Title Align', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'title-left',
				'options'     => array(
					'title-left'   => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'title-center' => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'title-right'  => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'description' => esc_html__( 'Controls the alignment of title. Options are left, center and right.', 'riode-core' ),
			)
		);

		$this->add_responsive_control(
			'decoration_spacing',
			array(
				'label'       => esc_html__( 'Decoration Spacing', 'riode-core' ),
				'description' => esc_html__( 'Controls the space between the heading and the decoration.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => -100,
						'max'  => 100,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .title::before' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .title::after'  => 'margin-left: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'decoration' => 'cross',
				),
			)
		);

		$this->add_control(
			'show_link',
			array(
				'label'       => esc_html__( 'Show Link?', 'riode-core' ),
				'description' => esc_html__( 'Toggle for making your heading has link or not.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_link',
			array(
				'label'     => esc_html__( 'Link', 'riode-core' ),
				'condition' => array(
					'show_link' => 'yes',
				),
			)
		);

		$this->add_control(
			'link_url',
			array(
				'label'       => esc_html__( 'Link Url', 'riode-core' ),
				'description' => esc_html__( 'Type a certain URL to link through other pages.', 'riode-core' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'url' => '',
				),
			)
		);

		$this->add_control(
			'link_label',
			array(
				'label'       => esc_html__( 'Link Label', 'riode-core' ),
				'description' => esc_html__( 'Type a certain label of your heading link.', 'riode-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'link',
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'       => esc_html__( 'Icon', 'riode-core' ),
				'description' => esc_html__( 'Upload a certain icon of your heading link.', 'riode-core' ),
				'type'        => Controls_Manager::ICONS,
			)
		);

		$this->add_control(
			'icon_pos',
			array(
				'label'       => esc_html__( 'Icon Position', 'riode-core' ),
				'description' => esc_html__( 'Select a certain position of your icon.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'after',
				'options'     => array(
					'after'  => esc_html__( 'After', 'riode-core' ),
					'before' => esc_html__( 'Before', 'riode-core' ),
				),
			)
		);

		$this->add_responsive_control(
			'icon_space',
			array(
				'label'       => esc_html__( 'Icon Spacing (px)', 'riode-core' ),
				'description' => esc_html__( 'Type a certain number for the space between label and icon.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .icon-before i' => 'margin-right: {{SIZE}}px;',
					'.elementor-element-{{ID}} .icon-after i'  => 'margin-left: {{SIZE}}px;',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'       => esc_html__( 'Icon Size (px)', 'riode-core' ),
				'description' => esc_html__( 'Type a certain number for your icon size.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} i' => 'font-size: {{SIZE}}px;',
				),
			)
		);

		$this->add_control(
			'link_align',
			array(
				'label'       => esc_html__( 'Link Align', 'riode-core' ),
				'description' => esc_html__( 'Choose a certain alignment of your heading link.', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'link-left'  => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'link-right' => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'     => 'link-right',
			)
		);

		$this->add_control(
			'show_divider',
			array(
				'label'       => esc_html__( 'Show Divider?', 'donad-core' ),
				'description' => esc_html__( 'Toggle for making your heading has a divider or not. It is only available in left alignment.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					'link_align' => 'link-left',
				),
			)
		);

		$this->add_responsive_control(
			'link_gap',
			array(
				'label'       => esc_html__( 'Link Space', 'riode-core' ),
				'description' => esc_html__( 'Type a certain number for the space between heading and link.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => -50,
						'max'  => 50,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 0,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .link' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_title_style',
			array(
				'label' => esc_html__( 'Title', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'title_spacing',
			array(
				'label'       => esc_html__( 'Title Spacing', 'riode-core' ),
				'description' => esc_html__( 'Controls the padding of your heading.', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'em',
					'%',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'       => esc_html__( 'Title Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the heading color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '.elementor-element-{{ID}} .title',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_link_style',
			array(
				'label' => esc_html__( 'Link', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'        => 'link_typography',
				'description' => esc_html__( 'Controls the link typography.', 'riode-core' ),
				'scheme'      => Typography::TYPOGRAPHY_1,
				'selector'    => '.elementor-element-{{ID}} .link',
			)
		);

		$this->start_controls_tabs( 'tabs_heading_link' );

		$this->start_controls_tab(
			'tab_link_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'riode-core' ),
			)
		);

		$this->add_control(
			'link_color',
			array(
				'label'       => esc_html__( 'Link Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the link color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_link_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'riode-core' ),
			)
		);

		$this->add_control(
			'link_hover_color',
			array(
				'label'       => esc_html__( 'Link Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the link hover color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .link:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_border_style',
			array(
				'label' => esc_html__( 'Border', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'border_color',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the border color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .title-cross .title::before, .elementor-element-{{ID}} .title-cross .title::after, .elementor-element-{{ID}} .title-underline::after' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'border_active_color',
			array(
				'label'       => esc_html__( 'Active Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the active border color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .title-underline .title::after' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'border_height',
			array(
				'label'       => esc_html__( 'Height', 'riode-core' ),
				'description' => esc_html__( 'Controls the border width.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .title::before, .elementor-element-{{ID}} .title::after, .elementor-element-{{ID}} .title-wrapper::after' => 'height: {{SIZE}}px;',
				),
			)
		);

		$this->add_control(
			'active_border_height',
			array(
				'label'       => esc_html__( 'Active Border Height', 'riode-core' ),
				'description' => esc_html__( 'Controls the active border width.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 30,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .title-underline .title::after' => 'height: {{SIZE}}px;',
				),
				'condition'   => array(
					'decoration' => 'underline',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( 'custom' == $settings['content_type'] ) {
			$this->add_inline_editing_attributes( 'title' );
		}
		$this->add_inline_editing_attributes( 'link_label' );
		include RIODE_CORE_PATH . 'elementor/render/widget-heading-render.php';
	}
}
