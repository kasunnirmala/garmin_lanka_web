<?php
$tags = get_the_tag_list();
?>

<div class="post-tags">
	<?php echo riode_strip_script_tags( $tags ); ?>
</div>
