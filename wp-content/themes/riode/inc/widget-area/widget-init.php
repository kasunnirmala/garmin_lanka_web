<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_action( 'widgets_init', 'riode_widgets_init' );

if ( ! function_exists( 'riode_widgets_init' ) ) :
	function riode_widgets_init() {

		$footer_widgets = array(
			'ft' => 'top',
			'fm' => 'main',
			'fb' => 'bottom',
		);

		foreach ( $footer_widgets as $key => $value ) {
			$count = count( explode( '+', riode_get_option( $key . '_widgets' ) ) );
			for ( $i = 0; $i < $count; ++ $i ) {
				$idx = '';
				if ( 1 < $count ) {
					$idx = $i + 1;
				}
				register_sidebar(
					array(
						'name'          => sprintf( esc_html__( 'Footer %1$s Widget %2$s', 'riode' ), ucfirst( $value ), $idx ),
						'id'            => 'footer-' . $value . '-widget-' . ( $i + 1 ),
						'before_widget' => '<div id="%1$s" class="widget %2$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>',
					)
				);
			}
		}

		register_sidebar(
			array(
				'name'          => esc_html__( 'Blog Sidebar', 'riode' ),
				'id'            => 'blog-sidebar',
				'before_widget' => '<nav id="%1$s" class="widget %2$s widget-collapsible">',
				'after_widget'  => '</nav>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Shop Sidebar', 'riode' ),
				'id'            => 'shop-sidebar',
				'before_widget' => '<nav id="%1$s" class="widget %2$s widget-collapsible">',
				'after_widget'  => '</nav>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		$extra_sidebars = get_option( 'riode_sidebars', '[]' );
		if ( ! empty( $extra_sidebars ) ) {
			$extra_sidebars = json_decode( $extra_sidebars, true );

			if ( ! empty( $extra_sidebars ) ) {
				foreach ( $extra_sidebars as $slug => $name ) {
					register_sidebar(
						array(
							'name'          => sprintf( esc_html__( '%s', 'riode' ), $name ),
							'id'            => $slug,
							'before_widget' => '<nav id="%1$s" class="widget %2$s widget-collapsible">',
							'after_widget'  => '</nav>',
							'before_title'  => '<h3 class="widget-title">',
							'after_title'   => '</h3>',
						)
					);
				}
			}
		}
	}
endif;
