<?php
defined( 'ABSPATH' ) || die;

define( 'RIODE_MAINTENANCE_TOOLS', RIODE_ADMIN . '/maintenance_tools' );

if ( ! class_exists( 'Riode_Maintenance_Tools' ) ) :
	/**
	* Riode Theme Setup Wizard
	*/
	class Riode_Maintenance_Tools {

		protected $theme_name = '';

		public $page_slug;

		protected $page_url;

		protected $riode_url = 'https://d-themes.com/wordpress/riode/';

		protected $tools = array();

		private static $instance = null;

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			$this->current_theme_meta();
			$this->init_maintenance_tools();
		}

		public function current_theme_meta() {
			$current_theme    = wp_get_theme();
			$this->theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
			$this->page_slug  = 'riode-maintenance-tools';
			$this->page_url   = 'admin.php?page=' . $this->page_slug;
		}

		/**
		 * inits all variables, actions and filters
		 */
		public function init_maintenance_tools() {
			$this->tools = array(
				'plugin_versions'        => array(
					'action_name' => esc_html__( 'Plugin Versions', 'riode' ),
					'description' => sprintf( esc_html__( 'This will clear version transient cache of Riode Core and WPBakery plugins and update to new.%1$sVersions are updated every 4 days by default. %2$sView Current Versions%3$s', 'riode' ), '<br>', '<a href="' . admin_url() . 'plugins.php' . '" target="__blank">', '</a>' ),
					'button_text' => esc_html__( 'Update Now', 'riode' ),
				),
				'studio_templates' => array(
					'action_name' => esc_html__( 'Studio Templates', 'riode' ),
					'description' => sprintf( esc_html__( 'This will update all templates in teamplates library (studio).%1$sTemplates are updated every month by default.', 'riode' ), '<br>' ),
					'button_text' => esc_html__( 'Update Now', 'riode' ),
				),
				'page_layouts'  => array(
					'action_name' => esc_html__( 'Page Layouts', 'riode' ),
					'description' => sprintf( esc_html__( 'This will check and update all existing page layouts. %1$sThis process is needed when some headers, footers, popups, blocks and other templates are removed. %2$sView Page Layouts%3$s', 'riode' ), '<br>', '<a href="' . admin_url() . 'admin.php?page=riode_layout_dashboard' . '" target="__blank" ' . ( defined( 'RIODE_CORE_VERSION' ) ? '' : 'style="display: none;"' ) . '>', '</a>' ),
					'button_text' => esc_html__( 'Update Now', 'riode' ),
				),
				'display_conditions'  => array(
					'action_name' => esc_html__( 'Display Conditions', 'riode' ),
					'description' => sprintf( esc_html__( 'This will check and update display conditions of page layouts and templates. %1$sThis process is needed when some pages, posts, taxonomies, terms, page layouts and templates are deleted. %2$sView Page Layouts%3$s', 'riode' ), '<br>', '<a href="' . admin_url() . 'admin.php?page=riode_layout_dashboard' . '" target="__blank" ' . ( defined( 'RIODE_CORE_VERSION' ) ? '' : 'style="display: none;"' ) . '>', '</a>' ),
					'button_text' => esc_html__( 'Update Now', 'riode' ),
				),
				'reset_review'       => array(
					'action_name' => esc_html__( 'Product Review Transient', 'riode' ),
					'description' => esc_html__( 'This will clear WooCommerce products review transient.', 'riode' ),
					'button_text' => esc_html__( 'Clear Now', 'riode' ),
				),
			);

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ), 30 );

			add_action( 'wp_ajax_riode_maintenance_tool_run', array( $this, 'run_tool' ) );
		}

		/**
		 * prints tools page
		 */
		public function view_maintenance_tools() {
			if ( ! Riode_Admin::get_instance()->is_registered() ) {
				wp_redirect( admin_url( 'admin.php?page=riode' ) );
			}
			Riode_Admin_Panel::get_instance()->view_header( 'license' );
			include RIODE_MAINTENANCE_TOOLS . '/views/index.php';
			Riode_Admin_Panel::get_instance()->view_footer();
		}

		/**
		 * enqueues styles and scripts
		 */
		public function enqueue() {
			if ( ! current_user_can( 'administrator' ) || ! isset( $_GET['page'] ) || 'riode-maintenance-tools' != $_GET['page'] ) {
				return;
			}

			wp_enqueue_style( 'riode-admin-wizard', RIODE_CSS . '/admin/wizard' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );
			wp_enqueue_script( 'riode-admin-wizard', RIODE_JS . '/admin/wizard' . riode_get_js_extension(), array( 'jquery-core' ), true, 50 );

			wp_localize_script(
				'riode-admin-wizard',
				'riode_maintenance_tools_params',
				array(
					'wpnonce' => wp_create_nonce( 'riode_maintenance_tools_nonce' ),
				)
			);
		}

		/**
		 * Run maintenance tools.
		 *
		 * @since 1.4.0
		 * @since 1.4.3 Added clear review transient functionality.
		 */
		public function run_tool() {
			if ( ! check_ajax_referer( 'riode_maintenance_tools_nonce', 'wpnonce' ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}
			if ( ! isset( $_POST['toolname'] ) ) {
				wp_send_json_error( esc_html__( 'Tool name does not exist', 'riode' ) );
			}

			switch ( $_POST['toolname'] ) {
				case 'plugin_versions':
					delete_site_transient( 'riode_plugins' );
					delete_site_transient( 'riode_plugin_rollback_versions' );
					delete_site_transient( 'riode_theme_rollback_versions' );
					wp_send_json_success(
						esc_html__( 'Updated plugin versions successfully', 'riode' )
					);
					break;

				case 'studio_templates':
					delete_site_transient( 'riode_blocks_e' );
					delete_site_transient( 'riode_blocks_v' );
					delete_site_transient( 'riode_blocks_w' );
					delete_site_transient( 'riode_block_categories_e' );
					delete_site_transient( 'riode_block_categories_v' );
					delete_site_transient( 'riode_block_categories_w' );
					wp_send_json_success(
						esc_html__( 'Updated studio templates successfully', 'riode' )
					);
					break;

				case 'page_layouts':
					$layouts = riode_get_option( 'page_layouts' );
					foreach ( $layouts as $slug => $layout ) {
						if ( ! is_array( $layout ) ) {
							continue;
						}

						if ( ! empty( $layout['content']['header'] ) && ! empty( $layout['content']['header']['id'] ) && ! $this->is_post_published( $layout['content']['header']['id'] ) ) {
							unset( $layouts[ $slug ]['content']['header']['id'] );
						}
						if ( ! empty( $layout['content']['ptb'] ) && ! empty( $layout['content']['ptb']['id'] ) && ! $this->is_post_published( $layout['content']['ptb']['id'] ) ) {
							unset( $layouts[ $slug ]['content']['ptb']['id'] );
						}
						if ( ! empty( $layout['content']['top_block'] ) && ! empty( $layout['content']['top_block']['id'] ) && ! $this->is_post_published( $layout['content']['top_block']['id'] ) ) {
							unset( $layouts[ $slug ]['content']['top_block']['id'] );
						}
						if ( ! empty( $layout['content']['inner_top_block'] ) && ! empty( $layout['content']['inner_top_block']['id'] ) && ! $this->is_post_published( $layout['content']['inner_top_block']['id'] ) ) {
							unset( $layouts[ $slug ]['content']['inner_top_block']['id'] );
						}
						if ( ! empty( $layout['content']['bottom_block'] ) && ! empty( $layout['content']['bottom_block']['id'] ) && ! $this->is_post_published( $layout['content']['bottom_block']['id'] ) ) {
							unset( $layouts[ $slug ]['content']['bottom_block']['id'] );
						}
						if ( ! empty( $layout['content']['inner_bottom_block'] ) && ! empty( $layout['content']['inner_bottom_block']['id'] ) && ! $this->is_post_published( $layout['content']['inner_bottom_block']['id'] ) ) {
							unset( $layouts[ $slug ]['content']['inner_bottom_block']['id'] );
						}
						if ( ! empty( $layout['content']['footer'] ) && ! empty( $layout['content']['footer']['id'] ) && ! $this->is_post_published( $layout['content']['footer']['id'] ) ) {
							unset( $layouts[ $slug ]['content']['footer']['id'] );
						}
						if ( ! empty( $layout['content']['top_sidebar'] ) && ! empty( $layout['content']['top_sidebar']['id'] ) && ! $this->is_sidebar_registered( $layout['content']['top_sidebar']['id'] ) ) {
							unset( $layouts[ $slug ]['content']['top_sidebar']['id'] );
						}
						if ( ! empty( $layout['content']['left_sidebar'] ) && ! empty( $layout['content']['left_sidebar']['id'] ) && ! $this->is_sidebar_registered( $layout['content']['left_sidebar']['id'] ) ) {
							unset( $layouts[ $slug ]['content']['left_sidebar']['id'] );
						}
						if ( ! empty( $layout['content']['right_sidebar'] ) && ! empty( $layout['content']['right_sidebar']['id'] ) && ! $this->is_sidebar_registered( $layout['content']['right_sidebar']['id'] ) ) {
							unset( $layouts[ $slug ]['content']['right_sidebar']['id'] );
						}
					}

					set_theme_mod( 'page_layouts', $layouts );

					wp_send_json_success(
						esc_html__( 'Updated page layouts successfully', 'riode' )
					);
					break;

				case 'display_conditions':
					// check if conditions of all page layouts are available
					$layouts = riode_get_option( 'page_layouts' );
					foreach ( $layouts as $slug => $layout ) {
						if ( empty( $layout ) ) {
							continue;
						}

						for ( $i = 0; $i < count( $layouts[ $slug ]['condition'] ); $i ++ ) {
							if ( ! $this->is_condition_available( $layouts[ $slug ]['condition'][ $i ] ) || ! $this->is_in_total_conditions( $slug, $layouts[ $slug ]['condition'][ $i ], riode_get_option( 'layout_conditions' ) ) ) {
								array_splice( $layouts[ $slug ]['condition'], $i, 1 );
								$i --;
							}
						}
					}
					set_theme_mod( 'page_layouts', $layouts );

					// check if conditions of all templates are available
					$template_types = array( 'product_layout', 'popup' );
					foreach ( $template_types as $type ) {
						$posts = get_posts(
							array(
								'post_status' => 'publish',
								'post_type'   => 'riode_template',
								'meta_key'    => 'riode_template_type',
								'meta_value'  => $type,
								'numberposts' => -1,
							)
						);

						foreach ( $posts as $post ) {
							$conditions = get_post_meta( $post->ID, 'riode_' . $type . '_conditions', true );

							if ( empty( $conditions ) ) {
								continue;
							}

							for ( $i = 0; $i < count( $conditions ); $i ++ ) {
								if ( ! $this->is_condition_available( $conditions[ $i ] ) || ! $this->is_in_total_conditions( $post->ID, $conditions[ $i ], riode_get_option( $type . '_conditions' ) ) ) {
									array_splice( $conditions, $i, 1 );
									$i --;
								}
							}

							update_post_meta( $post->ID, 'riode_' . $type . '_conditions', $conditions );
						}
					}

					// check if conditions and page layouts are correct in layout_conditions
					$layouts = array_keys( $layouts );
					$conditions = riode_get_option( 'layout_conditions' );
					foreach ( $conditions as $cat => $cat_conditions ) {
						if ( 'entire' == $cat || 'error' == $cat ) {
							$c = array( 'category' => $cat );
							if ( ! in_array( $cat_conditions, $layouts ) ||
								! $this->is_condition_available( $c ) ||
								! $this->is_in_item_conditions( $c, riode_get_option( 'page_layouts' )[ $cat_conditions ]['condition'] ) ) {
								unset( $conditions[ $cat ] );
							}
							continue;
						}

						if ( is_array( $cat_conditions ) ) {
							foreach ( $cat_conditions as $subcat => $subcat_conditions ) {
								if ( 'all' == $subcat ) {
									$c = array(
										'category' => $cat,
										'subcategory' => '',
									);

									if ( ! in_array( $subcat_conditions, $layouts ) ||
										! $this->is_condition_available( $c ) ||
										! $this->is_in_item_conditions( $c, riode_get_option( 'page_layouts' )[ $subcat_conditions ]['condition'] ) ) {
										unset( $conditions[ $cat ][ $subcat ] );
									}

									continue;
								}

								if ( is_array( $subcat_conditions ) ) {
									foreach ( $subcat_conditions as $id => $id_conditions ) {
										$c = array(
											'category'    => $cat,
											'subcategory' => $subcat,
											'id'          => 'all' == $id ? array( 'id' => '' ) : array( 'id' => $id ),
										);

										if ( ! in_array( $id_conditions, $layouts ) ||
											! $this->is_condition_available( $c ) ||
											! $this->is_in_item_conditions( $c, riode_get_option( 'page_layouts' )[ $id_conditions ]['condition'] ) ) {
											unset( $conditions[ $cat ][ $subcat ][ $id ] );
										}
									}

									if ( empty( $conditions[ $cat ][ $subcat ] ) ) {
										unset( $conditions[ $cat ][ $subcat ] );
									}
								}
							}

							if ( empty( $conditions[ $cat ] ) ) {
								unset( $conditions[ $cat ] );
							}
						}
					}
					set_theme_mod( 'layout_conditions', $conditions );

					// check if conditions and templates are correct in template conditions
					foreach ( $template_types as $type ) {
						$conditions = riode_get_option( $type . '_conditions' );
						foreach ( $conditions as $cat => $cat_conditions ) {
							if ( 'entire' == $cat || 'error' == $cat ) {
								if ( 'popup' == $type ) {
									if ( ! empty( $cat_conditions['popup_id'] ) ) {
										$cat_conditions = $cat_conditions['popup_id'];
									} else {
										$cat_conditions = 1;
									}
								}

								$c = array( 'category' => $cat );

								if ( ! $this->is_post_published( $cat_conditions ) ||
									$type != get_post_meta( $cat_conditions, 'riode_template_type', true ) ||
									! $this->is_condition_available( $c ) ||
									! $this->is_in_item_conditions( $c, get_post_meta( $cat_conditions, 'riode_' . $type . '_conditions', true ), true ) ) {
									unset( $conditions[ $cat ] );
								}
								continue;
							}

							if ( is_array( $cat_conditions ) ) {
								foreach ( $cat_conditions as $subcat => $subcat_conditions ) {
									if ( 'all' == $subcat ) {
										if ( 'popup' == $type ) {
											if ( ! empty( $subcat_conditions['popup_id'] ) ) {
												$subcat_conditions = $subcat_conditions['popup_id'];
											} else {
												$subcat_conditions = 1;
											}
										}

										$c = array(
											'category' => $cat,
											'subcategory' => '',
										);

										if ( ! $this->is_post_published( $subcat_conditions ) ||
											$type != get_post_meta( $subcat_conditions, 'riode_template_type', true ) ||
											! $this->is_condition_available( $c ) ||
											! $this->is_in_item_conditions( $c, get_post_meta( $subcat_conditions, 'riode_' . $type . '_conditions', true ), true ) ) {
											unset( $conditions[ $cat ][ $subcat ] );
										}

										continue;
									}

									if ( is_array( $subcat_conditions ) ) {
										foreach ( $subcat_conditions as $id => $id_conditions ) {
											if ( 'popup' == $type ) {
												if ( ! empty( $id_conditions['popup_id'] ) ) {
													$id_conditions = $id_conditions['popup_id'];
												} else {
													$id_conditions = 1;
												}
											}

											$c = array(
												'category'    => $cat,
												'subcategory' => $subcat,
												'id'       => 'all' == $id ? array( 'id' => '' ) : array( 'id' => $id ),
											);

											if ( ! $this->is_post_published( $id_conditions ) ||
												$type != get_post_meta( $id_conditions, 'riode_template_type', true ) ||
												! $this->is_condition_available( $c ) ||
												! $this->is_in_item_conditions( $c, get_post_meta( $id_conditions, 'riode_' . $type . '_conditions', true ), true ) ) {
												unset( $conditions[ $cat ][ $subcat ][ $id ] );
											}
										}

										if ( empty( $conditions[ $cat ][ $subcat ] ) ) {
											unset( $conditions[ $cat ][ $subcat ] );
										}
									}
								}

								if ( empty( $conditions[ $cat ] ) ) {
									unset( $conditions[ $cat ] );
								}
							}
						}
						set_theme_mod( $type . '_conditions', $conditions );
					}

					wp_send_json_success(
						esc_html__( 'Updated display conditions successfully', 'riode' )
					);
					break;
				case 'reset_review':
					// Reset product reviews.
					if ( class_exists( 'WooCommerce' ) ) {
						$args     = array(
							'limit'  => -1,
							'return' => 'ids',
						);
						$products = wc_get_products( $args );
						foreach ( $products as $item ) {
							WC_Comments::clear_transients( $item );
						}
					}
					wp_send_json_success(
						esc_html__( 'Cleared product review transient successfully', 'riode' )
					);
					break;
				default:
					break;
			}

			exit();
		}

		/**
		 * checks if current post exists
		 */
		public function is_post_published( $id ) {
			if ( ! is_numeric( $id ) ) {
				return true;
			}

			if ( $id <= 0 ) {
				return true;
			}

			if ( 'publish' == get_post_status( $id ) ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * checks if current sidebar is registered
		 */
		public function is_sidebar_registered( $id ) {
			if ( $id == -1 ) {
				return true;
			}

			return is_registered_sidebar( $id );
		}

		/**
		 * checks if current condition is available
		 */
		public function is_condition_available( $condition ) {
			if ( 'entire' == $condition['category'] || '404' == $condition['category'] ) {
				return true;
			}
			if ( 'page' == $condition['category'] ) {
				if ( 'individual' == $condition['subcategory'] && 
					! empty( $condition['id'] ) && $condition['id']['id'] &&
					( ! $this->is_post_published( $condition['id']['id'] ) || 'page' != get_post_type( $condition['id']['id'] ) ) ) {
					return false;
				}

				return true;
			}

			if ( 'archive' == substr( $condition['category'], -7 ) || 'single' == substr( $condition['category'], -6 ) ) {
				$post_type = ( 'archive' == substr( $condition['category'], -7 ) ) ? substr( $condition['category'], 0, -8 ) : substr( $condition['category'], 0, -7 );

				if ( ! post_type_exists( $post_type ) ) {
					return false;
				}

				if ( $condition['subcategory'] ) {
					if ( 'individual' == $condition['subcategory'] ) {
						if ( ! empty( $condition['id'] ) && $condition['id']['id'] &&
							( ! $this->is_post_published( $condition['id']['id'] ) || $post_type != get_post_type( $condition['id']['id'] ) ) ) {
							return false;
						}
					} else if ( ! taxonomy_exists( $condition['subcategory'] ) ) {
						return false;
					} else if ( ! empty( $condition['id'] ) && $condition['id']['id'] && ! term_exists( (int) $condition['id']['id'], $condition['subcategory'] ) ) {
						return false;
					}
				}

				return true;
			}

			return true;
		}

		/**
		 * check if single condition is in total conditions
		 */
		public function is_in_total_conditions( $slug, $sc, $conditions ) {
			$lists  = array( 'category', 'subcategory', 'id' );
			$target = $conditions;

			foreach ( $lists as $list ) {
				if ( ! isset( $sc[ $list ] ) ) {
					break;
				}
				if ( 'id' == $list ) {
					$sc[ $list ] = $sc[ $list ]['id'];
				}

				if ( empty( $sc[ $list ] ) || '0' == $sc[ $list ] ) {
					$sc[ $list ] = 'all';
				}

				if ( ! isset( $target[ $sc[ $list ] ] ) ) {
					return false;
				}

				$target = $target[ $sc[ $list ] ];

				if ( is_array( $target ) && isset( $target[ 'popup_id' ] ) ) {
					$target = $target[ 'popup_id' ];
				}
			}

			return $target == $slug;
		}

		/**
		 * check if single condition from total conditions is in item's conditions
		 */
		public function is_in_item_conditions( $sc, $conditions, $display = '' ) {
			if ( isset( $sc['subcategory'] ) && 'all' == $sc['subcategory'] ) {
				$sc['subcategory'] = '';
			}
			if ( isset( $sc['id'] ) && 'all' == $sc['id']['id'] ) {
				$sc['id']['id'] = '';
			}
			if ( ! is_array( $conditions ) ) {
				$conditions = array();
			}

			foreach ( $conditions as $condition ) {
				if ( ( isset( $condition['category'] ) != isset( $sc['category'] ) ) ||
					( isset( $sc['category'] ) && $condition['category'] != $sc['category'] ) ) {
					continue;
				}
				if ( ( isset( $condition['subcategory'] ) != isset( $sc['subcategory'] ) ) ||
					( isset( $sc['subcategory'] ) && $condition['subcategory'] != $sc['subcategory'] ) ) {
					continue;
				}
				if ( ( ( isset( $condition['id'] ) && isset( $condition['id']['id'] ) ) != ( isset( $sc['id'] ) && isset( $sc['id']['id'] ) ) ) ||
					( isset( $sc['id'] ) && $condition['id']['id'] != $sc['id']['id'] ) ) {
					continue;
				}

				return true;
			}

			return false;
		}
	}
endif;

add_action( 'after_setup_theme', 'riode_theme_maintenance_tools', 10 );

if ( ! function_exists( 'riode_theme_maintenance_tools' ) ) :
	function riode_theme_maintenance_tools() {
		$instance = Riode_Maintenance_Tools::get_instance();
	}
endif;
