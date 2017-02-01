<?php
/**
 * Shortcode pullquote.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_pullquote_shortcode' ) ) {
	function k2t_pullquote_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'align'    => 'left',
			'author'   => ''
		), $atts ) );

		//Global $cl
		$cl = array( 'k2t-pullquote' );

		/*-----------Align-------------*/
		if ( !in_array( trim( $align ), array( 'left', 'right', 'center' ) ) ) {$cl[] = 'align-left';} else {$cl[] = 'align-'.trim( $align );}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_pullquote_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$html = '<div class="'.trim( $cl ).'">';
		$html .= do_action( 'k2t_pullquote_open' );
		$html .= '<blockquote>'.do_shortcode( $content );
		if ( trim( $author ) != '' ):
			$html .= '<cite>'.trim( $author ).'</cite>';
		endif;
		$html .= '</blockquote>';
		$html .= do_action( 'k2t_pullquote_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_pullquote_return', $html );

		return $html;
	}
}
