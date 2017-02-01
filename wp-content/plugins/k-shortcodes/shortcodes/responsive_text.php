<?php
/**
 * Shortcode responsive text.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_responsive_text_shortcode' ) ) {
	function k2t_responsive_text_shortcode( $atts, $content ) {
		$html = $compression = $min_size = $max_size = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $ids = $class = '';
		extract( shortcode_atts( array(
			'compression' =>  '',
			'min_size'    => '',
			'max_size'    =>  '',
			'anm'         => '',
			'anm_name'    => '',
			'anm_delay'   => '',
			'id'          => '',
			'class'       => '',
		), $atts ) );

		wp_enqueue_script( 'k2t-fittext' );

		//Global $cl
		$id = 'k2t-res-text'.rand();
		$cl = array( 'k2t-responsive-text' );

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$ids = ( $ids != '' ) ? ' ' . $ids . '' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		/*-------------Compression------------*/
		if ( is_numeric( trim( $compression ) ) ) { $compression = trim( $compression ); } else { $compression = ''; }

		/*-------------Min Font Size------------*/
		if ( is_numeric( trim( $min_size ) ) ) { $min_size = trim( $min_size ); } else { $min_size = ''; }

		/*-------------Max Font Size------------*/
		if ( is_numeric( trim( $max_size ) ) ) { $max_size = trim( $max_size ); } else { $max_size = ''; }

		//Apply filters to cl
		$cl = apply_filters( 'k2t_responsive_text_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$html = '<div class="' . trim( $cl ) . $anm . '" id="' . $id . $ids . '" ' . $data_name . $data_delay . '>';
		$html .= do_action( 'k2t_responsive_text_open' );
		$html .= do_shortcode( $content );
		$html .= do_action( 'k2t_responsive_text_close' );
		$html .= '</div><script type="text/javascript">jQuery(document).ready(function(){';
		//Check to return script fitText
		if ( $compression == '' ) {
			$html .= 'jQuery("#'.$id.'").fitText();';
		} else {
			if ( ( $min_size == '' ) && ( $max_size == '' ) ) {
				$html .= 'jQuery("#'.$id.', #'.$id.' div, #'.$id.' p, #'.$id.' strong, #'.$id.' h1, #'.$id.' h2, #'.$id.' h3, #'.$id.' h4, #'.$id.' h5, #'.$id.' h6").fitText();';
			}elseif ( ( $min_size != '' ) && ( $max_size == '' ) ) {
				$html .= 'jQuery("#'.$id.', #'.$id.' div, #'.$id.' p, #'.$id.' strong, #'.$id.' h1, #'.$id.' h2, #'.$id.' h3, #'.$id.' h4, #'.$id.' h5, #'.$id.' h6").fitText('.$compression.', {minFontSize: "'.$min_size.'px"});';
			}elseif ( ( $min_size == '' ) && ( $max_size != '' ) ) {
				$html .= 'jQuery("#'.$id.', #'.$id.' div, #'.$id.' p, #'.$id.' strong, #'.$id.' h1, #'.$id.' h2, #'.$id.' h3, #'.$id.' h4, #'.$id.' h5, #'.$id.' h6").fitText('.$compression.', {maxFontSize: "'.$max_size.'px"});';
			}else {
				$html .= 'jQuery("#'.$id.', #'.$id.' div, #'.$id.' p, #'.$id.' strong, #'.$id.' h1, #'.$id.' h2, #'.$id.' h3, #'.$id.' h4, #'.$id.' h5, #'.$id.' h6").fitText('.$compression.', { minFontSize: "'.$min_size.'px", maxFontSize: "'.$max_size.'px" });';
			}
		}
		$html .= '});</script>';

		//Apply filters return
		$html = apply_filters( 'k2t_responsive_text_return', $html );

		return $html;
	}
}
