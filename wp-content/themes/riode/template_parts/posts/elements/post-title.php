<?php
if ( ! $related && $single ) {
	echo '<h2 class="post-title page-title">';
	the_title();
	echo '</h2>';
} else {
	echo '<h3 class="post-title"><a href="' . esc_url( get_the_permalink() ) . '">';
	the_title();
	echo '</a></h3>';
}
