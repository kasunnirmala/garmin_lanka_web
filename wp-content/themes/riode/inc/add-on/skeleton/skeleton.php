<?php

if ( ! class_exists( 'Riode_Skeleton' ) ) {
	class Riode_Skeleton {
		public $is_doing = '';

		private static $instance = null;

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );

			// Sidebar skeleton
			if ( ! defined('WOOF_VERSION') ) {
				add_action( 'riode_sidebar_content_start', array( $this, 'sidebar_content_start' ) );
				add_action( 'riode_sidebar_content_end', array( $this, 'sidebar_content_end' ) );
				add_filter( 'riode_sidebar_classes', array( $this, 'sidebar_classes' ) );
			}

			// Posts (archive + single) skeleton
			add_filter( 'riode_post_loop_wrapper_classes', array( $this, 'post_loop_wrapper_class' ) );
			add_filter( 'riode_post_single_class', array( $this, 'post_loop_wrapper_class' ) );
			add_action( 'riode_post_loop_before_item', array( $this, 'post_loop_before_item' ) );
			add_action( 'riode_post_loop_after_item', array( $this, 'post_loop_after_item' ) );

			// Archive products & categories skeleton
			add_filter( 'riode_product_loop_wrapper_classes', array( $this, 'product_loop_wrapper_class' ) );
			add_action( 'riode_product_loop_before_item', array( $this, 'product_loop_before_item' ) );
			add_action( 'riode_product_loop_after_item', array( $this, 'product_loop_after_item' ) );
			add_action( 'riode_product_loop_before_cat', array( $this, 'product_loop_before_cat' ) );
			add_action( 'riode_product_loop_after_cat', array( $this, 'product_loop_after_cat' ) );

			// Single product skeleton
			add_filter( 'riode_single_product_classes', array( $this, 'single_product_classes' ) );
			add_action( 'riode_before_product_gallery', array( $this, 'before_product_gallery' ), 20 );
			add_action( 'riode_after_product_gallery', array( $this, 'after_product_gallery' ), 20 );

			/**
			 * We disable skeleton screen for single produc page's summary and tab,
			 * because it has so many compatibility issues.
			 */
			if ( ! class_exists( 'WCFM' ) && ! class_exists( 'Uni_Cpo' ) && ! function_exists( 'anr_plugin_update' ) ) {
				add_action( 'riode_before_product_summary', array( $this, 'before_product_summary' ), 20 );
				add_action( 'riode_after_product_summary', array( $this, 'after_product_summary' ), 20 );
				add_action( 'riode_wc_product_before_tabs', array( $this, 'before_product_tabs' ), 20 );
				add_action( 'woocommerce_product_after_tabs', array( $this, 'after_product_tabs' ), 20 );
			}

			// Menu lazyload skeleton
			add_filter( 'riode_menu_lazyload_content', array( $this, 'menu_skeleton' ), 10, 4 );
		}

		public function enqueue_scripts() {
			wp_enqueue_style( 'riode-skeleton', RIODE_ADDON_URI . '/skeleton/skeleton' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );
			wp_enqueue_script( 'riode-skeleton', RIODE_ADDON_URI . '/skeleton/skeleton.min.js', array( 'riode-theme' ), RIODE_VERSION, true );

			wp_localize_script(
				'riode-skeleton-js',
				'lib_skeleton',
				array(
					'lazyload' => riode_get_option( 'lazyload' ),
				)
			);
		}

		public function sidebar_content_start() {
			$page_type = riode_get_layout_value( 'slug' );

			if ( ! ( riode_get_layout_value( 'top_sidebar', 'id' ) > 0 ) && ( 'post_archive_layout' === $page_type || 'post_single_layout' === $page_type || 'product_archive_layout' === $page_type || 'product_single_layout' === $page_type ) ) {
				ob_start();
				$this->is_doing = 'sidebar';
			}
		}

		public function sidebar_content_end() {
			if ( 'sidebar' == $this->is_doing ) {
				echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
				echo '<div class="widget-2"></div>';
			}

			$this->is_doing = '';
		}

		public function sidebar_classes( $class ) {
			$page_type = riode_get_layout_value( 'slug' );

			if ( ! in_array( 'top_sidebar', $class ) && ( 'post_archive_layout' === $page_type || 'post_single_layout' === $page_type || 'product_archive_layout' === $page_type || 'product_single_layout' === $page_type ) ) {
				$class[] = 'skeleton-body';
			}
			return $class;
		}

		public function product_loop_wrapper_class( $classes ) {
			if ( ! $this->is_doing ) {
				$page_type = riode_get_layout_value( 'slug' );
				if ( ! wc_get_loop_prop( 'widget' ) && ( 'product_archive_layout' === $page_type || 'product_single_layout' === $page_type ) ) {
					$classes[] = 'skeleton-body';
				}
			}
			return $classes;
		}

		public function product_loop_before_item() {
			if ( ! $this->is_doing ) {
				$page_type = riode_get_layout_value( 'slug' );
				if ( ! wc_get_loop_prop( 'widget' ) && ( 'product_archive_layout' === $page_type || 'product_single_layout' === $page_type ) ) {
					ob_start();
					$this->is_doing = 'product';
				}
			}
		}

		public function product_loop_after_item( $product_type ) {
			if ( 'product' == $this->is_doing ) {
				$page_type = riode_get_layout_value( 'slug' );
				if ( ! wc_get_loop_prop( 'widget' ) && ( 'product_archive_layout' === $page_type || 'product_single_layout' === $page_type ) ) {
					echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
					echo '<div class="skel-pro' . ( 'list' == $product_type ? ' skel-pro-list' : '' ) . '"></div>';
					$this->is_doing = '';
				}
			}
		}

		public function product_loop_before_cat() {
			if ( ! $this->is_doing ) {
				$page_type = riode_get_layout_value( 'slug' );
				if ( ! wc_get_loop_prop( 'widget' ) && ( 'product_archive_layout' === $page_type || 'product_single_layout' === $page_type ) ) {
					ob_start();
					$this->is_doing = 'product_cat';
				}
			}
		}

		public function product_loop_after_cat( $product_type ) {
			if ( 'product_cat' == $this->is_doing ) {
				$page_type = riode_get_layout_value( 'slug' );
				if ( ! wc_get_loop_prop( 'widget' ) && ( 'product_archive_layout' === $page_type || 'product_single_layout' === $page_type ) ) {
					echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
					echo '<div class="skel-cat"></div>';
					$this->is_doing = '';
				}
			}
		}

		public function post_loop_wrapper_class( $classes ) {
			if ( ! $this->is_doing ) {
				$page_type = riode_get_layout_value( 'slug' );
				if ( 'post_archive_layout' === $page_type || 'post_single_layout' === $page_type ) {
					$classes[] = 'skeleton-body';
				}
			}
			return $classes;
		}

		public function post_loop_before_item() {
			if ( ! $this->is_doing ) {
				$page_type = riode_get_layout_value( 'slug' );
				if ( 'post_archive_layout' === $page_type || 'post_single_layout' === $page_type ) {
					ob_start();
					$this->is_doing = 'post';
				}
			}
		}

		public function post_loop_after_item( $type ) {
			if ( 'post' == $this->is_doing ) {
				$page_type = riode_get_layout_value( 'slug' );
				if ( 'post_archive_layout' === $page_type || 'post_single_layout' === $page_type ) {
					echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
					$class = 'skel-post';
					if ( 'list' === $type ) {
						$class .= '-list';
					} elseif ( 'mask' === $type || 'mask gradient' === $type ) {
						$class .= '-mask';
					}
					echo '<div class="' . riode_escaped( $class ) . '"></div>';
					$this->is_doing = '';
				}
			}
		}

		public function single_product_classes( $classes ) {
			if ( ! $this->is_doing ) {
				$classes[] = 'skeleton-body';
			}
			return $classes;
		}

		public function before_product_gallery() {
			if ( ! $this->is_doing ) {
				ob_start();
				$this->is_doing = 'product_gallery';
			}
		}

		public function after_product_gallery() {
			if ( 'product_gallery' == $this->is_doing ) {
				echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';

				$single_product_layout = riode_get_option( 'single_product_type' );

				echo '<div class="skel-pro-gallery"></div>';

				$this->is_doing = '';
			}
		}

		public function before_product_summary() {
			if ( ! $this->is_doing ) {
				ob_start();
				$this->is_doing = 'product_summary';
			}
		}

		public function after_product_summary() {
			if ( 'product_summary' == $this->is_doing ) {
				echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
				echo '<div class="skel-pro-summary"></div>';
				$this->is_doing = '';
			}
		}

		public function before_product_tabs() {
			if ( ! $this->is_doing ) {
				ob_start();
				$this->is_doing = 'product_tabs';
			}
		}

		public function after_product_tabs() {
			if ( 'product_tabs' == $this->is_doing ) {
				echo '<script type="text/template">' . json_encode( ob_get_clean() ) . '</script>';
				echo '<div class="skel-pro-tabs"></div>';
				$this->is_doing = '';
			}
		}

		public function menu_skeleton( $content, $megamenu, $megamenu_width, $megamenu_pos ) {
			if ( ! $this->is_doing && riode_get_option( 'lazyload_menu' ) ) {
				if ( $megamenu ) {
					$class = '';
					$style = '';

					if ( $megamenu_width ) {
						$class .= ' mp-' . $megamenu_pos;
						$style .= ' style="width: ' . $megamenu_width . 'px;';

						if ( 'center' == $megamenu_pos ) {
							$style .= ' left: calc( 50% - ' . $megamenu_width / 2 . 'px );"';
						} else {
							$style .= '"';
						}
					} else {
						$class .= ' full-megamenu';
					}

					return '<ul class="megamenu' . $class . ' skel-megamenu"' . $style . '>';
				} else {
					return '<ul class="submenu skel-menu">';
				}
			}
			return $content;
		}

		public static function prevent_skeleton() {
			self::$instance->is_doing = 'stop';
		}

		public static function stop_prevent_skeleton() {
			self::$instance->is_doing = '';
		}
	}
}

Riode_Skeleton::get_instance();
