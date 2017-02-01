<?php
/**
 * Shortcode align.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_align_shortcode' ) ) {
	function k2t_align_shortcode( $atts, $content ) {
		$html = $align = '';
		extract( shortcode_atts( array(
			'align'   =>  'left',
		), $atts ) );

		//Global $cl
		$cl = array();

		/*-------------Link------------*/
		if ( in_array( trim( $align ), array( 'left', 'right', 'center' ) ) ) { $cl[] = 'k2t-align-' . trim( $align ); } else { $cl[] = 'k2t-align-left'; }

		//Apply filters to cl
		$cl = apply_filters( 'k2t_align_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$html = '<div class="' . trim( $cl ) . '">';
		$html .= do_action( 'k2t_align_open' );
		$html .= do_shortcode( $content );
		$html .= do_action( 'k2t_align_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_align_return', $html );

		return $html;
	}
}
