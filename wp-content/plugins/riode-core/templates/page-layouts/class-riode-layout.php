<?php
/**
 * The Riode_Layout class
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Riode_Layout {
	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {}

	public static function print_layout( $slug, $layout ) {
		$layouts      = riode_get_option( 'page_layouts' );
		$condition    = array();
		$layout_class = '';
		if ( ! empty( $layouts[ $slug ]['condition'] ) ) {
			$condition = $layouts[ $slug ]['condition'];
		}

		foreach ( $condition as $item ) {
			if ( ! empty( $item['category'] ) ) {
				if ( 'error' == $item['category'] ) {
					$layout_class .= ' error404';
				} else {
					$layout_class .= ' ' . $item['category'];
				}
			}
			if ( ! empty( $item['subcategory'] ) ) {
				$layout_class .= ' ' . ( isset( $item['category'] ) ? $item['category'] : '' ) . '-' . $item['subcategory'];
			} else {
				$layout_class .= ' ' . ( isset( $item['category'] ) ? $item['category'] : '' ) . '-' . 'all';
			}
		}
		?>

		<div class="layout-box<?php echo esc_attr( $layout_class ); ?>" id="<?php echo esc_attr( $slug ); ?>">
			<h3 class="layout-header">
				<a href="#" class="back"><i class="fas fa-arrow-<?php echo is_rtl() ? 'right' : 'left'; ?>"></i></a>
				<input type="text" name="riode-layout-name" class="riode-layout-name" value="<?php echo esc_attr( $layout['name'] ); ?>" <?php echo esc_attr( 'global-layout' == $slug ? ' readonly' : '' ); ?>>
				<a href="#" class="layout-action layout-action-clone" title="<?php esc_attr_e( 'duplicate', 'riode-core' ); ?>"><i class="far fa-clone"></i></a>
				<?php if ( 'global-layout' != $slug ) : ?>
				<a href="#" class="layout-action layout-action-condition" title="<?php esc_attr_e( 'display condition', 'riode-core' ); ?>"><i class="fas fa-cog"></i></a>
				<a href="#" class="layout-action layout-action-remove" title="<?php esc_attr_e( 'remove', 'riode-core' ); ?>"><i class="far fa-trash-alt"></i></a>
				<?php endif; ?>
			</h3>
			<div class="layout riode_layout">
				<div class="general layout-part set" data-part="general">
					<p><?php esc_html_e( 'General Settings', 'riode-core' ); ?></p>
				</div>

				<div class="header layout-part<?php echo esc_attr( isset( $layout['content']['header'] ) && isset( $layout['content']['header']['id'] ) ? ' set' : '' ); ?>" data-part="header">
					<p><?php esc_html_e( 'Header', 'riode-core' ); ?></p>
				</div>
				<div class="ptb layout-part<?php echo esc_attr( isset( $layout['content']['ptb'] ) && ( ! empty( $layout['content']['ptb']['id'] ) || ! empty( $layout['content']['ptb']['title'] ) || ! empty( $layout['content']['ptb']['subtitle'] ) ) ? ' set' : '' ); ?>" data-part="ptb">
					<p><?php esc_html_e( 'Page Title Bar', 'riode-core' ); ?></p>
				</div>
				<div class="block top_block layout-part<?php echo esc_attr( isset( $layout['content']['top_block'] ) && isset( $layout['content']['top_block']['id'] ) ? ' set' : '' ); ?>" data-part="top_block">
					<p><?php esc_html_e( 'Top Block', 'riode-core' ); ?></p>
				</div>

				<div class="content-wrapper">
					<div class="sidebar left_sidebar layout-part<?php echo esc_attr( isset( $layout['content']['left_sidebar'] ) && isset( $layout['content']['left_sidebar']['id'] ) ? ' set' : '' ); ?>" data-part="left_sidebar">
						<p><?php esc_html_e( 'Sidebar', 'riode-core' ); ?></p>
					</div>

					<div class="content">
						<div class="block inner_top_block layout-part<?php echo esc_attr( isset( $layout['content']['inner_top_block'] ) && isset( $layout['content']['inner_top_block']['id'] ) ? ' set' : '' ); ?>" data-part="inner_top_block">
							<p><?php esc_html_e( 'Inner Top', 'riode-core' ); ?></p>
						</div>
						<div class="sidebar top_sidebar layout-part<?php echo esc_attr( isset( $layout['content']['top_sidebar'] ) && isset( $layout['content']['top_sidebar']['id'] ) ? ' set' : '' ); ?>" data-part="top_sidebar">
							<p><?php esc_html_e( 'Top Filter Sidebar', 'riode-core' ); ?></p>
						</div>
						<div class="main-content layout-part" data-part="content">
							<p><?php esc_html_e( 'Main Content', 'riode-core' ); ?></p>
						</div>
						<div class="block inner_bottom_block layout-part<?php echo esc_attr( isset( $layout['content']['inner_bottom_block'] ) && isset( $layout['content']['inner_bottom_block']['id'] ) ? ' set' : '' ); ?>" data-part="inner_bottom_block">
							<p><?php esc_html_e( 'Inner Bottom', 'riode-core' ); ?></p>
						</div>
					</div>

					<div class="sidebar right_sidebar layout-part<?php echo esc_attr( isset( $layout['content']['right_sidebar'] ) && isset( $layout['content']['right_sidebar']['id'] ) ? ' set' : '' ); ?>" data-part="right_sidebar">
						<p><?php esc_html_e( 'Sidebar', 'riode-core' ); ?></p>
					</div>
				</div>

				<div class="block bottom_block layout-part<?php echo esc_attr( isset( $layout['content']['bottom_block'] ) && isset( $layout['content']['bottom_block']['id'] ) ? ' set' : '' ); ?>" data-part="bottom_block">
					<p><?php esc_html_e( 'Bottom Block', 'riode-core' ); ?></p>
				</div>
				<div class="footer layout-part<?php echo esc_attr( isset( $layout['content']['footer'] ) && isset( $layout['content']['footer']['id'] ) ? ' set' : '' ); ?>" data-part="footer">
					<p><?php esc_html_e( 'Footer', 'riode-core' ); ?></p>
				</div>
			</div>
			<div class="part-options">
			</div>
		</div>

		<?php
	}
}
