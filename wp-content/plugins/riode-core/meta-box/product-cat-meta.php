<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode_Product_Category_Metabox
 *
 * manages custom meta settings of product categories
 *
 * @since 1.4.0
 */

class Riode_Product_Category_Metabox {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'product_cat_edit_form_fields', array( $this, 'edit_form_fields' ), 100, 2 );
		add_action( 'edit_term', array( $this, 'save_form_fields' ), 100, 3 );
	}

	/**
	 * edit_form_fields
	 *
	 * adds more fields to category edit form
	 */
	public function edit_form_fields( $tag, $taxonomy ) {
		if ( 'product_cat' == $taxonomy ) {
			?>
			<tr class="form-field">
				<th scope="row"><label for="name"><?php esc_html_e( 'Category Icon', 'riode-core' ); ?></label></th>
				<td>
					<input name="product_cat_icon" id="product_cat_icon" type="text" value="<?php echo esc_attr( get_term_meta( $tag->term_id, 'product_cat_icon', true ) ); ?>" placeholder="Input icon class here...">
				</td>
			</tr>
			<?php
		}
	}

	/**
	 * save_form_fields
	 *
	 * saves product category meta options
	 */
	public function save_form_fields( $term_id, $tt_id, $taxonomy ) {
		if ( 'product_cat' == $taxonomy ) {
			if ( isset( $_POST['product_cat_icon'] ) ) {
				update_term_meta( $term_id, 'product_cat_icon', $_POST['product_cat_icon'] );
			} else {
				delete_term_meta( $term_id, 'product_cat_icon' );
			}
		}
	}
}

new Riode_Product_Category_Metabox;
