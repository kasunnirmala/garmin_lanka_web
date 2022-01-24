<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode_Product_Attribute_Metabox
 *
 * manages custom meta settings of posts
 *
 * @since 1.4.0
 */

class Riode_Product_Attribute_Metabox {
	/**
	 * Constructor
	 */
	public function __construct() {
		if ( isset( $_REQUEST['post_type'] ) && 'product' == $_REQUEST['post_type'] &&
			isset( $_REQUEST['page'] ) && 'product_attributes' == $_REQUEST['page'] ) {
			global $pagenow;

			if ( 'edit.php' == $pagenow ) {
				$this->manage_guide_options();
			}
		}

		add_action( 'after_setup_theme', array( $this, 'manage_swatch_options' ) );
	}

	/**
	 * manage_guide_options
	 * manages attributes guide-related meta options to product attributes
	 */
	public function manage_guide_options() {
		// Add, edit, or delete guide options
		$guide_block     = isset( $_POST['guide_block'] ) ? absint( $_POST['guide_block'] ) : ''; // WPCS: input var ok, CSRF ok.
		$guide_text      = isset( $_POST['guide_text'] ) ? wc_clean( wp_unslash( $_POST['guide_text'] ) ) : ''; // WPCS: input var ok, CSRF ok.
		$guide_icon      = isset( $_POST['guide_icon'] ) ? wc_clean( wp_unslash( $_POST['guide_icon'] ) ) : ''; // WPCS: input var ok, CSRF ok.
		$att_name        = isset( $_POST['attribute_name'] ) ? wc_sanitize_taxonomy_name( wp_unslash( $_POST['attribute_name'] ) ) : ''; // WPCS: input var ok, CSRF ok, sanitization ok.
		$riode_pa_blocks = get_option( 'riode_pa_blocks', array() );
		if ( ! empty( $_POST['add_new_attribute'] ) || ( ! empty( $_POST['save_attribute'] ) && ! empty( $_GET['edit'] ) ) ) { // WPCS: CSRF ok.
			$riode_pa_blocks[ $att_name ] = array(
				'block' => $guide_block,
				'text'  => $guide_text,
				'icon'  => $guide_icon,
			);
		} elseif ( ! empty( $_GET['delete'] ) && isset( $riode_pa_blocks[ $att_name ] ) ) {
			unset( $riode_pa_blocks[ $att_name ] );
		}
		update_option( 'riode_pa_blocks', $riode_pa_blocks );

		// Show guide input controls
		add_action( 'woocommerce_after_edit_attribute_fields', array( $this, 'edit_guide_meta_options' ) );
		add_action( 'woocommerce_after_add_attribute_fields', array( $this, 'add_guide_meta_options' ) );
	}

	/**
	 * add_guide_options
	 * addes attributes guide-related meta options to product attributes
	 */
	public function add_guide_meta_options() {
		if ( ! function_exists( 'riode_get_option' ) || ! riode_get_option( 'attribute_guide' ) ) {
			return;
		}

		// Get blocks
		$posts = get_posts(
			array(
				'post_type'   => 'riode_template',
				'meta_key'    => 'riode_template_type',
				'meta_value'  => 'block',
				'numberposts' => -1,
			)
		);
		sort( $posts );
		?>
		<div class="form-field">
			<label for="guide_block"><?php esc_html_e( 'Riode Guide block', 'riode-core' ); ?></label>
			<select name="guide_block" id="guide_block">
				<option value=""></option>
		<?php foreach ( $posts as $post ) : ?>
					<option value="<?php echo esc_attr( $post->ID ); ?>"><?php echo esc_html( $post->post_title ); ?></option>
				<?php endforeach; ?>
			</select>
			<p class="description"><?php esc_html_e( 'Guide block for the attribute(shown in product data tabs).', 'riode-core' ); ?></p>
		</div>
		<div class="form-field">
			<label for="guide_text"><?php esc_html_e( 'Riode Guide link text', 'riode-core' ); ?></label>
			<input name="guide_text" id="guide_text" type="text" maxlength="64" />
			<p class="description"><?php esc_html_e( 'Link text for guide block.', 'riode-core' ); ?></p>
		</div>
		<div class="form-field">
			<label for="guide_icon"><?php esc_html_e( 'Riode Guide link icon', 'riode-core' ); ?></label>
			<input name="guide_icon" id="guide_icon" type="text" maxlength="64" />
			<p class="description"><?php esc_html_e( 'Icon class for guide link.', 'riode-core' ); ?></p>
		</div>
		<?php
	}

	/**
	 * add_guide_options
	 * edit attributes guide-related meta options of product attributes
	 */
	public function edit_guide_meta_options() {
		if ( ! function_exists( 'riode_get_option' ) || ! riode_get_option( 'attribute_guide' ) ) {
			return;
		}

		$guide_block = isset( $_POST['guide_block'] ) ? absint( $_POST['guide_block'] ) : ''; // WPCS: input var ok, CSRF ok.
		$guide_text  = isset( $_POST['guide_text'] ) ? wc_clean( wp_unslash( $_POST['guide_text'] ) ) : ''; // WPCS: input var ok, CSRF ok.
		$guide_icon  = isset( $_POST['guide_icon'] ) ? wc_clean( wp_unslash( $_POST['guide_icon'] ) ) : ''; // WPCS: input var ok, CSRF ok.
		$edit        = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;

		if ( $edit ) {
			global $wpdb;
			$attribute = $wpdb->get_row(
				$wpdb->prepare( "SELECT attribute_name FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_id = %d", $edit )
			);

			if ( $attribute ) {
				$att_name = $attribute->attribute_name;

				$riode_pa_blocks = get_option( 'riode_pa_blocks', array() );
				if ( isset( $riode_pa_blocks[ $att_name ] ) ) {
					$guide_block = $riode_pa_blocks[ $att_name ]['block'];
					$guide_text  = $riode_pa_blocks[ $att_name ]['text'];
					$guide_icon  = $riode_pa_blocks[ $att_name ]['icon'];
				}
			}
		}

		// Get blocks
		$posts = get_posts(
			array(
				'post_type'   => 'riode_template',
				'meta_key'    => 'riode_template_type',
				'meta_value'  => 'block',
				'numberposts' => -1,
			)
		);
		sort( $posts );

		// Form
		?>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="guide_block"><?php esc_html_e( 'Riode Guide block', 'riode-core' ); ?></label>
			</th>
			<td>
				<select name="guide_block" id="guide_block">
					<option value=""></option>
			<?php foreach ( $posts as $post ) : ?>
						<option value="<?php echo esc_attr( $post->ID ); ?>" <?php selected( $guide_block, $post->ID ); ?>><?php echo esc_html( $post->post_title ); ?></option>
					<?php endforeach; ?>
				</select>
				<p class="description"><?php esc_html_e( 'Guide block for the attribute(shown in product data tabs).', 'riode-core' ); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="guide_text"><?php esc_html_e( 'Riode Guide link text', 'riode-core' ); ?></label>
			</th>
			<td>
				<input name="guide_text" id="guide_text" type="text" value="<?php echo esc_attr( $guide_text ); ?>" maxlength="28" />
				<p class="description"><?php esc_html_e( 'Link text for guide block.', 'riode-core' ); ?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="guide_icon"><?php esc_html_e( 'Riode Guide icon', 'riode-core' ); ?></label>
			</th>
			<td>
				<input name="guide_icon" id="guide_icon" type="text" value="<?php echo esc_attr( $guide_icon ); ?>" maxlength="64" />
				<p class="description"><?php esc_html_e( 'Icon class for guide title.', 'riode-core' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * manage_swatch_options
	 * manages swatch options for product attributes
	 */
	public function manage_swatch_options() {
		if ( ! $this->_is_swatch_enabled() ) {
			return;
		}

		add_filter( 'product_attributes_type_selector', array( $this, 'add_swatch_types' ) );
		add_action( 'woocommerce_product_option_terms', array( $this, 'show_swatch_attrs_in_product_data' ), 10, 3 );

		$attribute_taxonomies = wc_get_attribute_taxonomies();
		foreach ( $attribute_taxonomies as $tax ) {
			add_action( wc_attribute_taxonomy_name( $tax->attribute_name ) . '_add_form_fields', array( $this, 'print_add_swatch_meta_fields' ), 100, 1 );
			add_action( wc_attribute_taxonomy_name( $tax->attribute_name ) . '_edit_form_fields', array( $this, 'print_edit_swatch_meta_fields' ), 100, 2 );
			add_filter( 'manage_edit-pa_' . $tax->attribute_name . '_columns', array( $this, 'add_attr_term_swatch_columns' ) );
			add_filter( 'manage_pa_' . $tax->attribute_name . '_custom_column', array( $this, 'add_attr_term_swatch_column' ), 10, 3 );
			add_action( 'created_term', array( $this, 'save_swatch_meta_options' ), 100, 3 );
			add_action( 'edit_term', array( $this, 'save_swatch_meta_options' ), 100, 3 );
			add_action( 'delete_term', array( $this, 'delete_swatch_meta_options' ), 10, 5 );
		}
	}

	/**
	 * _is_swatch_enabled
	 * checks if current variation swatch option is enabled in theme option panel
	 */
	private function _is_swatch_enabled() {
		return function_exists( 'riode_get_option' ) && riode_get_option( 'attribute_swatch' );
	}

	/**
	 * add_swatch_types
	 * adds additional attribute types except default select box
	 */
	public function add_swatch_types( $types ) {
		if ( $this->_is_swatch_enabled() ) {
			$types['color'] = esc_html__( 'Color', 'riode-core' );
			$types['label'] = esc_html__( 'Label', 'riode-core' );
			$types['image'] = esc_html__( 'Image', 'riode-core' );
		}
		return $types;
	}

	/**
	 * show_swatch_attrs_in_product_data
	 * shows other types of product attributes inside attribute tab in product edit page
	 */
	public function show_swatch_attrs_in_product_data( $attribute_taxonomy, $i, $attribute ) {
		if ( 'select' != $attribute_taxonomy->attribute_type && $this->_is_swatch_enabled() ) {
			?>
			<select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'woocommerce' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo esc_attr( $i ); ?>][]">
				<?php
				$args      = array(
					'orderby'    => ! empty( $attribute_taxonomy->attribute_orderby ) ? $attribute_taxonomy->attribute_orderby : 'name',
					'hide_empty' => 0,
					'taxonomy'   => $attribute->get_taxonomy(),
				);
				$all_terms = get_terms( apply_filters( 'woocommerce_product_attribute_terms', $args ) );
				if ( $all_terms ) {
					foreach ( $all_terms as $term ) {
						$options = $attribute->get_options();
						$options = ! empty( $options ) ? $options : array();
						echo '<option value="' . esc_attr( $term->term_id ) . '"' . wc_selected( $term->term_id, $options ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
					}
				}
				?>
			</select>
			<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'woocommerce' ); ?></button>
			<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'woocommerce' ); ?></button>
			<button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'woocommerce' ); ?></button>
			<?php
		}
	}

	/**
	 * save_swatch_meta_options
	 * saves swatch meta options
	 */
	function save_swatch_meta_options( $term_id, $tt_id, $taxonomy ) {
		if ( strpos( $taxonomy, 'pa_' ) === false ) {
			return;
		}

		$args = array( 'attr_label', 'attr_color', 'attr_image' );

		foreach ( $args as $arg ) {
			if ( ! empty( $_POST[ $arg ] ) ) {
				update_term_meta( $term_id, $arg, sanitize_text_field( $_POST[ $arg ] ) );
			} else {
				delete_term_meta( $term_id, $arg );
			}
		}
	}

	/**
	 * delete_swatch_meta_options
	 * removes swatch meta options
	 */
	function delete_swatch_meta_options( $term_id, $tt_id, $taxonomy, $deleted_term, $object_ids ) {
		if ( strpos( $taxonomy, 'pa_' ) === false ) {
			return;
		}

		$args = array( 'attr_label', 'attr_color', 'attr_image' );

		foreach ( $args as $arg ) {
			delete_term_meta( $term_id, $arg );
		}
	}

	/**
	 * print_edit_swatch_meta_fields
	 * prints swatch meta option field in edit page
	 */
	function print_edit_swatch_meta_fields( $tag, $taxonomy ) {
		if ( false === strpos( $taxonomy, 'pa_' ) ) {
			return;
		}

		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( $attribute_taxonomies ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( wc_attribute_taxonomy_name( $tax->attribute_name ) == $taxonomy ) {
					$image_id = '';
					if ( $tag ) {
						$image_id = get_term_meta( $tag->term_id, 'attr_image', true );
					}
					if ( ! $image_id ) {
						$image_url = esc_url( wc_placeholder_img_src() );
					} else {
						$image_url = wp_get_attachment_url( $image_id );
					}
					?>
					<tr class="form-field">
						<th scope="row"><label for="name"><?php esc_html_e( 'Swatch Label', 'riode-core' ); ?></label></th>
						<td>
							<input name="attr_label" id="attr_label" type="text" value="<?php echo esc_attr( $tag ? get_term_meta( $tag->term_id, 'attr_label', true ) : '' ); ?>" placeholder="Short text with 1 or 2 letters...">
							<p class="description"><?php echo esc_html__( 'This option is added by Riode Theme. This label will be shown on attribute swatches.', 'riode-core' ); ?></p>
						</td>
					</tr>
					<tr class="form-field">
						<th scope="row"><label for="name"><?php esc_html_e( 'Swatch Color', 'riode-core' ); ?></label></th>
						<td>
							<input type="text" class="riode-color-picker" id="attr_color" name="attr_color" value="<?php echo esc_attr( $tag ? get_term_meta( $tag->term_id, 'attr_color', true ) : '' ); ?>">
							<p class="description"><?php echo esc_html__( 'This option is added by Riode Theme. Each attribute swatch will be filled with this color.', 'riode-core' ); ?></p>
						</td>
					</tr>
					<tr class="form-field">
						<th scope="row"><label for="name"><?php esc_html_e( 'Swatch Image', 'riode-core' ); ?></label></th>
						<td>
							<div id="attr_image_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image_url ); ?>" width="60px" height="60px" /></div>
							<div style="line-height: 60px;">
								<input type="hidden" id="attr_image" name="attr_image" value="<?php echo esc_attr( $image_id ); ?>" />
								<button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'riode-core' ); ?></button>
								<button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'riode-core' ); ?></button>
							</div>
							<p class="description"><?php echo esc_html__( 'This option is added by Riode Theme. This image will be shown on attribute swatches.', 'riode-core' ); ?></p>
							<script type="text/javascript">
								// Only show the "remove image" button when needed
								if ( '0' === jQuery( '#attr_image' ).val() ) {
									jQuery( '.remove_image_button' ).hide();
								}

								// Uploading files
								var file_frame;

								jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

									event.preventDefault();

									// If the media frame already exists, reopen it.
									if ( file_frame ) {
										file_frame.open();
										return;
									}

									// Create the media frame.
									file_frame = wp.media.frames.downloadable_file = wp.media({
										title: '<?php esc_html_e( 'Choose an image', 'riode-core' ); ?>',
										button: {
											text: '<?php esc_html_e( 'Use image', 'riode-core' ); ?>'
										},
										multiple: false
									});

									// When an image is selected, run a callback.
									file_frame.on( 'select', function() {
										var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
										var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

										jQuery( '#attr_image' ).val( attachment.id );
										jQuery( '#attr_image_thumbnail' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
										jQuery( '.remove_image_button' ).show();
									});

									// Finally, open the modal.
									file_frame.open();
								});

								jQuery( document ).on( 'click', '.remove_image_button', function() {
									jQuery( '#attr_image_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
									jQuery( '#attr_image' ).val( '' );
									jQuery( '.remove_image_button' ).hide();
									return false;
								});

							</script>
							<div class="clear"></div>
						</td>
					</tr>
					<?php

					break;
				}
			}
		}
	}

	/**
	 * print_add_swatch_meta_fields
	 * prints swatch meta option field in add page
	 */
	function print_add_swatch_meta_fields( $taxonomy ) {
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( $attribute_taxonomies ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( wc_attribute_taxonomy_name( $tax->attribute_name ) == $taxonomy ) {
					?>
					<div class="form-field term-swatch-label-wrap">
						<label for="name"><?php esc_html_e( 'Swatch Label', 'riode-core' ); ?></label>
						<input name="attr_label" id="attr_label" type="text" value="" placeholder="Short text with 1 or 2 letters...">
						<p class="description"><?php echo esc_html__( 'This option is added by Riode Theme. This label will be shown on attribute swatches.', 'riode-core' ); ?></p>
					</div>
					<div class="form-field term-swatch-color-wrap">
						<label for="name"><?php esc_html_e( 'Swatch Color', 'riode-core' ); ?></label>
						<input type="text" class="riode-color-picker" id="attr_color" name="attr_color" value="">
						<p class="description"><?php echo esc_html__( 'This option is added by Riode Theme. Each attribute swatch will be filled with this color.', 'riode-core' ); ?></p>
					</div>
					<div class="form-field term-swatch-image-wrap">
						<label for="name"><?php esc_html_e( 'Swatch Image', 'riode-core' ); ?></label>
						<div>
							<div id="attr_image_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
							<div style="line-height: 60px;">
								<input type="hidden" id="attr_image" name="attr_image" value="" />
								<button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'riode-core' ); ?></button>
								<button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'riode-core' ); ?></button>
							</div>
						</div>
						<div class="clear"></div>
						<p class="description"><?php echo esc_html__( 'This option is added by Riode Theme. This image will be shown on attribute swatches.', 'riode-core' ); ?></p>
						<script type="text/javascript">
							// Only show the "remove image" button when needed
							if ( '0' === jQuery( '#attr_image' ).val() ) {
								jQuery( '.remove_image_button' ).hide();
							}

							// Uploading files
							var file_frame;

							jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

								event.preventDefault();

								// If the media frame already exists, reopen it.
								if ( file_frame ) {
									file_frame.open();
									return;
								}

								// Create the media frame.
								file_frame = wp.media.frames.downloadable_file = wp.media({
									title: '<?php esc_html_e( 'Choose an image', 'riode-core' ); ?>',
									button: {
										text: '<?php esc_html_e( 'Use image', 'riode-core' ); ?>'
									},
									multiple: false
								});

								// When an image is selected, run a callback.
								file_frame.on( 'select', function() {
									var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
									var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

									jQuery( '#attr_image' ).val( attachment.id );
									jQuery( '#attr_image_thumbnail' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
									jQuery( '.remove_image_button' ).show();
								});

								// Finally, open the modal.
								file_frame.open();
							});

							jQuery( document ).on( 'click', '.remove_image_button', function() {
								jQuery( '#attr_image_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
								jQuery( '#attr_image' ).val( '' );
								jQuery( '.remove_image_button' ).hide();
								return false;
							});

						</script>
					</div>
					<?php

					break;
				}
			}
		}
	}

	/**
	 * add_attr_term_swatch_columns
	 * adds custom term columns for attribute swatches
	 */
	public function add_attr_term_swatch_columns( $columns ) {
		return array_merge(
			array_splice( $columns, 0, 2 ),
			array(
				'label' => esc_html__( 'Label', 'riode-core' ),
				'color' => esc_html__( 'Color', 'riode-core' ),
				'image' => esc_html__( 'Image', 'riode-core' ),
			),
			array_splice( $columns, 0, 5 )
		);
	}

	/**
	 * add_attr_term_swatch_column
	 * adds custom term column values for attribute swatches
	 */
	public function add_attr_term_swatch_column( $columns, $column, $id ) {
		if ( 'label' == $column ) {
			$label    = get_term_meta( $id, 'attr_label', true );
			$columns .= '<span class="swatch-value swatch-label">' . esc_html( $label ) . '</span>';
		}
		if ( 'color' == $column ) {
			$color    = get_term_meta( $id, 'attr_color', true );
			$columns .= '<span class="swatch-value swatch-color" style="background-color: ' . esc_attr( $color ) . ';"></span>';
		}
		if ( 'image' == $column ) {
			$image = get_term_meta( $id, 'attr_image', true );
			if ( ! $image ) {
				$image = wc_placeholder_img_src( 'thumbnail' );
			} else {
				$image = wp_get_attachment_url( $image );
			}
			$columns .= '<span class="swatch-value swatch-image" style="background-image: url(' . esc_url( $image ) . ');"></span>';
		}

		return $columns;
	}
}

new Riode_Product_Attribute_Metabox();
