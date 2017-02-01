<?php
/**
 * Shortcode circle button.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_circle_button_shortcode' ) ) {
	function k2t_circle_button_shortcode( $atts, $content = NULL ) {
		$html = $name = $link = $icon_hover = $background_color = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'name'             =>  '',
			'link'             => '',
			'icon_hover'       => '',
			'background_color' => '',
			'anm'              => '',
			'anm_name'         => '',
			'anm_delay'        => '',
			'id'               => '',
			'class'            => '',
		), $atts ) );

		//Global $cl and $style
		$cl = array( 'k2t-circle-button' );
		$style = array();

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		/*-------------Link------------*/
		if ( trim( $link ) ) { $href = ' href="' . trim( $link ) . '"'; } else { $href = ''; }

		/*-------------Icon hover------------*/
		if ( trim( $icon_hover ) != '' ) {
			$icon_trim = substr( trim( $icon_hover ), 0, 4 );
			$icon_html = '<span class="button-icon"><i class="' . trim( $icon_hover ) . '"></i></span>';
		} else {
			$icon_html = '';
		}

		/*-------------Background Color------------*/
		if ( trim( $background_color ) != '' ) { $style[] = 'background-color: ' . trim( $background_color ); }

		//Apply filters to cl
		$cl = apply_filters( 'k2t_circle_button_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );
		//Style
		if ( !empty( $style ) ) {
			$style_html = ' style="' . trim( join( "; ", $style ) ) . '"';
		} else {
			$style_html = '';
		}

		$html = '<a ' . $data_name . $data_delay . $id . ' class="' . trim( $cl ) . $anm . $class . '"' . $style_html.$href . '>';
		$html .= do_action( 'k2t_circle_button_open' );
		$html .= '<span class="button-text">' . trim( $name ) . '</span>' . $icon_html . '';
		$html .= do_action( 'k2t_circle_button_close' );
		$html .= '</a>';

		//Apply filters return
		$html = apply_filters( 'k2t_circle_button_return', $html );

		return $html;
	}
}
