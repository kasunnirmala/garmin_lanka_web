<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Filter Widget
 *
 * Riode Widget to display filter for products.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Repeater;
use Elementor\Group_Control_Border;

class Riode_Filter_Elementor_Widget extends \Elementor\Widget_Base {
	public $attributes;

	public function get_name() {
		return 'riode_widget_filter';
	}

	public function get_title() {
		return esc_html__( 'Filter', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-filter';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'filter', 'product', 'attribute', 'category', 'tag' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_filter_content',
			array(
				'label' => esc_html__( 'Filter', 'riode-core' ),
			)
		);

		$this->attributes = array();
		$taxonomies       = wc_get_attribute_taxonomies();
		$default_att      = '';

		if ( ! count( $taxonomies ) ) {
			$this->add_control(
				'sorry_desc',
				array(
					'description' => sprintf( esc_html__( 'Sorry, there are no product attributes available in this site. Click %1$shere%2$s to add attributes.', 'riode-core' ), '<a href="' . esc_url( admin_url() ) . 'edit.php?post_type=product&page=product_attributes" target="blank">', '</a>' ),
					'type'        => 'riode_description',
				)
			);

			$this->end_controls_section();

			return;
		}

		foreach ( $taxonomies as $key => $value ) {
			$this->attributes[ 'pa_' . $value->attribute_name ] = $value->attribute_label;
			if ( ! $default_att ) {
				$default_att = 'pa_' . $value->attribute_name;
			}
		}

			$repeater = new Repeater();

				$repeater->add_control(
					'name',
					array(
						'label'       => esc_html__( 'Attribute', 'riode-core' ),
						'description' => esc_html__( 'Choose specific product attribute to filter products.', 'riode-core' ),
						'type'        => Controls_Manager::SELECT,
						'options'     => $this->attributes,
						'default'     => $default_att,
					)
				);

				$repeater->add_control(
					'query_opt',
					array(
						'label'       => esc_html__( 'Query Type', 'riode-core' ),
						'description' => esc_html__( 'Choose item’s query type: AND / OR.', 'riode-core' ),
						'type'        => Controls_Manager::SELECT,
						'options'     => array(
							'and' => esc_html__( 'AND', 'riode-core' ),
							'or'  => esc_html__( 'OR', 'riode-core' ),
						),
						'default'     => 'or',
					)
				);

			$this->add_control(
				'attributes',
				array(
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array(
							'name'      => $default_att,
							'query_opt' => 'or',
						),
					),
					'title_field' => '{{{ name }}}',
				)
			);

			$this->add_control(
				'align',
				array(
					'label'       => esc_html__( 'Align', 'riode-core' ),
					'description' => esc_html__( 'Controls alignment of the attribute filter items.', 'riode-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'default'     => 'center',
					'options'     => array(
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
				'btn_label',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Filter Button Label', 'riode-core' ),
					'description' => esc_html__( 'Input filter button’s label.', 'riode-core' ),
					'default'     => 'Filter',
					'separator'   => 'before',
				)
			);

			$this->add_control(
				'btn_skin',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Filter Button Skin', 'riode-core' ),
					'description' => esc_html__( 'Choose submit button’s skin.', 'riode-core' ),
					'options'     => array(
						'btn-primary'   => esc_html__( 'Primary', 'riode-core' ),
						'btn-secondary' => esc_html__( 'Secondary', 'riode-core' ),
						'btn-alert'     => esc_html__( 'Alert', 'riode-core' ),
						'btn-success'   => esc_html__( 'Success', 'riode-core' ),
						'btn-dark'      => esc_html__( 'Dark', 'riode-core' ),
						'btn-white'     => esc_html__( 'White', 'riode-core' ),
					),
					'default'     => 'btn-primary',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_filter_style',
			array(
				'label' => esc_html__( 'Filter Items', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'filter_typography',
					'label'    => esc_html__( 'Typography', 'riode-core' ),
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '.elementor-element-{{ID}} .select-ul-toggle',
				)
			);

			$this->add_control(
				'filter_color',
				array(
					'label'       => esc_html__( 'Color', 'riode-core' ),
					'description' => esc_html__( 'Controls color of filter items.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .select-ul-toggle' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'filter_bg',
				array(
					'label'       => esc_html__( 'Background Color', 'riode-core' ),
					'description' => esc_html__( 'Controls background color of filter items.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor-element-{{ID}} .select-ul-toggle' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'filter_responsive_padding',
				array(
					'label'       => esc_html__( 'Padding', 'riode-core' ),
					'description' => esc_html__( 'Controls padding of filter items.', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array(
						'px',
						'%',
						'em',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .select-ul-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'filter_width',
				array(
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 300,
						),
					),
					'label'       => esc_html__( 'Width', 'riode-core' ),
					'description' => esc_html__( 'Controls width of filter items.', 'riode-core' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .riode-filter' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'btn_height',
				array(
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 20,
							'max'  => 100,
						),
					),
					'label'       => esc_html__( 'Height', 'riode-core' ),
					'description' => esc_html__( 'Controls height of filter items.', 'riode-core' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .btn-filter, .elementor-element-{{ID}} .riode-filter' => 'height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'filter_gap',
				array(
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
					),
					'default'     => array(
						'size' => '10',
						'unit' => 'px',
					),
					'label'       => esc_html__( 'Gap', 'riode-core' ),
					'description' => esc_html__( 'Controls space between filter items.', 'riode-core' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .align-left > *' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.elementor-element-{{ID}} .align-center > *' => 'margin-left: calc( {{SIZE}}{{UNIT}} / 2 ); margin-right: calc( {{SIZE}}{{UNIT}} / 2 );',
						'.elementor-element-{{ID}} .align-right > *' => 'margin-left: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'      => 'filter_bd',
					'selector'  => '.elementor-element-{{ID}} .select-ul-toggle',
					'separator' => 'before',
				)
			);

			$this->add_control(
				'filter_br',
				array(
					'label'       => esc_html__( 'Border Radius', 'riode-core' ),
					'description' => esc_html__( 'Controls border radius of filter items.', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array(
						'px',
						'%',
						'em',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .select-ul-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .btn-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_btn_style',
			array(
				'label' => esc_html__( 'Submit Button', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'btn_typography',
					'label'    => esc_html__( 'Typography', 'riode-core' ),
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '.elementor-element-{{ID}} .btn-filter',
				)
			);

			$this->add_responsive_control(
				'btn_width',
				array(
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'%',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 50,
							'max'  => 300,
						),
					),
					'label'       => esc_html__( 'Width', 'riode-core' ),
					'description' => esc_html__( 'Controls width of submit button.', 'riode-core' ),
					'selectors'   => array(
						'.elementor-element-{{ID}} .btn-filter' => 'width: {{SIZE}}{{UNIT}}; padding: 0;',
					),
				)
			);

			$this->add_control(
				'btn_bd',
				array(
					'label'       => esc_html__( 'Border Width', 'riode-core' ),
					'description' => esc_html__( 'Controls border width of submit button.', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array(
						'px',
						'%',
						'em',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .btn-filter' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_btn' );
				$this->start_controls_tab(
					'tab_btn_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

					$this->add_control(
						'btn_color',
						array(
							'label'       => esc_html__( 'Color', 'riode-core' ),
							'description' => esc_html__( 'Controls normal color of submit button.', 'riode-core' ),
							'type'        => Controls_Manager::COLOR,
							'selectors'   => array(
								'.elementor-element-{{ID}} .btn-filter' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bg_color',
						array(
							'label'       => esc_html__( 'Background Color', 'riode-core' ),
							'description' => esc_html__( 'Controls normal background color of submit button.', 'riode-core' ),
							'type'        => Controls_Manager::COLOR,
							'selectors'   => array(
								'.elementor-element-{{ID}} .btn-filter' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_bd_color',
						array(
							'label'       => esc_html__( 'Border Color', 'riode-core' ),
							'description' => esc_html__( 'Controls normal border color of submit button.', 'riode-core' ),
							'type'        => Controls_Manager::COLOR,
							'selectors'   => array(
								'.elementor-element-{{ID}} .btn-filter' => 'border-color: {{VALUE}};',
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
						'btn_hover_color',
						array(
							'label'       => esc_html__( 'Color', 'riode-core' ),
							'description' => esc_html__( 'Controls hover color of submit button.', 'riode-core' ),
							'type'        => Controls_Manager::COLOR,
							'selectors'   => array(
								'.elementor-element-{{ID}} .btn-filter:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bg_color',
						array(
							'label'       => esc_html__( 'Background Color', 'riode-core' ),
							'description' => esc_html__( 'Controls hover background color of submit button.', 'riode-core' ),
							'type'        => Controls_Manager::COLOR,
							'selectors'   => array(
								'.elementor-element-{{ID}} .btn-filter:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'btn_hover_bd_color',
						array(
							'label'       => esc_html__( 'Border Color', 'riode-core' ),
							'description' => esc_html__( 'Controls hover border color of submit button.', 'riode-core' ),
							'type'        => Controls_Manager::COLOR,
							'selectors'   => array(
								'.elementor-element-{{ID}} .btn-filter:hover' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-filter-render.php';
	}
}
