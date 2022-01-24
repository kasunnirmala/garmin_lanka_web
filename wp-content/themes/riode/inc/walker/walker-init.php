<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * walker-init.php
 * Class Riode_Walker
 */

class Riode_Walker {
	private $blocks = array();

	/**
	 * Constructor
	 */

	public function __construct() {
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'setup_walker_meta' ), 10, 1 );
		add_action( 'riode_add_custom_fields', array( $this, 'add_custom_fields' ), 10, 4 );
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker' ), 10, 2 );
		add_action( 'wp_update_nav_menu_item', array( $this, 'update_walker' ), 10, 3 );

		add_action( 'admin_enqueue_scripts', array( $this, 'load' ) );

		$this->_get_blocks();
	}

	private function _get_blocks() {
		$posts = get_posts(
			array(
				'post_type'   => 'riode_template',
				'meta_key'    => 'riode_template_type',
				'meta_value'  => 'block',
				'numberposts' => -1,
			)
		);

		sort( $posts );

		foreach ( $posts as $post ) {
			$this->blocks[ $post->ID ] = $post->post_title;
		}
	}

	/**
	 * Decorates a menu item object with the shared navigation menu item properties.
	 *
	 * @param    object    $menu_item    The menu item to modify.
	 */
	public function setup_walker_meta( $menu_item ) {
		$menu_item->nolink         = get_post_meta( $menu_item->ID, '_menu_item_nolink', true );
		$menu_item->megamenu       = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
		$menu_item->megamenu_width = get_post_meta( $menu_item->ID, '_menu_item_megamenu_width', true );
		$menu_item->megamenu_pos   = get_post_meta( $menu_item->ID, '_menu_item_megamenu_pos', true );
		$menu_item->image          = get_post_meta( $menu_item->ID, '_menu_item_image', true );
		$menu_item->block          = get_post_meta( $menu_item->ID, '_menu_item_block', true );
		$menu_item->icon           = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
		$menu_item->label_name     = get_post_meta( $menu_item->ID, '_menu_item_label_name', true );

		return $menu_item;
	}

	public function add_custom_fields( $id, $item, $depth, $args ) {
		?>

		<p class="field-nolink description description-wide riode-custom-fields-title"><label><?php echo esc_html__( 'Riode Custom Fields', 'riode' ); ?></label></p>

		<p class="field-nolink description description-wide">
			<label for="edit-menu-item-nolink-<?php echo esc_attr( $item->ID ); ?>">
				<input type="checkbox" id="edit-menu-item-nolink-<?php echo esc_attr( $item->ID ); ?>" value="nolink" name="menu-item-nolink[<?php echo esc_attr( $item->ID ); ?>]"<?php checked( $item->nolink, 'nolink' ); ?> />
					<?php esc_html_e( 'No Link', 'riode' ); ?>
			</label>
		</p>

		<p class="field-megamenu description description-wide">
			<label for="edit-menu-item-megamenu-<?php echo esc_attr( $item->ID ); ?>">
				<input type="checkbox" id="edit-menu-item-megamenu-<?php echo esc_attr( $item->ID ); ?>" value="megamenu" name="menu-item-megamenu[<?php echo esc_attr( $item->ID ); ?>]"<?php checked( $item->megamenu, 'megamenu' ); ?> />
					<?php esc_html_e( 'Megamenu', 'riode' ); ?>
			</label>
		</p>

		<p class="field-megamenu_width description description-wide">
			<label for="edit-menu-item-megamenu_width-<?php echo esc_attr( $item->ID ); ?>">
				<?php esc_html_e( 'Megamenu Width (px)', 'riode' ); ?>
				<input type="text" id="edit-menu-item-megamenu_width-<?php echo esc_attr( $item->ID ); ?>" class="widefat" value="<?php echo (int) ( $item->megamenu_width !== '' ? $item->megamenu_width : 618 ); ?>" name="menu-item-megamenu_width[<?php echo esc_attr( $item->ID ); ?>]" />
				<?php echo sprintf( esc_html__( 'Input %1$szero%2$s to make full width megamenu', 'riode' ), '<b style="color: #000;">', '</b>' ); ?>
			</label>
		</p>

		<p class="field-megamenu_pos description description-wide">
			<label for="edit-menu-item-megamenu_pos-<?php echo esc_attr( $item->ID ); ?>">
				<?php esc_html_e( 'Megamenu Position', 'riode' ); ?>
				<select id="edit-menu-item-megamenu_pos-<?php echo esc_attr( $item->ID ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-megamenu_pos[<?php echo esc_attr( $item->ID ); ?>]" value="<?php echo intval( $item->megamenu_pos ); ?>">
					<option value="left" <?php selected( 'left', $item->megamenu_pos ); ?>>Left</option>
					<option value="center" <?php selected( 'center', $item->megamenu_pos ); ?>>Center</option>
					<option value="right" <?php selected( 'right', $item->megamenu_pos ); ?>>Right</option>
				</select>
			</label>
		</p>

		<?php if ( 2 == $depth ) { ?>

		<p class="field-image description description-wide">
			<label for="edit-menu-item-image-<?php echo esc_attr( $item->ID ); ?>">
				<?php echo 'Select Background Image'; ?><br />
				<input type="text" id="edit-menu-item-image-<?php echo esc_attr( $item->ID ); ?>" class="widefat edit-menu-item-image"
					<?php if ( $item->image ) : ?>
						name="menu-item-image[<?php echo esc_attr( $item->ID ); ?>]"
					<?php endif; ?>
						data-name="menu-item-image[<?php echo esc_attr( $item->ID ); ?>]"
						value="<?php echo esc_attr( $item->image ); ?>" />
				<br/>
				<input class="btn_upload_img button" id="edit-menu-item-image-<?php echo esc_attr( $item->ID ); ?>" type="button" value="Upload Image" />&nbsp;
				<input class="btn_remove_img button" id="edit-menu-item-image-<?php echo esc_attr( $item->ID ); ?>" type="button" value="Remove Image" />
			</label>
		</p>

		<p class="field-block description description-wide">
			<label for="edit-menu-item-block-<?php echo esc_attr( $item->ID ); ?>">
				<?php echo 'Use Block'; ?><br />
				<select id="edit-menu-item-block-<?php echo esc_attr( $item->ID ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-block[<?php echo esc_attr( $item->ID ); ?>]" value="<?php echo intval( $item->block ); ?>">
					<option value=""><?php esc_html_e( 'Select A Block', 'riode' ); ?></option>
					<?php
					if ( $this->blocks ) :
						foreach ( $this->blocks as $key => $value ) :
							?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $item->block, $key ); ?>><?php echo esc_html( $value ); ?></option>
							<?php
						endforeach;
					endif;
					?>
				</select>
				<?php esc_html_e( 'This option only works in megamenu.', 'riode' ); ?>
			</label>
		</p>

		<?php } ?>

		<p class="field-icon description description-wide">
			<label for="edit-menu-item-icon-<?php echo esc_attr( $item->ID ); ?>">
				<?php esc_html_e( 'Prefix Icon Class', 'riode' ); ?>
				<input type="text" id="edit-menu-item-icon-<?php echo esc_attr( $item->ID ); ?>" class="widefat" value="<?php echo esc_attr( $item->icon ); ?>" name="menu-item-icon[<?php echo esc_attr( $item->ID ); ?>]" />
				<?php echo sprintf( esc_html__( '%1$sRiode Icon Store%2$s might be useful for you to select icons.', 'riode' ), '<a href="https://d-themes.com/wordpress/riode/elements/elements/element-icon-library" target="__blank">', '</a>' ); ?>
			</label>
		</p>

		<p class="field-label_name description description-wide">
			<label for="edit-menu-item-label_name-<?php echo esc_attr( $item->ID ); ?>">
				<?php esc_html_e( 'Add Label', 'riode' ); ?><br />
				<select id="edit-menu-item-label_name-<?php echo esc_attr( $item->ID ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-label_name[<?php echo esc_attr( $item->ID ); ?>]" value="<?php echo intval( $item->label_name ); ?>">
					<option value=""><?php esc_html_e( 'Select A Label', 'riode' ); ?></option>
					<?php
					$labels = json_decode( riode_get_option( 'menu_labels' ), true );
					if ( $labels ) :
						foreach ( $labels as $key => $value ) :
							?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $item->label_name, $key ); ?>><?php echo esc_html( $key ); ?></option>
							<?php
						endforeach;
					endif;
					?>
				</select>
			</label>
		</p>
		<?php
	}

	/**
	 * Filters the Walker class used when adding nav menu items
	 */
	public function edit_walker() {
		require_once RIODE_INC . '/walker/walker-nav-menu-edit.php';
		return 'Riode_Walker_Nav_Menu_Edit';
	}

	/**
	 * Save the properties of a menu item or create a new one.
	 *
	 * @param    int      $menu_id            The ID of the menu. Required. If "0", makes the menu item a draft orphan.
	 * @param    int      $menu_item_db_id    The ID of the menu item. If "0", creates a new menu item.
	 * @param    array    $args               The menu item's data.
	 */
	public function update_walker( $menu_id, $menu_item_db_id, $args ) {
		$customs = array( 'nolink', 'megamenu', 'megamenu_width', 'megamenu_pos', 'image', 'icon', 'label_name', 'block' );

		foreach ( $customs as $key ) {
			if ( ! isset( $_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] ) ) {
				if ( ! isset( $args[ 'menu-item-' . $key ] ) ) {
					$value = '';
				} else {
					$value = $args[ 'menu-item-' . $key ];
				}
			} else {
				$value = sanitize_text_field( $_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] );
			}

			if ( $value !== '' ) {
				update_post_meta( $menu_item_db_id, '_menu_item_' . $key, $value );
			} else {
				delete_post_meta( $menu_item_db_id, '_menu_item_' . $key );
			}
		}
	}

	public function load() {
		wp_enqueue_media();
		wp_enqueue_style( 'riode-admin-walker', RIODE_CSS . '/admin/walker.min.css', null, RIODE_VERSION, 'all' );
		wp_enqueue_script( 'riode-admin-walker', RIODE_JS . '/admin/walker' . riode_get_js_extension(), array( 'jquery-core' ), RIODE_VERSION, true );
	}
}

new Riode_Walker();
