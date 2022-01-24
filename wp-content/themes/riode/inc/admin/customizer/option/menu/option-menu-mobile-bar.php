<?php

/**
 * Mobile Icon Bar
 */

Riode_Customizer::add_section(
	'mobile_bar',
	array(
		'title'    => esc_html__( 'Mobile Sticky Icon Bar', 'riode' ),
		'priority' => 4,
		'panel'    => 'nav_menus',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'custom',
		'settings'  => 'cs_mobile_bar_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Mobile Icon Bar', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'sortable',
		'settings'  => 'mobile_bar_icons',
		'label'     => esc_html__( 'Mobile Bar Icons', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_icons' ),
		'tooltip'   => esc_html__( 'Select items to show in mobile sticky bottom bar.', 'riode' ),
		'choices'   => array(
			'menu'     => esc_html__( 'Mobile Menu Toggle', 'riode' ),
			'home'     => esc_html__( 'Home', 'riode' ),
			'shop'     => esc_html__( 'Shop', 'riode' ),
			'wishlist' => esc_html__( 'Wishlist', 'riode' ),
			'compare'  => esc_html__( 'Compare', 'riode' ),
			'account'  => esc_html__( 'Account', 'riode' ),
			'cart'     => esc_html__( 'Cart', 'riode' ),
			'search'   => esc_html__( 'Search', 'riode' ),
			'top'      => esc_html__( 'To Top', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'custom',
		'settings'  => 'cs_mobile_bar_menu_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Mobile Menu Toggle', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_menu_label',
		'label'     => esc_html__( 'Menu Label', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_menu_label' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_menu_icon',
		'label'     => esc_html__( 'Menu Icon', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_menu_icon' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'custom',
		'settings'  => 'cs_mobile_bar_home_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Home', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_home_label',
		'label'     => esc_html__( 'Home Label', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_home_label' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_home_icon',
		'label'     => esc_html__( 'Home Icon', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_home_icon' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'custom',
		'settings'  => 'cs_mobile_bar_shop_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Shop', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_shop_label',
		'label'     => esc_html__( 'Shop Label', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_shop_label' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_shop_icon',
		'label'     => esc_html__( 'Shop Icon', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_shop_icon' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'custom',
		'settings'  => 'cs_mobile_bar_wishlist_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Wishlist', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_wishlist_label',
		'label'     => esc_html__( 'Wishlist Label', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_wishlist_label' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_wishlist_icon',
		'label'     => esc_html__( 'Wishlist Icon', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_wishlist_icon' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'custom',
		'settings'  => 'cs_mobile_bar_account_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Account', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_account_label',
		'label'     => esc_html__( 'Account Label', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_account_label' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_account_icon',
		'label'     => esc_html__( 'Account Icon', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_account_icon' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'custom',
		'settings'  => 'cs_mobile_bar_cart_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Cart', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_cart_label',
		'label'     => esc_html__( 'Cart Label', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_cart_label' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_cart_icon',
		'label'     => esc_html__( 'Cart Icon', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_cart_icon' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'custom',
		'settings'  => 'cs_mobile_bar_search_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Search', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_search_label',
		'label'     => esc_html__( 'Search Label', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_search_label' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_search_icon',
		'label'     => esc_html__( 'Search Icon', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_search_icon' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'custom',
		'settings'  => 'cs_mobile_bar_totop_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'To Top', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_top_label',
		'label'     => esc_html__( 'To Top Label', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_top_label' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'mobile_bar',
		'type'      => 'text',
		'settings'  => 'mobile_bar_top_icon',
		'label'     => esc_html__( 'To Top Icon', 'riode' ),
		'transport' => 'refresh',
		'default'   => riode_get_option( 'mobile_bar_top_icon' ),
	)
);
