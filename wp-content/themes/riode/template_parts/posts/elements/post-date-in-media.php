<div class="post-calendar">
	<span class="post-day"><?php echo esc_html( apply_filters( 'riode_post_calendar_box_day', get_the_time( 'd', get_the_ID() ) ) ); ?></span>
	<span class="post-month"><?php echo esc_html( apply_filters( 'riode_post_calendar_box_month', get_the_time( 'M', get_the_ID() ) ) ); ?></span>
</div>
