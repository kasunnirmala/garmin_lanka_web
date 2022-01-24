<?php
defined( 'ABSPATH' ) || die;
?>

<div class="riode-admin-panel-header">
	<h1><?php esc_html_e( 'Page Layouts', 'riode-core' ); ?></h1>
	<p><?php esc_html_e( 'Create page layouts and assign them to different pages with display condition.', 'riode-core' ); ?></p>
</div>
<div class="riode-admin-panel-row">
	<div class="riode-admin-panel-side riode-page-layout-filter-wrapper">
		<h2 class="filter-title"><?php esc_html_e( 'Layout Filter', 'riode-core' ); ?></h2>
		<ul class="page-layout-filters">
			<?php
				$filters = $this->get_filters();
			foreach ( $filters as $key => $item ) {
				?>
				<?php
				if ( ! empty( $item ) ) {
					foreach ( $item as $name => $value ) {
						?>
						<li class="page-layout-filter">
							<a href="<?php echo esc_attr( $name ); ?>">
							<?php
							echo esc_html( isset( $value['name'] ) ? $value['name'] : '' );
							?>
							</a>
							<?php
							if ( ! empty( $value['subcats'] ) ) {
								?>
								<span class="toggle"></span>
								<ul class="page-layout-filters children" style="display: none;">
								<?php
								foreach ( $value['subcats'] as $slug => $subcat ) {
									?>
									<li class="page-layout-filter"><a href="<?php echo esc_attr( $name . ( empty( $slug ) ? '-all' : ( '-' . $slug ) ) ); ?>"><?php echo esc_html( $subcat ); ?></a></li>
									<?php
								}
								?>
								</ul>
								<?php
							}
							?>
						</li>
						<?php
					}
				}
			}
			?>
		</ul>
	</div>
	<div class="riode-admin-panel-body riode-page-layout-wrapper riode-admin-panel-content">
		<div class="page-layouts">
			<?php
				$page_layouts = riode_get_option( 'page_layouts' );
			foreach ( $page_layouts as $key => $layout ) {
				Riode_Layout::print_layout( $key, $layout );
			}
			?>

			<div class="layout-box empty-layout">
				<a href="#" class="add-new-layout"><i class="fas fa-plus"></i></a>
			</div>

		</div>

		<script type="text/template" id="riode_layout_remove_form"><?php echo $this->get_remove_form_html(); ?></script>

		<?php
		$parts = array( 'general', 'header', 'ptb', 'top_block', 'inner_top_block', 'inner_bottom_block', 'bottom_block', 'footer', 'top_sidebar', 'left_sidebar', 'right_sidebar' );
		foreach ( $parts as $part ) {
			ob_start();

			foreach ( $this->options[ $part ] as $setting => $args ) {
				$this->add_control( $setting, $args );
			}

			$html = ob_get_clean();
			?>
			<script type="text/template" id="riode_layout_<?php echo $part; ?>_options_html"><?php echo $html; ?></script>
			<?php
		}
		?>
	</div>
</div>
