<?php

use Elementor\Group_Control_Image_Size;

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			// Items
			'testimonial_group_list' => array(),

			// General
			'testimonial_type'       => 'simple',
			'star_icon'              => '',
			'star_shape'             => '',
			'avatar_pos'             => 'top',
			'commenter_pos'          => 'after',
			'rating_pos'             => 'before',
			'rating_sp'              => array( 'size' => 0 ),

			//Testimonial Layout
			'layout_type'            => 'grid',
			'col_sp'                 => '',
			'col_cnt'                => array( 'size' => 4 ),
		),
		$settings
	)
);

// Get Count
if ( ! is_array( $col_cnt ) ) {
	$col_cnt = json_decode( $col_cnt, true );
}

// Wrapper classes & attributes
$wrapper_class = array();
$wrapper_attrs = '';

$grid_space_class = riode_elementor_grid_space_class( $settings );
if ( $grid_space_class ) {
	$wrapper_class[] = $grid_space_class;
}

$col_cnt    = riode_elementor_grid_col_cnt( $settings );
$html_group = '';

if ( 'slider' == $layout_type ) {
	do_action( 'riode_save_used_widget', 'slider' );

	$wrapper_class = riode_get_slider_class( $settings );

	$wrapper_attrs .= ' data-plugin="owl" data-owl-options=' . esc_attr(
		json_encode(
			riode_get_slider_attrs( $settings, $col_cnt )
		)
	);
	$html_group    .= '<div class="testimonial-group ' . $wrapper_class . '" ' . $wrapper_attrs . '>';
} else {
	$extra_class = riode_get_col_class( $col_cnt );
	$html_group .= '<div class="testimonial-group ' . $extra_class . '">';
}

$group_settings = $settings;
unset( $group_settings['testimonial_group_list'] );

foreach ( $testimonial_group_list as $key => $item ) {
	ob_start();
	$settings = array_merge( $group_settings, $item );
	?>
	<div class="testimonial-item">
	<?php
	include RIODE_CORE_PATH . 'elementor/render/widget-testimonial-render.php';
	?>
	</div>
	<?php
	$html_group .= ob_get_clean();
}

$html_group .= '</div>';

echo $html_group;
