<?php
/**
 * Shortcode accordion.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_accordion_shortcode' ) ) {
	function k2t_accordion_shortcode( $atts, $content ) {
		$html = $title = $icon = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'style'     => '',
			'title'     => '',
			'icon'      => '',
			'anm'       => '',
			'anm_name'  => '',
			'anm_delay' => '',
			'id'        => '',
			'class'     => '',
		), $atts ) );

		wp_enqueue_script( 'k2t-collapse' );

		// Global class
		$cl = array( 'k2t-accordion' );

		// Get style
		if ( $style ) {
			$cl[] = 'style-' . $style;
		}

		if ( ! preg_match_all( "/(.?)\[(toggle)\b(.*?)(?:(\/))?\]/s", $content, $matches ) ) :
			return do_shortcode( $content );
		else :
			// Apply filters to cl
			$cl = apply_filters( 'k2t_accordion_classes', $cl );

		// Join cl class
		$cl    = join( ' ', $cl );
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}

		$html = '<div class="' . trim( $cl ) . $class . $anm . '" ' . $id . $data_name . $data_delay . '>';
		$html .= do_action( 'k2t_accordion_open' );

		for ( $i = 0; $i < count( $matches[0] ); $i++ ):

			$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );

		$title = isset( $matches[3][$i]['title'] ) ? trim( $matches[3][$i]['title'] ) : '';
		$icon  = isset( $matches[3][$i]['icon'] ) ? trim( $matches[3][$i]['icon'] ) : '';
		$open  = isset( $matches[3][$i]['open'] ) ? trim( $matches[3][$i]['open'] ) : 'false';

		//Check and set parameter of toggle

		/*-----------Title-------------*/
		if ( $title == '' ) { $title_toggle = 'Toggle Title'; } else { $title_toggle = $title; }

		/*-----------Icon-------------*/
		if ( trim( $icon ) == '' ) {
			$icon_html = '';
		} else {
			$icon_sub = substr( trim( $icon ), 0, 4 );
			$icon_html = '<i class="' . esc_attr( trim( $icon ) ) . '"></i>';
		}

		/*-----------Open-------------*/
		if ( $open == 'true' ) { $open_class = ' open'; } else { $open_class = ''; }

		/*-----------Accordion content-------------*/
		$acc_content = !empty( $matches[3][$i]['acc_content'] ) ? '<p>'.do_shortcode( $matches[3][$i]['acc_content'] ).'</p>' : '';

		$html .= '<h4 class="toggle-title' . $open_class . '"><span>' . $title_toggle . '</span>' . $icon_html . '</h4><div class="toggle-content">' . $acc_content . '</div>';
		endfor;
		$html .= do_action( 'k2t_accordion_close' );
		$html .= '</div>';

		//Apply filters return
		$html = apply_filters( 'k2t_accordion_return', $html );

		return $html;

		endif;
	}
}
