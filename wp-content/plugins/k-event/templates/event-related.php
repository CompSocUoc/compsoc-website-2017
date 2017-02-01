<?php global $smof_data, $single_layout_class; $post;?>		

<?php
	$related = get_related_tag_posts_ids( get_the_ID(), $smof_data['event-related-number'], 'k-event-category', 'post-k-event');
?>
<div class="k2t-related-event k2t-element-hover">
	<?php 
		$related_post_title = $smof_data['event-related-title'];
		if(!empty($related_post_title)) :
	?>
		<h3 class="related-title"><?php echo esc_html($related_post_title);?></h3>
	<?php endif;?>
	
	<div class="related-event-inner clearfix">
		
			<?php
				$args = array(
					'post__in'      => $related,
					'post__not_in'  => array($post->ID),
					'orderby'       => 'post__in',
					'no_found_rows' => true,
					'post_type'		=> 'post-k-event'
				);
				$related_posts = get_posts( $args );
				if(count($related_posts) > 0)
				foreach ( $related_posts as $post ): setup_postdata($post);
					$thumb_html = '';
					if(has_post_thumbnail(get_the_ID())){
						$thumb_html = get_the_post_thumbnail(get_the_ID(), 'thumb_600x600', array('alt' => trim(get_the_title())));
					}else{
						$thumb_html = '<img src="' . plugin_dir_url( __FILE__ ) . 'images/thumb-400x256.png" alt="'.trim(get_the_title()).'" />';
					}
					$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'post' );
			?>
			<article class="related-event">
				<div class="related-inner">
					<div class="related-thumb">
						<a class="image-link" href="<?php the_permalink(get_the_ID())?>"><?php echo ( $thumb_html );?></a>
					</div>
					<div class="related-text">
						<h5><a href="<?php the_permalink(get_the_ID())?>" title="<?php the_title()?>"><?php the_title();?></a></h5>
						<div class="related-meta">
							<span class="date">
								<i class="zmdi zmdi-calendar-note"></i>
								<?php
									echo get_the_date();
								?>
							</span>
						</div><!-- .related-meta -->
					</div><!-- .related-text -->	
				</div><!-- .related-inner -->		
			</article><!-- .related-post -->
			<?php 	
					endforeach;
				wp_reset_postdata();
			?>

	</div><!-- .related-event-inner -->
	
</div><!-- .k2t-related-posts -->



