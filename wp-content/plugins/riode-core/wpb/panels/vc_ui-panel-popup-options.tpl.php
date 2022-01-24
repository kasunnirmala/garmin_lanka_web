<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$popup_options = get_post_meta( get_the_ID(), 'popup_options', true );
if ( $popup_options ) {
	$popup_options = json_decode( $popup_options, true );
} else {
	$popup_options = array(
		'width'         => '600',
		'animation'     => '',
		'anim_duration' => 400,
		'transform'     => 't-mc',
		'top'           => '50%',
		'right'         => '',
		'bottom'        => '',
		'left'          => '50%',
		'popup_aclass'  => '',
	);
}
?>

<div class="vc_ui-font-open-sans vc_ui-panel-window vc_media-xs vc_ui-panel vc_ui-riode-panel" data-vc-panel=".vc_ui-panel-header-header" data-vc-ui-element="panel-riode-popup-options" id="vc_ui-panel-riode-popup-options">
	<div class="vc_ui-panel-window-inner">
		<?php
		vc_include_template(
			'editors/popups/vc_ui-header.tpl.php',
			array(
				'title'            => esc_html__( 'Riode Popup Options', 'js_composer' ),
				'controls'         => array( 'minimize', 'close' ),
				'header_css_class' => 'vc_ui-riode-popup-options-header-container',
				'content_template' => '',
			)
		);
		?>
		<div class="vc_ui-panel-content-container">
			<div class="vc_ui-panel-content vc_properties-list vc_edit_form_elements" data-vc-ui-element="panel-content">
				<div class="vc_row">
					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Popup Width', 'riode-core' ); ?></div>
						<div class="edit_form_line">
							<input name="popup_width" class="wpb-textinput" type="number" value="<?php echo esc_attr( $popup_options['width'] ); ?>" id="vc_popup-width-field" placeholder="<?php esc_attr_e( 'Default value is 600px.', 'riode-core' ); ?>">
							<span class="vc_description"><?php echo esc_html__( 'Controls width of popup template.', 'riode-core' ); ?></span>
						</div>
					</div>

					<?php
					global $riode_animations;

					$animations = array( 'none' => esc_html__( 'None', 'riode-core' ) );

					if ( ! empty( $riode_animations ) ) {
						$animations = array_merge( $animations, $riode_animations['sliderIn'], $riode_animations['sliderOut'], $riode_animations['appear']['Riode Fading'], $riode_animations['appear']['Blur'] );
						?>

						<div class="vc_col-xs-12 vc_column">
							<div class="wpb_element_label"><?php esc_html_e( 'Popup Animation', 'riode-core' ); ?></div>
							<div class="edit_form_line">
								<select name="popup_animation" class="wpb-textinput" type="number" id="vc_popup-animation-field">

									<?php foreach ( $animations as $key => $value ) { ?>
										<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key == $popup_options['animation'] ); ?>><?php echo esc_html( $value ); ?></option>
									<?php } ?>

								</select>
								<span class="vc_description"><?php echo esc_html__( 'Select an appear animation of popup template.', 'riode-core' ); ?></span>
							</div>
						</div>

						<?php
					}
					?>

					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Animation Duration (ms)', 'riode-core' ); ?></div>
						<div class="edit_form_line">
							<input name="popup_anim_duration" class="wpb-textinput" type="number" value="<?php echo esc_attr( $popup_options['anim_duration'] ); ?>" id="vc_popup-anim-duration-field">
							<span class="vc_description"><?php echo esc_html__( 'Controls duration time of appear animation.', 'riode-core' ); ?></span>
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label" style="font-weight: 400; max-width: 400px;"><?php echo sprintf( esc_html__( 'Please add two classes - "show-popup popup-id-ID" to any elements you want to show this popup on click. %1$se.g) show-popup popup-id-725%2$s', 'riode-core' ), '<b>', '</b>' ); ?></div>
					</div>

					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'Basis Point', 'riode-core' ); ?></div>
						<div class="edit_form_line">
							<select name="popup_transform" class="wpb-textinput" type="number" id="vc_popup-transform-field">
								<option value="t-none" <?php selected( 't-none' == $popup_options['transform'] ); ?>><?php esc_html_e( 'Left Top', 'riode-core' ); ?></option>
								<option value="t-m" <?php selected( 't-m' == $popup_options['transform'] ); ?>><?php esc_html_e( 'Left Center', 'riode-core' ); ?></option>
								<option value="t-c" <?php selected( 't-c' == $popup_options['transform'] ); ?>><?php esc_html_e( 'Center Top', 'riode-core' ); ?></option>
								<option value="t-mc" <?php selected( 't-mc' == $popup_options['transform'] ); ?>><?php esc_html_e( 'Center Center', 'riode-core' ); ?></option>
							</select>
							<span class="vc_description"><?php echo esc_html__( 'Controls basis point of popup template.', 'riode-core' ); ?></span>
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column wpb_edit_form_elements wpb_el_type_riode_dimension">
						<div class="wpb_element_label"><?php esc_html_e( 'Popup Position', 'riode-core' ); ?></div>
						<div class="edit_form_line">
							<div class="riode-wpb-dimension-container">
								<div class="riode-wpb-dimension-wrap top">
									<input type="text" class="wpb-textinput riode-wpb-dimension" name="popup_position_top" value="<?php echo esc_attr( $popup_options['top'] ); ?>" id="vc_popup-position-top-field">
									<label><?php esc_html_e( 'Top', 'riode-core' ); ?></label>
								</div>
								<div class="riode-wpb-dimension-wrap right">
									<input type="text" class="wpb-textinput riode-wpb-dimension" name="popup_position_right" value="<?php echo esc_attr( $popup_options['right'] ); ?>" id="vc_popup-position-right-field">
									<label><?php esc_html_e( 'Right', 'riode-core' ); ?></label>
								</div>
								<div class="riode-wpb-dimension-wrap bottom">
									<input type="text" class="wpb-textinput riode-wpb-dimension" name="popup_position_bottom" value="<?php echo esc_attr( $popup_options['bottom'] ); ?>" id="vc_popup-position-bottom-field">
									<label><?php esc_html_e( 'Bottom', 'riode-core' ); ?></label>
								</div>
								<div class="riode-wpb-dimension-wrap left">
									<input type="text" class="wpb-textinput riode-wpb-dimension" name="popup_position_left" value="<?php echo esc_attr( $popup_options['left'] ); ?>" id="vc_popup-position-left-field">
									<label><?php esc_html_e( 'Left', 'riode-core' ); ?></label>
								</div>
							</div>
						</div>
					</div>

					<div class="vc_col-xs-12 vc_column">
						<div class="wpb_element_label"><?php esc_html_e( 'CSS Classes', 'riode-core' ); ?></div>
						<div class="edit_form_line">
							<input name="popup_aclass" class="wpb-textinput" type="text" value="<?php echo esc_attr( empty( $popup_options['popup_aclass'] ) ? '' : $popup_options['popup_aclass'] ); ?>" id="vc_popup-aclass-field">
							<span class="vc_description" style="padding-bottom: 20px;"><?php echo esc_html__( 'Add your custom classes without dot.', 'riode-core' ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- param window footer-->
		<?php
		vc_include_template(
			'editors/popups/vc_ui-footer.tpl.php',
			array(
				'controls' => array(
					array(
						'name'        => 'save',
						'label'       => esc_html__( 'Save changes', 'js_composer' ),
						'css_classes' => 'vc_ui-button-fw',
						'style'       => 'action',
					),
				),
			)
		);
		?>
	</div>
</div>
