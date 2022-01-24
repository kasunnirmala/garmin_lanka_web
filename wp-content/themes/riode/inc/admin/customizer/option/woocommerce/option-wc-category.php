<?php
/**
 * WooCommerce/Category Type
 */

Riode_Customizer::add_section(
	'wc_category',
	array(
		'title'    => esc_html__( 'Category Type', 'riode' ),
		'panel'    => 'woocommerce',
		'priority' => 7,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wc_category',
		'type'     => 'custom',
		'settings' => 'cs_category_type_title',
		'default'  => '<h3 class="options-custom-title">' . esc_html__( 'Category Type', 'riode' ) . ' </h3>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wc_category',
		'type'      => 'radio_image',
		'settings'  => 'category_type',
		'label'     => esc_html__( 'Category Type', 'riode' ),
		'default'   => riode_get_option( 'category_type' ),
		'transport' => 'refresh',
		'choices'   => array(
			''             => RIODE_CUSTOMIZER_IMG . '/category/default.jpg',
			'badge'        => RIODE_CUSTOMIZER_IMG . '/category/badge.jpg',
			'banner'       => RIODE_CUSTOMIZER_IMG . '/category/banner.jpg',
			'simple'       => RIODE_CUSTOMIZER_IMG . '/category/simple.jpg',
			'icon'         => RIODE_CUSTOMIZER_IMG . '/category/icon.jpg',
			'classic'      => RIODE_CUSTOMIZER_IMG . '/category/classic.jpg',
			'ellipse'      => RIODE_CUSTOMIZER_IMG . '/category/ellipse.jpg',
			'ellipse-2'    => RIODE_CUSTOMIZER_IMG . '/category/ellipse-2.jpg',
			'icon-overlay' => RIODE_CUSTOMIZER_IMG . '/category/icon-overlay.jpg',
			'group'        => RIODE_CUSTOMIZER_IMG . '/category/subcategory-1.jpg',
			'group-2'      => RIODE_CUSTOMIZER_IMG . '/category/subcategory-2.jpg',
			'center'       => RIODE_CUSTOMIZER_IMG . '/category/centered.jpg',
			'label'        => RIODE_CUSTOMIZER_IMG . '/category/label.jpg',
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'wc_category',
		'type'     => 'custom',
		'settings' => 'cs_wc_category_type',
		'default'  => '<p style="margin: 0; cursor: auto; margin-top: -5px; font-size: 12px;">' . esc_html__( 'You can refer category elements page', 'riode' ) . ' <a target="_black" href="https://d-themes.com/wordpress/riode/elements/elements/element-categories/">' . esc_html__( 'here', 'riode' ) . '</a></p>',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wc_category',
		'type'            => 'toggle',
		'settings'        => 'category_default_w_auto',
		'label'           => esc_html__( 'Content Width Auto', 'riode' ),
		'default'         => riode_get_option( 'category_default_w_auto' ),
		'transport'       => 'refresh',
		'tooltip'         => esc_html__( 'Do you want to make content width auto for default type?', 'riode' ),
		'active_callback' => array(
			array(
				'setting'  => 'category_type',
				'operator' => '=',
				'value'    => '',
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wc_category',
		'type'            => 'toggle',
		'settings'        => 'category_show_icon',
		'label'           => esc_html__( 'Show Icon', 'riode' ),
		'default'         => riode_get_option( 'category_show_icon' ),
		'transport'       => 'refresh',
		'active_callback' => array(
			array(
				'setting'  => 'category_type',
				'operator' => 'in',
				'value'    => array( 'group', 'group-2' ),
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wc_category',
		'type'            => 'text',
		'settings'        => 'category_subcat_cnt',
		'label'           => esc_html__( 'Subcategory Count', 'riode' ),
		'default'         => riode_get_option( 'category_subcat_cnt' ),
		'transport'       => 'refresh',
		'tooltip'         => esc_html__( 'Current category type requires subcategories', 'riode' ),
		'active_callback' => array(
			array(
				'setting'  => 'category_type',
				'operator' => 'in',
				'value'    => array( 'group', 'group-2' ),
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wc_category',
		'type'            => 'select',
		'settings'        => 'category_overlay',
		'label'           => esc_html__( 'Imave Hover Effect', 'riode' ),
		'default'         => riode_get_option( 'category_overlay' ),
		'tooltip'         => esc_html__( 'Select hover effect of category image when mouse is over.', 'riode' ),
		'transport'       => 'refresh',
		'choices'         => array(
			''           => esc_html__( 'No', 'riode' ),
			'light'      => esc_html__( 'Light', 'riode' ),
			'dark'       => esc_html__( 'Dark', 'riode' ),
			'zoom'       => esc_html__( 'Zoom', 'riode' ),
			'zoom_light' => esc_html__( 'Zoom and Light', 'riode' ),
			'zoom_dark'  => esc_html__( 'Zoom and Dark', 'riode' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'category_show_icon',
				'operator' => '==',
				'value'    => '',
			),
		),
	)
);
