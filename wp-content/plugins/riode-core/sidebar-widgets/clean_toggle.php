<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Riode_Clean_Toggle_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-clean-toggle',
			'description' => esc_html__( 'Display Sidebar Toggle and Filter Clean button. This widget is working only for controllable shop sidebar.', 'riode-core' ),
		);

		$control_ops = array( 'id_base' => 'clean-toggle-widget' );

		parent::__construct( 'clean-toggle-widget', esc_html__( 'RIODE - Clean & Toggle', 'riode-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		if ( ! function_exists( 'riode_is_shop' ) || ! riode_is_shop() ) {
			return;
		}

		extract( $args ); // @codingStandardsIgnoreLine

		?>

		<div class="filter-actions">
			<a href="#" class="sidebar-toggle-btn toggle-remain btn btn-sm btn-rounded btn-outline btn-primary"><?php echo esc_html__( 'Filter', 'riode-core' ); ?><i class="d-icon-arrow-<?php echo is_rtl() ? 'right' : 'left'; ?>"></i></a>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="filter-clean"><?php echo esc_html__( 'Clean All', 'riode-core' ); ?></a>
		</div>

		<?php
	}


	function form( $instance ) {
		?>
		<p><?php echo sprintf( esc_html__( 'Display Sidebar Toggle and Filter Clean button. This widget is working only for %1$scontrollable shop sidebar%2$s. Make sure that this sidebar type is controllable in %3$spage layout dashboard%4$s.', 'riode-core' ), '<strong>', '</strong>', '<a href="' . admin_url( 'admin.php?page=riode_layout_dashboard' ) . '" target="_blank">', '</a>' ); ?></p>
		<?php
	}
}
