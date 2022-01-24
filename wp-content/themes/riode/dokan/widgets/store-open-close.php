<?php
/**
 * Dokan Store Open Close Time Widget
 *
 * @since 2.7.3
 *
 * @package dokan
 */
?>
<div class="dokan-store-open-close">
	<?php foreach ( $dokan_store_time as $day => $value ) : ?>
		<?php
			$status  = isset( $value['open'] ) ? $value['open'] : $value['status'];
			$to      = ! empty( dokan_get_translated_days( $status ) ) ? dokan_get_translated_days( $status ) : '-';
			$is_open = 'open' == $status ? true : false;
		?>
		<div class="open-close-day <?php echo esc_attr( $day ) . '-time'; ?>">
			<label for=""><?php echo esc_attr( dokan_get_translated_days( $day ) ); ?></label>
			<span><?php echo ! $is_open ? '' : esc_attr( ucfirst( $value['opening_time'] ) ), ' ' . $to, $is_open ? ' ' . esc_attr( ucfirst( $value['closing_time'] ) ) : ''; //// phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?></span>
		</div>
	<?php endforeach; ?>
</div>
