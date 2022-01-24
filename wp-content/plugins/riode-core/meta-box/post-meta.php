<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode_Post_Metabox
 *
 * manages custom meta settings of posts
 *
 * @since 1.4.0
 */

class Riode_Post_Metabox {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'riode_add_post_metaboxes' ) );
	}

	/**
	 * riode_add_post_metaboxes
	 *
	 * adds post meta fields to metabox list of MetaBox plugin
	 */
	function riode_add_post_metaboxes( $meta_boxes ) {
		$meta_boxes[] = array(
			'title'      => esc_html__( 'Riode Post Options', 'riode-core' ),
			'post_types' => array( 'post' ),
			'fields'     => array(
				'supported_images' => array(
					'type'              => 'file_advanced',
					'name'              => esc_html__( 'Supported Images', 'riode-core' ),
					'id'                => 'supported_images',
					'save_field'        => true,
					'label_description' => esc_html__( 'These images will be shown as slider with Featured Image.', 'riode-core' ),
				),
				'featured_video'   => array(
					'type'              => 'textarea',
					'name'              => esc_html__( 'Featured Video', 'riode-core' ),
					'id'                => 'featured_video',
					'save_field'        => true,
					'label_description' => esc_html__( 'Input embed code or use shortcodes. ex) iframe-tag or', 'riode-core' ) . ' [video src="url.mp4"]',
				),
			),
		);

		return $meta_boxes;
	}
}

new Riode_Post_Metabox;
