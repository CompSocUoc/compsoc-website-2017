<?php if($project_sidebar_content == 'show'):?>
	<div class="container clearfix">
	
		<div id="col-primary" class="site-content" role="main">
<?php else:?>
	<div id="col-primary" class="site-content" role="main">
	
		<div class="container">
<?php endif;?>
			<?php 
				if(has_post_thumbnail(get_the_ID())):
					$thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					echo '<div class="project-thumbnail post-thumbnail">
						<a href="'.$thumb_src[0].'" class="k2t-popup-link">'.get_the_post_thumbnail(get_the_ID(), 'full', array('alt'   => get_the_title())).'</a>
					</div><!-- .project-thumbnail -->';
				endif;
			?>
			<div class="project-meta">
				<span class="entry-date"><i class="zmdi zmdi-time"></i><?php echo get_the_date(); ?></span>
				<?php $tags = get_the_terms( get_the_ID(), 'k-project-tag' );?>
				<?php if ( is_array( $tags ) && count( $tags ) > 0 ) : ?>
					<span class="entry-tags">
					<?php
						$i = 1;
						foreach ( $tags as $key => $tag) {
							if ( $i == count( $tags ) ) {
								echo '<a href="'. get_term_link( $tag->term_id, 'k-project-tag' ) .'">'. $tag->name .'</a>';
							} else {
								echo '<a href="'. get_term_link( $tag->term_id, 'k-project-tag' ) .'">'. $tag->name .'</a>, ';
							}
							$i++;
						}
					?>
					</span>
				<?php endif;?>
			</div>
			<div class="project-text">
		
				<?php if($single_display_meta == 'show' && $project_sidebar_content != 'show'):?>
				<div class="project-fields">
					<div class="project-fields-inner">
						
						<ul class="project-info">
							<?php ob_start();?>
								<?php if(!empty($project_client)):?>
									<li>
										<p class="key"><?php _e('Client:', 'k2t');?></p>
										<span class="value"><?php echo esc_html($project_client);?></span>
									</li>
								<?php endif;?>

								<?php if(!empty($project_work)):?>
									<li>
										<p class="key"><?php _e('Work:', 'k2t');?></p>
										<span class="value"><?php echo esc_html($project_work);?></span>
									</li>
								<?php endif;?>

								<?php if(!empty($project_start_date) || !empty($project_end_date)):
									$first_date = strtotime($project_start_date);
									$second_date = strtotime($project_end_date);
									$offset = $second_date-$first_date; 
									$offset = floor($offset/60/60/24);
									if($offset > 1){
										$duration = $offset . ' days';
									} else {
										$duration = $offset . ' day';
									}
								?>
									<li>
										<p class="key"><?php _e('Duration:', 'k2t');?></p>
										<span class="value"><?php echo esc_html($duration);?></span>
									</li>
								<?php endif;?>
								<?php if(!empty($project_website)):?>
									<li>
										<p class="key"><?php _e('Website:', 'k2t');?></p>
										<a target="_blank" href="<?php echo esc_url($project_website_link);?>" class="value"><?php echo esc_html($project_website);?></a>
									</li>
								<?php endif;?>
							</ul>
							
							<?php if (function_exists( 'k2t_social_share' ) ) {k2t_social_share();}?>
							
							<?php if(!empty($project_text_link)):?>
								<a href="<?php echo esc_url($project_link);?>" target="_blank" class="project-link btn-ripple" ><?php echo !empty($project_text_link) ? $project_text_link : __('Launch Project', 'k2t'); ?></a>
							<?php endif;?>
						
					</div><!-- .project-fields-inner -->
				</div><!-- .project-fields -->
				<?php endif;?>
			
				<p class="project-content">
			
					<?php the_content();?>
					
				</p><!-- .project-content -->

			   
				
			</div><!-- .project-text -->
	   

<?php if($single_display_meta == 'show' && $project_sidebar_content == 'show'):?>
		</div><!-- #primary -->
		
		<div id="col-secondary">
			<div class="sidebar-inner k2t-element-hover">
				
				<div class="project-fields">
					<div class="project-fields-inner">
						<?php if ( is_array( $project_member ) && count( $project_member ) > 0 ) : ?>
							
							<div class="list-authors">
								<p class="title"><?php _e('Authors:', 'k2t');?></p>
								<?php foreach ( $project_member as $key => $teach ) : ?>
									<div class="item clearfix">
										<!-- Avatar of Speaker -->
										<?php if ( has_post_thumbnail( $teach->ID ) ) : ?>
											<div class="avatar k2t-element-hover">
												<?php echo get_the_post_thumbnail( $teach->ID, 'thumb_100x100' );?>
											</div>
										<?php endif;?>

										<a href="<?php echo esc_url($teach->guid);?>" class="name"><?php echo esc_html( $teach->post_title ); ?></a>
										<?php $position = get_field(  'teacher_position', $teach->ID );?>
										<?php if ( ! empty( $position ) ) : ?>
										<span class="role"><?php echo esc_html( $position ); ?></span>
										<?php endif;?>
									</div>
								<?php endforeach;?>
							</div>

						<?php endif;?>
						<ul class="project-info">
							<?php ob_start();?>
								<?php if(!empty($project_client)):?>
									<li>
										<p class="key"><?php _e('Client:', 'k2t');?></p>
										<span class="value"><?php echo esc_html($project_client);?></span>
									</li>
								<?php endif;?>

								<?php if(!empty($project_work)):?>
									<li>
										<p class="key"><?php _e('Work:', 'k2t');?></p>
										<span class="value"><?php echo esc_html($project_work);?></span>
									</li>
								<?php endif;?>

								<?php if(!empty($project_start_date) || !empty($project_end_date)):
									$first_date = strtotime($project_start_date);
									$second_date = strtotime($project_end_date);
									$offset = $second_date-$first_date; 
									$offset = floor($offset/60/60/24);
									if($offset > 1){
										$duration = $offset . ' days';
									} else {
										$duration = $offset . ' day';
									}
								?>
									<li>
										<p class="key"><?php _e('Duration:', 'k2t');?></p>
										<span class="value"><?php echo esc_html($duration);?></span>
									</li>
								<?php endif;?>
								<?php if(!empty($project_website)):?>
									<li>
										<p class="key"><?php _e('Website:', 'k2t');?></p>
										<a target="_blank" href="<?php echo esc_url($project_website_link);?>" class="value"><?php echo esc_html($project_website);?></a>
									</li>
								<?php endif;?>
							</ul>
							
							<?php if (function_exists( 'k2t_social_share' ) ) {k2t_social_share();}?>
							
							<?php if(!empty($project_link)):?>
								<a href="<?php echo esc_url($project_link);?>" target="_blank" class="project-link btn-ripple" ><?php echo !empty($project_text_link) ? $project_text_link : __('Launch Project', 'k2t'); ?></a>
							<?php endif;?>
						
					</div><!-- .project-fields-inner -->
				</div><!-- .project-fields -->
				
				<?php if(!empty($project_sidebar_text)):?>
				<div class="sidebar-content">
					<?php echo ( $project_sidebar_text );?>
				</div><!-- .sidebar-content -->	
				<?php endif;?>
			
			</div><!-- .sidebar-inner -->
		</div><!-- #secondary -->

		<div id="k2t-end-sidebar-sticky"></div>

		<div class="clear"></div>
				
		<?php if ( comments_open() ) :
				comments_template( '', false );
			endif;
		?>
	
	</div><!-- .container -->
	
   
<?php else:?>
		</div><!-- .container -->
	
	</div><!-- #primary -->
<?php endif;?>