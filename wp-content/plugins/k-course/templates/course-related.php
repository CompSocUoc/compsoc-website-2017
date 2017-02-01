<?php global $smof_data, $single_layout_class, $post;?>		

<?php $related = get_related_tag_posts_ids( get_the_ID(), 10, 'k-course-category', 'post-k-course'); ?>
<?php if ( count( $related ) > 0 && is_array( $related ) ) : wp_enqueue_script( 'k2t-owlcarousel' );?>
	<!-- Course line --><hr/>
	<div class="k2t-related-course">
		<?php 
			$related_post_title = $smof_data['course-related-title'];
			if( ! empty( $related_post_title ) ) :
		?>
			<h3 class="related-title"><?php echo esc_html( $related_post_title );?></h3>
		<?php endif;?>
		
		<div class="related-course-inner clearfix k2t-owl-slider">
			<div class="owl-carousel"
			data-items="<?php echo ( count( $related ) == '1' )? '1' : '2'; ?>" data-autoPlay="false" data-margin="30" data-nav="<?php echo esc_attr( ( $smof_data['course-related-navigation'] == '1' ) ? 'true' : 'false' ); ?>"
			data-dots="<?php echo esc_attr( ( $smof_data['course-related-pagination'] == '1' ) ? 'true' : 'false' ); ?>" data-mobile="1" data-tablet="2" data-desktop="2">
				<?php
					$args = array(
						'post__in'      => $related,
						'post__not_in'  => array( $post->ID ),
						'orderby'       => 'post__in',
						'no_found_rows' => true, // no need for pagination
						'post_type'		=> 'post-k-course'
					);
					$related_posts = get_posts( $args );
					if ( count( $related_posts ) > 0 )
					foreach ( $related_posts as $post ): setup_postdata( $post );
						$thumb_html = '';
						if( has_post_thumbnail( get_the_ID() ) ) {
							$thumb_html = get_the_post_thumbnail( get_the_ID(), 'thumb_270x155', array( 'alt' => trim( get_the_title() ) ) );
						}else{
							$thumb_html = '<img src="' . plugin_dir_url( __FILE__ ) . 'images/thumb-400x256.png" alt="'.trim( get_the_title() ).'" />';
						}
						$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'post' );
				?>
				<article class="related-course">
					<div class="related-inner">
						<div class="related-thumb">
							<a class="image-link" href="<?php the_permalink( get_the_ID() ); ?>"><?php echo ( $thumb_html );?><i class="zmdi zmdi-plus k2t-element-hover btn-ripple"></i></a>
						</div>
						<div class="related-text">
							<div class="related-meta">
								<span class="date">
									<i class="zmdi zmdi-calendar-note"></i>
									<?php echo get_the_date(); ?>
								</span>
							</div><!-- .related-meta -->
							<h5><a href="<?php the_permalink( get_the_ID() ); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
						</div><!-- .related-text -->
					</div><!-- .related-inner -->		
				</article><!-- .related-post -->
				<?php 	
					endforeach;
					wp_reset_postdata();
				?>
			</div>

		</div><!-- .related-course-inner -->
		
	</div><!-- .k2t-related-posts -->
<?php endif;?>



