<?php
/**
 * Riode Posts
 *
 * @since 1.1.0
 */

$creative_layout = riode_post_grid_presets();

foreach ( $creative_layout as $key => $item ) {
	$creative_layout[ $key ] = array(
		'title' => $key,
		'image' => $item,
	);
}

$params = array(
	esc_html__( 'General', 'riode-core' )          => array(
		esc_html__( 'Posts Selector', 'riode-core' ) => array(
			array(
				'type'        => 'autocomplete',
				'param_name'  => 'post_ids',
				'heading'     => esc_html__( 'Post IDs', 'riode-core' ),
				'description' => esc_html__(
					'Choose post ids of specific posts to display.
				*Comma separated list of post ids only.',
					'riode-core'
				),
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'        => 'autocomplete',
				'param_name'  => 'categories',
				'heading'     => esc_html__( 'Category IDs or slugs', 'riode-core' ),
				'description' => esc_html__(
					'Choose post category ids of specific posts to display or choose slugs of them.
				*Comma separated list of category ids or slugs only.',
					'riode-core'
				),
				'settings'    => array(
					'multiple' => true,
					'sortable' => true,
				),
			),
			array(
				'type'        => 'riode_number',
				'param_name'  => 'count',
				'heading'     => esc_html__( 'Posts Count', 'riode-core' ),
				'description' => esc_html__(
					'Select the number of posts to display.
					*0 value will show all categories.​',
					'riode-core'
				),
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'orderby',
				'heading'     => esc_html__( 'Order By', 'riode-core' ),
				'std'         => 'ID',
				'value'       => array(
					esc_html__( 'Default', 'riode-core' )  => '',
					esc_html__( 'ID', 'riode-core' )       => 'ID',
					esc_html__( 'Title', 'riode-core' )    => 'title',
					esc_html__( 'Date', 'riode-core' )     => 'date',
					esc_html__( 'Modified', 'riode-core' ) => 'modified',
					esc_html__( 'Author', 'riode-core' )   => 'author',
					esc_html__( 'Comment count', 'riode-core' ) => 'comment_count',
				),
				'description' => esc_html__(
					'Select the specific approach to sort your posts.',
					'riode-core'
				),
			),
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'orderway',
				'value'       => array(
					'DESC' => array(
						'title' => esc_html__( 'Descending', 'riode-core' ),
					),
					'ASC'  => array(
						'title' => esc_html__( 'Ascending', 'riode-core' ),
					),
				),
				'std'         => 'DESC',
				'description' => esc_html__(
					'Choose the specific approach to sort your posts.',
					'riode-core'
				),
			),
		),
		esc_html__( 'Layout', 'riode-core' )         => array(
			array(
				'type'        => 'riode_button_group',
				'param_name'  => 'layout_type',
				'heading'     => esc_html__( 'Posts Layout', 'riode-core' ),
				'std'         => 'grid',
				'value'       => array(
					'grid'     => array(
						'title' => esc_html__( 'Grid', 'riode-core' ),
					),
					'slider'   => array(
						'title' => esc_html__( 'Slider', 'riode-core' ),
					),
					'creative' => array(
						'title' => esc_html__( 'Creative Grid', 'riode-core' ),
					),
				),
				'description' => esc_html__(
					'Choose the specific layout to suit your need to display posts.',
					'riode-core'
				),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'thumbnail_size',
				'heading'    => esc_html__( 'Image Size', 'riode-core' ),
				'value'      => riode_get_image_sizes(),
			),
			array(
				'type'         => 'riode_button_group',
				'param_name'   => 'creative_mode',
				'heading'      => esc_html__( 'Creative Layout', 'riode-core' ),
				'std'          => 1,
				'button_width' => '150',
				'value'        => $creative_layout,
				'dependency'   => array(
					'element' => 'layout_type',
					'value'   => 'creative',
				),
				'description'  => esc_html__(
					'Select any preset to suit your need to display your posts under creative grid option.',
					'riode-core'
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Change Grid Height', 'riode-core' ),
				'param_name'  => 'creative_height',
				'units'       => array(
					'px',
					'rem',
					'vh',
					'%',
				),
				'std'         => '{"xl":"900","unit":"px"}',
				'dependency'  => array(
					'element' => 'layout_type',
					'value'   => 'creative',
				),
				'description' => esc_html__(
					'Determine the height of the grid layout.​',
					'riode-core'
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => esc_html__( 'Grid Mobile Height (%)', 'riode-core' ),
				'param_name'  => 'creative_height_ratio',
				'units'       => array(
					'%',
				),
				'dependency'  => array(
					'element' => 'layout_type',
					'value'   => 'creative',
				),
				'description' => esc_html__(
					'Determine the height of the grid layout on mobile.​​',
					'riode-core'
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'grid_float',
				'heading'     => esc_html__( 'Use Float Grid', 'riode-core' ),
				'description' => esc_html__( 'The Layout will be built with only float style not using isotope plugin. This is very useful for some simple creative layouts.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element' => 'layout_type',
					'value'   => 'creative',
				),
				'description' => esc_html__(
					'Allows you to configure your grid with only float style.​​​',
					'riode-core'
				),
			),
			array(
				'type'       => 'riode_number',
				'param_name' => 'col_cnt',
				'heading'    => esc_html__( 'Columns', 'riode-core' ),
				'responsive' => true,
				'value'      => '{"xl":"3"}',
			),
			array(
				'type'       => 'riode_button_group',
				'param_name' => 'col_sp',
				'heading'    => esc_html__( 'Columns Spacing', 'riode-core' ),
				'std'        => 'md',
				'value'      => array(
					'no' => array(
						'title' => esc_html__( 'No space', 'riode-core' ),
					),
					'xs' => array(
						'title' => esc_html__( 'Extra Small', 'riode-core' ),
					),
					'sm' => array(
						'title' => esc_html__( 'Small', 'riode-core' ),
					),
					'md' => array(
						'title' => esc_html__( 'Medium', 'riode-core' ),
					),
					'lg' => array(
						'title' => esc_html__( 'Large', 'riode-core' ),
					),
				),
			),
			array(
				'type'       => 'riode_button_group',
				'param_name' => 'slider_vertical_align',
				'heading'    => esc_html__( 'Vertical Align', 'riode-core' ),
				'value'      => array(
					'top'         => array(
						'title' => esc_html__( 'Top', 'riode-core' ),
					),
					'middle'      => array(
						'title' => esc_html__( 'Middle', 'riode-core' ),
					),
					'bottom'      => array(
						'title' => esc_html__( 'Bottom', 'riode-core' ),
					),
					'same-height' => array(
						'title' => esc_html__( 'Stretch', 'riode-core' ),
					),
				),
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'row_cnt',
				'heading'     => esc_html__( 'Rows Count', 'riode-core' ),
				'description' => esc_html__( 'How many rows of products should be shown in each column?', 'riode-core' ),
				'value'       => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
				),
				'dependency'  => array(
					'element' => 'layout_type',
					'value'   => 'slider',
				),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'loadmore_type',
				'heading'    => esc_html__( 'Load More', 'riode-core' ),
				'value'      => array(
					esc_html__( 'No', 'riode-core' ) => '',
					esc_html__( 'By button', 'riode-core' ) => 'button',
					esc_html__( 'By scroll', 'riode-core' ) => 'scroll',
				),
				'dependency' => array(
					'element' => 'layout_type',
					'value'   => 'grid',
				),
			),
			array(
				'type'       => 'textfield',
				'param_name' => 'loadmore_label',
				'heading'    => esc_html__( 'Load More Label', 'riode-core' ),
				'value'      => 'Load More',
				'dependency' => array(
					'element' => 'layout_type',
					'value'   => 'grid',
				),
			),
		),
		esc_html__( 'Type' )                         => array(
			array(
				'type'        => 'checkbox',
				'param_name'  => 'follow_theme_option',
				'heading'     => esc_html__( 'Follow Theme Option', 'riode-core' ),
				'std'         => 'yes',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'description' => esc_html__(
					'Determine the post type globally.​',
					'riode-core'
				),
			),
			array(
				'type'         => 'riode_button_group',
				'param_name'   => 'post_type',
				'heading'      => esc_html__( 'Post Type', 'riode-core' ),
				'button_width' => '200',
				'std'          => 'default',
				'value'        => array(
					'default'       => array(
						'image' => riode_get_customize_dir() . '/post/default.jpg',
						'title' => 'Default',
					),
					'list'          => array(
						'image' => riode_get_customize_dir() . '/post/list.jpg',
						'title' => 'List',
					),
					'mask'          => array(
						'image' => riode_get_customize_dir() . '/post/mask.jpg',
						'title' => 'Mask',
					),
					'mask gradient' => array(
						'image' => riode_get_customize_dir() . '/post/gradient.jpg',
						'title' => 'Gradient',
					),
					'widget'        => array(
						'image' => riode_get_customize_dir() . '/post/widget.jpg',
						'title' => 'Widget',
					),
					'list-xs'       => array(
						'image' => riode_get_customize_dir() . '/post/calendar.jpg',
						'title' => 'Calendar',
					),
					'framed'        => array(
						'image' => riode_get_customize_dir() . '/post/framed.jpg',
						'title' => 'Frame',
					),
					'overlap'       => array(
						'image' => riode_get_customize_dir() . '/post/overlap.jpg',
						'title' => 'Overlap',
					),
				),
				'dependency'   => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'description'  => esc_html__(
					'Select your specific post type to suit your need.​​',
					'riode-core'
				),
			),
			array(
				'type'        => 'riode_multiselect',
				'param_name'  => 'show_info',
				'heading'     => esc_html__( 'Show Information', 'riode-core' ),
				'value'       => array(
					esc_html__( 'Featured Image', 'riode-core' ) => 'image',
					esc_html__( 'Author', 'riode-core' )   => 'author',
					esc_html__( 'Date', 'riode-core' )     => 'date',
					esc_html__( 'Comments Count', 'riode-core' ) => 'comment',
					esc_html__( 'Category', 'riode-core' ) => 'category',
					esc_html__( 'Content', 'riode-core' )  => 'content',
					esc_html__( 'Read More', 'riode-core' ) => 'readmore',
				),
				'description' => sprintf( esc_html__( 'Includes the specific post information which you want to show in your site. *Showing information option will not work for %1$sList, Mask and Mask gradient type%2$s.', 'riode-core' ), '<b>', '</b>' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'std'         => 'image,date,author,category,comment,readmore',
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'overlay',
				'heading'     => esc_html__( 'Image Hover Effect', 'riode-core' ),
				'value'       => array(
					esc_html__( 'No', 'riode-core' )    => '',
					esc_html__( 'Light', 'riode-core' ) => 'light',
					esc_html__( 'Dark', 'riode-core' )  => 'dark',
					esc_html__( 'Zoom', 'riode-core' )  => 'zoom',
					esc_html__( 'Zoom and Light', 'riode-core' ) => 'zoom_light',
					esc_html__( 'Zoom and Dark', 'riode-core' ) => 'zoom_dark',
				),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'description' => esc_html__(
					'Allows your post media have overlay effect on hover.​',
					'riode-core'
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'show_datebox',
				'heading'     => esc_html__( 'Show Date On Featured Image', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'description' => esc_html__(
					'Allows you to show date on the post media with prebuilt design.​​',
					'riode-core'
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'excerpt_custom',
				'heading'     => esc_html__( 'Custom Excerpt Length', 'riode-core' ),
				'description' => esc_html__( 'If you want to customize excerpt length, toggle on this option.', 'riode-core' ),
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'excerpt_type',
				'heading'     => esc_html__( 'Excerpt By', 'riode-core' ),
				'value'       => array(
					esc_html__( 'Words', 'riode-core' ) => 'words',
					esc_html__( 'Characters', 'riode-core' ) => 'character',
				),
				'std'         => 'words',
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'description' => esc_html__(
					'Determine how to change the post excerpt line.​​​​',
					'riode-core'
				),
			),
			array(
				'type'        => 'riode_number',
				'heading'     => __( 'Excerpt Length', 'riode-core' ),
				'param_name'  => 'excerpt_limit',
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'description' => esc_html__(
					'Determine the number of words or characters to change the post excerpt line.​',
					'riode-core'
				),
			),
		),
		esc_html__( 'Read More Button' )             => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Read More Label', 'riode-core' ),
				'param_name'  => 'read_more_label',
				'admin_label' => true,
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'description' => esc_html__(
					'Type the specific label for read more button.​',
					'riode-core'
				),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Use Custom', 'riode-core' ),
				'param_name'  => 'read_more_custom',
				'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency'  => array(
					'element'            => 'follow_theme_option',
					'value_not_equal_to' => 'yes',
				),
				'description' => esc_html__(
					'Allows you to customize the read more button.​',
					'riode-core'
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Type', 'riode-core' ),
				'param_name' => 'button_type',
				'value'      => array(
					esc_html__( 'Default', 'riode-core' ) => '',
					esc_html__( 'Solid', 'riode-core' )   => 'btn-solid',
					esc_html__( 'Outline', 'riode-core' ) => 'btn-outline',
					esc_html__( 'Inline', 'riode-core' )  => 'btn-link',
				),
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Size', 'riode-core' ),
				'param_name' => 'button_size',
				'value'      => array(
					'btn-sm' => array(
						'title' => esc_html__( 'Small', 'riode-core' ),
					),
					'btn-md' => array(
						'title' => esc_html__( 'Medium', 'riode-core' ),
					),
					''       => array(
						'title' => esc_html__( 'Normal', 'riode-core' ),
					),
					'btn-lg' => array(
						'title' => esc_html__( 'Large', 'riode-core' ),
					),
				),
				'std'        => '',
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Hover Underline', 'riode-core' ),
				'param_name' => 'link_hover_type',
				'value'      => array(
					''                 => array(
						'title' => esc_html__( 'None', 'riode-core' ),
					),
					'btn-underline sm' => array(
						'title' => esc_html__( 'Underline1', 'riode-core' ),
					),
					'btn-underline'    => array(
						'title' => esc_html__( 'Underline2', 'riode-core' ),
					),
					'btn-underline lg' => array(
						'title' => esc_html__( 'Underline3', 'riode-core' ),
					),
				),
				'dependency' => array(
					'element' => 'button_type',
					'value'   => 'btn-link',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Box Shadow', 'riode-core' ),
				'param_name' => 'shadow',
				'value'      => array(
					esc_html__( 'None', 'riode-core' )     => '',
					esc_html__( 'Shadow 1', 'riode-core' ) => 'btn-shadow-sm',
					esc_html__( 'Shadow 2', 'riode-core' ) => 'btn-shadow',
					esc_html__( 'Shadow 3', 'riode-core' ) => 'btn-shadow-lg',
				),
				'dependency' => array(
					'element'            => 'button_type',
					'value_not_equal_to' => 'btn-link',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Border Style', 'riode-core' ),
				'param_name' => 'button_border',
				'label_type' => 'icon',
				'value'      => array(
					''            => array(
						'title' => esc_html__( 'Rectangle', 'riode-core' ),
						'icon'  => 'attr-icon-square',
					),
					'btn-rounded' => array(
						'title' => esc_html__( 'Rounded', 'riode-core' ),
						'icon'  => 'attr-icon-rounded',
					),
					'btn-ellipse' => array(
						'title' => esc_html__( 'Ellipse', 'riode-core' ),
						'icon'  => 'attr-icon-ellipse',
					),
				),
				'dependency' => array(
					'element'            => 'button_type',
					'value_not_equal_to' => 'btn-link',
				),
			),
			array(
				'type'        => 'riode_button_group',
				'heading'     => esc_html__( 'Skin', 'riode-core' ),
				'param_name'  => 'button_skin',
				'value'       => array(
					''              => array(
						'title' => esc_html__( 'Default', 'riode-core' ),
						'color' => '#e4eaec',
					),
					'btn-primary'   => array(
						'title' => esc_html__( 'Primary', 'riode-core' ),
						'color' => 'var(--rio-primary-color,#27c)',
					),
					'btn-secondary' => array(
						'title' => esc_html__( 'Secondary', 'riode-core' ),
						'color' => 'var(--rio-secondary-color,#d26e4b)',
					),
					'btn-alert'     => array(
						'title' => esc_html__( 'Alert', 'riode-core' ),
						'color' => 'var(--rio-alert-color,#b10001)',
					),
					'btn-success'   => array(
						'title' => esc_html__( 'Success', 'riode-core' ),
						'color' => 'var(--rio-success-color,#a8c26e)',
					),
					'btn-dark'      => array(
						'title' => esc_html__( 'Dark', 'riode-core' ),
						'color' => 'var(--rio-dark-color,#222)',
					),
					'btn-white'     => array(
						'title' => esc_html__( 'white', 'riode-core' ),
						'color' => '#fff',
					),
				),
				'description' => '',
				'dependency'  => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Disable Line-break', 'riode-core' ),
				'param_name' => 'line_break',
				'value'      => array(
					'nowrap' => array(
						'title' => esc_html__( 'On', 'riode-core' ),
					),
					'normal' => array(
						'title' => esc_html__( 'Off', 'riode-core' ),
					),
				),
				'std'        => 'nowrap',
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .btn' => 'white-space: {{VALUE}};',
				),
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Icon?', 'riode-core' ),
				'param_name' => 'show_icon',
				'value'      => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'read_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Label', 'riode-core' ),
				'param_name' => 'show_label',
				'value'      => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
				'std'        => 'yes',
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'iconpicker',
				'heading'    => esc_html__( 'Icon', 'riode-core' ),
				'param_name' => 'icon',
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Icon Position', 'riode-core' ),
				'param_name' => 'icon_pos',
				'value'      => array(
					'after'  => array(
						'title' => esc_html__( 'After', 'riode-core' ),
					),
					'before' => array(
						'title' => esc_html__( 'Before', 'riode-core' ),
					),
				),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Icon Spacing', 'riode-core' ),
				'param_name' => 'icon_space',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'value'      => '',
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .btn-icon-left:not(.btn-reveal-left) i' => "margin-{$right}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .post-wrap .btn-icon-right:not(.btn-reveal-right) i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .post-wrap .btn-reveal-left:hover i, {{WRAPPER}} .post-wrap .btn-reveal-left:active i, {{WRAPPER}} .post-wrap .btn-reveal-left:focus i'  => "margin-{$right}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .post-wrap .btn-reveal-right:hover i, {{WRAPPER}} .post-wrap .btn-reveal-right:active i, {{WRAPPER}} .post-wrap .btn-reveal-right:focus i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
				'param_name' => 'icon_size',
				'value'      => '',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .btn i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Hover Effect', 'riode-core' ),
				'param_name' => 'icon_hover_effect',
				'value'      => array(
					esc_html__( 'none', 'riode-core' )     => '',
					esc_html__( 'Slide Left', 'riode-core' ) => 'btn-slide-left',
					esc_html__( 'Slide Right', 'riode-core' ) => 'btn-slide-right',
					esc_html__( 'Slide Up', 'riode-core' ) => 'btn-slide-up',
					esc_html__( 'Slide Down', 'riode-core' ) => 'btn-slide-down',
					esc_html__( 'Reveal Left', 'riode-core' ) => 'btn-reveal-left',
					esc_html__( 'Reveal Right', 'riode-core' ) => 'btn-reveal-right',
				),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Animation Infinite', 'riode-core' ),
				'param_name' => 'icon_hover_effect_infinite',
				'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
		),
		esc_html__( 'Load More Button' )             => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Type', 'riode-core' ),
				'param_name' => 'loadmore_button_type',
				'value'      => array(
					esc_html__( 'Default', 'riode-core' ) => '',
					esc_html__( 'Solid', 'riode-core' )   => 'btn-solid',
					esc_html__( 'Outline', 'riode-core' ) => 'btn-outline',
					esc_html__( 'Inline', 'riode-core' )  => 'btn-link',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Size', 'riode-core' ),
				'param_name' => 'loadmore_button_size',
				'value'      => array(
					'btn-sm' => array(
						'title' => esc_html__( 'Small', 'riode-core' ),
					),
					'btn-md' => array(
						'title' => esc_html__( 'Medium', 'riode-core' ),
					),
					''       => array(
						'title' => esc_html__( 'Normal', 'riode-core' ),
					),
					'btn-lg' => array(
						'title' => esc_html__( 'Large', 'riode-core' ),
					),
				),
				'std'        => '',
				'dependency' => array(
					'element' => 'load_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Hover Underline', 'riode-core' ),
				'param_name' => 'loadmore_link_hover_type',
				'value'      => array(
					''                 => array(
						'title' => esc_html__( 'None', 'riode-core' ),
					),
					'btn-underline sm' => array(
						'title' => esc_html__( 'Underline1', 'riode-core' ),
					),
					'btn-underline'    => array(
						'title' => esc_html__( 'Underline2', 'riode-core' ),
					),
					'btn-underline lg' => array(
						'title' => esc_html__( 'Underline3', 'riode-core' ),
					),
				),
				'dependency' => array(
					'element' => 'button_type',
					'value'   => 'btn-link',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Box Shadow', 'riode-core' ),
				'param_name' => 'loadmore_shadow',
				'value'      => array(
					esc_html__( 'None', 'riode-core' )     => '',
					esc_html__( 'Shadow 1', 'riode-core' ) => 'btn-shadow-sm',
					esc_html__( 'Shadow 2', 'riode-core' ) => 'btn-shadow',
					esc_html__( 'Shadow 3', 'riode-core' ) => 'btn-shadow-lg',
				),
				'dependency' => array(
					'element'            => 'button_type',
					'value_not_equal_to' => 'btn-link',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Border Style', 'riode-core' ),
				'param_name' => 'loadmore_button_border',
				'label_type' => 'icon',
				'value'      => array(
					''            => array(
						'title' => esc_html__( 'Rectangle', 'riode-core' ),
						'icon'  => 'attr-icon-square',
					),
					'btn-rounded' => array(
						'title' => esc_html__( 'Rounded', 'riode-core' ),
						'icon'  => 'attr-icon-rounded',
					),
					'btn-ellipse' => array(
						'title' => esc_html__( 'Ellipse', 'riode-core' ),
						'icon'  => 'attr-icon-ellipse',
					),
				),
				'dependency' => array(
					'element'            => 'button_type',
					'value_not_equal_to' => 'btn-link',
				),
			),
			array(
				'type'        => 'riode_button_group',
				'heading'     => esc_html__( 'Skin', 'riode-core' ),
				'param_name'  => 'loadmore_button_skin',
				'value'       => array(
					''              => array(
						'title' => esc_html__( 'Default', 'riode-core' ),
						'color' => '#e4eaec',
					),
					'btn-primary'   => array(
						'title' => esc_html__( 'Primary', 'riode-core' ),
						'color' => 'var(--rio-primary-color,#27c)',
					),
					'btn-secondary' => array(
						'title' => esc_html__( 'Secondary', 'riode-core' ),
						'color' => 'var(--rio-secondary-color,#d26e4b)',
					),
					'btn-alert'     => array(
						'title' => esc_html__( 'Alert', 'riode-core' ),
						'color' => 'var(--rio-alert-color,#b10001)',
					),
					'btn-success'   => array(
						'title' => esc_html__( 'Success', 'riode-core' ),
						'color' => 'var(--rio-success-color,#a8c26e)',
					),
					'btn-dark'      => array(
						'title' => esc_html__( 'Dark', 'riode-core' ),
						'color' => 'var(--rio-dark-color,#222)',
					),
					'btn-white'     => array(
						'title' => esc_html__( 'white', 'riode-core' ),
						'color' => '#fff',
					),
				),
				'description' => '',
				'dependency'  => array(
					'element' => 'load_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Icon?', 'riode-core' ),
				'param_name' => 'loadmore_show_icon',
				'value'      => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
				'dependency' => array(
					'element' => 'load_more_custom',
					'value'   => 'yes',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Label', 'riode-core' ),
				'param_name' => 'loadmore_show_label',
				'value'      => array( esc_html__( 'Yes, please', 'riode-core' ) => 'yes' ),
				'std'        => 'yes',
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'iconpicker',
				'heading'    => esc_html__( 'Icon', 'riode-core' ),
				'param_name' => 'loadmore_icon',
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Icon Position', 'riode-core' ),
				'param_name' => 'loadmore_icon_pos',
				'value'      => array(
					'after'  => array(
						'title' => esc_html__( 'After', 'riode-core' ),
					),
					'before' => array(
						'title' => esc_html__( 'Before', 'riode-core' ),
					),
				),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Icon Spacing', 'riode-core' ),
				'param_name' => 'loadmore_icon_space',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'value'      => '',
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .btn-icon-left:not(.btn-reveal-left) i' => "margin-{$right}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .post-wrap .btn-icon-right:not(.btn-reveal-right) i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .post-wrap .btn-reveal-left:hover i, {{WRAPPER}} .post-wrap .btn-reveal-left:active i, {{WRAPPER}} .post-wrap .btn-reveal-left:focus i'  => "margin-{$right}: {{VALUE}}{{UNIT}};",
					'{{WRAPPER}} .post-wrap .btn-reveal-right:hover i, {{WRAPPER}} .post-wrap .btn-reveal-right:active i, {{WRAPPER}} .post-wrap .btn-reveal-right:focus i'  => "margin-{$left}: {{VALUE}}{{UNIT}};",
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
				'param_name' => 'loadmore_icon_size',
				'value'      => '',
				'units'      => array(
					'px',
					'rem',
					'em',
				),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .btn-load i' => 'font-size: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Hover Effect', 'riode-core' ),
				'param_name' => 'loadmore_icon_hover_effect',
				'value'      => array(
					esc_html__( 'none', 'riode-core' )     => '',
					esc_html__( 'Slide Left', 'riode-core' ) => 'btn-slide-left',
					esc_html__( 'Slide Right', 'riode-core' ) => 'btn-slide-right',
					esc_html__( 'Slide Up', 'riode-core' ) => 'btn-slide-up',
					esc_html__( 'Slide Down', 'riode-core' ) => 'btn-slide-down',
					esc_html__( 'Reveal Left', 'riode-core' ) => 'btn-reveal-left',
					esc_html__( 'Reveal Right', 'riode-core' ) => 'btn-reveal-right',
				),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Animation Infinite', 'riode-core' ),
				'param_name' => 'loadmore_icon_hover_effect_infinite',
				'value'      => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
				'dependency' => array(
					'element'   => 'show_icon',
					'not_empty' => true,
				),
			),
		),
	),
	esc_html__( 'Style', 'riode-core' )            => array(
		esc_html__( 'Content', 'riode-core' )          => array(
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'post_padding',
				'heading'    => esc_html__( 'Post Padding', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'post_bg',
				'heading'    => esc_html__( 'Post Background Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post' => 'background-color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'content_padding',
				'heading'    => esc_html__( 'Content Wrap Padding', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-details' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_button_group',
				'heading'    => esc_html__( 'Content Alignment', 'riode-core' ),
				'param_name' => 'content_align',
				'value'      => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'riode-core' ),
						'icon'  => 'fas fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'riode-core' ),
						'icon'  => 'fas fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'riode-core' ),
						'icon'  => 'fas fa-align-right',
					),
				),
			),
		),
		esc_html__( 'Post Meta', 'riode-core' )        => array(
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'meta_margin',
				'heading'    => esc_html__( 'Meta Margin', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-meta' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'meta_color',
				'heading'    => esc_html__( 'Meta Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-meta' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Meta Typography', 'riode-core' ),
				'param_name' => 'meta_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-meta',
				),
			),
		),
		esc_html__( 'Post Title', 'riode-core' )       => array(
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'title_margin',
				'heading'    => esc_html__( 'Title Margin', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-details .post-title' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'title_color',
				'heading'    => esc_html__( 'Title Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-details  .post-title' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Title Typography', 'riode-core' ),
				'param_name' => 'title_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-details  .post-title',
				),
			),
		),
		esc_html__( 'Post Category', 'riode-core' )    => array(
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'cats_margin',
				'heading'    => esc_html__( 'Category Margin', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-cats' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'cats_color',
				'heading'    => esc_html__( 'Category Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-cats' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Category Typography', 'riode-core' ),
				'param_name' => 'cats_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-cats',
				),
			),
		),
		esc_html__( 'Post Excerpt', 'riode-core' )     => array(
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'content_margin',
				'heading'    => esc_html__( 'Excerpt Margin', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-content p' => 'margin-top:{{TOP}};margin-right:{{RIGHT}};margin-bottom:{{BOTTOM}};margin-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'colorpicker',
				'param_name' => 'content_color',
				'heading'    => esc_html__( 'Excerpt Color', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-content' => 'color: {{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Excerpt Typography', 'riode-core' ),
				'param_name' => 'content_typography',
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-content p',
				),
			),
		),
		esc_html__( 'Calendar Type', 'riode-core' )    => array(
			array(
				'type'       => 'riode_number',
				'heading'    => __( 'Calendar Width', 'riode-core' ),
				'param_name' => 'cal_width',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-calendar' => 'width: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'riode_number',
				'heading'    => __( 'Calendar Height', 'riode-core' ),
				'param_name' => 'cal_height',
				'responsive' => true,
				'units'      => array(
					'px',
					'rem',
					'%',
				),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-calendar' => 'height: {{VALUE}}{{UNIT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'cal_border',
				'heading'    => esc_html__( 'Border Width', 'riode-core' ),
				'responsive' => false,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-calendar' => 'border-style: solid; border-top-width:{{TOP}};border-right-width:{{RIGHT}};border-bottom-width:{{BOTTOM}};border-left-width:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'cal_border_radius',
				'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
				'responsive' => false,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-calendar' => 'border-top-left-radius:{{TOP}};border-top-right-radius:{{RIGHT}};border-bottom-right-radius:{{BOTTOM}};border-bottom-left-radius:{{LEFT}};',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Day Typography', 'riode-core' ),
				'param_name' => 'cal_day_type',
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-calendar .post-day',
				),
			),
			array(
				'type'       => 'riode_typography',
				'heading'    => esc_html__( 'Month Typography', 'riode-core' ),
				'param_name' => 'cal_month_type',
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post-calendar .post-month',
				),
			),
			array(
				'type'       => 'riode_color_group',
				'heading'    => esc_html__( 'Colors', 'riode-core' ),
				'param_name' => 'cal_color',
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .post-wrap .post-calendar',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
		),
		esc_html__( 'Read More Button', 'riode-core' ) => array(
			array(
				'type'       => 'riode_typography',
				'param_name' => 'button_typography',
				'heading'    => esc_html__( 'Button Typography', 'riode-core' ),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post .btn',
				),
			),
			array(
				'type'       => 'riode_color_group',
				'param_name' => 'button_colors',
				'heading'    => esc_html__( 'Colors', 'riode-core' ),
				'selectors'  => array(
					'normal' => '{{WRAPPER}} .post-wrap .post .btn',
					'hover'  => '{{WRAPPER}} .post-wrap .post .btn:hover, {{WRAPPER}} .post-wrap .post .btn:focus',
				),
				'choices'    => array( 'color', 'background-color', 'border-color' ),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'button_padding',
				'heading'    => esc_html__( 'Button Padding', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post .btn' => 'padding-top:{{TOP}};padding-right:{{RIGHT}};padding-bottom:{{BOTTOM}};padding-left:{{LEFT}};',
				),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'button_border_type',
				'heading'    => esc_html__( 'Border Type', 'riode-core' ),
				'value'      => array(
					esc_html__( 'None', 'riode-core' )   => 'none',
					esc_html__( 'Solid', 'riode-core' )  => 'solid',
					esc_html__( 'Double', 'riode-core' ) => 'double',
					esc_html__( 'Dotted', 'riode-core' ) => 'dotted',
					esc_html__( 'Dashed', 'riode-core' ) => 'dashed',
					esc_html__( 'Groove', 'riode-core' ) => 'groove',
				),
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post .btn' => 'border-style:{{VALUE}};',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'button_border_width',
				'heading'    => esc_html__( 'Border Width', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post .btn' => 'border-top:{{TOP}};border-right:{{RIGHT}};border-bottom:{{BOTTOM}};border-left:{{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'button_border_type',
					'value_not_equal_to' => 'none',
				),
			),
			array(
				'type'       => 'riode_dimension',
				'param_name' => 'button_border_radius',
				'heading'    => esc_html__( 'Border Radius', 'riode-core' ),
				'responsive' => true,
				'selectors'  => array(
					'{{WRAPPER}} .post-wrap .post .btn' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				),
				'dependency' => array(
					'element'            => 'button_border_type',
					'value_not_equal_to' => 'none',
				),
			),
		),
		esc_html__( 'Load More Button Style', 'riode-core' ) => array(
			'riode_wpb_loadmore_button_controls',
		),
	),
	esc_html__( 'Carousel Options', 'riode-core' ) => array(
		esc_html__( 'Options', 'riode-core' ) => array(
			'riode_wpb_slider_general_controls',
		),
		esc_html__( 'Nav', 'riode-core' )     => array(
			'riode_wpb_slider_nav_controls',
		),
		esc_html__( 'Dots', 'riode-core' )    => array(
			'riode_wpb_slider_dots_controls',
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_design_controls(), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Posts', 'riode-core' ),
		'base'            => 'wpb_riode_posts',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_posts',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Display blog posts in grid/slider layout', 'riode-core' ),
		'params'          => $params,
	)
);


// Category Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_posts_categories_callback', 'riode_wpb_shortcode_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_posts_categories_render', 'riode_wpb_shortcode_category_id_render', 10, 1 );

// Post Ids Autocomplete
add_filter( 'vc_autocomplete_wpb_riode_posts_post_ids_callback', 'riode_wpb_shortcode_post_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_riode_posts_post_ids_render', 'riode_wpb_shortcode_post_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Posts extends WPBakeryShortCode {
	}
}
