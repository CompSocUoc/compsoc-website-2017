<?php
/**
 * Shortcode progress.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_progress_shortcode' ) ) {
	function k2t_progress_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'percent'          => '',
			'color'            => '',
			'background_color' => '',
			'text_color'       => '',
			'title'            => '',
			'height'           => '',
			'striped'          => 'false',
			'speed'            => '1000',
			'easing'           => 'easeOutExpo',
			'id'               => '',
			'class'            => '',
		), $atts ) );

		wp_enqueue_script( 'k2t-inview' );

		//Global $cl and css array
		$cl = array( 'k2t-progress' );
		$css_title = array();
		$css_bar = array();
		$css_progress = array();
		$css_percent = array();

		/*-----------Striped-------------*/
		if ( trim( $striped ) == 'true' ) { $cl[] = 'striped';}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		//Apply filters to cl
		$cl = apply_filters( 'k2t_progress_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		/*-----------Speed-------------*/
		if ( is_numeric( trim( $speed ) ) ) { $data_speed = trim( $speed );} else { $data_speed = '1000';}

		/*-----------Easing-------------*/
		if ( in_array( trim( $easing ), array( 'jswing', 'def', 'easeInQuad', 'easeOutQuad', 'easeInOutQuad', 'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 'easeOutQuart', 'easeInOutQuart', 'easeInQuint', 'easeOutQuint', 'easeInOutQuint', 'easeInSine', 'easeOutSine', 'easeInOutSine', 'easeInExpo', 'easeOutExpo', 'easeInOutExpo', 'easeInCirc', 'easeOutCirc', 'easeInOutCirc', 'easeInElastic', 'easeOutElastic', 'easeInOutElastic', 'easeInBack', 'easeOutBack', 'easeInOutBack', 'easeInBounce', 'easeOutBounce', 'easeInOutBounce' ) ) ) { $data_easing = trim( $easing );} else { $data_easing = 'easeOutExpo';}

		/*-----------Height-------------*/
		if ( trim( $height ) != '' ) { $css_title[] = ''; $css_progress[] = 'height: ' . trim( $height ) . 'px';}

		/*-----------Text color-------------*/
		if ( trim( $text_color ) != '' ) {
			$css_title[] = 'color: ' . trim( $text_color );
		}

		/*-----------Color-------------*/
		if ( trim( $color ) != '' ) {
			$css_bar[] = 'background-color: ' . trim( $color );
		}

		/*-----------Background color-------------*/
		if ( trim( $background_color ) != '' ) {
			$css_progress[] = 'background-color: ' . trim( $background_color );
		}

		/*-----------Percent-------------*/
		if ( is_numeric( trim( $percent ) ) ) {
			$percent = trim( $percent );
			$css_bar[] = 'width: ' . trim( $percent ) . '%';
			$css_percent[] = 'margin-left: ' . trim( $percent ) . '%';
		}else {
			$percent = '90';
			$css_bar[] = 'width: 90%';
			$css_percent[] = 'margin-left: 90%';
		}

		//Join style
		if ( !empty( $css_title ) ) { 		$style_title 		= ' style="' . esc_attr( trim( join( ';', $css_title ) ) ) . '"';} else { $style_title = '';}
		if ( !empty( $css_bar ) ) { 		$style_bar 			= ' style="' . esc_attr( trim( join( ';', $css_bar ) ) ) . '"';} else { $style_bar = '';}
		if ( !empty( $css_progress ) ) { 	$style_progress 	= ' style="' . esc_attr( trim( join( ';', $css_progress ) ) ) . '"';} else { $style_progress = '';}
		if ( !empty( $css_percent ) ) { 	$style_percent 		= ' style="' . esc_attr( trim( join( ';', $css_percent ) ) ) . '"';} else { $style_percent = '';}

		/*-----------Title-------------*/
		if ( trim( $title ) != '' ) { $title_html = '<div class="text"' . $style_title . '>' . trim( $title ) . '</div>'; }else { $title_html = ''; }

		$html = '<div ' . $id . ' class="' . trim( $cl ) . $class . '" data-speed="' . $data_speed . '" data-easing="' . $data_easing . '">';
		$html .= do_action( 'k2t_progress_open' );
		$html .=  $title_html . '<div class="progress-background"' . $style_progress . '><div class="percent" ' . $style_percent . '><i class="icon fa fa-map-marker"></i>' . $percent . '%</div><div class="bar-outer"><div class="bar"' . $style_bar . '></div></div></div>';
		$html .= do_action( 'k2t_progress_close' );
		$html  .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_progress_return', $html );

		return $html;
	}
}
