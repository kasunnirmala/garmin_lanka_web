<?php
/**
 * Single Prodcut Image Render
 *
 * @since 1.1.0
 */
extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'sp_type' => '',
			'col_sp'  => 'md',
		),
		$atts
	)
);

$GLOBALS['riode_wpb_sp_image_settings'] = $atts;
$GLOBALS['riode_wpb_sp_image_settings'] = array_merge(
	$atts,
	array(
		'col_sp' => isset( $atts['col_sp'] ) ? $atts['col_sp'] : 'md',
	)
);

// Responsive columns
$GLOBALS['riode_wpb_sp_image_settings'] = array_merge( $GLOBALS['riode_wpb_sp_image_settings'], riode_wpb_convert_responsive_values( 'col_cnt', $atts, 0 ) );
if ( ! $GLOBALS['riode_wpb_sp_image_settings']['col_cnt'] ) {
	$GLOBALS['riode_wpb_sp_image_settings']['col_cnt'] = $GLOBALS['riode_wpb_sp_image_settings']['col_cnt_xl'];
}

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-sp-image-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {

	if ( ! function_exists( 'get_gallery_type' ) ) {
		function get_gallery_type() {
			global $riode_wpb_sp_image_settings;
			return isset( $riode_wpb_sp_image_settings['sp_type'] ) ? $riode_wpb_sp_image_settings['sp_type'] : 'default';
		}
	}

	if ( ! function_exists( 'riode_extend_gallery_class' ) ) {
		function riode_extend_gallery_class( $classes ) {
			global $riode_wpb_sp_image_settings;
			$single_product_layout = isset( $riode_wpb_sp_image_settings['sp_type'] ) ? $riode_wpb_sp_image_settings['sp_type'] : '';
			$classes[]             = 'pg-custom';

			if ( 'grid' == $single_product_layout || 'masonry' == $single_product_layout ) {
				$classes[] = 'grid-gallery';

				foreach ( $classes as $i => $class ) {
					if ( 'cols-sm-2' == $class ) {
						array_splice( $classes, $i, 1 );
					}
				}
				$classes[]        = riode_get_col_class( riode_elementor_grid_col_cnt( $riode_wpb_sp_image_settings ) );
				$grid_space_class = riode_elementor_grid_space_class( $riode_wpb_sp_image_settings );
				if ( $grid_space_class ) {
					$classes[] = $grid_space_class;
				}
			}

			return $classes;
		}
	}

	if ( ! function_exists( 'riode_extend_gallery_type_class' ) ) {
		function riode_extend_gallery_type_class( $class ) {
			global $riode_wpb_sp_image_settings;
			$class            = ' ' . riode_get_col_class( riode_elementor_grid_col_cnt( $riode_wpb_sp_image_settings ) );
			$grid_space_class = riode_elementor_grid_space_class( $riode_wpb_sp_image_settings );
			if ( $grid_space_class ) {
				$class .= ' ' . $grid_space_class;
			}
			return $class;
		}
	}

	if ( ! function_exists( 'riode_extend_gallery_type_attr' ) ) {
		function riode_extend_gallery_type_attr( $attr ) {
			global $riode_wpb_sp_image_settings;
			$riode_wpb_sp_image_settings['show_nav']         = 'yes';
			$riode_wpb_sp_image_settings['show_dots_tablet'] = '';
			$attr .= ' data-owl-options=' . esc_attr(
				json_encode(
					riode_get_slider_attrs( $riode_wpb_sp_image_settings, riode_elementor_grid_col_cnt( $riode_wpb_sp_image_settings ) )
				)
			);
			return $attr;
		}
	}

	add_filter( 'riode_single_product_layout', 'get_gallery_type', 99 );
	add_filter( 'riode_single_product_gallery_main_classes', 'riode_extend_gallery_class', 20 );
	if ( 'gallery' == $sp_type ) {
		add_filter( 'riode_single_product_gallery_type_class', 'riode_extend_gallery_type_class' );
		add_filter( 'riode_single_product_gallery_type_attr', 'riode_extend_gallery_type_attr' );
	}

	woocommerce_show_product_images();

	remove_filter( 'riode_single_product_layout', 'get_gallery_type', 99 );
	remove_filter( 'riode_single_product_gallery_main_classes', 'riode_extend_gallery_class', 20 );
	if ( 'gallery' == $sp_type ) {
		remove_filter( 'riode_single_product_gallery_type_class', 'riode_extend_gallery_type_class' );
		remove_filter( 'riode_single_product_gallery_type_attr', 'riode_extend_gallery_type_attr' );
	}

	do_action( 'riode_single_product_builder_unset_product' );
}
?>
</div>
<?php
