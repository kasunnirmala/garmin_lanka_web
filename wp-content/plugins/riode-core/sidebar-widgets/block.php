<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Riode_Block_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-block',
			'description' => esc_html__( 'Display Riode Block built by template block bilder', 'riode-core' ),
		);

		$control_ops = array( 'id_base' => 'block-widget' );

		parent::__construct( 'block-widget', esc_html__( 'RIODE - Block', 'riode-core' ), $widget_ops, $control_ops );
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

		if ( isset( $instance['id'] ) ) {
			echo do_shortcode( '[riode_block name="' . $instance['id'] . '"]' );
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['id']    = $new_instance['id'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );

		$blocks = get_posts(
			array(
				'post_type'   => 'riode_template',
				'meta_key'    => 'riode_template_type',
				'meta_value'  => 'block',
				'numberposts' => -1,
			)
		);

		sort( $blocks );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php esc_html_e( 'Title', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : ''; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>">
				<strong><?php esc_html_e( 'Select Block', 'riode-core' ); ?>:</strong>
				<select class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo isset( $instance['id'] ) ? esc_attr( $instance['id'] ) : ''; ?>">
					<?php
					echo '<option value=""' . selected( ( isset( $instance['id'] ) ? $instance['id'] : '' ), '' ) . '>' . esc_attr( 'Select block to use', 'riode-core' ) . '</option>';

					if ( ! empty( $blocks ) ) {
						foreach ( $blocks as $block ) {
							echo '<option value="' . $block->ID . '" ' . selected( ( isset( $instance['id'] ) ? $instance['id'] : '' ), $block->ID ) . '>' . $block->post_title . '</option>';
						}
					}
					?>
				</select>
			</label>
		</p>
		<?php
	}
}
