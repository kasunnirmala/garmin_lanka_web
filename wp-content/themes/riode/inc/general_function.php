<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * inc/general_function.php
 * general functions using in Riode theme
 */

/**
 * Get JS file extension.
 *
 * @return string extension of JS file
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_get_js_extension' ) ) {
	function riode_get_js_extension() {
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			return '.js';
		}
		return '.min.js';
	}
}

/**
 * Get Riode theme option.
 *
 * @since 1.0.0
 * @since 1.2.0 added fallback function
 */
function riode_get_option( $option = '', $fallback = false ) {
	global $riode_option;

	if ( is_customize_preview() ) {
		try {
			if ( isset( $_POST['customized'] ) ) {
				$modified = json_decode( stripslashes_deep( $_POST['customized'] ), true );

				if ( isset( $modified[ $option ] ) ) {
					return $modified[ $option ];
				}
			}
		} catch ( Exception $e ) {
		}
	}

	return get_theme_mod( $option, isset( $riode_option[ $option ] ) ? $riode_option[ $option ] : $fallback );
}

function riode_get_template_part( $slug, $name = null, $args = array() ) {
	if ( empty( $args ) ) {
		return get_template_part( $slug, $name );
	}

	if ( is_array( $args ) ) {
		extract( $args ); // @codingStandardsIgnoreLine
	}

	$templates = array();
	$name      = (string) $name;
	if ( '' !== $name ) {
		$templates[] = "{$slug}-{$name}.php";
	}
	$templates[] = "{$slug}.php";
	$template    = locate_template( $templates );
	$template    = apply_filters( 'riode_get_template_part', $template, $slug, $name );

	if ( $template ) {
		include $template;
	}
}

function riode_load_google_font() {
	$typos   = array( 'typo_default', 'typo_heading', 'typo_custom1', 'typo_custom2', 'typo_custom3', 'typo_header', 'typo_menu_skin1_ancestor', 'typo_menu_skin1_content', 'typo_menu_skin1_toggle', 'typo_menu_skin2_ancestor', 'typo_menu_skin2_content', 'typo_menu_skin2_toggle', 'typo_menu_skin3_ancestor', 'typo_menu_skin3_content', 'typo_menu_skin3_toggle', 'typo_footer', 'typo_footer_title', 'typo_footer_widget', 'typo_ptb_title', 'typo_ptb_subtitle', 'typo_ptb_breadcrumb' );
	$weights = array();
	$fonts   = array();

	foreach ( $typos as $typo ) {
		$family = riode_get_option( $typo )['font-family'];
		if ( 'inherit' == $family || 'initial' == $family || '' == $family ) {
			continue;
		}

		$t = riode_get_option( $typo );

		if ( ! isset( $t['variant'] ) ) {
			$weight = '400';
		} elseif ( 'normal' == $t['variant'] || 'regular' == $t['variant'] ) {
			$weight = '400';
		} elseif ( 'italic' == $t['variant'] ) {
			$weight = '400italic';
		} else {
			$weight = $t['variant'];
		}

		if ( ! array_key_exists( $family, $weights ) ) {
			$weights[ $family ] = array( '300', '400', '500', '600', '700' );
		}

		if ( ! in_array( $weight, $weights[ $family ] ) ) {
			$weights[ $family ][] = $weight;
		}
	}

	$used_blocks = riode_get_layout_value( 'used_blocks' );

	foreach ( $weights as $family => $weight ) {
		$weight  = array_unique( $weight );
		$fonts[] = str_replace( ' ', '+', $family ) . ':' . implode( ',', $weight );
	}

	if ( $fonts ) {
		if ( is_admin() || riode_get_option( 'google_webfont' ) ) {
			?>
			<script>
				WebFontConfig = {
					google: { families: [ '<?php echo implode( "','", $fonts ); ?>' ] }
				};
				(function(d) {
					var wf = d.createElement('script'), s = d.scripts[0];
					wf.src = '<?php echo RIODE_JS; ?>/webfont.js';
					wf.async = true;
					s.parentNode.insertBefore(wf, s);
				})(document);
			</script>
			<?php
		} else {
			wp_enqueue_style( 'riode-google-fonts', esc_url( '//fonts.googleapis.com/css?family=' . implode( '%7C', $fonts ) ) );
		}
	}
}

function riode_icl_disp_language( $native_name, $translated_name = false, $lang_native_hidden = false, $lang_translated_hidden = false ) {
	if ( function_exists( 'icl_disp_language' ) ) {
		return icl_disp_language( $native_name, $translated_name, $lang_native_hidden, $lang_translated_hidden );
	}
	$ret = '';

	if ( ! $native_name && ! $translated_name ) {
		$ret = '';
	} elseif ( $native_name && $translated_name ) {
		$hidden1 = '';
		$hidden2 = '';
		$hidden3 = '';
		if ( $lang_native_hidden ) {
			$hidden1 = 'style="display:none;"';
		}
		if ( $lang_translated_hidden ) {
			$hidden2 = 'style="display:none;"';
		}
		if ( $lang_native_hidden && $lang_translated_hidden ) {
			$hidden3 = 'style="display:none;"';
		}

		if ( $native_name != $translated_name ) {
			$ret =
				'<span ' .
				$hidden1 .
				' class="icl_lang_sel_native">' .
				$native_name .
				'</span> <span ' .
				$hidden2 .
				' class="icl_lang_sel_translated"><span ' .
				$hidden1 .
				' class="icl_lang_sel_native">(</span>' .
				$translated_name .
				'<span ' .
				$hidden1 .
				' class="icl_lang_sel_native">)</span></span>';
		} else {
			$ret = '<span ' . $hidden3 . ' class="icl_lang_sel_current">' . esc_html( $native_name ) . '</span>';
		}
	} elseif ( $native_name ) {
		$ret = $native_name;
	} elseif ( $translated_name ) {
		$ret = $translated_name;
	}

	return $ret;
}

if ( ! function_exists( 'riode_strip_script_tags' ) ) :
	function riode_strip_script_tags( $content ) {
		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = preg_replace( '/<script.*?\/script>/s', '', $content ) ? : $content;
		$content = preg_replace( '/<style.*?\/style>/s', '', $content ) ? : $content;
		return $content;
	}
endif;

function riode_get_responsive_cols( $cols, $type = 'product' ) {
	$result = array();
	$base   = $cols['lg'] ? $cols['lg'] : 4;

	if ( 6 < $base ) { // 7, 8
		if ( ! isset( $cols['xl'] ) ) {
			$result = array(
				'xl'  => $base,
				'lg'  => 6,
				'md'  => 4,
				'sm'  => 3,
				'min' => 2,
			);
		} else {
			$result = array(
				'lg'  => $base,
				'md'  => 6,
				'sm'  => 4,
				'min' => 3,
			);
		}
	} elseif ( 4 < $base ) { // 5, 6
		$result = array(
			'lg'  => $base,
			'md'  => 4,
			'sm'  => 3,
			'min' => 2,
		);

		if ( ! isset( $cols['xl'] ) ) {
			$result['xl'] = $base;
			$result['lg'] = 4;
		}
	} elseif ( 2 < $base ) { // 3, 4
		$result = array(
			'lg'  => $base,
			'md'  => 3,
			'sm'  => 2,
			'min' => 2,
		);

		if ( 'post' == $type ) {
			$result['min'] = 1;
		}
	} else { // 1, 2
		$result = array(
			'lg'  => $base,
			'md'  => $base,
			'sm'  => 1,
			'min' => 1,
		);
	}

	foreach ( $cols as $w => $c ) {
		if ( 'lg' != $w && $c > 0 ) {
			$result[ $w ] = $c;
		}
	}

	return apply_filters( 'riode_filter_reponsive_cols', $result, $cols );
}

if ( ! function_exists( 'riode_get_col_class' ) ) {
	function riode_get_col_class( $col_cnt = array() ) {

		$class = ' row';

		foreach ( $col_cnt as $w => $c ) {
			if ( $c > 0 ) {
				$class .= ' cols-' . ( 'min' != $w ? $w . '-' : '' ) . $c;
			}
		}

		return apply_filters( 'riode_get_col_class', $class );
	}
}

if ( ! function_exists( 'riode_get_overlay_class' ) ) {
	function riode_get_overlay_class( $overlay ) {
		if ( 'light' === $overlay ) {
			return 'overlay-light';
		}
		if ( 'dark' === $overlay ) {
			return 'overlay-dark';
		}
		if ( 'zoom' === $overlay ) {
			return 'overlay-zoom';
		}
		if ( 'zoom_light' === $overlay ) {
			return 'overlay-zoom overlay-light';
		}
		if ( 'zoom_dark' === $overlay ) {
			return 'overlay-zoom overlay-dark';
		}
		if ( 0 == strncmp( $overlay, 'effect-', 7 ) ) {
			return 'overlay-' . $overlay;
		}
		return 'overlay-image-filter overlay-' . $overlay;
	}
}

if ( ! function_exists( 'riode_get_slider_class' ) ) {
	function riode_get_slider_class( $settings = array() ) {

		riode_add_async_script( 'owl-carousel' );

		$class = 'owl-carousel owl-theme';

		// Nav & Dots
		if ( isset( $settings['nav_type'] ) && 'full' === $settings['nav_type'] ) {
			$class .= ' owl-nav-full';
		} else {
			if ( isset( $settings['nav_type'] ) && 'simple' === $settings['nav_type'] ) {
				$class .= ' owl-nav-simple';
			}
			if ( isset( $settings['nav_pos'] ) && 'inner' === $settings['nav_pos'] ) {
				$class .= ' owl-nav-inner';
			} elseif ( isset( $settings['nav_pos'] ) && 'top' === $settings['nav_pos'] ) {
				$class .= ' owl-nav-top';
			}
		}
		if ( isset( $settings['nav_hide'] ) && 'yes' === $settings['nav_hide'] ) {
			$class .= ' owl-nav-fade';
		}
		if ( isset( $settings['dots_type'] ) && '' !== $settings['dots_type'] ) {
			$class .= ' owl-dot-' . $settings['dots_type'];
		}
		if ( isset( $settings['dots_pos'] ) && 'inner' === $settings['dots_pos'] ) {
			$class .= ' owl-dot-inner';
		}

		if ( isset( $settings['fullheight'] ) && 'yes' === $settings['fullheight'] ) {
			$class .= ' owl-full-height';
		}

		if ( isset( $settings['slider_vertical_align'] ) && ( 'top' === $settings['slider_vertical_align'] ||
		'middle' === $settings['slider_vertical_align'] ||
		'bottom' === $settings['slider_vertical_align'] ||
		'same-height' === $settings['slider_vertical_align'] ) ) {

			$class .= ' owl-' . $settings['slider_vertical_align'];
		}

		return $class;
	}
}

if ( ! function_exists( 'riode_get_slider_attrs' ) ) {
	function riode_get_slider_attrs( $settings, $col_cnt, $self = '' ) {

		global $riode_breakpoints;

		$extra_options = array();

		$margin = riode_get_grid_space( isset( $settings['col_sp'] ) ? $settings['col_sp'] : '' );

		if ( $margin > 0 ) { // default is 0
			$extra_options['margin'] = $margin;
		}

		if ( isset( $settings['dots_kind'] ) && 'thumb' === $settings['dots_kind'] ) { // default is ''
			$extra_options['dotsContainer'] = '.slider-thumb-dots-' . ( class_exists( $self ) && is_callable( array( $self, 'get_data' ) ) ? $self->get_data( 'id' ) : $self );
		}

		if ( isset( $settings['autoplay'] ) && 'yes' === $settings['autoplay'] ) { // default is false
			$extra_options['autoplay'] = true;
		}
		if ( isset( $settings['autoplay_timeout'] ) && 5000 !== (int) $settings['autoplay_timeout'] ) { // default is 5000
			$extra_options['autoplayTimeout'] = (int) $settings['autoplay_timeout'];
		}
		if ( isset( $settings['pause_onhover'] ) && 'yes' === $settings['pause_onhover'] ) { // default  is false
			$extra_options['autoplayHoverPause'] = true;
		}
		if ( isset( $settings['loop'] ) && 'yes' === $settings['loop'] ) {
			$extra_options['loop'] = true;
		}
		if ( isset( $settings['autoheight'] ) && 'yes' === $settings['autoheight'] ) {
			$extra_options['autoHeight'] = true;
		}
		if ( isset( $settings['center_mode'] ) && 'yes' === $settings['center_mode'] ) {
			$extra_options['center'] = true;
		}
		if ( isset( $settings['prevent_drag'] ) && 'yes' === $settings['prevent_drag'] ) {
			$extra_options['mouseDrag'] = false;
			$extra_options['touchDrag'] = false;
			$extra_options['pullDrag']  = false;
		}
		if ( isset( $settings['animation_in'] ) && $settings['animation_in'] ) {
			$extra_options['animateIn'] = $settings['animation_in'];
		}
		if ( isset( $settings['animation_out'] ) && $settings['animation_out'] ) {
			$extra_options['animateOut'] = $settings['animation_out'];
		}

		$responsive = array();
		foreach ( $col_cnt as $w => $c ) {
			$responsive[ $riode_breakpoints[ $w ] ] = array(
				'items' => $c,
			);
		}
		if ( isset( $responsive[ $riode_breakpoints['md'] ] ) && ! $responsive[ $riode_breakpoints['md'] ] ) {
			$responsive[ $riode_breakpoints['md'] ] = array();
		}
		if ( isset( $responsive[ $riode_breakpoints['lg'] ] ) && ! $responsive[ $riode_breakpoints['lg'] ] ) {
			$responsive[ $riode_breakpoints['lg'] ] = array();
		}

		if ( isset( $settings['show_nav'] ) ) {
			$extra_options['nav'] = $responsive[ $riode_breakpoints['md'] ]['nav'] = $responsive[ $riode_breakpoints['lg'] ]['nav'] = ( 'yes' === $settings['show_nav'] );
		}
		if ( isset( $settings['show_dots'] ) ) {
			$extra_options['dots'] = $responsive[ $riode_breakpoints['md'] ]['dots'] = $responsive[ $riode_breakpoints['lg'] ]['dots'] = ( 'yes' === $settings['show_dots'] );
		}
		if ( isset( $settings['show_nav_tablet'] ) ) {
			$extra_options['nav'] = $responsive[ $riode_breakpoints['md'] ]['nav'] = ( 'yes' === $settings['show_nav_tablet'] );
		}
		if ( isset( $settings['show_dots_tablet'] ) ) {
			$extra_options['dots'] = $responsive[ $riode_breakpoints['md'] ]['dots'] = ( 'yes' === $settings['show_dots_tablet'] );
		}
		if ( isset( $settings['show_nav_mobile'] ) ) { // default is false
			$extra_options['nav'] = ( 'yes' === $settings['show_nav_mobile'] );
		}
		if ( isset( $settings['show_dots_mobile'] ) ) { // default is true
			$extra_options['dots'] = ( 'yes' === $settings['show_dots_mobile'] );
		}

		if ( isset( $responsive[ $breakpoints['xl'] ] ) || ( isset( $settings['show_nav_xl'] ) && $settings['show_nav_xl'] != $settings['show_nav'] ) || ( isset( $settings['show_dots_xl'] ) && $settings['show_dots_xl'] != $settings['show_dots'] ) ) {
			if ( isset( $settings['show_nav_xl'] ) ) {
				$responsive[ $breakpoints['xl'] ]['nav'] = 'yes' == $settings['show_nav_xl'];
			} else {
				$responsive[ $breakpoints['xl'] ]['nav'] = isset( $settings['show_nav'] ) && 'yes' == $settings['show_nav'];
			}
			if ( isset( $settings['show_dots_xl'] ) ) {
				$responsive[ $breakpoints['xl'] ]['dots'] = 'yes' == $settings['show_dots_xl'];
			} else {
				$responsive[ $breakpoints['xl'] ]['dots'] = isset( $settings['show_dots'] ) && 'yes' == $settings['show_dots'];
			}

			if ( ! isset( $responsive[ $breakpoints['xl'] ] ) ) {
				$responsive[ $breakpoints['xl'] ] = $responsive[ $breakpoints['lg'] ];
			}
		}

		$extra_options['responsive'] = $responsive;

		return $extra_options;
	}
}

if ( ! function_exists( 'riode_get_grid_space' ) ) {
	function riode_get_grid_space( $col_sp ) {
		if ( 'no' === $col_sp ) {
			return 0;
		} elseif ( 'sm' === $col_sp ) {
			return 10;
		} elseif ( 'lg' === $col_sp ) {
			return 30;
		} elseif ( 'xs' === $col_sp ) {
			return 2;
		} else {
			return 20;
		}
	}
}

if ( ! function_exists( 'riode_loadmore_attributes' ) ) {
	function riode_loadmore_attributes( $props, $args, $loadmore_type, $max_num_pages ) {
		return 'data-load="' . esc_attr(
			json_encode(
				array(
					'props' => $props,
					'args'  => $args,
					'max'   => $max_num_pages,
				)
			)
		) . '"';
	}
}

if ( ! function_exists( 'riode_loadmore_html' ) ) {
	function riode_loadmore_html( $query, $loadmore_type, $loadmore_label, $loadmore_btn_style = '', $name_prefix = '' ) {
		if ( 'button' === $loadmore_type ) {
			$class = 'btn btn-load ';

			if ( $loadmore_btn_style ) {
				$class .= implode( ' ', riode_widget_button_get_class( $loadmore_btn_style, $name_prefix ) );
			} else {
				$class .= 'btn-primary';
			}

			$label = empty( $loadmore_label ) ? esc_html__( 'Load More', 'riode' ) : esc_html( $loadmore_label );
			echo '<button class="' . esc_attr( $class ) . '">' . ( $loadmore_btn_style ? riode_widget_button_get_label( $loadmore_btn_style, null, $label, $name_prefix ) : $label ) . '</button>';
		} elseif ( 'page' === $loadmore_type ) {
			echo riode_get_pagination( $query, 'pagination-load' );
		}
	}
}

if ( ! function_exists( 'riode_get_pagination_html' ) ) {
	function riode_get_pagination_html( $paged, $total, $class = '', $new_args = array() ) {

		$classes = array( 'pagination' );

		// Set up paginated links.
		$args = apply_filters(
			'riode_filter_pagination_args',
			array(
				'current'   => $paged,
				'total'     => $total,
				'end_size'  => 1,
				'mid_size'  => 2,
				'prev_text' => '<i class="d-icon-arrow-left"></i> ' . esc_html__( 'Prev', 'riode' ),
				'next_text' => esc_html__( 'Next', 'riode' ) . ' <i class="d-icon-arrow-right"></i>',
			)
		);
		$args = wp_parse_args( $new_args, $args );

		$links = paginate_links( $args );

		if ( $class ) {
			$classes[] = esc_attr( $class );
		}

		if ( $links ) {

			if ( 1 == $paged ) {
				$links = sprintf(
					'<span class="prev page-numbers disabled">%s</span>',
					$args['prev_text']
				) . $links;
			} elseif ( $paged == $total ) {
				$links .= sprintf(
					'<span class="next page-numbers disabled">%s</span>',
					$args['next_text']
				);
			}

			$links = '<div class="' . implode( ' ', $classes ) . '">' . preg_replace( '/^\s+|\n|\r|\s+$/m', '', $links ) . '</div>';
		}

		return $links;
	}
}

if ( ! function_exists( 'riode_get_page_links_html' ) ) :
	function riode_get_page_links_html() {
		if ( ! is_singular() ) {
			return;
		}
		global $page, $numpages, $multipage;
		if ( $multipage ) {
			global $wp_rewrite;
			$post       = get_post();
			$query_args = array();
			$prev_link  = '';
			$next_link  = '';

			if ( ! get_option( 'permalink_structure' ) || in_array( $post->post_status, array( 'draft', 'pending' ), true ) ) {
				if ( $page + 1 <= $numpages ) {
					$next_link = add_query_arg( 'page', $page + 1, get_permalink() );
				}
				if ( $page > 1 ) {
					$prev_link = add_query_arg( 'page', $page - 1, get_permalink() );
				}
			} elseif ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' ) == $post->ID ) {
				if ( $page + 1 <= $numpages ) {
					$next_link = trailingslashit( get_permalink() ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . ( $page + 1 ), 'single_paged' );
				}
				if ( $page > 1 ) {
					$prev_link = trailingslashit( get_permalink() ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . ( $page - 1 ), 'single_paged' );
				}
			} else {
				if ( $page + 1 <= $numpages ) {
					$next_link = trailingslashit( get_permalink() ) . user_trailingslashit( $page + 1, 'single_paged' );
				}
				if ( $page > 1 ) {
					$prev_link = trailingslashit( get_permalink() ) . user_trailingslashit( $page - 1, 'single_paged' );
				}
			}
			if ( $prev_link ) {
				$prev_html_escaped = '<a class="prev page-numbers" href="' . esc_url( $prev_link ) . '"><i class="d-icon-arrow-left"></i> ' . esc_html__( 'Prev', 'riode' ) . '</a>';
			} else {
				$prev_html_escaped = '<span class="prev page-numbers disabled"><i class="d-icon-arrow-left"></i> ' . esc_html__( 'Prev', 'riode' ) . '</span>';
			}
			if ( $next_link ) {
				$next_html_escaped = '<a class="next page-numbers" href="' . esc_url( $next_link ) . '">' . esc_html__( 'Next', 'riode' ) . ' <i class="d-icon-arrow-right"></i></a>';
			} else {
				$next_html_escaped = '<span class="next page-numbers disabled">' . esc_html__( 'Next', 'riode' ) . ' <i class="d-icon-arrow-right"></i></span>';
			}

			wp_link_pages(
				array(
					'before' => '<div class="pagination-footer"><div class="links pagination" role="navigation">' . $prev_html_escaped,
					'after'  => $next_html_escaped . '</div></div>',
				)
			);
		}
	}
endif;

if ( ! function_exists( 'riode_get_pagination' ) ) {
	function riode_get_pagination( $query = '', $class = '' ) {

		if ( ! $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		$paged = $query->get( 'paged' ) ? $query->get( 'paged' ) : ( $query->get( 'page' ) ? $query->get( 'page' ) : 1 );
		$total = $query->max_num_pages;

		return riode_get_pagination_html( $paged, $total, $class );
	}
}

if ( ! function_exists( 'riode_pagination' ) ) {
	function riode_pagination( $query = '', $class = '' ) {
		echo riode_get_pagination( $query, $class );
	}
}

function riode_trim_description( $text = '', $limit = 45, $unit = 'words' ) {
	$content = wp_strip_all_tags( $text );
	$content = strip_shortcodes( $content );

	if ( ! $limit ) {
		$limit = 45;
	}

	if ( ! $unit ) {
		$unit = 'words';
	}

	if ( 'words' == $unit ) {
		return apply_filters( 'riode_filter_trim_description', '<p>' . wp_trim_words( $content, $limit ) . '</p>' );
	}
	$affix = ( strlen( $content ) < $limit ? '' : ' ...' );
	return apply_filters( 'riode_filter_trim_description', '<p>' . mb_substr( $content, 0, $limit ) . $affix . '</p>' );
}

if ( ! function_exists( 'riode_post_comment' ) ) {
	function riode_post_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

			<?php if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) { ?>
			<div id="comment-<?php comment_ID(); ?>" class="comment comment-container">
				<p><?php esc_html_e( 'Pingback:', 'riode' ); ?> <span><span><?php comment_author_link( get_comment_ID() ); ?></span></span> <?php edit_comment_link( esc_html__( '(Edit)', 'riode' ), '<span class="edit-link">', '</span>' ); ?></p>
			</div>
			<?php } else { ?>
			<div class="comment">
				<figure class="comment-avatar">
					<?php echo get_avatar( $comment, 50 ); ?>
				</figure>

				<div class="comment-text">
					<?php /* translators: %s represents the date of the comment. */ ?>
					<h5 class="comment-date"><?php printf( esc_html__( '%1$s at %2$s', 'riode' ), get_comment_date(), get_comment_time() ); ?></h5>

					<h4 class="comment-name"><?php echo get_comment_author_link( get_comment_ID() ); ?></h4>

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'riode' ); ?></em>
						<br />
					<?php endif; ?>

					<?php
					comment_text();

					comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => 'comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
							)
						)
					);
					?>
				</div>
			</div>
				<?php
			}
	}
}

if ( ! function_exists( 'riode_doing_ajax' ) ) {
	function riode_doing_ajax() {
		// WordPress ajax
		if ( wp_doing_ajax() ) {
			return true;
		}

		return apply_filters( 'riode_core_filter_doing_ajax', false );
	}
}

function riode_get_period_from( $time ) {
	$time = time() - $time;     // to get the time since that moment
	$time = ( $time < 1 ) ? 1 : $time;

	$tokens = array(
		31536000 => 'year',
		2592000  => 'month',
		604800   => 'week',
		86400    => 'day',
		3600     => 'hour',
		60       => 'minute',
		1        => 'second',
	);

	foreach ( $tokens as $unit => $text ) {
		if ( $time < $unit ) {
			continue;
		}
		$number_of_units = floor( $time / $unit );
		return sprintf( esc_html__( '%s ago', 'riode' ), $number_of_units . ' ' . $text . ( ( $number_of_units > 1 ) ? 's' : '' ) );
	}
}

/**
 * Compile Dynamic CSS
 */
function riode_compile_dynamic_css( $arg = '', $used_elements = '' ) {
	$css_files = array( 'theme', 'blog', 'single-post', 'shop', 'shop-other', 'single-product' );

	$dynamic = '';

	// "Optimize Wizard/Optimize CSS" needs customizer functions.
	require_once RIODE_ADMIN . '/customizer/customizer-function.php';

	ob_start();
	include RIODE_INC . '/admin/customizer/dynamic/dynamic_config.php';

	// Optimize
	if ( 'optimize' == $arg ) {
		if ( is_array( $used_elements ) ) {
			echo '$is_component_optimize: true; $use_map:(';
			foreach ( $used_elements as $used_element => $used ) {
				if ( $used ) {
					echo esc_html( $used_element ) . ': true,';
				}
			}
			echo ');';
		}
	}

	$dynamic = ob_get_clean();

	// Compile CSS
	foreach ( $css_files as $file ) {
		ob_start();

		require RIODE_PATH . '/assets/sass/theme/' . ( 'theme' == $file ? 'theme' . ( is_rtl() ? '-rtl' : '' ) : 'pages/' . $file . ( is_rtl() ? '-rtl' : '' ) ) . '.scss';
		$config_scss = '$is_preview: false !default;' . wp_strip_all_tags( str_replace( '// @set_theme_configuration', $dynamic, ob_get_clean() ) );

		$src = RIODE_PATH . '/assets/sass/theme' . ( 'theme' == $file ? '' : '/pages' );

		$target = wp_upload_dir()['basedir'] . '/riode_styles/theme' . ( 'theme' == $file ? '' : '-' . $file ) . '.min.css';

		riode_compile_css( $target, $config_scss, $src );
	}
}

function riode_compile_css( $target, $config_scss, $src, $optimize = false ) {
	// filesystem
	global $wp_filesystem;
	// Initialize the WordPress filesystem, no more using file_put_contents function
	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	if ( ! class_exists( 'Compiler' ) ) {
		require_once RIODE_PLUGINS . '/scssphp/scss.inc.php';
	}

	$scss = new ScssPhp\ScssPhp\Compiler();
	$scss->setImportPaths( $src );

	// $scss->setFormatter( 'scss_formatter_crunched' );
	// $scss->setFormatter( 'scss_formatter' );

	try {
		$css = $scss->compile( $config_scss );
		// $css = $config_scss;
		$target_path = dirname( $target );

		$css = preg_replace( '/url\(\'(..\/)+/i', "url('" . esc_url( RIODE_ASSETS ) . '/', $css );

		if ( ! file_exists( $target_path ) ) {
			wp_mkdir_p( $target_path );
		}

		// check file mode and make it writable.
		if ( is_writable( $target_path ) == false ) {
			@chmod( get_theme_file_path( $target ), 0755 );
		}
		if ( file_exists( $target ) ) {
			if ( is_writable( $target ) == false ) {
				@chmod( $target, 0755 );
			}
			@unlink( $target );
		}

		$wp_filesystem->put_contents( $target, riode_minify_css( $css ), FS_CHMOD_FILE );
	} catch ( Exception $e ) {
		var_dump( $e );
		var_dump( 'error occured while SCSS compiling.' );
	}
}

function riode_minify_css( $style ) {
	if ( ! $style ) {
		return;
	}

	// Change ::before, ::after to :before, :after
	$style = str_replace( array( '::before', '::after' ), array( ':before', ':after' ), $style );
	$style = preg_replace( '/\s+/', ' ', $style );
	$style = preg_replace( '/;(?=\s*})/', '', $style );
	$style = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $style );
	$style = preg_replace( '/ (,|;|\{|})/', '$1', $style );
	$style = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $style );
	$style = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $style );
	$style = preg_replace( '/\/\*[^\/]*\*\//', '', $style );
	$style = str_replace( array( '}100%{', ',100%{', ' !important', ' >' ), array( '}to{', ',to{', '!important', '>' ), $style );

	// Trim
	$style = trim( $style );
	return $style;
}

if ( ! function_exists( 'riode_escaped' ) ) {
	function riode_escaped( $html_escaped ) {
		return $html_escaped;
	}
}

if ( ! function_exists( 'riode_get_page_layout' ) ) {
	function riode_get_page_layout() {
		$type = get_post_type();
		if ( ! $type ) {
			$type = 'post';
		}
		if ( apply_filters( 'riode_is_vendor_store', false ) ) {
			return 'page';
		}
		if ( is_404() ) {
			return 'error';
		} elseif ( is_home() || is_archive() || is_search() ) { // Blog or post_type archive Page
			if ( riode_is_shop() ) {
				return 'product_archive';
			} elseif ( 'post' == $type || 'attachment' == $type ) {
				return 'post_archive';
			}
			return $type . '_archive';
		} elseif ( is_page() || 'riode_template' == get_post_type() ) { // Page
			return 'page';
		} elseif ( is_single() ) {
			if ( riode_is_product() ) { // Single Product Page
				return 'product_single';
			} elseif ( 'post' == $type || 'attachment' == $type ) { // Single Post or single post_type Page
				return 'post_single';
			}

			return $type . '_single';
		}

		return '';
	}
}

function riode_merge_conditions( $higher, $inherit ) {
	if ( empty( $higher ) ) {
		$higher = array();
	}
	if ( is_array( $inherit ) ) {
		foreach ( $inherit as $part => $options ) {
			if ( ! isset( $higher[ $part ] ) ) {
				$higher[ $part ] = $options;
			} else {
				if ( 'general' != $part && ( ! isset( $higher[ $part ]['id'] ) || '' == $higher[ $part ]['id'] || ( $higher[ $part ]['id'] > 0 && is_numeric( $higher[ $part ]['id'] ) && 'publish' != get_post_status( $higher[ $part ]['id'] ) ) ) && '' != $inherit[ $part ]['id'] ) {
					$higher[ $part ] = $inherit[ $part ];
				}
			}
		}
	}
	return $higher;
}

function riode_get_template_layout_options( $template_type, $id, $conditions, $layouts = array() ) {
	$layout    = array( 'slug' => $id . '_layout' );
	$post_type = get_post_type();
	if ( ! $post_type ) {
		$post_type = 'post';
	}
	$merged_ids = array();

	if ( 'error' == $id ) {
		// error page
		if ( isset( $conditions['error'] ) ) {
			if ( 'layout' != $template_type ) {
				return $conditions['error'];
			}

			if ( isset( $layouts[ $conditions['error'] ] ) ) {
				$layout       = riode_merge_conditions( $layout, $layouts[ $conditions['error'] ]['content'] );
				$merged_ids[] = $conditions['error'];
			}
		}

		// in all pages
		if ( isset( $conditions['page'] ) && isset( $conditions['page']['all'] ) ) {
			if ( 'layout' != $template_type ) {
				return $conditions['page']['all'];
			}

			if ( ! in_array( $layouts[ $conditions['page']['all'] ], $merged_ids ) && isset( $layouts[ $conditions['page']['all'] ] ) ) {
				$layout       = riode_merge_conditions( $layout, $layouts[ $conditions['page']['all'] ]['content'] );
				$merged_ids[] = $conditions['page']['all'];
			}
		}
	} elseif ( 'page' == $id ) {
		$post_id = get_the_ID();

		// individual condition
		if ( isset( $conditions['page'] ) && isset( $conditions['page']['individual'] ) && isset( $conditions['page']['individual'][ $post_id ] ) ) {
			if ( 'layout' != $template_type ) {
				return $conditions['page']['individual'][ $post_id ];
			}
			if ( isset( $layouts[ $conditions['page']['individual'][ $post_id ] ] ) ) {
				$layout       = riode_merge_conditions( $layout, $layouts[ $conditions['page']['individual'][ $post_id ] ]['content'] );
				$merged_ids[] = $conditions['page']['individual'][ $post_id ];
			}
		}

		// in all pages
		if ( isset( $conditions['page'] ) && isset( $conditions['page']['all'] ) ) {
			if ( 'layout' != $template_type ) {
				return $conditions['page']['all'];
			}
			if ( ! in_array( $conditions['page']['all'], $merged_ids ) && isset( $layouts[ $conditions['page']['all'] ] ) ) {
				$layout       = riode_merge_conditions( $layout, $layouts[ $conditions['page']['all'] ]['content'] );
				$merged_ids[] = $conditions['page']['all'];
			}
		}
	} elseif ( 'archive' == substr( $id, -7 ) ) {
		$post_type = substr( $id, 0, -8 );

		if ( get_queried_object() && property_exists( get_queried_object(), 'term_id' ) ) {
			$term_id  = get_queried_object()->term_id;
			$taxonomy = get_queried_object()->taxonomy;

			// individual term archive
			if ( isset( $conditions[ $post_type . '_archive' ] ) && isset( $conditions[ $post_type . '_archive' ][ $taxonomy ] ) && isset( $conditions[ $post_type . '_archive' ][ $taxonomy ][ $term_id ] ) ) {
				if ( 'layout' != $template_type ) {
					return $conditions[ $post_type . '_archive' ][ $taxonomy ][ $term_id ];
				}
				if ( isset( $layouts[ $conditions[ $post_type . '_archive' ][ $taxonomy ][ $term_id ] ] ) ) {
					$layout       = riode_merge_conditions( $layout, $layouts[ $conditions[ $post_type . '_archive' ][ $taxonomy ][ $term_id ] ]['content'] );
					$merged_ids[] = $conditions[ $post_type . '_archive' ][ $taxonomy ][ $term_id ];
				}
			}

			// in all taxonomy's term archive
			if ( isset( $conditions[ $post_type . '_archive' ] ) && isset( $conditions[ $post_type . '_archive' ][ $taxonomy ] ) && isset( $conditions[ $post_type . '_archive' ][ $taxonomy ]['all'] ) ) {
				if ( 'layout' != $template_type ) {
					return $conditions[ $post_type . '_archive' ][ $taxonomy ]['all'];
				}
				if ( ! in_array( $conditions[ $post_type . '_archive' ][ $taxonomy ]['all'], $merged_ids ) && isset( $layouts[ $conditions[ $post_type . '_archive' ][ $taxonomy ]['all'] ] ) ) {
					$layout       = riode_merge_conditions( $layout, $layouts[ $conditions[ $post_type . '_archive' ][ $taxonomy ]['all'] ]['content'] );
					$merged_ids[] = $conditions[ $post_type . '_archive' ][ $taxonomy ]['all'];
				}
			}
		} elseif ( class_exists( 'WooCommerce' ) && is_shop() ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( isset( $conditions['page'] ) && isset( $conditions['page']['individual'] ) && isset( $conditions['page']['individual'][ $shop_id ] ) ) {
				if ( 'layout' != $template_type ) {
					return $conditions['page']['individual'][ $shop_id ];
				}
				if ( ! in_array( $conditions['page']['individual'][ $shop_id ], $merged_ids ) && isset( $layouts[ $conditions['page']['individual'][ $shop_id ] ] ) ) {
					$layout       = riode_merge_conditions( $layout, $layouts[ $conditions['page']['individual'][ $shop_id ] ]['content'] );
					$merged_ids[] = $conditions['page']['individual'][ $shop_id ];
				}
			}
		}

		// in all {post_type}_archive pages
		if ( isset( $conditions[ $post_type . '_archive' ] ) && isset( $conditions[ $post_type . '_archive' ]['all'] ) ) {
			if ( 'layout' != $template_type ) {
				return $conditions[ $post_type . '_archive' ]['all'];
			}
			if ( ! in_array( $conditions[ $post_type . '_archive' ]['all'], $merged_ids ) && isset( $layouts[ $conditions[ $post_type . '_archive' ]['all'] ] ) ) {
				$layout       = riode_merge_conditions( $layout, $layouts[ $conditions[ $post_type . '_archive' ]['all'] ]['content'] );
				$merged_ids[] = $conditions[ $post_type . '_archive' ]['all'];
			}
		}
	} elseif ( 'single' == substr( $id, -6 ) ) {
		$post_id = get_the_ID();

		// individual condition
		if ( isset( $conditions[ $post_type . '_single' ] ) && isset( $conditions[ $post_type . '_single' ]['individual'] ) && isset( $conditions[ $post_type . '_single' ]['individual'][ $post_id ] ) ) {
			if ( 'layout' != $template_type ) {
				return $conditions[ $post_type . '_single' ]['individual'][ $post_id ];
			}
			if ( isset( $layouts[ $conditions[ $post_type . '_single' ]['individual'][ $post_id ] ] ) ) {
				$layout       = riode_merge_conditions( $layout, $layouts[ $conditions[ $post_type . '_single' ]['individual'][ $post_id ] ]['content'] );
				$merged_ids[] = $conditions[ $post_type . '_single' ]['individual'][ $post_id ];
			}
		}

		// in taxonomy terms
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		$taxonomies = wp_filter_object_list(
			$taxonomies,
			array(
				'public'            => true,
				'show_in_nav_menus' => true,
			)
		);
		$tax_terms  = array();
		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $tax ) {
				$terms = wp_get_post_terms( get_the_ID(), $tax->name, array( 'fields' => 'ids' ) );
				if ( ! empty( $terms ) ) {
					foreach ( $terms as $term ) {
						$tax_terms[ $term ] = $tax->name;
					}
				}
			}
		}
		foreach ( $tax_terms as $term_id => $taxonomy ) {
			if ( isset( $conditions[ $post_type . '_single' ] ) && isset( $conditions[ $post_type . '_single' ][ $taxonomy ] ) && isset( $conditions[ $post_type . '_single' ][ $taxonomy ][ $term_id ] ) ) {
				if ( 'layout' != $template_type ) {
					return $conditions[ $post_type . '_single' ][ $taxonomy ][ $term_id ];
				}
				if ( ! in_array( $conditions[ $post_type . '_single' ][ $taxonomy ][ $term_id ], $merged_ids ) && isset( $layouts[ $conditions[ $post_type . '_single' ][ $taxonomy ][ $term_id ] ] ) ) {
					$layout       = riode_merge_conditions( $layout, $layouts[ $conditions[ $post_type . '_single' ][ $taxonomy ][ $term_id ] ]['content'] );
					$merged_ids[] = $conditions[ $post_type . '_single' ][ $taxonomy ][ $term_id ];
				}
			}
		}

		// in all {post_type}_single pages
		if ( isset( $conditions[ $post_type . '_single' ] ) && isset( $conditions[ $post_type . '_single' ]['all'] ) ) {
			if ( 'layout' != $template_type ) {
				return $conditions[ $post_type . '_single' ]['all'];
			}
			if ( ! in_array( $conditions[ $post_type . '_single' ]['all'], $merged_ids ) && isset( $layouts[ $conditions[ $post_type . '_single' ]['all'] ] ) ) {
				$layout       = riode_merge_conditions( $layout, $layouts[ $conditions[ $post_type . '_single' ]['all'] ]['content'] );
				$merged_ids[] = $conditions[ $post_type . '_single' ]['all'];
			}
		}
	}

	// merge with global layout
	if ( 'layout' != $template_type ) {
		if ( isset( $conditions['entire'] ) ) {
			return $conditions['entire'];
		}
		return false;
	}

	$layout = riode_merge_conditions( $layout, $layouts['global-layout']['content'] );

	// Get page title and subtitle for titlebar
	$title    = '';
	$subtitle = '';

	if ( get_queried_object() && property_exists( get_queried_object(), 'term_id' ) ) {
		$term_id  = get_queried_object()->term_id;
		$taxonomy = get_queried_object()->taxonomy;

		$title = get_term_field( 'name', $term_id, $taxonomy );
	}

	if ( 'product_archive' == $id ) {
		if ( $title ) {
			$subtitle = sanitize_text_field( get_the_title( wc_get_page_id( 'shop' ) ) );
		} else {
			$title = sanitize_text_field( get_the_title( wc_get_page_id( 'shop' ) ) );
		}
	} elseif ( is_home() || 'post_archive' == $id ) {
		if ( $title ) {
			$subtitle = apply_filters( 'riode_blog_ptb_title', esc_html__( 'Our Blog', 'riode' ) );
		} else {
			$title = apply_filters( 'riode_blog_ptb_title', esc_html__( 'Our Blog', 'riode' ) );
		}
	} elseif ( is_404() ) {
		$title    = apply_filters( 'riode_404_ptb_title', 'Error 404' );
		$subtitle = '';
	} elseif ( defined( 'DOKAN_PLUGIN_VERSION' ) && dokan_is_store_page() ) {
		$store_user = dokan()->vendor->get( get_query_var( 'author' ) );
		if ( $store_user ) {
			$title = esc_html( $store_user->get_shop_name() );
		}
	} else {
		$title     = sanitize_text_field( get_the_title() );
		$parent_id = wp_get_post_parent_id( get_the_ID() );
		if ( $parent_id ) {
			$subtitle = get_the_title( $parent_id );
		}
	}

	if ( empty( $layout['ptb']['title'] ) ) {
		$layout['ptb']['title'] = $title;
	}
	if ( empty( $layout['ptb']['subtitle'] ) ) {
		$layout['ptb']['subtitle'] = $subtitle;
	}

	// Global Option
	$global_layouts = riode_get_option( 'page_layouts' );
	if ( isset( $global_layouts['global-layout']['content'] ) ) {
		$global_layouts = $global_layouts['global-layout']['content'];
	}
	if ( isset( $global_layouts['general']['wrap'] ) && ! empty( $layout['general']['wrap'] ) && 'default' == $layout['general']['wrap'] ) {
		$layout['general']['wrap'] = $global_layouts['general']['wrap'];
	}
	if ( isset( $global_layouts['general']['reading_progress'] ) && ( empty( $layout['general']['reading_progress'] ) || 'default' == $layout['general']['reading_progress'] ) ) {
		$layout['general']['reading_progress'] = $global_layouts['general']['reading_progress'];
	}
	return $layout;
}

function riode_get_layout( $layout_id = '' ) {
	$meta = array();

	$id = riode_get_page_layout();

	// get page layout
	$layout = riode_get_template_layout_options( 'layout', $id, riode_get_option( 'layout_conditions' ), riode_get_option( 'page_layouts' ) );

	// get more content options
	$layout['content'] = array();

	// popup builder
	$layout['content']['popup'] = riode_get_template_layout_options( 'popup', $id, riode_get_option( 'popup_conditions' ) );

	if ( 'product_single' == $id ) { // single product builder
		$layout['content']['single_product_template'] = riode_get_template_layout_options( 'product_layout', 'product_single', riode_get_option( 'product_layout_conditions' ) );

		if ( false === $layout['content']['single_product_template'] ) {
			$layout['content']['single_product_template'] = riode_get_option( 'single_product_type' );
		}
	}

	return $layout;
}

function riode_get_taxonomies( $content_type = 'post' ) {
	$args       = array(
		'object_type' => array( $content_type ),
	);
	$output     = 'names'; // or objects
	$operator   = 'and'; // 'and' or 'or'
	$taxonomies = get_taxonomies( $args, $output, $operator );
	return $taxonomies;
}

function riode_is_shop() {
	if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_category() || is_product_tag() || ( is_search() && isset( $_POST['post_type'] ) && 'product' == $_POST['post_type'] ) ) ) { // Shop Page
		return 'shop';
	} else {
		$term = get_queried_object();
		if ( class_exists( 'WooCommerce' ) && $term && isset( $term->taxonomy ) && in_array( $term->taxonomy, riode_get_taxonomies( 'product' ) ) ) {
			return 'shop';
		}
	}

	return apply_filters( 'riode_is_shop', false );
}

function riode_is_product() {
	if ( class_exists( 'WooCommerce' ) && is_product() ) {
		return true;
	}
	return apply_filters( 'riode_is_product', false );
}

function riode_wc_set_loop_prop() {
	// Category Props //////////////////////////////////////////////////////////////////////////////
	$cat_options = array(
		''             => array(
			'link'  => '',
			'count' => '',
		),
		'badge'        => array(
			'link'  => 'yes',
			'count' => '',
		),
		'banner'       => array(
			'link'  => 'yes',
			'count' => 'yes',
		),
		'label'        => array(
			'link'  => '',
			'count' => '',
		),
		'icon'         => array(
			'link'  => '',
			'count' => '',
		),
		'classic'      => array(
			'link'  => '',
			'count' => 'yes',
		),
		'ellipse'      => array(
			'link'  => '',
			'count' => 'yes',
		),
		'ellipse-2'    => array(
			'link'  => '',
			'count' => '',
		),
		'icon-overlay' => array(
			'link'  => '',
			'count' => 'yes',
		),
		'group'        => array(
			'link'  => '',
			'count' => '',
		),
		'group-2'      => array(
			'link'  => '',
			'count' => '',
		),
		'center'       => array(
			'link'  => '',
			'count' => '',
		),
	);
	wc_set_loop_prop( 'category_type', riode_get_option( 'category_type' ) );
	wc_set_loop_prop( 'subcat_cnt', riode_get_option( 'category_subcat_cnt' ) );
	wc_set_loop_prop( 'show_icon', riode_get_option( 'category_show_icon' ) );
	wc_set_loop_prop( 'overlay', riode_get_option( 'category_overlay' ) );
	wc_set_loop_prop( 'default_width_auto', riode_get_option( 'category_default_w_auto' ) );

	if ( ! $cat_options[ riode_get_option( 'category_type' ) ]['count'] ) {
		wc_set_loop_prop( 'show_count', false );
	} else {
		wc_set_loop_prop( 'show_count', true );
	}

	if ( ! $cat_options[ riode_get_option( 'category_type' ) ]['link'] ) {
		wc_set_loop_prop( 'show_link', false );
	} else {
		wc_set_loop_prop( 'show_link', true );
	}

	// Product Props ///////////////////////////////////////////////////////////////////////////////
	wc_set_loop_prop( 'product_type', riode_get_option( 'product_type' ) );
	wc_set_loop_prop( 'show_in_box', riode_get_option( 'product_show_in_box' ) ? 'yes' : 'no' );
	wc_set_loop_prop( 'show_media_shadow', riode_get_option( 'product_show_media_shadow' ) ? 'yes' : 'no' );
	wc_set_loop_prop( 'show_hover_shadow', riode_get_option( 'product_show_hover_shadow' ) ? 'yes' : 'no' );
	wc_set_loop_prop( 'content_align', riode_get_option( 'product_content_align' ) );
	wc_set_loop_prop( 'addtocart_pos', riode_get_option( 'product_addtocart_pos' ) );
	wc_set_loop_prop( 'wishlist_pos', riode_get_option( 'product_wishlist_pos' ) );
	wc_set_loop_prop( 'quickview_pos', riode_get_option( 'product_quickview_pos' ) );
	wc_set_loop_prop( 'hover_change', riode_get_option( 'product_hover_change' ) );
	wc_set_loop_prop( 'classic_hover', riode_get_option( 'product_classic_hover' ) );
	wc_set_loop_prop( 'show_reviews_text', riode_get_option( 'product_show_reviews_text' ) );
	if ( false == wc_get_loop_prop( 'split-line', false ) ) {
		wc_set_loop_prop( 'split-line', riode_get_option( 'product_split_line' ) );
	}

	if ( riode_is_shop() || riode_is_product() ) {
		wc_set_loop_prop( 'show_labels', array( 'top', 'sale', 'new', 'stock', 'custom' ) );
	}

	$info = riode_get_option( 'product_show_info' );

	if ( ! wc_get_loop_prop( 'widget', false ) && riode_get_option( 'simple_shop' ) ) {
		$info = array_filter(
			$info,
			function( $i ) {
				return ! in_array( $i, array( 'category', 'rating', 'attribute' ) );
			}
		);

		wc_set_loop_prop( 'product_type', '' );
		wc_set_loop_prop( 'addtocart_pos', '' );
		wc_set_loop_prop( 'wishlist_pos', '' );
		wc_set_loop_prop( 'quickview_pos', 'bottom' );
		wc_set_loop_prop( 'content_align', 'center' );
	}

	wc_set_loop_prop( 'show_info', $info );
}

/**
 * riode_wc_show_info_for_role
 *
 * checks if current user can see product info item
 *
 * @since 1.0.1
 */
if ( ! function_exists( 'riode_wc_show_info_for_role' ) ) {
	function riode_wc_show_info_for_role( $item ) {
		$show_info = wc_get_loop_prop( 'show_info', false );

		if ( is_array( $show_info ) && ! in_array( $item, $show_info ) ) { // if item is not in show_info list, return false
			return false;
		}

		if ( ! riode_get_option( 'change_product_info_role' ) ) { // if different role option is not enabled, return true
			return true;
		}

		$access_roles  = riode_get_option( 'product_role_info_' . $item );
		$current_roles = wp_get_current_user()->roles;
		if ( empty( $current_roles ) ) {
			$current_roles[] = 'visitor';
		}

		foreach ( $current_roles as $role ) {
			if ( in_array( $role, $access_roles ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'riode_print_mobile_bar' ) ) {
	function riode_print_mobile_bar() {
		$mobile_bar = riode_get_option( 'mobile_bar_icons' );
		$result     = '';
		$cnt        = 0;

		foreach ( $mobile_bar as $item ) {
			$icon  = riode_get_option( 'mobile_bar_' . $item . '_icon' );
			$label = riode_get_option( 'mobile_bar_' . $item . '_label' );

			if ( 'menu' == $item ) {
				if ( riode_get_option( 'mobile_menu_items' ) ) {
					$result .= '<a href="#" class="mobile-menu-toggle mobile-item"><i class="' . $icon . '"></i><span>' . $label . '</span></a>';
					$cnt ++;
				}
			} elseif ( 'home' == $item ) {
				$result .= '<a href="' . esc_url( home_url() ) . '" class="mobile-item' . ( is_front_page() ? ' active' : '' ) . '"><i class="' . $icon . '"></i><span>' . $label . '</span></a>';
				$cnt ++;
			} elseif ( 'shop' == $item && class_exists( 'WooCommerce' ) ) {
				$result .= '<a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="mobile-item"><i class="' . $icon . '"></i><span>' . $label . '</span></a>';
				$cnt ++;
			} elseif ( 'wishlist' == $item && class_exists( 'WooCommerce' ) && defined( 'YITH_WCWL' ) ) {
				$result .= '<a href="' . esc_url( YITH_WCWL()->get_wishlist_url() ) . '" class="mobile-item"><i class="' . $icon . '"></i><span>' . $label . '</span></a>';
				$cnt ++;
			} elseif ( 'compare' == $item && class_exists( 'WooCommerce' ) && riode_get_option( 'product_compare' ) ) {
				$result .= '<a href="#" class="mobile-item compare-open"><i class="' . $icon . '"></i><span>' . $label . '</span></a>';
				$cnt ++;
			} elseif ( 'account' == $item && class_exists( 'WooCommerce' ) ) {
				$result .= '<a href="' . esc_url( wc_get_page_permalink( 'myaccount' ) ) . '" class="mobile-item"><i class="' . $icon . '"></i><span>' . $label . '</span></a>';
				$cnt ++;
			} elseif ( 'cart' == $item && class_exists( 'WooCommerce' ) ) {
				ob_start();
				?>

				<div class="dropdown cart-dropdown dir-up mini-basket-dropdown">
					<a class="cart-toggle mobile-item" href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>">
						<i class="<?php echo esc_attr( $icon ); ?>"></i>
						<span><?php echo esc_html( $label ); ?></span>
					</a>

					<div class="cart-popup widget_shopping_cart dropdown-box">
						<div class="widget_shopping_cart_content">
							<div class="cart-loading"></div>
						</div>
					</div>
				</div>

				<?php
				$result .= ob_get_clean();
				$cnt ++;
			} elseif ( 'search' == $item ) {
				ob_start();
				?>
				<div class="search-wrapper hs-toggle rect">
					<a href="#" class="search-toggle mobile-item"><i class="<?php echo esc_attr( $icon ); ?>"></i><span><?php echo esc_html( $label ); ?></span></a>
					<form action="<?php echo esc_url( home_url() ); ?>/" method="get" class="input-wrapper">
						<input type="hidden" name="post_type" value="<?php echo esc_attr( class_exists( 'WooCommerce' ) ? 'product' : 'post' ); ?>"/>
						<input type="search" class="form-control" name="s" placeholder="<?php esc_attr_e( 'Search your keywords...', 'riode' ); ?>" required="" autocomplete="off">

						<?php if ( riode_get_option( 'live_search' ) ) : ?>
							<div class="live-search-list"></div>
						<?php endif; ?>

						<button class="btn btn-search" type="submit">
							<i class="d-icon-search"></i>
						</button> 
					</form>
				</div>
				<?php
				$result .= ob_get_clean();
				$cnt ++;
			} elseif ( 'top' == $item ) {
				$result .= '<a href="#" class="mobile-item scroll-top"><i class="' . $icon . '"></i><span>' . $label . '</span></a>';
				$cnt ++;
			} else {
				$result .= '<a href="#" class="mobile-item"><i class="' . $icon . '"></i><span>' . $label . '</span></a>';
				$cnt ++;
			}
		}

		if ( $result ) {
			echo '<div class="mobile-icon-bar sticky-content fix-bottom items-' . $cnt . '">' . $result . '</div>';
		}
	}
}

/**
 * Print Riode Block
 */
function riode_print_template( $block_name ) {
	if ( $block_name && defined( 'RIODE_CORE_PATH' ) ) {
		$atts = array( 'name' => $block_name );
		include RIODE_CORE_PATH . '/elementor/render/widget-block-render.php';
	}
}

/**
 * Check Used Blocks
 */
if ( ! function_exists( 'riode_get_page_blocks' ) ) :
	function riode_get_page_blocks() {
		$used_blocks = array();

		// sidebar blocks
		$sidebar_blocks = get_theme_mod( '_riode_blocks_sidebar', array() );
		if ( ! empty( $sidebar_blocks ) ) {
			if ( riode_get_layout_value( 'left_sidebar', 'id' ) && isset( $sidebar_blocks[ riode_get_layout_value( 'left_sidebar', 'id' ) ] ) ) {
				$used_blocks = array_merge( $used_blocks, $sidebar_blocks[ riode_get_layout_value( 'left_sidebar', 'id' ) ] );
			}
			if ( riode_get_layout_value( 'right_sidebar', 'id' ) && isset( $sidebar_blocks[ riode_get_layout_value( 'right_sidebar', 'id' ) ] ) ) {
				$used_blocks = array_merge( $used_blocks, $sidebar_blocks[ riode_get_layout_value( 'right_sidebar', 'id' ) ] );
			}
			if ( riode_get_layout_value( 'top_sidebar', 'id' ) && isset( $sidebar_blocks[ riode_get_layout_value( 'top_sidebar', 'id' ) ] ) ) {
				$used_blocks = array_merge( $used_blocks, $sidebar_blocks[ riode_get_layout_value( 'top_sidebar', 'id' ) ] );
			}
		}

		// meta-box blocks
		$meta_blocks = array();
		$fields      = array( 'top_block', 'inner_top_block', 'inner_bottom_block', 'bottom_block' );
		foreach ( $fields as $field ) {
			if ( riode_get_layout_value( $field, 'id' ) ) {
				$meta_blocks[] = riode_get_layout_value( $field, 'id' );
			}
		}

		// using PTB block?
		if ( riode_get_layout_value( 'ptb', 'id' ) && ( riode_get_layout_value( 'ptb', 'title' ) || riode_get_layout_value( 'ptb', 'subtitle' ) ) ) {
			$meta_blocks[] = riode_get_layout_value( 'ptb', 'id' );
		}

		// single product layout builder
		if ( riode_is_product() && is_numeric( riode_get_layout_value( 'content', 'single_product_template' ) ) ) {
			$meta_blocks[] = riode_get_layout_value( 'content', 'single_product_template' );
		}

		// header builder
		if ( 'riode_template' != get_post_type() || 'header' != get_post_meta( get_the_ID(), 'riode_template_type', true ) ) {
			if ( riode_get_layout_value( 'header', 'id' ) && -1 != riode_get_layout_value( 'header', 'id' ) ) {
				$meta_blocks[] = riode_get_layout_value( 'header', 'id' );
			}
		}

		// footer builder
		if ( ( 'riode_template' != get_post_type() || 'footer' != get_post_meta( get_the_ID(), 'riode_template_type', true ) ) &&
			 ( riode_get_layout_value( 'footer', 'id' ) && -1 != riode_get_layout_value( 'footer', 'id' ) ) ) {
			$meta_blocks[] = riode_get_layout_value( 'footer', 'id' );
		} else {
			foreach ( $sidebar_blocks as $sidebar_id => $block_ids ) {
				if ( ! empty( $block_ids ) && ( 0 === strpos( $sidebar_id, 'footer-' ) ) ) {
					$used_blocks = array_merge( $used_blocks, $block_ids );
				}
			}
		}

		// popup container
		if ( riode_get_layout_value( 'general', 'popup' ) ) {
			$meta_blocks[] = riode_get_layout_value( 'general', 'popup' );
		}

		if ( ! empty( $meta_blocks ) && is_array( $meta_blocks ) ) {
			$used_blocks = array_merge( $used_blocks, $meta_blocks );
		}
		return array_fill_keys(
			array_unique( $used_blocks, SORT_NUMERIC ),
			array(
				'css' => false,
				'js'  => false,
			)
		);
	}
endif;

function riode_page_wrapper_attrs() {
	$atts = '';
	if ( riode_get_layout_value( 'general', 'left_fixed' ) ) {
		$atts = ' data-left-fixed="' . str_replace( ' ', '', riode_get_layout_value( 'general', 'left_fixed' ) ) . '"';
	}
	if ( riode_get_layout_value( 'general', 'right_fixed' ) ) {
		$atts = ' data-right-fixed="' . str_replace( ' ', '', riode_get_layout_value( 'general', 'right_fixed' ) ) . '"';
	}

	return apply_filters( 'riode_page_wrapper_attrs', $atts );
}

if ( ! function_exists( 'riode_print_popup_template' ) ) {
	function riode_print_popup_template( $popup_id, $popup_on, $popup_within ) {
		if ( ! shortcode_exists( 'vc_row' ) && class_exists( 'WPBMap' ) && method_exists( 'WPBMap', 'addAllMappedShortcodes' ) ) {
			WPBMap::addAllMappedShortcodes();
		}

		$popup_options = get_post_meta( $popup_id, 'popup_options', true );
		if ( $popup_options ) {
			$popup_options = json_decode( $popup_options, true );
		} else {
			return;
		}
		$wrapper_cls = $popup_options['transform'];
		if ( ! empty( $popup_options['wrapper_class'] ) ) {
			$wrapper_cls .= ( ' ' . $popup_options['wrapper_class'] );
		}

		$style  = 'display: none;';
		$style .= ' max-width: ' . (int) $popup_options['width'] . 'px;';
		$style .= ' left:' . esc_attr( $popup_options['left'] ) . ';';
		$style .= ' top:' . esc_attr( $popup_options['top'] ) . ';';
		$style .= ' right:' . esc_attr( $popup_options['right'] ) . ';';
		$style .= ' bottom:' . esc_attr( $popup_options['bottom'] ) . ';';

		echo '<div class="popup p-absolute ' . $wrapper_cls . '" data-popup-options=' . "'" . json_encode(
			array(
				'popup_on'        => $popup_on,
				'popup_within'    => $popup_within,
				'popup_animation' => $popup_options['animation'],
				'popup_duration'  => $popup_options['anim_duration'] . 'ms',
			)
		) . "'" . ' style="' . $style . '">';

		riode_print_template( $popup_id );
		echo '</div>';
	}
}


/**
 * function riode_the_content
 *
 * returns post content through various filters
 *
 * @since 1.0.1
 */
if ( ! function_exists( 'riode_the_content' ) ) {
	function riode_the_content( $content = null, $echo = true ) {
		if ( null == $content || '' == $content ) {
			$content = get_the_content();
		}
		if ( function_exists( 'has_blocks' ) && has_blocks( $content ) ) {
			$result = do_shortcode( do_blocks( $content ) );
		} else {
			$result = do_shortcode( $content );
		}
		if ( ! $echo ) {
			return $result;
		}
		echo riode_escaped( $result );
	}
}

/**
 * Is WPBakery Preview?
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_is_wpb_preview' ) ) {
	function riode_is_wpb_preview() {
		if ( defined( 'WPB_VC_VERSION' ) ) {
			if ( riode_is_wpb_backend() || vc_is_inline() ) {
				return true;
			}
		}
		return false;
	}
}

/**
 * Is in WPBakery Backend Editor?
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_is_wpb_backend' ) ) {
	function riode_is_wpb_backend() {
		if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && ( 'post.php' == $GLOBALS['pagenow'] || 'post-new.php' == $GLOBALS['pagenow'] ) && defined( 'WPB_VC_VERSION' ) ) {
			return true;
		}
		return false;
	}
}

/**
 * Riode WPB Global HashCode
 *
 * Generate hash code from attribues
 *
 * @param array $params
 *
 * @return string
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_get_global_hashcode' ) ) {
	function riode_get_global_hashcode( $atts, $tag, $params ) {
		$result = '';
		if ( is_array( $atts ) ) {
			$callback = function( $item, $key ) use ( $params ) {
				foreach ( $params as $param ) {
					if ( $param['param_name'] == $key && ! empty( $param['selectors'] ) ) {
						return true;
					}
				}
				return false;
			};
			if ( 'wpb_riode_masonry' != $tag ) {
				$atts = array_filter(
					$atts,
					$callback,
					ARRAY_FILTER_USE_BOTH
				);
			}
			$keys   = array_keys( $atts );
			$values = array_values( $atts );
			$hash   = $tag . implode( '', $keys ) . implode( '', $values );
			if ( 0 == strlen( $hash ) ) {
				return '0';
			}
			return hash( 'md5', $hash );
		}
		return '0';
	}
}

/**
 * Compile WPBakery Shortcodes
 *
 * @param array $wpb_shortcodes_to_remove
 *
 * @return void
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_wpb_shortcode_compile_css ' ) ) {
	function riode_wpb_shortcode_compile_css( $wpb_shortcodes_to_remove ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$upload_dir = wp_upload_dir();
		$style_path = $upload_dir['basedir'] . '/riode_styles';
		if ( ! file_exists( $style_path ) ) {
			wp_mkdir_p( $style_path );
		}

		// filesystem
		global $wp_filesystem;
		// Initialize the WordPress filesystem, no more using file_put_contents function
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$is_success = false;

		ob_start();
		include RIODE_PATH . '/inc/compatibilities/wpb/front.less.php';
		$_config_css = ob_get_clean();

		// compile visual composer css file
		if ( ! class_exists( 'lessc' ) ) {
			require_once RIODE_INC . '/plugins/lessphp/lessc.inc.php';
		}
		ob_start();
		$less = new lessc();
		$less->setFormatter( 'compressed' );
		try {
			$less->setImportDir( ABSPATH . 'wp-content/plugins/js_composer/assets/less/lib' );
			echo '' . $less->compile( '@import "../config/variables.less";' . $_config_css );
			$_config_css = ob_get_clean();

			$filename = $style_path . '/js_composer.css';
			riode_check_file_write_permission( $filename );

			$wp_filesystem->put_contents( $filename, $_config_css, FS_CHMOD_FILE );
		} catch ( Exception $e ) {
		}
	}
}


if ( ! function_exists( 'riode_check_file_write_permission' ) ) {
	function riode_check_file_write_permission( $filename ) {
		if ( is_writable( dirname( $filename ) ) == false ) {
			@chmod( dirname( $filename ), 0755 );
		}
		if ( file_exists( $filename ) ) {
			if ( is_writable( $filename ) == false ) {
				@chmod( $filename, 0755 );
			}
			@unlink( $filename );
		}
	}
}

/**
 * Get Value of Current Page Layout
 *
 * @since 1.4.0
 */
function riode_get_layout_value( ...$args ) {
	global $riode_layout;

	if ( ! isset( $riode_layout ) ) {
		$riode_layout                = riode_get_layout();
		$riode_layout['used_blocks'] = riode_get_page_blocks();
	}

	if ( empty( $args ) ) {
		return $riode_layout;
	}

	$layout = $riode_layout;
	foreach ( $args as $arg ) {
		if ( isset( $layout[ $arg ] ) ) {
			$layout = $layout[ $arg ];
		} else {
			return false;
		}
	}

	return $layout;
}

/**
 * Get current time
 *
 * @since 1.4.0
 */
function riode_get_time() {
	global $riode_time;

	return $riode_time;
}

/**
 * Set current time
 *
 * @since 1.4.0
 */
function riode_set_time() {
	global $riode_time;

	$riode_time = microtime( true );
}

/**
 * Get duration from old registered time to current time
 *
 * @since 1.4.0
 */
function riode_get_duration() {
	global $riode_time;

	$duration   = ( microtime( true ) - $riode_time ) * 1000;
	$riode_time = microtime( true );

	return $duration;
}
