<?php
if ( 'attachment' != get_post_type() ) {
	the_post_navigation(
		array(
			'prev_text'    => esc_html__( 'Previous Post', 'riode' ) . '<span class="pager-link-title">%title</span> <i class="d-icon-arrow-left"></i>',
			'next_text'    => esc_html__( 'Next Post', 'riode' ) . '<span class="pager-link-title">%title</span> <i class="d-icon-arrow-right"></i>',
			'in_same_term' => true,
		)
	);
}
