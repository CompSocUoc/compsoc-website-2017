<?php
/**
 * Shortcode tooltip.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_tooltip_shortcode' ) ) {
	function k2t_tooltip_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title'    => '',
			'position'   =>  'top',
		), $atts ) );

		//Global $cl
		$cl = array();

		/*-----------Title-------------*/
		if ( trim( $title ) != '' ) { $cl[] = 'hastip'; }

		/*-----------Position-------------*/
		if ( ! in_array( trim( $position ), array( 'top', 'bottom', 'left', 'right' ) ) ) {$cl[] = 'tooltip-top';} else {$cl[] = 'tooltip-' . trim( $position );}

		if ( ! empty( $cl ) ) {
			//Apply filters to cl
			$cl = apply_filters( 'k2t_tooltip_classes', $cl );

			//Join cl class
			$cl = join( ' ', $cl );

			$class_tooltip = ' class="' . trim( $cl ) . '"';

		} else {
			$class_tooltip = '';
		}

		$html = '<span' . $class_tooltip . ' title="' . esc_attr( trim( $title ) ) . '">';
		$html .= do_action( 'k2t_tooltip_open' );
		$html .= do_shortcode( $content );
		$html .= do_action( 'k2t_tooltip_close' );
		$html .= '</span>';

		//Apply filters return
		$html = apply_filters( 'k2t_tooltip_return', $html );

		return $html;
	}
}
