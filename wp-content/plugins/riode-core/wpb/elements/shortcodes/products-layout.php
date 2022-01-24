<?php
/**
 * Riode Products Layout Shortcode
 *
 * - products + banner
 * - products + single product
 *
 * @since 1.1.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' )          => array(
		'riode_wpb_products_select_controls',
	),
	esc_html__( 'Layout', 'riode-core' )           => array(
		'riode_wpb_products_layout_controls',
	),
	esc_html__( 'Type', 'riode-core' )             => array(
		'riode_wpb_product_type_controls',
	),
	esc_html__( 'Style', 'riode-core' )            => array(
		'riode_wpb_product_style_controls',
	),
	esc_html__( 'Carousel Options', 'riode-core' ) => array(
		esc_html__( 'Options', 'riode-core' ) => array(
			'riode_wpb_slider_general_controls',
		),
		esc_html__( 'Nav', 'riode-core' )     => array(
			'riode_wpb_slider_nav_controls',
		),
		esc_html__( 'Dots', 'riode-core' )    => array(
			'riode_wpb_slider_dots_controls',
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params, 'wpb_riode_products_layout' ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Products Layout', 'riode-core' ),
		'base'            => 'wpb_riode_products_layout',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_products_layout',
		'as_parent'       => array( 'only' => 'wpb_riode_products_banner_item, wpb_riode_products_single_item' ),
		'content_element' => true,
		'controls'        => 'full',
		'js_view'         => 'VcColumnView',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Group with products, banner and single product', 'riode-core' ),
		'params'          => $params,
		'default_content' => '[wpb_riode_products_banner_item item_no="1" full_screen="" effect_duration="30" creative_item_heading="" bg_color="#2277cc"][wpb_riode_banner_layer banner_origin="t-m" layer_pos="{``top``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``50%``},``right``:{``xl``:``5%``,``xs``:````,``sm``:````,``md``:````,``lg``:````},``bottom``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:````},``left``:{``xs``:````,``sm``:````,``md``:````,``lg``:````,``xl``:``5%``}}" layer_width="{``xl``:``90``,``unit``:``%``,``xs``:````,``sm``:````,``md``:````,``lg``:````}" layer_height="{``xl``:````,``unit``:``px``,``xs``:````,``sm``:````,``md``:````,``lg``:````}"][wpb_riode_heading heading_title="QSUyMFNpbXBsZSUyMEJhbm5lcg==" html_tag="h3" decoration="simple" title_align="title-center" link_align="link-left" extra_class="mb-4" title_color="#ffffff"][wpb_riode_heading heading_title="TG9yZW0lMjBpcHN1bSUyMGRvbG9yJTIwc2l0JTIwYW1ldCUyQyUyMGNvbnNlY3RldHVlciUyMGFkaXBpc2NpbmclMjBlbGl0JTJDJTIwc2VkJTIwZGlhbSUyMG5vbnVtbXklMjBuaWJoJTIw" html_tag="p" decoration="simple" title_align="title-center" link_align="link-left" title_color="#ffffff" title_typography="{``family``:``Default``,``variant``:``Default``,``size``:``14px``,``line_height``:````,``letter_spacing``:````,``text_transform``:``none``}"][/wpb_riode_banner_layer][/wpb_riode_products_banner_item]',
	)
);

// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_products_layout_categories_callback', 'riode_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_products_layout_categories_render', 'riode_wpb_shortcode_product_category_id_render', 10, 1 );

// Product Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_products_layout_product_ids_callback', 'riode_wpb_shortcode_product_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_products_layout_product_ids_render', 'riode_wpb_shortcode_product_id_render', 10, 1 );
add_filter( 'vc_form_fields_render_field_wpb_riode_products_layout_product_ids_param_value', 'riode_wpb_shortcode_product_id_param_value', 10, 4 );

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_WPB_Riode_Products_Layout extends WPBakeryShortCodesContainer {
	}
}
