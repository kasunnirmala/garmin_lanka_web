<?php

/**
 * Define functions using in Riode Core Plugin
 */

if ( ! function_exists( 'riode_strip_script_tags' ) ) :
	function riode_strip_script_tags( $content ) {
		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = preg_replace( '/<script.*?\/script>/s', '', $content ) ? : $content;
		$content = preg_replace( '/<style.*?\/style>/s', '', $content ) ? : $content;
		return $content;
	}
endif;

function riode_creative_preset() {
	return array(
		1  => RIODE_CORE_URI . '/assets/images/creative-grid/creative-1.jpg',
		2  => RIODE_CORE_URI . '/assets/images/creative-grid/creative-2.jpg',
		3  => RIODE_CORE_URI . '/assets/images/creative-grid/creative-3.jpg',
		4  => RIODE_CORE_URI . '/assets/images/creative-grid/creative-4.jpg',
		5  => RIODE_CORE_URI . '/assets/images/creative-grid/creative-5.jpg',
		6  => RIODE_CORE_URI . '/assets/images/creative-grid/creative-6.jpg',
		7  => RIODE_CORE_URI . '/assets/images/creative-grid/creative-7.jpg',
		8  => RIODE_CORE_URI . '/assets/images/creative-grid/creative-8.jpg',
		9  => RIODE_CORE_URI . '/assets/images/creative-grid/creative-9.jpg',
		10 => RIODE_CORE_URI . '/assets/images/creative-grid/creative-10.jpg',
		11 => RIODE_CORE_URI . '/assets/images/creative-grid/creative-11.jpg',
		12 => RIODE_CORE_URI . '/assets/images/creative-grid/creative-12.jpg',
		13 => RIODE_CORE_URI . '/assets/images/creative-grid/creative-13.jpg',
	);
}

function riode_product_grid_preset() {
	return array(
		1 => RIODE_CORE_URI . '/assets/images/products-grid/creative-1.jpg',
		2 => RIODE_CORE_URI . '/assets/images/products-grid/creative-2.jpg',
		3 => RIODE_CORE_URI . '/assets/images/products-grid/creative-3.jpg',
		4 => RIODE_CORE_URI . '/assets/images/products-grid/creative-4.jpg',
		5 => RIODE_CORE_URI . '/assets/images/products-grid/creative-5.jpg',
		6 => RIODE_CORE_URI . '/assets/images/products-grid/creative-6.jpg',
		7 => RIODE_CORE_URI . '/assets/images/products-grid/creative-7.jpg',
		8 => RIODE_CORE_URI . '/assets/images/products-grid/creative-8.jpg',
		9 => RIODE_CORE_URI . '/assets/images/products-grid/creative-9.jpg',
	);
}

function riode_post_grid_presets() {
	return array(
		1 => RIODE_CORE_URI . '/assets/images/post-creative/post-creative-1.jpg',
		2 => RIODE_CORE_URI . '/assets/images/post-creative/post-creative-2.jpg',
		3 => RIODE_CORE_URI . '/assets/images/post-creative/post-creative-3.jpg',
		4 => RIODE_CORE_URI . '/assets/images/post-creative/post-creative-4.jpg',
		5 => RIODE_CORE_URI . '/assets/images/post-creative/post-creative-5.jpg',
		6 => RIODE_CORE_URI . '/assets/images/post-creative/post-creative-6.jpg',
	);
}

/**
 * Get the exact parameters of each predefined layouts.
 *
 * @param    int    $index    The index of predefined creative layouts
 */
function riode_creative_layout( $index ) {
	$layout = array();
	if ( 1 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'large',
			),
		);
	} elseif ( 2 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	} elseif ( 3 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 4 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'large',
			),
		);
	} elseif ( 5 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-4',
				'h'    => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 6 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	} elseif ( 7 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '2-3',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-s'  => '1',
				'w-l'  => '1-3',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-s'  => '1',
				'w-l'  => '1-3',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-s'  => '1',
				'w-l'  => '1-3',
				'size' => 'medium',
			),
		);
	} elseif ( 8 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '2-3',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '2-3',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-s'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 9 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '2-3',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '2-3',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'w-s'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 10 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	} elseif ( 11 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '5-12',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '1',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '5-12',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-s'  => '1',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	} elseif ( 12 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '7-12',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '5-24',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '5-24',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '5-12',
				'h'    => '2-3',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '9-24',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
			array(
				'w'    => '5-24',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'medium',
			),
		);
	} elseif ( 13 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-2',
				'w-l'  => '1',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	}

	return apply_filters( 'riode_creative_layout_filter', $layout );
}

/**
 * Get the exact parameters of each predefined post layouts.
 *
 * @param int $index The index of predefined creative layouts
 */
function riode_post_creative_layout( $index ) {
	$layout = array();
	if ( 1 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-3',
				'h'    => '2-3',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '2-3',
				'h'    => '2-5',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '3-5',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '3-5',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'small',
			),
		);
	} elseif ( 2 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '3-5',
				'h'    => '2-3',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '2-5',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '2-5',
				'h'    => '1-2',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '3-10',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '3-10',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	} elseif ( 3 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '2-3',
				'h'    => '3-5',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '3-5',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '2-5',
				'h'    => '2-5',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '3-5',
				'h'    => '2-5',
				'w-l'  => '1-2',
				'size' => 'large',
			),
		);
	} elseif ( 4 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-3',
				'h'    => '3-5',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-1',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-4',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '3-4',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '2-5',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
		);
	} elseif ( 5 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-3',
				'h'    => '1-1',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-3',
				'h'    => '2-3',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-3',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '2-3',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'large',
			),
		);
	} elseif ( 6 === (int) $index ) {
		$layout = array(
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-4',
				'h'    => '2-3',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '2-3',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'large',
			),
			array(
				'w'    => '1-4',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'medium',
			),
			array(
				'w'    => '1-2',
				'h'    => '1-3',
				'w-l'  => '1-2',
				'size' => 'large',
			),
		);
	}
	return apply_filters( 'riode_post_creative_layout_filter', $layout );
}

function riode_creative_layout_style( $wrapper, $layout, $height = 600, $ratio = 75, $same_depth = false ) {
	if ( empty( $layout ) ) {
		return;
	}

	$height = str_replace( array( 'px', 'rem', 'em', '%', 'vh' ), '', $height );

	$deno  = array();
	$numer = array();
	$ws    = array(
		'w'    => array(),
		'w-xl' => array(),
		'w-l'  => array(),
		'w-m'  => array(),
		'w-s'  => array(),
	);
	$hs    = array(
		'h'    => array(),
		'h-xl' => array(),
		'h-l'  => array(),
		'h-m'  => array(),
		'h-s'  => array(),
	);

	global $riode_breakpoints;

	if ( $riode_breakpoints ) {
		$breakpoints = $riode_breakpoints;
	} else {
		$breakpoints = array(
			'min' => 0,
			'sm'  => 576,
			'md'  => 768,
			'lg'  => 992,
			'xl'  => 1200,
		);
	}

	echo '<style scope="">';
	foreach ( $layout as $grid_item ) {
		foreach ( $grid_item as $key => $value ) {
			if ( 'size' == $key ) {
				continue;
			}

			$num = explode( '-', $value );
			if ( isset( $num[1] ) && ! in_array( $num[1], $deno ) ) {
				$deno[] = (int) $num[1];
			}
			if ( ! in_array( $num[0], $numer ) ) {
				$numer[] = (int) $num[0];
			}

			if ( ( 'w' == $key || 'w-xl' == $key || 'w-l' == $key || 'w-m' == $key || 'w-s' == $key ) && ! in_array( $value, $ws[ $key ], true ) ) {
					$ws[ $key ][] = $value;
			}
			if ( ( 'h' == $key || 'h-xl' == $key || 'h-l' == $key || 'h-m' == $key || 'h-s' == $key ) && ! in_array( $value, $hs[ $key ], true ) ) {
				$hs[ $key ][] = $value;
			}
		}
	}
	foreach ( $ws as $key => $value ) {
		if ( empty( $value ) ) {
			continue;
		}

		if ( 'w-xl' == $key ) {
			echo '@media (max-width: ' . ( $breakpoints['xl'] - 1 ) . 'px) {';
		} elseif ( 'w-l' == $key ) {
			echo '@media (max-width: ' . ( $breakpoints['lg'] - 1 ) . 'px) {';
		} elseif ( 'w-m' == $key ) {
			echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
		} elseif ( 'w-s' == $key ) {
			echo '@media (max-width: ' . ( $breakpoints['sm'] - 1 ) . 'px) {';
		}

		foreach ( $value as $item ) {
			$opts  = explode( '-', $item );
			$width = ( ! isset( $opts[1] ) ? 100 : round( 100 * $opts[0] / $opts[1], 4 ) );
			echo esc_attr( $wrapper ) . ' .grid-item.' . $key . '-' . $item . '{flex:0 0 ' . $width . '%;width:' . $width . '%}';
		}

		if ( 'w-xl' == $key || 'w-l' == $key || 'w-m' == $key || 'w-s' == $key ) {
			echo '}';
		}
	};
	foreach ( $hs as $key => $value ) {
		if ( empty( $value ) ) {
			continue;
		}

		foreach ( $value as $item ) {
			$opts = explode( '-', $item );

			if ( isset( $opts[1] ) ) {
				$h = $height * $opts[0] / $opts[1];
			} else {
				$h = $height;
			}
			if ( 'h' == $key ) {
				echo esc_attr( $wrapper ) . ' .h-' . $item . '{height:' . round( $h, 2 ) . 'px}';
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-' . $item . '{height:' . round( $h * $ratio / 100, 2 ) . 'px}';
				echo '}';
			} elseif ( 'h-xl' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['xl'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-xl-' . $item . '{height:' . round( $h, 2 ) . 'px}';
				echo '}';
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-xl-' . $item . '{height:' . round( $h * $ratio / 100, 2 ) . 'px}';
				echo '}';
			} elseif ( 'h-l' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['lg'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-l-' . $item . '{height:' . round( $h, 2 ) . 'px}';
				echo '}';
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-l-' . $item . '{height:' . round( $h * $ratio / 100, 2 ) . 'px}';
				echo '}';
			} elseif ( 'h-m' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['md'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-m-' . $item . '{height:' . round( $h * $ratio / 100, 2 ) . 'px}';
				echo '}';
			} elseif ( 'h-s' == $key ) {
				echo '@media (max-width: ' . ( $breakpoints['sm'] - 1 ) . 'px) {';
				echo esc_attr( $wrapper ) . ' .h-s-' . $item . '{height:' . round( $h, 2 ) . 'px}';
				echo '}';
			}
		}
	};
	$lcm = 1;
	foreach ( $deno as $value ) {
		$lcm = $lcm * $value / riode_get_gcd( $lcm, $value );
	}
	$gcd = $numer[0];
	foreach ( $numer as $value ) {
		$gcd = riode_get_gcd( $gcd, $value );
	}
	$sizer = floor( 100 * $gcd / $lcm * 10000 ) / 10000;
	echo esc_attr( $wrapper ) . ( $same_depth ? '' : ' ' ) . '.grid>.grid-space{flex: 0 0 ' . ( $sizer < 0.01 ? 100 : $sizer ) . '%;width:' . ( $sizer < 0.01 ? 100 : $sizer ) . '%}';
	echo '</style>';
}

function riode_get_gcd( $a, $b ) {
	while ( $b ) {
		$r = $a % $b;
		$a = $b;
		$b = $r;
	}
	return $a;
}

add_filter(
	'riode_core_filter_doing_ajax',
	function() {
		// check ajax doing on others
		return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && mb_strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) ? true : false;
	}
);

/**
 * Is Elementor Preview?
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'riode_is_elementor_preview' ) ) {
	function riode_is_elementor_preview() {
		return defined( 'ELEMENTOR_VERSION' ) && (
				( isset( $_REQUEST['action'] ) && ( 'elementor' == $_REQUEST['action'] || 'elementor_ajax' == $_REQUEST['action'] ) ) ||
				isset( $_REQUEST['elementor-preview'] )
			);
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
 * Is Page Builder Preview?
 *
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_is_preview' ) ) {
	function riode_is_preview() {
		return riode_is_elementor_preview() || riode_is_wpb_preview();
	}
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

if ( ! function_exists( 'riode_get_slider_class' ) ) {
	function riode_get_slider_class( $settings = array() ) {

		function_exists( 'riode_add_async_script' ) ? riode_add_async_script( 'owl-carousel' ) : wp_enqueue_script( 'owl-carousel' );

		$class = 'owl-carousel owl-theme';

		// Nav & Dots
		if ( isset( $settings['nav_type'] ) && 'full' === $settings['nav_type'] ) {
			$class .= ' owl-nav-full';
		} else {
			if ( isset( $settings['nav_type'] ) && 'simple' === $settings['nav_type'] ) {
				$class .= ' owl-nav-simple';
			}
			if ( isset( $settings['nav_type'] ) && 'simple2' === $settings['nav_type'] ) {
				$class .= ' owl-nav-simple2';
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
		if ( isset( $settings['vertical_dots'] ) && '' !== $settings['vertical_dots'] ) {
			$class .= ' vertical-dots';
		}
		if ( isset( $settings['dots_type'] ) && '' !== $settings['dots_type'] ) {
			$class .= ' owl-dot-' . $settings['dots_type'];
		}
		if ( isset( $settings['dots_pos'] ) && 'inner' === $settings['dots_pos'] ) {
			$class .= ' owl-dot-inner';
		}
		if ( isset( $settings['dots_pos'] ) && 'close' === $settings['dots_pos'] ) {
			$class .= ' owl-dot-close';
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
			$extra_options['dotsContainer'] = '.slider-thumb-dots-' . ( is_object( $self ) && is_callable( array( $self, 'get_data' ) ) ? $self->get_data( 'id' ) : $self );
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

		if ( isset( $responsive[ $riode_breakpoints['xl'] ] ) ) {
			$responsive[ $riode_breakpoints['xl'] ]['nav']  = isset( $settings['show_nav'] ) && 'yes' === $settings['show_nav'];
			$responsive[ $riode_breakpoints['xl'] ]['dots'] = isset( $settings['show_dots'] ) && 'yes' === $settings['show_dots'];
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

if ( ! function_exists( 'riode_get_image_sizes' ) ) {
	function riode_get_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array(
			esc_html__( 'Default', 'riode-core' ) => '',
			esc_html__( 'Full', 'riode-core' )    => 'full',
		);

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[  $_size . ' ( ' . get_option( "{$_size}_size_w" ) . 'x' . get_option( "{$_size}_size_h" ) . ( get_option( "{$_size}_crop" ) ? '' : ', false' ) . ' )' ] = $_size;
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size . ' ( ' . $_wp_additional_image_sizes[ $_size ]['width'] . 'x' . $_wp_additional_image_sizes[ $_size ]['height'] . ( $_wp_additional_image_sizes[ $_size ]['crop'] ? '' : ', false' ) . ' )' ] = $_size;
			}
		}
		return $sizes;
	}
}

/**
 * Get button widget class
 */
function riode_widget_button_get_class( $settings, $prefix = '' ) {
	$class = array();
	if ( isset( $settings[ $prefix . 'button_type' ] ) && $settings[ $prefix . 'button_type' ] ) {
		$class[] = $settings[ $prefix . 'button_type' ];
	}
	if ( isset( $settings[ $prefix . 'link_hover_type' ] ) && $settings[ $prefix . 'link_hover_type' ] ) {
		$class[] = $settings[ $prefix . 'link_hover_type' ];
	}
	if ( isset( $settings[ $prefix . 'button_size' ] ) && $settings[ $prefix . 'button_size' ] ) {
		$class[] = $settings[ $prefix . 'button_size' ];
	}
	if ( isset( $settings[ $prefix . 'shadow' ] ) && $settings[ $prefix . 'shadow' ] ) {
		$class[] = $settings[ $prefix . 'shadow' ];
	}
	if ( isset( $settings[ $prefix . 'button_border' ] ) && $settings[ $prefix . 'button_border' ] ) {
		$class[] = $settings[ $prefix . 'button_border' ];
	}
	if ( ( ! isset( $settings[ $prefix . 'button_type' ] ) || 'btn-gradient' != $settings[ $prefix . 'button_type' ] ) && isset( $settings[ $prefix . 'button_skin' ] ) && $settings[ $prefix . 'button_skin' ] ) {
		$class[] = $settings[ $prefix . 'button_skin' ];
	}
	if ( isset( $settings[ $prefix . 'button_type' ] ) && 'btn-gradient' == $settings[ $prefix . 'button_type' ] && isset( $settings[ $prefix . 'button_gradient_skin' ] ) && $settings[ $prefix . 'button_gradient_skin' ] ) {
		$class[] = $settings[ $prefix . 'button_gradient_skin' ];
	}
	if ( ! empty( $settings[ $prefix . 'btn_class' ] ) ) {
		$class[] = $settings[ $prefix . 'btn_class' ];
	}
	if ( isset( $settings[ $prefix . 'icon_hover_effect_infinite' ] ) && 'yes' == $settings[ $prefix . 'icon_hover_effect_infinite' ] ) {
		$class[] = 'btn-infinite';
	}

	if ( isset( $settings[ $prefix . 'icon' ] ) && is_array( $settings[ $prefix . 'icon' ] ) && $settings[ $prefix . 'icon' ]['value'] ) {
		if ( ! $settings[ $prefix . 'show_label' ] ) {
			$class[] = 'btn-icon';
		} elseif ( 'before' == $settings[ $prefix . 'icon_pos' ] ) {
			$class[] = 'btn-icon-left';
		} else {
			$class[] = 'btn-icon-right';
		}
		if ( $settings[ $prefix . 'icon_hover_effect' ] ) {
			$class[] = $settings[ $prefix . 'icon_hover_effect' ];
		}
	}
	return $class;
}

/**
 * Get button widget label
 */
function riode_widget_button_get_label( $settings, $self, $label, $prefix = '' ) {
	if ( $self && ( ! isset( $self::$is_wpb ) || ! $self::$is_wpb ) ) {
		$editor = $self->get_render_attribute_string( 'label' );
		if ( $editor ) {
			$label = sprintf( '<span %1$s>%2$s</span>', $editor, $label );
		}
	}

	if ( isset( $settings[ $prefix . 'icon' ] ) && is_array( $settings[ $prefix . 'icon' ] ) && $settings[ $prefix . 'icon' ]['value'] ) {
		if ( ! $settings[ $prefix . 'show_label' ] ) {
			$label = '<i class="' . $settings[ $prefix . 'icon' ]['value'] . '"></i>';
		} elseif ( 'before' == $settings[ $prefix . 'icon_pos' ] ) {
			$label = '<i class="' . $settings[ $prefix . 'icon' ]['value'] . '"></i>' . $label;
		} else {
			$label .= '<i class="' . $settings[ $prefix . 'icon' ]['value'] . '"></i>';
		}
	}
	return $label;
}

function riode_elementor_grid_col_cnt( $settings ) {

	$col_cnt = array(
		'xl'  => isset( $settings['col_cnt_xl'] ) ? (int) $settings['col_cnt_xl'] : 0,
		'lg'  => isset( $settings['col_cnt'] ) ? (int) $settings['col_cnt'] : 0,
		'md'  => isset( $settings['col_cnt_tablet'] ) ? (int) $settings['col_cnt_tablet'] : 0,
		'sm'  => isset( $settings['col_cnt_mobile'] ) ? (int) $settings['col_cnt_mobile'] : 0,
		'min' => isset( $settings['col_cnt_min'] ) ? (int) $settings['col_cnt_min'] : 0,
	);

	return function_exists( 'riode_get_responsive_cols' ) ? riode_get_responsive_cols( $col_cnt ) : $col_cnt;
}


function riode_elementor_grid_space_class( $settings ) {

	$col_sp = $settings['col_sp'];

	if ( 'lg' === $col_sp || 'sm' === $col_sp || 'xs' === $col_sp || 'no' === $col_sp ) {
		return ' gutter-' . $col_sp;
	}

	return '';
}

function riode_get_post_id_by_name( $post_type, $name ) {
	global $wpdb;
	return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_name = %s", $post_type, $name ) );
}

if ( ! function_exists( 'riode_add_url_parameters' ) ) {
	function riode_add_url_parameters( $url, $name, $value ) {

		$url_data = parse_url( str_replace( '#038;', '&', $url ) );
		if ( ! isset( $url_data['query'] ) ) {
			$url_data['query'] = '';
		}
		$params = array();
		parse_str( $url_data['query'], $params );
		$params[ $name ]   = $value;
		$url_data['query'] = http_build_query( $params );
		return riode_build_url( $url_data );
	}
}

if ( ! function_exists( 'riode_remove_url_parameters' ) ) {
	function riode_remove_url_parameters( $url, $name ) {

		$url_data = parse_url( str_replace( '#038;', '&', $url ) );

		if ( ! isset( $url_data['query'] ) ) {
			$url_data['query'] = '';
		}

		$params = array();

		parse_str( $url_data['query'], $params );

		$params[ $name ] = '';

		$url_data['query'] = http_build_query( $params );

		return riode_build_url( $url_data );
	}
}

if ( ! function_exists( 'riode_build_url' ) ) {
	function riode_build_url( $url_data ) {
		$url = '';

		if ( isset( $url_data['host'] ) ) {

			$url .= $url_data['scheme'] . '://';

			if ( isset( $url_data['user'] ) ) {

				$url .= $url_data['user'];

				if ( isset( $url_data['pass'] ) ) {

					$url .= ':' . $url_data['pass'];
				}

				$url .= '@';

			}

			$url .= $url_data['host'];

			if ( isset( $url_data['port'] ) ) {

				$url .= ':' . $url_data['port'];
			}
		}

		if ( isset( $url_data['path'] ) ) {

			$url .= $url_data['path'];
		}

		if ( isset( $url_data['query'] ) ) {

			$url .= '?' . $url_data['query'];
		}

		if ( isset( $url_data['fragment'] ) ) {

			$url .= '#' . $url_data['fragment'];
		}

		return str_replace( '#038;', '&', $url );
	}
}

if ( ! function_exists( 'riode_escaped' ) ) {
	function riode_escaped( $html_escaped ) {
		return $html_escaped;
	}
}

/**
 * Query helper function
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'riode_query_time_range_filter' ) ) {
	function riode_query_time_range_filter( $table_handler, $time, $interval = 'all' ) {
		$sql = ' 1=1';
		switch ( $interval ) {
			case 'year':
				$sql .= " AND YEAR( {$table_handler}.{$time} ) = YEAR( CURDATE() )";
				break;

			case 'month':
				$sql .= " AND MONTH( {$table_handler}.{$time} ) = MONTH( NOW() )";
				break;
			case 'week':
				$sql .= " AND ( {$table_handler}.{$time} ) BETWEEN DATE_SUB( NOW(), INTERVAL 7 DAY ) AND NOW()";
				break;
			case 'default':
			case 'all':
				break;
		}

		return $sql;
	}
}


// Vendor Helpers.

/**
 * Get total sale of vendors
 *
 * @since 1.0.0
 */
function riode_get_vendor_total_sale( $vendor_id, $tbl_handler, $field_name = 'vendor_id' ) {
	global $wpdb;

	$cache_key  = 'riode_vendor_total_sale_' . $vendor_id;
	$total_sale = wp_cache_get( $cache_key, 'riode-total-sale' );

	// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	$total_sales = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT SUM(total_sales) AS total_sale
			FROM {$wpdb->prefix}{$tbl_handler} AS wpdo
			LEFT JOIN {$wpdb->prefix}wc_order_stats as wos ON wpdo.order_id = wos.order_id
			WHERE wpdo.{$field_name}=%d AND wos.status='wc-completed'",
			$vendor_id
		)
	);
	// phpcs:enable WordPress.DB.PreparedSQL.InterpolatedNotPrepared

	$total_sale = $total_sales ? $total_sales[0] : esc_html__( 'N/A', 'riode-core' );

	wp_cache_set( $cache_key, $total_sale, 'riode-elementor-widget', 3600 * 6 );
	wp_reset_postdata();

	return $total_sale;
}


/**
 * Get top selling vendors
 *
 * @since 1.0.0
 */
function riode_get_best_sellers( $limit = 4, $period = '' ) {
	global  $wpdb;

	$cache_key = 'riode-best-seller-' . $limit;
	$sellers   = wp_cache_get( $cache_key, 'riode-elementor-widget' );
	$results   = [];

	// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
	if ( false == $sellers ) {
		if ( class_exists( 'WeDevs_Dokan' ) ) { // get best sellers using dokan vendor plugins
			$sellers = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT seller_id, total_sale 
						FROM (
							SELECT seller_id, SUM(order_total) AS total_sale 
								FROM $wpdb->dokan_orders AS wdo 
								WHERE wdo.order_status = 'wc-completed'
								GROUP BY seller_id 
						) AS wpdo 
					LEFT JOIN $wpdb->usermeta AS wum ON wpdo.seller_id = wum.user_id 
					WHERE wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND wum.meta_value LIKE %s
					ORDER BY total_sale DESC
					LIMIT %d",
					'%seller%',
					$limit
				)
			);
		}

		if ( class_exists( 'WCFM' ) ) { // get best sellers using wcfm market place plugin
			$sellers = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT seller_id, total_sale
						FROM (
							SELECT vendor_id AS seller_id, SUM(total_sales) AS total_sale
								FROM {$wpdb->prefix}wcfm_marketplace_orders AS wcfmo
								LEFT JOIN {$wpdb->prefix}wc_order_stats ON wcfmo.order_id = {$wpdb->prefix}wc_order_stats.order_id
								WHERE {$wpdb->prefix}wc_order_stats.status = 'wc-completed' AND" . riode_query_time_range_filter( 'wp_posts', 'post_date', $period ) .
								" GROUP BY seller_id
						) AS wpfmo
						LEFT JOIN $wpdb->usermeta AS wum ON wpfmo.seller_id = wum.user_id
						WHERE wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND wum.meta_value LIKE %s
						ORDER BY total_sale
						LIMIT %d",
					'%wcfm_vendor%',
					$limit
				)
			);
		}

		if ( class_exists( 'WC-Vendors' ) ) { // get best sellers using wc vendor plugin
			$sellers = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT seller_id, total_sale
						FROM (
							SELECT vendor_id AS seller_id, SUM(total_sales) AS total_sale
								FROM {$wpdb->prefix}pv_commission AS wcvo
								LEFT JOIN {$wpdb->prefix}wc_order_stats ON wcvo.order_id = {$wpdb->prefix}wc_order_stats.order_id
								WHERE {$wpdb->prefix}wc_order_stats.status = 'wc-completed' AND" . riode_query_time_range_filter( $wpdb->prefix . 'wc_order_stats', 'date_created', $period ) .
								" GROUP BY seller_id
						) AS wcv
						LEFT JOIN $wpdb->usermeta AS wum ON wcv.seller_id = wum.user_id
						WHERE wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND wum.meta_value LIKE %s
						ORDER BY total_sale DESC
						LIMIT %d",
					'%vendor%',
					$limit
				)
			);
		}

		if ( class_exists( 'WCMp' ) ) { // get best sellers using wc-marketplace vendor plugin
			$sellers = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT seller_id, total_sale
						FROM (
							SELECT vendor_id AS seller_id, order_id, SUM(net_total) AS total_sale
								FROM {$wpdb->prefix}wcmp_vendor_orders AS wcmvo
								LEFT JOIN {$wpdb->prefix}wc_order_stats ON wcmvo.order_id = {$wpdb->prefix}wc_order_stats.order_id
								WHERE {$wpdb->prefix}wc_order_stats.status = 'wc-completed' AND" . riode_query_time_range_filter( $wpdb->prefix . 'wc_order_stats', 'date_created', $period ) .
								" GROUP BY seller_id
						) AS wcvo
						LEFT JOIN $wpdb->usermeta AS wum ON wcvo.seller_id = wum.user_id
						WHERE wum.meta_key='" . $wpdb->get_blog_prefix() . "capabilities' AND wum.meta_value LIKE %s
						ORDER BY total_sale
						DESC LIMIT %d",
					'%dc-vendor%',
					$limit
				)
			);
		}

		wp_cache_set( $cache_key, $sellers, 'riode-elementor-widget', 3600 * 6 );
	}
	// phpcs:enable WordPress.DB.PreparedSQL.NotPrepared
	if ( is_array( $sellers ) && count( $sellers ) > 0 ) {
		foreach ( $sellers as $seller ) {
			$result    = array(
				'id'         => $seller->seller_id,
				'total_sale' => $seller->total_sale,
			);
			$results[] = $result;
		}
	}

	return apply_filters( 'riode_get_best_sellers', $results );
}


/**
 * Get top rating vendors
 *
 * @since 1.0.0
 */
function riode_get_top_rating_sellers( $limit = 5 ) {
	global $wpdb;

	$cache_key = 'riode-top-rated-seller-' . $limit;
	$sellers   = wp_cache_get( $cache_key, 'riode-elementor-widget' );
	$results   = [];

	if ( false == $sellers ) {
		if ( class_exists( 'WeDevs_Dokan' ) ) {
			if ( class_exists( 'Dokan_Pro' ) ) {
				$sellers = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT 
                                    temp1.post_id,
                                    temp1.meta_value AS seller_id,
                                    AVG(temp2.meta_value) AS rating 
                                FROM
                                $wpdb->postmeta AS temp1 
                                INNER JOIN $wpdb->postmeta AS temp2
                                    ON temp1.post_id = temp2.post_id 
                                WHERE temp1.meta_key = 'store_id' 
                                    AND temp2.meta_key = 'rating' 
                                GROUP BY seller_id
                                ORDER BY rating DESC
                                LIMIT %d",
						$limit
					)
				);
			} else {
				$sellers = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT 
                                    p.ID,
                                    AVG(wcm.meta_value) AS rating,
                                    p.post_author AS seller_id
                                FROM
                                $wpdb->posts AS p
                                INNER JOIN $wpdb->comments AS wc
                                    ON p.ID = wc.comment_post_ID
                                LEFT JOIN $wpdb->commentmeta AS wcm
                                    ON wcm.comment_id = wc.comment_ID
                                LEFT JOIN $wpdb->usermeta AS wpu
                                    ON p.`post_author` = wpu.`user_id`
                                WHERE p.post_type = 'product'
                                AND	p.post_status = 'publish'
                                AND ( 
                                    wcm.meta_key = 'rating' 
                                    OR wcm.meta_key IS NULL
                                )
                                AND wc.comment_approved = 1
                                AND wpu.`meta_value` LIKE %s
                                GROUP BY p.post_author
                                ORDER BY rating DESC
                                LIMIT %d",
						'%seller%',
						$limit
					)
				);
			}
		}

		if ( class_exists( 'WCFM' ) ) {
			$sellers = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT 
                                user_id AS seller_id,
                                meta_value AS rating 
                            FROM
                            $wpdb->usermeta as wpu
                            WHERE wpu.meta_key = '_wcfmmp_avg_review_rating' 
                            GROUP BY seller_id
                            ORDER BY rating DESC
                            LIMIT %d",
					$limit
				)
			);
		}

		if ( class_exists( 'WCMp' ) ) {
			$sellers = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT
                                templ.meta_value AS seller_id,
                                templ.comment_id,
                                $wpdb->commentmeta.meta_value AS rating 
                            FROM
                                $wpdb->commentmeta AS templ 
                            JOIN $wpdb->commentmeta ON templ.comment_id = $wpdb->commentmeta.comment_id 
                            WHERE templ.meta_key = 'vendor_rating_id' AND $wpdb->commentmeta.meta_key = 'vendor_rating'
                            GROUP BY seller_id
                            ORDER BY rating DESC
                            LIMIT %d",
					$limit
				)
			);
		}

		wp_cache_set( $cache_key, $sellers, 'riode-elementor-widget', 3600 * 6 );
	}

	if ( is_array( $sellers ) && count( $sellers ) > 0 ) {
		foreach ( $sellers as $seller ) {
			$result    = array(
				'id'     => $seller->seller_id,
				'rating' => $seller->rating,
			);
			$results[] = $result;
		}
	}

	return apply_filters( 'riode_get_top_rating_sellers', $results );
}


/**
 * Get Vendors
 *
 * @since 1.0.0
 */
function riode_get_sellers( $limit = 5, $orderby = 'registered' ) {

	$results = [];

	$query_args = [
		'role'       => array( 'seller' ),
		'number'     => $limit,
		'offset'     => 0,
		'orderby'    => $orderby,
		'order'      => 'ASC',
		'status'     => 'approved',
		'featured'   => '', // yes or no
		'meta_query' => [],
	];

	if ( class_exists( 'WeDevs_Dokan' ) ) {
		$query_args['role'] = array( 'seller' );
	} elseif ( class_exists( 'WCMp' ) ) {
		$query_args['role'] = array( 'dc_vendor' );
	} elseif ( class_exists( 'WCFMmp' ) ) {
		$query_args['role'] = array( 'wcfm_vendor' );
	} elseif ( class_exists( 'WC_Vendors' ) ) {
		$query_args['role'] = array( 'vendor' );
	}

	$query   = new WP_User_Query( $query_args );
	$sellers = $query->get_results();

	foreach ( $sellers as $seller ) {
		$result    = array(
			'id'   => $seller->ID,
			'text' => $seller->display_name,
		);
		$results[] = $result;
	}

	return apply_filters( 'riode_get_sellers', $results );
}



/**
 * Get Dokan vendor information
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'riode_get_dokan_vendor_info' ) ) {
	function riode_get_dokan_vendor_info( $vendor ) {

		$store_info               = dokan_get_store_info( $vendor['id'] );
		if ( $store_info ) {
			$vendor['store_name']     = $store_info['store_name'];
			$vendor['store_url']      = dokan_get_store_url( $vendor['id'] );
			$vendor_review            = dokan_get_seller_rating( $vendor['id'] );
			$vendor['rating']         = is_numeric( $vendor_review['rating'] ) ? $vendor_review['rating'] : 0;
			$vendor['products_count'] = count_user_posts( $vendor['id'], 'product' );
			$vendor['banner']         = ! empty( $store_info['banner'] ) ? absint( $store_info['banner'] ) : 0;

			if ( ! isset( $vendor['total_sale'] ) ) {
				$result = riode_get_vendor_total_sale( $vendor['id'], 'dokan_orders', 'seller_id' );
				if ( $result ) {
					$vendor['total_sale'] = is_numeric( $result->total_sale ) ? $result->total_sale : 0;
				}
			}
		} else {
			$vendor = false;
		}

		return apply_filters( 'riode_get_dokan_vendors', $vendor );
	}
}


/**
 * Get WCFM vendor information
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'riode_get_wcfm_vendor_info' ) ) {
	function riode_get_wcfm_vendor_info( $vendor ) {

		// phpcs:disable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		global $WCFMmp;

		$store_info               = ! empty( $WCFMmp ) ? wcfmmp_get_store_info( $vendor['id'] ) : null;
		if ( $store_info ) {
			$store_user               = wcfmmp_get_store( $vendor['id'] );
			$vendor['store_name']     = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'riode-core' );
			$vendor['store_url']      = wcfmmp_get_store_url( $vendor['id'] );
			$vendor_rating            = $WCFMmp->wcfmmp_reviews->get_vendor_review_rating( $vendor['id'] );
			$vendor['rating']         = $vendor_rating ? $vendor_rating : 0;
			$vendor['products_count'] = count_user_posts( $vendor['id'], 'product' );
			$vendor_data              = get_user_meta( $vendor['id'], 'wcfmmp_profile_settings', true );
			$vendor['banner']         = isset( $vendor_data['banner'] ) ? absint( $vendor_data['banner'] ) : 0;
			$vendor['avatar_url']     = $store_user->get_avatar();
			// phpcs:enable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			if ( ! isset( $vendor['total_sale'] ) ) {
				$result = riode_get_vendor_total_sale( $vendor['id'], 'wcfm_marketplace_orders' );
				if ( $result ) {
					$vendor['total_sale'] = is_numeric( $result->total_sale ) ? $result->total_sale : 0;
				}
			}
		} else {
			$vendor = false;
		}

		return apply_filters( 'riode_get_wcfm_vendor_info', $vendor );
	}
}

/**
 * Get WCMp vendor information
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'riode_get_wcmp_vendor_info' ) ) {
	function riode_get_wcmp_vendor_info( $vendor ) {
		// phpcs:disable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		global $WCMp;

		$wcmp_vendor              = get_wcmp_vendor( $vendor['id'] );
		if ( $wcmp_vendor ) {
			$vendor['store_name']     = apply_filters( 'wcmp_vendor_lists_single_button_text', $wcmp_vendor->page_title );
			$vendor['store_url']      = $wcmp_vendor->get_permalink();
			$rating_info              = wcmp_get_vendor_review_info( $wcmp_vendor->term_id );
			$vendor['rating']         = $rating_info['avg_rating'];
			$vendor_image             = get_user_meta( $vendor['id'], '_vendor_profile_image', true );
			$vendor['avatar_url']     = ( isset( $vendor_image ) && $vendor_image > 0 ) ? wp_get_attachment_url( $vendor_image ) : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
			$vendor['products_count'] = count_user_posts( $vendor['id'], 'product' );
			$vendor['banner']         = ( '' != $wcmp_vendor->get_image( 'banner' ) ) ? $wcmp_vendor->get_image( 'banner' ) : $WCMp->plugin_url . 'assets/images/banner_placeholder.jpg';
			// phpcs:enable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			if ( ! isset( $vendor['total_sale'] ) ) {
				$result = riode_get_vendor_total_sale( $vendor['id'], 'wcmp_vendor_orders' );
				if ( $result ) {
					$vendor['total_sale'] = is_numeric( $result->total_sale ) ? $result->total_sale : 0;
				}
			}
		} else {
			$vendor = false;
		}

		return apply_filters( 'riode_get_wcmp_vendor_info', $vendor );
	}
}

/**
 * riode_remove_all_admin_notices
 *
 * removes all notices of theme and plugins from Riode admin panel
 *
 * @since 1.0.1
 */
function riode_remove_all_admin_notices() {
	add_action(
		'network_admin_notices',
		function() {
			remove_all_actions( 'network_admin_notices' );
		},
		1
	);
	add_action(
		'user_admin_notices',
		function() {
			remove_all_actions( 'user_admin_notices' );
		},
		1
	);
	add_action(
		'admin_notices',
		function() {
			remove_all_actions( 'admin_notices' );
		},
		1
	);
	add_action(
		'all_admin_notices',
		function() {
			remove_all_actions( 'all_admin_notices' );
		},
		1
	);
}

/**
 * riode_check_units
 *
 * checks units
 *
 * @param string $value
 *
 * @return string
 * @since 1.1.0
 */
if ( ! function_exists( 'riode_check_units' ) ) {
	function riode_check_units( $value ) {
		$value = str_replace( ' ', '', $value );
		if ( ! preg_match( '/((^\d+(.\d+){0,1})|((-){0,1}.\d+))(px|%|em|rem|pt){0,1}$/', $value ) ) {
			if ( 'auto' == $value || 'inherit' == $value || 'initial' == $value || 'unset' == $value ) {
				return $value;
			}
			return false;
		} elseif ( is_numeric( $value ) ) {
			$value .= 'px';
		}
		return $value;
	}
}

/**
 * riode_get_js_extension
 *
 * gets JS file extension.
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
 * riode_get_customize_dir
 *
 * gets image directory uri of theme's customize panel
 *
 * @since 1.4.0
 */
function riode_get_customize_dir() {
	if ( defined( 'RIODE_CUSTOMIZER_IMG' ) ) {
		return RIODE_CUSTOMIZER_IMG;
	}

	return '';
}

/**
 * riode_get_shape_dividers
 *
 * get shape dividers which riode provides
 *
 * @since 1.4.0
 */
function riode_get_shape_dividers() {
	return array(
		'arrow'                 => array(
			'title'        => esc_html__( 'Arrow', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/arrow.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/arrow.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'book'                  => array(
			'title'        => esc_html__( 'Book', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/book.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/book.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'clouds'                => array(
			'title'        => esc_html__( 'Clouds', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/clouds.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/clouds.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'curve'                 => array(
			'title'        => esc_html__( 'Curve', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/curve.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/curve.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'curve_asymmetrical'    => array(
			'title'        => esc_html__( 'Curve Asymmetrical', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/curve-asymmetrical.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/curve-asymmetrical.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'drops'                 => array(
			'title'        => esc_html__( 'Drops', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/drops.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/drops.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'mountains'             => array(
			'title'        => esc_html__( 'Mountains', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/mountains.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/mountains.svg',
			'has_flip'     => true,
		),
		'opacity_fan'           => array(
			'title'        => esc_html__( 'Opacity Fan', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/opacity-fan.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/opacity-fan.svg',
			'has_flip'     => true,
		),
		'opacity_tilt'          => array(
			'title'        => esc_html__( 'Opacity Tilt', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/opacity-tilt.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/opacity-tilt.svg',
			'has_flip'     => true,
		),
		'pyramids'              => array(
			'title'        => esc_html__( 'Pyramids', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/pyramids.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/pyramids.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'split'                 => array(
			'title'        => esc_html__( 'Split', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/split.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/split.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'tilt'                  => array(
			'title'        => esc_html__( 'Tilt', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/tilt.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/tilt.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'triangle'              => array(
			'title'        => esc_html__( 'Triangle', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/triangle.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/triangle.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'triangle_asymmetrical' => array(
			'title'        => esc_html__( 'Triangle Asymmetrical', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/triangle-asymmetrical.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/triangle-asymmetrical.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'wave_brush'            => array(
			'title'        => esc_html__( 'Wave Brush', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/wave-brush.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/wave-brush.svg',
			'has_flip'     => true,
		),
		'wave'                  => array(
			'title'        => esc_html__( 'Wave', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/wave.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/wave.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'zigzag'                => array(
			'title'        => esc_html__( 'Zigzag', 'riode-core' ),
			'path'         => RIODE_CORE_PATH . 'assets/images/dividers/zigzag.svg',
			'url'          => RIODE_CORE_URI . 'assets/images/dividers/zigzag.svg',
			'has_negative' => true,
			'has_flip'     => true,
		),
		'theme_shape_1'         => array(
			'title'    => esc_html__( 'Riode Shape 1', 'riode-core' ),
			'path'     => RIODE_CORE_PATH . 'assets/images/dividers/shape-1.svg',
			'url'      => RIODE_CORE_URI . 'assets/images/dividers/shape-1.svg',
			'has_flip' => true,
		),
		'theme_shape_2'         => array(
			'title'    => esc_html__( 'Riode Shape 2', 'riode-core' ),
			'path'     => RIODE_CORE_PATH . 'assets/images/dividers/shape-2.svg',
			'url'      => RIODE_CORE_URI . 'assets/images/dividers/shape-2.svg',
			'has_flip' => true,
		),
		'theme_shape_3'         => array(
			'title'    => esc_html__( 'Riode Shape 3', 'riode-core' ),
			'path'     => RIODE_CORE_PATH . 'assets/images/dividers/shape-3.svg',
			'url'      => RIODE_CORE_URI . 'assets/images/dividers/shape-3.svg',
			'has_flip' => true,
		),
		'theme_shape_4'         => array(
			'title'    => esc_html__( 'Riode Shape 4', 'riode-core' ),
			'path'     => RIODE_CORE_PATH . 'assets/images/dividers/shape-4.svg',
			'url'      => RIODE_CORE_URI . 'assets/images/dividers/shape-4.svg',
			'has_flip' => true,
		),
		'theme_shape_5'         => array(
			'title'    => esc_html__( 'Riode Shape 5', 'riode-core' ),
			'path'     => RIODE_CORE_PATH . 'assets/images/dividers/shape-5.svg',
			'url'      => RIODE_CORE_URI . 'assets/images/dividers/shape-5.svg',
			'has_flip' => true,
		),
		'theme_shape_6'         => array(
			'title'    => esc_html__( 'Riode Shape 6', 'riode-core' ),
			'path'     => RIODE_CORE_PATH . 'assets/images/dividers/shape-6.svg',
			'url'      => RIODE_CORE_URI . 'assets/images/dividers/shape-6.svg',
			'has_flip' => true,
		),
		'theme_shape_6'         => array(
			'title'    => esc_html__( 'Riode Shape 6', 'riode-core' ),
			'path'     => RIODE_CORE_PATH . 'assets/images/dividers/shape-6.svg',
			'url'      => RIODE_CORE_URI . 'assets/images/dividers/shape-6.svg',
			'has_flip' => true,
		),
		'custom'                => array(
			'title'        => esc_html__( 'Upload Your Own', 'riode-core' ),
			'has_negative' => false,
			'has_flip'     => true,
		),
	);
}
