<?php
defined( 'ABSPATH' ) || die;

/**
 * Riode Text Effect Widget Render
 *
 * @since 1.4
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'effect_type'     => 'animation',
			'animation_type'  => '',
			'animation_delay' => '',
			'animate_by'      => '',
			'text_before'     => '',
			'items'           => '',
			'text_after'      => '',
			'self'            => '',
		),
		$settings
	)
);

if ( 'animation' == $effect_type ) {
	if ( ! empty( $items ) ) {
		$html  = '';
		$first = true;

		foreach ( $items as $key => $item ) {
			if ( ! empty( $item['_id'] ) ) {
				if ( ! empty( $self ) ) {
					$repeater_setting_key = $self->get_repeater_setting_key( 'text', 'items', $key );
					$self->add_render_attribute( $repeater_setting_key, 'class', ( $first ? 'active visible ' : '' ) . 'animating-item ' . trim( esc_attr( ' elementor-repeater-item-' . $item['_id'] ) ) );
					$first = false;
				}
				$text = esc_html( $item['text'] );

				if ( $animate_by ) {

					$letters_array = array();
					$spanned_array = array();

					$base_words = explode( ' ', $text );

					if ( 'letter' === $animate_by ) {
						$glue          = '';
						$strlen        = mb_strlen( $text );
						$letters_array = array();

						while ( $strlen ) {
							$letters_array[] = mb_substr( $text, 0, 1, 'UTF-8' );
							$text            = mb_substr( $text, 1, $strlen, 'UTF-8' );
							$strlen          = mb_strlen( $text );
						}
					} else {
						$glue          = ' ';
						$letters_array = $base_words;
					}

					foreach ( $letters_array as $letter ) {

						if ( ' ' === $letter ) {
							$letter = '&nbsp;';
						}

						$spanned_array[] = sprintf( '<span>%s</span>', $letter );
					}

					$text = implode( $glue, $spanned_array );
				}

				$html .= '<span ' . ( $self ? $self->get_render_attribute_string( $repeater_setting_key ) : '' ) . '>' . $text . '</span> ';
			} else {
				$html .= esc_html( $item['text'] ) . ' ';
			}
		}

		if ( $html ) {
			$html = '<span class="animating-text animating-text-' . esc_attr( $animation_type ) . '" data-settings="' . esc_attr(
				json_encode(
					array(
						'effect' => esc_js( $animation_type ),
						'delay'  => empty( $animation_delay ) ? 3000 : (int) $animation_delay,
					)
				)
			) . '">' . $html . '</span>';
		}

		if ( ! empty( $self ) ) {
			$self->add_render_attribute( 'text', 'class', 'text-effect' );

			$is_preview = riode_is_elementor_preview();

			$text_before = esc_html( $text_before );
			$text_after  = esc_html( $text_after );

			if ( $is_preview ) {
				$self->add_inline_editing_attributes( 'text_before' );
				$self->add_inline_editing_attributes( 'text_after' );

				$text_before = '<span ' . $self->get_render_attribute_string( 'text_before' ) . '>' . $text_before . '</span>';
				$text_after  = '<span ' . $self->get_render_attribute_string( 'text_after' ) . '>' . $text_after . '</span>';
			}

			printf(
				'<%1$s %2$s>%3$s</%1$s>',
				in_array( $settings['header_size'], array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div' ) ) ? $settings['header_size'] : 'div',
				$self->get_render_attribute_string( 'text' ),
				$text_before . ' ' . $html . ' ' . $text_after
			);
		}
	}
} else if ( 'highlight' == $effect_type ) {
	
} else if ( 'dropcap' == $effect_type ) {
	
}
