<?php
/**
 * Shortcode toggle.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_toggle_shortcode' ) ) {
	function k2t_toggle_shortcode( $atts, $content ) {
		$html = $title = $open = $big = $id = $class = '';
		extract( shortcode_atts( array(
			'title' => __('Toggle Title', 'k2t'),
			'open'  => 'false',
			'big'   => '',
			'id'    => '',
			'class' => '',
		), $atts ) );

		//Global $cl
		$cl = array( 'k2t-toggle' );

		//Enqueue Script Collapse
		wp_enqueue_script( 'k2t-collapse' );

		/*-----------Title-------------*/
		if ( trim( $title ) == '' ) { $title = 'Toggle Title'; } else { $title = trim( $title ); }

		/*-----------Open-------------*/
		if ( trim( $open ) == 'true' ) { $class_open = ' open'; } else { $class_open = ''; }

		//Apply filters to cl
		$cl = apply_filters( 'k2t_toggle_classes', $cl );

		//Join cl class
		$cl    = join( ' ', $cl );
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		$html = '<div ' . $id . ' class="' . trim( $cl ) . $class . '">';
		$html .= do_action( 'k2t_toggle_open' );
		$html .= '<h4 class="toggle-title' . $class_open  . '"><span>' . $title . '</span></h4><div class="toggle-content"><p>' . do_shortcode( $content ) . '</p></div>';
		$html .= do_action( 'k2t_toggle_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_toggle_return', $html );

		return $html;
	}
}
