<?php global $smof_data, $wp_embed;
get_header();

// Register variables
$classes 						= array();
$single_pre 					= 'teacher_';

// Get metadata of teacher in single
$arr_teacher_meta_val  	= array();
$arr_teacher_meta 		= array(
	// Layout
	'layout'						=> 'right_sidebar',
	'custom_sidebar' 				=> '',

	// Location
	'subjects'						=> '',
	'phone_number'					=> '',
	'facebook'						=> '',
	'instagram'						=> '',
	'email'							=> '',
	'twitter'						=> '',
	'linkedin'						=> '',
	'tumblr'						=> '',
	'google_plus'					=> '',
	'pinterest'						=> '',
	'youtube'						=> '',
	'flickr'						=> '',
	'github'						=> '',
	'dribbble'						=> '',
	'vk'							=> '',

	'facebook_text'						=> '',
	'instagram_text'					=> '',
	'email_text'						=> '',
	'twitter_text'						=> '',
	'linkedin_text'						=> '',
	'tumblr_text'						=> '',
	'google_plus_text'					=> '',
	'pinterest_text'					=> '',
	'youtube_text'						=> '',
	'flickr_text'						=> '',
	'github_text'						=> '',
	'dribbble_text'						=> '',
	'vk_text'							=> '',
);

foreach ( $arr_teacher_meta as $meta => $val ) {
	if ( function_exists( 'get_field' ) ) {
		if ( get_field( $single_pre . $meta, $id ) ) {
			$arr_teacher_meta_val[$meta] = get_field( $single_pre . $meta, $id );
		}
	}
}
extract( shortcode_atts( $arr_teacher_meta, $arr_teacher_meta_val ) );


wp_enqueue_script( 'teacher' );

// Layout of single teacher
if ( ( empty( $layout ) || $layout == 'default' ) && ! empty( $smof_data['teacher-layout'] ) ) {
	if( isset( $smof_data['rtl_lang'] ) && $smof_data['rtl_lang'] == '1' ){
		$layout = 'left_sidebar';
	}
	else
		$layout = $smof_data['teacher-layout'];
} else if ( empty( $smof_data['teacher-layout'] ) ) {
	$layout = 'right_sidebar';
}
if ( 'right_sidebar' == $layout ){	
	$classes[] = 'right-sidebar';
} elseif ( 'left_sidebar' == $layout ) {
	$classes[] = 'left-sidebar';
} elseif ( 'no_sidebar' == $layout ) {
	$classes[] = 'no-sidebar';
}

?>

	<div class="k2t-content <?php echo implode( ' ', $classes ) ?>">
		<div class="k2t-wrap">
			<main class="k2t-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<div id="main-col" <?php post_class(); ?>>

						<div class="k2t-row">
							<div class="teacher-entry-meta col-4">
								<div class="k2t-element-hover">
									<?php if(has_post_thumbnail(get_the_ID())):?>
										<div class="teacher-thumbnail">
											<?php
												echo get_the_post_thumbnail(get_the_ID(), 'thumb_500x500', array('alt'   => get_the_title()));
											?>
										</div>
									<?php endif;?>
									<div class="entry-meta-inner">
										<div class="entry_teacher_number">
											<?php if( !empty($phone_number) ) :?>
												<i class="fa fa-phone"></i><span class="teacher_phone_number"><?= esc_html( $phone_number ); ?></span>
											<?php endif;?>
										</div>
										<ul class="teacher_social">
						                	<?php if(!empty($facebook) || !empty($facebook_text)) : ?>
						                		<li>
						                			<a target='_blank' href="<?php echo esc_url($facebook);?>">
						                				<i class='fa fa-facebook'></i><?php echo esc_html($facebook_text);?>
						                			</a>
						                		</li>
						               		<?php endif; ?>
						               		<?php if(!empty($instagram) || !empty($instagram_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($instagram);?>">
							                			<i class='fa fa-instagram'></i><?php echo esc_html($instagram_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($email) || !empty($email_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($email);?>">
							                			<i class="fa fa-envelope"></i><?php echo esc_html($email_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($twitter) || !empty($twitter_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($twitter);?>">
							                			<i class='fa fa-twitter'></i><?php echo esc_html($twitter_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($linkedin) || !empty($linkedin_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($linkedin);?>">
							                			<i class='fa fa-linkedin'></i><?php echo esc_html($linkedin_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($tumblr) || !empty($tumblr_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($tumblr);?>">
							                			<i class='fa fa-tumblr'></i><?php echo esc_html($tumblr_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($google_plus) || !empty($google_plus_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($google_plus);?>">
							                			<i class='fa fa-google-plus'></i><?php echo esc_html($google_plus_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($pinterest) || !empty($pinterest_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($pinterest);?>">
							                			<i class='fa fa-pinterest'></i><?php echo esc_html($pinterest_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($youtube) || !empty($youtube_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($youtube);?>">
							                			<i class='fa fa-youtube'></i><?php echo esc_html($youtube_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($flickr) || !empty($flickr_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($flickr);?>">
							                			<i class='fa fa-flickr'></i><?php echo esc_html($flickr_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($github) || !empty($github_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($github);?>">
							                			<i class='fa fa-github'></i><?php echo esc_html($github_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($dribbble) || !empty($dribbble_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($dribbble);?>">
							                			<i class='fa fa-dribbble'></i><?php echo esc_html($dribbble_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						               		<?php if(!empty($vk) || !empty($vk_text)) : ?>
							               		<li>
							                		<a target='_blank' href="<?php echo esc_url($vk);?>">
							                			<i class='fa fa-vk'></i><?php echo esc_html($vk_text);?>
							                		</a>
							                	</li>
						               		<?php endif; ?>
						                </ul>

									</div><!--entry-meta-inner-->
								</div>
							</div>
							<div class="teacher-entry-content col-8">

								<h3 class="h"><i class="zmdi zmdi-account"></i><span><?php _e( 'Bio', 'k2t' )?></span></h3>
								<div class="content">
									<?php the_content();?>
								</div>
								<?php if( !empty($subjects) ) :?>
									<h3 class="h"><i class="zmdi zmdi-graduation-cap"></i><span><?php _e( 'Subjects', 'k2t' )?></span></h3>
									<div class="subject"><?php echo esc_html( $subjects ); ?></div>
								<?php endif;?>

							</div>
						</div>


						<div class="teacher-connect">
							<?php
								$courses = k_teacher_get_courses(get_the_ID());
								if(count($courses) > 0) : ?>

								<h3 class="h"><?php _e( 'Courses', 'k2t' )?></h3>
								<table class="course-info k2t-element-hover">
									<thead>
										<tr>
											<th class="id">ID</th>
											<th>Course Name</th>
											<th>Duration</th>
											<th>Start Date</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach($courses as $course){
												$courseID = (function_exists('get_field')) ? get_field('course_id', $course->ID) : ''; $courseID = empty($courseID) ? '' : $courseID;

												$courseName = $course->post_title ;
												$link = get_the_permalink($course->ID);
												$courseDuration = (function_exists('get_field')) ? get_field('course_duration', $course->ID) : ''; $courseDuration = empty($courseDuration) ? '' : $courseDuration;
												$startDate = (function_exists('get_field')) ? get_field('course_start_date', $course->ID) : ''; $startDate = empty($startDate) ? '' : $startDate;
												
												$newDate = date("F d, Y", strtotime($startDate));
												$html = '';
												$html .= '<tr><td class="id">'.$courseID.'</td>';
												$html .= '<td><a href="'.$link.'" title="'.$courseName.'" >'.$courseName.'</a></td>';
												$html .= '<td>'.$courseDuration.'</td>';
												$html .= '<td>'.$newDate.'</td></tr>';
												echo ($html);
											}
										?>
									</tbody>
								</table>
							<?php endif; ?>

							<?php
							$events = k_teacher_get_events(get_the_ID());
							if(count($events) > 0) : ?>
								<h3 class="h"><?php _e( 'Event', 'k2t' )?></h3>
								<table class="course-info k2t-element-hover">
									<thead>
										<tr>
											<th class="id">ID</th>
											<th>Event Name</th>
											<th>Duration</th>
											<th>Start Date</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach($events as $event){
												$eventID = (function_exists('get_field')) ? get_field('event_event_id',  $event->ID) : ''; $eventID = empty($eventID) ? '' : $eventID;
					
												$eventName = $event->post_title;
												$link = get_the_permalink($event->ID);
												$startDate = (function_exists('get_field')) ? get_field('event_start_date', $event->ID) : ''; $startDate = empty($startDate) ? '' : $startDate;
												$endDate = (function_exists('get_field')) ? get_field('event_end_date', $event->ID) : ''; $endDate = empty($endDate) ? '' : $endDate;
			
												$newDate = date("F d, Y", strtotime($startDate));

												$datetimeStart = new DateTime($startDate);
												$datetimeEnd = new DateTime($endDate);
												$eventDuration = $datetimeEnd->diff($datetimeStart)->format('%a days');

												$html = '';
												$html .= '<tr><td class="id">'.$eventID.'</td>';
												$html .= '<td><a href="'.$link.'" title="'.$eventName.'" >'.$eventName.'</a></td>';
												$html .= '<td>'.$eventDuration.'</td>';
												$html .= '<td>'.$newDate.'</td></tr>';
												echo ($html);
											}
										?>
									</tbody>
								</table>
							<?php endif; ?>

						</div><!--teacher-connect-->

					</div><!-- #main-col -->

				<?php endwhile; ?>
				<div class="clear"></div>
				
				<?php if ( comments_open() ) :
						comments_template( '', false );
					endif;
				?>

			</main><!-- .k2t-blog -->

			<?php
				if ( 'right_sidebar' == $layout || 'left_sidebar' == $layout ) {
					get_sidebar();
				}
			?>

		</div><!-- .k2t-wrap -->
	</div><!-- .k2t-content -->

<?php get_footer(); ?>