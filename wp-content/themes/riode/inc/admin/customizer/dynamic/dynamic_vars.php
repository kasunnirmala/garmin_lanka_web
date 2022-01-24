<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$style = 'html {' . PHP_EOL;

/* Basic Layout */
$style .= '--rio-container-width: ' . riode_get_option( 'container' ) . 'px;
			--rio-container-fluid-width: ' . riode_get_option( 'container_fluid' ) . 'px;
			--rio-gutter-lg: ' . ( riode_get_option( 'gutter_lg' ) / 2 ) . 'px;
			--rio-gutter-md: ' . ( riode_get_option( 'gutter' ) / 2 ) . 'px;
			--rio-gutter-sm: ' . ( riode_get_option( 'gutter_sm' ) / 2 ) . 'px;' . PHP_EOL;

$site_type = riode_get_option( 'site_type' );
if ( 'full' != $site_type ) {
	$style .= riode_dyna_vars_bg( 'site', riode_get_option( 'screen_bg' ) );
	$style .= '--rio-site-width: ' . riode_get_option( 'site_width' ) . 'px;
				--rio-site-margin: ' . '0 auto;' . PHP_EOL;

	if ( 'boxed' == $site_type ) {
		$style .= '--rio-site-gap: ' . '0 ' . riode_get_option( 'site_gap' ) . 'px;' . PHP_EOL;
	} else {
		$style .= '--rio-site-gap: ' . riode_get_option( 'site_gap' ) . 'px;' . PHP_EOL;
	}
} else {
	$style .= riode_dyna_vars_bg( 'site', array( 'background-color' => '#fff' ) );
	$style .= '--rio-site-width: none;
				--rio-site-margin: 0;
				--rio-site-gap: 0;' . PHP_EOL;
}

$style .= riode_dyna_vars_bg( 'page-wrapper', riode_get_option( 'content_bg' ) );

/* Color & Typography */
$style .= '--rio-primary-color: ' . riode_get_option( 'primary_color' ) . ';
			--rio-secondary-color: ' . riode_get_option( 'secondary_color' ) . ';
			--rio-alert-color: ' . riode_get_option( 'alert_color' ) . ';
			--rio-success-color: ' . riode_get_option( 'success_color' ) . ';
			--rio-dark-color: ' . riode_get_option( 'dark_color' ) . ';
			--rio-light-color: ' . riode_get_option( 'light_color' ) . ';
			--rio-primary-color-hover: ' . RiodeColorLib::lighten( riode_get_option( 'primary_color' ), 6.7 ) . ';' . PHP_EOL;

$p_color_rgb = RiodeColorLib::hexToRGB( riode_get_option( 'primary_color' ), false );
$style      .= '--rio-primary-color-op-80: rgba(' . $p_color_rgb[0] . ',' . $p_color_rgb[1] . ',' . $p_color_rgb[2] . ', 0.8);
			--rio-primary-color-op-90: rgba(' . $p_color_rgb[0] . ',' . $p_color_rgb[1] . ',' . $p_color_rgb[2] . ', 0.9);' . PHP_EOL;

$style .= '--rio-secondary-color-hover: ' . RiodeColorLib::lighten( riode_get_option( 'secondary_color' ), 6.7 ) . ';
			--rio-alert-color-hover: ' . RiodeColorLib::lighten( riode_get_option( 'alert_color' ), 6.7 ) . ';
			--rio-success-color-hover: ' . RiodeColorLib::lighten( riode_get_option( 'success_color' ), 6.7 ) . ';
			--rio-dark-color-hover: ' . RiodeColorLib::lighten( riode_get_option( 'dark_color' ), 6.7 ) . ';
			--rio-light-color-hover: ' . RiodeColorLib::lighten( riode_get_option( 'light_color' ), 6.7 ) . ';' . PHP_EOL;

$style    .= riode_dyna_vars_typo( 'body', riode_get_option( 'typo_default' ) );
$body_size = riode_get_option( 'typo_default' )['font-size'];
if ( false !== strpos( $body_size, 'rem' ) || false !== strpos( $body_size, 'em' ) ) {
	$body_size = intval( str_replace( array( 'rem', 'em' ), '', $body_size ) ) * 10;
} else {
	$body_size = intval( preg_replace( '/[a~zA~Z]/', '', $body_size ) );
}

$style .= '--rio-typo-ratio: ' . floatval( $body_size / 14 ) . ';' . PHP_EOL;
$style .= riode_dyna_vars_typo( 'heading', riode_get_option( 'typo_heading' ), array( 'font-weight' => 600 ) );

/* PTB */
$style .= riode_dyna_vars_bg( 'ptb', riode_get_option( 'ptb_bg' ) );
$style .= '--rio-ptb-height: ' . riode_get_option( 'ptb_height' ) . 'px;' . PHP_EOL;
$style .= riode_dyna_vars_typo( 'ptb-title', riode_get_option( 'typo_ptb_title' ) );
$style .= riode_dyna_vars_typo( 'ptb-subtitle', riode_get_option( 'typo_ptb_subtitle' ) );
$style .= riode_dyna_vars_typo( 'ptb-breadcrumb', riode_get_option( 'typo_ptb_breadcrumb' ) );

/* Footer */
$footer_skin = riode_get_option( 'footer_skin' );
$style      .= riode_dyna_vars_bg( 'footer', riode_get_option( 'footer_bg' ) );
$style      .= '--rio-footer-link-color: ' . ( riode_get_option( 'footer_link_color' ) ? riode_get_option( 'footer_link_color' ) : ( 'dark' == $footer_skin ? '#999' : '#666' ) ) . ';' . PHP_EOL;
$style      .= '--rio-footer-link-active-color: ' . ( riode_get_option( 'footer_active_color' ) ? riode_get_option( 'footer_active_color' ) : ( 'dark' == $footer_skin ? '#fff' : 'var(--rio-primary-color)' ) ) . ';' . PHP_EOL;
$style      .= '--rio-footer-bd-color: ' . ( riode_get_option( 'footer_bd_color' ) ? riode_get_option( 'footer_bd_color' ) : ( 'dark' == $footer_skin ? '#333' : '#e1e1e1' ) ) . ';' . PHP_EOL;
$style      .= riode_dyna_vars_typo( 'footer', riode_get_option( 'typo_footer' ) );
$style      .= riode_dyna_vars_typo( 'footer-title', riode_get_option( 'typo_footer_title' ) );
$style      .= riode_dyna_vars_typo( 'footer-widget', riode_get_option( 'typo_footer_widget' ) );
$footer_bg   = riode_get_option( 'footer_bg' );
if ( ( ! isset( $footer_bg['background-image'] ) || ! $footer_bg['background-image'] ) && ( ! isset( $footer_bg['background-color'] ) || ! $footer_bg['background-color'] ) ) {
	$style .= '--rio-footer-bg-color: ' . ( 'dark' == $footer_skin ? 'var(--rio-dark-color)' : '#fff' ) . ';' . PHP_EOL;
}
if ( ! riode_get_option( 'typo_footer' )['color'] ) {
	$style .= '--rio-footer-color: #888;' . PHP_EOL;
}
if ( ! riode_get_option( 'typo_footer_title' )['color'] ) {
	$style .= '--rio-footer-title-color: ' . ( 'dark' == $footer_skin ? '#fff' : 'var(--rio-heading-color)' ) . ';' . PHP_EOL;
}
$style .= '--rio-scroll-top-size: ' . riode_get_option( 'top_button_size' ) . ';' . PHP_EOL;
if ( 'left' == riode_get_option( 'top_button_pos' ) ) {
	$style .= '--rio-scroll-top-left-position: 30px;
				--rio-scroll-top-right-position: auto;' . PHP_EOL;
} else {
	$style .= '--rio-scroll-top-left-position: auto;
				--rio-scroll-top-right-position: 30px;' . PHP_EOL;
}
$style .= '--rio-footer-top-padding-top: ' . riode_get_option( 'ft_padding' )['Padding-Top'] . 'px;
			--rio-footer-top-padding-bottom: ' . riode_get_option( 'ft_padding' )['Padding-Bottom'] . 'px;
			--rio-footer-main-padding-top: ' . riode_get_option( 'fm_padding' )['Padding-Top'] . 'px;
			--rio-footer-main-padding-bottom: ' . riode_get_option( 'fm_padding' )['Padding-Bottom'] . 'px;
			--rio-footer-bottom-padding-top: ' . riode_get_option( 'fb_padding' )['Padding-Top'] . 'px;
			--rio-footer-bottom-padding-bottom: ' . riode_get_option( 'fb_padding' )['Padding-Bottom'] . 'px;' . PHP_EOL;
$style .= '--rio-footer-top-divider: ' . ( riode_get_option( 'ft_divider' ) ? '1px solid var(--rio-footer-bd-color)' : 'none' ) . ';' . PHP_EOL;
$style .= '--rio-footer-main-divider: ' . ( riode_get_option( 'fm_divider' ) ? '1px solid var(--rio-footer-bd-color)' : 'none' ) . ';' . PHP_EOL;
$style .= '--rio-footer-bottom-divider: ' . ( riode_get_option( 'fb_divider' ) ? '1px solid var(--rio-footer-bd-color)' : 'none' ) . ';' . PHP_EOL;

/* Share Icons */
$style .= '--rio-share-custom-color: ' . riode_get_option( 'share_color' ) . ';' . PHP_EOL;

/* Menu Skins */
for ( $i = 1; $i <= 3; $i++ ) {
	// Ancestor
	$gap     = riode_get_option( 'skin' . $i . '_ancestor_gap' );
	$style  .= '--rio-menu-skin' . $i . '-ancestor-gap: ' . $gap . 'px;' . PHP_EOL;
	$padding = riode_get_option( 'skin' . $i . '_ancestor_padding' );
	$style  .= '--rio-menu-skin' . $i . '-ancestor-padding: ' . $padding['Padding-Top'] . 'px ' . $padding['Padding-Right'] . 'px ' . $padding['Padding-Bottom'] . 'px ' . $padding['Padding-Left'] . 'px;' . PHP_EOL;
	$style  .= riode_dyna_vars_typo( 'menu-skin' . $i . '-ancestor', riode_get_option( 'typo_menu_skin' . $i . '_ancestor' ) );
	$bg      = riode_get_option( 'skin' . $i . '_anc_bg' );
	if ( $bg ) {
		$style .= '--rio-menu-skin' . $i . '-ancestor-bg: ' . $bg . ';' . PHP_EOL;
	}
	$active_bg = riode_get_option( 'skin' . $i . '_anc_active_bg' );
	if ( $active_bg ) {
		$style .= '--rio-menu-skin' . $i . '-ancestor-active-bg: ' . $active_bg . ';' . PHP_EOL;
	}
	$active_color = riode_get_option( 'skin' . $i . '_anc_active_color' );
	if ( $active_color ) {
		$style .= '--rio-menu-skin' . $i . '-ancestor-active-color: ' . $active_color . ';' . PHP_EOL;
	}

	// Submenu
	$style .= riode_dyna_vars_typo( 'menu-skin' . $i . '-submenu', riode_get_option( 'typo_menu_skin' . $i . '_content' ) );
	$bg     = riode_get_option( 'skin' . $i . '_con_bg' );
	if ( $bg ) {
		$style .= '--rio-menu-skin' . $i . '-submenu-bg: ' . $bg . ';' . PHP_EOL;
	}
	$active_bg = riode_get_option( 'skin' . $i . '_con_active_bg' );
	if ( $active_bg ) {
		$style .= '--rio-menu-skin' . $i . '-submenu-active-bg: ' . $active_bg . ';' . PHP_EOL;
	}
	$active_color = riode_get_option( 'skin' . $i . '_con_active_color' );
	if ( $active_color ) {
		$style .= '--rio-menu-skin' . $i . '-submenu-active-color: ' . $active_color . ';' . PHP_EOL;
	}

	// Toggle
	$padding = riode_get_option( 'skin' . $i . '_toggle_padding' );
	$style  .= '--rio-menu-skin' . $i . '-toggle-padding: ' . $padding['Padding-Top'] . 'px ' . $padding['Padding-Right'] . 'px ' . $padding['Padding-Bottom'] . 'px ' . $padding['Padding-Left'] . 'px;' . PHP_EOL;
	$style  .= riode_dyna_vars_typo( 'menu-skin' . $i . '-toggle', riode_get_option( 'typo_menu_skin' . $i . '_toggle' ) );
	$bg      = riode_get_option( 'skin' . $i . '_tog_bg' );
	if ( $bg ) {
		$style .= '--rio-menu-skin' . $i . '-toggle-bg: ' . $bg . ';' . PHP_EOL;
	}
	$active_bg = riode_get_option( 'skin' . $i . '_tog_active_bg' );
	if ( $active_bg ) {
		$style .= '--rio-menu-skin' . $i . '-toggle-active-bg: ' . $active_bg . ';' . PHP_EOL;
	}
	$active_color = riode_get_option( 'skin' . $i . '_tog_active_color' );
	if ( $active_color ) {
		$style .= '--rio-menu-skin' . $i . '-toggle-active-color: ' . $active_color . ';' . PHP_EOL;
	}
}

/* Header */
// general
$style .= riode_dyna_vars_bg( 'header', riode_get_option( 'header_bg' ) );
$style .= riode_dyna_vars_typo( 'header', riode_get_option( 'typo_header' ) );
if ( riode_get_option( 'header_active_color' ) ) {
	$style .= '--rio-header-link-active-color: ' . riode_get_option( 'header_active_color' ) . ';' . PHP_EOL;
}

/* Lazyload Background */
$style .= '--rio-lazy-load-bg: ' . riode_get_option( 'lazyload_bg' ) . ';' . PHP_EOL;

/* Skeleton Image Ratio */
if ( 'custom' === get_option( 'woocommerce_thumbnail_cropping', '1:1' ) ) {
	$width  = (float) max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_width', '4' ) );
	$height = (float) max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_height', '3' ) );
	$style .= '--rio-skel-pro-ratio-pcnt: ' . round( $height / $width * 100 ) . '%;' . PHP_EOL;
	$style .= '--rio-skel-pro-ratio: ' . $height / $width . ';' . PHP_EOL;
} else {
	$style .= '--rio-skel-pro-ratio-pcnt: 100%;' . PHP_EOL;
	$style .= '--rio-skel-pro-ratio: 1;' . PHP_EOL;
}

/* Product Labels */
$style .= '--rio-product-top-label-color: ' . riode_get_option( 'product_top_label_bg_color' ) . ';' . PHP_EOL;
$style .= '--rio-product-sale-label-color: ' . riode_get_option( 'product_sale_label_bg_color' ) . ';' . PHP_EOL;
$style .= '--rio-product-stock-label-color: ' . riode_get_option( 'product_stock_label_bg_color' ) . ';' . PHP_EOL;
$style .= '--rio-product-new-label-color: ' . riode_get_option( 'product_new_label_bg_color' ) . ';' . PHP_EOL;
$style .= '--rio-product-thumbnail-label-color: ' . riode_get_option( 'product_thumbnail_label_bg_color' ) . ';' . PHP_EOL;

$style .= PHP_EOL . '}' . PHP_EOL;

/* Responsive */
$style .= '@media (min-width: ' . riode_get_option( 'container' ) . 'px) {
				.main-content > .wp-block-columns:not(.alignwide):not(.alignfull) {
					max-width: calc(var(--rio-container-width) - 40px + var(--rio-gutter-md) * 2);
					padding-left: 0;
					padding-right: 0;
					margin-left: auto;
					margin-right: auto;
				}
			}
			@media (min-width: ' . riode_get_option( 'container_fluid' ) . 'px) {
				.main-content > .alignwide.wp-block-columns {
					max-width: calc(var(--rio-container-fluid-width) - 40px + var(--rio-gutter-md) * 2);
					padding-left: 0;
					padding-right: 0;
					margin-left: auto;
					margin-right: auto;
				}
			}';

$style .= '@media (max-width: ' . ( riode_get_option( 'container' ) - 1 ) . 'px) and (min-width: 480px) {
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-no,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-no {
					width: calc(100% - 40px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-default,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-default {
					width: calc(100% + var(--rio-gutter-md) * 2 - 40px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-narrow,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-narrow {
					width: calc(100% + var(--rio-gutter-sm) * 2 - 40px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-extended,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-extended {
					width: calc(100% + var(--rio-gutter-lg) * 2 - 40px );
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-wide,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-wide {
					width: calc(100% + var(--rio-gutter-lg) * 2 - 30px );
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-wider,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-wider {
					width: calc(100% + var(--rio-gutter-lg) * 2 - 20px );
				}
			}

			@media (max-width: 479px) {
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-no,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-no {
					width: calc(100% - 30px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-default,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-default {
					width: calc(100% + var(--rio-gutter-md) * 2 - 30px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-narrow,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-narrow {
					width: calc(100% + var(--rio-gutter-sm) * 2 - 30px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-extended,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-extended {
					width: calc(100% + var(--rio-gutter-lg) * 2 - 30px );
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-wide,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-wide {
					width: calc(100% + var(--rio-gutter-lg) * 2 - 20px );
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-wider,
				.elementor-section-full_width .elementor-section-boxed > .elementor-column-gap-wider {
					width: calc(100% + var(--rio-gutter-lg) * 2 - 10px );
				}
			}
			.container .elementor-section.elementor-section-boxed > .elementor-column-gap-no,
			.container-fluid .elementor-section.elementor-section-boxed > .elementor-column-gap-no {
				width: 100%;
			}
			.container .elementor-section.elementor-section-boxed > .elementor-column-gap-default,
			.container-fluid .elementor-section.elementor-section-boxed > .elementor-column-gap-default {
				width: calc(100% + var(--rio-gutter-md) * 2 );
			}
			.container .elementor-section.elementor-section-boxed > .elementor-column-gap-narrow,
			.container-fluid .elementor-section.elementor-section-boxed > .elementor-column-gap-narrow {
				width: calc(100% + var(--rio-gutter-sm) * 2 );
			}
			.container .elementor-section.elementor-section-boxed > .elementor-column-gap-extended,
			.container-fluid .elementor-section.elementor-section-boxed > .elementor-column-gap-extended {
				width: calc(100% + var(--rio-gutter-lg) * 2 );
			}
			.container .elementor-section.elementor-section-boxed > .elementor-column-gap-wide,
			.container-fluid .elementor-section.elementor-section-boxed > .elementor-column-gap-wide {
				width: calc(100% + var(--rio-gutter-lg) * 2 + 10px );
			}
			.container .elementor-section.elementor-section-boxed > .elementor-column-gap-wider,
			.container-fluid .elementor-section.elementor-section-boxed > .elementor-column-gap-wider {
				width: calc(100% + var(--rio-gutter-lg) * 2 + 20px );
			}
			@media (max-width: ' . ( riode_get_option( 'container_fluid' ) - 1 ) . 'px) and (min-width: 480px) {
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-no.container-fluid {
					width: calc(100% - 40px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-default.container-fluid {
					width: calc(100% + var(--rio-gutter-md) * 2 - 40px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-narrow.container-fluid {
					width: calc(100% + var(--rio-gutter-sm) * 2 - 40px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-extended.container-fluid {
					width: calc(100% + var(--rio-gutter-lg) * 2 - 40px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-wide.container-fluid {
					width: calc(100% + var(--rio-gutter-lg) * 2 - 30px);
				}
				.elementor-top-section.elementor-section-boxed > .elementor-column-gap-wider.container-fluid {
					width: calc(100% + var(--rio-gutter-lg) * 2 - 20px);
				}
			}' . PHP_EOL;

echo preg_replace( '/[\t]+/', '', $style );
