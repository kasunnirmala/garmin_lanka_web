<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Column Element
 *
 * Extended Element_Column Class
 * Added Slider, 1 Layer Banner, Banner Layer, Creative Grid Item Functions.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;

add_action( 'elementor/frontend/column/before_render', 'riode_column_render_attributes', 10, 1 );

class Riode_Element_Column extends Elementor\Element_Column {

	public function __construct( array $data = array(), array $args = null ) {
		parent::__construct( $data, $args );
	}

	private function get_html_tag() {
		$html_tag = $this->get_settings( 'html_tag' );

		if ( empty( $html_tag ) ) {
			$html_tag = 'div';
		}

		return $html_tag;
	}

	protected function register_controls() {
		parent::register_controls();

		global $riode_animations;

		$left  = is_rtl() ? 'right' : 'left';
		$right = 'left' == $left ? 'right' : 'left';

		$this->start_controls_section(
			'column_additional',
			array(
				'label' => esc_html__( 'Riode Settings', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);
			$this->add_responsive_control(
				'creative_width',
				array(
					'label'       => esc_html__( 'Grid Item Width (%)', 'riode-core' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'This Option will be applied when only parent section is used for creative grid. Empty Value will be set from preset of parent creative grid.', 'riode-core' ),
					'min'         => 1,
					'max'         => 100,
				)
			);

			$this->add_responsive_control(
				'creative_height',
				array(
					'label'       => esc_html__( 'Grid Item Height', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'preset',
					'options'     => array(
						'1'      => '1',
						'1-2'    => '1/2',
						'1-3'    => '1/3',
						'2-3'    => '2/3',
						'1-4'    => '1/4',
						'3-4'    => '3/4',
						'1-5'    => '1/5',
						'2-5'    => '2/5',
						'3-5'    => '3/5',
						'4-5'    => '4/5',
						'child'  => esc_html__( 'Depending on Children', 'riode-core' ),
						'preset' => esc_html__( 'Use From Preset', 'riode-core' ),
					),
					'description' => esc_html__( 'This Option will be applied when only parent section is used for creative grid.', 'riode-core' ),
				)
			);

			$this->add_responsive_control(
				'creative_order',
				array(
					'label'       => esc_html__( 'Grid Item Order', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'separator'   => 'after',
					'options'     => array(
						''   => esc_html__( 'Default', 'riode-core' ),
						'1'  => '1',
						'2'  => '2',
						'3'  => '3',
						'4'  => '4',
						'5'  => '5',
						'6'  => '6',
						'7'  => '7',
						'8'  => '8',
						'9'  => '9',
						'10' => '10',
					),
					'description' => 'This Option will be applied when only parent section is used for creative grid.',
				)
			);

			$this->add_control(
				'use_as',
				array(
					'type'    => Controls_Manager::SELECT,
					'label'   => esc_html__( 'Use Column For', 'riode-core' ),
					'default' => '',
					'options' => array(
						''                  => esc_html__( 'Default', 'riode-core' ),
						'slider'            => esc_html__( 'Slider', 'riode-core' ),
						'banner'            => esc_html__( '1 Layer Banner', 'riode-core' ),
						'banner_layer'      => esc_html__( 'Banner Layer', 'riode-core' ),
						'accordion_content' => esc_html__( 'Accordion Content', 'riode-core' ),
						'tab_content'       => esc_html__( 'Tab Content', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'column_banner_layer_description',
				array(
					'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s Use %2$sparent section%3$s as %2$sbanner%3$s by using riode settings%4$s', 'riode-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
					'type'        => 'riode_description',
					'condition'   => array(
						'use_as' => 'banner_layer',
					),
				)
			);

			$this->add_control(
				'column_tab_content_description',
				array(
					'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s Use %2$sparent section%3$s as %2$stab%3$s by using riode settings%4$s', 'riode-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
					'type'        => 'riode_description',
					'condition'   => array(
						'use_as' => 'tab_content',
					),
				)
			);

			$this->add_control(
				'column_accordion_content_description',
				array(
					'description' => sprintf( esc_html__( '%1$s%2$sNote:%3$s Use %2$sparent section%3$s as %2$saccordion%3$s by using riode settings%4$s', 'riode-core' ), '<span class="important-note">', '<b>', '</b>', '</span>' ),
					'type'        => 'riode_description',
					'condition'   => array(
						'use_as' => 'accordion_content',
					),
				)
			);

			riode_elementor_grid_layout_controls( $this, 'use_as' );

			riode_elementor_slider_layout_controls( $this, 'use_as' );

		$this->end_controls_section();

		// Tab content
		$this->start_controls_section(
			'tab_content',
			array(
				'label'     => esc_html__( 'Tab Content', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'tab_content',
				),
			)
		);

			$this->add_control(
				'tab_title',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Tab Title', 'riode-core' ),
					'description' => esc_html__( 'Input heading title for each tab item.', 'riode-core' ),
					'condition'   => array(
						'use_as' => 'tab_content',
					),
				)
			);

			$this->add_control(
				'tab_icon',
				array(
					'label'       => esc_html__( 'Tab Icon', 'riode-core' ),
					'description' => esc_html__( 'Choose icon for title of each tab item.', 'riode-core' ),
					'type'        => Controls_Manager::ICONS,
					'condition'   => array(
						'use_as' => 'tab_content',
					),
				)
			);

			$this->add_control(
				'tab_icon_pos',
				array(
					'label'       => esc_html__( 'Tab Icon Position', 'riode-core' ),
					'description' => esc_html__( 'Choose icon position of each tab nav. Choose from Left, Up, Right, Bottom.', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'left',
					'options'     => array(
						'left'  => esc_html__( 'Left', 'riode-core' ),
						'right' => esc_html__( 'Right', 'riode-core' ),
						'up'    => esc_html__( 'Up', 'riode-core' ),
						'down'  => esc_html__( 'Down', 'riode-core' ),
					),
					'condition'   => array(
						'use_as' => 'tab_content',
					),
				)
			);

			$this->add_control(
				'tab_icon_space',
				array(
					'label'       => esc_html__( 'Tab Icon Spacing (px)', 'riode-core' ),
					'description' => esc_html__( 'Controls spacing between icon and label in tab item header.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => array(
						'size' => 10,
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 30,
						),
					),
					'selectors'   => array(
						'.nav-icon-left .nav-link[href="{{ID}}"] i' => "margin-{$right}: {{SIZE}}px;",
						'.nav-icon-right .nav-link[href="{{ID}}"] i' => "margin-{$left}: {{SIZE}}px;",
						'.nav-icon-up .nav-link[href="{{ID}}"] i' => 'margin-bottom: {{SIZE}}px;',
						'.nav-icon-down .nav-link[href="{{ID}}"] i' => 'margin-top: {{SIZE}}px;',
					),
					'condition'   => array(
						'use_as' => 'tab_content',
					),
				)
			);

			$this->add_control(
				'tab_icon_size',
				array(
					'label'       => esc_html__( 'Tab Icon Size (px)', 'riode-core' ),
					'description' => esc_html__( 'Controls icon size of tab item header.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'selectors'   => array(
						'.tab .nav-link[href="{{ID}}"] i' => 'font-size: {{SIZE}}px;',
					),
					'condition'   => array(
						'use_as' => 'tab_content',
					),
				)
			);

		$this->end_controls_section();

		// Accordion content
		$this->start_controls_section(
			'accordion_content',
			array(
				'label'     => esc_html__( 'Accordion Content', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'accordion_content',
				),
			)
		);
			$this->add_control(
				'accordion_title',
				array(
					'label'       => esc_html__( 'Card Title', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'description' => esc_html__( 'Set header title of each card items.', 'riode-core' ),
				)
			);

			$this->add_control(
				'accordion_header_icon',
				array(
					'label'            => esc_html__( 'Prefix Icon', 'riode-core' ),
					'description'      => esc_html__( 'Choose different prefix icon of each card headers.', 'riode-core' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
				)
			);

			$this->add_control(
				'accordion_header_icon_size',
				array(
					'label'       => esc_html__( 'Prefix Icon Size', 'riode-core' ),
					'description' => esc_html__( 'Set font size of prefix icons of card headers.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'em',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}}.card .card-header a > i:first-child' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'accordion_header_icon_space',
				array(
					'label'       => esc_html__( 'Prefix Icon Space', 'riode-core' ),
					'description' => esc_html__( 'Set spacing between prefix icon and card header title.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'rem',
						'em',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .card-header a > i:first-child' => "margin-{$right}: {{SIZE}}{{UNIT}};",
					),
				)
			);

		$this->end_controls_section();

		// Banner
		$this->start_controls_section(
			'banner_options_section',
			array(
				'label'     => esc_html__( 'Banner', 'riode-core' ),
				'tab'       => Controls_Manager::TAB_LAYOUT,
				'condition' => array(
					'use_as' => 'banner',
				),
			)
		);

			riode_elementor_banner_layout_controls( $this, 'use_as' );

		$this->end_controls_section();

		riode_elementor_banner_layer_layout_controls( $this, 'use_as' );

		riode_elementor_slider_style_controls( $this, 'use_as' );

		do_action( 'riode_elementor_add_common_options', $this );
	}

	protected function content_template() {
		$is_dom_optimization_active = riode_elementor_if_dom_optimization();
		$wrapper_element            = $is_dom_optimization_active ? 'widget' : 'column';
		?>
		<#
			let wrapper_class = '';
			let wrapper_attrs = '';
			let extra_class = '';
			let extra_attrs = '';

			// 1 Layer Banner.
			let grid_item = {};

			if ( 'slider' == settings.use_as ) {
				<?php
					riode_elementor_grid_template();
					riode_elementor_slider_template();
				if ( ! $is_dom_optimization_active ) {
					?>
					if ('thumb' == settings.dots_kind) {
						wrapper_class += ' flex-wrap';
					}
					<?php
				}
				?>
			}

			if ( settings.creative_width ) {
				grid_item['w'] = settings.creative_width;
			}
			if ( settings.creative_width_tablet ) {
				grid_item['w-l'] = settings.creative_width_tablet;
			}
			if ( settings.creative_width_mobile ) {
				grid_item['w-m'] = settings.creative_width_mobile;
			}

			if ( 'child' != settings.creative_height ) {
				grid_item['h'] = settings.creative_height;
			}
			if ( settings.creative_height_tablet && 'preset' != settings.creative_height_tablet && 'child' != settings.creative_height_tablet ) {
				grid_item['h-l'] = settings.creative_height_tablet;
			}
			if ( settings.creative_height_mobile && 'preset' != settings.creative_height_mobile && 'child' != settings.creative_height_mobile ) {
				grid_item['h-m'] = settings.creative_height_mobile;
			}

			if ( settings.creative_order ) {
				wrapper_attrs += ' data-creative-order="' + settings.creative_order + '"';
			}
			if ( settings.creative_order_tablet ) {
				wrapper_attrs += ' data-creative-order-lg="' + settings.creative_order_tablet + '"';
			}
			if ( settings.creative_order_mobile ) {
				wrapper_attrs += ' data-creative-order-md="' + settings.creative_order_mobile + '"';
			}

			wrapper_attrs += 'data-creative-item=' + JSON.stringify(grid_item);

			if ( 'banner_layer' == settings.use_as ) { // if banner content
				wrapper_attrs += ' data-banner-class="banner-content ' + (settings.banner_origin ? settings.banner_origin : '') + '"';
			}

			if( 'tab_content' == settings.use_as ) {
				wrapper_attrs += ' data-role="tab-pane"';
				wrapper_attrs += ' data-tab-title="' + settings.tab_title + '"';
				wrapper_attrs += ' data-tab-icon="' + (settings.tab_icon ? settings.tab_icon.value : '') + '"';
				wrapper_attrs += ' data-tab-icon-pos="' + settings.tab_icon_pos + '"';
			}

			if( 'accordion_content' == settings.use_as ) {
				wrapper_attrs += ' data-accordion-title="' + ( settings.accordion_title ? settings.accordion_title : 'Card' ) + '"';
				wrapper_attrs += ' data-accordion-icon="' + ( settings.accordion_header_icon ? settings.accordion_header_icon.value : '' ) + '"';
				wrapper_class += ' card-body expanded';
			}

			if( 'banner' == settings.use_as ) {

				var banner = 'el-banner banner el-banner-fixed banner-fixed';
				if ( settings.overlay ) {
					if ( 'light' === settings.overlay ) {
						banner += ' overlay-light';
					}
					if ( 'dark' === settings.overlay ) {
						banner += ' overlay-dark';
					}
					if ( 'zoom' === settings.overlay ) {
						banner += ' overlay-zoom';
					}
					if ( 'zoom_light' === settings.overlay ) {
						banner += ' overlay-zoom overlay-light';
					}
					if ( 'zoom_dark' === settings.overlay ) {
						banner += ' overlay-zoom overlay-dark';
					}
					if ( 'effect-1' == settings.overlay || 'effect-2' == settings.overlay || 'effect-3' == settings.overlay || 'effect-4' == settings.overlay ) {
						banner += ' overlay-' + settings.overlay;
					}
				}
				var banner_layer = 'banner-content';

				banner_layer += ' background-none';

				if ( settings.banner_origin ) {
					banner_layer += ' ' + settings.banner_origin;
				}

				wrapper_class += ' ' + banner_layer;
				wrapper_attrs += ' data-banner-class="' + banner + '"';
				if ( settings.banner_wrap_with ) {
					wrapper_attrs += ' data-wrap-class="' + settings.banner_wrap_with + '"';
				}
			}

			if ( settings.css_classes ) {
				wrapper_attrs += ' data-css-classes="' + settings.css_classes + '"';
			}
		#>
		<# if( 'banner' == settings.use_as && ( settings.background_image.url || settings.background_color ) ) { #>
			<figure class="banner-img" style="background-color: {{settings.background_color}}">
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
		<# if( 'accordion_content' == settings.use_as ) { #>
			<div class="card-header"></div>
		<# } #>
		<?php if ( ! $is_dom_optimization_active ) { ?>
			<div class="elementor-<?php echo $wrapper_element; ?>-wrap{{ wrapper_class }}" {{{ wrapper_attrs }}}>
		<?php } else { ?>
			<div class="elementor-<?php echo $wrapper_element; ?>-wrap{{ wrapper_class }} {{ extra_class }}" {{{ wrapper_attrs }}} {{{extra_attrs}}}>
		<?php } ?>
			<div class="elementor-background-overlay"></div>
			<?php if ( ! $is_dom_optimization_active ) { ?>
				<div class="elementor-widget-wrap{{{ extra_class }}}" {{{ extra_attrs }}}></div>
			<?php } ?>
		<?php if ( $is_dom_optimization_active ) { ?>
			</div>
		<?php } ?>
		<# if( 'slider' == settings.use_as && 'thumb' == settings.dots_kind ) { #>
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
		
		<?php if ( ! $is_dom_optimization_active ) { ?>
			</div>
			<?php
		}
	}

	public function before_render() {
		$settings = $this->get_settings_for_display();

		$has_background_overlay = in_array( $settings['background_overlay_background'], array( 'classic', 'gradient' ), true ) || in_array( $settings['background_overlay_hover_background'], array( 'classic', 'gradient' ), true );

		$is_dom_optimization_active = riode_elementor_if_dom_optimization();
		$wrapper_attribute_string   = $is_dom_optimization_active ? '_widget_wrapper' : '_inner_wrapper';

		$column_wrap_classes = $is_dom_optimization_active ? array( 'elementor-widget-wrap' ) : array( 'elementor-column-wrap' );

		if ( $this->get_children() ) {
			$column_wrap_classes[] = 'elementor-element-populated';
		}

		if ( 'slider' == $settings['use_as'] && 'thumb' == $settings['dots_kind'] ) {
			if ( ! $is_dom_optimization_active ) {
				$column_wrap_classes[] = 'flex-wrap';
			} else {
				$this->add_render_attribute( '_wrapper', 'class', 'flex-wrap' );
			}
		}

		$this->add_render_attribute(
			array(
				'_inner_wrapper'      => array(
					'class' => $column_wrap_classes,
				),
				'_widget_wrapper'     => array(
					'class' => $is_dom_optimization_active ? $column_wrap_classes : 'elementor-widget-wrap',
				),
				'_background_overlay' => array(
					'class' => array( 'elementor-background-overlay' ),
				),
			)
		);
		?>
		<<?php echo $this->get_html_tag(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		 <?php $this->print_render_attribute_string( '_wrapper' ); ?>>
			<?php
			if ( 'accordion_content' == $settings['use_as'] ) : // accordion header
				global $riode_section;
				if ( ! empty( $riode_section ) && ! empty( $riode_section['section'] ) && 'accordion' == $riode_section['section'] ) {
					?>
					<div class="card-header">
						<a href="<?php echo $this->get_data( 'id' ); ?>" class="<?php echo 1 == $riode_section['index'] ? 'collapse' : 'expand'; ?>">
							<?php
							if ( $settings['accordion_header_icon']['value'] ) {
								echo '<i class="' . $settings['accordion_header_icon']['value'] . '"></i>';
							}
							?>
							<span class="title"><?php echo esc_html( $settings['accordion_title'] ? $settings['accordion_title'] : 'undefined' ); ?></span>
							<?php
							if ( $riode_section['active_icon']['value'] ) {
								echo '<span class="toggle-icon opened"><i class="' . $riode_section['active_icon']['value'] . '"></i></span>';
							}
							if ( $riode_section['icon']['value'] ) {
								echo '<span class="toggle-icon closed"><i class="' . $riode_section['icon']['value'] . '"></i></span>';
							}
							?>
						</a>
					</div>
					<?php
				}
			endif;
			?>

			<?php
			if ( 'banner' === $settings['use_as'] ) {
				if ( isset( $settings['background_image']['id'] ) ) :
					$banner_img_id = $settings['background_image']['id'];
					?>
				<figure class="banner-img">
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

						echo wp_get_attachment_image(
							$settings['background_image_mobile']['id'],
							'full',
							false,
							$image_atts
						);
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

						echo wp_get_attachment_image(
							$settings['background_image_tablet']['id'],
							'full',
							false,
							$image_atts
						);
					}

					$desktop_image = wp_get_attachment_image_src( $banner_img_id, 'full', false );

					if ( $desktop_image ) {
						list( $desktop_src, $desktop_width, $desktop_height ) = $desktop_image;
						$image_atts['srcset']                                 = $desktop_src;
						$image_atts['class']                                  = $desktop_class;
					}
					echo wp_get_attachment_image(
						$banner_img_id,
						'full',
						false,
						$image_atts
					);
					?>
				</figure>
					<?php
				endif;
				if ( 'container' == $settings['banner_wrap_with'] ) {
					echo '<div class="container">';
				} elseif ( 'container-fluid' == $settings['banner_wrap_with'] ) {
					echo '<div class="container-fluid">';
				}
			}
			?>

			<?php
			// Additionals
			do_action( 'riode_elementor_common_before_render_content', $settings, $this->get_ID() );
			?>

			<div <?php $this->print_render_attribute_string( '_inner_wrapper' ); ?>>
		<?php if ( $has_background_overlay ) : ?>
			<div <?php $this->print_render_attribute_string( '_background_overlay' ); ?>></div>
		<?php endif; ?>
		<?php if ( ! $is_dom_optimization_active ) : ?>
			<div <?php $this->print_render_attribute_string( '_widget_wrapper' ); ?>>
		<?php endif; ?>
		<?php
	}

	public function after_render() {
		$settings = $this->get_settings_for_display();
		if ( ! riode_elementor_if_dom_optimization() ) {
			?>
				</div>
			<?php } ?>

		<?php if ( 'banner' === $settings['use_as'] && $settings['banner_wrap_with'] ) : ?>
			</div>
		<?php endif; ?>

		<?php
		if ( 'slider' == $settings['use_as'] && 'thumb' == $settings['dots_kind'] ) {
			if ( riode_elementor_if_dom_optimization() ) {
				?>
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
		if ( 'slider' != $settings['use_as'] || 'thumb' != $settings['dots_kind'] || ! riode_elementor_if_dom_optimization() ) {
			?>
			</div>
			<?php
		}
		?>

		</<?php echo $this->get_html_tag(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php
	}
}

if ( ! function_exists( 'riode_column_render_attributes' ) ) {
	/**
	 * Add render attributes for columns.
	 *
	 * @since 1.0
	 */
	function riode_column_render_attributes( $self ) {

		global $riode_section;
		global $riode_breakpoints;

		$settings = $self->get_settings_for_display();

		$inner_args   = array();
		$widget_args  = array();
		$wrapper_args = array( 'class' => '' );

		$is_dom_optimization_active = riode_elementor_if_dom_optimization();

		global $riode_section;

		if ( isset( $riode_section['section'] ) && 'creative' == $riode_section['section'] && $riode_section['top'] == $self->get_data( 'isInner' ) ) { // creative
			$idx       = $riode_section['index'];
			$classes[] = 'grid-item';
			$grid      = array();
			if ( $idx < count( $riode_section['preset'] ) ) {
				foreach ( $riode_section['preset'][ $idx ] as $key => $value ) {
					if ( 'h' == $key ) {
						continue;
					}

					$grid[ $key ] = $value;
				}
			} else {
				$grid['w']   = '1-4';
				$grid['w-l'] = '1-2';
			}

			if ( $settings['creative_width'] ) {
				$grid['w'] = $grid['w-l'] = $grid['w-m'] = $grid['w-s'] = $settings['creative_width'];
			}
			if ( $settings['creative_width_tablet'] ) {
				$grid['w-l'] = $grid['w-m'] = $grid['w-s'] = $settings['creative_width_tablet'];
			}
			if ( $settings['creative_width_mobile'] ) {
				$grid['w-m'] = $grid['w-s'] = $settings['creative_width_mobile'];
			}

			if ( 'preset' == $settings['creative_height'] ) {
				$grid['h'] = $idx < count( $riode_section['preset'] ) ? $riode_section['preset'][ $idx ]['h'] : '1-3';
			} elseif ( 'child' != $settings['creative_height'] ) {
				$grid['h'] = $settings['creative_height'];
			}

			if ( $settings['creative_height_tablet'] && 'preset' != $settings['creative_height_tablet'] && 'child' != $settings['creative_height_tablet'] ) {
				$grid['h-l'] = $settings['creative_height_tablet'];
			}
			if ( $settings['creative_height_mobile'] && 'preset' != $settings['creative_height_mobile'] && 'child' != $settings['creative_height_mobile'] ) {
				$grid['h-m'] = $settings['creative_height_mobile'];
			}

			if ( $settings['creative_order'] ) {
				$wrapper_args['data-creative-order'] = $settings['creative_order'];
			} else {
				$wrapper_args['data-creative-order'] = $idx + 1;
			}
			if ( $settings['creative_order_tablet'] ) {
				$wrapper_args['data-creative-order-lg'] = $settings['creative_order_tablet'];
			} else {
				$wrapper_args['data-creative-order-lg'] = $idx + 1;
			}
			if ( $settings['creative_order_mobile'] ) {
				$wrapper_args['data-creative-order-md'] = $settings['creative_order_mobile'];
			} else {
				$wrapper_args['data-creative-order-md'] = $idx + 1;
			}

			foreach ( $grid as $key => $value ) {
				if ( false !== strpos( $key, 'w' ) && is_numeric( $value ) && 1 != $value ) {
					if ( 0 == 100 % $value ) {
						if ( 100 == $value ) {
							$grid[ $key ] = '1';
						} else {
							$grid[ $key ] = '1-' . ( 100 / $value );
						}
					} else {
						for ( $i = 1; $i <= 100; ++$i ) {
							$val       = $value * $i;
							$val_round = round( $val );
							if ( abs( round( $val - $val_round, 2, PHP_ROUND_HALF_UP ) ) <= 0.01 ) {
								$g            = riode_get_gcd( 100, $val_round );
								$grid[ $key ] = ( $val_round / $g ) . '-' . ( $i * 100 / $g );
								break;
							}
						}
					}
				}
			}

			$riode_section['layout'][ $idx ] = $grid;
			foreach ( $grid as $key => $value ) {
				if ( $value ) {
					$classes[] = $key . '-' . $value;
				}
			}
			$riode_section['index'] = ++$idx;

			$wrapper_args['class'] .= implode( ' ', $classes );
		}

		if ( 'slider' === $settings['use_as'] ) { // if using as slider

			$col_cnt = riode_elementor_grid_col_cnt( $settings );

			$extra_class   = riode_get_col_class( $col_cnt );
			$extra_class  .= ' ' . riode_elementor_grid_space_class( $settings );
			$extra_class  .= ' ' . riode_get_slider_class( $settings );
			$extra_options = riode_get_slider_attrs( $settings, $col_cnt, $self );

			if ( ! $is_dom_optimization_active ) {
				$widget_args['class']            = $extra_class;
				$widget_args['data-plugin']      = 'owl';
				$widget_args['data-owl-options'] = esc_attr( json_encode( $extra_options ) );
			} else {
				$inner_args['class']            = $extra_class;
				$inner_args['data-plugin']      = 'owl';
				$inner_args['data-owl-options'] = esc_attr( json_encode( $extra_options ) );
			}
		} elseif ( 'banner_layer' == $settings['use_as'] ) { // if banner content
			$wrapper_args['class'] .= ' banner-content';
			if ( $settings['banner_origin'] ) {
				$wrapper_args['class'] .= ' ' . $settings['banner_origin'];
			}
		} elseif ( 'banner' == $settings['use_as'] ) { // if 1 layer banner
			$wrapper_args['class'] .= ' el-banner banner el-banner-fixed banner-fixed';
			if ( $settings['overlay'] && function_exists( 'riode_get_overlay_class' ) ) {
				$wrapper_args['class'] .= ' ' . riode_get_overlay_class( $settings['overlay'] );
			}
			$inner_args['class']  = 'banner-content';
			$inner_args['class'] .= ' background-none';
			if ( $settings['banner_origin'] ) {
				$inner_args['class'] .= ' ' . $settings['banner_origin'];
			}
		} elseif ( 'tab_content' == $settings['use_as'] ) { // tab content
			$classes[]                 = ' tab-pane';
			$wrapper_args['data-role'] = ' tab-pane';
			$wrapper_args['id']        = $self->get_data( 'id' );
			if ( isset( $riode_section['section'] ) ) {
				$riode_section['tab_data'][] = array(
					'title'    => $settings['tab_title'],
					'icon'     => $settings['tab_icon']['value'],
					'icon_pos' => $settings['tab_icon_pos'],
					'id'       => $self->get_data( 'id' ),
				);

				if ( 'tab' == $riode_section['section'] && 0 == $riode_section['index'] ) {
					$classes[] = 'active';
				}
			}
			if ( isset( $riode_section['index'] ) ) {
				$riode_section['index'] = ++$riode_section['index'];
			}
			$wrapper_args['class'] .= ' ' . implode( ' ', $classes );
		} elseif ( 'accordion_content' == $settings['use_as'] ) {
			if ( isset( $riode_section['section'] ) ) {
				$inner_args['id']       = $self->get_data( 'id' );
				$wrapper_args['class'] .= ' card';
				if ( 'accordion' == $riode_section['section'] ) {
					if ( 0 == $riode_section['index'] ) {
						$inner_args['class'] = 'card-body expanded';
					} else {
						$inner_args['class'] = 'card-body collapsed';
					}
				}
				$riode_section['index'] = ++$riode_section['index'];
			}
		}

		$self->add_render_attribute(
			array(
				'_wrapper'        => apply_filters( 'riode_elementor_common_wrapper_attributes', $wrapper_args, $settings, $self->get_ID() ),
				'_inner_wrapper'  => $inner_args,
				'_widget_wrapper' => $widget_args,
			)
		);

		if ( 'banner' != $settings['use_as'] && $settings['background_image'] && $settings['background_image']['url'] && function_exists( 'riode_get_option' ) && riode_get_option( 'lazyload' ) ) {
			if ( ! is_admin() && ! is_customize_preview() && ! riode_doing_ajax() ) {
				$data = array(
					'class'     => 'd-lazy-back',
					'data-lazy' => esc_url( $settings['background_image']['url'] ),
				);
				if ( $settings['background_color'] ) {
					$data['style'] = 'background-color: ' . riode_get_option( 'lazyload_bg' ) . ';';
				}
				$self->add_render_attribute( array( '_inner_wrapper' => $data ) );
			}
		}
	}
}
