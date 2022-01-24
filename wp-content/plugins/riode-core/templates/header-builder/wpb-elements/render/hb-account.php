<?php
/**
 * Header Account Shortcode Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-hb-account-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

$args = array(
	'type'              => isset( $atts['type'] ) ? $atts['type'] : 'inline',
	'items'             => isset( $atts['account_items'] ) ? explode( ',', $atts['account_items'] ) : array( 'icon', 'login', 'register' ),
	'login_text'        => isset( $atts['account_login'] ) ? $atts['account_login'] : 'Log in',
	'logout_text'       => isset( $atts['account_logout'] ) ? $atts['account_logout'] : 'Log out',
	'register_text'     => isset( $atts['account_register'] ) ? $atts['account_register'] : 'Register',
	'delimiter_text'    => isset( $atts['account_delimiter'] ) ? $atts['account_delimiter'] : '/',
	'icon'              => isset( $atts['icon'] ) && $atts['icon'] ? $atts['icon'] : 'd-icon-user',
	'account_dropdown'  => isset( $atts['account_dropdown'] ) ? 'yes' == $atts['account_dropdown'] : '',
	'account_avatar'    => isset( $atts['account_avatar'] ) ? 'yes' == $atts['account_avatar'] : '',
);

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php
// HB Account Render
if ( defined( 'RIODE_VERSION' ) ) {
	riode_get_template_part( RIODE_PART . '/header/elements/element-account', null, $args );
}
?>
</div>
<?php
