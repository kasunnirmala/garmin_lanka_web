<?php
/**
 * Riode Product Image Swatch Tab for Admin
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Riode_Image_Swatch_Tab' ) ) {
	class Riode_Image_Swatch_Tab {

		public function __construct() {
			add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_product_data_tab' ), 99 );
			add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_data_panel' ), 99 );

			// Save Riode Swatch Options
			add_action( 'wp_ajax_riode_save_product_swatch_options', array( $this, 'save_swatch_options' ) );
			add_action( 'wp_ajax_nopriv_riode_save_product_swatch_options', array( $this, 'save_swatch_options' ) );
			add_action( 'wp_ajax_riode_refresh_product_swatch_options', array( $this, 'refresh_swatch_options' ) );
			add_action( 'wp_ajax_nopriv_riode_refresh_product_swatch_options', array( $this, 'refresh_swatch_options' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1001 );
		}

		public function add_product_data_tab( $tabs ) {
			$tabs['swatch'] = array(
				'label'    => esc_html__( 'Riode Attribute Swatches', 'riode' ),
				'target'   => 'swatch_product_options',
				'class'    => array( 'show_if_variable' ),
				'priority' => 80,
			);
			return $tabs;
		}

		public function add_product_data_panel() {
			global $product_object;

			$attributes     = array_filter(
				$product_object->get_attributes(),
				function( $attr ) {
					return true === $attr->get_variation();
				}
			);

			$swatch_options = wc_get_product( $product_object->get_Id() )->get_meta( 'swatch_options', true );
			if ( $swatch_options ) {
				$swatch_options = json_decode( $swatch_options, true );
			} else {
				$swatch_options = array();
			}
			?>
			<div id="swatch_product_options" class="panel wc-metaboxes-wrapper woocommerce_options_panel hidden">
				<div class="wc-metaboxes">
				<?php
				if ( ! count( $attributes ) ) :
					?>

					<div id="message" class="inline notice riode-wc-message">
						<p><?php printf( esc_html__( 'Before you can add image swatch you need to add some %1$slist%2$s variation attributes on the %1$sAttributes%2$s tab.', 'riode' ), '<strong>', '</strong>' ); ?></p>
						<p><a class="button-primary" href="<?php echo apply_filters( 'woocommerce_docs_url', esc_url( 'https://docs.woocommerce.com/document/variable-product/' ), 'product-variations' ); ?>" target="_blank"><?php esc_html_e( 'Learn more', 'riode' ); ?></a></p>
					</div>

					<?php
				else :
					foreach ( $attributes as $attribute ) :
						$attribute_obj = $attribute->get_taxonomy_object();

						$metabox_class = array();
						if ( $attribute->is_taxonomy() ) {
							$metabox_class[] = 'taxonomy';
							$metabox_class[] = $attribute->get_name();
							$taxonomy        = $attribute->get_taxonomy();
						} else {
							$taxonomy = strtolower( preg_replace( '/\s+/', '_', $attribute->get_name() ) );
						}

						$swatch_type = isset( $swatch_options[ $taxonomy ] ) && isset( $swatch_options[ $taxonomy ]['type'] ) ? $swatch_options[ $taxonomy ]['type'] : 'default';
						?>
							<div data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>" class="woocommerce_attribute wc-metabox closed <?php echo esc_attr( implode( ' ', $metabox_class ) ); ?>" rel="<?php echo esc_attr( $attribute->get_position() ); ?>">
								<h3>
									<strong>
										<?php echo wc_attribute_label( $attribute->get_name() ); ?>
									</strong>
								</h3>
								<div class="woocommerce_attribute_data wc-metabox-content hidden">
									<p class="form-field">
										<label><?php esc_html_e( 'Display Type', 'riode' ); ?> </label>
										<select class="swatch-type">
											<option value="default" <?php selected( $swatch_type, 'default' ); ?>><?php esc_html_e( 'Default', 'riode' ); ?></option>
											<option value="select" <?php selected( $swatch_type, 'select' ); ?>><?php esc_html_e( 'Select', 'riode' ); ?></option>
											<option value="label" <?php selected( $swatch_type, 'label' ); ?>><?php esc_html_e( 'Label', 'riode' ); ?></option>
											<option value="color" <?php selected( $swatch_type, 'color' ); ?>><?php esc_html_e( 'Color', 'riode' ); ?></option>
											<option value="image" <?php selected( $swatch_type, 'image' ); ?>><?php esc_html_e( 'Image', 'riode' ); ?></option>
										</select>
										<span class="woocommerce-help-tip" data-tip="<?php esc_attr_e( 'You can use default type from global attribute type or use custom select/label/color/image type.', 'riode' ); ?>"></span>
									</p>
									<table class="product_custom_swatches">
										<thead>
											<th><?php esc_html_e( 'Item', 'riode' ); ?></th>
											<th><?php esc_html_e( 'Label', 'riode' ); ?></th>
											<th><?php esc_html_e( 'Color', 'riode' ); ?></th>
											<th><?php esc_html_e( 'Image', 'riode' ); ?></th>
										</thead>

										<tbody>
										<?php
										foreach ( $attribute->get_options() as $option ) {
											$term = get_term( $option );
											if ( $term ) {
												$attr_name = $term->name;
											} else {
												$attr_name = $option;
												$option    = strtolower( preg_replace( '/\s+/', '_', $option ) );
											}

											$attr_label     = $term ? get_term_meta( $term->term_id, 'attr_label', true ) : '';
											$attr_label_org = $attr_label;
											$attr_color     = $term ? get_term_meta( $term->term_id, 'attr_color', true ) : '';
											$attr_color_org = $attr_color;
											$attr_image     = $term ? get_term_meta( $term->term_id, 'attr_image', true ) : '';
											$attr_image_org = $attr_image;

											if ( isset( $swatch_options[ $taxonomy ] ) && isset( $swatch_options[ $taxonomy ][ $option ] ) ) {
												if ( isset( $swatch_options[ $taxonomy ][ $option ]['label'] ) ) {
													$attr_label = $swatch_options[ $taxonomy ][ $option ]['label'];
												}
												if ( isset( $swatch_options[ $taxonomy ][ $option ]['color'] ) ) {
													$attr_color = $swatch_options[ $taxonomy ][ $option ]['color'];
												}
												if ( isset( $swatch_options[ $taxonomy ][ $option ]['image'] ) ) {
													$attr_image = $swatch_options[ $taxonomy ][ $option ]['image'];
												}
											}

											if ( $attr_image ) {
												$attr_image_id = $attr_image;
												if ( ! empty( wp_get_attachment_image_src( $attr_image_id, 'thumbnail' ) ) ) {
												$attr_image = wp_get_attachment_image_src( $attr_image_id, 'thumbnail' )[0];
											} else {
													$attr_image = wc_placeholder_img_src( 'thumbnail' );
												}
											} else {
												$attr_image_id = '';
												$attr_image    = wc_placeholder_img_src( 'thumbnail' );
											}
											?>
												<tr data-term-id="<?php echo esc_attr( $option ); ?>">
													<td class="riode-attr-name"><?php echo esc_html( $attr_name ); ?></td>
													<td class="riode-attr-label"><input type="text" class="attr-field riode-attr-label-input" value="<?php echo esc_attr( $attr_label ); ?>" data-origin-value="<?php echo esc_attr( $attr_label_org ); ?>"></td>
													<td class="riode-attr-color"><input type="text" class="attr-field riode-color-picker" value="<?php echo esc_attr( $attr_color ); ?>" data-origin-value="<?php echo esc_attr( $attr_color_org ); ?>"></td>
													<td class="riode-attr-image">
														<img src="<?php echo esc_url( $attr_image ); ?>" alt="<?php esc_attr_e( 'Thumbnail Preview', 'riode' ); ?>" width="32" height="32">
														<input class="upload_image_url" type="hidden" value="<?php echo esc_attr( $attr_image_id ); ?>"  data-origin-value="<?php echo esc_attr( $attr_image_org ); ?>"/>
														<button class="button_upload_image button"><?php esc_html_e( 'Upload/Add image', 'riode' ); ?></button>
														<button class="button_remove_image button"><?php esc_html_e( 'Remove image', 'riode' ); ?></button>
													</td>
												</tr>
												<?php
										}
										?>
										</tbody>
									</table>
								</div>
							</div>
						<?php
					endforeach;
					?>
					<div class="toolbar">
						<span class="expand-close"><a href="#" class="expand_all"><?php esc_html_e( 'Expand', 'riode' ); ?></a> / <a href="#" class="close_all"><?php esc_html_e( 'Close', 'riode' ); ?></a></span>
						<button type="submit" class="button-primary riode-attribute-swatch-save"><?php esc_html_e( 'Save changes', 'riode' ); ?></button>
					</div>
					<?php
				endif;
				?>
				</div>
			</div>
			<?php
		}

		public function enqueue_scripts() {
			wp_enqueue_media();

			wp_enqueue_script( 'riode-swatch-admin', RIODE_ADDON_URI . '/attribute-swatch/swatch-admin.min.js', array(), RIODE_VERSION, true );

			wp_localize_script(
				'riode-swatch-admin',
				'riode_swatch_admin_vars',
				array(
					'placeholder'  => esc_url( wc_placeholder_img_src() ),
					'ajax_url'     => esc_url( admin_url( 'admin-ajax.php' ) ),
					'post_id'      => get_the_ID(),
					'product_type' => wc_get_product( get_the_ID() )->get_type(),
					'nonce'        => wp_create_nonce( 'riode-product-editor' ),
				)
			);
		}

		public function save_swatch_options() {
			if ( ! check_ajax_referer( 'riode-product-editor', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			if ( 'variable' != $_POST['product_type'] ) {
				wp_send_json_error( 'not a variable product' );
			}

			$post_id        = $_POST['post_id'];
			$swatch_options = isset( $_POST['swatch_options'] ) ? $_POST['swatch_options'] : '';

			if ( $swatch_options && count( $swatch_options ) ) {
				update_post_meta( $post_id, 'swatch_options', json_encode( $swatch_options ) );
			} else {
				delete_post_meta( $post_id, 'swatch_options' );
			}
			wp_send_json_success();
			die();
		}

		public function refresh_swatch_options() {
			if ( ! check_ajax_referer( 'riode-product-editor', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			$this->add_product_data_panel();
			wp_send_json_success();
			die();
		}
	}
}

new Riode_Image_Swatch_Tab();
