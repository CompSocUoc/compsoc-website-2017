<?php
/* ------------------------------------------------------- */
/* Video & audio
/* ------------------------------------------------------- */
if (!function_exists('k2t_k2t_video_shortcode')){
	function k2t_k2t_video_shortcode($atts,$content) {
		extract(shortcode_atts(array(
			'width'		=>	'',
		), $atts));
		if (is_numeric($width)) $width .= 'px';
		
		global $wp_embed;
		$return = $wp_embed->run_shortcode('[embed]' . $content . '[/embed]');
		if ($return) $return = '<div class="video-container media-container" style="width:'.$width.';">'. $return .'</div>';
		return $return;
	}
}