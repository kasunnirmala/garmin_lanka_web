<?php

/**
 * Woo Features/Sales & Stock Progress Bar
 *
 * @since 1.4.0
 */

Riode_Customizer::add_section(
	'wf_sales_stock_bar',
	array(
		'title' => esc_html__( 'Product Sales & Stock Bar', 'riode' ),
		'panel' => 'woo_features',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sales_stock_bar',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_sales_stock_bar_about',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'About This Feature', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sales_stock_bar',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_sales_stock_bar_description',
		'label'     => esc_html__( 'Progress bar will be placed on the bottom of each products, which shows product sale count and stock count.', 'riode' ),
		'default'   => '<p class="options-custom-description option-feature-description"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/sales-stock-bar-1.png' . '" alt="Theme Option Descrpition Image" style="margin-bottom: 5px;"><img class="description-image" src="' . RIODE_CUSTOMIZER_IMG . '/description-images/sales-stock-bar-2.png' . '" alt="Theme Option Descrpition Image"></p>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sales_stock_bar',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_sales_stock_bar',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Feature Options', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sales_stock_bar',
		'type'      => 'radio-buttonset',
		'settings'  => 'product_show_progress',
		'label'     => esc_html__( 'Progress Bar For', 'riode' ),
		'tooltip'   => esc_html__( 'Does progress bar show product sale count or stock count? Choose what progress bar is for.', 'riode' ),
		'default'   => riode_get_option( 'product_show_progress' ),
		'transport' => 'refresh',
		'choices'   => array(
			''      => esc_html__( 'Hide', 'riode' ),
			'sales' => esc_html__( 'Sale', 'riode' ),
			'stock' => esc_html__( 'Stock', 'riode' ),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_sales_stock_bar',
		'type'            => 'text',
		'settings'        => 'product_progress_text',
		'label'           => esc_html__( 'Sales & Stock Text', 'riode' ),
		'default'         => riode_get_option( 'product_progress_text' ),
		'transport'       => 'refresh',
		'tooltip'         => esc_html__( 'This text will be shown under progress bar. Please insert %1$s for sale count, %2$s for stock count. (e.g. %1$s sales, %2$s in stock)', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'wf_sales_stock_bar',
		'type'            => 'number',
		'settings'        => 'product_low_stock_cnt',
		'label'           => esc_html__( 'Default Low Stock Limit', 'riode' ),
		'default'         => riode_get_option( 'product_low_stock_cnt' ),
		'transport'       => 'refresh',
		'tooltip'         => esc_html__( 'This option will be applied by default for products which "low stock threshold" value is not set. Please read below for more details.', 'riode' ),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'wf_sales_stock_bar',
		'type'      => 'custom',
		'settings'  => 'cs_woo_feature_sales_stock_bar_guide',
		'label'   => '<p class="options-custom-description important-note">' . sprintf( esc_html__( '%1$sStock bar%2$s will have different background colors depending on stock count. Stock bar with low stock count will be highlighted. You can set %1$s"Low stock threshold"%2$s option for each product from %1$sinventory tab%2$s of product data in product edit page.', 'riode' ), '<b>', '</b>' ) . '</p>',
		'transport' => 'postMessage',
	)
);
