<?php
/* ------------------------------------------------------- */
/* Big Toggle
/* ------------------------------------------------------- */
if (!function_exists('k2t_big_toggle_shortcode')){
	function k2t_big_toggle_shortcode($atts,$content){
		extract(shortcode_atts(array(
			'title'				=>	'Toggle Title',
			'subtitle'			=> 	'',
			'open'				=>	'false',
		), $atts));
		
		//Global $cl
		$cl = array('k2t-toggle');
		
		$cl[] = 'k2t-big-toggle';
		
		//Enqueue Script Collapse
		wp_enqueue_script('k2t-collapse');
		
		/*-----------Title-------------*/
		if(trim($title) == ''){$title = 'Toggle Title';} else {$title = trim($title);}
		
		/*-----------Subtitle-------------*/
		if(trim($subtitle) == ''){ $subtitle_html = ''; } else { $subtitle_html = '<span class="subtitle">'.trim($subtitle).'</span>';}
		
		/*-----------Open-------------*/
		if(trim($open) == 'true'){ $class_open = ' open';} else { $class_open = ''; }
		
		//Apply filters to cl
		$cl = apply_filters('k2t_big_toggle_classes',$cl);
		
		//Join cl class
		$cl = join(' ', $cl);
		
		$return = '<div class="'.trim($cl).'">';
		$return .= do_action('k2t_big_toggle_open');
		$return .= '<h2 class="toggle-title big-toggle-title'.$class_open.'"><span class="toggle-t"><span class="main-title">'.$title.'</span>'.$subtitle_html.'</span></h2><div class="toggle-content big-toggle-content"><p>'.do_shortcode($content).'</p></div>';
		$return .= do_action('k2t_big_toggle_close');
		$return .= '</div>';
		
		//Apply filters return
		$return = apply_filters('k2t_big_toggle_return',$return);
		
		return $return;	
	}
}