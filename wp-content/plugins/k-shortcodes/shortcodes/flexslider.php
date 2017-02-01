<?php
/* ------------------------------------------------------- */
/* FlexSlider
/* ------------------------------------------------------- */
if (!function_exists('k2t_flexslider_shortcode')){
	function k2t_flexslider_shortcode($atts,$content){
		extract(shortcode_atts(array(
			'effect'			=> 'fade',
			'auto'				=> 'false',
			'auto_time'			=> '4000',
			'speed'				=> '500',
			'pager'				=> 'true',
			'navi'				=> 'true',
		), $atts));
		
		wp_enqueue_script('jquery-flexslider');
		wp_enqueue_style('flexslider');
		
		//Global $cl and $data
		$cl = array('k2t-flexslider');
		$data = array();
		
		/*--------------Effect--------------*/
		if(trim($effect) != 'slide'){$data[] = 'data-effect="fade"';} else { $data[] = 'data-effect="slide"';}
		
		/*--------------Auto--------------*/
		if(trim($auto) != 'true'){$data[] = 'data-auto="false"';} else { $data[] = 'data-auto="true"';}
		
		/*--------------Auto time--------------*/
		if(is_numeric(trim($auto_time))){$data[] = 'data-auto-time="'.trim($auto_time).'"';} else { $data[] = 'data-auto-time="4000"';}
		
		/*--------------Speed--------------*/
		if(is_numeric(trim($speed))){$data[] = 'data-speed="'.trim($speed).'"';} else { $data[] = 'data-speed="500"';}
		
		/*--------------Pager--------------*/
		if(trim($pager) != 'true'){$data[] = 'data-pager="false"';} else { $data[] = 'data-pager="true"';}
		
		/*--------------Navi--------------*/
		if(trim($navi) != 'false'){$data[] = 'data-navi="true"';} else { $data[] = 'data-navi="false"';}
		

		if (!preg_match_all("/(.?)\[(slide)\b(.*?)(?:(\/))?\](?:(.+?)\[\/slide\])?(.?)/s", $content, $matches)) :
			return do_shortcode($content);
		else :
			
			//Apply filters to cl
			$cl = apply_filters('k2t_flexslider_classes',$cl);
			
			//Join cl class
			$cl = join(' ', $cl);
			
			//Join $data
			$data = join(' ', $data);
			
			$return = '<div class="'.esc_attr(trim($cl)).'" '.trim($data).'><div class="flexslider"><ul class="slides">';
			$return .= do_action('k2t_flexslider_open');
			
			for($i = 0; $i < count($matches[0]); $i++):

				$return .= '<li class="slide">'.do_shortcode($matches[5][$i]).'</li>';
				
			endfor;
			
			$return .= do_action('k2t_flexslider_close');
			$return .= '</ul></div></div>';
			
			//Apply filters return
			$return = apply_filters('k2t_flexslider_return',$return);
			
			return $return;
			
		endif;
	}
}