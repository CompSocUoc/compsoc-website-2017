<?php
/**
 * Shortcode section.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_section_shortcode' ) ) {
	function k2t_section_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'id'     =>  '',
			'padding_top'   =>  '',
			'padding_bottom'  =>  '',
			'padding_left'   =>  '',
			'padding_right'   =>  '',
		), $atts ) );

		//Global $cl and $style
		$cl = array( 'k2t-section' );
		$style = array();

		/*------------------ID-------------------*/
		if ( trim( $id ) != '' ) { $id_reder = ' id="'.trim( $id ).'"';} else { $id_reder = '';}

		/*------------------Padding Top-------------------*/
		if ( is_numeric( trim( $padding_top ) ) ) { $style[] = 'padding-top: '.trim( $padding_top ).'px';}

		/*------------------Padding Bottom-------------------*/
		if ( is_numeric( trim( $padding_bottom ) ) ) { $style[] = 'padding-bottom: '.trim( $padding_bottom ).'px';}

		/*------------------Padding Left-------------------*/
		if ( is_numeric( trim( $padding_left ) ) ) { $style[] = 'padding-left: '.trim( $padding_left ).'px';}

		/*------------------Padding Right-------------------*/
		if ( is_numeric( trim( $padding_right ) ) ) { $style[] = 'padding-right: '.trim( $padding_right ).'px';}


		//Check to join style
		if ( !empty( $style ) ) {
			$style_html = ' style="'.trim( join( "; ", $style ) ).'"';
		} else {
			$style_html = '';
		}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_section_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$html = '<section'.$id_reder.' class="'.trim( $cl ).'"'.$style_html.'>';
		$html .= do_action( 'k2t_section_open' );
		$html .= do_shortcode( $content );
		$html .= do_action( 'k2t_section_close' );
		$html .= '</section>';

		//Apply filters return
		$html = apply_filters( 'k2t_section_return', $html );

		return $html;
	}
}
