<?php

/**
 * Product Compare
 */
if ( ! class_exists( 'Riode_Product_Compare' ) ) :
	class Riode_Product_Compare {

		public static $instance = null;

		public $products     = array();
		public $compare_page = array();

		/**
		 * Get Singleton Instance
		 */
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			$this->products = $this->get_compared_products();

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );

			// Create default compare page
			$this->compare_page = array(
				'name'    => _x( 'compare', 'Page slug', 'riode' ),
				'title'   => _x( 'Compare', 'Page title', 'riode' ),
				'content' => '<!-- wp:shortcode -->[' . apply_filters( 'riode_woocompare_shortcode_tag', 'riode_product_compare_page' ) . ']<!-- /wp:shortcode -->',
			);

			add_filter( 'woocommerce_create_pages', array( $this, 'add_default_compare_page' ) );
			add_action( 'init', array( $this, 'force_add_default_compare_page' ) );

			// Add product to compare
			add_action( 'wp_ajax_riode_add_to_compare', array( $this, 'add_to_compare' ) );
			add_action( 'wp_ajax_nopriv_riode_add_to_compare', array( $this, 'add_to_compare' ) );

			// Remove product from compare
			add_action( 'wp_ajax_riode_remove_from_compare', array( $this, 'remove_from_compare' ) );
			add_action( 'wp_ajax_nopriv_riode_remove_from_compare', array( $this, 'remove_from_compare' ) );
		}

		public function enqueue_scripts() {
			wp_enqueue_script( 'riode-product-compare', RIODE_ADDON_URI . '/product-compare/compare' . riode_get_js_extension(), array( 'riode-theme' ), RIODE_VERSION, true );
		}

		public function add_default_compare_page( $pages ) {
			$pages['compare'] = $this->compare_page;
			return $pages;
		}

		public function force_add_default_compare_page() {
			if ( class_exists( 'WooCommerce' ) && ! empty( get_option( 'woocommerce_db_version' ) ) && ( -1 == wc_get_page_id( 'compare' ) || 'publish' != get_post_status( wc_get_page_id( 'compare' ) ) ) ) {
				include_once WC()->plugin_path() . '/includes/admin/wc-admin-functions.php';
				wc_create_page( esc_sql( $this->compare_page['name'] ), 'woocommerce_compare_page_id', $this->compare_page['title'], $this->compare_page['content'], ! empty( $this->compare_page['parent'] ) ? wc_get_page_id( $this->compare_page['parent'] ) : '' );
			}
		}

		public function _compare_cookie_name() {
			$name = 'riode_compare_list';

			if ( is_multisite() ) {
				$name .= '_' . get_current_blog_id();
			}

			return $name;
		}

		public function is_compared_product( $prod_id ) {
			return in_array( $prod_id, $this->products );
		}

		public function get_compared_products() {
			$cookie_name = $this->_compare_cookie_name();
			return isset( $_COOKIE[ $cookie_name ] ) ? json_decode( wp_unslash( $_COOKIE[ $cookie_name ] ), true ) : array();
		}

		public function _set_compared_products( $prod_id, $action = 'add', $src = 0, $dst = 0 ) {
			$cookie_name = $this->_compare_cookie_name();
			$prods       = $this->products;

			if ( 'add' == $action ) {
				$prods[] = $prod_id;
			} elseif ( 'remove' == $action ) {
				$idx = array_search( $prod_id, $prods );
				if ( false !== $idx ) {
					array_splice( $prods, $idx, 1 );
				}
			}

			$this->products = $prods;

			if ( empty( $prods ) ) {
				setcookie( $cookie_name, false, 0, COOKIEPATH, COOKIE_DOMAIN, false, false );
				$_COOKIE[ $cookie_name ] = false;
			} else {
				setcookie( $cookie_name, json_encode( $prods ), 0, COOKIEPATH, COOKIE_DOMAIN, false, false );
				$_COOKIE[ $cookie_name ] = json_encode( $prods );
			}
		}

		public function add_to_compare() {
			$id = (int) sanitize_text_field( $_POST['id'] );

			if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
				global $sitepress;
				$id = wpml_object_id_filter( $id, 'product', true, $sitepress->get_default_language() );
			}

			if ( ! $this->is_compared_product( $id ) ) {
				$this->_set_compared_products( $id );
			}

			$args  = array(
				'url'      => get_permalink( wc_get_page_id( 'compare' ) ),
				'template' => $this->get_compare_popup_template(),
				'compare_text'   => esc_html__( 'Remove', 'riode' ),
			);

			ob_start();
			riode_get_template_part( RIODE_PART . '/header/elements/element-compare', null, array( 'minicompare' => $_POST['minicompare'] ) );
			$args['minicompare'] = ob_get_clean();

			wp_send_json( $args );
		}

		public function remove_from_compare() {
			$id = (int) sanitize_text_field( $_POST['id'] );

			if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
				global $sitepress;
				$id = wpml_object_id_filter( $id, 'product', true, $sitepress->get_default_language() );
			}

			if ( $this->is_compared_product( $id ) ) {
				$this->_set_compared_products( $id, 'remove' );
			}

			ob_start();
			$this->print_empty_compare_table();

			$args = array(
				'empty_template' => ob_get_clean(),
				'compare_text'   => esc_html__( 'Compare', 'riode' ),
			);

			wp_send_json($args);
		}

		public function get_compare_popup_template() {
			ob_start();

			if ( ! empty( $this->products ) ) {
				$product_id = $this->products[ count( $this->products ) - 1 ];
				$cur_product = wc_get_product( $product_id );
				?>

				<div class="minipopup-box">
					<h4 class="minipopup-title"><?php echo esc_html__( 'Added To Compare List', 'riode' ); ?></h4>
					<div class="product product-list-sm">
						<figure class="product-media">
							<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
							<?php echo riode_strip_script_tags( $cur_product->get_image( 'woocommerce_thumbnail' ) ); ?>
							</a>
						</figure>
						<div class="product-details">
							<a class="product-title" href="<?php echo esc_url( get_permalink( $product_id ) ); ?>"><?php echo esc_html( $cur_product->get_title() ); ?></a>
							<span class="price"><?php echo riode_strip_script_tags( $cur_product->get_price_html() ); ?></span>
						</div>
					</div>
					<div class="minipopup-footer">
						<?php
						global $product;
						$org_product = $product;
						$product = $cur_product;
						woocommerce_template_loop_add_to_cart(
							array(
								'class' => implode(
									' ',
									array(
										'btn btn-block btn-outline btn-primary btn-viewcart',
										$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
										$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
								)
								),
							)
						);

						$product = $org_product;
						?>
						<a href="<?php echo get_permalink( wc_get_page_id( 'compare' ) ); ?>" class="btn btn-block btn-primary btn-comparelist"><?php echo esc_html__( 'Compare List', 'riode' ); ?></a>
					</div>
				</div>

				<?php
			}
			return ob_get_clean();
		}

		// Compare Page
		public function print_compare_table() {
			$products = $this->get_compared_products_data();
			$fields   = $this->compare_product_fields();

			if ( ! empty( $products ) ) {
				?>
				<div class="riode-compare-table product-loop">
				<?php
				foreach ( $fields as $field_id => $field ) {
					if ( ! $this->is_field_avaliable( $field_id, $products ) ) {
						continue;
					}
					$tb_head = true;
					?>
					<div class="compare-row compare-<?php echo esc_attr( $field_id ); ?>">
					<?php
					foreach ( $products as $product_id => $product ) :
						if ( $tb_head ) :
							?>
							<div class="compare-col compare-field">
								<?php echo ! $field ? esc_html__( 'Product', 'riode' ) : $field; ?>
							</div>
							<?php
							$tb_head = false;
						endif;

						if ( ! empty( $product ) ) :
							?>
							<div class="compare-col compare-value" data-title="<?php echo esc_attr( $field ); ?>">
								<?php $this->compare_display_field( $field_id, $product ); ?>
							</div>
							<?php
						endif;
					endforeach;
					?>

					</div>
					<?php
				}
				?>
				</div>
				<?php
			} else {
				$this->print_empty_compare_table();
			}
		}

		// Empty Compare Page
		public function print_empty_compare_table() {
			?>

			<div class="riode-compare-table empty">
				<i class="d-icon-compare empty-icon"></i>
				<h2><?php echo apply_filters( 'riode_compare_no_product_to_remove_message', esc_html__( 'No products added to the compare', 'riode' ) ); ?></h2>
				<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
					<?php esc_html_e( 'GO SHOP', 'riode' ); ?>
				</a>
			</div>

			<?php
		}

		public function get_compared_products_data() {
			$ids = $this->products;

			if ( empty( $ids ) ) {
				return array();
			}

			$args = array(
				'include' => $ids,
				'orderby' => 'post__in',
			);

			$products = wc_get_products( $args );

			$result = array();

			$fields = $this->compare_product_fields( false );

			$none = '-';

			foreach ( $products as $product ) {
				$product_id         = $product->get_id();
				$product_title      = $product->get_title();
				$product_img        = $product->get_image();
				$add_to_cart        = $this->compare_add_to_cart_html( $product );
				$add_to_wishlist    = do_shortcode( '[yith_wcwl_add_to_wishlist product_id="' . $product_id . '" container_classes="btn-product-icon"]' );
				$remove_html        = '<a href="#" class="remove_from_compare btn-product-icon" data-product_id="' . $product_id . '"><i class="d-icon-times"></i></a>';
				$product_price_html = $product->get_price_html();
				$type               = $product->get_type() . ' product';
				$stock_html         = wc_get_stock_html( $product );
				$product_excerpt    = $product->get_short_description();
				$product_weight     = $product->get_weight();
				$product_sku        = $product->get_sku();
				$rating_count       = $product->get_rating_count();
				$average            = $product->get_average_rating();

				$result[ $product_id ] = array(
					'basic'        => array(
						'image'       => $product_img ? $product_img : $none,
						'add_to_cart' => $add_to_cart ? $add_to_cart : $none,
						'add_to_wish' => $add_to_wishlist ? $add_to_wishlist : $none,
						'remove'      => $remove_html ? $remove_html : $none,
						'permalink'   => $product->get_permalink(),
					),
					'id'           => $product_id,
					'title'        => $product_title ? $product_title : $none,
					'price'        => $product_price_html ? $product_price_html : $none,
					'type'         => $type ? $type : $none,
					'availability' => $stock_html ? $stock_html : esc_html__( 'In stock', 'riode' ),
					'description'  => $product_excerpt ? $product_excerpt : $none,
					'rating'       => wc_get_rating_html( $average, $rating_count ) . riode_get_rating_link_html( $product ),
					'dimensions'   => wc_format_dimensions( $product->get_dimensions( false ) ),
					'weight'       => $product_weight ? $product_weight : $none,
					'sku'          => $product_sku ? $product_sku : $none,
				);

				foreach ( $fields as $field_id => $field_name ) {
					if ( taxonomy_exists( $field_id ) ) {
						$separator                          = ', ';
						$result[ $product_id ][ $field_id ] = array();
						$orderby                            = wc_attribute_orderby( $field_id ) ? wc_attribute_orderby( $field_id ) : 'name';
						$terms                              = wp_get_post_terms(
							$product_id,
							$field_id,
							array(
								'orderby' => $orderby,
							)
						);
						if ( ! empty( $terms ) ) {
							foreach ( $terms as $term ) {
								$term_id = wc_attribute_taxonomy_id_by_name( $term->taxonomy );
								$type    = wc_get_attribute( $term_id )->type;
								$term    = sanitize_term( $term, $field_id );
								$color   = sanitize_hex_color( get_term_meta( $term->term_id, 'attr_color', true ) );
								$label   = sanitize_text_field( get_term_meta( $term->term_id, 'attr_label', true ) );

								if ( 'list' == $type && ( $color || $label ) ) {
									$separator                            = '';
									$result[ $product_id ][ $field_id ][] = sprintf(
										'<span %s title="%s">%s</span>',
										apply_filters(
											'riode_wc_product_listed_attribute_attr',
											' class="swatch' . ( $color ? ' color" style="background-color:' . esc_attr( $color ) . '"' : '"' ),
											$term->taxonomy,
											$term_id
										),
										$term->name,
										!$color && $label ? $label : ''
									);
								} else {
									$result[ $product_id ][ $field_id ][] = $term->name;
								}
							}
						} else {
							$result[ $product_id ][ $field_id ][] = '-';
						}
						$result[ $product_id ][ $field_id ] = implode( $separator, $result[ $product_id ][ $field_id ] );
					}
				}
			}

			return $result;
		}

		public function compare_product_fields( $global = true ) {
			$fields = array();

			if ( $global ) {
				$fields = array(
					'basic'        => '',
					'title'        => array(
						'name'  => esc_html__( 'Title', 'riode' ),
						'value' => 'title',
					),
					'price'        => array(
						'name'  => esc_html__( 'Price', 'riode' ),
						'value' => 'price',
					),
					'type'        => array(
						'name'  => esc_html__( 'Type', 'riode' ),
						'value' => 'type',
					),
					'availability' => array(
						'name'  => esc_html__( 'Availability', 'riode' ),
						'value' => 'availability',
					),
					'description'  => array(
						'name'  => esc_html__( 'Description', 'riode' ),
						'value' => 'description',
					),
					'rating'       => array(
						'name'  => esc_html__( 'Ratings & Reviews', 'riode' ),
						'value' => 'rating',
					),
					'dimensions'   => array(
						'name'  => esc_html__( 'Dimensions', 'riode' ),
						'value' => 'dimensions',
					),
					'weight'       => array(
						'name'  => esc_html__( 'Weight', 'riode' ),
						'value' => 'weight',
					),
					'sku'          => array(
						'name'  => esc_html__( 'Sku', 'riode' ),
						'value' => 'sku',
					),
				);
			}

			$product_attributes = wc_get_attribute_taxonomies();

			if ( count( $product_attributes ) > 0 ) {
				foreach ( $product_attributes as $attribute ) {
					$fields[ 'pa_' . $attribute->attribute_name ] = array(
						'name'  => wc_attribute_label( $attribute->attribute_label ),
						'value' => 'pa_' . $attribute->attribute_name,
					);
				}
			}

			if ( $global ) {
				foreach ( $fields as $name => $value ) {
					if ( isset( $fields[ $name ]['name'] ) ) {
						$fields[ $name ] = $fields[ $name ]['name'];
					}
				}
			}
			return $fields;
		}

		public function is_field_avaliable( $field, $products ) {
			foreach ( $products as $product_id => $product ) {
				if ( isset( $product[ $field ] ) && ( ! empty( $product[ $field ] ) && '-' !== $product[ $field ] && 'N/A' !== $product[ $field ] ) ) {
					return true;
				}
			}
			return false;
		}

		public function compare_display_field( $field_id, $product ) {

			$type = $field_id;

			if ( 'pa_' === substr( $field_id, 0, 3 ) ) {
				$type = 'attribute';
			}

			switch ( $type ) {
				case 'basic':
					echo '<div class="compare-basic-info">';
						echo '<figure class="product-media"><a href="' . esc_url( get_permalink( $product['id'] ) ) . '">' . $product['basic']['image'] . '</a></figure>';
						echo '<div class="product-action">';
							echo '<a class="to-left" href="#" title="' . esc_html__( 'To Left', 'riode' ) . '" data-product_id="' . $product['id'] . '"><i class="d-icon-angle-left"></i></a>';
							echo riode_strip_script_tags( $product['basic']['add_to_cart'] );
							echo riode_strip_script_tags( $product['basic']['add_to_wish'] );
							echo riode_strip_script_tags( $product['basic']['remove'] );
							echo '<a class="to-right" href="#" title="' . esc_html__( 'To Right', 'riode' ) . '" data-product_id="' . $product['id'] . '"><i class="d-icon-angle-right"></i></a>';
						echo '</div>';
					echo '</div>';
					break;

				case 'title' :
					echo '<a class="product-title" href="' . esc_url( get_permalink( $product['id'] ) ) . '">' . $product['title'] . '</a>';
					break;

				case 'weight':
					if ( $product[ $field_id ] ) {
						$unit = '-' !== $product[ $field_id ] ? get_option( 'woocommerce_weight_unit' ) : '';
						echo wc_format_localized_decimal( $product[ $field_id ] ) . ' ' . esc_attr( $unit );
					}
					break;

				case 'description':
					echo apply_filters( 'woocommerce_short_description', $product[ $field_id ] );
					break;

				default:
					echo riode_strip_script_tags( $product[ $field_id ] );
					break;
			}
		}

		public function compare_add_to_cart_html( $product ) {
			if ( ! $product ) {
				return;
			}

			$defaults = array(
				'quantity'   => 1,
				'class'      => implode(
					' ',
					array_filter(
						array(
							'btn-product-icon',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
						)
					)
				),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', $defaults, $product );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = strip_tags( $args['attributes']['aria-label'] );
			}

			return apply_filters(
				'woocommerce_loop_add_to_cart_link',
				sprintf(
					'<a href="%s" data-quantity="%s" class="%s add-to-cart-loop" %s><span>%s</span></a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
					esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
					isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
					esc_html( $product->add_to_cart_text() )
				),
				$product,
				$args
			);
		}
	}
	Riode_Product_Compare::get_instance();

	// Add shortcode
	add_shortcode( 'riode_product_compare_page', array( Riode_Product_Compare::get_instance(), 'print_compare_table' ) );
endif;
