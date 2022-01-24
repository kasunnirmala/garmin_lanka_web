<?php
defined( 'ABSPATH' ) || die;

if ( riode_doing_ajax() ) {
	$is_ajax = true;
} else {
	$is_ajax = false;
}
?>
<div class="blocks-wrapper closed">
	<div class="blocks-header">
		<h2><?php esc_html_e( 'Template Library', 'riode' ); ?></h2>
		<button title="<?php esc_attr_e( 'Close (Esc)', 'riode' ); ?>" type="button" class="mfp-close">&times;</button>
	</div>
	<div class="category-list">
		<h3><img src="<?php echo RIODE_URI; ?>/assets/images/logo-studio.png" alt="<?php esc_attr_e( 'Riode Studio', 'riode' ); ?>" width="185" height="73" /></h3>
		<ul>
			<li class="filtered"><a href="#" data-filter-by="0" data-total-page="<?php echo (int) $total_pages; ?>"></a></li>
			<li>
				<a href="#" class="all active">
				<img src="<?php echo RIODE_URI; ?>/assets/images/studio/icon-all.svg">
					<?php esc_html_e( 'All', 'riode' ); ?>
					<span>(<?php echo (int) $total_count; ?>)</span>
				</a>
			</li>
			<li class="category-has-children">
				<a href="#" class="block-category-blocks" data-filter-by="blocks" data-total-page="<?php echo (int) $blocks_pages; ?>">
					<img src="<?php echo RIODE_URI; ?>/assets/images/studio/icon-block.svg">
					<?php esc_html_e( 'Blocks', 'riode' ); ?><i class="fa fa-chevron-down"></i>
				</a>
				<ul>
					<?php
					foreach ( $block_categories as $category ) :
						if ( ! in_array( $category['title'], $big_categories ) && $category['count'] > 0 ) :
							?>
							<li>
								<a href="#" data-filter-by="<?php echo (int) $category['id']; ?>" data-total-page="<?php echo (int) ( $category['total'] ); ?>">
									<?php echo esc_html( $studio->get_category_title( $category['title'] ) ); ?>
								</a>
							</li>
							<?php
						endif;
					endforeach;
					?>
				</ul>
			</li>
			<?php
			foreach ( $big_categories as $big_category ) :
				$not_found = true;
				foreach ( $block_categories as $category ) :
					if ( $category['title'] == $big_category ) :
						?>
						<li>
							<a href="#" class="block-category-<?php echo esc_attr( $category['title'] ); ?>" data-filter-by="<?php echo esc_attr( $category['id'] ); ?>" data-total-page="<?php echo (int) ( $category['total'] ); ?>">
								<img src="<?php echo RIODE_URI; ?>/assets/images/studio/icon-<?php echo esc_attr( $big_category ); ?>.svg">
								<?php
								echo esc_html( $studio->get_category_title( $category['title'] ) );
								if ( 'favourites' == $big_category || 'my-templates' == $big_category ) {
									echo '<span>(' . (int) $category['count'] . ')</span>';
								}
								?>
							</a>
						</li>
						<?php
						$not_found = false;
						break;
					endif;
				endforeach;
				if ( $not_found ) :
					?>
					<li>
						<a href="#" class="block-category-<?php echo esc_attr( $big_category ); ?>">
							<img src="<?php echo RIODE_URI; ?>/assets/images/studio/icon-<?php echo esc_attr( $big_category ); ?>.svg">
							<?php echo esc_html( $studio->get_category_title( $big_category ) ); ?>
						</a>
					</li>
					<?php
				endif;
			endforeach;
			?>
		</ul>
	</div>
	<div class="blocks-section">
		<div class="blocks-section-inner">
			<div class="blocks-row">
				<div class="blocks-title">
					<h3><?php esc_html_e( 'All in One Library', 'riode' ); ?></h3>
					<p><?php esc_html_e( 'Choose any type of template from our library.', 'riode' ); ?></p>
				</div>
				<div class="demo-filter">
					<?php
					if ( ! class_exists( 'Riode_Setup_Wizard' ) ) {
						require_once RIODE_ADMIN . '/wizard/setup_wizard/setup_wizard.php';
					}
						$instance = Riode_Setup_Wizard::get_instance();
						$filters  = $instance->riode_demo_types();
					?>
					<div class="custom-select">
						<select class="filter-select">
							<option value=""><?php esc_html_e( 'Select Demo', 'riode' ); ?></option>
							<?php foreach ( $filters as $name => $value ) : ?>
								<?php
								if ( ! empty( $value['editors'] ) && (
									( 'e' == $page_type && in_array( 'elementor', $value['editors'] ) ) || 
									( 'w' == $page_type && in_array( 'js_composer', $value['editors'] ) ) ) ) :
									?>
									<option value="<?php echo esc_attr( $name ); ?>" data-filter="<?php echo esc_attr( $value['filter'] ); ?>"><?php echo esc_html( $value['alt'] ); ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</div>
					<button class="btn btn-primary" disabled="disabled"><?php esc_html_e( 'Filter', 'riode' ); ?></button>
				</div>
			</div>
				<?php if ( ! $is_ajax ) : ?>
				<div class="block-categories">
					<a href="#" class="block-category" data-category="blocks">
						<h4><?php esc_html_e( 'Blocks', 'riode' ); ?></h4>
						<img src="<?php echo RIODE_URI; ?>/assets/images/studio/block.svg">
					</a>
					<?php
					foreach ( $big_categories as $big_category ) {
						?>
						<a href="#" class="block-category" data-category="<?php echo esc_attr( $big_category ); ?>">
							<h4><?php echo esc_html( $studio->get_category_title( $big_category ) ); ?></h4>
							<img src="<?php echo RIODE_URI; ?>/assets/images/studio/<?php echo esc_attr( $big_category ); ?>.svg">
						</a>
						<?php
					}
					?>
				</div>
			<?php endif; ?>
			<div class="blocks-list"></div>
			<div class="riode-loading"><i></i></div>
		</div>
	</div>
	<div class="riode-loading"><i></i></div>
</div>
