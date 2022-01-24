<?php
/**
 * InfoBox Shortcode Render
 *
 * @since 1.1.0
 */


// Preprocess
if ( ! empty( $atts['link'] ) && function_exists( 'vc_build_link' ) ) {
	$atts['link'] = vc_build_link( $atts['link'] );
}

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'svg_html'    => '',
			'title'       => esc_html__( 'Free Shipping & Return', 'riode-core' ),
			'description' => esc_html__( 'Free shipping on orders over $99', 'riode-core' ),
			'html_tag'    => 'h3',
			'icon_pos'    => 'left',
			'icon'        => 'd-icon-truck',
			'link'        => '',
			'class'       => '',
			'view_type'   => '',
			'shape'       => 'circle',
			'enable_svg'  => 'no',
		),
		$atts
	)
);

$icon_anim_class = '';

if ( isset( $atts['enable_hover_effect'] ) && 'yes' == $atts['enable_hover_effect'] ) {
	$icon_anim_class .= ' infobox-anim';

	if ( ! empty( $atts['icon_hover_effect'] ) && isset( $atts['icon_hover_effect'] ) ) {
		$icon_anim_class .= ' infobox-anim-' . $atts['icon_hover_effect'];
	} else {
		$icon_anim_class .= ' infobox-anim-pushup';
	}
}

$wrapper_attrs = array(
	'class' => 'riode-infobox icon-box ' . $shortcode_class . $style_class . ( 'top' == $icon_pos ? '' : ' icon-box-side ' ) . ' ' . $view_type . ' ' . $shape . ' icon-box-' . $icon_pos . $icon_anim_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}
?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>

<?php // info Box Render ?>
<?php if ( ! empty( $icon ) || 'yes' == $enable_svg ) : ?>
	<div class="icon-box-icon-wrapper">
		<span class="icon-box-icon d-inline-flex align-items-center justify-content-center">
			<?php
			if ( 'yes' == $enable_svg ) {
				if ( ! empty( $svg_html ) ) {
					$html = rawurldecode( base64_decode( wp_strip_all_tags( $svg_html ) ) );

					echo riode_escaped( $html );
				}
			} else {
				if ( ! empty( $link ) && isset( $link['url'] ) ) :
					?>
					<a href="<?php echo esc_attr( $link['url'] ); ?>" >
			<?php endif; ?>
			<i class="<?php echo esc_attr( $icon ); ?>"></i>
			<?php if ( ! empty( $link ) ) : ?>
				</a>
			<?php endif; ?>
			<?php } ?>
			
		</span>
	</div>
<?php endif; ?>
	<div class="icon-box-content">
	<?php if ( ! empty( $title ) ) : ?>
		<?php if ( ! empty( $link ) && isset( $link['url'] ) ) : ?>
			<a href="<?php echo esc_url( $link['url'] ); ?>" >
		<?php endif; ?>
		<<?php echo riode_escaped( $html_tag ); ?> class="icon-box-title"><?php echo riode_escaped( $title ); ?></<?php echo riode_escaped( $html_tag ); ?>>
		<?php if ( ! empty( $link ) ) : ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ( ! empty( $description ) ) : ?>
		<p><?php echo riode_escaped( $description ); ?></p>
	<?php endif; ?>
	</div>
</div>
<?php
