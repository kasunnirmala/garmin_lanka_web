<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Image_Choose Control
 *
 * @since 1.0
 */

use Elementor\Base_Data_Control;

class Riode_Control_Image_Choose extends Base_Data_Control {
	public function get_type() {
		return 'riode_image_choose';
	}

	public function content_template() {
		$control_uid = $this->get_control_uid( '{{value}}' );
		?>
		<div class="elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<div class="elementor-choices">
					<# _.each( data.options, function( options, value ) { #>
					<input id="<?php echo $control_uid; ?>" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ value }}" data-setting="{{ data.name }}">
					<label class="elementor-choices-label width-{{{data.width}}}" for="<?php echo $control_uid; ?>">
						<img src="{{{ options }}}">
						<span class="elementor-screen-only">{{{ options }}}</span>
					</label>
					<# } ); #>
				</div>
			</div>
		</div>

		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	protected function get_default_settings() {
		return [
			'options' => [],
			'toggle'  => true,
			'width'   => 'default',
		];
	}
}
