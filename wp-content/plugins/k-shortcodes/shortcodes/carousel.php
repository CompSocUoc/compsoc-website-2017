<?php
/* ------------------------------------------------------- */
/* Carousel
/* ------------------------------------------------------- */
if (!function_exists('k2t_carousel_shortcode')){
	function k2t_carousel_shortcode($atts,$content){
		extract(shortcode_atts(array(
			'column'			=> '3',
			'auto'				=> 'false',
			'auto_time'			=> '5000',
			'speed'				=> '500',
			'pager'				=> 'true',
			'navi'				=> 'true',
			'touch'				=> 'true',
			'mousewheel'		=> 'false',
			'loop'				=> 'true',
			'keyboard'			=> 'false',
		), $atts));
		
		//Global $cl and $data
		$cl = array('k2t-swiper-slider');
		$data = array();
		
		$cl[] = 'k2t-carousel';
		
		/*--------------Column--------------*/
		if(in_array(trim($column), array('1','2','3','4','5','6','7'))){$data[] = 'data-perview="'.trim($column).'"';} else { $data[] = 'data-perview="3"';}
		
		/*--------------Auto--------------*/
		if(trim($auto) != 'true'){$data[] = 'data-auto="false"';} else { $data[] = 'data-auto="true"';}
		
		/*--------------Auto time--------------*/
		if(is_numeric(trim($auto_time))){$data[] = 'data-auto-time="'.trim($auto_time).'"';} else { $data[] = 'data-auto-time="5000"';}
		
		/*--------------Speed--------------*/
		if(is_numeric(trim($speed))){$data[] = 'data-speed="'.trim($speed).'"';} else { $data[] = 'data-speed="5000"';}
		
		/*--------------Pager--------------*/
		if(trim($pager) != 'false'){$data[] = 'data-pager="true"';} else { $data[] = 'data-pager="false"';}
		
		/*--------------Navi--------------*/
		if(trim($navi) != 'false'){$data[] = 'data-navi="true"';} else { $data[] = 'data-navi="false"';}
		
		/*--------------Touch--------------*/
		if(trim($touch) != 'false'){$data[] = 'data-touch="true"';} else { $data[] = 'data-touch="false"';}
		
		/*--------------Mousewheel--------------*/
		if(trim($mousewheel) != 'true'){$data[] = 'data-mousewheel="false"';} else { $data[] = 'data-mousewheel="true"';}
		
		/*--------------Loop--------------*/
		if(trim($loop) != 'false'){$data[] = 'data-loop="true"';} else { $data[] = 'data-loop="false"';}
		
		/*--------------Keyboard--------------*/
		if(trim($keyboard) != 'true'){$data[] = 'data-keyboard="false"';} else { $data[] = 'data-keyboard="true"';}
		

		if (!preg_match_all("/(.?)\[(carousel_item)\b(.*?)(?:(\/))?\](?:(.+?)\[\/carousel_item\])?(.?)/s", $content, $matches)) :
			return do_shortcode($content);
		else :
			
			//Apply filters to cl
			$cl = apply_filters('k2t_carousel_classes',$cl);
			
			//Join cl class
			$cl = join(' ', $cl);
			
			//Join $data
			$data = join(' ', $data);
						
			$return = '<div class="'.trim($cl).'" '.trim($data).'><div class="k2t-swiper-slider-inner"><div class="k2t-swiper-slider-inner-deeper"><div class="k2t-swiper-container"><div class="swiper-wrapper">';
			$return .= do_action('k2t_carousel_open');
			
			for($i = 0; $i < count($matches[0]); $i++):	
				$return .= '<div class="swiper-slide"><div class="swiper-slide-inner">'.do_shortcode($matches[5][$i]).'</div></div>';	
			endfor;
			
			$return .= do_action('k2t_carousel_close');
			$return .= '</div></div>';
			$return .= ($navi=='true') ? '<div class="k2t-swiper-navi"><ul><li><a class="prev"><i class="icon-chevron-left"></i></a></li><li><a class="next"><i class="icon-chevron-right"></i></a></li></ul></div>' : '';
			$return .= '</div>';
			$return .= ($pager=='true') ? '<div class="pagination" id="'.$pagination_id.'"></div>' : '';
			$return .= '</div></div>';
			
			//Apply filters return
			$return = apply_filters('k2t_carousel_return',$return);
			
			return $return;
			
		endif;
	}
}