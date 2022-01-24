<?php

/**
 * Header Menu Label
 */

Riode_Customizer::add_section(
	'menu_labels',
	array(
		'title'    => esc_html__( 'Menu Labels', 'riode' ),
		'panel'    => 'nav_menus',
		'priority' => 1,
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'menu_labels',
		'type'      => 'custom',
		'settings'  => 'cs_menu_labels_title',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'Menu Labels', 'riode' ) . '</h3>',
		'tooltip'   => esc_html__( 'Please change or remove registered labels. You could select menu labels while you are editing menus.', 'riode' ),
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'           => 'menu_labels',
		'type'              => 'text',
		'settings'          => 'menu_labels',
		'label'             => esc_html__( 'Menu Labels', 'riode' ),
		'transport'         => 'refresh',
		'sanitize_callback' => 'wp_strip_all_tags',
	)
);

ob_start();
?>

<div class="label-list">
	<label><?php esc_html_e( 'Menu Labels', 'riode' ); ?></label>
	<select id="label-select" name="label-select">
	<?php
	$labels = json_decode( riode_get_option( 'menu_labels' ), true );
	if ( $labels ) :
		foreach ( $labels as $text => $color ) :
			?>
			<option value="<?php echo esc_attr( $color ); ?>"><?php echo esc_html( $text ); ?></option>
			<?php
		endforeach;
	endif;
	?>
	</select>
</div>
<div class="menu-label">
	<label><?php esc_html_e( 'Label Text to Change', 'riode' ); ?></label>
	<input type="text" class="label-text" value="<?php echo esc_attr( $labels ? array_keys( $labels )[0] : '' ); ?>">
	<label><?php esc_html_e( 'Label Background Color to Change', 'riode' ); ?></label>
	<input type="text" class="riode-color-picker" value="<?php echo esc_attr( $labels ? $labels[ array_keys( $labels )[0] ] : '' ); ?>">
	<div class="label-actions">
		<button class="button button-primary btn-change-label"><?php esc_html_e( 'Change', 'riode' ); ?></button>
		<button class="button btn-remove-label"><?php esc_html_e( 'Remove', 'riode' ); ?></button>
	</div>
<p class="error-msg"></p>
</div>

<?php
$str = ob_get_clean();

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'menu_labels',
		'type'      => 'custom',
		'settings'  => 'cs_menu_labels',
		'default'   => $str,
		'transport' => 'refresh',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'menu_labels',
		'type'      => 'custom',
		'settings'  => 'cs_new_label',
		'label'     => '',
		'default'   => '<h3 class="options-custom-title">' . esc_html__( 'New Label', 'riode' ) . '</h3>',
		'tooltip'   => esc_html__( 'Please input label text and color to register new one.', 'riode' ),
		'transport' => 'refresh',
	)
);

ob_start();
?>

<div class="menu-label">
	<label><?php esc_html_e( 'Input Label Text', 'riode' ); ?></label>
	<input type="text" class="label-text">
	<label><?php esc_html_e( 'Choose Label Background Color', 'riode' ); ?></label>
	<input type="text" class="riode-color-picker" value="">
	<div class="label-actions">
		<button class="button button-primary btn-add-label"><?php esc_html_e( 'Add', 'riode' ); ?></button>
	</div>
	<p class="error-msg"></p>
</div>

<?php
$str = ob_get_clean();

Riode_Customizer::add_field(
	'option',
	array(
		'section'   => 'menu_labels',
		'type'      => 'custom',
		'settings'  => 'cs_new_menu_label',
		'default'   => $str,
		'transport' => 'refresh',
	)
);
