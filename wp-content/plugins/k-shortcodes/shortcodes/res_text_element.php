<?php
/**
 * Shortcode res text element.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_res_text_element_shortcode' ) ) {
	function k2t_res_text_element_shortcode( $atts, $content=NULL ) {
		extract( shortcode_atts( array(
			'selector'    =>  '',
			'compression' =>  '',
			'min_size'    => '',
			'max_size'    =>  '',
		), $atts ) );

		wp_enqueue_script( 'k2t-fittext' );

		/*-------------Compression------------*/
		if ( is_numeric( trim( $compression ) ) ) { $compression = trim( $compression ); } else { $compression = ''; }

		/*-------------Min Font Size------------*/
		if ( is_numeric( trim( $min_size ) ) ) { $min_size = trim( $min_size ); } else { $min_size = ''; }

		/*-------------Max Font Size------------*/
		if ( is_numeric( trim( $max_size ) ) ) { $max_size = trim( $max_size ); } else { $max_size = ''; }

		$html = '';
		if ( trim( $selector ) != '' ) {
			$html .= '<script type="text/javascript">jQuery(document).ready(function(){';
			//Check to return script fitText
			if ( $compression == '' ) {
				$html .= 'jQuery("'.$selector.'").fitText();';
			} else {
				if ( ( $min_size == '' ) && ( $max_size == '' ) ) {
					$html .= 'jQuery("'.$selector.'").fitText();';
				}elseif ( ( $min_size != '' ) && ( $max_size == '' ) ) {
					$html .= 'jQuery("'.$selector.'").fitText('.$compression.', {minFontSize: "'.$min_size.'px"});';
				}elseif ( ( $min_size == '' ) && ( $max_size != '' ) ) {
					$html .= 'jQuery("'.$selector.'").fitText('.$compression.', {maxFontSize: "'.$max_size.'px"});';
				}else {
					$html .= 'jQuery("'.$selector.'").fitText('.$compression.', { minFontSize: "'.$min_size.'px", maxFontSize: "'.$max_size.'px" });';
				}
			}
			$html .= '});</script>';
		}

		//Apply filters return
		$html = apply_filters( 'k2t_res_text_element_return', $html );

		return $html;
	}
}
