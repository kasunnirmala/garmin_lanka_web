<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Categories Widget Render
 *
 */

// Category Type Options
$cat_options = array(
	''             => array(
		'link'  => '',
		'count' => '',
	),
	'badge'        => array(
		'link'  => 'yes',
		'count' => '',
	),
	'banner'       => array(
		'link'  => 'yes',
		'count' => 'yes',
	),
	'label'        => array(
		'link'  => '',
		'count' => '',
	),
	'icon'         => array(
		'link'  => '',
		'count' => '',
	),
	'classic'      => array(
		'link'  => '',
		'count' => 'yes',
	),
	'ellipse'      => array(
		'link'  => '',
		'count' => 'yes',
	),
	'ellipse-2'    => array(
		'link'  => '',
		'count' => '',
	),
	'icon-overlay' => array(
		'link'  => '',
		'count' => 'yes',
	),
	'group'        => array(
		'link'  => '',
		'count' => '',
	),
	'group-2'      => array(
		'link'  => '',
		'count' => '',
	),
	'center'       => array(
		'link'  => '',
		'count' => '',
	),
	'simple'       => array(
		'link'  => '',
		'count' => 'yes',
	),
);

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Categories Selector
			'category_ids'               => array(),
			'run_as_filter'              => '',
			'show_subcategories'         => '',
			'hide_empty'                 => '',
			'count'                      => array( 'size' => 4 ),
			'orderby'                    => 'name',
			'orderway'                   => '',

			// Categories Layout
			'layout_type'                => 'grid',
			'col_sp'                     => '',
			'col_cnt'                    => array( 'size' => 4 ),
			'creative_mode'              => 1,
			'creative_height'            => array( 'size' => 600 ),
			'creative_height_ratio'      => array( 'size' => 75 ),
			'grid_float'                 => '',
			'thumbnail_size'             => 'woocommerce_thumbnail',
			'thumbnail_custom_dimension' => '',

			// Category Type
			'follow_theme_option'        => '',
			'category_type'              => '',
			'subcat_cnt'                 => 6,
			'default_width_auto'         => '',
			'show_icon'                  => '',
			'overlay'                    => '',
			'link_text'                  => esc_html__( 'Shop Now', 'riode-core' ),
			'content_align'              => '',
			'content_origin'             => '',
			'hover_effect'               => '',
			'page_builder'               => '',
			'wrapper_id'                 => '',
		),
		$atts
	)
);

// Get Count
if ( ! is_array( $count ) ) {
	$count = json_decode( $count, true );
}

if ( ! is_array( $col_cnt ) ) {
	$col_cnt = json_decode( $col_cnt, true );
}
if ( ! is_array( $creative_height ) ) {
	$creative_height = json_decode( $creative_height, true );
}
if ( ! is_array( $creative_height_ratio ) ) {
	$creative_height_ratio = json_decode( $creative_height_ratio, true );
}
if ( $category_ids && ! is_array( $category_ids ) ) {
	$category_ids = explode( ',', $category_ids );
}

if ( isset( $count['size'] ) ) {
	$count = (int) $count['size'];
}

// Setup filter
if ( $run_as_filter ) {
	wc_set_loop_prop( 'run_as_filter', true );
}

// Wrapper classes & attributes
$wrapper_class = array();
$wrapper_attrs = '';

$grid_space_class = riode_elementor_grid_space_class( $atts );
if ( $grid_space_class ) {
	$wrapper_class[] = $grid_space_class;
}

$col_cnt = riode_elementor_grid_col_cnt( $atts );

if ( 'slider' === $layout_type ) {
	do_action( 'riode_save_used_widget', 'slider' );

	$wrapper_class[] = riode_get_slider_class( $atts );

	$wrapper_attrs .= ' data-plugin="owl" data-owl-options=' . esc_attr(
		json_encode(
			riode_get_slider_attrs( $atts, $col_cnt )
		)
	);
}

if ( 'creative' == $layout_type ) {
	wp_enqueue_script( 'isotope-pkgd' );

	$wrapper_class[] = 'grid';
	$wrapper_class[] = 'creative-grid';
	$wrapper_class[] = 'grid-mode-' . $creative_mode;
	if ( $grid_float ) {
		$wrapper_class[] = 'grid-float';
	}

	$wrapper_attrs .= ' data-plugin="isotope"';

	$creative_layout = riode_creative_layout( $creative_mode );
	if ( 'wpb' == $page_builder ) {
		riode_creative_layout_style(
			'.' . str_replace( ' ', '', $shortcode_class ),
			$creative_layout,
			$creative_height['size'] ? $creative_height['size'] : 600,
			$creative_height_ratio['size'] ? $creative_height_ratio['size'] : 75
		);
	} else {
		riode_creative_layout_style(
			'.elementor-element-' . $this->get_data( 'id' ),
			$creative_layout,
			$creative_height['size'] ? $creative_height['size'] : 600,
			$creative_height_ratio['size'] ? $creative_height_ratio['size'] : 75
		);
	}
	$count = count( $creative_layout );
	wc_set_loop_prop( 'creative_idx', 0 );
	wc_set_loop_prop( 'creative_mode', $creative_mode );
} else {
	wc_set_loop_prop( 'col_cnt', $col_cnt );
}

wc_set_loop_prop( 'widget', 'product-category-group' );
wc_set_loop_prop( 'layout_type', $layout_type );
wc_set_loop_prop( 'col_sp', $col_sp );
wc_set_loop_prop( 'thumbnail_size', $thumbnail_size );
if ( 'custom' == $thumbnail_size && $thumbnail_custom_dimension ) {
	wc_set_loop_prop( 'thumbnail_custom_size', $thumbnail_custom_dimension );
}
wc_set_loop_prop( 'wrapper_class', $wrapper_class );
wc_set_loop_prop( 'wrapper_attrs', $wrapper_attrs );

// Props

// Preprocess
if ( 'any' != $cat_options[ $category_type ]['count'] ) {
	$show_count = $cat_options[ $category_type ]['count'];
}
if ( 'any' != $cat_options[ $category_type ]['link'] ) {
	$show_link = $cat_options[ $category_type ]['link'];
}

if ( ! $follow_theme_option ) {
	$props = array(
		'category_type'  => $category_type,
		'content_origin' => $content_origin,
		'overlay'        => $overlay,
		'hover_effect'   => $hover_effect,
		'show_count'     => 'yes' == $show_count,
		'show_link'      => 'yes' == $show_link,
	);
	if ( ( 'group' == $category_type || 'group-2' == $category_type ) && 'yes' == $show_icon || 'icon' == $category_type ) {
		$props['show_icon'] = true;
	}
	if ( 'group' == $category_type || 'group-2' == $category_type ) {
		$props['subcat_cnt'] = '' === $subcat_cnt ? 6 : $subcat_cnt;
	}
	if ( 'yes' == $show_link ) {
		$props['link_text'] = $link_text;
	}
} else {
	wc_set_loop_prop( 'follow_theme_option', 'yes' );
	$props = array();
}
$props['content_align']      = $content_align;
$props['default_width_auto'] = $default_width_auto;

foreach ( $props as $key => $prop ) {
	wc_set_loop_prop( $key, $prop );
}

// Extra Atts

$extra_atts  = '';
$extra_atts .= ' number="' . $count . '"';
$extra_atts .= ' columns="' . $col_cnt['lg'] . '"';
$extra_atts .= ' hide_empty="' . ( 'yes' == $hide_empty ) . '"';

if ( is_array( $category_ids ) && count( $category_ids ) ) {
	if ( $show_subcategories ) {
		$sub_ids = array();

		foreach ( $category_ids as $cat_id ) {
			if ( is_numeric( $cat_id ) ) {
				$terms = get_terms(
					array(
						'taxonomy'   => 'product_cat',
						'hide_empty' => boolval( $hide_empty ),
						'parent'     => (int) $cat_id,
					)
				);
				foreach ( $terms as $term_cat ) {
					$sub_ids[] = $term_cat->term_id;
				}
			}
		}

		$category_ids = $sub_ids;
		$extra_atts  .= ' orderby="' . esc_attr( $orderby ) . '"';
		$extra_atts  .= ' order="' . esc_attr( $orderway ) . '"';
	} else {
		$extra_atts .= ' orderby="include"  order="ASC"';
	}

	if ( empty( $category_ids ) ) {
		echo '<p>' . esc_html__( 'There are no subcategories of current categories.', 'riode-core' ) . '</p>';
		return;
	}

	$extra_atts .= ' ids="' . esc_attr( implode( ',', $category_ids ) ) . '"'; //'" orderby="include" order="ASC"';
} else {
	$extra_atts .= ' orderby="' . esc_attr( $orderby ) . '"';
	$extra_atts .= ' order="' . esc_attr( $orderway ) . '"';
}

// Do Shortcode
echo do_shortcode( '[product_categories' . $extra_atts . ']' );
