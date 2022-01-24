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
			'title' => esc_html__( 'Free Shipping & Return', 'riode-core' ),
			'icon'  => '',
			'link'  => '',
			'class' => '',

		),
		$atts
	)
);

$wrapper_attrs = array(
	'class' => 'riode-list-item ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}
?>
<li <?php echo riode_escaped( $wrapper_attr_html ); ?>>

<?php // info Box Render ?>
<?php if ( ! empty( $icon ) ) : ?>
	<span class="list-item-icon vertical-middle">
	<?php if ( ! empty( $link ) && isset( $link['url'] ) ) : ?>
		<a href="<?php echo esc_url( $link['url'] ); ?>" >
	<?php endif; ?>
	<i class="<?php echo esc_attr( $icon ); ?>"></i>
	<?php if ( ! empty( $link ) ) : ?>
		</a>
	<?php endif; ?>
	</span>
<?php endif; ?>
	<span class="list-item-content vertical-middle">
	<?php if ( ! empty( $title ) ) : ?>
		<?php if ( ! empty( $link ) && isset( $link['url'] ) ) : ?>
			<a href="<?php echo esc_url( $link['url'] ); ?>" >
		<?php endif; ?>
		<?php echo riode_escaped( $title ); ?>
		<?php if ( ! empty( $link ) ) : ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
	</span>
</li>
<?php
