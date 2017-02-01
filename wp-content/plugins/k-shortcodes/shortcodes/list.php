<?php
/**
 * Shortcode list.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_list_shortcode' ) ) {
	function k2t_list_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'type'   => 'star',
		), $atts ) );

		//Global $cl
		$cl = array( 'k2t-list' );

		/*-----------Type List-------------*/
		if ( !in_array( trim( $type ), array( 'star', 'dot', 'plus', 'minus' ) ) ) {$cl[] = 'type-star';} else {$cl[] = 'type-'.trim( $type );}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_list_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$html = '<div class="'.trim( $cl ).'">';
		$html .= do_action( 'k2t_list_open' );
		$html .= do_shortcode( $content );
		$html .= do_action( 'k2t_list_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_list_return', $html );

		return $html;
	}
}
