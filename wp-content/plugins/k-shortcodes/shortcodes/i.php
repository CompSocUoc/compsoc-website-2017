<?php
/* ------------------------------------------------------- */
/* Simple icon
/* ------------------------------------------------------- */
if (!function_exists('k2t_i_shortcode')){
	function k2t_i_shortcode($atts, $content = null ){
		extract(shortcode_atts(array(
			'icon'		=>  'checkmark',
			'color'		=>	'',
		), $atts));
		
		//Global $cl
		$cl = array('k2t-i');
		
		/*----------------Icon----------------*/
		if(trim($icon) == ''){ $icon_class = ' icon-checkmark';} else { $icon_class = ' icon-'.trim($icon);}
		
		/*----------------Color----------------*/
		if(trim($color) == ''){ $style_css = '';} else { $style_css = ' style="color: '.esc_attr(trim($color)).'"';}
		
		//Apply filters to cl
		$cl = apply_filters('k2t_i_classes',$cl);
		
		//Join cl class
		$cl = join(' ', $cl);
		
		$return = '<i class="k2t-i'.$icon_class.'"'.$style_css.'>';
		$return .= do_action('k2t_i_open');
		$return .= do_action('k2t_i_close');
		$return .= '</i>';
		
		//Apply filters return
		$return = apply_filters('k2t_i_return',$return);
		
		return $return;
	}
}