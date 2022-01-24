<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Define variables
 */
define( 'RIODE_PATH', get_parent_theme_file_path() );        // template directory path
define( 'RIODE_URI', get_parent_theme_file_uri() );          // template directory uri
define( 'RIODE_ASSETS', RIODE_URI . '/assets' );             // template assets directory uri
define( 'RIODE_INC', RIODE_PATH . '/inc' );                  // template include directory path
define( 'RIODE_PLUGINS', RIODE_INC . '/plugins' );           // template plugins directory path
define( 'RIODE_PLUGINS_URI', RIODE_URI . '/inc/plugins' );   // template plugins directory uri
define( 'RIODE_CSS', RIODE_ASSETS . '/css' );                // template css uri
define( 'RIODE_JS', RIODE_ASSETS . '/js' );                  // template javascript uri
define( 'RIODE_PART', 'template_parts' );                    // template parts

define( 'RIODE_BEFORE_CONTENT', 1 );
define( 'RIODE_BEFORE_INNER_CONTENT', 2 );
define( 'RIODE_AFTER_INNER_CONTENT', 3 );
define( 'RIODE_AFTER_CONTENT', 4 );

define( 'RIODE_ADMIN', RIODE_INC . '/admin' );
define( 'RIODE_COMPATIBILITY', RIODE_INC . '/compatibilities' );

require_once RIODE_INC . '/general_function.php';
require_once RIODE_INC . '/setup/theme-options.php';


/**
 * Setup & Register Theme assets and support
 */
require_once RIODE_INC . '/setup/theme-assets.php';
require_once RIODE_INC . '/setup/theme-setup.php';

/**
 * Setup Widget Area ( Sidebar )
 */
require_once RIODE_INC . '/widget-area/widget-init.php';


/**
 * Actions, Filters, Calls,
 */
require_once RIODE_INC . '/action_filter/init.php';
require_once RIODE_INC . '/functions/init.php';


/**
 * Plugin Compatabilities
 *
 * WooCommerce
 */
require_once RIODE_INC . '/compatibilities/init.php';

/**
 * Include Add-Ons
 */
require_once RIODE_INC . '/add-on/init.php';


/**
 * Version Compatibilities
 *
 * @since 1.0.1
 */
include RIODE_COMPATIBILITY . '/version/version-compatibility.php';


/**
 * Include Admin part;
 */

if ( current_user_can( 'manage_options' ) ) {
	require_once RIODE_INC . '/admin/admin-init.php';
}


/**
 * Include Theme Walker ( Menu )
 */

if ( 'nav-menus.php' == $GLOBALS['pagenow'] || is_customize_preview() || wp_doing_ajax() ) {
	require_once RIODE_INC . '/walker/walker-init.php';
}
require_once RIODE_INC . '/walker/walker-nav-menu.php';

/**
 * Save permalinks if needed
 */
if ( get_option( 'riode_need_flush' ) ) {
	flush_rewrite_rules();
	update_option( 'riode_need_flush', false );
}

/**
 * Global Variables
 */

global $riode_breakpoints;
$riode_breakpoints['min'] = 0;
$riode_breakpoints['sm']  = 576;
$riode_breakpoints['md']  = 768;
$riode_breakpoints['lg']  = 992;
$riode_breakpoints['xl']  = 1200;

global $riode_animations;

$riode_animations = array(
	'sliderIn'  => array(
		'default'           => esc_html__( 'Default Animation', 'riode' ),
		'bounce'            => esc_html__( 'Bounce', 'riode' ),
		'flash'             => esc_html__( 'Flash', 'riode' ),
		'pulse'             => esc_html__( 'Pulse', 'riode' ),
		'rubberBand'        => esc_html__( 'RubberBand', 'riode' ),
		'shake'             => esc_html__( 'Shake', 'riode' ),
		'headShake'         => esc_html__( 'HeadShake', 'riode' ),
		'swing'             => esc_html__( 'Swing', 'riode' ),
		'tada'              => esc_html__( 'Tada', 'riode' ),
		'wobble'            => esc_html__( 'Wobble', 'riode' ),
		'jello'             => esc_html__( 'Jello', 'riode' ),
		'heartBeat'         => esc_html__( 'HearBeat', 'riode' ),
		'blurIn'            => esc_html__( 'BlurIn', 'riode' ),
		'bounceIn'          => esc_html__( 'BounceIn', 'riode' ),
		'bounceInUp'        => esc_html__( 'BounceInUp', 'riode' ),
		'bounceInDown'      => esc_html__( 'BounceInDown', 'riode' ),
		'bounceInLeft'      => esc_html__( 'BounceInLeft', 'riode' ),
		'bounceInRight'     => esc_html__( 'BounceInRight', 'riode' ),
		'fadeIn'            => esc_html__( 'FadeIn', 'riode' ),
		'fadeInUp'          => esc_html__( 'FadeInUp', 'riode' ),
		'fadeInUpBig'       => esc_html__( 'FadeInUpBig', 'riode' ),
		'fadeInDown'        => esc_html__( 'FadeInDown', 'riode' ),
		'fadeInDownBig'     => esc_html__( 'FadeInDownBig', 'riode' ),
		'fadeInLeft'        => esc_html__( 'FadeInLeft', 'riode' ),
		'fadeInLeftBig'     => esc_html__( 'FadeInLeftBig', 'riode' ),
		'fadeInRight'       => esc_html__( 'FadeInRight', 'riode' ),
		'fadeInRightBig'    => esc_html__( 'FadeInRightBig', 'riode' ),
		'flip'              => esc_html__( 'Flip', 'riode' ),
		'flipInX'           => esc_html__( 'FlipInX', 'riode' ),
		'flipInY'           => esc_html__( 'FlipInY', 'riode' ),
		'lightSpeedIn'      => esc_html__( 'LightSpeedIn', 'riode' ),
		'rotateIn'          => esc_html__( 'RotateIn', 'riode' ),
		'rotateInUpLeft'    => esc_html__( 'RotateInUpLeft', 'riode' ),
		'rotateInUpRight'   => esc_html__( 'RotateInUpRight', 'riode' ),
		'rotateInDownLeft'  => esc_html__( 'RotateInDownLeft', 'riode' ),
		'rotateInDownRight' => esc_html__( 'RotateInDownRight', 'riode' ),
		'hinge'             => esc_html__( 'Hinge', 'riode' ),
		'jackInTheBox'      => esc_html__( 'JackInTheBox', 'riode' ),
		'rollIn'            => esc_html__( 'RollIn', 'riode' ),
		'zoomIn'            => esc_html__( 'ZoomIn', 'riode' ),
		'zoomInUp'          => esc_html__( 'ZoomInUp', 'riode' ),
		'zoomInDown'        => esc_html__( 'ZoomInDown', 'riode' ),
		'zoomInLeft'        => esc_html__( 'ZoomInLeft', 'riode' ),
		'zoomInRight'       => esc_html__( 'ZoomInRight', 'riode' ),
		'slideInUp'         => esc_html__( 'SlideInUp', 'riode' ),
		'slideInDown'       => esc_html__( 'SlideInDown', 'riode' ),
		'slideInLeft'       => esc_html__( 'SlideInLeft', 'riode' ),
		'slideInRight'      => esc_html__( 'SlideInRight', 'riode' ),
	),

	'sliderOut' => array(
		'default'            => esc_html__( 'Default Animation', 'riode' ),
		'blurOut'            => esc_html__( 'BlurOut', 'riode' ),
		'bounceOut'          => esc_html__( 'BounceOut', 'riode' ),
		'bounceOutUp'        => esc_html__( 'BounceOutUp', 'riode' ),
		'bounceOutDown'      => esc_html__( 'BounceOutDown', 'riode' ),
		'bounceOutLeft'      => esc_html__( 'BounceOutLeft', 'riode' ),
		'bounceOutRight'     => esc_html__( 'BounceOutRight', 'riode' ),
		'fadeOut'            => esc_html__( 'FadeOut', 'riode' ),
		'fadeOutUp'          => esc_html__( 'FadeOutUp', 'riode' ),
		'fadeOutUpBig'       => esc_html__( 'FadeOutUpBig', 'riode' ),
		'fadeOutDown'        => esc_html__( 'FadeOutDown', 'riode' ),
		'fadeOutDownBig'     => esc_html__( 'FadeOutDownBig', 'riode' ),
		'fadeOutLeft'        => esc_html__( 'FadeOutLeft', 'riode' ),
		'fadeOutLeftBig'     => esc_html__( 'FadeOutLeftBig', 'riode' ),
		'fadeOutRight'       => esc_html__( 'FadeOutRight', 'riode' ),
		'fadeOutRightBig'    => esc_html__( 'FadeOutRightBig', 'riode' ),
		'flipOutX'           => esc_html__( 'FlipOutX', 'riode' ),
		'flipOutY'           => esc_html__( 'FlipOutY', 'riode' ),
		'lightSpeedOut'      => esc_html__( 'LightSpeedOut', 'riode' ),
		'rotateOutUpLeft'    => esc_html__( 'RotateOutUpLeft', 'riode' ),
		'rotateOutRight'     => esc_html__( 'RotateOutUpRight', 'riode' ),
		'rotateOutDownLeft'  => esc_html__( 'RotateOutDownLeft', 'riode' ),
		'rotateOutDownRight' => esc_html__( 'RotateOutDownRight', 'riode' ),
		'rollOut'            => esc_html__( 'RollOut', 'riode' ),
		'zoomOut'            => esc_html__( 'ZoomOut', 'riode' ),
		'zoomOutUp'          => esc_html__( 'ZoomOutUp', 'riode' ),
		'zoomOutDown'        => esc_html__( 'ZoomOutDown', 'riode' ),
		'zoomOutLeft'        => esc_html__( 'ZoomOutLeft', 'riode' ),
		'zoomOutRight'       => esc_html__( 'ZoomOutRight', 'riode' ),
		'slideOutUp'         => esc_html__( 'SlideOutUp', 'riode' ),
		'slideOutDown'       => esc_html__( 'SlideOutDown', 'riode' ),
		'slideOutLeft'       => esc_html__( 'SlideOutLeft', 'riode' ),
		'slideOutRight'      => esc_html__( 'SlideOutRight', 'riode' ),
	),

	'appear'    => array(
		'Riode Fading' => array(
			'fadeInDownShorter'  => esc_html__( 'Fade In Down Shorter', 'riode' ),
			'fadeInLeftShorter'  => esc_html__( 'Fade In Left Shorter', 'riode' ),
			'fadeInRightShorter' => esc_html__( 'Fade In Right Shorter', 'riode' ),
			'fadeInUpShorter'    => esc_html__( 'Fade In Up Shorter', 'riode' ),
		),
		'Blur'         => array(
			'blurIn' => esc_html__( 'BlurIn', 'riode' ),
		),
	),
);
