<?php global $smof_data, $single_layout_class;?>		

<?php
	$related = get_related_tag_posts_ids( get_the_ID(), -1, 'k-project-category', 'post-k-project');
?>
<div class="k2t-related-project post-factor project-factor">
	<?php 
		$related_post_title = $smof_data['project-related-post-title'];
	?>
	<h3 class="related-title"><?php echo esc_html( $related_post_title );?></h3>
	
	<div class="k2t-owl-slider k2t-related-slider">
		
		<div class="owl-carousel" 
			data-items="4" data-autoPlay="false" data-margin="30" data-nav="<?php echo esc_attr( ( $smof_data['project-related-navigation'] == '1' ) ? 'true' : 'false' ); ?>"
			data-dots="<?php echo esc_attr( ( $smof_data['project-related-pagination'] == '1' ) ? 'true' : 'false' ); ?>" data-mobile="1" data-tablet="2" data-desktop="3">
			<?php
				$args = array(
					'post__in'      => $related,
					'post__not_in'  => array($post->ID),
					'orderby'       => 'post__in',
					'no_found_rows' => true, // no need for pagination
					'post_type'		=> 'post-k-project'
				);
				$related_posts = get_posts( $args );
				if(count($related_posts) > 0)
				foreach ( $related_posts as $post ): setup_postdata($post);
					$thumb_html = '';
					if(has_post_thumbnail(get_the_ID())){
						$thumb_html = get_the_post_thumbnail(get_the_ID(), 'thumb_400x256', array('alt' => trim(get_the_title())));
					}else{
						$thumb_html = '<img src="' . plugin_dir_url( __FILE__ ) . 'images/thumb-400x256.png" alt="'.trim(get_the_title()).'" />';
					}
					$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'post' );
					$project_member = (function_exists('get_field')) ? get_field('project_member', get_the_ID()) : ''; $project_member = empty($project_member) ? '' : $project_member;
			?>
			<article class="related-project">
				<div class="related-inner">
					<div class="related-thumb">
						<a class="image-link k2t-popup-link" href="<?php the_permalink(get_the_ID())?>"><?php echo ( $thumb_html );?></a>
						<?php if ( is_array( $project_member ) && count( $project_member ) > 0 ) : ?>
			                <div class="teacher-avatar">
			                    <?php foreach ( $project_member as $key => $teach ) : ?>
		                            <!-- Avatar of Speaker -->
		                            <?php if ( has_post_thumbnail( $teach->ID ) ) : ?>
		                                <div class="k2t-element-hover">
		                                    <a href="<?php echo get_the_permalink($teach->ID);?>" title="<?php echo get_the_title($teach->ID)?>"><?php echo get_the_post_thumbnail( $teach->ID, 'thumb_50x50' );?></a>
		                                </div>
		                            <?php endif;?>
			                    <?php endforeach;?>
			                </div>
			            <?php endif;?>
					</div>
					<div class="related-text">
						<h5><a href="<?php the_permalink(get_the_ID())?>" title="<?php the_title()?>"><?php the_title();?></a></h5>
						<div class="related-meta">
							<?php
								$categories = get_the_terms( get_the_ID(), 'k-project-category' );
								if ( count( $categories ) > 0 && is_array( $categories ) ) {
									$i = 0;
									foreach ( $categories as $key => $category ) {
										$term_link = get_term_link( $category->term_id, 'k-project-category' );
										if ( !is_wp_error( $term_link ) ){
											if ( $i == ( count( $categories ) - 1 ) ) {
												echo '<a href="' . esc_url( $term_link ) . '" title="' . $category->name . '">' . $category->name . '</a>';
											} else {
												echo '<a href="' . esc_url( $term_link ) . '" title="' . $category->name . '">' . $category->name . '</a>, ';
											}
										}
										$i++;
									}
								}
							?>
						</div><!-- .related-meta -->
					</div><!-- .related-text -->	
				</div><!-- .related-inner -->		
			</article><!-- .related-post -->
			<?php 	
					endforeach;
				wp_reset_postdata();
			?>
		</div><!-- .owl-carousel -->

	</div><!-- .k2t-swiper-slider -->
	
</div><!-- .k2t-related-posts -->



