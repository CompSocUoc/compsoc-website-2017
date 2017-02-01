<?php
/* ------------------------------------------------------- */
/* Animation
/* ------------------------------------------------------- */
if (!function_exists('k2t_animation_shortcode')){
	function k2t_animation_shortcode($atts,$content){
		extract(shortcode_atts(array(
			'effect'	=>  '',
			'delay'		=>	'',
		), $atts));
		
		//Global $cl
		$cl = array('k2t-animation-element');
		
		$array_effect = array('bounce','flash','pulse','rubberBand','shake','swing','tada','wobble','bounceIn','bounceInDown','bounceInLeft','bounceInRight','bounceInUp','fadeIn','fadeInDown','fadeInDownBig','fadeInLeft','fadeInLeftBig','fadeInRight','fadeInRightBig','fadeInUp','fadeInUpBig','flip','flipInX','flipInY','lightSpeedIn','rotateIn','rotateInDownLeft','rotateInDownRight','rotateInUpLeft','rotateInUpRight','rollIn','zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp');
		
		/*-------------Effect------------*/
		if(in_array(trim($effect), array('bounce','flash','pulse','rubberBand','shake','swing','tada','wobble','bounceIn','bounceInDown','bounceInLeft','bounceInRight','bounceInUp','fadeIn','fadeInDown','fadeInDownBig','fadeInLeft','fadeInLeftBig','fadeInRight','fadeInRightBig','fadeInUp','fadeInUpBig','flip','flipInX','flipInY','lightSpeedIn','rotateIn','rotateInDownLeft','rotateInDownRight','rotateInUpLeft','rotateInUpRight','rollIn','zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp'))) {$cl[] = 'animation-'.trim($effect);}
		
		/*-------------Delay------------*/
		if(is_numeric(trim($delay))){ $delay_html = ' data-delay="'.trim($delay).'"'; } else { $delay_html = ''; }
		
		//Apply filters to cl
		$cl = apply_filters('k2t_animation_classes',$cl);
		
		//Join cl class
		$cl = join(' ', $cl);
		
		$return = '<div class="'.trim($cl).'"'.$delay_html.'>';
		$return .= do_action('k2t_animation_open');
		$return .= do_shortcode($content);
		$return .= do_action('k2t_animation_close');
		$return .= '</div>';
		
		//Apply filters return
		$return = apply_filters('k2t_animation_return',$return);
		
		return $return;
	}
}