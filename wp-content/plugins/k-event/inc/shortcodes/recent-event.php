<?php
/**
 * Shortcode recent event.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_recent_event_shortcode' ) ) {
	function k2t_recent_event_shortcode( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
			'event_pagination'		=> 'show',
			'event_navigation'		=> 'show',
			'event_masonry_filter'  => 'show',
			'k_recent_url'			=> '',
			'recent_text_detail'	=> '',
		), $atts));

		wp_enqueue_script( 'k-event' );
		wp_enqueue_script( 'k-countdown' );
		wp_enqueue_script( 'k-lodash' );
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );

		$arr = array(
			'post_type' 		=> 'post-k-event',
			'posts_per_page' 	=> 1,
			'order'				=> 'DESC',
			'post_status'		=> 'publish',
			'paged'				=> $paged,
			'orderby'			=> 'date',
		);
		
		ob_start();
		$query = new WP_Query( $arr );
		?>

		<?php



			if( count( $query->posts ) > 0 ):
				while( $query->have_posts() ) : $query->the_post();

				$event_address = (function_exists('get_field')) ? get_field('event_address', get_the_ID()) : ''; $event_address = empty($event_address) ? '' : $event_address;
				$thumbnail = (has_post_thumbnail(get_the_ID())) ? true : false;
				$categories = get_the_terms(get_the_ID(), 'k-event-category');
				$title = get_the_title();
				$content = get_the_content();
				$post_link = get_permalink(get_the_ID());
				$post_thumb_size = 'thumb_600x450';
				$post_thumb = '<a class="event-thumb" href="'. esc_url( $post_link ) .'" title="'. esc_attr( $title ) .'">' . get_the_post_thumbnail(get_the_ID(), $post_thumb_size, array('alt' => trim(get_the_title()))) . '</a>';
				$post_thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );


				$start_date = (function_exists('get_field')) ? get_field('event_start_date', get_the_ID()) : ''; $start_date = empty($start_date) ? '' : $start_date;
				$end_date = (function_exists('get_field')) ? get_field('event_end_date', get_the_ID()) : ''; $end_date = empty($end_date) ? '' : $end_date;
				$event_info = array();
				$new_date = strtotime($start_date);
				$new_date = date_i18n('Y-m-d H:i', $new_date);
			?>
				<div class="k2t-recent-event k2t-element-hover">
					<?php echo ($post_thumb); ?>
					<div class="event-info">

						<div class="event-countdown-container">
							<div class="countdown-container"></div>
						</div>
						<div class="event-countdown-template">
						<<?php echo 'scr'.'ipt';?> type="text/template" class="countdown-template" data-startdate="<?php echo esc_attr($new_date)?>">
							<div class="time <%= label %>">
							  <span class="count curr top"><%= curr %></span>
							  <span class="count next top"><%= next %></span>
							  <span class="count next bottom"><%= next %></span>
							  <span class="count curr bottom"><%= curr %></span>
							  <span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
							</div>
						</<?php echo 'scr'.'ipt';?>>
						</div>


						<?php if(!empty($title)) : ?>
							<h3 class="title">
								<a href="<?php echo esc_url( $post_link );?>" title="<?php echo esc_attr( $title );?>">
									<?php echo esc_html($title);?>
								</a>
							</h3>
						<?php endif; ?>
						<div class="event-meta">
							<span class="date">
								<i class="zmdi zmdi-calendar-note"></i>
								<?= _e('Start Date: ','k2t') . esc_html( date_i18n( 'F d, Y - H:i', strtotime( $start_date ) ) ) ?>
							</span>
							<span class="date">
								<i class="zmdi zmdi-calendar-note"></i>
								<?= _e('End Date: ','k2t') . esc_html( date_i18n( 'F d, Y - H:i', strtotime( $end_date ) ) ) ?>
							</span>
							<?php if(!empty($event_address)) : ?>
								<span class="location">
									<i class="zmdi zmdi-pin"></i>
									<?php echo esc_html($event_address); ?>
								</span>
							<?php endif; ?>
						</div>
						<?php
							$recent_new = $related_new = '';
							
							if( ! empty( $recent_text_detail ) ){
								$recent_new = esc_html( $recent_text_detail );
							}
							else{
								$recent_new = esc_html__( 'Detail', 'k2t' ); 
							}
							if( ! empty( $k_recent_url ) ){
								$related_new = esc_url( $k_recent_url );
							}
							else{
								$related_new = esc_url( $post_link );
							}

						?>
						<a class="read-more btn-ripple" href="<?php echo $related_new;?>" title="<?php echo esc_attr( $title );?>"><?php echo $recent_new; ?></a>
					</div>
				</div>
			<?php		
				endwhile;
			endif; 
		?>

		<?php 
		$event_listing_html = ob_get_clean();
		wp_reset_postdata();
		return $event_listing_html;
		
		
		wp_reset_postdata();
	}
	add_shortcode('k_event_recent', 'k2t_recent_event_shortcode');
}


