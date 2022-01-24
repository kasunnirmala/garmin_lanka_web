<?php
/**
 * Riode Live Search
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Riode_Live_Search' ) ) :

	class Riode_Live_Search {
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'add_script' ) );
			add_action( 'wp_ajax_riode_ajax_search', array( $this, 'ajax_search' ) );
			add_action( 'wp_ajax_nopriv_riode_ajax_search', array( $this, 'ajax_search' ) );
			add_filter( 'riode_vars', array( $this, 'add_local_vars' ) );
		}

		/**
		 * adds js vars
		 *
		 * @since 1.4.0
		 */
		public function add_local_vars( $vars ) {
			$vars = array_merge_recursive(
				$vars,
				array(
					'texts' => array(
						'live_search_error' => esc_html__( 'No products were found matching your selection', 'riode' ),
					),
				)
			);

			return $vars;
		}

		public function add_script() {
			wp_register_script( 'jquery-autocomplete', RIODE_ASSETS . '/vendor/jquery.autocomplete/jquery.autocomplete.min.js', array( 'jquery-core' ), false, true );
			wp_register_script( 'riode-live-search', RIODE_ADDON_URI . '/live-search/live-search' . riode_get_js_extension(), false, RIODE_VERSION, true );

			riode_add_async_script( 'jquery-autocomplete' );
			riode_add_async_script( 'riode-live-search' );
		}

		public function ajax_search() {
			// phpcs:disable WordPress.Security.NonceVerification.NoNonceVerification
			// check_ajax_referer( 'riode-nonce', 'nonce' );

			$query = apply_filters( 'riode_live_search_query', sanitize_text_field( $_REQUEST['query'] ) );
			if ( ! empty( $_REQUEST['current_page'] ) ) {
				$current_page = $_REQUEST['current_page'];
			} else {
				$current_page = 0;
			}
			if ( ! empty( $_REQUEST['posts_per_page'] ) ) {
				$posts_per_page = apply_filters( 'riode_live_search_posts_per_page', sanitize_text_field( $_REQUEST['posts_per_page'] ) );
			} else {
				$posts_per_page = 50;
			}
			if ( ! empty( $_REQUEST['cat'] ) ) {
				$cat = $_REQUEST['cat'];
			} else {
				$cat = 0;
			}
			if ( get_transient( 'riode_full_screen_ajax_search_query' ) === $query && get_transient( 'riode_full_screen_ajax_search_cat' ) === $cat ) {
				$result = get_transient( 'riode_full_screen_ajax_search_results' );
			} else {
				$posts  = array();
				$result = array();
				$args   = array(
					's'                   => $query,
					'orderby'             => '',
					'post_status'         => 'publish',
					'posts_per_page'      => 50,
					'ignore_sticky_posts' => 1,
					'post_password'       => '',
					'suppress_filters'    => false,
				);

				if ( ! isset( $_REQUEST['post_type'] ) || empty( $_REQUEST['post_type'] ) || 'product' == $_REQUEST['post_type'] ) {
					if ( class_exists( 'WooCommerce' ) ) {
						$posts = $this->search_products( 'product', $args );
						$posts = array_merge( $posts, $this->search_products( 'sku', $args ) );
						$posts = array_merge( $posts, $this->search_products( 'tag', $args ) );
					}
					if ( ! isset( $_REQUEST['post_type'] ) || empty( $_REQUEST['post_type'] ) ) {
						$posts = array_merge( $posts, $this->search_posts( $args, $query ) );
					}
				} else {
					$posts = $this->search_posts( $args, $query, array( sanitize_text_field( $_REQUEST['post_type'] ) ) );
				}

				foreach ( $posts as $post ) {
					if ( class_exists( 'WooCommerce' ) && ( 'product' === $post->post_type || 'product_variation' === $post->post_type ) ) {
						$product       = wc_get_product( $post );
						$product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ) );
						$title         = $product->get_title();

						$result[ 'product_' . $product->get_id() ] = array(
							'type'  => 'Product',
							'id'    => $product->get_id(),
							'value' => $title ? $title : esc_html__( '(no title)', 'riode' ),
							'url'   => esc_url( $product->get_permalink() ),
							'img'   => esc_url( $product_image[0] ),
							'price' => $product->get_price_html(),
						);
					} else {
						$title = get_the_title( $post->ID );

						$result[ 'post_' . $post->ID ] = array(
							'type'  => get_post_type( $post->ID ),
							'id'    => $post->ID,
							'value' => $title ? $title : esc_html__( '(no title)', 'riode' ),
							'url'   => esc_url( get_the_permalink( $post->ID ) ),
							'img'   => esc_url( get_the_post_thumbnail_url( $post->ID, 'thumbnail' ) ),
							'price' => '',
						);
					}
				}

				// phpcs: enable
				$result = array_values( $result );
				set_transient( 'riode_full_screen_ajax_search_cat', $cat, 60 * 60 );
				set_transient( 'riode_full_screen_ajax_search_query', $query, 60 * 60 );
				set_transient( 'riode_full_screen_ajax_search_results', $result, 60 * 60 );
			}

			$pages  = ceil( count( $result ) / (int) $posts_per_page );
			$result = array_splice( $result, $current_page * $posts_per_page, $posts_per_page );

			wp_send_json(
				array(
					'suggestions' => $result,
					'pages'       => $pages,
				)
			);
			die();
		}

		private function search_posts( $args, $query, $post_type = array( 'post' ) ) {
			$args['s']         = $query;
			$args['post_type'] = apply_filters( 'riode_live_search_post_type', $post_type );
			$args              = $this->search_add_category_args( $args );

			$search_query   = http_build_query( $args );
			$search_funtion = apply_filters( 'riode_live_search_function', 'get_posts', $search_query, $args );

			return ( 'get_posts' === $search_funtion || ! function_exists( $search_funtion ) ? get_posts( $args ) : $search_funtion( $search_query, $args ) );
		}

		private function search_products( $search_type, $args ) {
			$args['post_type']  = 'product';
			$args['meta_query'] = WC()->query->get_meta_query(); // WPCS: slow query ok.
			$args               = $this->search_add_category_args( $args );

			switch ( $search_type ) {
				case 'product':
					$args['s'] = apply_filters( 'riode_live_search_products_query', sanitize_text_field( $_REQUEST['query'] ) );
					break;
				case 'sku':
					$query                = apply_filters( 'riode_live_search_products_by_sku_query', sanitize_text_field( $_REQUEST['query'] ) );
					$args['s']            = '';
					$args['post_type']    = array( 'product', 'product_variation' );
					$args['meta_query'][] = array(
						'key'   => '_sku',
						'value' => $query,
					);
					break;
				case 'tag':
					$args['s']           = '';
					$args['product_tag'] = apply_filters( 'riode_live_search_products_by_tag_query', sanitize_text_field( $_REQUEST['query'] ) );
					break;
			}

			$search_query   = http_build_query( $args );
			$search_funtion = apply_filters( 'riode_live_search_function', 'get_posts', $search_query, $args );

			return 'get_posts' === $search_funtion || ! function_exists( $search_funtion ) ? get_posts( $args ) : $search_funtion( $search_query, $args );
		}

		private function search_add_category_args( $args ) {
			if ( isset( $_REQUEST['cat'] ) && $_REQUEST['cat'] && '0' != $_REQUEST['cat'] ) {
				if ( 'product' == riode_get_option( 'search_post_type' ) ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'slug',
							'terms'    => sanitize_text_field( $_REQUEST['cat'] ),
						),
					);
				} elseif ( 'post' == riode_get_option( 'search_post_type' ) ) {
					$args['category'] = get_terms( array( 'slug' => sanitize_text_field( $_REQUEST['cat'] ) ) )[0]->term_id;
				}
			}
			return $args;
		}
	}
endif;

new Riode_Live_Search;
