<?php
/**
 * Riode Product Image Swatch for Frontend
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Riode_Image_Swatch' ) ) {
	class Riode_Image_Swatch {
		public $swatch_options = '';
		public $type           = '';

		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );

			add_filter( 'riode_wc_attribute_display_type', array( $this, 'get_display_type' ), 10, 3 );
			add_action( 'riode_wc_print_listed_type_attributes', array( $this, 'print_attribute_items' ), 10, 5 );
		}

		public function get_display_type( $result, $id, $attr_name ) {
			global $product;

			$this->type           = $result;
			$this->swatch_options = $product->get_meta( 'swatch_options', true );

			if ( 'variable' != $product->get_type() ) {
				return $this->type;
			}

			if ( $this->swatch_options && is_string( $this->swatch_options ) ) {
				$this->swatch_options = json_decode( $this->swatch_options, true );
			}

			if ( 'pa_' != substr( $attr_name, 0, 3 ) ) {
				$attr_name = strtolower( preg_replace( '/\s+/', '_', $attr_name ) );
			}

			if ( isset( $this->swatch_options[ $attr_name ] ) && isset( $this->swatch_options[ $attr_name ]['type'] ) ) {
				$this->type = $this->swatch_options[ $attr_name ]['type'];
			} elseif ( 'pa_' == substr( $attr_name, 0, 3 ) ) {
				$this->type = wc_get_attribute( wc_attribute_taxonomy_id_by_name( $attr_name ) )->type;
			} else {
				$this->type = 'select';
			}

			return $this->type;
		}

		public function enqueue_scripts() {
			// wp_enqueue_script( 'riode-image-swatch', RIODE_ADDON_URI . '/attribute-swatch/swatch.min.js', array( 'riode-theme' ), RIODE_VERSION, true );
		}

		public function print_attribute_items( $name, $options, $product, $type, $custom_attribute ) {
			if ( 'select' == $this->type ) {
				return;
			}

			if ( $custom_attribute ) {
				$name = strtolower( preg_replace( '/\s+/', '_', $name ) );
			}

			if ( $product && taxonomy_exists( $name ) ) {
				$temp_arr = array();

				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms(
					$product->get_id(),
					$name,
					array(
						'fields' => 'slugs',
					)
				);

				foreach ( $terms as $term ) {
					if ( in_array( $term, $options, true ) ) {
						$temp_arr[] = $term;
					}
				}

				$options = $temp_arr;
			}

			foreach ( $options as $item ) {
				$attr_value   = '';
				$swatch_name  = '';
				$swatch_title = '';

				if ( $custom_attribute ) {
					$swatch_title = $item;
					$swatch_name  = $item;
					$item         = strtolower( preg_replace( '/\s+/', '_', $item ) );
				} else {
					$term = get_term_by( 'slug', $item, $name );
					$swatch_title = $term->name;
					$swatch_name  = $term->slug;
					$item         = $term->term_id;
				}

				if ( isset( $this->swatch_options[ $name ] ) && isset( $this->swatch_options[ $name ][ $item ] ) && isset( $this->swatch_options[ $name ][ $item ][ $type ] ) ) {
					$attr_value = $this->swatch_options[ $name ][ $item ][ $type ];
				} elseif ( isset( $term ) ) {
					$attr_value = get_term_meta( $term->term_id, 'attr_' . $type, true );
				}

				if ( 'image' == $type ) {
					$attr_image = '';
					if ( $attr_value ) {
						$attr_image = wp_get_attachment_image_src( $attr_value, array( 32, 32 ) );

						if ( $attr_image ) {
							$attr_image = $attr_image[0];
						}
					}

					if ( ! $attr_image ) {
						$attr_image = wc_placeholder_img_src( array( 32, 32 ) );
					}
				}

				switch ( $type ) {
					case 'label':
						?>
						<button type="button" name="<?php echo esc_attr( $swatch_name ); ?>" title="<?php echo esc_attr( $swatch_title ); ?>"><?php echo sanitize_text_field( $attr_value ); ?></button>
						<?php
						break;
					case 'color':
						?>
						<button type="button" name="<?php echo esc_attr( $swatch_name ); ?>" title="<?php echo esc_attr( $swatch_title ); ?>" class="color" style="background-color: <?php echo sanitize_hex_color( $attr_value ); ?>"></button>
						<?php
						break;
					case 'image':
						if ( riode_get_option( 'lazyload' ) ) :
						?>
							<button type="button" name="<?php echo esc_attr( $swatch_name ); ?>" title="<?php echo esc_attr( $swatch_title ); ?>" class="image d-lazy-back" data-lazy="<?php echo esc_url( $attr_image ); ?>"></button>
						<?php
						else :
						?>
							<button type="button" name="<?php echo esc_attr( $swatch_name ); ?>" title="<?php echo esc_attr( $swatch_title ); ?>" class="image" style="background-image: url(<?php echo esc_url( $attr_image ); ?>);"></button>
						<?php
						endif;
						break;
				}
			}
		}
	}
}

new Riode_Image_Swatch();
