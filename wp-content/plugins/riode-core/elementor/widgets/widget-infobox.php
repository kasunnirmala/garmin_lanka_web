<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Infobox Widget
 *
 * Riode Widget to display custom infobox.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;

class Riode_Infobox_Elementor_Widget extends \Elementor\Widget_Icon_Box {

	public function get_name() {
		return 'riode_widget_infobox';
	}

	public function get_title() {
		return esc_html__( 'Info Box', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-info-box';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'icon box', 'info box' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		parent::register_controls();

		$this->update_control(
			'selected_icon',
			array(
				'default'     => array(
					'value'   => 'd-icon-truck',
					'library' => 'riode',
				),
				'description' => esc_html__( 'Allows you choose any icon in the library for your icon box.​', 'riode-core' ),
			)
		);
		$this->update_control(
			'view',
			array(
				'description' => esc_html__( 'Select any display type of your icon box among default, stacked and framed types.​', 'riode-core' ),
			)
		);
		$this->update_control(
			'shape',
			array(
				'description' => esc_html__( 'Select a certain shape among circl and square.​', 'riode-core' ),
			)
		);
		$this->add_control(
			'enable_hover_effect',
			array(
				'label'       => esc_html__( 'Add Hover Effect?', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => esc_html__( 'Determine whether your icon has hover effect or not.​', 'riode-core' ),
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'view',
				),
			)
		);
		$this->add_control(
			'icon_hover_effect',
			array(
				'label'        => __( 'Hover Effect', 'riode-core' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'pushup'    => __( 'Push Up', 'riode-core' ),
					'pushdown'  => __( 'Push Down', 'riode-core' ),
					'pushleft'  => __( 'Push Left', 'riode-core' ),
					'pushright' => __( 'Push Right', 'riode-core' ),
				),
				'default'      => 'pushup',
				'prefix_class' => 'infobox-anim infobox-anim-',
				'condition'    => array(
					'enable_hover_effect' => 'yes',
				),
				'description'  => esc_html__( 'Select any hover effect you want to implement in your icon box.​', 'riode-core' ),
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'enable_hover_effect',
				),
			)
		);
		$this->update_control(
			'title_text',
			array(
				'default'     => __( 'Free Shipping & Return', 'riode-core' ),
				'description' => esc_html__( 'Type a title for your icon box.​', 'riode-core' ),
			)
		);

		$this->update_control(
			'description_text',
			array(
				'default'     => __( 'Free shipping on orders over $99', 'riode-core' ),
				'description' => esc_html__( 'Type a description for your icon box.', 'riode-core' ),
			)
		);
		$this->update_control(
			'link',
			array(
				'description' => esc_html__( 'Type a certain URL to link through.', 'riode-core' ),
			)
		);
		$this->update_control(
			'position',
			array(
				'description' => esc_html__( 'Select the icon position of your icon box among left, top and right.', 'riode-core' ),
			)
		);
		$this->update_control(
			'title_size',
			array(
				'description' => esc_html__( 'Select the HTML Heading tag for icon box title from H1 to H6 and Div, Span and P tag, too.', 'riode-core' ),
			)
		);
		$this->update_control(
			'primary_color',
			array(
				'default'     => '#27c',
				'selectors'   => array(
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon, {{WRAPPER}}.elementor-view-framed.infobox-anim .elementor-icon-box-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
				),
				'description' => esc_html__( 'Controls the icon background color in Stacked type and controls the icon and icon border color in Framed type.', 'riode-core' ),
			)
		);
		$this->update_control(
			'secondary_color',
			array(
				'default'     => '#fff',
				'description' => esc_html__( 'Controls the icon color in Stacked type and controls the icon background color in Framed type.', 'riode-core' ),
			)
		);
		$this->update_control(
			'hover_primary_color',
			array(
				'description' => esc_html__( 'Controls the icon hover background color in Stacked type and controls the icon hover and icon border hover color in Framed type.', 'riode-core' ),
			)
		);
		$this->update_control(
			'hover_secondary_color',
			array(
				'description' => esc_html__( 'Controls the icon hover color in Stacked type and controls the icon hover background color in Framed type.', 'riode-core' ),
			)
		);
		$this->update_control(
			'icon_space',
			array(
				'description' => esc_html__( 'Controls the gap between the icon and the content.', 'riode-core' ),
			)
		);
		$this->update_control(
			'icon_size',
			array(
				'description' => esc_html__( 'Controls the icon size.', 'riode-core' ),
			)
		);
		$this->update_control(
			'icon_padding',
			array(
				'description' => esc_html__( 'Controls the padding of icon wrap.', 'riode-core' ),
			)
		);
		$this->update_control(
			'rotate',
			array(
				'description' => esc_html__( 'Controls the angle of rotate effect.', 'riode-core' ),
			)
		);
		$this->update_control(
			'border_width',
			array(
				'description' => esc_html__( 'Controls the border width of the icon wrap.', 'riode-core' ),
			)
		);
		$this->update_control(
			'border_radius',
			array(
				'description' => esc_html__( 'Controls the border radius of the icon wrap.', 'riode-core' ),
			)
		);
		$this->add_control(
			'border_color',
			array(
				'label'       => __( 'Border Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'selectors'   => array(
					'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'border-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed.infobox-anim .elementor-icon-box-icon' => 'background-color: {{VALUE}};',
				),
				'condition'   => array(
					'view' => 'framed',
				),
				'description' => esc_html__( 'Controls the icon border color. *On hover effect, also controls the icon wrapper background.​', 'riode-core' ),
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'border_radius',
				),
			)
		);
		$this->update_control(
			'text_align',
			array(
				'description' => esc_html__( 'Controls the alignment of your icon box.', 'riode-core' ),
			)
		);
		$this->update_control(
			'content_vertical_alignment',
			array(
				'description' => esc_html__( 'Controls the vertical alignment of your icon box.', 'riode-core' ),
			)
		);
		$this->update_control(
			'title_bottom_space',
			array(
				'description' => esc_html__( 'Controls bottom space of info box title.', 'riode-core' ),
			)
		);
		$this->update_control(
			'title_color',
			array(
				'description' => esc_html__( 'Controls the title color.', 'riode-core' ),
			)
		);
		$this->update_control(
			'title_typography',
			array(
				'description' => esc_html__( 'Controls the title typography.', 'riode-core' ),
			)
		);
		$this->update_control(
			'description_color',
			array(
				'description' => esc_html__( 'Controls the description color.', 'riode-core' ),
			)
		);
		$this->update_control(
			'description_typography',
			array(
				'description' => esc_html__( 'Controls the description typography.', 'riode-core' ),
			)
		);

		$this->remove_control( 'hover_animation' );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-infobox-render.php';
	}

	protected function content_template() {
		?>
		<#
		var link = settings.link.url ? 'href="' + settings.link.url + '"' : '',
			iconTag = link ? 'a' : 'span',
			iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
			migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' );

		view.addRenderAttribute( 'description_text', 'class', 'elementor-icon-box-description' );

		view.addInlineEditingAttributes( 'title_text', 'none' );
		view.addInlineEditingAttributes( 'description_text' );
		#>
		<div class="elementor-icon-box-wrapper">
			<# if ( settings.icon || settings.selected_icon ) { #>
			<div class="elementor-icon-box-icon">
				<{{{ iconTag + ' ' + link }}} class="elementor-icon elementor-animation-{{ settings.hover_animation }}">
					<# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
						{{{ iconHTML.value }}}
						<# } else { #>
							<i class="{{ settings.icon }}" aria-hidden="true"></i>
						<# } #>
				</{{{ iconTag }}}>
			</div>
			<# } #>
			<div class="elementor-icon-box-content">
				<{{{ settings.title_size }}} class="elementor-icon-box-title">
					<{{{ iconTag + ' ' + link }}} {{{ view.getRenderAttributeString( 'title_text' ) }}}>{{{ settings.title_text }}}</{{{ iconTag }}}>
				</{{{ settings.title_size }}}>
				<# if ( settings.description_text ) { #>
				<p {{{ view.getRenderAttributeString( 'description_text' ) }}}>{{{ settings.description_text }}}</p>
				<# } #>
			</div>
		</div>
		<?php
	}
}
