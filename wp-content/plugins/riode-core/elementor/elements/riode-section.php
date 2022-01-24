<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Section Element
 *
 * Extended Element_Section Class
 * Added Slider, Banner, Creative Grid Functions.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use ELementor\Group_Control_Background;
use ELementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Embed;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Modules\DynamicTags\Module as TagsModule;

add_action( 'elementor/frontend/section/before_render', 'riode_section_render_attributes', 10, 1 );

class Riode_Element_Section extends Elementor\Element_Section {
	public $is_dom_optimization_active = false;
	private static $presets            = array();

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );

		if ( riode_elementor_if_dom_optimization() ) {
			$this->is_dom_optimization_active = true;
		}

		add_action( 'elementor/shapes/additional_shapes', array( $this, 'add_more_shape_dividers' ) );
	}

	public static function get_presets( $columns_count = null, $preset_index = null ) {
		if ( ! self::$presets ) {
			self::init_presets();
		}

		$presets = self::$presets;

		if ( null !== $columns_count ) {
			$presets = $presets[ $columns_count ];
		}

		if ( null !== $preset_index ) {
			$presets = $presets[ $preset_index ];
		}

		return $presets;
	}
	public static function init_presets() {

		$additional_presets = array(
			2 => array(
				array(
					'preset' => array( 'flex-1', 'flex-auto' ),
				),
				array(
					'preset' => array( 33, 66 ),
				),
				array(
					'preset' => array( 66, 33 ),
				),
			),
			3 => array(
				array(
					'preset' => array( 'flex-1', 'flex-auto', 'flex-1' ),
				),
				array(
					'preset' => array( 'flex-auto', 'flex-1', 'flex-auto' ),
				),
				array(
					'preset' => array( 25, 25, 50 ),
				),
				array(
					'preset' => array( 50, 25, 25 ),
				),
				array(
					'preset' => array( 25, 50, 25 ),
				),
				array(
					'preset' => array( 16, 66, 16 ),
				),
			),
		);

		foreach ( range( 1, 10 ) as $columns_count ) {
			self::$presets[ $columns_count ] = array(
				array(
					'preset' => array(),
				),
			);

			$preset_unit = floor( 1 / $columns_count * 100 );

			for ( $i = 0; $i < $columns_count; $i++ ) {
				self::$presets[ $columns_count ][0]['preset'][] = $preset_unit;
			}

			if ( ! empty( $additional_presets[ $columns_count ] ) ) {
				self::$presets[ $columns_count ] = array_merge( self::$presets[ $columns_count ], $additional_presets[ $columns_count ] );
			}

			foreach ( self::$presets[ $columns_count ] as $preset_index => & $preset ) {
				$preset['key'] = $columns_count . $preset_index;
			}
		}
	}

	protected function get_initial_config() {
		global $post;
		if ( ( $post && 'riode_template' == $post->post_type && ( 'header' == get_post_meta( $post->ID, 'riode_template_type', true ) || 'footer' == get_post_meta( $post->ID, 'riode_template_type', true ) ) ) ) {
			$config = parent::get_initial_config();

			$config['presets']       = self::get_presets();
			$config['controls']      = $this->get_controls();
			$config['tabs_controls'] = $this->get_tabs_controls();

			return $config;
		} else {
			return parent::get_initial_config();
		}
	}


	protected function get_html_tag() {
		$html_tag = $this->get_settings( 'html_tag' );

		if ( empty( $html_tag ) ) {
			$html_tag = 'section';
		}

		return $html_tag;
	}

	protected function print_shape_divider( $side ) {
		$settings         = $this->get_active_settings();
		$base_setting_key = "shape_divider_$side";
		$negative         = ! empty( $settings[ $base_setting_key . '_negative' ] );

		if ( 'custom' != $settings[ $base_setting_key ] ) {
			$shape_path = Elementor\Shapes::get_shape_path( $settings[ $base_setting_key ], $negative );
			if ( ! is_file( $shape_path ) || ! is_readable( $shape_path ) ) {
				return;
			}
		}
		?>
		<div class="elementor-shape elementor-shape-<?php echo esc_attr( $side ); ?>" data-negative="<?php echo var_export( $negative ); ?>">
			<?php
			if ( 'custom' != $settings[ $base_setting_key ] ) {
				echo file_get_contents( $shape_path );
			} else {
				if ( isset( $settings[ "shape_divider_{$side}_custom" ] ) && isset( $settings[ "shape_divider_{$side}_custom" ]['value'] ) ) {
					\ELEMENTOR\Icons_Manager::render_icon( $settings[ "shape_divider_{$side}_custom" ] );
				}
			}
			?>
		</div>
		<?php
	}

	protected function register_controls() {
		global $post;

		$header = false;

		if ( is_admin() ) {
			if ( ! riode_is_elementor_preview() || ( $post && 'riode_template' == $post->post_type && 'header' == get_post_meta( $post->ID, 'riode_template_type', true ) ) ) {
				$header = true;
			}
		} elseif ( function_exists( 'riode_get_layout_value' ) ) {
			if ( riode_get_layout_value( 'header', 'id' ) && -1 != riode_get_layout_value( 'header', 'id' ) ) {
				$header = true;
			}
		}

		parent::register_controls();

		// Overide Elementor Controls to easier.
		$this->remove_control( 'section_typo' );
		$this->start_controls_section(
			'section_typo',
			array(
				'label' => esc_html__( 'Typography', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->remove_control( 'heading_color' );
		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__( 'Heading Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
				),
				'separator' => 'none',
			)
		);

		$this->remove_control( 'color_text' );
		$this->add_control(
			'color_text',
			array(
				'label'     => esc_html__( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.elementor .elementor-element-{{ID}}' => 'color: {{VALUE}};',
				),
			)
		);

		$this->remove_control( 'color_link' );
		$this->add_control(
			'color_link',
			array(
				'label'     => esc_html__( 'Link Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.elementor-element-{{ID}} a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->remove_control( 'color_link_hover' );
		$this->add_control(
			'color_link_hover',
			array(
				'label'     => esc_html__( 'Link Hover Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.elementor-element-{{ID}} a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->remove_control( 'text_align' );
		$this->add_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Text Align', 'elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} > .elementor-container' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Add Theme Controls
		$this->start_controls_section(
			'section_additional',
			array(
				'label' => esc_html__( 'Riode Settings', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);

			$this->add_control(
				'section_content_type',
				array(
					'label'     => esc_html__( 'Wrap with Container-Fluid', 'riode-core' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'layout' => 'boxed',
					),
				)
			);

		if ( $header ) {
			$this->add_responsive_control(
				'section_content_sticky',
				array(
					'label' => esc_html__( 'Sticky Content', 'riode-core' ),
					'type'  => Controls_Manager::SWITCHER,
				)
			);

			$this->add_responsive_control(
				'section_sticky_padding',
				array(
					'label'      => esc_html__( 'Sticky Padding', 'riode-core' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array(
						'px',
						'%',
					),
					'selectors'  => array(
						'{{WRAPPER}}.fixed' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition'  => array(
						'section_content_sticky' => 'yes',
					),
				)
			);

			$this->add_control(
				'section_sticky_bg',
				array(
					'label'     => esc_html__( 'Sticky Background', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}}.fixed' => 'background-color: {{VALUE}}',
					),
					'separator' => 'after',
					'condition' => array(
						'section_content_sticky' => 'yes',
					),
				)
			);
		}

			$this->add_control(
				'use_as',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Use Section For', 'riode-core' ),
					'default' => '',
					'options' => array(
						''          => esc_html__( 'Default', 'riode-core' ),
						'slider'    => esc_html__( 'Slider', 'riode-core' ),
						'tab'       => esc_html__( 'Tab', 'riode-core' ),
						'accordion' => esc_html__( 'Accordion', 'riode-core' ),
						'banner'    => esc_html__( 'Banner', 'riode-core' ),
						'creative'  => esc_html__( 'Creative Grid', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'section_tab_description',
				array(
					'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s Use %2$schild columns%3$s as %2$stab content%3$s by using riode settings%4$s', 'riode-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
					'type'        => 'riode_description',
					'condition'   => array(
						'use_as' => 'tab',
					),
				)
			);

			$this->add_control(
				'section_accordion_description',
				array(
					'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s Use %2$schild columns%3$s as %2$saccordion content%3$s by using riode settings%4$s', 'riode-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
					'type'        => 'riode_description',
					'condition'   => array(
						'use_as' => 'accordion',
					),
				)
			);

			$this->add_control(
				'section_banner_description',
				array(
					'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s Use %2$schild columns%3$s as %2$sbanner layer%3$s by using riode settings%4$s', 'riode-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
					'type'        => 'riode_description',
					'condition'   => array(
						'use_as' => 'banner',
					),
				)
			);

			$this->add_control(
				'section_creative_description',
				array(
					'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s Use %2$schild columns%3$s as %2$sgrid items%3$s by using riode settings%4$s', 'riode-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
					'type'        => 'riode_description',
					'condition'   => array(
						'use_as' => 'creative',
					),
				)
			);

			riode_elementor_grid_layout_controls( $this, 'use_as' );

			riode_elementor_slider_layout_controls( $this, 'use_as' );

		$this->end_controls_section();

		// Add Banner Controls
		$this->start_controls_section(
			'section_banner_options',
			array(
				'label'     => esc_html__( 'Banner', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'banner',
				),
			)
		);

			riode_elementor_banner_layout_controls( $this, 'use_as' );

			$this->add_control(
				'parallax',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Enable Parallax', 'riode-core' ),
					'description' => esc_html__( 'Set to enable parallax effect for banner.', 'riode-core' ),
				)
			);

			$this->add_control(
				'parallax_speed',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Parallax Speed', 'riode-core' ),
					'description' => esc_html__( 'Change speed of banner parallax effect.', 'riode-core' ),
					'condition'   => array(
						'use_as'   => 'banner',
						'parallax' => 'yes',
					),
					'default'     => array(
						'size' => 1.5,
						'unit' => 'px',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
					),
				)
			);

			$this->add_control(
				'parallax_offset',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Parallax Offset', 'riode-core' ),
					'description' => esc_html__( 'Determine offset value of parallax effect to show different parts on screen.', 'riode-core' ),
					'condition'   => array(
						'use_as'   => 'banner',
						'parallax' => 'yes',
					),
					'default'     => array(
						'size' => 0,
						'unit' => 'px',
					),
					'size_units'  => array(
						'px',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => -300,
							'max'  => 300,
						),
					),
				)
			);

			$this->add_control(
				'parallax_height',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Parallax Height (%)', 'riode-core' ),
					'description' => esc_html__( 'Change height of parallax background image.', 'riode-core' ),
					'condition'   => array(
						'use_as'   => 'banner',
						'parallax' => 'yes',
					),
					'separator'   => 'after',
					'default'     => array(
						'size' => 180,
						'unit' => 'px',
					),
					'size_units'  => array(
						'px',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 300,
						),
					),
				)
			);

			$this->add_control(
				'video_banner_switch',
				array(
					'label'       => esc_html__( 'Enable Video', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'use_as' => 'banner',
					),
					'description' => esc_html__( 'Allows your banner to have a video feature.', 'riode-core' ),
				)
			);

		$this->end_controls_section();

		riode_elementor_slider_style_controls( $this, 'use_as' );

		$this->start_controls_section(
			'tab_content',
			array(
				'label'     => esc_html__( 'Tab', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'tab',
				),
			)
		);

			riode_elementor_tab_layout_controls( $this, 'use_as' );

			riode_elementor_tab_style_controls( $this, 'use_as' );

		$this->end_controls_section();

		$this->start_controls_section(
			'accordion_style',
			array(
				'label'     => esc_html__( 'Accordion', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'accordion',
				),
			)
		);

			// Accordion Controls
			$this->add_control(
				'accordion_type',
				array(
					'label'       => esc_html__( 'Accordion Type', 'riode-core' ),
					'description' => esc_html__( 'Choose the design style for accordion.', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => array(
						''        => esc_html__( 'Default', 'riode-core' ),
						'shadow'  => esc_html__( 'Shadow', 'riode-core' ),
						'stacked' => esc_html__( 'Stacked', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'accordion_card_style',
				array(
					'label'     => esc_html__( 'Card', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'accordion_card_space',
				array(
					'label'       => esc_html__( 'Card Space', 'riode-core' ),
					'description' => esc_html__( 'Set the space between each card items.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array( 'px', 'rem', 'em' ),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .card:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'.elementor-element-{{ID}} .accordion-shadow .card' => 'margin-bottom: 0; border-bottom-width: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$this->add_control(
				'accordion_card_bg',
				array(
					'label'       => esc_html__( 'Background Color', 'riode-core' ),
					'description' => esc_html__( 'Set background color of card including card header and card body.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						// Stronger selector to avoid section style from overwriting
						'.elementor-element-{{ID}} .card' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'        => 'accordion_box_shadow',
					'description' => esc_html__( 'Set box shadow of entire accordion.', 'riode-core' ),
					'selector'    => '.elementor-element-{{ID}} .accordion',
				)
			);

			$this->add_control(
				'accordion_card_header_style',
				array(
					'label'     => esc_html__( 'Card Header', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'accordion_icon',
				array(
					'label'            => esc_html__( 'Toggle Icon', 'riode-core' ),
					'description'      => esc_html__( 'Choose inactive(closed) toggle icon of card header.', 'riode-core' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => array(
						'value'   => 'd-icon-plus',
						'library' => '',
					),
					'recommended'      => array(
						'fa-solid'   => array(
							'chevron-down',
							'angle-down',
							'angle-double-down',
							'caret-down',
							'caret-square-down',
						),
						'fa-regular' => array(
							'caret-square-down',
						),
					),
					'skin'             => 'inline',
					'label_block'      => false,
				)
			);

			$this->add_control(
				'accordion_active_icon',
				array(
					'label'            => esc_html__( 'Active Toggle Icon', 'riode-core' ),
					'description'      => esc_html__( 'Choose active(opened) toggle icon of card header.', 'riode-core' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon_active',
					'default'          => array(
						'value'   => 'd-icon-minus',
						'library' => '',
					),
					'recommended'      => array(
						'fa-solid'   => array(
							'chevron-up',
							'angle-up',
							'angle-double-up',
							'caret-up',
							'caret-square-up',
						),
						'fa-regular' => array(
							'caret-square-up',
						),
					),
					'skin'             => 'inline',
					'label_block'      => false,
				)
			);

			$this->add_control(
				'toggle_icon_size',
				array(
					'type'        => Controls_Manager::SLIDER,
					'label'       => esc_html__( 'Toggle Icon Size', 'riode-core' ),
					'description' => esc_html__( 'Set size of card header toggle icon.', 'riode-core' ),
					'size_units'  => array( 'px', 'rem', 'em' ),
					'range'       => array(
						'px'  => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 100,
						),
						'rem' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
						'em'  => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .toggle-icon' => 'font-size:  {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'        => 'panel_header_typography',
					'label'       => esc_html__( 'Typography', 'riode-core' ),
					'description' => esc_html__( 'Set typography of card headers.', 'riode-core' ),
					'selector'    => '.elementor-element-{{ID}} .card-header a',
				)
			);

			$this->start_controls_tabs( 'accordion_color_tabs' );

				$this->start_controls_tab(
					'accordion_color_normal_tab',
					array(
						'label'       => esc_html__( 'Normal', 'riode-core' ),
						'description' => esc_html__( 'Set text color, background color and border color of normal and active card headers.', 'riode-core' ),
					)
				);

					$this->add_control(
						'accordion_bg_color',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_color',
						array(
							'label'     => esc_html__( 'Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_bd_color',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'accordion_color_active_tab',
					array(
						'label' => esc_html__( 'Active', 'riode-core' ),
					)
				);

					$this->add_control(
						'accordion_bg_color_active',
						array(
							'label'     => esc_html__( 'Background Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a.collapse, .elementor-element-{{ID}} .card-header a:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_color_active',
						array(
							'label'     => esc_html__( 'Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a.collapse, .elementor-element-{{ID}} .card-header a:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'accordion_bd_color_active',
						array(
							'label'     => esc_html__( 'Border Color', 'riode-core' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								// Stronger selector to avoid section style from overwriting
								'.elementor-element-{{ID}} .card-header a.collapse, .elementor-element-{{ID}} .card-header a:hover' => 'border-color: {{VALUE}};',
							),
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'accordion_header_pad',
				array(
					'label'       => esc_html__( 'Padding', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'description' => esc_html__( 'Set padding of card headers.', 'riode-core' ),
					'size_units'  => array(
						'px',
						'%',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .card-header a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.elementor-element-{{ID}} .card-header .opened, .elementor-element-{{ID}} .card-header .closed' => 'right: {{RIGHT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'accordion_card_body_style',
				array(
					'label'     => esc_html__( 'Card Body', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_responsive_control(
				'accordion_body_pad',
				array(
					'label'       => esc_html__( 'Padding', 'riode-core' ),
					'description' => esc_html__( 'Set padding of card body content.', 'riode-core' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => array(
						'px',
						'%',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .card .card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'creative_grid_section',
			array(
				'label'     => esc_html__( 'Creative Grid', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'creative',
				),
			)
		);

		riode_el_creative_isotope_layout_controls( $this, 'use_as', 'section' );

		$this->end_controls_section();

		// Section Video Options
		$this->start_controls_section(
			'riode_video_section',
			array(
				'label'     => esc_html__( 'Riode Video Options', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as'              => 'banner',
					'video_banner_switch' => 'yes',
				),
			)
		);

		$this->add_control(
			'video_type',
			array(
				'label'       => esc_html__( 'Source', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'youtube',
				'options'     => array(
					'youtube'     => esc_html__( 'YouTube', 'riode-core' ),
					'vimeo'       => esc_html__( 'Vimeo', 'riode-core' ),
					'dailymotion' => esc_html__( 'Dailymotion', 'riode-core' ),
					'hosted'      => esc_html__( 'Self Hosted', 'riode-core' ),
				),
				'description' => esc_html__( 'Select a certain video upload mode among Youtube, Vimeo, Dailymotion and Self Hosted modes.', 'riode-core' ),
			)
		);

		$this->add_control(
			'youtube_url',
			array(
				'label'       => esc_html__( 'Link', 'riode-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'placeholder' => esc_html__( 'Enter your URL (YouTube)', 'riode-core' ),
				'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'youtube',
				),
				'description' => esc_html__( 'Type a certain URL of a video you want to upload.', 'riode-core' ),
			)
		);

		$this->add_control(
			'vimeo_url',
			array(
				'label'       => esc_html__( 'Link', 'riode-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'placeholder' => esc_html__( 'Enter your URL', 'riode-core' ) . ' (Vimeo)',
				'default'     => 'https://vimeo.com/235215203',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'vimeo',
				),
				'description' => esc_html__( 'Type a certain URL of a video you want to upload.', 'riode-core' ),
			)
		);

		$this->add_control(
			'dailymotion_url',
			array(
				'label'       => esc_html__( 'Link', 'riode-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'placeholder' => esc_html__( 'Enter your URL (Dailymotion)', 'riode-core' ),
				'default'     => 'https://www.dailymotion.com/video/x6tqhqb',
				'label_block' => true,
				'condition'   => array(
					'video_type' => 'dailymotion',
				),
				'description' => esc_html__( 'Type a certain URL of a video you want to upload.', 'riode-core' ),
			)
		);

		$this->add_control(
			'insert_url',
			array(
				'label'       => esc_html__( 'External URL', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					'video_type' => 'hosted',
				),
				'description' => esc_html__( 'Enables you to upload a video by uploading from a library or typing a certain URL.', 'riode-core' ),
			)
		);

		$this->add_control(
			'hosted_url',
			array(
				'label'      => esc_html__( 'Choose File', 'riode-core' ),
				'type'       => Controls_Manager::MEDIA,
				'dynamic'    => array(
					'active'     => true,
					'categories' => array(
						TagsModule::MEDIA_CATEGORY,
					),
				),
				'media_type' => 'video',
				'condition'  => array(
					'video_type' => 'hosted',
					'insert_url' => '',
				),
			)
		);

		$this->add_control(
			'external_url',
			array(
				'label'        => esc_html__( 'URL', 'riode-core' ),
				'type'         => Controls_Manager::URL,
				'autocomplete' => false,
				'options'      => false,
				'label_block'  => true,
				'show_label'   => false,
				'dynamic'      => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'media_type'   => 'video',
				'placeholder'  => esc_html__( 'Enter your URL', 'riode-core' ),
				'condition'    => array(
					'video_type' => 'hosted',
					'insert_url' => 'yes',
				),
			)
		);

		$this->add_control(
			'video_options',
			array(
				'label'     => esc_html__( 'Video Options', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'video_autoplay',
			array(
				'label'       => esc_html__( 'Autoplay', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'description' => esc_html__( 'Toggle for making your video play by itself.', 'riode-core' ),
			)
		);

		$this->add_control(
			'video_mute',
			array(
				'label'       => esc_html__( 'Mute', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Toggle for making your video mute or not.', 'riode-core' ),
			)
		);

		$this->add_control(
			'video_loop',
			array(
				'label'       => esc_html__( 'Loop', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					'video_type!' => 'dailymotion',
				),
				'description' => esc_html__( 'Toggle for making your video loop or not.', 'riode-core' ),
			)
		);

		$this->add_control(
			'video_controls',
			array(
				'label'       => esc_html__( 'Player Controls', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Hide', 'riode-core' ),
				'label_on'    => esc_html__( 'Show', 'riode-core' ),
				'default'     => 'yes',
				'condition'   => array(
					'video_type!' => 'vimeo',
				),
				'description' => esc_html__( 'Toggle for making your video has control panel or not.', 'riode-core' ),
			)
		);

		$this->add_control(
			'showinfo',
			array(
				'label'       => esc_html__( 'Video Info', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Hide', 'riode-core' ),
				'label_on'    => esc_html__( 'Show', 'riode-core' ),
				'default'     => 'yes',
				'condition'   => array(
					'video_type' => array( 'dailymotion' ),
				),
				'description' => esc_html__( 'Toggle for showing your video information or not.', 'riode-core' ),
			)
		);

		$this->add_control(
			'modestbranding',
			array(
				'label'       => esc_html__( 'Modest Branding', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					'video_type' => array( 'youtube' ),
					'controls'   => 'yes',
				),
				'description' => esc_html__( 'Toggle for showing the modest brand of your video or not.', 'riode-core' ),
			)
		);

		$this->add_control(
			'logo',
			array(
				'label'       => esc_html__( 'Logo', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Hide', 'riode-core' ),
				'label_on'    => esc_html__( 'Show', 'riode-core' ),
				'default'     => 'yes',
				'condition'   => array(
					'video_type' => array( 'dailymotion' ),
				),
				'description' => esc_html__( 'Toggle for showing a log of your video or not.', 'riode-core' ),
			)
		);

		$this->add_control(
			'control_color',
			array(
				'label'       => esc_html__( 'Controls Color', 'riode-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'condition'   => array(
					'video_type' => array( 'vimeo', 'dailymotion' ),
				),
				'description' => esc_html__( 'Controls the video controls color.', 'riode-core' ),
			)
		);

		// YouTube.
		$this->add_control(
			'yt_privacy',
			array(
				'label'       => esc_html__( 'Privacy Mode', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'riode-core' ),
				'condition'   => array(
					'video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'rel',
			array(
				'label'       => esc_html__( 'Suggested Videos', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''    => esc_html__( 'Current Video Channel', 'riode-core' ),
					'yes' => esc_html__( 'Any Video', 'riode-core' ),
				),
				'condition'   => array(
					'video_type' => 'youtube',
				),
				'description' => esc_html__( 'Select a certain suggested video among Current Video Channel and Any Video.', 'riode-core' ),
			)
		);

		// Vimeo.
		$this->add_control(
			'vimeo_title',
			array(
				'label'       => esc_html__( 'Intro Title', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Hide', 'riode-core' ),
				'label_on'    => esc_html__( 'Show', 'riode-core' ),
				'default'     => 'yes',
				'condition'   => array(
					'video_type' => 'vimeo',
				),
				'description' => esc_html__( 'Toggle for showing a title of your video or not.', 'riode-core' ),
			)
		);

		$this->add_control(
			'vimeo_portrait',
			array(
				'label'       => esc_html__( 'Intro Portrait', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Hide', 'riode-core' ),
				'label_on'    => esc_html__( 'Show', 'riode-core' ),
				'default'     => 'yes',
				'condition'   => array(
					'video_type' => 'vimeo',
				),
				'description' => esc_html__( 'Toggle for showing an intro portrait of your video or not.', 'riode-core' ),
			)
		);

		$this->add_control(
			'vimeo_byline',
			array(
				'label'       => esc_html__( 'Intro Byline', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Hide', 'riode-core' ),
				'label_on'    => esc_html__( 'Show', 'riode-core' ),
				'default'     => 'yes',
				'condition'   => array(
					'video_type' => 'vimeo',
				),
				'description' => esc_html__( 'Toggle for showing an intro byline of your video or not.', 'riode-core' ),
			)
		);

		$this->add_control(
			'show_image_overlay',
			array(
				'label'       => esc_html__( 'Image Overlay', 'riode-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_off'   => esc_html__( 'Hide', 'riode-core' ),
				'label_on'    => esc_html__( 'Show', 'riode-core' ),
				'separator'   => 'before',
				'description' => esc_html__( 'Toggle for making your video has image overlay or not.', 'riode-core' ),
			)
		);

		$this->add_control(
			'lightbox',
			array(
				'label'              => esc_html__( 'Lightbox', 'riode-core' ),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'label_off'          => esc_html__( 'Off', 'riode-core' ),
				'label_on'           => esc_html__( 'On', 'riode-core' ),
				'condition'          => array(
					'show_image_overlay' => 'yes',
				),
				'description'        => esc_html__( 'Toggle for making your video has lightbox feature or not.', 'riode-core' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_video_style',
			array(
				'label'     => esc_html__( 'Video', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'use_as'              => 'banner',
					'video_banner_switch' => 'yes',
				),
			)
		);

		$this->add_control(
			'aspect_ratio',
			array(
				'label'              => esc_html__( 'Aspect Ratio', 'riode-core' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'169' => '16:9',
					'219' => '21:9',
					'43'  => '4:3',
					'32'  => '3:2',
					'11'  => '1:1',
					'916' => '9:16',
				),
				'default'            => '169',
				'prefix_class'       => 'elementor-aspect-ratio-',
				'frontend_available' => true,
				'description'        => esc_html__( 'Select a certain aspect ratio for your video.', 'riode-core' ),
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'        => 'video_css_filters',
				'selector'    => '.elementor-element-{{ID}} .elementor-wrapper',
				'description' => esc_html__( 'Controls the CSS filters for your video.', 'riode-core' ),
			)
		);

		$this->add_responsive_control(
			'video_border_radius',
			array(
				'label'       => esc_html__( 'Border Radius', 'riode-core' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array(
					'px',
					'%',
					'rem',
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} .elementor-fit-aspect-ratio' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'description' => esc_html__( 'Controls the video wrapper border radius.', 'riode-core' ),
			)
		);

		$this->add_control(
			'play_icon_title',
			array(
				'label'     => esc_html__( 'Play Icon', 'riode-core' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'play_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.elementor-element-{{ID}} .elementor-custom-embed-play i' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'play_icon_size',
			array(
				'label'     => esc_html__( 'Size', 'riode-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 300,
					),
				),
				'selectors' => array(
					'.elementor-element-{{ID}} .elementor-custom-embed-play i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'           => 'play_icon_text_shadow',
				'selector'       => '.elementor-element-{{ID}} .elementor-custom-embed-play i',
				'fields_options' => array(
					'text_shadow_type' => array(
						'label' => esc_html__( 'Shadow', 'Text Shadow Control', 'riode-core' ),
					),
				),
				'condition'      => array(
					'show_image_overlay' => 'yes',
					'show_play_icon'     => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_lightbox_style',
			array(
				'label'     => esc_html__( 'Lightbox', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'use_as'              => 'banner',
					'video_banner_switch' => 'yes',
					'show_image_overlay'  => 'yes',
					'image_overlay[url]!' => '',
					'lightbox'            => 'yes',
				),
			)
		);

		$this->add_control(
			'lightbox_color',
			array(
				'label'     => esc_html__( 'Background Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'#elementor-lightbox-{{ID}}' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'lightbox_ui_color',
			array(
				'label'     => esc_html__( 'UI Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'lightbox_ui_color_hover',
			array(
				'label'     => esc_html__( 'UI Hover Color', 'riode-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button:hover' => 'color: {{VALUE}}',
				),
				'separator' => 'after',
			)
		);

		$this->add_control(
			'lightbox_video_width',
			array(
				'label'     => esc_html__( 'Content Width', 'riode-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'unit' => '%',
				),
				'range'     => array(
					'%' => array(
						'min' => 30,
					),
				),
				'selectors' => array(
					'(desktop+)#elementor-lightbox-{{ID}} .elementor-video-container' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'lightbox_content_position',
			array(
				'label'                => esc_html__( 'Content Position', 'riode-core' ),
				'type'                 => Controls_Manager::SELECT,
				'frontend_available'   => true,
				'options'              => array(
					''    => esc_html__( 'Center', 'riode-core' ),
					'top' => esc_html__( 'Top', 'riode-core' ),
				),
				'selectors'            => array(
					'#elementor-lightbox-{{ID}} .elementor-video-container' => '{{VALUE}}; transform: translateX(-50%);',
				),
				'selectors_dictionary' => array(
					'top' => 'top: 60px',
				),
			)
		);

		$this->add_responsive_control(
			'lightbox_content_animation',
			array(
				'label'              => esc_html__( 'Entrance Animation', 'riode-core' ),
				'type'               => Controls_Manager::ANIMATION,
				'frontend_available' => true,
			)
		);

		$this->end_controls_section();

		/* adds shape divider options */
		$this->add_responsive_control(
			'shape_divider_top_position',
			array(
				'label'      => esc_html__( 'Shape Position', 'riode-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'condition'  => array(
					'shape_divider_top!' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} > .elementor-shape-top svg' => 'left: {{SIZE}}{{UNIT}};',
				),
			),
			array(
				'position' => array(
					'of' => 'shape_divider_top_height',
				),
			)
		);

		$this->add_responsive_control(
			'shape_divider_bottom_position',
			array(
				'label'      => esc_html__( 'Shape Position', 'riode-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'default'    => array(
					'size' => 50,
					'unit' => '%',
				),
				'condition'  => array(
					'shape_divider_bottom!' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} > .elementor-shape-bottom svg' => 'left: {{SIZE}}{{UNIT}};',
				),
			),
			array(
				'position' => array(
					'of' => 'shape_divider_bottom_height',
				),
			)
		);

		$this->update_control(
			'shape_divider_top_color',
			array(
				'label'     => __( 'Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'shape_divider_top!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} > .elementor-shape-top .elementor-shape-fill' => 'fill: {{UNIT}};',
					'{{WRAPPER}} > .elementor-shape-top svg' => 'fill: {{UNIT}};',
				),
			),
			array(
				'overwrite' => true,
			)
		);

		$this->update_control(
			'shape_divider_bottom_color',
			array(
				'label'     => __( 'Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'shape_divider_bottom!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} > .elementor-shape-bottom .elementor-shape-fill' => 'fill: {{UNIT}};',
					'{{WRAPPER}} > .elementor-shape-bottom svg' => 'fill: {{UNIT}};',
				),
			),
			array(
				'overwrite' => true,
			)
		);

		$this->add_control(
			'shape_divider_top_custom',
			array(
				'label'                  => __( 'Custom SVG', 'porto' ),
				'type'                   => Controls_Manager::ICONS,
				'label_block'            => false,
				'skin'                   => 'inline',
				'exclude_inline_options' => array( 'icon' ),
				'render_type'            => 'none',
				'frontend_available'     => true,
				'condition'              => array(
					'shape_divider_top' => 'custom',
				),
			),
			array(
				'position' => array(
					'of' => 'shape_divider_top',
				),
			)
		);
		$this->add_control(
			'shape_divider_bottom_custom',
			array(
				'label'                  => __( 'Custom SVG', 'porto' ),
				'type'                   => Controls_Manager::ICONS,
				'label_block'            => false,
				'skin'                   => 'inline',
				'exclude_inline_options' => array( 'icon' ),
				'render_type'            => 'none',
				'frontend_available'     => true,
				'condition'              => array(
					'shape_divider_bottom' => 'custom',
				),
			),
			array(
				'position' => array(
					'of' => 'shape_divider_bottom',
				),
			)
		);

		/* adds advanced tab options */
		do_action( 'riode_elementor_add_common_options', $this );
	}

	protected function content_template() {
		?>
		<#
		let content_width = '';
		let extra_class = '';
		let extra_attrs = '';
		let wrapper_class = '';
		let wrapper_attrs = '';

		// Banner
		if ( 'yes' == settings.section_content_type && settings.layout == 'boxed' ) {
			content_width = ' container-fluid';
		}

		if ( 'slider' == settings.use_as ) {
			<?php
				riode_elementor_grid_template();
				riode_elementor_slider_template();
			?>
			settings.gap = 'no';
		} else if ( 'tab' == settings.use_as ) {
			wrapper_class += ' tab element-tab';
			settings.gap = 'no';

			if ( settings.tab_h_type ) {
				wrapper_class += ' tab-' + settings.tab_h_type;
			}

			if ( 'vertical' == settings.tab_type ) {
				wrapper_class += ' tab-vertical';
			}

			switch ( settings.tab_navs_pos ) { // nav position
				case 'center': 
					wrapper_class += ' tab-nav-center';
					break;
				case 'right':
					wrapper_class += ' tab-nav-right';
			}
			#>
			<?php if ( ! $this->is_dom_optimization_active ) { ?>
				<# extra_class += ' tab-content'; #>
			<?php } ?>
			<#
		} else if ( 'accordion' == settings.use_as ) { // use as accordion
			extra_class += ' accordion';
			settings.gap = 'no';

			if ( settings.accordion_type ) {
				extra_class += ' accordion-' + settings.accordion_type;
			}
			extra_attrs += ' data-toggle-icon="' + settings.accordion_icon.value + '"';
			extra_attrs += ' data-toggle-active-icon="' + settings.accordion_active_icon.value + '"';
		} else if ( 'banner' == settings.use_as ) {
			extra_class += ' el-banner banner';
			settings.gap = 'no';

			if ( 'yes' == settings.parallax ) {
				var parallax_options = {
					offset: settings.parallax_offset.size ? settings.parallax_offset.size : 0,
					speed: settings.parallax_speed.size ? 10 / settings.parallax_speed.size : 1.5,
					parallaxHeight: settings.parallax_height.size ? settings.parallax_height.size + '%' : '300%',
				};
				extra_attrs += ' data-class="parallax"';
				extra_attrs += " data-plugin='parallx' data-image-src='" + settings.background_image.url + "' data-parallax-options='" + JSON.stringify(parallax_options) + "'";
			} else {
				extra_class += ' el-banner-fixed banner-fixed';
				if( !settings.fixed_banner ) {
					extra_attrs += ' data-class="use_background"'
				} 
					if ( settings.overlay ) {
						if ( !settings.fixed_banner ) {
							extra_class += ' p-static'; 
						}
						if ( 'light' === settings.overlay ) {
							extra_class += ' overlay-light';
						}
						if ( 'dark' === settings.overlay ) {
							extra_class += ' overlay-dark';
						}
						if ( 'zoom' === settings.overlay ) {
							extra_class += ' overlay-zoom';
						}
						if ( 'zoom_light' === settings.overlay ) {
							extra_class += ' overlay-zoom overlay-light';
						}
						if ( 'zoom_dark' === settings.overlay ) {
							extra_class += ' overlay-zoom overlay-dark';
						}
					if ( 'effect-1' == settings.overlay || 'effect-2' == settings.overlay || 'effect-3' == settings.overlay || 'effect-4' == settings.overlay ) {
						extra_class += ' overlay-' + settings.overlay;
					}
				}
			}

			if ( 'yes' == settings.video_banner_switch ) {
				extra_class += ' video-banner';
			}
		} else if ( 'creative' == settings.use_as ) {
			let height = settings.creative_height.size;
			let mode = settings.creative_mode;
			let height_ratio = settings.creative_height_ratio.size;
			if ( '' == height ) {
				height = 600;
			}
			if ( '' == mode ) {
				mode = 0;
			}
			if ( ! Number(height_ratio) ) {
				height_ratio = 75;
			}

			extra_class += ' grid creative-grid gutter-' + settings.col_sp + ' grid-mode-' + mode;
			if ( settings.grid_float ) {
				extra_class += ' grid-float';
			} else {
				extra_attrs += ' data-plugin="isotope"';
			}

			extra_attrs += ' data-creative-mode=' + mode;
			extra_attrs += ' data-creative-height=' + height;
			extra_attrs += ' data-creative-height-ratio=' + height_ratio;

			if ( 'no' == settings.col_sp ) {
				settings.gap = 'no';
			} else if ( 'xs' == settings.col_sp ) {
				settings.gap = 'no';
			} else if ( 'sm' == settings.col_sp ) {
				settings.gap = 'narrow';
			} else if ( 'md' == settings.col_sp ) {
				settings.gap = 'default';
			} else if ( 'lg' == settings.col_sp ) {
				settings.gap = 'extended';
			}

			<?php if ( ! $this->is_dom_optimization_active ) { ?>
				settings.gap = 'no';
			<?php } ?>
		}

		if ( settings.background_video_link ) {
			let videoAttributes = 'autoplay muted playsinline';

			if ( ! settings.background_play_once ) {
				videoAttributes += ' loop';
			}

			view.addRenderAttribute( 'background-video-container', 'class', 'elementor-background-video-container' );

			if ( ! settings.background_play_on_mobile ) {
				view.addRenderAttribute( 'background-video-container', 'class', 'elementor-hidden-mobile' );
			}
		#>
			<div {{{ view.getRenderAttributeString( 'background-video-container' ) }}}>
				<div class="elementor-background-video-embed"></div>
				<video class="elementor-background-video-hosted elementor-html5-video" {{ videoAttributes }}></video>
			</div>
		<# } #>
		<div class="elementor-background-overlay"></div>
		<div class="elementor-shape elementor-shape-top"></div>
		<div class="elementor-shape elementor-shape-bottom"></div>

		<?php if ( ! $this->is_dom_optimization_active ) { ?>
			<div class="elementor-container{{ content_width }} elementor-column-gap-{{ settings.gap }} {{ wrapper_class }}" {{{ wrapper_attrs }}}>
		<?php } else { ?>
			<div class="elementor-container{{ content_width }} elementor-column-gap-{{ settings.gap }} {{ wrapper_class }}{{ extra_class }}" {{{ wrapper_attrs }}} {{{ extra_attrs }}}>
		<?php } ?>

		<# if ( 'tab' == settings.use_as ) { #>
			<ul class="nav nav-tabs" role="tablist">
			</ul>
			<?php if ( $this->is_dom_optimization_active ) { ?>
				<div class="tab-content">
			<?php } ?>
		<# } #>
		<?php if ( ! $this->is_dom_optimization_active ) { ?>
			<div class="elementor-row{{ extra_class }}"{{{ extra_attrs }}}>
		<?php } ?>
		<# if ( 'banner' == settings.use_as && ( '' !== settings.background_effect || '' !== settings.particle_effect ) ) {
			let background_effectwrapClass = 'background-effect-wrapper ';
			let background_effectClass = 'background-effect ';
			let particle_effectClass   = 'particle-effect ';
			if ( '' !== settings.background_effect ) {
				background_effectClass += settings.background_effect ;
			}
			if ( '' !== settings.particle_effect ) {
				particle_effectClass += settings.particle_effect;
			}
			if ( settings.background_image.url ) { 
				let background_img = '';
				if ( settings.particle_effect && !settings.background_effect ) {
					background_img = '';
					background_effectwrapClass += 'banner-img-visible';
				} else {
					background_img = 'background-image: url(' + settings.background_image.url + '); background-size: cover';
				}
			#>
			<div class="{{background_effectwrapClass}}">
			<div class="{{ background_effectClass }}" style="{{ background_img }}">
			<# if ( '' !== settings.particle_effect ) { #>
				<div class="{{ particle_effectClass }}"></div>
			<# } #> 
			</div>
			</div>
			<# } 
		}
		if ( 'banner' == settings.use_as && 'yes' == settings.fixed_banner && 'yes' != settings.parallax && settings.background_image.url ) { #>
			<figure class="banner-img" style="background-color: {{ settings.background_color }}">
				<#
				let tablet_class = '',
					desktop_class = '';
				if ( settings.background_image_mobile.id ) {
					tablet_class = 'show-only-tablet';
					desktop_class = 'hide-mobile';
					#>
					<img src="{{ settings.background_image_mobile.url }}" class="show-only-mobile" alt="banner">	
					<#
				} else {
					tablet_class = 'show-tablet';
				}
				#>
				<#
				if ( settings.background_image_tablet.id ) {
					desktop_class = 'show-only-desktop';
					#>
					<img src="{{ settings.background_image_tablet.url }}" class="{{ tablet_class }}" alt="banner">	
					<#
				}
				#>
				<img src="{{ settings.background_image.url }}" class="{{ desktop_class }}" alt="banner">
			</figure>
		<# } #>
		<# if ( 'yes' == settings.video_banner_switch && 'banner' == settings.use_as ) {
			view.addRenderAttribute( 'video_widget_wrapper', 'class', 'elementor-element elementor-widget-video riode-section-video' );
			view.addRenderAttribute( 'video_widget_wrapper', 'data-element_type', 'widget' );
			view.addRenderAttribute( 'video_widget_wrapper', 'data-widget_type', 'video.default' );
			view.addRenderAttribute( 'video_widget_wrapper', 'data-settings', JSON.stringify( settings ) );

			view.addRenderAttribute( 'video_wrapper', 'class', 'elementor-wrapper' );
			if ( settings.show_image_overlay && settings.lightbox ) {
				view.addRenderAttribute( 'video_widget_wrapper', 'style', 'position: absolute; left: 0; right: 0; top: 0; bottom: 0;' );
				view.addRenderAttribute( 'video_wrapper', 'style', 'width: 100%; height: 100%;' );
			}
			view.addRenderAttribute( 'video_wrapper', 'class', 'elementor-open-' + ( settings.show_image_overlay && settings.lightbox ? 'lightbox' : 'inline' ) );

			#>
			<div {{{ view.getRenderAttributeString( 'video_widget_wrapper' ) }}} style="position: absolute;">
				<div {{{ view.getRenderAttributeString( 'video_wrapper' ) }}}>
			<#

			let urls = {
				'youtube': settings.youtube_url,
				'vimeo': settings.vimeo_url,
				'dailymotion': settings.dailymotion_url,
				'hosted': settings.hosted_url,
				'external': settings.external_url
			};

			let video_url = urls[settings.video_type],
				video_html = '';

			if ( 'hosted' === settings.video_type ) {
				if ( settings.insert_url ) {
					video_url = urls['external']['url'];
				} else {
					video_url = urls['hosted']['url'];
				}

				if ( video_url ) {
					if ( settings.start || settings.end ) {
						video_url += '#t=';
					}

					if ( settings.start ) {
						video_url += settings.start;
					}

					if ( settings.end ) {
						video_url += ',' + settings.end;
					}
				}
			}
			if ( video_url ) {

				if ( 'hosted' === settings.video_type ) {
					var video_params = {},
						options = [ 'autoplay', 'loop', 'controls' ];

					for ( let i = 0; i < options.length; i ++ ) {
						if ( settings[ 'video_' + options[i] ] ) {
							video_params[ options[i] ] = '';
						}
					}

					if ( settings.video_autoplay ) {
						video_params['autoplay'] = '';
					}
					if ( settings.video_loop ) {
						video_params['loop'] = '';
					}
					if ( settings.video_controls ) {
						video_params['controls'] = '';
					}

					if ( settings.video_mute ) {
						video_params.muted = 'muted';
					}

					view.addRenderAttribute( 'video_tag', 'src', video_url );

					let param_keys = Object.keys( video_params );

					for ( let i = 0; i < param_keys.length; i ++ ) {
						view.addRenderAttribute( 'video_tag', param_keys[i], video_params[param_keys[i]] );
					}
					if ( ! settings.show_image_overlay || ! settings.lightbox ) {
						#>
						<video {{{ view.getRenderAttributeString( 'video_tag' ) }}}></video>
						<#
					}

				} else {
					view.addRenderAttribute( 'video_tag', 'src', video_url );
					if ( ! settings.show_image_overlay || ! settings.lightbox ) {
						#>
						<iframe {{{ view.getRenderAttributeString( 'video_tag' ) }}}></iframe>
						<#
					}
				}

				if ( settings.background_image.url && 'yes' === settings.show_image_overlay ) {
						view.addRenderAttribute( 'image-overlay', 'class', 'elementor-custom-embed-image-overlay' );

						if ( settings.show_image_overlay && settings.lightbox ) {
							let lightbox_url = video_url,
								lightbox_options = {};

							lightbox_options = {
								'type'        : 'video',
								'videoType'   : settings.video_type,
								'url'         : lightbox_url,
								'modalOptions': {
									'entranceAnimation'       : settings.lightbox_content_animation,
									'entranceAnimation_tablet': settings.lightbox_content_animation_tablet,
									'entranceAnimation_mobile': settings.lightbox_content_animation_mobile,
									'videoAspectRatio'        : settings.aspect_ratio,
								},
							};

							if ( 'hosted' === settings.video_type ) {
								lightbox_options['videoParams'] = video_params;
							}

							view.addRenderAttribute( 'image-overlay', 'data-elementor-open-lightbox', 'yes' );
							view.addRenderAttribute( 'image-overlay', 'data-elementor-lightbox', JSON.stringify( lightbox_options ) );
							view.addRenderAttribute( 'image-overlay-lightbox', 'src', settings.background_image.url );

						} else {
							view.addRenderAttribute( 'image-overlay', 'style', 'background-image: url(' + settings.background_image.url + ');' );
						}

						#>
						<div {{{ view.getRenderAttributeString( 'image-overlay' ) }}}>
							<# if ( settings.show_image_overlay && settings.lightbox ) { #>
								<img {{{ view.getRenderAttributeString( 'image-overlay-lightbox' ) }}}>
							<# } #>
							<# if ( 'yes' === settings.show_play_icon ) { #>
								<div class="elementor-custom-embed-play" role="button">
									<i class="eicon-play" aria-hidden="true"></i>
									<span class="elementor-screen-only"></span>
								</div>
							<# } #>
						</div>
						<#
					}
				}
				#>
				</div>
			</div>
		<# } #>
		<?php
		if ( ! $this->is_dom_optimization_active ) {
			echo '</div>';
		}
		?>
		<?php if ( $this->is_dom_optimization_active ) { ?>
			</div>
		<?php } ?>
		<# if( 'slider' == settings.use_as && 'thumb' == settings.dots_kind && 'yes' == settings.show_dots ) { #>
			<div class="slider-thumb-dots slider-thumb-dots-{{{view.getID()}}}">
			<#
				if ( settings.thumbs.length ) {
					settings.thumbs.map(function(img) {
					#>
						<button role="presentation" class="owl-dot">
							<img src="{{{img['url']}}}">
						</button>
					<#
					});
				}
			#>
			</div>
		<# } #>
		
		<?php if ( ! $this->is_dom_optimization_active ) { ?>
		</div>
			<?php
		}
	}

	public function before_render() {
		$settings = $this->get_settings_for_display();

		global $riode_section;
		?>
		
		<<?php echo $this->get_html_tag(); ?>
		 <?php $this->print_render_attribute_string( '_wrapper' ); ?>>
		
			<?php
			if ( 'video' === $settings['background_background'] ) :
				if ( $settings['background_video_link'] ) :
					$video_properties = Embed::get_video_properties( $settings['background_video_link'] );

					$this->add_render_attribute( 'background-video-container', 'class', 'elementor-background-video-container' );

					if ( ! $settings['background_play_on_mobile'] ) {
						$this->add_render_attribute( 'background-video-container', 'class', 'elementor-hidden-mobile' );
					}
					?>
					<div <?php $this->print_render_attribute_string( 'background-video-container' ); ?>>
						<?php if ( $video_properties ) : ?>
							<div class="elementor-background-video-embed"></div>
							<?php
						else :
							$video_tag_attributes = 'autoplay muted playsinline';
							if ( 'yes' !== $settings['background_play_once'] ) :
								$video_tag_attributes .= ' loop';
							endif;
							?>
							<video class="elementor-background-video-hosted elementor-html5-video" 
							<?php
								// PHPCS - the variable $video_tag_attributes is a plain string.
								echo $video_tag_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							></video>
						<?php endif; ?>
					</div>
					<?php
				endif;
			endif;

			$has_background_overlay = in_array( $settings['background_overlay_background'], array( 'classic', 'gradient' ), true ) ||
									in_array( $settings['background_overlay_hover_background'], array( 'classic', 'gradient' ), true );

			if ( $has_background_overlay ) :
				?>
				<div class="elementor-background-overlay"></div>
				<?php
			endif;

			if ( $settings['shape_divider_top'] ) {
				$this->print_shape_divider( 'top' );
			}

			if ( $settings['shape_divider_bottom'] ) {
				$this->print_shape_divider( 'bottom' );
			}

			// Additional Settings
			$extra_class = '';
			$extra_attrs = '';

			if ( 'creative' == $settings['use_as'] ) { // if using as creative grid
				$extra_class .= ' grid creative-grid gutter-' . $settings['col_sp'] . ' grid-mode-' . $settings['creative_mode'];

				if ( 'yes' == $settings['grid_float'] ) {
					$extra_class .= ' grid-float';
				} else {
					wp_enqueue_script( 'isotope-pkgd' );

					$extra_attrs .= ' data-plugin="isotope"';

					global $riode_breakpoints;
					if ( $riode_breakpoints ) {
						$breakpoints = $riode_breakpoints;
					} else {
						$breakpoints = Elementor\Core\Responsive\Responsive::get_breakpoints();
					}
					$extra_attrs .= " data-creative-breaks='" . json_encode(
						array(
							'md' => $breakpoints['md'],
							'lg' => $breakpoints['lg'],
						)
					) . "'";
				}

				if ( 'no' === $settings['col_sp'] ) {
					$settings['gap'] = 'no';
				} elseif ( 'xs' === $settings['col_sp'] ) {
					$settings['gap'] = 'no';
				} elseif ( 'sm' === $settings['col_sp'] ) {
					$settings['gap'] = 'narrow';
				} elseif ( 'md' === $settings['col_sp'] ) {
					$settings['gap'] = 'default';
				} elseif ( 'lg' === $settings['col_sp'] ) {
					$settings['gap'] = 'extended';
				}

				global $riode_section;
				riode_creative_layout_style(
					'.elementor-element-' . $this->get_data( 'id' ),
					$riode_section['layout'],
					$settings['creative_height']['size'] ? $settings['creative_height']['size'] : 600,
					$settings['creative_height_ratio']['size'] ? $settings['creative_height_ratio']['size'] : 75
				);

				if ( ! $this->is_dom_optimization_active ) {
					$settings['gap'] = 'no';
				}
			} elseif ( 'slider' === $settings['use_as'] ) { // if using as slider

				$col_cnt = riode_elementor_grid_col_cnt( $settings );

				$extra_class    .= ' ' . riode_get_col_class( $col_cnt );
				$extra_class    .= ' ' . riode_elementor_grid_space_class( $settings );
				$extra_class    .= ' ' . riode_get_slider_class( $settings );
				$extra_attrs    .= ' data-plugin="owl" data-owl-options=' . esc_attr(
					json_encode(
						riode_get_slider_attrs( $settings, $col_cnt, $this )
					)
				);
				$settings['gap'] = 'no';

			} elseif ( 'banner' == $settings['use_as'] ) { // if using as banner
				$extra_class    .= ' el-banner banner';
				$settings['gap'] = 'no';

				if ( 'yes' == $settings['parallax'] ) { // if parallax
					function_exists( 'riode_add_async_script' ) ? riode_add_async_script( 'jquery-parallax' ) : wp_enqueue_script( 'jquery-parallax' );
				} else {
					if ( $settings['overlay'] ) {
						$extra_class .= ' ' . riode_get_overlay_class( $settings['overlay'] );
						if ( 'yes' !== $settings['fixed_banner'] ) {
							$extra_class .= ' p-static';
						}
					}
					$extra_class .= ' el-banner-fixed banner-fixed';
				}

				if ( 'yes' == $settings['video_banner_switch'] ) {
					$extra_class .= ' video-banner';
				}
			} elseif ( 'tab' == $settings['use_as'] ) { // if using as tab
				$extra_class    .= ' tab element-tab';
				$settings['gap'] = 'no';

				if ( $settings['tab_h_type'] ) {
					$extra_class .= ' tab-' . $settings['tab_h_type'];
				}

				if ( 'vertical' == $settings['tab_type'] ) {
					$extra_class .= ' tab-vertical';
				}

				switch ( $settings['tab_navs_pos'] ) { // nav position
					case 'center':
						$extra_class .= ' tab-nav-center';
						break;
					case 'right':
						$extra_class .= ' tab-nav-right';
				}
			} elseif ( 'accordion' == $settings['use_as'] ) { // if using as accordion
				$extra_class    .= ' accordion';
				$settings['gap'] = 'no';

				if ( $settings['accordion_type'] ) {
					$extra_class .= ' accordion-' . $settings['accordion_type'];
				}
			}
			?>
			<?php if ( ! $this->is_dom_optimization_active ) { ?>
				<div class="<?php echo esc_attr( 'yes' == $settings['section_content_type'] ? 'elementor-container container-fluid' : 'elementor-container' ); ?> elementor-column-gap-<?php echo esc_attr( $settings['gap'] ) . ( 'tab' == $settings['use_as'] ? esc_attr( $extra_class ) : '' ); ?>">
			<?php } else { ?>
				<div class="<?php echo esc_attr( 'yes' == $settings['section_content_type'] ? 'elementor-container container-fluid' : 'elementor-container' ); ?> elementor-column-gap-<?php echo esc_attr( $settings['gap'] ) . esc_attr( $extra_class ); ?>" <?php echo riode_strip_script_tags( $extra_attrs ); ?>>

				<?php } ?>

				<?php
				// Additionals
				do_action( 'riode_elementor_common_before_render_content', $settings, $this->get_ID() );
				?>
				<?php if ( 'tab' == $settings['use_as'] ) : // add tab navs ?>
					<ul class="nav nav-tabs">
					<?php foreach ( $riode_section['tab_data'] as $idx => $data ) : ?>
						<?php
						$html = '';
						if ( $data['icon'] && ( 'left' == $data['icon_pos'] || 'up' == $data['icon_pos'] ) ) {
							$html .= '<i class="' . $data['icon'] . '"></i>';
						}
						$html .= $data['title'];
						if ( $data['icon'] && ( 'down' == $data['icon_pos'] || 'right' == $data['icon_pos'] ) ) {
							$html .= '<i class="' . $data['icon'] . '"></i>';
						}
						if ( ! $data['icon'] && ! $data['title'] ) {
							$html .= esc_html__( 'Tab Title', 'riode-core' );
						}
						?>
						<li class="nav-item <?php echo $data['icon'] ? 'nav-icon-' . $data['icon_pos'] : ''; ?>"><a class="nav-link<?php echo esc_attr( 0 == $idx ? ' active' : '' ); ?>" href="<?php echo esc_attr( $data['id'] ); ?>"><?php echo riode_strip_script_tags( $html ); ?></a></li>
					<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php if ( ! $this->is_dom_optimization_active ) { ?>
					<div class="elementor-row<?php echo 'tab' == $settings['use_as'] ? ' tab-content' : esc_attr( $extra_class ); ?>"<?php echo riode_strip_script_tags( $extra_attrs ); ?>>
					<?php
				} elseif ( 'tab' == $settings['use_as'] ) {
					echo '<div class="tab-content">';
				}
				if ( 'banner' == $settings['use_as'] && 'yes' != $settings['parallax'] ) :
					if ( '' !== $settings['background_effect'] || '' !== $settings['particle_effect'] ) {
						// Background Effect
						$background_wrapclass = '';
						$background_class[]   = '';
						if ( $settings['background_effect'] ) {
							$background_class[] = $settings['background_effect'];
						}
						// Particle Effect
						$particle_class[] = '';
						if ( $settings['particle_effect'] ) {
							$particle_class[] = $settings['particle_effect'];
						}

						if ( ! empty( $settings['background_image'] ) ) {
							if ( '' !== $settings['particle_effect'] && '' == $settings['background_effect'] ) {
								$background_img       = '';
								$background_wrapclass = ' banner-img-visible';
							} else {
								$background_img = esc_url( $settings['background_image']['url'] );
							}
							echo '<div class="background-effect-wrapper' . $background_wrapclass . '">';
							echo '<div class="background-effect ' . esc_attr( implode( ' ', $background_class ) ) . '" style="background-image: url(' . $background_img . '); background-size: cover">';

							if ( '' !== $settings['particle_effect'] ) {
								echo '<div class="particle-effect ' . esc_attr( implode( ' ', $particle_class ) ) . '"></div>';
							}

							echo '</div></div>';
						}
					}

					$banner_img_cls = '';
					if ( isset( $settings['background_effect'] ) && ! empty( $settings['background_effect'] ) ) {
						$banner_img_cls = 'banner-img-hidden';
					}

					if ( 'yes' == $settings['fixed_banner'] && isset( $settings['background_image'] ) ) {
						$banner_img_id = $settings['background_image']['id'];
					}
					if ( isset( $banner_img_id ) && $banner_img_id ) {
						?>
					<figure class="banner-img <?php echo esc_attr( $banner_img_cls ); ?>">
						<?php
						$tablet_class  = '';
						$desktop_class = '';
						$image_atts    = $settings['background_color'] ? array( 'style' => 'background-color:' . $settings['background_color'] ) : array();

						if ( ! empty( $settings['background_image_mobile']['id'] ) ) {
							$tablet_class  = 'show-only-tablet';
							$desktop_class = 'hide-mobile';

							$mobile_image = wp_get_attachment_image_src( $settings['background_image_mobile']['id'], 'full', false );

							if ( $mobile_image ) {
								list( $mobile_src, $mobile_width, $mobile_height ) = $mobile_image;
								$image_atts['srcset']                              = $mobile_src;
								$image_atts['class']                               = 'show-only-mobile';
							}

							$content = wp_get_attachment_image(
								$settings['background_image_mobile']['id'],
								'full',
								false,
								$image_atts
							);
							echo class_exists( 'Riode_LazyLoad_Images' ) ? Riode_LazyLoad_Images::add_image_placeholders( $content ) : $content;
						} else {
							$tablet_class = 'show-tablet';
						}

						if ( ! empty( $settings['background_image_tablet']['id'] ) ) {
							$desktop_class = 'show-only-desktop';

							$tablet_image = wp_get_attachment_image_src( $settings['background_image_tablet']['id'], 'full', false );

							if ( $tablet_image ) {
								list( $tablet_src, $tablet_width, $tablet_height ) = $tablet_image;
								$image_atts['srcset']                              = $tablet_src;
								$image_atts['class']                               = $tablet_class;
							}

							$content = wp_get_attachment_image(
								$settings['background_image_tablet']['id'],
								'full',
								false,
								$image_atts
							);
							echo class_exists( 'Riode_LazyLoad_Images' ) ? Riode_LazyLoad_Images::add_image_placeholders( $content ) : $content;
						}
						$desktop_image = wp_get_attachment_image_src( $banner_img_id, 'full', false );
						if ( $desktop_image ) {
							list( $desktop_src, $desktop_width, $desktop_height ) = $desktop_image;
							$image_atts['srcset']                                 = $desktop_src;
							$image_atts['class']                                  = $desktop_class;
						}
						$content = wp_get_attachment_image(
							$banner_img_id,
							'full',
							false,
							$image_atts
						);
						echo class_exists( 'Riode_LazyLoad_Images' ) ? Riode_LazyLoad_Images::add_image_placeholders( $content ) : $content;
						?>
					</figure>
						<?php
					}
				endif;
				if ( 'yes' == $settings['video_banner_switch'] ) :

					$video_url = $settings[ $settings['video_type'] . '_url' ];

					if ( 'hosted' === $settings['video_type'] ) {
						$video_url = $this->get_hosted_video_url();
					}

					if ( empty( $video_url ) ) {
						return;
					}

					if ( 'hosted' === $settings['video_type'] ) {
						ob_start();

						$this->render_hosted_video();

						$video_html = ob_get_clean();
					} else {
						$embed_params = $this->get_embed_params();

						$embed_options = $this->get_embed_options();

						$video_html = Embed::get_embed_html( $video_url, $embed_params, $embed_options );
					}

					if ( empty( $video_html ) ) {
						echo esc_url( $video_url );

						return;
					}

					$this->add_render_attribute( 'video_widget_wrapper', 'class', 'elementor-element elementor-widget-video riode-section-video' );
					$this->add_render_attribute( 'video_widget_wrapper', 'data-element_type', 'widget' );
					$this->add_render_attribute( 'video_widget_wrapper', 'data-widget_type', 'video.default' );
					$this->add_render_attribute( 'video_widget_wrapper', 'data-settings', wp_json_encode( $this->get_frontend_settings() ) );

					$this->add_render_attribute( 'video_wrapper', 'class', 'elementor-wrapper' );

					$this->add_render_attribute( 'video_wrapper', 'class', 'elementor-open-' . ( $settings['lightbox'] ? 'lightbox' : 'inline' ) );
					?>


					<div <?php $this->print_render_attribute_string( 'video_widget_wrapper' ); ?>>
						<div <?php $this->print_render_attribute_string( 'video_wrapper' ); ?>>
							<?php
							if ( ! $settings['lightbox'] ) {
								echo $video_html; // XSS ok.
							}
							global $riode_section;
							if ( $this->has_image_overlay() ) {
								if ( ! $settings['lightbox'] && isset( $riode_section['video_btn'] ) ) {
									$this->add_render_attribute( 'background_image', 'class', 'elementor-custom-embed-image-overlay no-event' );
								} else {
									$this->add_render_attribute( 'background_image', 'class', 'elementor-custom-embed-image-overlay' );
								}

								if ( $settings['lightbox'] ) {
									if ( ! isset( $riode_section['video_btn'] ) ) {
										if ( 'hosted' === $settings['video_type'] ) {
											$lightbox_url = $video_url;
										} else {
											$lightbox_url = Embed::get_embed_url( $video_url, $embed_params, $embed_options );
										}

										$lightbox_options = $riode_section['lightbox'];

										$this->add_render_attribute(
											'background_image',
											array(
												'data-elementor-open-lightbox' => 'yes',
												'data-elementor-lightbox' => wp_json_encode( $lightbox_options ),
											)
										);

										if ( Plugin::$instance->editor->is_edit_mode() ) {
											$this->add_render_attribute(
												'background_image',
												array(
													'class' => 'elementor-clickable',
												)
											);
										}
									}
								} else {
									$image_overlay = wp_get_attachment_image_src( $settings['background_image']['id'], 'full' );
									if ( is_array( $image_overlay ) ) {
										$this->add_render_attribute( 'background_image', 'style', 'background-image: url(' . $image_overlay[0] . ');' );
									}
								}
								?>
								<div <?php $this->print_render_attribute_string( 'background_image' ); ?>>
									<?php
									if ( $settings['lightbox'] && ! isset( $riode_section['video_btn'] ) ) {
										?>
										<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'background_image' ); ?>
									<?php } ?>
								</div>
							<?php } ?>

					<?php
				endif;
	}

	public function after_render() {
		$settings = $this->get_settings_for_display();

		if ( 'creative' == $settings['use_as'] ) {
			unset( $GLOBALS['riode_section'] );
			echo '<div class="grid-space"></div>';
		}
		if ( 'accordion' == $settings['use_as'] ) {
			unset( $GLOBALS['riode_section'] );
		}
		?>
				<?php if ( 'yes' == $settings['video_banner_switch'] ) : ?>
					</div>
					</div>
				<?php endif; ?>
				<?php if ( ! $this->is_dom_optimization_active ) { ?>
					</div>
					<?php
				} elseif ( 'tab' == $settings['use_as'] ) {
					echo '</div>';
				}
				if ( 'slider' == $settings['use_as'] && 'thumb' == $settings['dots_kind'] ) {
					if ( $this->is_dom_optimization_active ) {
						?>
			</div>
						<?php
					}
					?>
					<?php
					if ( ! $this->is_dom_optimization_active ) {
						?>
					</div>
					</div>
						<?php
					}
					?>
				<div class="slider-thumb-dots <?php echo 'slider-thumb-dots-' . esc_attr( $this->get_data( 'id' ) ); ?>">
					<?php
					if ( count( $settings['thumbs'] ) ) {
						foreach ( $settings['thumbs'] as $thumb ) {
							echo '<button role="presentation" class="owl-dot">';
							echo wp_get_attachment_image( $thumb['id'] );
							echo '</button>';
						}
					}
					?>
				</div>
				<?php } ?>
			<?php
			if ( 'slider' != $settings['use_as'] || 'thumb' != $settings['dots_kind'] || ! $this->is_dom_optimization_active ) {
				?>
				</div>
				<?php
			}
			?>
		</<?php echo $this->get_html_tag(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php
	}

	public function get_embed_params() {
		$settings = $this->get_settings_for_display();

		$params = array();

		if ( $settings['video_autoplay'] && ! $this->has_image_overlay() ) {
			$params['autoplay'] = '1';
		}

		$params_dictionary = array();

		if ( 'youtube' === $settings['video_type'] ) {
			$params_dictionary = array(
				'video_loop',
				'video_controls',
				'video_mute',
				'rel',
				'modestbranding',
			);

			if ( $settings['video_loop'] ) {
				$video_properties = Embed::get_video_properties( $settings['youtube_url'] );

				$params['playlist'] = $video_properties['video_id'];
			}

			$params['wmode'] = 'opaque';
		} elseif ( 'vimeo' === $settings['video_type'] ) {
			$params_dictionary = array(
				'video_loop',
				'video_mute'     => 'muted',
				'vimeo_title'    => 'title',
				'vimeo_portrait' => 'portrait',
				'vimeo_byline'   => 'byline',
			);

			$params['color'] = str_replace( '#', '', $settings['color'] );

			$params['autopause'] = '0';
		} elseif ( 'dailymotion' === $settings['video_type'] ) {
			$params_dictionary = array(
				'video_controls',
				'video_mute',
				'showinfo' => 'ui-start-screen-info',
				'logo'     => 'ui-logo',
			);

			$params['ui-highlight'] = str_replace( '#', '', $settings['color'] );

			$params['start'] = $settings['start'];

			$params['endscreen-enable'] = '0';
		}

		foreach ( $params_dictionary as $key => $param_name ) {
			$setting_name = $param_name;

			if ( is_string( $key ) ) {
				$setting_name = $key;
			}

			$setting_value = $settings[ $setting_name ] ? '1' : '0';

			$params[ $param_name ] = $setting_value;
		}

		return $params;
	}

	/**
	 * Whether the video has an overlay image or not.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function has_image_overlay() {
		$settings = $this->get_settings_for_display();

		return ! empty( $settings['background_image']['url'] ) && 'yes' === $settings['show_image_overlay'];
	}

	/**
	 * @since 1.0
	 * @access private
	 */
	public function get_embed_options() {
		$settings = $this->get_settings_for_display();

		$embed_options = array();

		if ( 'youtube' === $settings['video_type'] ) {
			$embed_options['privacy'] = $settings['yt_privacy'];
		} elseif ( 'vimeo' === $settings['video_type'] ) {
			$embed_options['start'] = $settings['start'];
		}

		$embed_options['lazy_load'] = ! empty( $settings['lazy_load'] );

		return $embed_options;
	}

	/**
	 * @since 1.0
	 * @access private
	 */
	public function get_hosted_params() {
		$settings = $this->get_settings_for_display();

		$video_params = array();

		foreach ( array( 'autoplay', 'loop', 'controls' ) as $option_name ) {
			if ( $settings[ 'video_' . $option_name ] ) {
				$video_params[ $option_name ] = '';
			}
		}

		if ( $settings['video_mute'] ) {
			$video_params['muted'] = 'muted';
		}

		return $video_params;
	}

	/**
	 * Returns video url
	 *
	 * @since 1.0
	 */
	public function get_hosted_video_url() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['insert_url'] ) ) {
			$video_url = $settings['external_url']['url'];
		} else {
			$video_url = $settings['hosted_url']['url'];
		}

		if ( empty( $video_url ) ) {
			return '';
		}

		return $video_url;
	}

	/**
	 * @since 1.0
	 * @access private
	 */
	public function render_hosted_video() {
		$video_url = $this->get_hosted_video_url();
		if ( empty( $video_url ) ) {
			return;
		}

		$video_params = $this->get_hosted_params();
		?>
		<video class="elementor-video" src="<?php echo esc_url( $video_url ); ?>" <?php Utils::print_html_attributes( $video_params ); ?>></video>
		<?php
	}

	/**
	 * adds more shape dividers
	 *
	 * @since 1.4.0
	 */
	public function add_more_shape_dividers( $shapes ) {
		$new_shapes = riode_get_shape_dividers();

		foreach ( $new_shapes as $key => $value ) {
			if ( 0 == strpos( $key, 'theme_shape_' ) ) {
				$shapes[ $key ] = $value;
			}
		}

		return $shapes;
	}
}

if ( ! function_exists( 'riode_section_render_attributes' ) ) {
	/**
	 * Add render attributes for sections.
	 *
	 * @since 1.0
	 */
	function riode_section_render_attributes( $self ) {
		$settings = $self->get_settings_for_display();
		$options  = array( 'class' => '' );

		if ( 'creative' == $settings['use_as'] ) { // if creative grid
			global $riode_section;
			$riode_section = array(
				'section' => 'creative',
				'preset'  => riode_creative_layout( $settings['creative_mode'] ),
				'layout'  => array(), // layout of children
				'index'   => 0, // index of children
				'top'     => $self->get_data( 'isInner' ), // check if the column is direct child of this section
			);
		} elseif ( 'slider' == $settings['use_as'] ) {
			if ( $self->is_dom_optimization_active && 'thumb' == $settings['dots_kind'] ) {
				$options['class'] = 'flex-wrap';
			}
		} elseif ( 'banner' == $settings['use_as'] ) {
			if ( 'yes' == $settings['fixed_banner'] || 'yes' == $settings['parallax'] ) {
				$options['class'] = 'background-none';
			}
			if ( 'yes' === $settings['parallax'] ) {
				$options['class']                .= ' parallax';
				$options['data-image-src']        = esc_url( $settings['background_image']['url'] );
				$parallax_options                 = array(
					'speed'          => $settings['parallax_speed']['size'] ? 10 / $settings['parallax_speed']['size'] : 1.5,
					'parallaxHeight' => $settings['parallax_height']['size'] ? $settings['parallax_height']['size'] . '%' : '300%',
					'offset'         => $settings['parallax_offset']['size'] ? $settings['parallax_offset']['size'] : 0,
				);
				$options['data-parallax-options'] = json_encode( $parallax_options );
				$options['data-plugin']           = 'parallax';
			} elseif ( 'yes' !== $settings['video_banner_switch'] ) {
				// $options['class'] .= ' background-trans';
			}
		} elseif ( 'tab' == $settings['use_as'] ) {
			global $riode_section;
			$riode_section = array(
				'section'  => 'tab',
				'index'    => 0,
				'tab_data' => array(),
			);
		} elseif ( 'accordion' == $settings['use_as'] ) {
			global $riode_section;

			if ( ! isset( $riode_section['section'] ) ) {
				$riode_section = array(
					'section'     => 'accordion',
					'parent_id'   => $self->get_data( 'id' ),
					'index'       => 0,
					'icon'        => $settings['accordion_icon'],
					'active_icon' => $settings['accordion_active_icon'],
				);
			}
		} elseif ( $settings['background_image'] && $settings['background_image']['url'] && function_exists( 'riode_get_option' ) && riode_get_option( 'lazyload' ) ) { // Lazyload background image
			if ( ! is_admin() && ! is_customize_preview() && ! riode_doing_ajax() && ( 'banner' != $settings['use_as'] || 'yes' != $settings['fixed_banner'] ) ) {
				if ( ! $settings['background_color'] ) {
					$options['style'] = 'background-color:' . riode_get_option( 'lazyload_bg' ) . ';';
				}
				$options['class']     = 'd-lazy-back';
				$options['data-lazy'] = esc_url( $settings['background_image']['url'] );
			}
		}

		if ( 'yes' == $settings['video_banner_switch'] ) {
			global $riode_section;
			$riode_section['video'] = true;
			if ( 'yes' == $settings['lightbox'] ) {

				$video_url = $settings[ $settings['video_type'] . '_url' ];

				if ( 'hosted' === $settings['video_type'] ) {
					$video_url = $self->get_hosted_video_url();
				}
				if ( 'hosted' != $settings['video_type'] ) {
					$embed_params  = $self->get_embed_params();
					$embed_options = $self->get_embed_options();
				}
				if ( 'hosted' === $settings['video_type'] ) {
					$lightbox_url = $video_url;
				} else {
					$lightbox_url = Embed::get_embed_url( $video_url, $embed_params, $embed_options );
				}

				$lightbox_options = array(
					'type'         => 'video',
					'videoType'    => $settings['video_type'],
					'url'          => $lightbox_url,
					'modalOptions' => array(
						'id'                       => 'elementor-lightbox-' . $self->get_id(),
						'entranceAnimation'        => $settings['lightbox_content_animation'],
						'entranceAnimation_tablet' => $settings['lightbox_content_animation_tablet'],
						'entranceAnimation_mobile' => $settings['lightbox_content_animation_mobile'],
						'videoAspectRatio'         => $settings['aspect_ratio'],
					),
				);

				if ( 'hosted' === $settings['video_type'] ) {
					$lightbox_options['videoParams'] = $self->get_hosted_params();
				}
				$riode_section['lightbox'] = $lightbox_options;
			}
		}

		if ( isset( $settings['section_content_sticky'] ) && ( 'yes' == $settings['section_content_sticky'] || 'yes' == $settings['section_content_sticky_tablet'] || 'yes' == $settings['section_content_sticky_mobile'] ) ) {
			$sticky_options = array(
				'defaults' => array(
					'minWidth' => 992,
					'maxWidth' => 20000,
				),
				'devices'  => array(
					'xl' => false,
					'lg' => false,
					'md' => false,
					'sm' => false,
					'xs' => false,
				),
			);

			if ( isset( $settings['section_content_sticky'] ) && 'yes' == $settings['section_content_sticky'] ) {
				$sticky_options['devices']['xl'] = true;
				$sticky_options['devices']['lg'] = true;
			}

			if ( isset( $settings['section_content_sticky_tablet'] ) && 'yes' == $settings['section_content_sticky_tablet'] ) {
				$sticky_options['devices']['md'] = true;
			}

			if ( isset( $settings['section_content_sticky_mobile'] ) && 'yes' == $settings['section_content_sticky_mobile'] ) {
				$sticky_options['devices']['sm'] = true;
				$sticky_options['devices']['xs'] = true;
			}

			$sticky_options                 = json_encode( $sticky_options );
			$options['data-sticky-options'] = $sticky_options;
			$options['class']              .= ' sticky-content fix-top';
		}

		$self->add_render_attribute(
			array(
				'_wrapper' => apply_filters( 'riode_elementor_common_wrapper_attributes', $options, $settings, $self->get_ID() ),
			)
		);
	}
}
