<?php
defined( 'ABSPATH' ) || die;
?>

<div class="riode-admin-panel-header">
	<h1><?php esc_html_e( 'Sidebar Manage', 'riode-core' ); ?></h1>
	<p><?php esc_html_e( 'Sidebar Manage Dashboard enables you to add unlimited widget areas for your stunning site and remove unnecessary sidebars.', 'riode-core' ); ?></p>
</div>
<div class="riode-admin-panel-body sidebar-manage">
	<table class="wp-list-table widefat" id="sidebar_table">
		<thead>
			<tr>
				<th scope="col" id="title" class="manage-column column-title column-primary"><?php esc_html_e( 'Title', 'riode-core' ); ?></th>
				<th scope="col" id="slug" class="manage-column column-slug"><?php esc_html_e( 'Slug', 'riode-core' ); ?></th>
				<th scope="col" id="remove" class="manage-column column-remove"><?php esc_html_e( 'Action', 'riode-core' ); ?></th>
			</tr>
		</thead>

		<tbody id="the-list">

		<?php 
			global $wp_registered_sidebars;
			$default_sidebars = array();
			foreach ( $wp_registered_sidebars as $key => $value) {
				echo '<tr id="' . $key . '" class="sidebar">';
					echo '<td class="title column-title"><a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">' . $value['name'] . '</a></td>';
					echo '<td class="slug column-slug">' . $key . '</td>';
					echo '<td class="remove column-remove">' . ( in_array( $key, array_keys( $this->sidebars ) ) ? '<a href="#">' . esc_html__( 'Remove', 'riode-core' ) . '</a>' : esc_html__( 'Unremovable', 'riode-core' ) ) . '</td>';
				echo '</tr>';
			}
		?>

		</tbody>
	</table>

	<button id="add_widget_area" class="button button-dark button-large"><?php esc_html_e( 'Add New Sidebar', 'riode-core' ); ?></button>
</div>
