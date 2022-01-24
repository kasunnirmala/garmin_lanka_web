<?php
/**
 * Riode Elementor Single Product Image Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

class Riode_Single_Product_Image_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_sproduct_image';
	}

	public function get_title() {
		return esc_html__( 'Product Images', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-product-images';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'image', 'thumbnail', 'gallery' );
	}

	public function get_script_depends() {
		$depends = array( 'owl-carousel', 'isotope-pkgd' );
		if ( riode_is_elementor_preview() ) {
			$depends[] = 'riode-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_product_gallery_content',
			array(
				'label' => esc_html__( 'Content', 'riode-core' ),
			)
		);

			$this->add_control(
				'sp_type',
				array(
					'label'   => esc_html__( 'Gallery Type', 'riode-core' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => array(
						'default'    => esc_html__( 'Default', 'riode-core' ),
						'horizontal' => esc_html__( 'Horizontal', 'riode-core' ),
						'grid'       => esc_html__( 'Grid', 'riode-core' ),
						'masonry'    => esc_html__( 'Masonry', 'riode-core' ),
						'gallery'    => esc_html__( 'Gallery', 'riode-core' ),
					),
				)
			);

			$this->add_responsive_control(
				'col_cnt',
				array(
					'type'      => Controls_Manager::SELECT,
					'label'     => esc_html__( 'Columns', 'riode-core' ),
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'riode-core' ),
					),
					'condition' => array(
						'sp_type' => array( 'grid', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_cnt_xl',
				array(
					'label'     => esc_html__( 'Columns ( >= 1200px )', 'riode-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'riode-core' ),
					),
					'condition' => array(
						'sp_type' => array( 'grid', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_cnt_min',
				array(
					'label'     => esc_html__( 'Columns ( < 576px )', 'riode-core' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
						'7' => 7,
						'8' => 8,
						''  => esc_html__( 'Default', 'riode-core' ),
					),
					'condition' => array(
						'sp_type' => array( 'grid', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'col_sp',
				array(
					'label'     => esc_html__( 'Spacing', 'riode-core' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'md',
					'options'   => array(
						'no' => esc_html__( 'No space', 'riode-core' ),
						'xs' => esc_html__( 'Extra Small', 'riode-core' ),
						'sm' => esc_html__( 'Small', 'riode-core' ),
						'md' => esc_html__( 'Medium', 'riode-core' ),
						'lg' => esc_html__( 'Large', 'riode-core' ),
					),
					'condition' => array(
						'sp_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

		$this->end_controls_section();
	}

	public function get_gallery_type() {
		return $this->get_settings_for_display( 'sp_type' );
	}

	public function extend_gallery_class( $classes ) {
		$settings              = $this->get_settings_for_display();
		$single_product_layout = $settings['sp_type'];
		$classes[]             = 'pg-custom';

		if ( 'grid' == $single_product_layout || 'masonry' == $single_product_layout ) {
			$classes[] = 'grid-gallery';

			foreach ( $classes as $i => $class ) {
				if ( 'cols-sm-2' == $class ) {
					array_splice( $classes, $i, 1 );
				}
			}
			$classes[]        = riode_get_col_class( riode_elementor_grid_col_cnt( $settings ) );
			$grid_space_class = riode_elementor_grid_space_class( $settings );
			if ( $grid_space_class ) {
				$classes[] = $grid_space_class;
			}
		}

		return $classes;
	}

	public function extend_gallery_type_class( $class ) {
		$settings         = $this->get_settings_for_display();
		$class            = ' ' . riode_get_col_class( riode_elementor_grid_col_cnt( $settings ) );
		$grid_space_class = riode_elementor_grid_space_class( $settings );
		if ( $grid_space_class ) {
			$class .= ' ' . $grid_space_class;
		}
		return $class;
	}

	public function extend_gallery_type_attr( $attr ) {
		$settings                     = $this->get_settings_for_display();
		$settings['show_nav']         = 'yes';
		$settings['show_dots_tablet'] = '';
		$attr                        .= ' data-owl-options=' . esc_attr(
			json_encode(
				riode_get_slider_attrs( $settings, riode_elementor_grid_col_cnt( $settings ) )
			)
		);
		return $attr;
	}

	public function before_render() {
		// Add `elementor-widget-theme-post-content` class to avoid conflicts that figure gets zero margin.
		$this->add_render_attribute(
			array(
				'_wrapper' => array(
					'class' => 'elementor-widget-theme-post-content',
				),
			)
		);

		parent::before_render();
	}

	protected function render() {

		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
			$sp_type = $this->get_settings_for_display( 'sp_type' );

			add_filter( 'riode_single_product_layout', array( $this, 'get_gallery_type' ), 99 );
			add_filter( 'riode_single_product_gallery_main_classes', array( $this, 'extend_gallery_class' ), 20 );
			if ( 'gallery' == $sp_type ) {
				add_filter( 'riode_single_product_gallery_type_class', array( $this, 'extend_gallery_type_class' ) );
				add_filter( 'riode_single_product_gallery_type_attr', array( $this, 'extend_gallery_type_attr' ) );
			}

			woocommerce_show_product_images();

			remove_filter( 'riode_single_product_layout', array( $this, 'get_gallery_type' ), 99 );
			remove_filter( 'riode_single_product_gallery_main_classes', array( $this, 'extend_gallery_class' ), 20 );
			if ( 'gallery' == $sp_type ) {
				remove_filter( 'riode_single_product_gallery_type_class', array( $this, 'extend_gallery_type_class' ) );
				remove_filter( 'riode_single_product_gallery_type_attr', array( $this, 'extend_gallery_type_attr' ) );
			}

			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
