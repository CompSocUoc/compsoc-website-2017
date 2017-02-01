<?php
/**
 * Shortcode spacer.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_spacer_shortcode' ) ) {
	function k2t_spacer_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'height'  => '',
		), $atts ) );

		//Global $cl
		$cl = array( 'k2t-spacer' );

		//Apply filters to cl
		$cl = apply_filters( 'k2t_spacer_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$style_height = ( is_numeric( trim( $height ) ) ) ? ' style="height: '.$height.'px"' : '';

		$height = absint( $height );
		$html = '<div class="clearfix"></div><div class="'.trim( $cl ).'"'.$style_height.'>';
		$html .= do_action( 'k2t_spacer_open' );
		$html .= do_action( 'k2t_spacer_close' );
		$html .= '</div><div class="clearfix"></div>';

		//Apply filters return
		$html = apply_filters( 'k2t_spacer_return', $html );

		return $html;
	}
}
