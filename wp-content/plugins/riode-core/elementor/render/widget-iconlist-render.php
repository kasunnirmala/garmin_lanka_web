<?php

$settings          = $this->get_settings_for_display();
$fallback_defaults = [
	'd-icon-heart',
	'd-icon-star',
	'd-icon-info',
];

$this->add_render_attribute( 'icon_list', 'class', 'elementor-icon-list-items' );
$this->add_render_attribute( 'list_item', 'class', 'elementor-icon-list-item' );

if ( 'inline' === $settings['view'] ) {
	$this->add_render_attribute( 'icon_list', 'class', 'elementor-inline-items' );
	$this->add_render_attribute( 'list_item', 'class', 'elementor-inline-item' );
}
?>
<ul <?php $this->print_render_attribute_string( 'icon_list' ); ?>>
	<?php
	foreach ( $settings['icon_list'] as $index => $item ) :
		$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'icon_list', $index );

		$this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-icon-list-text' );

		$this->add_inline_editing_attributes( $repeater_setting_key );
		?>
		<li <?php $this->print_render_attribute_string( 'list_item' ); ?>>
			<?php
			if ( ! empty( $item['link']['url'] ) ) {
				$link_key = 'link_' . $index;

				$this->add_link_attributes( $link_key, $item['link'] );

				echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
			}

			// add old default
			if ( ! isset( $item['icon'] ) ) {
				$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'd-icon-check';
			}

			if ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) :
				?>
				<span class="elementor-icon-list-icon">
					<?php
					if ( ! empty( $item['selected_icon'] ) ) {
						?>
							<i class="<?php echo esc_attr( $item['selected_icon']['value'] ); ?>" aria-hidden="true"></i>
						<?php
					} else {
						?>
							<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
					<?php } ?>
				</span>
			<?php endif; ?>
			<span <?php $this->print_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['text']; ?></span>
			<?php if ( ! empty( $item['link']['url'] ) ) : ?>
				</a>
			<?php endif; ?>
		</li>
		<?php
	endforeach;
	?>
</ul>
