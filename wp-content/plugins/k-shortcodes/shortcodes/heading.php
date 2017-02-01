<?php
/**
 * Shortcode heading.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_heading_shortcode' ) ) {
	function k2t_heading_shortcode( $atts, $content ) {
		$html = $h = $align = $font = $subtitle = $border = $border_color = $font_size = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'h'         	=> 'h2',
			'align'     	=> 'left',
			'font'      	=> '',
			'subtitle'  	=> '',
			'font_size' 	=> '',
			'color'			=> '',
			'border'    	=> 'false',
			'border_style'	=> 'two_dots',
			'border_color'	=> '',
			'icon'			=> '',
			'anm'       	=> '',
			'anm_name'  	=> '',
			'anm_delay' 	=> '',
			'id'        	=> '',
			'class'     	=> '',
		), $atts ) );

		//Global $cl and $style for css
		$cl = array( 'k2t-heading' );
		$style = array();

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}

		$length        	= 10;
		$random_id 		= substr( str_shuffle( "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ), 0, $length );
		$id 			= !empty( $id ) ? $id : $random_id ;
		$class 			= ( $class != '' ) ? ' ' . $class . '' : '';

		/*-----------Align-------------*/
		if ( trim( $align ) == '' ) {$cl[] = 'align-left'; } else {$cl[] = 'align-' . trim( $align ); }

		/*-----------H tag and subtitle-------------*/
		if ( !in_array( trim( $h ), array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) ) ) {$h = 'h2'; } else {$h = trim( $h ); }
		if ( !in_array( trim( $h ), array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) ) ) { $sub_h = 'h3'; } else {$sub_h = 'h' . ( substr( trim( $h ), 1 ) + 1 ); }

		/*-----------Font-------------*/
		if ( $font ) {
			$font_class = ' has_font';
			$protocol = is_ssl() ? 'https' : 'http';
			wp_enqueue_style( 'k2t-google-font-' . str_replace( ' ', '-', $font ), "$protocol://fonts.googleapis.com/css?family=" . str_replace( ' ', '+', $font ) . ":100,200,300,400,500,600,700,800,900&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese" );
			$style[] = 'font-family: "' . $font . '"';
		}

		/*-----------Color-------------*/
		if ( ! empty( $color ) ) {
			$style[] = 'color: ' . $color . '';
		}

		/*-----------Font size-------------*/
		if ( $h == 'custom' && is_numeric( trim( $font_size ) ) ) { $style[] = 'font-size: ' . trim( $font_size ) . 'px'; }

		/*-----------Border-------------*/
		if ( trim( $border ) == 'true' || $border == '1' ) { $cl[] = 'has-border';} else {$cl[] = 'no-border'; }


		/*-----------Subtitle-------------*/
		if ( trim( $subtitle ) == '' ) {$subtitle_render = ''; $cl[] = 'no-subtitle'; } else {$subtitle_render = '<' . $sub_h . ' class="subtitle">' . $subtitle . '</' . $sub_h . '>'; $cl[] = 'has-subtitle'; }

		/*-----------Border style-------------*/
		$border_style_html = ( trim( $border ) == 'true' ) ? '<div class="has-boder-style"><span></span></div>' : '';
		$border_style_html = ( trim( $border ) == 'true' && ( $border_style == 'bottom_icon' || $border_style == 'boxed_heading' ) ) ? '<div class="has-boder-style"><span><i></i></span><span><i class="'. ( !empty( $icon ) ? $icon : 'fa fa-star' ) .'"></i></span><span><i></i></span></div>' : $border_style_html;

		//Add class $h to $cl
		$cl[] = $h;
		$cl[] = $border_style;

		//Apply filters to cl
		$cl = apply_filters( 'k2t_heading_classes', $cl );

		//Join cl class and style
		$cl = join( ' ', $cl );
		$style = join( '; ', $style );
		if ( !empty( $style ) ) { $style_html = ' style="' . esc_attr( trim( $style ) ) . '"'; } else { $style_html = ''; }


		$html = '<div '. $data_name . $data_delay .' id="'. $id .'" class="' . trim( $cl ). $anm . $class . '">';
		$html .= do_action( 'k2t_heading_open' );
		$html .= '<div class="k2t-heading-inner">';
		$html .= '<div class="text"><' . $h . ' class="h"' . $style_html . '><span>' . do_shortcode( $content ) . '</span></' . $h . '>' . $border_style_html . $subtitle_render . '</div>';
		$html .= '</div>';
		$html .= do_action( 'k2t_heading_close' );
		$html .= '</div>';

		// Border color
		if ( ! empty( $border_color ) ) {
			$html .= '<style>';
			$html .= '#'. $id .'.k2t-heading.has-border .h:before, #'. $id .'.k2t-heading.has-border .h:after { color: '. $border_color .' !important;}';
			$html .= '</style>';
		}

		//Apply filters return
		$html = apply_filters( 'k2t_heading_return', $html );

		return $html;
	}
}
