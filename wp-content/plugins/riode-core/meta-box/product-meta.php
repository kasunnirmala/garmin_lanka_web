<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode_Product_Metabox
 *
 * manages custom meta settings of products
 *
 * @since 1.4.0
 */

class Riode_Product_Metabox {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'riode_add_product_metaboxes' ) );
	}

	/**
	 * riode_add_product_metaboxes
	 *
	 * adds products meta fields to metabox list of MetaBox plugin
	 */
	function riode_add_product_metaboxes( $meta_boxes ) {
		/**
		 * Adds video for product thumbnail
		 *
		 * @since 1.0.0
		 * @since 1.4.0    add meta box under theme option
		 */
		if ( function_exists( 'riode_get_option' ) && riode_get_option( 'product_video_thumbnail' ) ) {
			$meta_boxes[] = array(
				'title'      => esc_html__( 'Riode Video Thumbnail', 'riode-core' ),
				'post_types' => array( 'product' ),
				'context'    => 'side',
				'priority'   => 'low',
				'fields'     => array(
					'video_post_image' => array(
						'name' => esc_html__( 'Video from Library', 'riode-core' ),
						'id'   => 'riode_product_video_thumbnails',
						'type' => 'video',
						'std'  => false,
					),
					'video_url'        => array(
						'name' => esc_html__( 'Video Shortcode', 'riode-core' ),
						'id'   => 'riode_product_video_thumbnail_shortcode',
						'type' => 'textarea',
						'rows' => 5,
						'std'  => false,
						'desc' => esc_html__( 'ex. [video src="url.mp4" poster="image.jpg"]', 'riode-core' ),
					),
				),
			);
		}

		/**
		 * Adds product 360 degree gallery
		 *
		 * @since 1.1.0
		 */
		if ( function_exists( 'riode_get_option' ) && riode_get_option( 'product_360_thumbnail' ) ) {
			$meta_boxes[] = array(
				'title'      => esc_html__( 'Riode 360 Degree Gallery', 'riode-core' ),
				'post_types' => array( 'product' ),
				'context'    => 'side',
				'priority'   => 'low',
				'fields'     => array(
					'video_post_image' => array(
						'id'   => 'riode_product_360_gallery',
						'type' => 'image_advanced',
						'std'  => false,
					),
				),
			);
		}

		return $meta_boxes;
	}
}

new Riode_Product_Metabox;
