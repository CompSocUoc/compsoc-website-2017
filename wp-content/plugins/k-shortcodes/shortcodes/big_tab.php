<?php
/* ------------------------------------------------------- */
/* Big Tab
/* ------------------------------------------------------- */
if (!function_exists('k2t_big_tab_shortcode')){
	function k2t_big_tab_shortcode($args,$content){
		extract(shortcode_atts(array(
			'active'			=> '1',
			'mouse'				=> 'click',
			'animation'			=> 'false',
			'direction'			=> 'horizontal',
		), $args));
		
		wp_enqueue_script('k2t-tabslet');
		
		//Global $cl
		$cl = array('k2t-tab');
		
		$cl[] = ('k2t-big-tab');
		
		/*--------------Active---------------*/
		if(!is_numeric(trim($active))){ $data_active = '1';} else { $data_active = trim($active); }
		
		/*--------------Animation---------------*/
		if(trim($animation) != 'true'){ $data_animation = 'false';} else { $data_animation = 'true'; }
		
		/*--------------Mouse---------------*/
		if(trim($mouse) != 'hover'){ $data_mouse = 'click';} else { $data_mouse = 'hover'; $data_animation = 'false'; }
		
		/*--------------Direction---------------*/
		if(trim($direction) == 'vertical'){ $cl[] = 'tab-vertical';}
		

		if (!preg_match_all("/(.?)\[(tab_element)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab_element\])?(.?)/s", $content, $matches)) :
			return do_shortcode($content);
		else :
			
			$number_element = count($matches[0]);
			
			$cl[] = 'tab-'.$number_element;
			
			//Apply filters to cl
			$cl = apply_filters('k2t_big_tab_classes',$cl);
			
			//Join cl class
			$cl = join(' ', $cl);
			
			$return = '<div class="'.trim($cl).'" data-active="'.$data_active.'" data-mouse="'.$data_mouse.'" data-animation="'.$data_animation.'">';
			$return .= do_action('k2t_big_tab_open');
			$return .= '<ul class="tabnav">';
			
			//List tab
			for($i = 0; $i < count($matches[0]); $i++):
				
				$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
				
				$title = isset( $matches[3][$i]['title'] ) ? trim($matches[3][$i]['title']) : '';
				$icon = isset( $matches[3][$i]['icon'] ) ? trim($matches[3][$i]['icon']) : '';
				
				//Check and set parameter of toggle
				
				/*-----------Title-------------*/
				if($title == ''){ $title_tab = 'Tab Title';}else { $title_tab = $title;}
				
				/*-----------Icon-------------*/
				if($icon != ''){ $icon_html = '<i class="icon-'.$icon.'"></i>';} else { $icon_html = '';}
				
				$return .= '<li><a data-href="#tab-'.($i+1).'">'.$icon_html.'<span>'.$title_tab.'</span></a></li>';
			endfor;
			
			$return .= '</ul>';
			//Content for tab
			for($i = 0; $i < count($matches[0]); $i++):
				$return .= '<div id="tab-'.($i+1).'" class="tab-content">'.do_shortcode($matches[5][$i]).'</div>';
			endfor;
			
			$return .= do_action('k2t_big_tab_close');
			$return .= '</div>';
			
			//Apply filters return
			$return = apply_filters('k2t_big_tab_return',$return);
			
			return $return;
			
		endif;
	}
}