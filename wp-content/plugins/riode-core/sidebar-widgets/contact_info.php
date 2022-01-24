<?php

// direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Riode_Contact_Info_Sidebar_Widget extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-contact-info',
			'description' => esc_html__( 'Display Contact Information.', 'riode-core' ),
		);

		$control_ops = array( 'id_base' => 'contact_info-widget' );

		parent::__construct( 'contact_info-widget', esc_html__( 'RIODE - Contact Info', 'riode-core' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args ); // @codingStandardsIgnoreLine

		$defaults = array(
			'title'        => esc_html__( 'Contact Info', 'riode-core' ),
			'phone_label'  => 'PHONE:',
			'phone_number' => 'Toll Free (123) 456-7890',
			'phone_link'   => '#',
			'email_label'  => 'EMAIL:',
			'email_link'   => 'riode@mail.com',
			'addr_label'   => 'ADDRESS:',
			'addr_link'    => '123 Street, City, Country',
			'work_label'   => 'WORKING DAYS / HOURS:',
			'work_link'    => 'Mon - Sun / 9:00 AM - 8:00 PM',
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

		$params = array(
			'phone_label' => 'phone_link',
			'email_label' => 'email_link',
			'addr_label'  => 'addr_link',
			'work_label'  => 'work_link',
		);

		echo '<ul class="contact-info">';
		foreach ( $params as $label => $value ) {
			if ( $instance[ $label ] && $instance[ $value ] ) {
				echo '<li class="info ' . explode( '_', $label )[0] . '">';
				echo '<label>' . sanitize_text_field( $instance[ $label ] ) . '</label>';
				if ( 'email_label' == $label ) {
					echo '<a href="mailto:' . sanitize_text_field( $instance[ $value ] ) . '" target="_blank">' . sanitize_text_field( $instance[ $value ] ) . '</a>';
				} elseif ( 'phone_label' == $label ) {
					echo '<a href="tel:' . sanitize_text_field( $instance[ $value ] ) . '" target="_blank">' . sanitize_text_field( $instance['phone_number'] ) . '</a>';
				} else {
					echo sanitize_text_field( $instance[ $value ] );
				}
				echo '</li>';
			}
		}
		echo '</ul>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']        = $new_instance['title'];
		$instance['phone_label']  = $new_instance['phone_label'];
		$instance['phone_number'] = $new_instance['phone_number'];
		$instance['phone_link']   = $new_instance['phone_link'];
		$instance['email_label']  = $new_instance['email_label'];
		$instance['email_link']   = $new_instance['email_link'];
		$instance['addr_label']   = $new_instance['addr_label'];
		$instance['addr_link']    = $new_instance['addr_link'];
		$instance['work_label']   = $new_instance['work_label'];
		$instance['work_link']    = $new_instance['work_link'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title'        => esc_html__( 'Contact Info', 'riode-core' ),
			'phone_label'  => 'PHONE:',
			'phone_number' => 'Toll Free (123) 456-7890',
			'phone_link'   => '#',
			'email_label'  => 'EMAIL:',
			'email_link'   => 'riode@mail.com',
			'addr_label'   => 'ADDRESS:',
			'addr_link'    => '123 Street, City, Country',
			'work_label'   => 'WORKING DAYS / HOURS:',
			'work_link'    => 'Mon - Sun / 9:00 AM - 8:00 PM',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php esc_html_e( 'Title', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : ''; ?>" placeholder="<?php echo sanitize_text_field( $instance['title'] ); ?>"/>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'phone_label' ); ?>">
				<strong><?php esc_html_e( 'Phone Label', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'phone_label' ); ?>" name="<?php echo $this->get_field_name( 'phone_label' ); ?>" value="<?php echo isset( $instance['phone_label'] ) ? esc_attr( $instance['phone_label'] ) : ''; ?>" placeholder="<?php echo sanitize_text_field( $instance['phone_label'] ); ?>"/>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'phone_number' ); ?>">
				<strong><?php esc_html_e( 'Phone Number', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'phone_number' ); ?>" name="<?php echo $this->get_field_name( 'phone_number' ); ?>" value="<?php echo isset( $instance['phone_number'] ) ? esc_attr( $instance['phone_number'] ) : ''; ?>" placeholder="<?php echo sanitize_text_field( $instance['phone_number'] ); ?>"/>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'phone_link' ); ?>">
				<strong><?php esc_html_e( 'Phone Link', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'phone_link' ); ?>" name="<?php echo $this->get_field_name( 'phone_link' ); ?>" value="<?php echo isset( $instance['phone_link'] ) ? esc_attr( $instance['phone_link'] ) : ''; ?>" placeholder="<?php echo sanitize_text_field( $instance['phone_link'] ); ?>"/>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'email_label' ); ?>">
				<strong><?php esc_html_e( 'Email Label', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'email_label' ); ?>" name="<?php echo $this->get_field_name( 'email_label' ); ?>" value="<?php echo isset( $instance['email_label'] ) ? esc_attr( $instance['email_label'] ) : ''; ?>" placeholder="<?php echo sanitize_text_field( $instance['email_label'] ); ?>"/>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'email_link' ); ?>">
				<strong><?php esc_html_e( 'Email Address', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'email_link' ); ?>" name="<?php echo $this->get_field_name( 'email_link' ); ?>" value="<?php echo isset( $instance['email_link'] ) ? esc_attr( $instance['email_link'] ) : ''; ?>" placeholder="<?php echo sanitize_text_field( $instance['email_link'] ); ?>"/>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'addr_label' ); ?>">
				<strong><?php esc_html_e( 'Address Label', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'addr_label' ); ?>" name="<?php echo $this->get_field_name( 'addr_label' ); ?>" value="<?php echo isset( $instance['addr_label'] ) ? esc_attr( $instance['addr_label'] ) : ''; ?>" placeholder="<?php echo sanitize_text_field( $instance['addr_label'] ); ?>"/>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'addr_link' ); ?>">
				<strong><?php esc_html_e( 'Address', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'addr_link' ); ?>" name="<?php echo $this->get_field_name( 'addr_link' ); ?>" value="<?php echo isset( $instance['addr_link'] ) ? esc_attr( $instance['addr_link'] ) : ''; ?>" placeholder="<?php echo sanitize_text_field( $instance['addr_link'] ); ?>"/>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'work_label' ); ?>">
				<strong><?php esc_html_e( 'Working Label', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'work_label' ); ?>" name="<?php echo $this->get_field_name( 'work_label' ); ?>" value="<?php echo isset( $instance['work_label'] ) ? esc_attr( $instance['work_label'] ) : ''; ?>" placeholder="<?php echo sanitize_text_field( $instance['work_label'] ); ?>"/>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'work_link' ); ?>">
				<strong><?php esc_html_e( 'Working Time', 'riode-core' ); ?>:</strong>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'work_link' ); ?>" name="<?php echo $this->get_field_name( 'work_link' ); ?>" value="<?php echo isset( $instance['work_link'] ) ? esc_attr( $instance['work_link'] ) : ''; ?>" placeholder="<?php echo sanitize_text_field( $instance['work_link'] ); ?>"/>
			</label>
		</p>
		<?php
	}
}
