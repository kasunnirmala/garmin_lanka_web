<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<meta name="keywords" content="WordPress Template" />

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php
	$preload_fonts = riode_get_option( 'preload_fonts' );
	if ( ! empty( $preload_fonts ) ) {
		if ( in_array( 'riode', $preload_fonts ) ) {
			echo '<link rel="preload" href="' . RIODE_ASSETS . '/vendor/riode-icons/fonts/riode.ttf?5gap68" as="font" type="font/ttf" crossorigin>';
		}
		if ( in_array( 'fas', $preload_fonts ) ) {
			echo '<link rel="preload" href="' . RIODE_ASSETS . '/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>';
		}
		if ( in_array( 'far', $preload_fonts ) ) {
			echo '<link rel="preload" href="' . RIODE_ASSETS . '/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin>';
		}
		if ( in_array( 'fab', $preload_fonts ) ) {
			echo '<link rel="preload" href="' . RIODE_ASSETS . '/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>';
		}
	}
	if ( ! empty( $preload_fonts['custom'] ) ) {
		$font_urls = explode( "\n", $preload_fonts['custom'] );
		foreach ( $font_urls as $font_url ) {
			$dot_pos = strrpos( $font_url, '.' );
			if ( false !== $dot_pos ) {
				$type = substr( $font_url, $dot_pos + 1 );
				echo '<link rel="preload" href="' . esc_url( $font_url ) . '" as="font" type="font/' . esc_attr( $type ) . '" crossorigin>';
			}
		}
	}
	?>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div class="page-wrapper" <?php echo riode_page_wrapper_attrs(); ?>>

	<?php
		get_template_part( RIODE_PART . '/header/header' );
	?>

	<?php riode_print_title_bar(); ?>
		<main id="main" class="<?php echo apply_filters( 'riode_main_class', 'main' ); ?>">
