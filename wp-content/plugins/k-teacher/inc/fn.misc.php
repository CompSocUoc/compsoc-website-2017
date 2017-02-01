<?php
/* ------------------------------------------------------------------------------ */



/**
 * Get related post
 *
 * @link http://wordpress.org/support/topic/custom-query-related-posts-by-common-tag-amount
 * @link http://pastebin.com/NnDzdSLd
 */
if ( ! function_exists( 'get_related_tag_posts_ids' ) ) {
	function get_related_tag_posts_ids( $post_id, $number = 5, $taxonomy = 'post_tag', $post_type = 'post' ) {

		$related_ids = false;

		$post_ids = array();
		// get tag ids belonging to $post_id
		$tag_ids = wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );
		if ( $tag_ids ) {
			// get all posts that have the same tags
			$tag_posts = get_posts(
				array(
					'post_type'   => $post_type,
					'posts_per_page' => -1, // return all posts
					'no_found_rows'  => true, // no need for pagination
					'fields'         => 'ids', // only return ids
					'post__not_in'   => array( $post_id ), // exclude $post_id from results
					'tax_query'      => array(
						array(
							'taxonomy' => $taxonomy,
							'field'    => 'id',
							'terms'    => $tag_ids,
							'operator' => 'IN'
						)
					)
				)
			);

			// loop through posts with the same tags
			if ( $tag_posts ) {
				$score = array();
				$i = 0;
				foreach ( $tag_posts as $tag_post ) {
					// get tags for related post
					$terms = wp_get_post_terms( $tag_post, $taxonomy, array( 'fields' => 'ids' ) );
					$total_score = 0;

					foreach ( $terms as $term ) {
						if ( in_array( $term, $tag_ids ) ) {
							++$total_score;
						}
					}

					if ( $total_score > 0 ) {
						$score[$i]['ID'] = $tag_post;
						// add number $i for sorting
						$score[$i]['score'] = array( $total_score, $i );
					}
					++$i;
				}

				// sort the related posts from high score to low score
				uasort( $score, 'sort_tag_score' );
				// get sorted related post ids
				$related_ids = wp_list_pluck( $score, 'ID' );
				// limit ids
				$related_ids = array_slice( $related_ids, 0, (int) $number );
			}
		}
		return $related_ids;
	}
}


/* ------------------------------------------------------------------------------ */
/* Pagination
/* ------------------------------------------------------------------------------ */
if ( !function_exists('k2t_pagination') ) {
 function k2t_pagination( $custom_query = false ){
  global $wp_query;
  
  if ( !$custom_query ) $custom_query = $wp_query;

  $big = 999999999; // need an unlikely integer
  echo '<div class="k2t-pagination">';
   echo paginate_links( array(
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $custom_query->max_num_pages,
    'type'   => 'list',
    'prev_text'    => sprintf( __('%s Previous','wi'), '<i class="icon-angle-left"></i>' ),
    'next_text'    => sprintf( __('Next %s','wi'), '<i class="icon-angle-right"></i>' ),
   ) );
  echo '<div class="clearfix"></div></div>';
 }
}

/* ------------------------------------------------------------------------------ */
// Get a real label
if( !function_exists('k2t_get_object_label') ){
	function check_matches($matches){ return ' '.ucfirst($matches[1]); }
	function k2t_get_object_label($object_name){
		$object_name = preg_replace_callback('/[^a-z0-9]+(\w{1,})/i', check_matches($matches), strtolower(trim($object_name)));
		return ucfirst($object_name);
	}
}

// Get all values of an associated array by a specified key
function k2t_teacher_array_values_deep($elem, $field = null){
	$holder = array();
	k2t_teacher_array_values_deep_($elem, $field, null, $holder);
	return $holder;
}

function k2t_teacher_array_values_deep_($elem, $field, $pre_field, &$holder){
	if( !is_array($elem) && !is_object($elem) ){
		if( !$field || ($field && $pre_field === $field) ){
			$holder[] = $elem;
		}
	}
	else{
		foreach($elem as $k => $e){
			k2t_teacher_array_values_deep_($e, $field, $k, $holder);
		}
	}
	
	return $holder;	
}


/**
 * Function k2t_get_template_part
 * Like wordpress function get_template_part with override templates file.
 * All file in k-teacher/templates can be override in themes/theme_name/k-teacher/
 *
 */
if (!function_exists('k2t_get_template_part')) {
	function k2t_get_template_part($slug = null, $name = null, array $params = array())
	{
		global $wp_query;
		$template_slug = K_TEACHER_PLG_DIRECTORY . '/' . $slug;
		do_action("get_template_part_{$template_slug}", $template_slug, $name);

		$templates = array();
		if (isset($name)){
			$templates[] = "{$template_slug}-{$name}.php";
		}

		$templates[] = "{$template_slug}.php";

		$_template_file = locate_template($templates, false, false);

		if (is_array($wp_query->query_vars)) {
			extract($wp_query->query_vars, EXTR_SKIP);
		}
		extract($params, EXTR_SKIP);

		ob_start();
		if (file_exists($_template_file)) {
			include($_template_file);
		} else  {
			$templates = array();
			if (isset($name)){
				$templates[] = "{$slug}-{$name}.php";
			}
			$templates[] = "{$slug}.php";

			if((file_exists(K_TEACHER_PLG_PATH . '/templates/' . $templates[0])))
				include(K_TEACHER_PLG_PATH . '/templates/' . $templates[0]);
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}


if(!function_exists('k_teacher_get_events')){
	function k_teacher_get_events($teacherId){
		$event_args = array(
			'post_type'			=> 'post-k-event',
			'posts_per_page'	=> -1,
			'orderby'			=> 'date',
			'order'				=> 'DESC'
		);

		$eventsJoined = array();

		$events = get_posts($event_args);

		if(is_array($events) && count($events) > 0){
			foreach($events as $event){
				$teachers = get_field('event_teacher', $event->ID);
				if( is_array($teachers) &&  count($teachers) > 0){
					foreach($teachers as $teacher){
						if($teacher->ID == $teacherId){
							$eventsJoined[] = $event;
						}
					}
				}
			}
		}
		return $eventsJoined;
	}
}

if(!function_exists('k_teacher_get_courses')){
	function k_teacher_get_courses($teacherId){
		$course_args = array(
			'post_type'			=> 'post-k-course',
			'posts_per_page'	=> -1,
			'orderby'			=> 'date',
			'order'				=> 'DESC'
		);

		$coursesJoined = array();

		$courses = get_posts($course_args);

		if(is_array($courses) && count($courses) > 0){
			foreach($courses as $course){
				$teachers = get_field('course_teacher', $course->ID);
				if(is_array($teachers) && count($teachers) > 0){
					foreach($teachers as $teacher){
						if($teacher->ID == $teacherId){
							$coursesJoined[] = $course;
						}
					}
				}
			}
		}
		return $coursesJoined;
	}
}