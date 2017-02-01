<?php
/**
 * Shortcode icon list.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_iconlist_shortcode' ) ) {
	function k2t_iconlist_shortcode( $atts, $content ) {
		$html = $icon = $color = $text_list = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'icon'      => '',
			'color'     => '',
			'text_list' => '',
			'anm'       => '',
			'anm_name'  => '',
			'anm_delay' => '',
			'id'        => '',
			'class'     => '',
		), $atts ) );

		//Global $cl
		$cl = array( 'k2t-iconlist' );

		//Apply filters to cl
		$cl = apply_filters( 'k2t_iconlist_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		if ( ! preg_match_all( "/(.?)\[(li)\b(.*?)(?:(\/))?\]/s", $content, $matches ) ) {
			return do_shortcode( $content );
		} else {
			/*-----------Color Default-------------*/
			$color_list = ( trim( $color ) == '' ) ? '' : trim( $color );

			/*-----------Icon Default-------------*/
			$icon_default = ( trim( $icon ) == '' ) ? '' : trim( $icon );

			$html = '<div class="' . trim( $cl ). $anm . '" ' . $data_name . $data_delay . $id . '>';
			$html .= do_action( 'k2t_iconlist_open' );
			$html .= '<ul>';
			for ( $i = 0; $i < count( $matches[0] ); $i++ ):
				$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );

				// Check isset value of [li] to override
				$color_li = isset( $matches[3][$i]['color'] ) ? trim( $matches[3][$i]['color'] ) : '';
				$icon_li  = isset( $matches[3][$i]['icon'] ) ? trim( $matches[3][$i]['icon'] ) : '';

				$icon_save  = ( empty( $icon_li ) ) ? $icon_default : $icon_li;
				$color_save = ( empty( $color_li ) ) ? $color_list : $color_li;
				$color_end  = ( empty( $color_save ) ) ? '' : ' style="color: ' . esc_attr( $color_save ) . '"';

				if ( empty( $color_save ) ) {
					$color_end = '';
				} else {
					$sub_color = substr( trim( $color_save ), 0, 1 );
					$color_sub = ( $sub_color == '#' ) ? $color_save : '#' . $color_save;
					$color_end = ' style="color: ' . esc_attr( $color_sub ) . '"';
				}
				$icon_end = ( empty( $icon_save ) ) ? '' : '<i class="' . esc_attr( $icon_save ) . '"' . $color_end . '></i>';
				$title = !empty( $matches[3][$i]['title'] ) ? do_shortcode( $matches[3][$i]['title'] ) : '';
				$html .= '<li>' . $icon_end . $title . '</li>';

			endfor;
			$html .= '</ul>';
			$html .= do_action( 'k2t_iconlist_close' );
			$html .= '</div>';

			//Apply filters return
			$html = apply_filters( 'k2t_iconlist_return', $html );

			return $html;
		}
	}
}
