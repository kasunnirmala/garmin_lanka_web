<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * template_parts/header/header.php
 */

if ( 'yes' == riode_get_layout_value( 'general', 'reading_progress' ) ) {
	echo '<div class="rpb-wrapper"><span class="rpb"></span></div>';
}

if ( 'riode_template' == get_post_type() && 'header' == get_post_meta( get_the_ID(), 'riode_template_type', true ) ) {
	echo '<header class="header custom-header header-' . get_the_ID() . '" id="header">';

	if ( have_posts() ) :
		the_post();
			the_content();
		wp_reset_postdata();
	endif;

	echo '</header>';
} elseif ( is_numeric( riode_get_layout_value( 'header', 'id' ) ) ) {
	if ( -1 != riode_get_layout_value( 'header', 'id' ) ) {
		echo '<header class="header custom-header header-' . riode_get_layout_value( 'header', 'id' ) . '" id="header">';
		riode_print_template( riode_get_layout_value( 'header', 'id' ) );
		echo '</header>';
	}
} else {
	echo '<header class="header pt-5 pb-5" id="header">';
	echo '<div class="container d-flex align-items-center justify-content-between">';

	echo '<a href="' . esc_url( home_url() ) . '" class="' . esc_attr( is_rtl() ? 'ml-4' : 'mr-4' ) . '">';
	if ( riode_get_option( 'custom_logo' ) ) {
		echo '<img src="' . esc_url( str_replace( array( 'http:', 'https:' ), '', wp_get_attachment_url( riode_get_option( 'custom_logo' ) ) ) ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
	} else {
		echo '<img src="' . RIODE_ASSETS . '/images/logo.png" width="153" height="44"></img></a>';
	}
	echo '</a>';

	if ( has_nav_menu( 'main-menu' ) ) {
		ob_start();
		$menu_locations = get_nav_menu_locations();
		wp_nav_menu(
			array(
				'menu'            => isset( $menu_locations['main-menu'] ) ? $menu_locations['main-menu'] : 0,
				'container'       => 'nav',
				'container_class' => 'main-menu skin1 d-none d-lg-block',
				'items_wrap'      => '<ul id="%1$s" class="menu menu-main-menu horizontal-menu">%3$s</ul>',
				'walker'          => new Riode_Walker_Nav_Menu(),
			)
		);
		$nav_html_escaped = ob_get_clean();
		if ( $nav_html_escaped ) {
			if ( riode_get_option( 'mobile_menu_items' ) ) {
				echo '<a href="#" class="mobile-menu-toggle d-show-mob"><i class="d-icon-bars2"></i></a>';
			}

			echo riode_strip_script_tags( $nav_html_escaped );
		}
	}

	if ( empty( $nav_html_escaped ) ) {
		echo '<div class="welcome-msg-wrapper flex-1 text-' . esc_attr( is_rtl() ? 'left' : 'right' ) . ' overflow-hidden"><p class="mb-0 text-uppercase welcome-msg">' . esc_html__( 'Welcome to Riode Store Message or Remove it!', 'riode' ) . '</p></div>';
	}
	echo '</div>';

	echo '</header>';
}
