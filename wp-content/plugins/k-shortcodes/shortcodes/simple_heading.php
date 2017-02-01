<?php
/* ------------------------------------------------------- */
/* Simple Heading
/* ------------------------------------------------------- */
if (!function_exists('k2t_simple_heading_shortcode')){
	function k2t_simple_heading_shortcode($atts,$content){
		extract(shortcode_atts(array(
			'h'				=>	'h2',
			'align'			=>  'left',
		), $atts));
		
		//Global $cl
		$cl = array('k2t-simple-heading');
		
		/*-----------Align-------------*/
		if(in_array(trim($align), array('left','right','center'))){ $cl[] = 'align-'.trim($align);} else {$cl[] = 'align-left';}
		
		/*-----------H tag and subtitle-------------*/
		if(!in_array(trim($h), array('h1','h2','h3','h4','h5','h6'))){$h = 'h2'; $cl[] = 'h2';} else {$h = trim($h); $cl[] = trim($h);}
		
		//Apply filters to cl
		$cl = apply_filters('k2t_simple_heading_classes',$cl);
		
		//Join cl class
		$cl = join(' ', $cl);
		
		$return = '<div class="'.trim($cl).'">';
		$return .= do_action('k2t_simple_heading_open');
		$return .= '<'.$h.' class="h">'.do_shortcode($content).'</'.$h.'>';
		$return .= do_action('k2t_simple_heading_close');
		$return .= '</div>';
		
		//Apply filters return
		$return = apply_filters('k2t_simple_heading_return',$return);
		
		return $return;	
	}
}