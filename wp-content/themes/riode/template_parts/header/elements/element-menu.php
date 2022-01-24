<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-menu.php
 */

foreach ( $args as $key => $value ) {
	$value = (object) $value;
	if ( isset( $value->menu_id ) && wp_get_nav_menu_object( $value->menu_id ) ) {
		$class      = '';
		$wrap_cls   = '';
		$wrap_cls  .= ' ' . $value->type . '-menu';
		$wrap_style = '';

		if ( 'horizontal' != $value->type && isset( $value->width ) ) {
			$wrap_style .= 'width: ' . (float) $value->width . 'px';
		}

		if ( 'horizontal' == $value->type && $value->mobile ) {
			echo '<div class="dropdown dropdown-menu mobile-links ' . $value->skin . '">';
			echo '<a href="#" class="nolink">' . esc_attr( $value->mobile_text ) . '</a>';
			$class = 'dropdown-box' . ( isset( $value->mobile_dropdown_pos ) && $value->mobile_dropdown_pos ? ' ' . $value->mobile_dropdown_pos : '' );
		} elseif ( 'dropdown' == $value->type ) {
			$tog_class = array( $value->skin );
			if ( ! $value->no_bd ) {
				$tog_class[] = 'has-border';
			}
			if ( ( isset( $value->show_page ) && $value->show_page ) || ( $value->show_home && is_front_page() ) ) {
				$tog_class[] = 'show-home';
			}
			if ( $value->tog_equal ) {
				$tog_class[] = 'with-sidebar';
			}
			echo '<div class="dropdown toggle-menu ' . implode( ' ', $tog_class ) . '">';
			echo '<a href="#" class="dropdown-menu-toggle">';
			if ( $value->icon ) {
				if ( $value->hover_icon ) {
					echo '<i class="hover ' . esc_attr( $value->hover_icon ) . '"></i>';
				}
				echo '<i class="' . esc_attr( $value->icon ) . '"></i>';
			}
			if ( $value->label ) {
				echo '<span>' . esc_html( $value->label ) . '</span>';
			}
			echo '</a>';

			$class     = 'dropdown-box';
			$wrap_cls .= ' vertical-menu';
		} else {
			$class .= ' ' . $value->skin;
		}

		if ( isset( $value->underline ) && $value->underline ) {
			$wrap_cls .= ' menu-active-underline';
		}

		$class .= ' ' . get_term_field( 'slug', $value->menu_id );

		$lazyload_menu_enabled = ! wp_doing_ajax() &&
					! is_customize_preview() &&
					! ( function_exists( 'riode_is_elementor_preview' ) &&
						riode_is_elementor_preview()
					) && riode_get_option( 'lazyload_menu' );

		if ( $lazyload_menu_enabled ) {
			$wrap_cls .= ' lazy-menu';
		}

		wp_nav_menu(
			array(
				'menu'            => $value->menu_id,
				'container'       => 'nav',
				'container_class' => $class,
				'items_wrap'      => '<ul id="%1$s" class="menu ' . esc_attr( $wrap_cls ) . '" style="' . $wrap_style . '">%3$s</ul>',
				'walker'          => new Riode_Walker_Nav_Menu(),
				'depth'           => $lazyload_menu_enabled ? 2 : 0,
				'lazy'            => $lazyload_menu_enabled,
				'theme_location'  => '',
			)
		);

		if ( isset( $value->mobile ) && $value->mobile ) {
			echo '</div>';
		} elseif ( 'dropdown' == $value->type ) {
			echo '</div>';
		}
	} else {
		echo '<nav class="d-show-desk">';
		echo '<ul class="menu dummy-menu">';
		echo esc_html__( 'Select Menu', 'riode' );
		echo '</ul>';
		echo '</nav>';
	}
}
