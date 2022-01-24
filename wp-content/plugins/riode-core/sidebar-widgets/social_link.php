<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Riode_Social_Link_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-social-links',
			'description' => esc_html__( 'Display social link items composed of selected on theme options.', 'riode-core' ),
		);

		$control_ops = array( 'id_base' => 'social_link-widget' );

		parent::__construct( 'social_link-widget', esc_html__( 'RIODE - Social Links', 'riode-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args ); // @codingStandardsIgnoreLine

		$defaults = array(
			'facebook' => '#',
			'twitter'  => '#',
			'linkedin' => '#',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		$output = '';
		echo $before_widget;

		if ( $title ) {
			echo $before_title . sanitize_text_field( $title ) . $after_title;
		}
		?>

		<div class="social-icons framed-icons">
		<?php
		global $riode_social_name, $riode_social_icon;
		if ( ! empty( $riode_social_name ) ) {
			foreach ( $riode_social_name as $key => $value ) {
				if ( isset( $instance[ $key ] ) && $instance[ $key ] ) {
					?>
					<a class="social-icon framed social-<?php echo esc_attr( $key ); ?>" target="_blank" href="<?php echo esc_url( $instance[ $key ] ); ?>">
						<i class="<?php echo esc_attr( $riode_social_icon[ $key ][0] ); ?>"></i>
					</a>
					<?php
				}
			}
		}
		?>
		</div>

		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		global $riode_social_name;
		if ( ! empty( $riode_social_name ) ) {
			foreach ( $riode_social_name as $key => $value ) {
				$instance[ $key ] = $new_instance[ $key ];
			}
		}

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'facebook' => '#',
			'twitter'  => '#',
			'linkedin' => '#',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		global $riode_social_name;
		if ( ! empty( $riode_social_name ) ) {
			foreach ( $riode_social_name as $key => $value ) {
				?>

				<p>
					<label for="<?php echo $this->get_field_id( $key ); ?>">
						<strong><?php echo esc_html( $value ); ?>:</strong>
						<input type="text" class="widefat" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" value="<?php echo isset( $instance[ $key ] ) ? sanitize_text_field( $instance[ $key ] ) : ''; ?>" />
					</label>
				</p>

				<?php
			}
		}
	}
}
