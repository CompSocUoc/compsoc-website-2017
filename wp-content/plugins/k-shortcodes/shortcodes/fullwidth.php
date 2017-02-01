<?php
/**
 * Shortcode fullwidth.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_fullwidth_shortcode' ) ) {
	function k2t_fullwidth_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'padding_top'         => '',
			'padding_botom'       =>  '',
			'margin_top'          => '',
			'margin_bottom'       =>  '',
			'padding_left'        => '',
			'padding_right'       => '',
			'background_color'    =>  '',
			'background_image'    =>  '',
			'background_position' =>  '',
			'parallax'            =>  'true',
			'overlay_color'       =>  '',
			'overlay_opacity'     =>  '',
			'text_color'          =>  '',
			'text_white'          =>  'false',
			'shadow'              => 'false',
			'clipmask_opacity'    => '0',
			'id'                  => '',
		), $atts ) );

		//Global $cl
		$cl = array( 'k2t-fullwidth' );

		//Create var to save class of div parent k2t-fullwidth, overlay and bg-element
		$style = array();
		$bg_element = array();

		/*-----------ID-------------*/
		if ( trim( $id ) != '' ) { $id_html = ' id="'.trim( $id ).'"';} else { $id_html = '';}

		/*-----------Padding Top-------------*/
		if ( is_numeric( trim( $padding_top ) ) ) { $style[] = 'padding-top: '.$padding_top.'px';}

		/*-----------Padding Bottom-------------*/
		if ( is_numeric( trim( $padding_botom ) ) ) { $style[] = 'padding-bottom: '.$padding_botom.'px';}

		/*-----------Padding Left-------------*/
		if ( is_numeric( trim( $padding_left ) ) ) { $style[] = 'padding-left: '.$padding_left.'px';}

		/*-----------Padding Right-------------*/
		if ( is_numeric( trim( $padding_right ) ) ) { $style[] = 'padding-right: '.$padding_right.'px';}

		/*-----------Margin Top-------------*/
		if ( is_numeric( trim( $margin_top ) ) ) { $style[] = 'margin-top: '.$margin_top.'px';}

		/*-----------Margin Bottom-------------*/
		if ( is_numeric( trim( $margin_bottom ) ) ) { $style[] = 'margin-bottom: '.$margin_bottom.'px';}

		/*-----------Background Color-------------*/
		if ( trim( $background_color ) != '' ) {$bg_element[] = 'background-color: '.trim( $background_color );}

		/*-----------Background Image-------------*/
		if ( trim( $background_image ) != '' ) { $bg_element[] = 'background-image: url("'.esc_url( $background_image ).'")';}

		/*-----------Background Position-------------*/
		if ( trim( $background_position ) != '' ) { $bg_element[] = 'background-position: '.$background_position;}

		/*-----------Shadown-------------*/
		if ( trim( $shadow ) == 'true' ) { $cl[] = 'has-shadow'; $html_shadow = '<div class="shadow-element"></div>';} else { $html_shadow = '';}

		/*-----------Text White-------------*/
		if ( trim( $text_white ) == 'true' ) { $cl[] = 'text-white'; }

		/*-----------Clipmask Opacity-------------*/
		if ( is_numeric( trim( $clipmask_opacity ) ) ) {$clipmask_opacity = $clipmask_opacity/100; } else { $clipmask_opacity = '0';}

		/*-----------Text Color-------------*/
		if ( trim( $text_color ) != '' ) {
			$style[] = 'color: '.trim( $text_color );
		}

		/*-----------Parallax-------------*/
		if ( trim( $parallax ) == 'true' ) { $cl[] = 'k2t-parallax';}

		/*-----------Overlay Color-------------*/
		if ( trim( $overlay_color ) != '' ) {
			$overlay_color = 'background-color: '.trim( $overlay_color ).';';
		};

		/*-----------Overlay Opacity-------------*/
		if ( is_numeric( trim( $overlay_opacity ) ) ) {$overlay_opacity = ' opacity: '.( $overlay_opacity/100 ).';'; } else { $overlay_opacity = '';}

		/*------------Style for Overlay-----------*/
		if ( ( $overlay_color != '' ) && ( $overlay_opacity != '' ) ) { $style_overlay = ' style="'.esc_attr( $overlay_color.$overlay_opacity ).'"';} else { $style_overlay = '';}

		/*------------Style for Overlay-----------*/
		if ( !empty( $style ) ) {
			$style_parameter = trim( join( '; ', $style ) );
			$style = ' style="'.esc_attr( $style_parameter ).'"';
		}else {
			$style = '';
		}

		/*------------Style for Bg Element-----------*/
		if ( !empty( $bg_element ) ) {
			$bg_element = ' style="'.esc_attr( trim( join( '; ', $bg_element ) ) ).'"';
		}else {
			$bg_element = '';
		}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_fullwidth_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );

		$html = '</div><div'.$id_html.' class="'.trim( $cl ).'"'.$style.'>';
		$html .= do_action( 'k2t_fullwidth_open' );
		$html .= $html_shadow.'<div class="clipmask-element" style="opacity: '.$clipmask_opacity.';"></div><div class="bg-element"'.$bg_element.'></div><div class="overlay-element"'.$style_overlay.'></div><div class="fullwidth-content">'.do_shortcode( $content ).'</div>';
		$html .= do_action( 'k2t_fullwidth_close' );
		$html .= '</div><div class="container">';

		//Apply filters return
		$html = apply_filters( 'k2t_fullwidth_return', $html );

		return $html;
	}
}
