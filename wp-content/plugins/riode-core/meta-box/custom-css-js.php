<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode_Metabox_CSS_JS
 *
 * manages custom css and js settings of post/page meta box
 *
 * @since 1.4.0
 */

class Riode_Metabox_CSS_JS {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', function() {
			global $pagenow;

			// Do not add meta boxes in shop and blog page.
			if ( ( class_exists( 'WooCommerce' ) && get_the_ID() == wc_get_page_id( 'shop' ) ) || 
				get_the_ID() == get_option( 'page_for_posts' ) ) {
				return;
			}

			if ( 'post-new.php' == $pagenow || ( 'post.php' == $pagenow && isset( $_GET['action'] ) && 'edit' == $_GET['action'] ) ) {
				add_meta_box( 'riode-post-layout-meta-box', esc_html__( 'Riode Page Option', 'riode-core' ), array( $this, 'add_custom_css_js_metabox' ), null, 'advanced', 'low' );
			}
		}, 30 );

		add_action( 'save_post', array( $this, 'save_custom_css_js_metabox' ), 1, 2 );
	}


	/**
	 * add_custom_css_js_metabox
	 *
	 * adds custom css and js field to post/page metabox
	 */
	public function add_custom_css_js_metabox() {
		?>

		<div class="option riode-metabox">
			<label><?php esc_html_e( 'Custom CSS', 'riode-core' ); ?></label>
			<textarea rows="10" name="page_css" id="page_css"><?php echo wp_strip_all_tags( get_post_meta( get_the_ID(), 'page_css', true ) ); ?></textarea>
		</div>

		<?php if ( current_user_can( 'unfiltered_html' ) ) { ?>
		<div class="option riode-metabox">
			<label><?php esc_html_e( 'Custom JS', 'riode-core' ); ?></label>
			<label><b>Riode.$window.on('riode_complete', function() {</b></label>
			<textarea rows="10" name="page_js" id="page_js"><?php echo wp_strip_all_tags( get_post_meta( get_the_ID(), 'page_js', true ) ); ?></textarea>
			<label><b>})</b></label>
		</div>
		<?php } ?>

		<?php
	}


	/**
	 * save_custom_css_js_metabox
	 *
	 * saves custom css and js field of post/page metabox
	 */
	public function save_custom_css_js_metabox( $post_id, $post ) {
		if ( ! isset( $_POST['action'] ) || 'editpost' != $_POST['action'] ) {
			return;
		}

		if ( isset( $_POST['page_css'] ) && $_POST['page_css'] ) {
			update_post_meta( $post_id, 'page_css', wp_strip_all_tags( $_POST['page_css'] ) );
		} else {
			delete_post_meta( $post_id, 'page_css' );
		}

		if ( current_user_can( 'unfiltered_html' ) ) {
			if ( isset( $_POST['page_js'] ) && $_POST['page_js'] ) {
				$page_js = str_replace( ']]>', ']]&gt;', $_POST['page_js'] );
				$page_js = preg_replace( '/<script.*?\/script>/s', '', $page_js ) ? : $page_js;
				$page_js = preg_replace( '/<style.*?\/style>/s', '', $page_js ) ? : $page_js;

				update_post_meta( $post_id, 'page_js', trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $page_js ) ) );
			} else {
				delete_post_meta( $post_id, 'page_js' );
			}
		}
	}
}

new Riode_Metabox_CSS_JS;
