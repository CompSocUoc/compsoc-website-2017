<?php

if( !function_exists('k_teacher_listing_shortcode') ){
	function k_teacher_listing_shortcode($atts, $content = null){
		extract( shortcode_atts( array(
			'style' 				=> 'style-classic',
			'column' 		        => '4',
			'teacher_per_page'      => '12',
			'excerpt'		        => 'show',
			'excerpt_length'		=> '15',
			'cat'					=> '',
		), $atts));

		// include( plugin_dir_path( __FILE__ ) . '../class.k_teacher.php' );
		
		$html = k2t_get_template_part('teacher', 'listing', array(
            'style' 				=> $style,
            'column' 		        => $column,
            'teacher_per_page'      => $teacher_per_page,
            'excerpt'		        => $excerpt,
            'excerpt_length'		=> $excerpt_length,
			'cat'					=> $cat,
            )
        );

		wp_reset_postdata();

		return $html;
	}
	
	add_shortcode('k_teacher_listing', 'k_teacher_listing_shortcode');
}