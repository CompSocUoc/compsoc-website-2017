<?php
/* ------------------------------------------------------- */
/* Columns
/* ------------------------------------------------------- */
if (!function_exists('k2t_column_shortcode')){
	function k2t_column_shortcode($atts,$content = NULL){
		extract(shortcode_atts(array(
			'size'		=>  '1/2',
			'last'		=>	'false',
		), $atts));
		
		//Global $cl
		$cl = array('k2t-column');
		
		/*-------------Last Column------------*/
		$clearfix = '';
		if($last == 'true'){$cl[] = 'column-last'; $clearfix = '<div class="clearfix"></div>';}
		
		/*-------------Size------------*/
		if(!in_array($size,array('1/2','1/3','2/3','1/4','3/4','1/5','2/5','3/5','4/5','1/6','5/6'))) {$size="1/2";} else {$size = trim($size);}
		$size = str_replace("/","-",$size);
		$cl[] = 'column-'.$size;
		
		//Apply filters to cl
		$cl = apply_filters('k2t_column_classes',$cl);
		
		//Join cl class
		$cl = join(' ', $cl);

		$return = '<div class="'.trim($cl).'">';
		$return .= do_action('k2t_column_open');
		$return .= do_shortcode($content);
		$return .= do_action('k2t_column_close');
		$return .= '</div>'.$clearfix;
		
		//Apply filters return
		$return = apply_filters('k2t_column_return',$return);
		
		return $return;	
	}
}