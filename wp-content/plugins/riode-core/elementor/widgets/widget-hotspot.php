<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Riode Elementor CountTo Widget
 *
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use ELementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class Riode_Hotspot_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_hotspot';
	}

	public function get_title() {
		return esc_html__( 'Hotspot', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-hotspot';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'hotspot', 'dot' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_hotspot',
			array(
				'label' => esc_html__( 'Hotspot', 'riode-core' ),
			)
		);

			$this->add_control(
				'icon',
				array(
					'label'       => esc_html__( 'Icon', 'riode-core' ),
					'description' => esc_html__( 'Choose icon from icon library for hotspot on image.', 'riode-core' ),
					'type'        => Controls_Manager::ICONS,
					'default'     => array(
						'value'   => 'd-icon-plus',
						'library' => '',
					),
				)
			);

			$this->add_responsive_control(
				'horizontal',
				array(
					'label'       => esc_html__( 'Horizontal', 'riode-core' ),
					'description' => esc_html__( 'Controls horizontal position of hotspot on image.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 0,
						'unit' => 'px',
					),
					'size_units'  => array(
						'px',
						'%',
						'vw',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => -500,
							'max'  => 500,
						),
						'vw' => array(
							'step' => 1,
							'min'  => -100,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'{{WRAPPER}}' => 'left: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'vertical',
				array(
					'label'       => esc_html__( 'Vertical', 'riode-core' ),
					'description' => esc_html__( 'Controls vertical position of hotspot on image.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 0,
						'unit' => 'px',
					),
					'size_units'  => array(
						'px',
						'%',
						'vw',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => -500,
							'max'  => 500,
						),
						'vw' => array(
							'step' => 1,
							'min'  => -100,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'{{WRAPPER}}' => 'top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'effect',
				array(
					'label'       => esc_html__( 'Hotspot Effect', 'riode-core' ),
					'description' => esc_html__( 'Choose effect of hotspot item.', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'type1',
					'options'     => array(
						''      => esc_html__( 'None', 'riode-core' ),
						'type1' => esc_html__( 'Spread', 'riode-core' ),
						'type2' => esc_html__( 'Twinkle', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'el_class',
				array(
					'label'       => esc_html__( 'Custom Class', 'riode-core' ),
					'description' => esc_html__( 'Input custom class except dot to apply custom styles or codes.', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Popup Content', 'riode-core' ),
			)
		);

			$this->add_control(
				'type',
				array(
					'label'       => esc_html__( 'Type', 'riode-core' ),
					'description' => esc_html__( 'Choose popup information type that will be displayed when mouse is over hotspot.', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'html',
					'options'     => array(
						'html'    => esc_html__( 'Custom Html', 'riode-core' ),
						'block'   => esc_html__( 'Block', 'riode-core' ),
						'product' => esc_html__( 'Product', 'riode-core' ),
						'image'   => esc_html__( 'Image', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'html',
				array(
					'label'       => esc_html__( 'Custom Html', 'riode-core' ),
					'description' => esc_html__( 'Input Html Code that will be shown in hotspot popup.', 'riode-core' ),
					'type'        => Controls_Manager::TEXTAREA,
					'condition'   => array( 'type' => 'html' ),
				)
			);

			$this->add_control(
				'image',
				array(
					'label'       => esc_html__( 'Choose Image', 'riode-core' ),
					'description' => esc_html__( 'Choose image that will be shown in hotspot popupt.', 'riode-core' ),
					'type'        => Controls_Manager::MEDIA,
					'default'     => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'condition'   => array( 'type' => 'image' ),
				)
			);

			$this->add_control(
				'block',
				array(
					'label'       => esc_html__( 'Block', 'riode-core' ),
					'description' => esc_html__( 'Choose block that will be shown in hotspot popupt.', 'riode-core' ),
					'type'        => 'riode_ajaxselect2',
					'object_type' => 'riode_template',
					'label_block' => true,
					'condition'   => array( 'type' => 'block' ),
				)
			);

			$this->add_control(
				'link',
				array(
					'label'       => esc_html__( 'Link Url', 'riode-core' ),
					'description' => esc_html__( 'Input link url of hotspot where you will move to.', 'riode-core' ),
					'type'        => Controls_Manager::URL,
					'default'     => array(
						'url' => '',
					),
					'condition'   => array( 'type!' => 'product' ),
				)
			);

			$this->add_control(
				'product',
				array(
					'label'       => esc_html__( 'Product', 'riode-core' ),
					'description' => esc_html__( 'Choose product that will be shown in hotspot popupt.', 'riode-core' ),
					'type'        => 'riode_ajaxselect2',
					'object_type' => 'product',
					'label_block' => true,
					'condition'   => array( 'type' => 'product' ),
				)
			);

			$this->add_control(
				'popup_position',
				array(
					'label'       => esc_html__( 'Popup Position', 'riode-core' ),
					'description' => esc_html__( 'Determine where popup will be shown when mouse is over hotspot.', 'riode-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'default'     => 'top',
					'options'     => array(
						'none'   => array(
							'title' => esc_html__( 'None', 'riode-core' ),
							'icon'  => 'eicon-disable-trash-o',
						),
						'left'   => array(
							'title' => esc_html__( 'Left', 'riode-core' ),
							'icon'  => 'eicon-arrow-left',
						),
						'top'    => array(
							'title' => esc_html__( 'Top', 'riode-core' ),
							'icon'  => 'eicon-arrow-up',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'riode-core' ),
							'icon'  => 'eicon-arrow-right',
						),
						'bottom' => array(
							'title' => esc_html__( 'Bottom', 'riode-core' ),
							'icon'  => 'eicon-arrow-down',
						),
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_hotspot',
			array(
				'label' => esc_html__( 'Hotspot', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'size',
				array(
					'label'       => esc_html__( 'Hotspot Size', 'riode-core' ),
					'description' => esc_html__( 'Controls hotspot size.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 20,
						'unit' => 'px',
					),
					'size_units'  => array(
						'px',
						'%',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .hotspot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'icon_size',
				array(
					'label'       => esc_html__( 'Icon Size', 'riode-core' ),
					'description' => esc_html__( 'Controls icon size in hotspot.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 14,
						'unit' => 'px',
					),
					'size_units'  => array(
						'px',
						'em',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 500,
						),
						'em' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .hotspot i' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'border_radius',
				array(
					'label'       => esc_html__( 'Border Radius', 'riode-core' ),
					'description' => esc_html__( 'Controls border radius value of hotspot.', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array(
						'px',
						'%',
						'em',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .hotspot, .elementor-element-{{ID}} .hotspot-wrapper::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_hotspot' );

			$this->start_controls_tab(
				'tab_btn_normal',
				array(
					'label' => esc_html__( 'Normal', 'riode-core' ),
				)
			);

				$this->add_control(
					'btn_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .hotspot' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'btn_back_color',
					array(
						'label'     => esc_html__( 'Background Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .hotspot' => 'background-color: {{VALUE}};',
						),
					)
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_btn_hover',
				array(
					'label' => esc_html__( 'Hover', 'riode-core' ),
				)
			);

				$this->add_control(
					'btn_color_hover',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .hotspot-wrapper:hover .hotspot' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'btn_back_color_hover',
					array(
						'label'     => esc_html__( 'Background Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .hotspot-wrapper:hover .hotspot' => 'background-color: {{VALUE}};',
						),
					)
				);

			$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'style_popup',
			array(
				'label' => esc_html__( 'Popup', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'popup_width',
				array(
					'label'       => esc_html__( 'Width', 'riode-core' ),
					'description' => esc_html__( 'Controls width hotspot content popup.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 1000,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .tooltip' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$this->add_responsive_control(
				'popup_h_pos',
				array(
					'label'       => esc_html__( 'Horizontal Position', 'riode-core' ),
					'description' => esc_html__( 'Controls horizontal position of hotspot popup.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'%',
						'vw',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => -300,
							'max'  => 300,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .tooltip' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
						'.elementor-element-{{ID}} .hotspot-left-tooltip .hotspot::after, .elementor-element-{{ID}} .hotspot-right-tooltip .hotspot::after' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'popup_v_pos',
				array(
					'label'       => esc_html__( 'Vertical Position', 'riode-core' ),
					'description' => esc_html__( 'Controls vertical position of hotspot popup.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'%',
						'vw',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => -300,
							'max'  => 300,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .tooltip' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
						'.elementor-element-{{ID}} .hotspot-top-tooltip .hotspot::after, .elementor-element-{{ID}} .hotspot-bottom-tooltip .hotspot::after' => 'height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'popup_padding',
				array(
					'label'       => esc_html__( 'Padding', 'riode-core' ),
					'description' => esc_html__( 'Controls padding value of hotspot popup.', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array(
						'px',
						'%',
						'em',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'popup_bg',
				array(
					'label'       => esc_html__( 'Background Color', 'riode-core' ),
					'description' => esc_html__( 'Choose background color of hotspot popup.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .tooltip' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'        => 'popup_shadow',
					'description' => esc_html__( 'Controls box shadow of hotspot popup.', 'riode-core' ),
					'selector'    => '.elementor-element-{{ID}} .tooltip',
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-hotspot-render.php';
	}
}
