<?php
/**
 * Shortcode aweomse slider.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_awesome_slider_shortcode' ) ) {
	function k2t_awesome_slider_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'auto'    => 'false',
			'auto_time'   => '5000',
			'speed'    => '500',
			'pager'    => 'true',
			'navi'    => 'true',
			'touch'    => 'true',
			'mousewheel'  => 'false',
			'loop'    => 'true',
			'keyboard'   => 'false',
		), $atts ) );

		wp_enqueue_script( 'k2t-swiper' );
		wp_enqueue_style( 'k2t-swiper' );

		//Global id pagination
		$pagination_id = 'pagination-'.rand( 100000, 999999 );

		//Global $cl and $data
		$cl = array( 'k2t-swiper-slider' );
		$data = array();

		$cl[] = 'k2t-awesome-slider';

		/*--------------Auto--------------*/
		if ( trim( $auto ) != 'true' ) {$data[] = 'data-auto="false"';} else { $data[] = 'data-auto="true"';}

		/*--------------Auto time--------------*/
		if ( is_numeric( trim( $auto_time ) ) ) {$data[] = 'data-auto-time="'.trim( $auto_time ).'"';} else { $data[] = 'data-auto-time="5000"';}

		/*--------------Speed--------------*/
		if ( is_numeric( trim( $speed ) ) ) {$data[] = 'data-speed="'.trim( $speed ).'"';} else { $data[] = 'data-speed="500"';}

		/*--------------Pager--------------*/
		if ( trim( $pager ) != 'false' ) {$data[] = 'data-pager="true"'; $data[] = 'data-pagination-selector="#'.$pagination_id.'"';} else { $data[] = 'data-pager="false"';}

		/*--------------Navi--------------*/
		if ( trim( $navi ) != 'false' ) {$data[] = 'data-navi="true"';} else { $data[] = 'data-navi="false"';}

		/*--------------Touch--------------*/
		if ( trim( $touch ) != 'false' ) {$data[] = 'data-touch="true"';} else { $data[] = 'data-touch="false"';}

		/*--------------Mousewheel--------------*/
		if ( trim( $mousewheel ) != 'true' ) {$data[] = 'data-mousewheel="false"';} else { $data[] = 'data-mousewheel="true"';}

		/*--------------Loop--------------*/
		if ( trim( $loop ) != 'false' ) {$data[] = 'data-loop="true"';} else { $data[] = 'data-loop="false"';}

		/*--------------Keyboard--------------*/
		if ( trim( $keyboard ) != 'true' ) {$data[] = 'data-keyboard="false"';} else { $data[] = 'data-keyboard="true"';}

		/*-----------------Preview-----------------*/
		$data[] = 'data-perview="1"';

		if ( !preg_match_all( "/(.?)\[(slide)\b(.*?)(?:(\/))?\](?:(.+?)\[\/slide\])?(.?)/s", $content, $matches ) ) :
			return do_shortcode( $content );
		else :

			//Apply filters to cl
			$cl = apply_filters( 'k2t_awesome_slider_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		//Join $data
		$data = join( ' ', $data );


		$html = '<div class="'.esc_attr( trim( $cl ) ).'" '.trim( $data ).'><div class="k2t-swiper-slider-inner"><div class="k2t-swiper-slider-inner-deeper"><div class="k2t-swiper-container"><div class="swiper-wrapper">';
		$html .= do_action( 'k2t_awesome_slider_open' );

		for ( $i = 0; $i < count( $matches[0] ); $i++ ):

			$html .= '<div class="swiper-slide"><img src="'.do_shortcode( $matches[5][$i] ).'" alt="Gallery '.( $i+1 ).'" /></div>';

		endfor;

		$html .= do_action( 'k2t_awesome_slider_close' );
		$html .= '</div></div>';
		$html .= ( $navi=='true' ) ? '<div class="k2t-swiper-navi"><ul><li><a class="prev"><i class="icon-chevron-left"></i></a></li><li><a class="next"><i class="icon-chevron-right"></i></a></li></ul></div>' : '';
		$html .= '</div>';
		$html .= ( $pager=='true' ) ? '<div class="pagination" id="'.$pagination_id.'"></div>' : '';
		$html .= '</div></div>';

		//Apply filters return
		$html = apply_filters( 'k2t_awesome_slider_return', $html );

		return $html;

		endif;
	}
}
