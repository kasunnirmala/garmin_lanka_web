<?php
/**
 * Riode Blockquote
 *
 * @since 1.4.0
 */

$params = array(
	esc_html__( 'General', 'riode-core' ) => array(
		array(
			'type'         => 'riode_button_group',
			'param_name'   => 'type',
			'heading'      => esc_html__( 'Type', 'riode-core' ),
			'description'  => esc_html__( 'Choose your favourite blockquote type from pre-built types.', 'riode-core' ),
			'button_width' => '200',
			'value'        => array(
				'type1' => array(
					'image' => RIODE_CORE_URI . 'assets/images/blockquote/type1.jpg',
					'title' => 'Type1',
				),
				'type2' => array(
					'image' => RIODE_CORE_URI . 'assets/images/blockquote/type2.jpg',
					'title' => 'Type2',
				),
				'type3' => array(
					'image' => RIODE_CORE_URI . 'assets/images/blockquote/type3.jpg',
					'title' => 'Type3',
				),
				'type4' => array(
					'image' => RIODE_CORE_URI . 'assets/images/blockquote/type4.jpg',
					'title' => 'Type4',
				),
				'type5' => array(
					'image' => RIODE_CORE_URI . 'assets/images/blockquote/type5.jpg',
					'title' => 'Type5',
				),
			),
			'std'          => 'type1',
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'dark_skin',
			'heading'     => esc_html__( 'Dark Skin', 'riode-core' ),
			'description' => esc_html__( 'Choose whether if use dark skin', 'riode-core' ),
			'value'       => array( esc_html__( 'Yes', 'riode-core' ) => 'yes' ),
			'std'         => '',
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'type5',
			),
		),
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Image', 'riode-core' ),
			'description' => esc_html__( 'Choose a blockquote image', 'riode-core' ),
			'param_name'  => 'image',
			'value'       => '',
			'dependency'  => array(
				'element' => 'type',
				'value'   => array( 'type4', 'type5' ),
			),
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Content', 'riode-core' ),
			'description' => esc_html__( 'Type a blockquote content', 'riode-core' ),
			'param_name'  => 'blockquote',
			'std'         => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna.', 'riode-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Author', 'riode-core' ),
			'description' => esc_html__( 'Type a author name', 'riode-core' ),
			'param_name'  => 'cite',
			'std'         => esc_html__( 'John Doe', 'riode-core' ),
		),
	),
	esc_html__( 'Style', 'riode-core' )   => array(
		array(
			'type'       => 'riode_number',
			'heading'    => esc_html__( 'Icon Size', 'riode-core' ),
			'param_name' => 'icon_size',
			'units'      => array(
				'px',
			),
			'selectors'  => array(
				'{{WRAPPER}} .blockquote-wrapper .blockquote-icon' => 'font-size: {{VALUE}}{{UNIT}};',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Icon Color', 'riode-core' ),
			'param_name' => 'icon_color',
			'selectors'  => array(
				'{{WRAPPER}} .blockquote-wrapper .blockquote-icon' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Content Typorgaphy', 'riode-core' ),
			'param_name' => 'content_typo',
			'selectors'  => array(
				'{{WRAPPER}} .blockquote-wrapper blockquote p',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Content Color', 'riode-core' ),
			'param_name' => 'content_color',
			'selectors'  => array(
				'{{WRAPPER}} .blockquote-wrapper blockquote p' => 'color: {{VALUE}};',
			),
		),
		array(
			'type'       => 'riode_typography',
			'heading'    => esc_html__( 'Author Typorgaphy', 'riode-core' ),
			'param_name' => 'author_typo',
			'selectors'  => array(
				'{{WRAPPER}} .blockquote-wrapper blockquote cite',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Author Color', 'riode-core' ),
			'param_name' => 'author_color',
			'selectors'  => array(
				'{{WRAPPER}} .blockquote-wrapper blockquote cite' => 'color: {{VALUE}};',
			),
		),
	),
);

$params = array_merge( riode_wpb_filter_element_params( $params ), riode_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Blockquote', 'riode-core' ),
		'base'            => 'wpb_riode_blockquote',
		'icon'            => 'riode-logo-icon',
		'class'           => 'riode_blcokquote',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Riode', 'riode-core' ),
		'description'     => esc_html__( 'Riode Blockquote Element.', 'riode-core' ),
		'params'          => $params,
	)
);

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Riode_Blockquote extends WPBakeryShortCode {

	}
}
