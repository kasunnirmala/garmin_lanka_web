<?php
defined( 'ABSPATH' ) || die;

// Elements Group Mapping
$used_mapping = array(
	'component' => array(
		'title'  => esc_html__( 'Theme Resources', 'riode' ),
		'prefix' => array( 'accordion', 'banner', 'btn', 'carousel', 'category', 'countdown', 'hotspot', 'icon-box', 'image-box', 'instagram', 'price-slider', 'product-classic', 'product-list', 'tab', 'testimonial', 'title', 'wpbakery', 'elementor', 'gutenberg', 'dokan' ),
	),
	'shortcode' => array(
		'title' => esc_html__( 'WPBakery Shortcodes', 'riode' ),
	),
);

// Initialize grouped array.
foreach ( $used_mapping as $group => $data ) {
	$used_by_group[ $group ] = array();
}

foreach ( $riode_used_elements as $element => $used ) {
	$find = false;
	foreach ( $used_mapping as $group => $data ) {
		if ( isset( $data['prefix'] ) ) {
			foreach ( $data['prefix'] as $prefix ) {
				if ( substr( $element, 0, strlen( $prefix ) ) == $prefix ) {
					$used_by_group[ $group ][] = $element;
					$find                      = true;
					break;
				}
			}
		}
		if ( $find ) {
			break;
		}
	}
}

$used_by_group['shortcode'] = $this->get_all_shortcodes();


foreach ( $used_by_group as $group => $elements ) {
	ksort( $used_by_group[ $group ] );
}

foreach ( $used_by_group as $group => $elements ) {
	// WPB Shortcodes
	if ( 'shortcode' == $group && defined( 'WPB_VC_VERSION' ) ) {
		?>
	<div class="riode-card <?php echo esc_attr( $group ); ?>">
		<div class="riode-card-header">
			<h3><?php echo esc_html( $used_mapping[ $group ]['title'] ); ?></h3>
			<label class="checkbox checkbox-inline checkbox-toggle">
			<?php esc_html_e( 'Toggle All', 'riode' ); ?>
				<span type="checkbox" class="toggle"></span>
			</label>
		</div>
		<div class="riode-card-list">
			<?php
			foreach ( $elements as $element ) {
				?>
				<label class="checkbox checkbox-inline">
					<input type="checkbox" name="used_shortcode[<?php echo esc_attr( $element ); ?>]" 
						<?php
						disabled( in_array( $element, $used_shortcodes ) );
						checked( in_array( $element, $checked_shortcodes ) );
						?>
					class="element">
						<?php echo esc_html( $element ); ?>
				</label>
				<?php
			}
			?>
		</div>
	</div>	
		<?php
	} else {
		?>
	<div class="riode-card <?php echo esc_attr( $group ); ?>">
		<div class="riode-card-header">
			<h3><?php echo esc_html( $used_mapping[ $group ]['title'] ); ?></h3>
			<label class="checkbox checkbox-inline checkbox-toggle">
			<?php esc_html_e( 'Toggle All', 'riode' ); ?>
				<span type="checkbox" class="toggle"></span>
			</label>
		</div>
		<div class="riode-card-list">
			<?php
			foreach ( $elements as $element ) {
				if ( 'helper' != $group || ! in_array( $element, $helper_classes ) ) {
					?>
					<label class="checkbox checkbox-inline">
						<input type="checkbox" name="used[<?php echo esc_attr( $element ); ?>]" 
							<?php
							disabled( true === $riode_used_elements[ $element ] );
							checked( $riode_used_elements[ $element ] );
							?>
						class="element">
							<?php echo esc_html( $element ); ?>
					</label>
					<?php
				}
			}
			?>
		</div>
	</div>
		<?php
	}
}

if ( ! $first ) {
	echo '</div></div>';
}
