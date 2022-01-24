<?php

/**
 * Riode_Wcfm_Vendors class
 *
 * @since 1.2.0
 */


defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'WCFMmp' ) ) {
	return;
}

if ( ! class_exists( 'Riode_Wcfm_Vendors' ) ) {

	class Riode_Wcfm_Vendors {


		/**
		 * Singleton Instance
		 *
		 * @since 1.2.0
		 */
		public static $instance = null;


		/**
		 * Get Singleton Instance
		 *
		 * @since 1.2.0
		 * @return singleton instance
		 */
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}


		/**
		 * Constructor
		 *
		 * @since 1.2.0
		 */
		public function __construct() {
			global $WCFM, $WCFMmp; //phpcs:ignore

			add_action( 'init', array( $this, 'init_vendor_settings' ), 20 );

			// enqueue WCFMmp compatibility scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 50 );

			// // Remove shipping information text and add it in summary section
			// remove_action( 'woocommerce_single_product_summary', array( &$WCFMmp->wcfmmp_shipping, 'wcfmmp_shipping_info' ), 32 );
			// add_action( 'woocommerce_single_product_summary', array( &$WCFMmp->wcfmmp_shipping, 'wcfmmp_shipping_info' ), 35 );

			// add dashboard link to my account dashboard
			add_filter( 'riode_account_dashboard_items', array( $this, 'add_vendor_dashboard_btn' ) );
			add_filter( 'riode_is_vendor_store', array( $this, 'is_vendor_store_page' ) );
			add_filter( 'wcfmmp_stores_args', array( $this, 'set_store_args' ), 50, 3 );

			// add div element with class row if store list has sidebar
			add_action( 'wcfmmp_store_lists_after_map', array( $this, 'set_store_list_start' ) );
			add_action( 'wcfmmp_store_lists_end', array( $this, 'set_store_list_end' ) );

			// add_action( 'template_redirect', 'set_store_list_sidebar_layout' );
			add_filter( 'wcfm_store_lists_wrapper_class', array( $this, 'set_store_lists_wrapper_class' ) );
			add_filter( 'wcfm_store_wrapper_class', array( $this, 'set_store_wrapper_class' ) );
			add_filter( 'wcfmmp_store_sidebar_args', array( $this, 'set_sidebar_widget_args' ) );

			// enqueue wcfm core style to prevent style broken issue because of wcfm_buttons in homepage
			add_action( 'riode_eqnueue_product_widget_related_scripts', array( $this, 'enqueue_wcfm_core_scripts' ) );

			// Add vendor reg form fields
			add_action( 'riode_register_form', array( $this, 'add_vendor_reg_link' ) );
		}


		/**
		 * Initialize wcfm hooks
		 *
		 * @since 1.2.0
		 */
		public function init_vendor_settings() {

			global $WCFM, $WCFMmp; //phpcs:ignore

			// Remove vendor tab
			if ( riode_get_option( 'single_product_hide_vendor_tab' ) ) {
				remove_filter( 'woocommerce_product_tabs', 'wcfm_product_multivendor_tab', 98 );
			} else {
				// Change default tab title for vendor from theme options
				if ( riode_get_option( 'single_product_vendor_info_title' ) ) {
					add_filter( 'wcfm_product_store_tab_title', array( $this, 'set_vendor_info_tab_title' ) );
				}
			}

			// phpcs:disable
			if ( function_exists( 'riode_is_preview' ) && ! riode_is_preview() ) {

				if ( !is_admin() || defined('DOING_AJAX') ) {
				// Remove default product manage button and set newly
				remove_action( 'woocommerce_before_single_product_summary', array( $WCFM->frontend, 'wcfm_product_manage' ), 4 );
				add_action( 'riode_before_product_summary', array( $WCFM->frontend, 'wcfm_product_manage' ), 30 );

				remove_action( 'woocommerce_before_shop_loop_item', array( $WCFM->frontend, 'wcfm_product_manage' ), 4 );
				add_action( 'woocommerce_before_shop_loop_item', array( $WCFM->frontend, 'wcfm_product_manage' ), 6 );

				// Remove all defaut sold by template from WCFM dashboard settings
				remove_action( 'woocommerce_after_shop_loop_item_title', array( $WCFMmp->frontend, 'wcfmmp_sold_by_product' ), 9 );
				remove_action( 'woocommerce_after_shop_loop_item', array( $WCFMmp->frontend, 'wcfmmp_sold_by_product' ), 50 );
				remove_action( 'woocommerce_after_shop_loop_item_title', array( $WCFMmp->frontend, 'wcfmmp_sold_by_product' ), 50 );
				}

				// Set sold by position by theme.
				if ( riode_get_option( 'wcfm_show_sold_by_label' ) ) {
					// add_action( 'woocommerce_after_shop_loop_item_title', array( $WCFMmp->frontend, 'wcfmmp_sold_by_product' ), 10 );
					add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'add_sold_by_to_loop' ), 10 );
				}

				$vendor_sold_by_position = isset( $WCFMmp->wcfmmp_marketplace_options['vendor_sold_by_position'] ) ? $WCFMmp->wcfmmp_marketplace_options['vendor_sold_by_position'] : 'below_atc';

				if ( 'bellow_atc' == $vendor_sold_by_position ) {
					remove_action( 'woocommerce_product_meta_start', array( $WCFMmp->frontend, 'wcfmmp_sold_by_single_product' ), 50 );
					add_action( 'woocommerce_single_product_summary', array( $WCFMmp->frontend, 'wcfmmp_sold_by_single_product' ), 31 );
				}
			}
		}


		/**
		 * Change title of vendor info tab
		 *
		 * @since 1.2.0
		 * @param string title
		 * @return string title
		 */
		public function set_vendor_info_tab_title( $title ) {
			return riode_get_option( 'single_product_vendor_info_title' );
		}


		/**
		 * Enqueue WCFM scripts
		 *
		 * @since 1.2.0
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'riode-wcfm-comp-style', RIODE_CSS . '/theme/pages/wcfm' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', array( 'riode-style' ), RIODE_VERSION );
			wp_enqueue_style( 'riode-theme-shop' );
		}


		/**
		 * Add item to go to vendor dashboard in account dashboard
		 *
		 * @since 1.2.0
		 */
		public function add_vendor_dashboard_btn( $args = [] ) {
			if ( ! wcfm_is_vendor() ) {
				return $args;
			}

			$args['vendor_dashboard'] = array( 'Vendor Dashboard', get_wcfm_page() );

			return $args;
		}

		/**
		 * Check vendor store page or not
		 *
		 * @param boolean
		 * @return boolean
		 * @since 1.2.0
		 */
		public function is_vendor_store_page( $arg = false ) {
			return wcfmmp_is_store_page();
		}


		/**
		 * Wrapper start with class-row
		 *
		 * @since 1.2.0
		 */
		public function set_store_list_start() {
			global $WCFMmp; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			if ( $WCFMmp->wcfmmp_vendor->is_store_lists_sidebar() ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
				echo '<div class="row gutter-lg store-list-wrap">';
			}
		}


		/**
		 * Wrapper end with class-row
		 *
		 * @since 1.2.0
		 */
		public function set_store_list_end() {
			global $WCFMmp; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			if ( $WCFMmp->wcfmmp_vendor->is_store_lists_sidebar() ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
				echo '</div>';
			}
		}


		/**
		 * Set WCFM store list sidebar
		 *
		 * @since 1.2.0
		 */
		public function set_store_list_sidebar_layout() {

			global $WCFMmp; // phpcs:disable

			if ( wcfmmp_is_stores_list_page() && $WCFMmp->wcfmmp_vendor->is_store_lists_sidebar() ) {
				$store_sidebar_pos = isset( $WCFMmp->wcfmmp_marketplace_options['store_sidebar_pos'] ) ? $WCFMmp->wcfmmp_marketplace_options['store_sidebar_pos'] : 'left';
				// phpcs:enable

				riode_get_layout_value( 'slug' );

				global $riode_layout;
				if ( 'left' == $store_sidebar_pos ) {
					$riode_layout['left_sidebar'] = 'sidebar-wcfmmp-store-lists';
				} else {
					$riode_layout['right_sidebar'] = 'sidebar-wcfmmp-store-lists';
				}
			}
		}


		/**
		 * Enqueue WCFM core style
		 *
		 * @since 1.2.0
		 */
		public function enqueue_wcfm_core_scripts() {
			wp_enqueue_style( 'wcfm_core_css' );
		}


		/**
		 * Set wcfm store lists wrapper class
		 *
		 * @since 1.2.0
		 */
		public function set_store_lists_wrapper_class( $class ) {

			global $WCFMmp; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			if ( $WCFMmp->wcfmmp_vendor->is_store_lists_sidebar() ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
				$class .= ' has-sidebar';
			} else {
				$class .= ' no-sidebar';
			}

			return $class;
		}


		/**
		 * Set WCFM store wrapper class
		 *
		 * @since 1.2.0
		 */
		public function set_store_wrapper_class( $class ) {
			if ( 'full' != riode_get_layout_value( 'general', 'wrap' ) ) {
				$class .= 'container-fluid' == riode_get_layout_value( 'general', 'wrap' ) ? 'container-fluid' : 'container';
			}

			$class = 'container';

			return $class;
		}


		/**
		 * Set WCFM sidebar widget arguments
		 *
		 * @param array $args
		 * @return array $args
		 * @since 1.2.0
		 */
		public function set_sidebar_widget_args( $args ) {

			return array(
				'name'          => __( 'Vendor Store Sidebar', 'wc-multivendor-marketplace' ),
				'id'            => 'sidebar-wcfmmp-store',
				'before_widget' => '<aside class="widget widget-collapsible">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title"> <span class="wt-area">',
				'after_title'   => '</span></h3>',
			);
		}


		/**
		 * Set WCFM store arguments
		 *
		 * @param array $args
		 * @return array $args
		 * @since 1.2.0
		 */
		public function set_store_args( $args, $attr, $search_data ) {
			global $WCFMmp; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			if ( $WCFMmp->wcfmmp_vendor->is_store_lists_sidebar() ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
				$args['per_row'] = 2;
			}

			return apply_filters( 'set_store_args', $args, $attr, $search_data );
		}


		/**
		 * Add link to signup as a vendor to login popup
		 *
		 * @since 1.2.0
		 */
		public function add_vendor_reg_link() {
			if ( wp_doing_ajax() ) {

				$page_id = absint( get_option( 'wcfm_vendor_registration_page_id' ) );

				if ( $page_id ) {
					$register_link = get_permalink( $page_id );
					$register_text = esc_html__( 'Signup as a vendor?', 'riode' );

					echo '<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">';
						echo '<a class="register_as_vendor" href="' . esc_url( $register_link ) . '">' . $register_text . '</a>';
					echo '</p>';
				}
			}
		}



		/**
		 * Add sold by label to product loop
		 *
		 * @since 1.2.0
		 */
		public function add_sold_by_to_loop() {
			if ( ! class_exists( 'WCFM' ) ) {
				return;
			}

			global $WCFM, $post, $WCFMmp;

			$vendor_id = $WCFM->wcfm_vendor_support->wcfm_get_vendor_id_from_product( $post->ID );

			if ( ! $vendor_id ) {
				return;
			}

			$sold_by_text = riode_get_option( 'wcfm_sold_by_label' ) ? riode_get_option( 'wcfm_sold_by_label' ) : apply_filters( 'wcfmmp_sold_by_label', esc_html__( 'Sold By:', 'riode' ) );
			$store_name   = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_by_vendor( absint( $vendor_id ) );

			?>
			<div class="riode-sold-by-container">
				<span class="sold-by-label"><?php echo esc_html( $sold_by_text ); ?></span>
				<?php echo wp_kses_post( $store_name ); ?>
			</div>
			<?php
		}
	}
}

Riode_Wcfm_Vendors::get_instance();
