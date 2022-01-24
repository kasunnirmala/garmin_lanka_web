<?php
/**
 * Initialize WPBakery
 *
 * @since 1.1.0
 */

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

// WP Bakery
define( 'RIODE_CORE_WPB', RIODE_CORE_PATH . 'wpb' );



if ( ! class_exists( 'Riode_WPB_Init' ) ) :
	class Riode_WPB_Init {
		/**
		 * Instance
		 *
		 * @since 1.1.0
		 * @var Riode_WPB_Init
		 */
		private static $instance;

		/**
		 * Is WPBakery?
		 *
		 * @since 1.1.0
		 * @var boolean $is_wpb
		 */
		public static $is_wpb = true;

		/**
		 * Shortcodes
		 *
		 * @since 1.1.0
		 * @var array $shortcodes Array of custom shortcodes
		 */
		public $shortcodes = array(
			'360_degree',
			'accordion',
			'accordion_item',
			'banner',
			'banner_layer',
			'block',
			'blockquote',
			'breadcrumb',
			'button',
			'carousel',
			'countdown',
			'counter',
			'wrapper',
			'heading',
			'hotspot',
			'image_box',
			'image_gallery',
			'infobox',
			'list',
			'list_item',
			'logo',
			'masonry',
			'masonry_item',
			'menu',
			'posts',
			'share_icons',
			'share_icon',
			'svgfloating',
			'tab',
			'tab_item',
			'testimonial',
			'videoplayer',
			'videopopup',
		);

		/**
		 * Params
		 *
		 * @since 1.1.0
		 * @var array $params Array of custom control names
		 */
		public static $params = array(
			'button-group',
			'color-group',
			'number',
			'dimension',
			'heading',
			'typography',
			'multiselect',
			'responsive',
			'datetimepicker',
			'dropdown',
			'dropdown-group',
		);

		/**
		 * Dimension Patterns
		 *
		 * @since 1.1.0
		 * @var array $dimensions
		 */
		public static $dimensions = array(
			'top'    => '{{TOP}}',
			'right'  => '{{RIGHT}}',
			'bottom' => '{{BOTTOM}}',
			'left'   => '{{LEFT}}',
		);

		/**
		 * Get instance
		 *
		 * @since 1.1.0
		 * @return Riode_WPB_Init Riode_WPB_Init object
		 */
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			require_once RIODE_CORE_WPB . '/functions.php';

			if ( class_exists( 'WooCommerce' ) ) {
				$this->shortcodes = array_merge(
					$this->shortcodes,
					array(
						'categories',
						'products',
						'filter',
						'filter_item',
						'products_layout',
						'products_banner_item',
						'products_single_item',
						'singleproducts',
						'subcategories',
						'vendor',
						'wp_product_categories',
					)
				);
			}

			$this->add_shortcodes();

			// registers riode addons for wpb page builder including studio, resize, template condition
			add_filter( 'vc_nav_controls', array( $this, 'add_addon_list_html' ) );
			add_filter( 'vc_nav_front_controls', array( $this, 'add_addon_list_html' ) );
			// trick to run BuilderAddons function in admin.js
			if ( riode_is_wpb_preview() ) {
				add_filter( 'riode_builder_addon_html', array( $this, 'add_addon_html_to_vars' ) );

				add_action(
					'admin_enqueue_scripts',
					function() {
						wp_enqueue_script( 'riode-wpb-admin-js', RIODE_CORE_URI . 'assets/js/wpb-admin' . riode_get_js_extension(), array(), RIODE_CORE_VERSION, true );
						wp_localize_script(
							'riode-wpb-admin-js',
							'riode_wpb_admin_vars',
							apply_filters(
								'riode_core_wpb_admin_localize_vars',
								array(
									'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
								)
							)
						);
					}
				);
			}

			add_filter( 'vc_base_build_shortcodes_custom_css', array( $this, 'add_shortcodes_custom_css' ), 10, 2 );

			foreach ( $this::$params as $param ) {
				require_once RIODE_CORE_WPB . '/params/' . $param . '.php';
			}

			require_once RIODE_CORE_WPB . '/elements/shortcodes/existing.php';

			if ( vc_is_inline() ) {
				riode_remove_all_admin_notices();
			}

			// Init Google Fonts
			$this->init_google_fonts();

			// Init Riode Icons
			$this->init_riode_icons();

			add_action( 'wp_ajax_vc_save', array( $this, 'save_custom_panel_options' ), 9 );
			add_action( 'save_post', array( $this, 'save_custom_panel_options' ), 1 );

			add_action( 'riode_before_enqueue_theme_style', array( $this, 'add_global_css' ) );
			add_action( 'riode_after_enqueue_custom_style', array( $this, 'add_block_css' ) );

			// Change load ordering of custom & shortcode css
			add_action(
				'template_redirect',
				function() {
					remove_action( 'wp_head', array( Vc_Manager::getInstance()->vc(), 'addFrontCss' ), 1000 );
					add_action(
						'wp_head',
						function() {
							$wpb = Vc_Manager::getInstance()->vc();
							$wpb->addShortcodesCustomCss();
							$wpb->addPageCustomCss();
						},
						1000
					);
				}
			);
		}

		/**
		 * Init Riode Icons
		 *
		 * @since 1.1.0
		 */
		public function init_riode_icons() {
			require_once RIODE_CORE_WPB . '/lib/icons.php';
			add_action(
				'admin_enqueue_scripts',
				function() {
					if ( riode_is_wpb_preview() && defined( 'RIODE_VERSION' ) ) {
						wp_enqueue_style( 'riode-icons', RIODE_ASSETS . '/vendor/riode-icons/css/icons.min.css', array(), RIODE_VERSION );
					}
				}
			);
		}

		/**
		 * Init Google Fonts
		 *
		 * @since 1.1.0
		 */
		public function init_google_fonts() {
			// Backend Editor Save
			add_action(
				'save_post',
				function( $id ) {
					if ( ! vc_user_access()->wpAny(
						array(
							'edit_post',
							$id,
						)
					)->get() ) {
						return;
					}
					$this->save_google_fonts( $id );
				},
				99
			);
			// Frontend Editor Save
			add_action(
				'wp_ajax_vc_save',
				function() {
					$post_id = intval( vc_post_param( 'post_id' ) );
					vc_user_access()->checkAdminNonce()->validateDie()->wpAny( 'edit_posts', 'edit_pages' )->validateDie()->canEdit( $post_id )->validateDie();

					if ( $post_id > 0 ) {
						$this->save_google_fonts( $post_id );
					}
				},
				99
			);
		}

		/**
		 * add_addon_list_html
		 *
		 * registers riode addons for wpb page builder including below items
		 * - studio
		 * - edit area resize
		 * - template condition
		 * - popup options
		 *
		 * @since 1.1.0
		 * @param array $list
		 */
		public function add_addon_list_html( $list ) {
			$html  = '<li class="riode-wpb-addons">';
			$html .= '<a class="vc_icon-btn riode-wpb-addons-trigger" title="' . esc_html( 'Riode Addons', 'riode-core' ) . '"><span class="vc-composer-icon riode-mini-logo"></span></a>';
			$html .= '<ul class="dropdown riode-addons-dropdown">';

			$html .= '<li><a id="wpb-riode-studio-trigger" class="riode-wpb-addon-item"><i class="d-icon-layer"></i>' . esc_html( 'Riode Studio', 'riode-core' ) . '</a></li>';

			$post_type          = get_post_type( get_the_ID() );
			$post_type_category = get_post_meta( get_the_ID(), 'riode_template_type', true );

			if ( vc_is_inline() ) {
				if ( ! ( 'riode_template' == $post_type && 'popup' == $post_type_category ) ) {
					$html .= '<li><a id="riode-edit-area" class="riode-wpb-addon-item"><i class="fas fa-arrows-alt-h"></i>' . esc_html( 'Edit Area Size', 'riode-core' ) . '</a></li>';

					$this->add_custom_panel( 'edit_area_size_panel', 'vc_ui-panel-edit-area-size.tpl.php' );
				}
			}

			if ( 'riode_template' == $post_type && 'popup' == $post_type_category ) {
				$html .= '<li><a id="riode-popup-options" class="riode-wpb-addon-item"><i class="far fa-sun"></i>' . esc_html( 'Popup Options', 'riode-core' ) . '</a></li>';

				$this->add_custom_panel( 'popup_panel', 'vc_ui-panel-popup-options.tpl.php' );
			}

			if ( 'riode_template' == $post_type && ! in_array( $post_type_category, array( 'block', 'header', 'footer' ) ) ) {
				$html .= '<li><a id="riode-template-display-condition" class="riode-wpb-addon-item"><i class="d-icon-filter-2"></i>' . esc_html__( 'Template Condition', 'riode-core' ) . '</a></li>';
			}

			$html  .= '</ul>';
			$html  .= '</li>';
			$list[] = array( 'riode_addon', $html );
			return $list;
		}

		/**
		 * add_custom_panel
		 *
		 * adds custom panel to frontend and backend
		 *
		 * @since 1.1.0
		 */
		public function add_custom_panel( $id, $template ) {
			add_filter(
				'vc_path_filter',
				function( $path ) use ( $id, $template ) {
					if ( false !== strpos( $path, 'editors/popups/class-vc-post-settings.php' ) ) {
						add_filter(
							'riode_core_admin_localize_vars',
							function( $vars ) use ( $id, $template ) {
								if ( empty( $vars['wpb_preview_panels'] ) ) {
									$vars['wpb_preview_panels'] = array();
								}
								ob_start();
								include RIODE_CORE_WPB . '/panels/' . $template;
								$vars['wpb_preview_panels'][ $id ] = ob_get_clean();
								return $vars;
							}
						);
					}

					return $path;
				}
			);
		}

		/**
		 * save_custom_panel_options
		 *
		 * saves custom panel options on ajax save event
		 * - popup options
		 * - edit area size
		 * - page css
		 *
		 * @since 1.1.0
		 */
		public function save_custom_panel_options( $post_id ) {
			if ( isset( $post_id ) && is_numeric( $post_id ) ) { // post save
				// save popup options
				if ( ! empty( $_POST['riode_popup_options'] ) ) {
					if ( is_array( $_POST['riode_popup_options'] ) ) {
						$_POST['riode_popup_options'] = wp_slash( json_encode( $_POST['riode_popup_options'] ) );
					}
					update_post_meta( $post_id, 'popup_options', $_POST['riode_popup_options'] );
				}

				// save edit area size
				if ( ! empty( $_POST['riode_edit_area_width'] ) ) {
					update_post_meta( $post_id, 'riode_edit_area_width', esc_attr( $_POST['riode_edit_area_width'] ) );
				}
			} else { // ajax save
				$post_id = intval( vc_post_param( 'post_id' ) );
				vc_user_access()->checkAdminNonce()->validateDie()->wpAny( 'edit_posts', 'edit_pages' )->validateDie()->canEdit( $post_id )->validateDie();

				// save popup options
				$popup_options = vc_post_param( 'riode_popup_options' );
				if ( $post_id > 0 && ! empty( $popup_options ) ) {
					if ( is_array( $popup_options ) ) {
						$popup_options = wp_slash( json_encode( $popup_options ) );
					}
					update_post_meta( $post_id, 'popup_options', $popup_options );
				}

				// save edit area size
				$edit_area_width = vc_post_param( 'riode_edit_area_width' );
				if ( $post_id > 0 && ! empty( $edit_area_width ) ) {
					update_post_meta( $post_id, 'riode_edit_area_width', esc_attr( $edit_area_width ) );
				}

				// save page css
				$page_css = vc_post_param( 'pageCss' );
				if ( $post_id > 0 && isset( $page_css ) ) {
					update_post_meta( $post_id, 'page_css', wp_slash( $page_css ) );
				}
			}
		}

		/**
		 * add_addon_html_to_vars
		 *
		 * tricks to run BuilderAddons function in admin.js
		 *
		 * @since 1.1.0
		 * @param array $html
		 */
		public function add_addon_html_to_vars( $html ) {
			$html[] = array(
				'wpb' => '',
			);

			return $html;
		}

		/**
		 * add_global_css
		 *
		 * enqueue JS Composer default style in header
		 *
		 * @since 1.1.0
		 */
		public function add_global_css() {
			if ( ! wp_style_is( 'js_composer_front' ) ) {
				wp_enqueue_style( 'js_composer_front' );
			}

			// WPBakery Page Builder
			$used_wpb_shortcodes = get_theme_mod( 'used_wpb_shortcodes', false );
			if ( ! empty( $used_wpb_shortcodes ) && ! riode_is_wpb_preview() ) {
				$upload_dir = wp_upload_dir();
				$upload_url = wp_upload_dir()['baseurl'];
				$css_file   = $upload_dir['basedir'] . '/riode_styles/js_composer.css';
				if ( file_exists( $css_file ) ) {
					$inline_styles = wp_styles()->get_data( 'js_composer_front', 'after' );
					wp_deregister_style( 'js_composer_front' );
					wp_dequeue_style( 'js_composer_front' );
					wp_enqueue_style( 'js_composer_front', $upload_url . '/riode_styles/js_composer.css', array(), RIODE_VERSION );
					if ( ! empty( $inline_styles ) ) {
						$inline_styles = implode( "\n", $inline_styles );
						wp_add_inline_style( 'js_composer_front', $inline_styles );
					}
				}
			}

			if ( defined( 'RIODE_VERSION' ) ) {
				wp_enqueue_style( 'riode-animation', RIODE_ASSETS . '/vendor/animate/animate.min.css' );
			}
		}

		/**
		 * add_block_css
		 *
		 * enqueue JS Composer default style in header
		 *
		 * @since 1.1.0
		 */
		public function add_block_css() {
			$used_blocks = function_exists( 'riode_get_layout_value' ) ? riode_get_layout_value( 'used_blocks' ) : array();
			if ( ! empty( $used_blocks ) ) {
				foreach ( $used_blocks as $block_id => $enqueued ) {
					if ( ! ( riode_is_wpb_preview() && isset( $_REQUEST['post_id'] ) && $_REQUEST['post_id'] == $block_id ) ) {
						$block_css  = get_post_meta( (int) $block_id, '_wpb_shortcodes_custom_css', true );
						$block_css .= get_post_meta( (int) $block_id, '_wpb_post_custom_css', true );
						$block_css .= get_post_meta( (int) $block_id, 'page_css', true );

						if ( $block_css ) {
							$block_css = function_exists( 'riode_minify_css' ) ? riode_minify_css( $block_css ) : $block_css;
						}

						wp_add_inline_style( 'riode-style', $block_css );
						$riode_layout['used_blocks'][ $block_id ]['css'] = true;
					}
				}
			}
		}

		/**
		 * Save used google fonts list
		 *
		 * @since 1.1.0
		 *
		 * @param integer $id
		 */
		public function save_google_fonts( $id ) {
			$post  = get_post( $id );
			$fonts = $this->get_google_fonts( $post->post_content );

			if ( ! empty( $fonts ) ) {
				update_post_meta( $id, 'riode_vc_google_fonts', rawurlencode( json_encode( $fonts ) ) );
			}
		}

		/**
		 * Get used google fonts
		 *
		 * @since 1.1.0
		 *
		 * @param string $content
		 */
		public function get_google_fonts( $content ) {
			$fonts = array();

			WPBMap::addAllMappedShortcodes();
			preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );

			foreach ( $shortcodes[2] as $index => $tag ) {
				// Get attributes
				$atts      = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
				$shortcode = WPBMap::getShortCode( $tag );
				if ( ! empty( $shortcode['params'] ) ) {
					foreach ( $shortcode['params'] as $param ) {
						if ( 'riode_typography' === $param['type'] && ! empty( $atts[ $param['param_name'] ] ) ) {
							$typography = json_decode( str_replace( '``', '"', $atts[ $param['param_name'] ] ), true );
							$font       = array();

							if ( ! empty( $typography['family'] ) && 'Inherit' != $typography['family'] && 'Default' != $typography['family'] ) {
								if ( empty( $fonts[ $typography['family'] ] ) ) {
									$font[ $typography['family'] ] = array( $typography['variant'] );
									$fonts                         = array_merge( $fonts, $font );
								} else {
									if ( ! in_array( $typography['variant'], $fonts[ $typography['family'] ] ) ) {
										$fonts[ $typography['family'] ][] = $typography['variant'];
									}
								}
							}
						}
					}
				}
			}

			foreach ( $shortcodes[5] as $shortcode_content ) {
				$fonts = array_merge_recursive( $fonts, $this->get_google_fonts( $shortcode_content ) );
			}

			return $fonts;
		}

		/**
		 * Add Shortcodes
		 *
		 * @since 1.1.0
		 */
		public function add_shortcodes( $shortcodes = array(), $path = '' ) {

			require_once RIODE_CORE_FUNCTIONS . '/core-functions.php';

			require_once RIODE_CORE_WPB . '/partials/extra.php';
			require_once RIODE_CORE_WPB . '/partials/design-option.php';

			$is_wpb = defined( 'WPB_VC_VERSION' );
			$left   = is_rtl() ? 'right' : 'left';
			$right  = 'left' == $left ? 'right' : 'left';

			if ( empty( $shortcodes ) ) {
				$shortcodes = $this->shortcodes;
			}

			if ( empty( $path ) ) {
				$path = RIODE_CORE_WPB . '/elements';
			}

			foreach ( $shortcodes as $shortcode ) {
				$callback = function( $atts, $content = null ) use ( $shortcode, $path ) {

					ob_start();

					$style_class = '';
					if ( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ) {
						if ( isset( $atts['css'] ) ) {
							$style_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), 'wpb_riode_' . $shortcode, $atts );
						}
					}
					// Frontend editor
					if ( isset( $_REQUEST['vc_editable'] ) && ( true == $_REQUEST['vc_editable'] ) ) {
						$style_array = $this->riode_generate_shortcode_css( 'wpb_riode_' . $shortcode, $atts );

						$style = '<style>';

						foreach ( $style_array as $key => $value ) {
							if ( 'responsive' == $key ) {
								$style .= $value;
							} else {
								$style .= $key . '{' . $value . '}';
							}
						}

						$style .= '</style>';
						echo $style;

						// Google Fonts
						$weights = array();
						$sc      = WPBMap::getShortCode( 'wpb_riode_' . $shortcode );
						if ( ! empty( $sc['params'] ) ) {
							foreach ( $sc['params'] as $param ) {
								if ( 'riode_typography' === $param['type'] ) {
									if ( isset( $atts[ $param['param_name'] ] ) ) {
										$typography = json_decode( str_replace( '``', '"', $atts[ $param['param_name'] ] ), true );
										$font       = array();

										if ( ! empty( $typography['family'] ) && 'Inherit' != $typography['family'] && 'Default' != $typography['family'] ) {
											if ( empty( $weights[ $typography['family'] ] ) ) {
												$font[ $typography['family'] ] = array( $typography['variant'] );
												$weights                       = array_merge( $weights, $font );
											} else {
												if ( ! in_array( $typography['variant'], $weights[ $typography['family'] ] ) ) {
													$weights[ $typography['family'] ][] = $typography['variant'];
												}
											}
										}
									}
								}
							}
						}

						foreach ( $weights as $family => $weight ) {
							$fonts[] = str_replace( ' ', '+', $family ) . ':' . implode( ',', $weight );
						}

						if ( ! empty( $fonts ) ) {
							wp_enqueue_style( strtolower( implode( '', $fonts ) ), esc_url( '//fonts.googleapis.com/css?family=' . implode( '%7C', $fonts ) ) );
						}
					}

					// Shortcode class
					if ( empty( $atts ) ) {
						$atts = array();
					}
					$atts['tag']     = 'wpb_riode_' . $shortcode;
					$shortcode_class = '';
					$sc              = WPBMap::getShortCode( 'wpb_riode_' . $shortcode );
					if ( ! empty( $sc['params'] ) ) {
						$shortcode_class = ' wpb_custom_' . riode_get_global_hashcode( $atts, 'wpb_riode_' . $shortcode, $sc['params'] );
					}

					$template = riode_wpb_shortcode_template( $shortcode, $path );

					if ( $template ) {
						require $template;
					}
					return ob_get_clean();
				};
				if ( ! shortcode_exists( 'wpb_riode_' . $shortcode ) ) {
					add_shortcode( 'wpb_riode_' . $shortcode, $callback );
				}
				add_action(
					'vc_after_init',
					function() use ( $shortcode, $left, $right, $path ) {
						include_once $path . '/shortcodes/' . str_replace( '_', '-', $shortcode ) . '.php';
					}
				);
			}
		}

		/**
		 * Add custom css of shortcodes
		 *
		 * @param  string $css
		 * @param  string $id
		 *
		 * @return string
		 * @since  2.0
		 */
		public function add_shortcodes_custom_css( $css, $id ) {
			$post = get_post( $id );

			$css_array = $this->parse_shortcodes_custom_css( $post->post_content );

			foreach ( $css_array as $key => $value ) {
				if ( 'responsive' == $key ) {
					if ( ! is_array( $value ) ) {
						$css .= $value;
					} else {
						$value = array_unique( $value );
						$css  .= implode( '', $value );
					}
				} else {
					if ( ! is_array( $value ) ) {
						$css .= $key . '{' . $value . '}';
					} else {
						$value = array_unique( $value );
						$css  .= $key . '{' . implode( '', $value ) . '}';
					}
				}
			}

			return $css;
		}

		/**
		 * Parse shortcodes custom css
		 *
		 * @param string $content
		 *
		 * @return array
		 * @since 1.1.0
		 */
		public function parse_shortcodes_custom_css( $content ) {
			$css = array();

			WPBMap::addAllMappedShortcodes();
			preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );

			foreach ( $shortcodes[2] as $index => $tag ) {
				// Get attributes
				$atts = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
				$css  = array_merge_recursive( $css, $this->riode_generate_shortcode_css( $tag, $atts ) );
			}

			foreach ( $shortcodes[5] as $shortcode_content ) {
				$css = array_merge_recursive( $css, $this->parse_shortcodes_custom_css( $shortcode_content ) );
			}

			return $css;
		}

		/**
		 * Generate Shortcode CSS
		 *
		 * @param string $tag
		 * @param array $atts
		 *
		 * @return array
		 * @since 1.1.0
		 */
		public function riode_generate_shortcode_css( $tag, $atts ) {
			$css = array();
			if ( defined( 'WPB_VC_VERSION' ) ) {
				$shortcode = WPBMap::getShortCode( $tag );

				// Get attributes
				if ( empty( $atts ) ) {
					$atts = array(
						'tag' => $tag,
					);
				} else {
					$atts['tag'] = $tag;
				}

				if ( isset( $shortcode['params'] ) && ! empty( $shortcode['params'] ) ) {
					$shortcode_class = '.wpb_custom_' . riode_get_global_hashcode( $atts, $tag, $shortcode['params'] );

					foreach ( $shortcode['params'] as $param ) {
						if ( isset( $param['selectors'] ) && ( isset( $atts[ $param['param_name'] ] ) || isset( $param['std'] ) ) ) {

							foreach ( $param['selectors'] as $key => $value ) {
								if ( isset( $param['std'] ) ) {
									$saved_value = $param['std'];
								}
								if ( isset( $atts[ $param['param_name'] ] ) ) {
									$saved_value = $atts[ $param['param_name'] ];
								}

								if ( 'riode_number' == $param['type'] && ! empty( $param['units'] ) && is_array( $param['units'] ) ) {
									$saved_value       = str_replace( '``', '"', $saved_value );
									$responsive_values = json_decode( $saved_value, true );
									if ( ! empty( $responsive_values['xl'] ) || ( isset( $responsive_values['xl'] ) && '0' === $responsive_values['xl'] ) ) {
										$saved_value = $responsive_values['xl'];
									} else {
										$saved_value = '';
									}
								} elseif ( 'riode_dimension' == $param['type'] ) {
									$saved_value      = str_replace( '``', '"', $saved_value );
									$dimension_values = json_decode( $saved_value, true );
								} elseif ( 'riode_typography' == $param['type'] ) {
									$saved_value = str_replace( '``', '"', $saved_value );
									$saved_value = json_decode( $saved_value, true );
									$typography  = '';
									if ( ! empty( $saved_value['family'] ) && 'Default' != $saved_value['family'] ) {
										if ( 'Inherit' == $saved_value['family'] ) {
											$typography .= 'font-family:inherit;';
										} else {
											$typography .= "font-family:'" . $saved_value['family'] . "';";
										}
									}
									if ( ! empty( $saved_value['variant'] ) ) {
										preg_match( '/^\d+|(regular)|(italic)/', $saved_value['variant'], $weight );
										if ( ! empty( $weight ) ) {
											if ( 'regular' == $weight[0] || 'italic' == $weight[0] ) {
												$weight[0] = 400;
											}
											$typography .= 'font-weight:' . $weight[0] . ';';
										}
										preg_match( '/(italic)/', $saved_value['variant'], $weight );
										if ( ! empty( $weight ) ) {
											$typography .= 'font-style:' . $weight[0] . ';';
										}
									}
									if ( ! empty( $saved_value['size'] ) && riode_check_units( $saved_value['size'] ) ) {
										$typography .= 'font-size:' . riode_check_units( $saved_value['size'] ) . ';';
									}
									if ( ! empty( $saved_value['letter_spacing'] ) || ( isset( $saved_value['letter_spacing'] ) && '0' === $saved_value['letter_spacing'] ) ) {
										$typography .= 'letter-spacing:' . $saved_value['letter_spacing'] . ';';
									}
									if ( ! empty( $saved_value['line_height'] ) || ( isset( $saved_value['line_height'] ) && '0' === $saved_value['line_height'] ) ) {
										$typography .= 'line-height:' . $saved_value['line_height'] . ';';
									}
									if ( ! empty( $saved_value['text_transform'] ) || ( isset( $saved_value['text_transform'] ) && '0' === $saved_value['text_transform'] ) ) {
										$typography .= 'text-transform:' . $saved_value['text_transform'] . ';';
									}
								}

								if ( ! empty( $param['units'] ) && is_array( $param['units'] ) ) {
									if ( empty( $responsive_values['unit'] ) ) {
										$value = str_replace( '{{UNIT}}', $param['units'][0], $value );
									} else {
										$value = str_replace( '{{UNIT}}', $responsive_values['unit'], $value );
									}
								}

								if ( ! empty( $param['responsive'] ) && $param['responsive'] ) {
									if ( isset( $param['std'] ) ) {
										$saved_value = $param['std'];
									}
									if ( isset( $atts[ $param['param_name'] ] ) ) {
										$saved_value = $atts[ $param['param_name'] ];
									}
									$saved_value       = str_replace( '``', '"', $saved_value );
									$key               = str_replace( '{{WRAPPER}}', $shortcode_class, $key );
									$responsive_values = json_decode( $saved_value, true );
									$style             = '';

									// Generate Responsive CSS
									$breakpoints = array(
										'lg' => '1199px',
										'md' => '991px',
										'sm' => '767px',
										'xs' => '575px',
									);

									if ( 'riode_dimension' == $param['type'] ) {
										$temp_value     = $value;
										$dimension_flag = false;
										foreach ( $this::$dimensions as $dimension => $pattern ) {
											if ( isset( $dimension_values[ $dimension ]['xl'] ) ) {
												$temp = riode_check_units( $dimension_values[ $dimension ]['xl'] );
												if ( ! $temp ) {
													$temp_value = preg_replace( '/([^;]*)(\{\{' . strtoupper( $dimension ) . '\}\})([^;]*)(;*)/', '', $temp_value );
												} else {
													$temp_value     = str_replace( $pattern, $temp, $temp_value );
													$dimension_flag = true;
												}
											}
										}
										if ( $dimension_flag ) {
											$style = $key . '{' . $temp_value . '}';
										}

										foreach ( $breakpoints as $breakpoint => $width ) {
											$temp_value     = $value;
											$dimension_flag = false;
											foreach ( $this::$dimensions as $dimension => $pattern ) {
												if ( isset( $dimension_values[ $dimension ][ $breakpoint ] ) ) {
													$temp = riode_check_units( $dimension_values[ $dimension ][ $breakpoint ] );
													if ( ! $temp ) {
														$temp_value = preg_replace( '/([^;]*)(\{\{' . strtoupper( $dimension ) . '\}\})([^;]*)(;*)/', '', $temp_value );
													} else {
														$temp_value     = str_replace( $pattern, $temp, $temp_value );
														$dimension_flag = true;
													}
												}
											}
											if ( $dimension_flag && ! empty( $temp_value ) ) {
												$style .= '@media (max-width:' . $width . '){';
												$style .= $key . '{' . $temp_value . '}}';
											}
										}
									} else {
										if ( ! empty( $responsive_values['xl'] ) || ( isset( $responsive_values['xl'] ) && '0' === $responsive_values['xl'] ) ) {
											if ( ! empty( $param['with_units'] ) && $param['with_units'] ) {
												$responsive_values['xl'] = riode_check_units( $responsive_values['xl'] );
												if ( false === $responsive_values['xl'] ) {
													break;
												}
											}
											$style = $key . '{' . str_replace( '{{VALUE}}', $responsive_values['xl'], $value ) . '}';
										}
										foreach ( $breakpoints as $breakpoint => $width ) {
											if ( ! empty( $param['with_units'] ) && $param['with_units'] ) {
												$responsive_values[ $breakpoint ] = riode_check_units( $responsive_values[ $breakpoint ] );
											}
											if ( ! empty( $responsive_values[ $breakpoint ] ) || ( isset( $responsive_values[ $breakpoint ] ) && '0' === $responsive_values[ $breakpoint ] ) ) {
												$style .= '@media (max-width:' . $width . '){';
												$style .= $key . '{' . str_replace( '{{VALUE}}', $responsive_values[ $breakpoint ], $value ) . '}}';
											}
										}
									}

									if ( empty( $css['responsive'] ) ) {
										$css['responsive'] = $style;
									} else {
										$css['responsive'] .= $style;
									}
								} else {
									if ( ! empty( $param['with_units'] ) && $param['with_units'] ) {
										$saved_value = riode_check_units( $saved_value );

										if ( ! $saved_value ) {
											continue;
										}
									}
									if ( 'riode_dimension' == $param['type'] ) { // Dimension
										$dimension_flag = false;
										foreach ( $this::$dimensions as $dimension => $pattern ) {
											$temp = riode_check_units( $dimension_values[ $dimension ]['xl'] );
											if ( ! $temp ) {
												$value = preg_replace( '/([^;]*)(\{\{' . strtoupper( $dimension ) . '\}\})([^;]*)(;*)/', '', $value );

											} else {
												$value          = str_replace( $pattern, $temp, $value );
												$dimension_flag = true;
											}
										}
										if ( $dimension_flag ) {
											if ( empty( $css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] ) ) {
												$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] = $value;
											} else {
												$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] .= $value;
											}
										}
									} elseif ( 'riode_color_group' == $param['type'] ) { // Color Group
										$colors = json_decode( str_replace( '``', '"', $saved_value ), true );

										if ( ! empty( $colors[ $key ] ) ) {
											foreach ( $colors[ $key ] as $k => $v ) {
												if ( empty( $css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] ) ) {
													$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] = $k . ': ' . $v . ';';
												} else {
													$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] .= $k . ': ' . $v . ';';
												}
											}
										}
									} elseif ( 'riode_typography' == $param['type'] && ! empty( $typography ) ) {
										if ( empty( $css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] ) ) {
											$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] = $typography;
										} else {
											$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $value ) ] .= $typography;
										}
									} elseif ( 'checkbox' == $param['type'] && ( empty( $saved_value ) && 'yes' == $saved_value ) ) {
										if ( empty( $css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] ) ) {
											$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] = $value;
										} else {
											$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] .= $value;
										}
									} else { // Others
										if ( ! empty( $saved_value ) || ( isset( $saved_value ) && '0' === $saved_value ) ) {
											if ( empty( $css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] ) ) {
												$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] = str_replace( '{{VALUE}}', $saved_value, $value );
											} else {
												$css[ str_replace( '{{WRAPPER}}', $shortcode_class, $key ) ] .= str_replace( '{{VALUE}}', $saved_value, $value );
											}
										}
									}
								}
							}
						}
					}
				}
			}
			return $css;
		}
	}

	Riode_WPB_Init::get_instance();
endif;
