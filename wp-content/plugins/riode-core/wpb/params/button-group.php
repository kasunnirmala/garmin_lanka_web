<?php
/**
 * Riode WPBakery ButtonGroup Callback
 *
 * adds button-choose control supporting label, icon and image
 * follow below example of riode_button_group control
 * order of options' priority is 'image' > 'color' > 'icon' > 'label'
 *
 * if all type options are omited, it will automatically change to label type
 * and 'title' option will be worked as 'lable' option
 *
 * array(
 *      'type'        => 'riode_button_group',
 *      'heading'     => __( 'Alignment', 'riode-core' ),
 *      'param_name'  => 'button_align',
 *      'value'       => array(
 *          'left' => array(
 *              'title' => esc_html__( 'Left', 'riode-core' ), // tooltip text
 *              'color' => 'var(--rio-primary-color, #27c)',
 *              'icon'  => 'fas fa-align-left',
 *              'label' => esc_html__( 'Left', 'riode-core' ),
 *          ),
 *          'center' => array(
 *              'title' => esc_html__( 'Center', 'riode-core' ), // tooltip text
 *              'color' => 'var(--rio-secondary-color, #d26e4b)',
 *              'icon'  => 'fas fa-align-center',
 *              'label' => esc_html__( 'Center', 'riode-core' ),
 *          ),
 *          'right' => array(
 *              'title' => esc_html__( 'Right', 'riode-core' ), // tooltip text
 *              'color' => 'var(--rio-success-color, #a8c26e)',
 *              'icon'  => 'fas fa-align-right',
 *              'label' => esc_html__( 'Right', 'riode-core' ),
 *          ),
 *          'inline' => array(
 *              'title' => esc_html__( 'Inline', 'riode-core' ), // tooltip text
 *              'color' => '#fff',
 *              'icon'  => 'fas fa-arrows-alt-h',
 *              'label' => esc_html__( 'Inline', 'riode-core' ),
 *          )
 *      ),
 *      'std' => 'left',
 *      'description' => '',
 *      'group'       => 'General',
 *  ),
 *
 * @since 1.1.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function riode_button_group_callback( $settings, $value ) {
	$param_name    = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type          = isset( $settings['type'] ) ? $settings['type'] : '';
	$values        = isset( $settings['value'] ) ? $settings['value'] : array();
	$is_responsive = isset( $settings['responsive'] ) ? $settings['responsive'] : false;
	$button_width  = isset( $settings['button_width'] ) ? $settings['button_width'] : '';

	$class = 'riode-wpb-button-group';
	$attr  = '';

	if ( empty( $values ) ) {
		return;
	}

	if ( is_array( $value ) ) { // if std value does not exist
		$value = array_keys( $values )[0];
	}

	if ( '/' == $value ) {
		$value = '';
	}

	if ( $is_responsive ) {
		$class .= ' riode-responsive-control';
		$attr  .= "data-width='xl'";

		if ( null == json_decode( $value, true ) ) {
			$value = array( 'xl' => $value );
		} else {
			$value = json_decode( $value, true );
		}
	}

	$keys = array_keys( $values[ array_keys( $values )[0] ] );
	if ( in_array( 'image', $keys ) ) {
		$class .= ' image-button';
	} elseif ( in_array( 'color', $keys ) ) {
		$class .= ' color-button';
	} elseif ( in_array( 'icon', $keys ) ) {
		$class .= ' icon-button';
	} elseif ( in_array( 'label', $keys ) ) {
		$class .= ' label-button';
	}

	$class .= ' ' . $value;

	$html  = '';
	$html .= '<div class="' . esc_attr( $class ) . '"' . ( $attr ? ' ' . $attr : '' ) . '>';

	$html .= '<ul class="options-wrapper">';
	foreach ( $values as $key => $options ) {
		$label  = '';
		$style  = '';
		$o_keys = array_keys( $options );

		if ( in_array( 'image', $o_keys ) ) {
			$label = '<img src="' . esc_url( $options['image'] ) . '" />';
		} elseif ( in_array( 'color', $o_keys ) ) {
			$style = 'background-color: ' . esc_attr( $options['color'] );
		} elseif ( in_array( 'icon', $o_keys ) ) {
			$label = '<i class="' . esc_attr( $options['icon'] ) . '"></i>';
		} elseif ( in_array( 'label', $o_keys ) ) {
			$label = esc_html( $options['label'] );
		} else {
			$label = esc_html( $options['title'] );
		}

		if ( $button_width ) {
			$style .= 'width: ' . $button_width . 'px;';
		}

		$html .= '<li attr-value="' . esc_attr( $key ) . '"' . ( ( is_array( $value ) ? $value['xl'] : $value ) == $key ? ' class="active"' : '' ) . ' title="' . esc_attr( $options['title'] ) . '"' . ( $style ? ' style="' . $style . '"' : '' ) . '>' . $label . '</li>';
	}
	$html .= '</ul>';

	if ( $is_responsive ) {
		ob_start();
		?>
		<div class="riode-responsive-dropdown">
			<a class="riode-responsive-toggle" title="Toggle Responsive Option"><i class="vc-composer-icon vc-c-icon-layout_default"></i></a>
			<ul class="riode-responsive-span">
				<li data-width="xl" title=">= 1200px" class="active" data-size="100%"><i class="vc-composer-icon vc-c-icon-layout_default"></i></li>
				<li data-width="lg" title=">= 992px" data-size="1024px"><i class="vc-composer-icon vc-c-icon-layout_landscape-tablets"></i></li>
				<li data-width="md" title=">= 768px" data-size="768px"><i class="vc-composer-icon vc-c-icon-layout_portrait-tablets"></i></li>
				<li data-width="sm" title=">= 576px" data-size="480px"><i class="vc-composer-icon vc-c-icon-layout_landscape-smartphones"></i></li>
				<li data-width="xs" title="< 576px" data-size="320px"><i class="vc-composer-icon vc-c-icon-layout_portrait-smartphones"></i></li>
			</ul>
		</div>
		<?php
		$html .= ob_get_clean();
	}

	$html .= '</div>';
	$html .= '<input type="hidden" name="' . esc_attr( $param_name ) . '" class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $type ) . '_field" value=\'' . ( is_array( $value ) ? json_encode( $value ) : $value ) . '\' />';
	return $html;
}

vc_add_shortcode_param( 'riode_button_group', 'riode_button_group_callback', plugins_url( '../js/riode-button-group.js', __FILE__ ) );
