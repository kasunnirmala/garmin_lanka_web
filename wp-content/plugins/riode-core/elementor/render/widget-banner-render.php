<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Banner Widget Render
 *
 * @since 1.0
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'banner_preset'              => 'simple-center',
			'banner_item_list'           => array(),
			'banner_origin'              => '',
			'absolute_banner'            => '',
			'fixed_banner'               => '',
			'banner_wrap'                => '',
			'parallax'                   => '',
			'_content_animation'         => '',
			'content_animation_duration' => '',
			'_content_animation_delay'   => '',
		),
		$atts
	)
);

$banner_class  = array( 'el-banner banner' );
$wrapper_class = array( 'banner-content' );

// Preset Option
if ( 1 == strpos( $banner_preset, 'oxed', 0 ) ) {
	$banner_class[] = 'boxed';
}
$banner_class[] = $banner_preset;


// Banner Overlay
if ( $atts['overlay'] ) {
	$banner_class[] = riode_get_overlay_class( $atts['overlay'] );
}

// Background Effect
$background_class[] = '';
if ( $atts['background_effect'] ) {
	$background_class[] = $atts['background_effect'];
}

// Particle Effect
$particle_class[] = '';
if ( $atts['particle_effect'] ) {
	$particle_class[] = $atts['particle_effect'];
}

if ( 'yes' == $absolute_banner ) {
	$banner_class[] = 'el-banner-fixed banner-fixed';

	if ( 'yes' != $fixed_banner && ! $parallax ) {
		$banner_class[] = 'p-static';
	}

	// Banner Origin
	$wrapper_class[] = $banner_origin;
}

// Parallax
if ( 'yes' == $parallax ) {
	$banner_class[]   = 'parallax';
	$parallax_img     = esc_url( $atts['banner_background_image']['url'] );
	$parallax_options = array(
		'speed'          => $atts['parallax_speed']['size'] ? 10 / $atts['parallax_speed']['size'] : 1.5,
		'parallaxHeight' => $atts['parallax_height']['size'] ? $atts['parallax_height']['size'] . '%' : '300%',
		'offset'         => $atts['parallax_offset']['size'] ? $atts['parallax_offset']['size'] : 0,
	);
	$parallax_options = "data-parallax-options='" . json_encode( $parallax_options ) . "'";
	echo '<div class="' . esc_attr( implode( ' ', $banner_class ) ) . '" data-plugin="parallax" data-image-src="' . $parallax_img . '" ' . $parallax_options . '>';
} else {
	echo  '<div class="' . esc_attr( implode( ' ', $banner_class ) ) . '">';
}

// Background Effect
if ( '' !== $atts['background_effect'] || '' !== $atts['particle_effect'] ) {
	echo '<div class="background-effect-wrapper">';

	if ( ! empty( $atts['banner_background_image'] ) ) {
		if ( '' !== $atts['particle_effect'] && '' == $atts['background_effect'] ) {
			$background_img = '';
		} else {
			$background_img = esc_url( $atts['banner_background_image']['url'] );
		}

		echo '<div class="background-effect ' . esc_attr( implode( ' ', $background_class ) ) . '" style="background-image: url(' . $background_img . '); background-size: cover;">';

		if ( '' !== $atts['particle_effect'] ) {
			echo '<div class="particle-effect ' . esc_attr( implode( ' ', $particle_class ) ) . '"></div>';
		}

		echo '</div>';
	}

	echo '</div>';
}
$banner_img_cls = '';
if ( isset( $atts['background_effect'] ) && ! empty( $atts['background_effect'] ) ) {
	$banner_img_cls = 'banner-img-hidden';
}

/* Image */
if ( isset( $atts['banner_background_image']['id'] ) && $atts['banner_background_image']['id'] && 'yes' == $fixed_banner && 'yes' == $absolute_banner ) {
	$banner_img_id = $atts['banner_background_image']['id'];
	?>
<figure class="banner-img <?php echo esc_attr( $banner_img_cls ); ?>">
	<?php

	$tablet_class  = '';
	$desktop_class = '';
	$image_atts    = $atts['banner_background_color'] ? array( 'style' => 'background-color:' . $atts['banner_background_color'] ) : '';

	if ( ! empty( $atts['banner_background_image_mobile']['id'] ) ) {
		$tablet_class  = 'show-only-tablet';
		$desktop_class = 'hide-mobile';

		$mobile_image = wp_get_attachment_image_src( $atts['banner_background_image_mobile']['id'], 'full', false );

		if ( $mobile_image ) {
			list( $mobile_src, $mobile_width, $mobile_height ) = $mobile_image;
			$image_atts['srcset']                              = $mobile_src;
			$image_atts['class']                               = 'show-only-mobile';
		}

		echo wp_get_attachment_image(
			$atts['banner_background_image_mobile']['id'],
			'full',
			false,
			$image_atts
		);
	} else {
		$tablet_class = 'show-tablet';
	}

	if ( ! empty( $atts['banner_background_image_tablet']['id'] ) ) {
		$desktop_class = 'show-only-desktop';

		$tablet_image = wp_get_attachment_image_src( $atts['banner_background_image_tablet']['id'], 'full', false );

		if ( $tablet_image ) {
			list( $tablet_src, $tablet_width, $tablet_height ) = $tablet_image;
			$image_atts['srcset']                              = $tablet_src;
			$image_atts['class']                               = $tablet_class;
		}

		echo wp_get_attachment_image(
			$atts['banner_background_image_tablet']['id'],
			'full',
			false,
			$image_atts
		);
	}
	$desktop_image = wp_get_attachment_image_src( $banner_img_id, 'full', false );
	if ( $desktop_image ) {
		list( $desktop_src, $desktop_width, $desktop_height ) = $desktop_image;
		$image_atts['srcset']                                 = $desktop_src;
		$image_atts['class']                                  = $desktop_class;
	}
	echo wp_get_attachment_image(
		$banner_img_id,
		'full',
		false,
		$image_atts
	);
	?>
</figure>
	<?php
}

if ( $banner_wrap ) {
	echo '<div class="' . esc_attr( $banner_wrap ) . '">';
}

/* Showing Items */
echo '<div class="' . esc_attr( implode( ' ', $wrapper_class ) ) . '">';

/* Content Animation */
$settings = array( '' );
if ( $_content_animation ) {
	$wrapper_class[] = '';
	$wrapper_class[] = 'animated-' . $content_animation_duration;
	$settings        = array(
		'_animation'       => $_content_animation,
		'_animation_delay' => $_content_animation_delay ? $_content_animation_delay : 0,
	);
	$settings        = "data-settings='" . json_encode( $settings ) . "'";
	echo '<div class="appear-animate animated-' . $content_animation_duration . '" ' . $settings . '>';
}

foreach ( $banner_item_list as $key => $item ) {
	$class = array( 'banner-item' );

	extract( // @codingStandardsIgnoreLine
		shortcode_atts(
			array(
				// Global Options.
				'_id'                 => '',
				'banner_item_display' => 'block',
				'banner_item_aclass'  => '',
				'_animation'          => '',
				'animation_duration'  => '',
				'_animation_delay'    => '',

				// Text Options.
				'banner_item_type'    => '',
				'banner_text_tag'     => 'h2',
				'banner_text_content' => '',

				// Image Options.
				'banner_image'        => '',
				'banner_image_size'   => 'full',

				// Button Options.
				'banner_btn_text'     => '',
				'banner_btn_link'     => '',
				'banner_btn_aclass'   => '',
			),
			$item
		)
	);

	$class[] = 'elementor-repeater-item-' . $_id;

	// Custom Class
	if ( $banner_item_aclass ) {
		$class[] = $banner_item_aclass;
	}

	// Animation
	$settings = '';
	if ( $_animation ) {
		$class[]   = 'appear-animate';
		$class[]   = 'animated-' . $animation_duration;
		$settings = array(
			'_animation'       => $_animation,
			'_animation_delay' => $_animation_delay ? $_animation_delay : 0,
		);
		$settings = "data-settings='" . json_encode( $settings ) . "'";
	}

	// Item display type
	if ( 'block' == $banner_item_display ) {
		$class[] = 'item-block';
	} else {
		$class[] = 'item-inline';
	}

	$floating_options = riode_elementor_common_wrapper_floating_attributes( array(), $item, isset( $this ) ? $this->get_ID() : $self->get_ID() );
	$floating_attrs   = '';
	if ( ! empty( $floating_options ) ) {
		foreach ( $floating_options as $key => $value ) {
			$floating_attrs .= $key . "='" . $value . "'";
		}

		echo '<div class="' . esc_attr( implode( ' ', $class ) ) . '" ' . $settings . '>';
		$class    = array();
		$settings = '';

		echo '<div class="floating-wrapper layer-wrapper elementor-repeater-item-' . $_id . '-wrapper" ' . $floating_attrs . '>';

		if ( 0 === strpos( $item['riode_floating'], 'mouse_tracking' ) ) {
			echo '<div class="layer">';
		}
	}

	if ( 'text' == $banner_item_type ) { // Text
		echo sprintf( '<%1$s class="' . esc_attr( implode( ' ', $class ) ) . ' text" ' . $settings . '>%2$s</%1$s>', esc_attr( $banner_text_tag ), ( function_exists( 'riode_strip_script_tags' ) ? do_shortcode( riode_strip_script_tags( $banner_text_content ) ) : do_shortcode( wp_strip_all_tags( $banner_text_content ) ) ) );

	} elseif ( 'image' == $banner_item_type ) { // Image

		echo '<div class="' . esc_attr( implode( ' ', $class ) ) . ' image" ' . $settings . '>';
		echo wp_get_attachment_image(
			$banner_image['id'],
			$banner_image_size,
			false,
			''
		);
		echo '</div>';

	} elseif ( 'button' == $banner_item_type ) { // Button

		$class[] = ' btn';
		if ( $banner_btn_aclass ) {
			$class[] = $banner_btn_aclass;
		}
		if ( ! $banner_btn_text ) {
			$banner_btn_text = esc_html__( 'Click here', 'riode-core' );
		}
		$banner_btn_text = riode_widget_button_get_label( $item, isset( $self ) ? $self : $this, $banner_btn_text );
		$class[]         = implode( ' ', riode_widget_button_get_class( $item ) );

		echo sprintf( '<a class="' . esc_attr( implode( ' ', $class ) ) . '" href="' . esc_url( $banner_btn_link['url'] ) . '" ' . $settings . '>%1$s</a>', riode_strip_script_tags( $banner_btn_text ) );

	}

	if ( ! empty( $floating_options ) ) {
		if ( 0 === strpos( $item['riode_floating'], 'mouse_tracking' ) ) {
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
	}
}

echo '</div>';

if ( $_content_animation ) {
	echo '</div>';
}

if ( $banner_wrap ) {
	echo '</div>';
}

echo  '</div>';
