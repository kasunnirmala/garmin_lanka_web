<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Iconlist Widget
 *
 * Riode Widget to display custom iconlist.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Riode_Iconlist_Elementor_Widget extends \Elementor\Widget_Icon_List {

	public function get_name() {
		return 'riode_widget_iconlist';
	}

	public function get_title() {
		return esc_html__( 'Icon List', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-bullet-list';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'icon list' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		parent::register_controls();
		$this->update_control(
			'view',
			array(
				'description' => esc_html__( 'Select a certain layout type of your list among Default and Inline types.', 'riode-core' ),
			)
		);
		$this->update_control(
			'icon_list',
			array(
				'description' => esc_html__( 'Configure your list with icons and texts.', 'riode-core' ),
				'default'     => [
					[
						'text'          => __( 'List Item #1', 'elementor' ),
						'selected_icon' => [
							'value'   => 'd-icon-heart',
							'library' => 'riode',
						],
					],
					[
						'text'          => __( 'List Item #2', 'elementor' ),
						'selected_icon' => [
							'value'   => 'd-icon-star',
							'library' => 'riode',
						],
					],
					[
						'text'          => __( 'List Item #3', 'elementor' ),
						'selected_icon' => [
							'value'   => 'd-icon-info',
							'library' => 'riode',
						],
					],
				],
			)
		);
		$this->update_control(
			'link_click',
			array(
				'description' => esc_html__( 'Select a certain option for your list among Full Width and Inline.', 'riode-core' ),
			)
		);
		$this->update_control(
			'space_between',
			array(
				'description' => esc_html__( 'Controls the space between your list items.', 'riode-core' ),
			)
		);
		$this->update_control(
			'icon_align',
			array(
				'description' => esc_html__( 'Controls the alignment of your lists.', 'riode-core' ),
			)
		);
		$this->update_control(
			'divider',
			array(
				'description' => esc_html__( 'Toggle for making your list items have dividers or not.', 'riode-core' ),
			)
		);
		$this->update_control(
			'divider_style',
			array(
				'description' => esc_html__( 'Controls the divider style.', 'riode-core' ),
			)
		);
		$this->update_control(
			'divider_weight',
			array(
				'description' => esc_html__( 'Controls the divider height.', 'riode-core' ),
			)
		);
		$this->update_control(
			'divider_width',
			array(
				'description' => esc_html__( 'Controls the divider width.', 'riode-core' ),
			)
		);
		$this->update_control(
			'divider_height',
			array(
				'description' => esc_html__( 'Controls the divider height in the inline type.', 'riode-core' ),
			)
		);
		$this->update_control(
			'divider_color',
			array(
				'description' => esc_html__( 'Controls the divider color.', 'riode-core' ),
			)
		);
		$this->update_control(
			'icon_color',
			array(
				'description' => esc_html__( 'Controls the icon color.', 'riode-core' ),
			)
		);
		$this->update_control(
			'icon_color_hover',
			array(
				'description' => esc_html__( 'Controls the icon hover color.', 'riode-core' ),
			)
		);
		$this->update_control(
			'icon_size',
			array(
				'description' => esc_html__( 'Controls the icon size.', 'riode-core' ),
			)
		);
		$this->add_responsive_control(
			'bg_size',
			[
				'label'       => __( 'Background Size', 'elementor' ),
				'description' => esc_html__( 'Controls the icon background size.', 'riode-core' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 40,
				],
				'range'       => [
					'px' => [
						'min' => 25,
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .elementor-icon-list-icon' => 'display: inline-flex; justify-content: center; align-items: center; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-icon-list-icon i' =>
					'width: 1em;',
				],
			],
			[
				'position' => [
					'at' => 'after',
					'of' => 'icon_size',
				],
			]
		);
		$this->add_control(
			'bg_color',
			[
				'label'       => __( 'Background Color', 'elementor' ),
				'description' => esc_html__( 'Controls the icon background color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .elementor-icon-list-icon' => 'background-color: {{VALUE}};',
				],
			],
			[
				'position' => [
					'at' => 'after',
					'of' => 'bg_size',
				],
			]
		);
		$this->add_control(
			'bg_color_hover',
			[
				'label'       => __( 'Background Hover Color', 'elementor' ),
				'description' => esc_html__( 'Controls the icon background hover color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon' => 'background-color: {{VALUE}};',
				],
			],
			[
				'position' => [
					'at' => 'after',
					'of' => 'bg_color',
				],
			]
		);
		$this->add_control(
			'border_style',
			[
				'label'     => __( 'Border Style', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'   => __( 'None', 'elementor' ),
					'solid'  => __( 'Solid', 'elementor' ),
					'double' => __( 'Double', 'elementor' ),
					'dotted' => __( 'Dotted', 'elementor' ),
					'dashed' => __( 'Dashed', 'elementor' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-icon' => 'border-style: {{VALUE}}',
				],
			],
			[
				'position' => [
					'at' => 'after',
					'of' => 'bg_color_hover',
				],
			]
		);
		$this->add_control(
			'br_color',
			[
				'label'       => __( 'Border Color', 'elementor' ),
				'description' => esc_html__( 'Controls the icon border color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .elementor-icon-list-icon' => 'border-color: {{VALUE}};',
				],
			],
			[
				'position' => [
					'at' => 'after',
					'of' => 'border_style',
				],
			]
		);
		$this->add_control(
			'br_color_hover',
			[
				'label'       => __( 'Border Hover Color', 'elementor' ),
				'description' => esc_html__( 'Controls the icon border hover color.', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon' => 'border-color: {{VALUE}};',
				],
			],
			[
				'position' => [
					'at' => 'after',
					'of' => 'br_color',
				],
			]
		);
		$this->add_control(
			'border_radius',
			[
				'label'       => __( 'Border Radius', 'elementor' ),
				'description' => esc_html__( 'Controls the icon border radius.', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'selectors'   => [
					'{{WRAPPER}} .elementor-icon-list-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
			[
				'position' => [
					'at' => 'after',
					'of' => 'br_color_hover',
				],
			]
		);
		$this->add_control(
			'border_width',
			[
				'label'       => __( 'Border Width', 'elementor' ),
				'description' => esc_html__( 'Controls the icon border width.', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'selectors'   => [
					'{{WRAPPER}} .elementor-icon-list-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
			[
				'position' => [
					'at' => 'after',
					'of' => 'border_radius',
				],
			]
		);
		$this->update_control(
			'icon_self_align',
			array(
				'description' => esc_html__( 'Controls the icon alignment.', 'riode-core' ),
			)
		);
		$this->update_control(
			'text_color',
			array(
				'description' => esc_html__( 'Controls the list text color.', 'riode-core' ),
			)
		);
		$this->update_control(
			'text_color_hover',
			array(
				'description' => esc_html__( 'Controls the list text hover color.', 'riode-core' ),
			)
		);
		$this->update_control(
			'text_indent',
			array(
				'description' => esc_html__( 'Controls the text indent.', 'riode-core' ),
			)
		);
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-iconlist-render.php';
	}

	protected function content_template() {
		?>
		<#
			view.addRenderAttribute( 'icon_list', 'class', 'elementor-icon-list-items' );
			view.addRenderAttribute( 'list_item', 'class', 'elementor-icon-list-item' );

			if ( 'inline' == settings.view ) {
				view.addRenderAttribute( 'icon_list', 'class', 'elementor-inline-items' );
				view.addRenderAttribute( 'list_item', 'class', 'elementor-inline-item' );
			}
			var iconsHTML = {},
				migrated = {};
		#>
		<# if ( settings.icon_list ) { #>
			<ul {{{ view.getRenderAttributeString( 'icon_list' ) }}}>
			<# _.each( settings.icon_list, function( item, index ) {

					var iconTextKey = view.getRepeaterSettingKey( 'text', 'icon_list', index );

					view.addRenderAttribute( iconTextKey, 'class', 'elementor-icon-list-text' );

					view.addInlineEditingAttributes( iconTextKey ); #>

					<li {{{ view.getRenderAttributeString( 'list_item' ) }}}>
						<# if ( item.link && item.link.url ) { #>
							<a href="{{ item.link.url }}">
						<# } #>
						<# if ( item.icon || item.selected_icon.value ) { #>
						<span class="elementor-icon-list-icon">
							<#
								iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
								migrated[ index ] = elementor.helpers.isIconMigrated( item, 'selected_icon' );
								if ( iconsHTML[ index ] && iconsHTML[ index ].rendered && ( ! item.icon || migrated[ index ] ) ) { #>
									{{{ iconsHTML[ index ].value }}}
								<# } else { #>
									<i class="{{ item.icon }}" aria-hidden="true"></i>
								<# }
							#>
						</span>
						<# } #>
						<span {{{ view.getRenderAttributeString( iconTextKey ) }}}>{{{ item.text }}}</span>
						<# if ( item.link && item.link.url ) { #>
							</a>
						<# } #>
					</li>
				<#
				} ); #>
			</ul>
		<#	} #>

		<?php
	}
}
