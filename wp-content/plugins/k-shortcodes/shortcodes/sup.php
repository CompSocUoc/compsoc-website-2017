<?php
/**
 * Shortcode sup.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_sup_shortcode' ) ) {
	function k2t_sup_shortcode( $atts, $content ) {

		$html = '<sup>'.do_shortcode( $content ).'</sup>';

		//Apply filters return
		$html = apply_filters( 'k2t_sup_return', $html );

		return $html;
	}
}
