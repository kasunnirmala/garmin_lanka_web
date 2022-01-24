<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

/**
 * Register elementor tab layout controls
 */
function riode_elementor_tab_layout_controls( $self, $condition_key = '' ) {

	$self->add_control(
		'tab_h_type',
		array_merge(
			array(
				'label'       => esc_html__( 'Tab Type', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose from 6 tab types. Choose from Default, Stacked, Border, Simple, Outline, Inverse.', 'riode-core' ),
				'default'     => '',
				'options'     => array(
					''        => esc_html__( 'Default', 'riode-core' ),
					'stacked' => esc_html__( 'Stacked', 'riode-core' ),
					'border'  => esc_html__( 'Border', 'riode-core' ),
					'simple'  => esc_html__( 'Simple', 'riode-core' ),
					'outline' => esc_html__( 'Outline', 'riode-core' ),
					'inverse' => esc_html__( 'Inverse', 'riode-core' ),
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);

	$self->add_control(
		'tab_type',
		array_merge(
			array(
				'label'       => esc_html__( 'Tab Layout', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Determine whether to arrange tab navs horizontally or vertically.', 'riode-core' ),
				'default'     => '',
				'options'     => array(
					''         => esc_html__( 'Horizontal', 'riode-core' ),
					'vertical' => esc_html__( 'Vertical', 'riode-core' ),
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);

	$self->add_responsive_control(
		'tab-nav-width',
		array_merge(
			array(
				'label'       => esc_html__( 'Vertical Nav width', 'riode-core' ),
				'description' => esc_html__( 'Controls nav width of vertical tab.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array(
					'px',
					'%',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 20,
						'max'  => 500,
					),
					'%'  => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 100,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .tab-vertical .nav' => 'width: {{SIZE}}{{UNIT}};',
					'.elementor-element-{{ID}} .tab-vertical .tab-content' => 'width: calc(100% - {{SIZE}}{{UNIT}});',
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
					'tab_type'     => 'vertical',
				),
			) : array(
				'condition' => array(
					'tab_type' => 'vertical',
				),
			)
		)
	);

	$self->add_control(
		'tab_justify',
		array_merge(
			array(
				'label'       => esc_html__( 'Justify Tabs', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Set to make tab navs have 100% full width.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .tab .nav-item' => 'flex: 1',
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
					'tab_type'     => '',
				),
			) : array(
				'condition' => array(
					'tab_type' => '',
				),
			)
		)
	);

	$self->add_control(
		'tab_default_bd_width',
		array_merge(
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Active Border Width', 'riode-core' ),
				'description' => esc_html__( 'Controls underline width of active nav in Default type tab.', 'riode-core' ),
				'size_units'  => array(
					'px',
					'%',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .nav-link::after' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}}',
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
					'tab_h_type'   => '',
					'tab_type'     => '',
				),
			) : array(
				'condition' => array(
					'tab_h_type' => '',
					'tab_type'   => '',
				),
			)
		)
	);

	$self->add_control(
		'tab_default_bd_height',
		array_merge(
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Active Border Height', 'riode-core' ),
				'description' => esc_html__( 'Controls underline height of active nav in Default type tab.', 'riode-core' ),
				'size_units'  => array(
					'px',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .nav-link::after' => 'height: {{SIZE}}{{UNIT}};',
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
					'tab_h_type'   => '',
					'tab_type'     => '',
				),
			) : array(
				'condition' => array(
					'tab_h_type' => '',
					'tab_type'   => '',
				),
			)
		)
	);

	$self->add_control(
		'tab_navs_pos',
		array_merge(
			array(
				'label'       => esc_html__( 'Tab Navs Position', 'riode-core' ),
				'description' => esc_html__( 'Controls alignment of tab navs. Choose from Start, Middle, End.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'separator'   => 'after',
				'default'     => 'left',
				'options'     => array(
					'left'   => esc_html__( 'Start', 'riode-core' ),
					'center' => esc_html__( 'Middle', 'riode-core' ),
					'right'  => esc_html__( 'End', 'riode-core' ),
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);
}

/**
 * Register elementor tab style controls
 */
function riode_elementor_tab_style_controls( $self, $condition_key = '' ) {
	$self->add_control(
		'nab_style_heading',
		array_merge(
			array(
				'label' => esc_html__( 'Nav Styles', 'riode-core' ),
				'type'  => Controls_Manager::HEADING,
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);

	$self->add_responsive_control(
		'nav_dimension',
		array(
			'label'       => esc_html__( 'Nav Padding', 'riode-core' ),
			'description' => esc_html__( 'Controls padding of tab navs.', 'riode-core' ),
			'type'        => Controls_Manager::DIMENSIONS,
			'size_units'  => array(
				'px',
				'%',
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .nav .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_responsive_control(
		'nav_space',
		array(
			'label'       => esc_html__( 'Nav Spacing (px)', 'riode-core' ),
			'description' => esc_html__( 'Controls space between tab navs.', 'riode-core' ),
			'type'        => Controls_Manager::NUMBER,
			'selectors'   => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .tab-nav-left>ul>li:not(:last-child)' => 'margin-right: {{VALUE}}px;',
				'.elementor-element-{{ID}} .tab>ul>li:not(:last-child)' => 'margin-right: {{VALUE}}px;',
				'.elementor .elementor-element-{{ID}} .tab-nav-center>ul>li' => 'margin-left: calc( {{VALUE}}px / 2 ); margin-right: calc( {{VALUE}}px / 2 );',
				'.elementor-element-{{ID}} .tab-nav-right>ul>li:not(:first-child)' => 'margin-left: {{VALUE}}px; margin-right: 0;',
				'.elementor-element-{{ID}} .tab-nav-right>ul>li:first-child' => 'margin-right: 0;',
				'.elementor-element-{{ID}} .tab-vertical>ul>li:not(:last-child)' => 'margin-bottom: {{VALUE}}px; margin-right: 0; margin-left: 0;',
			),
		)
	);

	$self->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'        => 'tab_nav_typography',
			'label'       => esc_html__( 'Nav Typography', 'riode-core' ),
			'description' => esc_html__( 'Choose font family, weight, size, text transform, line height and letter spacing of tab navs.', 'riode-core' ),
			'selector'    => '.elementor-element-{{ID}} .nav .nav-link',
		)
	);

	$self->start_controls_tabs( 'tabs_bg_color' );

	$self->start_controls_tab(
		'tab_color_normal',
		array(
			'label' => esc_html__( 'Normal', 'riode-core' ),
		)
	);

	$self->add_control(
		'bg_color',
		array(
			'label'     => esc_html__( 'Background Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .nav .nav-link' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'color',
		array(
			'label'     => esc_html__( 'Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .nav .nav-link' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'nav_bd_color',
		array(
			'label'     => esc_html__( 'Border Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .nav .nav-link' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->start_controls_tab(
		'tab_color_active',
		array(
			'label' => esc_html__( 'Active', 'riode-core' ),
		)
	);

	$self->add_control(
		'bg_color_active',
		array(
			'label'     => esc_html__( 'Background Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .nav .nav-link.active, .elementor-element-{{ID}} .nav .nav-link:hover' => 'background-color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'color_active',
		array(
			'label'     => esc_html__( 'Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				// Stronger selector to avoid section style from overwriting
				'.elementor-element-{{ID}} .nav .nav-link.active, .elementor-element-{{ID}} .nav .nav-link:hover' => 'color: {{VALUE}};',
			),
		)
	);

	$self->add_control(
		'nav_bd_active_color',
		array(
			'label'     => esc_html__( 'Border Color', 'riode-core' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array(
				'.elementor-element-{{ID}} .nav .nav-link.active, .elementor-element-{{ID}} .nav .nav-link:hover' => 'border-color: {{VALUE}};',
			),
		)
	);

	$self->end_controls_tab();

	$self->end_controls_tabs();

	$self->add_control(
		'tab_style_heading',
		array_merge(
			array(
				'label'     => esc_html__( 'Tab Styles', 'riode-core' ),
				'separator' => 'before',
				'type'      => Controls_Manager::HEADING,
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);

	$self->add_responsive_control(
		'tab_content_pad',
		array(
			'label'       => esc_html__( 'Padding', 'riode-core' ),
			'description' => esc_html__( 'Control global padding of tab content.', 'riode-core' ),
			'type'        => Controls_Manager::DIMENSIONS,
			'size_units'  => array(
				'px',
				'%',
			),
			'selectors'   => array(
				'.elementor-element-{{ID}} .tab-content .tab-pane' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$self->add_control(
		'tab_bg_color',
		array_merge(
			array(
				'label'       => esc_html__( 'Background Color', 'riode-core' ),
				'description' => esc_html__( 'Choose background color of tab content.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .tab-content .tab-pane' => 'background-color: {{VALUE}};',
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);

	$self->add_control(
		'tab_bd_color',
		array_merge(
			array(
				'label'       => esc_html__( 'Tab Border Color', 'riode-core' ),
				'description' => esc_html__( 'Choose border color of tab content.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .tab-content .tab-pane' => 'border-color: {{VALUE}};',
				),
			),
			$condition_key ? array(
				'condition' => array(
					$condition_key => 'tab',
				),
			) : array()
		)
	);
}

/**
 * Register elementor products layout controls
 */
function riode_elementor_products_layout_controls( $self, $mode = 'presets' ) {

	$self->start_controls_section(
		'section_products_layout',
		array(
			'label' => 'presets' == $mode ? esc_html__( 'Products Layout', 'riode-core' ) : esc_html__( 'Layout', 'riode-core' ),
		)
	);

	$self->add_control(
		'layout_type',
		array(
			'label'       => esc_html__( 'Products Layout', 'riode-core' ),
			'description' => esc_html__( 'Choose products layout type: Grid, Slider, Creative Layout', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => 'custom_layouts' == $mode ? 'creative' : 'grid',
			'options'     => array(
				'grid'     => esc_html__( 'Grid', 'riode-core' ),
				'slider'   => esc_html__( 'Slider', 'riode-core' ),
				'creative' => esc_html__( 'Creative', 'riode-core' ),
			),
		)
	);

	if ( 'presets' == $mode ) {

		$self->add_control(
			'custom_creative',
			array(
				'label'       => esc_html__( 'Use Custom Layout', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Use creative layout preset or build your own.', 'riode-core' ),
				'default'     => '',
				'condition'   => array(
					'layout_type' => 'creative',
				),
			)
		);

		$self->add_control(
			'creative_mode',
			array(
				'label'       => esc_html__( 'Creative Layout', 'riode-core' ),
				'description' => esc_html__( 'Choose from 9 supported presets.', 'riode-core' ),
				'type'        => 'riode_image_choose',
				'default'     => 1,
				'options'     => riode_product_grid_preset(),
				'condition'   => array(
					'layout_type'     => 'creative',
					'custom_creative' => '',
				),
			)
		);

		$self->add_responsive_control(
			'creative_cols',
			array(
				'type'           => Controls_Manager::SLIDER,
				'label'          => esc_html__( 'Columns', 'riode-core' ),
				'description'    => esc_html__( 'Controls number of creative columns to display.', 'riode-core' ),
				'default'        => array(
					'size' => 4,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 3,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 2,
					'unit' => 'px',
				),
				'size_units'     => array(
					'px',
				),
				'range'          => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 60,
					),
				),
				'condition'      => array(
					'layout_type'     => 'creative',
					'custom_creative' => 'yes',
				),
				'selectors'      => array(
					'.elementor-element-{{ID}} .product-grid' => 'grid-template-columns: repeat(auto-fill, calc(100% / {{SIZE}}))',
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_no',
			array(
				'label'       => esc_html__( 'Item Number', 'riode-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Blank for all items.', 'riode-core' ),
				'description' => esc_html__( 'Choose item number to control creative items.', 'riode-core' ),
			)
		);

		$repeater->add_responsive_control(
			'item_col_pan',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Column Size', 'riode-core' ),
				'description' => esc_html__( 'Controls selected item\'s column size.', 'riode-core' ),
				'default'     => array(
					'size' => 1,
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 12,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-column-end: span {{SIZE}}',
				),
			)
		);

		$repeater->add_responsive_control(
			'item_row_pan',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Row Size', 'riode-core' ),
				'description' => esc_html__( 'Controls selected item\'s row size.', 'riode-core' ),
				'default'     => array(
					'size' => 1,
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 8,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-row-end: span {{SIZE}}',
				),
			)
		);

		$repeater->add_control(
			'item_custom_product_type',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Custom Product Type', 'riode-core' ),
				'description' => esc_html__( 'Choose whether to control selected item\'s product type', 'riode-core' ),
				'condition'   => array(
					'item_no!' => '',
				),
			)
		);

		$repeater->add_control(
			'item_product_type',
			array(
				'label'       => esc_html__( 'Product Type', 'riode-core' ),
				'description' => esc_html__( 'Choose from 4 default types: Default, Classic, List, Widget.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''        => esc_html__( 'Default', 'riode-core' ),
					'classic' => esc_html__( 'Classic', 'riode-core' ),
					'list'    => esc_html__( 'List', 'riode-core' ),
					'widget'  => esc_html__( 'Widget', 'riode-core' ),
				),
				'condition'   => array(
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_classic_hover',
			array(
				'label'       => esc_html__( 'Hover Effect', 'riode-core' ),
				'description' => esc_html__( 'Choose content’s hover effect from: Default, Popup, Slide-up. ', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''        => esc_html__( 'Default', 'riode-core' ),
					'popup'   => esc_html__( 'Popup', 'riode-core' ),
					'slideup' => esc_html__( 'Slide Up', 'riode-core' ),
				),
				'condition'   => array(
					'item_no!'                 => '',
					'item_product_type'        => 'classic',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_show_info',
			array(
				'type'        => Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Show Information', 'riode-core' ),
				'description' => esc_html__( 'Choose to show information of product: Category, Label, Price, Rating, Attribute, Cart, Compare, Quick view, Wishlist, Excerpt.', 'riode-core' ),
				'multiple'    => true,
				'default'     => array(
					'category',
					'label',
					'price',
					'rating',
					'addtocart',
					'compare',
					'quickview',
					'wishlist',
				),
				'options'     => array(
					'category'   => esc_html__( 'Category', 'riode-core' ),
					'label'      => esc_html__( 'Label', 'riode-core' ),
					'price'      => esc_html__( 'Price', 'riode-core' ),
					'rating'     => esc_html__( 'Rating', 'riode-core' ),
					'attribute'  => esc_html__( 'Attribute', 'riode-core' ),
					'addtocart'  => esc_html__( 'Add To Cart', 'riode-core' ),
					'compare'    => esc_html__( 'Compare', 'riode-core' ),
					'quickview'  => esc_html__( 'Quickview', 'riode-core' ),
					'wishlist'   => esc_html__( 'Wishlist', 'riode-core' ),
					'short_desc' => esc_html__( 'Short Description', 'riode-core' ),
				),
				'condition'   => array(
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_show_labels',
			array(
				'type'        => Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Show Labels', 'riode-core' ),
				'description' => esc_html__( 'Select to show product labels on left part of product thumbnail: Top, Sale, New, Out of Stock, Custom labels.', 'riode-core' ),
				'multiple'    => true,
				'default'     => array(
					'top',
					'sale',
					'new',
					'stock',
					'custom',
				),
				'options'     => array(
					'top'    => esc_html__( 'Top', 'riode-core' ),
					'sale'   => esc_html__( 'Sale', 'riode-core' ),
					'new'    => esc_html__( 'New', 'riode-core' ),
					'stock'  => esc_html__( 'Stock', 'riode-core' ),
					'custom' => esc_html__( 'Custom', 'riode-core' ),
				),
				'condition'   => array(
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_addtocart_pos',
			array(
				'label'       => esc_html__( 'Add to Cart Pos', 'riode-core' ),
				'description' => esc_html__( 'Choose cart position from: Top, Bottom, 100% fullwidth, With quantity input. ', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''              => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom'        => esc_html__( 'On bottom of the image', 'riode-core' ),
					'detail_bottom' => esc_html__( '100% full width', 'riode-core' ),
					'with_qty'      => esc_html__( 'with QTY input', 'riode-core' ),
					'hide'          => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition'   => array(
					'item_product_type'        => '',
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_quickview_pos',
			array(
				'label'       => esc_html__( 'Quickview Pos', 'riode-core' ),
				'description' => esc_html__( 'Choose quickview position from: Top, Bottom.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'bottom',
				'options'     => array(
					''       => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom' => esc_html__( 'On bottom of the image', 'riode-core' ),
					'hide'   => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition'   => array(
					'item_product_type'        => '',
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_wishlist_pos',
			array(
				'label'       => esc_html__( 'Add to wishlist Pos', 'riode-core' ),
				'description' => esc_html__( 'Choose wishlist position from: Top, Under.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''       => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom' => esc_html__( 'Under the image', 'riode-core' ),
					'hide'   => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition'   => array(
					'item_product_type'        => '',
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$self->add_control(
			'items_list',
			array(
				'label'       => esc_html__( "Customize each grid item's layout", 'riode-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'condition'   => array(
					'layout_type'     => 'creative',
					'custom_creative' => 'yes',
				),
				'default'     => array(
					array(
						'item_no'       => '',
						'item_col_pan'  => array(
							'size' => 1,
							'unit' => 'px',
						),
						'item_row_span' => array(
							'size' => 1,
							'unit' => 'px',
						),
					),
					array(
						'item_no'       => 1,
						'item_col_pan'  => array(
							'size' => 2,
							'unit' => 'px',
						),
						'item_row_span' => array(
							'size' => 2,
							'unit' => 'px',
						),
					),
				),
				'title_field' => sprintf( '{{{ item_no ? \'%1$s\' : \'%2$s\' }}}' . ' <strong>{{{ item_no }}}</strong>', esc_html__( 'Index', 'riode-core' ), esc_html__( 'Base', 'riode-core' ) ),
			)
		);

		$self->add_responsive_control(
			'creative_auto_height',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Auto Row Height', 'riode-core' ),
				'description' => esc_html__( 'Make base creative grid item’s height to their own.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .product-grid' => 'grid-auto-rows: auto',
				),
				'condition'   => array(
					'layout_type' => 'creative',
				),
			)
		);
	} else {
		$self->add_responsive_control(
			'creative_cols',
			array(
				'type'           => Controls_Manager::SLIDER,
				'label'          => esc_html__( 'Columns', 'riode-core' ),
				'description'    => esc_html__( 'Controls number of products to display or load more.', 'riode-core' ),
				'default'        => array(
					'size' => 4,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 3,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 2,
					'unit' => 'px',
				),
				'size_units'     => array(
					'px',
				),
				'range'          => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 60,
					),
				),
				'condition'      => array(
					'layout_type' => 'creative',
				),
				'selectors'      => array(
					'.elementor-element-{{ID}} .product-grid' => 'grid-template-columns: repeat(auto-fill, calc(100% / {{SIZE}}))',
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_no',
			array(
				'label'       => esc_html__( 'Item Number', 'riode-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'blank for all items.', 'riode-core' ),
			)
		);

		$repeater->add_responsive_control(
			'item_col_pan',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Column Size', 'riode-core' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 12,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-column-end: span {{SIZE}}',
				),
			)
		);

		$repeater->add_responsive_control(
			'item_row_pan',
			array(
				'type'       => Controls_Manager::SLIDER,
				'label'      => esc_html__( 'Row Size', 'riode-core' ),
				'default'    => array(
					'size' => 1,
					'unit' => 'px',
				),
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 8,
					),
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-row-end: span {{SIZE}}',
				),
			)
		);

		$repeater->add_control(
			'item_custom_product_type',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Custom Product Type', 'riode-core' ),
				'condition' => array(
					'item_no!' => '',
				),
			)
		);

		$repeater->add_control(
			'item_product_type',
			array(
				'label'     => esc_html__( 'Product Type', 'riode-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''        => esc_html__( 'Default', 'riode-core' ),
					'classic' => esc_html__( 'Classic', 'riode-core' ),
					'list'    => esc_html__( 'List', 'riode-core' ),
					'widget'  => esc_html__( 'Widget', 'riode-core' ),
				),
				'condition' => array(
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_classic_hover',
			array(
				'label'     => esc_html__( 'Hover Effect', 'riode-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''        => esc_html__( 'Default', 'riode-core' ),
					'popup'   => esc_html__( 'Popup', 'riode-core' ),
					'slideup' => esc_html__( 'Slide Up', 'riode-core' ),
				),
				'condition' => array(
					'item_no!'                 => '',
					'item_product_type'        => 'classic',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_show_info',
			array(
				'type'      => Controls_Manager::SELECT2,
				'label'     => esc_html__( 'Show Information', 'riode-core' ),
				'multiple'  => true,
				'default'   => array(
					'category',
					'label',
					'price',
					'rating',
					'addtocart',
					'compare',
					'quickview',
					'wishlist',
				),
				'options'   => array(
					'category'   => esc_html__( 'Category', 'riode-core' ),
					'label'      => esc_html__( 'Label', 'riode-core' ),
					'price'      => esc_html__( 'Price', 'riode-core' ),
					'rating'     => esc_html__( 'Rating', 'riode-core' ),
					'attribute'  => esc_html__( 'Attribute', 'riode-core' ),
					'addtocart'  => esc_html__( 'Add To Cart', 'riode-core' ),
					'compare'    => esc_html__( 'Compare', 'riode-core' ),
					'quickview'  => esc_html__( 'Quickview', 'riode-core' ),
					'wishlist'   => esc_html__( 'Wishlist', 'riode-core' ),
					'short_desc' => esc_html__( 'Short Description', 'riode-core' ),
				),
				'condition' => array(
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_show_labels',
			array(
				'type'      => Controls_Manager::SELECT2,
				'label'     => esc_html__( 'Show Labels', 'riode-core' ),
				'multiple'  => true,
				'default'   => array(
					'top',
					'sale',
					'new',
					'stock',
					'custom',
				),
				'options'   => array(
					'top'    => esc_html__( 'Top', 'riode-core' ),
					'sale'   => esc_html__( 'Sale', 'riode-core' ),
					'new'    => esc_html__( 'New', 'riode-core' ),
					'stock'  => esc_html__( 'Stock', 'riode-core' ),
					'custom' => esc_html__( 'Custom', 'riode-core' ),
				),
				'condition' => array(
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_addtocart_pos',
			array(
				'label'     => esc_html__( 'Add to Cart Pos', 'riode-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''              => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom'        => esc_html__( 'On bottom of the image', 'riode-core' ),
					'detail_bottom' => esc_html__( '100% full width', 'riode-core' ),
					'with_qty'      => esc_html__( 'with QTY input', 'riode-core' ),
					'hide'          => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition' => array(
					'item_product_type'        => '',
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_quickview_pos',
			array(
				'label'     => esc_html__( 'Quickview Pos', 'riode-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom',
				'options'   => array(
					''       => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom' => esc_html__( 'On bottom of the image', 'riode-core' ),
					'hide'   => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition' => array(
					'item_product_type'        => '',
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_wishlist_pos',
			array(
				'label'     => esc_html__( 'Add to wishlist Pos', 'riode-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''       => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom' => esc_html__( 'Under the image', 'riode-core' ),
					'hide'   => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition' => array(
					'item_product_type'        => '',
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$self->add_control(
			'items_list',
			array(
				'label'       => esc_html__( "Customize each grid item's layout", 'riode-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'condition'   => array(
					'layout_type' => 'creative',
				),
				'default'     => array(
					array(
						'item_no'       => '',
						'item_col_pan'  => array(
							'size' => 1,
							'unit' => 'px',
						),
						'item_row_span' => array(
							'size' => 1,
							'unit' => 'px',
						),
					),
					array(
						'item_no'       => 1,
						'item_col_pan'  => array(
							'size' => 2,
							'unit' => 'px',
						),
						'item_row_span' => array(
							'size' => 2,
							'unit' => 'px',
						),
					),
				),
				'title_field' => sprintf( '{{{ item_no ? \'%1$s\' : \'%2$s\' }}}' . ' <strong>{{{ item_no }}}</strong>', esc_html__( 'Index', 'riode-core' ), esc_html__( 'Base', 'riode-core' ) ),
			)
		);

		$self->add_responsive_control(
			'creative_auto_height',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Auto Row Height', 'riode-core' ),
				'description' => esc_html__( 'Make base creative grid item’s height to their own.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .product-grid' => 'grid-auto-rows: auto',
				),
				'condition'   => array(
					'layout_type' => 'creative',
				),
			)
		);
	}

	riode_elementor_grid_layout_controls( $self, 'layout_type' );

	if ( 'presets' == $mode ) {
		riode_elementor_loadmore_layout_controls( $self, 'layout_type' );
	}

	riode_elementor_slider_layout_controls( $self, 'layout_type' );

		$self->add_control(
			'large_thumbnail_heading',
			array(
				'label'     => esc_html__( 'Product image size for large grid areas', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'layout_type' => 'creative',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'large_thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
				'label'     => esc_html__( 'Large Image Size', 'riode-core' ),
				'default'   => 'woocommerce_single',
				'condition' => array(
					'layout_type' => 'creative',
				),
			)
		);

	if ( 'presets' == $mode ) {
		$self->add_control(
			'filter_cat_w',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Filter by Category Widget', 'riode-core' ),
				'separator'   => 'before',
				'description' => esc_html__( 'If there is a category widget enabled "Run as filter" option in the same section, You can filter by category widget using this option.', 'riode-core' ),
			)
		);

		$self->add_control(
			'filter_cat',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Show Category Filter', 'riode-core' ),
				'description' => esc_html__( 'Defines whether to show or hide category filters above products.', 'riode-core' ),
			)
		);

		$self->add_control(
			'show_all_filter',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Show "All" Filter', 'riode-core' ),
				'default'   => 'yes',
				'condition' => array(
					'filter_cat' => 'yes',
				),
			)
		);
	}

	$self->end_controls_section();
}
/**
 * Register elementor products select controls
 */
function riode_elementor_products_select_controls( $self, $add_section = true ) {

	if ( $add_section ) {
		$self->start_controls_section(
			'section_products_selector',
			array(
				'label' => esc_html__( 'Products Selector', 'riode-core' ),
			)
		);
	}

	$self->add_control(
		'product_ids',
		array(
			'type'        => 'riode_ajaxselect2',
			'label'       => esc_html__( 'Product IDs', 'riode-core' ),
			'description' => esc_html__( 'Choose product ids of specific products to display.', 'riode-core' ),
			'object_type' => 'product',
			'label_block' => true,
			'multiple'    => true,
		)
	);

	$categories = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		)
	);
	$options    = array();
	if ( is_array( $categories ) ) {
		foreach ( $categories as $category ) {
			$options[ $category->term_id ] = $category->name;
		}
	}

	$self->add_control(
		'categories',
		array(
			'label'       => esc_html__( 'Categories', 'riode-core' ),
			'description' => esc_html__( 'Choose categories which include products to display.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT2,
			'options'     => $options,
			'default'     => array(),
			'multiple'    => true,
		)
	);

	$self->add_control(
		'count',
		array(
			'type'        => Controls_Manager::SLIDER,
			'label'       => esc_html__( 'Product Count', 'riode-core' ),
			'description' => esc_html__( 'Controls number of products to display or load more.', 'riode-core' ),
			'default'     => array(
				'unit' => 'px',
				'size' => 10,
			),
			'range'       => array(
				'px' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 50,
				),
			),
		)
	);

	$self->add_control(
		'status',
		array(
			'label'       => esc_html__( 'Product Status', 'riode-core' ),
			'description' => esc_html__( 'Choose product status: All, Featured, On Sale, Recently Viewed.', 'riode-core' ),
			'type'        => Controls_Manager::SELECT,
			'default'     => '',
			'options'     => array(
				''         => esc_html__( 'All', 'riode-core' ),
				'featured' => esc_html__( 'Featured', 'riode-core' ),
				'sale'     => esc_html__( 'On Sale', 'riode-core' ),
				'viewed'   => esc_html__( 'Recently Viewed', 'riode-core' ),
			),
		)
	);

	if ( 'riode_widget_single_product' == $self->get_name() ) {
		$self->add_control(
			'orderby',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Order By', 'riode-core' ),
				'description' => esc_html__( 'Defines how products should be ordered: Default, ID, Name, Date, Modified, Price, Random, Rating, Total Sales.', 'riode-core' ),
				'default'     => '',
				'options'     => array(
					''         => esc_html__( 'Default', 'riode-core' ),
					'ID'       => esc_html__( 'ID', 'riode-core' ),
					'title'    => esc_html__( 'Name', 'riode-core' ),
					'date'     => esc_html__( 'Date', 'riode-core' ),
					'modified' => esc_html__( 'Modified', 'riode-core' ),
					'rand'     => esc_html__( 'Random', 'riode-core' ),
				),
				'separator'   => 'before',
			)
		);
	} else {
		$self->add_control(
			'orderby',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Order By', 'riode-core' ),
				'description' => esc_html__( 'Defines how products should be ordered: Default, ID, Name, Date, Modified, Price, Random, Rating, Total Sales.', 'riode-core' ),
				'options'     => array(
					''           => esc_html__( 'Default', 'riode-core' ),
					'ID'         => esc_html__( 'ID', 'riode-core' ),
					'title'      => esc_html__( 'Name', 'riode-core' ),
					'date'       => esc_html__( 'Date', 'riode-core' ),
					'modified'   => esc_html__( 'Modified', 'riode-core' ),
					'price'      => esc_html__( 'Price', 'riode-core' ),
					'rand'       => esc_html__( 'Random', 'riode-core' ),
					'rating'     => esc_html__( 'Rating', 'riode-core' ),
					'popularity' => esc_html__( 'Total Sales', 'riode-core' ),
				),
				'separator'   => 'before',
			)
		);
	}

	$self->add_control(
		'orderway',
		array(
			'type'        => Controls_Manager::SELECT,
			'label'       => esc_html__( 'Order Way', 'riode-core' ),
			'description' => esc_html__( 'Defines products ordering type: Ascending or Descending.', 'riode-core' ),
			'default'     => 'ASC',
			'options'     => array(
				'ASC'  => esc_html__( 'Ascending', 'riode-core' ),
				'DESC' => esc_html__( 'Descending', 'riode-core' ),
			),
			'condition'   => array(
				'orderby!' => array( 'rand', 'rating', 'popularity' ),
			),
		)
	);

	if ( $add_section ) {
		$self->end_controls_section();
	}
}

/**
 * Register elementor single product style controls
 */
function riode_elementor_single_product_style_controls( $self ) {
	$self->start_controls_section(
		'section_sp_style',
		array(
			'label' => esc_html__( 'Single Product', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->start_controls_tabs( 'sp_tabs' );

			$self->start_controls_tab(
				'sp_title_tab',
				array(
					'label' => esc_html__( 'Title', 'riode-core' ),
				)
			);

				$self->add_control(
					'sp_title_color',
					array(
						'label'       => esc_html__( 'Color', 'riode-core' ),
						'description' => esc_html__( 'Controls the color of product title', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} .product_title a' => 'color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'        => 'sp_title_typo',
						'description' => esc_html__( 'Controls the typography of product title.', 'riode-core' ),
						'scheme'      => Typography::TYPOGRAPHY_1,
						'selector'    => '.elementor-element-{{ID}} .product_title',
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'sp_price_tab',
				array(
					'label' => esc_html__( 'Price', 'riode-core' ),
				)
			);

				$self->add_control(
					'sp_price_color',
					array(
						'label'       => esc_html__( 'Color', 'riode-core' ),
						'description' => esc_html__( 'Controls the color of product price', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} p.price' => 'color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'        => 'sp_price_typo',
						'description' => esc_html__( 'Controls the typography of product price', 'riode-core' ),
						'scheme'      => Typography::TYPOGRAPHY_1,
						'selector'    => '.elementor-element-{{ID}} p.price',
					)
				);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'sp_old_price_tab',
				array(
					'label' => esc_html__( 'Old Price', 'riode-core' ),
				)
			);

				$self->add_control(
					'sp_old_price_color',
					array(
						'label'       => esc_html__( 'Color', 'riode-core' ),
						'description' => esc_html__( 'Controls the color of product old price', 'riode-core' ),
						'type'        => Controls_Manager::COLOR,
						'selectors'   => array(
							'.elementor-element-{{ID}} p.price del' => 'color: {{VALUE}};',
						),
					)
				);

				$self->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'        => 'sp_old_price_typo',
						'description' => esc_html__( 'Controls the typography of product old price', 'riode-core' ),
						'scheme'      => Typography::TYPOGRAPHY_1,
						'selector'    => '.elementor-element-{{ID}} p.price del',
					)
				);

			$self->end_controls_tab();

		$self->end_controls_tabs();

		$self->add_control(
			'style_heading_countdown',
			array(
				'label' => esc_html__( 'Countdown', 'riode-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$self->add_control(
			'sp_countdown_color',
			array(
				'label'       => esc_html__( 'Color', 'riode-core' ),
				'description' => esc_html__( 'Controls the color of product sale countdown.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'.elementor-element-{{ID}} .product-countdown-container' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'        => 'sp_countdown_typo',
				'description' => esc_html__( 'Controls the typography of product sale countdown.', 'riode-core' ),
				'scheme'      => Typography::TYPOGRAPHY_1,
				'selector'    => '.elementor-element-{{ID}} .product-countdown-container',
			)
		);

	$self->end_controls_section();
}
/**
 * Register elementor product type controls
 */
function riode_elementor_product_type_controls( $self ) {

	$self->start_controls_section(
		'section_product_type',
		array(
			'label' => esc_html__( 'Product Type', 'riode-core' ),
		)
	);

		$self->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
				'default' => 'woocommerce_thumbnail',
			)
		);

		$self->add_control(
			'follow_theme_option',
			array(
				'label'       => esc_html__( 'Follow Theme Option', 'riode-core' ),
				'description' => esc_html__( 'Choose to follows product type from theme options.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
			)
		);

		$self->add_control(
			'product_type',
			array(
				'label'       => esc_html__( 'Product Type', 'riode-core' ),
				'description' => esc_html__( 'Choose from 4 default types: Default, Classic, List, Widget.', 'riode-core' ),
				'type'        => 'riode_image_choose',
				'default'     => '',
				'width'       => 'full',
				'options'     => array(
					''        => RIODE_CORE_URI . 'assets/images/product/default.jpg',
					'classic' => RIODE_CORE_URI . 'assets/images/product/classic.jpg',
					'list'    => RIODE_CORE_URI . 'assets/images/product/list.jpg',
					'widget'  => RIODE_CORE_URI . 'assets/images/product/widget.jpg',
				),
				'condition'   => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'classic_hover',
			array(
				'label'       => esc_html__( 'Hover Effect', 'riode-core' ),
				'description' => esc_html__( 'Choose content’s hover effect from: Default, Popup, Slide-up.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''        => esc_html__( 'Default', 'riode-core' ),
					'popup'   => esc_html__( 'Popup', 'riode-core' ),
					'slideup' => esc_html__( 'Slide Up', 'riode-core' ),
				),
				'condition'   => array(
					'follow_theme_option' => '',
					'product_type'        => 'classic',
				),
			)
		);

		$self->add_control(
			'show_in_box',
			array(
				'label'       => esc_html__( 'Show In Box', 'riode-core' ),
				'description' => esc_html__( 'Choose to show outline border around each product.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'condition'   => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'show_reviews_text',
			array(
				'label'       => esc_html__( 'Show Reviews Text', 'riode-core' ),
				'description' => esc_html__( 'Choose whether to show “reviews” text beside rating count or hide text.', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'condition'   => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'show_hover_shadow',
			array(
				'label'     => esc_html__( 'Shadow Effect on Hover', 'riode-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'follow_theme_option' => '',
					'product_type'        => '',
				),
			)
		);

		$self->add_control(
			'show_media_shadow',
			array(
				'label'     => esc_html__( 'Media Shadow Effect on Hover', 'riode-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'show_info',
			array(
				'type'        => Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Show Information', 'riode-core' ),
				'description' => esc_html__( 'Choose to show information of product: Category, Label, Price, Rating, Attribute, Cart, Compare, Quick view, Wishlist, Excerpt.', 'riode-core' ),
				'multiple'    => true,
				'default'     => array(
					'category',
					'label',
					'price',
					'rating',
					'addtocart',
					'compare',
					'quickview',
					'wishlist',
				),
				'options'     => array(
					'category'   => esc_html__( 'Category', 'riode-core' ),
					'label'      => esc_html__( 'Label', 'riode-core' ),
					'price'      => esc_html__( 'Price', 'riode-core' ),
					'rating'     => esc_html__( 'Rating', 'riode-core' ),
					'attribute'  => esc_html__( 'Attribute', 'riode-core' ),
					'addtocart'  => esc_html__( 'Add To Cart', 'riode-core' ),
					'compare'    => esc_html__( 'Compare', 'riode-core' ),
					'quickview'  => esc_html__( 'Quickview', 'riode-core' ),
					'wishlist'   => esc_html__( 'Wishlist', 'riode-core' ),
					'short_desc' => esc_html__( 'Short Description', 'riode-core' ),
				),
				'condition'   => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'desc_line_clamp',
			array(
				'label'      => esc_html__( 'Line Clamp', 'riode-core' ),
				'type'       => Controls_Manager::NUMBER,
				'selectors'  => array(
					'.elementor-element-{{ID}} .short-desc p' => 'display: -webkit-box; -webkit-line-clamp: {{VALUE}}; -webkit-box-orient: vertical; overflow: hidden;',
				),
				'default'    => 3,
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => 'show_info',
							'operator' => 'contains',
							'value'    => 'short_desc',
						),
					),
				),
			)
		);

		$self->add_control(
			'show_labels',
			array(
				'type'        => Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Show Labels', 'riode-core' ),
				'description' => esc_html__( 'Select to show product labels on left part of product thumbnail: Top, Sale, New, Out of Stock, Custom labels.', 'riode-core' ),
				'multiple'    => true,
				'default'     => array(
					'top',
					'sale',
					'new',
					'stock',
					'custom',
				),
				'options'     => array(
					'top'    => esc_html__( 'Top', 'riode-core' ),
					'sale'   => esc_html__( 'Sale', 'riode-core' ),
					'new'    => esc_html__( 'New', 'riode-core' ),
					'stock'  => esc_html__( 'Stock', 'riode-core' ),
					'custom' => esc_html__( 'Custom', 'riode-core' ),
				),
			)
		);

		$self->add_control(
			'hover_change',
			array(
				'label'     => esc_html__( 'Change Image on Hover', 'riode-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'content_align',
			array(
				'label'       => esc_html__( 'Content Align', 'riode-core' ),
				'description' => esc_html__( 'Text alignment of product content: Left, Center, Right.', 'riode-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'left',
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
				'condition'   => array(
					'follow_theme_option' => '',
				),
			)
		);

		$self->add_control(
			'addtocart_pos',
			array(
				'label'       => esc_html__( 'Add to Cart Pos', 'riode-core' ),
				'description' => esc_html__( 'Choose cart position from: Top, Bottom, 100% fullwidth, With quantity input.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''              => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom'        => esc_html__( 'On bottom of the image', 'riode-core' ),
					'detail_bottom' => esc_html__( '100% full width', 'riode-core' ),
					'with_qty'      => esc_html__( 'with QTY input', 'riode-core' ),
					'hide'          => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition'   => array(
					'follow_theme_option' => '',
					'product_type'        => '',
				),
			)
		);

		$self->add_control(
			'quickview_pos',
			array(
				'label'       => esc_html__( 'Quickview Pos', 'riode-core' ),
				'description' => esc_html__( 'Choose quickview position from: Top, Bottom.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'bottom',
				'options'     => array(
					''       => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom' => esc_html__( 'On bottom of the image', 'riode-core' ),
					'hide'   => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition'   => array(
					'follow_theme_option' => '',
					'product_type'        => '',
				),
			)
		);

		$self->add_control(
			'wishlist_pos',
			array(
				'label'       => esc_html__( 'Add to wishlist Pos', 'riode-core' ),
				'description' => esc_html__( 'Choose wishlist position from: Top, Under.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''       => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom' => esc_html__( 'Under the image', 'riode-core' ),
					'hide'   => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition'   => array(
					'follow_theme_option' => '',
					'product_type'        => '',
				),
			)
		);

		$self->add_control(
			'show_progress_global',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Use Progress Bar from Theme Option', 'riode-core' ),
				'default'     => '',
				'description' => sprintf( esc_html__( 'Do you want to use progress bar setting from theme option? You can change progress bar options %1$shere.%2$s', 'riode-core' ), '<a href="' . wp_customize_url() . '#wf_sales_stock_bar" data-target="wf_sales_stock_bar" data-type="section" target="_blank">', '</a>' ),
			)
		);

		$self->add_control(
			'show_progress',
			array(
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Progress Bar for', 'riode-core' ),
				'description' => esc_html__( 'Choose what progress bar should mean: None, Sale count, Stock count.', 'riode-core' ),
				'options'     => array(
					''      => esc_html__( 'None', 'riode-core' ),
					'sales' => esc_html__( 'Sales', 'riode-core' ),
					'stock' => esc_html__( 'Stock', 'riode-core' ),
				),
				'condition'   => array(
					'show_progress_global' => '',
				),
			)
		);

		$self->add_control(
			'count_text',
			array(
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__( 'Sales & Stock Text', 'riode-core' ),
				/* translators: %1$s, %2$s are format texts. */
				'description' => esc_html__( 'Please insert %1$s for sale count, %2$s for stock count.', 'riode-core' ),
				/* translators: %1$s is sales, %2$s is stock */
				'placeholder' => esc_html__( 'e.g. %1$s sales, %2$s in stock', 'riode-core' ),
				'condition'   => array(
					'show_progress_global' => '',
				),
			)
		);

		$self->add_control(
			'low_stock_cnt',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Default Low Stock Count', 'riode-core' ),
				'description' => esc_html__( 'Controls default low stock count that will be highlighted.', 'riode-core' ),
				'default'     => array(
					'unit' => 'px',
					'size' => 10,
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'condition'   => array(
					'show_progress_global' => '',
					'show_progress'        => 'stock',
				),
			)
		);

	$self->end_controls_section();

}

/**
 * Register elementor product style controls
 */
function riode_elementor_product_style_controls( $self ) {

	$self->start_controls_section(
		'section_filter_style',
		array(
			'label' => esc_html__( 'Category Filter', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'style_heading_filter',
			array(
				'label' => esc_html__( 'Category Filter Style', 'riode-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$self->add_responsive_control(
			'filter_margin',
			array(
				'label'      => esc_html__( 'Margin', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'filter_padding',
			array(
				'label'      => esc_html__( 'Padding', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-filters' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'filter_item_margin',
			array(
				'label'      => esc_html__( 'Item Margin', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'separator'  => 'before',
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filters > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'filter_item_padding',
			array(
				'label'      => esc_html__( 'Item Padding', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'rem', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'cat_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'cat_border_width',
			array(
				'label'      => esc_html__( 'Border Width', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'separator'  => 'after',
				'selectors'  => array(
					'.elementor-element-{{ID}} .nav-filter' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'filter_typography',
				'selector' => '.elementor-element-{{ID}} .nav-filter',
			)
		);

		$self->add_control(
			'cat_align',
			array(
				'label'     => esc_html__( 'Align', 'riode-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .product-filters' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$self->start_controls_tabs( 'tabs_cat_color' );
			$self->start_controls_tab(
				'tab_cat_normal',
				array(
					'label' => esc_html__( 'Normal', 'riode-core' ),
				)
			);

			$self->add_control(
				'cat_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter' => 'color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter' => 'background-color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter' => 'border-color: {{VALUE}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'tab_cat_hover',
				array(
					'label' => esc_html__( 'Hover', 'riode-core' ),
				)
			);

			$self->add_control(
				'cat_hover_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter:hover' => 'color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_hover_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter:hover' => 'background-color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_hover_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter:hover' => 'border-color: {{VALUE}};',
					),
				)
			);

			$self->end_controls_tab();

			$self->start_controls_tab(
				'tab_cat_active',
				array(
					'label' => esc_html__( 'Active', 'riode-core' ),
				)
			);

			$self->add_control(
				'cat_active_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter.active' => 'color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_active_back_color',
				array(
					'label'     => esc_html__( 'Background Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter.active' => 'background-color: {{VALUE}};',
					),
				)
			);

			$self->add_control(
				'cat_active_border_color',
				array(
					'label'     => esc_html__( 'Border Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .nav-filter.active' => 'border-color: {{VALUE}};',
					),
				)
			);

			$self->end_controls_tab();
		$self->end_controls_tabs();

	$self->end_controls_section();

	$self->start_controls_section(
		'section_products_style',
		array(
			'label' => esc_html__( 'Product', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);
		$self->add_control(
			'style_heading_product',
			array(
				'label' => esc_html__( 'Product Style', 'riode-core' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$self->add_responsive_control(
			'product_padding',
			array(
				'label'      => esc_html__( 'Padding', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'product_border',
			array(
				'label'      => esc_html__( 'Border Width', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'product_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product' => 'border-color: {{VALUE}}',
				),
			)
		);

		$self->add_control(
			'product_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product' => 'background-color: {{VALUE}}',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'product_box_shadow',
				'selector' => '.elementor-element-{{ID}} .product',
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'product_typography',
				'selector' => '.elementor-element-{{ID}} .product',
			)
		);

		$self->add_control(
			'product_split_color',
			array(
				'label'     => esc_html__( 'Split Line Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => array(
					'.elementor-element-{{ID}} .split-line .product-wrap' => 'border-color: {{VALUE}}',
					'.elementor-element-{{ID}} .split-line .product-wrap::before' => 'border-color: {{VALUE}}',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'section_content_style',
		array(
			'label' => esc_html__( 'Content', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'section_name_style',
		array(
			'label' => esc_html__( 'Name', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_responsive_control(
			'product_name_margin',
			array(
				'label'      => esc_html__( 'Margin', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'product_name_type',
				'selector' => '.elementor-element-{{ID}} .woocommerce-loop-product__title',
			)
		);

		$self->add_control(
			'product_name_color',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .woocommerce-loop-product__title' => 'color: {{VALUE}}',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'section_cats_style',
		array(
			'label' => esc_html__( 'Category', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_responsive_control(
			'product_cats_margin',
			array(
				'label'      => esc_html__( 'Margin', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-cat' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'product_cats_type',
				'selector' => '.elementor-element-{{ID}} .product-cat',
			)
		);

		$self->add_control(
			'product_cats_color',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-cat' => 'color: {{VALUE}}',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'section_price_style',
		array(
			'label' => esc_html__( 'Price', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_responsive_control(
			'product_price_margin',
			array(
				'label'      => esc_html__( 'Margin', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-loop .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'product_price_type',
				'selector' => '.elementor-element-{{ID}} .product-loop .price',
			)
		);

		$self->add_control(
			'product_price_color',
			array(
				'label'     => esc_html__( 'Price Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-loop .price' => 'color: {{VALUE}}',
				),
			)
		);

		$self->add_control(
			'product_old_price_color',
			array(
				'label'     => esc_html__( 'Old Price Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-loop .price del' => 'color: {{VALUE}}',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'section_rating_style',
		array(
			'label' => esc_html__( 'Rating', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_responsive_control(
			'product_rating_margin',
			array(
				'label'      => esc_html__( 'Margin', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .woocommerce-product-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'product_rating_type',
				'selector' => '.elementor-element-{{ID}} .star-rating',
			)
		);

		$self->add_control(
			'product_rating_color',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .star-rating span::after' => 'color: {{VALUE}}',
				),
			)
		);
	$self->end_controls_section();

	$self->start_controls_section(
		'section_attrs_style',
		array(
			'label' => esc_html__( 'Attributes', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_responsive_control(
			'product_attrs_margin',
			array(
				'label'      => esc_html__( 'Margin', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-variations > *' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.elementor-element-{{ID}} .product-variations > *:last-child' => 'margin-right: 0;',
				),
			)
		);

		$self->add_control(
			'product_attrs_width',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Attribute Width (PX)', 'riode-core' ),
				'default'   => array(
					'unit' => 'px',
					'size' => 26,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .product-variations > *' => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'product_attrs_height',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Attribute Height (PX)', 'riode-core' ),
				'default'   => array(
					'unit' => 'px',
					'size' => 26,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .product-variations > *' => 'height: {{SIZE}}{{UNIT}}; line-height: 0; vertical-align:middle;',
				),
			)
		);
		$self->add_responsive_control(
			'product_attrs_border',
			array(
				'label'      => esc_html__( 'Border Width', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.elementor-element-{{ID}} .product-variations > *' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'product_attrs_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-variations > *' => 'border-color: {{VALUE}}',
				),
			)
		);

		$self->add_control(
			'product_attrs_color',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-variations > *' => 'color: {{VALUE}}',
				),
			)
		);

		$self->add_control(
			'product_attrs_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .product-variations > *' => 'background-color: {{VALUE}}',
				),
			)
		);

	$self->end_controls_section();

	$self->start_controls_section(
		'section_sales_style',
		array(
			'label' => esc_html__( 'Sales & Stock', 'riode-core' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

		$self->add_control(
			'count_text_heading',
			array(
				'label'     => esc_html__( 'Count Text', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'count_text!' => '',
				),
			)
		);

		$self->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'count_text_typography',
				'label'     => esc_html__( 'Typography', 'doanld-core' ),
				'condition' => array(
					'count_text!' => '',
				),
				'selector'  => '.elementor-element-{{ID}} .count-text',
			)
		);

		$self->add_control(
			'count_text_color',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'count_text!' => '',
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .count-text' => 'color: {{VALUE}};',
				),
			)
		);

		$self->add_control(
			'count_progress_heading',
			array(
				'label'     => esc_html__( 'Progress Bar', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'count_text!' => '',
				),
			)
		);

		$self->add_control(
			'count_progress_height',
			array(
				'type'      => Controls_Manager::SLIDER,
				'label'     => esc_html__( 'Height (PX)', 'riode-core' ),
				'default'   => array(
					'unit' => 'px',
					'size' => 10,
				),
				'range'     => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 50,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .count-progress' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$self->add_responsive_control(
			'count_progress_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'riode-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array(
					'px',
					'%',
					'em',
				),
				'selectors'  => array(
					'.elementor-element-{{ID}} .count-progress' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$self->add_control(
			'count_progress_bg',
			array(
				'label'     => esc_html__( 'Background', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'show_progress!' => '',
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .count-progress' => 'background-color: {{VALUE}};',
				),
			)
		);

			$self->start_controls_tabs( 'tabs_progress_active_bg' );
				$self->start_controls_tab(
					'count_few_tab',
					array(
						'label' => esc_html__( 'Few', 'riode-core' ),
					)
				);

				$self->add_control(
					'count_few_bg',
					array(
						'label'     => esc_html__( 'Fill Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .progress-few' => 'background-color: {{VALUE}};',
						),
					)
				);

				$self->end_controls_tab();

				$self->start_controls_tab(
					'count_normal_tab',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

				$self->add_control(
					'count_normal_bg',
					array(
						'label'     => esc_html__( 'Fill Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .count-now' => 'background-color: {{VALUE}};',
						),
					)
				);

				$self->end_controls_tab();

				$self->start_controls_tab(
					'count_many_tab',
					array(
						'label' => esc_html__( 'Many', 'riode-core' ),
					)
				);

				$self->add_control(
					'count_many_bg',
					array(
						'label'     => esc_html__( 'Fill Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .progress-many' => 'background-color: {{VALUE}};',
						),
					)
				);

				$self->end_controls_tab();
			$self->end_controls_tabs();

	$self->end_controls_section();
}
/**
 * Single Product Functions
 * Products Functions
 */
if ( ! function_exists( 'riode_single_product_widget_get_title_tag' ) ) {
	function riode_single_product_widget_get_title_tag() {
		global $riode_spw_settings;
		return isset( $riode_spw_settings['sp_title_tag'] ) ? $riode_spw_settings['sp_title_tag'] : 'h2';
	}
}
if ( ! function_exists( 'riode_single_product_widget_get_gallery_type' ) ) {
	function riode_single_product_widget_get_gallery_type() {
		global $riode_spw_settings;
		return isset( $riode_spw_settings['sp_gallery_type'] ) ? $riode_spw_settings['sp_gallery_type'] : '';
	}
}

if ( ! function_exists( 'riode_single_product_widget_remove_row_class' ) ) {
	function riode_single_product_widget_remove_row_class( $classes ) {
		global $riode_spw_settings;

		if ( isset( $riode_spw_settings['sp_vertical'] ) && $riode_spw_settings['sp_vertical'] ) {
			foreach ( $classes as $i => $class ) {
				if ( 'row' == $class ) {
					array_splice( $classes, $i, 1 );
				}
			}
		}

		return $classes;
	}
}
if ( ! function_exists( 'riode_single_product_widget_show_in_box' ) ) {
	function riode_single_product_widget_show_in_box( $classes ) {
		global $riode_spw_settings;

		if ( isset( $riode_spw_settings['sp_show_in_box'] ) && $riode_spw_settings['sp_show_in_box'] ) {
			$classes[] = 'product-boxed';
		}

		return $classes;
	}
}
if ( ! function_exists( 'riode_single_product_widget_extend_gallery_class' ) ) {
	function riode_single_product_widget_extend_gallery_class( $classes ) {
		global $riode_spw_settings;
		$single_product_layout = isset( $riode_spw_settings['sp_gallery_type'] ) ? $riode_spw_settings['sp_gallery_type'] : '';
		$classes[]             = 'pg-custom';

		if ( 'grid' == $single_product_layout || 'masonry' == $single_product_layout ) {

			foreach ( $classes as $i => $class ) {
				if ( 'cols-sm-2' == $class ) {
					array_splice( $classes, $i, 1 );
				}
			}

			if ( isset( $riode_spw_settings['sp_col_cnt'] ) ) {
				$col_cnt   = array(
					'xl'  => isset( $riode_spw_settings['sp_col_cnt_xl'] ) ? (int) $riode_spw_settings['sp_col_cnt_xl'] : 0,
					'lg'  => isset( $riode_spw_settings['sp_col_cnt'] ) ? (int) $riode_spw_settings['sp_col_cnt'] : 0,
					'md'  => isset( $riode_spw_settings['sp_col_cnt_tablet'] ) ? (int) $riode_spw_settings['sp_col_cnt_tablet'] : 0,
					'sm'  => isset( $riode_spw_settings['sp_col_cnt_mobile'] ) ? (int) $riode_spw_settings['sp_col_cnt_mobile'] : 0,
					'min' => isset( $riode_spw_settings['sp_col_cnt_min'] ) ? (int) $riode_spw_settings['sp_col_cnt_min'] : 0,
				);
				$classes[] = riode_get_col_class( function_exists( 'riode_get_responsive_cols' ) ? riode_get_responsive_cols( $col_cnt ) : $col_cnt );

				$col_sp = $riode_spw_settings['sp_col_sp'];
				if ( 'lg' === $col_sp || 'sm' === $col_sp || 'xs' === $col_sp || 'no' === $col_sp ) {
					$classes[] = 'gutter-' . $col_sp;
				}
			} else {
				$classes[]        = riode_get_col_class( riode_elementor_grid_col_cnt( $riode_spw_settings ) );
				$grid_space_class = riode_elementor_grid_space_class( $riode_spw_settings );
				if ( $grid_space_class ) {
					$classes[] = $grid_space_class;
				}
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'riode_single_product_extend_gallery_type_class' ) ) {
	function riode_single_product_extend_gallery_type_class( $class ) {
		global $riode_spw_settings;

		if ( isset( $riode_spw_settings['sp_col_cnt'] ) ) {
			$col_cnt = array(
				'xl'  => isset( $riode_spw_settings['sp_col_cnt_xl'] ) ? (int) $riode_spw_settings['sp_col_cnt_xl'] : 0,
				'lg'  => isset( $riode_spw_settings['sp_col_cnt'] ) ? (int) $riode_spw_settings['sp_col_cnt'] : 0,
				'md'  => isset( $riode_spw_settings['sp_col_cnt_tablet'] ) ? (int) $riode_spw_settings['sp_col_cnt_tablet'] : 0,
				'sm'  => isset( $riode_spw_settings['sp_col_cnt_mobile'] ) ? (int) $riode_spw_settings['sp_col_cnt_mobile'] : 0,
				'min' => isset( $riode_spw_settings['sp_col_cnt_min'] ) ? (int) $riode_spw_settings['sp_col_cnt_min'] : 0,
			);
			$class   = riode_get_col_class( function_exists( 'riode_get_responsive_cols' ) ? riode_get_responsive_cols( $col_cnt ) : $col_cnt );
			$col_sp  = $riode_spw_settings['sp_col_sp'];
			if ( 'lg' === $col_sp || 'sm' === $col_sp || 'xs' === $col_sp || 'no' === $col_sp ) {
				$class .= ' gutter-' . $col_sp;
			}
		} else {
			$class            = riode_get_col_class( riode_elementor_grid_col_cnt( $riode_spw_settings ) );
			$grid_space_class = riode_elementor_grid_space_class( $riode_spw_settings );
			if ( $grid_space_class ) {
				$class .= $grid_space_class;
			}
		}

		return $class;
	}
}

if ( ! function_exists( 'riode_single_product_extend_gallery_type_attr' ) ) {
	function riode_single_product_extend_gallery_type_attr( $attr ) {
		global $riode_spw_settings;

		if ( isset( $riode_spw_settings['sp_col_cnt'] ) ) {
			global $riode_breakpoints;

			$col_cnt = array(
				'xl'  => isset( $riode_spw_settings['sp_col_cnt_xl'] ) ? (int) $riode_spw_settings['sp_col_cnt_xl'] : 0,
				'lg'  => isset( $riode_spw_settings['sp_col_cnt'] ) ? (int) $riode_spw_settings['sp_col_cnt'] : 0,
				'md'  => isset( $riode_spw_settings['sp_col_cnt_tablet'] ) ? (int) $riode_spw_settings['sp_col_cnt_tablet'] : 0,
				'sm'  => isset( $riode_spw_settings['sp_col_cnt_mobile'] ) ? (int) $riode_spw_settings['sp_col_cnt_mobile'] : 0,
				'min' => isset( $riode_spw_settings['sp_col_cnt_min'] ) ? (int) $riode_spw_settings['sp_col_cnt_min'] : 0,
			);
			$col_cnt = function_exists( 'riode_get_responsive_cols' ) ? riode_get_responsive_cols( $col_cnt ) : $col_cnt;

			$extra_options = array();

			$margin = riode_get_grid_space( isset( $riode_spw_settings['sp_col_sp'] ) ? $riode_spw_settings['sp_col_sp'] : '' );
			if ( $margin > 0 ) { // default is 0
				$extra_options['margin'] = $margin;
			}

			$responsive = array();
			foreach ( $col_cnt as $w => $c ) {
				$responsive[ $riode_breakpoints[ $w ] ] = array(
					'items' => $c,
				);
			}
			if ( isset( $responsive[ $riode_breakpoints['md'] ] ) && ! $responsive[ $riode_breakpoints['md'] ] ) {
				$responsive[ $riode_breakpoints['md'] ] = array();
			}
			if ( isset( $responsive[ $riode_breakpoints['lg'] ] ) && ! $responsive[ $riode_breakpoints['lg'] ] ) {
				$responsive[ $riode_breakpoints['lg'] ] = array();
			}

			$extra_options['responsive'] = $responsive;
			$extra_options['nav']        = true;
			$extra_options['dots']       = false;

			$attr .= ' data-owl-options=' . esc_attr(
				json_encode(
					apply_filters( 'riode_single_product_extended_slider_options', $extra_options )
				)
			);
		} else {
			$attr .= ' data-owl-options=' . esc_attr(
				json_encode(
					riode_get_slider_attrs( $riode_spw_settings, riode_elementor_grid_col_cnt( $riode_spw_settings ) )
				)
			);
		}

		return $attr;
	}
}

if ( ! function_exists( 'riode_products_widget_render' ) ) {
	function riode_products_widget_render( $atts ) {
		include RIODE_CORE_PATH . 'elementor/render/widget-products-render.php';
	}
}

if ( ! function_exists( 'riode_single_product_gallery_countdown' ) ) {
	function riode_single_product_gallery_countdown() {
		global $riode_spw_settings;

		riode_single_product_sale_countdown( empty( $riode_spw_settings['sp_sales_label'] ) ? '' : $riode_spw_settings['sp_sales_label'], '', '' );
	}
}

if ( ! function_exists( 'riode_single_product_widget_vertical_label_group_class' ) ) {
	function riode_single_product_widget_vertical_label_group_class( $class ) {
		global $riode_spw_settings;

		if ( ! empty( $riode_spw_settings['sp_gallery_type'] ) && 'default' == $riode_spw_settings['sp_gallery_type'] ) {
			$class .= ' pg-vertical-label';
		}
		return $class;
	}
}

if ( ! function_exists( 'riode_set_single_product_widget' ) ) {
	function riode_set_single_product_widget( $atts ) {
		global $riode_spw_settings;
		$riode_spw_settings = $atts;

		// Add woocommerce default filters for compatibility with single product
		if ( riode_is_elementor_preview() &&
			! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ) ) { // Add only once

			// Add woocommerce actions for compatibility in elementor editor.
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			}
			if ( ! has_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 ) ) {
				add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
			}
			if ( ! has_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 ) ) {
				add_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
			}
			if ( ! has_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 ) ) {
				add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
			}
		}

		add_filter( 'riode_is_single_product_widget', '__return_true' );
		add_filter( 'riode_single_product_layout', 'riode_single_product_widget_get_gallery_type' );
		add_filter( 'riode_single_product_title_tag', 'riode_single_product_widget_get_title_tag' );
		add_filter( 'riode_single_product_gallery_main_classes', 'riode_single_product_widget_extend_gallery_class', 20 );
		add_filter( 'riode_product_label_group_class', 'riode_single_product_widget_vertical_label_group_class', 99 );

		remove_action( 'riode_before_main_content', 'riode_single_product_top_breadcrumb' );
		remove_action( 'woocommerce_before_single_product', 'riode_single_product_inner_breadcrumb', 15 );
		remove_action( 'woocommerce_single_product_summary', 'riode_single_product_summary_breadcrumb', 3 );

		if ( ! empty( $atts['sp_vertical'] ) ) {
			remove_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_start', 5 );
			remove_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_end', 30 );
			remove_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_start', 30 );
			remove_action( 'riode_after_product_summary_wrap', 'riode_single_product_wrap_general_end', 20 );
			add_filter( 'riode_single_product_classes', 'riode_single_product_widget_remove_row_class', 30 );
		}

		if ( ! empty( $atts['sp_show_in_box'] ) ) {
			add_filter( 'riode_single_product_classes', 'riode_single_product_widget_show_in_box', 99 );
		}

		if ( isset( $atts['sp_show_info'] ) && is_array( $atts['sp_show_info'] ) ) {
			$sp_show_info = $atts['sp_show_info'];
			if ( ! in_array( 'gallery', $sp_show_info ) ) {
				remove_action( 'woocommerce_before_single_product_summary', 'riode_wc_show_product_images_not_sticky_both', 20 );
				remove_action( 'riode_before_product_summary', 'riode_wc_show_product_images_sticky_both', 5 );
				if ( empty( $atts['sp_vertical'] ) ) {
					remove_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_start', 5 );
					remove_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_end', 30 );
					remove_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_start', 30 );
					remove_action( 'riode_after_product_summary_wrap', 'riode_single_product_wrap_general_end', 20 );
					add_filter( 'riode_single_product_classes', 'riode_single_product_widget_remove_row_class', 30 );
				}
			}
			if ( ! in_array( 'title', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! in_array( 'meta', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
			}
			if ( ! in_array( 'price', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'riode_wc_template_single_price', 9 );
				remove_action( 'woocommerce_single_product_summary', 'riode_wc_template_gallery_single_price', 24 );
			}
			if ( ! in_array( 'rating', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! in_array( 'excerpt', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! in_array( 'addtocart_form', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			if ( ! in_array( 'divider', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'riode_single_product_divider', 31 );
				remove_action( 'woocommerce_before_add_to_cart_button', 'riode_single_product_divider' );
			}
			if ( ! in_array( 'share', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			}
			if ( class_exists( 'YITH_WCWL_Frontend' ) && ! in_array( 'wishlist', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', array( YITH_WCWL_Frontend::get_instance(), 'print_button' ), 55 );
			}
			if ( ( function_exists( 'riode_get_option' ) && riode_get_option( 'product_compare' ) ) || ! in_array( 'compare', $sp_show_info ) ) {
				remove_action( 'woocommerce_single_product_summary', 'riode_product_compare', 57 );
			}
		}

		if ( isset( $atts['sp_sales_type'] ) && 'gallery' == $atts['sp_sales_type'] ) {
			remove_action( 'woocommerce_single_product_summary', 'riode_single_product_sale_countdown', 9 );
			add_action( 'riode_after_wc_gallery_figure', 'riode_single_product_gallery_countdown' );
		}

		if ( isset( $atts['sp_gallery_type'] ) && 'gallery' == $atts['sp_gallery_type'] ) {
			add_filter( 'riode_single_product_gallery_type_class', 'riode_single_product_extend_gallery_type_class' );
			add_filter( 'riode_single_product_gallery_type_attr', 'riode_single_product_extend_gallery_type_attr' );
		}

		if ( class_exists( 'Riode_Skeleton' ) ) {
			Riode_Skeleton::prevent_skeleton();
		}
	}
}

if ( ! function_exists( 'riode_unset_single_product_widget' ) ) {
	function riode_unset_single_product_widget( $atts ) {
		global $riode_spw_settings;
		unset( $riode_spw_settings );

		// Remove added filters
		remove_filter( 'riode_is_single_product_widget', '__return_true' );
		remove_filter( 'riode_single_product_layout', 'riode_single_product_widget_get_gallery_type' );
		remove_filter( 'riode_single_product_title_tag', 'riode_single_product_widget_get_title_tag' );
		remove_filter( 'riode_single_product_gallery_main_classes', 'riode_single_product_widget_extend_gallery_class', 20 );
		remove_filter( 'riode_product_label_group_class', 'riode_single_product_widget_vertical_label_group_class', 99 );

		add_action( 'riode_before_main_content', 'riode_single_product_top_breadcrumb' );
		add_action( 'woocommerce_before_single_product', 'riode_single_product_inner_breadcrumb', 15 );
		add_action( 'woocommerce_single_product_summary', 'riode_single_product_summary_breadcrumb', 3 );

		if ( ! empty( $atts['sp_vertical'] ) ) {
			add_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_start', 5 );
			add_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_end', 30 );
			add_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_start', 30 );
			add_action( 'riode_after_product_summary_wrap', 'riode_single_product_wrap_general_end', 20 );
			remove_filter( 'riode_single_product_classes', 'riode_single_product_widget_remove_row_class', 30 );
		}

		if ( ! empty( $atts['sp_show_in_box'] ) ) {
			remove_filter( 'riode_single_product_classes', 'riode_single_product_widget_show_in_box', 99 );
		}

		if ( isset( $atts['sp_show_info'] ) && is_array( $atts['sp_show_info'] ) ) {
			$sp_show_info = $atts['sp_show_info'];
			if ( ! in_array( 'gallery', $sp_show_info ) ) {
				add_action( 'woocommerce_before_single_product_summary', 'riode_wc_show_product_images_not_sticky_both', 20 );
				add_action( 'riode_before_product_summary', 'riode_wc_show_product_images_sticky_both', 5 );
				if ( empty( $atts['sp_vertical'] ) ) {
					add_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_start', 5 );
					add_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_end', 30 );
					add_action( 'woocommerce_before_single_product_summary', 'riode_single_product_wrap_general_start', 30 );
					add_action( 'riode_after_product_summary_wrap', 'riode_single_product_wrap_general_end', 20 );
					remove_filter( 'riode_single_product_classes', 'riode_single_product_widget_remove_row_class', 30 );
				}
			}
			if ( ! in_array( 'title', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			}
			if ( ! in_array( 'meta', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
			}
			if ( ! in_array( 'price', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'riode_wc_template_single_price', 9 );
				add_action( 'woocommerce_single_product_summary', 'riode_wc_template_gallery_single_price', 24 );
			}
			if ( ! in_array( 'rating', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}
			if ( ! in_array( 'excerpt', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			}
			if ( ! in_array( 'addtocart_form', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			}
			if ( ! in_array( 'divider', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'riode_single_product_divider', 31 );
				add_action( 'woocommerce_before_add_to_cart_button', 'riode_single_product_divider' );
			}
			if ( ! in_array( 'share', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			}
			if ( class_exists( 'YITH_WCWL_Frontend' ) && ! in_array( 'wishlist', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', array( YITH_WCWL_Frontend::get_instance(), 'print_button' ), 55 );
			}
			if ( ( function_exists( 'riode_get_option' ) && riode_get_option( 'product_compare' ) ) || ! in_array( 'compare', $sp_show_info ) ) {
				add_action( 'woocommerce_single_product_summary', 'riode_product_compare', 57 );
			}
		}

		if ( isset( $atts['sp_sales_type'] ) && 'gallery' == $atts['sp_sales_type'] ) {
			add_action( 'woocommerce_single_product_summary', 'riode_single_product_sale_countdown', 9 );
			remove_action( 'riode_after_wc_gallery_figure', 'riode_single_product_gallery_countdown' );
		}

		if ( isset( $atts['sp_gallery_type'] ) && 'gallery' == $atts['sp_gallery_type'] ) {
			remove_filter( 'riode_single_product_gallery_type_class', 'riode_single_product_extend_gallery_type_class' );
			remove_filter( 'riode_single_product_gallery_type_attr', 'riode_single_product_extend_gallery_type_attr' );
		}

		if ( class_exists( 'Riode_Skeleton' ) ) {
			Riode_Skeleton::stop_prevent_skeleton();
		}
	}
}
