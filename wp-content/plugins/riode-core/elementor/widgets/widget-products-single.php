<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Products Widget
 *
 * Riode Widget to display products.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Riode_Products_Single_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_products_single';
	}

	public function get_title() {
		return esc_html__( 'Products + Single', 'riode-core' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce', 'banner' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-products-single';
	}

	public function get_style_depends() {
		return array( 'riode-theme-single-product' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_products_layout',
			array(
				'label' => esc_html__( 'Products Layout', 'riode-core' ),
			)
		);

		$this->add_responsive_control(
			'creative_cols',
			array(
				'type'           => Controls_Manager::SLIDER,
				'label'          => esc_html__( 'Columns', 'riode-core' ),
				'description'    => esc_html__( 'Controls number of columns to display.', 'riode-core' ),
				'default'        => array(
					'size' => 4,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 3,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 2,
					'unit' => 'px',
				),
				'size_units'     => array(
					'px',
				),
				'range'          => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 60,
					),
				),
				'selectors'      => array(
					'.elementor-element-{{ID}} .product-grid' => 'grid-template-columns: repeat(auto-fill, calc(100% / {{SIZE}}))',
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_no',
			array(
				'label'       => esc_html__( 'Item Number', 'riode-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Blank for all items.', 'riode-core' ),
				'description' => esc_html__( 'Choose item number to control creative items.', 'riode-core' ),
			)
		);

		$repeater->add_responsive_control(
			'item_col_pan',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Column Size', 'riode-core' ),
				'description' => esc_html__( 'Controls selected item\'s column size.', 'riode-core' ),
				'default'     => array(
					'size' => 1,
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 12,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-column-end: span {{SIZE}}',
				),
			)
		);

		$repeater->add_responsive_control(
			'item_row_pan',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Row Size', 'riode-core' ),
				'description' => esc_html__( 'Controls selected item\'s row size.', 'riode-core' ),
				'default'     => array(
					'size' => 1,
					'unit' => 'px',
				),
				'size_units'  => array(
					'px',
				),
				'range'       => array(
					'px' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 8,
					),
				),
				'selectors'   => array(
					'.elementor-element-{{ID}} {{CURRENT_ITEM}}' => 'grid-row-end: span {{SIZE}}',
				),
			)
		);

		$repeater->add_control(
			'item_custom_product_type',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Custom Product Type', 'riode-core' ),
				'description' => esc_html__( 'Choose whether to control selected item\'s product type', 'riode-core' ),
				'condition'   => array(
					'item_no!' => '',
				),
			)
		);

		$repeater->add_control(
			'item_product_type',
			array(
				'label'       => esc_html__( 'Product Type', 'riode-core' ),
				'description' => esc_html__( 'Choose from 4 default types: Default, Classic, List, Widget.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''        => esc_html__( 'Default', 'riode-core' ),
					'classic' => esc_html__( 'Classic', 'riode-core' ),
					'list'    => esc_html__( 'List', 'riode-core' ),
					'widget'  => esc_html__( 'Widget', 'riode-core' ),
				),
				'condition'   => array(
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_classic_hover',
			array(
				'label'       => esc_html__( 'Hover Effect', 'riode-core' ),
				'description' => esc_html__( 'Choose content’s hover effect from: Default, Popup, Slide-up. ', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''        => esc_html__( 'Default', 'riode-core' ),
					'popup'   => esc_html__( 'Popup', 'riode-core' ),
					'slideup' => esc_html__( 'Slide Up', 'riode-core' ),
				),
				'condition'   => array(
					'item_no!'                 => '',
					'item_product_type'        => 'classic',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_show_info',
			array(
				'type'        => Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Show Information', 'riode-core' ),
				'description' => esc_html__( 'Choose to show information of product: Category, Label, Price, Rating, Attribute, Cart, Compare, Quick view, Wishlist, Excerpt.', 'riode-core' ),
				'multiple'    => true,
				'default'     => array(
					'category',
					'label',
					'price',
					'rating',
					'addtocart',
					'compare',
					'quickview',
					'wishlist',
				),
				'options'     => array(
					'category'   => esc_html__( 'Category', 'riode-core' ),
					'label'      => esc_html__( 'Label', 'riode-core' ),
					'price'      => esc_html__( 'Price', 'riode-core' ),
					'rating'     => esc_html__( 'Rating', 'riode-core' ),
					'attribute'  => esc_html__( 'Attribute', 'riode-core' ),
					'addtocart'  => esc_html__( 'Add To Cart', 'riode-core' ),
					'compare'    => esc_html__( 'Compare', 'riode-core' ),
					'quickview'  => esc_html__( 'Quickview', 'riode-core' ),
					'wishlist'   => esc_html__( 'Wishlist', 'riode-core' ),
					'short_desc' => esc_html__( 'Short Description', 'riode-core' ),
				),
				'condition'   => array(
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_show_labels',
			array(
				'type'        => Controls_Manager::SELECT2,
				'label'       => esc_html__( 'Show Labels', 'riode-core' ),
				'description' => esc_html__( 'Select to show product labels on left part of product thumbnail: Top, Sale, New, Out of Stock, Custom labels.', 'riode-core' ),
				'multiple'    => true,
				'default'     => array(
					'top',
					'sale',
					'new',
					'stock',
				),
				'options'     => array(
					'top'   => esc_html__( 'Top', 'riode-core' ),
					'sale'  => esc_html__( 'Sale', 'riode-core' ),
					'new'   => esc_html__( 'New', 'riode-core' ),
					'stock' => esc_html__( 'Stock', 'riode-core' ),
				),
				'condition'   => array(
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_addtocart_pos',
			array(
				'label'       => esc_html__( 'Add to Cart Pos', 'riode-core' ),
				'description' => esc_html__( 'Choose cart position from: Top, Bottom, 100% fullwidth, With quantity input. ', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''              => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom'        => esc_html__( 'On bottom of the image', 'riode-core' ),
					'detail_bottom' => esc_html__( '100% full width', 'riode-core' ),
					'with_qty'      => esc_html__( 'with QTY input', 'riode-core' ),
					'hide'          => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition'   => array(
					'item_product_type'        => '',
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_quickview_pos',
			array(
				'label'       => esc_html__( 'Quickview Pos', 'riode-core' ),
				'description' => esc_html__( 'Choose quickview position from: Top, Bottom.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'bottom',
				'options'     => array(
					''       => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom' => esc_html__( 'On bottom of the image', 'riode-core' ),
					'hide'   => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition'   => array(
					'item_product_type'        => '',
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_wishlist_pos',
			array(
				'label'       => esc_html__( 'Add to wishlist Pos', 'riode-core' ),
				'description' => esc_html__( 'Choose wishlist position from: Top, Under.', 'riode-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''       => esc_html__( 'On top of the image', 'riode-core' ),
					'bottom' => esc_html__( 'Under the image', 'riode-core' ),
					'hide'   => esc_html__( 'Don\'t show', 'riode-core' ),
				),
				'condition'   => array(
					'item_product_type'        => '',
					'item_no!'                 => '',
					'item_custom_product_type' => 'yes',
				),
			)
		);

		$this->add_control(
			'items_list',
			array(
				'label'       => esc_html__( "Customize each grid item's layout", 'riode-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_no'       => '',
						'item_col_pan'  => array(
							'size' => 1,
							'unit' => 'px',
						),
						'item_row_span' => array(
							'size' => 1,
							'unit' => 'px',
						),
					),
					array(
						'item_no'       => 1,
						'item_col_pan'  => array(
							'size' => 2,
							'unit' => 'px',
						),
						'item_row_span' => array(
							'size' => 2,
							'unit' => 'px',
						),
					),
				),
				'title_field' => sprintf( '{{{ item_no ? \'%1$s\' : \'%2$s\' }}}' . ' <strong>{{{ item_no }}}</strong>', esc_html__( 'Index', 'riode-core' ), esc_html__( 'Base', 'riode-core' ) ),
			)
		);

		$this->add_control(
			'col_sp',
			array(
				'label'       => esc_html__( 'Columns Spacing', 'riode-core' ),
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
			)
		);

		$this->add_responsive_control(
			'creative_auto_height',
			array(
				'type'        => Controls_Manager::SWITCHER,
				'label'       => esc_html__( 'Auto Row Height', 'riode-core' ),
				'description' => esc_html__( 'Make base creative grid item’s height to their own.', 'riode-core' ),
				'selectors'   => array(
					'.elementor-element-{{ID}} .product-grid' => 'grid-auto-rows: auto',
				),
			)
		);

		riode_elementor_loadmore_layout_controls( $this, 'layout_type' );

			$this->add_control(
				'large_thumbnail_heading',
				array(
					'label' => esc_html__( 'Product Image Size for Large grid areas', 'riode-core' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'    => 'large_thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`
					'label'   => esc_html__( 'Large Image Size', 'riode-core' ),
					'default' => 'woocommerce_single',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_single_product',
			array(
				'label' => esc_html__( 'Single Product', 'riode-core' ),
			)
		);

			$this->add_control(
				'sp_id',
				array(
					'label'       => esc_html__( 'Product ID or Slug', 'riode-core' ),
					'type'        => 'riode_ajaxselect2',
					'description' => esc_html__( 'If this field is empty, it displays below index of user-selected products as single product.', 'riode-core' ),
					'object_type' => 'product',
					'label_block' => true,
				)
			);

			$this->add_control(
				'sp_insert',
				array(
					'label'       => esc_html__( 'Insert number', 'riode-core' ),
					'description' => esc_html__( 'Choose insert position index of single product item.', 'riode-core' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => '1',
				)
			);

			$this->add_control(
				'sp_title_tag',
				array(
					'label'       => esc_html__( 'Title Tag', 'elementor' ),
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
					'default'     => 'yes',
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

		riode_elementor_products_select_controls( $this );

		riode_elementor_product_type_controls( $this );

		riode_elementor_single_product_style_controls( $this );

		riode_elementor_slider_style_controls( $this, 'layout_type' );

		riode_elementor_product_style_controls( $this );
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-products-single-render.php';
	}

	protected function content_template() {}
}
