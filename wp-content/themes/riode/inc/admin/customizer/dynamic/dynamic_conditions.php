<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
global $riode_used_elements;

// Available Post Types
$available_post_types = apply_filters(
	'riode_optimize_available_post_types',
	array(
		'post',
		'page',
		'wp_block',
		'elementor_library',
		'product',
		'product_variation',
		'riode_template',
		'wpcf7_contact_form',
	)
);

// Component Patterns
$component_patterns = array(
	'accordion'              => 1,
	'banner'                 => array(
		'b' => '[wpb_riode_banner',
		'e' => array( '"use_as":"banner"', 'riode_widget_banner' ),
		'v' => '"riodeBanner"',
	),
	'btn'                    => array(
		'b' => '[wpb_riode_button',
		'e' => '"btn"',
		'g' => '"btn"',
		'v' => '"btn"',
		'c' => 'btn',
	),
	'carousel'               => 1,
	'category-type-default'  => array(
		'b' => '[wpb_riode_categories',
		'e' => '"category_type":""',
		'v' => '"categoryType":""',
		'g' => '"category_type":""',
		'c' => false,
	),
	'category-type-classic'  => array(
		'b' => array(
			'[wpb_riode_categories',
			'category_type="classic"',
		),
		'e' => '"category_type":"classic"',
		'v' => '"categoryType":"classic"',
		'g' => '"category_type":"classic"',
		'c' => false,
	),
	'category-type-simple'   => array(
		'b' => array(
			'[wpb_riode_categories',
			'category_type="simple"',
		),
		'e' => '"category_type":"simple"',
		'v' => '"categoryType":"simple"',
		'g' => '"category_type":"simple"',
		'c' => false,
	),
	'category-type-icon'     => array(
		'b' => array(
			'[wpb_riode_categories',
			'category_type="icon"',
		),
		'e' => '"category_type":"icon"',
		'v' => '"categoryType":"icon"',
		'g' => '"category_type":"icon"',
		'c' => false,
	),
	'category-type-ellipse'  => array(
		'b' => array(
			'[wpb_riode_categories',
			'category_type="ellipse"',
		),
		'e' => '"category_type":"ellipse"',
		'v' => '"categoryType":"ellipse"',
		'g' => '"category_type":"ellipse"',
		'c' => false,
	),
	'category-type-ellipse2' => array(
		'b' => array(
			'[wpb_riode_categories',
			'category_type="ellipse-2"',
		),
		'e' => '"category_type":"ellipse-2"',
		'v' => '"categoryType":"ellipse-2"',
		'c' => false,
	),
	'category-type-group'    => array(
		'b' => array(
			'[wpb_riode_categories',
			'category_type="group"',
		),
		'e' => '"category_type":"group"',
		'v' => '"categoryType":"group"',
		'g' => '"category_type":"group"',
		'c' => false,
	),
	'category-type-group-2'  => array(
		'b' => array(
			'[wpb_riode_categories',
			'category_type="group-2"',
		),
		'e' => '"category_type":"group-2"',
		'v' => '"categoryType":"group-2"',
		'g' => '"category_type":"group-2"',
		'c' => false,
	),
	'category-type-banner'   => array(
		'b' => array(
			'[wpb_riode_categories',
			'category_type="banner"',
		),
		'e' => '"category_type":"banner"',
		'v' => '"categoryType":"banner"',
		'g' => '"category_type":"banner"',
		'c' => false,
	),
	'category-type-badge'    => array(
		'b' => array(
			'[wpb_riode_categories',
			'category_type="badge"',
		),
		'e' => '"category_type":"badge"',
		'v' => '"categoryType":"badge"',
		'g' => '"category_type":"badge"',
		'c' => false,
	),
	'countdown'              => array(
		'b' => '[wpb_riode_countdown',
		'e' => '"riode_widget_countdown"',
		'v' => '"riodeCounterDown"',
		// 'c' => false,
	),
	'hotspot'                => array(
		'b' => '[wpb_riode_hotspot',
		'e' => 'riode_widget_hotspot',
		'v' => 'riodeHotSpot',
		'c' => false,
	),
	'icon-box'               => array(
		'b' => '[wpb_riode_infobox',
		'g' => 'wp:riode/riode-icon-box',
		'v' => '"riodeInfoBox"',
		'c' => 0, // Do not find class
	),
	'image-box'              => array(
		'b' => '[wpb_riode_image_box',
		'e' => 'riode_widget_imagebox',
		// 'c' => false,
	),
	'tab'                    => array(
		'b' => '[wpb_riode_tab',
		'e' => '"use_as":"tab"',
		'v' => '"riodeTab"',
	),
	'testimonial'            => array(
		'b' => '[wpb_riode_testimonial',
		'e' => 'riode_widget_testimonial',
		'v' => '"riodeTestimonial"',
	),
	'title'                  => array(
		'b' => '[wpb_riode_heading',
		'e' => '"title"',
		'g' => '"title"',
		'v' => '"title"',
	),
	'product-classic'        => array(
		'b' => 'product_type="classic"',
		'e' => '"product_type":"classic"',
		'v' => '"productType":"classic"',
		'g' => '"product_type":"classic"',
		'c' => 'product-classic',
	),
	'product-list'           => 1,
);

// Shortcode Patters
$shortcode_patterns = array(
	'wpcf7' => '[contact-form-7',
);

// Helper classes
$helper_classes = array(
	'instagram',
	'w-25',
	'w-50',
	'w-75',
	'w-100',
	'h-100',
	'd-none',
	'd-block',
	'd-inline-block',
	'd-flex',
	'd-inline-flex',
	'justify-content-center',
	'justify-content-start',
	'justify-content-end',
	'justify-content-between',
	'align-items-start',
	'align-items-center',
	'align-items-end',
	'flex-column',
	'flex-wrap',
	'flex-1',
	'overflow-hidden',
	'vertical-top',
	'vertical-main',
	'vertical-bottom',
	'd-sm-none',
	'd-sm-block',
	'd-sm-flex',
	'd-md-none',
	'd-md-block',
	'd-md-flex',
	'd-lg-none',
	'd-lg-block',
	'd-lg-flex',
	'd-xl-none',
	'd-xl-block',
	'd-xl-flex',
	'font-primary',
	'font-secondary',
	'font-tertiary',
	'font-weight-bold',
	'font-weight-semi-bold',
	'font-weight-normal',
	'text-uppercase',
	'text-capitalize',
	'text-normal',
	'font-italic',
	'font-normal',
	'text-white',
	'text-light',
	'text-grey',
	'text-body',
	'text-primary',
	'text-secondary',
	'text-success',
	'text-alert',
	'text-light',
	'text-dark',
	'text-black',
	'ls-s',
	'ls-m',
	'ls-l',
	'ls-normal',
	'lh-1',
	'bg-white',
	'bg-dark',
	'bg-grey',
	'bg-light',
	'bg-black',
	'bg-primary',
	'bg-secondary',
	'border-no',
	'order-first',
	'order-last',
	'order-sm-auto',
	'order-sm-first',
	'order-sm-last',
	'order-md-auto',
	'order-md-first',
	'order-md-last',
	'order-lg-auto',
	'order-lg-first',
	'order-lg-last',
	'col-lg-1-5',
	'col-lg-2-5',
	'col-lg-3-5',
	'col-lg-4-5',
	'pr-0',
	'pt-4',
	'pl-0',
	'pb-0',
	'pb-10',
	'mb-1',
	'mb-4',
	'mb-6',
	'text-center',
	'col-lg-4',
	'col-lg-5',
	'col-lg-7',
	'col-lg-8',
	'col-md-6',
	'pr-lg-4',
	'mb-0',
	'mt-2',
);

// Used Components and classes
$used_classes = array(
	'mt-8',
	'ml-auto',
	'mr-auto',
	'mr-1',
	'mr-2',
	'mr-4',
	'mb-0',
	'mb-2',
	'mb-3',
	'mb-4',
	'mb-5',
	'mb-6',
	'mb-8',
	'mt-2',
	'pt-1',
	'pr-0',
	'pb-10',
	'ls-m',
	'd-none',
	'd-lg-none',
	'd-inline-block',
	'font-primary',
	'text-normal',
	'text-primary',
	'order-lg-last',
	'cols-1',
	'cols-2',
	'cols-3',
	'cols-4',
	'cols-sm-1',
	'cols-sm-2',
	'cols-sm-3',
	'cols-sm-4',
	'cols-md-1',
	'cols-md-2',
	'cols-md-3',
	'cols-md-4',
	'cols-md-6',
	'cols-lg-1',
	'cols-lg-2',
	'cols-lg-3',
	'cols-lg-4',
	'cols-lg-5',
	'cols-lg-6',
	'cols-lg-7',
	'cols-lg-8',
	'cols-xl-2',
	'col-sm-1',
	'col-md-3',
	'col-md-6',
	'col-lg-3',
	'col-lg-4',
	'col-lg-6',
	'col-lg-8',
	'pr-0',
	'pt-4',
	'pl-0',
	'pb-0',
	'pb-10',
	'mb-1',
	'mb-4',
	'mb-6',
	'text-center',
	'pr-lg-4',
	'mb-0',
	'mt-2',
	'flex-none',
	'w-auto',
	'p-absolute',
	't-mc',
	'col-lg-5',
	'col-lg-7',
	'col-md-3',
	'col-md-9',
);

// Initialize
foreach ( $component_patterns as $class => $pattern ) {
	if ( ! isset( $riode_used_elements[ $class ] ) ) {
		$riode_used_elements[ $class ] = false;
	}
}

// Step 2 : Check theme option
$riode_used_elements['product-classic']       = boolval( 'classic' == riode_get_option( 'product_type' ) );
$riode_used_elements['product-list']          = true;
$riode_used_elements['category-type-default'] = boolval( '' == riode_get_option( 'category_type' ) );
$riode_used_elements['category-type-classic'] = boolval( 'classic' == riode_get_option( 'category_type' ) );
$riode_used_elements['category-type-icon']    = boolval( 'icon' == riode_get_option( 'category_type' ) );
$riode_used_elements['category-type-ellipse'] = boolval( 'ellipse' == riode_get_option( 'category_type' ) );
$riode_used_elements['category-type-group']   = boolval( 'group' == riode_get_option( 'category_type' ) );
$riode_used_elements['category-type-group-2'] = boolval( 'group-2' == riode_get_option( 'category_type' ) );
$riode_used_elements['category-type-banner']  = boolval( 'banner' == riode_get_option( 'category_type' ) );
$riode_used_elements['category-type-badge']   = boolval( 'badge' == riode_get_option( 'category_type' ) );

$riode_used_elements['carousel']  = true;
$riode_used_elements['accordion'] = true;

// Editor
$riode_used_elements['wpbakery']  = false;
$riode_used_elements['elementor'] = false;
$riode_used_elements['gutenberg'] = false;
$riode_used_elements['dokan']     = defined( 'DOKAN_PLUGIN_VERSION' ) ? true : false;

// Find all posts and classes
$all_classes = '';
foreach ( $available_post_types as $post_type ) {
	$posts = new WP_Query;
	$posts = $posts->query(
		array(
			'posts_per_page' => -1,
			'post_type'      => $post_type,
			'post_status'    => 'publish',
		)
	);

	foreach ( $posts as $post ) {
		$content      = $post->post_content;
		$classes      = riode_dynamic_get_classes( '/class="([^"]*)"/', $content );
		$is_gutenburg = true;

		if ( 'wpcf7_contact_form' == $post_type ) {
			$classes .= riode_dynamic_get_classes( '/class:([^ ]*)/', $content );
		}

		// WPBakery Editor
		if ( defined( 'WPB_VC_VERSION' ) ) {
			$riode_used_elements['wpbakery'] = true;

			$classes .= riode_dynamic_get_classes( '/extra_class="([^"]*)"/', $content );
			$classes .= riode_dynamic_get_classes( '/el_class="([^"]*)"/', $content );

			foreach ( $component_patterns as $key => $pattern ) {
				if ( $riode_used_elements[ $key ] ) {
					continue;
				}
				if ( is_array( $pattern ) ) {
					if ( isset( $pattern['b'] ) ) {
						if ( is_array( $pattern['b'] ) ) {
							foreach ( $pattern['b'] as $e_pattern ) {
								if ( strpos( $content, $e_pattern ) > 0 ) {
									$riode_used_elements[ $key ] = true;
								}
							}
						} elseif ( strpos( $content, $pattern['b'] ) > 0 ) {
							$riode_used_elements[ $key ] = true;
						}
					}
				}
			}
		}

		// Elementor Editor
		if ( defined( 'ELEMENTOR_VERSION' ) && get_post_meta( $post->ID, '_elementor_edit_mode', true ) ) {
			$is_gutenburg                     = false;
			$riode_used_elements['elementor'] = true;

			$data     = get_post_meta( $post->ID, '_elementor_data', true );
			$classes .= riode_dynamic_get_classes( '/class=\\\"([^"]*)\\\"/', $data );
			$classes .= riode_dynamic_get_classes( '/"_css_classes":"([^"]*)"/', $data );
			$classes .= riode_dynamic_get_classes( '/"css_classes":"([^"]*)"/', $data );
			$classes .= riode_dynamic_get_classes( '/"btn_class":"([^"]*)"/', $data );
			$classes .= riode_dynamic_get_classes( '/"banner_item_aclass":"([^"]*)"/', $data );

			foreach ( $component_patterns as $key => $pattern ) {
				if ( $riode_used_elements[ $key ] ) {
					continue;
				}
				if ( is_array( $pattern ) ) {
					if ( isset( $pattern['e'] ) ) {
						if ( is_array( $pattern['e'] ) ) {
							foreach ( $pattern['e'] as $e_pattern ) {
								if ( strpos( $data, $e_pattern ) > 0 ) {
									$riode_used_elements[ $key ] = true;
								}
							}
						} elseif ( strpos( $data, $pattern['e'] ) > 0 ) {
							$riode_used_elements[ $key ] = true;
						}
					}
				}
			}

			if ( ! $riode_used_elements['testimonial-simple'] ) {
				$dwtc = substr_count( $data, 'riode_widget_testimonial' );
				if ( $dwtc > 0 && $dwtc - substr_count( $data, '"testimonial_type":"boxed"' ) - substr_count( $data, '"testimonial_type":"custom"' ) > 0 ) {
					$riode_used_elements['testimonial-simple'] = true;
				}
			}


			// cols classes in shortcodes (elementor)
			$matches = array();
			preg_match_all( '/"col_cnt":"([1-8])"/', $data, $matches, PREG_SET_ORDER );
			foreach ( $matches as $match ) {
				array_push( $used_classes, 'cols-lg-' . intval( $match[1] ) );
			}
			preg_match_all( '/"col_cnt_xl":"([1-8])"/', $data, $matches, PREG_SET_ORDER );
			foreach ( $matches as $match ) {
				array_push( $used_classes, 'cols-xl-' . intval( $match[1] ) );
			}
			preg_match_all( '/"col_cnt_tablet":"([1-8])"/', $data, $matches, PREG_SET_ORDER );
			foreach ( $matches as $match ) {
				array_push( $used_classes, 'cols-md-' . intval( $match[1] ) );
			}
			preg_match_all( '/"col_cnt_mobile":"([1-8])"/', $data, $matches, PREG_SET_ORDER );
			foreach ( $matches as $match ) {
				array_push( $used_classes, 'cols-sm-' . intval( $match[1] ) );
			}
			preg_match_all( '/"col_cnt_min":"([1-8])"/', $data, $matches, PREG_SET_ORDER );
			foreach ( $matches as $match ) {
				array_push( $used_classes, 'cols-' . intval( $match[1] ) );
			}
		}

		// Gutenberg Editor
		if ( $is_gutenburg ) {
			$riode_used_elements['gutenberg'] = true;
			$classes                         .= riode_dynamic_get_classes( '/"className":"([^"]*)"/', $content );
			$classes                         .= riode_dynamic_get_classes( '/"icon_class":"([^"]*)"/', $content );

			foreach ( $component_patterns as $key => $pattern ) {
				if ( ! $riode_used_elements[ $key ] ) {
					continue;
				}
				if ( is_array( $pattern ) ) {
					if ( isset( $pattern['g'] ) && false !== strpos( $content, $pattern['g'] ) ) {
						$riode_used_elements[ $key ] = true;
					}
				}
			}
		}

		// cols classes in shortcodes (vc)
		$matches = array();
		preg_match_all( '/col_cnt=([1-8])/', $content, $matches, PREG_SET_ORDER );
		foreach ( $matches as $match ) {
			array_push( $used_classes, 'cols-lg-' . intval( $match[1] ) );
		}
		preg_match_all( '/col_cnt_xl=([1-8])/', $content, $matches, PREG_SET_ORDER );
		foreach ( $matches as $match ) {
			array_push( $used_classes, 'cols-xl-' . intval( $match[1] ) );
		}
		preg_match_all( '/col_cnt_tablet=([1-8])/', $content, $matches, PREG_SET_ORDER );
		foreach ( $matches as $match ) {
			array_push( $used_classes, 'cols-md-' . intval( $match[1] ) );
		}
		preg_match_all( '/col_cnt_mobile=([1-8])/', $content, $matches, PREG_SET_ORDER );
		foreach ( $matches as $match ) {
			array_push( $used_classes, 'cols-sm-' . intval( $match[1] ) );
		}
		preg_match_all( '/col_cnt_min=([1-8])/', $content, $matches, PREG_SET_ORDER );
		foreach ( $matches as $match ) {
			array_push( $used_classes, 'cols-' . intval( $match[1] ) );
		}

		// Find shortcodes in content
		foreach ( $shortcode_patterns as $key => $shortcode ) {
			if ( isset( $riode_used_elements[ $key ] ) && ! $riode_used_elements[ $key ] && false !== strpos( $content, $shortcode ) ) {
				$riode_used_elements[ $key ] = true;
			}
		}

		// Find classes in content
		foreach ( $component_patterns as $key => $pattern ) {
			if ( $riode_used_elements[ $key ] ) {
				continue;
			}
			if ( is_array( $pattern ) && isset( $pattern['c'] ) && $pattern['c'] && strpos( $classes, $pattern['c'] ) > 0 ) {
				$riode_used_elements[ $key ] = true;
			} elseif ( strpos( $classes, $key ) > 0 ) {
				$riode_used_elements[ $key ] = true;
			}
		}

		$all_classes .= $classes;
	}
}
foreach ( $used_classes as $class ) {
	$riode_used_elements[ $class ] = true;
}
if ( $all_classes ) { // margin, padding, col-*
	preg_match_all( '/(mt-|mr-|mb-|ml-|pt-|pr-|pb-|pl-)(|sm-|md-|lg-|xl-)(1?\d)/', $all_classes, $matches, PREG_SET_ORDER );
	foreach ( $matches as $match ) {
		$riode_used_elements[ $match[0] ] = true;
	}
	preg_match_all( '/cols-(|xs-|sm-|md-|xl-)(\d)/', $all_classes, $matches, PREG_SET_ORDER ); // "cols-lg-*" are all used.
	foreach ( $matches as $match ) {
		$riode_used_elements[ $match[0] ] = true;
	}
	preg_match_all( '/col-(|xs-|sm-|md-|lg-|xl-)(1?\d)/', $all_classes, $matches, PREG_SET_ORDER );
	foreach ( $matches as $match ) {
		$riode_used_elements[ $match[0] ] = true;
	}
	foreach ( $helper_classes as $class ) {
		if ( ! ( isset( $riode_used_elements[ $class ] ) && $riode_used_elements[ $class ] ) &&
			false !== strpos( $all_classes, $class ) ) {

			$riode_used_elements[ $class ] = true;
		}
	}
}


function riode_dynamic_get_classes( $pattern, $data ) {
	$classes = '';
	preg_match_all( $pattern, $data, $matches, PREG_SET_ORDER );
	foreach ( $matches as $match ) {
		if ( $match[1] ) {
			$classes .= ' ' . $match[1];
		}
	}
	return $classes;
}
