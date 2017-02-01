<?php
/* ------------------------------------------------------- */
/* Big Accordion
/* ------------------------------------------------------- */
if (!function_exists('k2t_big_accordion_shortcode')){
	function k2t_big_accordion_shortcode($args,$content){
		
		wp_enqueue_script('k2t-collapse');
		
		//Global $cl
		$cl = array('k2t-accordion');
		
		$cl[] = 'k2t-big-accordion';

		if (!preg_match_all("/(.?)\[(toggle)\b(.*?)(?:(\/))?\](?:(.+?)\[\/toggle\])?(.?)/s", $content, $matches)) :
			return do_shortcode($content);
		else :
			
			//Apply filters to cl
			$cl = apply_filters('k2t_big_accordion_classes',$cl);
			
			//Join cl class
			$cl = join(' ', $cl);
			
			$return = '<div class="'.trim($cl).'">';
			$return .= do_action('k2t_big_accordion_open');
			
			for($i = 0; $i < count($matches[0]); $i++):
				
				$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
				
				$title = isset( $matches[3][$i]['title'] ) ? trim($matches[3][$i]['title']) : '';
				$subtitle = isset( $matches[3][$i]['subtitle'] ) ? trim($matches[3][$i]['subtitle']) : '';
				$open = isset( $matches[3][$i]['open'] ) ? trim($matches[3][$i]['open']) : 'false';
				
				//Check and set parameter of toggle
				
				/*-----------Title-------------*/
				if($title == ''){ $title_toggle = 'Toggle Title';}else { $title_toggle = $title;}
				
				/*-----------Subtitle-------------*/
				if($subtitle != ''){ $subtitle_html = '<span class="subtitle">'.$subtitle.'</span>';}else { $subtitle_html = '';}
				
				/*-----------Open-------------*/
				if($open == 'true'){ $open_class = ' open';} else { $open_class = '';}
				
				$return .= '<h2 class="toggle-title big-toggle-title"><span class="toggle-t"><span class="main-title">'.$title_toggle.'</span>'.$subtitle_html.'</span></h2><div class="toggle-content big-toggle-content"><p>'.do_shortcode($matches[5][$i]).'</p></div>';
				
			endfor;
			
			$return .= do_action('k2t_big_accordion_close');
			$return .= '</div>';
			
			//Apply filters return
			$return = apply_filters('k2t_big_accordion_return',$return);
			
			return $return;
			
		endif;
	}
}