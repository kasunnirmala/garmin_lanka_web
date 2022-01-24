<?php

/**
 * Riode_Product_Data_Addons class
 *
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Riode_Product_Data_Addons' ) ) {
	class Riode_Product_Data_Addons {

		public function __construct() {
			add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_product_data_tab' ), 101 );
			add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_data_panel' ), 99 );

			// Save 'Riode Extra Options'
			add_action( 'wp_ajax_riode_save_product_data_addon_options', array( $this, 'save_extra_options' ) );
			add_action( 'wp_ajax_nopriv_riode_save_product_data_addon_options', array( $this, 'save_extra_options' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1001 );
		}

		public function add_product_data_tab( $tabs ) {
			$tabs['riode_data_addon'] = array(
				'label'    => esc_html__( 'Riode Extra Options', 'riode' ),
				'target'   => 'riode_data_addons',
				'priority' => 90,
			);
			return $tabs;
		}

		public function add_product_data_panel() {
			global $thepostid;

			?>
			<div id="riode_data_addons" class="panel woocommerce_options_panel wc-metaboxes-wrapper hidden">
				<div class="wc-metaboxes">
					<div class="options-group">
						<?php
						// individual hover image change option
						$rioce_image_change_hover = get_post_meta( $thepostid, 'riode_image_change_hover', true );
						?>
						<p class="form-field riode_prevent_hover_image">
							<label><?php esc_html_e( 'Image Change on Hover', 'riode' ); ?></label>
							<select class="image-change-hover" id="riode_image_change_hover" name="riode_image_change_hover">
								<option value="" <?php selected( $rioce_image_change_hover, '' ); ?>><?php esc_html_e( 'Theme Option', 'riode' ); ?></option>
								<option value="show" <?php selected( $rioce_image_change_hover, 'show' ); ?>><?php esc_html_e( 'Change', 'riode' ); ?></option>
								<option value="hide" <?php selected( $rioce_image_change_hover, 'hide' ); ?>><?php esc_html_e( 'Do not change', 'riode' ); ?></option>
							</select>
							<?php echo wc_help_tip( esc_html__( 'This option determines whether second featured image is changed or not on hover event.', 'riode' ) ); ?>
						</p>
					</div>

					<?php if ( riode_get_option( 'sales_popup' ) ) { ?>
					<div class="options-group">
						<?php
						// individual virtual sold date time
						$riode_virtual_buy_time = get_post_meta( $thepostid, 'riode_virtual_buy_time', true );
						?>
						<p class="form-field riode-virtual-buy-time">
							<label><?php esc_html_e( 'Virtual Buy Time', 'riode' ); ?></label>
							<input type="text" id="riode_virtual_buy_time" name="riode_virtual_buy_time" value="<?php echo esc_attr( $riode_virtual_buy_time ); ?>" placeholder="YYYY-MM-DD" maxlength="10" pattern="<?php echo esc_attr( apply_filters( 'woocommerce_date_input_html_pattern', '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])' ) ); ?>" />
							<?php echo wc_help_tip( esc_html__( 'This is Virtual Buy Time for this product. This time will be shown in sales popup until this product is really sold. Track for boost sale for unsold products.', 'riode' ) ); ?>
						</p>

						<?php
						// individual virtual sold time text
						$riode_virtual_buy_time_text = get_post_meta( $thepostid, 'riode_virtual_buy_time_text', true );
						?>
						<p class="form-field riode-virtual-buy-time">
							<label><?php esc_html_e( 'Virtual Buy Time Text', 'riode' ); ?></label>
							<input type="text" id="riode_virtual_buy_time_text" name="riode_virtual_buy_time_text" value="<?php echo esc_attr( $riode_virtual_buy_time_text ); ?>" />
							<?php echo wc_help_tip( esc_html__( 'This virtual buy time text will always be shown in sales popup. Track for boost sale for this product.', 'riode' ) ); ?>
						</p>
					</div>
					<?php } ?>

					<?php if ( riode_get_option( 'product_custom_label' ) ) { ?>
					<div class="options-group">
						<div class="wc-metabox wc-metabox-template" style="display: none;">
							<h3>
								<select class="custom_label_type" class="riode_label_type" name="riode_label_type" hidden>
									<option value=""><?php esc_html_e( 'Text', 'riode' ); ?></option>
									<option value="image"><?php esc_html_e( 'Image', 'riode' ); ?></option>
								</select>
								<div class="text-controls">
									<label><?php esc_html_e( 'Custom Label:', 'riode' ); ?></label>
									<input type="text" placeholder="Label" class="label_text"  name="label_text">
									<label><?php esc_html_e( 'Background Color:', 'riode' ); ?></label>
									<input type="text" class="color-picker label_bgcolor" name="label_bgcolor" value="">
								</div>
								<a href="#" class="delete"><?php esc_html_e( 'Remove', 'riode' ); ?></a>
							</h3>
						</div>
						<div class="form-field riode_custom_labels">
							<label><?php esc_html_e( 'Custom Labels', 'riode' ); ?></label>
							<button type="button" class="button add_custom_label" id="riode_add_custom_label"><?php esc_html_e( 'Add a Label', 'riode' ); ?></button>
							<?php echo wc_help_tip( __( 'Add custom labels for this product. Custom labels will be shown just after theme supported labels.', 'riode' ) ); ?>
							<div class="wc-metaboxes ui-sortable">
							<?php
							$riode_custom_labels = get_post_meta( $thepostid, 'riode_custom_labels', true );

							if ( is_array( $riode_custom_labels ) && count( $riode_custom_labels ) ) :
								foreach ( $riode_custom_labels as $custom_label ) :
									?>
									<div class="wc-metabox wc-metabox-template">
										<h3>
											<div class="text-controls">
												<label><?php esc_html_e( 'Custom Label:', 'riode' ); ?></label>
												<input type="text" placeholder="Label" class="label_text"  name="label_text" value="<?php echo ( isset( $custom_label['label'] ) ? esc_attr( $custom_label['label'] ) : '' ); ?>">
												<label><?php esc_html_e( 'Background Color:', 'riode' ); ?></label>
												<input type="text" class="color-picker" name="label_bgcolor" value="<?php echo ( isset( $custom_label['bgColor'] ) ? esc_attr( $custom_label['bgColor'] ) : '' ); ?>">
											</div>
											<a href="#" class="delete"><?php esc_html_e( 'Remove', 'riode' ); ?></a>
										</h3>
									</div>
									<?php
								endforeach;
							endif;
							?>
							</div>
						</div>
					</div>
					<?php } ?>

					<div class="toolbar clear">
						<button type="submit" class="button-primary riode-data-addon-save" disabled="disabled"><?php esc_html_e( 'Save changes', 'riode' ); ?></button>
					</div>
				</div>
			</div>
			<?php
		}

		public function enqueue_scripts() {
			wp_enqueue_script( 'riode-product-data-addons', RIODE_ADDON_URI . '/product-data-addons/product-data-addons-admin.min.js', array(), RIODE_VERSION, true );
			wp_localize_script(
				'riode-product-data-addons',
				'riode_product_data_addon_vars',
				array(
					'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'post_id'  => get_the_ID(),
					'nonce'    => wp_create_nonce( 'riode-product-editor' ),
				)
			);
		}

		public function save_extra_options() {
			if ( ! check_ajax_referer( 'riode-product-editor', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			$post_id = $_POST['post_id'];
			$image_change_hover = isset( $_POST['image_change_hover'] ) ? riode_strip_script_tags( $_POST['image_change_hover'] ) : '';
			$virtual_buy_time = isset( $_POST['virtual_buy_time'] ) ? riode_strip_script_tags( $_POST['virtual_buy_time'] ) : '';
			$virtual_buy_time_text = isset( $_POST['virtual_buy_time_text'] ) ? riode_strip_script_tags( $_POST['virtual_buy_time_text'] ) : '';
			$custom_labels         = isset( $_POST['custom_labels'] ) ? $_POST['custom_labels'] : '';
			
			if ( $image_change_hover ) {
				update_post_meta( $post_id, 'riode_image_change_hover', $image_change_hover );
			} else {
				delete_post_meta( $post_id, 'riode_image_change_hover' );
			}
			
			if ( $virtual_buy_time ) {
				update_post_meta( $post_id, 'riode_virtual_buy_time', $virtual_buy_time );
			} else {
				delete_post_meta( $post_id, 'riode_virtual_buy_time' );
			}
			
			if ( $virtual_buy_time_text ) {
				update_post_meta( $post_id, 'riode_virtual_buy_time_text', $virtual_buy_time_text );
			} else {
				delete_post_meta( $post_id, 'riode_virtual_buy_time_text' );
			}

			if ( is_array( $custom_labels ) && count( $custom_labels ) ) {
				update_post_meta( $post_id, 'riode_custom_labels', $custom_labels );
			} else {
				delete_post_meta( $post_id, 'riode_custom_labels' );
			}

			wp_send_json_success();
			die();
		}
	}
}

new Riode_Product_Data_Addons();
