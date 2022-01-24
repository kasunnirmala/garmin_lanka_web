<?php
/**
 * Version Compatibility
 *
 * @since 1.0.1
 */

if ( ! riode_doing_ajax() ) {
	$riode_cur_version = get_option( 'riode_version', '1.0.0' );

	if ( version_compare( RIODE_VERSION, $riode_cur_version, '!=' ) ) {

		$coms = array( '1.0.1', '1.2.0', '1.4.0' );

		foreach ( $coms as $com ) {
			if ( version_compare( $com, $riode_cur_version, '>' ) ) {
				include RIODE_COMPATIBILITY . '/version/' . $com . '.php';
			}
		}

		// Save Theme Options
		require_once RIODE_ADMIN . '/customizer/dynamic/riode-color-lib.php';
		require_once RIODE_ADMIN . '/customizer/customizer-function.php';

		ob_start();
		include RIODE_INC . '/admin/customizer/dynamic/dynamic_vars.php';

		global $wp_filesystem;
		// Initialize the WordPress filesystem, no more using file_put_contents function
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		try {
			$target      = wp_upload_dir()['basedir'] . '/riode_styles/dynamic_css_vars.css';
			$target_path = dirname( $target );
			if ( ! file_exists( $target_path ) ) {
				wp_mkdir_p( $target_path );
			}

			// check file mode and make it writable.
			if ( is_writable( $target_path ) == false ) {
				@chmod( get_theme_file_path( $target ), 0755 );
			}
			if ( file_exists( $target ) ) {
				if ( is_writable( $target ) == false ) {
					@chmod( $target, 0755 );
				}
				@unlink( $target );
			}

			$wp_filesystem->put_contents( $target, ob_get_clean(), FS_CHMOD_FILE );
		} catch ( Exception $e ) {
			var_dump( $e );
			var_dump( 'error occured while saving dynamic css vars.' );
		}

		// Compile Theme Style
		$used_components = get_theme_mod( 'used_elements', false );

		if ( ! $used_components ) {
			riode_compile_dynamic_css( 'optimize', $used_components );
		} else {
			riode_compile_dynamic_css();
		}

		add_action(
			'init',
			function() {
				update_option( 'riode_version', RIODE_VERSION );
			},
			20
		);

		delete_site_transient( 'riode_plugins' );
	}
}
