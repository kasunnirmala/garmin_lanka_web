<?php
/**
 * Riode WooCommerce Archive Product Functions
 *
 * Functions used to display archive product.
 */

defined( 'ABSPATH' ) || die;

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_filter( 'loop_shop_per_page', 'riode_loop_shop_per_page' );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 4 );
add_filter( 'woocommerce_widget_get_current_page_url', 'riode_woo_widget_get_current_page_url' );
add_filter( 'wcfmmp_store_ppp', 'riode_wcfmmp_store_ppp', 99 );

// No Products Found
remove_action( 'woocommerce_no_products_found', 'wc_no_products_found', 10 );
add_action( 'woocommerce_no_products_found', 'woocommerce_product_loop_start', 10, 0 );
add_action( 'woocommerce_no_products_found', 'wc_no_products_found', 20 );
add_action( 'woocommerce_no_products_found', 'woocommerce_product_loop_end', 30, 0 );

/**
 * Riode Store page products count
 */
if ( ! function_exists( 'riode_wcfmmp_store_ppp' ) ) {
	function riode_wcfmmp_store_ppp( $count = 10 ) {
		if ( ! empty( $_GET['count'] ) ) {
			return (int) $_GET['count'];
		}
		return $count;
	}
}

/**
 * Riode shop page products count
 */
if ( ! function_exists( 'riode_loop_shop_per_page' ) ) {
	function riode_loop_shop_per_page( $shownums = '' ) {
		if ( ! empty( $_GET['count'] ) ) {
			return (int) $_GET['count'];
		}

		if ( ! is_array( $shownums ) ) {
			global $wp_query;
			$query = $wp_query->query;

			$shownums = '';

			if ( isset( $query['product_cat'] ) ) {
				$term = get_term_by( 'slug', $query['product_cat'], 'product_cat' );
			} elseif ( isset( $query['product_tag'] ) ) {
				$term = get_term_by( 'slug', $query['product_tag'], 'product_tag' );
			}

			if ( isset( $term ) && $term ) {
				$meta = json_decode( get_term_meta( $term->term_id, 'riode_post_layout', true ), true );

				if ( $meta && isset( $meta['content'] ) && isset( $meta['content']['meta_option'] ) && 'custom' == $meta['content']['meta_option'] && isset( $meta['content']['shop_shownums'] ) ) {
					$shownums = $meta['content']['shop_shownums'];
				}
			}

			if ( ! $shownums ) {
				$shownums = riode_get_option( 'shop_shownums' );
			}

			if ( $shownums ) {
				$shownums = explode( ',', str_replace( ' ', '', $shownums ) );
			} else {
				$shownums = array( '9', '_12', '24', '36' );
			}
		}

		$default = $shownums[0];

		foreach ( $shownums as $num ) {
			if ( is_string( $num ) && '_' === $num[0] ) {
				$default = (int) str_replace( '_', '', $num );
				break;
			}
		}

		return $default;
	}
}

/**
 * Riode shop page - select form for products count
 */
if ( ! function_exists( 'riode_wc_count_per_page' ) ) {
	function riode_wc_count_per_page() {
		$ts = is_active_sidebar( riode_get_layout_value( 'top_sidebar', 'id' ) );
		?>
		<div class="toolbox-item toolbox-show-count select-box">
			<label><?php esc_html_e( 'Show :', 'riode' ); ?></label>
			<select name="count" class="count form-control">
				<?php
				$shownums = riode_get_option( 'shop_shownums' ) ? explode( ',', str_replace( ' ', '', riode_get_option( 'shop_shownums' ) ) ) : array( '9', '_12', '24', '36' );

				$current = riode_loop_shop_per_page( $shownums );

				if ( false === riode_get_layout_value( 'slug' ) || 'product_archive_layout' != riode_get_layout_value( 'slug' ) ) {
					if ( empty( $_GET['count'] ) ) {
						$current = 0;
						echo '<option value="0" selected="">Default</option>';
					} else {
						echo '<option value="0">Default</option>';
					}
				}
				foreach ( $shownums as $count ) {
					$num = (int) str_replace( '_', '', $count );
					echo '<option value="' . $num . '" ' . selected( $num == $current, true, false ) . '>' . $num . '</option>';
				}
				?>
			</select>
			<?php
			$except = array( 'count' );
			// Keep query string vars intact
			foreach ( $_GET as $key => $val ) {
				if ( in_array( $key, $except ) ) {
					continue;
				}

				if ( is_array( $val ) ) {
					foreach ( $val as $inner_val ) {
						echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $inner_val ) . '" />';
					}
				} else {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
				}
			}
			?>
		</div>
		<?php
	}
}

/**
 * Riode shop - page category filter function
 */
if ( ! function_exists( 'riode_wc_print_category_filter' ) ) {
	function riode_wc_print_category_filter() {
		// Find active category
		$active_category_id = '';
		$terms              = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
			)
		);
		$is_request         = isset( $_REQUEST['source_tax'] ) && 'product_cat' == $_REQUEST['source_tax'] && isset( $_REQUEST['product_cat'] );

		foreach ( $terms as $term ) {
			if ( $term->count && ( is_product_category( $term->term_id ) || ( $is_request && $term->slug == $_REQUEST['product_cat'] ) ) ) {
				$active_category_id = $term->term_id;
				break;
			}
		}

		// Category filter nav
		$filter_html = '<ul class="nav-filters product-filters"><li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="nav-filter' . ( $active_category_id ? '' : ' active' ) . '" data-filter="*">' . esc_html__( 'All', 'riode' ) . '</a></li>';

		foreach ( $terms as $term ) {
			if ( $term->count ) {
				$filter_html .= '<li><a href="' . esc_url( get_term_link( $term, 'product_cat' ) ) . '" class="nav-filter' . ( $active_category_id == $term->term_id ? ' active' : '' ) . '" data-cat="' . (int) $term->term_id . '" data-filter="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</a></li>';
			}
		}

		$filter_html .= '</ul>';

		echo riode_escaped( $filter_html );
	}
}

/**
 * Riode shop page show type
 *
 * @since 1.0.0
 * @version 1.4.3 Updated for show as list type option in shop page.
 */
if ( ! function_exists( 'riode_wc_shop_show_type' ) ) {
	function riode_wc_shop_show_type() {
		$is_list_type = isset( $_REQUEST['showtype'] ) && 'list' == $_REQUEST['showtype'];

		// If default show type is list type.
		if ( riode_get_option( 'show_as_list_type' ) && empty( $_REQUEST['showtype'] ) ) {
			$is_list_type = true;
		}

		$domain  = parse_url( get_site_url() );
		$cur_url = esc_url( $domain['host'] . remove_query_arg( 'showtype' ) );
		?>
		<div class="toolbox-item toolbox-show-type">
			<a href="<?php echo esc_url( riode_add_url_parameters( $cur_url, 'showtype', 'list' ) ); ?>" class="d-icon-mode-list btn-showtype<?php echo boolval( $is_list_type ) ? ' active' : ''; ?>"></a>
			<a href="<?php echo esc_url( riode_add_url_parameters( $cur_url, 'showtype', 'grid' ) ); ?>" class="d-icon-mode-grid btn-showtype<?php echo boolval( $is_list_type ) ? '' : ' active'; ?>"></a>
		</div>
		<?php
		do_action( 'riode_wc_archive_after_toolbox' );
	}
}

if ( ! function_exists( 'riode_woo_widget_get_current_page_url' ) ) {
	/**
	 * Add showtype, count params to current page URL when various filtering works.
	 *
	 * @param string $link
	 * @return string
	 */
	function riode_woo_widget_get_current_page_url( $link ) {
		if ( isset( $_GET['showtype'] ) && 'list' == $_GET['showtype'] ) {
			$link = riode_add_url_parameters( $link, 'showtype', 'list' );
		}

		if ( ! empty( $_GET['count'] ) ) {
			$link = riode_add_url_parameters( $link, 'count', (int) $_GET['count'] );
		}

		return $link;
	}
}
