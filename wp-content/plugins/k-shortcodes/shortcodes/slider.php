<?php
/**
 * Shortcode slider.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_slider_shortcode' ) ) {
	function k2t_slider_shortcode( $args, $content ) {
		extract( shortcode_atts( array(
			'mode'              => 'horizontal',
			'speed'             => '300',
			'pagination'        =>  'true',
			'mouse_swipe'       => 'true',
			'column'            => '1',
			'infinite_scroll'   => 'false',
			'mousewheelControl' => 'false'
		), $args ) );

		//Global $cl
		$cl = array( 'swiper-container' );

		wp_enqueue_script( 'k2t-swiper' );
		wp_enqueue_script( 'k2t-slider' );
		wp_enqueue_style( 'k2t-swiper' );

		if ( !preg_match_all( "/(.?)\[(slide)\b(.*?)(?:(\/))?\](?:(.+?)\[\/slide\])?(.?)/s", $content, $matches ) ) :
			return do_shortcode( $content );
		else :

			/* mode */
			if ( trim( $mode ) != 'horizontal' ) $mode = 'vertical'; else $mode = 'horizontal';

			/* Speed - check if speed not is number */
			if ( !is_numeric( trim( $speed ) ) ) $speed = '300';

			/* Column - check if column not is number */
			if ( !is_numeric( trim( $column ) ) ) $column = '1';

			/* mouse_swipe */
			if ( trim( $mouse_swipe ) != 'false' ) $mouse_swipe = 'true'; else $mouse_swipe = 'false';

			/* infinite_scroll */
			if ( trim( $infinite_scroll ) != 'false' ) $infinite_scroll = 'true'; else $infinite_scroll = 'false';

			/* mousewheelControl */
			if ( trim( $mousewheelControl ) != 'false' ) $mousewheelControl = 'true'; else $mousewheelControl = 'false';

			/* navi */
			$has_pagi = '';
		if ( trim( $pagination )!= 'false' ) {
			$pagination = 'true';
			$cl[] = 'has_pagi';
		} else {
			$pagination = 'false';
			$cl[] = 'no_pagi';
		}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_slider_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$html = '<div class="'.trim( $cl ).'" data-mode="'.$mode.'" data-speed="'.$speed.'" data-pagination="'.$pagination.'" data-mouse_swipe="'.$mouse_swipe.'" data-column="'.$column.'" data-infinite_scroll="'.$infinite_scroll.'" data-mousewheelControl="'.$mousewheelControl.'">';
		$html .= do_action( 'k2t_slider_open' );
		$html .= '<div class="swiper-wrapper">';

		for ( $i = 0; $i < count( $matches[0] ); $i++ ):

			$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );
		$image = trim( $matches[5][$i] );

		if ( $image ) {
			$img = '<div><img src="' . esc_url( $image ) . '" alt="'.basename( $image ).'" /></div>';
		} else {
			$img = '';
		}

		$link = isset( $matches[3][$i]['link'] ) ? trim( $matches[3][$i]['link'] ) : '';
		$title = isset( $matches[3][$i]['title'] ) ? trim( $matches[3][$i]['title'] ) : '';
		$desc = isset( $matches[3][$i]['desc'] ) ? trim( $matches[3][$i]['desc'] ) : '';
		$target = isset( $matches[3][$i]['target'] ) ? trim( $matches[3][$i]['target'] ) : '';

		if ( $target != '_blank' ) $target = '_self';
		if ( !$link ) $link = isset( $matches[3][$i]['url'] ) ? trim( $matches[3][$i]['url'] ) : '';

		if ( $link ) {
			$open = '<a href="'.esc_url( $link ).'" target="'.$target.'">';
			$close = '</a>';
		} else {
			$open = '';
			$close = '';
		}

		if ( $title || $desc ) {
			if ( $desc ) $has_desc = ' has_desc'; else $has_desc= '';
			$caption = '<div class="caption'.$has_desc.'">';
			if ( $title ) $caption .= '<h4 class="title">'. $open . $title. $close . '</h4>';
			if ( $desc ) $caption .= '<div class="desc">'.$desc.'</div>';
			$caption .= '</div>';
		} else {
			$caption = '';
		}

		$html .= '<div class="swiper-slide"><div class="k2t-slide">' . $img . $caption .'</div></div>';

		endfor;

		$html .= '</div><div class="pagination"></div>';
		$html .= do_action( 'k2t_slider_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_slider_return', $html );

		return $html;

		endif;
	}
}
