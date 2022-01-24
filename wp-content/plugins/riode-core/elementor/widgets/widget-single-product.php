<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Single Product Widget
 *
 * Riode Widget to display products.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;

class Riode_Single_Product_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_single_product';
	}

	public function get_title() {
		return esc_html__( 'Single Product', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-single-product';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'product', 'flipbook', 'lookbook', 'carousel', 'slider', 'shop', 'woocommerce' );
	}

	public function get_style_depends() {
		return array( 'riode-theme-single-product' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( riode_is_elementor_preview() ) {
			$depends[] = 'riode-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		riode_elementor_products_select_controls( $this );

		$this->start_controls_section(
			'section_single_product',
			array(
				'label' => esc_html__( 'Single Product', 'riode-core' ),
			)
		);

			$this->add_control(
				'sp_title_tag',
				array(
					'label'       => esc_html__( 'Title Tag', 'riode-core' ),
					'description' => esc_html__( 'Choose product name’s tag: H1, H2, H3, H4, H5, H6.', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'options'     => array(
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
					),
					'default'     => 'h2',
				)
			);

			$this->add_control(
				'sp_gallery_type',
				array(
					'label'       => esc_html__( 'Gallery Type', 'riode-core' ),
					'description' => esc_html__( 'Choose single product gallery type from 7 presets.', 'riode-core' ),
					'type'        => 'riode_image_choose',
					'default'     => '',
					'width'       => 'full',
					'options'     => array(
						''           => riode_get_customize_dir() . '/single-product/default.jpg',
						'default'    => riode_get_customize_dir() . '/single-product/vertical.jpg',
						'horizontal' => riode_get_customize_dir() . '/single-product/horizontal.jpg',
						'grid'       => riode_get_customize_dir() . '/single-product/grid.jpg',
						'masonry'    => riode_get_customize_dir() . '/single-product/masonry.jpg',
						'gallery'    => riode_get_customize_dir() . '/single-product/gallery.jpg',
						'rotate'     => riode_get_customize_dir() . '/single-product/rotate.jpg',
					),
				)
			);

			$this->add_control(
				'sp_sales_type',
				array(
					'label'       => esc_html__( 'Sales Type', 'riode-core' ),
					'description' => esc_html__( 'Choose position of sale countdown: In Summary, In Gallery.', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '',
					'options'     => array(
						''        => esc_html__( 'In Summary', 'riode-core' ),
						'gallery' => esc_html__( 'In Gallery', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'sp_sales_label',
				array(
					'type'        => Controls_Manager::TEXT,
					'label'       => esc_html__( 'Sales Label', 'riode-core' ),
					'description' => esc_html__( 'Controls sale countdown label.', 'riode-core' ),
					'placeholder' => esc_html__( 'Flash Deals', 'riode-core' ),
				)
			);

			$this->add_control(
				'sp_vertical',
				array(
					'label'       => esc_html__( 'Show Vertical', 'riode-core' ),
					'description' => esc_html__( 'Choose to show single product vertically.', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'sp_gallery_type!' => 'gallery',
					),
				)
			);

			$this->add_control(
				'sp_show_in_box',
				array(
					'label'       => esc_html__( 'Show In Box', 'riode-core' ),
					'description' => esc_html__( 'Choose to show outline border around single product.', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
				)
			);

			$this->add_control(
				'sp_show_info',
				array(
					'type'        => Controls_Manager::SELECT2,
					'label'       => esc_html__( 'Show Information', 'riode-core' ),
					'description' => esc_html__( 'Choose to show information of product: Category, Label, Price, Rating, Attribute, Cart, Compare, Quick view, Wishlist, Excerpt.', 'riode-core' ),
					'multiple'    => true,
					'default'     => array( 'gallery', 'title', 'meta', 'price', 'rating', 'excerpt', 'addtocart_form', 'share', 'wishlist', 'compare', 'divider' ),
					'options'     => array(
						'gallery'        => esc_html__( 'Gallery', 'riode-core' ),
						'title'          => esc_html__( 'Title', 'riode-core' ),
						'meta'           => esc_html__( 'Meta', 'riode-core' ),
						'price'          => esc_html__( 'Price', 'riode-core' ),
						'rating'         => esc_html__( 'Rating', 'riode-core' ),
						'excerpt'        => esc_html__( 'Description', 'riode-core' ),
						'addtocart_form' => esc_html__( 'Add To Cart Form', 'riode-core' ),
						'divider'        => esc_html__( 'Divider In Cart Form', 'riode-core' ),
						'share'          => esc_html__( 'Share', 'riode-core' ),
						'wishlist'       => esc_html__( 'Wishlist', 'riode-core' ),
						'compare'        => esc_html__( 'Compare', 'riode-core' ),
					),
				)
			);

			$this->add_responsive_control(
				'sp_col_cnt',
				array(
					'type'        => Controls_Manager::SELECT,
					'label'       => esc_html__( 'Columns', 'riode-core' ),
					'description' => esc_html__( 'Controls number of columns to display gallery.', 'riode-core' ),
					'options'     => array(
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
					'condition'   => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_cnt_xl',
				array(
					'label'       => esc_html__( 'Columns ( >= 1200px )', 'riode-core' ),
					'description' => esc_html__( 'Select number of columns to display gallery on large display( >= 1200px ).', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'options'     => array(
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
					'condition'   => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_cnt_min',
				array(
					'label'       => esc_html__( 'Columns ( < 576px )', 'riode-core' ),
					'description' => esc_html__( 'Select number of columns to display gallery on mobile( < 576px ).', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'options'     => array(
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
					'condition'   => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

			$this->add_control(
				'sp_col_sp',
				array(
					'label'       => esc_html__( 'Spacing', 'riode-core' ),
					'description' => esc_html__( 'Controls amount of spacing between columns.', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'md',
					'options'     => array(
						'no' => esc_html__( 'No space', 'riode-core' ),
						'xs' => esc_html__( 'Extra Small', 'riode-core' ),
						'sm' => esc_html__( 'Small', 'riode-core' ),
						'md' => esc_html__( 'Medium', 'riode-core' ),
						'lg' => esc_html__( 'Large', 'riode-core' ),
					),
					'condition'   => array(
						'sp_gallery_type' => array( 'grid', 'masonry', 'gallery' ),
					),
				)
			);

		$this->end_controls_section();

		riode_elementor_single_product_style_controls( $this );

		riode_elementor_slider_style_controls(
			$this,
			'',
			array(
				'show_dots' => true,
				'show_nav'  => true,
			)
		);
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
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-single-product-render.php';
	}

	protected function content_template() {}
}
