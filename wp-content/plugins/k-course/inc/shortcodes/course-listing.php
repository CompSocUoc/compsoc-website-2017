<?php

if( !function_exists('k_course_listing_shortcode') ){
	function k_course_listing_shortcode($atts, $content = null){

		extract( shortcode_atts( array(
			'style' 				=> 'style-1',
			'masonry_column' 		=> 'columns-2',
			'post_per_page'			=> '5',
			'category_course_id'	=> '',
			'course_date'			=> 'show',
			'course_price'			=> 'text',
			'course_pagination'		=> 'show',
			'course_carousel_navi'  => 'show',
			'course_masonry_filter' => 'show',
		), $atts));
		
		$html = '';

		switch ( $style ) {
			case 'style-2':
				$html .= K_Course::K_Render_course_listing_masonry( $post_per_page, $masonry_column, $course_masonry_filter , $course_pagination, $course_date, $course_price, $category_course_id );
				break;
			case 'style-3':
				$html .= K_Course::K_Render_course_listing_carousel( $course_carousel_navi, $post_per_page, $masonry_column, $course_pagination, $course_date, $course_price, $category_course_id );
				break;
			default:
				$html .= K_Course::K_Render_course_listing_default( $post_per_page , $course_pagination, $course_date, $category_course_id );
				break;
		}

		wp_reset_postdata();
		return $html;
	}
	
	add_shortcode('k_course_listing', 'k_course_listing_shortcode');
}