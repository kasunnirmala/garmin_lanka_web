<?php

/**
 * Add Gutenberg Blocks
 *
 * @since 1.0
 */

if ( ! class_exists( 'Riode_Gutenberg' ) ) :
	class Riode_Gutenberg {

		public $id;

		/**
		 * Constructor
		 */
		public function __construct() {

			$id = array();

			if ( is_admin() ) {
				add_action(
					'enqueue_block_editor_assets',
					function() {
						if ( defined( 'RIODE_VERSION' ) ) {
							wp_enqueue_script( 'imagesloaded' );
							wp_enqueue_script( 'owl-carousel', RIODE_ASSETS . '/vendor/owl-carousel/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
							wp_enqueue_script( 'isotope-pkgd', RIODE_ASSETS . '/vendor/isotope/isotope.pkgd.min.js', array( 'jquery' ), '3.0.6', true );
							wp_enqueue_script( 'riode-gutenberg-js', RIODE_JS . '/admin/editor' . riode_get_js_extension(), array( 'jquery' ), RIODE_VERSION, true );
						}

						wp_enqueue_script( 'riode_gutenberg_blocks', RIODE_CORE_URI . 'gutenberg/assets/blocks.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-data'/*, 'wp-editor'*/ ), RIODE_CORE_VERSION, true );

						global $riode_breakpoints;
						wp_localize_script(
							'riode_gutenberg_blocks',
							'riode_gutenberg_vars',
							array(
								'placeholder_img' => class_exists( 'woocommerce' ) ? apply_filters( 'woocommerce_placeholder_img_src', wc_placeholder_img_src( 'shop_catalog' ) ) : '',
								'ajax_url'        => esc_url( admin_url( 'admin-ajax.php' ) ),
								'nonce'           => wp_create_nonce( 'riode-nonce' ),
								'breakpoints'     => $riode_breakpoints,
							)
						);
					},
					999
				);

				add_filter( 'block_categories_all', array( $this, 'blocks_categories' ), 10, 1 );
			}

			include RIODE_CORE_PATH . 'gutenberg/rest/rest-init.php';
			add_action( 'init', array( $this, 'register_block_types' ) );
		}

		public function register_block_types() {
			$riode_block = array( 'slider', 'banner', 'products', 'categories', 'posts', 'icon-box', 'heading', 'button' );

			if ( function_exists( 'register_block_type' ) ) {
				for ( $i = 0; $i < count( $riode_block ); $i++ ) {
					$this->id[ $riode_block[ $i ] ] = 0;

					register_block_type(
						'riode/riode-' . $riode_block[ $i ],
						array(
							'editor_script'   => 'riode_gutenberg_blocks',
							'render_callback' => array(
								$this,
								'render_' . str_replace( '-', '_', $riode_block[ $i ] ),
							),
						)
					);
				}
			}
		}

		public function blocks_categories( $categories ) {
			return array_merge(
				$categories,
				array(
					array(
						'slug'  => 'riode',
						'title' => esc_html__( 'Riode', 'riode-core' ),
						'icon'  => '',
					),
				)
			);
		}

		public function render_slider( $atts, $content = null ) {
			$this->id['slider'] ++;
			$atts['id'] = $this->id['slider'];
			ob_start();
			echo '<div id="riode_gtnbg_slider_' . $this->id['slider'] . '" class="' . ( isset( $atts['align'] ) ? 'align' . $atts['align'] . ' ' : '' ) . ( isset( $atts['className'] ) ? $atts['className'] : '' ) . '">';
			include RIODE_CORE_PATH . 'gutenberg/render/block-slider-render.php';
			echo '</div>';
			return ob_get_clean();
		}

		public function render_banner( $atts, $content = null ) {
			$this->id['banner'] ++;

			ob_start();
			echo '<div id="riode_gtnbg_banner_' . $this->id['banner'] . '" class="' . ( isset( $atts['align'] ) ? 'align' . $atts['align'] . ' ' : '' ) . ( isset( $atts['className'] ) ? $atts['className'] : '' ) . '">';
			include RIODE_CORE_PATH . 'gutenberg/render/block-banner-render.php';
			echo '</div>';
			return ob_get_clean();
		}

		public function render_products( $atts, $content = null ) {
			$this->id['products'] ++;

			if ( isset( $atts['status'] ) ) {
				if ( 'on_sale' == $atts['status'] ) {
					$atts['status'] = 'sale_products';
				} elseif ( 'featured' == $atts['status'] ) {
					$atts['status'] = 'featured_products';
				} else {
					$atts['status'] = 'products';
				}
			}

			$atts['count'] = array( 'size' => isset( $atts['count'] ) ? $atts['count'] : 10 );

			foreach ( $atts as $key => $value ) {
				if ( 'boolean' === gettype( $value ) ) {
					if ( $value ) {
						$atts[ $key ] = 'yes';
					} else {
						$atts[ $key ] = '';
					}
				}
			}

			if ( isset( $atts['category_type'] ) && $atts['category_type'] ) {
				$atts['categories'] = array();

				foreach ( $atts['category_list'] as $cat ) {
					if ( $cat['checked'] ) {
						$atts['categories'][] = $cat['id'];
					}
				}

				$atts['categories'] = implode( ',', $atts['categories'] );
			}

			$atts = shortcode_atts(
				array(
					// Products Selector
					'ids'                 => '',
					'categories'          => '',
					'status'              => '',
					'count'               => array( 'size' => 10 ),
					'orderby'             => '',
					'orderway'            => 'ASC',

					// Products Layout
					'col_cnt'             => '4',
					'col_cnt_xl'          => '',
					'col_cnt_tablet'      => '',
					'col_cnt_mobile'      => '',
					'col_cnt_min'         => '',
					'col_sp'              => '',
					'layout_type'         => 'grid',
					'split_line'          => '',
					'show_nav'            => '',
					'nav_hide'            => '',
					'nav_type'            => '',
					'nav_pos'             => '',
					'show_dots'           => '',
					'dots_type'           => '',
					'dots_pos'            => '',
					'autoplay'            => '',
					'autoplay_timeout'    => '5000',
					'loop'                => '',
					'pause_onhover'       => '',
					'autoheight'          => '',
					'center_mode'         => '',
					'animation_in'        => '',
					'animation_out'       => '',

					// Product Type
					'follow_theme_option' => '',
					'show_labels'         => array( 'top', 'sale', 'new', 'stock' ),
					'product_type'        => '',
					'classic_hover'       => '',
					'show_in_box'         => '',
					'show_media_shadow'   => '',
					'show_info'           => array( 'category', 'label', 'price', 'rating', 'attribute', 'addtocart', 'quickview', 'wishlist' ),
					'hover_change'        => '',
					'content_align'       => '',
					'addtocart_pos'       => '',
					'quickview_pos'       => 'bottom',
					'wishlist_pos'        => '',

					'page_builder'        => 'gutenberg',
				),
				$atts
			);

			if ( 'list' == $atts['product_type'] ) {
				$atts['show_info'] . push( 'short_desc' );
			}

			$padding = isset( $atts['padding'] ) ? $atts['padding'] : 0;

			ob_start();
			echo '<style type="text/css">';
			echo '#riode_gtnbg_products_' . $this->id['products'] . ' .product-details{ padding-left: ' . ( ! isset( $atts['content_align'] ) ? $padding : 0 ) . 'px; padding-right: ' . ( isset( $atts['content_align'] ) && 'right-aligned' == $atts['content_align'] ? $padding : 0 ) . 'px; }';
			echo '</style>';
			echo '<div id="riode_gtnbg_products_' . $this->id['products'] . '" class="' . ( isset( $atts['className'] ) ? $atts['className'] : '' ) . '">';
			include RIODE_CORE_PATH . 'elementor/render/widget-products-render.php';
			echo '</div>';
			return ob_get_clean();
		}

		public function render_categories( $atts, $content = null ) {
			$this->id['categories'] ++;

			$atts['count'] = array( 'size' => isset( $atts['count'] ) ? $atts['count'] : 4 );
			foreach ( $atts as $key => $value ) {
				if ( 'boolean' === gettype( $value ) ) {
					if ( $value ) {
						$atts[ $key ] = 'yes';
					} else {
						$atts[ $key ] = '';
					}
				}
			}

			if ( isset( $atts['category'] ) && $atts['category'] && isset( $atts['category_list'] ) ) {
				$atts['categories'] = array();

				foreach ( $atts['category_list'] as $cat ) {
					$atts['categories'][] = $cat['id'];
				}

				$atts['ids'] = implode( ',', $atts['categories'] );
			}

			if ( isset( $atts['creative_height'] ) ) {
				$atts['creative_height'] = array( 'size' => $atts['creative_height'] );
			}

			$atts = shortcode_atts(
				array(
					// Categories Selector
					'ids'                        => array(),
					'show_subcategories'         => '',
					'hide_empty'                 => '',
					'count'                      => array( 'size' => 4 ),
					'orderby'                    => 'name',
					'orderway'                   => '',

					// Categories
					'layout_type'                => 'grid',
					'col_sp'                     => '',
					'creative_mode'              => 1,
					'creative_height'            => array( 'size' => 600 ),
					'creative_height_ratio'      => array( 'size' => 75 ),
					'grid_float'                 => '',
					'thumbnail_size'             => 'woocommerce_thumbnail',
					'thumbnail_custom_dimension' => '',
					'col_cnt'                    => '4',
					'col_cnt_xl'                 => '',
					'col_cnt_tablet'             => '',
					'col_cnt_mobile'             => '',
					'col_cnt_min'                => '',
					'col_sp'                     => '',
					'layout_type'                => 'grid',
					'show_nav'                   => '',
					'nav_hide'                   => '',
					'nav_type'                   => '',
					'nav_pos'                    => '',
					'show_dots'                  => '',
					'dots_type'                  => '',
					'dots_pos'                   => '',
					'autoplay'                   => '',
					'autoplay_timeout'           => '5000',
					'loop'                       => '',
					'pause_onhover'              => '',
					'autoheight'                 => '',
					'center_mode'                => '',
					'animation_in'               => '',
					'animation_out'              => '',

					// Category Type
					'follow_theme_option'        => '',
					'category_type'              => 'classic',
					'overlay'                    => '',
					'show_count'                 => '',
					'show_link'                  => '',
					'link_text'                  => 'Shop now',

					'page_builder'               => 'gutenberg',
					'wrapper_id'                 => '#riode_gtnbg_categories_' . $this->id['categories'],
				),
				$atts
			);

			ob_start();
			echo '<style type="text/css">';
			echo '#riode_gtnbg_categories_' . $this->id['categories'] . ' .category-content{ text-align: ' . ( isset( $atts['content_align'] ) ? $atts['content_align'] : 'left' ) . '; }';
			echo '</style>';
			echo '<div id="riode_gtnbg_categories_' . $this->id['categories'] . '" class="' . ( isset( $atts['className'] ) ? $atts['className'] : '' ) . '">';
			include RIODE_CORE_PATH . 'elementor/render/widget-categories-render.php';
			echo '</div>';
			return ob_get_clean();
		}

		public function render_posts( $atts, $content = null ) {
			$this->id['posts'] ++;

			$atts['count'] = array( 'size' => isset( $atts['count'] ) ? $atts['count'] : 4 );

			if ( isset( $atts['category_type'] ) && $atts['category_type'] && isset( $atts['category_list'] ) ) {
				$atts['categories'] = array();

				foreach ( $atts['category_list'] as $cat ) {
					if ( $cat['checked'] ) {
						$atts['categories'][] = $cat['id'];
					}
				}

				$atts['categories'] = implode( ',', $atts['categories'] );
			}

			if ( isset( $atts['show_info'] ) ) {
				$infos = [];

				foreach ( $atts['show_info'] as $key => $value ) {
					if ( $value ) {
						$infos[] = $key;
					}
				}

				$atts['show_info'] = $infos;
			}

			foreach ( $atts as $key => $value ) {
				if ( 'boolean' === gettype( $value ) ) {
					if ( $value ) {
						$atts[ $key ] = 'yes';
					} else {
						$atts[ $key ] = '';
					}
				}
			}

			if ( isset( $atts['icon'] ) ) {
				$atts['icon'] = array( 'value' => $atts['icon'] );
			}
			if ( isset( $atts['excerpt_limit'] ) ) {
				$atts['excerpt_limit'] = array( 'size' => $atts['excerpt_limit'] );
			}

			$atts = shortcode_atts(
				array(
					// Posts Selector
					'ids'                        => '',
					'categories'                 => '',
					'count'                      => array( 'size' => 4 ),
					'orderby'                    => '',
					'orderway'                   => '',

					// Posts Layout
					'layout_type'                => 'grid',
					'col_cnt'                    => '4',
					'col_cnt_xl'                 => '',
					'col_cnt_tablet'             => '',
					'col_cnt_mobile'             => '',
					'col_cnt_min'                => '',
					'col_sp'                     => '',
					'show_nav'                   => '',
					'nav_hide'                   => '',
					'nav_type'                   => '',
					'nav_pos'                    => '',
					'show_dots'                  => '',
					'dots_type'                  => '',
					'dots_pos'                   => '',
					'autoplay'                   => '',
					'autoplay_timeout'           => '5000',
					'loop'                       => '',
					'pause_onhover'              => '',
					'autoheight'                 => '',
					'center_mode'                => '',
					'animation_in'               => '',
					'animation_out'              => '',
					'loadmore_type'              => '',
					'loadmore_label'             => '',

					// Post Type
					'follow_theme_option'        => '',
					'post_type'                  => '',
					'overlay'                    => '',
					'show_info'                  => array(),
					'show_datebox'               => '',
					'read_more_label'            => 'Read More',
					'read_more_custom'           => '',
					'excerpt_custom'             => '',
					'excerpt_limit'              => array( 'size' => 20 ),
					'excerpt_type'               => 'words',

					// Custom Button
					'button_skin'                => 'btn-dark',
					'button_border'              => '',
					'button_type'                => '',
					'link_hover_type'            => '',
					'button_size'                => '',
					'icon'                       => '',
					'icon_pos'                   => 'after',
					'icon_hover_effect'          => '',
					'icon_hover_effect_infinite' => '',
					'icon_size'                  => '',
					'show_label'                 => 'yes',

					// Style
					'content_align'              => '',
					'page_builder'               => 'gutenberg',
					'wrapper_id'                 => '',
				),
				$atts
			);

			ob_start();
			echo '<style type="text/css">';
			echo '#riode_gtnbg_posts_' . $this->id['posts'] . ' .post-body{ text-align: ' . ( isset( $atts['content_align'] ) ? $atts['content_align'] : 'left' ) . '; }';
			echo '#riode_gtnbg_posts_' . $this->id['posts'] . ' .btn > i { font-size: ' . ( isset( $atts['icon_size'] ) ? $atts['icon_size'] : 'inherit' ) . ' } }';
			echo '</style>';
			echo '<div id="riode_gtnbg_posts_' . $this->id['posts'] . '" class="' . ( isset( $atts['className'] ) ? $atts['className'] : '' ) . '">';
			include RIODE_CORE_PATH . 'elementor/render/widget-posts-render.php';
			echo '</div>';
			return ob_get_clean();
		}

		public function render_icon_box( $atts, $content = null ) {
			$this->id['icon-box'] ++;

			$atts['id'] = $this->id['icon-box'];

			ob_start();
			include RIODE_CORE_PATH . 'gutenberg/render/block-icon-box-render.php';
			return ob_get_clean();
		}

		public function render_heading( $atts, $content = null ) {
			$this->id['heading'] ++;

			$atts['id'] = $this->id['heading'];

			ob_start();
			include RIODE_CORE_PATH . 'gutenberg/render/block-heading-render.php';
			return ob_get_clean();
		}

		public function render_button( $atts, $content = null ) {
			$this->id['button'] ++;

			$atts['id'] = $this->id['button'];

			ob_start();
			include RIODE_CORE_PATH . 'gutenberg/render/block-button-render.php';
			return ob_get_clean();
		}
	}

endif;

new Riode_Gutenberg;
