<?php
defined( 'ABSPATH' ) || die;
?>
<h2><?php esc_html_e( 'Setup Riode Child Theme (Optional)', 'riode' ); ?></h2>
<p class="lead">
	<?php
	printf( esc_html__( 'If you are going to make changes to the theme source code please use a %1$s rather than modifying the main theme HTML/CSS/PHP code. %2$s This allows the parent theme to receive updates without overwriting your source code changes. Use the form below to create and activate the Child Theme.', 'riode' ), '<a href="https://codex.wordpress.org/Child_Themes" target="_blank">' . esc_html__( 'Child Theme', 'riode' ) . '</a>', '<br>' );
	?>
</p>

<?php
// Create Child Theme
if ( isset( $_REQUEST['theme_name'] ) && current_user_can( 'manage_options' ) ) {
	echo riode_escaped( $this->_make_child_theme( sanitize_text_field( $_REQUEST['theme_name'] ) ) );
}
$theme = 'Riode Child';
?>

<?php if ( ! isset( $_REQUEST['theme_name'] ) ) { ?>

<form method="POST">
	<div class="child-theme-input" style="margin-bottom: 30px;">
		<label style="font-weight: bold;margin:35px 0 5px; display: block;" for="child-theme"><?php esc_html_e( 'Child Theme Title:', 'riode' ); ?></label>
		<input type="text" style="width: 100%;" name="theme_name" id="child-theme" value="<?php echo esc_attr( $theme ); ?>" />
	</div>

	<p class="info-qt"><?php esc_html_e( 'If you\'re not sure what a Child Theme is just click the "Skip this step" button.', 'riode' ); ?></p>

	<p class="riode-admin-panel-actions">
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-dark button-large button-next button-icon-hide"><?php esc_html_e( 'Skip this step', 'riode' ); ?></a>
		<button type="submit" class="button button-primary button-large button-next"><?php esc_html_e( 'Create and Use Child Theme', 'riode' ); ?></button>
	</p>
</form>

<?php } else { ?>
<p class="riode-admin-panel-actions">
	<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-primary button-large button-next"><?php esc_html_e( 'Continue', 'riode' ); ?></a>
</p>
<?php } ?>
