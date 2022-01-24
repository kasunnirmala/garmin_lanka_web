<?php

/**
 * Riode_Product_Custom_Tab_Admin class
 *
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Riode_Product_Custom_Tab_Admin' ) ) {
	class Riode_Product_Custom_Tab_Admin {

		public function __construct() {
			add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_product_data_tab' ), 101 );
			add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_data_panel' ), 99 );

			// Save 'Riode Extra Options'
			add_action( 'wp_ajax_riode_save_product_tabs_options', array( $this, 'save_tabs_options' ) );
			add_action( 'wp_ajax_nopriv_riode_save_product_tabs_options', array( $this, 'save_tabs_options' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1001 );
		}

		public function add_product_data_tab( $tabs ) {
			$tabs['riode_custom_tabs'] = array(
				'label'    => esc_html__( 'Riode Custom Description Tab ', 'riode' ),
				'target'   => 'riode_custom_tab_options',
				'priority' => 80,
			);
			return $tabs;
		}

		public function add_product_data_panel() {
			global $thepostid;
			?>
			<div id="riode_custom_tab_options" class="panel woocommerce_options_panel wc-metaboxes-wrapper hidden">
				<div class="wc-metaboxes">
					<div class="options_group" style="padding-bottom: 9px;">
						<?php
						woocommerce_wp_text_input(
							array(
								'id'    => 'riode_custom_tab_title',
								'label' => esc_html__( 'Custom Tab Title', 'riode' ),
							)
						);
						?>
						<div class="form-field riode_custom_tab_content_field">
							<label for="riode_custom_tab_title"><?php esc_html_e( 'Custom Tab Content', 'riode' ); ?></label>
							<?php
							$settings    = array(
								'textarea_name' => 'riode_custom_tab_content',
								'quicktags'     => array( 'buttons' => 'em,strong,link' ),
								'tinymce'       => array(
									'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
									'theme_advanced_buttons2' => '',
								),
							);
							$tab_content = get_post_meta( $thepostid, 'riode_custom_tab_content', true );

							wp_editor( wp_specialchars_decode( $tab_content, ENT_QUOTES ), 'riode_custom_tab_content', apply_filters( 'riode_product_custom_tab_content_editor_settings', $settings ) );
							?>
						</div>
					</div>
					<div class="options_group" style="padding-bottom: 9px;">
						<?php
						woocommerce_wp_text_input(
							array(
								'id'    => 'riode_custom_tab_title2',
								'label' => esc_html__( 'Custom Tab Title 2', 'riode' ),
							)
						);
						?>
						<div class="form-field riode_custom_tab_content_field">
							<label for="riode_custom_tab_title2"><?php esc_html_e( 'Custom Tab Content 2', 'riode' ); ?></label>
							<?php
							$settings    = array(
								'textarea_name' => 'riode_custom_tab_content2',
								'quicktags'     => array( 'buttons' => 'em,strong,link' ),
								'tinymce'       => array(
									'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
									'theme_advanced_buttons2' => '',
								),
							);
							$tab_content = get_post_meta( $thepostid, 'riode_custom_tab_content2', true );

							wp_editor( wp_specialchars_decode( $tab_content, ENT_QUOTES ), 'riode_custom_tab_content2', apply_filters( 'riode_product_custom_tab_content_editor_settings', $settings ) );
							?>
						</div>
					</div>
					<div class="toolbar clear">
						<button type="submit" class="button-primary riode-custom-tab-save" disabled="disabled"><?php esc_html_e( 'Save changes', 'riode' ); ?></button>
					</div>
				</div>
			</div>
			<?php
		}

		public function enqueue_scripts() {
			wp_enqueue_media();

			wp_enqueue_script( 'riode-product-custom-tab', RIODE_ADDON_URI . '/product-custom-tab/product-custom-tab-admin.min.js', array(), RIODE_VERSION, true );
			wp_localize_script(
				'riode-product-custom-tab',
				'riode_product_custom_tab_vars',
				array(
					'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'post_id'  => get_the_ID(),
					'nonce'    => wp_create_nonce( 'riode-product-editor' ),
				)
			);
		}

		public function save_tabs_options() {
			if ( ! check_ajax_referer( 'riode-product-editor', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}
			$post_id = $_POST['post_id'];

			// Save Tab 1
			$custom_tab_title   = isset( $_POST['custom_tab_title'] ) ? riode_strip_script_tags( $_POST['custom_tab_title'] ) : '';
			$custom_tab_content = isset( $_POST['custom_tab_content'] ) ? riode_strip_script_tags( $_POST['custom_tab_content'] ) : '';
			if ( $custom_tab_title ) {
				update_post_meta( $post_id, 'riode_custom_tab_title', $custom_tab_title );
			} else {
				delete_post_meta( $post_id, 'riode_custom_tab_title' );
			}

			if ( $custom_tab_content ) {
				update_post_meta( $post_id, 'riode_custom_tab_content', $custom_tab_content );
			} else {
				delete_post_meta( $post_id, 'riode_custom_tab_content' );
			}

			// Save Tab 2
			$custom_tab_title2   = isset( $_POST['custom_tab_title2'] ) ? riode_strip_script_tags( $_POST['custom_tab_title2'] ) : '';
			$custom_tab_content2 = isset( $_POST['custom_tab_content2'] ) ? riode_strip_script_tags( $_POST['custom_tab_content2'] ) : '';
			if ( $custom_tab_title2 ) {
				update_post_meta( $post_id, 'riode_custom_tab_title2', $custom_tab_title2 );
			} else {
				delete_post_meta( $post_id, 'riode_custom_tab_title2' );
			}

			if ( $custom_tab_content2 ) {
				update_post_meta( $post_id, 'riode_custom_tab_content2', $custom_tab_content2 );
			} else {
				delete_post_meta( $post_id, 'riode_custom_tab_content2' );
			}
			wp_send_json_success();
			die();
		}
	}
}

new Riode_Product_Custom_Tab_Admin();
