<?php
defined( 'ABSPATH' ) || die;
?>
<div class="riode-wrap">
	<div class="riode-admin-panel">
		<nav class="riode-admin-nav">
			<img class="logo" src="<?php echo RIODE_URI; ?>/assets/images/logo-white.png" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" width="154" height="43" />
			<ul class="riode-admin-menu">
				<?php
				if ( 'license' == $menu_type ) {
					printf(
						'<li><a href="%s"%s>%s</a></li>',
						esc_url( admin_url( 'admin.php?page=riode' ) ),
						$_REQUEST['page'] && 'riode' == $_REQUEST['page'] ? ' class="active"' : '',
						esc_html__( 'Welcome', 'riode' )
					);

					printf( '<li><a href="%s">%s</a></li>', esc_url( admin_url( 'customize.php' ) ), esc_html__( 'Theme Options', 'riode' ) );

					if ( Riode_Admin::get_instance()->is_registered() ) {
						printf(
							'<li><a href="%s"%s>%s</a></li>',
							esc_url( admin_url( 'admin.php?page=riode-setup-wizard' ) ),
							$_REQUEST['page'] && 'riode-setup-wizard' == $_REQUEST['page'] ? ' class="active"' : '',
							esc_html__( 'Setup Wizard', 'riode' )
						);
						printf(
							'<li><a href="%s"%s>%s</a></li>',
							esc_url( admin_url( 'admin.php?page=riode-optimize-wizard' ) ),
							$_REQUEST['page'] && 'riode-optimize-wizard' == $_REQUEST['page'] ? ' class="active"' : '',
							esc_html__( 'Optimize Wizard', 'riode' )
						);
						printf(
							'<li><a href="%s"%s>%s</a></li>',
							esc_url( admin_url( 'admin.php?page=riode-maintenance-tools' ) ),
							$_REQUEST['page'] && 'riode-maintenance-tools' == $_REQUEST['page'] ? ' class="active"' : '',
							esc_html__( 'Maintenance Tools', 'riode' )
						);
						printf(
							'<li><a href="%s"%s>%s</a></li>',
							esc_url( admin_url( 'admin.php?page=riode-version-control' ) ),
							$_REQUEST['page'] && 'riode-version-control' == $_REQUEST['page'] ? ' class="active"' : '',
							esc_html__( 'Version Control', 'riode' )
						);
					} else {
						printf( '<li><a href="#" class="disabled">%s</a></li>', esc_html__( 'Setup Wizard', 'riode' ) );
						printf( '<li><a href="#" class="disabled">%s</a></li>', esc_html__( 'Optimize Wizard', 'riode' ) );
						printf( '<li><a href="#" class="disabled">%s</a></li>', esc_html__( 'Maintenance Tools', 'riode' ) );
						printf( '<li><a href="#" class="disabled">%s</a></li>', esc_html__( 'Version Control', 'riode' ) );
					}
					do_action( 'riode_add_admin_panel_header' );
				} elseif ( 'template_dashboard' == $menu_type ) {
					global $pagenow;

					printf(
						'<li><a href="%s"%s>%s</a></li>',
						esc_url( admin_url( 'admin.php?page=riode_layout_dashboard' ) ),
						isset( $_REQUEST['page'] ) && 'riode_layout_dashboard' == $_REQUEST['page'] ? ' class="active"' : '',
						esc_html__( 'Page Layouts', 'riode' )
					);
					printf(
						'<li><a href="%s"%s>%s</a></li>',
						esc_url( admin_url( 'edit.php?post_type=riode_template' ) ),
						'edit.php' == $pagenow && $_REQUEST['post_type'] && 'riode_template' == $_REQUEST['post_type'] ? ' class="active"' : '',
						esc_html__( 'Templates Builder', 'riode' )
					);
					printf(
						'<li><a href="%s"%s>%s</a></li>',
						esc_url( admin_url( 'admin.php?page=riode_sidebar' ) ),
						isset( $_REQUEST['page'] ) && 'riode_sidebar' == $_REQUEST['page'] ? ' class="active"' : '',
						esc_html__( 'Sidebar Manage', 'riode' )
					);
				}
				?>
			</ul>
		</nav>
