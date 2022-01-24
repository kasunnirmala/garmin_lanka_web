<?php
/**
 * Riode Image Gallery Widget Render
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Images
			'images'              => '',
			'caption_type'        => '',
			'thumbnail_size'      => 'thumbnail',
			'slider_image_expand' => '',

			// Gallery Layout
			'layout_type'         => '',
			'col_cnt'             => array( 'size' => 4 ),
			'col_sp'              => 'md',
			'custom_creative'     => '',
			'creative_mode'       => 1,
			'items_list'          => '',

			'creative_auto_height' => false,
		),
		$atts
	)
);

$image_size   = [];
$image_size[] = $thumbnail_size;

if ( ! is_array( $images ) ) {
	$images = explode( '|', $images );
	foreach ( $images as $key => $val ) {
		$images[ $key ] = json_decode( $val, true );
	}
}
if ( ! is_array( $items_list ) ) {
	$items_list = explode( '|', $items_list );
	foreach ( $items_list as $key => $val ) {
		$items_list[ $key ] = json_decode( $val, true );
	}
}

if ( ! is_array( $col_cnt ) ) {
	$col_cnt = json_decode( $col_cnt, true );
}
// Layout
$extra_class = 'image-gallery';
$extra_attrs = '';
if ( 'creative' != $layout_type ) {
	$col_cnt      = riode_elementor_grid_col_cnt( $atts );
	$extra_class .= ' ' . riode_get_col_class( $col_cnt );
}
$extra_class .= ' ' . riode_elementor_grid_space_class( $atts );

if ( 'creative' == $layout_type ) {
	$extra_class .= ' row creative-grid creative-display-grid';
	if ( riode_is_preview() ) {
		$extra_class .= ' editor-mode';
	}
	if ( ! isset( $atts['creative_cols'] ) && ( ! isset( $atts['custom_creative'] ) || ! $atts['custom_creative'] ) ) {
		$extra_class .= ' grid-layout-' . $creative_mode;
	} else {
		if ( is_array( $items_list ) ) {
			$repeaters = array(
				'ids'    => array(),
				'images' => array(),
			);
			foreach ( $items_list as $item ) {
				$repeaters['ids'][ (int) $item['item_no'] ]    = 'elementor-repeater-item-' . $item['_id'];
				$repeaters['images'][ (int) $item['item_no'] ] = $item['item_thumb_size'];
			}
		}
	}
} elseif ( '' == $layout_type ) {
	$extra_class .= ' owl-image-gallery';

	if ( '' == $slider_image_expand ) {
		$extra_class .= ' owl-image-org';
	}

	$extra_class .= ' ' . riode_elementor_grid_space_class( $atts );
	$extra_class .= ' ' . riode_get_slider_class( $atts );
	$extra_attrs .= ' data-plugin="owl" data-owl-options=' . esc_attr(
		json_encode(
			riode_get_slider_attrs( $atts, $col_cnt )
		)
	);
} else {
	$extra_class .= ' grid-gallery';
}

if ( $creative_auto_height ) {
	$extra_class .= ' grid-equal-height';
}

?>

<div class="<?php echo esc_attr( $extra_class ); ?>"<?php echo $extra_attrs; ?>>
	<?php
	foreach ( $images as $index => $attachment ) :
		if ( empty( $attachment ) ) {
			continue;
		}
		$img_class = 'grid' == $layout_type ? 'grid-item image-wrap' : 'slide-image-wrap';
		if ( 'creative' == $layout_type ) {
			$img_wrap_class  = 'grid-item';
			$img_wrap_class .= ' grid-item-' . ( $index + 1 );
			$img_wrap_attr   = '';
			if ( isset( $repeaters ) ) {
				if ( isset( $repeaters['ids'][ $index + 1 ] ) ) {
					$img_wrap_class          .= ' ' . $repeaters['ids'][ $index + 1 ];
					$image_size[ $index + 1 ] = $repeaters['images'][ $index + 1 ];
				} else {
					$image_size[ $index + 1 ] = $image_size[0];
				}

				if ( isset( $repeaters['ids'][0] ) ) {
					$img_wrap_class .= ' ' . $repeaters['ids'][0];
				}
			}
			$wrap_attrs = ' data-grid-idx=' . ( $index + 1 );
			echo '<div class="' . esc_attr( $img_wrap_class ) . '"' . esc_attr( $wrap_attrs ) . '>';

			if ( '' == $custom_creative ) {
				if ( ( 1 == $creative_mode ) && ( 1 == ( $index + 1 ) % 7 ) ) {
					$image_size[ $index + 1 ] = 'woocommerce_single';
				}
				if ( ( 2 == $creative_mode ) && ( 2 == ( $index + 1 ) % 5 ) ) {
					$image_size[ $index + 1 ] = 'woocommerce_single';
				}
				if ( ( 3 == $creative_mode ) && ( 1 == ( $index + 1 ) % 5 ) ) {
					$image_size[ $index + 1 ] = 'woocommerce_single';
				}
				if ( ( 4 == $creative_mode ) && ( 3 == ( $index + 1 ) % 5 ) ) {
					$image_size[ $index + 1 ] = 'woocommerce_single';
				}
				if ( ( 5 == $creative_mode ) && ( ( 1 == ( $index + 1 ) % 4 ) || ( 2 == ( $index + 1 ) % 4 ) ) ) {
					$image_size[ $index + 1 ] = 'woocommerce_single';
				}
				if ( ( 6 == $creative_mode ) && ( ( 1 == ( $index + 1 ) % 4 ) || ( 3 == ( $index + 1 ) % 4 ) ) ) {
					$image_size[ $index + 1 ] = 'woocommerce_single';
				}
				if ( ( 9 == $creative_mode ) && ( 1 == ( $index + 1 ) % 10 ) ) {
					$image_size[ $index + 1 ] = 'woocommerce_single';
				}
			}
		}
		?>
		<figure class="<?php echo esc_attr( $img_class ); ?>">
			<?php
			echo wp_get_attachment_image( $attachment['id'], ( isset( $image_size[ $index + 1 ] ) ? $image_size[ $index + 1 ] : $image_size[0] ) );
			$image_caption = '';
			if ( $caption_type ) {
				$attachment_post = get_post( $attachment['id'] );
				if ( 'caption' === $caption_type ) {
					$image_caption = $attachment_post->post_excerpt;
				} elseif ( 'title' === $caption_type ) {
					$image_caption = $attachment_post->post_title;
				} else {
					$image_caption = $attachment_post->post_content;
				}
			}

			if ( ! empty( $image_caption ) ) {
				echo '<figcaption class="elementor-image-carousel-caption">' . riode_strip_script_tags( $image_caption ) . '</figcaption>';
			}
			?>
		</figure>
		<?php
		if ( 'creative' == $layout_type ) {
			echo '</div>';
		}
		endforeach;
	?>
</div>
