<?php
/**
 * Shortcode hr.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_hr_shortcode' ) ) {
	function k2t_hr_shortcode( $atts, $content = null ) {
		$html = $style = $width = $margin_top = $margin_bottom = $id = $class = '';
		extract( shortcode_atts( array(
			'style'         => '1',
			'width'         =>  '',
			'margin_top'    => '20',
			'margin_bottom' => '30',
		), $atts ) );

		//Global $cl
		$cl = array( 'k2t-hr' );
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		/*-------------Style--------------*/
		if ( in_array( trim( $style ), array( '1', '2', '3', '4' ) ) ) { $cl[] = 'style-'.trim( $style );} else { $cl[] = 'style-1';}

		$css = '';
		/*-------------Width--------------*/
		if ( trim( $width ) == '' ) {
			$css .= '';
		} else {
			$sub_width = substr( trim( $width ), -1 );
			//If width value is %
			if ( $sub_width == '%' ) {
				$css .= 'width: '.esc_attr( trim( $width ) ).';';
			}elseif ( is_numeric( $sub_width ) ) {
				$css .= 'width: '.trim( $width ).'px;';
			}
			else {
				$css .= '';
			}
		}

		/*-------------Margin--------------*/
		if ( trim( $margin_top ) == '' ) {
			$css.= '';
		} else {
			$css .= 'margin-top:'.trim( $margin_top ).'px;';
		}
		if ( trim( $margin_bottom ) == '' ) {
			$css .= '';
		} else {
			$css .= 'margin-bottom:'.trim( $margin_bottom ).'px;';
		}
		if ( $css ) $css = 'style="'.esc_attr( $css ).'"';

		//Apply filters to cl
		$cl = apply_filters( 'k2t_hr_classes', $cl );

		//Join $cl
		$cl = join( ' ', $cl );

		$html = '<div class="clearfix"></div><div class="' . trim( $cl ) . $class . '"' . $css . $id . '>';
		$html .= do_action( 'k2t_hr_open' );
		$html .= '</div><div class="clearfix">';
		$html .= do_action( 'k2t_hr_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_hr_return', $html );

		return $html;
	}
}
