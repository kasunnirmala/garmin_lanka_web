<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Filter Widget Render
 *
 */

extract( // @codingStandardsIgnoreLine
	shortcode_atts(
		array(
			'attributes'   => array(),
			'btn_label'    => 'Filter',
			'btn_skin'     => 'btn-primary',
			'align'        => 'center',
			'page_builder' => '',
		),
		$settings
	)
);

if ( ! empty( $attributes ) && count( $attributes ) ) {
	?>

<div class="riode-filters align-<?php echo esc_attr( $align ); ?>">
	<?php
	foreach ( $attributes as $attribute ) {
		$tax  = get_taxonomy( $attribute['name'] );
		$name = '';
		if ( ! empty( $tax->labels->singular_name ) ) {
			$name = $tax->labels->singular_name;
		}
		?>
		<div class="riode-filter select-ul <?php echo esc_attr( $attribute['name'] ); ?>" data-filter-attr="<?php echo substr( $attribute['name'], 3 ); ?>" data-filter-query="<?php echo esc_attr( $attribute['query_opt'] ); ?>">
			<h3 class="select-ul-toggle"><?php printf( esc_html__( 'Select %s', 'riode-core' ), esc_attr( $name ) ); ?></h3>
			<?php
			$terms = get_terms(
				array(
					'taxonomy'   => $attribute['name'],
					'hide_empty' => false,
				)
			);
			if ( is_array( $terms ) && count( $terms ) ) :
				?>
			<ul>
				<?php foreach ( $terms as $term ) : ?>
					<li data-value="<?php echo esc_attr( $term->slug ); ?>"><a href="#"><?php echo esc_attr( $term->name ); ?></a></li>
			<?php endforeach; ?>
			</ul>
				<?php
			else :
				?>
				<ul><li> No Attribute </li></ul>
				<?php
			endif;
			?>
		</div>
		<?php
	}
	?>

	<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn <?php echo esc_attr( $btn_skin ); ?> btn-filter"><?php echo esc_attr( $btn_label ? $btn_label : 'Filter' ); ?></a>
</div>

	<?php
}
