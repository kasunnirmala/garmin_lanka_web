<?php
/**
 * Riode Template
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RIODE_CORE_LAYOUTS', RIODE_CORE_TEMPLATE . '/page-layouts' );

class Riode_Layout_Dashboard {
	public $page_slug = '';

	protected $layouts;

	private static $instance = null;

	private $options;

	private $template_list;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		$this->page_slug = 'riode_layout_dashboard';
		include_once RIODE_CORE_LAYOUTS . '/class-riode-layout.php';

		// Ajax
		add_action( 'wp_ajax_riode_clone_layout', array( $this, 'clone_layout' ) );
		add_action( 'wp_ajax_nopriv_riode_clone_layout', array( $this, 'clone_layout' ) );
		add_action( 'wp_ajax_riode_add_layout', array( $this, 'add_layout' ) );
		add_action( 'wp_ajax_nopriv_riode_add_layout', array( $this, 'add_layout' ) );
		add_action( 'wp_ajax_riode_remove_layout', array( $this, 'remove_layout' ) );
		add_action( 'wp_ajax_nopriv_riode_remove_layout', array( $this, 'remove_layout' ) );
		add_action( 'wp_ajax_riode_change_layout_name', array( $this, 'change_layout_name' ) );
		add_action( 'wp_ajax_nopriv_riode_change_layout_name', array( $this, 'change_layout_name' ) );
		add_action( 'wp_ajax_riode_save_option', array( $this, 'save_option' ) );
		add_action( 'wp_ajax_nopriv_riode_save_option', array( $this, 'save_option' ) );

		if ( ! ( isset( $_REQUEST['page'] ) && 'riode_layout_dashboard' == $_REQUEST['page'] ) ) {
			return;
		}

		riode_remove_all_admin_notices();

		add_filter( 'riode_core_admin_localize_vars', array( $this, 'add_localize_vars' ) );
		add_action( 'riode_page_riode_layout_dashboard', array( $this, 'init_layout_part_options' ) );
	}

	public function init_layout_part_options() {
		$this->_get_template_list();

		$ptb_blocks = array();
		foreach ( $this->template_list['block'] as $key => $value ) {
			$ptb_blocks[ $key ] = $value;
			if ( -1 == $key ) {
				$ptb_blocks['classic'] = esc_html__( 'Theme Option', 'riode-core' );
			}
		}

		$footer_blocks = array();
		foreach ( $this->template_list['footer'] as $key => $value ) {
			$footer_blocks[ $key ] = $value;
			if ( -1 == $key ) {
				$footer_blocks['classic'] = esc_html__( 'Classic Footer', 'riode-core' );
			}
		}

		$this->options = array(
			'general'            => array(
				'wrap'             => array(
					'control' => 'select',
					'default' => '',
					'label'   => esc_html__( 'Page Content Wrap', 'riode-core' ),
					'choices' => array(
						''                => esc_html__( 'Default', 'riode-core' ),
						'container'       => esc_html__( 'Container', 'riode-core' ),
						'container-fluid' => esc_html__( 'Container Fluid', 'riode-core' ),
						'full'            => esc_html__( 'Full', 'riode-core' ),
					),
					'tooltip' => esc_html__( 'Select whether page content is wrapped in full width, container or container-fluid.', 'riode-core' ),
				),
				'reading_progress' => array(
					'control' => 'select',
					'default' => '',
					'choices' => array(
						''    => esc_html__( 'Default', 'riode-core' ),
						'yes' => esc_html__( 'Show', 'riode-core' ),
						'no'  => esc_html__( 'Hide', 'riode-core' ),
					),
					'label'   => esc_html__( 'Reading Progress Bar', 'riode-core' ),
					'tooltip' => esc_html__( 'Select whether reading progress bar is shown or hidden.', 'riode-core' ),
				),
				'center_content'   => array(
					'control' => 'check',
					'default' => 'false',
					'label'   => esc_html__( 'Center Content', 'riode-core' ),
					'tooltip' => esc_html__( 'If possible, content will be aligned center when sidebar is opened.', 'riode-core' ),
				),
				'left_fixed'       => array(
					'control'   => 'text',
					'default'   => '',
					'label'     => esc_html__( 'Left Fixed Items', 'riode-core' ),
					'tooltip'   => esc_html__( 'Comma separated items to be considered while opening/closing sidebars. (e.g: .left-sidebar-toggle, .custom-html - used in demo 21 )', 'riode-core' ),
					'condition' => array(
						'center_content' => true,
					),
				),
				'right_fixed'      => array(
					'control'   => 'text',
					'default'   => '',
					'label'     => esc_html__( 'Right Fixed Items', 'riode-core' ),
					'tooltip'   => esc_html__( 'Comma separated items to be considered while opening/closing sidebars. (e.g: .right-sidebar-toggle, .custom-html )', 'riode-core' ),
					'condition' => array(
						'center_content' => true,
					),
				),
			),
			'header'             => array(
				'id' => array(
					'control'     => 'select',
					'default'     => '',
					'label'       => esc_html__( 'Select Header', 'riode-core' ),
					'choices'     => $this->template_list['header'],
					'description' => sprintf( esc_html__( 'Select one of existing headers or %1$screate a new header%2$s.', 'riode-core' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=header' ) ) . '" target="_blank">', '</a>' ),
				),
			),
			'ptb'                => array(
				'id'                      => array(
					'control'     => 'select',
					'default'     => '',
					'label'       => esc_html__( 'Select PTB Block', 'riode-core' ),
					'choices'     => $ptb_blocks,
					'description' => sprintf( esc_html__( 'Select one of existing blocks or %1$screate a new block%2$s.', 'riode-core' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=block' ) ) . '" target="_blank">', '</a>' ),
				),
				'ptb_follow_theme_option' => array(
					'control'   => 'check',
					'default'   => true,
					'label'     => esc_html__( 'Follow Theme Option', 'riode-core' ),
					'condition' => array(
						'id' => 'classic',
					),
				),
				'ptb_type'                => array(
					'control'   => 'select',
					'default'   => 'center',
					'label'     => esc_html__( 'PTB Type', 'riode-core' ),
					'choices'   => array(
						'center' => esc_html__( 'Center', 'riode-core' ),
						'left'   => esc_html__( 'Left', 'riode-core' ),
						'inline' => esc_html__( 'Inline', 'riode-core' ),
						'depart' => esc_html__( 'Depart', 'riode-core' ),
					),
					'condition' => array(
						'id'                      => 'classic',
						'ptb_follow_theme_option' => false,
					),
				),
				'ptb_title_show'          => array(
					'control'   => 'check',
					'default'   => true,
					'label'     => esc_html__( 'Show Page Title', 'riode-core' ),
					'condition' => array(
						'id'                      => 'classic',
						'ptb_follow_theme_option' => false,
					),
				),
				'ptb_subtitle_show'       => array(
					'control'   => 'check',
					'default'   => true,
					'label'     => esc_html__( 'Show Page Subtitle', 'riode-core' ),
					'condition' => array(
						'id'                      => 'classic',
						'ptb_follow_theme_option' => false,
					),
				),
				'ptb_breadcrumb_show'     => array(
					'control'   => 'check',
					'default'   => true,
					'label'     => esc_html__( 'Show Breadcrumb', 'riode-core' ),
					'condition' => array(
						'id'                      => 'classic',
						'ptb_follow_theme_option' => false,
					),
				),
				'ptb_wrap_container'      => array(
					'control'   => 'select',
					'default'   => '',
					'label'     => esc_html__( 'Wrap PTB with', 'riode-core' ),
					'tooltip'   => esc_html__( 'You can wrap PTB content with container or container-fluid by using this option.', 'riode-core' ),
					'choices'   => array(
						''                => esc_html__( 'Default', 'riode-core' ),
						'container'       => esc_html__( 'Boxed', 'riode-core' ),
						'container-fluid' => esc_html__( 'Fluid', 'riode-core' ),
					),
					'condition' => array(
						'id'                      => 'classic',
						'ptb_follow_theme_option' => false,
					),
				),
				'title'                   => array(
					'control' => 'text',
					'default' => '',
					'label'   => esc_html__( 'Custom Page Title', 'riode-core' ),
					'tooltip' => esc_html__( 'Input custom page title for certain pages', 'riode-core' ),
				),
				'subtitle'                => array(
					'control' => 'text',
					'default' => '',
					'label'   => esc_html__( 'Custom Page Subtitle', 'riode-core' ),
					'tooltip' => esc_html__( 'Input custom page subtitle for certain pages', 'riode-core' ),
				),
			),
			'top_block'          => array(
				'id' => array(
					'control'     => 'select',
					'default'     => '',
					'label'       => esc_html__( 'Select Top Block', 'riode-core' ),
					'choices'     => $this->template_list['block'],
					'description' => sprintf( esc_html__( 'Select one of existing blocks or %1$screate a new block%2$s.', 'riode-core' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=block' ) ) . '" target="_blank">', '</a>' ),
				),
			),
			'inner_top_block'    => array(
				'id' => array(
					'control'     => 'select',
					'default'     => '',
					'label'       => esc_html__( 'Select Inner Top Block', 'riode-core' ),
					'choices'     => $this->template_list['block'],
					'description' => sprintf( esc_html__( 'Select one of existing blocks or %1$screate a new block%2$s.', 'riode-core' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=block' ) ) . '" target="_blank">', '</a>' ),
				),
			),
			'inner_bottom_block' => array(
				'id' => array(
					'control'     => 'select',
					'default'     => '',
					'label'       => esc_html__( 'Select Inner Bottom Block', 'riode-core' ),
					'choices'     => $this->template_list['block'],
					'description' => sprintf( esc_html__( 'Select one of existing blocks or %1$screate a new block%2$s.', 'riode-core' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=block' ) ) . '" target="_blank">', '</a>' ),
				),
			),
			'bottom_block'       => array(
				'id' => array(
					'control'     => 'select',
					'default'     => '',
					'label'       => esc_html__( 'Select Bottom Block', 'riode-core' ),
					'choices'     => $this->template_list['block'],
					'description' => sprintf( esc_html__( 'Select one of existing blocks or %1$screate a new block%2$s.', 'riode-core' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=block' ) ) . '" target="_blank">', '</a>' ),
				),
			),
			'footer'             => array(
				'id' => array(
					'control'     => 'select',
					'default'     => '',
					'label'       => esc_html__( 'Select Footer', 'riode-core' ),
					'choices'     => $footer_blocks,
					'description' => sprintf( esc_html__( 'Select one of existing footers or %1$screate a new footer%2$s.', 'riode-core' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=footer' ) ) . '" target="_blank">', '</a>' ),
				),
			),
			'top_sidebar'        => array(
				'note' => array(
					'control' => 'heading',
					'label'   => esc_html__( '*Note that top filter sidebar is working only in shop pages.', 'riode-core' ),
				),
				'id'   => array(
					'control'     => 'select',
					'default'     => '',
					'label'       => esc_html__( 'Select Sidebar', 'riode-core' ),
					'choices'     => $this->template_list['sidebar'],
					'description' => sprintf( esc_html__( 'Select one of existing sidebars or %1$sregister new sidebar%2$s.', 'riode-core' ), '<a href="' . esc_url( admin_url( 'admin.php?page=riode_sidebar' ) ) . '" target="_blank">', '</a>' ),
				),
				'type' => array(
					'control'   => 'select',
					'default'   => 'horizontal',
					'label'     => esc_html__( 'Sidebar Type', 'riode-core' ),
					'choices'   => array(
						'horizontal' => esc_html__( 'Horizontal', 'riode-core' ),
						'navigation' => esc_html__( 'Navigation', 'riode-core' ),
					),
					'condition' => array(
						'id' => 'any',
					),
				),
			),
			'left_sidebar'       => array(
				'id'            => array(
					'control'     => 'select',
					'default'     => '',
					'label'       => esc_html__( 'Select Sidebar', 'riode-core' ),
					'choices'     => $this->template_list['sidebar'],
					'description' => sprintf( esc_html__( 'Select one of existing sidebars or %1$sregister new sidebar%2$s.', 'riode-core' ), '<a href="' . esc_url( admin_url( 'admin.php?page=riode_sidebar' ) ) . '" target="_blank">', '</a>' ),
				),
				'type'          => array(
					'control'   => 'select',
					'default'   => 'horizontal',
					'label'     => esc_html__( 'Sidebar Type', 'riode-core' ),
					'choices'   => array(
						''        => esc_html__( 'Classic', 'riode-core' ),
						'control' => esc_html__( 'Controllable', 'riode-core' ),
					),
					'tooltip'   => esc_html__( 'Controllable sidebar will be shown or hidden by control button. Please add "left-sidebar-toggle" class to control button.', 'riode-core' ),
					'condition' => array(
						'id' => 'any',
					),
				),
				'place'         => array(
					'control'   => 'select',
					'default'   => 'in',
					'label'     => esc_html__( 'Sidebar Position', 'riode-core' ),
					'choices'   => array(
						'in'  => esc_html__( 'Inside Content', 'riode-core' ),
						'out' => esc_html__( 'Off Canvas', 'riode-core' ),
					),
					'condition' => array(
						'id'   => 'any',
						'type' => 'control',
					),
				),
				'first_show'    => array(
					'control'   => 'check',
					'default'   => 'true',
					'label'     => esc_html__( 'Show/Hide after load', 'riode-core' ),
					'tooltip'   => esc_html__( 'If checked, sidebar will be shown after page load.', 'riode-core' ),
					'condition' => array(
						'id'    => 'any',
						'type'  => 'control',
						'place' => 'out',
					),
				),
				'overlay'       => array(
					'control'   => 'check',
					'default'   => 'true',
					'label'     => esc_html__( 'Show/Hide overlay', 'riode-core' ),
					'tooltip'   => esc_html__( 'If checked, dark sidebar overlay will be overwrapped the content so that the content will not be clickable.', 'riode-core' ),
					'condition' => array(
						'id'    => 'any',
						'type'  => 'control',
						'place' => 'out',
					),
				),
				'sticky_top'    => array(
					'control'   => 'text',
					'default'   => '',
					'label'     => esc_html__( 'Sticky Top', 'riode-core' ),
					'tooltip'   => esc_html__( 'Input top space when sidebar is sticky while scrolling. For empty value, theme will calculate automatically', 'riode-core' ),
					'condition' => array(
						'id' => 'any',
					),
				),
				'sticky_bottom' => array(
					'control'   => 'text',
					'default'   => '',
					'label'     => esc_html__( 'Sticky Bottom', 'riode-core' ),
					'tooltip'   => esc_html__( 'Input bottom space when sidebar is sticky while scrolling. For empty value, theme will calculate automatically', 'riode-core' ),
					'condition' => array(
						'id' => 'any',
					),
				),
			),
			'right_sidebar'      => array(
				'id'            => array(
					'control'     => 'select',
					'default'     => '',
					'label'       => esc_html__( 'Select Sidebar', 'riode-core' ),
					'choices'     => $this->template_list['sidebar'],
					'description' => sprintf( esc_html__( 'Select one of existing sidebars or %1$sregister new sidebar%2$s.', 'riode-core' ), '<a href="' . esc_url( admin_url( 'admin.php?page=riode_sidebar' ) ) . '" target="_blank">', '</a>' ),
				),
				'type'          => array(
					'control'   => 'select',
					'default'   => 'horizontal',
					'label'     => esc_html__( 'Sidebar Type', 'riode-core' ),
					'choices'   => array(
						''        => esc_html__( 'Classic', 'riode-core' ),
						'control' => esc_html__( 'Controllable', 'riode-core' ),
					),
					'tooltip'   => esc_html__( 'Controllable sidebar will be shown or hidden by control button. Please add "left-sidebar-toggle" class to control button.', 'riode-core' ),
					'condition' => array(
						'id' => 'any',
					),
				),
				'place'         => array(
					'control'   => 'select',
					'default'   => 'in',
					'label'     => esc_html__( 'Sidebar Position', 'riode-core' ),
					'choices'   => array(
						'in'  => esc_html__( 'Inside Content', 'riode-core' ),
						'out' => esc_html__( 'Off Canvas', 'riode-core' ),
					),
					'condition' => array(
						'id'   => 'any',
						'type' => 'control',
					),
				),
				'first_show'    => array(
					'control'   => 'check',
					'default'   => 'true',
					'label'     => esc_html__( 'Show/Hide after load', 'riode-core' ),
					'tooltip'   => esc_html__( 'If checked, sidebar will be shown after page load.', 'riode-core' ),
					'condition' => array(
						'id'    => 'any',
						'type'  => 'control',
						'place' => 'out',
					),
				),
				'overlay'       => array(
					'control'   => 'check',
					'default'   => 'true',
					'label'     => esc_html__( 'Show/Hide overlay', 'riode-core' ),
					'tooltip'   => esc_html__( 'If checked, dark sidebar overlay will be overwrapped the content so that the content will not be clickable.', 'riode-core' ),
					'condition' => array(
						'id'    => 'any',
						'type'  => 'control',
						'place' => 'out',
					),
				),
				'sticky_top'    => array(
					'control'   => 'text',
					'default'   => '',
					'label'     => esc_html__( 'Sticky Top', 'riode-core' ),
					'tooltip'   => esc_html__( 'Input top space when sidebar is sticky while scrolling. For empty value, theme will calculate automatically', 'riode-core' ),
					'condition' => array(
						'id' => 'any',
					),
				),
				'sticky_bottom' => array(
					'control'   => 'text',
					'default'   => '',
					'label'     => esc_html__( 'Sticky Bottom', 'riode-core' ),
					'tooltip'   => esc_html__( 'Input bottom space when sidebar is sticky while scrolling. For empty value, theme will calculate automatically', 'riode-core' ),
					'condition' => array(
						'id' => 'any',
					),
				),
			),
		);
	}

	private function _get_template_list() {
		$types               = array( 'header', 'footer', 'block' );
		$this->template_list = array();

		// builder templates
		foreach ( $types as $type ) {
			$posts = get_posts(
				array(
					'post_type'   => 'riode_template',
					'meta_key'    => 'riode_template_type',
					'meta_value'  => $type,
					'numberposts' => -1,
				)
			);

			$this->template_list[ $type ]['']   = sprintf( esc_html__( 'Select %1$s', 'riode-core' ), ucfirst( $type ) );
			$this->template_list[ $type ]['-1'] = esc_html__( 'Do Not Show', 'riode-core' );

			foreach ( $posts as $post ) {
				$this->template_list[ $type ][ $post->ID ] = $post->post_title;
			}
		}

		// sidebar
		global $wp_registered_sidebars;

		$this->template_list['sidebar']['']   = esc_html__( 'Select Sidebar', 'riode-core' );
		$this->template_list['sidebar']['-1'] = esc_html__( 'Do Not Show', 'riode-core' );

		foreach ( $wp_registered_sidebars as $key => $value ) {
			$this->template_list['sidebar'][ $key ] = $value['name'];
		}
	}

	private function add_control( $setting, $args ) {
		?>
		<div class="option"<?php echo isset( $args['condition'] ) ? 'data-condition=' . json_encode( $args['condition'] ) : ''; ?>>

			<?php if ( 'select' == $args['control'] ) { ?>

				<label><?php echo esc_html( $args['label'] ); ?></label>
				<select id="<?php echo esc_attr( $setting ); ?>">
				<?php foreach ( $args['choices'] as $key => $value ) { ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $args['default'], $key ); ?>><?php echo esc_html( $value ); ?></option>
				<?php } ?>
				</select>

			<?php } elseif ( 'text' == $args['control'] ) { ?>

				<label><?php echo esc_html( $args['label'] ); ?></label>
				<input type="text" name="<?php echo esc_attr( $setting ); ?>" id="<?php echo esc_attr( $setting ); ?>" value="<?php echo esc_attr( $args['default'] ); ?>">

			<?php } elseif ( 'check' == $args['control'] ) { ?>

				<input type="checkbox" name="<?php echo esc_attr( $setting ); ?>" id="<?php echo esc_attr( $setting ); ?>" <?php checked( true, $args['default'] ); ?>>
				<label class="d-inline-block"><?php echo esc_html( $args['label'] ); ?></label>

			<?php } elseif ( 'heading' == $args['control'] ) { ?>

				<h4 class="heading"><?php echo esc_html( $args['label'] ); ?></h4>

			<?php } ?>

			<?php if ( isset( $args['tooltip'] ) ) { ?>
				<div class="tooltip-wrapper">
					<span class="tooltip-trigger"><span class="dashicons dashicons-editor-help"></span></span>
					<div class="tooltip-content tooltip-right hidden"><?php echo esc_html( $args['tooltip'] ); ?></div>
				</div>
			<?php } ?>

			<?php if ( isset( $args['description'] ) ) { ?>
				<p class="description"><?php echo $args['description']; ?></p>
			<?php } ?>

		</div>
		<?php
	}

	public function add_localize_vars( $vars ) {
		$vars['layout_labels']  = array(
			'default_layout_name' => esc_html__( 'Layout Name', 'riode-core' ),
			'saving_status'       => esc_html__( 'Saving...', 'riode-core' ),
		);
		$vars['layout_counter'] = riode_get_option( 'layout_counter' );
		$vars['page_layouts']   = riode_get_option( 'page_layouts' );

		return $vars;
	}

	public function view_layout_dashboard() {
		if ( class_exists( 'Riode_Admin_Panel' ) ) {
			Riode_Admin_Panel::get_instance()->view_header( 'template_dashboard' );
			include RIODE_CORE_LAYOUTS . '/view.php';
			Riode_Admin_Panel::get_instance()->view_footer();
		}
	}

	private function get_remove_form_html() {
		ob_start();
		?>

		<div class="riode-layout-popup">
			<div class="mfp-header">
				<h2><span class="riode-mini-logo"></span><?php esc_html_e( 'Remove Layout', 'riode-core' ); ?></h2>
			</div>
			<div class="mfp-body">
				<p><?php esc_html_e( 'Are you sure to remove this layout and its condition?', 'riode-core' ); ?></p>
				<button class="button button-primary button-remove-layout"><?php esc_html_e( 'Confirm', 'riode-core' ); ?></button>
				<button class="button button-close"><?php esc_html_e( 'Cancel', 'riode-core' ); ?></button>
			</div>
		</div>

		<?php
		return ob_get_clean();
	}

	public function clone_layout() {
		if ( ! check_ajax_referer( 'riode-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( ! isset( $_POST['slug'] ) ) {
			wp_send_json_error( esc_html__( 'invalid original layout slug', 'riode-core' ) );
		}

		$layouts                                     = riode_get_option( 'page_layouts' );
		$counter                                     = riode_get_option( 'layout_counter' );
		$index                                       = array_search( $_POST['slug'], array_keys( $layouts ) );
		$new_layouts                                 = array_merge( array_slice( $layouts, 0, $index + 1 ), array( 'layout-' . $counter => $layouts[ $_POST['slug'] ] ), array_slice( $layouts, $index + 1 ) );
		$new_layouts[ 'layout-' . $counter ]['name'] = $new_layouts[ 'layout-' . $counter ]['name'] . '-1';
		$new_layouts[ 'layout-' . $counter ]['condition'] = array();
		set_theme_mod( 'page_layouts', $new_layouts );
		set_theme_mod( 'layout_counter', $counter + 1 );

		wp_send_json_success( $new_layouts );
	}

	public function add_layout() {
		if ( ! check_ajax_referer( 'riode-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		$layouts                         = riode_get_option( 'page_layouts' );
		$counter                         = riode_get_option( 'layout_counter' );
		$layouts[ 'layout-' . $counter ] = array(
			'name'      => esc_html__( 'Layout Name', 'riode-core' ),
			'content'   => array(
				'general' => array(
					'wrap'           => 'container',
					'center_content' => 'true',
				),
			),
			'condition' => array(),
		);
		set_theme_mod( 'page_layouts', $layouts );
		set_theme_mod( 'layout_counter', $counter + 1 );

		ob_start();
		Riode_Layout::print_layout( 'layout-' . $counter, $layouts[ 'layout-' . $counter ] );

		wp_send_json_success( ob_get_clean() );
	}

	public function remove_layout() {
		if ( ! check_ajax_referer( 'riode-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( ! isset( $_POST['slug'] ) ) {
			wp_send_json_error( esc_html__( 'invalid layout slug', 'riode-core' ) );
		}

		$layouts = riode_get_option( 'page_layouts' );
		unset( $layouts[ $_POST['slug'] ] );
		set_theme_mod( 'page_layouts', $layouts );

		wp_send_json_success( $layouts );
	}

	public function change_layout_name() {
		if ( ! check_ajax_referer( 'riode-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( ! isset( $_POST['slug'] ) || ! isset( $_POST['name'] ) ) {
			wp_send_json_error( esc_html__( 'invalid layout slug or name', 'riode-core' ) );
		}

		$layouts                           = riode_get_option( 'page_layouts' );
		$layouts[ $_POST['slug'] ]['name'] = esc_html( $_POST['name'] );
		set_theme_mod( 'page_layouts', $layouts );

		wp_send_json_success( 'success' );
	}

	public function save_option() {
		if ( ! check_ajax_referer( 'riode-core-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( ! isset( $_POST['layout_id'] ) || ! isset( $_POST['part_id'] ) || ! isset( $_POST['option'] ) ) {
			wp_send_json_error( esc_html__( 'invalid id for layout, part and option or changed value', 'riode-core' ) );
		}

		$layouts = riode_get_option( 'page_layouts' );
		$layouts[ $_POST['layout_id'] ]['content'][ $_POST['part_id'] ] = $_POST['option'];

		set_theme_mod( 'page_layouts', $layouts );
		wp_send_json_success( 'success' );
	}

	/**
	 * Get Filters
	 *
	 * @return array
	 *
	 * @since 1.2.0
	 */
	public function get_filters() {
		$result = array();

		$result['all'] = array(
			'entire' => array(
				'name'    => esc_html__( 'All Layouts', 'riode-core' ),
				'subcats' => array(),
			),
		);

		// Other registered post types
		$post_types = get_post_types( array( 'show_in_nav_menus' => true ), 'objects' );
		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type->name, array( 'page', 'riode_template' ) ) ) {
				continue;
			}

			$taxonomies = get_object_taxonomies( $post_type->name, 'objects' );
			$taxonomies = wp_filter_object_list(
				$taxonomies,
				array(
					'public'            => true,
					'show_in_nav_menus' => true,
				)
			);

			$archive_parts = array( '' => esc_html__( 'All Archives', 'riode-core' ) );
			$single_parts  = array( '' => 'All ' . ucwords( $post_type->labels->name ) );

			if ( $taxonomies ) {
				foreach ( $taxonomies as $key => $value ) {
					$archive_parts[ $key ] = ucwords( $value->labels->name );
					$single_parts[ $key ]  = ucwords( $value->labels->name );
				}
			}

			$single_parts['individual'] = 'Individual ' . $post_type->labels->name;

			$result[ $post_type->name ][ $post_type->name . '_archive' ] = array(
				'name'    => ucwords( $post_type->labels->singular_name ) . ' ' . esc_html__( 'Archive', 'riode-core' ),
				'subcats' => $archive_parts,
			);

			$result[ $post_type->name ][ $post_type->name . '_single' ] = array(
				'name'    => ucwords( $post_type->labels->singular_name ) . ' ' . esc_html__( 'Single', 'riode-core' ),
				'subcats' => $single_parts,
			);
		}

		$result['page'] = array(
			'page'     => array(
				'name'    => esc_html__( 'Pages', 'riode-core' ),
				'subcats' => array(
					''           => esc_html__( 'All Pages', 'riode-core' ),
					'individual' => esc_html__( 'Individual Pages', 'riode-core' ),
				),
			),
			'error404' => array(
				'name'    => esc_html__( 'Error 404', 'riode-core' ),
				'subcats' => array(),
			),
		);

		return $result;
	}
}

Riode_Layout_Dashboard::get_instance();
