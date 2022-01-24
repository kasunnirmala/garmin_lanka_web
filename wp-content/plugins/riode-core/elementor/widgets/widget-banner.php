<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Banner Widget
 *
 * Riode Widget to display banner.
 *
 * @since 1.0
 */

class Riode_Banner_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_banner';
	}

	public function get_title() {
		return esc_html__( 'Banner', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-banner';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'banner' );
	}

	public function get_script_depends() {
		return array( 'jquery-parallax' );
	}

	protected function register_controls() {
		riode_elementor_banner_controls( $this );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'title' );
		include RIODE_CORE_PATH . 'elementor/render/widget-banner-render.php';
	}

	public function before_render() {
		$atts = $this->get_settings_for_display();
		if ( function_exists( 'riode_get_option' ) && riode_get_option( 'lazyload' ) ) {

			if ( ! is_customize_preview() && isset( $atts['banner_background_image'] ) && isset( $atts['banner_background_image']['url'] ) ) {
				if ( ! $atts['absolute_banner'] || ! $atts['fixed_banner'] ) {
					$this->add_render_attribute(
						'_wrapper',
						array(
							'class'     => 'd-lazy-back',
							'data-lazy' => esc_url( $atts['banner_background_image']['url'] ),
						)
					);
				}
			}
		}
		if ( 'yes' == $atts['fixed_banner'] && 'yes' == $atts['absolute_banner'] ) {
			$this->add_render_attribute(
				'_wrapper',
				array(
					'class' => 'background-none',
				)
			);
		}
		if ( 'yes' == $atts['absolute_banner'] && '' !== $atts['background_effect'] && '' !== $atts['particle_effect'] ) {
			$this->add_render_attribute(
				'_wrapper',
				array(
					'class' => 'background-none p-relative',
				)
			);
		}
		?>
		<div <?php $this->print_render_attribute_string( '_wrapper' ); ?>>
		<?php
	}

	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'banner_wrapper', 'class', 'el-banner banner' );
		view.addRenderAttribute( 'banner_content', 'class', 'banner-content' );

		let banner_preset = settings.banner_preset;

		if ( -1 != banner_preset.indexOf( 'boxed-' ) ) {
			view.addRenderAttribute( 'banner_wrapper', 'class', 'boxed' );
		}

		view.addRenderAttribute( 'banner_wrapper', 'class', settings.banner_preset );

		if ( '' !== settings.overlay ) {

			let overlayClass = '';

			if ( 'light' == settings.overlay || 'dark' == settings.overlay || 'zoom' == settings.overlay ) {
				overlayClass = 'overlay-' + settings.overlay;
			} else if ( 'zoom_light' == settings.overlay ) {
				overlayClass = 'overlay-zoom overlay-light';
			} else if ( 'zoom_dark' == settings.overlay ) {
				overlayClass = 'overlay-zoom overlay-dark';
			} else if ( 'effect-1' == settings.overlay || 'effect-2' == settings.overlay || 'effect-3' == settings.overlay || 'effect-4' == settings.overlay ) {
				overlayClass = 'overlay-' + settings.overlay;
			} else {
				overlayClass = 'overlay-image-filter overlay-' + settings.overlay;
			}
			
			view.addRenderAttribute( 'banner_wrapper', 'class', overlayClass );
		}

		if ( 'yes' == settings.absolute_banner ) {
			view.addRenderAttribute( 'banner_wrapper', 'class', 'el-banner-fixed banner-fixed' );
		}

		if ( 'no' == settings.fixed_banner ) {
			view.addRenderAttribute( 'banner_wrapper', 'class', 'p-static' );
		}
		
		view.addRenderAttribute( 'banner_content', 'class', settings.banner_origin );

		// Parallax
		if ( 'yes' == settings.parallax ) {
			let parallax_img     = settings.banner_background_image.url;
			let parallax_options = {
				'speed'          : settings.parallax_speed.size ? 10 / settings.parallax_speed.size : 1.5,
				'parallaxHeight' : settings.parallax_height.size ? settings.parallax_height.size + '%' : '300%',
				'offset'         : settings.parallax_offset.size ? settings.parallax_offset.size : 0,
			};
			view.addRenderAttribute( 'banner_wrapper', 'class', 'parallax' );
			view.addRenderAttribute( 'banner_wrapper', 'data-plugin', 'parallax' );
			view.addRenderAttribute( 'banner_wrapper', 'data-image-src', parallax_img );
			view.addRenderAttribute( 'banner_wrapper', 'data-parallax-options', JSON.stringify( parallax_options ) );
		}

		#><div {{{ view.getRenderAttributeString( 'banner_wrapper' ) }}}><#

		if ( '' !== settings.background_effect || '' !== settings.particle_effect ) {
			let background_effectClass = 'background-effect ';
			let particle_effectClass   = 'particle-effect ';
			if ( settings.background_effect ) {
				background_effectClass += settings.background_effect;
			}
			if ( settings.particle_effect ) {
				particle_effectClass += settings.particle_effect;
			}

			view.addRenderAttribute( 'backgroundClass', 'class', background_effectClass );
			view.addRenderAttribute( 'particleClass', 'class', particle_effectClass );

			if ( settings.banner_background_image ) {
				let background_img = '';
				if ( settings.particle_effect && !settings.background_effect ) {
					background_img = '';
				} else {
				background_img = 'background-image: url(' + settings.banner_background_image.url + '); background-size: cover;';
				}
				view.addRenderAttribute( 'backgroundClass', 'style', background_img );
			}

			#>
			<div class="background-effect-wrapper">
			<div {{{ view.getRenderAttributeString( 'backgroundClass' ) }}}>
			<# if ( '' !== settings.particle_effect ) { #>
				<div {{{ view.getRenderAttributeString( 'particleClass' ) }}}></div>
			<# } #> 
			</div>
			</div>
			<#
		}
				
		if ( settings.banner_background_image.id && 'yes' == settings.absolute_banner && 'yes' == settings.fixed_banner ) {
			#>
			<figure class="banner-img">
				<#
				let tablet_class = '',
					desktop_class = '';
				if ( settings.banner_background_image_mobile.id ) {
					tablet_class = 'show-only-tablet';
					desktop_class = 'hide-mobile';
					#>
					<img src="{{ settings.banner_background_image_mobile.url }}" class="show-only-mobile">	
					<#
				} else {
					tablet_class = 'show-tablet';
				}
				#>
				<#
				if ( settings.banner_background_image_tablet.id ) {
					desktop_class = 'show-only-desktop';
					#>
					<img src="{{ settings.banner_background_image_tablet.url }}" class="{{ tablet_class }}">	
					<#
				}
				#>
				<img src="{{ settings.banner_background_image.url }}" class="{{ desktop_class }}">
			</figure>
			<#
		}
		
		if ( settings.banner_wrap ) {
			#><div class="{{ settings.banner_wrap }}"><#
		}

		// Showing Items
		#><div {{{ view.getRenderAttributeString( 'banner_content' ) }}}><#

		if ( settings._content_animation ) {
			view.addRenderAttribute( 'banner_content_inner', 'class', 'appear-animate animated-' + settings.content_animation_duration );
			let contentSettings       = {
				'_animation'       : settings._content_animation,
				'_animation_delay' : settings._content_animation_delay ? settings._content_animation_delay : 0,
			};
			view.addRenderAttribute( 'banner_content_inner', 'data-settings', JSON.stringify( contentSettings ) );
			#><div {{{ view.getRenderAttributeString( 'banner_content_inner' ) }}}><#
		}

		_.each( settings.banner_item_list, function( item, index ) {

			let item_key = 'banner_item';
			if ( item.banner_item_type == 'text' ) { // Text
				item_key = view.getRepeaterSettingKey( 'banner_text_content', 'banner_item_list', index );
			}

			view.renderAttributes[item_key] = {};
			view.addRenderAttribute( item_key, 'class', 'banner-item' );
			view.addRenderAttribute( item_key, 'class', 'elementor-repeater-item-' + item._id );

			// Custom Class
			if ( item.banner_item_aclass ) {
				view.addRenderAttribute( item_key, 'class', item.banner_item_aclass );
			}

			// Item display type
			if ( item.banner_item_display == 'block' ) {
				view.addRenderAttribute( item_key, 'class', 'item-block' );
			} else {
				view.addRenderAttribute( item_key, 'class', 'item-inline' );
			}

			let floating = {
				floating: item.riode_floating,
				m_track_dir: item.riode_m_track_dir,
				m_track_speed: item.riode_m_track_speed.size ? item.riode_m_track_speed.size : 0.5,
				scroll_size: item.riode_scroll_size.size ? item.riode_scroll_size.size : 50,
				scroll_stop: item.riode_scroll_stop,
			};
			view.addRenderAttribute( item_key, 'data-floating', JSON.stringify(floating) );
			if ( item.riode_floating ) {
				#><div {{{ view.getRenderAttributeString( item_key ) }}}><#
				view.renderAttributes[item_key] = {};
			}

			if ( item.banner_item_type == 'text' ) { // Text

				view.addRenderAttribute( item_key, 'class', 'elementor-banner-item-text text' );

				view.addInlineEditingAttributes( item_key );

				#><{{item.banner_text_tag}} {{{ view.getRenderAttributeString( item_key ) }}}>{{{ item.banner_text_content }}}</{{item.banner_text_tag}}><#

			} else if ( item.banner_item_type == 'button' ) { // Button

				btn_class = [];

				if ( item.button_type ) {
					btn_class.push(item.button_type);
				}
				if ( item.link_hover_type ) {
					btn_class.push(item.link_hover_type);
				}
				if ( item.button_size ) {
					btn_class.push(item.button_size);
				}
				if ( item.shadow ) {
					btn_class.push(item.shadow);
				}
				if ( item.button_border ) {
					btn_class.push(item.button_border);
				}
				if ( item.button_skin ) {
					btn_class.push(item.button_skin);
				}
				if ( item.btn_class ) {
					btn_class.push(item.btn_class);
				}
				if ( 'yes' == item.icon_hover_effect_infinite ) {
					btn_class.push('btn-infinite');
				}

				if ( 'yes' == item.show_icon && item.icon && item.icon.value ) {
					if ( 'yes' != item.show_label ) {
						btn_class.push('btn-icon');
					} else if ( 'before' == item.icon_pos ) {
						btn_class.push('btn-icon-left');
					} else {
						btn_class.push('btn-icon-right');
					}
					if ( item.icon_hover_effect ) {
						btn_class.push(item.icon_hover_effect);
					}
				}

				view.addRenderAttribute( item_key, 'href', item.banner_btn_link.url );
				view.addRenderAttribute( item_key, 'class', 'btn' );
				if ( item.banner_btn_aclass ) {
					view.addRenderAttribute( item_key, 'class', item.banner_btn_aclass );
				}
				view.addRenderAttribute( item_key, 'class', btn_class );
					#>
				<a {{{ view.getRenderAttributeString( item_key ) }}}>
					<#
					let btn_text_key = view.getRepeaterSettingKey( 'banner_btn_text', 'banner_item_list', index );

					view.addRenderAttribute( btn_text_key, 'class', 'elementor-banner-item-text' );
					view.addInlineEditingAttributes( btn_text_key );

					let btn_text = '';

					btn_text = item.banner_btn_text;
					if ( item.icon && item.icon.value && 'yes' == item.show_icon ) {
						if ( 'yes' != item.show_label ) {
							#><i class="{{{ item.icon.value }}}"></i><#
						} else if ( 'before' == item.icon_pos ) {
							#>
							<i class="{{{ item.icon.value }}}"></i><span {{{ view.getRenderAttributeString( btn_text_key ) }}}>{{{ btn_text }}}</span>
							<#
						} else {
							#>
							<span {{{ view.getRenderAttributeString( btn_text_key ) }}}>{{{ btn_text }}}</span><i class="{{{ item.icon.value }}}"></i>
							<#
						}
					} else {
						#>
					<span {{{ view.getRenderAttributeString( btn_text_key ) }}}>{{{ btn_text }}}</span>
						<#
					}
					#>
				</a>
					<#
			} else { // Image
				let image = {
					id: item.banner_image.id,
					url: item.banner_image.url,
					size: item.banner_image_size,
					dimension: item.banner_image_custom_dimension,
					model: view.getEditModel()
				};
				let image_url = elementor.imagesManager.getImageUrl( image );
				view.addRenderAttribute( item_key, 'src', image_url );

				#><img {{{ view.getRenderAttributeString( item_key ) }}}><#
			}

			if ( item.riode_floating ) {
				#>
				</div>
				<#
			}
		} );
		if ( settings._content_animation ) {
			#></div><#
		}
		#></div><#
		if ( settings.banner_wrap ) {
			#></div><#
		}
		#></div><#
		#>
		<?php
	}
}
