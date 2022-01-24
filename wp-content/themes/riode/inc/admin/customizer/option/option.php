<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'RIODE_OPTION', RIODE_ADMIN . '/customizer/option' );

include_once RIODE_OPTION . '/general/option-general.php';
include_once RIODE_OPTION . '/style/option-style.php';
include_once RIODE_OPTION . '/header/option-header.php';
include_once RIODE_OPTION . '/menu/option-menu.php';
include_once RIODE_OPTION . '/page_title_bar/option-ptb.php';
include_once RIODE_OPTION . '/footer/option-footer.php';
include_once RIODE_OPTION . '/share/option-share.php';
include_once RIODE_OPTION . '/blog/option-blog.php';
include_once RIODE_OPTION . '/woocommerce/option-woocommerce.php';
include_once RIODE_OPTION . '/woo-features/option-woo-features.php';
include_once RIODE_OPTION . '/404/option-404.php';
include_once RIODE_OPTION . '/advanced/option-advanced.php';
include_once RIODE_OPTION . '/custom/option-custom.php';

include_once RIODE_OPTION . '/wp/option-wp.php';
