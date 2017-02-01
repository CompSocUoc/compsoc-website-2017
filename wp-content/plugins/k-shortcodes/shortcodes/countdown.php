<?php
/**
 * Shortcode countdown.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_countdown_shortcode' ) ) {
	function k2t_countdown_shortcode( $atts, $content = NULL ) {
		$html =  $time = $year = $month = $day = $hour = $minute = $second = $fontsize = $background_color = $text_color = $id = $class = '';
		extract( shortcode_atts( array(
			'time'             => '2016-11-11-11-11-11',
			'align'			   => 'left',
			'id'               => '',
			'class'            => '',
		), $atts ) );

		$event_info = array();
		$new_date = strtotime($time);
		$new_date = date('Y-m-d', $new_date); 
		$event_info['start_date'] = $new_date;

		wp_enqueue_script( 'k-event' );
		wp_localize_script( 'k-event', 'event_info', $event_info );
		wp_enqueue_script( 'k-countdown' );
		wp_enqueue_script( 'k-lodash' );

		//Global $cl and $style
		$cl = array( 'k2t-countdown' );
		$cl[] = '';
		$style = array();

		$id    = ( $id != '' ) ? $id : 'countdown' . rand();
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		/*--------------------Fontsize---------------------*/
		if ( !is_numeric( trim( $fontsize ) ) ) {
			$num_style = '';
		} else {
			if ( trim( $fontsize ) < 25 ) {
				$cl[] = 'countdown-small-font';
				$padding = ( trim( $fontsize ) )*0.6;
				$padding_bottom = ( trim( $fontsize ) )*0.5;
				$num_style = ' style="font-size: ' . trim( $fontsize ) . 'px; padding-bottom: ' . $padding_bottom . 'px;"';
			} else {
				$num_style = '';
			}
		}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_countdown_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		//Join style
		if ( !empty( $style ) ) { $style = ' style="' . trim( join( '; ', $style ) ) . '"'; } else { $style = '';}

		$html = '<div id="'. esc_attr( $id ) .'" class="' . trim( esc_attr( $cl ) ) . esc_attr( $class ) . ' '. esc_attr( $align ) .'" data-time="'. esc_attr( $time ) .'" '. esc_attr( $style ) .'>';
		$html .= do_action( 'k2t_countdown_open' );
		$html .= '<div class="event-countdown-container"><div class="countdown-container"></div></div><div class="event-countdown-template"><scr'.'ipt type="text/template" class="countdown-template" data-startdate="'.esc_attr($new_date).'"><div class="time <%= label %>"><span class="count curr top"><%= curr %></span><span class="count next top"><%= next %></span><span class="count next bottom"><%= next %></span><span class="count curr bottom"><%= curr %></span><span class="label"><%= label.length < 6 ? label : label.substr(0, 3)  %></span></div></scr'.'ipt></div>';
		$html .= do_action( 'k2t_countdown_close' );
		$html .= '</div>';


		//Apply filters return
		$html = apply_filters( 'k2t_countdown_return', $html );


		return $html;
	}
}


