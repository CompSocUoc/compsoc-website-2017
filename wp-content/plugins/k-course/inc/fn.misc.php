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

// Get all values of an associated array by a specified key
function k2t_course_array_values_deep($elem, $field = null){
	$holder = array();
	k2t_course_array_values_deep_($elem, $field, null, $holder);
	return $holder;
}

function k2t_course_array_values_deep_($elem, $field, $pre_field, &$holder){
	if( !is_array($elem) && !is_object($elem) ){
		if( !$field || ($field && $pre_field === $field) ){
			$holder[] = $elem;
		}
	}
	else{
		foreach($elem as $k => $e){
			k2t_course_array_values_deep_($e, $field, $k, $holder);
		}
	}
	
	return $holder;	
}