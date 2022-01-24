<?php
/**
 * Prints posts and terms in Elementor Frontend editor
 *
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Riode_Elementor_Ajax_Select2_Api {

	public function action( $request ) {
		if ( isset( $request['method'] ) && in_array( $request['method'], array( 'page', 'post', 'product', 'riode_template' ) ) ) {
			return $this->get_posts( $request );
		} elseif ( isset( $request['method'] ) && in_array( $request['method'], array( 'product_cat', 'category' ) ) ) {
			return $this->get_terms( $request );
		} elseif ( isset( $request['method'] ) && 'vendors' == $request['method'] ) {
			return $this->get_vendors();
		}
	}

	public function get_vendors() {
		$query_args = [
			'role'       => array( 'seller' ),
			'number'     => 10,
			'offset'     => 0,
			'orderby'    => 'registered',
			'order'      => 'ASC',
			'status'     => 'approved',
			'featured'   => '', // yes or no
			'meta_query' => [],
		];

		if ( class_exists( 'WeDevs_Dokan' ) ) {
			$query_args['role'] = array( 'seller' );
		} elseif ( class_exists( 'WCMp' ) ) {
			$query_args['role'] = array( 'dc_vendor' );
		} elseif ( class_exists( 'WCFMmp' ) ) {
			$query_args['role'] = array( 'wcfm_vendor' );
		}

		if ( isset( $this->request['ids'] ) ) {
			$ids                   = $this->request['ids'];
			$query_args['include'] = $ids;

			if ( '' == $this->request['ids'] ) {
				return [ 'results' => [] ];
			}
		}

		if ( isset( $this->request['s'] ) ) {
			$query_args['s'] = $this->request['s'];
		}

		$query   = new WP_User_Query( $query_args );
		$results = $query->get_results();

		foreach ( $results as $result ) {
			if ( is_numeric( $result ) ) {
				$the_user = get_user_by( 'id', $result );

				if ( $the_user ) {
					$options[] = array(
						'id'   => $the_user->ID,
						'text' => $the_user->display_name,
					);
				}
			} elseif ( is_a( $result, 'WP_User' ) ) {
				$options[] = array(
					'id'   => $result->ID,
					'text' => $result->display_name,
				);
			}
		}

		return [ 'results' => $options ];
		wp_reset_postdata();
	}

	public function get_posts( $request ) {
		$query_args = [
			'post_type'      => sanitize_text_field( $request['method'] ),
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		];

		if ( isset( $request['ids'] ) ) {
			if ( empty( $request['ids'] ) ) {
				return [ 'results' => [] ];
			}
			$query_args['post__in'] = explode( ',', sanitize_text_field( $request['ids'] ) );
			$query_args['orderby']  = 'post__in';
			$query_args['order']    = 'ASC';
		}
		if ( isset( $request['s'] ) ) {
			$query_args['s'] = sanitize_text_field( $request['s'] );
		}
		if ( 'riode_template' == $request['method'] ) {
			$query_args['meta_query'] = [
				[
					'key'   => 'riode_template_type',
					'value' => 'block',
				],
			];
		}

		$query   = new WP_Query( $query_args );
		$options = [];
		if ( $query->have_posts() ) :
			if ( isset( $request['add_none'] ) ) {
				$options[] = array(
					'id'   => '',
					'text' => esc_html__( 'Select...', 'riode-core' ),
				);
			}
			$posts = $query->get_posts();
			foreach ( $posts as $p ) {
				$options[] = [
					'id'   => (int) $p->ID,
					'text' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $p->post_title ) ),
				];
			}
		endif;
		return [ 'results' => $options ];
	}

	public function get_terms( $request ) {
		if ( ! taxonomy_exists( sanitize_text_field( $request['method'] ) ) ) {
			return [ 'results' => [] ];
		}
		$query_args = [
			'taxonomy'   => sanitize_text_field( $request['method'] ),
			'hide_empty' => false,
		];

		if ( isset( $request['ids'] ) ) {
			if ( empty( $request['ids'] ) ) {
				return [ 'results' => [] ];
			}
			$query_args['include'] = explode( ',', sanitize_text_field( $request['ids'] ) );
			$query_args['orderby'] = 'include';
			$query_args['order']   = 'ASC';
		}
		if ( isset( $request['s'] ) ) {
			$query_args['name__like'] = sanitize_text_field( $request['s'] );
		}

		$terms   = get_terms( $query_args );
		$options = [];
		if ( count( $terms ) ) :
			if ( isset( $request['add_none'] ) ) {
				$options[] = array(
					'id'   => '',
					'text' => esc_html__( 'Default', 'riode-core' ),
				);
			}
			foreach ( $terms as $term ) {
				$options[] = [
					'id'   => (int) $term->term_id,
					'text' => str_replace( array( '&amp;', '&#039;' ), array( '&', '\'' ), esc_html( $term->name ) ),
				];
			}
		endif;
		return [ 'results' => $options ];
	}
}

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'ajaxselect2/v1',
			'/(?P<method>\w+)/',
			array(
				'methods'             => 'GET',
				'callback'            => 'riode_elementor_ajax_select2_api',
				'permission_callback' => '__return_true',
			)
		);
	}
);

function riode_elementor_ajax_select2_api( WP_REST_Request $request ) {
	$class = new Riode_Elementor_Ajax_Select2_Api();
	return $class->action( $request );
}
