<?php
/**
 * Shortcode highlight.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_highlight_shortcode' ) ) {
	function k2t_highlight_shortcode( $atts, $content ) {
		$html = $style = $color = '';
		extract( shortcode_atts( array(
			'style'			=> '1',
			'text_color'  	=> '',
			'color'  		=>  '',
		), $atts ) );

		$cl = array( 'k2t-highlight' );

		/*-------------Style--------------*/
		if ( in_array( trim( $style ), array( '1', '2' ) ) ) { $cl[] = 'style-'.trim( $style );} else { $cl[] = 'style-1';}

		/*-------------Color--------------*/
		$css_bgcolor = '';
		if ( $style == '1' ){
			$color = trim( $color );
			$color = str_replace('#', '', $color);
			$css_bgcolor = !empty( $color ) ? 'background-color: #'. esc_attr( $color ) .';' : '';
		}

		/*-------------Text Color--------------*/
		$text_color = trim( $text_color );
		$text_color = str_replace('#', '', $text_color);
		$css_textcolor = !empty( $text_color ) ? 'color: #'. esc_attr( $text_color ) .';' : '';

		//Apply filters to cl
		$cl = apply_filters( 'k2t_highlight_classes', $cl );

		//Join $cl
		$cl = join( ' ', $cl );

		$html = '<span class="'. trim( $cl ) .'" style="'. $css_bgcolor . $css_textcolor .'">';
		$html .= do_action( 'k2t_highlight_open' );
		$html .= do_shortcode( $content );
		$html .= do_action( 'k2t_highlight_close' );
		$html .= '</span>';

		//Apply filters return
		$html = apply_filters( 'k2t_highlight_return', $html );

		return $html;
	}
}
