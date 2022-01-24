<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
	return;
}

define( 'RIODE_CORE_ELEMENTOR', RIODE_CORE_PATH . '/elementor' );

use Elementor\Core\Files\CSS\Global_CSS;

class Riode_Elementor {

	private $controls = array();

	private $partials = array();

	private $widgets = array();

	private $elements = array();

	private $additionals = array();

	/**
	 * Constructor
	 *
	 * @since 1.0
	*/
	public function __construct() {
		require_once RIODE_CORE_ELEMENTOR . '/functions.php';

		$this->partials = array(
			'banner',
			'creative',
			'grid',
			'slider',
			'button',
			'products',
			'testimonial',
		);

		$this->elements = array(
			'section',
			'column',
		);

		$this->controls = array(
			'image_choose',
			'origin_position',
			'description',
			'ajaxselect2',
		);

		$this->widgets = array(
			'heading',
			'posts',
			'block',
			'banner',
			'countdown',
			'button',
			'imageslider',
			'testimonial',
			'testimonial-group',
			'imagebox',
			'share',
			'menu',
			'subcategories',
			'banner',
			'floating',
			'hotspot',
			'logo',
			'infobox',
			'list',
			'360-degree',
			'blockquote',
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$this->widgets = array_merge(
				$this->widgets,
				array(
					'breadcrumb',
					'products',
					'products-tab',
					'products-banner',
					'products-single',
					'categories',
					'single-product',
					'filter',
					'vendors',
				)
			);
		}

		$this->additionals = array(
			'floating-effect',
			'custom-css-js',
			'dismiss',
		);

		$this->load_part_files();

		// Register controls, widgets, elements, icons
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_control' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widget' ) );
		add_action( 'elementor/elements/elements_registered', array( $this, 'register_element' ) );
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'riode_add_icon_library' ) );
		add_filter( 'elementor/controls/animations/additional_animations', array( $this, 'add_appear_animations' ), 10, 1 );

		// Load Elementor CSS and JS
		if ( riode_is_elementor_preview() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'load_preview_scripts' ) );
		}
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'load_styles' ) );

		// Include Elementor Admin JS
		add_action(
			'elementor/editor/after_enqueue_scripts',
			function() {
				if ( defined( 'RIODE_VERSION' ) ) {
					wp_enqueue_style( 'riode-icons', RIODE_ASSETS . '/vendor/riode-icons/css/icons.min.css', array(), RIODE_VERSION );
				}
				wp_enqueue_script( 'riode-elementor-admin-js', RIODE_CORE_URI . 'assets/js/elementor-admin' . riode_get_js_extension(), array( 'elementor-editor' ), RIODE_CORE_VERSION, true );
			}
		);

		// Dequeue Elementor Default styles
		add_action(
			'elementor/frontend/after_register_styles',
			function() {
				// Animation Style
				if ( defined( 'RIODE_VERSION' ) ) {
					wp_deregister_style( 'elementor-animations' );
					wp_register_style( 'elementor-animations', RIODE_ASSETS . '/vendor/animate/animate.min.css' );
				}
			}
		);

		// Add Elementor Page Custom CSS
		if ( wp_doing_ajax() ) {
			add_action( 'elementor/document/before_save', array( $this, 'save_page_custom_css_js' ), 10, 2 );
			add_action( 'elementor/document/after_save', array( $this, 'save_elementor_page_css_js' ), 10, 2 );
		}

		// Init Elementor Document Config
		add_filter( 'elementor/document/config', array( $this, 'init_elementor_config' ), 10, 2 );

		// Register Document Controls
		add_action( 'elementor/documents/register_controls', array( $this, 'register_document_controls' ) );
		// Because elementor removes all callbacks, add it again
		add_action( 'elementor/editor/after_enqueue_scripts', array( RIODE_CORE::get_instance(), 'load_scripts' ) );

		if ( riode_is_elementor_preview() ) {
			// Add Custom CSS & JS to Riode Elementor Addons
			add_filter( 'riode_builder_addon_html', array( $this, 'add_addon_html_to_vars' ) );
		}

		// Compatabilities
		add_filter( 'elementor/widgets/wordpress/widget_args', array( $this, 'add_wp_widget_args' ), 10, 2 );

		/*
		 * Loads used block CSS
		 * Gets dependent elementor styles
		 * Includes kit style and post style
		 */
		add_action( 'elementor/css-file/post/enqueue', array( $this, 'get_dependent_elementor_styles' ) );
		add_action( 'riode_before_enqueue_theme_style', array( $this, 'add_global_css' ) );
		add_action( 'riode_after_enqueue_theme_style', array( $this, 'add_post_css' ) );
		add_action( 'riode_after_enqueue_custom_style', array( $this, 'add_block_css' ) );

		// Elementor Ajax Requests
		add_action( 'wp_ajax_riode_load_creative_layout', array( $this, 'load_creative_layout' ) );
		add_action( 'wp_ajax_nopriv_riode_load_creative_layout', array( $this, 'load_creative_layout' ) );
	}

	/**
	 * Loads part files
	 *
	 * @since 1.4.0
	 */
	public function load_part_files() {
		// register rest apis
		include_once 'restapi/ajaxselect2.php';

		array_multisort( $this->partials );
		foreach ( $this->partials as $partial ) {
			include_once 'partials/' . $partial . '.php';
		}

		include_once RIODE_CORE_ELEMENTOR . '/tabs/riode-elementor-custom-tabs.php';

		foreach ( $this->additionals as $addon ) {
			include_once RIODE_CORE_ELEMENTOR . '/additionals/additional-' . $addon . '.php';
		}
	}

	// Register new Category
	public function register_category( $self ) {
		$self->add_category(
			'riode_widget',
			array(
				'title'  => esc_html__( 'Riode Widgets', 'riode-core' ),
				'active' => true,
			)
		);
	}

	// Register new Control
	public function register_control( $self ) {
		foreach ( $this->controls as $control ) {
			include_once RIODE_CORE_ELEMENTOR . '/controls/control-' . $control . '.php';
			$class_name = 'Riode_Control_' . ucfirst( $control );
			$self->register_control( 'riode_' . $control, new $class_name( array(), array( 'control_name' => $class_name ) ) );
		}
	}


	public function register_element() {
		foreach ( $this->elements as $element ) {
			include_once RIODE_CORE_ELEMENTOR . '/elements/riode-' . $element . '.php';
		}

		Elementor\Plugin::$instance->elements_manager->unregister_element_type( 'section' );
		Elementor\Plugin::$instance->elements_manager->register_element_type( new Riode_Element_Section() );

		Elementor\Plugin::$instance->elements_manager->unregister_element_type( 'column' );
		Elementor\Plugin::$instance->elements_manager->register_element_type( new Riode_Element_Column() );
	}

	// Register new widget
	public function register_widget( $self ) {
		/* Remove elementor default common widget and register ours */
		$self->unregister_widget_type( 'common' );
		include_once RIODE_CORE_ELEMENTOR . '/widgets/widget-common.php';
		$self->register_widget_type( new Riode_Common_Elementor_Widget( array(), array( 'widget_name' => 'common' ) ) );

		array_multisort( $this->widgets );

		foreach ( $this->widgets as $widget ) {
			include_once RIODE_CORE_ELEMENTOR . '/widgets/widget-' . $widget . '.php';
			$class_name = 'Riode_' . ucwords( str_replace( '-', '_', $widget ) ) . '_Elementor_Widget';
			if ( class_exists( $class_name ) ) {
				$self->register_widget_type( new $class_name( array(), array( 'widget_name' => $class_name ) ) );
			}
		}
	}


	public function load_styles() {
		wp_enqueue_style( 'riode-elementor-style', RIODE_CORE_URI . 'assets/css/elementor-admin' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );
	}


	public function load_preview_scripts() {
		// load needed style file in elementor preview
		wp_enqueue_style( 'riode-elementor-preview', RIODE_CORE_URI . 'assets/css/elementor-preview' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );

		wp_enqueue_script( 'riode-elementor-js', RIODE_CORE_URI . 'assets/js/elementor' . riode_get_js_extension(), array(), RIODE_CORE_VERSION, true );

		wp_localize_script(
			'riode-elementor-js',
			'riode_elementor_vars',
			array(
				'ajax_url'         => esc_url( admin_url( 'admin-ajax.php' ) ),
				'wpnonce'          => wp_create_nonce( 'riode-elementor-nonce' ),
				'theme_assets_url' => defined( 'RIODE_VERSION' ) ? RIODE_ASSETS : '',
			)
		);
	}


	public function riode_add_icon_library( $icons ) {
		if ( defined( 'RIODE_VERSION' ) ) {
			$icons['riode-icons'] = array(
				'name'          => 'riode',
				'label'         => esc_html__( 'Riode Icons', 'riode-core' ),
				'prefix'        => 'd-icon-',
				'displayPrefix' => ' ',
				'labelIcon'     => 'd-icon-gift',
				'fetchJson'     => RIODE_CORE_URI . '/assets/js/icons/riode-icons.js',
				'ver'           => RIODE_CORE_VERSION,
				'native'        => false,
			);
		}
		return $icons;
	}


	public function save_page_custom_css_js( $self, $data ) {
		if ( empty( $data['settings'] ) || empty( $_REQUEST['editor_post_id'] ) ) {
			return;
		}
		$post_id = absint( $_REQUEST['editor_post_id'] );

		// save Riode elementor page CSS
		if ( ! empty( $data['settings']['page_css'] ) ) {
			update_post_meta( $post_id, 'page_css', wp_slash( $data['settings']['page_css'] ) );
		} else {
			delete_post_meta( $post_id, 'page_css' );
		}

		if ( current_user_can( 'unfiltered_html' ) ) {
			// save Riode elementor page JS
			if ( ! empty( $data['settings']['page_js'] ) ) {
				update_post_meta( $post_id, 'page_js', trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $data['settings']['page_js'] ) ) );
			} else {
				delete_post_meta( $post_id, 'page_js' );
			}
		}

		// save Riode template builder options
		if ( 'riode_template' == get_post_type() ) {
			$category = get_post_meta( get_the_ID(), 'riode_template_type', true );

			if ( 'popup' == $category ) {
				$popup_options = array();

				$popup_options['width']         = wp_slash( '' != $data['settings']['popup_width'] ? $data['settings']['popup_width'] : 600 );
				$popup_options['animation']     = ! empty( $data['settings']['popup_animation'] ) ? wp_slash( $data['settings']['popup_animation'] ) : '';
				$popup_options['anim_duration'] = wp_slash( '' != $data['settings']['popup_anim_duration'] ? $data['settings']['popup_anim_duration'] : 400 );
				$popup_options['transform']     = wp_slash( '' != $data['settings']['popup_pos_origin'] ? $data['settings']['popup_pos_origin'] : 't-mc' );
				$popup_options['left']          = '' != $data['settings']['popup_pos_left']['size'] ? $data['settings']['popup_pos_left']['size'] . $data['settings']['popup_pos_left']['unit'] : '50%';
				$popup_options['top']           = '' != $data['settings']['popup_pos_top']['size'] ? $data['settings']['popup_pos_top']['size'] . $data['settings']['popup_pos_top']['unit'] : '50%';
				$popup_options['right']         = '' != $data['settings']['popup_pos_right']['size'] ? $data['settings']['popup_pos_right']['size'] . $data['settings']['popup_pos_right']['unit'] : 'auto';
				$popup_options['bottom']        = '' != $data['settings']['popup_pos_bottom']['size'] ? $data['settings']['popup_pos_bottom']['size'] . $data['settings']['popup_pos_bottom']['unit'] : 'auto';
				$popup_options['wrapper_class'] = ! empty( $data['settings']['popup_aclass'] ) ? wp_slash( $data['settings']['popup_aclass'] ) : '';

				update_post_meta( $post_id, 'popup_options', wp_slash( json_encode( $popup_options ) ) );
			}
		}
	}

	public function save_elementor_page_css_js( $self, $data ) {
		if ( current_user_can( 'unfiltered_html' ) || empty( $data['settings'] ) || empty( $_REQUEST['editor_post_id'] ) ) {
			return;
		}
		$post_id = absint( $_REQUEST['editor_post_id'] );
		if ( ! empty( $data['settings']['page_css'] ) ) {
			$elementor_settings = get_post_meta( $post_id, '_elementor_page_settings', true );
			if ( is_array( $elementor_settings ) ) {
				$elementor_settings['page_css'] = riode_strip_script_tags( get_post_meta( $post_id, 'page_css', true ) );
				update_post_meta( $post_id, '_elementor_page_settings', $elementor_settings );
			}
		}
		if ( ! empty( $data['settings']['page_js'] ) ) {
			$elementor_settings = get_post_meta( $post_id, '_elementor_page_settings', true );
			if ( is_array( $elementor_settings ) ) {
				$elementor_settings['page_js'] = riode_strip_script_tags( get_post_meta( $post_id, 'page_js', true ) );
				update_post_meta( $post_id, '_elementor_page_settings', $elementor_settings );
			}
		}
	}

	public function init_elementor_config( $config, $post_id ) {
		if ( ! isset( $config['settings'] ) ) {
			$config['settings'] = array();
		}
		if ( ! isset( $config['settings']['settings'] ) ) {
			$config['settings']['settings'] = array();
		}

		$config['settings']['settings']['page_css'] = get_post_meta( $post_id, 'page_css', true );
		$config['settings']['settings']['page_js']  = get_post_meta( $post_id, 'page_js', true );
		return $config;
	}

	public function add_addon_html_to_vars( $html ) {
		$html[] = array(
			'elementor' => '<li id="riode-custom-css-js"><i class="far fa-edit"></i>' . esc_html__( 'Page CSS & JS', 'riode-core' ) . '</li>',
		);
		$html[] = array(
			'elementor' => '<li id="riode-edit-area"><i class="fas fa-arrows-alt-h"></i>' . esc_html__( 'Edit Area Size', 'riode-core' ) . '</li>',
		);
		if ( 'popup' == get_post_meta( get_the_ID(), 'riode_template_type', true ) ) {
			$html[] = array(
				'elementor' => '<li id="riode-popup-options"><i class="far fa-sun"></i>' . esc_html__( 'Popup Options', 'riode-core' ) . '</li>',
			);
		}
		return $html;
	}

	public function register_document_controls( $document ) {
		if ( ! $document instanceof Elementor\Core\DocumentTypes\PageBase && ! $document instanceof Elementor\Modules\Library\Documents\Page ) {
			return;
		}

		// Add Template Builder Controls
		if ( 'riode_template' == get_post_type() ) {
			$category = get_post_meta( get_the_ID(), 'riode_template_type', true );

			if ( 'popup' == $category ) {
				global $riode_animations;

				$document->start_controls_section(
					'riode_popup_settings',
					array(
						'label' => esc_html__( 'Riode Popup Settings', 'riode-core' ),
						'tab'   => Elementor\Controls_Manager::TAB_SETTINGS,
					)
				);

					$document->add_control(
						'popup_width',
						array(
							'type'        => Elementor\Controls_Manager::NUMBER,
							'label'       => esc_html__( 'Popup Width (px)', 'riode-core' ),
							'description' => esc_html__( 'Controls width of popup template.', 'riode-core' ),
							'default'     => 600,
						)
					);

					$document->add_control(
						'popup_animation',
						array(
							'type'        => Elementor\Controls_Manager::SELECT,
							'label'       => esc_html__( 'Popup Animation', 'riode-core' ),
							'options'     => $riode_animations['sliderIn'],
							'description' => esc_html__( 'Select an appear animation of popup template.', 'riode-core' ),
							'default'     => 'default',
						)
					);

					$document->add_control(
						'popup_anim_duration',
						array(
							'type'        => Elementor\Controls_Manager::NUMBER,
							'label'       => esc_html__( 'Animation Duration (ms)', 'riode-core' ),
							'description' => esc_html__( 'Controls duration time of appear animation.', 'riode-core' ),
							'default'     => 400,
						)
					);

					$document->add_control(
						'popup_desc_click',
						array(
							'type'        => 'riode_description',
							/* translators: opening and closing bold tags */
							'description' => sprintf( esc_html__( 'Please add two classes - "show-popup popup-id-ID" to any elements you want to show this popup on click. %1$se.g) show-popup popup-id-725%2$s', 'riode-core' ), '<b>', '</b>' ),
						)
					);

					$document->add_control(
						'popup_pos_heading',
						array(
							'label'     => esc_html__( 'Popup Position', 'riode-core' ),
							'type'      => Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$document->add_control(
						'popup_pos_origin',
						array(
							'label'       => esc_html__( 'Basis Point', 'riode-core' ),
							'type'        => Elementor\Controls_Manager::CHOOSE,
							'options'     => array(
								't-none' => array(
									'title' => esc_html__( 'Default', 'riode-core' ),
									'icon'  => 'eicon-ban',
								),
								't-m'    => array(
									'title' => esc_html__( 'Vertical Center', 'riode-core' ),
									'icon'  => 'eicon-v-align-middle',
								),
								't-c'    => array(
									'title' => esc_html__( 'Horizontal Center', 'riode-core' ),
									'icon'  => 'eicon-h-align-center',
								),
								't-mc'   => array(
									'title' => esc_html__( 'Center', 'riode-core' ),
									'icon'  => 'eicon-frame-minimize',
								),
							),
							'default'     => 't-mc',
							'description' => esc_html__( 'Controls basis point of popup template.', 'riode-core' ),
						)
					);

					$document->start_controls_tabs( 'popup_pos_tabs' );

						$document->start_controls_tab(
							'popup_pos_left_tab',
							array(
								'label' => esc_html__( 'Left', 'riode-core' ),
							)
						);

							$document->add_control(
								'popup_pos_left',
								array(
									'label'      => esc_html__( 'Left Offset', 'riode-core' ),
									'type'       => Elementor\Controls_Manager::SLIDER,
									'size_units' => array(
										'px',
										'rem',
										'%',
									),
									'default'    => array(
										'size' => 50,
										'unit' => '%',
									),
								)
							);

						$document->end_controls_tab();

						$document->start_controls_tab(
							'popup_pos_top_tab',
							array(
								'label' => esc_html__( 'Top', 'riode-core' ),
							)
						);

							$document->add_control(
								'popup_pos_top',
								array(
									'label'      => esc_html__( 'Top Offset', 'riode-core' ),
									'type'       => Elementor\Controls_Manager::SLIDER,
									'size_units' => array(
										'px',
										'rem',
										'%',
									),
									'default'    => array(
										'size' => 50,
										'unit' => '%',
									),
								)
							);

						$document->end_controls_tab();

						$document->start_controls_tab(
							'popup_pos_right_tab',
							array(
								'label' => esc_html__( 'Right', 'riode-core' ),
							)
						);

							$document->add_control(
								'popup_pos_right',
								array(
									'label'      => esc_html__( 'Right Offset', 'riode-core' ),
									'type'       => Elementor\Controls_Manager::SLIDER,
									'size_units' => array(
										'px',
										'rem',
										'%',
									),
								)
							);

						$document->end_controls_tab();

						$document->start_controls_tab(
							'popup_pos_bottom_tab',
							array(
								'label' => esc_html__( 'Bottom', 'riode-core' ),
							)
						);

							$document->add_control(
								'popup_pos_bottom',
								array(
									'label'      => esc_html__( 'Bottom Offset', 'riode-core' ),
									'type'       => Elementor\Controls_Manager::SLIDER,
									'size_units' => array(
										'px',
										'rem',
										'%',
									),
								)
							);

						$document->end_controls_tab();

					$document->end_controls_tabs();

					$document->add_control(
						'popup_aclass',
						array(
							'label'       => esc_html__( 'CSS Classes', 'riode-core' ),
							'type'        => Elementor\Controls_Manager::TEXT,
							'separator'   => 'before',
							'description' => esc_html__( 'Add your custom classes without dot.', 'riode-core' ),
						)
					);

				$document->end_controls_section();
			}
		}

		$document->start_controls_section(
			'riode_edit_area',
			array(
				'label' => esc_html__( 'Riode Edit Area', 'riode-core' ),
				'tab'   => Elementor\Controls_Manager::TAB_SETTINGS,
			)
		);

			$document->add_control(
				'riode_edit_area_width',
				array(
					'label'       => esc_html__( 'Edit Area Width', 'riode-core' ),
					'description' => esc_html__( "Control edit area width for this template's usage.", 'riode-core' ),
					'type'        => Elementor\Controls_Manager::SLIDER,
					'size_units'  => array(
						'px',
						'%',
						'vw',
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 100,
							'max'  => 500,
						),
						'%'  => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
						'vw' => array(
							'step' => 1,
							'min'  => 0,
							'max'  => 100,
						),
					),
					'separator'   => 'after',
				)
			);

		$document->end_controls_section();

		$document->start_controls_section(
			'riode_blank_styles',
			array(
				'label' => esc_html__( 'Riode Blank Styles', 'riode-core' ),
				'tab'   => Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$document->end_controls_section();

		$document->start_controls_section(
			'riode_custom_css_settings',
			array(
				'label' => esc_html__( 'Riode Custom CSS', 'riode-core' ),
				'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

			$document->add_control(
				'page_css',
				array(
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'rows' => 40,
				)
			);

		$document->end_controls_section();

		$document->start_controls_section(
			'riode_custom_js_settings',
			array(
				'label' => esc_html__( 'Riode Custom JS', 'riode-core' ),
				'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		if ( current_user_can( 'unfiltered_html' ) ) {
			$document->add_control(
				'page_js_prefix',
				array(
					'type'  => Elementor\Controls_Manager::HEADING,
					'label' => 'Riode.' . '$' . "window.on('riode_complete', function() {",
				)
			);

			$document->add_control(
				'page_js',
				array(
					'type' => Elementor\Controls_Manager::TEXTAREA,
					'rows' => 40,
				)
			);

			$document->add_control(
				'page_js_suffix',
				array(
					'type'  => Elementor\Controls_Manager::HEADING,
					'label' => '})',
				)
			);
		}

		$document->end_controls_section();
	}

	public function add_appear_animations() {
		global $riode_animations;

		if ( $riode_animations ) {
			return $riode_animations['appear'];
		}

		return array();
	}

	public function add_wp_widget_args( $args, $self ) {
		$args['before_widget'] = '<div class="widget ' . $self->get_widget_instance()->widget_options['classname'] . ' widget-collapsible">';
		$args['after_widget']  = '</div>';
		$args['before_title']  = '<h3 class="widget-title">';
		$args['after_title']   = '</h3>';

		return $args;
	}

	public function get_dependent_elementor_styles( $self ) {
		if ( 'file' === $self->get_meta()['status'] ) { // Re-check if it's not empty after CSS update.
			preg_match( '/post-(\d+).css/', $self->get_url(), $id );
			if ( count( $id ) == 2 ) {
				global $e_post_ids;

				wp_dequeue_style( 'elementor-post-' . $id[1] );

				wp_register_style( 'elementor-post-' . $id[1], $self->get_url(), array( 'elementor-frontend' ), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

				if ( ! isset( $e_post_ids ) ) {
					$e_post_ids = array();
				}
				$e_post_ids[] = $id[1];
			}
		}
	}

	public function add_global_css() {
		$used_blocks = function_exists( 'riode_get_layout_value' ) ? riode_get_layout_value( 'used_blocks' ) : array();
		if ( ! empty( $used_blocks ) ) {
			foreach ( $used_blocks as $block_id => $enqueued ) {
				if ( riode_is_elementor_block( $block_id ) ) {
					if ( ! wp_style_is( 'elementor-frontend' ) ) {
					wp_enqueue_style( 'elementor-icons' );
					wp_enqueue_style( 'elementor-animations' );
					wp_enqueue_style( 'elementor-frontend' );
						do_action( 'elementor/frontend/after_enqueue_styles' );
					}

					if ( isset( \Elementor\Plugin::$instance ) ) {
						// $css_file              = new Elementor\Core\Files\CSS\Post( $block_id );
						// $shortcodes_custom_css = $css_file->get_content();
						// var_dump( $shortcodes_custom_css );

						add_action(
							'wp_footer',
							function() {
								try {
									wp_enqueue_script( 'elementor-frontend' );
									$settings = \Elementor\Plugin::$instance->frontend->get_settings();
									\Elementor\Utils::print_js_config( 'elementor-frontend', 'elementorFrontendConfig', $settings );
								} catch ( Exception $e ) {
								}
							}
						);
					}

					if ( 'external' == get_option( 'elementor_css_print_method' ) ) {
			     		        $scheme_css_file = Global_CSS::create( 'global.css' );
			     		        $scheme_css_file->enqueue();
					}

					break;
				}
			}
		}

		global $e_post_ids;
		if ( is_array( $e_post_ids ) ) {
			foreach ( $e_post_ids as $id ) {
				if ( get_the_ID() != $id ) {
					wp_enqueue_style( 'elementor-post-' . $id );
				}
			}
		}
	}

	public function add_post_css() {
		if ( is_singular() ) {
			if ( 'internal' !== get_option( 'elementor_css_print_method' ) ) { // external
				wp_enqueue_style( 'elementor-post-' . intval( get_the_ID() ) );
			} elseif ( wp_style_is( 'elementor-frontend' ) ) { // internal
				$inline_styles = wp_styles()->get_data( 'elementor-frontend', 'after' );
				if ( is_array( $inline_styles ) && ! empty( $inline_styles ) ) {
					$post_css = array_pop( $inline_styles );
					if ( $post_css ) {
						wp_styles()->add_data( 'elementor-frontend', 'after', $inline_styles );
						wp_add_inline_style( 'riode-theme', $post_css );
					}
				}
			}
		}
	}

	public function add_block_css() {
		$used_blocks = function_exists( 'riode_get_layout_value' ) ? riode_get_layout_value( 'used_blocks' ) : array();
		if ( ! empty( $used_blocks ) ) {
			$upload_dir = wp_upload_dir()['basedir'];
			$upload_url = wp_upload_dir()['baseurl'];

			foreach ( $used_blocks as $block_id => $enqueued ) {
				if ( ( ! riode_is_elementor_preview() || ! isset( $_REQUEST['elementor-preview'] ) || $_REQUEST['elementor-preview'] != $block_id ) && riode_is_elementor_block( $block_id ) ) { // Check if current elementor block is editing

					$block_css = get_post_meta( (int) $block_id, 'page_css', true );
					if ( $block_css ) {
						$block_css = function_exists( 'riode_minify_css' ) ? riode_minify_css( $block_css ) : $block_css;
					}

					if ( file_exists( wp_normalize_path( $upload_dir . '/elementor/css/post-' . $block_id . '.css' ) ) ) {
						wp_enqueue_style( 'elementor-post-' . $block_id, wp_upload_dir()['baseurl'] . '/elementor/css/post-' . $block_id . '.css' );
						wp_add_inline_style( 'elementor-post-' . $block_id, apply_filters( 'riode_elementor_block_style', $block_css ) );
					}

					$riode_layout['used_blocks'][ $block_id ]['css'] = true;
				}
			}
		}
	}

	public function load_creative_layout() {
		// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification

		$mode = isset( $_POST['mode'] ) ? $_POST['mode'] : 0;

		if ( $mode ) {
			echo json_encode( riode_creative_layout( $mode ) );
		} else {
			echo json_encode( array() );
		}

		exit();

		// phpcs:enable
	}
}

new Riode_Elementor();
