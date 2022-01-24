<?php
/**
 * The Template for displaying store.
 *
 * @package WCfM Markeplace Views Store Sold By Simple
 *
 * For edit coping this to yourtheme/wcfm/sold-by
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $WCFM, $WCFMmp;

if ( empty( $product_id ) && empty( $vendor_id ) ) {
	return;
}

if ( empty( $vendor_id ) && $product_id ) {
	$vendor_id = wcfm_get_vendor_id_by_post( $product_id );
}

if ( ! $vendor_id ) {
	return;
}

if ( 'widget' == wc_get_loop_prop( 'product_type' ) ) {
	return;
}

// $show_info = wc_get_loop_prop( 'show_info', false );

// if ( is_array( $show_info ) && ! in_array( 'sold_by', $show_info ) ) {
// 	return;
// }

if ( $vendor_id ) {
	if ( apply_filters( 'wcfmmp_is_allow_sold_by', true, $vendor_id ) && wcfm_vendor_has_capability( $vendor_id, 'sold_by' ) ) {
		// Check is store Online
		$is_store_offline = get_user_meta( $vendor_id, '_wcfm_store_offline', true );
		if ( $is_store_offline ) {
			return;
		}

		$sold_by_text = $WCFMmp->wcfmmp_vendor->sold_by_label( absint( $vendor_id ) );

		if ( riode_get_option( 'wcfm_sold_by_label' ) ) {
			$sold_by_text = riode_get_option( 'wcfm_sold_by_label' );
		}

		$store_name = wcfm_get_vendor_store_name( absint( $vendor_id ) );
		$store_url  = wcfmmp_get_store_url( $vendor_id );

		?>
		<div class="riode-sold-by-container">
			<span class="sold-by-label"><?php echo esc_html( $sold_by_text ); ?></span>:
			<a href="<?php echo esc_url( $store_url ); ?>">
				<?php
				if ( apply_filters( 'wcfmmp_is_allow_sold_by_logo', true ) ) {
					$store_logo = wcfm_get_vendor_store_logo_by_vendor( $vendor_id );
					if ( ! $store_logo ) {
						$store_logo = apply_filters( 'wcfmmp_store_default_logo', $WCFM->plugin_url . 'assets/images/wcfmmp-blue.png' );
					}
					echo '<img class="wcfmmp_sold_by_logo" src="' . $store_logo . '" />&nbsp;';
				}
				echo esc_html( $store_name );
				?>
			</a>
		</div>
		<?php
	}
}
