<?php
if ( in_array( 'readmore', $show_info ) ) {
	$read_more_label = wp_unslash($read_more_label);

	printf(
		'<a href="%s" class="btn %s">%s</a>',
		esc_url( get_the_permalink() ),
		$read_more_class ? esc_attr( $read_more_class ) : 'btn-link btn-underline btn-primary',
		$read_more_class ? $read_more_label : $read_more_label . '<i class="d-icon-arrow-' . ( is_rtl() ? 'left' : 'right' ) . '"></i>'
	);
}
