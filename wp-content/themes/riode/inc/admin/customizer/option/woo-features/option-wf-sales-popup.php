<?php

/**
 * Woo Features/Hurry Up Notification
 *
 * @since 1.4.0    moved into woo features panel
 */

Riode_Customizer::add_section(
	'wf_sales_popup',
	array(
		'title' => esc_html__( 'Sales Popup', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sales_popup',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_sales_popup_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sales_popup',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_sales_popup_description',
		'label'     => esc_html__( "People will get detailed information of nowadays' trending from the other's purchase. This feature is often used to encourage people to buy certain products.", 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/sales-popup-1.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sales_popup',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_sales_popup',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'type'      => 'select',
		'settings'  => 'sales_popup',
		'label'     => esc_html__( 'Popup Content', 'riode' ),
		'section'   => 'wf_sales_popup',
		'default'   => riode_get_option( 'sales_popup' ),
		'tooltip'   => esc_html__( 'Select which products you want to show in sales popup.', 'riode' ),
		'choices'   => array(
			''         => esc_html__( 'Do not show', 'riode' ),
			'popular'  => esc_html__( 'Popular products', 'riode' ),
			'rating'   => esc_html__( 'Top rated products', 'riode' ),
			'sale'     => esc_html__( 'Sale products', 'riode' ),
			'featured' => esc_html__( 'Featured products', 'riode' ),
			'recent'   => esc_html__( 'Recent products', 'riode' ),
			'category' => esc_html__( 'Select a category', 'riode' ),
			'products' => esc_html__( 'Select products', 'riode' ),
		),
		'transport' => 'refresh',
	)
);

add_action(
	'init',
	function() {
		$categories = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
			)
		);

		$category_list = array();
		foreach ( $categories as $category ) {
			$category_list[ $category->term_id ] = $category->name;
		}

		Riode_Customizer::add_field(
			'option',
			array(
				'type'            => 'select',
				'settings'        => 'sales_popup_category',
				'label'           => esc_html__( 'Sales Popup Category', 'riode' ),
				'section'         => 'wf_sales_popup',
				'choices'         => $category_list,
				'active_callback' => array(
					array(
						'setting'  => 'sales_popup',
						'operator' => '==',
						'value'    => 'category',
					),
				),
				'transport'       => 'refresh',
			)
		);

		Riode_Customizer::add_field(
			'option',
			array(
				'type'            => 'text',
				'settings'        => 'sales_popup_products',
				'label'           => esc_html__( 'Input Products Ids', 'riode' ),
				'tooltip'         => esc_html__( 'Input comma seperated product ids for sales popup. e.g) 18, 21, 120', 'riode' ),
				'section'         => 'wf_sales_popup',
				'default'         => riode_get_option( 'sales_popup_products' ),
				'active_callback' => array(
					array(
						'setting'  => 'sales_popup',
						'operator' => '==',
						'value'    => 'products',
					),
				),
				'transport'       => 'refresh',
			)
		);

		Riode_Customizer::add_field(
			'option',
			array(
				'section'         => 'wf_sales_popup',
				'type'            => 'slider',
				'settings'        => 'sales_popup_count',
				'label'           => esc_html__( 'Products Count', 'riode' ),
				'default'         => riode_get_option( 'sales_popup_count' ),
				'transport'       => 'refresh',
				'choices'         => array(
					'min'  => 1,
					'max'  => 30,
					'step' => 1,
				),
				'active_callback' => array(
					array(
						'setting'  => 'sales_popup',
						'operator' => '!=',
						'value'    => 'products',
					),
					array(
						'setting'  => 'sales_popup',
						'operator' => '!=',
						'value'    => '',
					),
				),
			)
		);

		Riode_Customizer::add_field(
			'option',
			array(
				'type'            => 'text',
				'settings'        => 'sales_popup_title',
				'label'           => esc_html__( 'Popup Title', 'riode' ),
				'tooltip'         => esc_html__( 'Input title for sales popup.', 'riode' ),
				'default'         => riode_get_option( 'sales_popup_title' ),
				'section'         => 'wf_sales_popup',
				'active_callback' => array(
					array(
						'setting'  => 'sales_popup',
						'operator' => '!=',
						'value'    => '',
					),
				),
				'transport'       => 'refresh',
			)
		);

		Riode_Customizer::add_field(
			'option',
			array(
				'section'         => 'wf_sales_popup',
				'type'            => 'slider',
				'settings'        => 'sales_popup_start_delay',
				'label'           => esc_html__( 'Start Delay(seconds)', 'riode' ),
				'default'         => riode_get_option( 'sales_popup_start_delay' ),
				'tooltip'         => esc_html__( 'Change delay time to show the first popup after page loading.', 'riode' ),
				'active_callback' => array(
					array(
						'setting'  => 'sales_popup',
						'operator' => '!=',
						'value'    => '',
					),
				),
				'transport'       => 'refresh',
				'choices'         => array(
					'min'  => 1,
					'max'  => 30,
					'step' => 1,
				),
			)
		);

		Riode_Customizer::add_field(
			'option',
			array(
				'section'         => 'wf_sales_popup',
				'type'            => 'slider',
				'settings'        => 'sales_popup_interval',
				'label'           => esc_html__( 'Interval(seconds)', 'riode' ),
				'default'         => riode_get_option( 'sales_popup_interval' ),
				'tooltip'         => esc_html__( 'Change duration between popups. Each sales popup will be disappeared after 4 seconds.', 'riode' ),
				'active_callback' => array(
					array(
						'setting'  => 'sales_popup',
						'operator' => '!=',
						'value'    => '',
					),
				),
				'transport'       => 'refresh',
				'choices'         => array(
					'min'  => 1,
					'max'  => 600,
					'step' => 1,
				),
			)
		);

		Riode_Customizer::add_field(
			'option',
			array(
				'type'            => 'toggle',
				'settings'        => 'sales_popup_mobile',
				'label'           => esc_html__( 'Enable on Mobile', 'riode' ),
				'default'         => riode_get_option( 'sales_popup_mobile' ),
				'section'         => 'wf_sales_popup',
				'tooltip'         => esc_html__( 'Do you want to enable sales popup on mobile?', 'riode' ),
				'active_callback' => array(
					array(
						'setting'  => 'sales_popup',
						'operator' => '!=',
						'value'    => '',
					),
				),
				'transport'       => 'refresh',
			)
		);

		Riode_Customizer::add_field(
			'option',
			array(
				'section'         => 'wf_sales_popup',
				'type'            => 'custom',
				'settings'        => 'cs_woo_feature_sales_popup_guide',
				'label'           => '<p class="options-custom-description important-note">' . esc_html__( 'You could also set virtual buy time and virtual buy texts for each product in product data settings of product edit page.', 'riode' ) . '</p>',
				'transport'       => 'postMessage',
				'active_callback' => array(
					array(
						'setting'  => 'sales_popup',
						'operator' => '!=',
						'value'    => '',
					),
				),
			)
		);
	}
);
