<?php
/**
 * Shortcode dropcap.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_dropcap_shortcode' ) ) {
	function k2t_dropcap_shortcode( $atts, $content ) {
		$html = $style = $icon = $fontsize = $anm = $anm_name = $anm_delay = $data_name = $data_delay = $id = $class = '';
		extract( shortcode_atts( array(
			'style'     => '1',
			'icon'      => '',
			'fontsize'  => '',
			'anm'       => '',
			'anm_name'  => '',
			'anm_delay' => '',
			'id'        => '',
			'class'     => '',
		), $atts ) );

		//Global $cl and $style
		$cl = array( 'k2t-dropcap' );
		$style_css = array();

		if ( $anm ) {
			$anm        = ' animated';
			$data_name  = ' data-animation="' . $anm_name . '"';
			$data_delay = ' data-animation-delay="' . $anm_delay . '"';
		}
		$id    = ( $id != '' ) ? ' id="' . $id . '"' : '';
		$class = ( $class != '' ) ? ' ' . $class . '' : '';

		/*-----------Style-------------*/
		if ( !in_array( trim( $style ), array( '1', '2', '3', '4' ) ) ) {$cl[] = 'style-1'; $style = '1';} else {$cl[] = 'style-' . trim( $style ); $style = trim( $style );}

		/*--------Check type dropcap-------*/
		if ( trim( $icon ) == '' ) {
			$type = 'text';
		} else {
			$type_trim = substr( trim( $icon ), 0, 4 );
			if ( $type_trim == 'http' ) {
				$type = 'image';
			} else {
				$type = 'icon';
			}
		}

		/*-------------Fontsize------------*/
		$icon_style = '';
		if ( is_numeric( trim( $fontsize ) ) ) {
			$text_width = $fontsize*1.5;
			$icon_width = $fontsize*2.5;
			$style_css[] = 'font-size: ' . trim( $fontsize ) . 'px';
			if ( ( $style != '1' ) && ( $type == 'text' ) ) {
				$style_css[] = 'width: ' . $text_width . 'px';
				$style_css[] = 'height: ' . $text_width . 'px';
				$style_css[] = 'line-height: ' . $text_width . 'px';
			} elseif ( ( $style != '1' ) && ( $type == 'icon' ) ) {
				$style_css[] = 'width: ' . $icon_width . 'px';
				$style_css[] = 'height: ' . $icon_width . 'px';
				$style_css[] = 'line-height: ' . $icon_width . 'px';
				$icon_style = ' style="line-height: ' . $icon_width . 'px"';
			}
		}

		/*-----------Icon-------------*/
		$content_dropcap = '';
		if ( empty( $icon ) ) {
			$cl[] = 'dropcap-text';
			$content_dropcap = do_shortcode( $content );
		} else {
			$icon_trim = substr( trim( $icon ), 0, 4 );
			if ( $icon_trim == 'http' ) {
				$cl[] = 'dropcap-image';
				$content_dropcap = '<img src="' . esc_url( $icon ) . '" />';
			} else {
				$cl[] = 'dropcap-icon';
				$content_dropcap = '<i class="' . esc_attr( $icon ) . '"' . $icon_style . '></i>';
			}
		}

		//Check $style_css and join to style inline
		if ( !empty( $style_css ) ) {
			$style_inline = ' style="' . trim( join( '; ', $style_css ) ) . '"';
		}else {
			$style_inline = '';
		}

		//Apply filters to cl
		$cl = apply_filters( 'k2t_dropcap_classes', $cl );

		//Join cl class
		$cl = join( ' ', $cl );


		$html = '<span ' . $data_name . $data_delay . $id . ' class="' . trim( $cl ). $anm  . $class . '"' . $style_inline . '>';
		$html .= do_action( 'k2t_dropcap_open' );
		$html .= $content_dropcap;
		$html .= do_action( 'k2t_dropcap_close' );
		$html .= '</span>';

		//Apply filters return
		$html = apply_filters( 'k2t_dropcap_return', $html );

		return $html;
	}
}
