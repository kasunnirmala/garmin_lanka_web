<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * element-mmenu-toggle.php
 */

$icon_class = 'd-icon-bars2';

if ( isset( $mmenu_toggle ) && isset( $mmenu_toggle['icon'] ) && $mmenu_toggle['icon'] ) {
	$icon_class = $mmenu_toggle['icon'];
}

if ( riode_get_option( 'mobile_menu_items' ) ) {
	?>
	<a href="#" class="mobile-menu-toggle d-show-mob"><i class="<?php echo esc_attr( $icon_class ); ?>"></i></a>
	<?php
}
