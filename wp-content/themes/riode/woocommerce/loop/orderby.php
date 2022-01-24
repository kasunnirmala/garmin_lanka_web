<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ( 'product_archive_layout' != riode_get_layout_value( 'slug' ) ) && ! apply_filters( 'riode_is_vendor_store', false ) ) {
	return;
}

$ts = is_active_sidebar( riode_get_layout_value( 'top_sidebar', 'id' ) );
if ( $ts ) {
	$ts = riode_get_layout_value( 'top_sidebar', 'type' );
}
$ls                = is_active_sidebar( riode_get_layout_value( 'left_sidebar', 'id' ) );
$rs                = is_active_sidebar( riode_get_layout_value( 'right_sidebar', 'id' ) );
$top_toolbox_items = riode_get_option( 'shop_top_toolbox_items' );

if ( $ts ) {
	do_action( 'riode_before_inner_content', RIODE_BEFORE_INNER_CONTENT );
}

if ( 'navigation' == $ts ) :
	?>

<div class="toolbox-wrap">

	<?php
	riode_get_template_part(
		RIODE_PART . '/sidebar',
		null,
		array(
			'layout_slug' => riode_get_layout_value( 'slug' ),
			'sidebar'     => riode_get_layout_value( 'top_sidebar' ),
			'pos'         => 'top',
		)
	);
endif;
?>

<div class="sticky-toolbox sticky-content fix-top toolbox toolbox-top<?php echo esc_attr( 'horizontal' == $ts ? ' toolbox-horizontal' : '' ); ?>">

	<?php
	if ( 'horizontal' == $ts ) :
		riode_get_template_part(
			RIODE_PART . '/sidebar',
			null,
			array(
				'layout_slug' => riode_get_layout_value( 'slug' ),
				'sidebar'     => riode_get_layout_value( 'top_sidebar' ),
				'pos'         => 'top',
			)
		);
	endif;
	?>

	<div class="toolbox-left">
		<?php if ( 'product_archive_layout' == riode_get_layout_value( 'slug' ) && 'horizontal' == $ts ) : ?>
			<a href="#" class="toolbox-item toolbox-toggle top-sidebar-toggle btn btn-sm btn-outline btn-primary d-lg-none"><?php esc_html_e( 'Filter', 'riode' ); ?><i class="d-icon-arrow-<?php echo is_rtl() ? 'left' : 'right'; ?>"></i></a>
		<?php endif; ?>

		<?php
		if ( 'product_archive_layout' == riode_get_layout_value( 'slug' ) && $ls && 'control' == riode_get_layout_value( 'left_sidebar', 'type' ) ) :

			$widgets             = get_option( 'sidebars_widgets' )[ riode_get_layout_value( 'left_sidebar', 'id' ) ];
			$clean_toggle_widget = false;

			foreach ( $widgets as $widget ) {
				if ( 'clean-toggle' == substr( $widget, 0, 12 ) ) {
					$clean_toggle_widget = true;
					break;
				}
			}

			if ( $clean_toggle_widget ) : // if sidebar has clean-toggle widget
				$off_canvas = ( 'out' == riode_get_layout_value( 'left_sidebar', 'place' ) );

				?>
				<a href="#" class="toolbox-item toolbox-toggle <?php echo is_rtl() ? 'right' : 'left'; ?>-sidebar-toggle btn btn-sm btn-outline btn-primary<?php echo esc_attr( $off_canvas ? '' : ' d-lg-none' ); ?>"><?php esc_html_e( 'Filter', 'riode' ); ?><i class="d-icon-arrow-<?php echo is_rtl() ? 'left' : 'right'; ?>"></i></a>
				<?php
			endif;
		endif;
		?>

		<?php if ( 'navigation' != $ts ) : ?>
			<?php
			if ( in_array( 'title', $top_toolbox_items ) ) {
				echo '<h3 class="title">' . riode_get_layout_value( 'ptb', 'title' ) . '</h3>';
			}
			if ( in_array( 'res_count', $top_toolbox_items ) ) {
				woocommerce_result_count();
			}
			?>
			<?php if ( in_array( 'sort_by', $top_toolbox_items ) ) { ?>
			<form class="woocommerce-ordering toolbox-item toolbox-sort select-box" method="get">
				<?php if ( 'horizontal' != $ts ) : ?>
				<label><?php esc_html_e( 'Sort By', 'riode' ); ?> :</label>
				<?php endif; ?>

				<select name="orderby" class="orderby form-control" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
					<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
					<?php endforeach; ?>
				</select>
				<input type="hidden" name="paged" value="1" />
				<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
			</form>
			<?php } ?>
			<?php
		else :
			echo '<a href="#" class="toolbox-item top-sidebar-toggle btn btn-outline btn-primary btn-icon-before"><i class="d-icon-filter-2"></i>' . esc_html__( 'Filter', 'riode' ) . '</a>';
			if ( in_array( 'res_count', $top_toolbox_items ) ) {
				woocommerce_result_count();
			}
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 9 );
		endif;
		?>

	</div> <?php // End of toolbox-left ?>

	<div class="toolbox-right">
	<?php
	if ( 'navigation' == $ts ) {
		if ( in_array( 'sort_by', $top_toolbox_items ) ) {
			?>
			<form class="woocommerce-ordering toolbox-item toolbox-sort select-box" method="get">
				<label><?php esc_html_e( 'Sort By', 'riode' ); ?> :</label>

				<select name="orderby" class="orderby form-control" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
				<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
					<?php endforeach; ?>
				</select>
				<input type="hidden" name="paged" value="1" />
			<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
			</form>
			<?php
		}
	} else {
		if ( in_array( 'count_box', $top_toolbox_items ) ) {
			riode_wc_count_per_page();
		}
	}

	if ( in_array( 'view_type', $top_toolbox_items ) ) {
		riode_wc_shop_show_type();
	}
	?>

	<?php
	if ( 'product_archive_layout' == riode_get_layout_value( 'slug' ) && $rs && 'control' == riode_get_layout_value( 'right_sidebar', 'type' ) ) :

		$widgets             = get_option( 'sidebars_widgets' )[ riode_get_layout_value( 'right_sidebar', 'id' ) ];
		$clean_toggle_widget = false;

		foreach ( $widgets as $widget ) {
			if ( 'clean-toggle' == substr( $widget, 0, 12 ) ) {
				$clean_toggle_widget = true;
				break;
			}
		}

		if ( $clean_toggle_widget ) : // if sidebar has clean-toggle widget
			$off_canvas = ( 'out' == riode_get_layout_value( 'right_sidebar', 'place' ) );
			?>
			<a href="#" class="toolbox-item toolbox-toggle <?php echo is_rtl() ? 'left' : 'right'; ?>-sidebar-toggle btn btn-sm btn-outline btn-primary<?php echo esc_attr( $off_canvas ? '' : ' d-lg-none' ); ?>"><?php esc_html_e( 'Filter', 'riode' ); ?><i class="d-icon-arrow-<?php echo is_rtl() ? 'right' : 'left'; ?>"></i></a>
			<?php
		endif;
	endif;
	?>

	</div> <?php // End of toolbox-right ?>

	<?php if ( in_array( 'cat_filter', $top_toolbox_items ) || in_array( 'search', $top_toolbox_items ) ) { ?>
		<div class="action-wrapper">

		<?php
		if ( in_array( 'cat_filter', $top_toolbox_items ) ) {
			riode_wc_print_category_filter();
		}
		if ( in_array( 'search', $top_toolbox_items ) ) {
			get_search_form(
				array(
					'aria_label' => array(
						'type'        => 'hs-toggle',
						'border_type' => '',
					),
				)
			);
		}
		?>

		</div>
	<?php } ?>
</div>

<?php if ( 'navigation' == $ts ) : ?>
</div>
<?php elseif ( 'horizontal' == $ts ) : ?>
<div class="select-items">
	<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="filter-clean text-primary"><?php echo esc_html__( 'Clean All', 'riode' ); ?></a>
</div>
	<?php
endif;

// If shop page's loadmore type is buton, do not show pagination.
if ( 'page' != riode_get_option( 'shop_loadmore_type' ) ) {
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
}
