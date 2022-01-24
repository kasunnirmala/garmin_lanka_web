<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Default Theme Options
 */

global $riode_social_name;
global $riode_social_icon;
$riode_social_name = array(
	'facebook'  => esc_html__( 'Facebook', 'riode' ),
	'twitter'   => esc_html__( 'Twitter', 'riode' ),
	'linkedin'  => esc_html__( 'Linkedin', 'riode' ),
	'email'     => esc_html__( 'Email', 'riode' ),
	'google'    => esc_html__( 'Google +', 'riode' ),
	'pinterest' => esc_html__( 'Pinterest', 'riode' ),
	'reddit'    => esc_html__( 'Reddit', 'riode' ),
	'tumblr'    => esc_html__( 'Tumblr', 'riode' ),
	'vk'        => esc_html__( 'VK', 'riode' ),
	'whatsapp'  => esc_html__( 'WhatsApp', 'riode' ),
	'xing'      => esc_html__( 'Xing', 'riode' ),
	'instagram' => esc_html__( 'Instagram', 'riode' ),
	'youtube'   => esc_html__( 'Youtube', 'riode' ),
	'tiktok'    => esc_html__( 'Tiktok', 'riode' ),
	'wechat'    => esc_html__( 'WeChat', 'riode' ),
);
$riode_social_icon = array(
	'facebook'  => array( 'fab fa-facebook-f', 'https://www.facebook.com/sharer.php?u=$permalink' ),
	'twitter'   => array( 'fab fa-twitter', 'https://twitter.com/intent/tweet?text=$title&amp;url=$permalink' ),
	'linkedin'  => array( 'fab fa-linkedin-in', 'https://www.linkedin.com/shareArticle?mini=true&amp;url=$permalink&amp;title=$title' ),
	'email'     => array( 'far fa-envelope', 'mailto:?subject=$title&amp;body=$permalink' ),
	'google'    => array( 'fab fa-google-plus-g', '' ),
	'pinterest' => array( 'fab fa-pinterest-p', 'https://pinterest.com/pin/create/button/?url=$permalink&amp;media=$image' ),
	'reddit'    => array( 'fab fa-reddit-alien', 'http://www.reddit.com/submit?url=$permalink&amp;title=$title' ),
	'tumblr'    => array( 'fab fa-tumblr', 'http://www.tumblr.com/share/link?url=$permalink&amp;name=$title&amp;description=$excerpt' ),
	'vk'        => array( 'fab fa-vk', 'https://vk.com/share.php?url=$permalink&amp;title=$title&amp;image=$image&amp;noparse=true' ),
	'whatsapp'  => array( 'fab fa-whatsapp', 'whatsapp://send?text=$title - $permalink' ),
	'xing'      => array( 'fab fa-xing', 'https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=$permalink' ),
	'instagram' => array( 'fab fa-instagram', '' ),
	'youtube'   => array( 'fab fa-youtube', '' ),
	'tiktok'    => array( 'fab fa-tiktok', '' ),
	'wechat'    => array( 'fab fa-weixin', '' ),
);

$riode_option = array(
	// Navigator
	'navigator_items'                     => array(
		'custom_css_js'               => array( 'Style / Additional CSS & Script', 'section' ),
		'menu_skins'                  => array( 'Menu / Menu Skins', 'section' ),
		'wc_product'                  => array( 'WooCommerce / Product Type', 'section' ),
		'woocommerce_product_catalog' => array( 'WooCommerce / Shop Page', 'section' ),
		'wc_single_product'           => array( 'WooCommerce / Single Product Layout', 'section' ),
		'blog_archive'                => array( 'Blog / Blog Archive Layout', 'section' ),
		'blog_single'                 => array( 'Blog / Blog Single Layout', 'section' ),
		'woo_features'                => array( 'WooCommerce / Woo Features', 'section' ),
		'performance'                 => array( 'Advanced / Theme Features', 'section' ),
	),
	// General
	'site_type'                           => 'full',
	'site_width'                          => '1400',
	'site_gap'                            => '20',
	'container'                           => '1220',
	'container_fluid'                     => '1820',
	'gutter_lg'                           => '30',
	'gutter'                              => '20',
	'gutter_sm'                           => '10',
	'breakpoint_tab'                      => '992',
	'breakpoint_mob'                      => '768',
	'content_bg'                          => array(
		'background-color' => '#fff',
	),
	'screen_bg'                           => array(
		'background-color' => '#fff',
	),

	// Colors
	'primary_color'                       => '#27c',
	'secondary_color'                     => '#d26e4b',
	'alert_color'                         => '#b10001',
	'success_color'                       => '#a8c26e',
	'dark_color'                          => '#222',
	'light_color'                         => '#ccc',

	// Typography
	'typo_default'                        => array(
		'font-family'    => 'Poppins',
		'variant'        => '400',
		'font-size'      => '14px',
		'line-height'    => '1.86',
		'letter-spacing' => '',
		'color'          => '#666',
	),
	'typo_heading'                        => array(
		'font-family'    => 'inherit',
		'variant'        => '600',
		'line-height'    => '1.2',
		'letter-spacing' => '-0.025em',
		'text-transform' => 'none',
		'color'          => '#222',
	),
	'typo_custom1'                        => array(
		'font-family' => 'inherit',
	),
	'typo_custom2'                        => array(
		'font-family' => 'inherit',
	),
	'typo_custom3'                        => array(
		'font-family' => 'inherit',
	),
	// Skin
	'rounded_skin'                        => false,

	// Header
	'header_bg'                           => array(
		'background-color' => '#fff',
	),
	'typo_header'                         => array(
		'font-family'    => 'inherit',
		'font-size'      => '14px',
		'letter-spacing' => '-0.025em',
		'line-height'    => '',
		'text-transform' => 'uppercase',
		'color'          => '',
	),
	'header_active_color'                 => '',
	// Elements
	'social_type'                         => 'framed',
	'social_custom_color'                 => true,
	'social_color'                        => '#999',
	'social_link_icons'                   => array( 'facebook', 'twitter', 'linkedin' ),

	// Mobile Bar
	'mobile_bar_icons'                    => array(),
	'mobile_bar_menu_label'               => esc_html__( 'Menu', 'riode' ),
	'mobile_bar_menu_icon'                => 'd-icon-bars2',
	'mobile_bar_home_label'               => esc_html__( 'Home', 'riode' ),
	'mobile_bar_home_icon'                => 'd-icon-home',
	'mobile_bar_shop_label'               => esc_html__( 'Categories', 'riode' ),
	'mobile_bar_shop_icon'                => 'd-icon-volume',
	'mobile_bar_wishlist_label'           => esc_html__( 'Wishlist', 'riode' ),
	'mobile_bar_wishlist_icon'            => 'd-icon-heart',
	'mobile_bar_compare_label'            => esc_html__( 'Compare', 'riode' ),
	'mobile_bar_compare_icon'             => 'd-icon-refresh',
	'mobile_bar_account_label'            => esc_html__( 'Account', 'riode' ),
	'mobile_bar_account_icon'             => 'd-icon-user',
	'mobile_bar_cart_label'               => esc_html__( 'Cart', 'riode' ),
	'mobile_bar_cart_icon'                => 'd-icon-bag',
	'mobile_bar_search_label'             => esc_html__( 'Search', 'riode' ),
	'mobile_bar_search_icon'              => 'd-icon-search',
	'mobile_bar_top_label'                => esc_html__( 'To Top', 'riode' ),
	'mobile_bar_top_icon'                 => 'd-icon-arrow-up',

	// Menu
	'menu_labels'                         => '',
	'typo_menu_skin1_ancestor'            => array(
		'font-family'    => 'inherit',
		'variant'        => '700',
		'font-size'      => '',
		'line-height'    => '1',
		'letter-spacing' => '',
		'text-transform' => '',
		'color'          => '',
	),
	'typo_menu_skin1_content'             => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '14px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'text-transform' => 'capitalize',
		'color'          => '#666',
	),
	'typo_menu_skin1_toggle'              => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '',
		'line-height'    => '',
		'letter-spacing' => '',
		'text-transform' => '',
		'color'          => '#fff',
	),
	'skin1_ancestor_gap'                  => '23',
	'skin1_ancestor_padding'              => array(
		'Padding-Top'    => '11',
		'Padding-Right'  => '0',
		'Padding-Bottom' => '11',
		'Padding-Left'   => '0',
	),
	'skin1_anc_bg'                        => '',
	'skin1_anc_active_bg'                 => '',
	'skin1_anc_active_color'              => '',
	'skin1_con_bg'                        => '',
	'skin1_con_active_bg'                 => '',
	'skin1_con_active_color'              => '',
	'skin1_toggle_padding'                => array(
		'Padding-Top'    => '13',
		'Padding-Right'  => '15.5',
		'Padding-Bottom' => '13',
		'Padding-Left'   => '15.5',
	),
	'skin1_tog_bg'                        => '',
	'skin1_tog_active_bg'                 => '',
	'skin1_tog_active_color'              => '#fff',
	'typo_menu_skin2_ancestor'            => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '',
		'line-height'    => '1',
		'letter-spacing' => '',
		'text-transform' => '',
		'color'          => '',
	),
	'typo_menu_skin2_content'             => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '14px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'text-transform' => 'capitalize',
		'color'          => '#666',
	),
	'typo_menu_skin2_toggle'              => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '',
		'line-height'    => '',
		'letter-spacing' => '',
		'text-transform' => '',
		'color'          => '#fff',
	),
	'skin2_ancestor_gap'                  => '23',
	'skin2_ancestor_padding'              => array(
		'Padding-Top'    => '11',
		'Padding-Right'  => '0',
		'Padding-Bottom' => '11',
		'Padding-Left'   => '0',
	),
	'skin2_anc_bg'                        => '',
	'skin2_anc_active_bg'                 => '',
	'skin2_anc_active_color'              => '',
	'skin2_con_bg'                        => '',
	'skin2_con_active_bg'                 => '',
	'skin2_con_active_color'              => '',
	'skin2_toggle_padding'                => array(
		'Padding-Top'    => '11',
		'Padding-Right'  => '0',
		'Padding-Bottom' => '11',
		'Padding-Left'   => '0',
	),
	'skin2_tog_bg'                        => '',
	'skin2_tog_active_bg'                 => '',
	'skin2_tog_active_color'              => '#fff',
	'typo_menu_skin3_ancestor'            => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '',
		'line-height'    => '1',
		'letter-spacing' => '',
		'text-transform' => '',
		'color'          => '',
	),
	'typo_menu_skin3_content'             => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '14px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'text-transform' => 'capitalize',
		'color'          => '#666',
	),
	'typo_menu_skin3_toggle'              => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '',
		'line-height'    => '',
		'letter-spacing' => '',
		'text-transform' => '',
		'color'          => '#fff',
	),
	'skin3_ancestor_gap'                  => '23',
	'skin3_ancestor_padding'              => array(
		'Padding-Top'    => '13',
		'Padding-Right'  => '15.5',
		'Padding-Bottom' => '13',
		'Padding-Left'   => '15.5',
	),
	'skin3_anc_bg'                        => '',
	'skin3_anc_active_bg'                 => '',
	'skin3_anc_active_color'              => '',
	'skin3_con_bg'                        => '',
	'skin3_con_active_bg'                 => '',
	'skin3_con_active_color'              => '',
	'skin3_toggle_padding'                => array(
		'Padding-Top'    => '11',
		'Padding-Right'  => '0',
		'Padding-Bottom' => '11',
		'Padding-Left'   => '0',
	),
	'skin3_tog_bg'                        => '',
	'skin3_tog_active_bg'                 => '',
	'skin3_tog_active_color'              => '#fff',
	'mobile_menu_items'                   => array( 'main-menu' ),
	'mobile_menu_type'                    => 'tab',

	// Footer Option
	'footer_skin'                         => 'dark',
	'footer_bg'                           => array(),
	'footer_link_color'                   => '',
	'footer_active_color'                 => '',
	'footer_bd_color'                     => '',
	'typo_footer'                         => array(
		'font-family'    => 'inherit',
		'font-size'      => '13px',
		'line-height'    => '',
		'letter-spacing' => '',
		'color'          => '',
	),
	'typo_footer_title'                   => array(
		'font-family'    => 'inherit',
		'font-size'      => '1.6rem',
		'line-height'    => '',
		'letter-spacing' => '',
		'text-transform' => '',
		'color'          => '',
	),
	'typo_footer_widget'                  => array(
		'font-family'    => 'inherit',
		'font-size'      => '',
		'line-height'    => '',
		'letter-spacing' => '',
		'text-transform' => '',
		'color'          => '',
	),
	'ft_wrap'                             => 'container',
	'ft_widgets'                          => '1/4+3/4',
	'ft_padding'                          => array(
		'Padding-Top'    => '40',
		'Padding-Bottom' => '40',
	),
	'ft_divider'                          => 0,
	'fm_wrap'                             => 'container',
	'fm_widgets'                          => '1/4+1/4+1/4+1/4',
	'fm_padding'                          => array(
		'Padding-Top'    => '50',
		'Padding-Bottom' => '50',
	),
	'fm_divider'                          => 0,
	'fb_wrap'                             => 'container',
	'fb_widgets'                          => '',
	'fb_padding'                          => array(
		'Padding-Top'    => '30',
		'Padding-Bottom' => '30',
	),
	'fb_divider'                          => 0,
	'top_button_size'                     => '100',
	'top_button_pos'                      => 'right',

	// Share
	'share_type'                          => '',
	'share_custom_color'                  => true,
	'share_color'                         => '#999',
	'share_icons'                         => array( 'facebook', 'twitter', 'pinterest' ),

	// Page Title Bar
	'ptb_type'                            => 'depart',
	'ptb_title_show'                      => true,
	'ptb_subtitle_show'                   => true,
	'ptb_breadcrumb_show'                 => true,
	'ptb_wrap_container'                  => 'default',
	'ptb_bg'                              => array(
		'background-color'  => '#385aa1',
		'background-repeat' => 'no-repeat',
		'background-size'   => 'cover',
	),
	'ptb_height'                          => '250',
	'ptb_home_icon'                       => true,
	'ptb_delimiter'                       => '/',
	'ptb_delimiter_use_icon'              => true,
	'ptb_delimiter_icon'                  => 'fas fa-chevron-right',
	'typo_ptb_title'                      => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '40px',
		'line-height'    => '1.125',
		'letter-spacing' => '-0.025em',
		'text-transform' => 'uppercase',
		'color'          => '#fff',
	),
	'typo_ptb_subtitle'                   => array(
		'font-family'    => 'inherit',
		'variant'        => '',
		'font-size'      => '2rem',
		'line-height'    => '',
		'letter-spacing' => '',
		'text-transform' => 'uppercase',
		'color'          => '#fff',
	),
	'typo_ptb_breadcrumb'                 => array(
		'font-family'    => 'inherit',
		'font-size'      => '14px',
		'line-height'    => '1.6',
		'letter-spacing' => '',
		'text-transform' => '',
		'color'          => '#fff',
	),

	// Blog
	'post_grid'                           => 'grid',
	'post_count_row'                      => 1,
	'post_show_filter'                    => false,
	'post_loadmore_type'                  => 'page',
	'post_loadmore_label'                 => 'Load More',
	'post_show_info'                      => array( 'image', 'meta', 'content', 'author_box', 'tag', 'share', 'navigation', 'related', 'comments_list' ),
	'post_related_count'                  => 3,
	'post_related_per_row'                => 3,
	'post_related_orderby'                => '',
	'post_related_orderway'               => '',
	'post_type'                           => '',
	'post_overlay'                        => 'zoom_dark',
	'post_show_datebox'                   => '',
	'post_excerpt_type'                   => 'words',
	'post_excerpt_limit'                  => 30,


	// WC Product Type
	'product_type'                        => '',
	'product_classic_hover'               => '',
	'product_addtocart_pos'               => '',
	'product_quickview_pos'               => 'bottom',
	'product_wishlist_pos'                => '',
	'product_show_in_box'                 => false,
	'product_show_reviews_text'           => true,
	'product_show_media_shadow'           => false,
	'product_show_hover_shadow'           => false,
	'product_show_info'                   => array(
		'category',
		'label',
		'price',
		'rating',
		'addtocart',
		'quickview',
		'wishlist',
		'compare',
	),
	'product_hover_change'                => true,
	'product_content_align'               => 'left',
	'product_split_line'                  => false,

	// WC Category Type
	'category_type'                       => '',
	'category_subcat_cnt'                 => '5',
	'category_show_icon'                  => '',
	'category_overlay'                    => '',
	'category_default_w_auto'             => false,

	// WC Catalog
	'product_count_row'                   => 3,
	'shop_listcount'                      => 1,
	'show_cat_description'                => false,
	'product_gap'                         => 'gutter-md',
	'simple_shop'                         => false,
	'show_as_list_type'                   => false,
	'shop_loadmore_type'                  => 'page',
	'shop_loadmore_label'                 => 'Load More',
	'shop_top_toolbox_items'              => array( 'sort_by', 'view_type', 'count_box' ),
	'shop_shownums'                       => '9, _12, 24, 36',
	'shop_bottom_toolbox_items'           => array( 'res_count' ),
	'shop_toolbox_sticky'                 => true,

	// WC Single Product
	'single_product_type'                 => 'default',
	'single_product_breadcrumb_pos'       => '',
	'single_product_tab_type'             => 'tab',
	'single_product_cart_sticky'          => false,
	'single_product_tab_inside'           => false,
	'single_product_tab_title'            => '',
	'single_product_tab_block'            => '',
	'single_product_related_count'        => 4,
	'single_product_related_per_row'      => 4,
	'single_product_related_orderby'      => '',
	'single_product_related_orderway'     => '',

	/* WOO Features */
	// Vairation Swarch
	'attribute_swatch'                    => true,
	// Product Compare
	'product_compare'                     => false,
	// Auto-Remove Notices
	'wc_alert_remove'                     => 10,
	// Product Hurry Up Notification
	'product_hurryup_limit'               => 0,
	// Sales Popup
	'sales_popup'                         => 'popular',
	'sales_popup_products'                => '',
	'sales_popup_title'                   => 'Someone Purchased',
	'sales_popup_count'                   => 5,
	'sales_popup_start_delay'             => 60,
	'sales_popup_interval'                => 60,
	'sales_popup_category'                => '',
	'sales_popup_mobile'                  => true,
	// Product Access Roles
	'change_product_info_role'            => false,
	'product_role_info_category'          => array(),
	'product_role_info_label'             => array(),
	'product_role_info_price'             => array(),
	'product_role_info_rating'            => array(),
	'product_role_info_attribute'         => array(),
	'product_role_info_addtocart'         => array(),
	'product_role_info_quickview'         => array(),
	'product_role_info_wishlist'          => array(),
	'product_role_info_compare'           => array(),
	// Product Custom Description Tab
	'product_cdt'                         => true,
	// Vendor
	'dokan_dashboard_style'               => 'theme',
	'single_product_hide_vendor_tab'      => true,
	'single_product_vendor_info_title'    => '',
	'vendor_products_count_row'           => 4,
	'wcfm_show_sold_by_label'             => false,
	'wcfm_sold_by_label'                  => '',
	// Product Quickview
	'product_quickview_type'              => 'popup',
	'product_quickview_popup_loading'     => 'skeleton',
	'product_quickview_offcanvas_loading' => 'loading',
	// Product Labels
	'product_top_label'                   => 'Top',
	'product_top_label_bg_color'          => '#27c',
	'product_sale_label'                  => '%percent% Off',
	'product_sale_label_bg_color'         => '#d26e4b',
	'product_stock_label'                 => 'Out of Stock',
	'product_stock_label_bg_color'        => '#ccc',
	'product_new_label'                   => 'New',
	'product_period'                      => '7',
	'product_new_label_bg_color'          => '#a8c26e',
	'product_thumbnail_label_bg_color'    => '#a8c26e',
	'product_custom_label'                => true,
	// Video Thumbnail
	'product_video_thumbnail'             => true,
	// 360 Degree Thumbnail
	'product_360_thumbnail'               => true,
	// Social Login
	'social_login'                        => true,
	// Live Search
	'live_search'                         => true,
	// Attribute Guide
	'attribute_guide'                     => true,
	// Sales & Stock Progress Bar
	'product_show_progress'               => '',
	'product_progress_text'               => '',
	'product_low_stock_cnt'               => '10',
	// Sale countdown box
	'product_sale_countdown_type'         => '',
	// Product Buy Now
	'product_buy_now'                     => false,
	// Media Reviews
	'product_media_review'                => true,
	'product_review_image_cnt'            => 2,
	'product_review_video_cnt'            => 2,
	'product_review_image_type'           => '.png, .jpg, .jpeg',
	'product_review_video_type'           => '.avi, .mp4',
	'product_review_max_size'             => 2,
	// Reviews Like/Unlike
	'product_review_feeling'              => true,
	// Reviews Order/Filter
	'product_review_ordering'             => true,

	// 404 Block
	'404_block'                           => '',

	// Advanced
	'lazyload'                            => false,
	'lazyload_bg'                         => '#f4f4f4',
	'loading_animation'                   => false,
	'skeleton_screen'                     => false,
	'skeleton_bg'                         => 'light',
	'blog_ajax'                           => true,
	'shop_ajax'                           => true,
	'elementor_starter_guide'             => true,
	'custom_image_size'                   => array(
		'Width'  => '',
		'Height' => '',
	),
	'social_no_follow'                    => false,
	'mmenu_no_follow'                     => false,

	// optimize wizard
	'google_webfont'                      => false,
	'lazyload_menu'                       => false,
	'menu_last_time'                      => 0,
	'mobile_disable_animation'            => false,
	'mobile_disable_slider'               => false,

	'resource_disable_gutenberg'          => false,
	'resource_disable_wc_blocks'          => false,
	'resource_disable_elementor_unused'   => false,
	'resource_async_js'                   => true,
	'resource_split_tasks'                => true,
	'resource_idle_run'                   => true,
	'resource_after_load'                 => true,

	// Custom CSS & JS
	'custom_css'                          => '',
	'custom_js'                           => '',

	/* page layouts */
	'page_layouts'                        => array(
		'global-layout' => array(
			'name'      => 'Global Layout',
			'content'   => array(
				'general' => array(
					'wrap'           => 'container',
					'center_content' => 'true',
				),
			),
			'condition' => array(),
		),
		'layout-1'      => array(
			'name'      => 'Shop Layout',
			'content'   => array(
				'general'      => array(
					'wrap'           => 'container',
					'center_content' => 'true',
				),
				'left_sidebar' => array(
					'id' => 'shop-sidebar',
				),
			),
			'condition' => array(
				array(
					'category'    => 'product_archive',
					'subcategory' => '',
				),
			),
		),
		'layout-2'      => array(
			'name'      => 'Blog Layout',
			'content'   => array(
				'general'       => array(
					'wrap'           => 'container',
					'center_content' => 'true',
				),
				'right_sidebar' => array(
					'id' => 'blog-sidebar',
				),
			),
			'condition' => array(
				array(
					'category'    => 'post_archive',
					'subcategory' => '',
				),
				array(
					'category'    => 'post_single',
					'subcategory' => '',
				),
			),
		),
		'layout-3'      => array(
			'name'      => 'Product Layout',
			'content'   => array(
				'general' => array(
					'wrap'           => 'container',
					'center_content' => 'true',
				),
				'ptb'     => array(
					'id' => -1,
				),
			),
			'condition' => array(
				array(
					'category'    => 'product_single',
					'subcategory' => '',
				),
			),
		),
		'layout-4'      => array(
			'name'      => '404 Layout',
			'content'   => array(
				'general' => array(
					'wrap' => 'full',
				),
				'ptb'     => array(
					'id' => -1,
				),
			),
			'condition' => array(
				array(
					'category' => 'error',
				),
			),
		),
	),
	'layout_counter'                      => 5,

	/* conditions */
	'layout_conditions'                   => array(
		'product_archive' => array(
			'all' => 'layout-1',
		),
		'product_single'  => array(
			'all' => 'layout-3',
		),
		'post_archive'    => array(
			'all' => 'layout-2',
		),
		'post_single'     => array(
			'all' => 'layout-2',
		),
		'error'           => 'layout-4',
	),
	'product_layout_conditions'           => array(),
	'popup_conditions'                    => array(),
);

$riode_option['product_top_label_bg_color']  = riode_get_option( 'primary_color' );
$riode_option['product_sale_label_bg_color'] = riode_get_option( 'secondary_color' );

$riode_option['menu_labels'] = json_encode(
	array(
		'new' => riode_get_option( 'primary_color' ),
		'hot' => riode_get_option( 'secondary_color' ),
	)
);

$all_roles = array();
$roles     = wp_roles()->roles;
$roles     = apply_filters( 'editable_roles', $roles );
foreach ( $roles as $role_name => $role_info ) {
	$all_roles[ $role_name ] = $role_info['name'];
}
$all_roles['visitor'] = esc_html__( 'Visitor', 'riode' );
array_multisort( $all_roles );

$riode_option['product_role_info_category']  = array_keys( $all_roles );
$riode_option['product_role_info_label']     = array_keys( $all_roles );
$riode_option['product_role_info_price']     = array_keys( $all_roles );
$riode_option['product_role_info_rating']    = array_keys( $all_roles );
$riode_option['product_role_info_attribute'] = array_keys( $all_roles );
$riode_option['product_role_info_addtocart'] = array_keys( $all_roles );
$riode_option['product_role_info_quickview'] = array_keys( $all_roles );
$riode_option['product_role_info_wishlist']  = array_keys( $all_roles );
$riode_option['product_role_info_compare']   = array_keys( $all_roles );

if ( ! class_exists( 'WooCommerce' ) ) {
	unset( $riode_option['page_layouts']['layout-1'] );
	unset( $riode_option['page_layouts']['layout-3'] );
}
