<?php
/**
 * Shortcode Image.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists('k2t_image_shortcode')){
	function k2t_image_shortcode($atts, $content = null ){
		extract(shortcode_atts(array(
			'link'		=>  '',
			'alt'		=>	'',
			'grayscale'	=>  'false',
		), $atts));
		
		// Global $cl
		$cl = array( 'image-sc' );
		
		if ( trim( $grayscale ) == 'true') { $cl[] = 'image-grayscale'; }
		
		// Apply filters to cl
		$cl = apply_filters( 'k2t_image_classes', $cl );
		
		// Join cl class
		$cl = join( ' ', $cl );
		
		if ( trim( $link ) == '' ) {
			$return = '';
		} else {
			$return = '<img class="' . trim($cl) . '" src="' . esc_url( $link ) . '" alt="' . esc_attr( $alt ) . '" />';
		}
		
		//Apply filters return
		$return = apply_filters('k2t_i_return',$return);
		
		return $return;
	}
}