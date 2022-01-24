<?php
/**
 * Riode_Single_Product_Builder class
 */
defined( 'ABSPATH' ) || die;

define( 'RIODE_TEMPLATE_CONDITION', RIODE_CORE_TEMPLATE . '/template-condition' );

class Riode_Template_Condition {

	protected $condition_network = '';

	protected $template_conditions = '';

	protected $templates = array();

	protected $is_template = '';

	protected $post_id = '';

	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->is_template = false;

		/* Ajax */
		add_action( 'wp_ajax_riode_template_ids_search', array( $this, 'condition_ids_search' ) );
		add_action( 'wp_ajax_nopriv_riode_template_ids_search', array( $this, 'condition_ids_search' ) );
		add_action( 'wp_ajax_riode_save_conditions', array( $this, 'save_conditions' ) );
		add_action( 'wp_ajax_nopriv_riode_save_conditions', array( $this, 'save_conditions' ) );

		add_filter(
			'riode_core_admin_localize_vars',
			function( $vars ) {
				$vars['template_type'] = $this->post_id ? get_post_meta( $this->post_id, 'riode_template_type', true ) : 'layout';
				return $vars;
			}
		);

		if ( is_admin() ) {
			if ( riode_is_elementor_preview() && isset( $_REQUEST['post'] ) && $_REQUEST['post'] ) {
				$this->post_id = $_REQUEST['post'];

				if ( 'riode_template' == get_post_type( $_REQUEST['post'] ) && ! in_array( get_post_meta( $_REQUEST['post'], 'riode_template_type', true ), array( 'block', 'header', 'footer' ) ) ) {
					$this->is_template = 'elementor';
				}
			} elseif ( riode_is_wpb_preview() ) {
				if ( isset( $_REQUEST['post'] ) ) {
					$this->post_id = $_REQUEST['post'];
				} elseif ( isset( $_REQUEST['post_id'] ) ) {
					$this->post_id = $_REQUEST['post_id'];
				} else {
					$this->post_id = 0;
				}
				if ( 'riode_template' == get_post_type( $this->post_id ) && ! in_array( get_post_meta( $this->post_id, 'riode_template_type', true ), array( 'block', 'header', 'footer' ) ) ) {
					$this->is_template = 'wpb';
				}
			} elseif ( ( isset( $_REQUEST['page'] ) && 'riode_layout_dashboard' == $_REQUEST['page'] ) ) { // allow in page layout dashboard page
				$this->is_template = 'page_layout';
			}
		}

		if ( ! $this->is_template ) {
			return;
		}

		if ( 'elementor' == $this->is_template ) {
			add_action(
				'init',
				function() {
					$this->_init_condition_network( get_post_meta( $_REQUEST['post'], 'riode_template_type', true ) );
				},
				100
			);

			add_action( 'admin_print_footer_scripts', array( $this, 'print_display_conditions' ), 1 );

			add_action(
				'elementor/editor/after_enqueue_styles',
				function() {
					if ( defined( 'RIODE_VERSION' ) ) {
						wp_enqueue_script(
							'jquery-magnific-popup',
							RIODE_ASSETS . '/vendor/jquery.magnific-popup/jquery.magnific-popup.min.js',
							array( 'jquery-core' ),
							'1.1.0',
							true
						);
						wp_enqueue_script(
							'jquery-autocomplete',
							RIODE_ASSETS . '/vendor/jquery.autocomplete/jquery.autocomplete.min.js',
							array( 'jquery-core' ),
							false,
							true
						);
					}
				}
			);

			add_filter(
				'riode_builder_addon_html',
				function( $html ) {
					$html[] = array(
						'elementor' => '<li id="riode-template-display-condition"><i class="d-icon-filter-2"></i>' . esc_html__( 'Display Conditions', 'riode-core' ) . '</li>',
					);
					return $html;
				}
			);
		} elseif ( 'wpb' == $this->is_template ) {
			add_action(
				'init',
				function() {
					$this->_init_condition_network( get_post_meta( $this->post_id, 'riode_template_type', true ) );
				},
				100
			);

			add_action(
				'admin_enqueue_scripts',
				function() {
					if ( defined( 'RIODE_VERSION' ) ) {
						wp_enqueue_script(
							'jquery-magnific-popup',
							RIODE_ASSETS . '/vendor/jquery.magnific-popup/jquery.magnific-popup.min.js',
							array( 'jquery-core' ),
							'1.1.0',
							true
						);
						wp_enqueue_script(
							'jquery-autocomplete',
							RIODE_ASSETS . '/vendor/jquery.autocomplete/jquery.autocomplete.min.js',
							array( 'jquery-core' ),
							false,
							true
						);
					}
				}
			);

			add_action(
				'admin_print_footer_scripts',
				function() {
					$this->print_display_conditions();
				}
			);
		} elseif ( 'page_layout' == $this->is_template ) {
			add_action(
				'init',
				function() {
					$this->_init_condition_network( get_post_meta( 'layout', 'riode_template_type', true ) );
				},
				100
			);

			add_action(
				'admin_enqueue_scripts',
				function() {
					if ( defined( 'RIODE_VERSION' ) ) {
						wp_enqueue_script(
							'jquery-magnific-popup',
							RIODE_ASSETS . '/vendor/jquery.magnific-popup/jquery.magnific-popup.min.js',
							array( 'jquery-core' ),
							'1.1.0',
							true
						);
						wp_enqueue_style(
							'riode-icons',
							RIODE_ASSETS . '/vendor/riode-icons/css/icons.min.css',
							array(),
							RIODE_VERSION
						);
					}
				}
			);

			add_action(
				'admin_enqueue_scripts',
				function() {
					if ( defined( 'RIODE_VERSION' ) ) {
						wp_enqueue_script(
							'jquery-autocomplete',
							RIODE_ASSETS . '/vendor/jquery.autocomplete/jquery.autocomplete.min.js',
							array( 'jquery-core' ),
							false,
							true
						);
					}
				}
			);

			add_action(
				'admin_print_footer_scripts',
				function() {
					$this->print_display_conditions();
				}
			);
		}

		add_filter( 'riode_core_admin_localize_vars', array( $this, 'add_localize_vars' ) );
	}


	/**
	 * localize php variables to use in JS
	 *
	 * @since 1.0
	 * @since 1.4.0 added templates, condition duplication texts
	 */
	public function add_localize_vars( $vars ) {
		$vars['condition_network']   = $this->condition_network;
		$vars['post_id']             = $this->post_id;
		$vars['template_conditions'] = $this->template_conditions;
		$vars['templates']           = $this->templates;

		if ( ! isset( $vars['texts'] ) ) {
			$vars['texts'] = array();
		}

		$vars['texts']['condition_warning']             = esc_html__( 'Error occupied while saving template display conditions', 'riode-core' );
		$vars['texts']['condition_duplicated']          = esc_html__( 'This condition is already set - ', 'riode-core' );
		$vars['texts']['condition_override']            = sprintf( esc_html__( 'There are some conditions which are set in others.%1$sDo you want to override existing conditions?', 'riode-core' ), '%list%' );
		$vars['texts']['condition_duplicated_template'] = sprintf( esc_html__( 'Condition %1$s - set in %2$s', 'riode-core' ), '%index%', '%name%' );
		$vars['display_conditions']                    = true;

		return $vars;
	}


	/**
	 * gets and save all display conditions to use in JS
	 *
	 * @since 1.0
	 * @since 1.4.0 added all conditions of templates
	 */
	protected function _init_condition_network( $type ) {
		// Save old conditions
		if ( $this->post_id ) {
			$this->template_conditions = get_post_meta( $this->post_id, 'riode_' . $type . '_conditions', true );

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
				if ( defined( 'ELEMENTOR_VERSION' ) && get_post_meta( $post->ID, '_elementor_edit_mode', true ) ) {
					$edit_link = admin_url( 'post.php?post=' . $post->ID . '&action=elementor' );
				} else {
					$edit_link = admin_url( 'post.php?post=' . $post->ID . '&action=edit' );
				}

				$this->templates[ $post->ID ] = array(
					'name'       => $post->post_title,
					'edit_link'  => $edit_link,
					'conditions' => get_post_meta( $post->ID, 'riode_' . $type . '_conditions', true )
				);
			}
		}

		// Create condition network
		$this->condition_network = array();

		$this->condition_network['all'] = array(
			'entire' => array(
				'name'    => esc_html__( 'Entire Site', 'riode-core' ),
				'subcats' => array(),
			),
		);

		// Other registered post types
		$post_types = get_post_types( array( 'show_in_nav_menus' => true ), 'objects' );
		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type->name, array( 'page', 'riode_template' ) ) ) {
				continue;
			}

			if ( 'product_layout' == $type && 'product' != $post_type->name ) {
				continue;
			}

			$taxonomies = get_object_taxonomies( $post_type->name, 'objects' );
			$taxonomies = wp_filter_object_list(
				$taxonomies,
				array(
					'public'            => true,
					'show_in_nav_menus' => true,
				)
			);

			$archive_parts = array( '' => esc_html__( 'All Archives', 'riode-core' ) );
			$single_parts  = array( '' => 'All ' . ucwords( $post_type->labels->name ) );

			if ( $taxonomies ) {
				foreach ( $taxonomies as $key => $value ) {
					$archive_parts[ $key ] = ucwords( $value->labels->name ) . ' Of';
					$single_parts[ $key ]  = 'In ' . ucwords( $value->labels->name ) . ' Of';
				}
			}

			$single_parts['individual'] = 'Individual ' . $post_type->labels->name;

			if ( 'product_layout' != $type || 'product' != $post_type->name ) {
				$this->condition_network[ $post_type->name ][ $post_type->name . '_archive' ] = array(
					'name'    => ucwords( $post_type->labels->singular_name ) . ' ' . esc_html__( 'Archive', 'riode-core' ),
					'subcats' => $archive_parts,
				);
			}

			$this->condition_network[ $post_type->name ][ $post_type->name . '_single' ] = array(
				'name'    => ucwords( $post_type->labels->singular_name ) . ' ' . esc_html__( 'Single', 'riode-core' ),
				'subcats' => $single_parts,
			);
		}

		if ( 'product_layout' != $type ) {
			$this->condition_network['page'] = array(
				'page'  => array(
					'name'    => esc_html__( 'Pages', 'riode-core' ),
					'subcats' => array(
						''           => esc_html__( 'All Pages', 'riode-core' ),
						'individual' => esc_html__( 'Individual Pages', 'riode-core' ),
					),
				),
				'error' => array(
					'name'    => esc_html__( 'Error 404', 'riode-core' ),
					'subcats' => array(),
				),
			);
		}

		// Rename some condition pages
		if ( isset( $this->condition_network['post'] ) && isset( $this->condition_network['post']['post_archive'] ) ) {
			$this->condition_network['post']['post_archive']['name']        = esc_html__( 'Blog Pages', 'riode-core' );
			$this->condition_network['post']['post_archive']['subcats'][''] = esc_html__( 'All Blog Pages', 'riode-core' );
		}
		if ( isset( $this->condition_network['post'] ) && isset( $this->condition_network['post']['post_single'] ) ) {
			$this->condition_network['post']['post_single']['name'] = esc_html__( 'Post Detail Pages', 'riode-core' );
		}
		if ( isset( $this->condition_network['product'] ) && isset( $this->condition_network['product']['product_archive'] ) ) {
			$this->condition_network['product']['product_archive']['name']        = esc_html__( 'Shop Pages', 'riode-core' );
			$this->condition_network['product']['product_archive']['subcats'][''] = esc_html__( 'All Shop Pages', 'riode-core' );
		}
		if ( isset( $this->condition_network['product'] ) && isset( $this->condition_network['product']['product_single'] ) ) {
			$this->condition_network['product']['product_single']['name'] = esc_html__( 'Product Detail Pages', 'riode-core' );
		}
	}

	public function print_display_conditions() {
		if ( $this->post_id ) {
			$template_type = get_post_meta( $this->post_id, 'riode_template_type', true );
		} else {
			$template_type = 'layout';
		}
		?>
		<div id="riode_template_conditions_popup" class="riode-template-form<?php echo ' template-type-' . esc_attr( $template_type ); ?>" style="display: none;">
			<div class="mfp-header">
				<h2><span class="riode-mini-logo"></span><?php esc_html_e( 'Display Conditions', 'riode-core' ); ?></h2>
			</div>
			<div class="mfp-body">
				<?php
					if ( ! empty( $_REQUEST['page'] ) && 'riode_layout_dashboard' == $_REQUEST['page'] ) {
						echo '<h3>' . sprintf( esc_html__( 'Determine %1$sWhere to Apply%2$s %3$sThis Layout', 'riode-core' ), '<strong>', '</strong>', '<br>' ) . '</h3>';
						printf( esc_html__( '%1$sAdd any simple or complicated conditions which determine where this layout should be applied.%2$sThe last layout will have higher priority if several layouts are applied under same condition.%3$s', 'riode-core' ), '<p>', '<br>', '</br>' );
					} else {
						echo '<h3>' . sprintf( esc_html__( 'Determine %1$sWhere to Display%2$s %3$sThis Template', 'riode-core' ), '<strong>', '</strong>', '<br>' ) . '</h3>';
						printf( esc_html__( '%1$sAdd any simple or complicated conditions which determine where this template is displayed.%2$sThe last layout will have higher priority if several layouts are applied under same condition.%3$s', 'riode-core' ), '<p>', '<br>', '</br>' );
					}
				?>

				<?php
				if ( $this->post_id ) {
					$conditions = get_post_meta( $this->post_id, 'riode_template_conditions', true );
				} elseif ( 'layout' == $template_type ) {
					$conditions = array();
				}
				?>

				<ul class="conditions">
				</ul>
				<button class="button btn" id="riode-add-display-condition"><?php esc_html_e( 'Add Condition', 'riode-core' ); ?></button>
			</div>
			<div class="mfp-footer">
				<button class="button btn" id="riode-save-display-conditions" disabled="disabled"><?php esc_html_e( 'Save Conditions', 'riode-core' ); ?></button>
			</div>
		</div>
		<?php
	}

	public function condition_ids_search() {
		check_ajax_referer( 'riode-core-nonce', 'nonce' );

		$taxonomy  = isset( $_REQUEST['taxonomy'] ) && ! in_array( $_REQUEST['taxonomy'], array( 'individual', 'child_page' ) ) ? $_REQUEST['taxonomy'] : '';
		$post_type = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : '';

		global $wpdb;
		$results = $wpdb->get_results(
			$taxonomy ?
			$wpdb->prepare(
				"SELECT terms.term_id AS id, terms.name AS title
					FROM {$wpdb->terms} AS terms LEFT JOIN {$wpdb->term_taxonomy} AS taxonomy
					ON terms.term_id = taxonomy.term_id 
					WHERE taxonomy.taxonomy = '{$taxonomy}' AND terms.name LIKE '%%%s%%'",
				$wpdb->esc_like( stripslashes( $_REQUEST['query'] ) )
			) :
			$wpdb->prepare(
				"SELECT ID AS id, post_title AS title
					FROM {$wpdb->posts} 
					WHERE post_type = '{$post_type}' AND post_status = 'publish' AND post_title LIKE '%%%s%%'",
				$wpdb->esc_like( stripslashes( $_REQUEST['query'] ) )
			),
			ARRAY_A
		);

		wp_send_json( array( 'suggestions' => $results ) );
	}


	/**
	 * saves display conditions for page layouts and templates
	 *
	 * @since 1.0
	 * @since 1.4.0 existing conditions will be removed when same conditions are applied
	 */
	public function save_conditions() {
		check_ajax_referer( 'riode-core-nonce', 'nonce' );

		// Apply conditions to targets
		$template_type = is_numeric( $_POST['post_id'] ) ? get_post_meta( $_POST['post_id'], 'riode_template_type', true ) : 'layout';

		$conditions = riode_get_option( $template_type . '_conditions' );

		if ( 'layout' == $template_type ) {
			$layouts = riode_get_option( 'page_layouts' );
			if ( ! empty( $layouts[ $_POST['post_id'] ]['condition'] ) ) {
				$cods = $layouts[ $_POST['post_id'] ]['condition'];
			} else {
				$cods = array();
			}
		} else {
			$cods = get_post_meta( $_POST['post_id'], 'riode_' . $template_type . '_conditions', true );
		}

		// remove old conditions from layouts and conditions
		if ( ! empty( $cods ) ) {
			foreach ( $cods as $each ) {
				$conditions = $this->set_remove_condition( $conditions, $each, true );
			}
		}

		// update to new layouts and conditions
		if ( 'layout' == $template_type ) {
			$layouts[ $_POST['post_id'] ]['condition'] = empty( $_POST['conditions'] ) ? array() : $_POST['conditions'];
		}
		$cods = empty( $_POST['conditions'] ) ? array() : $_POST['conditions'];

		if ( 'layout' == $template_type ) {
			// remove existing conditions
			if ( ! empty( $_POST['duplications'] ) ) {
				foreach ( $_POST['duplications'] as $item ) {
					array_splice( $layouts[ $item['origin_slug'] ]['condition'], $item['origin_idx'], 1 );
				}
			}

			set_theme_mod( 'page_layouts', $layouts );
		} else {
			// remove existing conditions
			if ( ! empty( $_POST['duplications'] ) ) {
				$templates = array();
				$posts = get_posts(
					array(
						'post_status' => 'publish',
						'post_type'   => 'riode_template',
						'meta_key'    => 'riode_template_type',
						'meta_value'  => $template_type,
						'numberposts' => -1,
					)
				);

				foreach ( $posts as $post ) {
					if ( defined( 'ELEMENTOR_VERSION' ) && get_post_meta( $post->ID, '_elementor_edit_mode', true ) ) {
						$edit_link = admin_url( 'post.php?post=' . $post->ID . '&action=elementor' );
					} else {
						$edit_link = admin_url( 'post.php?post=' . $post->ID . '&action=edit' );
					}

					$templates[ $post->ID ] = array(
						'name'       => $post->post_title,
						'edit_link'  => $edit_link,
						'conditions' => get_post_meta( $post->ID, 'riode_' . $template_type . '_conditions', true )
					);
				}

				foreach ( $_POST['duplications'] as $item ) {
					array_splice( $templates[ $item['origin_slug'] ]['conditions'], $item['origin_idx'], 1 );
					if ( empty( $templates[ $item['origin_slug'] ]['conditions'] ) ) {
						$templates[ $item['origin_slug'] ]['conditions'] = array();
					}

					update_post_meta( $item['origin_slug'], 'riode_' . $template_type . '_conditions', $templates[ $item['origin_slug'] ]['conditions'] );
				}
			}

			update_post_meta( $_POST['post_id'], 'riode_' . $template_type . '_conditions', $cods );
			$this->templates = $templates;
		}

		if ( ! empty( $cods ) ) {
			foreach ( $cods as $each ) {
				$option = $_POST['post_id'];
				if ( 'popup' == $template_type ) {
					$option = array(
						'popup_id'     => $_POST['post_id'],
						'popup_on'     => $each['popup_on'],
						'popup_within' => $each['popup_within'],
					);
				}

				$conditions = $this->set_remove_condition( $conditions, $each, false, $option );
			}
		}

		set_theme_mod( $template_type . '_conditions', $conditions );

		wp_send_json( array(
			'result'       => 'success',
			'page_layouts' => isset( $layouts ) ? $layouts : array(),
			'templates'    => isset( $templates ) ? $templates : array()
		) );
	}

	public function set_remove_condition( $conditions, $each, $remove = false, $option = '' ) {
		if ( ! $remove && ! isset( $conditions[ $each['category'] ] ) ) {
			$conditions[ $each['category'] ] = array();
		}

		if ( ! isset( $each['subcategory'] ) ) { // for entire
			if ( $remove ) {
				unset( $conditions[ $each['category'] ] );
			} else {
				$conditions[ $each['category'] ] = $option;
			}
			return $conditions;
		}

		if ( '' == $each['subcategory'] ) { // for all archive or single
			if ( $remove ) {
				unset( $conditions[ $each['category'] ]['all'] );
			} else {
				$conditions[ $each['category'] ]['all'] = $option;
			}
			return $conditions;
		}

		if ( ! isset( $each['id'] ) || empty( $each['id'] ) ) {
			return $conditions;
		}

		if ( 0 == $each['id']['id'] ) {
			if ( 'page' == $each['category'] ) {
				return $conditions;
			}
			if ( 'archive' == substr( $each['category'], -7 ) ) { // for all taxonomy archive
				if ( $remove ) {
					unset( $conditions[ $each['category'] ][ $each['subcategory'] ]['all'] );
				} else {
					$conditions[ $each['category'] ][ $each['subcategory'] ]['all'] = $option;
				}
				return $conditions;
			}
			if ( 'single' == substr( $each['category'], -6 ) ) { // for all taxonomy single
				return $conditions;
			}
		}

		if ( $remove ) {
			unset( $conditions[ $each['category'] ][ $each['subcategory'] ][ $each['id']['id'] ] );
		} else {
			$conditions[ $each['category'] ][ $each['subcategory'] ][ $each['id']['id'] ] = $option; // for specific archive or single
		}

		return $conditions;
	}
}

Riode_Template_Condition::get_instance();
