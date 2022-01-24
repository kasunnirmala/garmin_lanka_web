<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Grid Functions
 * Load More Functions
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

/**
 * Register elementor layout controls for grid.
 */

function riode_elementor_grid_layout_controls( $self, $condition_key ) {
	$self->add_responsive_control(
		'col_cnt',
		array(
			'type'        => Controls_Manager::SELECT,
			'label'       => esc_html__( 'Columns', 'riode-core' ),
			'description' => esc_html__( 'Select number of columns to display.', 'riode-core' ),
			'options'     => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
				'6' => 6,
				'7' => 7,
				'8' => 8,
				''  => esc_html__( 'Default', 'riode-core' ),
			),
			'condition'   => array(
				$condition_key => array( 'slider', 'grid' ),
			),
		)
	);

	$self->add_control(
		'col_cnt_xl',
		array(
			'label'       => esc_html__( 'Columns ( >= 1200px )', 'riode-core' ),
			'description' => esc_html__( 'Select number of columns to display on large display( >= 1200px ). ', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'options'     => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
				'6' => 6,
				'7' => 7,
				'8' => 8,
				''  => esc_html__( 'Default', 'riode-core' ),
			),
			'condition'   => array(
				$condition_key => array( 'slider', 'grid' ),
			),
		)
	);

	$self->add_control(
		'col_cnt_min',
		array(
			'label'       => esc_html__( 'Columns ( < 576px )', 'riode-core' ),
			'description' => esc_html__( 'Select number of columns to display on mobile( < 576px ). ', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'options'     => array(
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
				'5' => 5,
				'6' => 6,
				'7' => 7,
				'8' => 8,
				''  => esc_html__( 'Default', 'riode-core' ),
			),
			'condition'   => array(
				$condition_key => array( 'slider', 'grid' ),
			),
		)
	);

	$self->add_control(
		'col_sp',
		array(
			'label'       => esc_html__( 'Columns Spacing', 'riode-core' ),
			'description' => esc_html__( 'Select the amount of spacing between items.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'md',
			'options'     => array(
				'no' => esc_html__( 'No space', 'riode-core' ),
				'xs' => esc_html__( 'Extra Small', 'riode-core' ),
				'sm' => esc_html__( 'Small', 'riode-core' ),
				'md' => esc_html__( 'Medium', 'riode-core' ),
				'lg' => esc_html__( 'Large', 'riode-core' ),
			),
			'condition'   => array(
				$condition_key => array( 'grid', 'slider', 'creative' ),
			),
		)
	);
}

function riode_elementor_grid_template() {
	?>

	function riode_get_responsive_cols( cols ) {
		var result = {},
			base = parseInt(cols.lg);

		base || (base = 4);

		if ( 6 < base ) {
			result = {
				lg: base,
				md: 6,
				sm: 4,
				min: 3
			};
		} else if ( 4 < base ) {
			result = {
				lg: base,
				md: 4,
				sm: 3,
				min: 2,
			};
		} else if ( 2 < base ) {
			result = {
				lg: base,
				md: 3,
				sm: 2
			};
		} else {
			result = {
				md: base
			};
		}

		for ( var w in cols ) {
			cols[w] > 0 && ( result[w] = cols[w] );
		}

		return result;
	}

	function riode_get_col_class( cols ) {
		var cls = ' row';
		for ( var w in cols ) {
			cols[w] > 0 && ( cls += ' cols-' + ( 'min' !== w ? w + '-' : '' ) + cols[w] );
		}
		return cls;
	}

	<?php
}

function riode_elementor_loadmore_layout_controls( $self, $condition_key ) {

	$self->add_control(
		'loadmore_type',
		array(
			'label'       => esc_html__( 'Load More', 'riode-core' ),
			'description' => esc_html__( 'Choose load more type: By button, By Scroll.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''       => esc_html__( 'No', 'riode-core' ),
				'button' => esc_html__( 'By button', 'riode-core' ),
				'scroll' => esc_html__( 'By scroll', 'riode-core' ),
			),
			'condition'   => array(
				$condition_key => array( 'grid' ),
			),
		)
	);

	$self->add_control(
		'loadmore_label',
		array(
			'label'       => esc_html__( 'Load More Label', 'riode-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => esc_html__( 'Load More', 'riode-core' ),
			'condition'   => array(
				'loadmore_type' => 'button',
				$condition_key  => array( 'grid' ),
			),
		)
	);
}

function riode_elementor_loadmore_button_controls( $self, $condition_key, $name_prefix = '' ) {
	$self->start_controls_section(
		'section_load_more_btn_skin',
		array(
			'label'     => esc_html__( 'Load More Button', 'riode-core' ),
			'condition' => array(
				'loadmore_type' => 'button',
				$condition_key  => array( 'grid' ),
			),
		)
	);

	riode_elementor_button_layout_controls( $self, $condition_key, array( 'grid', 'creative' ), $name_prefix );

	$self->end_controls_section();

	$self->start_controls_section(
		'section_load_more_btn_style',
		array(
			'label'     => esc_html__( 'Load More Button', 'riode-core' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'loadmore_type' => 'button',
				$condition_key  => array( 'grid' ),
			),
		)
	);

		$self->add_control(
			$name_prefix . 'button_customize_heading',
			array(
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Customize Options', 'riode-core' ),
				'separator' => 'before',
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => $name_prefix . 'button_typography',
				'label'    => esc_html__( 'Label Typography', 'riode-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '.elementor-element-{{ID}} .btn-load',
			)
		);

		$self->add_responsive_control(
			$name_prefix . 'btn_min_width',
			array(
				'label'      => esc_html__( 'Min Width', 'riode-core' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 5,
					),
				),
				'size_units' => array(
					'px',
					'%',
					'rem',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .btn-load' => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			$name_prefix . 'btn_padding',
			array(
				'label'      => esc_html__( 'Padding', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .btn-load' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			$name_prefix . 'btn_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .btn-load' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			$name_prefix . 'btn_border_width',
			array(
				'label'      => esc_html__( 'Border Width', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .btn-load' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
				),
			)
		);

		$self->start_controls_tabs( $name_prefix . 'tabs_btn_cat' );

		$self->start_controls_tab(
			$name_prefix . 'tab_btn_normal',
			array(
				'label' => esc_html__( 'Normal', 'riode-core' ),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_color',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_back_color',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => $name_prefix . 'btn_box_shadow',
				'selector' => '.elementor-element-{{ID}} .btn-load',
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			$name_prefix . 'tab_btn_hover',
			array(
				'label' => esc_html__( 'Hover', 'riode-core' ),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_back_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => $name_prefix . 'btn_box_shadow_hover',
				'selector' => '.elementor-element-{{ID}} .btn-load:hover',
			)
		);

		$self->end_controls_tab();

		$self->start_controls_tab(
			$name_prefix . 'tab_btn_active',
			array(
				'label' => esc_html__( 'Active', 'riode-core' ),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_color_active',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:not(:focus):active, .elementor-element-{{ID}} .btn-load:focus' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_back_color_active',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:not(:focus):active, .elementor-element-{{ID}} .btn-load:focus' => 'background-color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			$name_prefix . 'btn_border_color_active',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .btn-load:not(:focus):active, .elementor-element-{{ID}} .btn-load:focus' => 'border-color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => $name_prefix . 'btn_box_shadow_active',
				'selector' => '.elementor-element-{{ID}} .btn-load:active, .elementor-element-{{ID}} .btn-load:focus',
			)
		);

		$self->end_controls_tab();

		$self->end_controls_tabs();

	$self->end_controls_section();
}
