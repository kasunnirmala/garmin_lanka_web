<?php

if ( is_admin() ) {
	add_action( 'enqueue_block_editor_assets', 'riode_enqueue_block_editor_assets', 999 );
}

if ( ! function_exists( 'riode_enqueue_block_editor_assets' ) ) {
	function riode_enqueue_block_editor_assets() {
		$upload_dir = wp_upload_dir()['basedir'];
		$upload_url = wp_upload_dir()['baseurl'];

		if ( file_exists( wp_normalize_path( $upload_dir . '/riode_styles/dynamic_css_vars.css' ) ) ) {
			$dynamic_url = $upload_url . '/riode_styles/dynamic_css_vars.css';
		} else {
			$dynamic_url = RIODE_CSS . '/theme/dynamic_css_vars.css';
		}
		wp_enqueue_style( 'riode-dynamic-vars', $dynamic_url, array(), RIODE_VERSION );

		wp_enqueue_style( 'font-awesome-free', RIODE_ASSETS . '/vendor/fontawesome-free/css/all.min.css', array(), '5.14.0' );
		wp_enqueue_style( 'riode-icons', RIODE_ASSETS . '/vendor/riode-icons/css/icons.min.css', array(), RIODE_VERSION );
		wp_enqueue_style( 'owl-carousel', RIODE_ASSETS . '/vendor/owl-carousel/owl.carousel.min.css' );
		wp_enqueue_style( 'riode-blocks-style-editor', RIODE_CSS . '/admin/gutenberg-editor' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', RIODE_VERSION );

		riode_load_google_font();

		riode_get_layout_value( 'slug' );

		ob_start();
		include RIODE_COMPATIBILITY . '/gutenberg/gutenberg-variable.php';
		$output_style = ob_get_clean();

		if ( function_exists( 'riode_minify_css' ) ) {
			$output_style = riode_minify_css( $output_style );
		}

		wp_add_inline_style( 'riode-blocks-style-editor', $output_style );
	}
}
