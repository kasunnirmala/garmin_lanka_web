<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Riode_Vendor_Info_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-vendor-info',
			'description' => esc_html__( 'Display vendor info for single product page.', 'riode-core' ),
		);

		$control_ops = array( 'id_base' => 'vendor-info-widget' );

		parent::__construct( 'vendor-info-widget', esc_html__( 'RIODE - Vendor Info', 'riode-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args ); // @codingStandardsIgnoreLine

		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		$output = '';
		echo $before_widget;

		if ( $title ) {
			echo $before_title . sanitize_text_field( $title ) . $after_title;
		}

		global $post;
		global $product;

		$origial_product = $product;
		$product         = wc_get_product( $post );

		$author_id  = get_post_field( 'post_author', $product->get_id() );
		$author     = get_user_by( 'id', $author_id );
		$store_info = dokan_get_store_info( $author->ID );

		dokan_get_template_part(
			'global/product-tab',
			'',
			array(
				'author'     => $author,
				'store_info' => $store_info,
			)
		);

		$product = $origial_product;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title' => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php esc_html_e( 'Title', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : ''; ?>" />
			</label>
		</p>
		<?php
	}
}
