<?php
/**
 * Single Prodcut Navigation Render
 *
 * @since 1.1.0
 */

// Preprocess
$wrapper_attrs = array(
	'class' => 'riode-sp-navigation-container ' . $shortcode_class . $style_class,
);

$wrapper_attrs = apply_filters( 'riode_wpb_element_wrapper_atts', $wrapper_attrs, $atts );

$wrapper_attr_html = '';
foreach ( $wrapper_attrs as $key => $value ) {
	$wrapper_attr_html .= $key . '="' . $value . '" ';
}

?>
<div <?php echo riode_escaped( $wrapper_attr_html ); ?>>
<?php

if ( ! class_exists( 'RiodeSingleProductNavigation' ) ) {
	class RiodeSingleProductNavigation {
		public $sp_prev_icon = 'd-icon-arrow-left';
		public $sp_next_icon = 'd-icon-arrow-right';

		public function get_nav_pev_icon() {
			return $this->sp_prev_icon;
		}

		public function set_nav_prev_icon( $icon ) {
			$this->sp_prev_icon = $icon;
		}

		public function get_nav_next_icon() {
			return $this->sp_next_icon;
		}

		public function set_nav_next_icon( $icon ) {
			$this->sp_next_icon = $icon;
		}
	}
}

$riode_sp_nav = new RiodeSingleProductNavigation();

if ( ! empty( $atts['sp_prev_icon'] ) ) {
	$riode_sp_nav->set_nav_prev_icon( $atts['sp_prev_icon'] );
}
if ( ! empty( $atts['sp_next_icon'] ) ) {
	$riode_sp_nav->set_nav_next_icon( $atts['sp_next_icon'] );
}

if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {
	add_filter( 'riode_check_single_next_prev_nav', '__return_true' );
	add_filter( 'riode_single_product_nav_prev_icon', array( $riode_sp_nav, 'get_nav_pev_icon' ) );
	add_filter( 'riode_single_product_nav_next_icon', array( $riode_sp_nav, 'get_nav_next_icon' ) );

	echo '<div class="product-navigation">' . riode_single_product_navigation() . '</div>';

	remove_filter( 'riode_check_single_next_prev_nav', '__return_true' );
	remove_filter( 'riode_single_product_nav_prev_icon', array( $riode_sp_nav, 'get_nav_pev_icon' ) );
	remove_filter( 'riode_single_product_nav_next_icon', array( $riode_sp_nav, 'get_nav_next_icon' ) );

	do_action( 'riode_single_product_builder_unset_product' );
}
?>
</div>
<?php
