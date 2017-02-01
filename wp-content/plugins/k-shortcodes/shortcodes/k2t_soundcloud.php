<?php
/* ------------------------------------------------------- */
/* Soundcloud
/* ------------------------------------------------------- */
if (!function_exists('k2t_k2t_soundcloud_shortcode')){
	function k2t_k2t_soundcloud_shortcode($atts,$content = NULL) {
		extract(shortcode_atts(array(
			'height'	=>	'166',
		), $atts));
		global $wp_embed;
		$height = intval($height);
		$return = $wp_embed->run_shortcode('[embed height="'.$height.'"]' . $content . '[/embed]');
		if ($return) $return = '<div class="media-container soundcloud-container">'. $return .'</div>';
		return $return;	
	}
}