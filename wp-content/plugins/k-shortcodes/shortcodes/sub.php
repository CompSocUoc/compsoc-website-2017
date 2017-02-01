<?php
/**
 * Shortcode sub.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_sub_shortcode' ) ) {
	function k2t_sub_shortcode( $atts, $content ) {

		$html = '<sub>'.do_shortcode( $content ).'</sub>';

		//Apply filters return
		$html = apply_filters( 'k2t_sub_return', $html );

		return $html;
	}
}
