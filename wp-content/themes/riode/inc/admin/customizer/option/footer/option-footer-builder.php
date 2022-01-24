<?php

/**
 * Footer Builder
 */

Riode_Customizer::add_section(
	'footer_builder',
	array(
		'title' => esc_html__( 'Footer Builder', 'riode' ),
		'panel' => 'footer',
	)
);

Riode_Customizer::add_field(
	'option',
	array(
		'section'  => 'footer_builder',
		'type'     => 'custom',
		'settings' => 'cs_footer_builder_title',
		'label'    => '',
		'default'  => '<p>' . esc_html__( 'There are 2 methods to build your footer.', 'riode' ) . '</p>' . '<p style="margin: 0; cursor: auto;">' . sprintf( esc_html__( '1. Complete your footer by drag and drop widgets to %1$sWidget Areas%2$s. (Classic Footer)', 'riode' ), '<strong>', '</strong>' ) . '</p>' . '<p style="cursor: auto;">' . sprintf( esc_html__( '2. Create your footer with %1$sFooter Builder%2$s and show it in %3$sLayout Dashboard%4$s.', 'riode' ), '<strong>', '</strong>', '<a href="' . esc_url( admin_url( 'admin.php?page=riode_layout_dashboard' ) ) . '" target="_blank">', '</a>' ) . '</p>' . '<a class="button button-xlarge button-primary" href="' . esc_url( admin_url( 'widgets.php' ) ) . '" target="_blank" > ' . esc_html__( 'Classic Footer', 'riode' ) . '</a>' . ' <a class="button button-xlarge button-primary" href="' . esc_url( admin_url( 'edit.php?post_type=riode_template&riode_template_type=footer' ) ) . '" target="_blank" > ' . esc_html__( 'Footer Builder', 'riode' ) . '</a>',
	)
);
