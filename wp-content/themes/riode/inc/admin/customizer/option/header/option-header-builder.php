<?php

/**
 * Header Builder
 */

Riode_Customizer::add_section(
	'header_builder',
	array(
		'title' => esc_html__( 'Header Builder', 'riode' ),
		'panel' => 'header',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'header_builder',
		'type'     => 'custom',
		'settings' => 'cs_header_builder_title',
		'label'    => '',
		'default'  => '<p style="margin-bottom: 20px; cursor: auto;">' . esc_html__( 'Create your header with Header Builder and show it in Layout Dashboard', 'riode' ) . '</p><a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=header' ) ) . '" target="_blank">' . esc_html__( 'Header Builder', 'riode' ) . '</a><a class="button button-primary button-xlarge" href="' . esc_url( admin_url( 'admin.php?page=riode_layout_dashboard' ) ) . '" target="_blank">' . esc_html__( 'Layout Dashboard', 'riode' ) . '</a>',
	)
);
