<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Menu Widget Render
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'list_type'            => 'pcat',
			'category_ids'         => '',
			'product_category_ids' => '',
			'hide_empty'           => '',
			'count'                => '',
			'view_all'             => '',
		),
		$atts
	)
);

$tax = 'category';

if ( 'pcat' == $list_type ) {
	$category_ids = $product_category_ids;
	$tax          = 'product_cat';
}

if ( empty( $category_ids ) ) {
	$category_ids = '';
}

if ( ! is_array( $category_ids ) || empty( $category_ids ) ) {
	$category_ids = array_map( 'absint', explode( ',', $category_ids ) );
}

if ( isset( $count['size'] ) ) {
	$count = $count['size'];
}
$link = '';
if ( is_product_category() ) {
	$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
}

if ( is_array( $category_ids ) && count( $category_ids ) ) {
	$cats = get_terms(
		array(
			'taxonomy'   => $tax,
			'include'    => implode( ',', $category_ids ),
			'hide_empty' => boolval( $hide_empty ),
		)
	);
	?>
	<nav class="subcat-nav">
		<ul class="subcat-menu">
			<?php foreach ( $cats as $cat ) { ?>
				<?php
				$sub_cats = get_terms(
					array(
						'taxonomy'   => $tax,
						'hide_empty' => boolval( $hide_empty ),
						'parent'     => $cat->term_id,
						'number'     => absint( $count ),
					)
				);
				if ( ! empty( $sub_cats ) ) {
					echo '<li>';
					echo '<h5 class="subcat-title">' . esc_html( $cat->name ) . '</h5>';

					foreach ( $sub_cats as $sub_cat ) {
						?>
						<a href="<?php echo esc_url( get_term_link( $sub_cat ) ); ?>" class="<?php echo esc_attr( get_term_link( $sub_cat ) == $link ? 'active' : '' ); ?>"><?php echo esc_html( $sub_cat->name ); ?></a>
						<?php
					}
					if ( $view_all ) {
						echo '<a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $view_all ) . '</a>';
					}
					echo '</li>';
				}
				?>
			<?php } ?>
		</ul>
	</nav>
	<?php
}
