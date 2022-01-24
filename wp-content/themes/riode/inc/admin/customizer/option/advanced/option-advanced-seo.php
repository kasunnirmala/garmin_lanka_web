<?php

/**
 * Advanced SEO
 */



Riode_Customizer::add_section(
	'seo',
	array(
		'title' => esc_html__( 'SEO', 'riode' ),
		'panel' => 'advanced',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'seo',
		'type'      => 'custom',
		'settings'  => 'seo_desc_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title option-feature-title">' . esc_html__( 'Recommended SEO Plugins', 'riode' ) . '</h3>',
		'transport' => 'postMessage',
	)
);


Riode_Customizer::add_field(
	'option',
	array(
		'section'         => 'seo',
		'type'            => 'custom',
		'settings'        => 'seo_desc2',
		'label'           => '<p class="options-custom-description important-note">' . sprintf( esc_html__( '1. %1$sRank Math SEO%2$s - This will help you get access to SEO tools you need to improve your SEO and attract more traffic to their website. Our theme has perfect compatibility with this plugin. Please %3$sinstall%4$s. %5$s %5$s 2. %1$sYoast SEO%2$s - This will help you write better content and have a fully optimized wordpress site. Please %3$sinstall%4$s.', 'riode' ), '<b>', '</b>', '<a href="' . esc_url( admin_url( 'admin.php?page=riode-setup-wizard&step=default_plugins' ) ) . '" target="__blank">', '</a>', '<br>' ) . '</p>',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'product_video_thumbnail',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'seo',
		'type'      => 'custom',
		'settings'  => 'cs_social_no_follow_title',
		'label'     => '',
		'tooltip'   => esc_html__( 'Indicates that the linked document is not endorsed by the author of this one. This link type may be used by search engines that use popularity ranking techniques.', 'riode' ),
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Add rel="nofollow"', 'riode' ) . '</h3>',
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'seo',
		'type'      => 'toggle',
		'settings'  => 'social_no_follow',
		'label'     => esc_html__( 'Share & Social Links', 'riode' ),
		'default'   => riode_get_option( 'social_no_follow' ),
		'tooltip'   => esc_html__( 'Share & Social Links are not endorsed by the author. So you can use these as nofollow types.', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'seo',
		'type'      => 'toggle',
		'settings'  => 'mmenu_no_follow',
		'label'     => esc_html__( 'Mobile Menu Items', 'riode' ),
		'default'   => riode_get_option( 'mmenu_no_follow' ),
		'tooltip'   => esc_html__( 'If desktop menu and mobile menu are same, you can use this option for SEO.', 'riode' ),
		'transport' => 'refresh',
	)
);
