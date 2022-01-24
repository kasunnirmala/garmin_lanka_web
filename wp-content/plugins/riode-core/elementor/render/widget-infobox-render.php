<?php
if ( ! defined( 'META_KEY' ) ) {
	define( 'META_KEY', '_elementor_inline_svg' );
}
$settings = $this->get_settings_for_display();

$this->add_render_attribute( 'icon', 'class', [ 'elementor-icon', '' ] );

$icon_tag = 'span';

$svg      = '';
$svg_file = '';

$has_icon = ! empty( $settings['selected_icon'] );

if ( ! empty( $settings['link']['url'] ) ) {
	$icon_tag = 'a';

	$this->add_link_attributes( 'link', $settings['link'] );
}

if ( $has_icon ) {
	$this->add_render_attribute( 'i', 'class', $settings['selected_icon'] );
	$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
}

$icon_attributes = $this->get_render_attribute_string( 'icon' );
$link_attributes = $this->get_render_attribute_string( 'link' );

$this->add_render_attribute( 'description_text', 'class', 'elementor-icon-box-description' );

$this->add_inline_editing_attributes( 'title_text', 'none' );
$this->add_inline_editing_attributes( 'description_text' );
if ( ! $has_icon && ! empty( $settings['selected_icon']['value'] ) ) {
	$has_icon = true;
}
?>
<div class="elementor-icon-box-wrapper">
	<?php if ( $has_icon ) : ?>
	<div class="elementor-icon-box-icon">
		<<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); ?>>
		<?php
		if ( ! empty( $settings['selected_icon'] ) ) {
			if ( 'svg' == $settings['selected_icon']['library'] ) {
				if ( ! isset( $settings['selected_icon']['value']['id'] ) ) {
					return '';
				}

				$svg = get_post_meta( $settings['selected_icon']['value']['id'], META_KEY, true );

				$svg_file = get_attached_file( $settings['selected_icon']['value']['id'] );

				if ( ! $svg_file ) {
					return '';
				}

				$svg = file_get_contents( $svg_file );

				if ( ! empty( $svg ) ) {
					update_post_meta( $settings['selected_icon']['value']['id'], META_KEY, $svg );
				}

				echo $svg;

			} else {
				?>
			<i <?php $this->print_render_attribute_string( 'i' ); ?>></i>
						<?php
			}
		}
		?>
		</<?php echo $icon_tag; ?>>
	</div>
	<?php endif; ?>
	<div class="elementor-icon-box-content">
		<<?php echo $settings['title_size']; ?> class="elementor-icon-box-title">
			<<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?><?php $this->print_render_attribute_string( 'title_text' ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
		</<?php echo $settings['title_size']; ?>>
		
		<p <?php $this->print_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></p>
	
	</div>
</div>
