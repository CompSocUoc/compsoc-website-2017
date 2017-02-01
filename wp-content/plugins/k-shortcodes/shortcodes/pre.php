<?php
/* ------------------------------------------------------- */
/* Pre Shortcode
/* ------------------------------------------------------- */
if (!function_exists('k2_pre_shortcode')){
	function k2_pre_shortcode($atts,$content){
		extract(shortcode_atts(array(
			'position'			=> 'top',
		), $atts));
		
		//Global $cl
		$cl = array('k2-pre');
		
		/*-----------Position-------------*/
		if(!in_array(trim($position), array('top','bottom','left','right'))){$cl[] = 'align-top';} else {$cl[] = 'align-'.trim($position);}
		
		//Apply filters to cl
		$cl = apply_filters('k2_pre_classes',$cl);
		
		//Join cl class
		$cl = join(' ', $cl);
		
		$return = '<div class="'.trim($cl).'">';
		$return .= do_action('k2_pre_open');
		$return .= do_shortcode($content);
		$return .= do_action('k2_pre_close');
		$return .= '</div>';
		
		//Apply filters return
		$return = apply_filters('k2_pre_return',$return);
		
		return $return;	
	}
}