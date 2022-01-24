<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-language-switcher.php
 */

if ( has_nav_menu( 'lang-switcher' ) ) {
	wp_nav_menu(
		array(
			'theme_location'  => 'lang-switcher',
			'container'       => 'nav',
			'container_class' => '',
			'items_wrap'      => '<ul id="%1$s" class="menu switcher lang-switcher">%3$s</ul>',
			'walker'          => new Riode_Walker_Nav_Menu(),
		)
	);
} elseif ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
	$languages = apply_filters( 'wpml_active_languages', array() );
	if ( ! empty( $languages ) && 1 < count( $languages ) ) {
		$active_lang = '';
		$other_langs = '';
		foreach ( $languages as $l ) {
			if ( ! $l['active'] ) {
				$other_langs .= '<li class="menu-item"><a href="' . esc_url( $l['url'] ) . '">';
			}
			if ( $l['country_flag_url'] ) {
				if ( $l['active'] ) {
					$active_lang .= '<img src="' . esc_url( $l['country_flag_url'] ) . '" alt="' . esc_attr( $l['language_code'] ) . '" width="18" height="12px" />';
				} else {
					$other_langs .= '<img src="' . esc_url( $l['country_flag_url'] ) . '" alt="' . esc_attr( $l['language_code'] ) . '" width="18" height="12px" />';
				}
			}
			if ( $l['active'] ) {
				$active_lang .= icl_disp_language( $l['native_name'], $l['translated_name'], apply_filters( 'riode_icl_show_native_name', true, $l ) );
			} else {
				$other_langs .= icl_disp_language( $l['native_name'], $l['translated_name'], apply_filters( 'riode_icl_show_native_name', true, $l ) );
			}
			if ( ! $l['active'] ) {
				$other_langs .= '</a></li>';
			}
		}
		?>
		<ul class="menu switcher lang-switcher">
			<li class="menu-item-has-children">
				<a class="switcher-toggle" href="#"><?php echo riode_strip_script_tags( $active_lang ); ?></a>
				<?php if ( $other_langs ) : ?>
				<ul>
					<?php echo riode_strip_script_tags( $other_langs ); ?>
				</ul>
				<?php endif; ?>
			</li>
		</ul>
		<?php
	}
} elseif ( class_exists( 'QTX_Translator' ) ) {
	global $q_config;

	$languages     = qtranxf_getSortedLanguages();
	$flag_location = qtranxf_flag_location();
	if ( is_404() ) {
		$url = esc_url( home_url() );
	} else {
		$url = '';
	}

	if ( ! empty( $languages ) && 1 < count( $languages ) ) {
		$active_lang = '';
		$other_langs = '';
		foreach ( $languages as $language ) {
			if ( $language != $q_config['language'] ) {
				$other_langs .= '<li><a href="' . qtranxf_convertURL( $url, $language, false, true ) . '">';
				$other_langs .= '<img src="' . esc_url( $flag_location . $q_config['flag'][ $language ] ) . '" alt="' . esc_attr( $q_config['language_name'][ $language ] ) . '" width="18px" height="12px"/>';
				$other_langs .= $q_config['language_name'][ $language ];
				$other_langs .= '</a></li>';
			} else {
				$active_lang .= '<img src="' . esc_url( $flag_location . $q_config['flag'][ $language ] ) . '" alt="' . esc_attr( $q_config['language_name'][ $language ] ) . '" width="18px" height="12px"/>';
				$active_lang .= $q_config['language_name'][ $language ];
			}
		}
		?>
		<ul class="menu switcher lang-switcher">
			<li class="menu-item-has-children">
				<a class="switcher-toggle" href="#"><?php echo riode_strip_script_tags( $active_lang ); ?></a>
				<?php if ( $other_langs ) : ?>
				<ul>
					<?php echo riode_strip_script_tags( $other_langs ); ?>
				</ul>
				<?php endif; ?>
			</li>
		</ul>
		<?php
	}
} else {
	?>
	<ul class="menu switcher lang-switcher">
		<li class="menu-item-has-children">
			<a href="#" class="switcher-toggle"><?php esc_html_e( 'ENG', 'riode' ); ?></a>
			<ul>
				<li><a href="#"><?php esc_html_e( 'ENG', 'riode' ); ?></a></li>
				<li><a href="#"><?php esc_html_e( 'FRA', 'riode' ); ?></a></li>
			</ul>
		</li>
	</ul>
	<?php
}
