<?php
/**
 * The footer part of our Riode theme
 */
?>
		</main>

		<?php
		if ( 'riode_template' == get_post_type() && 'footer' == get_post_meta( get_the_ID(), 'riode_template_type', true ) ) {
			echo '<footer class="footer custom-footer footer-' . get_the_ID() . '" id="footer">';

			if ( have_posts() ) :
				the_post();
				the_content();
				wp_reset_postdata();
			endif;

			echo '</footer>';
		} elseif ( is_numeric( riode_get_layout_value( 'footer', 'id' ) ) ) {
			$footer_id = riode_get_layout_value( 'footer', 'id' );
			if ( -1 != $footer_id ) {
				echo '<footer class="footer custom-footer footer-' . $footer_id . '" id="footer">';
				riode_print_template( $footer_id );
				echo '</footer>';
			}
		} else {
			?>
			<footer class="footer <?php echo esc_attr( 'footer-' . riode_get_option( 'footer_skin' ) ); ?>" id="footer">
				<?php
				$footer_wrap = array(
					'ft' => riode_get_option( 'ft_wrap' ),
					'fm' => riode_get_option( 'fm_wrap' ),
					'fb' => riode_get_option( 'fb_wrap' ),
				);

				$prefix = array(
					'ft' => 'top',
					'fm' => 'main',
					'fb' => 'bottom',
				);

				$f_used = false; // check if footer is used

				foreach ( $prefix as $key => $value ) :
					$status    = false;
					$cols      = explode( '+', riode_get_option( $key . '_widgets' ) );
					$ext_class = '';

					for ( $i = 0; $i < count( $cols ); ++$i ) {
						$status |= is_active_sidebar( 'footer-' . $value . '-widget-' . ( $i + 1 ) );
					}

					if ( ! $status ) :
						continue;
					endif;

					if ( 'full' != $footer_wrap[ $key ] ) {
						echo '<div class="' . esc_attr( $footer_wrap[ $key ] ) . '">';
					}

					if ( ! riode_get_option( $key . '_widgets' ) ) {
						$ext_class = ' full-footer-wrapper';
					}
					?>

					<div class="footer-<?php echo esc_attr( $value . $ext_class ); ?>">
					<?php
					if ( $cols[0] ) :
						?>

						<div class="row">
						<?php
						$cols_cnt = count( $cols );
						for ( $i = 0; $i < $cols_cnt; ++$i ) :
							$arg   = explode( '/', $cols[ $i ] );
							$op1   = intval( $arg[0] );
							$op2   = intval( isset( $arg[1] ) ? $arg[1] : 1 );
							$class = 'col-lg-';
							if ( 0 == 12 % $op2 ) {
								$class .= $op1 * 12 / $op2;
							} else {
								$class .= $op1 . '-' . $op2;
							}

							if ( 0 == count( $cols ) % 2 ) {
								$class .= ' col-sm-6';
							}

							$class .= ' footer-column column-' . intval( $i + 1 ) . ( $i == $cols_cnt - 1 ? ' last-column' : '' );

							// sidebar check again
							if ( is_active_sidebar( 'footer-' . $value . '-widget-' . ( $i + 1 ) ) ) :
								?>
							<div class="<?php echo esc_attr( $class ); ?>">
								<?php dynamic_sidebar( 'footer-' . $value . '-widget-' . ( $i + 1 ) ); ?>
							</div>
								<?php
							endif;
					endfor;
						?>
						</div>

						<?php
					else :
						// sidebar check again
						if ( is_active_sidebar( 'footer-' . $value . '-widget-1' ) ) :
							dynamic_sidebar( 'footer-' . $value . '-widget-1' );
						endif;
					endif;

					$f_used = true;
					?>
					</div>

					<?php
					if ( 'full' != $footer_wrap[ $key ] ) {
						echo '</div>';
					}
				endforeach;

				if ( ! $f_used ) {
					?>
					<div class="footer-bottom full-footer-wrapper">
						<?php /* translators: date format */ ?>
						<div class="copyright"><?php printf( esc_html__( 'Riode eCommerce &copy; %s. All Rights Reserved', 'riode' ), date( 'Y' ) ); ?></div>
					</div>
					<?php
				}
				?>
			</footer>
			<?php
		}
		?>
	</div>

	<?php // print mobile bar ?>
	<?php riode_print_mobile_bar(); ?>

	<?php // scroll top button ?>
	<a class="scroll-top" href="#" title="Top" role="button"><i class="d-icon-arrow-up"></i></a>

	<?php if ( ! empty( riode_get_option( 'mobile_menu_items' ) ) ) { // mobile menu ?>
	<div class="mobile-menu-wrapper">
		<div class="mobile-menu-overlay"></div>
		<div class="mobile-menu-container" style="height: 100vh;">
			<!-- Need to ajax load mobile menus -->
		</div>
		<a class="mobile-menu-close" href="#"><i class="close-icon"></i></a>
	</div>
	<?php } ?>

	<?php
	// first popup
	if ( ( function_exists( 'riode_is_elementor_preview' ) && ! riode_is_elementor_preview() ) &&
		( function_exists( 'riode_is_wpb_preview' ) && ! riode_is_wpb_preview() ) &&
		! ( 'riode_template' == get_post_type() && 'popup' == get_post_meta( get_the_ID(), 'riode_template_type', true ) ) && 
		! empty( riode_get_layout_value( 'content', 'popup' ) ) ) {

		wp_enqueue_script( 'jquery-magnific-popup' );

		$popup = riode_get_layout_value( 'content', 'popup' );
		riode_print_popup_template( $popup['popup_id'], $popup['popup_on'], $popup['popup_within'] );
	}
	?>
<?php wp_footer(); ?>
</body>
</html>
