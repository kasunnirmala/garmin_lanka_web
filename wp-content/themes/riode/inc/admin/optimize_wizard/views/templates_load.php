<?php
defined( 'ABSPATH' ) || die;

// Layouts & Sidebars
global $wp_registered_sidebars;

$layouts      = riode_get_option( 'page_layouts' );
$use_sidebars = array();
$sidebars     = get_option( 'riode_sidebars' );

if ( $sidebars ) {
	$sidebars = json_decode( $sidebars, true );
}
?>
<p>
<?php esc_html_e( 'Through this step, you can remove unused layouts and sidebars.', 'riode' ); ?>
<br/>
<?php esc_html_e( 'Selected items will be saved for next use and the others will be automatically removed.', 'riode' ); ?>
</p>
<p>
<?php esc_html_e( 'Please check used layouts and sidebars!', 'riode' ); ?>
</p>
<h4 style="margin-bottom: 0"><?php esc_html_e( '1. Layouts', 'riode' ); ?></h4>

<ul class="layout-items">
<li class="layout-item">
	<strong><?php esc_html_e( 'Name', 'riode' ); ?></strong>
	<span><?php esc_html_e( 'Action', 'riode' ); ?></span>
</li>
<?php
foreach ( $layouts as $key => $layout ) {
	$flag = true;
	if ( 'global-layout' != $key && ( ! isset( $layout['condition'] ) || 0 == count( $layout['condition'] ) ) ) {
		$flag = false;
	}

	isset( $layout['content']['left_sidebar']['id'] ) && array_push( $use_sidebars, $layout['content']['left_sidebar']['id'] );
	isset( $layout['content']['right_sidebar']['id'] ) && array_push( $use_sidebars, $layout['content']['right_sidebar']['id'] );
	isset( $layout['content']['top_sidebar']['id'] ) && array_push( $use_sidebars, $layout['content']['top_sidebar']['id'] );

	?>
	<li class="layout-item">
		<label><?php echo esc_html( $layout['name'], 'riode' ); ?></label>
		<input type="checkbox" class="layout" name="<?php echo esc_attr( $key ); ?>" <?php checked( $flag ); ?> <?php disabled( $flag ); ?>> 
	</li>
	<?php
}
?>
</ul>


<h4 style="margin-bottom: 0"><?php esc_html_e( '2. Sidebars', 'riode' ); ?></h4>
<ul class="sidebar-items">
<li class="sidebar-item">
	<strong><?php esc_html_e( 'Name', 'riode' ); ?></strong>
	<span><?php esc_html_e( 'Action', 'riode' ); ?></span>
</li>
<?php
// Registered Sidebars
foreach ( $wp_registered_sidebars as $key => $sidebar ) {
	$flag = false;
	if ( ! in_array( $key, array_keys( $sidebars ) ) ) {
		$flag = true;
	}
	if ( in_array( $key, $use_sidebars ) ) {
		$flag = true;
	}
	?>
	<li class="sidebar-item">
		<label><?php echo esc_html( $sidebar['name'], 'riode' ); ?></label>
		<input type="checkbox" class="sidebar" name="<?php echo esc_attr( $key ); ?>" <?php checked( $flag ); ?> <?php disabled( $flag ); ?>> 
	</li>
	<?php
}

?>
</ul>
