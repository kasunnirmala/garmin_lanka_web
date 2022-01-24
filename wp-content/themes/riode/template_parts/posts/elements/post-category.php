<?php

if ( in_array( 'category', $show_info ) ) {
	$cats = get_the_category_list( ' , ' );
	if ( $cats ) {
		echo '<div class="post-cats">' . riode_strip_script_tags( $cats ) . '</div>';
	}
}
