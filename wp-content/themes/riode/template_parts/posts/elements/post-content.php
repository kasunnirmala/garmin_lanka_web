<?php if ( in_array( 'content', $show_info ) ) { ?>
<div class="post-content">
	<?php
	if ( $single ) {
		the_content();
		riode_get_page_links_html();
	} else {
		global  $post;

		if ( has_excerpt( $post ) ) {
			echo '<p>' . riode_trim_description( get_the_excerpt( $post ), $excerpt_limit, $excerpt_type ) . '</p>';
		} elseif ( strpos( $post->post_content, '<!--more-->' ) ) {
			echo riode_trim_description( apply_filters( 'the_content', get_the_content() ), $excerpt_limit, $excerpt_type );
		} else {
			echo riode_trim_description( get_the_content(), $excerpt_limit, $excerpt_type );
		}
	}
	?>
</div>
<?php }
