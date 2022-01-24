<?php
/**
 * Riode WPBakery Number Callback
 *
 * follow below example of riode_number control
 *
 * array(
 *      'type'        => 'riode_number',
 *      'heading'     => __( 'Icon Spacing', 'riode-core' ),
 *      'param_name'  => 'icon_space',
 *      'responsive'  => false,
 *
 *      ================================
 *      'units'       => array(
 *          'px',
 *          'rem',
 *          'em',
 *          '%',
 *      ),
 *      ============= OR ===============
 *      'with_units'  => true / false, // Check values including valid CSS unit.
 *      ================================
 *
 *      'dependency'  => array(
 *          'element' => 'show_icon',
 *          'not_empty'   => true,
 *      ),
 *      'selectors'   => array(
 *          '{{WRAPPER}}.btn' => 'font-size: {{VALUE}}{{UNIT}};',
 *      ),
 *      'group'       => 'Icon',
 * ),
 *
 * @since 1.1.0
 *
 * @param object $settings
 * @param string $value
 *
 * @return string
 */
function riode_number_callback( $settings, $value ) {
	$param_name    = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type          = isset( $settings['type'] ) ? $settings['type'] : '';
	$is_responsive = isset( $settings['responsive'] ) ? $settings['responsive'] : false;
	$units         = isset( $settings['units'] ) ? $settings['units'] : array();
	$with_unit     = isset( $settings['with_units'] ) ? $settings['with_units'] : false;
	$class         = 'riode-wpb-number-container';

	if ( $is_responsive ) {
		$class .= ' riode-responsive-control';
	}

	$responsive_value = json_decode( $value, true );
	$saved_unit       = ! empty( $responsive_value['unit'] ) ? $responsive_value['unit'] : '';
	$html             = '<div class="' . esc_attr( $class ) . '">';

	if ( ! empty( $units ) ) {
		ob_start();
		?>
		<input type="number"
			class="riode-wpb-number"
			value="<?php echo esc_attr( $responsive_value['xl'] ); ?>"
			data-xl="<?php echo ( isset( $responsive_value['xl'] ) ? esc_attr( $responsive_value['xl'] ) : '' ); ?>"
			data-lg="<?php echo ( isset( $responsive_value['lg'] ) ? esc_attr( $responsive_value['lg'] ) : '' ); ?>"
			data-md="<?php echo ( isset( $responsive_value['md'] ) ? esc_attr( $responsive_value['md'] ) : '' ); ?>"
			data-sm="<?php echo ( isset( $responsive_value['sm'] ) ? esc_attr( $responsive_value['sm'] ) : '' ); ?>"
			data-xs="<?php echo ( isset( $responsive_value['xs'] ) ? esc_attr( $responsive_value['xs'] ) : '' ); ?>"
			data-unit="<?php echo ( isset( $responsive_value['unit'] ) ? esc_attr( $responsive_value['unit'] ) : '' ); ?>"
			/>
		<select class="riode-wpb-units">
			<?php foreach ( $units as $unit ) { ?>
				<option value="<?php echo esc_attr( $unit ); ?>" <?php echo esc_attr( $unit == $saved_unit ? 'selected' : '' ); ?>><?php echo esc_html( $unit ); ?></option>
			<?php } ?>
		</select>
		<?php
		$html .= ob_get_clean();
	} else {
		ob_start();
		if ( $is_responsive ) {
			?>
		<input type="<?php echo esc_attr( $with_unit ? 'text' : 'number' ); ?>"
			class="riode-wpb-number"
			value="<?php echo esc_attr( $responsive_value['xl'] ); ?>"
			data-xl="<?php echo ( isset( $responsive_value['xl'] ) ? esc_attr( $responsive_value['xl'] ) : '' ); ?>"
			data-lg="<?php echo ( isset( $responsive_value['lg'] ) ? esc_attr( $responsive_value['lg'] ) : '' ); ?>"
			data-md="<?php echo ( isset( $responsive_value['md'] ) ? esc_attr( $responsive_value['md'] ) : '' ); ?>"
			data-sm="<?php echo ( isset( $responsive_value['sm'] ) ? esc_attr( $responsive_value['sm'] ) : '' ); ?>"
			data-xs="<?php echo ( isset( $responsive_value['xs'] ) ? esc_attr( $responsive_value['xs'] ) : '' ); ?>"
			data-unit="<?php echo ( isset( $responsive_value['unit'] ) ? esc_attr( $responsive_value['unit'] ) : '' ); ?>"
			/>
			<?php
		} else {
			?>
			<input type="<?php echo esc_attr( $with_unit ? 'text' : 'number' ); ?>"
			class="riode-wpb-number simple-value"
			value="<?php echo esc_attr( $value ); ?>"
			/>
			<?php
		}
		$html .= ob_get_clean();
	}

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
	$html .= '<input type="hidden" name="' . esc_attr( $param_name ) . '" class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $type ) . '_field" value="' . esc_attr( $value ) . '" ' . ' />';
	return $html;
}

vc_add_shortcode_param( 'riode_number', 'riode_number_callback', plugins_url( '../js/riode-number.js', __FILE__ ) );
