<?php

if( !function_exists('k_event_listing_shortcode') ){
	function k_event_listing_shortcode($atts, $content = null){

		extract( shortcode_atts( array(
			'style' 				=> 'style-1',
			'masonry_column' 		=> 'columns-2',
			'post_per_page'         => '4',
			'cate_event_id'		=> '',
			'number_post_show'		=> '9',
			'event_pagination'		=> 'show',
			'event_navigation'		=> 'show',
			'event_masonry_filter'  => 'show'
		), $atts));

		//include( plugin_dir_path( __FILE__ ) . '../class.k_event.php' );
		
		$html = '';

		switch ( $style ) {
			case 'style-1':
			case 'style-2':
				$html .= '<div id="calendar-box" class="k2t-calendar-event '. $style .'">'. K_Event::K_Render_event_listing_calendar( $style ) .'</div>';
				break;
			case 'style-3':
				$html .= K_Event::K_Render_event_listing_masonry( $masonry_column, $post_per_page, $event_pagination, $event_masonry_filter,$cate_event_id );
				break;
			case 'style-5':
				$html .= K_Event::K_Render_event_listing_carousel( $masonry_column, $number_post_show, $event_pagination, $event_navigation,$cate_event_id );
				break;
			default:
				$html .= K_Event::K_Render_event_listing_default( $post_per_page, $event_pagination, $cate_event_id );
				break;
		}

		wp_reset_postdata();
		return $html;
	}
	
	add_shortcode('k_event_listing', 'k_event_listing_shortcode');
}