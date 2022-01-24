<?php

/**
 * Riode WPB Shortcode Template
 *
 * @param string
 * @return string
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_template' ) ) {
	function riode_wpb_shortcode_template( $name = false, $path = '' ) {
		if ( ! $name ) {
			return false;
		}

		if ( $overridden_template = locate_template( 'template_parts/wpb/' . $name . '.php' ) ) {
			return $overridden_template;
		} else {
			// If neither the child nor parent theme have overridden the template,
			// we load the template from the 'templates' sub-directory of the directory this file is in
			$name = str_replace( '_', '-', $name );
			if ( empty( $path ) ) {
				return RIODE_CORE_PATH . '/wpb/elements/render/' . $name . '.php';
			} else {
				return $path . '/render/' . $name . '.php';
			}
		}
	}
}

/**
 * Riode WPB Global HashCode
 *
 * Generate hash code from attribues
 *
 * @param array $params
 *
 * @return string
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_get_global_hashcode' ) ) {
	function riode_get_global_hashcode( $atts, $tag, $params ) {
		$result = '';
		if ( is_array( $atts ) ) {
			$callback = function( $item, $key ) use ( $params ) {
				foreach ( $params as $param ) {
					if ( $param['param_name'] == $key && ! empty( $param['selectors'] ) ) {
						return true;
					}
				}
				return false;
			};
			if ( 'wpb_riode_masonry' != $tag ) {
				$atts = array_filter(
					$atts,
					$callback,
					ARRAY_FILTER_USE_BOTH
				);
			}

			$keys   = array_keys( $atts );
			$values = array_values( $atts );
			$hash   = $tag . implode( '', $keys ) . implode( '', $values );
			if ( 0 == strlen( $hash ) ) {
				return '0';
			}
			return hash( 'md5', $hash );
		}
		return '0';
	}
}

/**
 * riode_wpb_filter_element_params
 *
 * filters params following structure of WPB element params
 *
 * @param array     $unfiltered_params - required param
 * @param string    $shortcode_name    - optional param
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_filter_element_params' ) ) {
	function riode_wpb_filter_element_params( $unfiltered_params, $shortcode_name = '' ) {
		require_once RIODE_CORE_WPB . '/partials/products.php';
		require_once RIODE_CORE_WPB . '/partials/grid.php';
		require_once RIODE_CORE_WPB . '/partials/banner.php';
		require_once RIODE_CORE_WPB . '/partials/single-product.php';

		$params                 = array();
		$imagedot_param         = 'wpb_riode_carousel' == $shortcode_name;
		$product_layout_builder = 'wpb_riode_products' != $shortcode_name;

		foreach ( $unfiltered_params as $group => $group_options ) {
			if ( ! is_numeric( $group ) ) { // with group
				foreach ( $group_options as $subgroup => $options ) {
					if ( ! is_numeric( $subgroup ) ) { // with accordion
						$params[] = array(
							'type'       => 'riode_accordion_header',
							'heading'    => $subgroup,
							'param_name' => str_replace( ' ', '_', strtolower( $subgroup ) ) . '_ah',
							'group'      => $group,
						);

						foreach ( $options as $option ) {
							if ( is_string( $option ) ) {
								if ( 'riode_wpb_slider_dots_controls' == $option ) {
									$partials = call_user_func( $option, $imagedot_param );
								} elseif ( 'riode_wpb_products_layout_controls' == $option ) {
									$partials = call_user_func( $option, $product_layout_builder );
								} else {
									$partials = call_user_func( $option );
								}
								foreach ( $partials as $item ) {
									$item['group'] = $group;
									$params[]      = $item;
								}
							} else {
								$option['group'] = $group;
								$params[]        = $option;
							}
						}
					} else {
						if ( is_string( $options ) ) { // partial params
							if ( 'riode_wpb_slider_dots_controls' == $options ) {
								$partials = call_user_func( $options, $imagedot_param );
							} elseif ( 'riode_wpb_products_layout_controls' == $options ) {
								$partials = call_user_func( $options, $product_layout_builder );
							} else {
								$partials = call_user_func( $options );
							}
							foreach ( $partials as $item ) {
								$item['group'] = $group;
								$params[]      = $item;
							}
						} else { // without accordion
							$options['group'] = $group;
							$params[]         = $options;
						}
					}
				}
			} else {
				if ( is_string( $group_options ) ) { // partial params
					if ( 'riode_wpb_slider_dots_controls' == $group_options ) {
						$partials = call_user_func( $group_options, $imagedot_param );
					} elseif ( 'riode_wpb_products_layout_controls' == $group_options ) {
						$partials = call_user_func( $group_options, $product_layout_builder );
					} else {
						$partials = call_user_func( $option );
					}
					foreach ( $partials as $item ) {
						$params[] = $item;
					}
				} else { // without group
					$params[] = $group_options;
				}
			}
		}

		return $params;
	}
}

/**
 * riode_wpb_shortcode_product_id_callback
 *
 * get product id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_product_id_callback' ) ) {
	function riode_wpb_shortcode_product_id_callback( $query ) {
		if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
			$vc_vendor_wc = new Vc_Vendor_Woocommerce();
			return $vc_vendor_wc->productIdAutocompleteSuggester( $query );
		}
		return '';
	}
}

/**
 * riode_wpb_shortcode_product_id_render
 *
 * get product id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_product_id_render' ) ) {
	function riode_wpb_shortcode_product_id_render( $query ) {
		if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
			$vc_vendor_wc = new Vc_Vendor_Woocommerce();
			return $vc_vendor_wc->productIdAutocompleteRender( $query );
		}
		return '';
	}
}

/**
 * riode_wpb_shortcode_post_id_callback
 *
 * get block id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_post_id_callback' ) ) {
	function riode_wpb_shortcode_post_id_callback( $query ) {
		$query_args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
			'name__like'     => sanitize_text_field( $query ),
		);

		$query   = new WP_Query( $query_args );
		$options = array();
		if ( $query->have_posts() ) :
			$posts = $query->get_posts();
			foreach ( $posts as $p ) {
				$options[] = array(
					'value' => (int) $p->ID,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $p->post_title ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * riode_wpb_shortcode_post_id_render
 *
 * get block id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_post_id_render' ) ) {
	function riode_wpb_shortcode_post_id_render( $query ) {
		$query_args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
			'p'              => $query['value'],
		);

		$query   = new WP_Query( $query_args );
		$options = array();
		if ( $query->have_posts() ) :
			$posts = $query->get_posts();
			foreach ( $posts as $p ) {
				$options = array(
					'value' => (int) $p->ID,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $p->post_title ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * riode_wpb_shortcode_vendor_id_callback
 *
 * get block id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_vendor_id_callback' ) ) {
	function riode_wpb_shortcode_vendor_id_callback( $query ) {
		$search_value = $query;
		global $wpdb;
		$sellers = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT users.ID AS ID, users.display_name AS display_name, usermeta.meta_value as role
					FROM {$wpdb->users} AS users
					INNER JOIN {$wpdb->usermeta} AS usermeta
					ON users.ID = usermeta.user_id AND usermeta.meta_key = '" . $wpdb->get_blog_prefix() . "capabilities'
					WHERE users.user_status = 'approved' AND display_name LIKE %s",
				'%' . $wpdb->esc_like( stripslashes( $search_value ) ) . '%'
			),
			ARRAY_A
		);

		$role = 'seller';

		if ( class_exists( 'WeDevs_Dokan' ) ) {
			$role = 'seller';
		} elseif ( class_exists( 'WCMp' ) ) {
			$role = 'dc_vendor';
		} elseif ( class_exists( 'WCFMmp' ) ) {
			$role = 'wcfm_vendor';
		}

		if ( ! empty( $sellers ) ) {
			foreach ( $sellers as $seller ) {
				if ( strstr( $seller['role'], $role ) ) {
					$result[] = array(
						'value' => $seller['ID'],
						'label' => $seller['display_name'],
					);
				}
			}
		}
		return $result;
	}
}

/**
 * riode_wpb_shortcode_vendor_id_render
 *
 * get block id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_vendor_id_render' ) ) {
	function riode_wpb_shortcode_vendor_id_render( $query ) {
		$search_value = $query['value'];
		global $wpdb;
		$sellers = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT users.ID AS ID, users.display_name AS display_name, usermeta.meta_value as role
					FROM {$wpdb->users} AS users
					INNER JOIN {$wpdb->usermeta} AS usermeta
					ON users.ID = usermeta.user_id AND usermeta.meta_key = '" . $wpdb->get_blog_prefix() . "capabilities'
					WHERE users.user_status = 'approved' and users.ID = %s",
				$search_value
			),
			ARRAY_A
		);
		$role    = 'seller';

		if ( class_exists( 'WeDevs_Dokan' ) ) {
			$role = 'seller';
		} elseif ( class_exists( 'WCMp' ) ) {
			$role = 'dc_vendor';
		} elseif ( class_exists( 'WCFMmp' ) ) {
			$role = 'wcfm_vendor';
		}

		if ( ! empty( $sellers ) ) {
			foreach ( $sellers as $seller ) {
				if ( strstr( $seller['role'], $role ) ) {
					$result = array(
						'value' => $seller['ID'],
						'label' => $seller['display_name'],
					);
				}
			}
		}
		return $result;
	}
}

/**
 * riode_wpb_shortcode_block_id_callback
 *
 * get block id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_block_id_callback' ) ) {
	function riode_wpb_shortcode_block_id_callback( $query ) {
		$args = array(
			'post_type'      => 'riode_template',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
			'name__like'     => sanitize_text_field( $query ),
			'meta_query'     => array(
				array(
					'key'   => 'riode_template_type',
					'value' => 'block',
				),
			),
		);

		$query   = new WP_Query( $query_args );
		$options = array();
		if ( $query->have_posts() ) :
			$posts = $query->get_posts();
			foreach ( $posts as $p ) {
				$options[] = array(
					'value' => (int) $p->ID,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $p->post_title ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * riode_wpb_shortcode_block_id_render
 *
 * get block id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_block_id_render' ) ) {
	function riode_wpb_shortcode_block_id_render( $query ) {
		$query_args = array(
			'post_type'      => 'riode_template',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
			'p'              => $query['value'],
			'meta_query'     => array(
				array(
					'key'   => 'riode_template_type',
					'value' => 'block',
				),
			),
		);

		$query   = new WP_Query( $query_args );
		$options = array();
		if ( $query->have_posts() ) :
			$posts = $query->get_posts();
			foreach ( $posts as $p ) {
				$options = array(
					'value' => (int) $p->ID,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $p->post_title ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * riode_wpb_shortcode_category_id_callback
 *
 * get category id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_category_id_callback' ) ) {
	function riode_wpb_shortcode_category_id_callback( $query ) {
		$query_args = array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
			'name__like' => sanitize_text_field( $query ),
		);

		$terms   = get_terms( $query_args );
		$options = array();
		if ( count( $terms ) ) :
			foreach ( $terms as $term ) {
				$options[] = array(
					'value' => (int) $term->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * riode_wpb_shortcode_category_id_render
 *
 * get category id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_category_id_render' ) ) {
	function riode_wpb_shortcode_category_id_render( $query ) {
		$query_args = array(
			'taxonomy'         => 'category',
			'hide_empty'       => false,
			'term_taxonomy_id' => $query['value'],
		);

		$terms   = get_terms( $query_args );
		$options = array();
		if ( count( $terms ) ) :
			foreach ( $terms as $term ) {
				$options = array(
					'value' => (int) $term->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * riode_wpb_shortcode_product_category_id_callback
 *
 * get product_category id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_product_category_id_callback' ) ) {
	function riode_wpb_shortcode_product_category_id_callback( $query ) {
		$query_args = array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'name__like' => sanitize_text_field( $query ),
		);

		$terms   = get_terms( $query_args );
		$options = array();
		if ( count( $terms ) ) :
			foreach ( $terms as $term ) {
				$options[] = array(
					'value' => (int) $term->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * riode_wpb_shortcode_product_category_id_render
 *
 * get product_category id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_product_category_id_render' ) ) {
	function riode_wpb_shortcode_product_category_id_render( $query ) {
		$query_args = array(
			'taxonomy'         => 'product_cat',
			'hide_empty'       => false,
			'term_taxonomy_id' => $query['value'],
		);

		$terms   = get_terms( $query_args );
		$options = array();
		if ( count( $terms ) ) :
			foreach ( $terms as $term ) {
				$options = array(
					'value' => (int) $term->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				);
			}
		endif;
		return $options;
	}
}

/**
 * riode_wpb_shortcode_product_id_param_value
 *
 * get product id for wpb autocomplete
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_product_id_param_value' ) ) {
	function riode_wpb_shortcode_product_id_param_value( $current_value, $param_settings, $map_settings, $atts ) {
		if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
			$vc_vendor_wc = new Vc_Vendor_Woocommerce();
			return $vc_vendor_wc->productIdDefaultValue( $current_value, $param_settings, $map_settings, $atts );
		}
		return '';
	}
}

/**
 * riode_wpb_convert_responsive_values
 *
 * convert wpb responsive string values to valid array
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_convert_responsive_values' ) ) {
	function riode_wpb_convert_responsive_values( $key, $atts, $default = 'unset' ) {
		$res = array();

		if ( is_numeric( $default ) || 'unset' != $default ) {
			$res = array(
				$key . '_xl'     => $default,
				$key             => $default,
				$key . '_tablet' => $default,
				$key . '_mobile' => $default,
				$key . '_min'    => $default,
			);
		}

		if ( isset( $atts[ $key ] ) ) {
			$atts = json_decode( str_replace( '``', '"', $atts[ $key ] ), true );

			if ( isset( $atts['xl'] ) ) {
				$res[ $key . '_xl' ] = $atts['xl'];
			}
			if ( isset( $atts['lg'] ) ) {
				$res[ $key ] = $atts['lg'];
			} else {
				$res[ $key ] = $res[ $key . '_xl' ];
			}
			if ( isset( $atts['md'] ) ) {
				$res[ $key . '_tablet' ] = $atts['md'];
			}
			if ( isset( $atts['sm'] ) ) {
				$res[ $key . '_mobile' ] = $atts['sm'];
			}
			if ( isset( $atts['xs'] ) ) {
				$res[ $key . '_min' ] = $atts['xs'];
			}
		}

		return $res;
	}
}

/**
 * riode_wpb_shortcode_menu_id_callback
 *
 * get menu ids by ajax select 2
 *
 * @since 1.4.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_menu_id_callback' ) ) {
	function riode_wpb_shortcode_menu_id_callback( $query ) {
		$query_args = array(
			'name__like'     => sanitize_text_field( $query ),
		);

		$nav_menus = wp_get_nav_menus( $query_args );
		$menus     = array();

		if ( count( $nav_menus ) ) {
			foreach ( $nav_menus as $menu ) {
				$menus[] = array(
					'value'   => (int) $menu->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $menu->name ) )
				);
			}
		}

		return $menus;
	}
}

/**
 * riode_wpb_shortcode_menu_id_render
 *
 * get menu ids by ajax select 2
 *
 * @since 1.4.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_menu_id_render' ) ) {
	function riode_wpb_shortcode_menu_id_render( $query ) {
		$query_args = array(
			'include'     => $query['value'],
		);

		$nav_menus = wp_get_nav_menus( $query_args );
		$menus     = array();

		if ( count( $nav_menus ) ) {
			foreach ( $nav_menus as $menu ) {
				$menus = array(
					'value'   => (int) $menu->term_id,
					'label' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $menu->name ) )
				);
			}
		}

		return $menus;
	}
}
