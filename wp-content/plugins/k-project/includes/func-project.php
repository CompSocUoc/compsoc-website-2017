<?php
/* ------------------------------------------------------------------------------ */
/* Function load single project
/* ------------------------------------------------------------------------------ */
if ( ! function_exists( 'k2t_load_single_project_ajax' ) ) {
	function k2t_load_single_project_ajax() {
		global $post, $wp_embed;
		$id = $_GET['id'];
		$post = get_post( $id );
		$html = '';
		if ( !empty( $post ) ){
			setup_postdata( $post );
			$post_thumb_size = 'full';
			$post_thumb = get_the_post_thumbnail( get_the_ID(), $post_thumb_size, array( 'alt' => trim( get_the_title() ) ) );
			$format = get_post_format( get_the_ID() ); 
			$format = empty( $format ) ? 'standard' : $format;

			// Load metadata in project
			$hover_link = (function_exists('get_field')) ? get_field('hover_link', get_the_ID()) : ''; $hover_link = empty($hover_link) ? '' : $hover_link;
			$project_video_format_url = (function_exists('get_field')) ? get_field('project_video_format_url', get_the_ID()) : ''; $project_video_format_url = empty($project_video_format_url) ? '' : $project_video_format_url;
			$project_video_code = (function_exists('get_field')) ? get_field('project_video_code', get_the_ID()) : ''; $project_video_code = empty($project_video_code) ? '' : $project_video_code;
			$project_audio_format_url = (function_exists('get_field')) ? get_field('project_audio_format_url', get_the_ID()) : ''; $project_audio_format_url = empty($project_audio_format_url) ? '' : $project_audio_format_url;
			$project_media_file = (function_exists('get_field')) ? get_field('project_media_file', get_the_ID()) : array(); $project_media_file = empty($project_media_file) ? array() : $project_media_file;
			$project_gallery = (function_exists('get_field')) ? get_field('project_gallery', get_the_ID()) : array(); $project_gallery = empty($project_gallery) ? array() : $project_gallery;


			$media_html = '';
			switch ( $format ) {
				case 'video':
					if ( !empty( $project_video_code ) ) {
			            $media_html = $project_video_code;
			        }elseif ( !empty( $project_video_format_url ) ) {
			            $media_html = $wp_embed->run_shortcode( '[embed]' . $project_video_format_url . '[/embed]' );
			        }elseif ( count( $project_media_file ) > 0 ) {
			            $media_html = do_shortcode( '[video src="'.$project_media_file['url'].'"/]' );
			        }
			        $html .= '<div class="k2t-thumbnail">' . $media_html . '</div><div class="k2t-popup-content">';
					break;
				case 'audio': 
					if ( count( $project_media_file ) > 0 ) {
			            $media_html = do_shortcode( '[audio src="'.$project_media_file['url'].'"/]' );
			        }else {
			            $media_html = $wp_embed->run_shortcode( '[embed]' . $project_audio_format_url . '[/embed]' );
			        }
			        $html .= '<div class="k2t-thumbnail">' . $media_html . '</div><div class="k2t-popup-content">';
					break;
				case 'gallery': 
					$html .= '
						<div class="k2t-thumbnail">
						<div class="k2t-swiper-slider" id="project_'. $id .'" data-auto="false" data-auto-time="5000" data-speed="300" data-pager="false" data-navi="true" data-touch="true" data-mousewheel="false"  data-loop="false" data-keyboard="false" data-perview="1">
			                <div class="k2t-swiper-slider-inner">
			                    <div class="k2t-swiper-slider-inner-deeper">
			                        <div class="k2t-swiper-container" data-settings="">
			                            <div class="swiper-wrapper k2t-popup-gallery">
			        ';
			                                foreach ( $project_gallery as $slide ): 
			                                	$image = $image_url = '';
			                                    if ( is_array( $slide ) && !empty( $slide['ID'] ) ):
			                                    	$image = wp_get_attachment_image( $slide['ID'], $post_thumb_size );
			                                    	$image_url = wp_get_attachment_url( $slide['ID'] );
			                                    elseif ( !empty( $slide ) ):
			                                    	$image = wp_get_attachment_image( $slide, $post_thumb_size );
			                                    	$image_url = wp_get_attachment_url( $slide );
			                                    endif;

			                                    $html .= '<div class="swiper-slide">';
			                                    if ( !empty( $hover_link ) ) {
				                                	$html .= '<a href="'. $hover_link .'">'. $image .'</a>';
				                                } else {
				                                	$html .= '<a href="'. $image_url .'">'. $image .'</a>';
				                                }
				                                $html .= '</div><!-- .swiper-slide -->';
			                                endforeach;
			        $html .= '
			                            </div><!-- .swiper-wrapper -->
			                        </div><!-- .swiper-container -->

			                        <div class="k2t-swiper-navi">
			                            <ul>
			                                <li><a class="prev"><i class="fa fa-chevron-left"></i></a></li>
			                                <li><a class="next"><i class="fa fa-chevron-right"></i></a></li>
			                            </ul>
			                        </div><!-- .k2t-swiper-navi -->

			                    </div><!-- .k2t-swiper-slider-inner-deeper -->
			                </div><!-- .k2t-swiper-slider-inner -->
			            </div><!-- .k2t-swiper-slider -->
			            </div><div class="k2t-popup-content">
					';
					break;
				default:
					$html .= '<div class="k2t-thumbnail">' . $post_thumb . '</div><div class="k2t-popup-content">';
					break;
			}

			
			$html .= '<h2 class="k2t-title">' . get_the_title() . '</h2>';
			$html .= '<div class="k2t-meta">' . get_the_date() . '</div>';
			$html .= '<div class="k2t-desc">' . get_the_content() . '</div></div>';
		}
		echo $html;
		wp_reset_postdata();
		die();
	}
	add_action('wp_ajax_k2t_load_single_project_ajax', 'k2t_load_single_project_ajax');
	add_action('wp_ajax_nopriv_k2t_load_single_project_ajax', 'k2t_load_single_project_ajax');
}






/**
 * Get related post
 *
 * @link http://wordpress.org/support/topic/custom-query-related-posts-by-common-tag-amount
 * @link http://pastebin.com/NnDzdSLd
 */
if ( ! function_exists( 'get_related_tag_posts_ids' ) ) {
	function get_related_tag_posts_ids( $post_id, $number = 5, $taxonomy = 'k-project-tag', $post_type = 'post' ) {

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

?>